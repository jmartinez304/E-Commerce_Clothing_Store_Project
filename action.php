<?php
//action.php
session_start([
    'cookie_lifetime' => 86400,
]);
require 'db.php';
if (isset($_POST["product_id"])) {
    $order_table = '';
    $message = '';

    /* Add conditions */
    if ($_POST["action"] == "add") {

        /* Query to verify that combination exists in database */
        $query = '
SELECT variations.variation_id
FROM variations
JOIN sizes
ON variations.size_id = sizes.size_id
JOIN colors
ON variations.color_id = colors.color_id
WHERE product_id = ' . $_POST['product_id'] . ' 
AND size_name = "' . $_POST['product_size'] . '" 
AND color_name = "' . $_POST['product_color'] . '"';

        $query_result = $mysqli->query($query);

        /* If items are retrieved from the database add them to the cart if it exists, and create a new cart cookie if it does not exist */
        if ($query_result->num_rows > 0) {
            if (isset($_SESSION["shopping_cart"])) {
                $is_available = 0;
                foreach ($_SESSION["shopping_cart"] as $keys => $values) {
                    if ($_SESSION["shopping_cart"][$keys]['product_id'] == $_POST["product_id"] &&
                        $_SESSION["shopping_cart"][$keys]['product_color'] == $_POST["product_color"] &&
                        $_SESSION["shopping_cart"][$keys]['product_size'] == $_POST["product_size"]) {
                        $is_available++;
                        $_SESSION["shopping_cart"][$keys]['product_quantity'] = $_SESSION["shopping_cart"][$keys]['product_quantity'] + $_POST["product_quantity"];
                    }
                }
                if ($is_available < 1) {
                    $item_array = array(
                        'product_id' => $_POST["product_id"],
                        'product_name' => $_POST["product_name"],
                        'product_price' => $_POST["product_price"],
                        'product_color' => $_POST["product_color"],
                        'product_size' => $_POST["product_size"],
                        'product_quantity' => $_POST["product_quantity"]
                    );
                    $_SESSION["shopping_cart"][] = $item_array;
                }
            } else {
                $item_array = array(
                    'product_id' => $_POST["product_id"],
                    'product_name' => $_POST["product_name"],
                    'product_price' => $_POST["product_price"],
                    'product_color' => $_POST["product_color"],
                    'product_size' => $_POST["product_size"],
                    'product_quantity' => $_POST["product_quantity"]
                );
                $_SESSION["shopping_cart"][] = $item_array;
            }
        } else {
            die();
        }
    }

    /* Remove items from cart and if there are no more items in the cart then the cart cookie gets deleted*/
    if ($_POST["action"] == "remove") {
        foreach ($_SESSION["shopping_cart"] as $keys => $values) {
            if ($values["product_id"] == $_POST["product_id"] &&
                $values["product_color"] == $_POST["product_color"] &&
                $values["product_size"] == $_POST["product_size"]) {
                unset($_SESSION["shopping_cart"][$keys]);
                $message = '<h2 class="cartEmpty"><strong>Product removed</strong></h2>';
            }
        }
    }

    /* Quantity change conditions */
    if ($_POST["action"] == "quantity_change") {
        foreach ($_SESSION["shopping_cart"] as $keys => $values) {
            if ($_SESSION["shopping_cart"][$keys]['product_id'] == $_POST["product_id"] &&
                $values["product_color"] == $_POST["product_color"] &&
                $values["product_size"] == $_POST["product_size"]) {
                $_SESSION["shopping_cart"][$keys]['product_quantity'] = $_POST["quantity"];
            }
        }
    }

    /* This section is for use when Ajax commands to repopulate the cart table when there is a change in quantity or a currency gets deleted*/
    $order_table .= '  
           ' . $message . '  
           <table>  
                <tr>
                     <th width="40%">Product Name</th>
                     <th width="10%">Color</th>
                     <th width="10%">Size</th>
                     <th width="10%">Quantity</th>
                     <th width="20%">Price</th>
                     <th width="15%">Total</th>
                     <th width="5%">Action</th>
                </tr>
           ';
    if (!empty($_SESSION["shopping_cart"])) {
        $total = 0;
        $subtotal = 0;
        $tax = 0;
        foreach ($_SESSION["shopping_cart"] as $keys => $values) {
            $order_table .= '  
                     <tr>  
                          <td>' . $values["product_name"] . '</td>
                          <td>' . $values["product_color"] . '</td>
                          <input type="hidden" name="hidden_color"
                                 id="color' . $values['product_id'] . '"
                                 value="' . $values['product_color'] . '"/>
                          <td>' . $values["product_size"] . '</td>
                          <input type="hidden" name="hidden_size"
                                 id="size' . $values['product_id'] . '"
                                 value="' . $values['product_size'] . '"/>
                          <td><input type="text" name="quantity[]" 
                          id="quantity' . $values["product_id"] . $values["product_color"] . $values["product_size"] . '" 
                          value="' . $values["product_quantity"] . '" 
                          class="textQuantity quantity" 
                          data-product_id="' . $values["product_id"] . '" 
                          data-product_color="' . $values["product_color"] . '" 
                          data-product_size="' . $values["product_size"] . '" 
                          /></td>  
                          <td align="right">$' . $values["product_price"] . '</td>  
                          <td align="right">$' . number_format($values["product_quantity"] * $values["product_price"], 2) . '</td>  
                          <td><button name="delete" class="deleteButton delete" id="' . $values["product_id"] . '"
                          data-product_id="' . $values["product_id"] . '" 
                          data-product_color="' . $values["product_color"] . '" 
                          data-product_size="' . $values["product_size"] . '" 
                          >Remove</button></td>  
                     </tr>  
                ';
            $subtotal = $subtotal + ($values['product_quantity'] * $values['product_price']);
            $tax = $tax + (($values['product_quantity'] * $values['product_price']) * 0.07);
            $total = $subtotal + $tax;
            $_SESSION['total_price'] = $total;
        }
        $order_table .= '  
                <tr>  
                            <td colspan="5" align="right">Subtotal<br></br>Tax (7%)<br><br>Order Total</td>
                            <td align="right">$' . number_format($subtotal, 2) . '<br><br>$' . number_format($tax, 2) . '<br><br>$' . number_format($total, 2) . '</td>
                            <td></td>
                </tr>  
                <tr>  
                     <td colspan="7" align="center">  
                                <button id="goToCheckout" class="submitButton submit-button">Checkout</button>
                                <script type="text/javascript">
                                    document.getElementById("goToCheckout").onclick = function () {
                                        var total =  "' . $total . '";
                                        if (total > 0 && total <= 9999999) {
                                            location.href = "checkout.php";
                                        } else {
                                            alert("This is an invalid order");
                                        }
                                    };
                                </script>
                     </td>  
                </tr>  
           ';
    }
    $order_table .= '</table>';
    $output = array(
        'order_table' => $order_table,
        'cart_item' => count($_SESSION["shopping_cart"])
    );
    echo json_encode($output);
} else {
    echo("<h2 class=\"cartEmpty\">Cart is empty</h2>");
}
