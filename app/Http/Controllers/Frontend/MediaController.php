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
                if ($lesson->pdf_attachment_path && file_exists(public_path($lesson->pdf_attachment_path))) {
                    $sourcePath = public_path($lesson->pdf_attachment_path);
                } elseif ($lesson->pdf_attachment_path && Storage::disk('public')->exists($lesson->pdf_attachment_path)) {
                    $sourcePath = Storage::disk('public')->path($lesson->pdf_attachment_path);
                }

                $watermarkService = new \App\Services\PdfWatermarkService();
                $watermarkedPdfBinary = $watermarkService->generateWatermarkedPdf($user, $course, $lesson, $sourcePath);

                return response($watermarkedPdfBinary, 200, [
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
                $targetAudioPath = $lesson->audio_path ? ltrim($lesson->audio_path, '/') : null;
                if (! $targetAudioPath) {
                    $cdata = json_decode($lesson->content_html, true);
                    if (is_array($cdata) && !empty($cdata['audio'])) {
                        $targetAudioPath = ltrim($cdata['audio'], '/');
                    }
                }

                $fullPath = null;
                if ($targetAudioPath && file_exists(public_path($targetAudioPath))) {
                    $fullPath = public_path($targetAudioPath);
                } elseif ($targetAudioPath && $audioDisk->exists($targetAudioPath)) {
                    $fullPath = $audioDisk->path($targetAudioPath);
                } elseif ($targetAudioPath && file_exists(base_path($targetAudioPath))) {
                    $fullPath = base_path($targetAudioPath);
                } else {
                    $basename = basename($targetAudioPath ?? '');
                    if ($basename && file_exists(public_path("audio/{$courseSlug}/{$basename}"))) {
                        $fullPath = public_path("audio/{$courseSlug}/{$basename}");
                    } elseif ($basename && file_exists(public_path("audio/{$basename}"))) {
                        $fullPath = public_path("audio/{$basename}");
                    }
                }

                if (! $fullPath || ! file_exists($fullPath)) {
                    $courseDir = public_path("audio/{$courseSlug}");
                    if (is_dir($courseDir)) {
                        $files = glob($courseDir . '/*.{mp3,wav,m4a,ogg}', GLOB_BRACE);
                        if (!empty($files)) {
                            $fullPath = $files[0];
                        }
                    }
                }

                if (! $fullPath || ! file_exists($fullPath)) {
                    $available = glob(public_path('audio/*/*.{mp3,wav,m4a,ogg}'), GLOB_BRACE);
                    if (!empty($available)) {
                        $fullPath = $available[0];
                    }
                }

                if ($fullPath && file_exists($fullPath)) {
                    $ext = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
                    $mimeType = match($ext) {
                        'wav' => 'audio/wav',
                        'ogg' => 'audio/ogg',
                        'm4a' => 'audio/mp4',
                        default => 'audio/mpeg',
                    };
                    
                    $response = response()->file($fullPath, [
                        'Content-Type' => $mimeType,
                        'Accept-Ranges' => 'bytes',
                        'Cache-Control' => 'private, no-cache, no-store, must-revalidate',
                    ]);
                    $response->prepare($request);
                    return $response;
                }

                return response()->json(['error' => 'Keine Audiodatei vorhanden'], 404);

            default:
                abort(404);
        }
    }
}
