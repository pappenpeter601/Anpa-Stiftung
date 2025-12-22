<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../src/helpers.php';
$pageTitle = 'Über uns';
$pageDescription = 'Die Andreas Pareigis Stiftung ist eine gemeinnützige Stiftung mit Sitz in Soltau zur Förderung sozial benachteiligter Kinder und Jugendlicher in den Bereichen Jugendhilfe, Bildung und Kultur.';
include __DIR__ . '/../templates/header.php';
?>

<div class="hero pt-5 pb-5 mb-5">
  <div class="container text-center">
    <h1 class="display-5 mb-3">Über die Andreas Pareigis Stiftung</h1>
    <p class="lead text-muted mx-auto" style="max-width: 700px;">
      Eine gemeinnützige Stiftung mit Sitz in Soltau zur Förderung sozial benachteiligter Kinder und Jugendlicher
    </p>
  </div>
</div>

<div class="container mb-5">
  <div class="row align-items-center mb-5">
    <div class="col-lg-6">
      <h2 class="fw-bold mb-4">Unser Stiftungszweck</h2>
      <p class="lead">Die Andreas Pareigis Stiftung fördert mildtätige und gemeinnützige Zwecke gemäß § 53 AO.</p>
      <p>Die Stiftung verfolgt folgende gemeinnützige Zwecke:</p>
      <ul>
        <li>Förderung der Jugendhilfe</li>
        <li>Förderung der Erziehung und Bildung</li>
        <li>Förderung der Kunst und Kultur</li>
      </ul>
      <p>Der jährlich aus der Stiftung erzielte Ertrag kommt gemeinnützigen Institutionen zugute, die sozial benachteiligten Kindern und Jugendlichen die Teilnahme an Kultur und Bildung ermöglichen und sie in die Gesellschaft integrieren.</p>
    </div>
    <div class="col-lg-6">
      <div class="card border-0 shadow-lg glass-card p-4">
        <h5 class="fw-bold mb-3">Stiftung auf einen Blick</h5>
        <div class="mb-3">
          <p class="mb-2"><strong>Name:</strong> Andreas Pareigis Stiftung</p>
          <p class="mb-2"><strong>Rechtsform:</strong> Rechtsfähige Stiftung des bürgerlichen Rechts</p>
          <p class="mb-2"><strong>Sitz:</strong> Meinern 15a, 29614 Soltau</p>
          <p class="mb-2"><strong>Status:</strong> Gemeinnützig anerkannt</p>
          <p class="mb-0"><strong>Fördergebiet:</strong> Ausschließlich in Soltau ansässige gemeinnützige Einrichtungen</p>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container mb-5">
  <div class="section-header">
    <h2>Gemeinnützigkeit</h2>
    <p>Die Stiftung verfolgt ausschließlich gemeinnützige und mildtätige Zwecke</p>
  </div>
  <div class="row g-4">
    <div class="col-md-4">
      <div class="card h-100 border-0 shadow-sm">
        <div class="card-body">
          <div class="feature-icon">
            <svg width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
            </svg>
          </div>
          <h5 class="fw-bold">Selbstlosigkeit</h5>
          <p class="text-muted">Die Stiftung ist selbstlos tätig und verfolgt nicht in erster Linie eigenwirtschaftliche Zwecke.</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card h-100 border-0 shadow-sm">
        <div class="card-body">
          <div class="feature-icon">
            <svg width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
              <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm4.5 0a.5.5 0 0 0-.5.5v2a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 0-.5-.5h-2z"/>
            </svg>
          </div>
          <h5 class="fw-bold">Zweckgebundene Mittelverwendung</h5>
          <p class="text-muted">Mittel der Stiftung dürfen nur für die satzungsmäßigen Zwecke verwendet werden.</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card h-100 border-0 shadow-sm">
        <div class="card-body">
          <div class="feature-icon">
            <svg width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
              <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
            </svg>
          </div>
          <h5 class="fw-bold">Steuerbegünstigt</h5>
          <p class="text-muted">Die Stiftung verfolgt gemeinnützige und mildtätige Zwecke im Sinne der Abgabenordnung.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container mb-5">
  <div class="section-header">
    <h2>Unsere Werte</h2>
    <p>Grundsätze, die unser Handeln leiten</p>
  </div>
  <div class="row g-4">
    <div class="col-md-4">
      <div class="card h-100 border-0 shadow-sm">
        <div class="card-body">
          <div class="feature-icon">
            <svg width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
              <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
            </svg>
          </div>
          <h5 class="fw-bold">Chancengleichheit</h5>
          <p class="text-muted">Wir priorisieren Projekte, die benachteiligten Kindern und Jugendlichen Zugang zu Bildung und Kultur ermöglichen.</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card h-100 border-0 shadow-sm">
        <div class="card-body">
          <div class="feature-icon">
            <svg width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
              <path d="M2 1a1 1 0 0 0-1 1v4.586a1 1 0 0 0 .293.707l7 7a1 1 0 0 0 1.414 0l4.586-4.586a1 1 0 0 0 0-1.414l-7-7A1 1 0 0 0 6.586 1H2zm4 3.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
            </svg>
          </div>
          <h5 class="fw-bold">Zusammenarbeit</h5>
          <p class="text-muted">Wir arbeiten mit gemeinnützigen Organisationen in Soltau zusammen, um unsere Reichweite und Wirksamkeit zu maximieren.</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card h-100 border-0 shadow-sm">
        <div class="card-body">
          <div class="feature-icon">
            <svg width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
              <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
              <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4z"/>
            </svg>
          </div>
          <h5 class="fw-bold">Nachhaltigkeit</h5>
          <p class="text-muted">Wir unterstützen Programme, die langfristige Wirkung erzielen und nachhaltige Verbesserungen schaffen.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="py-5 mb-5" style="background: linear-gradient(135deg, rgba(37, 99, 235, 0.05), rgba(124, 58, 237, 0.05));">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-8">
        <h3 class="fw-bold mb-3">Unser Engagement für junge Menschen</h3>
        <p class="mb-0">Die Andreas Pareigis Stiftung setzt sich dafür ein, ein Motor für positive Veränderungen zu sein. Wir glauben, dass Investitionen in junge Menschen Investitionen in die Zukunft sind, und wir gehen diese Verantwortung mit größter Hingabe und Sorgfalt an. Durch sorgfältige Projektauswahl, kontinuierliche Begleitung und ständiges Lernen stellen wir sicher, dass jeder investierte Euro maximalen Nutzen für die von uns unterstützten Kinder und Jugendlichen schafft.</p>
      </div>
      <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
        <a href="team.php" class="btn btn-primary btn-lg">Unser Team kennenlernen</a>
      </div>
    </div>
  </div>
