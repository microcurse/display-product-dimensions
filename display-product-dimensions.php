<?php

/*
Plugin Name: WooCommerce Product Dimensions Table
Description: Displays a WooCommerce Product's dimensions in a table under the short description of the product details page.
Version: 1.0.0
Author: Marc M.
*/

// Register a hook to display the product dimensions table under the short description.
add_action( 'woocommerce_single_product_summary', 'wc_product_dimensions_table', 25 );
add_action( 'woocommerce_single_product_summary', 'wc_product_dimensions_enqueue_style' );

function wc_product_dimensions_enqueue_style() {
  wp_enqueue_style( 'wc-product-dimensions-table', plugins_url( 'display-product-dimensions/css/wc-product-dimensions-table.css', dirname( __FILE__ ) ) );
}

/**
 * Displays a WooCommerce Product's dimensions in a table under the short description of
 * the product details page.
 *
 * @param WC_Product $product The product object.
 */
function wc_product_dimensions_table($product) {
  global $product;
    // Get the product dimensions.
  $formatted = false;
  $dimensions = $product->get_dimensions($formatted);
  $weight = $product->get_weight();

  // If the product has dimensions, display them in a table.
  if ($dimensions) {
    echo '<h3 class="section-title">Overall Product Dimensions</h3>';
    echo '<table class="product_dimensions">';
    echo '<tr>';
    foreach ($dimensions as $dimension_name => $dimension_value) {
      echo '<th>' . esc_html($dimension_name) . '</th>';
    }
  
    // Add a new table header for the weight column.
    echo '<th>Weight</th>';
    echo '</tr>';
    echo '<tr>';
    foreach ($dimensions as $dimension_name => $dimension_value) {
      echo '<td>' . esc_html($dimension_value) . '"' . '</td>';
    }
  
    // Add a new table data cell for the weight column.
    echo '<td>' . esc_html($weight) . ' lbs' . '</td>';
    echo '</tr>';
    echo '</table>';
  }
}

?>
