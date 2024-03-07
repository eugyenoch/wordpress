add_filter('woocommerce_get_availability', 'wcs_custom_get_availability', 1, 2);

function wcs_custom_get_availability($availability, $_product) {
    // Change In Stock Text
    if ($_product->is_in_stock()) {
        $availability['availability'] = sprintf('<strong style="font-size: 1.2em;">%s</strong>', __('Available', 'woocommerce'));
    }

    // Change Out of Stock Text
    if (!$_product->is_in_stock()) {
        $availability['availability'] = sprintf('<strong style="font-size: 1.2em;">%s</strong>', __('Sold Out', 'woocommerce'));
    }

    return $availability;
}
