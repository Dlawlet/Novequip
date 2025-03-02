<?php
/**
 * WordPress Site URL Fixer
 * 
 * This script fixes the WordPress site URL if it's pointing to the wrong port.
 * Upload this to your WordPress root directory and access it via browser.
 * Delete after use for security purposes.
 */

// Make sure this is run directly
if (!isset($_SERVER['HTTP_HOST']) || !isset($_SERVER['REQUEST_URI'])) {
    die('This script must be run in a browser.');
}

// Add a secret key for security
$secret = 'novequip-fix';
$input_secret = isset($_GET['key']) ? $_GET['key'] : '';

if ($input_secret !== $secret) {
    die('Invalid security key. Use ?key=novequip-fix');
}

// Define the current URL (where this script is being accessed)
$current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];
$port = $_SERVER['SERVER_PORT'];
$intended_url = "http://localhost:8000";

echo "<h1>WordPress URL Fixer</h1>";
echo "<p>Current URL: {$current_url}</p>";
echo "<p>Intended URL: {$intended_url}</p>";

// Check if WordPress configuration is available
if (file_exists('wp-config.php')) {
    require_once('wp-config.php');
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    
    // Make sure we can connect to the database
    if (!isset($wpdb)) {
        die('WordPress database connection not available');
    }
    
    // Get current WordPress URLs from database
    $old_site_url = get_option('siteurl');
    $old_home_url = get_option('home');
    
    echo "<p>Current WordPress site URL: {$old_site_url}</p>";
    echo "<p>Current WordPress home URL: {$old_home_url}</p>";
    
    // Prepare for update
    if (isset($_GET['update']) && $_GET['update'] === 'true') {
        // Update the URLs in the database
        update_option('siteurl', $intended_url);
        update_option('home', $intended_url);
        
        echo "<p style='color: green;'>URLs updated successfully!</p>";
        echo "<p>New site URL: {$intended_url}</p>";
        echo "<p>New home URL: {$intended_url}</p>";
        
        // Flush rewrite rules
        echo "<p>Flushing rewrite rules...</p>";
        flush_rewrite_rules();
        
        echo "<p>Updates complete. <a href='{$intended_url}'>Visit your site</a> to verify.</p>";
        echo "<p><strong>Important:</strong> Delete this file for security!</p>";
    } else {
        // Show update button
        echo "<p>Click the button below to update your WordPress URLs.</p>";
        echo "<p><a href='?key={$secret}&update=true' style='display: inline-block; padding: 10px 15px; background: #0073aa; color: white; text-decoration: none; border-radius: 3px;'>Update URLs to {$intended_url}</a></p>";
    }
} else {
    echo "<p style='color: red;'>WordPress configuration file not found! Make sure this script is in the WordPress root directory.</p>";
}
?>
