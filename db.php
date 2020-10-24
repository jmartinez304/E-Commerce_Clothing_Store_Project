<?php
/*File to connect to the database*/
$host = "localhost";
$port = 3306;
$socket = "";
$user = "root";
$password = "Tester123";
$dbname = "signature_sports_clothing";
$mysqli = new mysqli($host, $user, $password, $dbname, $port, $socket)
or die ('Could not connect to the database server' . mysqli_connect_error());
//$mysqli->close();
/* check connection */
if ($mysqli->connect_error) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}
//select a database to work with
$mysqli->select_db('signature_sports_clothing');