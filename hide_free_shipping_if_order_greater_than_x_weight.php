<?php
/**
 * Hide free shipping when the order weight is more than (*)kgs.
 *
 * Make sure to update the snippet to change the "*" to a valid number.
 *
 * @param array $rates Array of rates found for the package.
 * @return array
 */
function ts_hide_free_shipping_for_order_weight( $rates, $package ) {
    $order_weight = WC()->cart->get_cart_contents_weight();
    if ( $order_weight > 10 ) {
        foreach( $rates as $rate_id => $rate_val ) {
            if ( 'free_shipping' === $rate_val->get_method_id() ) {
                unset( $rates[ $rate_id ] );
            }
        }
    }
    return $rates;
}
add_filter( 'woocommerce_package_rates', 'ts_hide_free_shipping_for_order_weight', 100, 2 );
?>
