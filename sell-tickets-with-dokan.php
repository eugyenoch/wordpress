<?php
/*
Plugin Name: Sell tickets with Dokan 
Plugin URI: https://iboora.com
Description: Sell tickets with Dokan. It is useful if you want to sell tickets for any kind of event or activity. For non-downloadable tickets, be sure to select the "virtual" option only. For downloadable tickets, select both the "virtual" and "downloadable" options, and for physical tickets, do not select either.
Version: 1.1.0
Author: Eugy Enoch
Author URI: https://github.com/eugyenoch
Textdomain: kadence
License: GPLv2
*/


// Append user-selected attributes and custom fields to the additional information tab on the product page
add_filter( 'woocommerce_product_tabs', 'append_user_selected_attributes_and_custom_fields_tab' );

function append_user_selected_attributes_and_custom_fields_tab( $tabs ) {
    global $product;

    // Get the selected attributes from product meta data
    $selected_attributes = get_post_meta( $product->get_id(), 'product_attributes', true );

    // Check if any attributes are selected
    if ( ! empty( $selected_attributes ) ) {
        // Create a new tab for the user-selected attributes
        $tabs['user_selected_attributes_and_custom_fields'] = array(
            'title'    => __( 'Additional Information', 'dokan' ),
            'priority' => 20,
            'callback' => 'display_user_selected_attributes_and_custom_fields_tab_content',
        );
    }

    return $tabs;
}

// Display user-selected attributes and custom fields tab content
function display_user_selected_attributes_and_custom_fields_tab_content() {
    global $product;

    // Get the selected attributes from product meta data
    $selected_attributes = get_post_meta( $product->get_id(), 'product_attributes', true );

    if ( ! empty( $selected_attributes ) ) {
        echo '<h2>' . esc_html__( 'Additional Information', 'dokan' ) . '</h2>';
        echo '<table class="woocommerce-product-attributes shop_attributes">';
        
        // Loop through selected attributes
        foreach ( $selected_attributes as $selected_attribute ) {
            list( $attribute_name, $attribute_value ) = explode( '|', $selected_attribute );
            echo '<tr class="woocommerce-product-attributes-item">';
            echo '<th class="woocommerce-product-attributes-item__label">' . esc_html( $attribute_name ) . '</th>';
            echo '<td class="woocommerce-product-attributes-item__value">' . esc_html( $attribute_value ) . '</td>';
            echo '</tr>';
        }

        // Display custom fields
        $event_date_start = get_post_meta( $product->get_id(), 'event_date_start', true );
        $event_date_end = get_post_meta( $product->get_id(), 'event_date_end', true );
        $event_time = get_post_meta( $product->get_id(), 'event_time', true );
        $event_actors = get_post_meta( $product->get_id(), 'event_actors', true );
        $event_location = get_post_meta( $product->get_id(), 'event_location', true );

        if ( ! empty( $event_date_start ) ) {
            echo '<tr class="woocommerce-product-attributes-item">';
            echo '<th class="woocommerce-product-attributes-item__label">' . esc_html__( 'Event Date (Start)', 'dokan-lite' ) . '</th>';
            echo '<td class="woocommerce-product-attributes-item__value">' . esc_html( $event_date_start ) . '</td>';
            echo '</tr>';
        }

        if ( ! empty( $event_date_end ) ) {
            echo '<tr class="woocommerce-product-attributes-item">';
            echo '<th class="woocommerce-product-attributes-item__label">' . esc_html__( 'Event Date (End)', 'dokan-lite' ) . '</th>';
            echo '<td class="woocommerce-product-attributes-item__value">' . esc_html( $event_date_end ) . '</td>';
            echo '</tr>';
        }

        if ( ! empty( $event_time ) ) {
            echo '<tr class="woocommerce-product-attributes-item">';
            echo '<th class="woocommerce-product-attributes-item__label">' . esc_html__( 'Event Time', 'dokan-lite' ) . '</th>';
            echo '<td class="woocommerce-product-attributes-item__value">' . esc_html( $event_time ) . '</td>';
            echo '</tr>';
        }

        if ( ! empty( $event_actors ) ) {
            echo '<tr class="woocommerce-product-attributes-item">';
            echo '<th class="woocommerce-product-attributes-item__label">' . esc_html__( 'Performers', 'dokan-lite' ) . '</th>';
            echo '<td class="woocommerce-product-attributes-item__value">' . esc_html( $event_actors ) . '</td>';
            echo '</tr>';
        }

        if ( ! empty( $event_location ) ) {
            echo '<tr class="woocommerce-product-attributes-item">';
            echo '<th class="woocommerce-product-attributes-item__label">' . esc_html__( 'Event Location', 'dokan-lite' ) . '</th>';
            echo '<td class="woocommerce-product-attributes-item__value">' . esc_html( $event_location ) . '</td>';
            echo '</tr>';
        }

        echo '</table>';
    }
}

?>
