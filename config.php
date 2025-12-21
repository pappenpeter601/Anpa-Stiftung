<?php
// Basic configuration - update values after setup
define('SITE_NAME', 'Andreas Pareigis Stiftung');
define('FROM_EMAIL', 'info@andreas-pareigis-stiftung.de');
define('ADMIN_EMAIL', 'info@andreas-pareigis-stiftung.de');
define('BASE_URL', '/'); // e.g. '/'
define('STORAGE_PATH', __DIR__ . '/storage');

// Ensure storage dirs exist
if (!is_dir(STORAGE_PATH)) {
    @mkdir(STORAGE_PATH, 0755, true);
}
if (!is_dir(STORAGE_PATH . '/pdfs')) {
    @mkdir(STORAGE_PATH . '/pdfs', 0755, true);
}
