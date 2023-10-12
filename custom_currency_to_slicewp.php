/**
 * Register "BTC" currency
 *
 * @param array $currencies
 *
 * @return array
 *
 */
function slicewp_register_custom_currency_btc( $currencies ) {

	$currencies['BTC'] = array(
		'name' 					=> 'Bitcoin',
		'symbol' 				=> '₿',
		'symbol_position' 		=> 'before',
		'decimal_places' 		=> 8,
		'thousands_separator' 	=> ',',
		'decimal_separator' 	=> '.'
	);
	
	$currencies['USDT'] = array(
		'name' 					=> 'USD Tether',
		'symbol' 				=> 'USD₮',
		'symbol_position' 		=> 'before',
		'decimal_places' 		=> 4,
		'thousands_separator' 	=> ',',
		'decimal_separator' 	=> '.'
	);
	
	$currencies['USDC'] = array(
		'name' 					=> 'USD Coin',
		'symbol' 				=> 'USDC',
		'symbol_position' 		=> 'before',
		'decimal_places' 		=> 4,
		'thousands_separator' 	=> ',',
		'decimal_separator' 	=> '.'
	);

	return $currencies;

}
add_filter( 'slicewp_register_currency', 'slicewp_register_custom_currency_btc' );
