// Add the new field
add_action( 'woocommerce_before_add_to_cart_button', 'ecommercehints_custom_product_checkbox_field' );

function ecommercehints_custom_product_checkbox_field() {
   echo '<div class="ecommercehints_custom_product_checkbox_field">
      <label for="is-gift-checkbox">Is this a gift? </label>
      <input type="checkbox" id="is-gift-checkbox" name="is-gift-checkbox" value="Yes">
   </div>';
}

// Save the field to the cart data
add_filter( 'woocommerce_add_cart_item_data', 'ecommercehints_save_custom_checkbox_to_cart_data', 10, 3 );
function ecommercehints_save_custom_checkbox_to_cart_data( $cart_item_data, $product_id, $variation_id ) {
   if ( !empty( $_POST['is-gift-checkbox'] ) ) {
      $cart_item_data['is-gift-checkbox'] = sanitize_text_field( $_POST['is-gift-checkbox']);
   }
   return $cart_item_data;
}

// Show custom field data on cart, checkout, and thank you page.
add_filter( 'woocommerce_get_item_data', 'ecommercehints_show_custom_field_data_under_product_name', 10, 2 );
function ecommercehints_show_custom_field_data_under_product_name( $item_data, $cart_item ) {

   if ( !empty( $cart_item['is-gift-checkbox'] ) ) {
      $item_data[] = array(
         'key'     => 'Is this a gift?',
         'value'   => $cart_item['is-gift-checkbox'],
      );
   }
   return $item_data;
}

// Save the custom field data as order meta
add_action( 'woocommerce_checkout_create_order_line_item', 'ecommercehints_add_custom_field_data_as_order_meta', 10, 4 );
function ecommercehints_add_custom_field_data_as_order_meta( $item, $cart_item_key, $values, $order ) {
   if ( !empty( $values['is-gift-checkbox'] ) ) {
      $item->add_meta_data( 'Is this a gift?', $values['is-gift-checkbox'] );
   }
}
