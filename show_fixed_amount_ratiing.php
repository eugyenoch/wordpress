// Simple Products
add_filter( 'woocommerce_get_price_html', 'ecommercehints_display_fixed_amount_savings_on_sale_simple_products', 10, 2 );
function ecommercehints_display_fixed_amount_savings_on_sale_simple_products( $price, $product ) {
    if ( $product->is_on_sale() && $product->is_type( 'simple' ) ) {
        $regular_price = $product->get_regular_price();
        $sale_price = $product->get_sale_price();
		$savings = $regular_price - $sale_price;
        $price .= '<br><small>You save ' . wc_price($savings) . '!</small>';
	}
    return $price;
}

// Variations (appears once variations have been selected)
add_filter( 'woocommerce_available_variation', 'ecommercehints_display_fixed_amount_savings_on_sale_variable_products', 10, 3 );
function ecommercehints_display_fixed_amount_savings_on_sale_variable_products( $data, $product, $variation ) {
    if( $variation->is_on_sale() ) {
        $savings_amount = $data['display_regular_price'] - $data['display_price'];
        $data['price_html'] .= 'You save' . wc_price($savings_amount);
    }
    return $data;
}
