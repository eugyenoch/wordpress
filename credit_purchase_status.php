#Gets the current credit purchase status of a user
#Requires the terawallet plugin(originally woo_wallet)

add_filter('wallet_credit_purchase_order_status', 'wallet_credit_purchase_order_status');
function wallet_credit_purchase_order_status($status){
    $status = array('completed');
    return $status;
}
