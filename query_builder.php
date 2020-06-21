<div class="list-group">
    <h3>Brand</h3>
    <div class="query-selector">
        <?php

        $query = "SELECT DISTINCT(brands.brand_name) 
FROM brands
JOIN products 
ON brands.brand_id = products.brand_id
JOIN variations
ON products.product_id = variations.product_id
ORDER BY products.product_id DESC";
        $result = $mysqli->query($query);
        ?>
        <select class="list-group-item dropdown">
            <?php
            foreach ($result as $row) {
                ?>
                <option class="common_dropdown brands"
                        value="<?php echo $row['brand_name']; ?>"> <?php echo $row['brand_name']; ?>
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

        $query = "SELECT DISTINCT(colors.color_name) 
FROM colors
JOIN variations
ON colors.color_id = variations.color_id
JOIN products
ON products.product_id = variations.product_id";
        $result = $mysqli->query($query);
        ?>
        <select class="list-group-item dropdown">
            <?php
            foreach ($result as $row) {
                ?>
                <option class="common_dropdown colors"
                        value="<?php echo $row['color_name']; ?>"> <?php echo $row['color_name']; ?>
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

        $query = "SELECT DISTINCT(sizes.size_name) 
FROM sizes
JOIN variations
ON sizes.size_id = variations.size_id
JOIN products
ON products.product_id = variations.product_id";
        $result = $mysqli->query($query);
            ?>
            <select class="list-group-item dropdown">
                <?php
                foreach ($result as $row) {
                ?>
                <option class="common_dropdown size"
                       value="<?php echo $row['size_name']; ?>"> <?php echo $row['size_name']; ?>
                </option>
            <?php

        }

        ?>
            </select>
    </div>
</div>