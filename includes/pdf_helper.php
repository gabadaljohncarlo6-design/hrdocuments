<?php
/**
 * PDF generation helper using Dompdf.
 *
 * SETUP (one-time, no Composer needed):
 * 1. Go to https://github.com/dompdf/dompdf/releases/latest
 * 2. Download the asset literally named "dompdf-x.x.x.zip"
 *    (NOT the "Source code (zip)" link — that one is missing dependencies).
 * 3. Extract it. You'll get a folder like "dompdf-2.0.4".
 * 4. Rename that folder to "dompdf" and place it inside a "vendor" folder
 *    at your project root, so this path exists:
 *    C:\xampp\htdocs\hr\vendor\dompdf\vendor\autoload.php
 *    (the release zip has its own nested "vendor" folder — that's normal)
 *
 * That's it — no composer install needed, this release zip bundles
 * everything Dompdf needs to run.
 */

require_once __DIR__ . '/../vendor/dompdf/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Renders an HTML string to a real PDF and sends it to the browser.
 *
 * @param string $html      Full HTML content to render (can include inline <style>).
 * @param string $filename  Suggested download filename, e.g. "report.pdf".
 * @param bool   $download  true = force download ("Save As"), false = open inline in browser tab.
 * @param string $paper     Paper size, default 'A4'.
 * @param string $orientation 'portrait' or 'landscape'.
 */
function generate_pdf($html, $filename = 'document.pdf', $download = true, $paper = 'A4', $orientation = 'portrait')
{
    $options = new Options();
    $options->set('isRemoteEnabled', true); // allows loading images/logos from the images/ folder
    $options->set('defaultFont', 'Arial');

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper($paper, $orientation);
    $dompdf->render();

    $dompdf->stream($filename, [
        'Attachment' => $download
    ]);
    exit();
}