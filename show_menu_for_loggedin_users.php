function my_wp_nav_menu_args( $args = '' ) {
if( is_user_logged_in() ) {
// Logged in menu to display
$args['menu'] = 43;
 
} else {
// Non-logged-in menu to display
$args['menu'] = 35;
}
return $args;
}
add_filter( 'wp_nav_menu_args', 'my_wp_nav_menu_args' );
