//First, create the new table column between Date and Status columns
add_filter( 'woocommerce_my_account_my_orders_columns', 'ecommercehints_product_column_my_account_orders_table', 10, 1 );
function ecommercehints_product_column_my_account_orders_table( $columns ) {
    $product_column = [];
    foreach ( $columns as $key => $name ) {
        $product_column[ $key ] = $name;
        if ( 'order-date' === $key ) {
            $product_column['order-items'] = __( 'Product', 'woocommerce' );
        }
    }
    return $product_column;
}

//Second, insert the data from the order into the new column
add_action( 'woocommerce_my_account_my_orders_column_order-items', 'ecommercehints_get_product_data', 10, 1 );
function ecommercehints_get_product_data( $order ) {
    $details = array();
    foreach( $order->get_items() as $item ) {
		$product = $item->get_product();
		$product_permalink = get_permalink( $product->get_id() );
        $details[] = '<a href="' . $product_permalink . '">' . $item->get_name() . '<strong class="product-quantity">&nbsp;&times;&nbsp;' . $item->get_quantity() . '</strong>';
	}
    echo count( $details ) > 0 ? implode( '<br>', $details ) : '&ndash;';
}
