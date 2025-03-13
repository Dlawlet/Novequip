#!/bin/bash
# Script to install and configure TranslatePress for NovEquip medical equipment store

# Get the WordPress container ID
CONTAINER_ID=$(docker ps --filter "name=novequip_wordpress" --format "{{.ID}}")

if [ -z "$CONTAINER_ID" ]; then
    echo "WordPress container not found. Make sure it's running."
    exit 1
fi

echo "Found WordPress container: $CONTAINER_ID"
echo "Installing TranslatePress translation plugin..."

# Install the plugin directly using WP-CLI in the container
docker exec -it $CONTAINER_ID wp plugin install translatepress-multilingual --activate

if [ $? -eq 0 ]; then
    echo "TranslatePress successfully installed and activated!"
    
    # Configure default settings
    echo "Configuring TranslatePress for medical equipment website..."
    docker exec -it $CONTAINER_ID wp option update trp_settings '{"default-language":"en_US","translation-languages":["en_US","fr_FR","es_ES","de_DE","ar"],"publish-languages":["en_US","fr_FR","es_ES","de_DE","ar"],"url-slugs":{"en_US":"en","fr_FR":"fr","es_ES":"es","de_DE":"de","ar":"ar"},"trp_advanced_settings":{"force_language_in_custom_ajax":0},"native_or_english_name":"english_name","add-subdirectory-to-default-language":"no","browser-redirect":"no","trp_machine_translation_settings":{"machine-translation":"no","machine-translation-for-automatic-translation-editor":"no","google-translate-key":"","deepl-api-type":"free","deepl-api-key":""}}'
    
    echo ""
    echo "TranslatePress has been configured with the following languages:"
    echo "- English (Default)"
    echo "- French"
    echo "- Spanish"
    echo "- German"
    echo "- Arabic"
    echo ""
    echo "Next steps:"
    echo "1. Go to WordPress admin: http://localhost:8080/wp-admin"
    echo "2. Navigate to Settings > TranslatePress"
    echo "3. Configure any additional languages you need"
    echo "4. For automatic translation, get an API key for Google Translate or DeepL"
    echo "5. To translate your site, click the 'Translate Site' button in the admin bar"
    echo ""
    echo "Important for medical equipment site:"
    echo "- Consider the SEO Pack add-on for language-specific medical SEO"
    echo "- The DeepL translator may provide better results for medical terminology"
    echo "- Create a medical glossary for consistent translation of technical terms"
else
    echo "Failed to install TranslatePress plugin."
    echo "You can try installing it manually from WordPress admin."
fi
