add_action( 'woocommerce_thankyou', 'ecommercehints_get_up_sells', 10, 1 );
function ecommercehints_get_up_sells( $order_id ){
$up_sell_ids = array();
$order = wc_get_order( $order_id );
$items = $order->get_items();
foreach ( $items as $item ) {
if( $item_up_sell_ids = get_post_meta( $item['product_id'], '_upsell_ids', true ) ) {
$up_sell_ids = array_unique( array_merge( $item_up_sell_ids, $up_sell_ids ));
}
}

if(!empty($up_sell_ids)) {
$up_sell = new WP_Query( array(
'post_type' => array( 'product', 'product_variation' ),
'post_status' => 'publish',
'post__in' => $up_sell_ids,
'orderby' => 'post__in'
) );

if( $up_sell->have_posts() ) {
echo '<h2>You may also like...</h2>';
woocommerce_product_loop_start();
while ( $up_sell->have_posts() ) : $up_sell->the_post();
$product = wc_get_product( $up_sell->post->ID );
wc_get_template_part( 'content', 'product' );
endwhile;
woocommerce_product_loop_end();
woocommerce_reset_loop();
wp_reset_postdata();
}
}
}
