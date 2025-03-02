<?php
/**
 * NovEquip - WooCommerce Attribute Setup Script
 * 
 * This script creates product attributes and terms for filtering products
 * Run this script after WooCommerce activation from WordPress admin
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    define('WP_USE_THEMES', false);
    require_once dirname(__FILE__) . '/wp-config.php';
}

// Ensure WooCommerce is active
if (!function_exists('wc_get_attribute_taxonomies')) {
    echo "Error: WooCommerce must be activated before running this script.\n";
    exit;
}

// Function to create a product attribute if it doesn't exist
function create_product_attribute($attribute_name, $attribute_label, $attribute_type = 'select', $sort_order = 0) {
    global $wpdb;
    
    // Check if attribute already exists
    $attribute_taxonomies = wc_get_attribute_taxonomies();
    $attribute_name_slug = wc_sanitize_taxonomy_name($attribute_name);
    
    foreach ($attribute_taxonomies as $taxonomy) {
        if ($taxonomy->attribute_name === $attribute_name_slug) {
            echo "Attribute '$attribute_name' already exists. Skipping creation.\n";
            return wc_attribute_taxonomy_id_by_name($attribute_name_slug);
        }
    }
    
    // Insert the attribute
    $wpdb->insert(
        $wpdb->prefix . 'woocommerce_attribute_taxonomies',
        [
            'attribute_name'    => $attribute_name_slug,
            'attribute_label'   => $attribute_label,
            'attribute_type'    => $attribute_type,
            'attribute_orderby' => 'menu_order',
            'attribute_public'  => 0,
        ]
    );
    
    // Clear cached attribute taxonomies
    delete_transient('wc_attribute_taxonomies');
    
    $attribute_id = $wpdb->insert_id;
    
    echo "Created attribute: $attribute_label (ID: $attribute_id)\n";
    
    // Register the taxonomy for this session
    register_taxonomy(
        'pa_' . $attribute_name_slug,
        apply_filters('woocommerce_taxonomy_objects_pa_' . $attribute_name_slug, ['product']),
        apply_filters('woocommerce_taxonomy_args_pa_' . $attribute_name_slug, [
            'hierarchical' => true,
            'show_ui'      => false,
            'query_var'    => true,
            'rewrite'      => false,
        ])
    );
    
    return $attribute_id;
}

// Function to add terms to attribute
function add_attribute_terms($attribute_name, $terms) {
    $taxonomy = 'pa_' . wc_sanitize_taxonomy_name($attribute_name);
    
    // Ensure the taxonomy is registered
    if (!taxonomy_exists($taxonomy)) {
        echo "Error: Taxonomy $taxonomy does not exist. Ensure the attribute is created first.\n";
        return false;
    }
    
    $added_terms = [];
    
    foreach ($terms as $term) {
        if (!term_exists($term, $taxonomy)) {
            $result = wp_insert_term($term, $taxonomy);
            if (is_wp_error($result)) {
                echo "Error adding term '$term' to $taxonomy: " . $result->get_error_message() . "\n";
            } else {
                $added_terms[] = $term;
                echo "Added term '$term' to $taxonomy\n";
            }
        } else {
            echo "Term '$term' already exists in $taxonomy. Skipping.\n";
        }
    }
    
    return $added_terms;
}

// Start setup
echo "Starting WooCommerce attribute setup...\n\n";

// Define attributes to create with their terms
$attributes = [
    [
        'name'  => 'color',
        'label' => 'Color',
        'type'  => 'color',
        'terms' => ['Black', 'Blue', 'Red', 'Green', 'Yellow', 'White', 'Orange', 'Silver', 'Grey']
    ],
    [
        'name'  => 'size',
        'label' => 'Size',
        'type'  => 'select',
        'terms' => ['Small', 'Medium', 'Large', 'X-Large', 'XX-Large']
    ],
    [
        'name'  => 'material',
        'label' => 'Material',
        'type'  => 'select',
        'terms' => ['Steel', 'Aluminum', 'Plastic', 'Carbon Fiber', 'Titanium', 'Chrome Vanadium', 'Rubber', 'Leather', 'Kevlar']
    ],
    [
        'name'  => 'power',
        'label' => 'Power',
        'type'  => 'select',
        'terms' => ['12V', '18V', '20V', '24V', '110V', '220V', '1000W', '1200W', '1500W', '1800W', '2000W']
    ],
    [
        'name'  => 'certification',
        'label' => 'Certification',
        'type'  => 'select',
        'terms' => ['CE', 'ANSI', 'ISO', 'OSHA', 'UL', 'CSA', 'ANSI Z89.1', 'EN166', 'EN388']
    ],
];

// Create each attribute and its terms
foreach ($attributes as $attribute) {
    $attribute_id = create_product_attribute(
        $attribute['name'],
        $attribute['label'],
        $attribute['type']
    );
    
    if ($attribute_id) {
        add_attribute_terms($attribute['name'], $attribute['terms']);
        echo "\n";
    }
}

// Flush rewrite rules after creating attributes
flush_rewrite_rules();

echo "WooCommerce attribute setup complete!\n";
echo "You can now use these attributes when editing products.\n";
