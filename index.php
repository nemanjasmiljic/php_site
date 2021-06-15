<?php
session_start();

include "func.php";
$id=validatet($_GET[r]);
if($id !="") {
//if($_SESSION["refid_session"]=="") {
$_SESSION["refid_session"]=$id ;
//}
}
include "header.php";
include "config.php"; 

$rs=mysqli_query($dbconnect,"select count(*) from users where active=1");
$arr=mysqli_fetch_array($rs);
$totalusers=$arr[0];

$rs=mysqli_query($dbconnect,"select * from pages where ID=1");
$arr=mysqli_fetch_array($rs);
$arr[2]=str_ireplace("{sitename}",$sitename,$arr[3]);
$arr[2]=str_ireplace("{totalinvestment}",$totalinv,$arr[2]);
$arr[2]=str_ireplace("{membersearnings}",$memearn,$arr[2]);
$arr[2]=str_ireplace("{totalusers}",$totalusers,$arr[2]);
echo stripslashes($arr[2]);

include "footer.php";
?>
