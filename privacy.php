<?php
  include "header.php";
  include "config.php";

$rs=mysqli_query($dbconnect,"select * from pages where filename='privacy.php'");
$arr=mysqli_fetch_array($rs);

$arr[2]=str_ireplace("{sitename}",$sitename,$arr[3]);
echo stripslashes($arr[2]);

  include "footer.php";
?>