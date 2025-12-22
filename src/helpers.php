<?php
require_once __DIR__ . '/../config.php';

use PHPMailer\PHPMailer\PHPMailer;
use Mpdf\Mpdf;

/**
 * Transliterate German and other special characters to ASCII equivalents
 * ä→ae, ö→oe, ü→ue, ß→ss, etc.
 */
function transliterate_to_ascii($string) {
    // German special characters
    $transliteration = [
        'ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue', 'ß' => 'ss',
        'Ä' => 'Ae', 'Ö' => 'Oe', 'Ü' => 'Ue',
        'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'å' => 'a',
        'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
        'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
        'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o',
        'ù' => 'u', 'ú' => 'u', 'û' => 'u',
        'ñ' => 'n', 'ç' => 'c', 'ý' => 'y', 'ÿ' => 'y'
    ];
    
    return str_replace(array_keys($transliteration), array_values($transliteration), $string);
}

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

/**
 * Get logo URL from external website
 * Attempts to fetch favicon or logo from the provided URL
 * 
 * @param string $url The website URL
 * @return string|null Logo URL or null if not found
 */
function fetch_logo_from_url($url) {
    if (empty($url)) {
        return null;
    }
    
    // Parse URL to get domain
    $parsed = parse_url($url);
    if (!$parsed || empty($parsed['scheme']) || empty($parsed['host'])) {
        return null;
    }
    
    $baseUrl = $parsed['scheme'] . '://' . $parsed['host'];
    
    // Try multiple logo/favicon sources
    $logoSources = [
        $baseUrl . '/favicon.ico',
        $baseUrl . '/favicon.png',
        $baseUrl . '/apple-touch-icon.png',
        $baseUrl . '/apple-touch-icon-precomposed.png',
        'https://www.google.com/s2/favicons?domain=' . $parsed['host'] . '&sz=128',
    ];
    
    // Try to fetch HTML and parse for logo
    try {
        $context = stream_context_create([
            'http' => [
                'timeout' => 5,
                'user_agent' => 'Mozilla/5.0 (compatible; LogoFetcher/1.0)'
            ]
        ]);
        
        $html = @file_get_contents($url, false, $context);
        if ($html) {
            // Look for common logo meta tags
            if (preg_match('/<link[^>]+rel=["\'](?:icon|shortcut icon|apple-touch-icon)["\'][^>]+href=["\'](.*?)["\']/i', $html, $match)) {
                $logoUrl = $match[1];
                // Make absolute URL if relative
                if (strpos($logoUrl, 'http') !== 0) {
                    $logoUrl = $baseUrl . (strpos($logoUrl, '/') === 0 ? '' : '/') . $logoUrl;
                }
                array_unshift($logoSources, $logoUrl);
            }
        }
    } catch (Exception $e) {
        // Ignore errors, will use fallback sources
    }
    
    // Return first valid source (Google favicons as fallback)
    return $logoSources[count($logoSources) - 1]; // Use Google favicons as reliable fallback
}
