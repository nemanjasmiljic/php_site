<?php
  include "dbconfig.php";

$rs=mysqli_query($dbconnect,"select * from pages where ID=7");
$arr=mysqli_fetch_array($rs);

$arr[2]=str_ireplace("{sitename}",$sitename,$arr[3]);
echo stripslashes($arr[2]);

?>