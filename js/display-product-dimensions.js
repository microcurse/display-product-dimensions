jQuery(function($) {
    $(document).ready(function() {
        $('.variations_form').on('show_variation', function(event, variation) {
            // Access the variation data from the JavaScript object.
            var dimensions = variation.dimensions;
            var weight = variation.weight;

            // Update the product dimensions.
            for (var dimension_name in dimensions) {
                if (dimensions.hasOwnProperty(dimension_name)) {
                    var dimensionValue = dimensions[dimension_name];
                    $('#dimension_' + dimension_name).text(dimensionValue + '"');
                }
            }

            // Update the product weight.
            $('#product_weight').text(weight + ' lbs');
        });
    });
});
