<?php
/**
 * Plugin Name: NovEquip Fixes
 * Description: Fixes common WordPress issues including output buffering problems
 * Version: 1.0.0
 * Author: NovEquip Team
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Fix for ob_end_flush() error with WPForms
 * This works by ensuring we don't attempt to flush a buffer that's already been closed
 */
function novequip_fix_ob_end_flush() {
    // Only target WPForms related pages
    if (!isset($_GET['page']) || strpos($_GET['page'], 'wpforms') === false) {
        return;
    }
    
    // Check if output buffering is active
    if (ob_get_level() > 0) {
        // We have an open buffer, so we can safely end it
        @ob_end_flush();
    }
}
add_action('admin_init', 'novequip_fix_ob_end_flush', 1);

/**
 * Fix the buffer handling in WordPress core
 * Replace the problematic function with a safer version
 */
function novequip_fix_wp_ob_end_flush_all() {
    // Remove the original function and add our safer version
    remove_action('shutdown', 'wp_ob_end_flush_all', 1);
    add_action('shutdown', 'novequip_safe_ob_end_flush_all', 1);
}
add_action('plugins_loaded', 'novequip_fix_wp_ob_end_flush_all');

/**
 * Safer version of wp_ob_end_flush_all() that checks buffer status
 */
function novequip_safe_ob_end_flush_all() {
    $levels = ob_get_level();
    
    // Only attempt to flush if we actually have open buffers
    for ($i = 0; $i < $levels; $i++) {
        @ob_end_flush();
    }
}
