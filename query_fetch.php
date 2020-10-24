<?php

//fetch_data.php

include('db.php');

$comma_verify = False;

/* Here we check if any of the filter drop-downs have been set and we modify the page items SQL with the filters that were set. */

if (((isset($_GET["brand"])) && $_GET["brand"] !== "") || ((isset($_GET["color"])) && $_GET["color"] !== "") || ((isset($_GET["size"])) && $_GET["size"] !== "")) {

    $query .= " WHERE ";

    if (isset($_GET["brand"]) && $_GET["brand"] !== "") {
        $brand_filter = $_GET["brand"];
        $query .= "products.brand_id = ('" . $brand_filter . "')";
        $comma_verify = True;
    }

    if (isset($_GET["color"]) && $_GET["color"] !== "") {
        $color_filter = $_GET["color"];
        if ($comma_verify) {
            $query .= " AND ";
        }
        $query .= "variations.color_id = ('" . $color_filter . "')";
        $comma_verify = True;
    }

    if (isset($_GET["size"]) && $_GET["size"] !== "") {
        $size_filter = $_GET["size"];
        if ($comma_verify) {
            $query .= " AND ";
        }
        $query .= "variations.size_id = ('" . $size_filter . "')";
        $comma_verify = True;
    }


}