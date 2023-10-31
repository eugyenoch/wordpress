// Customize WPCargo Track form header label
add_filter('wpcargo_tn_form_title', function(){
    return 'Enter your Consignment No.';
});
 
// Customize WPCargo Track form sample text
add_filter('wpcargo_example_text', function(){
    $text = '<tr class="track_form_tr">';
    $text .= '<td class="track_form_td" colspan="2">';
    $text .= '<h6>Powered by my Cargo </h6>';
    $text .= '</td>';
    $text .= '</tr>';
    return $text;
});
 
// Customize WPCargo Track form submit button label
add_action('wpcargo_tn_submit_val', function(){
    return 'TRACK MY CARGO';
});
 
// Customize WPCargo Track form Additional information
add_action('wpcargo_add_form_fields', function(){
    $text = '<tr>';
    $text .= '<td>';
    $text .= 'Use the form to view the movement of your cargo item with us from shipping to point of delivery.';
    $text .= '</td>';
    $text .= '</tr>';
    echo $text;
});
 
// Customize WPCargo Track form Placeholder information
add_filter('wpcargo_tn_placeholder', function(){
    return 'EX: CARGO20202020-ITEM';
});
