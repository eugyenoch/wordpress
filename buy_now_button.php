add_action ('woocommerce_after_add_to_cart_form', 'ecommercehints_buy_now', 10, 0);
function ecommercehints_buy_now() {
	global $product;
	if ( ! $product->is_type( 'simple' ) ) return; // Only show on simple products
	echo '<a href="/checkout?add-to-cart='.$product->get_ID().'" class="button">Buy Now</a>';
};
