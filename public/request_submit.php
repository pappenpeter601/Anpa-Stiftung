<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../src/EmailService.php';
require_once __DIR__ . '/../src/EmailTemplates.php';
require_once __DIR__ . '/../src/helpers.php';
require_once __DIR__ . '/../src/SecurityHelper.php';

// Set security headers
SecurityHelper::setSecurityHeaders();

// Load environment variables from .env file if it exists
if (file_exists(__DIR__ . '/../.env')) {
    $envLines = file(__DIR__ . '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($envLines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($key, $value) = explode('=', $line, 2);
        putenv(trim($key) . '=' . trim($value));
    }
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: request.php');
    exit;
}

// Validate CSRF token
if (!isset($_POST['csrf_token']) || !SecurityHelper::validateCSRFToken($_POST['csrf_token'])) {
    include __DIR__ . '/../templates/header.php';
    echo '<div class="container my-5">';
    echo '<div class="alert alert-warning">';
    echo '<h4 class="alert-heading"><svg width="24" height="24" fill="currentColor" class="me-2" style="display:inline-block;vertical-align:middle;" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>Sitzung abgelaufen</h4>';
    echo '<p>Ihre Sitzung ist abgelaufen oder das Sicherheitstoken ist ungültig. Dies kann passieren, wenn:</p>';
    echo '<ul class="mb-3"><li>Das Formular länger als 2 Stunden geöffnet war</li><li>Sie die Seite in einem anderen Tab neu geladen haben</li><li>Ihr Browser Cookies blockiert</li></ul>';
    echo '<p class="mb-3"><strong>Hinweis:</strong> Ihre eingegebenen Daten gingen leider verloren. Bitte füllen Sie das Formular erneut aus.</p>';
    echo '<p class="text-muted small">Tipp: Speichern Sie längere Texte zunächst in einem Texteditor, um Datenverlust zu vermeiden.</p>';
    echo '</div>';
    echo '<a href="request.php" class="btn btn-primary">Zurück zum Antragsformular</a>';
    echo '</div>';
    include __DIR__ . '/../templates/footer.php';
    exit;
}

// Honeypot/time check to filter bots
if (SecurityHelper::isLikelyBotSubmission($_POST)) {
    include __DIR__ . '/../templates/header.php';
    echo '<div class="container my-5">';
    echo '<div class="alert alert-warning">Ihr Antrag konnte nicht verifiziert werden. Bitte laden Sie das Formular neu und versuchen Sie es erneut.</div>';
    echo '<a href="request.php" class="btn btn-primary">Zurück zum Antragsformular</a>';
    echo '</div>';
    include __DIR__ . '/../templates/footer.php';
    exit;
}

// Rate limiting (3 submissions per 10 minutes per IP)
$clientIP = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
if (!SecurityHelper::checkRateLimit('request_' . $clientIP, 3, 600)) {
    include __DIR__ . '/../templates/header.php';
    echo '<div class="container my-5">';
    echo '<div class="alert alert-danger">Zu viele Anträge. Bitte warten Sie einige Minuten und versuchen Sie es erneut.</div>';
    echo '<a href="request.php" class="btn btn-primary">Zurück</a>';
    echo '</div>';
    include __DIR__ . '/../templates/footer.php';
    exit;
}

// Collect all form data directly (for new questionnaire-based structure)
$formData = [];
foreach ($_POST as $key => $value) {
    if (is_array($value)) {
        $formData[$key] = $value;
    } else {
        $formData[$key] = trim($value);
    }
}

// Convert numeric values for backward compatibility
if (isset($formData['total_cost'])) {
    $formData['total_cost_numeric'] = floatval(str_replace(',', '.', $formData['total_cost']));
}
if (isset($formData['requested_amount'])) {
    $formData['requested_amount_numeric'] = floatval(str_replace(',', '.', $formData['requested_amount']));
}

// Legacy field mappings for email templates (kept for backward compatibility)
$formData['applicant'] = $formData['contact_person'] ?? '';
$formData['organization'] = $formData['org_name'] ?? '';
$formData['title'] = $formData['project_name'] ?? '';
$formData['description'] = $formData['project_description'] ?? '';
$formData['goals'] = $formData['project_goal'] ?? '';
$formData['age_group'] = $formData['target_group'] ?? '';
$formData['duration'] = $formData['timeline'] ?? '';
$formData['budget'] = $formData['total_cost_numeric'] ?? 0;
$formData['amount_requested'] = $formData['requested_amount_numeric'] ?? 0;
$formData['budget_breakdown'] = $formData['cost_details'] ?? '';
$formData['experience'] = $formData['org_purpose'] ?? '';
$formData['community_need'] = $formData['success_criteria'] ?? '';
$formData['sustainability'] = $formData['remarks'] ?? '';

// Basic validation
$required = ['applicant', 'organization', 'email', 'phone', 'title', 'description', 'goals', 'budget_breakdown', 'other_funding', 'duration'];
$missingFields = [];
foreach ($required as $field) {
    if (empty($formData[$field])) {
        $missingFields[] = $field;
    }
}

