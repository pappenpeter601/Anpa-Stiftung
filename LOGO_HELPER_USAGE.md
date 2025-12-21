# Logo Helper - Verwendungsbeispiele

## Einfacher Wechsel zwischen Standard und Rainbow Logo

### 1. Aktivierung des Rainbow-Logos

Bearbeite `/src/LogoHelper.php` und ändere:

```php
// Standard-Logo verwenden
define('USE_RAINBOW_LOGO', false);

// Rainbow-Logo verwenden
define('USE_RAINBOW_LOGO', true);
```

### 2. Verwendung in Templates

#### Aktueller Code (manuell):
```php
<img src="<?php echo BASE_URL; ?>assets/img/logo-120.png" alt="Logo" width="60" height="32">
```

#### Neuer Code (automatisch mit Helper):
```php
<?php require_once __DIR__ . '/../src/LogoHelper.php'; ?>
<?php echo getLogoTag('120', 60, 32); ?>
```

### 3. Verschiedene Logo-Größen verwenden

```php
<?php require_once __DIR__ . '/../src/LogoHelper.php'; ?>

<!-- Kleines Logo (64px) -->
<?php echo getLogoTag('64', 32, 17); ?>

<!-- Standard Header (120px) -->
<?php echo getLogoTag('120', 60, 32); ?>

<!-- Footer (120px, größer angezeigt) -->
<?php echo getLogoTag('120', 64, 34); ?>

<!-- Große Version (400px) -->
<?php echo getLogoTag('400', 200, 107); ?>

<!-- SVG Version (skalierbar) -->
<?php echo getLogoTag('svg', 120, 64); ?>
```

### 4. Nur Logo-URL abrufen

```php
<?php require_once __DIR__ . '/../src/LogoHelper.php'; ?>

<!-- Für CSS Background -->
<div style="background-image: url('<?php echo getLogoUrl('200'); ?>');">

<!-- Für JavaScript -->
<script>
const logoUrl = '<?php echo getLogoUrl('120'); ?>';
</script>
```

### 5. Logo-Dateiname abrufen (ohne URL)

```php
<?php require_once __DIR__ . '/../src/LogoHelper.php'; ?>

<?php 
$logoFile = getLogo('120'); 
// Gibt zurück: "logo-120.png" oder "logo-rainbow-120.png"
?>
```

## Beispiel: Header aktualisieren

### Vorher (templates/header.php):
```php
<a class="navbar-brand d-flex align-items-center gap-2" href="<?php echo BASE_URL; ?>">
  <img src="<?php echo BASE_URL; ?>assets/img/logo-120.png" alt="Andreas Pareigis Stiftung Logo" width="60" height="32">
  <span class="brand-text"><?php echo SITE_NAME; ?></span>
</a>
```

### Nachher (mit LogoHelper):
```php
<?php require_once __DIR__ . '/../src/LogoHelper.php'; ?>
<a class="navbar-brand d-flex align-items-center gap-2" href="<?php echo BASE_URL; ?>">
  <?php echo getLogoTag('120', 60, 32); ?>
  <span class="brand-text"><?php echo SITE_NAME; ?></span>
</a>
```

## Beispiel: Email-Template aktualisieren

### In src/EmailTemplates.php:
```php
// Am Anfang der Datei
require_once __DIR__ . '/LogoHelper.php';

// Im HTML-Template
<td style="background: linear-gradient(135deg, #2563eb, #7c3aed); padding: 30px; text-align: center;">
    <img src="<?php echo getLogoUrl('120'); ?>" alt="Andreas Pareigis Stiftung Logo" width="120" height="64" style="margin-bottom: 15px;">
    <h1>Andreas Pareigis Stiftung</h1>
</td>
```

## Vorteile des LogoHelper

✅ **Zentrale Steuerung**: Ein Schalter für die gesamte Website  
✅ **Automatisch**: Alle Seiten nutzen automatisch das richtige Logo  
✅ **Wartbar**: Änderungen nur an einer Stelle  
✅ **Flexibel**: Verschiedene Größen für verschiedene Verwendungszwecke  
✅ **Pride-freundlich**: Einfacher Wechsel zum Rainbow-Logo für besondere Anlässe

## Wann Rainbow-Logo verwenden?

- **Pride Month** (Juni)
- **Coming Out Day** (11. Oktober)
- **Internationaler Tag gegen Homophobie** (17. Mai)
- **Christopher Street Day** Veranstaltungen
- Besondere Events zur Unterstützung der LGBTQ+ Community

Einfach `USE_RAINBOW_LOGO` auf `true` setzen und alle Logos wechseln automatisch!
