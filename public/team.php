<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../src/helpers.php';
$team = load_json('data/team.json');
include __DIR__ . '/../templates/header.php';
?>

<div class="hero pt-5 pb-5 mb-5">
  <div class="container text-center">
    <h1 class="display-5 mb-3">Unser Team</h1>
    <p class="lead text-muted mx-auto" style="max-width: 700px;">
      Die Personen, die die Andreas Pareigis Stiftung leiten und betreuen
    </p>
  </div>
</div>

<div class="container mb-5">
  <div class="section-header">
    <h2>Vorstand</h2>
    <p>Der Vorstand leitet die Geschäfte der Stiftung</p>
  </div>
  
  <div class="row g-4 mb-5">
    <?php 
    $board = array_filter($team, function($m) {
      return isset($m['category']) && $m['category'] === 'board';
    });
    foreach ($board as $member): 
    ?>
      <div class="col-md-6 col-lg-4">
        <div class="card h-100 border-0 shadow-sm team-member" style="transition: all 0.3s ease;">
          <div class="card-body text-center p-4">
            <img src="<?php echo BASE_URL; ?>assets/img/<?php echo htmlspecialchars($member['image'] ?? 'person-placeholder.svg'); ?>" 
                 class="rounded-circle mb-3" 
                 width="120" 
                 height="120" 
                 style="object-fit: cover; border: 4px solid #fff; box-shadow: 0 4px 15px rgba(0,0,0,0.1);"
                 alt="<?php echo htmlspecialchars($member['name']); ?>">
            <h5 class="fw-bold mb-1"><?php echo htmlspecialchars($member['name']); ?></h5>
            <p class="text-primary fw-semibold mb-3"><?php echo htmlspecialchars($member['role'] ?? ''); ?></p>
            <?php if (!empty($member['bio'])): ?>
              <p class="text-muted small mb-3"><?php echo htmlspecialchars($member['bio']); ?></p>
            <?php endif; ?>
            
            <?php if (!empty($member['email']) || !empty($member['phone'])): ?>
              <div class="mt-3 pt-3 border-top">
                <?php if (!empty($member['email'])): ?>
                  <div class="d-flex align-items-center justify-content-center mb-2">
                    <svg width="16" height="16" fill="currentColor" class="text-primary me-2 flex-shrink-0" viewBox="0 0 16 16">
                      <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z"/>
                    </svg>
                    <a href="mailto:<?php echo htmlspecialchars($member['email']); ?>" class="small text-decoration-none" style="overflow-wrap: break-word; word-break: break-word; hyphens: auto; max-width: 100%;">
                      <?php echo htmlspecialchars($member['email']); ?>
                    </a>
                  </div>
                <?php endif; ?>
                <?php if (!empty($member['phone'])): ?>
                  <div class="d-flex align-items-center justify-content-center">
                    <svg width="16" height="16" fill="currentColor" class="text-primary me-2" viewBox="0 0 16 16">
                      <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                    </svg>
                    <span class="small text-muted">
                      <?php echo htmlspecialchars($member['phone']); ?>
                    </span>
                  </div>
                <?php endif; ?>
              </div>
            <?php endif; ?>
            
            <?php if (!empty($member['expertise'])): ?>
              <div class="mt-3 d-flex flex-wrap gap-2 justify-content-center">
                <?php foreach ($member['expertise'] as $skill): ?>
                  <span class="badge rounded-pill" style="background: rgba(37, 99, 235, 0.1); color: var(--primary); font-weight: 500;">
                    <?php echo htmlspecialchars($skill); ?>
                  </span>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="section-header mt-5">
    <h2>Kuratorium</h2>
    <p>Das Kuratorium überwacht die Geschäftsführung des Vorstands</p>
  </div>
  
  <div class="row g-4">
    <?php 
    $advisors = array_filter($team, function($m) {
      return isset($m['category']) && $m['category'] === 'kuratorium';
    });
    foreach ($advisors as $member): 
    ?>
      <div class="col-md-6 col-lg-4">
        <div class="card h-100 border-0 shadow-sm">
          <div class="card-body text-center p-4">
            <img src="<?php echo BASE_URL; ?>assets/img/<?php echo htmlspecialchars($member['image'] ?? 'person-placeholder.svg'); ?>" 
                 class="rounded-circle mb-3" 
                 width="100" 
                 height="100" 
                 style="object-fit: cover; border: 3px solid #fff; box-shadow: 0 3px 10px rgba(0,0,0,0.08);"
                 alt="<?php echo htmlspecialchars($member['name']); ?>">
            <h6 class="fw-bold mb-1"><?php echo htmlspecialchars($member['name']); ?></h6>
            <p class="text-primary small fw-semibold mb-2"><?php echo htmlspecialchars($member['role'] ?? ''); ?></p>
            <?php if (!empty($member['bio'])): ?>
              <p class="text-muted small mb-3"><?php echo htmlspecialchars($member['bio']); ?></p>
            <?php endif; ?>
            
            <?php if (!empty($member['email']) || !empty($member['phone'])): ?>
              <div class="mt-3 pt-3 border-top">
                <?php if (!empty($member['email'])): ?>
                  <div class="d-flex align-items-center justify-content-center mb-2">
                    <svg width="14" height="14" fill="currentColor" class="text-primary me-2 flex-shrink-0" viewBox="0 0 16 16">
                      <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z"/>
                    </svg>
                    <a href="mailto:<?php echo htmlspecialchars($member['email']); ?>" class="small text-decoration-none" style="overflow-wrap: break-word; word-break: break-word; hyphens: auto; font-size: 0.8rem; max-width: 100%;">
                      <?php echo htmlspecialchars($member['email']); ?>
                    </a>
                  </div>
                <?php endif; ?>
                <?php if (!empty($member['phone'])): ?>
                  <div class="d-flex align-items-center justify-content-center">
                    <svg width="14" height="14" fill="currentColor" class="text-primary me-2" viewBox="0 0 16 16">
                      <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                    </svg>
                    <span class="small text-muted" style="font-size: 0.8rem;">
                      <?php echo htmlspecialchars($member['phone']); ?>
                    </span>
                  </div>
                <?php endif; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<div class="py-5 mb-5" style="background: linear-gradient(135deg, rgba(37, 99, 235, 0.05), rgba(124, 58, 237, 0.05));">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-8">
        <h3 class="fw-bold mb-3">Kontakt</h3>
        <p class="mb-0">Unser Team vereint Expertise in Jugendhilfe, Erziehung, Bildung, Kunst und Kultur. Diese vielfältige Zusammensetzung stellt sicher, dass wir fundierte Entscheidungen treffen, die den sozial benachteiligten Kindern und Jugendlichen in Soltau zugutekommen.</p>
      </div>
      <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
        <a href="contact.php" class="btn btn-primary btn-lg">Kontaktieren Sie uns</a>
      </div>
    </div>
  </div>
