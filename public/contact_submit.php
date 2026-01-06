<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../src/EmailService.php';
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
    header('Location: contact.php');
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
    echo '<p class="mb-0"><strong>Bitte laden Sie die Seite neu und versuchen Sie es erneut.</strong></p>';
    echo '</div>';
    echo '<a href="contact.php" class="btn btn-primary">Zurück zum Kontaktformular</a>';
    echo '</div>';
    include __DIR__ . '/../templates/footer.php';
    exit;
}

// Honeypot/time check to filter bots
if (SecurityHelper::isLikelyBotSubmission($_POST)) {
    include __DIR__ . '/../templates/header.php';
    echo '<div class="container my-5">';
    echo '<div class="alert alert-warning">Ihre Anfrage konnte nicht verifiziert werden. Bitte laden Sie die Seite neu und versuchen Sie es erneut.</div>';
    echo '<a href="contact.php" class="btn btn-primary">Zurück zum Kontaktformular</a>';
    echo '</div>';
    include __DIR__ . '/../templates/footer.php';
    exit;
}

// Rate limiting (5 submissions per 5 minutes per IP)
$clientIP = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
if (!SecurityHelper::checkRateLimit('contact_' . $clientIP, 5, 300)) {
    include __DIR__ . '/../templates/header.php';
    echo '<div class="container my-5">';
    echo '<div class="alert alert="danger">Zu viele Anfragen. Bitte warten Sie einige Minuten und versuchen Sie es erneut.</div>';
    echo '<a href="contact.php" class="btn btn-primary">Zurück</a>';
    echo '</div>';
    include __DIR__ . '/../templates/footer.php';
    exit;
}

$formData = [
    'name' => trim($_POST['name'] ?? ''),
    'email' => trim($_POST['email'] ?? ''),
    'phone' => trim($_POST['phone'] ?? ''),
    'subject' => trim($_POST['subject'] ?? ''),
    'message' => trim($_POST['message'] ?? '')
];

// Basic validation
if (empty($formData['name']) || empty($formData['email']) || empty($formData['message'])) {
    include __DIR__ . '/../templates/header.php';
    echo '<div class="container my-5">';
    echo '<div class="alert alert-danger">Bitte füllen Sie alle erforderlichen Felder aus.</div>';
    echo '<a href="contact.php" class="btn btn-primary">Zurück</a>';
    echo '</div>';
    include __DIR__ . '/../templates/footer.php';
    exit;
}

// Email validation
if (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
    include __DIR__ . '/../templates/header.php';
    echo '<div class="container my-5">';
    echo '<div class="alert alert-danger">Bitte geben Sie eine gültige E-Mail-Adresse an.</div>';
    echo '<a href="contact.php" class="btn btn-primary">Zurück</a>';
    echo '</div>';
    include __DIR__ . '/../templates/footer.php';
    exit;
}

// German-friendly validation for name and message content
if (!SecurityHelper::isValidGermanName($formData['name'])) {
    include __DIR__ . '/../templates/header.php';
    echo '<div class="container my-5">';
    echo '<div class="alert alert-danger">Bitte verwenden Sie für den Namen nur Buchstaben (inkl. ä, ö, ü, ß), Leerzeichen, Bindestriche oder Apostrophe.</div>';
    echo '<a href="contact.php" class="btn btn-primary">Zurück</a>';
    echo '</div>';
    include __DIR__ . '/../templates/footer.php';
    exit;
}

if (!SecurityHelper::isValidGermanMessage($formData['message'])) {
    include __DIR__ . '/../templates/header.php';
    echo '<div class="container my-5">';
    echo '<div class="alert alert-danger">Ihre Nachricht muss wie ein echter deutscher Satz formuliert sein, mindestens 20 Zeichen und 5 Wörter enthalten und darf nur HTTPS-Links und erlaubte Zeichen nutzen.</div>';
    echo '<a href="contact.php" class="btn btn-primary">Zurück</a>';
    echo '</div>';
    include __DIR__ . '/../templates/footer.php';
    exit;
}

try {
    $emailService = new EmailService();
    $result = $emailService->sendContactForm($formData);
    
    include __DIR__ . '/../templates/header.php';
    echo '<div class="container my-5">';
    
    if ($result['success']) {
        echo '<div class="card border-0 shadow-lg p-5 text-center">';
        echo '<div class="mb-4"><svg width="64" height="64" fill="#28a745" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg></div>';
        echo '<h2 class="fw-bold mb-3">Nachricht gesendet!</h2>';
        echo '<p class="lead text-muted mb-4">Vielen Dank für Ihre Nachricht. Wir haben Ihre Anfrage erhalten und werden uns in Kürze bei Ihnen melden.</p>';
        echo '<p class="text-muted small mb-4">Eine Kopie der Nachricht wurde an Ihre E-Mail-Adresse gesendet.</p>';
        echo '<a href="' . BASE_URL . '" class="btn btn-primary">Zur Startseite</a>';
        echo '</div>';
    } else {
        echo '<div class="alert alert-danger">';
        echo '<h4>Fehler beim Senden</h4>';
        echo '<p>' . htmlspecialchars($result['error'] ?? 'Ein Fehler ist aufgetreten.') . '</p>';
        echo '</div>';
        echo '<a href="contact.php" class="btn btn-primary">Zurück</a>';
    }
    
    echo '</div>';
    include __DIR__ . '/../templates/footer.php';
    
} catch (Exception $e) {
    include __DIR__ . '/../templates/header.php';
    echo '<div class="container my-5">';
    echo '<div class="alert alert-danger">Ein Fehler ist aufgetreten: ' . htmlspecialchars($e->getMessage()) . '</div>';
    echo '<a href="contact.php" class="btn btn-primary">Zurück</a>';
    echo '</div>';
    include __DIR__ . '/../templates/footer.php';
}
?>
