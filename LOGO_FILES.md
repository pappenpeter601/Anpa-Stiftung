# Logo-Dateien für Andreas Pareigis Stiftung

## Übersicht der Logo-Dateien

### Original-Logo
- **logo-original.png** (229x122px) - Das Originale Logo mit Text

### Standard-Versionen (Reguläre Farben)
- **logo-64.png** (64px Breite) - Für Favicons, kleine Icons
- **logo-120.png** (120px Breite) - Für Header/Navigation (Standard)
- **logo-200.png** (200px Breite) - Für mittlere Displays
- **logo-400.png** (400px Breite) - Für große Displays, hochauflösend
- **logo-full.svg** (SVG) - Vektorversion, skalierbar für alle Größen

### Rainbow/LGBTQ-Versionen
- **logo-rainbow.png** (400px Breite) - Rainbow-Version in hoher Auflösung
- **logo-rainbow-64.png** (64px Breite) - Kleine Rainbow-Version
- **logo-rainbow-120.png** (120px Breite) - Rainbow für Header/Navigation
- **logo-rainbow-200.png** (200px Breite) - Rainbow mittlere Größe
- **logo-rainbow.svg** (SVG) - Rainbow-Vektorversion mit LGBTQ-Farbverlauf

### Alte Dateien (nicht mehr verwendet)
- **logo.svg** - Alter Platzhalter, kann entfernt werden

## Verwendung

### Webseite
- **Header/Navigation**: `logo-120.png` (60x32 angezeigt)
- **Footer**: `logo-120.png` (64x34 angezeigt)
- **Hochauflösende Displays**: `logo-400.png`

### E-Mail-Templates
- **Standard**: `logo-120.png` (120x64 angezeigt, über URL referenziert)
- **Alternative**: Logo kann als Base64 inline eingebettet werden

### PDF-Dokumente (mPDF)
- **Empfohlen**: `logo-200.png` oder `logo-400.png`
- **Alternative**: `logo-full.svg` (beste Qualität)

### Rainbow/LGBTQ Version
Die Rainbow-Versionen nutzen die offiziellen LGBTQ Pride-Farben:
- Rot: #E40303
- Orange: #FF8C00
- Gelb: #FFED00
- Grün: #008026
- Blau: #24408E
- Lila: #732982

**Verwendung**: Für besondere Anlässe (z.B. Pride Month) können die Rainbow-Versionen die Standard-Logos ersetzen.

## Wie man zwischen Standard und Rainbow wechselt

### Header (templates/header.php)
```php
<!-- Standard -->
<img src="<?php echo BASE_URL; ?>assets/img/logo-120.png" alt="Logo" width="60" height="32">

<!-- Rainbow Version -->
<img src="<?php echo BASE_URL; ?>assets/img/logo-rainbow-120.png" alt="Logo" width="60" height="32">
```

### Footer (templates/footer.php)
```php
<!-- Standard -->
<img src="<?php echo BASE_URL; ?>assets/img/logo-120.png" alt="Logo" width="64" height="34">

<!-- Rainbow Version -->
<img src="<?php echo BASE_URL; ?>assets/img/logo-rainbow-120.png" alt="Logo" width="64" height="34">
```

### E-Mail Templates (src/EmailTemplates.php)
```php
<!-- Standard -->
<img src="' . BASE_URL . 'assets/img/logo-120.png" ...>

<!-- Rainbow Version -->
<img src="' . BASE_URL . 'assets/img/logo-rainbow-120.png" ...>
```

## Dateigröße & Performance
- PNG-Dateien: Optimiert für Web, gute Qualität
- SVG-Dateien: Kleinste Dateigröße, perfekt für alle Auflösungen
- Empfehlung: SVG bevorzugen wo möglich, PNG für Kompatibilität

## Technische Details
- Originalformat: PNG (229x122px)
- Seitenverhältnis: ~1.88:1 (bewahrt bei allen Größen)
- Alle PNGs mit ICC-Profil für Farbkonsistenz
- SVG-Versionen mit eingebetteten Schriften für Portabilität

## Zukünftige Verbesserungen
1. Ersetzen der Platzhalter-SVGs durch konvertierte Version des Original-Logos
2. Favicon-Set erstellen (16x16, 32x32, etc.)
3. Apple Touch Icons für iOS-Geräte
4. Open Graph / Social Media Vorschaubilder (1200x630px)
