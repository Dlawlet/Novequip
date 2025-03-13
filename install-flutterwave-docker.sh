#!/bin/bash
# Script to install Flutterwave payment gateway directly in WordPress docker container

# Get the WordPress container ID
CONTAINER_ID=$(docker ps --filter "name=novequip_wordpress" --format "{{.ID}}")

if [ -z "$CONTAINER_ID" ]; then
    echo "WordPress container not found. Make sure it's running."
    exit 1
fi

echo "Found WordPress container: $CONTAINER_ID"
echo "Installing Flutterwave payment gateway..."

# Install the plugin directly using WP-CLI in the container
docker exec -it $CONTAINER_ID wp plugin install rave-woocommerce-payment-gateway --activate

# Check if installation was successful
if [ $? -eq 0 ]; then
    echo "Flutterwave plugin successfully installed and activated!"
    echo ""
    echo "Next steps:"
    echo "1. Go to WordPress admin: http://localhost:8080/wp-admin"
    echo "2. Navigate to WooCommerce > Settings > Payments"
    echo "3. Enable Flutterwave and click 'Manage'"
    echo "4. Enter your API keys from your Flutterwave dashboard"
    echo "5. Configure to enable African mobile money payments"
    echo ""
    echo "For testing:"
    echo "- Use test mode and test API keys during setup"
    echo "- Card Number: 5531 8866 5214 2950"
    echo "- Expiry: 09/32"
    echo "- CVV: 564"
    echo "- PIN: 3310"
    echo "- OTP: 12345"
else
    echo "Failed to install Flutterwave plugin."
    echo "You can try installing it manually from WordPress admin."
fi
