$(document).ready(function() {
    // get cart count
    updateCartCount();
    // add to cart
    $('.addToCart').click(function() {
        const btn = $(this);
        const id = $(this).attr('data-product');
        $.ajax({
            type: "POST",
            url: '/addtocart',
            data: {
                CSRFName: $('input[name$="CSRFName"]').val(),
                CSRFToken: $('input[name$="CSRFToken"]').val(),
                product: id
            },
            success: function(data) {
                updateCartCount();
                btn.notify("Added to cart", "success");
            },
            dataType: 'json'
        });
    });
});

function updateCartCount() {
    $.ajax({
        type: "GET",
        url: '/cartcount',
        success: function(data) {
            $('#cartCount').text(data.cartCount);
        },
        dataType: 'json'
    });
}