// Check budget fields separately (they can be 0)
if (!isset($_POST['total_cost']) || $_POST['total_cost'] === '') {
    $missingFields[] = 'total_cost (Gesamtkosten)';
}
if (!isset($_POST['requested_amount']) || $_POST['requested_amount'] === '') {
    $missingFields[] = 'requested_amount (Beantragte Förderung)';
}

if (!empty($missingFields)) {
    include __DIR__ . '/../templates/header.php';
    echo '<div class="container my-5">';
    echo '<div class="alert alert-danger">';
    echo '<h4>Bitte füllen Sie alle erforderlichen Felder aus.</h4>';
    echo '<p>Folgende Felder fehlen: <strong>' . implode(', ', $missingFields) . '</strong></p>';
    echo '</div>';
    echo '<a href="request.php" class="btn btn-primary">Zurück</a>';
    echo '</div>';
    include __DIR__ . '/../templates/footer.php';
    exit;
}

// Email validation
if (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
    include __DIR__ . '/../templates/header.php';
    echo '<div class="container my-5">';
    echo '<div class="alert alert-danger">Bitte geben Sie eine gültige E-Mail-Adresse an.</div>';
    echo '<a href="request.php" class="btn btn-primary">Zurück</a>';
    echo '</div>';
    include __DIR__ . '/../templates/footer.php';
    exit;
}

try {
    // Generate PDF using PDF-specific template (left-aligned, professional)
    $pdfPath = null;
    $html = EmailTemplates::generateProjectRequestPDF($formData);
    
    // Create filename-safe version of project title with proper German character handling
    $projectTitle = $formData['project_name'] ?? $formData['title'] ?? 'antrag';
    $filenameSafe = transliterate_to_ascii($projectTitle);
    $filenameSafe = preg_replace('/[^a-z0-9_-]/i', '_', $filenameSafe);
    $filenameSafe = preg_replace('/_+/', '_', $filenameSafe); // Replace multiple underscores with single
    $filenameSafe = trim($filenameSafe, '_'); // Remove leading/trailing underscores
    
    $pdfPath = generate_pdf($html, $filenameSafe);
    
    // Send email with PDF attachment
    $emailService = new EmailService();
    $result = $emailService->sendProjectRequest($formData, $pdfPath);
    
    include __DIR__ . '/../templates/header.php';
    echo '<div class="container my-5">';
    
    if ($result['success']) {
        echo '<div class="card border-0 shadow-lg p-5 text-center">';
        echo '<div class="mb-4"><svg width="64" height="64" fill="#28a745" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg></div>';
        echo '<h2 class="fw-bold mb-3">Antrag erfolgreich eingereicht!</h2>';
        echo '<p class="lead text-muted mb-4">Vielen Dank für Ihren Förderantrag. Wir haben Ihre Bewerbung erhalten und werden sie sorgfältig prüfen.</p>';
        echo '<p class="text-muted mb-4">Eine Kopie Ihres Antrags wurde an Ihre E-Mail-Adresse gesendet.</p>';
        
        if ($pdfPath) {
            // Extract filename from path and create download URL
            $pdfFilename = basename($pdfPath);
            $pdfUrl = rtrim(BASE_URL, '/') . '/download_pdf.php?file=' . urlencode($pdfFilename);
            echo '<p class="mb-4"><a href="' . htmlspecialchars($pdfUrl) . '" class="btn btn-outline-primary">';
            echo '<svg width="16" height="16" fill="currentColor" class="me-2" viewBox="0 0 16 16" style="display:inline-block;vertical-align:middle;"><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/></svg>';
            echo 'PDF herunterladen</a></p>';
        }
        
        echo '<a href="' . BASE_URL . '" class="btn btn-primary">Zur Startseite</a>';
        echo '</div>';
    } else {
        echo '<div class="alert alert-danger">';
        echo '<h4>Fehler beim Einreichen</h4>';
        echo '<p>' . htmlspecialchars($result['error'] ?? 'Ein Fehler ist aufgetreten.') . '</p>';
        echo '</div>';
        
        if ($pdfPath) {
            $pdfFilename = basename($pdfPath);
            $pdfUrl = rtrim(BASE_URL, '/') . '/download_pdf.php?file=' . urlencode($pdfFilename);
            echo '<p>Ihr Antrag wurde als PDF gespeichert: <a href="' . htmlspecialchars($pdfUrl) . '">PDF herunterladen</a></p>';
        }
        
        echo '<a href="request.php" class="btn btn-primary">Zurück</a>';
    }
    
    echo '</div>';
    include __DIR__ . '/../templates/footer.php';
    
} catch (Exception $e) {
    include __DIR__ . '/../templates/header.php';
    echo '<div class="container my-5">';
    echo '<div class="alert alert-danger">Ein Fehler ist aufgetreten: ' . htmlspecialchars($e->getMessage()) . '</div>';
    echo '<a href="request.php" class="btn btn-primary">Zurück</a>';
    echo '</div>';
    include __DIR__ . '/../templates/footer.php';
}
?>
