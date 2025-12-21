<?php
require_once __DIR__ . '/../config.php';

use PHPMailer\PHPMailer\PHPMailer;
use Mpdf\Mpdf;

function load_json($path) {
    $file = __DIR__ . '/../' . ltrim($path, '/');
    if (!file_exists($file)) return [];
    $c = file_get_contents($file);
    return json_decode($c, true) ?: [];
}

function send_mail($to, $subject, $body, $attachments = []) {
    if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
        // fallback: try to send using mail()
        $headers = "From: " . FROM_EMAIL . "\r\n";
        return mail($to, $subject, strip_tags($body), $headers);
    }
    require_once __DIR__ . '/../vendor/autoload.php';
    $mail = new PHPMailer(true);
    try {
        $mail->setFrom(FROM_EMAIL, SITE_NAME);
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->isHTML(true);
        $mail->Body = $body;
        foreach ($attachments as $att) {
            if (file_exists($att)) $mail->addAttachment($att);
        }
        // NOTE: On shared hosts you may need to use mail() transport or configure SMTP here.
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function generate_pdf($html, $filenameBase = null) {
    if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
        // cannot generate without mPDF
        return false;
    }
    require_once __DIR__ . '/../vendor/autoload.php';
    $mpdf = new Mpdf();
    $mpdf->WriteHTML($html);
    $fname = ($filenameBase ?: 'request') . '-' . date('Ymd-His') . '.pdf';
    $outPath = STORAGE_PATH . '/pdfs/' . $fname;
    $mpdf->Output($outPath, \Mpdf\Output\Destination::FILE);
    return $outPath;
}
