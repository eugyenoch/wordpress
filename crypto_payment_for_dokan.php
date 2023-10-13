<?php
/*
Plugin Name: Iboora Cryptocurrency Payment For Dokan
Plugin URI: https://console.iboora.com
Description: Adds custom payment methods to Dokan dashboard
Version: 1.0
Author: Eugy Enoch
Author URI: https://github.com/eugyenoch
Textdomain: kadence
License: GPLv2
*/


/**
 * 
 * Register New Withdraw Method
 * 
 */
function register_new_withdraw_method( $methods ){
    $methods['custom']    = [
        'title'     => __( 'Crypto Payment', 'dokan' ),
        'callback'  => 'dokan_withdraw_method_custom'
    ];

    return $methods;
}
add_filter( 'dokan_withdraw_methods', 'register_new_withdraw_method', 99 );

/**
 * 
 * Method Callback Function
 * 
 */
function dokan_withdraw_method_custom( $store_settings ){
    $value = isset( $store_settings['payment']['custom']['value'] ) ? esc_attr( $store_settings['payment']['custom']['value'] ) : ''; ?>

    <div class="dokan-form-group">
        <div class="dokan-w8">
            <div class="dokan-input-group">
                <span class="dokan-input-group-addon"><?php esc_html_e( 'USDT wallet(on BSC)', 'dokan-lite' ); ?></span>
                <input value="<?php echo esc_attr( $value ); ?>" name="settings[custom][value]" class="dokan-form-control value" placeholder="Enter USDT wallet" type="text" title="Wallet should be domiciled on the Binance Smart Chain (BSC)">
            </div>
        </div>
    </div>
    <?php if ( dokan_is_seller_dashboard() ) : ?>
        <div class="dokan-form-group">
            <div class="dokan-w8">
                <input name="dokan_update_payment_settings" type="hidden">
                <button class="ajax_prev disconnect dokan_payment_disconnect_btn dokan-btn dokan-btn-danger <?php echo empty( $value ) ? 'dokan-hide' : ''; ?>" type="button" name="settings[custom][disconnect]">
                    <?php esc_attr_e( 'Disconnect', 'dokan-lite' ); ?>
                </button>
            </div>
        </div>
    <?php endif; ?>
    <?php
}
?>
<?php

/**
 * 
 * Save Withdraw Method
 * 
 */
function save_withdraw_method_wise( $store_id, $dokan_settings ) {

  if ( isset( $_POST['settings']['custom']['value'] ) ) {
      $dokan_settings['payment']['custom'] = array(
          'value' => sanitize_text_field( $_POST['settings']['custom']['value'] ),
      );
  }

  update_user_meta( $store_id, 'dokan_profile_settings', $dokan_settings );
}
add_action( 'dokan_store_profile_saved', 'save_withdraw_method_wise', 10, 2 );

/**
 * 
 * Add Custom Withdraw Method to the Payment Method List
 * 
 */
function add_custom_withdraw_in_payment_method_list( $required_fields, $payment_method_id ){
    if( 'custom' == $payment_method_id ){
        $required_fields = ['value'];
    }
    return $required_fields;
}
add_filter( 'dokan_payment_settings_required_fields', 'add_custom_withdraw_in_payment_method_list', 10, 2 );

/**
 * 
 * Add Custom Withdraw Method to the Active Withdraw Method List
 * 
 */
function custom_method_in_active_withdraw_method( $active_payment_methods, $vendor_id ) {
    $store_info = dokan_get_store_info( $vendor_id );
    if ( isset( $store_info['payment']['custom']['value'] ) && $store_info['payment']['custom']['value'] !== false ) {
        $active_payment_methods[] = 'custom';
    }

    return $active_payment_methods;
}
add_filter( 'dokan_get_seller_active_withdraw_methods', 'custom_method_in_active_withdraw_method', 99, 2 );

/**
 * 
 * Include Method to Available Withdraw Method Section
 * 
 */
function include_method_in_withdraw_method_section( $methods ){
    $methods[] = 'custom';
    return $methods;
}
add_filter( 'dokan_withdraw_withdrawable_payment_methods', 'include_method_in_withdraw_method_section' );

/**
 * 
 * Add details to the Withdrawal Requests
 * 
 */
function vue_admin_withdraw(){
    ?>
    <script>
      var hooks;
      function getCustomPaymentDetails( details, method, data ){
        if ( data[method] !== undefined ) {
          if ( 'custom' === method) {
            details = data[method].value || '';
          }
        }
  
        return details;
      }
      dokan.hooks.addFilter( 'dokan_get_payment_details', 'getCustomPaymentDetails', getCustomPaymentDetails, 33, 3 );
    </script>
    <?php
}
add_action( 'admin_print_footer_scripts', 'vue_admin_withdraw', 99 );

