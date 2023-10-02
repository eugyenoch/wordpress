add_filter( 'woocommerce_get_price_html', 'ecommercehints_display_sale_price_dates', 100, 2 );
function ecommercehints_display_sale_price_dates( $price, $product ) {
    $sales_price_from = get_post_meta( $product->id, '_sale_price_dates_from', true );
    $sales_price_to   = get_post_meta( $product->id, '_sale_price_dates_to', true );
    if ( is_product() && $product->is_on_sale() && $sales_price_to != "" ) {
        $sales_price_date_from = date( "l jS F", $sales_price_from );
        $sales_price_date_to   = date( "l jS F", $sales_price_to );
        $price .= "<br><small>Sale from " . $sales_price_date_from . ' to ' . $sales_price_date_to . "</small>";
	}
    return $price;
}
