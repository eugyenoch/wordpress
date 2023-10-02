// Create Radio Buttons
add_action( 'woocommerce_review_order_before_payment', 'ecommercehints_checkout_radio_buttons' );
function ecommercehints_checkout_radio_buttons() {

   echo '<div id="donation" class="ecommercehints-donation">';
   echo '<h3>Leave a donation for a charity?</h3>';
   woocommerce_form_field( 'charity_choice', array(
   'type' => 'radio',
   'class' => array( 'form-row-wide', 'update_totals_on_change', 'donation-options' ),
   'options' => array(
      '0' => ' No Donation',
      'Charity 1' => ' Charity 1',
      'Charity 2' => ' Charity 2',
   ),
	   'default' => '0'
   ));
   echo '</div>';
}

// Add The Fixed Donation
add_action( 'woocommerce_cart_calculate_fees', 'ecommercehints_charity_choice_fee', 20, 1 );
function ecommercehints_charity_choice_fee( $cart ) {
   if ( is_admin() && ! defined( 'DOING_AJAX' ) ) return;
   $radio = WC()->session->get( 'charity_chosen' );
   if ( $radio ) {
      $cart->add_fee( $radio . ' donation', 5 );
   }
}

// Save Choice To Order
add_action( 'woocommerce_checkout_update_order_review', 'ecommercehints_save_charity_choice' );
function ecommercehints_save_charity_choice( $posted_data ) {
    parse_str( $posted_data, $output );
    if ( isset( $output['charity_choice'] ) ){
        WC()->session->set( 'charity_chosen', $output['charity_choice'] );
    }
}

// CSS Styling - you will need to tweak this based on your theme!
add_action( 'wp_footer', 'ecommercehints_checkout_donation_styling' );
function ecommercehints_checkout_donation_styling() { ?>
<style>
	label.radio {
		display:inline!important;
		margin-right:50px;
	}
	.ecommercehints-donation {
	padding: 30px 0;
	}
</style>
<?php }
