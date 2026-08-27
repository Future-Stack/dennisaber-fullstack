<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function generateMailto(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'course' => ['nullable', 'string', 'max:150'],
            'message' => ['nullable', 'string', 'max:2000'],
        ]);

        $recipient = 'mail@besseler.de';
        $subject = 'Anfrage: ' . ($request->course ?: 'Kursbuchung / Beratung') . ' - ' . $request->first_name;

        $body = "Sehr geehrter Herr Besseler,\n\n" .
            "ich interessiere mich für folgendes Angebot:\n" .
            "Ausgewähltes Produkt / Kurs: " . ($request->course ?: 'Allgemeine Anfrage') . "\n" .
            "Vorname: " . $request->first_name . "\n" .
            "E-Mail-Adresse: " . $request->email . "\n\n" .
            "Ihre Nachricht:\n" . ($request->message ?: 'Bitte senden Sie mir weitere Informationen und die Anmeldeunterlagen zu.') . "\n\n" .
            "Mit freundlichen Grüßen,\n" . $request->first_name;

        $mailtoLink = 'mailto:' . $recipient . '?subject=' . rawurlencode($subject) . '&body=' . rawurlencode($body);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'mailto_link' => $mailtoLink,
                'subject' => $subject,
                'body' => $body,
            ]);
        }

        return redirect()->away($mailtoLink);
    }
}
