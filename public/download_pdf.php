<?php
/**
 * Secure PDF Download Handler
 * Serves PDFs from the storage directory
 */

require_once __DIR__ . '/../config.php';

// Get the requested PDF filename (support both 'file' and 'doc' parameters)
$filename = $_GET['file'] ?? $_GET['doc'] ?? '';

// Security: Only allow alphanumeric characters, hyphens, underscores, and .pdf extension
if (!preg_match('/^[a-zA-Z0-9_-]+\.pdf$/', $filename)) {
    header('HTTP/1.0 403 Forbidden');
    die('Invalid filename');
}

// Check both pdfs and documents subdirectories
$pdfPath = null;
$possiblePaths = [
    STORAGE_PATH . '/pdfs/' . $filename,
    STORAGE_PATH . '/documents/' . $filename,
];

foreach ($possiblePaths as $path) {
    if (file_exists($path)) {
        $pdfPath = $path;
        break;
    }
}

// Check if file exists
if (!$pdfPath || !file_exists($pdfPath)) {
    header('HTTP/1.0 404 Not Found');
    die('File not found');
}

// Security: Make sure the file is actually in the allowed directories
$realPath = realpath($pdfPath);
$allowedPaths = [
    realpath(STORAGE_PATH . '/pdfs'),
    realpath(STORAGE_PATH . '/documents'),
];

$isAllowed = false;
foreach ($allowedPaths as $allowedPath) {
    if ($allowedPath && strpos($realPath, $allowedPath) === 0) {
        $isAllowed = true;
        break;
    }
}

if (!$isAllowed) {
    header('HTTP/1.0 403 Forbidden');
    die('Access denied');
}

// Set headers for PDF download
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
header('Content-Length: ' . filesize($pdfPath));
header('Cache-Control: private, max-age=0, must-revalidate');
header('Pragma: public');

// Output the file
readfile($pdfPath);
exit;
