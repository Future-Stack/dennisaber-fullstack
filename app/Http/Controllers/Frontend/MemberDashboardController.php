<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\LessonProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $courses = Course::withCount('lessons')->orderBy('order')->get();
            $enrollments = collect();
        } else {
            $enrollments = Enrollment::with('course.lessons')
                ->where('user_id', $user->id)
                ->where('is_active', true)
                ->where('started_at', '<=', now()->toDateString())
                ->where('expires_at', '>=', now()->toDateString())
                ->get();

            $courses = $enrollments->map(function ($enrollment) {
                return $enrollment->course;
            })->filter();
        }

        // Calculate progress for each course
        $coursesWithProgress = $courses->map(function ($course) use ($user) {
            $progress = $course->getProgressForUser($user);
            $completedIds = $course->getCompletedLessonIdsForUser($user);
            
            // Find next incomplete lesson
            $nextLesson = $course->lessons->first(function ($lesson) use ($completedIds) {
                return ! in_array($lesson->id, $completedIds);
            }) ?: $course->lessons->first();

            return [
                'course' => $course,
                'progress' => $progress,
                'next_lesson' => $nextLesson,
                'total_lessons' => $course->lessons->count(),
                'completed_count' => count($completedIds),
            ];
        });

        return view('frontend.pages.member.dashboard', compact('user', 'coursesWithProgress', 'enrollments'));
    }
}
