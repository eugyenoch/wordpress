add_filter( 'yith_wcaf_affiliate_rate', 'custom_yith_aff_commission_rate', 99, 3 );

function custom_yith_aff_commission_rate( $rate, $affiliate_id, $context ) {
    // Get the global WC Cart
    global $woocommerce;
    
    // Iterate through each cart item
    foreach($woocommerce->cart->cart_contents as $cart_item_key => $cart_item) {
        
        // Get the product ID
        $product_id = $cart_item['product_id'];
        
        // Set the commission rate based on the product ID
        switch($product_id) {
            case 1300:
                $rate = 40; // 50% commission
                break;
            case 1827:
                $rate = 40; // 20% commission
                break;
            case 3519:
                $rate = 40; // 35% commission
                break;
        }
    }
    
    // Return the commission rate
    return $rate;
}
