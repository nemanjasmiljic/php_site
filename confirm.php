<?php
session_start();
include "header.php";
include "config.php";
  include "func.php";
  ?>
  <div class="container">
<?
$id=(int)$_GET[id];
$username=validatet($_GET[username]);
if ($id=="" || $username=="")
{
  ?>
  <br><br>
  <blockquote>
  <p align="center"><font size="3" face="Verdana, Arial, Helvetica, sans-serif"><b>Invalid
  Confirmation Link!</b></font></p><br><br><br>
  <?php
}
else
{
  $sql = "Select * from users where ID=".$id." and Username='".$username."'";
  $result = mysqli_query($dbconnect,$sql);
  $total = mysqli_num_rows($result);
  $rs  =  mysqli_fetch_row($result);

  if ($total <1)
  {
    ?>
    <br><br>
      <blockquote>
        <p align="center"><font size="3" face="Verdana, Arial, Helvetica, sans-serif"><b>Invalid
          Confirmation Link!</b></font></p><br><br><br>
    <?php
  }
  else
  {
    if ($rs[10]==1)
    {
      echo("<br><br><b><font size=3><center>You had already activated your account.<br><br>Now just login to your account and start using our service.<br><br><br></b>");
    }
    else
    {
      $sql_u = "Update users set active='1' where Username='" . $username ."'";
      $result_u = mysqli_query($dbconnect,$sql_u);

?>
<p align="left"><font size="2" face="Verdana"><b>Your Email Address has been validated now! </b><br>
<?php


if($freemember==0) {
      echo("<br>You need to purchase a matrix position in order to activate your account!<br>");

if($startmatrix==0) $rsm=mysqli_query($dbconnect,"select * from membershiplevels order by ID");
else $rsm=mysqli_query($dbconnect,"select * from membershiplevels where ID=$startmatrix");

while($arrm=mysqli_fetch_array($rsm)) {
echo "<br><b>Just make the payment of BTC $arrm[2] for your membership at $arrm[1] using the payment button given below.</b>";

$nowTime = date ( "Y-m-d H:i:s", mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$sql_i="insert into transaction(Username,PaymentMode,matrixid,Date) values('$username','','$arrm[0]','$nowTime')";
$rs=mysqli_query($dbconnect,$sql_i);
$b=mysqli_insert_id($dbconnect);
$amount1=round($arrm[2],5);
$transaction7=md5(md5($b).md5($username).md5($sitename).md5($amount1*773477).md5($nowTime));

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
else {
echo("All features of our service are available to you immediately.<br>
You can <a href=login.php>Login now</a> and start using our service!<br>");
}

  $to = $rs[7];

$message1=$message2;
$message1=str_ireplace("{name}","$rs[1]",$message1);
$message1=str_ireplace("{email}","$rs[7]",$message1);
$message1=str_ireplace("{username}","$rs[8]",$message1);
$message1=str_ireplace("{password}","$rs[9]",$message1);
$message1=str_ireplace("{sitename}","$sitename",$message1);
$message1=str_ireplace("{siteurl}","$siteurl",$message1);

$subject1=str_ireplace("{name}","$rs[1]",$subject2);
$subject1=str_ireplace("{email}","$rs[7]",$subject1);
$subject1=str_ireplace("{username}","$rs[8]",$subject1);
$subject1=str_ireplace("{password}","$rs[9]",$subject1);
$subject1=str_ireplace("{sitename}","$sitename",$subject1);
$subject1=str_ireplace("{siteurl}","$siteurl",$subject1);
      $message=stripslashes($message1);
      $subject=stripslashes($subject1);

$from=$webmasteremail;
    	$header = "From: $sitename<$from>\n";
if($eformat2==1) 
	$header .="Content-type: text/plain; charset=iso-8859-1\n";
else
	$header .="Content-type: text/html; charset=iso-8859-1\n";
	$header .= "Reply-To: <$from>\n";
	$header .= "X-Sender: <$from>\n";
	$header .= "X-Mailer: PHP4\n";
	$header .= "X-Priority: 3\n";
	$header .= "Return-Path: <$from>\n";

  //mail($to,$subject,$message,$header);
send_mailer($to,$subject,$message,$eformat2,$mailertype,$from);

if($refnotification==1) {
$ref_by=$rs[11];
$rs1=mysqli_query($dbconnect,"select * from users where Username='$ref_by'");
if(mysqli_num_rows($rs1)>0) {
$arr1=mysqli_fetch_array($rs1);
$message1=$message3;
$message1=str_ireplace("{name}","$arr1[1]",$message1);
$message1=str_ireplace("{email}","$arr1[7]",$message1);
$message1=str_ireplace("{username}","$arr1[8]",$message1);
$message1=str_ireplace("{password}","$arr1[9]",$message1);
$message1=str_ireplace("{sitename}","$sitename",$message1);
$message1=str_ireplace("{siteurl}","$siteurl",$message1);
$message1=str_ireplace("{refname}","$rs[1]",$message1);
$message1=str_ireplace("{refemail}","$rs[7]",$message1);
$message1=str_ireplace("{refusername}","$rs[8]",$message1);


$subject1=str_ireplace("{name}","$arr1[1]",$subject3);
$subject1=str_ireplace("{email}","$arr1[7]",$subject1);
$subject1=str_ireplace("{username}","$arr1[8]",$subject1);
$subject1=str_ireplace("{password}","$arr1[9]",$subject1);
$subject1=str_ireplace("{sitename}","$sitename",$subject1);
$subject1=str_ireplace("{siteurl}","$siteurl",$subject1);
$subject1=str_ireplace("{refname}","$rs[1]",$subject1);
$subject1=str_ireplace("{refemail}","$rs[7]",$subject1);
$subject1=str_ireplace("{refusername}","$rs[8]",$subject1);

      $message=stripslashes($message1);
      $subject=stripslashes($subject1);

    $to = $arr1[7];
    	$header = "From: $sitename<$from>\n";
if($eformat3==1) 
	$header .="Content-type: text/plain; charset=iso-8859-1\n";
else
	$header .="Content-type: text/html; charset=iso-8859-1\n";
	$header .= "Reply-To: <$from>\n";
	$header .= "X-Sender: <$from>\n";
	$header .= "X-Mailer: PHP4\n";
	$header .= "X-Priority: 3\n";
	$header .= "Return-Path: <$from>\n";

    //mail($to,$subject,$message,$header);
	send_mailer($to,$subject,$message,$eformat3,$mailertype,$from);
}
}

    }
  }
}
echo "</div>";
include "./footer.php";
?>