add_action( 'wp_head', 'ecommercehints_cart_total_based_banner' );
function ecommercehints_cart_total_based_banner() {
$order_total = WC()->cart->subtotal;
if ( $order_total > 2000 ) { // The threshold for the banner to appear ?>
<style>
	.ecommercehints_category_banner {
		background-color: blue;
		color: white;
		font-size:20px;
		text-align:center;
	}
</style>
<?php echo '<div class="ecommercehints_cart_total_based_banner">Your order is over 2K, you qualify for free shipping!</div>';
}
}
