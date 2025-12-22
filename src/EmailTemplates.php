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
     * Uses questionnaire.json structure to ensure consistency with form
     */
    public static function generateProjectRequestPDF($formData) {
        // Load questionnaire structure
        $questionnairePath = __DIR__ . '/../data/questionnaire.json';
        $questionnaire = null;
        if (file_exists($questionnairePath)) {
            $json = file_get_contents($questionnairePath);
            $questionnaire = json_decode($json, true);
        }
        
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
        table.info td.label { font-weight: bold; width: 200px; color: #555; }
        .section { margin-bottom: 20px; }
        .text-content { margin: 10px 0; padding: 10px; background: #f9f9f9; border-left: 3px solid #ddd; }
        .footer { margin-top: 40px; padding-top: 20px; border-top: 2px solid #ddd; font-size: 9pt; color: #666; }
        .declaration { background: #f8f9fa; padding: 15px; margin: 20px 0; border: 1px solid #ddd; }
        .declaration-item { margin: 8px 0; font-size: 10pt; }
    </style>
</head>
<body>
    ' . $logoHtml . '
    <h1>Förderantrag</h1>
    <p style="color: #666; margin-bottom: 25px;">Eingereicht am ' . date('d.m.Y \u\m H:i') . ' Uhr</p>';
        
        // Generate sections from questionnaire if available
        if ($questionnaire && isset($questionnaire['sections'])) {
            foreach ($questionnaire['sections'] as $section) {
                $html .= '<div class="section"><h2>' . $section['order'] . '. ' . htmlspecialchars($section['title'], ENT_QUOTES, 'UTF-8') . '</h2>';
                
                $hasContent = false;
                $sectionContent = '<table class="info">';
                
                foreach ($section['questions'] as $question) {
                    $questionId = $question['id'];
                    $questionLabel = $question['label'];
                    $value = isset($formData[$questionId]) ? $formData[$questionId] : null;
                    
                    // Check if field has data - handle different types properly
                    $hasValue = false;
                    if ($value !== null && $value !== '') {
                        $hasValue = true;
                    } elseif (is_numeric($value) && $value == 0) {
                        $hasValue = true; // 0 is a valid value
                    }
                    
                    // Only show fields with actual data (skip truly empty values)
                    if ($hasValue) {
                        $hasContent = true;
                        
                        // Format value based on field properties
                        if ($question['type'] === 'textarea') {
                            // For textarea, show as text content block
                            $sectionContent .= '</table>';
                            $sectionContent .= '<h3>' . htmlspecialchars($questionLabel, ENT_QUOTES, 'UTF-8') . '</h3>';
                            $sectionContent .= '<div class="text-content">' . nl2br(htmlspecialchars($value, ENT_QUOTES, 'UTF-8')) . '</div>';
                            $sectionContent .= '<table class="info">';
                            continue;
                        } elseif (isset($question['input_type']) && $question['input_type'] === 'numeric' && isset($question['prefix'])) {
                            // Format numeric fields with prefix (e.g., currency)
                            $numericValue = str_replace(',', '.', $value);
                            $formattedValue = $question['prefix'] . ' ' . number_format((float)$numericValue, 2, ',', '.');
                        } else {
                            $formattedValue = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
                            if (strpos($value, "\n") !== false) {
                                $formattedValue = nl2br($formattedValue);
                            }
                        }
                        
                        $sectionContent .= '<tr><td class="label">' . htmlspecialchars($questionLabel, ENT_QUOTES, 'UTF-8') . ':</td><td>' . $formattedValue . '</td></tr>';
                    }
                }
                
                $sectionContent .= '</table>';
                
                // Only output section if it has content
                if ($hasContent) {
                    $html .= $sectionContent;
                }
                
                $html .= '</div>';
            }
            
            // Add declaration section if present
            if (isset($questionnaire['declaration'])) {
                $html .= '<div class="section"><h2>' . htmlspecialchars($questionnaire['declaration']['title'], ENT_QUOTES, 'UTF-8') . '</h2>';
                $html .= '<div class="declaration">';
                
                foreach ($questionnaire['declaration']['statements'] as $index => $statement) {
                    $romanNumeral = ['I', 'II', 'III', 'IV', 'V', 'VI'][$index];
                    $html .= '<div class="declaration-item"><strong>' . $romanNumeral . '.</strong> ' . htmlspecialchars($statement, ENT_QUOTES, 'UTF-8') . '</div>';
                }
                
                $html .= '</div>';
                
                if (isset($questionnaire['declaration']['agreement'])) {
                    $html .= '<p style="margin-top: 15px; font-size: 10pt; font-style: italic;">Der Antragsteller hat bestätigt: ' . htmlspecialchars($questionnaire['declaration']['agreement']['label'], ENT_QUOTES, 'UTF-8') . '</p>';
                }
                
                $html .= '</div>';
            }
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
            </div>';
        
        // Organization Information Section
        if (!empty($formData['org_since']) || !empty($formData['legal_form']) || !empty($formData['previous_application'])) {
            $content .= '
            <div style="background: #f8f9fa; border-radius: 6px; padding: 20px; margin: 20px 0;">
                <h3 style="margin: 0 0 15px 0; color: #2563eb; font-size: 18px;">🏢 Organisation</h3>
                <table style="width: 100%; font-size: 14px; color: #333;">';
            
            if (!empty($formData['org_since'])) {
                $content .= '<tr><td style="padding: 5px 0; font-weight: bold; width: 160px;">Seit wann:</td><td style="padding: 5px 0;">' . htmlspecialchars($formData['org_since'], ENT_QUOTES, 'UTF-8') . '</td></tr>';
            }
            
            if (!empty($formData['legal_form'])) {
                $content .= '<tr><td style="padding: 5px 0; font-weight: bold;">Rechtsform:</td><td style="padding: 5px 0;">' . htmlspecialchars($formData['legal_form'], ENT_QUOTES, 'UTF-8') . '</td></tr>';
            }
            
            if (!empty($formData['previous_application'])) {
                $content .= '<tr><td style="padding: 5px 0; font-weight: bold;">Frühere Anträge:</td><td style="padding: 5px 0;">' . htmlspecialchars($formData['previous_application'], ENT_QUOTES, 'UTF-8');
                if (!empty($formData['previous_project'])) {
                    $content .= ' (' . htmlspecialchars($formData['previous_project'], ENT_QUOTES, 'UTF-8') . ')';
                }
                $content .= '</td></tr>';
            }
            
            $content .= '
                </table>
            </div>';
        }
        
        $content .= '
            <div style="background: #f8f9fa; border-radius: 6px; padding: 20px; margin: 20px 0;">
                <h3 style="margin: 0 0 15px 0; color: #2563eb; font-size: 18px;">🎯 Projektdetails</h3>
                <table style="width: 100%; font-size: 14px; color: #333;">
                    <tr><td style="padding: 5px 0; font-weight: bold; width: 160px;">Projekttitel:</td><td style="padding: 5px 0; font-size: 16px; font-weight: bold; color: #2563eb;">' . htmlspecialchars($formData['project_name'] ?? '', ENT_QUOTES, 'UTF-8') . '</td></tr>
                    <tr><td style="padding: 5px 0; font-weight: bold;">Zielgruppe:</td><td style="padding: 5px 0;">' . nl2br(htmlspecialchars($formData['target_group'] ?? '', ENT_QUOTES, 'UTF-8')) . '</td></tr>';
        
        if (!empty($formData['timeline'])) {
            $content .= '<tr><td style="padding: 5px 0; font-weight: bold;">Zeitplanung:</td><td style="padding: 5px 0;">' . nl2br(htmlspecialchars($formData['timeline'], ENT_QUOTES, 'UTF-8')) . '</td></tr>';
        }
        
        $content .= '
                </table>
            </div>
            
            <div style="background: #f8f9fa; border-radius: 6px; padding: 20px; margin: 20px 0;">
                <h3 style="margin: 0 0 15px 0; color: #2563eb; font-size: 18px;">📝 Projektbeschreibung</h3>
                <p style="margin: 0; color: #333; line-height: 1.6; white-space: pre-wrap;">' . nl2br(htmlspecialchars($formData['project_description'] ?? '', ENT_QUOTES, 'UTF-8')) . '</p>
            </div>
            
            <div style="background: #f8f9fa; border-radius: 6px; padding: 20px; margin: 20px 0;">
                <h3 style="margin: 0 0 15px 0; color: #2563eb; font-size: 18px;">🎯 Ziel und Zweck des Projekts</h3>
                <p style="margin: 0; color: #333; line-height: 1.6; white-space: pre-wrap;">' . nl2br(htmlspecialchars($formData['project_goal'] ?? '', ENT_QUOTES, 'UTF-8')) . '</p>
            </div>
            
            <div style="background: #e8f5e9; border-radius: 6px; padding: 20px; margin: 20px 0;">
                <h3 style="margin: 0 0 15px 0; color: #2e7d32; font-size: 18px;">💰 Budget</h3>
                <table style="width: 100%; font-size: 14px; color: #333;">
                    <tr><td style="padding: 5px 0; font-weight: bold; width: 200px;">Gesamtkosten:</td><td style="padding: 5px 0; font-size: 16px; font-weight: bold; color: #2e7d32;">€ ' . number_format($formData['total_cost_numeric'] ?? 0, 2, ',', '.') . '</td></tr>
                    <tr><td style="padding: 5px 0; font-weight: bold;">Beantragte Förderung:</td><td style="padding: 5px 0; font-size: 16px; font-weight: bold; color: #2563eb;">€ ' . number_format($formData['requested_amount_numeric'] ?? 0, 2, ',', '.') . '</td></tr>
                </table>';
        
        if (!empty($formData['cost_details'])) {
            $content .= '
                <h4 style="margin: 15px 0 10px 0; color: #2e7d32; font-size: 14px;">Angaben zu den Kosten:</h4>
                <p style="margin: 0; color: #333; line-height: 1.6; white-space: pre-wrap; font-size: 13px;">' . nl2br(htmlspecialchars($formData['cost_details'], ENT_QUOTES, 'UTF-8')) . '</p>';
        }
        
        if (!empty($formData['other_funding'])) {
            $content .= '
                <h4 style="margin: 15px 0 10px 0; color: #2e7d32; font-size: 14px;">Andere Finanzierungsquellen:</h4>
                <p style="margin: 0; color: #333; line-height: 1.6; white-space: pre-wrap; font-size: 13px;">' . nl2br(htmlspecialchars($formData['other_funding'], ENT_QUOTES, 'UTF-8')) . '</p>';
        }
        
        $content .= '</div>';
        
        // Additional information section
        if (!empty($formData['org_purpose']) || !empty($formData['success_criteria']) || !empty($formData['remarks'])) {
            $content .= '<div style="background: #f8f9fa; border-radius: 6px; padding: 20px; margin: 20px 0;">
                <h3 style="margin: 0 0 15px 0; color: #2563eb; font-size: 18px;">ℹ️ Zusätzliche Informationen</h3>';
            
            if (!empty($formData['org_purpose'])) {
                $content .= '
                <h4 style="margin: 15px 0 10px 0; color: #666; font-size: 14px;">Zwecke der Organisation:</h4>
                <p style="margin: 0 0 15px 0; color: #333; line-height: 1.6; white-space: pre-wrap; font-size: 13px;">' . nl2br(htmlspecialchars($formData['org_purpose'], ENT_QUOTES, 'UTF-8')) . '</p>';
            }
            
            if (!empty($formData['success_criteria'])) {
                $content .= '
                <h4 style="margin: 15px 0 10px 0; color: #666; font-size: 14px;">Das Projekt ist erfolgreich, wenn:</h4>
                <p style="margin: 0 0 15px 0; color: #333; line-height: 1.6; white-space: pre-wrap; font-size: 13px;">' . nl2br(htmlspecialchars($formData['success_criteria'], ENT_QUOTES, 'UTF-8')) . '</p>';
            }
            
            if (!empty($formData['remarks'])) {
                $content .= '
                <h4 style="margin: 15px 0 10px 0; color: #666; font-size: 14px;">Bemerkungen:</h4>
                <p style="margin: 0; color: #333; line-height: 1.6; white-space: pre-wrap; font-size: 13px;">' . nl2br(htmlspecialchars($formData['remarks'], ENT_QUOTES, 'UTF-8')) . '</p>';
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
