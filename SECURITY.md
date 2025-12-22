# Security Configuration & Best Practices
## Andreas Pareigis Stiftung Website

**Last Updated:** 2025-12-22

---

## 🔒 Security Measures Implemented

### 1. **File Access Protection**

#### Protected Directories (via .htaccess)
- ✅ `.config/` - Configuration files
- ✅ `storage/` - Uploaded files and PDFs
- ✅ `vendor/` - Composer dependencies
- ✅ `src/` - PHP source code
- ✅ `templates/` - PHP templates
- ✅ `data/` - JSON data files

#### Protected Files
- ✅ `.env` - Environment variables (SMTP credentials)
- ✅ `.htaccess` - Apache configuration
- ✅ `composer.json` / `composer.lock` - Dependency files
- ✅ All hidden files (starting with `.`)

#### Dangerous File Types Blocked
- ✅ Executable files: `.exe`, `.com`, `.bat`, `.cmd`, `.sh`
- ✅ Scripts: `.cgi`, `.pl`, `.py`, `.rb`, `.jsp`, `.asp`, `.aspx`

---

### 2. **CSRF Protection**

#### Implementation
- ✅ CSRF tokens generated for all forms (contact, request)
- ✅ Token validation on all form submissions
- ✅ Secure token generation using `random_bytes(32)`
- ✅ Hash-based token comparison (`hash_equals()`)
- ✅ **Token lifetime: 2 hours** (allows time for form filling)
- ✅ Timestamp-based token expiration
- ✅ Automatic token regeneration after use (one-time use pattern)

#### Token Lifetime
- **Duration:** 2 hours (7200 seconds)
- **Purpose:** Allows users sufficient time to fill out complex forms
- **Session lifetime:** Also extended to 2 hours
- **Expiration handling:** User-friendly error messages with instructions

#### Usage
```php
// In form pages (contact.php, request.php)
$csrfToken = SecurityHelper::generateCSRFToken();

// In forms
<input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">

// In submit handlers
SecurityHelper::validateCSRFToken($_POST['csrf_token']);

// Check token age (for debugging)
$tokenAge = SecurityHelper::getTokenAge(); // Returns age in seconds
```

#### User Experience
- Users are notified about 2-hour timeout on request form
- Expired token shows helpful error message explaining:
  - Why token expired
  - How to resolve (reload page)
  - Tip to save long texts externally

---

### 3. **Rate Limiting**

#### Contact Form
- ✅ **Limit:** 5 submissions per 5 minutes per IP address
- ✅ **Error Message:** "Zu viele Anfragen. Bitte warten Sie..."

#### Request Form
- ✅ **Limit:** 3 submissions per 10 minutes per IP address
- ✅ **Error Message:** "Zu viele Anträge. Bitte warten Sie..."

#### Implementation
- File-based tracking in `storage/.rate_limits`
- Automatic cleanup of expired entries
- IP-based identification

---

### 4. **Security Headers** (HTTP)

#### Implemented Headers
```apache
X-XSS-Protection: 1; mode=block
X-Frame-Options: SAMEORIGIN
X-Content-Type-Options: nosniff
Referrer-Policy: strict-origin-when-cross-origin
Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; ...
```

#### HTTPS Enforcement (When SSL Active)
```apache
Strict-Transport-Security: max-age=31536000; includeSubDomains; preload
```

**Note:** Uncomment HTTPS redirect in `/public/.htaccess` after SSL certificate is installed.

---

### 5. **Input Validation & Sanitization**

#### XSS Prevention
- ✅ All user input escaped with `htmlspecialchars($var, ENT_QUOTES, 'UTF-8')`
- ✅ Email validation: `filter_var($email, FILTER_VALIDATE_EMAIL)`
- ✅ Filename sanitization: Regex pattern `^[a-zA-Z0-9_-]+\.pdf$`

#### Email Injection Prevention
- ✅ Email addresses sanitized and validated
- ✅ No direct user input in email headers
- ✅ SMTP authentication required

#### Path Traversal Prevention
- ✅ `realpath()` verification for file downloads
- ✅ Whitelist-based file access
- ✅ No `../` allowed in filenames

---

### 6. **File Download Security**

#### PDF Download Handler (`download_pdf.php`)
```php
// 1. Filename validation (alphanumeric + .pdf only)
if (!preg_match('/^[a-zA-Z0-9_-]+\.pdf$/', $filename)) {
    die('Invalid filename');
}

// 2. Path traversal protection
$realPath = realpath($pdfPath);
if (strpos($realPath, realpath(STORAGE_PATH)) !== 0) {
    die('Access denied');
}

// 3. File existence check
if (!file_exists($pdfPath)) {
    die('File not found');
}
```

---

### 7. **Session Security**

#### Secure Session Settings
```php
// Extended session lifetime for form filling (2 hours)
ini_set('session.gc_maxlifetime', 7200);
ini_set('session.cookie_lifetime', 7200);

// Security settings
ini_set('session.cookie_httponly', 1);  // Prevent JavaScript access
ini_set('session.use_only_cookies', 1);  // No session ID in URL
ini_set('session.cookie_samesite', 'Strict');  // CSRF protection
ini_set('session.cookie_secure', 1);  // HTTPS only (when available)
```

#### Session Timeout
- **Lifetime:** 2 hours (7200 seconds)
- **Reason:** Complex forms (request form) can take time to complete
- **Cookie lifetime:** Also 2 hours
- **Garbage collection:** Automatic cleanup of expired sessions

---

