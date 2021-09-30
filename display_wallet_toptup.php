#Displays a form for user to topup wallet
#Requires the terawallet plugin and woocommerce

add_shortcode('terawallet-topup', 'terawallet_topup_shortcode');

function terawallet_topup_shortcode(){
    ob_start();
    ?>
    <form method="post" action="">
        <div class="woo-wallet-add-amount">
            <label for="woo_wallet_balance_to_add"><?php _e( 'Enter amount', 'woo-wallet' ); ?></label>
            <?php
            $min_amount = woo_wallet()->settings_api->get_option( 'min_topup_amount', '_wallet_settings_general', 0 );
            $max_amount = woo_wallet()->settings_api->get_option( 'max_topup_amount', '_wallet_settings_general', '' );
            ?>
            <input type="number" step="0.01" min="<?php echo $min_amount; ?>" max="<?php echo $max_amount; ?>" name="woo_wallet_balance_to_add" id="woo_wallet_balance_to_add" class="woo-wallet-balance-to-add" required="" />
            <?php wp_nonce_field( 'woo_wallet_topup', 'woo_wallet_topup' ); ?>
            <input type="submit" name="woo_add_to_wallet" class="woo-add-to-wallet" value="<?php _e( 'Add', 'woo-wallet' ); ?>" />
        </div>
    </form>
    <?php
    return ob_get_clean();
}
