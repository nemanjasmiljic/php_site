<?php
session_start();
include "header.php";
include "config.php";
include "func.php";
  ?>
  <div class="container">
<?
$id=(int)($_GET[id]);
$email=validatet($_GET[email]);
if(!$email) {
echo "<br><br><b>Invalid Unsubscription link</b><br><br>";
}
elseif(!$id) {
echo "<br><br><b>Invalid Unsubscription link</b><br><br>";
}
else {

$rs1 = mysqli_query($dbconnect,"select * from users where subscribed=1 and ID='$id' and Email='$email'");
if(mysqli_num_rows($rs1)>0) {

if(!$_POST) {

echo "<br><br><center>Are you sure you want to un-subscribe?
<form action=\"remove.php?id=$id&email=$email\" method=post><input type=hidden name=id value=$id><input type=hidden name=email value=$email><input type=Submit value=Yes></form>";
echo "<br>If you don't want to remove your account then just close this window<br>";
}
else {

$sql="update users set subscribed=0 where ID='$id'";
$rsd=mysqli_query($dbconnect,$sql);
echo "<br><br><b>We are sad to see you go. </b><br><br>";
}
}
else {
$rs1 = mysqli_query($dbconnect,"select * from users where subscribed=0 and ID='$id' and Email='$email'");
if(mysqli_num_rows($rs1)>0) {
echo "<br><br><b>You had already unsubscribed!</b><br><br>";
}
else {
echo "<br><br><b>Invalid Unsubscription link!</b><br><br>";
}
}
}
echo "</div>";
include "footer.php";
?>