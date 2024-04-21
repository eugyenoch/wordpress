// Add a new query variable
add_filter( 'dokan_query_var_filter', 'dokan_load_marketplace_menu' );
function dokan_load_marketplace_menu( $query_vars ) {
    $query_vars['marketplace'] = 'marketplace';
    return $query_vars;
}

// Add a new menu item to the Dokan dashboard navigation
add_filter( 'dokan_get_dashboard_nav', 'dokan_add_marketplace_menu_item' );
function dokan_add_marketplace_menu_item( $urls ) {
    $urls['marketplace'] = array(
        'title' => __( 'Marketplace', 'dokan' ),
        'icon'  => '<i class="fa fa-shopping-bag"></i>',
        'url'   => home_url('/shop'), // Redirect to the shop page
        'pos'   => 51
    );
    return $urls;
}

// Redirect to the shop page when the marketplace query variable is set
add_action( 'template_redirect', 'dokan_redirect_to_shop_page' );
function dokan_redirect_to_shop_page() {
    $marketplace_url = dokan_get_navigation_url( 'marketplace' );
    if ( is_page() && $marketplace_url === get_permalink() ) {
        wp_redirect( home_url( '/shop' ) );
        exit;
    }
}
