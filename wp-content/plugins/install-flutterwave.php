<?php
/**
 * NovEquip - Automatic Flutterwave Installer
 * This plugin automatically installs and activates Flutterwave payment gateway
 * 
 * Copy this file to wp-content/plugins/install-flutterwave.php
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    define('WP_USE_THEMES', false);
    require_once dirname(dirname(dirname(__FILE__))) . '/wp-load.php';
}

// Make sure we have the necessary functions
require_once(ABSPATH . 'wp-admin/includes/plugin.php');
require_once(ABSPATH . 'wp-admin/includes/plugin-install.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/misc.php');
require_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');

/**
 * Installs and activates a plugin
 */
function novequip_install_plugin($plugin_slug, $activate = true) {
    // Check if the plugin is already installed
    $installed_plugins = get_plugins();
    $plugin_path = false;
    
    // Check if it's already installed
    foreach ($installed_plugins as $path => $plugin) {
        if (strpos($path, $plugin_slug . '/') === 0) {
            $plugin_path = $path;
            break;
        }
    }
    
    // If not installed, install it
    if (!$plugin_path) {
        echo "Installing $plugin_slug plugin...<br>";
        
        // Get plugin info from WordPress.org
        $api = plugins_api('plugin_information', array(
            'slug' => $plugin_slug,
            'fields' => array(
                'short_description' => false,
                'sections' => false,
                'requires' => false,
                'rating' => false,
                'ratings' => false,
                'downloaded' => false,
                'last_updated' => false,
                'added' => false,
                'tags' => false,
                'compatibility' => false,
                'homepage' => false,
                'donate_link' => false,
            ),
        ));
        
        if (is_wp_error($api)) {
            echo "Error getting plugin information: " . $api->get_error_message() . "<br>";
            return false;
        }
        
        // Use the WordPress upgrader to install the plugin
        $upgrader = new Plugin_Upgrader(new WP_Ajax_Upgrader_Skin());
        $result = $upgrader->install($api->download_link);
        
        if (is_wp_error($result)) {
            echo "Installation failed: " . $result->get_error_message() . "<br>";
            return false;
        } elseif (is_null($result)) {
            echo "Installation failed. Check permissions.<br>";
            return false;
        }
        
        echo "Plugin installed successfully!<br>";
        
        // Get the plugin path for activation
        $installed_plugins = get_plugins();
        foreach ($installed_plugins as $path => $plugin) {
            if (strpos($path, $plugin_slug . '/') === 0) {
                $plugin_path = $path;
                break;
            }
        }
    } else {
        echo "Plugin $plugin_slug is already installed.<br>";
    }
    
    // Activate the plugin if requested
    if ($activate && $plugin_path) {
        if (is_plugin_active($plugin_path)) {
            echo "Plugin is already active.<br>";
        } else {
            echo "Activating plugin...<br>";
            $result = activate_plugin($plugin_path);
            
            if (is_wp_error($result)) {
                echo "Activation failed: " . $result->get_error_message() . "<br>";
                return false;
            }
            
            echo "Plugin activated successfully!<br>";
        }
    }
    
    return true;
}

// Handle the plugin installation
function novequip_handle_flutterwave_installation() {
    // Security check
    if (!current_user_can('install_plugins')) {
        echo "You don't have permission to install plugins.";
        return;
    }
    
    echo "<h2>Flutterwave Installation for NovEquip</h2>";
    
    // First, ensure WooCommerce is active as it's a dependency
    if (!is_plugin_active('woocommerce/woocommerce.php')) {
        echo "<div style='color:red;'>WooCommerce is not active. Please activate WooCommerce first.</div>";
        return;
    }
    
    // Install and activate Flutterwave
    $flutterwave_installed = novequip_install_plugin('rave-woocommerce-payment-gateway');
    
    if ($flutterwave_installed) {
        echo "<h3>Next Steps:</h3>";
        echo "<ol>";
        echo "<li>Go to <a href='" . admin_url('admin.php?page=wc-settings&tab=checkout&section=rave') . "'>WooCommerce > Settings > Payments > Flutterwave</a> to configure the plugin.</li>";
        echo "<li>Enable the payment method and enter your API keys from your <a href='https://dashboard.flutterwave.com/' target='_blank'>Flutterwave dashboard</a>.</li>";
        echo "<li>Configure the payment options to enable Mobile Money and other payment methods.</li>";
        echo "</ol>";
        
        echo "<p><strong>Important:</strong> For testing purposes, you can use these test card details:</p>";
        echo "<ul>";
        echo "<li>Card Number: 5531 8866 5214 2950</li>";
        echo "<li>Expiry: 09/32</li>";
        echo "<li>CVV: 564</li>";
        echo "<li>PIN: 3310</li>";
        echo "<li>OTP: 12345</li>";
        echo "</ul>";
    }
}

// Add a menu item to run the installation
function novequip_add_flutterwave_installer_menu() {
    add_submenu_page(
        'woocommerce',
        'Install Flutterwave',
        'Install Flutterwave',
        'install_plugins',
        'install-flutterwave',
        'novequip_handle_flutterwave_installation'
    );
}
add_action('admin_menu', 'novequip_add_flutterwave_installer_menu');

// If this file is accessed directly, run the installation
if (isset($_GET['install']) && $_GET['install'] === 'now') {
    novequip_handle_flutterwave_installation();
}
