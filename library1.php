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
	$id=$_SESSION[username_session];
	$rs = mysqli_query($dbconnect,"select * from users where Username='$id'");
	$arr=mysqli_fetch_array($rs);
	$username=$_SESSION[username_session];
	$status=$arr[14];

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="10" colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td align="left" class="bodytext" colspan="2" valign="top">
<table border="0" width="98%"><tr><td><b><p align="center"><? echo $pname; ?></b></p>
<br>
<?
		$rs=mysqli_query($dbconnect,"select * from pages where ID=9");
$arr=mysqli_fetch_array($rs);
echo stripslashes($arr[3]);
?>
</td></tr></table>
</td></tr>
              <tr>
                <td height="10" colspan="2">&nbsp;</td>
              </tr>
</table>
<? } 
include "footer.php";
?>