<?php
/*File to connect to the database*/
$host="localhost";
$port=3306;
$socket="";
$user="root";
$password="";
$dbname="signature_sports_clothing";
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
echo "Connected successfully";

$result = mysqli_query($mysqli, "SELECT * FROM brand");

echo "<table border='1'>
<tr>
<th>brand_id</th>
<th>brand_name</th>
</tr>";

while ($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['brand_id'] . "</td>";
    echo "<td>" . $row['brand_name'] . "</td>";
    echo "</tr>";
}
echo "</table>";

mysqli_close($mysqli);
