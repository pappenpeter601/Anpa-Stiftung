<?php
/**
 * Secure PDF Download Handler
 * Serves PDFs from the storage directory
 */

require_once __DIR__ . '/../config.php';

// Get the requested PDF filename
$filename = $_GET['file'] ?? '';

// Security: Only allow alphanumeric characters, hyphens, underscores, and .pdf extension
if (!preg_match('/^[a-zA-Z0-9_-]+\.pdf$/', $filename)) {
    header('HTTP/1.0 403 Forbidden');
    die('Invalid filename');
}

$pdfPath = STORAGE_PATH . '/pdfs/' . $filename;

// Check if file exists
if (!file_exists($pdfPath)) {
    header('HTTP/1.0 404 Not Found');
    die('File not found');
}

// Security: Make sure the file is actually in the pdfs directory
$realPath = realpath($pdfPath);
$expectedPath = realpath(STORAGE_PATH . '/pdfs');
if (strpos($realPath, $expectedPath) !== 0) {
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
