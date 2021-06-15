<?php
  session_start();

include "header.php";
include "config.php";
include "func.php";
$id=$_SESSION[refid_session];
$sname="";
if($id) {
	$rs=mysqli_query($dbconnect,"select Name from users where Username='$id'");
	if(mysqli_num_rows($rs)>0) {
		$arr=mysqli_fetch_array($rs);
		$sname=$arr[0];
	}
}

if($_POST) {
	if($_POST['first_name'] == '') {
		$fnameError = 'You forgot to enter the First Name.';
	}
	if($_POST['last_name'] == '') {
		$lnameError = 'You forgot to enter the Last Name.';
	}
	if(($showaddress==1)&&($_POST['address'] == '')) {
		$addressError = 'You forgot to enter the Address.';
	}
	if(($showcity==1)&&($_POST['city'] == '')) {
		$cityError = 'You forgot to enter the City.';
	}
	if(($showstate==1)&&($_POST['state'] == '')) {
		$stateError = 'You forgot to enter the State.';
	}
	if(($showzip==1)&&($_POST['zip'] == '')) {
		$zipError = 'You forgot to enter the Zip.';
	}
	if(($showcountry==1)&&($_POST['country'] == '')) {
		$countryError = 'You forgot to enter the Country.';
	}
	if(($phonereq==1)&&($_POST['phone'] == '')) {
		$phoneError = 'You forgot to enter the Phone Number.';
	}
	if(($bitcoinreq==1)&&($_POST['bitcoin'] == '')) {
		$bitcoinError = 'You forgot to enter the Bitcoin Wallet Address.';
	}	elseif(($bitcoinreq==1)&&(strlen($_POST["bitcoin"])<32)||(strlen($_POST["bitcoin"])>34)) $bitcoinError = "Incorrect Bitcoin wallet, please open up a fresh wallet at <a href=https://www.blockchain.info target=_blank>BlockChain</a>";
	if($_POST['username'] == '') {
		$usernameError = 'You forgot to enter the Username.';
	} elseif(!preg_match ("/^([[:alnum:]]+)$/", $_POST['username']))  {
		$usernameError = 'Username can contain only alpha numeric characters.';
	} elseif(strlen($_POST['username'])<5)  {
		$usernameError = 'Username must have atleast 5 alpha numeric characters.';
	}
	if($_POST['password'] == '') {
		$passwordError = 'You forgot to enter the Password.';
	}
	if($_POST['cpassword'] == '') {
		$cpasswordError = 'You forgot to enter the Confirm Password.';
	} elseif($_POST[password]!=$_POST[cpassword]) {
		$cpasswordError = 'Password and Confirm Password doesn\'t match.';
	}
	if($_POST['email'] == '') {
		$emailError = 'You forgot to enter the email address.';
	} elseif(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $_POST['email'])) {
		$emailError = 'Enter a valid email address to send to.';
	}
   if( $_SESSION['security_code'] == $_POST['security_code'] && !empty($_SESSION['security_code'] ) ) {
 	} else {
$capError="Invalid Security Code.";
    }

