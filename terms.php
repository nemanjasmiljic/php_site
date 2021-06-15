<?php
session_start();
  include "header.php";
  include "config.php";
?>
<div class="container">
<?php
$rs=mysqli_query($dbconnect,"select * from pages where ID=5");
$arr=mysqli_fetch_array($rs);

$arr[2]=str_ireplace("{sitename}",$sitename,$arr[2]);
echo stripslashes($arr[3]);
echo "</div>";
  include "footer.php";
?>