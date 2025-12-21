<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../src/EmailService.php';
require_once __DIR__ . '/../src/EmailTemplates.php';
require_once __DIR__ . '/../src/helpers.php';

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

$formData = [
    'applicant' => trim($_POST['contact_person'] ?? ''),
    'organization' => trim($_POST['org_name'] ?? ''),
    'email' => trim($_POST['email'] ?? ''),
    'phone' => trim($_POST['phone'] ?? ''),
    'title' => trim($_POST['project_name'] ?? ''),
    'category' => 'Allgemein', // Not in form, set default
    'age_group' => trim($_POST['target_group'] ?? ''),
    'beneficiaries' => '0', // Not in form, set default
    'description' => trim($_POST['project_description'] ?? ''),
    'goals' => trim($_POST['project_goal'] ?? ''),
    'start_date' => '', // Not in current form
    'duration' => trim($_POST['timeline'] ?? ''),
    'budget' => floatval($_POST['total_cost'] ?? 0),
    'amount_requested' => floatval($_POST['requested_amount'] ?? 0),
    'budget_breakdown' => trim($_POST['cost_details'] ?? ''),
    'other_funding' => trim($_POST['other_funding'] ?? ''),
    'experience' => trim($_POST['org_purpose'] ?? ''),
    'community_need' => trim($_POST['success_criteria'] ?? ''),
    'sustainability' => trim($_POST['remarks'] ?? ''),
    // Additional fields from form
    'address' => trim($_POST['address'] ?? ''),
    'iban' => trim($_POST['iban'] ?? ''),
    'bic' => trim($_POST['bic'] ?? ''),
    'org_since' => trim($_POST['org_since'] ?? ''),
    'legal_form' => trim($_POST['legal_form'] ?? ''),
    'previous_application' => trim($_POST['previous_application'] ?? ''),
    'previous_project' => trim($_POST['previous_project'] ?? '')
];

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
    
    $pdfPath = generate_pdf($html, preg_replace('/[^a-z0-9_-]/i','_', $formData['title'] ?: 'antrag'));
    
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
