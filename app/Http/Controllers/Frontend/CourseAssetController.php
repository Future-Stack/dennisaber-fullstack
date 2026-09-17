<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseAssetController extends Controller
{
    /**
     * Show a list of PDFs and audio files for the given course.
     */
    public function index(string $slug)
    {
        $course = Course::where('slug', $slug)->firstOrFail();
        // Get lessons that have either audio or pdf attached
        $lessons = $course->lessons()
            ->where(function ($q) {
                $q->whereNotNull('audio_path')
                  ->orWhereNotNull('pdf_attachment_path');
            })
            ->orderBy('order')
            ->get();

        return view('frontend.pages.course.assets', compact('course', 'lessons'));
    }
}
