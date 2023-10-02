add_filter( 'manage_edit-shop_order_columns', 'ecommercehints_add_order_count_column', 20 );
function ecommercehints_add_order_count_column( $columns ) {
    $columns['email_order_count'] = __( 'Order Count (Email)', 'woocommerce' );
    return $columns;
}

// Populate column with order count
add_action( 'manage_shop_order_posts_custom_column', 'ecommercehints_populate_new_column' );
function ecommercehints_populate_new_column( $column ) {
    global $post;
    if ( 'email_order_count' === $column ) {
        $billing_email = get_post_meta( $post->ID, '_billing_email', true );
        if ( $billing_email ) {
            $customer_orders = get_posts( array(
                'numberposts' => -1,
                'meta_key'    => '_billing_email',
                'meta_value'  => $billing_email,
                'post_type'   => wc_get_order_types(),
                'post_status' => array_keys( wc_get_order_statuses() ),
            ) );
            $order_count = count( $customer_orders );
            echo $order_count;
        }
    }
}
