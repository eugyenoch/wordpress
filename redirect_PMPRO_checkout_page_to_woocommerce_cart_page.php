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


/***********************************************************
//When there are multiple PMPRP user levels to woocommerce pages
function redirect_membership_checkout() {
    // Check if the user is accessing the specific membership level checkout
    if (isset($_GET['level'])) {
        // Map levels to corresponding product IDs
        $product_mapping = array(
            2 => 1300,
            3 => 1827,
            // Add more mappings if needed
        );

        // Check if the level is mapped to a product ID
        if (isset($product_mapping[$_GET['level']])) {
            // Add the product to the cart
            global $woocommerce;
            $product_id = $product_mapping[$_GET['level']];
            $quantity = 1;

            // Check if the product ID is valid
            if (wc_get_product($product_id)) {
                // Attempt to add the product to the cart
                $cart_result = $woocommerce->cart->add_to_cart($product_id, $quantity);

                // Check if adding to the cart was successful
                if (is_wp_error($cart_result)) {
                    // Handle error, for example, log it
                    error_log('Error adding product to cart: ' . $cart_result->get_error_message());
                } else {
                    // Redirect to the WooCommerce cart page
                    wp_redirect(wc_get_cart_url());
                    exit;
                }
            } else {
                // Handle invalid product ID error
                error_log('Invalid product ID: ' . $product_id);
            }
        }
    }
}

// Hook to perform the redirection
add_action('template_redirect', 'redirect_membership_checkout');
*********************************************************************/
