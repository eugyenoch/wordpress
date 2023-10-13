/*
*Original author: https://wordpress.org/support/users/iovamihai/
*/
function slicewp_custom_add_afflink() {
	
	if ( is_user_logged_in() && slicewp_is_affiliate_active( slicewp_get_current_affiliate_id() ) ) {
		
		$referal_link = slicewp_get_affiliate_url( slicewp_get_current_affiliate_id(), get_permalink() );
		
		echo '<br>Product Affiliate link:&nbsp;<input type="text" style="display: block; border: transparent; max-width: 100%; margin-top: 10px;" value="' . esc_url( $referal_link ) . '"/>';
		
	}
	
}
add_action( 'woocommerce_after_add_to_cart_button', 'slicewp_custom_add_afflink', 99 );
