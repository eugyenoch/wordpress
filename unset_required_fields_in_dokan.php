#-- Remove Bank Payment Required Fields --#
function remove_bank_required_fields( $fields ){
    unset( $fields['routing_number'] );
    return $fields;
}
add_filter( 'dokan_bank_payment_required_fields', 'remove_bank_required_fields' );
