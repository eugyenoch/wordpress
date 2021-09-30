function no_wordpress_error(){
  return 'Login detail is incorrect, try again!';
}
add_filter( 'login_errors', 'no_wordpress_error' );
