# Self-Hosted Fonts

## Inter Font Family

This directory contains self-hosted Inter font files for GDPR compliance.

### Why Self-Hosted?

German courts have ruled that loading Google Fonts from Google's servers can violate GDPR because:
- User IP addresses are transferred to Google (USA)
- No explicit consent obtained
- Potential GDPR violations

**Solution:** We host fonts locally on our own servers.

### Font Files Included

- `Inter-Light.woff2` (300) - Light weight
- `Inter-Regular.woff2` (400) - Normal weight
- `Inter-SemiBold.woff2` (600) - Semi-bold weight
- `Inter-Bold.woff2` (700) - Bold weight
- `Inter-Italic.woff2` (400 italic) - Italic
- `Inter-BoldItalic.woff2` (700 italic) - Bold italic
- `InterVariable.woff2` - Variable font (all weights)
- `InterVariable-Italic.woff2` - Variable font italic

**Total Size:** ~1.4 MB (highly compressed WOFF2 format)

### Font Loading

Fonts are loaded via `/assets/css/fonts.css` with:
- `font-display: swap` - Text remains visible during font load
- WOFF2 format - Best compression, supported by all modern browsers

### License

**Inter Font License:** SIL Open Font License 1.1
- Free for commercial use
- Can be modified and redistributed
- Full license: LICENSE.txt

### Source

- **Font:** Inter by Rasmus Andersson
- **Website:** https://rsms.me/inter/
- **Version:** 4.0
- **Downloaded:** December 2025

### Performance

WOFF2 files are highly compressed:
- ~106-116 KB per weight
- Loads in < 50ms on broadband
- Cached by browser after first load

### Browser Support

WOFF2 is supported by:
- ✅ Chrome 36+
- ✅ Firefox 39+
- ✅ Safari 12+
- ✅ Edge 14+
- ✅ All modern mobile browsers

Coverage: 97%+ of global users
