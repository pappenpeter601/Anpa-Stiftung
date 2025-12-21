<?php
require_once __DIR__ . '/../config.php';
$pageTitle = 'Förderung anfragen';
$pageDescription = 'Beantragen Sie eine Förderung für Ihr Projekt zur Unterstützung sozial benachteiligter Kinder und Jugendlicher in Soltau. Schnelle Bearbeitung innerhalb weniger Tage.';
include __DIR__ . '/../templates/header.php';
?>

<div class="hero pt-5 pb-5 mb-5">
  <div class="container text-center">
    <h1 class="display-5 mb-3">Förderantrag</h1>
    <p class="lead text-muted mx-auto" style="max-width: 700px;">
      Reichen Sie Ihren Förderantrag für die Andreas Pareigis Stiftung ein
    </p>
  </div>
</div>

<div class="container mb-5">
  <div class="row">
    <div class="col-lg-10 mx-auto">
      <div class="card border-0 shadow-lg p-4 mb-4">
        <h4 class="fw-bold mb-3">Vor der Antragstellung</h4>
        <p class="text-muted">Bitte stellen Sie sicher, dass Ihre Organisation die folgenden Kriterien erfüllt:</p>
        <ul class="text-muted">
          <li>Ist in Soltau ansässig</li>
          <li>Ist eine gemeinnützige Organisation</li>
          <li>Fördert Kinder und Jugendliche bis 18 Jahre</li>
          <li>Verfolgt Zwecke in den Bereichen: Jugendhilfe, Erziehung und Bildung, oder Kunst und Kultur</li>
        </ul>
      </div>

      <div class="card border-0 shadow-lg p-4">
        <h4 class="fw-bold mb-4">Förderantrag</h4>
        <form method="post" action="request_submit.php">
          
          <h6 class="fw-bold mb-3 text-primary">1. Antragsteller-Informationen</h6>
          
          <div class="mb-3">
            <label class="form-label">Name der Organisation / Person *</label>
            <input class="form-control" name="org_name" required placeholder="Name der Organisation oder Person">
          </div>
          
          <div class="mb-3">
            <label class="form-label">Kontaktperson (Position) *</label>
            <input class="form-control" name="contact_person" required placeholder="Name und Position der Kontaktperson">
          </div>
          
          <div class="mb-3">
            <label class="form-label">Postanschrift *</label>
            <textarea class="form-control" name="address" rows="2" required placeholder="Vollständige Postanschrift"></textarea>
          </div>
          
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Telefon *</label>
              <input type="tel" class="form-control" name="phone" required placeholder="+49 123 456 7890">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">E-Mail *</label>
              <input type="email" class="form-control" name="email" required placeholder="ihre.email@beispiel.de">
            </div>
          </div>

          <h6 class="fw-bold mb-3 mt-4 text-primary">2. Bankverbindung</h6>
          
          <div class="row">
            <div class="col-md-8 mb-3">
              <label class="form-label">IBAN *</label>
              <input class="form-control" name="iban" required placeholder="DE89 3704 0044 0532 0130 00">
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">BIC</label>
              <input class="form-control" name="bic" placeholder="COBADEFFXXX">
            </div>
          </div>

          <h6 class="fw-bold mb-3 mt-4 text-primary">3. Informationen zur Organisation</h6>
          
          <div class="mb-3">
            <label class="form-label">Seit wann existiert die Organisation? *</label>
            <input type="text" class="form-control" name="org_since" required placeholder="z.B. 2010 oder seit 15 Jahren">
          </div>
          
          <div class="mb-3">
            <label class="form-label">Rechtsform (z. B. Verein, gemeinnützige GmbH) *</label>
            <input class="form-control" name="legal_form" required placeholder="z.B. eingetragener Verein (e.V.)">
          </div>
          
          <div class="mb-3">
            <label class="form-label">Welche Zwecke verfolgt die Organisation? *</label>
            <textarea class="form-control" name="org_purpose" rows="3" required placeholder="Beschreiben Sie die Zwecke und Ziele Ihrer Organisation"></textarea>
          </div>

          <h6 class="fw-bold mb-3 mt-4 text-primary">4. Frühere Anträge</h6>
          
          <div class="mb-3">
            <label class="form-label">Hat Ihre Organisation bereits einen Förderantrag an die Andreas Pareigis Stiftung gestellt? *</label>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="previous_application" id="prev_yes" value="Ja" required>
              <label class="form-check-label" for="prev_yes">Ja</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="previous_application" id="prev_no" value="Nein" required>
              <label class="form-check-label" for="prev_no">Nein</label>
            </div>
          </div>
          
          <div class="mb-3">
            <label class="form-label">Wenn ja, welches Projekt?</label>
            <input class="form-control" name="previous_project" placeholder="Name des früheren Projekts">
          </div>

          <hr class="my-4">
          
          <h6 class="fw-bold mb-3 text-primary">5. Projektdetails</h6>
          
          <div class="mb-3">
            <label class="form-label">Name des Projekts *</label>
            <input class="form-control" name="project_name" required placeholder="Projekttitel">
          </div>
          
          <div class="mb-3">
            <label class="form-label">Ziel und Zweck des Projekts *</label>
            <textarea class="form-control" name="project_goal" rows="4" required placeholder="Was sind die Ziele und Zwecke des Projekts?"></textarea>
          </div>
          
          <div class="mb-3">
            <label class="form-label">Zielgruppe *</label>
            <textarea class="form-control" name="target_group" rows="3" required placeholder="Welche Zielgruppe wird durch das Projekt erreicht?"></textarea>
          </div>
          
          <div class="mb-3">
            <label class="form-label">Beschreibung / Durchführung *</label>
            <textarea class="form-control" name="project_description" rows="6" required placeholder="Beschreiben Sie detailliert, wie das Projekt durchgeführt werden soll"></textarea>
          </div>
          
          <div class="mb-3">
            <label class="form-label">Das Projekt ist erfolgreich, wenn: *</label>
            <textarea class="form-control" name="success_criteria" rows="3" required placeholder="Welche Kriterien definieren den Erfolg des Projekts?"></textarea>
          </div>
          
          <div class="mb-3">
            <label class="form-label">Angaben zu den Kosten *</label>
            <textarea class="form-control" name="cost_details" rows="4" required placeholder="Detaillierte Kostenaufstellung des Projekts"></textarea>
          </div>

          <hr class="my-4">
          
          <h6 class="fw-bold mb-3 text-primary">6. Budgetinformationen</h6>
          
          <div class="mb-3">
            <label class="form-label">Gesamtkosten des Projekts *</label>
            <div class="input-group">
              <span class="input-group-text">€</span>
              <input type="number" class="form-control" name="total_cost" required min="0" step="0.01" placeholder="0.00">
            </div>
          </div>
          
          <div class="mb-3">
            <label class="form-label">Erwartete Förderung durch die Andreas Pareigis Stiftung *</label>
            <div class="input-group">
              <span class="input-group-text">€</span>
              <input type="number" class="form-control" name="requested_amount" required min="0" step="0.01" placeholder="0.00">
            </div>
          </div>
          
          <div class="mb-3">
            <label class="form-label">Durch wen und wie wird das Projekt noch finanziell unterstützt? *</label>
            <textarea class="form-control" name="other_funding" rows="3" required placeholder="Listen Sie alle anderen Finanzierungsquellen auf"></textarea>
          </div>

          <h6 class="fw-bold mb-3 mt-4 text-primary">7. Zeitplanung</h6>
          
          <div class="mb-3">
            <label class="form-label">Zeitplan für das Projekt *</label>
            <textarea class="form-control" name="timeline" rows="4" required placeholder="Beschreiben Sie den zeitlichen Ablauf des Projekts"></textarea>
          </div>

          <h6 class="fw-bold mb-3 mt-4 text-primary">8. Bemerkungen</h6>
          
          <div class="mb-4">
            <label class="form-label">Bemerkungen</label>
            <textarea class="form-control" name="remarks" rows="3" placeholder="Weitere Anmerkungen oder Informationen"></textarea>
          </div>

          <hr class="my-4">

          <h6 class="fw-bold mb-3 text-primary">Erklärung</h6>

          <div class="card bg-light border-0 p-3 mb-4">
            <p class="mb-2 small"><strong>I.</strong> Ich bin autorisiert, den Förderantrag im Namen der oben genannten Organisation / Initiative einzureichen.</p>
            <p class="mb-2 small"><strong>II.</strong> Ich bestätige, dass alle Informationen in diesem Förderantrag korrekt sind.</p>
            <p class="mb-2 small"><strong>III.</strong> Falls sich die Angaben im Förderantrag in irgendeiner Weise ändern, werde ich die Andreas Pareigis Stiftung davon umgehend in Kenntnis setzen.</p>
            <p class="mb-0 small"><strong>IV.</strong> Alle erforderlichen Genehmigungen wurden von uns eingeholt.</p>
          </div>

          <div class="form-check mb-4 p-4 border rounded bg-light">
            <input class="form-check-input mt-1" type="checkbox" id="agreeAll" name="agree_all" required>
            <label class="form-check-label" for="agreeAll" style="margin-left: 0.5rem; line-height: 1.6;">
              Ich bestätige hiermit, dass ich die Satzung, die Allgemeinen Geschäftsbedingungen und die Datenschutzerklärung gelesen und verstanden habe. Ich bestätige außerdem, dass der Antragsteller eine gemeinnützige Organisation ist, die gemäß der Satzung der Andreas Pareigis Stiftung förderfähig ist. *
            </label>
          </div>

          <div class="d-grid gap-2">
            <button class="btn btn-primary btn-lg" type="submit">
              <svg width="20" height="20" fill="currentColor" class="me-2" viewBox="0 0 16 16" style="display:inline-block;vertical-align:middle;">
                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
              </svg>
              Förderantrag einreichen
            </button>
            <p class="text-center text-muted small mb-0">Ihr Antrag wird als PDF generiert und an die Stiftung gesendet</p>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
