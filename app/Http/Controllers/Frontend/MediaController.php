<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function streamMedia(Request $request, string $courseSlug, string $lessonSlug, string $type)
    {
        $user = Auth::user();
        if (! $user) {
            abort(403, 'Zugriff verweigert: Sie müssen angemeldet sein.');
        }

        $course = Course::where('slug', $courseSlug)->firstOrFail();
        $lesson = $course->lessons()->where('slug', $lessonSlug)->firstOrFail();

        // Check permission
        if (! $user->isEnrolledIn($course) && ! $user->isAdmin()) {
            abort(403, 'Zugriff verweigert: Keine aktive Freischaltung für dieses Medium.');
        }

        switch ($type) {
            case 'pdf':
                $filename = $lesson->pdf_attachment_name ?: "{$lesson->slug}-arbeitsblatt.pdf";
                if (!str_ends_with(strtolower($filename), '.pdf')) {
                    $filename .= '.pdf';
                }

                $sourcePath = null;
                if ($lesson->pdf_attachment_path && Storage::disk('public')->exists($lesson->pdf_attachment_path)) {
                    $sourcePath = Storage::disk('public')->path($lesson->pdf_attachment_path);
                }

                if ($sourcePath && file_exists($sourcePath)) {
                    return response()->file($sourcePath, [
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => 'inline; filename="' . $filename . '"',
                        'Cache-Control' => 'private, no-cache, no-store, must-revalidate',
                        'Pragma' => 'no-cache',
                        'Expires' => '0',
                        'X-Content-Type-Options' => 'nosniff',
                    ]);
                }

                $watermarkService = new \App\Services\PdfWatermarkService();
                $cleanPdfBinary = $watermarkService->generateCleanPdf($course, $lesson);

                return response($cleanPdfBinary, 200, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="' . $filename . '"',
                    'Cache-Control' => 'private, no-cache, no-store, must-revalidate',
                    'Pragma' => 'no-cache',
                    'Expires' => '0',
                    'X-Content-Type-Options' => 'nosniff',
                ]);

            case 'video':
                // Check if local uploaded video exists
                if ($lesson->video_path && Storage::disk('public')->exists($lesson->video_path)) {
                    return response()->file(Storage::disk('public')->path($lesson->video_path), [
                        'Content-Type' => 'video/mp4',
                        'Accept-Ranges' => 'bytes',
                        'Cache-Control' => 'private, no-cache, no-store, must-revalidate',
                    ]);
                }

                if ($lesson->video_url) {
                    return redirect()->away($lesson->video_url);
                }
                return response()->json(['error' => 'Keine Videoquelle hinterlegt'], 404);

            case 'audio':
                $audioDisk = Storage::disk('public');
                $targetAudioPath = $lesson->audio_path;

                // If path doesn't exist directly, check available files in audio directory
                if (!$targetAudioPath || !$audioDisk->exists($targetAudioPath)) {
                    $available = $audioDisk->files('audio');
                    if (!empty($available)) {
                        $targetAudioPath = $available[0];
                    }
                }

                if ($targetAudioPath && $audioDisk->exists($targetAudioPath)) {
                    $fullPath = $audioDisk->path($targetAudioPath);
                    $mimeType = str_ends_with(strtolower($fullPath), '.wav') ? 'audio/wav' : 'audio/mpeg';
                    
                    return response()->file($fullPath, [
                        'Content-Type' => $mimeType,
                        'Accept-Ranges' => 'bytes',
                        'Cache-Control' => 'private, no-cache, no-store, must-revalidate',
                    ]);
                }

                return response()->json(['error' => 'Keine Audiodatei vorhanden'], 404);

            default:
                abort(404);
        }
    }
}
