// Modify the product data tabs to include custom fields
function add_event_ticket_product_data_tabs($tabs){
    $tabs['event_ticket'] = array(
        'label'  => __('Event Ticket', 'woocommerce'),
        'target' => 'event_ticket_options',
        'class'  => array('show_if_event_ticket'),
    );
    return $tabs;
}
add_filter('woocommerce_product_data_tabs', 'add_event_ticket_product_data_tabs', 20, 1);

// Show general and inventory tabs for event_ticket type
function show_general_and_inventory_settings(){
    global $post;
    $product_type = get_post_meta($post->ID, '_product_type', true);
    
    if ($product_type === 'event_ticket') {
        echo '<div id="general_product_data" class="panel woocommerce_options_panel">';
        do_action('woocommerce_product_options_general_product_data');
        echo '</div>';
        
        echo '<div id="inventory_product_data" class="panel woocommerce_options_panel show_if_simple">';
        do_action('woocommerce_product_options_inventory_product_data');
        echo '</div>';
    }
}
add_action('woocommerce_product_data_panels', 'show_general_and_inventory_settings');

// Show virtual and downloadable options
function add_virtual_downloadable_options(){
    global $post;
    $product_type = get_post_meta($post->ID, '_product_type', true);
    
    if ($product_type === 'event_ticket') {
        woocommerce_wp_checkbox(
            array(
                'id'          => '_virtual',
                'label'       => __('Virtual', 'woocommerce'),
                'description' => __('Enable this if the event is virtual.', 'woocommerce'),
            )
        );
        
        woocommerce_wp_checkbox(
            array(
                'id'          => '_downloadable',
                'label'       => __('Downloadable', 'woocommerce'),
                'description' => __('Enable this if the event has downloadable content.', 'woocommerce'),
            )
        );
    }
}
add_action('woocommerce_product_options_general_product_data', 'add_virtual_downloadable_options');
