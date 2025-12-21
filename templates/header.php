<?php
if (!defined('SITE_NAME')) require_once __DIR__ . '/../config.php';
?>
<!doctype html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  
  <!-- SEO Meta Tags -->
  <title><?php echo isset($pageTitle) ? $pageTitle . ' | ' . SITE_NAME : SITE_NAME . ' - Förderung sozial benachteiligter Kinder und Jugendlicher in Soltau'; ?></title>
  <meta name="description" content="<?php echo isset($pageDescription) ? $pageDescription : 'Die Andreas Pareigis Stiftung unterstützt gemeinnützige Institutionen in Soltau bei der Förderung sozial benachteiligter Kinder und Jugendlicher in den Bereichen Jugendhilfe, Bildung und Kultur.'; ?>">
  <meta name="keywords" content="Stiftung Soltau, Jugendförderung, Jugendhilfe, Bildungsförderung, Kulturförderung, sozial benachteiligte Kinder, gemeinnützige Stiftung, Andreas Pareigis Stiftung">
  <meta name="author" content="Andreas Pareigis Stiftung">
  <meta name="robots" content="index, follow">
  <meta name="language" content="de">
  <meta name="revisit-after" content="7 days">
  
  <!-- Open Graph / Facebook -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
  <meta property="og:title" content="<?php echo isset($pageTitle) ? $pageTitle . ' | ' . SITE_NAME : SITE_NAME; ?>">
  <meta property="og:description" content="<?php echo isset($pageDescription) ? $pageDescription : 'Gemeinnützige Stiftung zur Förderung sozial benachteiligter Kinder und Jugendlicher in Soltau'; ?>">
  <meta property="og:image" content="<?php echo BASE_URL; ?>assets/img/logo-400.png">
  <meta property="og:locale" content="de_DE">
  <meta property="og:site_name" content="Andreas Pareigis Stiftung">
  
  <!-- Twitter -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:url" content="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
  <meta name="twitter:title" content="<?php echo isset($pageTitle) ? $pageTitle . ' | ' . SITE_NAME : SITE_NAME; ?>">
  <meta name="twitter:description" content="<?php echo isset($pageDescription) ? $pageDescription : 'Gemeinnützige Stiftung zur Förderung sozial benachteiligter Kinder und Jugendlicher in Soltau'; ?>">
  <meta name="twitter:image" content="<?php echo BASE_URL; ?>assets/img/logo-400.png">
  
  <!-- Mobile Optimization -->
  <meta name="theme-color" content="#2563eb">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="default">
  <meta name="apple-mobile-web-app-title" content="Andreas Pareigis Stiftung">
  <meta name="format-detection" content="telephone=no">
  
  <!-- Favicon -->
  <link rel="icon" type="image/png" sizes="64x64" href="<?php echo BASE_URL; ?>assets/img/logo-64.png">
  <link rel="apple-touch-icon" sizes="120x120" href="<?php echo BASE_URL; ?>assets/img/logo-120.png">
  <link rel="apple-touch-icon" sizes="200x200" href="<?php echo BASE_URL; ?>assets/img/logo-200.png">
  
  <!-- PWA Manifest -->
  <link rel="manifest" href="<?php echo BASE_URL; ?>manifest.json">
  
  <!-- Preconnect for performance -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preconnect" href="https://cdn.jsdelivr.net">
  
  <!-- Fonts & Styles -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo BASE_URL; ?>assets/css/style.css" rel="stylesheet">
  
  <!-- Structured Data / JSON-LD for SEO -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "NGO",
    "name": "Andreas Pareigis Stiftung",
    "description": "Gemeinnützige Stiftung zur Förderung sozial benachteiligter Kinder und Jugendlicher in Soltau",
    "url": "<?php echo BASE_URL; ?>",
    "logo": "<?php echo BASE_URL; ?>assets/img/logo-400.png",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "Meinern 15a",
      "addressLocality": "Soltau",
      "postalCode": "29614",
      "addressCountry": "DE"
    },
    "areaServed": {
      "@type": "City",
      "name": "Soltau"
    },
    "foundingDate": "<?php echo date('Y'); ?>",
    "nonprofitStatus": "NonprofitANBI"
  }
  </script>
</head>
<body class="theme-light">
<!-- Skip to main content for accessibility -->
<a href="#main-content" class="skip-to-main visually-hidden-focusable">Zum Hauptinhalt springen</a>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top" role="navigation" aria-label="Hauptnavigation">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2" href="<?php echo BASE_URL; ?>" aria-label="Zur Startseite">
      <img src="<?php echo BASE_URL; ?>assets/img/logo-120.png" alt="Andreas Pareigis Stiftung Logo" width="60" height="32">
      <span class="brand-text"><?php echo SITE_NAME; ?></span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu" aria-controls="navmenu" aria-expanded="false" aria-label="Navigation umschalten">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navmenu">
      <ul class="navbar-nav ms-auto align-items-lg-center">
        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>">Startseite</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>about.php">Über uns</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>team.php">Team</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>projects.php">Projekte</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>statutes.php">Satzung</a></li>
        <li class="nav-item"><a class="nav-link btn btn-outline-primary ms-lg-3" href="<?php echo BASE_URL; ?>request.php">Förderung anfragen</a></li>
        <li class="nav-item d-lg-none"><a class="nav-link" href="<?php echo BASE_URL; ?>contact.php">Kontakt</a></li>
      </ul>
    </div>
  </div>
</nav>
<main class="container py-4" id="main-content">
