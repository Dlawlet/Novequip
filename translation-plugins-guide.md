# WordPress Translation Plugins for Medical Equipment E-commerce

This guide provides information about the best translation plugins for your NovEquip medical equipment e-commerce website, with a focus on medical terminology support and WooCommerce compatibility.

## Recommended Options

### 1. TranslatePress
**Best for: Visual editing and medical terminology**

![TranslatePress](https://ps.w.org/translatepress-multilingual/assets/banner-772x250.png)

✅ **Pros:**
- Visual front-end translation editor (see translations in context)
- Excellent WooCommerce support (translates product titles, descriptions, attributes)
- SEO-friendly with language-specific URLs
- Machine translation via Google Translate or DeepL API
- Free version available with premium add-ons

🔄 **Installation:**
```bash
# Use the provided script
./install-translatepress.sh
```

💲 **Pricing:**
- Free version: 2 languages
- Personal: $99/year - unlimited languages
- Business: $199/year - includes DeepL, SEO pack, automatic user language detection

### 2. WPML
**Best for: Enterprise-level medical websites**

![WPML](https://wpml.org/wp-content/uploads/2022/10/wpml-logo.png)

✅ **Pros:**
- Most comprehensive translation solution
- Complete WooCommerce integration
- Professional translation services (good for accurate medical translations)
- Advanced SEO support
- Multi-currency support for international sales

🔄 **Installation:**
- Purchase from [wpml.org](https://wpml.org/)
- Upload the plugin ZIP file in WordPress admin
- Activate and enter license key

💲 **Pricing:**
- Multilingual Blog: $29/year
- Multilingual CMS: $79/year (recommended for e-commerce)
- Multilingual Agency: $159/year (for client sites)

### 3. Polylang
**Best for: Budget-conscious sites**

![Polylang](https://ps.w.org/polylang/assets/banner-772x250.png)

✅ **Pros:**
- Free core plugin
- Integrates with WooCommerce (with premium add-on)
- SEO-friendly URLs
- Easy language switching

🔄 **Installation:**
```bash
docker exec -it $(docker ps --filter "name=novequip_wordpress" --format "{{.ID}}") wp plugin install polylang --activate
```

💲 **Pricing:**
- Polylang: Free
- Polylang Pro: €99/year (includes WooCommerce integration)

### 4. GTranslate
**Best for: Quick setup with minimal effort**

![GTranslate](https://ps.w.org/gtranslate/assets/banner-772x250.jpg)

✅ **Pros:**
- Easiest setup (automatic with Google Translate)
- No manual translation required
- Browser language detection
- Good for testing international markets

🔄 **Installation:**
```bash
docker exec -it $(docker ps --filter "name=novequip_wordpress" --format "{{.ID}}") wp plugin install gtranslate --activate
```

💲 **Pricing:**
- Free: Provides on-the-fly translation
- $7.99/month: SEO-friendly translations with human editing capability

## Medical Equipment Translation Considerations

### Important Factors for Medical Equipment Sites

1. **Terminology Accuracy**
   - Medical equipment names and descriptions require precise translation
   - Consider DeepL API for better accuracy with medical terms
   - Build a glossary of medical terms in TranslatePress or WPML

2. **Regulatory Compliance**
   - Ensure translated content meets medical regulatory requirements in target countries
   - Maintain proper disclaimers and warnings in all languages

3. **SEO for Medical Equipment**
   - Medical equipment searches are often specific
   - Use SEO add-ons to optimize each language version
   - Consider keyword research in target languages

4. **African Market Support**
   - For integration with Flutterwave, ensure support for African languages
   - Arabic, French, and English cover much of the African market

## Integration with WooCommerce

All recommended plugins integrate with WooCommerce, but with different levels of support:

| Plugin | WooCommerce Support |
|--------|---------------------|
| TranslatePress | Built-in (even in free version) |
| WPML | Complete (requires WooCommerce Multilingual add-on) |
| Polylang | Requires Pro version |
| GTranslate | Basic support in free, full in paid |

## Installation Script

For easiest setup, use the provided `install-translatepress.sh` script, which:
- Installs TranslatePress plugin
- Sets up English, French, Spanish, German, and Arabic languages
- Creates basic configuration optimized for medical equipment

## Next Steps After Installation

1. Configure machine translation if desired (Google Translate or DeepL API)
2. Add or remove languages in Settings > TranslatePress
3. Create language switcher in your site menu or sidebar
4. Review and fine-tune translations of medical terminology
5. Test checkout process in different languages

---

For assistance with translation setup or customization, contact your developer or refer to the [TranslatePress documentation](https://translatepress.com/docs/).
