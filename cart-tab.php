<?php
require 'selection_header.php';
?>

    <div class="sec-MCR">
        <span class="title2">Select your Style</span>
        <hr class="one">

        <div class="container-Menu">
            <div class="container-Tabs">
                <a class="tabs" href="index.php">All Products</a>
                <a class="tabs" href="cart-tab.php" style="background-color: khaki;">Cart <span class="badge">
                    <?php if (isset($_SESSION["shopping_cart"])) {
                        echo count($_SESSION["shopping_cart"]);
                    } else {
                        echo '0';
                    } ?></span>
                </a>
            </div>


            <!-- Cart Table -->
            <div id="cart" class="container-Products">
                <div id="order_table" class="pro-animate">
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
                        <?php
                        if (!empty($_SESSION['shopping_cart'])) {

                            $total = 0;
                            $subtotal = 0;
                            $tax = 0;
                            foreach ($_SESSION['shopping_cart'] as $keys => $values) {
                                ?>
                                <tr>
                                    <td><?php echo $values["product_name"]; ?></td>
                                    <td><?php echo $values["product_color"]; ?></td>
                                    <input type="hidden" name="hidden_color"
                                           id="color<?php echo $values['product_id']; ?>"
                                           value="<?php echo $values['product_color']; ?>"/>
                                    <td><?php echo $values["product_size"]; ?></td>
                                    <input type="hidden" name="hidden_size"
                                           id="size<?php echo $values['product_id']; ?>"
                                           value="<?php echo $values['product_size']; ?>"/>
                                    <td><input type="text" name="quantity[]"
                                               id="quantity<?php echo $values["product_id"];
                                               echo $values['product_color'];
                                               echo $values['product_size']; ?>"
                                               value="<?php echo $values["product_quantity"]; ?>"
                                               data-product_id="<?php echo $values["product_id"]; ?>"
                                               data-product_color="<?php echo $values['product_color']; ?>"
                                               data-product_size="<?php echo $values['product_size']; ?>"
                                               class="textQuantity quantity"/></td>
                                    <td align="right">$<?php echo $values["product_price"]; ?></td>
                                    <td align="right">
                                        $<?php echo number_format($values["product_quantity"] * $values["product_price"], 2); ?></td>
                                    <td>
                                        <button name="delete" class="deleteButton delete"
                                                id="<?php echo $values["product_id"]; ?>"
                                                data-product_id="<?php echo $values["product_id"]; ?>"
                                                data-product_color="<?php echo $values['product_color']; ?>"
                                                data-product_size="<?php echo $values['product_size']; ?>"
                                        >Remove
                                        </button>
                                    </td>
                                </tr>
                                <?php
                                $subtotal = $subtotal + ($values['product_quantity'] * $values['product_price']);
                                $tax = $tax + (($values['product_quantity'] * $values['product_price']) * 0.07);
                                $total = $subtotal + $tax;
                                $_SESSION['total_price'] = $total;
                            }
                            ?>
                            <tr>
                                <td colspan="5" align="right">Subtotal<br><br>Tax (7%)<br><br>Order Total</td>
                                <td align="right">$<?php echo number_format($subtotal, 2); ?>
                                    <br><br>$<?php echo number_format($tax, 2); ?>
                                    <br><br>$<?php echo number_format($total, 2); ?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <!-- Show checkout button only if the shopping cart is not empty -->
                                <td colspan="7" align="center">
                                    <button id="goToCheckout" class="submitButton submit-button">Checkout</button>
                                    <script type="text/javascript">
                                        //Checkout button will not let user advance unless they have a valid amount in the order
                                        document.getElementById("goToCheckout").onclick = function () {
                                            var total = "<?php echo $total ?>";
                                            if (total > 0 && total <= 9999999) {
                                                location.href = "checkout.php";
                                            } else {
                                                alert("This is an invalid order");
                                            }
                                        };
                                    </script>
                                </td>
                            </tr>
                            <?php
                        } else {
                            echo("<h2 class=\"cartEmpty\">Cart is empty</h2>");
                            ?>
                            <style type="text/css">table {
                                    display: none;
                                }</style>
                            <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <a href="javascript:" id="return-to-top"><i class="fa fa-angle-double-up"></i></a>

<?php
require 'selection_footer.php';
?>