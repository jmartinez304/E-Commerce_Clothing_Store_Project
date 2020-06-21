<div class="container-Menu">
    <div class="container-Tabs">
        <a class="tabs" href="all-products-tab.php" style="background-color: khaki;">All Products</a>
        <a class="tabs" href="cart-tab.php">Cart <span class="badge">
                    <?php if (isset($_SESSION["shopping_cart"])) {
                        echo count($_SESSION["shopping_cart"]);
                    } else {
                        echo '0';
                    } ?></span>
        </a>
    </div>

    <div id="all-products" class="container-Products pro-animate">
        <?php
        require 'db.php';
        $product_id = 0;
        $icount = 0; //Row variable
        $jcount = 0; //Column variable
        $sizes = array();
        $colors = array();

        $querySizes = '
SELECT distinct  products.product_id, products.product_name, sizes.size_id, sizes.size_name
FROM products
JOIN variations
ON products.product_id = variations.product_id
JOIN sizes
ON variations.size_id = sizes.size_id
ORDER BY  product_id, size_id';

        /* Query the database for colors */
        if ($result = $mysqli->query($querySizes)) {
            // Verify that there are more than 0 rows
            if ($result->num_rows > 0) {
                // Fetch and print associated rows

                while ($row = $result->fetch_assoc()) {
                    // print_r($product);
                    if ($row['product_id'] != $product_id) {
                        $jcount = 0;
                        $icount++;
                        $sizes[$icount][$jcount] = $row['size_name'];
                        $product_id = $row['product_id'];
                    } else {
                        $jcount++;
                        $sizes[$icount][$jcount] = $row['size_name'];
                    }
                }
            }
        }

        /* Reset the row and column variables */
        $icount = 0;
        $jcount = 0;

        $query = '
SELECT distinct categories.category_name, products.product_id, products.product_name, products.product_price, products.product_default_picture, colors.color_name
FROM categories
JOIN products
ON categories.category_id = products.category_id
JOIN variations
ON products.product_id = variations.product_id
JOIN colors
ON variations.color_id = colors.color_id';

        /* Query the database for colors */
        if ($result = $mysqli->query($query)) {
            // Verify that there are more than 0 rows
            if ($result->num_rows > 0) {
                // Fetch and print associated rows

                while ($row = $result->fetch_assoc()) {
                    // print_r($product);
                    if ($row['product_id'] != $product_id) {
                        $jcount = 0;
                        $icount++;
                        $colors[$icount][$jcount] = $row['color_name'];
                        $product_id = $row['product_id'];
                    } else {
                        $jcount++;
                        $colors[$icount][$jcount] = $row['color_name'];
                    }
                }


                /* Query the database to display the products */
                mysqli_data_seek($result, 0);
                $product_id = 0;
                while ($row = $result->fetch_assoc()) {
                    // print_r($product);

                    if ($row['product_id'] != $product_id) {

                        ?>
                        <div class="grid-menu">
                            <div class="grid-items">
                                <img class="imgRadius"
                                     src="<?php echo $row['product_default_picture']; ?>" height="180"
                                     width="260"/><br>


                                <h3 class="product-title"><?php echo $row['product_name']; ?></h3>

                                <!--                                <button class="accordion">View details &darr;</button>-->
                                <!--                                <div class="panel">-->
                                <!--                                    <p class="product-desc" id="viewdetails-->
                                <?php //echo $row['category_name'];
                                //                                    echo $row['product_id']; ?><!--">-->
                                <?php //echo $row['Product_Description']; ?><!--</p>-->
                                <!--                                </div>-->

                                <h3 class="tPrice">$ <?php echo $row['product_price']; ?></h3>

                                <div id="sizes-dropwdown">
                                    <label for="size<?php echo $row['product_id']; ?>">Size:&nbsp&nbsp</label>

                                    <select id="size<?php echo $row['product_id']; ?>" name="sizes">
                                        <?php
                                        $rowProductId = $row['product_id'];
                                        $sizesArrayCount = count($sizes[$rowProductId]);

                                        for ($col = 0; $col < $sizesArrayCount; $col++) {
                                            $sizesArrayEntry = $sizes[$rowProductId][$col];
                                            echo "<option value=" . $sizesArrayEntry . ">" . $sizesArrayEntry . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <br>

                                <div id="colors-dropwdown">
                                    <label for="color<?php echo $row['product_id']; ?>">Colors:</label>

                                    <select id="color<?php echo $row['product_id']; ?>" name="colors">
                                        <?php
                                        $rowProductId = $row['product_id'];
                                        $colorsArrayCount = count($colors[$rowProductId]);

                                        for ($col = 0; $col < $colorsArrayCount; $col++) {
                                            $colorsArrayEntry = $colors[$rowProductId][$col];
                                            echo "<option value=" . $colorsArrayEntry . ">" . $colorsArrayEntry . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <br>

                                <input type="text" name="quantity"
                                       id="quantity<?php echo $row['product_id']; ?>"
                                       class="textProduct form-control" value="1"/>

                                <input type="hidden" name="hidden_name"
                                       id="name<?php echo $row['product_id']; ?>"
                                       value="<?php echo $row['product_name']; ?>"/>

                                <input type="hidden" name="hidden_price"
                                       id="price<?php echo $row['product_id']; ?>"
                                       value="<?php echo $row['product_price']; ?>"/>

                                <input type="button" name="add_to_cart" id="<?php echo $row['product_id']; ?>"
                                       class="buttonProduct form-control add_to_cart" value="Add to Cart"/>
                                <br>
                            </div>
                        </div>
                        <?php
                        $product_id = $row['product_id'];
                    }
                }
            }
        } else {
            echo "Error getting products from the database: " . $mysqli->error . "<br>";
        }
        ?>
    </div>
</div>