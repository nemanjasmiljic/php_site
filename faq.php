<?php
session_start();
include "header.php";
include "config.php";


$rs=mysqli_query($dbconnect,"select * from pages where ID=2");
$arr=mysqli_fetch_array($rs);

echo stripslashes($arr[3]);


include "footer.php";
?>
