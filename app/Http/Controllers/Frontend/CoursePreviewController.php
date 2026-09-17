<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CoursePreviewController extends Controller
{
    /**
     * Map course slugs to their relative Proben HTML preview files.
     */
    protected array $previewMap = [
        'dnl-kompakt' => 'akademie/bildungsurlaub/index.html',
        'bildungsurlaub' => 'akademie/bildungsurlaub/index.html',
        'dnl-vertiefung' => 'akademie/vertiefung/index.html',
        'vertiefung' => 'akademie/vertiefung/index.html',
        'dnl-premium' => 'akademie/premium/index.html',
        'premium' => 'akademie/premium/index.html',
        'stress-und-ressourcen' => 'praevention/stress/index.html',
        'stress' => 'praevention/stress/index.html',
        'rauchfrei' => 'praevention/rauchfrei/index.html',
        'ernaehrung' => 'praevention/ernaehrung/index.html',
        'klar-entscheiden' => 'praevention/klar-entscheiden/index.html',
        'erfolgreich-gruenden' => 'gruenden/index.html',
        'gruenden' => 'gruenden/index.html',
        'presse-oeffentlichkeit' => 'presse/index.html',
        'presse' => 'presse/index.html',
        'rhetorik-unter-druck' => 'rhetorik/index.html',
        'rhetorik' => 'rhetorik/index.html',
        'rio-negro-2002' => 'rausgehen-reicht-nicht/abenteuer/index.html',
        'abenteuer' => 'rausgehen-reicht-nicht/abenteuer/index.html',
        'angebote' => 'angebote/index.html',
    ];

    /**
     * Render the Proben design for a preview page.
     */
    public function render(string $pageKey)
    {
        $pageKey = trim($pageKey, '/');
        
        if (!isset($this->previewMap[$pageKey])) {
            abort(404, 'Preview page not found');
        }

        $relativePath = $this->previewMap[$pageKey];
        $baseDir = base_path('Proben/Portal Backup/portal/besseler-kursvorschau.dennis-bes.chatgpt.site/');
        $fullPath = $baseDir . $relativePath;

        if (!file_exists($fullPath)) {
            abort(404, 'Preview source file missing');
        }

        $html = file_get_contents($fullPath);

        // Transform relative media & asset paths into local public assets
        $html = preg_replace('/(?:\.\.\/)+media\//', '/media/', $html);
        $html = preg_replace('/(?<!\/)media\//', '/media/', $html);
        // Fix any double slashes
        $html = str_replace('//media/', '/media/', $html);
        $html = str_replace('/media//', '/media/', $html);
        $html = str_replace('/media/media/', '/media/', $html);

        // Ensure SVGs and fonts resolve
        $html = str_replace('../dnl-master.svg', '/dnl-master.svg', $html);
        $html = str_replace('../../dnl-master.svg', '/dnl-master.svg', $html);
        $html = str_replace('dnl-master.svg', '/dnl-master.svg', $html);

        // Replace relative links with local Laravel routes
        // Anfragen -> local course login / checkout
        $html = preg_replace('/(\.\.\/)+anfrage\/[^\'"]*/', '/login', $html);
        $html = preg_replace('/anfrage\/[^\'"]*/', '/login', $html);

        // Angebote -> /angebote
        $html = preg_replace('/(\.\.\/)+angebote(\/index\.html)?/', '/angebote', $html);
        $html = preg_replace('/angebote(\/index\.html)?/', '/angebote', $html);

        // Index / Home -> /
        $html = preg_replace('/(\.\.\/)+index\.html/', '/', $html);
        $html = str_replace('href="../index.html"', 'href="/"', $html);
        $html = str_replace('href="index.html"', 'href="/"', $html);

        // Specific sub-sections
        $html = preg_replace('/(\.\.\/)+akademie(\/index\.html)?/', '/#academy', $html);
        $html = preg_replace('/(\.\.\/)+praevention(\/index\.html)?/', '/#prevention', $html);
        $html = preg_replace('/(\.\.\/)+gruenden(\/index\.html)?/', '/gruenden', $html);
        $html = preg_replace('/(\.\.\/)+presse(\/index\.html)?/', '/presse', $html);
        $html = preg_replace('/(\.\.\/)+rhetorik(\/index\.html)?/', '/rhetorik', $html);
        $html = preg_replace('/(\.\.\/)+rausgehen-reicht-nicht(\/index\.html)?/', '/rausgehen-reicht-nicht/abenteuer', $html);

        // Legal & terms
        $html = preg_replace('/(\.\.\/)+zahlungsbedingungen(\/index\.html)?/', '/zahlungsbedingungen', $html);
        $html = preg_replace('/(\.\.\/)+datenschutz(\/index\.html)?/', '/datenschutz', $html);
        $html = preg_replace('/(\.\.\/)+impressum(\/index\.html)?/', '/impressum', $html);
        $html = preg_replace('/(\.\.\/)+widerruf(\/index\.html)?/', '/zahlungsbedingungen', $html);
        $html = preg_replace('/(\.\.\/)+barrierefreiheit(\/index\.html)?/', '/kopierschutz', $html);

        // Fix external link references to chatgpt.site or besseler.de inside links
        $html = str_replace('https://besseler-kursvorschau.dennis-bes.chatgpt.site/', '/', $html);
        $html = str_replace('https://besseler-kursportal.dennis-bes.chatgpt.site/', '/', $html);

        // Add target="_blank" for PDF downloads if not present
        $html = preg_replace('/(<a[^>]*class="[^"]*workbook-button[^"]*"[^>]*)>/i', '$1 target="_blank">', $html);

        // Remove HTTrack meta comments
        $html = preg_replace('/<!-- Mirrored from [^>]* -->\s*/i', '', $html);
        $html = preg_replace('/<!-- Added by HTTrack -->[\s\S]*?<!-- \/Added by HTTrack -->\s*/i', '', $html);

        return response($html, 200, [
            'Content-Type' => 'text/html; charset=UTF-8',
        ]);
    }
}
