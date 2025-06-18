<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class WC_Product_Dimensions_Table {

    public function __construct() {
        // Using a priority of 25 to appear after the short description.
        add_action( 'woocommerce_before_add_to_cart_form', array( $this, 'display_dimensions_table' ), 25 );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
    }

    public function enqueue_scripts() {
        if ( ! is_product() ) {
            return;
        }

        wp_enqueue_style( 'wc-product-dimensions-table', plugin_dir_url( dirname( __FILE__ ) ) . 'css/wc-product-dimensions-table.css' );
        wp_enqueue_script( 'wc-product-dimensions-script', plugin_dir_url( dirname( __FILE__ ) ) . 'js/display-product-dimensions.js', array( 'jquery' ), '1.0.1', true );

        $product = wc_get_product();
        if ( ! $product ) {
            return;
        }

        $variation_data = array();
        if ( $product->is_type( 'variable' ) && is_a( $product, 'WC_Product_Variable' ) ) {
            $variations = $product->get_available_variations();
            foreach ( $variations as $variation ) {
                if ( isset( $variation['variation_id'] ) ) {
                    $variation_data[ $variation['variation_id'] ] = array(
                        'dimensions' => $variation['dimensions'],
                        'weight'     => $variation['weight'],
                    );
                }
            }
        }
        
        wp_localize_script( 'wc-product-dimensions-script', 'product_variations', $variation_data );
    }

    public function display_dimensions_table() {
        global $product;

        if ( ! is_a( $product, 'WC_Product' ) ) {
            $product = wc_get_product();
        }

        if ( ! is_a( $product, 'WC_Product' ) ) {
            return;
        }
        
        $dimensions = $product->get_dimensions( false );
        $weight     = $product->get_weight();

        // For simple products, don't display table if any dimension is missing.
        if ( $product->is_type( 'simple' ) ) {
            foreach ($dimensions as $dimension_value) {
                if (empty($dimension_value)) {
                    return;
                }
            }
        }
        
        // Don't display if there are no dimensions and no weight.
        if ( empty( $dimensions ) && ! $weight ) {
            return;
        }

        // Reorder the dimensions to 'width', 'length', 'height'
        $reordered_dimensions = array();
        if(!empty($dimensions)){
            $reordered_dimensions = array(
                'width' => $dimensions['width'],
                'length' => $dimensions['length'],
                'height' => $dimensions['height'],
            );
        }

        $template_args = array(
            'product'      => $product,
            'dimensions'   => $reordered_dimensions,
            'weight'       => $weight,
            'is_variable'  => $product->is_type( 'variable' ),
        );

        $this->include_template( 'product-dimensions-table.php', $template_args );
    }
    
    private function include_template( $template_name, $args = array() ) {
        $template_path = plugin_dir_path( dirname( __FILE__ ) ) . 'templates/' . $template_name;
        if ( file_exists( $template_path ) ) {
            extract( $args );
            include $template_path;
        }
    }
} 