### 8. **SQL Injection Protection**

✅ **No Database Used** - Application is file-based (JSON)
- No SQL queries = No SQL injection risk
- JSON data is read-only
- No direct file writes from user input

---

### 9. **Server Configuration**

#### Apache Settings
```apache
Options -Indexes              # Disable directory listing
ServerSignature Off           # Hide Apache version
Header unset Server           # Hide server information
Header unset X-Powered-By     # Hide PHP version
```

#### PHP Settings (Recommended in php.ini)
```ini
display_errors = Off
log_errors = On
error_log = /var/log/php_errors.log
expose_php = Off
allow_url_fopen = Off
allow_url_include = Off
disable_functions = exec,passthru,shell_exec,system,proc_open,popen
```

---

## ⚠️ Known Limitations

### 1. **No HTTPS Yet**
- **Status:** HTTP only (development/staging)
- **Action Required:** Install SSL certificate before production
- **Instructions:** Uncomment HTTPS redirect in `/public/.htaccess`

### 2. **Rate Limiting Storage**
- **Current:** File-based in `/storage/.rate_limits`
- **Limitation:** Shared hosting may have file lock issues
- **Improvement:** Consider Redis/Memcached for high-traffic sites

### 3. **Content Security Policy**
- **Current:** Allows `'unsafe-inline'` for scripts/styles
- **Reason:** Bootstrap and inline scripts
- **Improvement:** Move to external JS files and use nonces

---

## 🔧 Security Checklist for Production

### Before Going Live:

- [ ] **Install SSL Certificate**
  - Obtain certificate from provider (Let's Encrypt, etc.)
  - Configure Apache/Nginx for HTTPS
  - Uncomment HTTPS redirect in `.htaccess`

- [ ] **Secure .env File**
  - Verify `.env` is NOT accessible via web
  - Test: `https://your-domain.de/.env` should return 403
  - Change all default passwords

- [ ] **File Permissions**
  ```bash
  chmod 755 /home/bee/git/Anpa-Stiftung
  chmod 755 /home/bee/git/Anpa-Stiftung/public
  chmod 644 /home/bee/git/Anpa-Stiftung/public/*.php
  chmod 600 /home/bee/git/Anpa-Stiftung/.config/.env
  chmod 755 /home/bee/git/Anpa-Stiftung/storage
  chmod 755 /home/bee/git/Anpa-Stiftung/storage/pdfs
  chmod 755 /home/bee/git/Anpa-Stiftung/storage/documents
  ```

- [ ] **Test Security Headers**
  - Use: https://securityheaders.com/
  - Target Grade: A or A+

- [ ] **Verify CSRF Protection**
  - Test form submission without token
  - Should fail with error message

- [ ] **Test Rate Limiting**
  - Submit form 6+ times rapidly
  - Should block after 5 attempts

- [ ] **Scan for Vulnerabilities**
  - Use: https://www.acunetix.com/ or OWASP ZAP
  - Fix any HIGH or CRITICAL issues

- [ ] **Backup Strategy**
  - Set up automated backups
  - Include: `/data`, `/storage/documents`, `.env`
  - Exclude: `/vendor`, `/storage/pdfs` (regenerable)

- [ ] **Error Logging**
  - Verify `error_log` is writable
  - Set up log rotation
  - Monitor logs regularly

- [ ] **Update Dependencies**
  ```bash
  composer update
  ```
  - Check for security advisories
  - Test thoroughly after updates

---

## 📊 Security Testing

### Manual Tests

1. **CSRF Attack Test**
   ```html
   <!-- External page attempting CSRF -->
   <form action="https://your-site.de/contact_submit.php" method="post">
     <input name="name" value="Attacker">
     <input name="email" value="attacker@evil.com">
     <input name="message" value="CSRF test">
   </form>
   ```
   **Expected:** Form submission fails (invalid token)

2. **Path Traversal Test**
   ```
   https://your-site.de/download_pdf.php?file=../../config.php
   ```
   **Expected:** 403 Forbidden or "Invalid filename"

3. **XSS Attack Test**
   ```
   Name: <script>alert('XSS')</script>
   ```
   **Expected:** Script is escaped and displayed as text

4. **SQL Injection Test** (Not applicable - no database)

5. **Rate Limiting Test**
   ```bash
   for i in {1..10}; do
     curl -X POST https://your-site.de/contact_submit.php
   done
   ```
   **Expected:** 429 Too Many Requests after 5 attempts

---

## 🚨 Incident Response

### If Compromise Suspected:

1. **Immediately:**
   - Change ALL passwords (SMTP, FTP, SSH, .env)
   - Review server access logs
   - Check for unauthorized files

2. **Investigation:**
   - Check `/storage/.rate_limits` for unusual IPs
   - Review Apache error and access logs
   - Scan for malware: `clamscan -r /path/to/website`

3. **Recovery:**
   - Restore from clean backup
   - Update all dependencies
   - Patch vulnerabilities
   - Monitor for 24-48 hours

---

## 📞 Security Contacts

- **Developer:** [Your Name/Team]
- **Hosting Provider:** [Provider Support]
- **Security Issues:** Report to `security@andreas-pareigis-stiftung.de`

---

## 📚 Resources

- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [PHP Security Guide](https://www.php.net/manual/en/security.php)
- [Apache Security Tips](https://httpd.apache.org/docs/2.4/misc/security_tips.html)
- [Content Security Policy](https://content-security-policy.com/)

---

**Version:** 1.0  
**Status:** ✅ Production Ready (after SSL installation)
