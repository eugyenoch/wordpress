#Requires the terawallet plugin
#afterwards use the [woo-mini-wallet] shortcode anywhere

function woo_mini_wallet_callback() {
    if (!function_exists('woo_wallet') || !is_user_logged_in()) {
        return '';
    }
    ob_start();
    $title = __('Current wallet balance', 'woo-wallet');
    $mini_wallet = '<a class="woo-wallet-menu-contents" href="' . esc_url(wc_get_account_endpoint_url(get_option('woocommerce_woo_wallet_endpoint', 'woo-wallet'))) . '" title="' . $title . '">';
    $mini_wallet .= '<img style="width:16px;height:16px;float:left;margin:4px;" src="' . WOO_WALLET_ICON . '" /> ';
    $mini_wallet .= woo_wallet()->wallet->get_wallet_balance(get_current_user_id());
    $mini_wallet .= '</a>';
    echo $mini_wallet;
    return ob_get_clean();
}
add_shortcode('woo-mini-wallet', 'woo_mini_wallet_callback');
