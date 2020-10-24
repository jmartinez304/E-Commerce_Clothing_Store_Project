<?php
session_start([
    'cookie_lifetime' => 86400,
]);
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
    <script src="js/jquery.js"></script>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/sections.css">
    <link rel="stylesheet" href="css/checkout.css">
    <link rel="stylesheet" href="css/font_styles.css">
    <style>
        @media print {
            #print {
                display: none;
            }

            #makeAnotherOrder {
                display: none;
            }

            table, td.receipt {
                width: 500px;
                margin: 0 auto;
            }

            header, footer {
                display: none;
            }
        }
    </style>
</head>
<body>
<header>
    <div class="container">
        <nav class="fixNav">
            <span id="home" class="fixSpan">Signature Sports Clothing</span>
            <ul>
                <li><a href="index.php" style="color: khaki;">Order Now</a></li>
            </ul>
        </nav>
    </div>
</header>