</div>

<div class="container mb-5">
  <div class="row">
    <div class="col-lg-8 mx-auto">
      <div class="card border-0 shadow-lg glass-card p-4">
        <h4 class="fw-bold mb-4 text-center">Unsere Organisation</h4>
        <div class="row g-4">
          <div class="col-md-6">
            <div class="text-center">
              <div class="feature-icon mx-auto mb-3">
                <svg width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917l-7.5-3.5Z"/>
                </svg>
              </div>
              <h6 class="fw-bold">Vorstand</h6>
              <p class="text-muted small">Der Vorstand leitet die Geschäfte der Stiftung und vertritt sie gerichtlich und außergerichtlich</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="text-center">
              <div class="feature-icon mx-auto mb-3">
                <svg width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                </svg>
              </div>
              <h6 class="fw-bold">Kuratorium</h6>
              <p class="text-muted small">Das Kuratorium überwacht die Geschäftsführung des Vorstands und berät ihn bei wichtigen Entscheidungen</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="text-center">
              <div class="feature-icon mx-auto mb-3">
                <svg width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                  <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                </svg>
              </div>
              <h6 class="fw-bold">Gemeinnützig</h6>
              <p class="text-muted small">Die Stiftung ist als gemeinnützig anerkannt und verfolgt ausschließlich mildtätige Zwecke</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="text-center">
              <div class="feature-icon mx-auto mb-3">
                <svg width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5v-3zM2.5 2a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zM1 10.5A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3z"/>
                </svg>
              </div>
              <h6 class="fw-bold">Lokaler Fokus</h6>
              <p class="text-muted small">Die Stiftung fördert ausschließlich in Soltau ansässige gemeinnützige Einrichtungen</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>
