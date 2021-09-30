#This is a code snipet from and for the UWP plugin

add_action( 'uwp_profile_after_title', 'uwp_profile_after_title_cb', 9, 1 );
function uwp_profile_after_title_cb($user_id){
	global $uwp_in_user_loop;
	$user = get_userdata( $user_id );

	if ( ! $uwp_in_user_loop && $user && is_user_logged_in() && isset($user->roles[0]) ) {
		echo '<span>('.$user->roles[0].')</span>';

	}
}
