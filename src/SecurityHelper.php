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
