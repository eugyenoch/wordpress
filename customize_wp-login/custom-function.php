<?php
/*add the following code to your theme functions.php file*/
function custom_login_styles() {
    wp_enqueue_style('custom-login', get_stylesheet_directory_uri() . '/custom-login.css');
}
add_action('login_enqueue_scripts', 'custom_login_styles');

?>
