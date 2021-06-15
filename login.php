<?php
  session_start();
include "config.php";
include "func.php";
$a="";
$b="";
if ($_POST) {
	$a=validatet($_POST["id"]);
	$b=validatet($_POST["password"]);
}
if ($a=="" || $b=="")
{

if (!isset($_SESSION["username_session"])) {
include "header.php";
include "loginform.php";
}
else {
  middle();
}
}
else
{
$check=0;

$username=$a;
if($freemember==0) 
$rs = mysqli_query($dbconnect,"select * from users where Username='$username' and Password='$b' and active=1 and status=2");
else
$rs = mysqli_query($dbconnect,"select * from users where Username='$username' and Password='$b' and active=1");

if (mysqli_num_rows($rs)>0) {
$arr=mysqli_fetch_array($rs);
		$check=1;
		$_SESSION["username_session"]=$arr[8];
		$_SESSION["password_session"]=$arr[9];
		$_SESSION[refid_session]=$arr[11];
		middle();
}
if ($check==0)
{
include "header.php";
$rs = mysqli_query($dbconnect,"select * from users where Username='$a' and Password='$b' and active=0");
$rs1 = mysqli_query($dbconnect,"select * from users where Username='$a' and Password='$b' and active=1 and status=1");
if(mysqli_num_rows($rs)>0) $check=3;
if((mysqli_num_rows($rs1)>0)&&($freemember==0)) $check=4;
  if($check==0) {
  print "<h2 align=center>Invalid Username or Password.</h2>";
  }
  elseif($check==4) {
  print "<h3 align=center>You need to purchase a matrix position in order to activate your account.</h3>";

if($startmatrix==0) $rsm=mysqli_query($dbconnect,"select * from membershiplevels order by ID");
else $rsm=mysqli_query($dbconnect,"select * from membershiplevels where ID=$startmatrix");

while($arrm=mysqli_fetch_array($rsm)) {
echo "<br><b>Just make the payment of BTC $arrm[2] for your membership at $arrm[1] using the payment button given below.</b>";

$nowTime = date ( "Y-m-d H:i:s", mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$rsm1=mysqli_query($dbconnect,"select * from transaction where Username='$username' and matrixid=$arrm[0]");
if(mysqli_num_rows($rsm1)>0) {
$arrm1=mysqli_fetch_array($rsm1);
$b=$arrm1[0];
$nowTime=$arrm1[4];
$amount1=round($arrm[2],5);
$transaction7=md5(md5($b).md5($username).md5($sitename).md5($amount1*773477).md5($nowTime));
} else {
$sql_i="insert into transaction(Username,PaymentMode,matrixid,Date) values('$username','','$arrm[0]','$nowTime')";
$rs=mysqli_query($dbconnect,$sql_i);
$b=mysqli_insert_id($dbconnect);
$amount1=round($arrm[2],5);
$transaction7=md5(md5($b).md5($username).md5($sitename).md5($amount1*773477).md5($nowTime));
}

$package=$arrm[1];
$profee=$arrm[2];
$fee=$arrm[2];
$amount=$fee;
$desc="$package Membership for User: $username!! Order ID: $b";

echo "<div align=center><table border=0 cellspacing=0 cellpadding=0><tr>";
if($bitcoin_apikey!='0') {
 ?>
 <td align="center">
<form action="https://www.coinpayments.net/index.php" method="post">
    <input type="hidden" name="cmd" value="_pay_simple">
    <input type="hidden" name="reset" value="1">
    <input type="hidden" name="merchant" value="<?php echo $bitcoin_apikey; ?>">
    <input type="hidden" name="item_name" value="<?php echo $sitename; ?> Membership Fee">
    <input type="hidden" name="currency" value="BTC">
    <input type="hidden" name="amountf" value="<?php echo $fee; ?>">
    <input type="hidden" name="want_shipping" value="0">
    <input type="hidden" name="success_url" value="<?php echo $siteurl; ?>/thanks.php">
    <input type="hidden" name="cancel_url" value="<?php echo $siteurl; ?>/purchasepos.php">
    <input type="hidden" name="ipn_url" value="<?php echo $siteurl; ?>/coinpayment.php">
<input type='hidden' name='invoice' value='<?php echo $transaction7; ?>'>
<input type='hidden' name='custom' value='<?php echo $b; ?>'>
    <input type="image" src="https://www.coinpayments.net/images/pub/buynow-wide-blue.png" alt="Buy Now with CoinPayments.net">
</form>
</td>
<?php }
 if($extramerchants>0) {
	$pcode=str_ireplace("{fee}",$profee,$merchantcode1);
	$pcode=str_ireplace("{username}",$username,$pcode);
	$pcode=str_ireplace("{id}",$b,$pcode);
	echo "<td align=center>".stripslashes($pcode)."</td>";
   }
 if($extramerchants>1) {
	$pcode=str_ireplace("{fee}",$profee,$merchantcode2);
	$pcode=str_ireplace("{username}",$username,$pcode);
	$pcode=str_ireplace("{id}",$b,$pcode);
	echo "<td align=center>".stripslashes($pcode)."</td>";
   }
 if($extramerchants>2) {
	$pcode=str_ireplace("{fee}",$profee,$merchantcode3);
	$pcode=str_ireplace("{username}",$username,$pcode);
	$pcode=str_ireplace("{id}",$b,$pcode);
	echo "<td align=center>".stripslashes($pcode)."</td>";
   }
 if($extramerchants>3) {
	$pcode=str_ireplace("{fee}",$profee,$merchantcode4);
	$pcode=str_ireplace("{username}",$username,$pcode);
	$pcode=str_ireplace("{id}",$b,$pcode);
	echo "<td align=center>".stripslashes($pcode)."</td>";
   }
 if($extramerchants>4) {
	$pcode=str_ireplace("{fee}",$profee,$merchantcode5);
	$pcode=str_ireplace("{username}",$username,$pcode);
	$pcode=str_ireplace("{id}",$b,$pcode);
	echo "<td align=center>".stripslashes($pcode)."</td>";
   }
echo "</tr></table></div>";

}



  }
  elseif($check==3) {
  print "<h3 align=center>You hadn't activated your account yet by clicking on activation link.<br>If you hadn't received the confirmation email yet <A href=resendv.php>Click Here</a> to resend your confirmation email.</h3>";
  }
include "loginform.php";
} 
}

function middle()
{
include "header.php";
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

$rs1=mysqli_query($dbconnect,"select Username from users where active=1 and ref_by='$username'");
$totrefs=mysqli_num_rows($rs1);

$totalpos=0;
$rsm=mysqli_query($dbconnect,"select ID,Name,fee,levels from membershiplevels order by ID");
while($arrm=mysqli_fetch_array($rsm)) {
$levels=$arrm[3];
$rsm1=mysqli_query($dbconnect,"select * from matrix$arrm[0] where Username='$username' order by ID");
$totalpos=$totalpos+mysqli_num_rows($rsm1);
}
$rs=mysqli_query($dbconnect,"select * from pages where ID=3");
$arr=mysqli_fetch_array($rs);

if($total=="") $total=0;
if($unpaid=="") $unpaid=0;

$arr[2]=str_ireplace("{sitename}",$sitename,$arr[3]);
$arr[2]=str_ireplace("{total}",$total,$arr[2]);
$arr[2]=str_ireplace("{totrefs}",$totrefs,$arr[2]);
$arr[2]=str_ireplace("{pos}",$totalpos,$arr[2]);
$arr[2]=str_ireplace("{name}",$name,$arr[2]);
$arr[2]=str_ireplace("{unpaid}",$unpaid,$arr[2]);

echo stripslashes($arr[2]);

 }
include "footer.php";
?>