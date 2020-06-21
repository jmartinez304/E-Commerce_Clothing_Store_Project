<?php

//fetch_data.php

include('db.php');

if(isset($_POST["action"]))
{
    $query = "
SELECT distinct categories.category_name, products.product_id, products.product_name, products.product_price, products.product_default_picture, colors.color_name
FROM categories
JOIN products
ON categories.category_id = products.category_id
JOIN variations
ON products.product_id = variations.product_id
JOIN colors
ON variations.color_id = colors.color_id";

    if(isset($_POST["minimum_price"], $_POST["maximum_price"]) && !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"]))
    {
        $query .= "
   AND product_price BETWEEN '".$_POST["minimum_price"]."' AND '".$_POST["maximum_price"]."'
  ";
    }

}