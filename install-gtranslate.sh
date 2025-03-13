#!/bin/bash
# Script to install and configure GTranslate for NovEquip medical equipment store
# GTranslate provides FREE automatic translation powered by Google Translate

# Get the WordPress container ID
CONTAINER_ID=$(docker ps --filter "name=novequip_wordpress" --format "{{.ID}}")

if [ -z "$CONTAINER_ID" ]; then
    echo "WordPress container not found. Make sure it's running."
    exit 1
fi

echo "Found WordPress container: $CONTAINER_ID"
echo "Installing GTranslate plugin with FREE automatic translation..."

# Install the plugin directly using WP-CLI in the container
docker exec -it $CONTAINER_ID wp plugin install gtranslate --activate

if [ $? -eq 0 ]; then
    echo "GTranslate successfully installed and activated!"
    
    # Configure optimal settings for medical equipment site
    echo "Configuring GTranslate with optimal settings for medical equipment website..."
    
    # Set up GTranslate settings (analytics disabled, show in menu)
    docker exec -it $CONTAINER_ID wp option update GTranslate '{"pro_version":"","enterprise_version":"","url_translation":"","add_hreflang_tags":"","email_translation":"","email_translation_user":"","widget_look":"dropdown_with_flags","flag_size":"24","monochrome_flags":"","widget_code":"<!-- GTranslate: https://gtranslate.io/ -->","incl_langs":["en","fr","es","de","ar","zh-CN","ru","nl","it","pt","ja","hi"],"fincl_langs":["en","fr","es","de","ar","zh-CN","ru","nl","it","pt","ja","hi"],"alt_flags":"","language_codes":"","default_language":"en","detect_browser_language":"","custom_domains":"","custom_domains_enabled":"","enable_cdn":"","show_in_menu":"","floating_language_selector":"no","native_language_names":"1","analytics":"","add_new_line":"1"}'
    
    # Add GTranslate widget to footer widget area
    docker exec -it $CONTAINER_ID wp widget add block sidebar-1 1 --content="<!-- wp:shortcode -->[gtranslate]<!-- /wp:shortcode -->"
    
    echo ""
    echo "GTranslate has been configured with the following languages:"
    echo "- English (Default)"
    echo "- French"
    echo "- Spanish"
    echo "- German"
    echo "- Arabic"
    echo "- Chinese (Simplified)"
    echo "- Russian"
    echo "- Dutch"
    echo "- Italian"
    echo "- Portuguese"
    echo "- Japanese" 
    echo "- Hindi"
    echo ""
    echo "IMPORTANT: GTranslate FREE version automatically translates your site using Google Translate"
    echo "with these benefits:"
    echo "- No API key needed"
    echo "- No monthly limits"
    echo "- Automatic browser language detection"
    echo "- Translation is performed client-side (no server load)"
    echo ""
    echo "Next steps:"
    echo "1. Go to WordPress admin: http://localhost:8080/wp-admin"
    echo "2. Navigate to Settings > GTranslate"
    echo "3. You can modify the language list or widget appearance"
    echo "4. Visit your site - the language dropdown will appear in your widget area"
    echo ""
    echo "Note for medical equipment store:"
    echo "- The free version translates content client-side using Google Translate"
    echo "- For SEO-translated pages, consider upgrading to paid version later"
    echo "- For better medical terminology translation, use the provided glossary with paid versions"
else
    echo "Failed to install GTranslate plugin."
    echo "You can try installing it manually from WordPress admin:"
    echo "1. Go to Plugins > Add New"
    echo "2. Search for 'GTranslate'"
    echo "3. Click Install Now and then Activate"
fi
