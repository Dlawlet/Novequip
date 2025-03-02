/**
 * NovEquip WooCommerce Extensions - Frontend Scripts
 */
(function($) {
    'use strict';

    var NovEquipWC = {
        /**
         * Initialize scripts
         */
        init: function() {
            // Initialize quick view functionality
            this.initQuickView();
            
            // Initialize product image zoom
            this.initProductImageZoom();
            
            // Add product hover effects
            this.initProductHoverEffects();
            
            // Initialize quantity buttons
            this.initQuantityButtons();
        },
        
        /**
         * Initialize Quick View functionality
         */
        initQuickView: function() {
            // Create modal container if it doesn't exist
            if ($('.novequip-quick-view-modal').length === 0) {
                $('body').append('<div class="novequip-quick-view-modal"><div class="novequip-quick-view-content"><span class="novequip-quick-view-close">&times;</span><div class="novequip-quick-view-body"></div></div></div>');
            }
            
            // Quick view button click
            $(document).on('click', '.novequip-quick-view', function(e) {
                e.preventDefault();
                
                var productId = $(this).data('product-id');
                var $modal = $('.novequip-quick-view-modal');
                var $modalBody = $('.novequip-quick-view-body');
                
                // Show loading
                $modalBody.html('<p>Loading product information...</p>');
                $modal.show();
                
                // Mock Ajax call (would be implemented with real Ajax in production)
                setTimeout(function() {
                    // This would be replaced with actual AJAX call to get product data
                    // For demo purposes, we're just showing a simple product view
                    $modalBody.html(
                        '<div class="product-quick-view-container">' +
                        '   <div class="row">' +
                        '       <div class="col-6">' +
                        '           <img src="https://via.placeholder.com/400x400" alt="Product Image" class="quick-view-image">' +
                        '       </div>' +
                        '       <div class="col-6">' +
                        '           <h2>Product #' + productId + '</h2>' +
                        '           <div class="price">$99.99</div>' +
                        '           <div class="description"><p>This is a sample product description that would be loaded via AJAX.</p></div>' +
                        '           <form class="cart">' +
                        '               <div class="quantity">' +
                        '                   <input type="number" class="input-text qty text" step="1" min="1" max="" value="1" title="Qty" size="4">' +
                        '               </div>' +
                        '               <button type="submit" class="single_add_to_cart_button button alt">Add to cart</button>' +
                        '           </form>' +
                        '       </div>' +
                        '   </div>' +
                        '</div>'
                    );
                }, 500);
            });
            
            // Close modal when clicking X or outside the modal
            $(document).on('click', '.novequip-quick-view-close, .novequip-quick-view-modal', function(e) {
                if (e.target === this) {
                    $('.novequip-quick-view-modal').hide();
                }
            });
            
            // Prevent modal from closing when clicking inside content
            $(document).on('click', '.novequip-quick-view-content', function(e) {
                e.stopPropagation();
            });
        },
        
        /**
         * Initialize product image zoom
         */
        initProductImageZoom: function() {
            // Only on single product pages
            if (!$('.single-product').length) {
                return;
            }
            
            // Simple hover zoom effect (would be more sophisticated in production)
            $('.woocommerce-product-gallery__image').hover(
                function() {
                    $(this).css('transform', 'scale(1.05)');
                    $(this).css('transition', 'transform 0.3s ease');
                    $(this).css('z-index', '1');
                },
                function() {
                    $(this).css('transform', 'scale(1)');
                }
            );
        },
        
        /**
         * Add product hover effects
         */
        initProductHoverEffects: function() {
            // Add "New" badge to products
            // This would be more sophisticated in production, checking product publish date
            $('.products li').each(function(index) {
                // Demo - add to random products
                if (index % 7 === 0) {
                    $(this).append('<span class="novequip-badge novequip-badge-new">New</span>');
                }
                
                // Demo - add recommended badge to some products
                if (index % 5 === 0) {
                    $(this).append('<span class="novequip-badge">Recommended</span>');
                }
            });
        },
        
        /**
         * Add quantity increment/decrement buttons
         */
        initQuantityButtons: function() {
            // Ensure we only add the buttons once
            if ($('.novequip-qty-buttons').length) {
                return;
            }
            
            // Add increment/decrement buttons to quantity inputs
            $('div.quantity').each(function() {
                var $quantity = $(this);
                var $input = $quantity.find('input.qty');
                
                // Add buttons
                $input.before('<button type="button" class="novequip-qty-buttons minus">-</button>');
                $input.after('<button type="button" class="novequip-qty-buttons plus">+</button>');
                
                // Button click handlers
                $quantity.on('click', '.novequip-qty-buttons', function() {
                    var $button = $(this);
                    var oldVal = parseFloat($input.val());
                    var newVal = 0;
                    
                    if ($button.hasClass('plus')) {
                        newVal = oldVal + 1;
                    } else {
                        // Don't allow decrementing below 1
                        if (oldVal > 1) {
                            newVal = oldVal - 1;
                        } else {
                            newVal = 1;
                        }
                    }
                    
                    $input.val(newVal);
                    $input.trigger('change');
                });
            });
        }
    };
    
    // Initialize on document ready
    $(document).ready(function() {
        NovEquipWC.init();
    });
    
})(jQuery);
