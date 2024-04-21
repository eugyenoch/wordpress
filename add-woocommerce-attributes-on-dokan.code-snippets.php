<?php

/**
 * Add woocommerce attributes on Dokan
 *
 * This code will fetch all the product attributes from WooCommerce and display them in a multi-select dropdown field on the Dokan product add/edit form. Vendors can then select the attributes they want for their products.
 */
/**
 * Fetch product attributes and their values, and display multi-select field on Dokan product add/edit form
 */

/**
 * Add custom field to Dokan product add/edit form
 */
add_action( 'dokan_new_product_after_product_tags', 'add_custom_attribute_field', 10 );
add_action( 'dokan_product_edit_after_product_tags', 'add_custom_attribute_field', 10 );

function add_custom_attribute_field() {
    $product_attributes = get_product_attributes();

    if ( ! empty( $product_attributes ) ) {
        ?>
        <div class="dokan-form-group">
            <label for="product_attributes"><?php esc_html_e( 'Select Product Attributes', 'kadence' ); ?></label>
            <select name="product_attributes[]" id="product_attributes" multiple="multiple" class="dokan-form-control chosen_attributes" style="height: 100px;">
                <?php
                foreach ( $product_attributes as $attribute_name => $attribute_values ) {
                    echo '<optgroup label="' . esc_attr( $attribute_name ) . '">';
                    foreach ( $attribute_values as $value_id => $value_name ) {
                        echo '<option value="' . esc_attr( $attribute_name . '|' . $value_id ) . '">' . esc_html( $value_name ) . '</option>';
                    }
                    echo '</optgroup>';
                }
                ?>
            </select>
        </div>
        <?php
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
