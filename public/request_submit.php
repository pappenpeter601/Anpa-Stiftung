<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../src/EmailService.php';
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
    'applicant' => trim($_POST['applicant'] ?? ''),
    'organization' => trim($_POST['organization'] ?? ''),
    'email' => trim($_POST['email'] ?? ''),
    'phone' => trim($_POST['phone'] ?? ''),
    'title' => trim($_POST['title'] ?? ''),
    'category' => trim($_POST['category'] ?? ''),
    'age_group' => trim($_POST['age_group'] ?? ''),
    'beneficiaries' => trim($_POST['beneficiaries'] ?? ''),
    'description' => trim($_POST['description'] ?? ''),
    'goals' => trim($_POST['goals'] ?? ''),
    'start_date' => trim($_POST['start_date'] ?? ''),
    'duration' => trim($_POST['duration'] ?? ''),
    'budget' => floatval($_POST['budget'] ?? 0),
    'amount_requested' => floatval($_POST['amount_requested'] ?? 0),
    'budget_breakdown' => trim($_POST['budget_breakdown'] ?? ''),
    'other_funding' => trim($_POST['other_funding'] ?? ''),
    'experience' => trim($_POST['experience'] ?? ''),
    'community_need' => trim($_POST['community_need'] ?? ''),
    'sustainability' => trim($_POST['sustainability'] ?? '')
];

// Basic validation
$required = ['applicant', 'organization', 'email', 'title', 'category', 'age_group', 'beneficiaries', 'description', 'goals', 'budget', 'amount_requested'];
foreach ($required as $field) {
    if (empty($formData[$field])) {
        include __DIR__ . '/../templates/header.php';
        echo '<div class="container my-5">';
        echo '<div class="alert alert-danger">Bitte füllen Sie alle erforderlichen Felder aus.</div>';
        echo '<a href="request.php" class="btn btn-primary">Zurück</a>';
        echo '</div>';
        include __DIR__ . '/../templates/footer.php';
        exit;
    }
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
    // Generate PDF if mPDF is available
    $pdfPath = null;
    $html = '<h1>Förderantrag: ' . htmlspecialchars($formData['title']) . '</h1>';
    $html .= '<h3>Antragsteller</h3>';
    $html .= '<p><strong>Name:</strong> ' . htmlspecialchars($formData['applicant']) . '</p>';
    $html .= '<p><strong>Organisation:</strong> ' . htmlspecialchars($formData['organization']) . '</p>';
    $html .= '<p><strong>E-Mail:</strong> ' . htmlspecialchars($formData['email']) . '</p>';
    $html .= '<p><strong>Telefon:</strong> ' . htmlspecialchars($formData['phone']) . '</p>';
    $html .= '<h3>Projektdetails</h3>';
    $html .= '<p><strong>Kategorie:</strong> ' . htmlspecialchars($formData['category']) . '</p>';
    $html .= '<p><strong>Zielgruppe:</strong> ' . htmlspecialchars($formData['age_group']) . '</p>';
    $html .= '<p><strong>Begünstigte:</strong> ' . htmlspecialchars($formData['beneficiaries']) . '</p>';
    $html .= '<h4>Beschreibung</h4>';
    $html .= '<p>' . nl2br(htmlspecialchars($formData['description'])) . '</p>';
    $html .= '<h4>Ziele</h4>';
    $html .= '<p>' . nl2br(htmlspecialchars($formData['goals'])) . '</p>';
    $html .= '<h3>Budget</h3>';
    $html .= '<p><strong>Gesamtbudget:</strong> €' . number_format($formData['budget'], 2, ',', '.') . '</p>';
    $html .= '<p><strong>Beantragte Förderung:</strong> €' . number_format($formData['amount_requested'], 2, ',', '.') . '</p>';
    
    $pdfPath = generate_pdf($html, preg_replace('/[^a-z0-9_-]/i','_', $formData['title'] ?: 'antrag'));
    
    // Send email
    $emailService = new EmailService();
    $result = $emailService->sendProjectRequest($formData);
    
    include __DIR__ . '/../templates/header.php';
    echo '<div class="container my-5">';
    
    if ($result['success']) {
        echo '<div class="card border-0 shadow-lg p-5 text-center">';
        echo '<div class="mb-4"><svg width="64" height="64" fill="#28a745" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg></div>';
        echo '<h2 class="fw-bold mb-3">Antrag erfolgreich eingereicht!</h2>';
        echo '<p class="lead text-muted mb-4">Vielen Dank für Ihren Förderantrag. Wir haben Ihre Bewerbung erhalten und werden sie sorgfältig prüfen.</p>';
        echo '<p class="text-muted mb-4">Eine Kopie Ihres Antrags wurde an Ihre E-Mail-Adresse gesendet.</p>';
        
        if ($pdfPath) {
            echo '<p class="mb-4"><a href="' . str_replace(__DIR__, BASE_URL, $pdfPath) . '" class="btn btn-outline-primary" target="_blank">';
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
            echo '<p>Ihr Antrag wurde als PDF gespeichert: <a href="' . str_replace(__DIR__, BASE_URL, $pdfPath) . '" target="_blank">PDF herunterladen</a></p>';
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
