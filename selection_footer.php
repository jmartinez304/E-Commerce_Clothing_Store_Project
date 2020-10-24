<?php
require 'footer.php';
?>

<!-- jQuery -->

<script>

    /* Adding item to cart */
    $(document).ready(function (data) {
        $('.add_to_cart').click(function () {
            var product_id = $(this).attr("id");
            var product_name = $('#name' + product_id).val();
            var product_price = $('#price' + product_id).val();
            var product_color = $('#color' + product_id).val();
            var product_size = $('#size' + product_id).val();
            var product_quantity = Math.round(($('#quantity' + product_id).val()).replace(/[^1-9\.]/g, ''));
            var action = "add";
            if (product_quantity > 0) {
                $.ajax({
                    url: "action.php",
                    method: "POST",
                    dataType: "json",
                    data: {
                        product_id: product_id,
                        product_name: product_name,
                        product_price: product_price,
                        product_quantity: product_quantity,
                        product_color: product_color,
                        product_size: product_size,
                        action: action
                    },
                    success: function (data) {
                        $('#order_table').html(data.order_table);
                        $('.badge').text(data.cart_item);
                        alert("Product has been added into Cart");
                    },
                    error: function (data) {
                        alert("This item is not available with this size and color");
                    }
                });
            } else {
                alert("Please enter number of quantity");
            }
        });

        /* Deleting item from cart */
        $(document).on('click', '.delete', function () {
            var product_id = $(this).data("product_id");
            var product_color = $(this).data("product_color");
            var product_size = $(this).data("product_size");
            var action = "remove";
            if (confirm("Are you sure you want to remove this product?")) {
                $.ajax({
                    url: "action.php",
                    method: "POST",
                    dataType: "json",
                    data: {
                        product_id: product_id,
                        product_color: product_color,
                        product_size: product_size,
                        action: action
                    },
                    success: function (data) {
                        $('#order_table').html(data.order_table);
                        $('.badge').text(data.cart_item);
                    }
                });
            } else {
                return false;
            }
        });

        /* Changing quantity of cart item */
        $(document).on('keyup', '.quantity', function () {
            var product_id = $(this).data("product_id");
            var quantity = ($(this).val()).replace(/[^0-9\.]/g, '');
            var product_color = $(this).data("product_color");
            var product_size = $(this).data("product_size");
            var action = "quantity_change";
            if (quantity != '' && quantity > 0) {
                $.ajax({
                    url: "action.php",
                    method: "POST",
                    dataType: "json",
                    data: {
                        product_id: product_id,
                        quantity: quantity,
                        product_color: product_color,
                        product_size: product_size,
                        action: action
                    },
                    success: function (data) {
                        $('#order_table').html(data.order_table);
                    }
                });
            } else {
                alert("Please enter number of quantity");
            }
        });
    })
    ;
</script>