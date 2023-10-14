function redirect_membership_checkout() {
    // Check if the user is accessing the specific membership level checkout
    if (isset($_GET['level']) && $_GET['level'] == 2) {
        // Add the product to the cart
        global $woocommerce;
        $product_id = 1300;
        $quantity = 1;
        $woocommerce->cart->add_to_cart($product_id, $quantity);

        // Redirect to the WooCommerce cart page
        wp_redirect(wc_get_cart_url());
        exit;
    }
}

// Hook to perform the redirection
add_action('template_redirect', 'redirect_membership_checkout');
