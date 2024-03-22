jQuery(document).ready(function($) {
    var maxQuantity = limitCartQuantityData.max_quantity;

    // Modify the "Add to Cart" button behavior
    $('form.cart').on('submit', function(e) {
        var quantity = parseInt($('input.qty').val());
        if (quantity > maxQuantity) {
            e.preventDefault();
            alert('You can only add one item to the cart for this product category.');
        }
    });

    // Modify the quantity input field behavior
    $('input.qty').on('change', function() {
        var quantity = parseInt($(this).val());
        if (quantity > maxQuantity) {
            $(this).val(maxQuantity);
            alert('You can only add one item to the cart for this product category.');
        }
    });
});
