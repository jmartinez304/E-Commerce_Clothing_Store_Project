<?php
require 'selection_header.php';
?>

    <div class="sec-MCR">
        <div class="sec-animate">
            <span class="title2">Thanks for your order!</span>
            <hr class="one">

            <?php

            /* Saving user inputs and inserting them into the database */

            if (isset($_POST["place_order"])) {
                $email = $_POST['email'];
                $first_name = $_POST['firstName'];
                $last_name = $_POST['lastName'];
                $address = $_POST['address'];
                $city = $_POST['city'];
                $region = $_POST['region'];
                $country = $_POST['country'];
                $postal_code = $_POST['postalCode'];
                $phone_number = $_POST['phoneNumber'];
                $total_price = $_SESSION['total_price'];

                // Using prepared statement to insert customer information to database
                $insert_customer = $mysqli->prepare("INSERT INTO customers
                 (customer_first_name, customer_last_name, customer_phone, customer_address, customer_city,
                  customer_state, customer_postal_code, customer_country, customer_email)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $insert_customer->bind_param("sssssssss", $first_name, $last_name, $phone_number, $address,
                    $city, $region, $postal_code, $country, $email);
                $customer_id = "";
                if ($insert_customer->execute()) {
                    $customer_id = $mysqli->insert_id;
                } else {
                    echo "Error entering values into database: " . $mysqli->error . "<br>";
                }

                // Generating random receipt code
                $receipt_code = abs(crc32(uniqid()));

                /* Inserting order into database */

                $insert_order = "  
                             INSERT INTO orders(customer_id, order_submitted_date, order_required_date, order_receipt_code, order_total_price)  
                             VALUES('" . $customer_id . "', '" . date('Y-m-d H:i:s') . "', '" . date("Y-m-d", strtotime("+1 week")) . "', '" . $receipt_code . "',  '" . $_SESSION['total_price'] . "')
                             ";
                $order_id = "";
                if ($mysqli->query($insert_order)) {
                    $order_id = $mysqli->insert_id;
                } else {
                    echo "Error entering values into database: " . $mysqli->error . "<br>";
                }
                $_SESSION["order_id"] = $order_id;
                $order_details = "";

                /* Inserting order details into database */

                foreach ($_SESSION["shopping_cart"] as $keys => $values) {


                    $query = '
SELECT variations.variation_id
FROM variations
JOIN sizes
ON variations.size_id = sizes.size_id
JOIN colors
ON variations.color_id = colors.color_id
WHERE product_id = ' . $values['product_id'] . ' AND size_name = "' . $values['product_size'] . '" AND color_name = "' . $values['product_color'] . '" ';

                    if ($result = $mysqli->query($query)) {
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $variation_id = $row['variation_id'];
                            }
                        }
                    }

                    $order_details .= "  
                                  INSERT INTO order_lines(order_id, variation_id, order_product_quantity)  
                                  VALUES('" . $order_id . "', '" . $variation_id . "', '" . $values["product_quantity"] . "');  
                                  ";
                }
                if ($mysqli->multi_query($order_details)) {
                    unset($_SESSION["shopping_cart"]);
                    echo '<script>alert("You have successfully placed an order... Thank you!")</script>';
                    echo '<script>window.location.href="receipt.php"</script>';
                } else {
                    echo "Error entering values into database: " . $mysqli->error . "<br>";
                }
            }

            /* Obtaining the details from the order that was just inserted in order to generate the receipt */

            if (isset($_SESSION["order_id"])) {
                $customer_details = '';
                $order_details = '';
                $total = 0;
                $subtotal = 0;
                $tax = 0;
                $query = '  
                             SELECT * FROM orders  
                             INNER JOIN customers  
                             ON customers.customer_id = orders.customer_id 
                             WHERE orders.order_id = "' . $_SESSION["order_id"] . '"  
                             ';
                $result = $mysqli->query($query);
                while ($row = mysqli_fetch_array($result)) {
                    $customer_details = '  
                                  <label>' . $row["customer_last_name"] . ', ' . $row["customer_first_name"] . '</label><br> 
                                  <p>' . $row["customer_address"] . '</p>  
                                  <p>' . $row["customer_city"] . ', ' . $row["customer_postal_code"] . '</p>  
                                  <p>' . $row["customer_country"] . '</p>   
                                  ';
                    $receipt_code = $row["order_receipt_code"];
                    $order_required_date = date("M jS, Y", strtotime($row["order_required_date"]));
                }
                $query = '  
                             SELECT * FROM order_lines  
                             INNER JOIN orders  
                             ON orders.order_id = order_lines.order_id
                             INNER JOIN variations  
                             ON variations.variation_id = order_lines.variation_id
                             INNER JOIN products
                             ON variations.product_id = products.product_id
                             INNER JOIN colors
                             ON variations.color_id = colors.color_id
                             INNER JOIN sizes
                             ON variations.size_id = sizes.size_id 
                             WHERE order_lines.order_id = "' . $_SESSION["order_id"] . '"  
                             ';
                $result = $mysqli->query($query);
                while ($row = mysqli_fetch_array($result)) {
                    $order_details .= "  
                                       <tr>  
                                            <td>" . $row["product_name"] . "</td>  
                                            <td>" . $row["color_name"] . "</td>
                                            <td>" . $row["size_name"] . "</td>
                                            <td>" . $row["order_product_quantity"] . "</td>  
                                            <td>" . $row["product_price"] . "</td>  
                                            <td>" . number_format($row["order_product_quantity"] * $row["product_price"], 2) . "</td>  
                                       </tr>  
                                  ";
                    $subtotal = $subtotal + ($row["order_product_quantity"] * $row["product_price"]);
                    $tax = $tax + (($row["order_product_quantity"] * $row["product_price"]) * 0.075);
                    $total = $subtotal + $tax;
                }

                /* Receipt HTML*/

                echo '  
                             <h3 class="orderS">Order summary for Order No. ' . $receipt_code . '</h3>  
                             <div class="container-Receipt">  
                                  <table class="receipt">  
                                       <tr>  
                                            <td><label><strong>Customer Details<strong></label></td>  
                                       </tr>  
                                       <tr>  
                                            <td>' . $customer_details . '</td>  
                                       </tr>
                                       <tr>  
                                            <td><label><strong>Date to be delivered by: &nbsp;<strong></label> <span style="font-weight:normal">' . $order_required_date . '</span></td>  
                                       </tr>   
                                       <tr>  
                                            <td><label><strong>Order Details<strong></label></td>  
                                       </tr>  
                                       <tr>  
                                            <td>  
                                                 <table>  
                                                      <tr>  
                                                           <th width="40%">Product Name</th> 
                                                           <th width="10%">Color</th>
                                                           <th width="10%">Size</th> 
                                                           <th width="10%">Quantity</th>  
                                                           <th width="15%">Price</th>  
                                                           <th width="20%">Total</th>  
                                                      </tr>  
                                                      ' . $order_details . '  
                                                      <tr>  
                                                      <td colspan="5" align="right">Subtotal<br></br>Tax (7.5%)<br></br>Order Total</td>
                                                      <td align="right">$' . number_format($subtotal, 2) . '<br></br>$' . number_format($tax, 2) . '<br></br>$' . number_format($total, 2) . '</td>
                                                      </tr>  
                                                 </table>  
                                                    
                                                <div style="text-align: center; margin-top: 12px">
                                                 <input type="button2" style="margin-right: 10px;" id="print" class="submitButton print" value="Print"/>
                                                 <script type="text/javascript">
                                                 document.getElementById("print").onclick = function () {
                                                     window.print();
                                                 };
                                                 </script>

                                                 <input type="button2" style="width: 200px;" id= "makeAnotherOrder" class="submitButton make-new-order" value="Make another order"/>
                                                 <script type="text/javascript">
                                                 document.getElementById("makeAnotherOrder").onclick = function () {
                                                     location.href = "index.php";
                                                 };
                                                 </script>
                                                 </div>
                                            </td>  
                                       </tr>  
                                  </table>  
                             </div>  
                             ';
            } else {
                echo "Error getting values from database: " . $mysqli->error . "<br>";
            }
            ?>
        </div>
    </div>

    <a href="javascript:" id="return-to-top"><i class="fa fa-angle-double-up"></i></a>

<?php
require 'footer.php';
?>