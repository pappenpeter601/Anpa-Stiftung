<?php
/** @var array $questionnaire Questionnaire supplied by public/request_pdf.php. */
$escape = static function ($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
};
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <style>
    body { font-family: dejavusans; font-size: 10pt; color: #222; }
    h1 { font-size: 20pt; margin-bottom: 2mm; }
    h2 { font-size: 12pt; margin-top: 6mm; margin-bottom: 3mm; }
    p { margin: 0 0 3mm; }
    ul { margin-top: 1mm; }
    .field { width: 100%; border-collapse: collapse; margin-bottom: 4mm; }
    .field td { padding: 0; }
    .choices { border-collapse: collapse; }
    .choices td { padding: 1mm 0; vertical-align: middle; }
    .choices .control { width: 6mm; }
    .choices .option { width: 20mm; }
    .label { margin-bottom: 2mm; font-weight: bold; }
    .hint { font-size: 9pt; }
    input, textarea { font-family: dejavusans; font-size: 11pt; color: #000; background-color: #fff; border: 1px solid #555; }
    textarea { width: 170mm; overflow: hidden; }
    .declaration { page-break-before: always; }
  </style>
</head>
<body>
  <h1>Förderantrag</h1>
  <p><?= $escape(SITE_NAME) ?></p>
  <p class="hint">
    Bitte im PDF-Viewer ausfüllen und speichern oder ausdrucken und handschriftlich ausfüllen.
    Bei Platzbedarf bitte zusätzliche, mit Feldname und Antragsteller beschriftete Blätter beifügen.
    Mit * gekennzeichnete Felder sind Pflichtfelder.
  </p>
  <p class="hint">Den ausgefüllten Antrag bitte an <?= $escape(ADMIN_EMAIL) ?> senden. Dieses PDF wird nicht automatisch eingereicht.</p>

  <?php if (isset($questionnaire['criteria'])): ?>
    <h2><?= $escape($questionnaire['criteria']['title']) ?></h2>
    <p><?= $escape($questionnaire['criteria']['description']) ?></p>
    <ul>
      <?php foreach ($questionnaire['criteria']['items'] as $item): ?>
        <li><?= $escape($item) ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <?php foreach ($questionnaire['sections'] as $section): ?>
    <h2><?= (int) $section['order'] ?>. <?= $escape($section['title']) ?></h2>
    <?php foreach ($section['questions'] as $question): ?>
      <?php
      $name = $escape($question['id']);
      $label = $escape($question['label']);
      $required = !empty($question['required']);
      ?>
      <!-- Single-row tables keep labels and active PDF fields on the same page. -->
      <table class="field"><tr><td>
        <p class="label"><?= $label ?><?= $required ? ' *' : '' ?><?= isset($question['prefix']) ? ' (' . $escape($question['prefix']) . ')' : '' ?></p>
        <?php if ($question['type'] === 'radio'): ?>
          <table class="choices"><tr>
            <?php foreach ($question['options'] as $option): ?>
              <td class="control"><input type="radio" name="<?= $name ?>" value="<?= $escape($option['value']) ?>" title="<?= $label ?>" <?= $required ? 'required' : '' ?>></td>
              <td class="option"><?= $escape($option['label']) ?></td>
            <?php endforeach; ?>
          </tr></table>
        <?php else: ?>
          <?php $height = $question['type'] === 'textarea' ? max(24, (int) ($question['rows'] ?? 3) * 10) + 3 : 15; ?>
          <?php // mPDF only creates textarea widgets when the element contains text. ?>
          <textarea name="<?= $name ?>" title="<?= $label ?>" style="height: <?= $height ?>mm;" <?= $required ? 'required' : '' ?>>&#32;</textarea>
        <?php endif; ?>
      </td></tr></table>
    <?php endforeach; ?>
  <?php endforeach; ?>

  <?php if (isset($questionnaire['declaration'])): ?>
    <div class="declaration">
      <h2><?= $escape($questionnaire['declaration']['title']) ?></h2>
      <?php foreach ($questionnaire['declaration']['statements'] as $index => $statement): ?>
        <p><?= $index + 1 ?>. <?= $escape($statement) ?></p>
      <?php endforeach; ?>
      <?php $agreement = $questionnaire['declaration']['agreement']; ?>
      <p>
        <input type="checkbox" name="<?= $escape($agreement['id']) ?>" value="Ja" title="Einverständniserklärung" <?= !empty($agreement['required']) ? 'required' : '' ?>>
        <?= $escape($agreement['label']) ?><?= !empty($agreement['required']) ? ' *' : '' ?>
      </p>
      <p class="hint">Satzung, Allgemeine Geschäftsbedingungen und Datenschutzerklärung finden Sie auf unserer Website.</p>
      <table class="field"><tr><td>
        <p class="label">Ort, Datum</p>
        <textarea name="place_date" title="Ort, Datum" style="height: 15mm;">&#32;</textarea>
      </td></tr></table>
      <table class="field"><tr><td>
        <p class="label">Name / Unterschrift der antragstellenden Person</p>
        <textarea name="signature" title="Name / Unterschrift" style="height: 18mm;">&#32;</textarea>
      </td></tr></table>
    </div>
  <?php endif; ?>
</body>
</html>
