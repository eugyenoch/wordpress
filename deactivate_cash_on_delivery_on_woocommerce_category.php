add_filter( 'woocommerce_available_payment_gateways', 'ts_unset_gateway_by_category' );
  
function ts_unset_gateway_by_category( $available_gateways ) {
    if ( is_admin() ) return $available_gateways;
    if ( ! is_checkout() ) return $available_gateways;
    $unset = false;
    $category_id = 410; // TARGET CATEGORY
    foreach ( WC()->cart->get_cart_contents() as $key => $values ) {
        $terms = get_the_terms( $values['product_id'], 'product_cat' );    
        foreach ( $terms as $term ) {        
            if ( $term->term_id == $category_id ) {
                $unset = true; // CATEGORY IS IN THE CART
                break;
            }
        }
    }
    if ( $unset == true ) unset( $available_gateways['cod'] ); // DISABLE COD IF CATEGORY IS IN THE CART
    return $available_gateways;
}
