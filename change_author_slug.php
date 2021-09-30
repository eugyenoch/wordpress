#change 'author' to 'profile'
#you may use anything else you wish, simply change 'profile' to whatever you wish

add_action('init', 'cng_author_base');
function cng_author_base() {
    global $wp_rewrite;
    $author_slug = 'profile'; // change slug name
    $wp_rewrite->author_base = $author_slug;
}
