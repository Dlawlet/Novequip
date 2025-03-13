#!/bin/bash
# Script to fix CamPay API plugin deprecation warnings in WordPress docker container

# Get the WordPress container ID
CONTAINER_ID=$(docker ps --filter "name=novequip_wordpress" --format "{{.ID}}")

if [ -z "$CONTAINER_ID" ]; then
    echo "WordPress container not found. Make sure it's running."
    exit 1
fi

echo "Found WordPress container: $CONTAINER_ID"
echo "Creating fix for CamPay API plugin deprecation warnings..."

# Copy the fix script to the container
docker cp "d:/Hwork/NovEquip/fix-campay-deprecation.php" "$CONTAINER_ID:/var/www/html/fix-campay-deprecation.php"

# Execute the fix script in the container
docker exec -it $CONTAINER_ID php /var/www/html/fix-campay-deprecation.php

if [ $? -eq 0 ]; then
    echo "Fix script executed successfully!"
    echo ""
    echo "The script has:"
    echo "1. Created a backup of the original CamPay plugin file"
    echo "2. Added proper property declarations to prevent deprecation warnings"
    echo "3. Saved the modified plugin file"
    echo ""
    echo "You should no longer see the 'Creation of dynamic property' deprecation warnings"
    echo "If you encounter any issues, the original plugin file has been backed up as campay-api.php.bak"
else
    echo "Failed to apply the fix. You may need to modify the plugin manually:"
    echo ""
    echo "Manual fix instructions:"
    echo "1. Edit wp-content/plugins/campay-api/campay-api.php"
    echo "2. Find the WC_CamPay_Gateway class definition"
    echo "3. Add the following property declarations after the class opening bracket:"
    echo "   public \$testmode;"
    echo "   public \$dollar_activated;"
    echo "   public \$card_activated;" 
    echo "   public \$euro_activated;"
    echo "   public \$usd_xaf;"
    echo "   public \$euro_xaf;"
    echo "   public \$version;"
    echo "   public \$campay_username;"
    echo "   public \$campay_password;"
    echo "4. Save the file"
fi
