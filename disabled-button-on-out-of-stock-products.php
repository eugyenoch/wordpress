<?php
if (!function_exists('woocommerce_template_loop_add_to_cart')) {
    function woocommerce_template_loop_add_to_cart() {
        global $product;
        if (!$product->is_in_stock() || !$product->is_purchasable()) {
            // Display a disabled button for out-of-stock products
            echo '<button class="button disabled" disabled>Out of Stock</button>';
            return;
        }
        wc_get_template('loop/add-to-cart.php');
    }
}

?>
