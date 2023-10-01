/**
 * Snippet Name:	WooCommerce Checkout How Did You Hear About Us
 * Snippet Author:	ecommercehints.com
 */

// Create the custom select field in the billing section of the checkout form
add_action( 'woocommerce_after_checkout_billing_form', 'ecommercehints_checkout_select_field' );
function ecommercehints_checkout_select_field($checkout) {
woocommerce_form_field(
		'how_did_you_hear',
		array(
			'type'		=> 'select',
			'required'	=> true, // Shows an asterisk if true (*)
			'label'		=> 'How Did You Hear About Us?',
			'options'	=> array(
				''			=> 'Please select...',
				'word-of-mouth'		=> 'Word of mouth',
				'google-search'		=> 'Google Search',
				'social-media'		=> 'Social Media',
				'ecommercehints'	=> 'eCommerceHints.com'
			)
		),
		( isset($_POST['how_did_you_hear']) ? $_POST['how_did_you_hear'] : '' )
	);
}

// Show an error message of field is not populated
add_action('woocommerce_checkout_process', 'ecommercehints_custom_checkout_select_field_validation');
function ecommercehints_custom_checkout_select_field_validation() {
		if (empty( $_POST['how_did_you_hear'] ) ) {
			wc_add_notice( 'We would really like to know how you heard about us.', 'error' );
		}
}

// Save the custom field data as order meta
add_action( 'woocommerce_checkout_update_order_meta', 'ecommercehints_save_custom_checkout_select_field' );
function ecommercehints_save_custom_checkout_select_field( $order_id ){
	if( !empty( $_POST['how_did_you_hear'] ) ) {
		update_post_meta( $order_id, 'how_did_you_hear', sanitize_text_field( $_POST['how_did_you_hear'] ) );
	}
}
