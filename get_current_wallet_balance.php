#Gets the current wallet balance of a user
#Requires the terawallet plugin(originally woo_wallet)

add_filter('woo_wallet_current_balance', 'woo_wallet_current_balance', 10, 2);

if(!function_exists('woo_wallet_current_balance')){
    function woo_wallet_current_balance($balance, $user_id){
        $credit_amount = array_sum(wp_list_pluck(get_wallet_transactions(array('user_id' => $user_id, 'where' => array(array('key' => 'type', 'value' => 'credit')), 'nocache' => true)), 'amount'));
        $debit_amount = array_sum(wp_list_pluck(get_wallet_transactions(array('user_id' => $user_id, 'where' => array(array('key' => 'type', 'value' => 'debit')), 'nocache' => true)), 'amount'));
        $balance = $credit_amount - $debit_amount;
        return $balance;
    }
}
