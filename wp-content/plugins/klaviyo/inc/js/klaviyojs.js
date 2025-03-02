/**
 * Klaviyo core JavaScript functionality
 * This file resolves the missing dependency for kl-identify-browser.js
 */

var klaviyo = klaviyo || {};

(function() {
    'use strict';
    
    // Core Klaviyo functionality
    klaviyo = {
        // Initialize the Klaviyo functionality
        init: function() {
            // Setup event listeners and initialize components
            this.setupEventListeners();
        },
        
        // Set up event listeners for Klaviyo tracking
        setupEventListeners: function() {
            if (typeof jQuery !== 'undefined') {
                jQuery(document).ready(function($) {
                    // Track product views
                    if ($('.product').length) {
                        klaviyo.trackProductView();
                    }
                    
                    // Track add to cart events
                    $(document.body).on('added_to_cart', function(event, fragments, cart_hash, $button) {
                        klaviyo.trackAddToCart($button);
                    });
                });
            }
        },
        
        // Track product view events
        trackProductView: function() {
            if (typeof _learnq !== 'undefined' && typeof wc_klaviyo_product_data !== 'undefined') {
                var product = wc_klaviyo_product_data;
                if (product) {
                    _learnq.push(['track', 'Viewed Product', product]);
                }
            }
        },
        
        // Track add to cart events
        trackAddToCart: function($button) {
            if (typeof _learnq !== 'undefined' && typeof wc_klaviyo_add_to_cart_data !== 'undefined') {
                var cartData = wc_klaviyo_add_to_cart_data;
                if (cartData) {
                    _learnq.push(['track', 'Added to Cart', cartData]);
                }
            }
        },
        
        // Identify a user
        identifyUser: function(userData) {
            if (typeof _learnq !== 'undefined' && userData && userData.email) {
                _learnq.push(['identify', userData]);
            }
        }
    };
    
    // Initialize Klaviyo
    if (document.readyState === 'complete' || document.readyState !== 'loading') {
        klaviyo.init();
    } else {
        document.addEventListener('DOMContentLoaded', klaviyo.init);
    }
})();
