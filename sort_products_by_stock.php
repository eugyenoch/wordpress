add_filter('woocommerce_catalog_orderby', 'ecommercehints_sort_products_by_stock');
function ecommercehints_sort_products_by_stock($options) {
	$options['in-stock'] = 'Show in stock products first';
	return $options;

}

add_filter('woocommerce_get_catalog_ordering_args', 'ecommercehints_sort_products_by_stock_order');
function ecommercehints_sort_products_by_stock_order($args) {
	if( isset( $_GET['orderby'] ) && 'in-stock' === $_GET['orderby'] ) {
		$args['meta_key'] = '_stock_status';
		$args['orderby'] = array( 'meta_value' => 'ASC' ); // Show products in stock first. Change 'ASC' to 'DESC' to show out of stock products first.
	}
	return $args;
}
