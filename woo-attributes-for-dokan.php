<?php
/*
Plugin Name: Woo Attributes For Dokan 
Plugin URI: https://web.iboora.com
Description: This plugin adds custom attribute selection functionality to Dokan vendor product forms and displays those attributes on the frontend product pages.
Version: 1.0.9
Author: Iboora Web Services
Author URI: https://web.iboora.com
Textdomain: kadence
License: GPLv2
*/

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Add custom fields for product attributes to Dokan product add/edit form
add_action( 'dokan_new_product_after_product_tags', 'add_custom_attribute_field', 10 );
add_action( 'dokan_product_edit_after_product_tags', 'add_custom_attribute_field', 10 );

function add_custom_attribute_field() {
    global $post;
    
    $product_attributes = get_custom_product_attributes();
    $selected_attributes = array();
    
    // Get previously selected attributes for edit form
    if ( isset( $post->ID ) ) {
        $selected_attributes = get_post_meta( $post->ID, 'custom_product_attributes', true );
        if ( ! is_array( $selected_attributes ) ) {
            $selected_attributes = array();
        }
    }

    if ( ! empty( $product_attributes ) ) {
        ?>
        <div class="dokan-form-group">
            <label for="custom_product_attributes"><strong><?php esc_html_e( 'Select Product Attributes', 'dokan' ); ?></strong></label>
            <select name="custom_product_attributes[]" id="custom_product_attributes" multiple="multiple" class="dokan-form-control" style="height: 100px;">
                <?php
                foreach ( $product_attributes as $attribute_name => $attribute_values ) {
                    echo '<optgroup label="' . esc_attr( $attribute_name ) . '">';
                    foreach ( $attribute_values as $value_id => $value_name ) {
                        $option_value = $attribute_name . '|' . $value_name;
                        $selected = in_array( $option_value, $selected_attributes ) ? 'selected="selected"' : '';
                        echo '<option value="' . esc_attr( $option_value ) . '" ' . $selected . '>' . esc_html( $value_name ) . '</option>';
                    }
                    echo '</optgroup>';
                }
                ?>
            </select>
            <?php
            if ( ! wp_is_mobile() ) {
                echo '<small class="form-text text-muted">' . esc_html__( 'Hold down Ctrl key to select multiple attributes', 'dokan' ) . '</small>';
            }
            ?>
        </div>
        
        <!-- Option to hide default WooCommerce additional information tab -->
        <div class="dokan-form-group" style="margin-bottom: 20px !important;">
            <label class="dokan-w3 dokan-control-label">
                <?php esc_html_e( 'Tab Settings', 'dokan' ); ?>
            </label>
            <div class="dokan-w5 dokan-text-left">
                <label>
                    <?php
                    $hide_default_tab = '';
                    if ( isset( $post->ID ) ) {
                        $hide_default_tab = get_post_meta( $post->ID, '_hide_default_additional_info_tab', true );
                    }
                    ?>
                    <input type="checkbox" name="hide_default_additional_info_tab" value="yes" <?php checked( $hide_default_tab, 'yes' ); ?>>
                    <?php esc_html_e( 'Hide default Additional Information tab', 'dokan' ); ?>
                </label>
                <br>
                <small class="form-text text-muted"><?php esc_html_e( 'Check this to prevent tab duplication', 'dokan' ); ?></small>
            </div>
            <br>
        </div>
        <br>
        <?php
    }
}

// Save custom fields for product attributes with validation
add_action( 'dokan_new_product_added', 'save_custom_product_attributes_fields', 10, 2 );
add_action( 'dokan_product_updated', 'save_custom_product_attributes_fields', 10, 2 );

function save_custom_product_attributes_fields( $product_id, $postdata ) {
    $validated_attributes = array();
    
    // Validate and save product attributes
    if ( isset( $postdata['custom_product_attributes'] ) && is_array( $postdata['custom_product_attributes'] ) ) {
        $available_attributes = get_custom_product_attributes();
        
        foreach ( $postdata['custom_product_attributes'] as $selected_attribute ) {
            if ( validate_selected_custom_attribute( $selected_attribute, $available_attributes ) ) {
                $validated_attributes[] = sanitize_text_field( $selected_attribute );
            }
        }
        
        update_post_meta( $product_id, 'custom_product_attributes', $validated_attributes );
    } else {
        // Clear attributes if none selected
        delete_post_meta( $product_id, 'custom_product_attributes' );
    }
    
    // Save tab visibility setting
    $hide_default_tab = isset( $postdata['hide_default_additional_info_tab'] ) ? 'yes' : 'no';
    update_post_meta( $product_id, '_hide_default_additional_info_tab', $hide_default_tab );
}

/**
 * Validate if a selected attribute still exists in the system
 */
function validate_selected_custom_attribute( $selected_attribute, $available_attributes ) {
    if ( empty( $selected_attribute ) || strpos( $selected_attribute, '|' ) === false ) {
        return false;
    }
    
    $parts = explode( '|', $selected_attribute, 2 );
    if ( count( $parts ) !== 2 ) {
        return false;
    }
    
    list( $attribute_name, $attribute_value ) = $parts;
    
    // Check if attribute name exists
    if ( ! isset( $available_attributes[ $attribute_name ] ) ) {
        return false;
    }
    
    // Check if attribute value exists
    return in_array( $attribute_value, $available_attributes[ $attribute_name ] );
}

