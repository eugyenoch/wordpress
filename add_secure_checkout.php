function secure_icon_text_after_cart_totals(  ) {
    echo '<div id="cart-trust-symbols"><i class="fas fa-lock"></i> Secure Checkout</div>';
};
add_action( 'woocommerce_after_cart_totals', 'secure_icon_text_after_cart_totals', 10, 0 );


/**
*ADD THE BELOW CODE AFTER THE PREVIOS
add_action( 'wp_head', function () {
if (is_cart()) { ?>
<style>
#cart-trust-symbols {
color:green;
text-align:center;
}
</style>
<?php } } );
*/
