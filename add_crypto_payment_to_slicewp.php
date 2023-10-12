function slicewp_custom_register_affiliate_fields_crypto_details( $fields ) {
	
	$fields[] = array(
		'type'  	  		  => 'heading',
		'default_value'		  => __( 'Cryptocurrency Payment Details; USDC and USDT are for the Binance Smart Chain (BSC) Blockchain', 'slicewp' ),
		'output_conditionals' => array( 'form' => array( 'affiliate_registration', 'affiliate_account' ) )
	);

	$fields[] = array(
		'type'  	  		  => 'text',
		'id'				  => 'slicewp-usdt-name',
		'name'				  => 'usdt_name',
		'label'				  => __( 'USDT Wallet', 'slicewp' ),
		'is_required'		  => false,
		'output_conditionals' => array( 'form' => array( 'affiliate_registration', 'affiliate_account' ) )
	);

	$fields[] = array(
		'type'  	  		  => 'text',
		'id'				  => 'slicewp-usdc-name',
		'name'				  => 'usdc_name',
		'label'				  => __( 'USDC Wallet', 'slicewp' ),
		'is_required'		  => false,
		'output_conditionals' => array( 'form' => array( 'affiliate_registration', 'affiliate_account' ) )
	);
	
	$fields[] = array(
		'type'  	  		  => 'text',
		'id'				  => 'slicewp-bitcoin-address',
		'name'				  => 'bitcoin_name',
		'label'				  => __( 'Bitcoin address', 'slicewp' ),
		'is_required'		  => false,
		'output_conditionals' => array( 'form' => array( 'affiliate_registration', 'affiliate_account' ) )
	);
	

	return $fields;

}
add_filter( 'slicewp_register_affiliate_fields', 'slicewp_custom_register_affiliate_fields_crypto_details', 50 );
