<?php
/**
 * Homepage Setup Script for NovEquip
 * 
 * This script creates a homepage with essential e-commerce sections:
 * - Hero section with featured products
 * - Product categories
 * - Latest products
 * - Promotions section
 * - Testimonials
 * - Newsletter signup
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Create the homepage if it doesn't exist
function novequip_create_homepage() {
    $homepage_id = get_option('page_on_front');
    $homepage = get_post($homepage_id);
    
    // If homepage doesn't exist or isn't set as front page
    if (!$homepage || get_option('show_on_front') != 'page') {
        // Create the homepage
        $homepage_id = wp_insert_post(array(
            'post_title'     => 'Home',
            'post_content'   => '<!-- wp:cover {"url":"https://via.placeholder.com/1920x600/f5f5f5/333333","id":999999,"dimRatio":50,"overlayColor":"primary","align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","right":"var:preset|spacing|40","bottom":"var:preset|spacing|80","left":"var:preset|spacing|40"}}}} -->
<div class="wp-block-cover alignfull" style="padding-top:var(--wp--preset--spacing--80);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--80);padding-left:var(--wp--preset--spacing--40)"><span aria-hidden="true" class="wp-block-cover__background has-primary-background-color has-background-dim"></span><img class="wp-block-cover__image-background wp-image-999999" alt="" src="https://via.placeholder.com/1920x600/f5f5f5/333333" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"center","level":1,"style":{"typography":{"fontStyle":"normal","fontWeight":"700"}}} -->
<h1 class="has-text-align-center" style="font-style:normal;font-weight:700">Professional Equipment for Every Project</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">High-quality tools and equipment for professionals and hobbyists</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/shop">Shop Now</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="/about">Learn More</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div></div>
<!-- /wp:cover -->

<!-- wp:heading {"textAlign":"center","style":{"spacing":{"margin":{"top":"var:preset|spacing|70"}}}} -->
<h2 class="has-text-align-center" style="margin-top:var(--wp--preset--spacing--70)">Featured Categories</h2>
<!-- /wp:heading -->

<!-- wp:woocommerce/product-categories {"columns":4,"align":"wide"} /-->

<!-- wp:heading {"textAlign":"center","style":{"spacing":{"margin":{"top":"var:preset|spacing|70"}}}} -->
<h2 class="has-text-align-center" style="margin-top:var(--wp--preset--spacing--70)">Latest Products</h2>
<!-- /wp:heading -->

<!-- wp:woocommerce/product-new {"columns":4,"rows":1,"align":"wide"} /-->

<!-- wp:columns {"align":"wide","style":{"spacing":{"margin":{"top":"var:preset|spacing|70"},"blockGap":"var:preset|spacing|40"}}} -->
<div class="wp-block-columns alignwide" style="margin-top:var(--wp--preset--spacing--70)"><!-- wp:column {"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","right":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50"}},"border":{"width":"1px"}},"borderColor":"secondary"} -->
<div class="wp-block-column has-border-color has-secondary-border-color" style="border-width:1px;padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)"><!-- wp:heading {"textAlign":"center","level":3} -->
<h3 class="has-text-align-center">Free Shipping</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">On orders over $100</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","right":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50"}},"border":{"width":"1px"}},"borderColor":"secondary"} -->
<div class="wp-block-column has-border-color has-secondary-border-color" style="border-width:1px;padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)"><!-- wp:heading {"textAlign":"center","level":3} -->
<h3 class="has-text-align-center">30-Day Returns</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Hassle-free returns policy</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","right":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50"}},"border":{"width":"1px"}},"borderColor":"secondary"} -->
<div class="wp-block-column has-border-color has-secondary-border-color" style="border-width:1px;padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)"><!-- wp:heading {"textAlign":"center","level":3} -->
<h3 class="has-text-align-center">Secure Payment</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">100% secure checkout</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:group {"align":"full","style":{"spacing":{"margin":{"top":"var:preset|spacing|70"}},"elements":{"link":{"color":{"text":"var:preset|color|background"}}}},"backgroundColor":"secondary","textColor":"background"} -->
<div class="wp-block-group alignfull has-background-color has-secondary-background-color has-text-color has-background has-link-color" style="margin-top:var(--wp--preset--spacing--70)"><!-- wp:heading {"textAlign":"center","style":{"spacing":{"margin":{"top":"var:preset|spacing|60"}}}} -->
<h2 class="has-text-align-center" style="margin-top:var(--wp--preset--spacing--60)">Subscribe to Our Newsletter</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Get the latest updates, offers and special announcements.</p>
<!-- /wp:paragraph -->

<!-- wp:html -->
<form class="wp-block-newsletter-form" style="display: flex; justify-content: center; margin-bottom: 3rem; padding: 0 1rem;">
  <input type="email" placeholder="Your Email Address" style="min-width: 300px; padding: 10px; border: none;">
  <button type="submit" style="background-color: #333; color: white; border: none; padding: 10px 20px; cursor: pointer;">Subscribe</button>
</form>
<!-- /wp:html --></div>
<!-- /wp:group -->',
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'comment_status' => 'closed',
            'ping_status'    => 'closed',
        ));

        // Set the homepage as the front page
        update_option('show_on_front', 'page');
        update_option('page_on_front', $homepage_id);
        
        // Create a blog page if it doesn't exist
        $blog_page_id = get_option('page_for_posts');
        if (!$blog_page_id) {
            $blog_page_id = wp_insert_post(array(
                'post_title'     => 'Blog',
                'post_content'   => '',
                'post_status'    => 'publish',
                'post_type'      => 'page',
                'comment_status' => 'closed',
                'ping_status'    => 'closed',
            ));
            update_option('page_for_posts', $blog_page_id);
        }
        
        return true;
    }
    
    return false;
}

// Create sample product categories
function novequip_create_product_categories() {
    $categories = array(
        'Power Tools' => array(
            'slug' => 'power-tools',
            'description' => 'High-performance power tools for professionals',
        ),
        'Hand Tools' => array(
            'slug' => 'hand-tools',
            'description' => 'Quality hand tools for precision work',
        ),
        'Safety Equipment' => array(
            'slug' => 'safety-equipment',
            'description' => 'Essential safety gear for workplace protection',
        ),
        'Measuring Tools' => array(
            'slug' => 'measuring-tools',
            'description' => 'Precise measuring instruments for accurate results',
        ),
    );
    
    foreach ($categories as $name => $args) {
        if (!term_exists($name, 'product_cat')) {
            wp_insert_term($name, 'product_cat', array(
                'slug' => $args['slug'],
                'description' => $args['description'],
            ));
        }
    }
}

// Configure basic WooCommerce settings
function novequip_configure_woocommerce() {
    // Set currency
    update_option('woocommerce_currency', 'USD');
    
    // Enable tax calculations
    update_option('woocommerce_calc_taxes', 'yes');
    
    // Set default customer location
    update_option('woocommerce_default_customer_address', 'geolocation');
    
    // Enable reviews
    update_option('woocommerce_enable_reviews', 'yes');
    
    // Enable ratings on reviews
    update_option('woocommerce_enable_review_rating', 'yes');
    
    // Set product image sizes
    update_option('woocommerce_single_image_width', 600);
    update_option('woocommerce_thumbnail_image_width', 300);
    
    // Set the shop page
    $shop_page_id = wc_get_page_id('shop');
    if ($shop_page_id > 0) {
        // Update shop page title
        wp_update_post(array(
            'ID' => $shop_page_id,
            'post_title' => 'Equipment Store',
        ));
    }
}

// Create menu structure
function novequip_create_menus() {
    // Create Primary Menu
    $menu_name = 'Main Navigation';
    $menu_exists = wp_get_nav_menu_object($menu_name);
    
    if (!$menu_exists) {
        $menu_id = wp_create_nav_menu($menu_name);
        
        // Set up menu items
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => 'Home',
            'menu-item-url' => home_url('/'),
            'menu-item-status' => 'publish',
            'menu-item-type' => 'custom',
        ));
        
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => 'Shop',
            'menu-item-url' => get_permalink(wc_get_page_id('shop')),
            'menu-item-status' => 'publish',
            'menu-item-type' => 'custom',
        ));
        
        // Add product categories as submenu items
        $categories = get_terms(array(
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
        ));
        
        if (!is_wp_error($categories)) {
            $parent_id = wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title' => 'Categories',
                'menu-item-url' => '#',
                'menu-item-status' => 'publish',
                'menu-item-type' => 'custom',
            ));
            
            foreach ($categories as $category) {
                wp_update_nav_menu_item($menu_id, 0, array(
                    'menu-item-title' => $category->name,
                    'menu-item-url' => get_term_link($category),
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'custom',
                    'menu-item-parent-id' => $parent_id,
                ));
            }
        }
        
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => 'About',
            'menu-item-url' => home_url('/about'),
            'menu-item-status' => 'publish',
            'menu-item-type' => 'custom',
        ));
        
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => 'Contact',
            'menu-item-url' => home_url('/contact'),
            'menu-item-status' => 'publish',
            'menu-item-type' => 'custom',
        ));
        
        // Set menu location
        $locations = get_theme_mod('nav_menu_locations');
        $locations['main-menu'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }
}

// Run the setup functions when this file is included
function novequip_run_setup() {
    novequip_create_homepage();
    novequip_create_product_categories();
    novequip_configure_woocommerce();
    novequip_create_menus();
}
