#Code from diveinwp.com

function diwp_remove_all_posts(){

$getallposts = get_posts( 
			array(
				'post_type'=>'your-custom-post-type', // Replace with your custom post type.
				'numberposts'=>'-1' // number of posts to remove, '-1' to remove all posts.
			     ) 
			);

	foreach ($getallposts as $singlepost) {
		wp_delete_post( $singlepost->ID, true );
	}
}

add_action( 'init', 'diwp_remove_all_posts' );