// Conditionally hide the default WooCommerce additional information tab
add_filter( 'woocommerce_product_tabs', 'maybe_hide_default_additional_info_tab', 5 );
function maybe_hide_default_additional_info_tab( $tabs ) {
    global $product;
    
    if ( ! $product ) {
        return $tabs;
    }
    
    $hide_default_tab = get_post_meta( $product->get_id(), '_hide_default_additional_info_tab', true );
    
    if ( $hide_default_tab === 'yes' ) {
        unset( $tabs['additional_information'] );
    }
    
    return $tabs;
}

// Append user-selected attributes to a custom tab on the product page
add_filter( 'woocommerce_product_tabs', 'append_user_selected_attributes_tab', 10 );
function append_user_selected_attributes_tab( $tabs ) {
    global $product;

    if ( ! $product ) {
        return $tabs;
    }

    // Get the selected attributes from product meta data
    $selected_attributes = get_post_meta( $product->get_id(), 'custom_product_attributes', true );

    // Check if any attributes are selected
    if ( ! empty( $selected_attributes ) && is_array( $selected_attributes ) ) {
        // Validate attributes still exist and filter out invalid ones
        $valid_attributes = validate_and_filter_custom_attributes( $selected_attributes );
        
        if ( ! empty( $valid_attributes ) ) {
            // Create a new tab for the user-selected attributes
            $tabs['user_selected_attributes'] = array(
                'title'    => __( 'Product Specifications', 'dokan' ),
                'priority' => 20,
                'callback' => 'display_user_selected_attributes_tab_content',
            );
        }
    }

    return $tabs;
}

// Display user-selected attributes tab content with error handling
function display_user_selected_attributes_tab_content() {
    global $product;

    if ( ! $product ) {
        return;
    }

    // Get the selected attributes from product meta data
    $selected_attributes = get_post_meta( $product->get_id(), 'custom_product_attributes', true );

    if ( ! empty( $selected_attributes ) && is_array( $selected_attributes ) ) {
        // Validate and filter attributes
        $valid_attributes = validate_and_filter_custom_attributes( $selected_attributes );
        
        if ( ! empty( $valid_attributes ) ) {
            echo '<h2>' . esc_html__( 'Product Specifications', 'dokan' ) . '</h2>';
            echo '<table class="woocommerce-product-attributes shop_attributes">';
            
            foreach ( $valid_attributes as $valid_attribute ) {
                // Additional safety check
                if ( strpos( $valid_attribute, '|' ) !== false ) {
                    $parts = explode( '|', $valid_attribute, 2 );
                    if ( count( $parts ) === 2 ) {
                        list( $attribute_name, $attribute_value ) = $parts;
                        echo '<tr class="woocommerce-product-attributes-item">';
                        echo '<th class="woocommerce-product-attributes-item__label">' . esc_html( $attribute_name ) . '</th>';
                        echo '<td class="woocommerce-product-attributes-item__value">' . esc_html( $attribute_value ) . '</td>';
                        echo '</tr>';
                    }
                }
            }
            
            echo '</table>';
            
            // If some attributes were invalid, update the meta to remove them
            if ( count( $valid_attributes ) !== count( $selected_attributes ) ) {
                update_post_meta( $product->get_id(), 'custom_product_attributes', $valid_attributes );
            }
        } else {
            echo '<p>' . esc_html__( 'No valid product specifications available.', 'dokan' ) . '</p>';
            // Clean up if no valid attributes remain
            delete_post_meta( $product->get_id(), 'custom_product_attributes' );
        }
    }
}

/**
 * Validate and filter selected attributes, removing any that no longer exist
 */
function validate_and_filter_custom_attributes( $selected_attributes ) {
    if ( empty( $selected_attributes ) || ! is_array( $selected_attributes ) ) {
        return array();
    }
    
    $available_attributes = get_custom_product_attributes();
    $valid_attributes = array();
    
    foreach ( $selected_attributes as $selected_attribute ) {
        if ( validate_selected_custom_attribute( $selected_attribute, $available_attributes ) ) {
            $valid_attributes[] = $selected_attribute;
        }
    }
    
    return $valid_attributes;
}

/**
 * Fetch product attributes and their values with error handling
 */
function get_custom_product_attributes() {
    $product_attributes = array();
    
    // Check if WooCommerce is active
    if ( ! function_exists( 'wc_get_attribute_taxonomies' ) ) {
        return $product_attributes;
    }
    
    $attribute_taxonomies = wc_get_attribute_taxonomies();

    if ( ! empty( $attribute_taxonomies ) && ! is_wp_error( $attribute_taxonomies ) ) {
        foreach ( $attribute_taxonomies as $attribute ) {
            if ( ! isset( $attribute->attribute_name ) || ! isset( $attribute->attribute_label ) ) {
                continue; // Skip malformed attributes
            }
            
            $attribute_name = wc_attribute_taxonomy_name( $attribute->attribute_name );
            
            // Enhanced error handling for get_terms
            $attribute_terms = get_terms( array(
                'taxonomy' => $attribute_name,
                'hide_empty' => false,
                'fields' => 'all'
            ) );

            // Check if get_terms returned valid data
            if ( ! is_wp_error( $attribute_terms ) && ! empty( $attribute_terms ) ) {
                $attribute_values = array();
                foreach ( $attribute_terms as $term ) {
                    if ( isset( $term->term_id ) && isset( $term->name ) ) {
                        $attribute_values[ $term->term_id ] = $term->name;
                    }
                }
                
                if ( ! empty( $attribute_values ) ) {
                    $product_attributes[ $attribute->attribute_label ] = $attribute_values;
                }
            }
        }
    }

    return $product_attributes;
}
?>
