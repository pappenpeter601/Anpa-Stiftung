<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../src/helpers.php';
require_once __DIR__ . '/../src/SecurityHelper.php';

// Set security headers
SecurityHelper::setSecurityHeaders();

$pageTitle = 'Förderung anfragen';
$pageDescription = 'Beantragen Sie eine Förderung für Ihr Projekt zur Unterstützung sozial benachteiligter Kinder und Jugendlicher in Soltau. Schnelle Bearbeitung innerhalb weniger Tage.';

// Generate CSRF token
$csrfToken = SecurityHelper::generateCSRFToken();

// Load questionnaire structure
$questionnaire = load_json('data/questionnaire.json');

include __DIR__ . '/../templates/header.php';

/**
 * Render a form field based on questionnaire configuration
 */
function renderField($question) {
    $id = htmlspecialchars($question['id']);
    $label = htmlspecialchars($question['label']);
    $required = $question['required'] ? 'required' : '';
    $requiredMark = $question['required'] ? ' *' : '';
    $placeholder = htmlspecialchars($question['placeholder'] ?? '');
    
    // Build validation attributes
    $validationAttrs = '';
    if (isset($question['min_length'])) {
        $validationAttrs .= ' minlength="' . (int)$question['min_length'] . '"';
    }
    if (isset($question['pattern'])) {
        $validationAttrs .= ' pattern="' . htmlspecialchars($question['pattern']) . '"';
    }
    
    $width = $question['width'] ?? 'full';
    $colClass = match($width) {
        'half' => 'col-md-6',
        'one-third' => 'col-md-4',
        'two-thirds' => 'col-md-8',
        default => 'col-12'
    };
    
    echo '<div class="' . $colClass . ' mb-3">';
    echo '<label class="form-label">' . $label . $requiredMark . '</label>';
    
    switch ($question['type']) {
        case 'textarea':
            $rows = $question['rows'] ?? 3;
            echo '<textarea class="form-control" name="' . $id . '" rows="' . $rows . '" ' . $required . $validationAttrs . ' placeholder="' . $placeholder . '"></textarea>';
            break;
            
        case 'radio':
            foreach ($question['options'] as $option) {
                $optionValue = htmlspecialchars($option['value']);
                $optionLabel = htmlspecialchars($option['label']);
                $radioId = $id . '_' . preg_replace('/[^a-z0-9]/i', '', strtolower($optionValue));
                echo '<div class="form-check">';
                echo '<input class="form-check-input" type="radio" name="' . $id . '" id="' . $radioId . '" value="' . $optionValue . '" ' . $required . '>';
                echo '<label class="form-check-label" for="' . $radioId . '">' . $optionLabel . '</label>';
                echo '</div>';
            }
            break;
            
        case 'text':
        default:
            // Determine input type (use inputmode for numeric fields)
            $inputType = 'text';
            $inputMode = '';
            if (isset($question['input_type']) && $question['input_type'] === 'numeric') {
                $inputMode = ' inputmode="decimal"';
            }
            
            if (isset($question['prefix'])) {
                echo '<div class="input-group">';
                echo '<span class="input-group-text">' . htmlspecialchars($question['prefix']) . '</span>';
                echo '<input type="' . $inputType . '" class="form-control" name="' . $id . '" ' . $required . $validationAttrs . $inputMode . ' placeholder="' . $placeholder . '">';
                echo '</div>';
            } else {
                echo '<input type="' . $inputType . '" class="form-control" name="' . $id . '" ' . $required . $validationAttrs . $inputMode . ' placeholder="' . $placeholder . '">';
            }
            break;
    }
    
    echo '</div>';
}
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
      
      <?php if (isset($questionnaire['criteria'])): ?>
      <div class="card border-0 shadow-lg p-4 mb-4">
        <h4 class="fw-bold mb-3"><?php echo htmlspecialchars($questionnaire['criteria']['title']); ?></h4>
        <p class="text-muted"><?php echo htmlspecialchars($questionnaire['criteria']['description']); ?></p>
        <ul class="text-muted">
          <?php foreach ($questionnaire['criteria']['items'] as $item): ?>
            <li><?php echo htmlspecialchars($item); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php endif; ?>

      <!-- Session Timeout Notice -->
      <div class="alert alert-info border-0 shadow-sm mb-4">
        <div class="d-flex align-items-start">
          <svg width="24" height="24" fill="currentColor" class="me-3 flex-shrink-0 mt-1" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
          </svg>
          <div>
            <strong>Hinweis zur Bearbeitungszeit:</strong>
            <p class="mb-0 mt-1">Sie haben <strong>2 Stunden Zeit</strong> zum Ausfüllen dieses Formulars. Danach läuft Ihre Sitzung aus Sicherheitsgründen ab. Bei längeren Texten empfehlen wir, diese zunächst in einem Texteditor vorzubereiten.</p>
          </div>
        </div>
      </div>

      <div class="card border-0 shadow-lg p-4">
        <h4 class="fw-bold mb-4">Förderantrag</h4>
        <form method="post" action="request_submit.php">
          <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
          
          <?php foreach ($questionnaire['sections'] as $section): ?>
            <h6 class="fw-bold mb-3 <?php echo $section['order'] > 1 ? 'mt-4' : ''; ?> text-primary">
              <?php echo $section['order']; ?>. <?php echo htmlspecialchars($section['title']); ?>
            </h6>
            
            <?php if ($section['id'] === 'project_details'): ?>
              <hr class="my-4">
            <?php endif; ?>
            
            <?php 
            // Check if we need a row wrapper for multi-column layout
            $hasMultiColumn = false;
            foreach ($section['questions'] as $q) {
                if (isset($q['width']) && $q['width'] !== 'full') {
                    $hasMultiColumn = true;
                    break;
                }
            }
            
            if ($hasMultiColumn): ?>
              <div class="row">
                <?php foreach ($section['questions'] as $question): ?>
                  <?php renderField($question); ?>
                <?php endforeach; ?>
              </div>
            <?php else: ?>
              <?php foreach ($section['questions'] as $question): ?>
                <?php renderField($question); ?>
              <?php endforeach; ?>
            <?php endif; ?>
            
            <?php if ($section['id'] === 'remarks'): ?>
              <hr class="my-4">
            <?php endif; ?>
          <?php endforeach; ?>

          <?php if (isset($questionnaire['declaration'])): ?>
            <h6 class="fw-bold mb-3 text-primary"><?php echo htmlspecialchars($questionnaire['declaration']['title']); ?></h6>

            <div class="card bg-light border-0 p-3 mb-4">
              <?php foreach ($questionnaire['declaration']['statements'] as $index => $statement): ?>
                <p class="<?php echo $index < count($questionnaire['declaration']['statements']) - 1 ? 'mb-2' : 'mb-0'; ?> small">
                  <strong><?php echo ['I', 'II', 'III', 'IV', 'V', 'VI'][$index]; ?>.</strong>
                  <?php echo htmlspecialchars($statement); ?>
                </p>
              <?php endforeach; ?>
            </div>

            <?php $agreement = $questionnaire['declaration']['agreement']; ?>
            <div class="form-check mb-4 p-4 border rounded bg-light">
              <input class="form-check-input mt-1" type="checkbox" id="<?php echo htmlspecialchars($agreement['id']); ?>" 
                     name="<?php echo htmlspecialchars($agreement['id']); ?>" <?php echo $agreement['required'] ? 'required' : ''; ?>>
              <label class="form-check-label" for="<?php echo htmlspecialchars($agreement['id']); ?>" style="margin-left: 0.5rem; line-height: 1.6;">
                <?php 
                  // Replace document names with links
                  $labelText = $agreement['label'];
                  $labelText = str_replace(
                    ['Satzung', 'Allgemeinen Geschäftsbedingungen', 'Datenschutzerklärung'],
                    [
                      '<a href="' . BASE_URL . 'statutes.php" target="_blank" class="text-primary">Satzung</a>',
                      '<a href="' . BASE_URL . 'datenschutz.php" target="_blank" class="text-primary">Allgemeinen Geschäftsbedingungen</a>',
                      '<a href="' . BASE_URL . 'datenschutz.php" target="_blank" class="text-primary">Datenschutzerklärung</a>'
                    ],
                    htmlspecialchars($labelText)
                  );
                  echo $labelText;
                ?> <?php echo $agreement['required'] ? '*' : ''; ?>
              </label>
            </div>
          <?php endif; ?>

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

