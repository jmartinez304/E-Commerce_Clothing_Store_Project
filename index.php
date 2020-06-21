<?php
require 'selection_header.php';

//$query = 'SELECT distinct products.product_id, colors.color_name
//FROM categories
//JOIN products
//ON categories.category_id = products.category_id
//JOIN variations
//ON products.product_id = variations.product_id
//JOIN colors
//ON variations.color_id = colors.color_id';
//
///* Try to query the database */
//if ($result = $mysqli->query($query)) {
//    // Verify that there are more than 0 rows
//    if ($result->num_rows > 0) {
//        // Fetch and print associated rows
//        while ($row = $result->fetch_assoc()) {
//            // print_r($product);
//            if ($row['product_id'] != $product_id) {
//
//                $jcount = 0;
//                $colors[$icount][$jcount] = $row['color_name'];
//                $product_id = $row['product_id'];
//                $icount++;
//            } else {
//                $colors[$icount][$jcount] = $row['color_name'];
//                $jcount++;
//            }
//        }
//    }
//} else {
//    echo "Error getting products from the database: " . $mysqli->error . "<br>";
//}
?>
<div class="sec-MCR">
    <span class="title2">Discover the menu</span>
    <hr class="one">

    <div class="query-builder">

        <?php
        require 'query_builder.php';
        ?>


    </div>

    <?php
    require 'all_products_menu.php';
    ?>


</div>

<?php
require 'selection_footer.php';
?>
