// Register the subscription product type
function add_subscription_product_type() {
    class WC_Product_Subscription extends WC_Product {
        public function __construct( $product ) {
            $this->product_type = 'subscription';
            parent::__construct( $product );
        }
    }
}
add_action( 'init', 'add_subscription_product_type' );

// Set the subscription product type in the product data
function set_subscription_product_data( $data ) {
    if ( 'subscription' === $data['product-type'] ) {
        $data['virtual'] = 'yes'; // Set whether the subscription is a virtual product or not
        $data['downloadable'] = 'no'; // Set whether the subscription is downloadable or not
    }
    return $data;
}
add_filter( 'woocommerce_product_data', 'set_subscription_product_data' );

// Enable recurring payments for subscriptions
function enable_subscription_recurring_payments( $sub_id, $subscription ) {
    $subscription->update_dates( array(
        'next_payment' => strtotime( '+1 month', $subscription->get_time( 'next_payment' ) ), // Set the interval for recurring payments (e.g., +1 month).
    ) );
}
add_action( 'woocommerce_subscription_status_pending', 'enable_subscription_recurring_payments', 10, 2 );
