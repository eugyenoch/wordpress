#removes the footer credit on the wp-admin dashboard

function remove_footer_admin () { 
echo '&copy;&nbsp;YOUR TEXT HERE'; 
} 
add_filter('admin_footer_text', 'remove_footer_admin'); 
