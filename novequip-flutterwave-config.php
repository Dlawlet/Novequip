<?php
/**
 * NovEquip - Flutterwave Configuration Guide
 * This file provides instructions for setting up Flutterwave for WooCommerce
 * and contains a script to automatically activate it.
 */

// Output HTML format for nicer display
header('Content-Type: text/html');
?>
<!DOCTYPE html>
<html>
<head>
    <title>NovEquip - Flutterwave Configuration Guide</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 800px; margin: 0 auto; padding: 20px; }
        h1 { color: #2a5885; }
        h2 { color: #3a6ea5; margin-top: 30px; }
        code { background: #f5f5f5; padding: 2px 4px; border-radius: 3px; }
        .step { background: #f9f9f9; padding: 15px; margin: 15px 0; border-left: 4px solid #3a6ea5; }
        .note { background: #fff8e5; padding: 10px; margin: 10px 0; border-left: 4px solid #ffb900; }
        table { border-collapse: collapse; width: 100%; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .button { display: inline-block; background: #2a5885; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px; }
    </style>
</head>
<body>
    <h1>Flutterwave for WooCommerce - Setup Guide</h1>
    
    <p>This guide will help you set up Flutterwave as a payment gateway for your NovEquip medical equipment store, enabling various payment methods including African mobile money.</p>
    
    <div class="note">
        <strong>Note:</strong> You need a Flutterwave account to use this payment gateway. If you don't have one, <a href="https://dashboard.flutterwave.com/signup" target="_blank">sign up here</a>.
    </div>
    
    <h2>Supported Payment Methods</h2>
    
    <p>Flutterwave supports a wide range of payment methods, making it ideal for international and African markets:</p>
    
    <table>
        <tr>
            <th>Category</th>
            <th>Payment Methods</th>
        </tr>
        <tr>
            <td>Cards</td>
            <td>Visa, Mastercard, Discover, American Express</td>
        </tr>
        <tr>
            <td>Mobile Money</td>
            <td>MTN Mobile Money, Airtel Money, Vodafone Cash, Tigo Pesa, EcoCash</td>
        </tr>
        <tr>
            <td>Bank Transfers</td>
            <td>Nigerian banks, Ghanaian banks, South African banks, Kenyan banks</td>
        </tr>
        <tr>
            <td>E-Wallets</td>
            <td>Paga, Barter</td>
        </tr>
        <tr>
            <td>USSD</td>
            <td>GTBank, Zenith Bank, UBA</td>
        </tr>
    </table>
    
    <h2>Installation Steps</h2>
    
    <div class="step">
        <h3>Step 1: Plugin Installation</h3>
        <p>You've already downloaded the plugin using the <code>download-flutterwave.sh</code> script. The plugin is now in your <code>wp-content/plugins/</code> directory.</p>
    </div>
    
    <div class="step">
        <h3>Step 2: Plugin Activation</h3>
        <p>Log in to your WordPress admin and navigate to <strong>Plugins > Installed Plugins</strong>. Find "Flutterwave for WooCommerce" and click "Activate".</p>
    </div>
    
    <div class="step">
        <h3>Step 3: Configure Flutterwave</h3>
        <p>After activation, go to <strong>WooCommerce > Settings > Payments</strong> and click on "Flutterwave".</p>
        <p>Configure the following settings:</p>
        <ul>
            <li><strong>Enable/Disable</strong> - Check this to enable Flutterwave</li>
            <li><strong>Title</strong> - This will be shown at checkout (e.g., "Pay with Card, Mobile Money")</li>
            <li><strong>Description</strong> - Information displayed to customers (e.g., "Pay securely using Flutterwave")</li>
            <li><strong>Test Mode</strong> - Enable for testing (use test API keys)</li>
            <li><strong>Test Secret Key</strong> - From your Flutterwave dashboard (test mode)</li>
            <li><strong>Test Public Key</strong> - From your Flutterwave dashboard (test mode)</li>
            <li><strong>Live Secret Key</strong> - From your Flutterwave dashboard (production)</li>
            <li><strong>Live Public Key</strong> - From your Flutterwave dashboard (production)</li>
            <li><strong>Payment Options</strong> - Select which payment methods to display</li>
            <li><strong>Custom Logo</strong> - Upload your store logo (optional)</li>
            <li><strong>Modal Title</strong> - Title displayed on payment modal (e.g., "NovEquip Medical")</li>
            <li><strong>Modal Description</strong> - Description displayed on payment modal (e.g., "Payment for medical equipment")</li>
        </ul>
    </div>
    
    <div class="step">
        <h3>Step 4: Getting Your API Keys</h3>
        <p>To get your API keys:</p>
        <ol>
            <li>Log in to your <a href="https://dashboard.flutterwave.com/login" target="_blank">Flutterwave Dashboard</a></li>
            <li>Navigate to <strong>Settings > API</strong></li>
            <li>Copy your Public Key and Secret Key</li>
            <li>Toggle between Test and Live modes to get both sets of keys</li>
        </ol>
    </div>
    
    <div class="step">
        <h3>Step 5: Testing</h3>
        <p>Before going live, test your setup using Flutterwave's test cards:</p>
        <table>
            <tr>
                <th>Card Number</th>
                <th>Expiry</th>
                <th>CVV</th>
                <th>PIN</th>
                <th>OTP</th>
            </tr>
            <tr>
                <td>5531 8866 5214 2950</td>
                <td>09/32</td>
                <td>564</td>
                <td>3310</td>
                <td>12345</td>
            </tr>
            <tr>
                <td>4187 4274 1556 4246</td>
                <td>09/32</td>
                <td>828</td>
                <td>3310</td>
                <td>12345</td>
            </tr>
        </table>
    </div>
    
    <div class="note">
        <p><strong>Important:</strong> Always use test mode with test API keys when testing. Only switch to live mode with live API keys when your store is ready for real transactions.</p>
    </div>
    
    <h2>Troubleshooting</h2>
    
    <p>If you encounter issues with Flutterwave:</p>
    <ul>
        <li>Ensure your API keys are entered correctly</li>
        <li>Check that your Flutterwave account is properly verified</li>
        <li>Verify that your store currency is supported by Flutterwave</li>
        <li>Check WooCommerce logs at WooCommerce > Status > Logs</li>
        <li>Contact Flutterwave support at <a href="mailto:support@flutterwave.com">support@flutterwave.com</a></li>
    </ul>
    
    <h2>Going Live</h2>
    
    <p>When you're ready to accept real payments:</p>
    <ol>
        <li>Complete your business verification on Flutterwave</li>
        <li>Switch from Test Mode to Live Mode in your Flutterwave settings</li>
        <li>Use your Live API keys instead of Test keys</li>
        <li>Make a small test purchase to verify everything works</li>
    </ol>
    
    <?php
    // Check if we're in WordPress context and have access to functions
    if (file_exists('../wp-load.php')) {
        echo '<div class="step">';
        echo '<h3>Automatic Activation</h3>';
        echo '<p>Click the button below to automatically activate Flutterwave if it\'s already installed:</p>';
        echo '<a href="?activate=true" class="button">Activate Flutterwave Plugin</a>';
        echo '</div>';
        
        // Process activation if requested
        if (isset($_GET['activate']) && $_GET['activate'] === 'true') {
            // Load WordPress
            require_once('../wp-load.php');
            
            // Check if plugin exists
            $plugin_path = 'rave-woocommerce-payment-gateway/woocommerce-flutterwave.php';
            if (file_exists(WP_PLUGIN_DIR . '/' . $plugin_path)) {
                // Activate the plugin
                include_once(ABSPATH . 'wp-admin/includes/plugin.php');
                $result = activate_plugin($plugin_path);
                
                if (is_wp_error($result)) {
                    echo '<div class="note" style="border-left-color: #dc3232;">';
                    echo '<p><strong>Error:</strong> ' . $result->get_error_message() . '</p>';
                    echo '</div>';
                } else {
                    echo '<div class="note" style="border-left-color: #46b450;">';
                    echo '<p><strong>Success:</strong> Flutterwave plugin has been activated! Now go to WooCommerce > Settings > Payments to configure it.</p>';
                    echo '</div>';
                }
            } else {
                echo '<div class="note" style="border-left-color: #dc3232;">';
                echo '<p><strong>Error:</strong> Flutterwave plugin is not installed. Please run the download-flutterwave.sh script first.</p>';
                echo '</div>';
            }
        }
    }
    ?>
</body>
</html>
<?php
// End of HTML output
?>