</div>

<div class="container mb-5">
  <div class="row">
    <div class="col-lg-8 mx-auto">
      <div class="card border-0 shadow-lg p-4">
        <h4 class="fw-bold mb-4">Wie wir arbeiten</h4>
        <div class="row g-4">
          <div class="col-md-6">
            <div class="d-flex gap-3">
              <div class="text-primary fw-bold fs-3">01</div>
              <div>
                <h6 class="fw-bold">Bedarf ermitteln</h6>
                <p class="small text-muted mb-0">Wir identifizieren wichtige Bedarfe, die Kinder und Jugendliche in Soltau betreffen.</p>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="d-flex gap-3">
              <div class="text-primary fw-bold fs-3">02</div>
              <div>
                <h6 class="fw-bold">Projekte bewerten</h6>
                <p class="small text-muted mb-0">Vorstand und Kuratorium prüfen Anträge anhand von Wirkungspotenzial, Machbarkeit und Übereinstimmung mit unserem Stiftungszweck.</p>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="d-flex gap-3">
              <div class="text-primary fw-bold fs-3">03</div>
              <div>
                <h6 class="fw-bold">Förderung gewähren</h6>
                <p class="small text-muted mb-0">Ausgewählte Projekte erhalten finanzielle Unterstützung und kontinuierliche Begleitung.</p>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="d-flex gap-3">
              <div class="text-primary fw-bold fs-3">04</div>
              <div>
                <h6 class="fw-bold">Wirkung messen</h6>
                <p class="small text-muted mb-0">Wir dokumentieren Ergebnisse und teilen Erkenntnisse, um zukünftige Förderungen zu verbessern.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>
