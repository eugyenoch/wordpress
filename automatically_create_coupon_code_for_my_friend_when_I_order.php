add_action( 'woocommerce_thankyou', 'ecommercehints_create_referral_coupon_code_automatically_after_purchase' );
function ecommercehints_create_referral_coupon_code_automatically_after_purchase($order_id) {

    $order = wc_get_order( $order_id );

    $billing_first_name = $order->get_billing_first_name();
    $coupon = new WC_Coupon();
    $coupon->set_code( $billing_first_name . '20' ); // Coupon code
    $coupon->set_amount( 20 ); // Discount amount
    $coupon->set_discount_type( 'percent' );

    $coupon->save();

    echo 'Refer a friend with coupon code: ' . $billing_first_name . '20 and they\'ll get 20% off their order';
}
