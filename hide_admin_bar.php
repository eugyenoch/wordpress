#Hides the admin bar from non-admins

if (!current_user_can( 'manage_options' ) ) {
add_filter('show_admin_bar', '__return_false');
}
