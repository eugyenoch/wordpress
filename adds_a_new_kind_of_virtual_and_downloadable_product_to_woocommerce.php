// Register the ticket product type
function add_ticket_product_type() {
    class WC_Product_Subscription extends WC_Product {
        public function __construct( $product ) {
            $this->product_type = 'ticket';
            parent::__construct( $product );
        }
    }
}
add_action( 'init', 'add_ticket_product_type' );

// Set the subscription product type in the product data
function set_ticket_product_data( $data ) {
    if ( 'ticket' === $data['product-type'] ) {
        $data['virtual'] = 'yes'; // Set whether the ticket is a virtual product or not
        $data['downloadable'] = 'no'; // Set whether the ticket is downloadable or not
    }
    return $data;
}
add_filter( 'woocommerce_product_data', 'set_ticket_product_data' );
