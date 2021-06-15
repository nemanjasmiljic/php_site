<?php
// Provide Values for Database
$dbhost="localhost";
$dbname="yfwworld_btcapma";
$dbuser="yfwworld_btcapma";
$dbpass="I2+w)?qcvE.i";

$dbconnect=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();
?>