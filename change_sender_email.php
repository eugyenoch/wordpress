#Function to change sender email address
#change 'EMAIL@DOMAIN.COM' to sender email
#change 'COMPANY NAME' to yours

function wpb_sender_email( $original_email_address ) {
    return 'EMAIL@DOMAIN.COM';
}
 
// Function to change sender name
function wpb_sender_name( $original_email_from ) {
    return 'COMPANY NAME';
}
 
// Hooking up our functions to WordPress filters 
add_filter( 'wp_mail_from', 'wpb_sender_email' );
add_filter( 'wp_mail_from_name', 'wpb_sender_name' );
