<div class="container-Menu">
    <div class="container-Tabs">
        <a class="tabs" href="all-products-tab.php" style="background-color: khaki;">Products</a>
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
        $color_icount = 0; //Color Row variable
        $color_jcount = 0; //Color Column variable
        $size_icount = 0; //Size Row variable
        $size_jcount = 0; //Size Column variable
        $sizes = array();
        $colors = array();

        /* Retrieving each items available sizes */
        $querySizes = '
SELECT distinct  products.product_id, products.product_name, sizes.size_id, sizes.size_name
FROM products
JOIN variations
ON products.product_id = variations.product_id
JOIN sizes
ON variations.size_id = sizes.size_id
ORDER BY  product_id, size_id';

        if ($result = $mysqli->query($querySizes)) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // print_r($product);
                    if ($row['product_id'] != $product_id) {
                        $size_jcount = 0;
                        $size_icount++;
                        $sizes[$size_icount][$size_jcount] = $row['size_name'];
                        $product_id = $row['product_id'];
                    } else {
                        $size_jcount++;
                        $sizes[$size_icount][$size_jcount] = $row['size_name'];
                    }
                }
            }
        }

        /* Retrieving each items available colors */
        $query = '
SELECT distinct categories.category_name, products.product_id, products.product_name, products.product_price, products.product_default_picture, colors.color_name
FROM categories
JOIN products
ON categories.category_id = products.category_id
JOIN variations
ON products.product_id = variations.product_id
JOIN colors
ON variations.color_id = colors.color_id';

        $product_id = 0;

        if ($result = $mysqli->query($query)) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // print_r($product);
                    if ($row['product_id'] != $product_id) {
                        $color_jcount = 0;
                        $color_icount++;
                        $colors[$color_icount][$color_jcount] = $row['color_name'];
                        $product_id = $row['product_id'];
                    } else {
                        $color_jcount++;
                        $colors[$color_icount][$color_jcount] = $row['color_name'];
                    }
                }
            }
        }


        /* Display all products in the database */
        $query = '
SELECT distinct categories.category_name, products.product_id, products.product_name, products.product_price, products.product_default_picture
FROM categories
JOIN products
ON categories.category_id = products.category_id
JOIN variations
ON products.product_id = variations.product_id';

        require 'query_fetch.php';

        if ($result = $mysqli->query($query)) {
            if ($result->num_rows > 0) {
                mysqli_data_seek($result, 0);
                $product_id = 0;
                while ($row = $result->fetch_assoc()) {

                    if ($row['product_id'] != $product_id) {

                        ?>
                        <div class="grid-menu">
                            <div class="grid-items">
                                <img class="imgRadius"
                                     src="<?php echo $row['product_default_picture']; ?>" height="180"
                                     width="260"/><br>


                                <h3 class="product-title"><?php echo $row['product_name']; ?></h3>

                                <h3 class="tPrice">$ <?php echo $row['product_price']; ?></h3>

                                <div id="sizes-dropwdown">
                                    <label for="size<?php echo $row['product_id']; ?>">Size:&nbsp&nbsp</label>

                                    <select id="size<?php echo $row['product_id']; ?>" name="sizes">
                                        <?php
                                        $row_product_id = $row['product_id'];
                                        $sizes_array_count = count($sizes[$row_product_id]);

                                        for ($col = 0; $col < $sizes_array_count; $col++) {
                                            $sizes_array_entry = $sizes[$row_product_id][$col];
                                            echo "<option value=" . $sizes_array_entry . ">" . $sizes_array_entry . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <br>

                                <div id="colors-dropwdown">
                                    <label for="color<?php echo $row['product_id']; ?>">Colors:</label>

                                    <select id="color<?php echo $row['product_id']; ?>" name="colors">
                                        <?php
                                        $row_product_id = $row['product_id'];
                                        $colors_array_count = count($colors[$row_product_id]);

                                        for ($col = 0; $col < $colors_array_count; $col++) {
                                            $colors_array_entry = $colors[$row_product_id][$col];
                                            echo "<option value=" . $colors_array_entry . ">" . $colors_array_entry . "</option>";
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