<form action="index.php" method="GET">
    <div class="list-group">
        <h3>Brand</h3>
        <div class="query-selector">
            <?php

            /* Brand query drop-down */
            $query = "SELECT DISTINCT brands.brand_name, brands.brand_id
FROM brands
JOIN products 
ON brands.brand_id = products.brand_id
JOIN variations
ON products.product_id = variations.product_id
ORDER BY products.product_id DESC";
            $result = $mysqli->query($query);
            ?>
            <select class="list-group-item dropdown" name="brand">
                <option selected value> -- No Selection --</option>
                <?php
                foreach ($result as $row) {
                    ?>
                    <option class="common_dropdown brands"
                            value="<?php echo $row['brand_id']; ?>"
                        <?php if (isset($_GET["brand"])) {
                            if ($_GET["brand"] == $row['brand_id']) { ?> selected <?php }
                        } ?>> <?php echo $row['brand_name']; ?>
                    </option>
                    <?php

                }

                ?>
            </select>
        </div>
    </div>

    <div class="list-group">
        <h3>Color</h3>
        <div class="query-selector">
            <?php

            /* Color query drop-down */
            $query = "SELECT DISTINCT colors.color_name, colors.color_id
FROM colors
JOIN variations
ON colors.color_id = variations.color_id
JOIN products
ON products.product_id = variations.product_id";
            $result = $mysqli->query($query);
            ?>
            <select class="list-group-item dropdown" name="color">
                <option selected value> -- No Selection --</option>
                <?php
                foreach ($result as $row) {
                    ?>
                    <option class="common_dropdown colors"
                            value="<?php echo $row['color_id']; ?>"
                        <?php if (isset($_GET["color"])) {
                            if ($_GET["color"] == $row['color_id']) { ?> selected <?php }
                        } ?>> <?php echo $row['color_name']; ?>
                    </option>
                    <?php

                }

                ?>
            </select>
        </div>
    </div>

    <div class="list-group">
        <h3>Size</h3>
        <div class="query-selector">
            <?php

            /* Size query drop-down */
            $query = "SELECT DISTINCT sizes.size_name, sizes.size_id
FROM sizes
JOIN variations
ON sizes.size_id = variations.size_id
JOIN products
ON products.product_id = variations.product_id";
            $result = $mysqli->query($query);
            ?>
            <select class="list-group-item dropdown" name="size">
                <option selected value> -- No Selection --</option>
                <?php
                foreach ($result as $row) {
                    ?>
                    <option class="common_dropdown size"
                            value="<?php echo $row['size_id']; ?>"
                        <?php if (isset($_GET["size"])) {
                            if ($_GET["size"] == $row['size_id']) { ?> selected <?php }
                        } ?>> <?php echo $row['size_name']; ?>
                    </option>
                    <?php

                }

                ?>
            </select>
        </div>
    </div>
    <div class="list-group">
        <div class="query-selector">
            <input type="submit" name="Submit" value="Send">
        </div>
    </div>
</form>