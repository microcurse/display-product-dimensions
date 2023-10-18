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
add_action( 'wp_enqueue_scripts', 'wc_product_dimensions_enqueue_script' );

function wc_product_dimensions_enqueue_style() {
  wp_enqueue_style( 'wc-product-dimensions-table', plugins_url( 'display-product-dimensions/css/wc-product-dimensions-table.css', dirname( __FILE__ ) ) );
}

function wc_product_dimensions_enqueue_script() {
  wp_enqueue_script('wc-product-dimensions-script', plugins_url('js/display-product-dimensions.js', __FILE__), array('jquery'), '1.0', true);

  $variation_data = array(); // Initialize an array to store variation data.

  if (is_product() && $product = wc_get_product()) {
      if ($product->is_type('variable')) {
          $variations = $product->get_available_variations();
          foreach ($variations as $variation) {
              $variation_data[$variation['variation_id']] = array(
                  'dimensions' => $variation['dimensions'],
                  'weight' => $variation['weight'],
              );
          }
      }
  }

  // Pass the variation data to the JavaScript.
  wp_localize_script('wc-product-dimensions-script', 'product_variations', $variation_data);
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

  // Check if dimensions and weight are empty.
  $dimensions_empty = empty($dimensions);
  $weight_empty = empty($weight);

  // Check if the product is variable.
  if ($product->is_type('variable')) {

      // If either dimensions or weight is not empty, display the table.
      if (!$dimensions_empty || !$weight_empty) {
          echo '<h3 class="section-title">Overall Product Dimensions</h3>';
          echo '<table class="product_dimensions_summary">';
          echo '<tr>';

          if (!$dimensions_empty) {
              foreach ($dimensions as $dimension_name => $dimension_value) {
                  echo '<th>' . esc_html($dimension_name) . '</th>';
              }
          }

          if (!$weight_empty) {
              echo '<th>Weight</th>';
          }

          echo '</tr>';
          echo '<tr>';

          if (!$dimensions_empty) {
              foreach ($dimensions as $dimension_name => $dimension_value) {
                  echo '<td id="dimension_' . esc_attr($dimension_name) . '"></td>';
              }
          }

          if (!$weight_empty) {
              echo '<td id="product_weight"></td>';
          }

          echo '</tr>';
          echo '</table>';
      }
  } else {
      // Handle simple products.
      $formatted = false;
      $dimensions = $product->get_dimensions($formatted);
      $weight = $product->get_weight();

      echo '<h3 class="section-title">Overall Product Dimensions</h3>';
      echo '<table class="product_dimensions_summary">';
      echo '<tr>';

      foreach ($dimensions as $dimension_name => $dimension_value) {
          echo '<th>' . esc_html($dimension_name) . '</th>';
      }

      if (!$weight_empty) {
          echo '<th>Weight</th>';
      }
      echo '</tr>';
      echo '<tr>';

      foreach ($dimensions as $dimension_name => $dimension_value) {
          echo '<td>' . esc_html($dimension_value) . '"' . '</td>';
      }

      if (!$weight_empty) {
          echo '<td id="product_weight"></td>';
      }
      echo '</tr>';
      echo '</table>';
  }
}


?>
