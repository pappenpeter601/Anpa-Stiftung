<?php
/**
 * Security Helper for Andreas Pareigis Stiftung
 * Provides CSRF protection and other security utilities
 */

class SecurityHelper {
    
    /**
     * Initialize session securely
     */
    public static function initSession() {
        if (session_status() === PHP_SESSION_NONE) {
            // Extended session lifetime for long forms (2 hours)
            ini_set('session.gc_maxlifetime', 7200);
            ini_set('session.cookie_lifetime', 7200);
            
            // Secure session settings
            ini_set('session.cookie_httponly', 1);
            ini_set('session.use_only_cookies', 1);
            ini_set('session.cookie_samesite', 'Strict');
            
            // Enable secure cookies if HTTPS
            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                ini_set('session.cookie_secure', 1);
            }
            
            session_start();
        }
    }
    
    /**
     * Generate CSRF token with timestamp
     * Tokens are valid for 2 hours to allow time for form filling
     */
    public static function generateCSRFToken() {
        self::initSession();
        
        // Check if token exists and is still valid (within 2 hours)
        if (!empty($_SESSION['csrf_token']) && !empty($_SESSION['csrf_token_time'])) {
            $tokenAge = time() - $_SESSION['csrf_token_time'];
            if ($tokenAge < 7200) {
                // Token is still valid, return existing one
                return $_SESSION['csrf_token'];
            }
        }
        
        // Generate new token
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        $_SESSION['csrf_token_time'] = time();
        
        return $_SESSION['csrf_token'];
    }
    
    /**
     * Validate CSRF token
     * Tokens are valid for 2 hours from generation
     */
    public static function validateCSRFToken($token) {
        self::initSession();
        
        // Check if token exists
        if (!isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token_time'])) {
            return false;
        }
        
        // Check token age (2 hours = 7200 seconds)
        $tokenAge = time() - $_SESSION['csrf_token_time'];
        if ($tokenAge > 7200) {
            // Token expired
            unset($_SESSION['csrf_token']);
            unset($_SESSION['csrf_token_time']);
            return false;
        }
        
        // Validate token
        if (!hash_equals($_SESSION['csrf_token'], $token)) {
            return false;
        }
        
        // Token is valid - regenerate for next use (one-time use pattern)
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        $_SESSION['csrf_token_time'] = time();
        
        return true;
    }
    
    /**
     * Get token age in seconds (for debugging)
     */
    public static function getTokenAge() {
        self::initSession();
        if (isset($_SESSION['csrf_token_time'])) {
            return time() - $_SESSION['csrf_token_time'];
        }
        return null;
    }
    
    /**
     * Rate limiting check (simple file-based)
     */
    public static function checkRateLimit($identifier, $maxAttempts = 5, $timeWindow = 300) {
        $rateLimitFile = STORAGE_PATH . '/.rate_limits';
        
        if (!is_dir(dirname($rateLimitFile))) {
            @mkdir(dirname($rateLimitFile), 0755, true);
        }
        
        $limits = [];
        if (file_exists($rateLimitFile)) {
            $limits = json_decode(file_get_contents($rateLimitFile), true) ?: [];
        }
        
        $now = time();
        $key = md5($identifier);
        
        // Clean old entries
        $limits = array_filter($limits, function($data) use ($now, $timeWindow) {
            return ($now - $data['first_attempt']) < $timeWindow;
        });
        
        // Check current rate
        if (isset($limits[$key])) {
            $data = $limits[$key];
            if (($now - $data['first_attempt']) < $timeWindow) {
                if ($data['count'] >= $maxAttempts) {
                    return false; // Rate limit exceeded
                }
                $limits[$key]['count']++;
                $limits[$key]['last_attempt'] = $now;
            } else {
                // Reset window
                $limits[$key] = [
                    'count' => 1,
                    'first_attempt' => $now,
                    'last_attempt' => $now
                ];
            }
        } else {
            $limits[$key] = [
                'count' => 1,
                'first_attempt' => $now,
                'last_attempt' => $now
            ];
        }
        
        // Save limits
        file_put_contents($rateLimitFile, json_encode($limits));
        
        return true;
    }

    /**
     * Lightweight bot check using honeypot and form timing
     */
    public static function isLikelyBotSubmission(array $postData, $honeypotField = 'website', $minSeconds = 3) {
        $honeypot = trim($postData[$honeypotField] ?? '');
        if ($honeypot !== '') {
            return true;
        }

        $formTime = isset($postData['form_time']) ? (int)$postData['form_time'] : 0;
        if ($formTime <= 0) {
            return true;
        }

        $age = time() - $formTime;
        if ($age < $minSeconds || $age > 7200) {
            return true;
        }

        return false;
    }

    /**
     * Validate German-ish person names (allow umlauts, ß, spaces, apostrophes, hyphens)
     */
    public static function isValidGermanName($name) {
        $name = trim($name);
        if ($name === '' || mb_strlen($name) < 2) {
            return false;
        }

        // Only letters (including umlauts/ß), spaces, apostrophes, and hyphens
        return (bool) preg_match('/^[A-Za-zÄÖÜäöüß\s\-\'’]{2,80}$/u', $name);
    }

    /**
     * Validate message content: allow basic punctuation, ensure HTTPS-only links, require multiple words
     */
    public static function isValidGermanMessage($message, $minWords = 5, $minLength = 20) {
        $message = trim($message);
        if ($message === '' || mb_strlen($message) < $minLength) {
            return false;
        }

        // Reject disallowed characters (keep it to letters incl. umlauts, digits, common punctuation, newlines, slashes for URLs)
        if (!preg_match('/^[A-Za-zÄÖÜäöüß0-9\s\n\r.,!?:;()"\'’\-–—„“‚‘…\/]+$/u', $message)) {
            return false;
        }

        // Must have enough words to resemble a sentence
        $words = preg_split('/\s+/u', $message, -1, PREG_SPLIT_NO_EMPTY);
        if (count($words) < $minWords) {
            return false;
        }

        // Require at least one vowel (including umlauts) to avoid gibberish
        if (!preg_match('/[AEIOUÄÖÜaeiouäöü]/u', $message)) {
            return false;
        }

        // Enforce HTTPS if links are present; forbid http://
        if (preg_match('/http:\/\//i', $message)) {
            return false;
        }

        // If any link is present, ensure it is https://
        if (preg_match_all('/https?:\/\/\S+/i', $message, $matches)) {
            foreach ($matches[0] as $url) {
                if (stripos($url, 'https://') !== 0) {
                    return false;
                }
            }
        }

        return true;
    }
    
    /**
     * Sanitize filename for safe file operations
     */
    public static function sanitizeFilename($filename) {
        // Remove any path components
        $filename = basename($filename);
        
        // Allow only alphanumeric, hyphens, underscores, and dots
        $filename = preg_replace('/[^a-zA-Z0-9_.-]/', '_', $filename);
        
        // Remove multiple consecutive dots (path traversal protection)
        $filename = preg_replace('/\.{2,}/', '.', $filename);
        
        return $filename;
    }
    
    /**
     * Validate and sanitize email address
     */
    public static function sanitizeEmail($email) {
        $email = trim($email);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $email;
        }
        
        return false;
    }
    
    /**
     * Security headers
     */
    public static function setSecurityHeaders() {
        // Prevent clickjacking
        header('X-Frame-Options: SAMEORIGIN');
        
        // XSS Protection
        header('X-XSS-Protection: 1; mode=block');
        
        // Content type sniffing
        header('X-Content-Type-Options: nosniff');
        
        // Referrer Policy
        header('Referrer-Policy: strict-origin-when-cross-origin');
        
        // Content Security Policy (adjust as needed)
        header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://fonts.googleapis.com; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' data: https:; frame-ancestors 'self';");
        
        // HTTPS enforcement (if on HTTPS)
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
        }
    }
}
?>
