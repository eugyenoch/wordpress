function slicewp_custom_register_affiliate_fields_bank_details( $fields ) {
	
	$fields[] = array(
		'type'  	  		  => 'heading',
		'default_value'		  => __( 'Bank Account Details - Local Bank or Payoneer(GBP only)', 'slicewp' ),
		'output_conditionals' => array( 'form' => array( 'affiliate_registration', 'affiliate_account' ) )
	);

	$fields[] = array(
		'type'  	  		  => 'text',
		'id'				  => 'slicewp-bank-name',
		'name'				  => 'bank_name',
		'label'				  => __( 'Bank Name', 'slicewp' ),
		'is_required'		  => true,
		'output_conditionals' => array( 'form' => array( 'affiliate_registration', 'affiliate_account' ) )
	);

	$fields[] = array(
		'type'  	  		  => 'text',
		'id'				  => 'slicewp-bank-account-number',
		'name'				  => 'bank_account_number',
		'label'				  => __( 'Bank Account Number/IBAN', 'slicewp' ),
		'is_required'		  => true,
		'output_conditionals' => array( 'form' => array( 'affiliate_registration', 'affiliate_account' ) )
	);
	
	$fields[] = array(
		'type'  	  		  => 'text',
		'id'				  => 'slicewp-bank-account-name',
		'name'				  => 'bank_account_name',
		'label'				  => __( 'Beneficiary Name', 'slicewp' ),
		'is_required'		  => true,
		'output_conditionals' => array( 'form' => array( 'affiliate_registration', 'affiliate_account' ) )
	);
	
	$fields[] = array(
		'type'  	  		  => 'text',
		'id'				  => 'slicewp-bank-address',
		'name'				  => 'bank_address',
		'label'				  => __( 'Bank Full Address', 'slicewp' ),
		'is_required'		  => true,
		'output_conditionals' => array( 'form' => array( 'affiliate_registration', 'affiliate_account' ) )
	);
	
	$fields[] = array(
		'type'  	  		  => 'text',
		'id'				  => 'slicewp-bank-swift',
		'name'				  => 'bank_swift',
		'label'				  => __( 'Bank BIC/SWIFT Code', 'slicewp' ),
		'is_required'		  => true,
		'output_conditionals' => array( 'form' => array( 'affiliate_registration', 'affiliate_account' ) )
	);
	
	$fields[] = array(
		'type'  	  		  => 'text',
		'id'				  => 'slicewp-routing-number',
		'name'				  => 'bank_routing _code',
		'label'				  => __( 'Routing Code', 'slicewp' ),
		'is_required'		  => false,
		'output_conditionals' => array( 'form' => array( 'affiliate_registration', 'affiliate_account' ) )
	);

	return $fields;

}
add_filter( 'slicewp_register_affiliate_fields', 'slicewp_custom_register_affiliate_fields_bank_details', 50 );
