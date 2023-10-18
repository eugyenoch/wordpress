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


add_action( 'dokan_new_product_after_product_tags','new_product_fields',10 );

function new_product_fields(){ ?>
 <div class="dokan-form-group">
        <label for="event_notice">Fill out Event dates, Event time, Event performers, and Event location, only if you want to sell tickets (to an event, exhibition, cinema, appointment, and any other activity). For non-downloadable tickets, be sure select the "virtual" option, only. For downloadable tickets, select both the "virtual" and "downloadable" options. For physical tickets, Select neither option.</label>
    </div>
    
      <div class="dokan-form-group">
        <label for="event_date_start" class="form-label"><?php esc_html_e( 'Event Date (Start)', 'dokan-lite' ); ?></label>
        <input type="date" class="dokan-form-control" name="event_date_start" id="event_date_start" value="<?php echo esc_attr( $event_date_start ); ?>">
    </div>

    <div class="dokan-form-group">
        <label for="event_date_end" class="form-label"><?php esc_html_e( 'Event Date (End)', 'dokan-lite' ); ?></label>
        <input type="date" class="dokan-form-control" name="event_date_end" id="event_date_end" value="<?php echo esc_attr( $event_date_end ); ?>">
    </div>

     <div class="dokan-form-group">
         <label for="event_time" class="form-label"><?php esc_html_e( 'Event Time', 'dokan-lite' ); ?></label>
         <input type="time" class="dokan-form-control" name="event_time" id="event_time"><br>
         <small>Fill out this section if your event is a timed activity</small>
     </div>

     <div class="dokan-form-group">
         <label for="event_actors" class="form-label"><?php esc_html_e( 'Performers', 'dokan-lite' ); ?></label>
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

    if ( ! empty( $postdata['event_date_start'] ) ) {
        update_post_meta( $product_id, 'event_date_start', $postdata['event_date_start'] );
    }

    if ( ! empty( $postdata['event_date_end'] ) ) {
        update_post_meta( $product_id, 'event_date_end', $postdata['event_date_end'] );
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
    $event_date_start = get_post_meta( $post_id, 'event_date_start', true );
    $event_date_end = get_post_meta( $post_id, 'event_date_end', true );
    $event_time = get_post_meta( $post_id, 'event_time', true );
    $event_actors = get_post_meta( $post_id, 'event_actors', true );
    $event_location = get_post_meta( $post_id, 'event_location', true );
    ?>
     <div class="dokan-form-group">
        <label for="event_notice">
            <strong>Fill out Event date, Event time, Event actors, and Event location, only if you want to sell tickets (for a single-date event, exhibition, cinema, appointment, and some other activity). For non-downloadable tickets, be sure select the "virtual" option, only. For downloadable tickets, select both the "virtual" and "downloadable" options.</strong>
        </label>
    </div>

     <div class="dokan-form-group">
        <label for="event_date_start" class="form-label"><?php esc_html_e( 'Event Date (Start)', 'dokan-lite' ); ?></label>
        <input type="date" class="dokan-form-control" name="event_date_start" id="event_date_start" value="<?php echo esc_attr( $event_date_start ); ?>">
    </div>

    <div class="dokan-form-group">
        <label for="event_date_end" class="form-label"><?php esc_html_e( 'Event Date (End)', 'dokan-lite' ); ?></label>
        <input type="date" class="dokan-form-control" name="event_date_end" id="event_date_end" value="<?php echo esc_attr( $event_date_end ); ?>">
    </div>

    <div class="dokan-form-group">
        <label for="event_time" class="form-label"><?php esc_html_e( 'Event Time', 'dokan-lite' ); ?></label>
        <input type="time" class="dokan-form-control" name="event_time" id="event_time" value="<?php echo esc_attr( $event_time ); ?>">
    </div>

    <div class="dokan-form-group">
        <label for="event_actors" class="form-label"><?php esc_html_e( 'Performers', 'dokan-lite' ); ?></label>
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

    $event_date_start = get_post_meta( $product->get_id(), 'event_date_start', true );
    $event_date_end = get_post_meta( $product->get_id(), 'event_date_end', true );
    $event_time = get_post_meta( $product->get_id(), 'event_time', true );
    $event_actors = get_post_meta( $product->get_id(), 'event_actors', true );
    $event_location = get_post_meta( $product->get_id(), 'event_location', true );

    if ( ! empty( $event_date_start ) ) {
        ?>
        <span class="details"><?php echo esc_attr__( 'Start date:', 'dokan-lite' ); ?> <strong><?php echo esc_attr( $event_date_start ); ?></strong></span>
        <?php
    }

    if ( ! empty( $event_date_end ) ) {
        ?>
        <span class="details"><?php echo esc_attr__( '&nbsp;End date:', 'dokan-lite' ); ?> <strong><?php echo esc_attr( $event_date_end ); ?></strong></span>
        <?php
    }

    if ( ! empty( $event_time ) ) {
        ?>
        <span class="details"><?php echo esc_attr__( '&nbsp;Time:', 'dokan-lite' ); ?> <strong><?php echo esc_attr( $event_time ); ?></strong></span>
        <?php
    }

    if ( ! empty( $event_actors ) ) {
        ?>
        <span class="details"><?php echo esc_attr__( '&nbsp;Performers:', 'dokan-lite' ); ?> <strong><?php echo esc_attr( $event_actors ); ?></strong></span>
        <?php
    }

    if ( ! empty( $event_location ) ) {
        ?>
        <span class="details"><?php echo esc_attr__( '&nbsp;Location:', 'dokan-lite' ); ?> <strong><?php echo esc_attr( $event_location ); ?></strong></span>
        <?php
    }
}
?>
