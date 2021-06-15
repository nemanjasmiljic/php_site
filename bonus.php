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
	$id=$_SESSION["username_session"];
	$rs = mysqli_query($dbconnect,"select * from users where Username='$id'");
	$arr=mysqli_fetch_array($rs);
	$status=$arr[14];
	if($status==1) {
		$statust="Free";
$bonus=$freebonus;
	}
	else {
		$statust="Pro";
$bonus="";

$rsm=mysqli_query($dbconnect,"select ID,Name,bonusdownloads from membershiplevels order by ID");
while($arrm=mysqli_fetch_array($rsm)) {
$rs1=mysqli_query($dbconnect,"select * from matrix$arrm[0] where Username='$id'");
if(mysqli_num_rows($rs1)>0) {
$arrm[2]=stripslashes($arrm[2]);
$bonus.="<br><b>$arrm[1] Bonus</b><br>$arrm[2]<hr>";
}
}

	}
?>
         	<div class="row-fluid">
                
				<div class="col-lg-12">
                    <div class="row"><?php
echo stripslashes($bonus);
?>
                    </div>
                </div>
                
				<div class="clearfix"></div>
            </div>
<?php   return 1;
} include "footer.php";
?>