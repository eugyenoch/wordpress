function register_new_item_endpoint() {
    add_rewrite_endpoint( 'affiliate-account', EP_ROOT | EP_PAGES );
}
add_action( 'init', 'register_new_item_endpoint', 10, 0);

function new_item_query_vars( $vars ) {
    $vars[] = 'affiliate-account';
    return $vars;
}
add_filter( 'query_vars', 'new_item_query_vars' );

function add_new_item_tab( $items ) {
    $items['affiliate-account'] = 'Affiliate Account';
    return $items;
}
add_filter( 'woocommerce_account_menu_items', 'add_new_item_tab' );

function add_new_item_content() {
    get_template_part( 'template-parts/affiliate-account-content' );
}
add_action( 'woocommerce_account_affiliate-account_endpoint', 'add_new_item_content' );
