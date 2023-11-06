if ( defined( 'YITH_WCAF' ) ) {
    function yith_wcaf_available_endpoints( $endpoints ) {
        $endpoints['sell_your_item'] = 'Sell your own items';
        $endpoints['add_payment_method'] = 'Add payment methods';
        return $endpoints;
    }
    add_filter( 'yith_wcaf_available_endpoints', 'yith_wcaf_available_endpoints' );

    function yith_wcaf_change_settings_page_url( $url, $endpoint ) {
        if ( 'sell_your_item' === $endpoint ) {
            $url = get_the_permalink( get_page_by_path( 'dashboard' ) );
        }
        if ( 'add_payment_method' === $endpoint ) {
            $url = home_url( 'dashboard/settings/payment' );
        }
        return $url;
    }
    add_filter( 'yith_wcaf_get_endpoint_url', 'yith_wcaf_change_settings_page_url', 10, 2 );
}
