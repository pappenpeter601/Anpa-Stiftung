<?php
if (!defined('SITE_NAME')) require_once __DIR__ . '/../config.php';
?>
<!doctype html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo SITE_NAME; ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo BASE_URL; ?>assets/css/style.css" rel="stylesheet">
</head>
<body class="theme-light">
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2" href="<?php echo BASE_URL; ?>">
      <img src="<?php echo BASE_URL; ?>assets/img/logo-120.png" alt="Andreas Pareigis Stiftung Logo" width="60" height="32">
      <span class="brand-text"><?php echo SITE_NAME; ?></span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
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
<main class="container py-4">
