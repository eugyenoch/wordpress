#Requires the terawallet plugin(formerly woowallet)

add_shortcode('terawallet-transfer', 'terawallet_transfer_shortcode_callback');

if (!function_exists('terawallet_transfer_shortcode_callback')) {

    function terawallet_transfer_shortcode_callback($atts) {
        ob_start();
        if (!is_user_logged_in()) {
            echo '<div class="woocommerce">';
            wc_get_template('myaccount/form-login.php');
            echo '</div>';
        } else {
            wp_enqueue_style('woo-wallet-payment-jquery-ui');
            wp_enqueue_style('dashicons');
            wp_enqueue_style('select2');
            wp_enqueue_style('jquery-datatables-style');
            wp_enqueue_style('jquery-datatables-responsive-style');
            wp_enqueue_script('jquery-datatables-script');
            wp_enqueue_script('jquery-datatables-responsive-script');
            wp_enqueue_script('selectWoo');
            wp_enqueue_script('jquery-ui-datepicker');
            wp_enqueue_script('wc-endpoint-wallet');
            if (apply_filters('woo_wallet_is_enable_transfer', 'on' === woo_wallet()->settings_api->get_option('is_enable_wallet_transfer', '_wallet_settings_general', 'on'))) {
                ?>
                <form method="post" action="" id="woo_wallet_transfer_form">
                    <p class="woo-wallet-field-container form-row form-row-wide">
                        <label for="woo_wallet_transfer_user_id"><?php _e('Select whom to transfer', 'woo-wallet'); ?> <?php
                            if (apply_filters('woo_wallet_user_search_exact_match', true)) {
                                _e('(Email)', 'woo-wallet');
                            }
                            ?></label>
                        <select name="woo_wallet_transfer_user_id" class="woo-wallet-select2" required=""></select>
                    </p>
                    <p class="woo-wallet-field-container form-row form-row-wide">
                        <label for="woo_wallet_transfer_amount"><?php _e('Amount', 'woo-wallet'); ?></label>
                        <input type="number" step="0.01" min="<?php echo woo_wallet()->settings_api->get_option('min_transfer_amount', '_wallet_settings_general', 0); ?>" name="woo_wallet_transfer_amount" required=""/>
                    </p>
                    <p class="woo-wallet-field-container form-row form-row-wide">
                        <label for="woo_wallet_transfer_note"><?php _e('What\'s this for', 'woo-wallet'); ?></label>
                        <textarea name="woo_wallet_transfer_note"></textarea>
                    </p>
                    <p class="woo-wallet-field-container form-row">
                        <?php wp_nonce_field('woo_wallet_transfer', 'woo_wallet_transfer'); ?>
                        <input type="submit" class="button" name="woo_wallet_transfer_fund" value="<?php _e('Proceed to transfer', 'woo-wallet'); ?>" />
                    </p>
                </form>
                <?php
            }
        }
        return ob_get_clean();
    }

}
