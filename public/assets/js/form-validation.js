/**
 * Real-time Form Validation
 * Provides interactive validation feedback as users fill out the form
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('Form validation script loaded');
    
    const form = document.querySelector('form[action="request_submit.php"]');
    if (!form) {
        console.log('Form not found');
        return;
    }
    
    console.log('Form found, initializing validation');

    // Add validation styling
    const style = document.createElement('style');
    style.textContent = `
        .field-valid { border-color: #28a745 !important; background-color: #f0fdf4; }
        .field-invalid { border-color: #dc3545 !important; background-color: #fef2f2; }
        .validation-feedback {
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .validation-feedback.valid { color: #28a745; }
        .validation-feedback.invalid { color: #dc3545; }
        .validation-feedback.info { color: #6c757d; }
        .char-counter { font-size: 0.8rem; color: #6c757d; margin-top: 0.25rem; }
        .char-counter.warning { color: #ffc107; }
        .char-counter.success { color: #28a745; }
    `;
    document.head.appendChild(style);

    // Get all form inputs and textareas
    const fields = form.querySelectorAll('input[type="text"], textarea, input[type="radio"], input[type="checkbox"]');
    console.log('Found ' + fields.length + ' fields to validate');
    
    fields.forEach(field => {
        const isRadio = field.type === 'radio';
        const isCheckbox = field.type === 'checkbox';
        console.log('Setting up validation for field: ' + field.name + ' (type: ' + field.type + ')');
        
        if (isRadio) {
            // For radio buttons, validate on change
            field.addEventListener('change', function() {
                validateRadioGroup(field);
            });
        } else if (isCheckbox) {
            // For checkboxes, validate on change
            field.addEventListener('change', function() {
                validateCheckbox(field);
            });
        } else {
            // Add real-time validation for text and textarea
            const container = field.closest('.mb-3');
            if (!container) return;

            // Get validation rules from HTML attributes
            const minLength = field.getAttribute('minlength');
            const pattern = field.getAttribute('pattern');
            const required = field.hasAttribute('required');

            // Add character counter for fields with minlength
            if (minLength) {
                const counter = document.createElement('div');
                counter.className = 'char-counter';
                counter.innerHTML = `<small>Mindestens ${minLength} Zeichen erforderlich</small>`;
                
                // Insert after the input/textarea, or after input-group if it exists
                const insertAfter = field.closest('.input-group') || field;
                insertAfter.parentNode.insertBefore(counter, insertAfter.nextSibling);
                field.dataset.counter = 'true';
            }

            // Add feedback container
            const feedback = document.createElement('div');
            feedback.className = 'validation-feedback';
            
            // Find the right place to insert feedback
            const insertAfter = container.querySelector('.char-counter') || field.closest('.input-group') || field;
            insertAfter.parentNode.insertBefore(feedback, insertAfter.nextSibling);
 (real-time as user types)
            field.addEventListener('input', function() {
                console.log('Input event on ' + field.name + ', value length: ' + field.value.length);
                validateField(field, feedback, minLength, pattern, required, false);
            });

            // Validate on blur (show all errors when leaving field)
            field.addEventListener('blur', function() {
                console.log('Blur event on ' + field.name);
                validateField(field, feedback, minLength, pattern, required, true);
            });
            
            // Also validate on keyup for immediate feedback
            field.addEventListener('keyup', function() {
                validateField(field, feedback, minLength, pattern, required, false);   validateField(field, feedback, minLength, pattern, required, true);
                }
            });
        }
    });

    // Validate form on submit
    form.addEventListener('submit', function(e) {
        let hasErrors = false;
        
        fields.forEif (field.type === 'checkbox') {
                if (!validateCheckbox(field, true)) {
                    hasErrors = true;
                }
            } else ach(field => {
            if (field.type === 'radio') {
                if (!validateRadioGroup(field, true)) {
                    hasErrors = true;
                }
            } else {
                const container = field.closest('.mb-3');
                if (!container) return;
                
                const feedback = container.querySelector('.validation-feedback');
                const minLength = field.getAttribute('minlength');
                const pattern = field.getAttribute('pattern');
                const required = field.hasAttribute('required');
                
                if (!validateField(field, feedback, minLength, pattern, required, true)) {
                    hasErrors = true;
                }
            }
        });

        if (hasErrors) {
            e.preventDefault();
            
            // Scroll to first error
            const firstError = form.querySelector('.field-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }

            // Show alert
            showAlert('Bitte korrigieren Sie die markierten Felder.', 'danger');
        }
    });

    /**
     * Validate a single field
     */
    function validateField(field, feedback, minLength, pattern, required, showAllErrors = false) {
        const value = field.value.trim();
        const container = field.closest('.mb-3');
        const counter = container?.querySelector('.char-counter');
        
        // Reset state (always show, even when typing)
        if (counter && minLength) {
            const currentLength = value.length;
            const minLengthNum = parseInt(minLength);
            const remaining = minLengthNum - currentLength;
            
            if (currentLength === 0) {
                counter.innerHTML = `<small>0 / ${minLength} Zeichen (mindestens ${minLength} erforderlich)</small>`;
                counter.className = 'char-counter';
            } else if (currentLength < minLengthNum) {
                counter.innerHTML = `<small>${currentLength} / ${minLength} Zeichen (noch ${remaining} erforderlich
            if (currentLength === 0) {
                counter.innerHTML = `<small>Mindestens ${minLength} Zeichen erforderlich</small>`;
                counter.className = 'char-counter';
            } else if (currentLength < minLengthNum) {
                counter.innerHTML = `<small>Noch ${remaining} Zeichen erforderlich (${currentLength}/${minLength})</small>`;
                counter.className = 'char-counter warning';
            } else {
                counter.innerHTML = `<small>✓ ${currentLength} Zeichen (mindestens ${minLength} erforderlich)</small>`;
                counter.className = 'char-counter success';
            }
        }

        // Empty field validation
        if (value.length === 0) {
            if (required && showAllErrors) {
                field.classList.add('field-invalid');
                feedback.className = 'validation-feedback invalid';
                feedback.innerHTML = '⚠️ Dieses Feld ist erforderlich';
                return false;
            }
            return !required;
        }

        // Minimum length validation
        if (minLength && value.length < parseInt(minLength)) {
            if (showAllErrors) {
                field.classList.add('field-invalid');
                feedback.className = 'validation-feedback invalid';
                feedback.innerHTML = `⚠️ Mindestens ${minLength} Zeichen erforderlich`;
            }
            return false;
        }

        // Pattern validation
        if (pattern && value.length > 0) {
            const regex = new RegExp(pattern);
            if (!regex.test(value)) {
                field.classList.add('field-invalid');
                feedback.className = 'validation-feedback invalid';
                feedback.innerHTML = '⚠️ ' + getPatternErrorMessage(field);
                return false;
            }
        }

        // Valid! (only show green check if there's actual content)
        if (value.length > 0) {
            field.classList.add('field-valid');
            feedback.className = 'validation-feedback valid';
            feedback.innerHTML = '✓ Gültig';
        }
        return true;
    }

    /**
     * Validate radio button group
     */
    function validateRadioGroup(radio, showError = false) {
        const name = radio.name;
        const group = form.querySelectorAll(`input[name="${name}"]`);
        const container = radio.closest('.mb-3');
        
        if (!container) return true;

        // Check if any radio is selected
        const isSelected = Array.from(group).some(r => r.checked);
        
        // Remove existing feedback
        let feedback = container.querySelector('.validation-feedback');
        if (!feedback) {
            feedback = document.createElement('div');
            feedback.className = 'validation-feedback';
            group[group.length - 1].closest('.form-check').parentNode.appendChild(feedback);
        }

        if (!isSelected && showError) {
            feedback.className = 'validation-feedback invalid';
            feedback.innerHTML = '⚠️ Bitte wählen Sie eine Option';
            return false;
        } else if (isSelected) {
            feedback.className = 'validation-feedback valid';
            feedback.innerHTML = '✓ Ausgewählt';
            return true;
        }

        feedback.innerHTML = '';
        return true;
    }

    /**
     * Validate checkbox (for agreement checkbox)
     */
    function validateCheckbox(checkbox, showError = false) {
        const container = checkbox.closest('.mb-4') || checkbox.closest('.form-check');
        if (!container) return true;

        const required = checkbox.hasAttribute('required');
        const isChecked = checkbox.checked;

        // Remove existing feedback
        let feedback = container.querySelector('.validation-feedback');
        if (!feedback) {
            feedback = document.createElement('div');
            feedback.className = 'validation-feedback';
            feedback.style.marginTop = '10px';
            container.appendChild(feedback);
        }

        if (required && !isChecked && showError) {
            feedback.className = 'validation-feedback invalid';
            feedback.innerHTML = '⚠️ Sie müssen diese Bestätigung akzeptieren';
            return false;
        } else if (isChecked) {
            feedback.className = 'validation-feedback valid';
            feedback.innerHTML = '✓ Bestätigt';
            return true;
        }

        feedback.innerHTML = '';
        return true;
    }

    /**
     * Get user-friendly error message for pattern validation
     */
    function getPatternErrorMessage(field) {
        const name = field.name;
        
        switch(name) {
            case 'email':
                return 'Bitte geben Sie eine gültige E-Mail-Adresse ein';
            case 'phone':
                return 'Bitte geben Sie eine gültige Telefonnummer ein';
            case 'iban':
                return 'Bitte geben Sie eine gültige IBAN ein (z.B. DE89 3704 0044 0532 0130 00)';
            case 'bic':
                return 'Bitte geben Sie einen gültigen BIC/SWIFT-Code ein';
            case 'total_cost':
            case 'requested_amount':
                return 'Bitte geben Sie einen gültigen Betrag ein (z.B. 5000 oder 5000,00)';
            default:
                return 'Ungültiges Format';
        }
    }

    /**
     * Show alert message
     */
    function showAlert(message, type = 'info') {
        const existingAlert = form.querySelector('.validation-alert');
        if (existingAlert) {
            existingAlert.remove();
        }

        const alert = document.createElement('div');
        alert.className = `alert alert-${type} validation-alert`;
        alert.style.marginBottom = '20px';
        alert.innerHTML = `
            <strong>${type === 'danger' ? 'Fehler!' : 'Hinweis:'}</strong> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        form.insertBefore(alert, form.firstChild);

        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            alert.remove();
        }, 5000);
    }
});
