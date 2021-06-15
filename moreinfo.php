<?php
  session_start();

set_time_limit(0);
include "header.php";
include "config.php";
if (!isset($_SESSION["username_session"])) {
include "loginform.php";
}
else {
middle();
} 

function middle()
{
include "config.php";
	$id=$_SESSION["username_session"];
	$rs = mysqli_query($dbconnect,"select * from users where Username='$id'");
	$arr=mysqli_fetch_array($rs);
	$check=1;
	$email=$arr[7];
        $name=$arr[1];
	$ref=$arr[11];
	$username=$_SESSION[username_session];
	$status=$arr[14];
	if($status==1) {
		$statust="Free";
	}
	else {
		$statust="Pro";
	}
	$total=$arr[15];
	$paid=$arr[17];
	$unpaid=$arr[16];

?>
         	<div class="row-fluid">
				<h2>Downline Information</h2>
<?php
$m=(int)$_GET[m];
$totalpos=0;
$rsm=mysqli_query($dbconnect,"select * from membershiplevels where ID=$m");
if(mysqli_num_rows($rsm)<1) {
echo "<br><b>Invalid Matrix</b><br>";
}
else {
$arrm=mysqli_fetch_array($rsm);
$levels=$arrm[4];

$l=(int)$_GET[l];
if(($l<1)||($l>$levels)) {
echo "<br><b>Invalid Link</b><br>";
}
else {
$id=(int)$_GET[id];
$ts=mysqli_query($dbconnect,"select * from matrix$arrm[0] where Username='$username' and ID=$id");

if(mysqli_num_rows($ts)<1) {
echo "<br><b>Invalid Link</b><br>";
}
else {
$arts=mysqli_fetch_array($ts); 

$a1="";
$a2="";
$a3="";
$a4="";
$a5="";
$a6="";
$a7="";
$a8="";
$a9="";
$a10="";

$rss=mysqli_query($dbconnect,"Select * from matrix$arrm[0] where ref_by=".$arts[0]);
if(mysqli_num_rows($rss)>0) {
while($arr2=mysqli_fetch_array($rss)) {

$id=$arr2[0];
$name=$arr2[1];
if($arr2[16]==$arr2[18]) $cdate="";
else $cdate="<br>Cycled On: $arr2[18]";

$a1=$a1."<tr><td align=center><b><font face=Verdana size=2> 1 </font></b></td><td align=center><b><font face=Verdana size=2> $arr2[0] </font></b></td><td align=center><b><font face=Verdana size=2> $name </font></b></td><td align=center><b><font face=Verdana size=2> ".($arr2[4]+$arr2[5]+$arr2[6]+$arr2[7]+$arr2[8]+$arr2[9]+$arr2[10]+$arr2[11]+$arr2[12]+$arr2[13])." </font></b></td><td align=center><b><font face=Verdana size=2> $arr2[16] $cdate </td></tr>";

if($l>1) {
$rss2=mysqli_query($dbconnect,"Select * from matrix$arrm[0] where ref_by=".$arr2[0]);
if(mysqli_num_rows($rss2)>0) {
while($arrr2=mysqli_fetch_array($rss2)) {

$id=$arrr2[0];
$name=$arrr2[1];
if($arrr2[16]==$arrr2[18]) $cdate="";
else $cdate="<br>Cycled On: $arrr2[18]";

$a2=$a2."<tr><td align=center><b><font face=Verdana size=2> 2 </font></b></td><td align=center><b><font face=Verdana size=2> $arrr2[0] </font></b></td><td align=center><b><font face=Verdana size=2> $name </font></b></td><td align=center><b><font face=Verdana size=2> ".($arrr2[4]+$arrr2[5]+$arrr2[6]+$arrr2[7]+$arrr2[8]+$arrr2[9]+$arrr2[10]+$arrr2[11]+$arrr2[12]+$arrr2[13])." </font></b></td><td align=center><b><font face=Verdana size=2> $arrr2[16] $cdate </td></tr>";

if($l>2) {
$rss3=mysqli_query($dbconnect,"Select * from matrix$arrm[0] where ref_by=".$arrr2[0]);
if(mysqli_num_rows($rss3)>0) {
while($arrr3=mysqli_fetch_array($rss3)) {

$id=$arrr3[0];
$name=$arrr3[1];
if($arrr3[16]==$arrr3[18]) $cdate="";
else $cdate="<br>Cycled On: $arrr3[18]";

$a3=$a3."<tr><td align=center><b><font face=Verdana size=2> 3 </font></b></td><td align=center><b><font face=Verdana size=2> $arrr3[0] </font></b></td><td align=center><b><font face=Verdana size=2> $name </font></b></td><td align=center><b><font face=Verdana size=2> ".($arrr3[4]+$arrr3[5]+$arrr3[6]+$arrr3[7]+$arrr3[8]+$arrr3[9]+$arrr3[10]+$arrr3[11]+$arrr3[12]+$arrr3[13])." </font></b></td><td align=center><b><font face=Verdana size=2> $arrr3[16] $cdate </td></tr>";

if($l>3) {
$rss4=mysqli_query($dbconnect,"Select * from matrix$arrm[0] where ref_by=".$arrr3[0]);
if(mysqli_num_rows($rss4)>0) {
while($arrr4=mysqli_fetch_array($rss4)) {

$id=$arrr4[0];
$name=$arrr4[1];
if($arrr4[16]==$arrr4[18]) $cdate="";
else $cdate="<br>Cycled On: $arrr4[18]";

$a4=$a4."<tr><td align=center><b><font face=Verdana size=2> 4 </font></b></td><td align=center><b><font face=Verdana size=2> $arrr4[0] </font></b></td><td align=center><b><font face=Verdana size=2> $name </font></b></td><td align=center><b><font face=Verdana size=2> ".($arrr4[4]+$arrr4[5]+$arrr4[6]+$arrr4[7]+$arrr4[8]+$arrr4[9]+$arrr4[10]+$arrr4[11]+$arrr4[12]+$arrr4[13])." </font></b></td><td align=center><b><font face=Verdana size=2> $arrr4[16] $cdate </td></tr>";

if($l>4) {
$rss5=mysqli_query($dbconnect,"Select * from matrix$arrm[0] where ref_by=".$arrr4[0]);
if(mysqli_num_rows($rss5)>0) {
while($arrr5=mysqli_fetch_array($rss5)) {

$id=$arrr5[0];
$name=$arrr5[1];
if($arrr5[16]==$arrr5[18]) $cdate="";
else $cdate="<br>Cycled On: $arrr5[18]";

$a5=$a5."<tr><td align=center><b><font face=Verdana size=2> 5 </font></b></td><td align=center><b><font face=Verdana size=2> $arrr5[0] </font></b></td><td align=center><b><font face=Verdana size=2> $name </font></b></td><td align=center><b><font face=Verdana size=2> ".($arrr5[4]+$arrr5[5]+$arrr5[6]+$arrr5[7]+$arrr5[8]+$arrr5[9]+$arrr5[10]+$arrr5[11]+$arrr5[12]+$arrr5[13])." </font></b></td><td align=center><b><font face=Verdana size=2> $arrr5[16] $cdate </td></tr>";

if($l>5) {
$rss6=mysqli_query($dbconnect,"Select * from matrix$arrm[0] where ref_by=".$arrr5[0]);
if(mysqli_num_rows($rss6)>0) {
while($arrr6=mysqli_fetch_array($rss6)) {

$id=$arrr6[0];
$name=$arrr6[1];
if($arrr6[16]==$arrr6[18]) $cdate="";
else $cdate="<br>Cycled On: $arrr6[18]";

$a6=$a6."<tr><td align=center><b><font face=Verdana size=2> 6 </font></b></td><td align=center><b><font face=Verdana size=2> $arrr6[0] </font></b></td><td align=center><b><font face=Verdana size=2> $name </font></b></td><td align=center><b><font face=Verdana size=2> ".($arrr6[4]+$arrr6[5]+$arrr6[6]+$arrr6[7]+$arrr6[8]+$arrr6[9]+$arrr6[10]+$arrr6[11]+$arrr6[12]+$arrr6[13])." </font></b></td><td align=center><b><font face=Verdana size=2> $arrr6[16] $cdate </td></tr>";

if($l>6) {
$rss7=mysqli_query($dbconnect,"Select * from matrix$arrm[0] where ref_by=".$arrr6[0]);
if(mysqli_num_rows($rss7)>0) {
while($arrr7=mysqli_fetch_array($rss7)) {

$id=$arrr7[0];
$name=$arrr7[1];
if($arrr7[16]==$arrr7[18]) $cdate="";
else $cdate="<br>Cycled On: $arrr7[18]";

$a7=$a7."<tr><td align=center><b><font face=Verdana size=2> 7 </font></b></td><td align=center><b><font face=Verdana size=2> $arrr7[0] </font></b></td><td align=center><b><font face=Verdana size=2> $name </font></b></td><td align=center><b><font face=Verdana size=2> ".($arrr7[4]+$arrr7[5]+$arrr7[6]+$arrr7[7]+$arrr7[8]+$arrr7[9]+$arrr7[10]+$arrr7[11]+$arrr7[12]+$arrr7[13])." </font></b></td><td align=center><b><font face=Verdana size=2> $arrr7[16] $cdate </td></tr>";

if($l>7) {
$rss8=mysqli_query($dbconnect,"Select * from matrix$arrm[0] where ref_by=".$arrr7[0]);
if(mysqli_num_rows($rss8)>0) {
while($arrr8=mysqli_fetch_array($rss8)) {

$id=$arrr8[0];
$name=$arrr8[1];
if($arrr8[16]==$arrr8[18]) $cdate="";
else $cdate="<br>Cycled On: $arrr8[18]";

$a8=$a8."<tr><td align=center><b><font face=Verdana size=2> 8 </font></b></td><td align=center><b><font face=Verdana size=2> $arrr8[0] </font></b></td><td align=center><b><font face=Verdana size=2> $name </font></b></td><td align=center><b><font face=Verdana size=2> ".($arrr8[4]+$arrr8[5]+$arrr8[6]+$arrr8[7]+$arrr8[8]+$arrr8[9]+$arrr8[10]+$arrr8[11]+$arrr8[12]+$arrr8[13])." </font></b></td><td align=center><b><font face=Verdana size=2> $arrr8[16] $cdate </td></tr>";

if($l>8) {
$rss9=mysqli_query($dbconnect,"Select * from matrix$arrm[0] where ref_by=".$arrr8[0]);
if(mysqli_num_rows($rss9)>0) {
while($arrr9=mysqli_fetch_array($rss9)) {

$id=$arrr9[0];
$name=$arrr9[1];
if($arrr9[16]==$arrr9[18]) $cdate="";
else $cdate="<br>Cycled On: $arrr9[18]";

$a9=$a9."<tr><td align=center><b><font face=Verdana size=2> 9 </font></b></td><td align=center><b><font face=Verdana size=2> $arrr9[0] </font></b></td><td align=center><b><font face=Verdana size=2> $name </font></b></td><td align=center><b><font face=Verdana size=2> ".($arrr9[4]+$arrr9[5]+$arrr9[6]+$arrr9[7]+$arrr9[8]+$arrr9[9]+$arrr9[10]+$arrr9[11]+$arrr9[12]+$arrr9[13])." </font></b></td><td align=center><b><font face=Verdana size=2> $arrr9[16] $cdate </td></tr>";

if($l>9) {
$rss10=mysqli_query($dbconnect,"Select * from matrix$arrm[0] where ref_by=".$arrr9[0]);
if(mysqli_num_rows($rss10)>0) {
while($arrr10=mysqli_fetch_array($rss10)) {

$id=$arrr10[0];
$name=$arrr10[1];
if($arrr10[16]==$arrr10[18]) $cdate="";
else $cdate="<br>Cycled On: $arrr10[18]";

$a10=$a10."<tr><td align=center><b><font face=Verdana size=2> 10 </font></b></td><td align=center><b><font face=Verdana size=2> $arrr10[0] </font></b></td><td align=center><b><font face=Verdana size=2> $name </font></b></td><td align=center><b><font face=Verdana size=2> ".($arrr10[4]+$arrr10[5]+$arrr10[6]+$arrr10[7]+$arrr10[8]+$arrr10[9]+$arrr10[10]+$arrr10[11]+$arrr10[12]+$arrr10[13])." </font></b></td><td align=center><b><font face=Verdana size=2> $arrr10[16] $cdate </td></tr>";

} } 

} } 

} } 

} } 

} } 

} } 

} } 

} } 

} } 

} }

} } } } } } } } }

if($l==1) {
if($a1=="") {
echo "<br><b>No Downline Present</b><br>";
}
else {
echo "<div class=\"table-responsive\">
		<table class=\"table table-hover\">
		<tbody><tr><td align=center><b><font face=Verdana size=2>Level</font></b></td><td align=center><b><font face=Verdana size=2>ID #</font></b></td><td align=center><b><font face=Verdana size=2>Username</font></b></td><td align=center><b><font face=Verdana size=2># Downline</font></b></td><td align=center><b><font face=Verdana size=2>Date Joined</font></b></td></tr>$a1</tbody></table></div>";
}
}

if($l==2) {
if($a2=="") {
echo "<br><b>No Downline Present</b><br>";
}
else {
echo "<div class=\"table-responsive\">
		<table class=\"table table-hover\">
		<tbody><tr><td align=center><b><font face=Verdana size=2>Level</font></b></td><td align=center><b><font face=Verdana size=2>ID #</font></b></td><td align=center><b><font face=Verdana size=2>Username</font></b></td><td align=center><b><font face=Verdana size=2># Downline</font></b></td><td align=center><b><font face=Verdana size=2>Date Joined</font></b></td></tr>$a2</tbody></table></div>";
}
}

if($l==3) {
if($a3=="") {
echo "<br><b>No Downline Present</b><br>";
}
else {
echo "<div class=\"table-responsive\">
		<table class=\"table table-hover\">
		<tbody><tr><td align=center><b><font face=Verdana size=2>Level</font></b></td><td align=center><b><font face=Verdana size=2>ID #</font></b></td><td align=center><b><font face=Verdana size=2>Username</font></b></td><td align=center><b><font face=Verdana size=2># Downline</font></b></td><td align=center><b><font face=Verdana size=2>Date Joined</font></b></td></tr>$a3</tbody></table></div>";
}
}

if($l==4) {
if($a4=="") {
echo "<br><b>No Downline Present</b><br>";
}
else {
echo "<div class=\"table-responsive\">
		<table class=\"table table-hover\">
		<tbody><tr><td align=center><b><font face=Verdana size=2>Level</font></b></td><td align=center><b><font face=Verdana size=2>ID #</font></b></td><td align=center><b><font face=Verdana size=2>Username</font></b></td><td align=center><b><font face=Verdana size=2># Downline</font></b></td><td align=center><b><font face=Verdana size=2>Date Joined</font></b></td></tr>$a4</tbody></table></div>";
}
}

if($l==5) {
if($a5=="") {
echo "<br><b>No Downline Present</b><br>";
}
else {
echo "<div class=\"table-responsive\">
		<table class=\"table table-hover\">
		<tbody><tr><td align=center><b><font face=Verdana size=2>Level</font></b></td><td align=center><b><font face=Verdana size=2>ID #</font></b></td><td align=center><b><font face=Verdana size=2>Username</font></b></td><td align=center><b><font face=Verdana size=2># Downline</font></b></td><td align=center><b><font face=Verdana size=2>Date Joined</font></b></td></tr>$a5</tbody></table></div>";
}
}

if($l==6) {
if($a6=="") {
echo "<br><b>No Downline Present</b><br>";
}
else {
echo "<div class=\"table-responsive\">
		<table class=\"table table-hover\">
		<tbody><tr><td align=center><b><font face=Verdana size=2>Level</font></b></td><td align=center><b><font face=Verdana size=2>ID #</font></b></td><td align=center><b><font face=Verdana size=2>Username</font></b></td><td align=center><b><font face=Verdana size=2># Downline</font></b></td><td align=center><b><font face=Verdana size=2>Date Joined</font></b></td></tr>$a6</tbody></table></div>";
}
}

if($l==7) {
if($a7=="") {
echo "<br><b>No Downline Present</b><br>";
}
else {
echo "<div class=\"table-responsive\">
		<table class=\"table table-hover\">
		<tbody><tr><td align=center><b><font face=Verdana size=2>Level</font></b></td><td align=center><b><font face=Verdana size=2>ID #</font></b></td><td align=center><b><font face=Verdana size=2>Username</font></b></td><td align=center><b><font face=Verdana size=2># Downline</font></b></td><td align=center><b><font face=Verdana size=2>Date Joined</font></b></td></tr>$a7</tbody></table></div>";
}
}

if($l==8) {
if($a8=="") {
echo "<br><b>No Downline Present</b><br>";
}
else {
echo "<div class=\"table-responsive\">
		<table class=\"table table-hover\">
		<tbody><tr><td align=center><b><font face=Verdana size=2>Level</font></b></td><td align=center><b><font face=Verdana size=2>ID #</font></b></td><td align=center><b><font face=Verdana size=2>Username</font></b></td><td align=center><b><font face=Verdana size=2># Downline</font></b></td><td align=center><b><font face=Verdana size=2>Date Joined</font></b></td></tr>$a8</tbody></table></div>";
}
}

if($l==9) {
if($a9=="") {
echo "<br><b>No Downline Present</b><br>";
}
else {
echo "<div class=\"table-responsive\">
		<table class=\"table table-hover\">
		<tbody><tr><td align=center><b><font face=Verdana size=2>Level</font></b></td><td align=center><b><font face=Verdana size=2>ID #</font></b></td><td align=center><b><font face=Verdana size=2>Username</font></b></td><td align=center><b><font face=Verdana size=2># Downline</font></b></td><td align=center><b><font face=Verdana size=2>Date Joined</font></b></td></tr>$a9</tbody></table></div>";
}
}

if($l==10) {
if($a10=="") {
echo "<br><b>No Downline Present</b><br>";
}
else {
echo "<div class=\"table-responsive\">
		<table class=\"table table-hover\">
		<tbody><tr><td align=center><b><font face=Verdana size=2>Level</font></b></td><td align=center><b><font face=Verdana size=2>ID #</font></b></td><td align=center><b><font face=Verdana size=2>Username</font></b></td><td align=center><b><font face=Verdana size=2># Downline</font></b></td><td align=center><b><font face=Verdana size=2>Date Joined</font></b></td></tr>$a10</tbody></table></div>";
}
}

}
}
}
?>
</div>
<?php   return 1;
} include "footer.php";
?>