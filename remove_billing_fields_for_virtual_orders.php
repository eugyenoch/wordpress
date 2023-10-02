add_filter( 'woocommerce_checkout_fields' , 'ecommercehints_remove_checkout_billing_fields_if_virtual_product' );
function ecommercehints_remove_checkout_billing_fields_if_virtual_product( $fields ) {

   $only_virtual_in_cart = true; // If there is a physical product too, don't remove the fields

   foreach( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {

      if ( ! $cart_item['data']->is_virtual() ) {
		  $only_virtual_in_cart = false;
	  }
   }
	if ($only_virtual_in_cart) {
		unset($fields['billing']['billing_company']);
		unset($fields['billing']['billing_address_1']);
		unset($fields['billing']['billing_address_2']);
		unset($fields['billing']['billing_city']);
		unset($fields['billing']['billing_postcode']);
		unset($fields['billing']['billing_country']);
		unset($fields['billing']['billing_state']);
		unset($fields['billing']['billing_phone']);
	}
     return $fields;
}