$email=validatet($_POST[email]);
$username=validatet($_POST[username]);
      $check=0;
      $sql = "select * from users where Email='".$email."'";
      $result = mysqli_query($dbconnect,$sql);
      $total = mysqli_num_rows($result);
      $rs  =  mysqli_fetch_row($result);

      $sql1 = "select * from users where Username='".$username."'";
      $result1 = mysqli_query($dbconnect,$sql1);
      $total1 = mysqli_num_rows($result1);
      $rs1  =  mysqli_fetch_row($result1);

      if ($total > 0) {
          $check=1;
      }
      $username=strtolower($username); if($username=="admin") {
	$check=5;
      }
      if ($total1 > 0) {
          $check=3;
      }
    if ($check==1) {
		$emailError = 'Account with this email address already exists.';
    }
    elseif ($check==3) {
		$usernameError = 'Account with this username already exists.';
    }
    elseif ($check==5) {
		$usernameError = 'Account with this username already exists.';
    }


	if(!isset($emailError) && !isset($fnameError) && !isset($lnameError) && !isset($addressError) && !isset($cityError) && !isset($stateError) && !isset($zipError) && !isset($countryError) && !isset($usernameError) && !isset($passwordError) && !isset($cpasswordError) && !isset($capError) && !isset($bitcoinError)) {

  $space = " ";
  $a[1] = $_POST[first_name] . $space . $_POST[last_name];
	$a[1]=validatet($a[1]);
 if($showaddress==1)  $a[2]=validatet($_POST[address]); else $a[2]=" ";
 if($showcity==1)  $a[3]=validatet($_POST[city]); else $a[3]=" ";
 if($showstate==1)  $a[4]=validatet($_POST[state]); else $a[4]=" ";
 if($showzip==1)  $a[5]=validatet($_POST[zip]); else $a[5]=" ";
 if($showcountry==1)  $a[6]=validatet($_POST[country]); else $a[6]=" ";
  $a[7]=validatet($_POST[email]);
  $a[8]=validatet($_POST[username]);
	$a[8]=str_ireplace(" ","",$a[8]);
	$a[8]=strtolower($a[8]);
$username=$a[8];
  $a[9]=validatet($_POST[password]);
  $a[12]=getUserIP();
  $a[13]=date("j M, Y");
  $a[14]=validatet($_POST[cpassword]);
  $a[15]=validatet($_POST[phone]);
  $a[16]=validatet($_POST[bitcoin]);
  $ref_by=strtolower($_SESSION["refid_session"]);

		if($emailcourtapikey==""||$emailcourtapikey=="0")	$em=TRUE;
		else 												$em=authenticateemail($emailcourtapikey,$a[7]);

		if(($em<>"Unknown")&&(is_bool($em)!=TRUE)) {
			$emailError=$em;
		}
		else {
$rs=mysqli_query($dbconnect,"select * from users where Username='$ref_by' and active=1");
if(mysqli_num_rows($rs)<1) {
$ref_by="";
}


if($confirmreq==1) $aactive=0;
else $aactive=1;

      $sql_i="insert into users(Name,Address,City,State,Zip,Country,Email,Username,Password,active,ref_by,IP,Date,status,Total,Unpaid,Paid,RDate,subscribed,banners,bannersused,textads,textadsused,Phone,BitcoinWallet) values
              (
               '$a[1]',
               '$a[2]',
               '$a[3]',
               '$a[4]',
               '$a[5]',
               '$a[6]',
               '$a[7]',
               '$a[8]',
               '$a[9]',
               $aactive,
               '$ref_by',
               '$a[12]',
               now(),
		1,
		0.00,
		0.00,
		0.00,
		now(),1,0,0,0,0,'$a[15]','$a[16]'
              )";
      $rs=mysqli_query($dbconnect,$sql_i);
      $b=mysqli_insert_id($dbconnect);


      echo("<div class=\"container\">");
if($confirmreq==1) {
echo("<br><div align=left><font size=2 face='Verdana, Arial, Helvetica, sans-serif'>$a[1] Thank you for registering.<br>");
?>
A message has been sent to your email box: <?php echo $a[7]; ?>.
There's a link inside the email, click it. You will be returned to <?php echo $sitename;?>.  
It will activate your account. </b><br><br>
The e-mail is sent out instantly. If you do not received it within 10-15 minutes, we recommend you <a href=resendv.php>Click Here</a> to receive it again.<br>
If you are using free email address provider like yahoo/hotmail then please don't forget to check your junk/bulk folder as it may be delivered there.
<br><br>
Also don't forget to whitelist our email address <?php echo $webmasteremail; ?> so that you may receive all the future emails properly.
<br><br>
<?php
echo "</div>";
      echo("<br><br><br>");

$to = $a[7];

$validationurl="$siteurl/confirm.php?username=$a[8]&id=$b";
$message1=str_ireplace("{validationurl}","$validationurl",$message1);
$message1=str_ireplace("{name}","$a[1]",$message1);
$message1=str_ireplace("{email}","$a[7]",$message1);
$message1=str_ireplace("{username}","$a[8]",$message1);
$message1=str_ireplace("{password}","$a[9]",$message1);
$message1=str_ireplace("{sitename}","$sitename",$message1);
$message1=str_ireplace("{siteurl}","$siteurl",$message1);

$subject1=str_ireplace("{name}","$a[1]",$subject1);
$subject1=str_ireplace("{email}","$a[7]",$subject1);
$subject1=str_ireplace("{username}","$a[8]",$subject1);
$subject1=str_ireplace("{password}","$a[9]",$subject1);
$subject1=str_ireplace("{sitename}","$sitename",$subject1);
$subject1=str_ireplace("{siteurl}","$siteurl",$subject1);
      $message=stripslashes($message1);
      $subject=stripslashes($subject1);

$from=$webmasteremail;
    	$header = "From: $sitename<$from>\n";
if($eformat1==1) 
	$header .="Content-type: text/plain; charset=iso-8859-1\n";
else
	$header .="Content-type: text/html; charset=iso-8859-1\n";
	$header .= "Reply-To: <$from>\n";
	$header .= "X-Sender: <$from>\n";
	$header .= "X-Mailer: PHP4\n";
	$header .= "X-Priority: 3\n";
	$header .= "Return-Path: <$from>\n";

  //mail($to,$subject,$message,$header);
  send_mailer($to,$subject,$message,$eformat1,$mailertype,$from);

} else {
      echo("<br><font size=2 face='Verdana, Arial, Helvetica, sans-serif'>");

if($freemember==0) {
      echo("<br><b>".$a[1]." Thank you for registering. <br>");
echo("You need to purchase a matrix position in order to activate your account!<br>");

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
      echo("<br><b>".$a[1]." Thank you for registering. <br>");
echo("Your Account have been Activated Now!<br>
All features of our service are available to you immediately.<br>
You can <a href=login.php>Login now</a> and start using our service!<br>");
}

      echo("</font><br>");

  $to = $a[7];

$message1=$message2;
$message1=str_ireplace("{name}","$a[1]",$message1);
$message1=str_ireplace("{email}","$a[7]",$message1);
$message1=str_ireplace("{username}","$a[8]",$message1);
$message1=str_ireplace("{password}","$a[9]",$message1);
$message1=str_ireplace("{sitename}","$sitename",$message1);
$message1=str_ireplace("{siteurl}","$siteurl",$message1);

$subject1=str_ireplace("{name}","$a[1]",$subject2);
$subject1=str_ireplace("{email}","$a[7]",$subject1);
$subject1=str_ireplace("{username}","$a[8]",$subject1);
$subject1=str_ireplace("{password}","$a[9]",$subject1);
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
$message1=str_ireplace("{refname}","$a[1]",$message1);
$message1=str_ireplace("{refemail}","$a[7]",$message1);
$message1=str_ireplace("{refusername}","$a[8]",$message1);

$subject1=str_ireplace("{name}","$arr1[1]",$subject3);
$subject1=str_ireplace("{email}","$arr1[7]",$subject1);
$subject1=str_ireplace("{username}","$arr1[8]",$subject1);
$subject1=str_ireplace("{password}","$arr1[9]",$subject1);
$subject1=str_ireplace("{sitename}","$sitename",$subject1);
$subject1=str_ireplace("{siteurl}","$siteurl",$subject1);
$subject1=str_ireplace("{refname}","$a[1]",$subject1);
$subject1=str_ireplace("{refemail}","$a[7]",$subject1);
$subject1=str_ireplace("{refusername}","$a[8]",$subject1);

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

include "footer.php";
exit;
	}
}
}



?>

         	<div class="margin-vertical-40"></div>  
            
         	<div class="container">
				<div class="col-sm-10 col-md-8 col-sm-offset-1 col-md-offset-2">
					<div class="panel panel-main">
						<div class="panel-heading"><h4>Join Now</h4></div>
						<div class="panel-body">
							<form class="form-horizontal" role="form" action="" method="post">
								<div class='form-group'>
									<label class="col-sm-3 control-label">Sponsor</label>
									<div class="col-sm-9">
										<?php echo $sname; ?>
									</div>
								</div>
								<div class='form-group <? if(isset($fnameError)) echo "has-error has-feedback";?>'>
									<label class="col-sm-3 control-label">First Name</label>
									<div class="col-sm-9">
										<input type="text" name="first_name" id="first_name" class="form-control" placeholder="<? if(isset($fnameError)) echo $fnameError; else echo "First Name";?>" title="First Name" value="<?php echo validatet($_POST[first_name]); ?>">
										<?php if(isset($fnameError)) echo "<span class='glyphicon glyphicon-warning-sign form-control-feedback'></span>"; ?>
									</div>
								</div>
								<div class='form-group <? if(isset($lnameError)) echo "has-error has-feedback";?>'>
									<label class="col-sm-3 control-label">Last Name</label>
									<div class="col-sm-9">
										<input type="text" name="last_name" id="last_name" class="form-control" placeholder="<? if(isset($lnameError)) echo $lnameError; else echo "Last Name";?>" title="Last Name" value="<?php echo validatet($_POST[last_name]); ?>">
										<?php if(isset($lnameError)) echo "<span class='glyphicon glyphicon-warning-sign form-control-feedback'></span>"; ?>
									</div>
								</div>
<?php if($showaddress==1) { ?>
								<div class='form-group <? if(isset($addressError)) echo "has-error has-feedback";?>'>
									<label class="col-sm-3 control-label">Address</label>
									<div class="col-sm-9">
										<input type="text" name="address" id="address" class="form-control" placeholder="<? if(isset($addressError)) echo $addressError; else echo "Address";?>" title="Address" value="<?php echo validatet($_POST[address]); ?>">
										<?php if(isset($addressError)) echo "<span class='glyphicon glyphicon-warning-sign form-control-feedback'></span>"; ?>
									</div>
								</div>
<?php } ?>
<?php if($showcity==1) { ?>
								<div class='form-group <? if(isset($cityError)) echo "has-error has-feedback";?>'>
									<label class="col-sm-3 control-label">City</label>
									<div class="col-sm-9">
										<input type="text" name="city" id="city" class="form-control" placeholder="<? if(isset($cityError)) echo $cityError; else echo "City";?>" title="City" value="<?php echo validatet($_POST[city]); ?>">
										<?php if(isset($cityError)) echo "<span class='glyphicon glyphicon-warning-sign form-control-feedback'></span>"; ?>
									</div>
								</div>
<?php } ?>
<?php if($showstate==1) { ?>
								<div class='form-group <? if(isset($stateError)) echo "has-error has-feedback";?>'>
									<label class="col-sm-3 control-label">State</label>
									<div class="col-sm-9">
										<input type="text" name="state" id="state" class="form-control" placeholder="<? if(isset($stateError)) echo $stateError; else echo "State";?>" title="State" value="<?php echo validatet($_POST[state]); ?>">
										<?php if(isset($stateError)) echo "<span class='glyphicon glyphicon-warning-sign form-control-feedback'></span>"; ?>
									</div>
								</div>
<?php } ?>
<?php if($showzip==1) { ?>
								<div class='form-group <? if(isset($zipError)) echo "has-error has-feedback";?>'>
									<label class="col-sm-3 control-label">Postal Code</label>
									<div class="col-sm-9">
										<input type="text" name="zip" id="zip" class="form-control" placeholder="<? if(isset($zipError)) echo $zipError; else echo "Postal Code";?>" title="Postal Code" value="<?php echo validatet($_POST[zip]); ?>">
										<?php if(isset($zipError)) echo "<span class='glyphicon glyphicon-warning-sign form-control-feedback'></span>"; ?>
									</div>
								</div>
<?php } ?>
<?php if($showcountry==1) { ?>
								<div class='form-group <? if(isset($countryError)) echo "has-error has-feedback";?>'>
									<label class="col-sm-3 control-label">Country</label>
									<div class="col-sm-9">
										<input type="text" name="country" id="country" class="form-control" placeholder="<? if(isset($countryError)) echo $countryError; else echo "Country";?>" title="Country" value="<?php echo validatet($_POST[country]); ?>">
										<?php if(isset($countryError)) echo "<span class='glyphicon glyphicon-warning-sign form-control-feedback'></span>"; ?>
									</div>
								</div>
<?php } ?>
								<div class='form-group <? if(isset($phoneError)) echo "has-error has-feedback";?>'>
									<label class="col-sm-3 control-label" for="phone">Phone:</label>
									<div class="col-sm-9">
										<input type="phone" class="form-control" id="Phone" placeholder="<? if(isset($phoneError)) echo $phoneError; else echo "Enter Phone";?>" name="phone" value="<?php echo validatet($_POST[phone]); ?>">
										<?php if(isset($phoneError)) echo "<span class='glyphicon glyphicon-warning-sign form-control-feedback'></span>"; ?>
									</div>
								</div>
								<div class='form-group <? if(isset($bitcoinError)) echo "has-error has-feedback";?>'>
									<label class="col-sm-3 control-label" for="bitcoin">Bitcoin Wallet Address:</label>
									<div class="col-sm-9">
										<input type="bitcoin" class="form-control" id="bitcoin" placeholder="<? if(isset($bitcoinError)) echo $bitcoinError; else echo "Enter Bitcoin Wallet Address";?>" name="bitcoin" value="<?php echo validatet($_POST[bitcoin]); ?>">
										<?php if(isset($bitcoinError)) echo "<span class='glyphicon glyphicon-warning-sign form-control-feedback'></span>"; ?>
									</div>
								</div>
								<div class='form-group <? if(isset($emailError)) echo "has-error has-feedback";?>'>
									<label class="col-sm-3 control-label">E-mail Address</label>
									<div class="col-sm-9">
										<input type="email" name="email" id="email" class="form-control" placeholder="<? if(isset($emailError)) echo $emailError; else echo "Email Address";?>" title="Email Address" value="<?php echo validatet($_POST[email]); ?>">
										<?php if(isset($emailError)) echo "<span class='glyphicon glyphicon-warning-sign form-control-feedback'></span>"; ?>
									</div>
								</div>
								<div class='form-group <? if(isset($usernameError)) echo "has-error has-feedback";?>'>
									<label class="col-sm-3 control-label">Username</label>
									<div class="col-sm-9">
										<input type="text" name="username" id="username" class="form-control" placeholder="<? if(isset($usernameError)) echo $usernameError; else echo "Username";?>" title="User Name" value="<?php echo validatet($_POST[username]); ?>">
										<?php if(isset($usernameError)) echo "<span class='glyphicon glyphicon-warning-sign form-control-feedback'></span>"; ?>
									</div>
								</div>
								<div class='form-group <? if(isset($passwordError)) echo "has-error has-feedback";?>'>
									<label class="col-sm-3 control-label">Password</label>
									<div class="col-sm-9">
										<input type="password" name="password" id="password" class="form-control" placeholder="<? if(isset($passwordError)) echo $passwordError; else echo "Password";?>" title="Password">
										<?php if(isset($passwordError)) echo "<span class='glyphicon glyphicon-warning-sign form-control-feedback'></span>"; ?>
									</div>
								</div>
								<div class='form-group <? if(isset($cpasswordError)) echo "has-error has-feedback";?>'>
									<label class="col-sm-3 control-label">Confirm Password</label>
									<div class="col-sm-9">
										<input type="password" name="cpassword" id="password_confirmation" class="form-control" placeholder="<? if(isset($cpasswordError)) echo $cpasswordError; else echo "Confirm Password";?>" title="Confirm Password" />
										<?php if(isset($cpasswordError)) echo "<span class='glyphicon glyphicon-warning-sign form-control-feedback'></span>"; ?>
									</div>
								</div>
								<div class='form-group <? if(isset($capError)) echo "has-error has-feedback";?>'>
									<label class="col-sm-3 control-label">Security Code</label>
									<div class="col-sm-9">
										<div class="input-group">
											<span class="input-group-addon" id="sizing-addon2" style="padding:0"><img src="CaptchaSecurityImages.php?width=80&height=30&characters=5" /></span>
											<input type="text" class="form-control" placeholder="<? if(isset($capError)) echo $capError; else echo "Security Code";?>" aria-describedby="sizing-addon2" name="security_code">
											<?php if(isset($capError)) echo "<span class='glyphicon glyphicon-warning-sign form-control-feedback'></span>"; ?>
										</div>
									</div>
								</div>
								<div class="help-block">
									<p>You are <B>agreeing</B> to our <b><a href=terms.php target=_blank>Terms and Conditions</a></b> by pressing the Register Button.</p>
								</div>
								<center><input type="submit" value="Register" class="btn btn-main btn-lg" /></center>
							</form>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
            </div>
			<div class="margin-vertical-20"></div>
<?php
	include "footer.php";
    function getUserIP()
    {
        if (isset($_SERVER['REMOTE_ADDR']) AND isset($_SERVER['HTTP_CLIENT_IP']))
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        elseif (isset($_SERVER['REMOTE_ADDR']))
            $ip = $_SERVER['REMOTE_ADDR'];
        elseif(isset($_SERVER['HTTP_CLIENT_IP']))
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    
        return $ip;
    }
?>