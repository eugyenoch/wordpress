<?php
/**
 * Plugin Name: WooCommerce QR Code
 * Description: Automatically generate and display QR codes for WooCommerce products with customization and analytics.
 * Version: 1.0
 * Author: Eugy Enoch
 * Text Domain: kadence
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Add QR code to WooCommerce product page
add_action('woocommerce_single_product_summary', 'wc_qr_code_display', 20);

function wc_qr_code_display() {
    global $product;
    $product_id = $product->get_id();
    $product_url = get_permalink($product_id);
    $qr_code_url = add_query_arg('wc_qr_code', $product_id, site_url());
    echo '<div class="wc-qr-code"><img src="' . esc_url($qr_code_url) . '" alt="QR Code" /></div>';
}

// Generate QR code dynamically
add_action('init', 'wc_generate_qr_code');
function wc_generate_qr_code() {
    if (isset($_GET['wc_qr_code'])) {
        $product_id = intval($_GET['wc_qr_code']);
        $product_url = get_permalink($product_id);
        $qr_code_data = urlencode($product_url);
        $qr_code_image = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . $qr_code_data;
        header("Content-Type: image/png");
        echo file_get_contents($qr_code_image);
        exit;
    }
}

// Create settings page
add_action('admin_menu', 'wc_qr_code_settings_page');
function wc_qr_code_settings_page() {
    add_options_page(
        'QR Code Settings',
        'QR Code Settings',
        'manage_options',
        'wc-qr-code-settings',
        'wc_qr_code_settings_page_content'
    );
}

function wc_qr_code_settings_page_content() {
    ?>
    <div class="wrap">
        <h1>QR Code Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('wc_qr_code_settings');
            do_settings_sections('wc_qr_code_settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

add_action('admin_init', 'wc_qr_code_settings_init');
function wc_qr_code_settings_init() {
    register_setting('wc_qr_code_settings', 'wc_qr_code_size');
    register_setting('wc_qr_code_settings', 'wc_qr_code_color');

    add_settings_section(
        'wc_qr_code_settings_section',
        'QR Code Settings',
        'wc_qr_code_settings_section_cb',
        'wc_qr_code_settings'
    );

    add_settings_field(
        'wc_qr_code_size',
        'QR Code Size',
        'wc_qr_code_size_cb',
        'wc_qr_code_settings',
        'wc_qr_code_settings_section'
    );

    add_settings_field(
        'wc_qr_code_color',
        'QR Code Color',
        'wc_qr_code_color_cb',
        'wc_qr_code_settings',
        'wc_qr_code_settings_section'
    );
}

function wc_qr_code_settings_section_cb() {
    echo '<p>Configure the settings for the QR codes.</p>';
}

function wc_qr_code_size_cb() {
    $size = get_option('wc_qr_code_size', '150x150');
    echo '<input type="text" name="wc_qr_code_size" value="' . esc_attr($size) . '" />';
}

function wc_qr_code_color_cb() {
    $color = get_option('wc_qr_code_color', '000000');
    echo '<input type="text" name="wc_qr_code_color" value="' . esc_attr($color) . '" />';
}

// Enqueue custom styles
add_action('wp_enqueue_scripts', 'wc_qr_code_styles');

function wc_qr_code_styles() {
    wp_enqueue_style('wc-qr-code-styles', plugin_dir_url(__FILE__) . 'styles.css');
}

// Create database table for analytics
register_activation_hook(__FILE__, 'wc_qr_code_create_db');
function wc_qr_code_create_db() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'qr_code_scans';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        product_id mediumint(9) NOT NULL,
        scan_time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Track QR code scans
add_action('init', 'wc_track_qr_code_scan');
function wc_track_qr_code_scan() {
    if (isset($_GET['wc_qr_code'])) {
        global $wpdb;
        $product_id = intval($_GET['wc_qr_code']);
        $table_name = $wpdb->prefix . 'qr_code_scans';
        $wpdb->insert(
            $table_name,
            array(
                'product_id' => $product_id,
                'scan_time' => current_time('mysql'),
            )
        );
    }
}
