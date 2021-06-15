<?php
  session_start();

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


if (isset($_SESSION["username_session"])) {
	$id=$_SESSION["username_session"];
	if ($id=="") {
		$id=$username_session;
	}
	$rs = mysqli_query($dbconnect,"select * from users where Username='$id'");
	$arr=mysqli_fetch_array($rs);
	$check=1;
	$email_session=$arr[7];
	$username_session=$arr[8];
	$password_session=$arr[9];
        $name_session=$arr[1];
	$ref_session=$arr[11];
	$status=$arr[14];
	if($status==1) {
		$statust="Free";
	}
	else {
		$statust="Pro";
	}
	$total_session=$arr[15];
	$paid_session=$arr[17];
	$unpaid_session=$arr[16];
	}


?>
         	<div class="row-fluid">
				<h2>Downline Details</h2>
<?php 
$rs1=mysqli_query($dbconnect,"select * from users where active=1 and ref_by='$_SESSION[username_session]'");
if(mysqli_num_rows($rs1)>0) {
?>
<div class="table-responsive">
   <table class="table table-hover">
	<tbody><?php
echo "<tr>
<td><font face=verdana size=2><b>Name</b></font></td>
<td><font face=verdana size=2><b>Username</b></font></td>
<td><font face=verdana size=2><b>Email</b></font></td>
<td><font face=verdana size=2><b>Status</b></font></td>
<td><font face=verdana size=2><b>Date Joined</b></font></td>
</tr>";


while($arr=mysqli_fetch_array($rs1)) {
if($arr[14]==1) $status="Free";
else {
$status="Sponsor";
}
echo "<tr>
<td ><font face=verdana size=2>$arr[1]</font></td>
<td ><font face=verdana size=2>$arr[8]</font></td>
<td ><font face=verdana size=2><A href=mailto:$arr[7]>$arr[7]</a></font></td>
<td ><font face=verdana size=2>$status</font></td>
<td ><font face=verdana size=2>$arr[13]</font></td>
</tr>";
}
echo "</tbody></table></div>";
}
else {
echo "<p><strong>No Downlines Found!</strong></p>";
}
?></div>
<?php }
include "footer.php";
?>