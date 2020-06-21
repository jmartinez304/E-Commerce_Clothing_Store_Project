<?php
//session_start([
//    'cookie_lifetime' => 86400,
//]);
require 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= isset($PageTitle) ? $PageTitle : "Signature Sports Clothing" ?></title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/sections.css">
    <link rel="stylesheet" href="css/font_styles.css">
</head>
<body>
<header>
    <div class="container">
        <nav class="fixNav">
            <span id="home" class="fixSpan">Signature Sports Clothing</span>
            <ul>
                <li><a href="home.html">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="all-products-tab.php" style="color: khaki;">Order Now</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
        </nav>
    </div>
</header>