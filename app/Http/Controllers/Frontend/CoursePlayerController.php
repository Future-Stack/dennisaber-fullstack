<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoursePlayerController extends Controller
{
    public function showCourse(Request $request, string $slug)
    {
        $course = Course::where('slug', $slug)->firstOrFail();
        $user = Auth::user();

        // Check enrollment or admin
        if ($user && ! $user->isEnrolledIn($course) && ! $user->isAdmin()) {
            return redirect()->route('member.dashboard')
                ->with('error', "Sie sind für den Kurs '{$course->title}' derzeit nicht freigeschaltet.");
        }

        $completedIds = $user ? $course->getCompletedLessonIdsForUser($user) : [];

        // Find next incomplete lesson
        $nextLesson = $course->lessons->first(function ($lesson) use ($completedIds) {
            return ! in_array($lesson->id, $completedIds);
        }) ?: $course->lessons->first();

        if (! $nextLesson) {
            return redirect()->route('member.dashboard')
                ->with('info', 'Dieser Kurs enthält derzeit noch keine freigeschalteten Lektionen.');
        }

        return redirect()->route('course.lesson', [
            'courseSlug' => $course->slug,
            'lessonSlug' => $nextLesson->slug,
        ]);
    }

    public function showLesson(Request $request, string $courseSlug, string $lessonSlug)
    {
        $course = Course::with('lessons')->where('slug', $courseSlug)->firstOrFail();
        $lesson = $course->lessons()->where('slug', $lessonSlug)->firstOrFail();
        $user = Auth::user();

        // Admin preview or enrollment verification
        $isAdminPreview = $user && $user->isAdmin();
        if ($user && ! $user->isEnrolledIn($course) && ! $isAdminPreview) {
            return redirect()->route('member.dashboard')
                ->with('error', "Zugriff verweigert: Sie haben keine aktive Freischaltung für diesen Kurs.");
        }

        // All lessons in sequence
        $allLessons = $course->lessons;
        $currentIndex = $allLessons->search(function ($item) use ($lesson) {
            return $item->id === $lesson->id;
        });

        $prevLesson = $currentIndex > 0 ? $allLessons->get($currentIndex - 1) : null;
        $nextLesson = $currentIndex < ($allLessons->count() - 1) ? $allLessons->get($currentIndex + 1) : null;

        // Group lessons by module / chapter
        $chapters = $allLessons->groupBy(function ($item) {
            return $item->chapter_name ?: 'Hauptmodul';
        });

        // User completion status
        $completedIds = $user ? $course->getCompletedLessonIdsForUser($user) : [];
        $isCurrentCompleted = in_array($lesson->id, $completedIds);
        $progressPercent = $course->getProgressForUser($user);

        return view('frontend.pages.course.player', compact(
            'course',
            'lesson',
            'chapters',
            'allLessons',
            'prevLesson',
            'nextLesson',
            'completedIds',
            'isCurrentCompleted',
            'progressPercent',
            'isAdminPreview'
        ));
    }

    public function toggleComplete(Request $request, string $courseSlug, string $lessonSlug)
    {
        $course = Course::where('slug', $courseSlug)->firstOrFail();
        $lesson = $course->lessons()->where('slug', $lessonSlug)->firstOrFail();
        $user = Auth::user();

        if (! $user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $progress = LessonProgress::firstOrNew([
            'user_id' => $user->id,
            'lesson_id' => $lesson->id,
            'course_id' => $course->id,
        ]);

        $newStatus = ! $progress->is_completed;
        $progress->is_completed = $newStatus;
        $progress->completed_at = $newStatus ? now() : null;
        $progress->save();

        $newPercentage = $course->getProgressForUser($user);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'is_completed' => $newStatus,
                'progress_percent' => $newPercentage,
                'message' => $newStatus ? 'Lektion als abgeschlossen markiert.' : 'Lektion wieder als offen markiert.',
            ]);
        }

        return back()->with('success', $newStatus ? 'Lektion als abgeschlossen markiert.' : 'Lektion wieder als offen markiert.');
    }
}
