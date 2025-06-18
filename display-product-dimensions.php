<?php
/**
 * Plugin Name:       WooCommerce Product Dimensions Table
 * Plugin URI:        https://github.com/microcurse/display-product-dimensions
 * Description:       Displays a WooCommerce Product's dimensions in a table on the product details page.
 * Version:           1.1.0
 * Author:            Marc Maninang
 * Author URI:        https://github.com/microcurse
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wc-product-dimensions-table
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Define plugin constants.
define( 'WCPDT_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

// Include the main class file.
require_once WCPDT_PLUGIN_PATH . 'includes/class-wc-product-dimensions-table.php';

// Initialize the plugin.
function wc_product_dimensions_table_init() {
    new WC_Product_Dimensions_Table();
}
add_action( 'plugins_loaded', 'wc_product_dimensions_table_init' );