<style>
.field-valid { border-color: #28a745 !important; background-color: #f0fdf4 !important; }
.field-invalid { border-color: #dc3545 !important; background-color: #fef2f2 !important; }
.validation-feedback { font-size: 0.875rem; margin-top: 0.25rem; display: flex; align-items: center; gap: 0.5rem; }
.validation-feedback.valid { color: #28a745; font-weight: 500; }
.validation-feedback.invalid { color: #dc3545; font-weight: 500; }
.char-counter { font-size: 0.8rem; color: #6c757d; margin-top: 0.25rem; }
.char-counter.warning { color: #ffc107; font-weight: 500; }
.char-counter.success { color: #28a745; font-weight: 500; }
</style>

<script>
(function() {
    'use strict';
    
    console.log('🚀 Form validation initializing...');
    
    const form = document.querySelector('form[action="request_submit.php"]');
    if (!form) {
        console.error('❌ Form not found');
        return;
    }
    
    console.log('✓ Form found');
    
    // Get all text inputs and textareas
    const textFields = form.querySelectorAll('input[type="text"], textarea');
    const checkboxFields = form.querySelectorAll('input[type="checkbox"][required]');
    
    console.log('📝 Found', textFields.length, 'text fields');
    
    // Setup text field validation
    textFields.forEach(field => {
        const container = field.closest('.mb-3');
        if (!container) return;
        
        const minLength = field.getAttribute('minlength');
        const pattern = field.getAttribute('pattern');
        const required = field.hasAttribute('required');
        
        console.log('Setting up:', field.name, '| minlength:', minLength, '| pattern:', pattern ? 'yes' : 'no');
        
        // Create counter element
        let counter = null;
        if (minLength) {
            counter = document.createElement('div');
            counter.className = 'char-counter';
            const insertAfter = field.closest('.input-group') || field;
            insertAfter.parentNode.insertBefore(counter, insertAfter.nextSibling);
        }
        
        // Create feedback element
        const feedback = document.createElement('div');
        feedback.className = 'validation-feedback';
        const insertAfter = counter || field.closest('.input-group') || field;
        insertAfter.parentNode.insertBefore(feedback, insertAfter.nextSibling);
        
        // Validate function
        const validate = () => {
            const value = field.value.trim();
            const length = value.length;
            
            // Reset
            field.classList.remove('field-valid', 'field-invalid');
            feedback.className = 'validation-feedback';
            feedback.textContent = '';
            
            // Update counter
            if (counter && minLength) {
                const min = parseInt(minLength);
                const remaining = min - length;
                
                if (length === 0) {
                    if (required) {
                        counter.textContent = `0 / ${min} Zeichen (erforderlich)`;
                        counter.className = 'char-counter';
                    } else {
                        counter.textContent = `0 / ${min} Zeichen (optional)`;
                        counter.className = 'char-counter';
                    }
                } else if (length < min) {
                    counter.textContent = `${length} / ${min} Zeichen (noch ${remaining} benötigt)`;
                    counter.className = 'char-counter warning';
                } else {
                    counter.textContent = `✓ ${length} Zeichen`;
                    counter.className = 'char-counter success';
                }
            }
            
            // Validation logic - empty field
            if (length === 0) {
                if (required) {
                    feedback.className = 'validation-feedback invalid';
                    feedback.textContent = '⚠️ Erforderlich';
                    return false;
                } else {
                    // Optional field, empty is valid
                    feedback.className = 'validation-feedback';
                    feedback.textContent = '';
                    return true;
                }
            }
            
            // Field has content - now validate min_length and pattern
            if (minLength && length < parseInt(minLength)) {
                feedback.className = 'validation-feedback invalid';
                feedback.textContent = `⚠️ Mindestens ${minLength} Zeichen`;
                field.classList.add('field-invalid');
                return false;
            }
            
            if (pattern) {
                const regex = new RegExp(pattern);
                if (!regex.test(value)) {
                    feedback.className = 'validation-feedback invalid';
                    feedback.textContent = getErrorMessage(field.name);
                    field.classList.add('field-invalid');
                    return false;
                }
            }
            
            // Valid!
            field.classList.add('field-valid');
            feedback.className = 'validation-feedback valid';
            feedback.textContent = '✓ Gültig';
            return true;
        };
        
        // Attach events
        field.addEventListener('input', validate);
        field.addEventListener('keyup', validate);
        field.addEventListener('blur', validate);
        
        // Initial validation if has value
        if (field.value) validate();
    });
    
    // Setup checkbox validation
    checkboxFields.forEach(checkbox => {
        const container = checkbox.closest('.mb-4') || checkbox.parentElement;
        const feedback = document.createElement('div');
        feedback.className = 'validation-feedback';
        feedback.style.marginTop = '10px';
        container.appendChild(feedback);
        
        checkbox.addEventListener('change', () => {
            if (checkbox.checked) {
                feedback.className = 'validation-feedback valid';
                feedback.textContent = '✓ Bestätigt';
            } else {
                feedback.className = 'validation-feedback invalid';
                feedback.textContent = '⚠️ Bitte bestätigen';
            }
        });
    });
    
    // Form submit validation
    form.addEventListener('submit', (e) => {
        let isValid = true;
        
        textFields.forEach(field => {
            const value = field.value.trim();
            const minLength = field.getAttribute('minlength');
            const pattern = field.getAttribute('pattern');
            const required = field.hasAttribute('required');
            
            // Required field must have value
            if (required && !value) {
                isValid = false;
                field.classList.add('field-invalid');
                return;
            }
            
            // Optional field with no value is valid
            if (!required && !value) {
                return;
            }
            
            // Field has value - validate min_length and pattern
            if (minLength && value.length < parseInt(minLength)) {
                isValid = false;
                field.classList.add('field-invalid');
            } else if (pattern && value) {
                const regex = new RegExp(pattern);
                if (!regex.test(value)) {
                    isValid = false;
                    field.classList.add('field-invalid');
                }
            }
        });
        
        checkboxFields.forEach(checkbox => {
            if (!checkbox.checked) {
                isValid = false;
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Bitte korrigieren Sie die markierten Felder.');
            const firstInvalid = form.querySelector('.field-invalid');
            if (firstInvalid) {
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstInvalid.focus();
            }
        }
    });
    
    function getErrorMessage(fieldName) {
        const messages = {
            'email': '⚠️ Ungültige E-Mail-Adresse',
            'phone': '⚠️ Ungültige Telefonnummer',
            'iban': '⚠️ Ungültige IBAN',
            'bic': '⚠️ Ungültiger BIC',
            'total_cost': '⚠️ Ungültiger Betrag',
            'requested_amount': '⚠️ Ungültiger Betrag'
        };
        return messages[fieldName] || '⚠️ Ungültiges Format';
    }
    
    console.log('✓ Validation ready!');
})();
</script>

<?php include __DIR__ . '/../templates/footer.php'; ?>
