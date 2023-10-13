/*
* author: https://wordpress.org/support/users/iovamihai/
*/
function slicewp_custom_affiliate_account_tab_dashboard_referred_affiliates_cards() {
	
	$current_date_min = ( new DateTime() )->sub( new DateInterval( 'P29D' ) );
	$current_date_min->setTime( 00, 00, 00 );

	$current_date_max = new DateTime();
	$current_date_max->setTime( 23, 59, 59 );
	
	$affiliate_id = slicewp_get_current_affiliate_id();
	
	$children_count_last_30_days = slicewp_get_affiliates( array( 'parent_id' => $affiliate_id, 'date_min' => get_gmt_from_date( $current_date_min->format( 'Y-m-d H:i:s' ) ), 'date_max' => get_gmt_from_date( $current_date_max->format( 'Y-m-d H:i:s' ) ) ), true );
	$children_count_all			 = slicewp_get_affiliates( array( 'parent_id' => $affiliate_id ), true );
	
	?>

		<div class="slicewp-card slicewp-card-affiliate-dashboard slicewp-card-affiliate-dashboard-referred-affiliates-last-30-days">
			<div class="slicewp-card-inner">
				<div class="slicewp-card-title">Referred Affiliates</div>
				<div class="slicewp-kpi-value"><?php echo absint( $children_count_last_30_days ); ?></div>
			</div>
		</div>

		<div class="slicewp-card slicewp-card-affiliate-dashboard slicewp-card-affiliate-dashboard-referred-affiliates-all-time">
			<div class="slicewp-card-inner">
				<div class="slicewp-card-title">Referred Affiliates</div>
				<div class="slicewp-kpi-value"><?php echo absint( $children_count_all ); ?></div>
			</div>
		</div>

		<script>
			document.querySelector('.slicewp-grid-affiliate-dashboard-last-30-days').appendChild( document.querySelector( '.slicewp-card-affiliate-dashboard-referred-affiliates-last-30-days'  ) );
			document.querySelector('.slicewp-grid-affiliate-dashboard-all-time').appendChild( document.querySelector( '.slicewp-card-affiliate-dashboard-referred-affiliates-all-time'  ) );
		</script>

		<style>
			.slicewp-grid.slicewp-grid-affiliate-dashboard-last-30-days { grid-template-columns: repeat( auto-fit, minmax( 20%, 1fr ) ); }
			.slicewp-grid.slicewp-grid-affiliate-dashboard-all-time { grid-template-columns: repeat( 5, minmax( 0, 1fr ) ) }
		</style>

	<?php
	
}
add_action( 'slicewp_affiliate_account_tab_dashboard_bottom', 'slicewp_custom_affiliate_account_tab_dashboard_referred_affiliates_cards' );
