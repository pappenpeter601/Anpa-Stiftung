<?php
/**
 * Email Templates for Andreas Pareigis Stiftung
 * Professional HTML email templates
 */

class EmailTemplates {
    
    /**
     * Get base64 encoded logo for email embedding
     */
    private static function getLogoBase64() {
        $logoPath = __DIR__ . '/../public/assets/img/logo-120.png';
        if (file_exists($logoPath)) {
            $imageData = file_get_contents($logoPath);
            return 'data:image/png;base64,' . base64_encode($imageData);
        }
        return '';
    }
    
    /**
     * Generate HTML email base structure
     */
    public static function getHtmlBase($title, $content) {
        $logoSrc = self::getLogoBase64();
        
        return '<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '</title>
    <style>
        @media only screen and (max-width: 600px) {
            .container { width: 100% !important; }
            .content { padding: 10px !important; }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f4; font-family: Arial, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4; padding: 20px 0;">
        <tr>
            <td align="center">
                <table class="container" width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #2563eb, #7c3aed); padding: 30px; text-align: center;">' 
                            . ($logoSrc ? '<img src="' . $logoSrc . '" alt="Andreas Pareigis Stiftung Logo" width="120" height="51" style="margin-bottom: 15px; display: block; margin-left: auto; margin-right: auto;">' : '') . 
                            '<h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: normal;">Andreas Pareigis Stiftung</h1>
                            <p style="margin: 10px 0 0 0; color: #f4f4f4; font-size: 16px;">Junge Leben stärken durch soziale Projekte</p>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td class="content" style="padding: 30px;">
                            ' . $content . '
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8f8f8; padding: 25px; text-align: center; border-top: 1px solid #e0e0e0;">
                            <p style="margin: 0 0 10px 0; font-size: 14px; color: #555;">
                                <strong>Andreas Pareigis Stiftung</strong>
                            </p>
                            <p style="margin: 0 0 10px 0; font-size: 13px; color: #666;">
                                Meinern 15a, 29614 Soltau
                            </p>
                            <p style="margin: 0; font-size: 12px; color: #888;">
                                Unterstützung von Kindern und Jugendlichen bis 18 Jahre
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>';
    }
    
    /**
     * Generate contact form email
     */
    public static function generateContactFormEmail($formData) {
        $content = '
            <h2 style="margin: 0 0 20px 0; color: #2563eb; font-size: 24px;">📧 Neue Kontaktanfrage</h2>
            
            <div style="background: #e3f2fd; border-radius: 6px; padding: 20px; margin: 20px 0;">
                <h3 style="margin: 0 0 15px 0; color: #1976d2; font-size: 18px;">Kontaktdaten</h3>
                <table style="width: 100%; font-size: 14px; color: #333;">
                    <tr><td style="padding: 5px 0; font-weight: bold; width: 120px;">Name:</td><td style="padding: 5px 0;">' . htmlspecialchars($formData['name'], ENT_QUOTES, 'UTF-8') . '</td></tr>
                    <tr><td style="padding: 5px 0; font-weight: bold;">E-Mail:</td><td style="padding: 5px 0;"><a href="mailto:' . htmlspecialchars($formData['email'], ENT_QUOTES, 'UTF-8') . '" style="color: #2563eb;">' . htmlspecialchars($formData['email'], ENT_QUOTES, 'UTF-8') . '</a></td></tr>';
        
        if (!empty($formData['phone'])) {
            $content .= '<tr><td style="padding: 5px 0; font-weight: bold;">Telefon:</td><td style="padding: 5px 0;"><a href="tel:' . htmlspecialchars($formData['phone'], ENT_QUOTES, 'UTF-8') . '" style="color: #2563eb;">' . htmlspecialchars($formData['phone'], ENT_QUOTES, 'UTF-8') . '</a></td></tr>';
        }
        
        if (!empty($formData['subject'])) {
            $content .= '<tr><td style="padding: 5px 0; font-weight: bold;">Betreff:</td><td style="padding: 5px 0;">' . htmlspecialchars($formData['subject'], ENT_QUOTES, 'UTF-8') . '</td></tr>';
        }
        
        $content .= '
                    <tr><td style="padding: 5px 0; font-weight: bold;">Datum:</td><td style="padding: 5px 0;">' . date('d.m.Y H:i') . ' Uhr</td></tr>
                </table>
            </div>
            
            <div style="background: #f8f9fa; border-radius: 6px; padding: 20px; margin: 20px 0;">
                <h3 style="margin: 0 0 15px 0; color: #2563eb; font-size: 18px;">💬 Nachricht</h3>
                <p style="margin: 0; color: #333; line-height: 1.6; white-space: pre-wrap;">' . htmlspecialchars($formData['message'], ENT_QUOTES, 'UTF-8') . '</p>
            </div>
            
            <div style="background: #fff3cd; border-radius: 6px; padding: 15px; margin: 20px 0; border-left: 4px solid #ffc107;">
                <p style="margin: 0; font-size: 14px; color: #856404;">
                    <strong>💡 Hinweis:</strong> Diese E-Mail wurde an Sie und den Absender gesendet. Sie können direkt auf diese E-Mail antworten, um dem Absender zu antworten.
                </p>
            </div>
            
            <p style="margin: 20px 0 0 0; color: #666; font-size: 13px;">
                Diese Nachricht wurde über das Kontaktformular auf anpa-stiftung.de gesendet.
            </p>';
        
        return self::getHtmlBase('Neue Kontaktanfrage', $content);
    }
    
    /**
     * Generate PDF-formatted project request (left-aligned, professional)
     */
    public static function generateProjectRequestPDF($formData) {
        $logoPath = __DIR__ . '/../public/assets/img/logo-120.png';
        $logoHtml = '';
        if (file_exists($logoPath)) {
            $imageData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/png;base64,' . base64_encode($imageData);
            $logoHtml = '<img src="' . $logoBase64 . '" alt="Andreas Pareigis Stiftung" width="120" height="51" style="margin-bottom: 20px;">';
        }
        
        $html = '<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 11pt; line-height: 1.6; color: #333; }
        h1 { color: #2563eb; font-size: 18pt; margin-bottom: 5px; border-bottom: 3px solid #2563eb; padding-bottom: 10px; }
        h2 { color: #2563eb; font-size: 14pt; margin-top: 25px; margin-bottom: 10px; background: #e3f2fd; padding: 8px 12px; border-left: 4px solid #2563eb; }
        h3 { color: #555; font-size: 11pt; margin-top: 15px; margin-bottom: 8px; font-weight: bold; }
        table.info { width: 100%; border-collapse: collapse; margin: 10px 0; }
        table.info td { padding: 5px 10px; vertical-align: top; }
        table.info td.label { font-weight: bold; width: 180px; color: #555; }
        .section { margin-bottom: 20px; }
        .budget-box { background: #e8f5e9; padding: 15px; border-left: 4px solid #2e7d32; margin: 15px 0; }
        .budget-box .amount { font-size: 14pt; font-weight: bold; color: #2e7d32; }
        .text-content { margin: 10px 0; padding: 10px; background: #f9f9f9; border-left: 3px solid #ddd; }
        .footer { margin-top: 40px; padding-top: 20px; border-top: 2px solid #ddd; font-size: 9pt; color: #666; }
    </style>
</head>
<body>
    ' . $logoHtml . '
    <h1>Förderantrag</h1>
    <p style="color: #666; margin-bottom: 25px;">Eingereicht am ' . date('d.m.Y \u\m H:i') . ' Uhr</p>
    
    <div class="section">
        <h2>Antragsteller</h2>
        <table class="info">
            <tr><td class="label">Name:</td><td>' . htmlspecialchars($formData['applicant'], ENT_QUOTES, 'UTF-8') . '</td></tr>
            <tr><td class="label">Organisation:</td><td>' . htmlspecialchars($formData['organization'], ENT_QUOTES, 'UTF-8') . '</td></tr>
            <tr><td class="label">E-Mail:</td><td>' . htmlspecialchars($formData['email'], ENT_QUOTES, 'UTF-8') . '</td></tr>';
        
        if (!empty($formData['phone'])) {
            $html .= '<tr><td class="label">Telefon:</td><td>' . htmlspecialchars($formData['phone'], ENT_QUOTES, 'UTF-8') . '</td></tr>';
        }
        if (!empty($formData['address'])) {
            $html .= '<tr><td class="label">Adresse:</td><td>' . nl2br(htmlspecialchars($formData['address'], ENT_QUOTES, 'UTF-8')) . '</td></tr>';
        }
        
        $html .= '</table>
    </div>
    
    <div class="section">
        <h2>Projektinformationen</h2>
        <table class="info">
            <tr><td class="label">Projekttitel:</td><td><strong>' . htmlspecialchars($formData['title'], ENT_QUOTES, 'UTF-8') . '</strong></td></tr>
            <tr><td class="label">Kategorie:</td><td>' . htmlspecialchars($formData['category'], ENT_QUOTES, 'UTF-8') . '</td></tr>
            <tr><td class="label">Zielgruppe:</td><td>' . htmlspecialchars($formData['age_group'], ENT_QUOTES, 'UTF-8') . '</td></tr>';
        
        if (!empty($formData['duration'])) {
            $html .= '<tr><td class="label">Projektdauer:</td><td>' . htmlspecialchars($formData['duration'], ENT_QUOTES, 'UTF-8') . '</td></tr>';
        }
        
        $html .= '</table>
        
        <h3>Projektbeschreibung</h3>
        <div class="text-content">' . nl2br(htmlspecialchars($formData['description'], ENT_QUOTES, 'UTF-8')) . '</div>
        
        <h3>Projektziele und erwartete Wirkung</h3>
        <div class="text-content">' . nl2br(htmlspecialchars($formData['goals'], ENT_QUOTES, 'UTF-8')) . '</div>
    </div>
    
    <div class="section">
        <h2>Budgetinformationen</h2>
        <div class="budget-box">
            <table class="info">
                <tr><td class="label">Gesamtbudget:</td><td class="amount">€ ' . number_format($formData['budget'], 2, ',', '.') . '</td></tr>
                <tr><td class="label">Beantragte Förderung:</td><td class="amount" style="color: #2563eb;">€ ' . number_format($formData['amount_requested'], 2, ',', '.') . '</td></tr>
            </table>
        </div>';
        
        if (!empty($formData['budget_breakdown'])) {
            $html .= '<h3>Budgetaufschlüsselung</h3>
            <div class="text-content">' . nl2br(htmlspecialchars($formData['budget_breakdown'], ENT_QUOTES, 'UTF-8')) . '</div>';
        }
        
        if (!empty($formData['other_funding'])) {
            $html .= '<h3>Andere Finanzierungsquellen</h3>
            <div class="text-content">' . nl2br(htmlspecialchars($formData['other_funding'], ENT_QUOTES, 'UTF-8')) . '</div>';
        }
        
        $html .= '</div>';
        
        // Additional information
        $hasAdditionalInfo = !empty($formData['experience']) || !empty($formData['community_need']) || !empty($formData['sustainability']);
        if ($hasAdditionalInfo) {
            $html .= '<div class="section"><h2>Zusätzliche Informationen</h2>';
            
            if (!empty($formData['experience'])) {
                $html .= '<h3>Bisherige Erfahrung der Organisation</h3>
                <div class="text-content">' . nl2br(htmlspecialchars($formData['experience'], ENT_QUOTES, 'UTF-8')) . '</div>';
            }
            
            if (!empty($formData['community_need'])) {
                $html .= '<h3>Bedarf in der Gemeinde / Erfolgskriterien</h3>
                <div class="text-content">' . nl2br(htmlspecialchars($formData['community_need'], ENT_QUOTES, 'UTF-8')) . '</div>';
            }
            
            if (!empty($formData['sustainability'])) {
                $html .= '<h3>Nachhaltigkeitsplan / Anmerkungen</h3>
                <div class="text-content">' . nl2br(htmlspecialchars($formData['sustainability'], ENT_QUOTES, 'UTF-8')) . '</div>';
            }
            
            $html .= '</div>';
        }
        
        // Bank details if available
        if (!empty($formData['iban'])) {
            $html .= '<div class="section">
                <h2>Bankverbindung</h2>
                <table class="info">
                    <tr><td class="label">IBAN:</td><td>' . htmlspecialchars($formData['iban'], ENT_QUOTES, 'UTF-8') . '</td></tr>';
            
            if (!empty($formData['bic'])) {
                $html .= '<tr><td class="label">BIC:</td><td>' . htmlspecialchars($formData['bic'], ENT_QUOTES, 'UTF-8') . '</td></tr>';
            }
            
            $html .= '</table></div>';
        }
        
        $html .= '
    <div class="footer">
        <p><strong>Andreas Pareigis Stiftung</strong><br>
        Meinern 15a, 29614 Soltau<br>
        Unterstützung von Kindern und Jugendlichen bis 18 Jahre</p>
    </div>
</body>
</html>';
        
        return $html;
    }
    
    /**
     * Generate project request email
     */
    public static function generateProjectRequestEmail($formData) {
        $content = '
            <h2 style="margin: 0 0 20px 0; color: #2563eb; font-size: 24px;">📋 Neuer Förderantrag</h2>
            
            <div style="background: #e3f2fd; border-radius: 6px; padding: 20px; margin: 20px 0;">
                <h3 style="margin: 0 0 15px 0; color: #1976d2; font-size: 18px;">Antragsteller</h3>
                <table style="width: 100%; font-size: 14px; color: #333;">
                    <tr><td style="padding: 5px 0; font-weight: bold; width: 160px;">Name:</td><td style="padding: 5px 0;">' . htmlspecialchars($formData['applicant'], ENT_QUOTES, 'UTF-8') . '</td></tr>
                    <tr><td style="padding: 5px 0; font-weight: bold;">Organisation:</td><td style="padding: 5px 0;">' . htmlspecialchars($formData['organization'], ENT_QUOTES, 'UTF-8') . '</td></tr>
                    <tr><td style="padding: 5px 0; font-weight: bold;">E-Mail:</td><td style="padding: 5px 0;"><a href="mailto:' . htmlspecialchars($formData['email'], ENT_QUOTES, 'UTF-8') . '" style="color: #2563eb;">' . htmlspecialchars($formData['email'], ENT_QUOTES, 'UTF-8') . '</a></td></tr>';
        
        if (!empty($formData['phone'])) {
            $content .= '<tr><td style="padding: 5px 0; font-weight: bold;">Telefon:</td><td style="padding: 5px 0;"><a href="tel:' . htmlspecialchars($formData['phone'], ENT_QUOTES, 'UTF-8') . '" style="color: #2563eb;">' . htmlspecialchars($formData['phone'], ENT_QUOTES, 'UTF-8') . '</a></td></tr>';
        }
        
        $content .= '
                    <tr><td style="padding: 5px 0; font-weight: bold;">Antragsdatum:</td><td style="padding: 5px 0;">' . date('d.m.Y H:i') . ' Uhr</td></tr>
                </table>
            </div>
            
            <div style="background: #f8f9fa; border-radius: 6px; padding: 20px; margin: 20px 0;">
                <h3 style="margin: 0 0 15px 0; color: #2563eb; font-size: 18px;">🎯 Projektdetails</h3>
                <table style="width: 100%; font-size: 14px; color: #333;">
                    <tr><td style="padding: 5px 0; font-weight: bold; width: 160px;">Projekttitel:</td><td style="padding: 5px 0; font-size: 16px; font-weight: bold; color: #2563eb;">' . htmlspecialchars($formData['title'], ENT_QUOTES, 'UTF-8') . '</td></tr>
                    <tr><td style="padding: 5px 0; font-weight: bold;">Kategorie:</td><td style="padding: 5px 0;">' . htmlspecialchars($formData['category'], ENT_QUOTES, 'UTF-8') . '</td></tr>
                    <tr><td style="padding: 5px 0; font-weight: bold;">Zielgruppe:</td><td style="padding: 5px 0;">' . htmlspecialchars($formData['age_group'], ENT_QUOTES, 'UTF-8') . '</td></tr>
                    <tr><td style="padding: 5px 0; font-weight: bold;">Begünstigte:</td><td style="padding: 5px 0;">' . htmlspecialchars($formData['beneficiaries'], ENT_QUOTES, 'UTF-8') . ' junge Menschen</td></tr>';
        
        if (!empty($formData['start_date'])) {
            $content .= '<tr><td style="padding: 5px 0; font-weight: bold;">Startdatum:</td><td style="padding: 5px 0;">' . date('d.m.Y', strtotime($formData['start_date'])) . '</td></tr>';
        }
        
        if (!empty($formData['duration'])) {
            $content .= '<tr><td style="padding: 5px 0; font-weight: bold;">Dauer:</td><td style="padding: 5px 0;">' . htmlspecialchars($formData['duration'], ENT_QUOTES, 'UTF-8') . '</td></tr>';
        }
        
        $content .= '
                </table>
            </div>
            
            <div style="background: #f8f9fa; border-radius: 6px; padding: 20px; margin: 20px 0;">
                <h3 style="margin: 0 0 15px 0; color: #2563eb; font-size: 18px;">📝 Projektbeschreibung</h3>
                <p style="margin: 0; color: #333; line-height: 1.6; white-space: pre-wrap;">' . htmlspecialchars($formData['description'], ENT_QUOTES, 'UTF-8') . '</p>
            </div>
            
            <div style="background: #f8f9fa; border-radius: 6px; padding: 20px; margin: 20px 0;">
                <h3 style="margin: 0 0 15px 0; color: #2563eb; font-size: 18px;">🎯 Ziele und erwartete Wirkung</h3>
                <p style="margin: 0; color: #333; line-height: 1.6; white-space: pre-wrap;">' . htmlspecialchars($formData['goals'], ENT_QUOTES, 'UTF-8') . '</p>
            </div>
            
            <div style="background: #e8f5e9; border-radius: 6px; padding: 20px; margin: 20px 0;">
                <h3 style="margin: 0 0 15px 0; color: #2e7d32; font-size: 18px;">💰 Budget</h3>
                <table style="width: 100%; font-size: 14px; color: #333;">
                    <tr><td style="padding: 5px 0; font-weight: bold; width: 200px;">Gesamtbudget:</td><td style="padding: 5px 0; font-size: 16px; font-weight: bold; color: #2e7d32;">€ ' . number_format($formData['budget'], 2, ',', '.') . '</td></tr>
                    <tr><td style="padding: 5px 0; font-weight: bold;">Beantragte Förderung:</td><td style="padding: 5px 0; font-size: 16px; font-weight: bold; color: #2563eb;">€ ' . number_format($formData['amount_requested'], 2, ',', '.') . '</td></tr>
                </table>';
        
        if (!empty($formData['budget_breakdown'])) {
            $content .= '
                <h4 style="margin: 15px 0 10px 0; color: #2e7d32; font-size: 14px;">Budgetaufschlüsselung:</h4>
                <p style="margin: 0; color: #333; line-height: 1.6; white-space: pre-wrap; font-size: 13px;">' . htmlspecialchars($formData['budget_breakdown'], ENT_QUOTES, 'UTF-8') . '</p>';
        }
        
        if (!empty($formData['other_funding'])) {
            $content .= '
                <h4 style="margin: 15px 0 10px 0; color: #2e7d32; font-size: 14px;">Andere Finanzierungsquellen:</h4>
                <p style="margin: 0; color: #333; line-height: 1.6; white-space: pre-wrap; font-size: 13px;">' . htmlspecialchars($formData['other_funding'], ENT_QUOTES, 'UTF-8') . '</p>';
        }
        
        $content .= '</div>';
        
        // Additional information sections
        if (!empty($formData['experience']) || !empty($formData['community_need']) || !empty($formData['sustainability'])) {
            $content .= '<div style="background: #f8f9fa; border-radius: 6px; padding: 20px; margin: 20px 0;">
                <h3 style="margin: 0 0 15px 0; color: #2563eb; font-size: 18px;">ℹ️ Zusätzliche Informationen</h3>';
            
            if (!empty($formData['experience'])) {
                $content .= '
                <h4 style="margin: 15px 0 10px 0; color: #666; font-size: 14px;">Bisherige Erfahrung:</h4>
                <p style="margin: 0 0 15px 0; color: #333; line-height: 1.6; white-space: pre-wrap; font-size: 13px;">' . htmlspecialchars($formData['experience'], ENT_QUOTES, 'UTF-8') . '</p>';
            }
            
            if (!empty($formData['community_need'])) {
                $content .= '
                <h4 style="margin: 15px 0 10px 0; color: #666; font-size: 14px;">Bedarf in der Gemeinde:</h4>
                <p style="margin: 0 0 15px 0; color: #333; line-height: 1.6; white-space: pre-wrap; font-size: 13px;">' . htmlspecialchars($formData['community_need'], ENT_QUOTES, 'UTF-8') . '</p>';
            }
            
            if (!empty($formData['sustainability'])) {
                $content .= '
                <h4 style="margin: 15px 0 10px 0; color: #666; font-size: 14px;">Nachhaltigkeitsplan:</h4>
                <p style="margin: 0; color: #333; line-height: 1.6; white-space: pre-wrap; font-size: 13px;">' . htmlspecialchars($formData['sustainability'], ENT_QUOTES, 'UTF-8') . '</p>';
            }
            
            $content .= '</div>';
        }
        
        $content .= '
            <div style="background: #fff3cd; border-radius: 6px; padding: 15px; margin: 20px 0; border-left: 4px solid #ffc107;">
                <p style="margin: 0; font-size: 14px; color: #856404;">
                    <strong>💡 Hinweis:</strong> Dieser Antrag wurde an Sie und den Antragsteller gesendet. Sie können direkt auf diese E-Mail antworten, um mit dem Antragsteller zu kommunizieren.
                </p>
            </div>
            
            <p style="margin: 20px 0 0 0; color: #666; font-size: 13px;">
                Dieser Förderantrag wurde über das Online-Formular auf anpa-stiftung.de eingereicht.
            </p>';
        
        return self::getHtmlBase('Neuer Förderantrag', $content);
    }
}
?>
