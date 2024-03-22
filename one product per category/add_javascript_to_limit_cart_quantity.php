<?php
/**
 * Enqueue custom JavaScript to limit cart quantity per category.
 */
function limit_cart_quantity_script() {
    // Define the categories where you want to limit the cart quantity
    $limited_categories = array( 123, 456 ); // Replace with your category IDs

    // Enqueue the JavaScript file conditionally
    foreach ( $limited_categories as $category_id ) {
        if ( is_product_category( $category_id ) ) {
            wp_enqueue_script( 'limit-cart-quantity', get_stylesheet_directory_uri() . '/js/limit-cart-quantity.js', array( 'jquery' ), '1.0', true );
            wp_localize_script( 'limit-cart-quantity', 'limitCartQuantityData', array(
                'max_quantity' => 1, // Set the maximum allowed quantity
            ) );
            break;
        }
    }
}
add_action( 'wp_enqueue_scripts', 'limit_cart_quantity_script' );

?>
