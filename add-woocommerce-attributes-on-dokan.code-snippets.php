<?php

/**
 * Add woocommerce attributes on Dokan
 *
 * This code will fetch all the product attributes from WooCommerce and display them in a multi-select dropdown field on the Dokan product add/edit form. Vendors can then select the attributes they want for their products.
 */
// Add custom fields for product attributes to Dokan product add/edit form
add_action( 'dokan_new_product_after_product_tags', 'add_custom_attribute_field', 10 );
add_action( 'dokan_product_edit_after_product_tags', 'add_custom_attribute_field', 10 );

function add_custom_attribute_field() {
    global $post;
    $product_attributes = get_product_attributes();
    $selected_attributes = get_post_meta( $post->ID, 'product_attributes', true );

    if ( ! empty( $product_attributes ) ) {
        ?>
        <div class="dokan-form-group">
            <label for="product_attributes"><strong><?php esc_html_e( 'Select Product Attributes', 'kadence' ); ?></strong></label>
            <select name="product_attributes[]" id="product_attributes" multiple="multiple" class="dokan-form-control chosen_attributes" style="height: 100px;">
                <?php
                foreach ( $product_attributes as $attribute_name => $attribute_values ) {
                    echo '<optgroup label="' . esc_attr( $attribute_name ) . '">';
                    foreach ( $attribute_values as $value_id => $value_name ) {
                        $selected = in_array( $attribute_name . '|' . $value_name, $selected_attributes ) ? 'selected="selected"' : '';
                        echo '<option value="' . esc_attr( $attribute_name . '|' . $value_name ) . '" ' . $selected . '>' . esc_html( $value_name ) . '</option>';
                    }
                    echo '</optgroup>';
                }
                ?>
            </select>
            <?php
            if ( ! wp_is_mobile() ) {
                echo "Hold down control key to select multiple attributes at once";
            }
            ?>
        </div>
        <?php
    }
}

// Save custom fields for product attributes
add_action( 'dokan_new_product_added', 'save_custom_product_attributes_fields', 10, 2 );
add_action( 'dokan_product_updated', 'save_custom_product_attributes_fields', 10, 2 );

function save_custom_product_attributes_fields( $product_id, $postdata ) {
    if ( isset( $postdata['product_attributes'] ) && is_array( $postdata['product_attributes'] ) ) {
        update_post_meta( $product_id, 'product_attributes', $postdata['product_attributes'] );
    }
}

// Append user-selected attributes to the additional information tab on the product page
add_filter( 'woocommerce_product_tabs', 'append_user_selected_attributes_tab' );
function append_user_selected_attributes_tab( $tabs ) {
    global $product;

    // Get the selected attributes from product meta data
    $selected_attributes = get_post_meta( $product->get_id(), 'product_attributes', true );

    // Check if any attributes are selected
    if ( ! empty( $selected_attributes ) ) {
        // Create a new tab for the user-selected attributes
        $tabs['user_selected_attributes'] = array(
            'title'    => __( 'Additional Information', 'kadence' ),
            'priority' => 20,
            'callback' => 'display_user_selected_attributes_tab_content',
        );
    }

    return $tabs;
}

// Display user-selected attributes tab content
function display_user_selected_attributes_tab_content() {
    global $product;

    // Get the selected attributes from product meta data
    $selected_attributes = get_post_meta( $product->get_id(), 'product_attributes', true );

    if ( ! empty( $selected_attributes ) ) {
        echo '<h2>' . esc_html__( 'Additional Information', 'kadence' ) . '</h2>';
        echo '<table class="woocommerce-product-attributes shop_attributes">';
        foreach ( $selected_attributes as $selected_attribute ) {
            list( $attribute_name, $attribute_value ) = explode( '|', $selected_attribute );
            echo '<tr class="woocommerce-product-attributes-item">';
            echo '<th class="woocommerce-product-attributes-item__label">' . esc_html( $attribute_name ) . '</th>';
            echo '<td class="woocommerce-product-attributes-item__value">' . esc_html( $attribute_value ) . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }
}

/**
 * Fetch product attributes and their values
 *
 * @return array $product_attributes
 */
function get_product_attributes() {
    $product_attributes = array();
    $attribute_taxonomies = wc_get_attribute_taxonomies();

    if ( ! empty( $attribute_taxonomies ) ) {
        foreach ( $attribute_taxonomies as $attribute ) {
            $attribute_name = wc_attribute_taxonomy_name( $attribute->attribute_name );
            $attribute_terms = get_terms( $attribute_name, array( 'hide_empty' => false ) );

            if ( ! empty( $attribute_terms ) ) {
                $attribute_values = array();
                foreach ( $attribute_terms as $term ) {
                    $attribute_values[ $term->term_id ] = $term->name;
                }
                $product_attributes[ $attribute->attribute_label ] = $attribute_values;
            }
        }
    }

    return $product_attributes;
}
