  </main>
  <footer class="site-footer mt-5" role="contentinfo" aria-label="Fußzeile">
    <div class="footer-top py-5 text-light" style="background:linear-gradient(135deg,#0d6efd,#7b61ff);">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <img src="<?php echo BASE_URL; ?>assets/img/logo-120.png" alt="Andreas Pareigis Stiftung Logo" width="64" height="34">
            <p class="mt-3 small">&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?> — Wir helfen Kindern vor Ort.</p>
          </div>
          <div class="col-md-4">
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
          <div class="col-md-4">
            <h6>Kontakt</h6>
            <address class="small mb-0">
              <p class="mb-1">Andreas Pareigis Stiftung</p>
              <p class="mb-1">Meinern 15a, 29614 Soltau</p>
              <p class="mb-0">E-Mail: <a class="text-light" href="mailto:<?php echo ADMIN_EMAIL; ?>"><?php echo ADMIN_EMAIL; ?></a></p>
            </address>
          </div>
        </div>
      </div>
    </div>
    <div class="py-3 bg-light text-center small">
      <div class="container">
        © <?php echo date('Y'); ?> <?php echo SITE_NAME; ?> — 
        <a href="<?php echo BASE_URL; ?>impressum.php">Impressum</a> | 
        <a href="<?php echo BASE_URL; ?>datenschutz.php">Datenschutz & AGB</a>
      </div>
    </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
