<?php
/*
Plugin Name: Add order quantity and delivery dates to Dokan
Plugin URI: https://iboora.com
Description: Add minimum and maximum order quantity on Dokan, also included with the plugin is the delivery date option. Useful for importers, wholesalers, suppliers, manufacturers and dealers in bulk purchase
Version: 1.1.0
Author: Eugy Enoch
Author URI: https://github.com/eugyenoch
Textdomain: kadence
License: GPLv2
*/

add_action( 'dokan_new_product_after_product_tags','new_product_fields',10 );

function new_number_quantity_fields(){ ?>
 <div class="dokan-form-group">
        <label for="number_quantity_notice"><strong>Fill out the minimum and maximum order quantity for your product, if applicable(this section is intended for importers, manufacturers, wholesalers, suppliers and those with bulk purchase requirements).</strong></div>

     <div class="dokan-form-group">
         <label for="number_quantity_minimum" class="form-label"><?php esc_html_e( 'Minimum Order', 'dokan-lite' ); ?></label>
         <input type="text" class="dokan-form-control" name="number_quantity_minimum" id="number_quantity_minimum">
     </div>

     <div class="dokan-form-group">
         <label for="number_quantity_maximum" class="form-label"><?php esc_html_e( 'Maximum Order', 'dokan-lite' ); ?></label>
         <input type="text" class="dokan-form-control" name="number_quantity_maximum" id="number_quantity_maximum">
     </div>

	<div class="dokan-form-group">
        <label for="number_quantity_estimated_delivery_date" class="form-label"><?php esc_html_e( 'Delivery Date (Estimate)', 'dokan-lite' ); ?></label>
        <input type="date" class="dokan-form-control" name="number_quantity_estimated_delivery_date" id="number_quantity_estimated_delivery_date" value="<?php echo esc_attr( $number_quantity_estimated_delivery_date ); ?>">
    </div>

<?php
}

/*
* Saving product field data for edit and update
*/

add_action( 'dokan_new_product_added','save_new_number_quantity_fields', 10, 2 );
add_action( 'dokan_product_updated', 'save_new_number_quantity_fields', 10, 2 );

function save_new_number_quantity_fields($product_id, $postdata){

    if ( ! dokan_is_user_seller( get_current_user_id() ) ) {
        return;
    }
    if ( isset( $postdata['number_quantity_minimum'] ) ) {
        update_post_meta( $product_id, 'number_quantity_minimum', $postdata['number_quantity_minimum'] );
    }

    if ( ! empty( $postdata['number_quantity_maximum'] ) ) {
        update_post_meta( $product_id, 'number_quantity_maximum', $postdata['number_quantity_maximum'] );
    }

    if ( ! empty( $postdata['number_quantity_estimated_delivery_date'] ) ) {
        update_post_meta( $product_id, 'event_date_end', $postdata['number_quantity_estimated_delivery_date'] );
    }
}

/*
* Showing field data on product edit page
*/

add_action('dokan_product_edit_after_product_tags','show_order_quantity_fields_on_edit_page',99,2);

function show_order_quantity_fields_on_edit_page($post, $post_id){
    $number_quantity_minimum = get_post_meta( $post_id, 'number_quantity_minimum', true );
    $number_quantity_maximum = get_post_meta( $post_id, 'number_quantity_maximum', true );
    $number_quantity_estimated_delivery_date = get_post_meta( $post_id, 'number_quantity_estimated_delivery_date', true );   
    ?>
     <div class="dokan-form-group">
        <label for="number_quantity_notice"><strong>Edit the minimum and maximum order quantity for your product, if applicable(this section is intended for importers, manufacturers, wholesalers, suppliers and those with bulk purchase requirements).</strong></div>

     <div class="dokan-form-group">
         <label for="number_quantity_minimum" class="form-label"><?php esc_html_e( 'Minimum Order', 'dokan-lite' ); ?></label>
         <input type="text" class="dokan-form-control" name="number_quantity_minimum" id="number_quantity_minimum">
     </div>

     <div class="dokan-form-group">
         <label for="number_quantity_maximum" class="form-label"><?php esc_html_e( 'Maximum Order', 'dokan-lite' ); ?></label>
         <input type="text" class="dokan-form-control" name="number_quantity_maximum" id="number_quantity_maximum">
     </div>

	<div class="dokan-form-group">
        <label for="number_quantity_estimated_delivery_date" class="form-label"><?php esc_html_e( 'Delivery Date (Estimate)', 'dokan-lite' ); ?></label>
        <input type="date" class="dokan-form-control" name="number_quantity_estimated_delivery_date" id="number_quantity_estimated_delivery_date" value="<?php echo esc_attr( $number_quantity_estimated_delivery_date ); ?>">
    </div>
    <?php
}

// showing on single product page
add_action('woocommerce_single_product_summary','show_order_product_fields',13);

function show_order_product_fields(){
    global $product;

    if ( empty( $product ) ) {
        return;
    }

 	$number_quantity_minimum = get_post_meta( $product->get_id(), 'number_quantity_minimum', true ); 
	$number_quantity_maximum = get_post_meta( $product->get_id(), 'number_quantity_maximum', true );    
	$number_quantity_estimated_delivery_date = get_post_meta( $product->get_id(), 'number_quantity_estimated_delivery_date', true );

 if ( ! empty( $number_quantity_minimum ) ) {
        ?>
        <span class="details"><?php echo esc_attr__( 'Minimum Order Number:', 'dokan-lite' ); ?> <strong><?php echo esc_attr( $number_quantity_minimum ); ?></strong></span>
        <?php
    }

 if ( ! empty( $number_quantity_maximum ) ) {
        ?>
        <span class="details"><?php echo esc_attr__( 'Minimum Order Number:', 'dokan-lite' ); ?> <strong><?php echo esc_attr( $number_quantity_maximum ); ?></strong></span>
        <?php
    }

 if ( ! empty( $number_quantity_estimated_delivery_date ) ) {
        ?>
        <span class="details"><?php echo esc_attr__( 'Estimated Delivery Date:', 'dokan-lite' ); ?> <strong><?php echo esc_attr( $number_quantity_estimated_delivery_date ); ?></strong></span>
        <?php
    }
   
}


?>
