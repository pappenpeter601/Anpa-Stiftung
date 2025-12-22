  </main>
  <?php
  // Load foundation data for footer
  $foundationData = load_json('data/foundation.json');
  ?>
  <footer class="site-footer mt-5" role="contentinfo" aria-label="Fußzeile">
    <div class="footer-top py-5 text-light" style="background:linear-gradient(135deg,#0d6efd,#7b61ff);">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <img src="<?php echo BASE_URL; ?>assets/img/logo-120.png" alt="<?php echo htmlspecialchars($foundationData['name'] ?? SITE_NAME); ?> Logo" width="64" height="34">
            <p class="mt-3 small">&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($foundationData['name'] ?? SITE_NAME); ?> — Wir helfen Kindern vor Ort.</p>
          </div>
          <div class="col-md-3">
            <h6>Navigation</h6>
            <nav aria-label="Fußzeilen-Navigation">
              <ul class="list-unstyled small">
                <li><a class="text-light" href="<?php echo BASE_URL; ?>">Startseite</a></li>
                <li><a class="text-light" href="<?php echo BASE_URL; ?>about.php">Über uns</a></li>
                <li><a class="text-light" href="<?php echo BASE_URL; ?>projects.php">Projekte</a></li>
                <li><a class="text-light" href="<?php echo BASE_URL; ?>team.php">Team</a></li>
                <li><a class="text-light" href="<?php echo BASE_URL; ?>request.php">Förderung anfragen</a></li>
                <li><a class="text-light" href="<?php echo BASE_URL; ?>contact.php">Kontakt</a></li>
              </ul>
            </nav>
          </div>
          <div class="col-md-3">
            <h6>Kontakt</h6>
            <address class="small mb-0">
              <p class="mb-1"><?php echo htmlspecialchars($foundationData['name'] ?? 'Andreas Pareigis Stiftung'); ?></p>
              <p class="mb-1"><?php 
                if (isset($foundationData['address'])) {
                  echo htmlspecialchars($foundationData['address']['street'] . ', ' . $foundationData['address']['postal_code'] . ' ' . $foundationData['address']['city']);
                } else {
                  echo 'Meinern 15a, 29614 Soltau';
                }
              ?></p>
              <p class="mb-0">E-Mail: <a class="text-light" href="mailto:<?php echo htmlspecialchars($foundationData['contact']['email'] ?? ADMIN_EMAIL); ?>"><?php echo htmlspecialchars($foundationData['contact']['email'] ?? ADMIN_EMAIL); ?></a></p>
            </address>
          </div>
          <div class="col-md-3">
            <h6>Bankverbindung</h6>
            <div class="small">
              <?php if (isset($foundationData['bank_account'])): ?>
                <p class="mb-1"><strong>IBAN:</strong><br><?php echo htmlspecialchars($foundationData['bank_account']['iban']); ?></p>
                <p class="mb-1"><strong>BIC:</strong> <?php echo htmlspecialchars($foundationData['bank_account']['bic']); ?></p>
              <?php endif; ?>
              <?php if (isset($foundationData['tax']['tax_id'])): ?>
                <p class="mb-0 mt-2"><strong>Steuernummer:</strong><br><?php echo htmlspecialchars($foundationData['tax']['tax_id']); ?></p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="py-3 bg-light text-center small">
      <div class="container">
        © <?php echo date('Y'); ?> <?php echo htmlspecialchars($foundationData['name'] ?? SITE_NAME); ?> — 
        <a href="<?php echo BASE_URL; ?>impressum.php">Impressum</a> | 
        <a href="<?php echo BASE_URL; ?>datenschutz.php">Datenschutz & AGB</a>
      </div>
    </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <?php 
  $currentPage = basename($_SERVER['SCRIPT_FILENAME']);
  if ($currentPage === 'request.php'): 
  ?>
  <script src="<?php echo rtrim(BASE_URL, '/'); ?>/assets/js/form-validation.js"></script>
  <?php endif; ?>
</body>
</html>
