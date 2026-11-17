<?php
require_once __DIR__ . '/../src/helpers.php';
require_once __DIR__ . '/../src/SecurityHelper.php';
require_once __DIR__ . '/../vendor/autoload.php';

SecurityHelper::setSecurityHeaders();

try {
    $questionnaire = load_json('data/questionnaire.json');
    if (empty($questionnaire['sections'])) {
        throw new RuntimeException('Request questionnaire is missing or invalid.');
    }

    $pdf = new \Mpdf\Mpdf([
        'format' => 'A4',
        'margin_left' => 18,
        'margin_right' => 18,
        'margin_top' => 20,
        'margin_bottom' => 20,
        'default_font' => 'dejavusans',
        'default_font_size' => 10,
        'useActiveForms' => true,
        'use_kwt' => true,
        'tempDir' => STORAGE_PATH . '/pdfs/tmp',
    ]);
    // mPDF's documented appearance setting is only exposed on its private form service.
    $formProperty = new ReflectionProperty(\Mpdf\Mpdf::class, 'form');
    $form = $formProperty->getValue($pdf);
    if (!$form instanceof \Mpdf\Form) {
        throw new RuntimeException('mPDF form service is unavailable.');
    }
    $form->formUseZapD = false;
    $pdf->SetTitle('Förderantrag – ' . SITE_NAME);
    $pdf->SetAuthor(SITE_NAME);
    $pdf->SetHTMLFooter('<div style="text-align: right; font-size: 8pt;">Seite {PAGENO} von {nbpg}</div>');

    ob_start();
    include __DIR__ . '/../templates/request_pdf.php';
    $html = ob_get_clean();
    $pdf->WriteHTML($html);
    $content = $pdf->Output('', \Mpdf\Output\Destination::STRING_RETURN);
} catch (\Mpdf\MpdfException | RuntimeException $e) {
    error_log('Blank request PDF generation failed: ' . $e->getMessage());
    http_response_code(500);
    header('Content-Type: text/plain; charset=UTF-8');
    echo 'Das PDF konnte nicht erstellt werden. Bitte versuchen Sie es später erneut oder nutzen Sie das Onlineformular.';
    exit;
}

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="foerderantrag.pdf"');
header('Content-Length: ' . strlen($content));
header('Cache-Control: no-store');
echo $content;
