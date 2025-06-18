<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$has_dimensions = ! empty( $dimensions );
$has_weight = ! empty( $weight );

?>
<div class="product_dimensions_summary_container">
    <span><strong>Overall Product Dimensions</strong></span>
    <table class="product_dimensions_summary">
        <thead>
            <tr>
                <?php if ( $has_dimensions ) : ?>
                    <?php foreach ( array_keys($dimensions) as $dimension_name ) : ?>
                        <th><?php echo esc_html( $dimension_name ); ?></th>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php if ( $has_weight ) : ?>
                    <th>Weight</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php if ( $has_dimensions ) : ?>
                    <?php foreach ( $dimensions as $dimension_name => $dimension_value ) : ?>
                        <td id="<?php echo $is_variable ? 'dimension_' . esc_attr( $dimension_name ) : ''; ?>">
                            <?php 
                            if ( ! $is_variable && ! empty( $dimension_value ) ) {
                                echo esc_html( $dimension_value ) . '"';
                            }
                            ?>
                        </td>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php if ( $has_weight ) : ?>
                    <td id="<?php echo $is_variable ? 'product_weight' : ''; ?>">
                        <?php 
                        if ( ! $is_variable && ! empty( $weight ) ) {
                            echo esc_html( $weight ) . ' lbs';
                        }
                        ?>
                    </td>
                <?php endif; ?>
            </tr>
        </tbody>
    </table>
</div> 