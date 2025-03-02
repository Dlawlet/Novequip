<?php
/**
 * Plugin Name: NovEquip WooCommerce Extensions
 * Plugin URI: https://novequip.com
 * Description: Custom functionality for the NovEquip WooCommerce store
 * Version: 1.0.0
 * Author: NovEquip Team
 * Text Domain: novequip-wc-extensions
 * Domain Path: /languages
 * WC requires at least: 5.0
 * WC tested up to: 7.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('NOVEQUIP_WC_EXT_VERSION', '1.0.0');
define('NOVEQUIP_WC_EXT_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('NOVEQUIP_WC_EXT_PLUGIN_URL', plugin_dir_url(__FILE__));

class NovEquipWooCommerceExtensions {
    /**
     * Constructor
     */
    public function __construct() {
        // Main hooks
        add_action('plugins_loaded', array($this, 'init'));
        
        // Frontend enhancements
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_filter('woocommerce_product_tabs', array($this, 'modify_product_tabs'), 99);
        add_action('woocommerce_after_shop_loop_item', array($this, 'add_quick_view_button'), 15);
        add_action('woocommerce_after_single_product_summary', array($this, 'add_technical_specifications_tab_content'), 12);
        
        // Shop and category enhancements
        add_filter('woocommerce_catalog_orderby', array($this, 'custom_sorting_options'));
        add_filter('woocommerce_get_catalog_ordering_args', array($this, 'custom_catalog_ordering'));
        
        // Cart enhancements
        add_action('woocommerce_before_cart', array($this, 'add_cart_notice'));
        add_action('woocommerce_cart_coupon', array($this, 'add_progress_bar'));
        
        // Admin enhancements
        if (is_admin()) {
            add_action('admin_menu', array($this, 'add_admin_menu'));
            add_action('admin_init', array($this, 'register_settings'));
        }
    }
    
    /**
     * Initialize plugin when WordPress and all plugins are loaded
     */
    public function init() {
        // Check if WooCommerce is active
        if (!class_exists('WooCommerce')) {
            add_action('admin_notices', function() {
                echo '<div class="error"><p>' . __('NovEquip WooCommerce Extensions requires WooCommerce to be installed and active.', 'novequip-wc-extensions') . '</p></div>';
            });
            return;
        }
        
        // Load plugin text domain
        load_plugin_textdomain('novequip-wc-extensions', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }
    
    /**
     * Enqueue scripts and styles
     */
    public function enqueue_scripts() {
        if (is_shop() || is_product_category() || is_product()) {
            wp_enqueue_style(
                'novequip-wc-styles',
                NOVEQUIP_WC_EXT_PLUGIN_URL . 'assets/css/frontend.css',
                array(),
                NOVEQUIP_WC_EXT_VERSION
            );
            
            wp_enqueue_script(
                'novequip-wc-scripts',
                NOVEQUIP_WC_EXT_PLUGIN_URL . 'assets/js/frontend.js',
                array('jquery'),
                NOVEQUIP_WC_EXT_VERSION,
                true
            );
            
            // Add localized variables for JavaScript
            wp_localize_script('novequip-wc-scripts', 'novequipWCData', array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'security' => wp_create_nonce('novequip-wc-nonce')
            ));
        }
    }
    
    /**
     * Modify product tabs on single product page
     */
    public function modify_product_tabs($tabs) {
        // Add Technical Specifications tab
        $tabs['technical_specs'] = array(
            'title'    => __('Technical Specs', 'novequip-wc-extensions'),
            'priority' => 25,
            'callback' => array($this, 'technical_specs_tab_content')
        );
        
        // Rename Description tab
        if (isset($tabs['description'])) {
            $tabs['description']['title'] = __('Product Details', 'novequip-wc-extensions');
        }
        
        return $tabs;
    }
    
    /**
     * Technical specifications tab content
     */
    public function technical_specs_tab_content() {
        global $product;
        
        // Get product attributes
        $attributes = $product->get_attributes();
        
        if (!empty($attributes)) {
            echo '<h2>' . __('Technical Specifications', 'novequip-wc-extensions') . '</h2>';
            echo '<table class="novequip-specs-table">';
            echo '<tbody>';
            
            foreach ($attributes as $attribute) {
                if ($attribute->get_visible()) {
                    echo '<tr>';
                    echo '<th>' . wc_attribute_label($attribute->get_name()) . '</th>';
                    echo '<td>' . $this->get_formatted_attribute_value($attribute, $product) . '</td>';
                    echo '</tr>';
                }
            }
            
            // Add SKU if available
            if ($product->get_sku()) {
                echo '<tr>';
                echo '<th>' . __('SKU', 'novequip-wc-extensions') . '</th>';
                echo '<td>' . $product->get_sku() . '</td>';
                echo '</tr>';
            }
            
            // Add dimensions if available
            if ($product->has_dimensions()) {
                echo '<tr>';
                echo '<th>' . __('Dimensions', 'novequip-wc-extensions') . '</th>';
                echo '<td>' . wc_format_dimensions($product->get_dimensions(false)) . '</td>';
                echo '</tr>';
            }
            
            // Add weight if available
            if ($product->has_weight()) {
                echo '<tr>';
                echo '<th>' . __('Weight', 'novequip-wc-extensions') . '</th>';
                echo '<td>' . $product->get_weight() . ' ' . get_option('woocommerce_weight_unit') . '</td>';
                echo '</tr>';
            }
            
            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<p>' . __('No technical specifications available for this product.', 'novequip-wc-extensions') . '</p>';
        }
    }
    
    /**
     * Format attribute values nicely
     */
    private function get_formatted_attribute_value($attribute, $product) {
        if ($attribute->is_taxonomy()) {
            $values = wc_get_product_terms($product->get_id(), $attribute->get_name(), array('fields' => 'names'));
            return apply_filters('woocommerce_attribute', wptexturize(implode(', ', $values)), $attribute, $values);
        } else {
            $values = $attribute->get_options();
            return apply_filters('woocommerce_attribute', wptexturize(implode(', ', $values)), $attribute, $values);
        }
    }
    
    /**
     * Add content after technical specifications tab
     */
    public function add_technical_specifications_tab_content() {
        global $product;
        
        // Add product guarantee notice
        echo '<div class="novequip-guarantee-box">';
        echo '<h3>' . __('NovEquip Quality Guarantee', 'novequip-wc-extensions') . '</h3>';
        echo '<p>' . __('All our products come with a 2-year manufacturer warranty and 30-day money-back guarantee.', 'novequip-wc-extensions') . '</p>';
        echo '</div>';
    }
    
    /**
     * Add Quick View button
     */
    public function add_quick_view_button() {
        global $product;
        
        echo '<a href="#" class="button novequip-quick-view" data-product-id="' . esc_attr($product->get_id()) . '">' . __('Quick View', 'novequip-wc-extensions') . '</a>';
    }
    
    /**
     * Customize product sorting options
     */
    public function custom_sorting_options($options) {
        // Add custom sorting option
        $options['rating_desc'] = __('Sort by rating: high to low', 'novequip-wc-extensions');
        
        return $options;
    }
    
    /**
     * Apply custom catalog ordering
     */
    public function custom_catalog_ordering($args) {
        // Custom sorting based on the selected option
        if (isset($_GET['orderby'])) {
            if ('rating_desc' === $_GET['orderby']) {
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'DESC';
                $args['meta_key'] = '_wc_average_rating';
            }
        }
        
        return $args;
    }
    
    /**
     * Add notice to cart page
     */
    public function add_cart_notice() {
        // Get cart total
        $cart_total = WC()->cart->get_cart_contents_total();
        $free_shipping_threshold = $this->get_free_shipping_threshold();
        
        if ($free_shipping_threshold > 0 && $cart_total < $free_shipping_threshold) {
            $amount_needed = $free_shipping_threshold - $cart_total;
            
            echo '<div class="novequip-cart-notice">';
            echo '<p>' . sprintf(
                __('Add %s more to your cart to qualify for FREE shipping!', 'novequip-wc-extensions'),
                wc_price($amount_needed)
            ) . '</p>';
            echo '</div>';
        } else if ($free_shipping_threshold > 0 && $cart_total >= $free_shipping_threshold) {
            echo '<div class="novequip-cart-notice novequip-cart-notice-success">';
            echo '<p>' . __('Congratulations! You qualify for FREE shipping on this order!', 'novequip-wc-extensions') . '</p>';
            echo '</div>';
        }
    }
    
    /**
     * Add progress bar to cart page
     */
    public function add_progress_bar() {
        // Get cart total
        $cart_total = WC()->cart->get_cart_contents_total();
        $free_shipping_threshold = $this->get_free_shipping_threshold();
        
        if ($free_shipping_threshold > 0) {
            $percentage = min(100, ($cart_total / $free_shipping_threshold) * 100);
            
            echo '<div class="novequip-shipping-progress">';
            echo '<div class="novequip-shipping-progress-bar" style="width: ' . esc_attr($percentage) . '%"></div>';
            echo '<div class="novequip-shipping-progress-text">';
            
            if ($percentage < 100) {
                $amount_needed = $free_shipping_threshold - $cart_total;
                echo sprintf(
                    __('%s away from free shipping', 'novequip-wc-extensions'),
                    wc_price($amount_needed)
                );
            } else {
                echo __('Free shipping unlocked!', 'novequip-wc-extensions');
            }
            
            echo '</div>';
            echo '</div>';
        }
    }
    
    /**
     * Get free shipping threshold
     */
    private function get_free_shipping_threshold() {
        // Default value
        $threshold = 100;
        
        // Get threshold from settings
        $option = get_option('novequip_free_shipping_threshold', $threshold);
        
        return floatval($option);
    }
    
    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_submenu_page(
            'woocommerce',
            __('NovEquip Settings', 'novequip-wc-extensions'),
            __('NovEquip Settings', 'novequip-wc-extensions'),
            'manage_options',
            'novequip-settings',
            array($this, 'settings_page')
        );
    }
    
    /**
     * Register plugin settings
     */
    public function register_settings() {
        register_setting('novequip_settings', 'novequip_free_shipping_threshold', 'floatval');
        
        add_settings_section(
            'novequip_settings_section',
            __('NovEquip Store Settings', 'novequip-wc-extensions'),
            array($this, 'settings_section_callback'),
            'novequip_settings'
        );
        
        add_settings_field(
            'novequip_free_shipping_threshold',
            __('Free Shipping Threshold', 'novequip-wc-extensions'),
            array($this, 'free_shipping_threshold_callback'),
            'novequip_settings',
            'novequip_settings_section'
        );
    }
    
    /**
     * Settings section callback
     */
    public function settings_section_callback() {
        echo '<p>' . __('Configure settings for the NovEquip WooCommerce store.', 'novequip-wc-extensions') . '</p>';
    }
    
    /**
     * Free shipping threshold field callback
     */
    public function free_shipping_threshold_callback() {
        $value = get_option('novequip_free_shipping_threshold', 100);
        echo '<input type="number" min="0" step="0.01" name="novequip_free_shipping_threshold" value="' . esc_attr($value) . '" />';
        echo '<p class="description">' . __('Set the cart total required to qualify for free shipping.', 'novequip-wc-extensions') . '</p>';
    }
    
    /**
     * Settings page content
     */
    public function settings_page() {
        ?>
        <div class="wrap">
            <h1><?php echo esc_html__('NovEquip Store Settings', 'novequip-wc-extensions'); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('novequip_settings');
                do_settings_sections('novequip_settings');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }
}

// Initialize the plugin
$novequip_wc_extensions = new NovEquipWooCommerceExtensions();
