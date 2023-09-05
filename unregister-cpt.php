#Unregsiter CPT from diveinwp.com

function diwp_unregister_custom_post_type(){

	unregister_post_type( 'your-post-type-name' ); // replace custom post type name
}

add_action( 'init', 'diwp_unregister_custom_post_type' );
