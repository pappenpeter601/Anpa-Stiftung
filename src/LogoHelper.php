<?php
/**
 * Logo Configuration Helper
 * Simple way to switch between standard and rainbow/LGBTQ logos
 * 
 * Usage:
 * 1. Set USE_RAINBOW_LOGO to true to use rainbow colors
 * 2. All pages will automatically use the rainbow logo
 */

// Set to true to use rainbow/LGBTQ colored logo, false for standard logo
define('USE_RAINBOW_LOGO', false);

/**
 * Get logo path based on configuration
 * 
 * @param string $size Logo size: '64', '120', '200', '400', 'svg', 'original'
 * @return string Path to logo file (relative to assets/img/)
 */
function getLogo($size = '120') {
    $prefix = USE_RAINBOW_LOGO ? 'logo-rainbow' : 'logo';
    
    switch($size) {
        case 'svg':
            return $prefix . '.svg';
        case 'original':
            return 'logo-original.png';
        case 'full-svg':
            return USE_RAINBOW_LOGO ? 'logo-rainbow.svg' : 'logo-full.svg';
        default:
            // For specific sizes like 64, 120, 200, 400
            if (USE_RAINBOW_LOGO && $size !== 'original') {
                return $prefix . '-' . $size . '.png';
            }
            return 'logo-' . $size . '.png';
    }
}

/**
 * Get full logo URL including BASE_URL
 * 
 * @param string $size Logo size
 * @return string Full URL to logo
 */
function getLogoUrl($size = '120') {
    if (!defined('BASE_URL')) {
        require_once __DIR__ . '/config.php';
    }
    return BASE_URL . 'assets/img/' . getLogo($size);
}

/**
 * Get logo HTML tag
 * 
 * @param string $size Logo size
 * @param int $displayWidth Display width in pixels
 * @param int $displayHeight Display height in pixels  
 * @param string $alt Alt text
 * @return string Complete img tag
 */
function getLogoTag($size = '120', $displayWidth = 60, $displayHeight = 32, $alt = 'Andreas Pareigis Stiftung Logo') {
    return '<img src="' . getLogoUrl($size) . '" alt="' . htmlspecialchars($alt, ENT_QUOTES, 'UTF-8') . '" width="' . $displayWidth . '" height="' . $displayHeight . '">';
}
