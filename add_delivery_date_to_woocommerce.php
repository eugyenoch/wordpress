<?php
// Add delivery date field to the checkout
add_action("woocommerce_after_order_notes", "cwpai_add_delivery_date_field");
function cwpai_add_delivery_date_field($checkout)
{
    $min_date = date('Y-m-d', strtotime('+2 days')); // 2 days from today
    $max_date = date('Y-m-d', strtotime('+30 days')); // 7 days from today

    echo '<div id="cwpai_delivery_date_field"><h2>' . __("<br>Delivery Date") . "</h2>";
    woocommerce_form_field(
        "cwpai_delivery_date",
        [
            "type" => "date",
            "class" => ["cwpai-field-class form-row-wide"],
            "required" => true, // this field is mandatory
            "custom_attributes" => [
                'min' => $min_date,
                'max' => $max_date
            ],
        ],
        $checkout->get_value("cwpai_delivery_date")
    );
    echo "<small>Choose an expected delivery date if you want this order delivered to you on a later date. This feature is in test, and it is up to the seller to honour this request.</small><br></div>";
}

// Save delivery date to the order meta
add_action(
    "woocommerce_checkout_update_order_meta",
    "cwpai_save_delivery_date_to_order_meta"
);
function cwpai_save_delivery_date_to_order_meta($order_id)
{
    if (!empty($_POST["cwpai_delivery_date"])) {
        update_post_meta(
            $order_id,
            "cwpai_delivery_date",
            sanitize_text_field($_POST["cwpai_delivery_date"])
        );
    }
}

// Display delivery date in the custom column
add_action('woocommerce_admin_order_data_after_shipping_address', 'cwpai_my_orders_delivery_date_column');
function cwpai_my_orders_delivery_date_column($order)
{
    $delivery_date =  "<strong>Delivery Date:</strong><br>" . get_post_meta($order->get_id(), 'cwpai_delivery_date', true); // Get custom order meta
    echo !empty($delivery_date) ? $delivery_date : 'N/A';
}
?>
