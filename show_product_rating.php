add_filter( 'woocommerce_product_get_rating_html', 'ecommercehints_show_rating_count_on_product_archive', 20, 3 );
function ecommercehints_show_rating_count_on_product_archive( $html, $rating, $count ) {
	global $product;
	$rating_count = $product->get_rating_count();
	if (is_product_category() || is_shop()) {
		if ($rating_count == 1) {
			$html .= "<div class='ecommercehints_rating_count'>(" . $product->get_rating_count() . " Review)</div>";
		} else {
			$html .= "<div class='ecommercehints_rating_count'>(" . $product->get_rating_count() . " Reviews)</div>";
		}
	}
	return $html;
}
