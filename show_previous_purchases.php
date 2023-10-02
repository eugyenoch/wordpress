add_action( 'woocommerce_after_add_to_cart_form', 'ecommercehints_show_product_order_history', 10 );
function ecommercehints_show_product_order_history() {
	global $product, $post;
	echo '<strong>Previous Purchases</strong><br><ol>';
	$orders = get_posts( array(
		'numberposts' => -1,
		'meta_key'    => '_customer_user',
		'meta_value'  => get_current_user_id(),
		'post_type'   => 'shop_order',
		'post_status' => 'wc-completed'
	) );
	foreach ($orders as $order) {
		$order = new WC_Order( $order->ID );
		$order_data = $order->get_data();
		$order->get_date_completed();
		$public_view_order_url = esc_url( $order->get_view_order_url() );
		$items = $order->get_items();
		foreach( $items as $item ) {
			$product_id = $item['product_id'];
			$quantity = $item->get_quantity();
			if ( $post->ID == $product_id ) {
				echo '<li><a href="' . $public_view_order_url . '">' . $order_date . ' &times;</a>' . $quantity . '</li>';
			}
		}
	}
	echo '</ol></div>';
}
