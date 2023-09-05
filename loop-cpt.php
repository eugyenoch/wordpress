<?php 
/*
*By querying the database, you can retrieve items from a custom post type.
*Copy the following code snippet into the template where you wish to display the custom post type.
*This code defines the post type and number of posts per page in the arguments for our new WP_Query class. 
*It then runs the query, retrieves the posts, and displays them inside the loop.
*/
$args = array( 'post_type' => 'jobs', 'posts_per_page' => 10 );
$the_query = new WP_Query( $args ); 
?>
<?php if ( $the_query->have_posts() ) : ?>
<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
<h2><?php the_title(); ?></h2>
<div class="entry-content">
<?php the_content(); ?> 
</div>
<?php endwhile;
wp_reset_postdata(); ?>
<?php else:  ?>
<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>
