<?php
// Load environment variables from .env file
$envFile = __DIR__ . '/.config/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Skip comments
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        
        // Parse KEY=VALUE
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            
            // Set as environment variable
            if (!array_key_exists($key, $_ENV)) {
                putenv("$key=$value");
                $_ENV[$key] = $value;
                $_SERVER[$key] = $value;
            }
        }
    }
}

// Basic configuration - update values after setup
define('SITE_NAME', 'Andreas Pareigis Stiftung');
define('FROM_EMAIL', getenv('SMTP_FROM_EMAIL') ?: 'info@andreas-pareigis-stiftung.de');
define('ADMIN_EMAIL', getenv('SMTP_FROM_EMAIL') ?: 'info@andreas-pareigis-stiftung.de');
define('BASE_URL', '/'); // e.g. '/'
define('STORAGE_PATH', __DIR__ . '/storage');

// Ensure storage dirs exist
if (!is_dir(STORAGE_PATH)) {
    @mkdir(STORAGE_PATH, 0755, true);
}
if (!is_dir(STORAGE_PATH . '/pdfs')) {
    @mkdir(STORAGE_PATH . '/pdfs', 0755, true);
}
