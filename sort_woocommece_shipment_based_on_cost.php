<?php
add_filter( 'woocommerce_package_rates' , 'xa_sort_shipping_services_by_cost', 10, 2 );
function xa_sort_shipping_services_by_cost( $rates, $package ) 
{
if ( ! $rates ) return $rates;

$rate_cost = array();
foreach( $rates as $rate ) {
$rate_cost[] = $rate->cost;
}

// using rate_cost, sort rates.
array_multisort( $rate_cost, $rates );

return $rates;
}
?>
