#!/bin/bash
# Script to download and install Flutterwave for WooCommerce

echo "Downloading Flutterwave for WooCommerce plugin..."

# Create plugins directory if it doesn't exist
mkdir -p wp-content/plugins/

# Download the latest version of Flutterwave for WooCommerce
curl -L https://downloads.wordpress.org/plugin/rave-woocommerce-payment-gateway.zip -o flutterwave-woocommerce.zip

# Unzip the plugin
echo "Extracting plugin..."
unzip -q flutterwave-woocommerce.zip -d wp-content/plugins/

# Clean up
echo "Cleaning up..."
rm flutterwave-woocommerce.zip

echo "Flutterwave for WooCommerce plugin has been downloaded and extracted to wp-content/plugins/"
echo ""
echo "Next steps:"
echo "1. Activate the plugin from WordPress admin (Plugins > Installed Plugins)"
echo "2. Configure Flutterwave: WooCommerce > Settings > Payments > Flutterwave"
echo "3. Create a Flutterwave account if you don't have one at https://dashboard.flutterwave.com"
echo "4. Enter your Public Key and Secret Key from your Flutterwave dashboard"
echo ""
echo "For detailed setup instructions, refer to the configuration guide in novequip-flutterwave-config.php"
