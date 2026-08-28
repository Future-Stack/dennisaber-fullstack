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
                
                // If uploaded file exists in storage, deliver it with protected headers
                if ($lesson->pdf_attachment_path && Storage::disk('public')->exists($lesson->pdf_attachment_path)) {
                    return response()->file(Storage::disk('public')->path($lesson->pdf_attachment_path), [
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => 'inline; filename="' . $filename . '"',
                        'Cache-Control' => 'private, no-cache, no-store, must-revalidate',
                        'Pragma' => 'no-cache',
                        'Expires' => '0',
                        'X-Content-Type-Options' => 'nosniff',
                    ]);
                }

                // Return a clean inline PDF document with watermarking info
                $pdfContent = "%PDF-1.4\n" .
                    "1 0 obj << /Type /Catalog /Pages 2 0 R >> endobj\n" .
                    "2 0 obj << /Type /Pages /Kids [3 0 R] /Count 1 >> endobj\n" .
                    "3 0 obj << /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >> endobj\n" .
                    "4 0 obj << /Length 200 >> stream\n" .
                    "BT\n" .
                    "/F1 18 Tf\n" .
                    "50 720 Td\n" .
                    "(" . addcslashes($course->title, "()") . ") Tj\n" .
                    "/F1 14 Tf\n" .
                    "0 -30 Td\n" .
                    "(" . addcslashes($lesson->title, "()") . ") Tj\n" .
                    "/F1 10 Tf\n" .
                    "0 -40 Td\n" .
                    "(Geschuetztes Kursmaterial - Dennis Besseler Kursportal) Tj\n" .
                    "0 -20 Td\n" .
                    "(Ausgestellt fuer: " . addcslashes($user->first_name ?: $user->name, "()") . " - Rechnungs-Nr: " . addcslashes($user->invoice_number ?: 'N/A', "()") . ") Tj\n" .
                    "ET\n" .
                    "endstream\n" .
                    "endobj\n" .
                    "5 0 obj << /Type /Font /Subtype /Type1 /BaseFont /Helvetica >> endobj\n" .
                    "xref\n" .
                    "0 6\n" .
                    "0000000000 65535 f \n" .
                    "0000000009 00000 n \n" .
                    "0000000058 00000 n \n" .
                    "0000000115 00000 n \n" .
                    "0000000234 00000 n \n" .
                    "0000000485 00000 n \n" .
                    "trailer << /Size 6 /Root 1 0 R >>\n" .
                    "startxref\n" .
                    "556\n" .
                    "%%EOF";

                return response($pdfContent, 200, [
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
                // Check if local uploaded audio exists
                if ($lesson->audio_path && Storage::disk('public')->exists($lesson->audio_path)) {
                    return response()->file(Storage::disk('public')->path($lesson->audio_path), [
                        'Content-Type' => 'audio/mpeg',
                        'Accept-Ranges' => 'bytes',
                        'Cache-Control' => 'private, no-cache, no-store, must-revalidate',
                    ]);
                }

                if ($lesson->audio_path) {
                    return response()->json(['status' => 'audio_ready', 'path' => $lesson->audio_path]);
                }
                return response()->json(['error' => 'Keine Audiodatei vorhanden'], 404);

            default:
                abort(404);
        }
    }
}
