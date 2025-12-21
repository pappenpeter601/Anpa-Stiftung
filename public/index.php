<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../src/helpers.php';
$team = load_json('data/team.json');
$projects = load_json('data/projects.json');
include __DIR__ . '/../templates/header.php';
?>

<section class="hero pt-5 pb-5 mb-5">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-7">
        <div class="mb-3">
          <span class="stat-badge">
            <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
              <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
            </svg>
            Führende Stiftung für Jugendförderung
          </span>
        </div>
        <h1 class="display-5">Förderung sozial benachteiligter Kinder und Jugendlicher</h1>
        <p class="lead">Die Andreas Pareigis Stiftung unterstützt gemeinnützige Institutionen in Soltau, die sozial benachteiligten Kindern und Jugendlichen die Teilnahme an Kultur und Bildung ermöglichen und sie in die Gesellschaft integrieren.</p>
        <div class="d-flex flex-wrap gap-3 mt-4">
          <a href="request.php" class="btn btn-primary btn-lg">
            <svg width="20" height="20" fill="currentColor" class="me-2" viewBox="0 0 16 16" style="display:inline-block;vertical-align:middle;">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
              <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
            </svg>
            Förderung anfragen
          </a>
          <a href="projects.php" class="btn btn-outline-secondary btn-lg">
            Unsere Projekte ansehen
          </a>
        </div>
      </div>
      <div class="col-lg-5 d-none d-lg-block text-end">
        <img src="<?php echo BASE_URL; ?>assets/img/logo-400.png" alt="Andreas Pareigis Stiftung" class="img-fluid hero-img" style="max-width: 90%;">
      </div>
    </div>
  </div>
</section>

<div class="container mb-5">
  <div class="section-header">
    <h2>Unsere Förderbereiche</h2>
    <p>Die Stiftung fördert gemeinnützige Zwecke gemäß Satzung</p>
  </div>
  <div class="row g-4">
    <div class="col-md-4">
      <div class="card h-100 border-0 shadow-sm">
        <div class="card-body text-center">
          <div class="feature-icon mx-auto">
            <svg width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917l-7.5-3.5Z"/>
              <path d="M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .294.605l4.5 1.8a.5.5 0 0 0 .372 0l4.5-1.8a.5.5 0 0 0 .294-.605l-.5-1.7a.5.5 0 0 0-.656-.327L8 10.466 4.176 9.032Z"/>
            </svg>
          </div>
          <h5 class="fw-bold">Förderung der Erziehung und Bildung</h5>
          <p class="text-muted">Unterstützung von Bildungsangeboten für sozial benachteiligte Kinder und Jugendliche</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card h-100 border-0 shadow-sm">
        <div class="card-body text-center">
          <div class="feature-icon mx-auto">
            <svg width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
              <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
            </svg>
          </div>
          <h5 class="fw-bold">Förderung der Jugendhilfe</h5>
          <p class="text-muted">Integration sozial benachteiligter Kinder und Jugendlicher in die Gesellschaft</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card h-100 border-0 shadow-sm">
        <div class="card-body text-center">
          <div class="feature-icon mx-auto">
            <svg width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
              <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm4.5 0a.5.5 0 0 0-.5.5v2a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 0-.5-.5h-2zm0 4a.5.5 0 0 0-.5.5v5a.5.5 0 0 0 .5.5h5a.5.5 0 0 0 .5-.5v-5a.5.5 0 0 0-.5-.5h-5z"/>
            </svg>
          </div>
          <h5 class="fw-bold">Förderung der Kunst und Kultur</h5>
          <p class="text-muted">Teilnahme an kulturellen Angeboten für benachteiligte junge Menschen</p>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-lg-8">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Aktuelle Projekte</h3>
        <a href="projects.php" class="btn btn-outline-primary">Alle anzeigen</a>
      </div>
      <div class="row">
        <?php foreach (array_slice($projects, 0, 6) as $p): ?>
          <div class="col-md-6 mb-4 animate-fade-in-up">
            <div class="card h-100 shadow-sm project-card">
              <img src="<?php echo BASE_URL; ?>assets/img/<?php echo htmlspecialchars($p['image'] ?? 'project-placeholder.svg'); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($p['title']); ?>">
              <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($p['title']); ?></h5>
                <p class="card-text text-muted"><?php echo htmlspecialchars($p['summary'] ?? ''); ?></p>
                <div class="d-flex justify-content-between align-items-center">
                  <small class="text-muted">
                    <svg width="14" height="14" fill="currentColor" class="me-1" viewBox="0 0 16 16" style="display:inline-block;vertical-align:middle;">
                      <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                      <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                    </svg>
                    <?php echo htmlspecialchars($p['year'] ?? ''); ?>
                  </small>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    
    <div class="col-lg-4">
      <h4 class="fw-bold mb-4">Unsere Führung</h4>
      <?php foreach (array_slice($team, 0, 5) as $m): ?>
        <div class="d-flex mb-3 align-items-center team-member">
          <img src="<?php echo BASE_URL; ?>assets/img/<?php echo htmlspecialchars($m['image'] ?? 'person-placeholder.svg'); ?>" width="72" height="72" class="rounded-circle me-3 team-avatar" alt="<?php echo htmlspecialchars($m['name']); ?>">
          <div>
            <strong class="d-block"><?php echo htmlspecialchars($m['name']); ?></strong>
            <small class="text-muted"><?php echo htmlspecialchars($m['role'] ?? ''); ?></small>
          </div>
        </div>
      <?php endforeach; ?>
      
      <a href="team.php" class="btn btn-outline-primary w-100 mt-3">Gesamtes Team kennenlernen</a>

      <div class="card mt-4 border-0 shadow-sm glass-card">
        <div class="card-body">
          <h6 class="fw-bold">Unterstützung benötigt?</h6>
          <p class="small text-muted mb-3">Reichen Sie einen Antrag ein und unser Team wird Ihren Projektvorschlag zur Förderung prüfen.</p>
          <a href="request.php" class="btn btn-primary w-100">Antrag einreichen</a>
        </div>
      </div>

      <div class="card mt-4 border-0 shadow-sm">
        <div class="card-body">
          <h6 class="fw-bold">Stiftungsdokumente</h6>
          <ul class="list-unstyled small mb-0">
            <li class="mb-2">
              <a href="statutes.php" class="text-decoration-none">
                <svg width="14" height="14" fill="currentColor" class="me-2" viewBox="0 0 16 16" style="display:inline-block;vertical-align:middle;">
                  <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                </svg>
                Stiftungssatzung
              </a>
            </li>
            <li class="mb-2">
              <a href="about.php" class="text-decoration-none">
                <svg width="14" height="14" fill="currentColor" class="me-2" viewBox="0 0 16 16" style="display:inline-block;vertical-align:middle;">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                </svg>
                Über uns
              </a>
            </li>
            <li>
              <a href="contact.php" class="text-decoration-none">
                <svg width="14" height="14" fill="currentColor" class="me-2" viewBox="0 0 16 16" style="display:inline-block;vertical-align:middle;">
                  <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z"/>
                </svg>
                Kontakt
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>
