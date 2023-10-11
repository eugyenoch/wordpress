function restrict_pages_to_loggedin_users() {
   if ( ! is_user_logged_in() && is_page( array( 'page1', 'page2', 'page3' ) ) ) {
      wp_redirect( wp_login_url() );
      exit;
   }
}
add_action( 'template_redirect', 'restrict_pages_to_loggedin_users' );
