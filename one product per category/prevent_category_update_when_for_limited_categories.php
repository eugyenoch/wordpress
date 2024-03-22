<?php
/**
 * Prevent cart update for limited categories.
 */
function prevent_cart_update_for_limited_categories( $passed, $cart_item_key, $values, $quantity ) {
    // Define the categories where you want to limit the cart quantity
    $limited_categories = array( 123, 456 ); // Replace with your category IDs

    foreach ( $limited_categories as $category_id ) {
        $product_categories = get_term_ids( $values['data']->get_id(), 'product_cat' );
        if ( in_array( $category_id, $product_categories ) && $quantity > 1 ) {
            $passed = false;
            wc_add_notice( 'You can only have one item in the cart for this product category.', 'error' );
        }
    }

    return $passed;
}
add_filter( 'woocommerce_update_cart_validation', 'prevent_cart_update_for_limited_categories', 10, 4 );
?>
