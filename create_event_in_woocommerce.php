// Register the custom product type
function register_event_ticket_product_type() {
    class WC_Product_Event_Ticket extends WC_Product {
        public function __construct( $product ) {
            $this->product_type = 'event_ticket';
            parent::__construct( $product );
        }
    }
}
add_action( 'init', 'register_event_ticket_product_type' );

// Add the custom product type to the product data dropdown
function add_event_ticket_product_type( $types ) {
    $types['event_ticket'] = __( 'Event Ticket', 'woocommerce' );
    return $types;
}
add_filter( 'product_type_selector', 'add_event_ticket_product_type' );

// Modify the product data tabs to include custom fields
function add_event_ticket_product_data_tabs( $tabs ) {
    $tabs['event_ticket'] = array(
        'label'  => __( 'Event Ticket', 'woocommerce' ),
        'target' => 'event_ticket_options',
    );
    return $tabs;
}
add_filter( 'woocommerce_product_data_tabs', 'add_event_ticket_product_data_tabs' );

// Render custom fields on the product data tabs
function render_event_ticket_product_data_fields() {
    global $post;
    ?>
    <div id="event_ticket_options" class="panel woocommerce_options_panel">
        <div class="options_group">
            <?php
            woocommerce_wp_text_input(
                array(
                    'id'          => '_event_date',
                    'label'       => __( 'Event Date', 'woocommerce' ),
                    'placeholder' => 'YYYY-MM-DD',
                    'desc_tip'    => 'true',
                )
            );

            woocommerce_wp_text_input(
                array(
                    'id'          => '_event_location',
                    'label'       => __( 'Event Location', 'woocommerce' ),
                    'placeholder' => __( 'Enter the event location', 'woocommerce' ),
                    'desc_tip'    => 'true',
                )
            );
		woocommerce_wp_text_input( array(
        'id'          => 'event_time',
        'label'       => __( 'Event Time (GMT)', 'woocommerce' ),
        'placeholder' => __( 'Enter the event time in GMT', 'woocommerce' ),
    ) );
    
    	woocommerce_wp_textarea_input( array(
        'id'          => 'event_speakers',
        'label'       => __( 'Event Speakers', 'woocommerce' ),
        'placeholder' => __( 'Enter the speakers for this event', 'woocommerce' ),
    ) );
            ?>
        </div>
    </div>
    <?php
}
add_action( 'woocommerce_product_data_panels', 'render_event_ticket_product_data_fields' );

// Save custom field data upon product save
function save_event_ticket_product_data_fields( $post_id ) {
    $event_date = ! empty( $_POST['_event_date'] ) ? sanitize_text_field( $_POST['_event_date'] ) : '';
    $event_location = ! empty( $_POST['_event_location'] ) ? sanitize_text_field( $_POST['_event_location'] ) : '';
	$event_time    = isset( $_POST['event_time'] ) ? sanitize_text_field( $_POST['event_time'] ) : '';
    $event_speakers = isset( $_POST['event_speakers'] ) ? sanitize_textarea_field( $_POST['event_speakers'] ) : '';

    update_post_meta( $post_id, '_event_date', $event_date );
    update_post_meta( $post_id, '_event_location', $event_location );
	update_post_meta( $product_id, 'event_time', $event_time );
    update_post_meta( $product_id, 'event_speakers', $event_speakers );
}
add_action( 'woocommerce_process_product_meta_event_ticket', 'save_event_ticket_product_data_fields' );
