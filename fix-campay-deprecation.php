<?php
/**
 * Fix for CamPay API Plugin Deprecation Warnings
 * 
 * This script patches the CamPay API plugin to properly declare properties
 * and remove "Creation of dynamic property" deprecation warnings in PHP 8.2+
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    define('WP_USE_THEMES', false);
    require_once dirname(__FILE__) . '/wp-load.php';
}

// Define the plugin file path
$plugin_file = WP_PLUGIN_DIR . '/campay-api/campay-api.php';

if (!file_exists($plugin_file)) {
    echo "CamPay API plugin not found. Please ensure it's installed at wp-content/plugins/campay-api/";
    exit;
}

// Backup the original file
$backup_file = WP_PLUGIN_DIR . '/campay-api/campay-api.php.bak';
if (!file_exists($backup_file)) {
    copy($plugin_file, $backup_file);
    echo "Created backup of original plugin file at: " . $backup_file . "\n";
}

// Read the plugin file
$content = file_get_contents($plugin_file);

// Find the WC_CamPay_Gateway class definition
if (preg_match('/class\s+WC_CamPay_Gateway\s+extends\s+WC_Payment_Gateway\s*{/i', $content, $matches, PREG_OFFSET_CAPTURE)) {
    $class_start_pos = $matches[0][1] + strlen($matches[0][0]);
    
    // Check if properties are already declared
    if (strpos($content, 'public $testmode;') === false) {
        // Add property declarations after the class opening bracket
        $property_declarations = "
    // Property declarations to prevent deprecation warnings
    public \$testmode;
    public \$dollar_activated;
    public \$card_activated;
    public \$euro_activated;
    public \$usd_xaf;
    public \$euro_xaf;
    public \$version;
    public \$campay_username;
    public \$campay_password;
    public \$debugging;
    public \$title;
    public \$description;
    public \$live_url;
    public \$test_url;
";
        
        // Insert property declarations at the beginning of the class
        $content = substr_replace($content, $property_declarations, $class_start_pos, 0);
        
        // Save the modified file
        file_put_contents($plugin_file, $content);
        
        echo "Successfully fixed CamPay API plugin deprecation warnings.\n";
        echo "Added proper property declarations to prevent 'Creation of dynamic property' warnings.\n";
    } else {
        echo "Properties are already declared in the plugin. No changes needed.\n";
    }
} else {
    echo "Could not find the WC_CamPay_Gateway class in the plugin file. Manual fix may be required.\n";
}

/**
 * Instructions for admin
 */
echo "\nTo verify the fix:\n";
echo "1. Refresh your WordPress admin pages\n";
echo "2. The deprecation warnings for CamPay API should no longer appear\n";
echo "3. If you encounter any issues, the original plugin file is backed up at: " . $backup_file . "\n";
?>
