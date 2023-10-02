add_action ('woocommerce_product_options_advanced', 'ecommercehints_product_data_metabox');
function ecommercehints_product_data_metabox() {
   echo '<div class="options_group">';
   woocommerce_wp_text_input (array (
      'id'                => 'demo_url',
      'value'             => get_post_meta (get_the_ID(), 'demo_url', true),
      'label'             => 'Demo URL',
      'description'       => 'The button link'
  ));
   echo '</div>';
}

add_action ('woocommerce_process_product_meta', 'ecommercehints_save_field_on_update', 10, 2);
function ecommercehints_save_field_on_update ($id, $post) {
      update_post_meta ($id, 'demo_url', $_POST['demo_url']);
}

function ecommercehints_content_after_add_to_cart_form() {
   global $product;
   $demo_url = $product->get_meta ('demo_url');
   echo '<a class="button" href="' . $demo_url . '" target="_blank">View Demo</a>';
};

add_action ('woocommerce_after_add_to_cart_form', 'ecommercehints_content_after_add_to_cart_form', 10, 0);
