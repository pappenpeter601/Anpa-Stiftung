<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../src/helpers.php';
require_once __DIR__ . '/../src/SecurityHelper.php';

// Set security headers
SecurityHelper::setSecurityHeaders();

$pageTitle = 'Kontakt';
$pageDescription = 'Nehmen Sie Kontakt mit der Andreas Pareigis Stiftung auf. Wir beantworten Ihre Fragen zur Förderung und unterstützen Sie bei Ihrem Antrag.';

// Generate CSRF token
$csrfToken = SecurityHelper::generateCSRFToken();
include __DIR__ . '/../templates/header.php';
?>

<div class="hero pt-5 pb-5 mb-5">
  <div class="container text-center">
    <h1 class="display-5 mb-3">Kontakt</h1>
    <p class="lead text-muted mx-auto" style="max-width: 700px;">
      Haben Sie Fragen oder möchten Sie mehr über unsere Arbeit erfahren? Wir sind für Sie da!
    </p>
  </div>
</div>

<div class="container mb-5" style="padding-bottom: 8rem;">
  <div class="row g-4">
    
    <!-- Contact Information -->
    <div class="col-lg-4">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body p-4">
          <h5 class="fw-bold mb-4">Kontaktinformationen</h5>
          
          <div class="mb-4">
            <div class="d-flex align-items-start mb-3">
              <div class="flex-shrink-0">
                <svg width="24" height="24" fill="currentColor" class="text-primary" viewBox="0 0 16 16">
                  <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                  <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                </svg>
              </div>
              <div class="ms-3">
                <h6 class="fw-bold mb-1">Adresse</h6>
                <p class="text-muted mb-0">
                  Andreas Pareigis Stiftung<br>
                  Meinern 15a<br>
                  29614 Soltau
                </p>
              </div>
            </div>
          </div>

          <div class="mb-4">
            <div class="d-flex align-items-start mb-3">
              <div class="flex-shrink-0">
                <svg width="24" height="24" fill="currentColor" class="text-primary" viewBox="0 0 16 16">
                  <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z"/>
                </svg>
              </div>
              <div class="ms-3">
                <h6 class="fw-bold mb-1">E-Mail</h6>
                <a href="mailto:info@andreas-pareigis-stiftung.de" class="text-decoration-none">
                  info@andreas-pareigis-stiftung.de
                </a>
              </div>
            </div>
          </div>

          <div class="mb-4">
            <div class="d-flex align-items-start mb-3">
              <div class="flex-shrink-0">
                <svg width="24" height="24" fill="currentColor" class="text-primary" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                </svg>
              </div>
              <div class="ms-3">
                <h6 class="fw-bold mb-1">Telefon</h6>
                <p class="text-muted mb-0">
                  Bitte kontaktieren Sie uns per E-Mail.<br>
                  Wir rufen Sie gerne zurück.
                </p>
              </div>
            </div>
          </div>

        </div>
      </div>

      <div class="card border-0 shadow-sm mt-4">
        <div class="card-body p-4">
          <h6 class="fw-bold mb-3">Schnellzugriff</h6>
          <div class="d-grid gap-2">
            <a href="statutes.php" class="btn btn-outline-primary btn-sm">
              <svg width="16" height="16" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                <path d="M5 0h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z"/>
              </svg>
              Satzung ansehen
            </a>
            <a href="request.php" class="btn btn-outline-primary btn-sm">
              <svg width="16" height="16" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
              </svg>
              Förderantrag stellen
            </a>
            <a href="team.php" class="btn btn-outline-primary btn-sm">
              <svg width="16" height="16" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8z"/>
              </svg>
              Unser Team
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Contact Form -->
    <div class="col-lg-8">
      <div class="card border-0 shadow-lg">
        <div class="card-body p-4">
          <h4 class="fw-bold mb-4">Nachricht senden</h4>
          <p class="text-muted mb-4">
            Füllen Sie das untenstehende Formular aus und wir werden uns so schnell wie möglich bei Ihnen melden. 
            Bitte beachten Sie, dass wir nur Anfragen von gemeinnützigen Organisationen in Soltau bearbeiten können.
          </p>

          <form method="post" action="contact_submit.php">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
            <div class="d-none" aria-hidden="true">
              <label>Bitte nicht ausfüllen</label>
              <input type="text" name="website" tabindex="-1" autocomplete="off">
            </div>
            <input type="hidden" name="form_time" value="<?php echo time(); ?>">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Vor- und Nachname *</label>
                <input class="form-control" name="name" required pattern="[A-Za-zÄÖÜäöüß\s\-']{2,80}" title="Nur Buchstaben (inkl. ä, ö, ü, ß), Leerzeichen, Bindestriche oder Apostrophe" placeholder="Max Mustermann">
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Organisation</label>
                <input class="form-control" name="organization" placeholder="Name Ihrer Organisation">
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">E-Mail-Adresse *</label>
                <input type="email" class="form-control" name="email" required placeholder="ihre.email@beispiel.de">
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Telefonnummer</label>
                <input type="tel" class="form-control" name="phone" placeholder="+49 123 456 7890">
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Betreff *</label>
              <select class="form-select" name="subject" required>
                <option value="">-- Bitte wählen --</option>
                <option value="Allgemeine Anfrage">Allgemeine Anfrage</option>
                <option value="Förderantrag">Frage zum Förderantrag</option>
                <option value="Projektstatus">Projektstatus abfragen</option>
                <option value="Partnerschaft">Partnerschaft anfragen</option>
                <option value="Sonstiges">Sonstiges</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Ihre Nachricht *</label>
              <textarea class="form-control" name="message" rows="6" required minlength="20" placeholder="Beschreiben Sie bitte Ihr Anliegen..."></textarea>
              <small class="text-muted">Mindestens 20 Zeichen, bitte als Satz formulieren. Nur HTTPS-Links erlaubt.</small>
            </div>

            <div class="form-check mb-4">
              <input class="form-check-input" type="checkbox" id="privacy" required>
              <label class="form-check-label" for="privacy">
                Ich habe die <a href="datenschutz.php" target="_blank">Datenschutzbestimmungen</a> gelesen und akzeptiere diese. *
              </label>
            </div>

            <div class="d-grid gap-2">
              <button class="btn btn-primary btn-lg" type="submit">
                <svg width="20" height="20" fill="currentColor" class="me-2" viewBox="0 0 16 16" style="display:inline-block;vertical-align:middle;">
                  <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
                </svg>
                Nachricht senden
              </button>
              <p class="text-center text-muted small mb-0">Wir antworten in der Regel innerhalb von 2-3 Werktagen</p>
            </div>
          </form>

        </div>
      </div>

      <!-- FAQ Section -->
      <div class="card border-0 shadow-sm mt-4">
        <div class="card-body p-4">
          <h5 class="fw-bold mb-3">Häufig gestellte Fragen</h5>
          
          <div class="accordion" id="faqAccordion">
            <div class="accordion-item border-0 mb-2">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                  Wer kann einen Förderantrag stellen?
                </button>
              </h2>
              <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                  Die Andreas Pareigis Stiftung fördert ausschließlich in Soltau ansässige gemeinnützige Organisationen, die Projekte in den Bereichen Jugendhilfe, Erziehung und Bildung, sowie Kunst und Kultur für Kinder und Jugendliche bis 18 Jahre durchführen.
                </div>
              </div>
            </div>

            <div class="accordion-item border-0 mb-2">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                  Wie lange dauert die Bearbeitung eines Antrags?
                </button>
              </h2>
              <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                  Die Bearbeitung eines Förderantrags dauert in der Regel nur wenige Tage. Sie erhalten zeitnah eine Rückmeldung vom Vorstand und Kuratorium.
                </div>
              </div>
            </div>

            <div class="accordion-item border-0 mb-2">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                  Welche Unterlagen werden benötigt?
                </button>
              </h2>
              <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                  Für einen Förderantrag benötigen wir eine vollständige Projektbeschreibung, einen Kostenplan, Informationen zur Organisation und ggf. Nachweise über die Gemeinnützigkeit.
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<div style="height: 150px;"></div>

<?php include __DIR__ . '/../templates/footer.php'; ?>
