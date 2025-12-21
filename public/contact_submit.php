<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../src/EmailService.php';

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
