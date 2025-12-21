<?php
/**
 * Email Service for Andreas Pareigis Stiftung
 * Handles SMTP email sending for contact and request forms
 */

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/SMTPClient.php';
require_once __DIR__ . '/EmailTemplates.php';

class EmailService {
    private $smtpClient;
    private $config;
    
    public function __construct() {
        // Get email configuration from environment or config
        $this->config = [
            'host' => getenv('SMTP_HOST') ?: 'smtp.ionos.de',
            'port' => (int)(getenv('SMTP_PORT') ?: 587),
            'username' => getenv('SMTP_USERNAME') ?: '',
            'password' => getenv('SMTP_PASSWORD') ?: '',
            'from_email' => getenv('SMTP_FROM_EMAIL') ?: 'info@andreas-pareigis-stiftung.de',
            'from_name' => getenv('SMTP_FROM_NAME') ?: 'Andreas Pareigis Stiftung',
            'admin_email' => getenv('SMTP_FROM_EMAIL') ?: 'info@andreas-pareigis-stiftung.de'
        ];
        
        $this->smtpClient = new SMTPClient(
            $this->config['host'],
            $this->config['port'],
            $this->config['username'],
            $this->config['password']
        );
    }
    
    /**
     * Send contact form email to admin with copy to sender
     */
    public function sendContactForm($formData) {
        try {
            $subject = "Neue Kontaktanfrage von " . $formData['name'];
            $htmlBody = EmailTemplates::generateContactFormEmail($formData);
            
            // Send to admin with customer in CC
            $result = $this->smtpClient->send(
                $this->config['from_email'],
                $this->config['from_name'],
                $this->config['admin_email'],
                $subject,
                $htmlBody,
                $formData['email'], // Reply-To
                $formData['email'], // CC to customer
                true // isHtml
            );
            
            return ['success' => true, 'message' => 'Kontaktformular erfolgreich gesendet'];
        } catch (Exception $e) {
            error_log("Contact form email error: " . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    /**
     * Send project request form email to admin with copy to applicant
     */
    public function sendProjectRequest($formData, $pdfPath = null) {
        try {
            $subject = "Neuer Förderantrag: " . $formData['title'] . " von " . $formData['applicant'];
            $htmlBody = EmailTemplates::generateProjectRequestEmail($formData);
            
            $attachments = [];
            if ($pdfPath && file_exists($pdfPath)) {
                $attachments[] = [
                    'path' => $pdfPath,
                    'mime' => 'application/pdf'
                ];
            }
            
            // Send to admin with applicant in CC
            $result = $this->smtpClient->send(
                $this->config['from_email'],
                $this->config['from_name'],
                $this->config['admin_email'],
                $subject,
                $htmlBody,
                $formData['email'], // Reply-To
                $formData['email'], // CC to applicant
                true, // isHtml
                $attachments // PDF attachment
            );
            
            return ['success' => true, 'message' => 'Förderantrag erfolgreich eingereicht'];
        } catch (Exception $e) {
            error_log("Project request email error: " . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
?>
