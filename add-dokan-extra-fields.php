<?php
/*
Plugin Name: Extra [event] fields For Dokan
Plugin URI: https://iboora.com
Description: Adds custom payment methods to Dokan dashboard
Version: 1.0
Author: Eugy Enoch
Author URI: https://github.com/eugyenoch
Textdomain: twentytwentythree
License: GPLv2
*/


add_action( 'dokan_new_product_after_product_tags','new_product_fields',10 );

function new_product_fields(){ ?>
 <div class="dokan-form-group">
        <label for="event_notice">Fill out Event date, Event time, Event actors, and Event location, only if you want to sell tickets (for an event, exhibition, cinema, appointment, and some other activity). For non-downloadable tickets, be sure select the "virtual" option, only. For downloadable tickets, select both the "virtual" and "downloadable" options.</label>
    </div>
    
     <div class="dokan-form-group">
         <label for="event_date" class="form-label"><?php esc_html_e( 'Event Date', 'dokan-lite' ); ?></label>
         <input type="date" class="dokan-form-control" name="event_date" id="event_date"><br>
         <small>Fill out the name of your activity</small>
     </div>

     <div class="dokan-form-group">
         <label for="event_time" class="form-label"><?php esc_html_e( 'Event Time', 'dokan-lite' ); ?></label>
         <input type="time" class="dokan-form-control" name="event_time" id="event_time"><br>
         <small>Fill out this section only if your product is a timed activity</small>
     </div>

     <div class="dokan-form-group">
         <label for="event_actors" class="form-label"><?php esc_html_e( 'Event Actors, Performers, Speakers', 'dokan-lite' ); ?></label>
         <input type="text" class="dokan-form-control" name="event_actors" id="event_actors">
     </div>

     <div class="dokan-form-group">
         <label for="event_location" class="form-label"><?php esc_html_e( 'Event Location', 'dokan-lite' ); ?></label>
         <input type="text" class="dokan-form-control" name="event_location" id="event_location">
     </div>

<?php
}

/*
* Saving product field data for edit and update
*/

add_action( 'dokan_new_product_added','save_additional_product_meta', 10, 2 );
add_action( 'dokan_product_updated', 'save_additional_product_meta', 10, 2 );

function save_additional_product_meta($product_id, $postdata){

    if ( ! dokan_is_user_seller( get_current_user_id() ) ) {
        return;
    }
    if ( isset( $postdata['event_notice'] ) ) {
        update_post_meta( $product_id, 'event_notice', $postdata['event_notice'] );
    }

    if ( ! empty( $postdata['event_date'] ) ) {
        update_post_meta( $product_id, 'event_date', $postdata['event_date'] );
    }

    if ( ! empty( $postdata['event_time'] ) ) {
        update_post_meta( $product_id, 'event_time', $postdata['event_time'] );
    }

    if ( ! empty( $postdata['event_actors'] ) ) {
        update_post_meta( $product_id, 'event_actors', $postdata['event_actors'] );
    }

    if ( ! empty( $postdata['event_location'] ) ) {
        update_post_meta( $product_id, 'event_location', $postdata['event_location'] );
    }
}

/*
* Showing field data on product edit page
*/

add_action('dokan_product_edit_after_product_tags','show_extra_fields_on_edit_page',99,2);

function show_extra_fields_on_edit_page($post, $post_id){
    $event_notice = get_post_meta( $post_id, 'event_notice', true );
    $event_date = get_post_meta( $post_id, 'event_date', true );
    $event_time = get_post_meta( $post_id, 'event_time', true );
    $event_actors = get_post_meta( $post_id, 'event_actors', true );
    $event_location = get_post_meta( $post_id, 'event_location', true );
    ?>
     <div class="dokan-form-group">
        <label for="event_notice">
            <strong>Fill out Event date, Event time, Event actors, and Event location, only if you want to sell tickets (for an event, exhibition, cinema, appointment, and some other activity). For non-downloadable tickets, be sure select the "virtual" option, only. For downloadable tickets, select both the "virtual" and "downloadable" options.</strong>
        </label>
    </div>

    <div class="dokan-form-group">
        <label for="event_date" class="form-label"><?php esc_html_e( 'Event Date', 'dokan-lite' ); ?></label>
        <input type="date" class="dokan-form-control" name="event_date" id="event_date" value="<?php echo esc_attr( $event_date ); ?>">
    </div>

    <div class="dokan-form-group">
        <label for="event_time" class="form-label"><?php esc_html_e( 'Event Time', 'dokan-lite' ); ?></label>
        <input type="time" class="dokan-form-control" name="event_time" id="event_time" value="<?php echo esc_attr( $event_time ); ?>">
    </div>

    <div class="dokan-form-group">
        <label for="event_actors" class="form-label"><?php esc_html_e( 'Event Actors, Performers, Speakers', 'dokan-lite' ); ?></label>
        <input type="text" class="dokan-form-control" name="event_actors" id="event_actors" value="<?php echo esc_attr( $event_actors ); ?>">
    </div>

    <div class="dokan-form-group">
        <label for="event_location" class="form-label"><?php esc_html_e( 'Event Location', 'dokan-lite' ); ?></label>
        <input type="text" class="dokan-form-control" name="event_location" id="event_location" value="<?php echo esc_attr( $event_location ); ?>">
    </div>
    <?php
}

// showing on single product page
add_action('woocommerce_single_product_summary','show_additional_product_fields',13);

function show_additional_product_fields(){
    global $product;

    if ( empty( $product ) ) {
        return;
    }

    $event_date = get_post_meta( $product->get_id(), 'event_date', true );
    $event_time = get_post_meta( $product->get_id(), 'event_time', true );
    $event_actors = get_post_meta( $product->get_id(), 'event_actors', true );
    $event_location = get_post_meta( $product->get_id(), 'event_location', true );

    if ( ! empty( $event_date ) ) {
        ?>
        <span class="details"><?php echo esc_attr__( 'Event Date:', 'dokan-lite' ); ?> <strong><?php echo esc_attr( $event_date ); ?></strong></span>
        <?php
    }

    if ( ! empty( $event_time ) ) {
        ?>
        <span class="details"><?php echo esc_attr__( 'Event Time:', 'dokan-lite' ); ?> <strong><?php echo esc_attr( $event_time ); ?></strong></span>
        <?php
    }

    if ( ! empty( $event_actors ) ) {
        ?>
        <span class="details"><?php echo esc_attr__( 'Event Actors:', 'dokan-lite' ); ?> <strong><?php echo esc_attr( $event_actors ); ?></strong></span>
        <?php
    }

    if ( ! empty( $event_location ) ) {
        ?>
        <span class="details"><?php echo esc_attr__( 'Event Location:', 'dokan-lite' ); ?> <strong><?php echo esc_attr( $event_location ); ?></strong></span>
        <?php
    }
}
?>
