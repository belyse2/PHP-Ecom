$(document).ready(function() {
    // // Handle increment button click
    // $('.increment-btn').on('click', function() {
    //     var $input = $(this).siblings('input');
    //     var currentValue = parseInt($input.val());

    //     if (!isNaN(currentValue)) {
    //         $input.val(currentValue + 1);
    //     } else {
    //         $input.val(1);
    //     }
    // });

    // // Handle decrement button click
    // $('.decrement-btn').on('click', function() {
    //     var $input = $(this).siblings('input');
    //     var currentValue = parseInt($input.val());

    //     if (!isNaN(currentValue) && currentValue > 1) {
    //         $input.val(currentValue - 1);
    //     } else {
    //         $input.val(1);
    //     }
    // });
    //  // Handle add to cart button click
    //  $('.addToCartBtn').on('click', function() {
    //     var quantity = $(this).closest('.row').siblings('.row').find('input').val();
    //     alert('Added ' + quantity + ' item(s) to the cart.');
    //     // You can add your AJAX call here to send the quantity to the server
    // });

    // // Handle add to wishlist button click
    // $('.btn-danger').on('click', function() {
    //     alert('Added item to the wishlist.');
    //     // You can add your AJAX call here to send the item to the wishlist
    // });
});
$(document).ready(function() {

    $('.increment-btn').click(function(e)
    {
        e.preventDefault();
        var qty =$(this).closest('.product-data').find('.input-qty').val();
        
        var value = parseInt(qty,10);
        value = isNaN(value)? 0 : value ;
        if (value < 10)
            {
            value++;
            // $('.input-qty').val(value);
            var qty =$(this).closest('.product-data').find('.input-qty').val(value);
        }
    });
    $('.decrement-btn').click(function(e)
    {
        e.preventDefault();
        var qty =$(this).closest('.product-data').find('.input-qty').val();
        
        var value = parseInt(qty,10);
        value = isNaN(value)? 0 : value ;
        if (value > 1)
            {
            value--;
            // $('.input-qty').val(value);
            var qty =$(this).closest('.product-data').find('.input-qty').val(value);
        }
    });
     // Handle add to cart button click
     $('.addToCartBtn').click(function(e) {
        e.preventDefault();
        var qty = $(this).closest('.product-data').find('.input-qty').val();
        var prod_id = $(this).val();

        $.ajax({
            method: "POST",
            url: "functions/handlecart.php",
            data: {
                "prod_id": prod_id,
                "prod_qty": qty,
                "scope": "add"
            },
            dataType: "json",
            success: function(response) {
                if (response.status == 201) {
                    alertify.success(response.message);
                } else if (response.status == 203) {
                    alertify.message(response.message);
                } else if (response.status == 401) {
                    alertify.error(response.message);
                } else if (response.status == 500) {
                    alertify.error(response.message);
                }
            }
        });
    });
});