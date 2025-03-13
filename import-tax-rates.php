<?php
/**
 * NovEquip Tax Rates Importer
 * 
 * This script adds a custom "Import Tax Rates" page to WooCommerce
 * that provides guidance on importing the tax-rates.csv file.
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    define('WP_USE_THEMES', false);
    require_once dirname(__FILE__) . '/wp-load.php';
}

// Add a submenu page under WooCommerce
function novequip_tax_rates_menu() {
    add_submenu_page(
        'woocommerce',
        'Import Tax Rates',
        'Import Tax Rates',
        'manage_woocommerce',
        'novequip-tax-rates',
        'novequip_tax_rates_page'
    );
}
add_action('admin_menu', 'novequip_tax_rates_menu');

// Output the admin page
function novequip_tax_rates_page() {
    ?>
    <div class="wrap">
        <h1>Import Medical Equipment Tax Rates</h1>
        
        <div class="card">
            <h2>About the Tax Rates File</h2>
            <p>The <code>tax-rates.csv</code> file includes tax rates for multiple countries with special consideration for medical equipment. Key features:</p>
            <ul style="list-style-type: disc; padding-left: 20px;">
                <li>Standard tax rates for general products</li>
                <li>Reduced or zero rates for medical equipment (in the "medical" tax class)</li>
                <li>Coverage for the US, EU, UK, Canada, Australia, and many African and Asian countries</li>
                <li>State/province level tax rates where applicable</li>
            </ul>
        </div>
        
        <div class="card" style="margin-top: 20px;">
            <h2>Before Importing</h2>
            <p>Before importing tax rates, you should set up a "medical" tax class:</p>
            <ol style="list-style-type: decimal; padding-left: 20px;">
                <li>Go to <a href="<?php echo admin_url('admin.php?page=wc-settings&tab=tax'); ?>">WooCommerce → Settings → Tax</a></li>
                <li>Click on the "Tax Classes" tab</li>
                <li>Add a new tax class named "Medical Equipment" with slug "medical"</li>
                <li>Save changes</li>
            </ol>
        </div>
        
        <div class="card" style="margin-top: 20px;">
            <h2>Import Tax Rates</h2>
            <p>To import the tax rates:</p>
            <ol style="list-style-type: decimal; padding-left: 20px;">
                <li>Go to <a href="<?php echo admin_url('admin.php?page=wc-settings&tab=tax'); ?>">WooCommerce → Settings → Tax</a></li>
                <li>Click on the "Standard Rates" tab</li>
                <li>Click the "Import CSV" button</li>
                <li>Upload the <code>tax-rates.csv</code> file</li>
                <li>Check "Replace existing tax rates" if you want to start fresh</li>
                <li>Click "Import"</li>
            </ol>
            <p><strong>Note:</strong> Importing tax rates will not automatically assign the medical tax class to your products. You'll need to edit each medical product and select the "Medical Equipment" tax class.</p>
        </div>
        
        <div class="card" style="margin-top: 20px;">
            <h2>Assigning Tax Classes to Products</h2>
            <p>To assign the "Medical Equipment" tax class to your products:</p>
            <ol style="list-style-type: decimal; padding-left: 20px;">
                <li>Go to Products → All Products</li>
                <li>Edit each medical product</li>
                <li>In the "Product Data" section, select the "Tax" tab</li>
                <li>From the "Tax Class" dropdown, select "Medical Equipment"</li>
                <li>Update the product</li>
            </ol>
            <p><strong>Tip:</strong> For bulk editing, select multiple products, choose "Edit" from the Bulk Actions dropdown, and set the tax class for all selected products at once.</p>
        </div>
        
        <div class="card" style="margin-top: 20px; background-color: #f8f9fa; border-left: 4px solid #007cba;">
            <h2>Tax Compliance Note</h2>
            <p><strong>Important:</strong> Tax rates vary by jurisdiction and can change over time. The provided tax rates are for demonstration purposes and may not reflect current tax laws. Consult with a tax professional to ensure compliance with tax regulations in the jurisdictions where you do business.</p>
        </div>
    </div>
    <?php
}

// Run as a standalone script too
if (isset($_SERVER['SCRIPT_FILENAME']) && basename($_SERVER['SCRIPT_FILENAME']) === basename(__FILE__)) {
    // Check if we have WordPress loaded
    if (function_exists('add_action')) {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>NovEquip Tax Rates Import Guide</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 800px; margin: 0 auto; padding: 20px; }
                h1 { color: #2a5885; }
                h2 { color: #3a6ea5; margin-top: 30px; }
                .card { border: 1px solid #ddd; border-radius: 4px; padding: 20px; margin-bottom: 20px; }
                code { background: #f5f5f5; padding: 2px 4px; border-radius: 3px; }
                ol li, ul li { margin-bottom: 10px; }
            </style>
        </head>
        <body>
            <h1>NovEquip Medical Equipment Tax Rates</h1>
            
            <div class="card">
                <h2>About the Tax Rates File</h2>
                <p>The <code>tax-rates.csv</code> file includes tax rates for multiple countries with special consideration for medical equipment. Key features:</p>
                <ul>
                    <li>Standard tax rates for general products</li>
                    <li>Reduced or zero rates for medical equipment (in the "medical" tax class)</li>
                    <li>Coverage for the US, EU, UK, Canada, Australia, and many African and Asian countries</li>
                    <li>State/province level tax rates where applicable</li>
                </ul>
            </div>
            
            <div class="card">
                <h2>How to Import</h2>
                <p>Follow these steps to import the tax rates into your WooCommerce store:</p>
                <ol>
                    <li>Log in to your WordPress admin</li>
                    <li>Create a tax class called "Medical Equipment" with slug "medical" at WooCommerce → Settings → Tax → Tax Classes</li>
                    <li>Go to WooCommerce → Settings → Tax → Standard Rates</li>
                    <li>Click "Import CSV" and upload the tax-rates.csv file</li>
                </ol>
            </div>
            
            <div class="card" style="border-left: 4px solid #007cba;">
                <h2>Tax Disclaimer</h2>
                <p><strong>Important:</strong> These tax rates are provided as a starting point and may not reflect current tax laws. Always consult with a tax professional to ensure compliance with tax regulations in the jurisdictions where you do business.</p>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "This script needs to be run within WordPress or uploaded to your WordPress site.";
    }
}
?>
