<?php
session_start();
include "header.php";
include "config.php";
include "func.php";

$a=validatet($_POST[Email]);
if ($a=="")
{
  ?>
<div class="margin-vertical-40"></div>  
<div class="container">
	<div class="col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
		<div class="panel panel-main">
			<div class="panel-heading"><h4>Resend Verification Email</h4></div>
			<div class="panel-body">
				<form action='' method=post>
					<p align="center"> <strong>Please enter&nbsp;the Email address you used to register at <font color="#000040"><b><?php echo($sitename) ; ?></b></font> and then press submit.</strong></p>
					<input class="form-control" name="Email" size="30" /><br>
					<center><input type="submit" class="btn btn-main" value="Submit"></center>
					<p><strong>Your confirmation email will be sent to you within few minutes.</strong>
				</form>
			</div>
		</div>
	</div>
</div>
  <?php
}
else
{
  $sql = "Select * from users where Email='".$a."'";
  $result = mysqli_query($dbconnect,$sql);
  $total = mysqli_num_rows($result);
  $rs  =  mysqli_fetch_row($result);
  if ($total < 1)
  {
    echo("<b><br><br><br><center>Sorry, this Email Address doesn't exist in our member database.<br></center></b>");
    ?>
<div class="margin-vertical-40"></div>  
<div class="container">
	<div class="col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
		<div class="panel panel-main">
			<div class="panel-heading"><h4>Resend Verification Email</h4></div>
			<div class="panel-body">
				<form action='' method=post>
					<p align="center"> <strong>Please enter&nbsp;the Email address you used to register at <font color="#000040"><b><?php echo($sitename) ; ?></b></font> and then press submit.</strong></p>
					<input class="form-control" name="Email" size="30" /><br>
					<center><input type="submit" class="btn btn-main" value="Submit"></center>
					<p><strong>Your confirmation email will be sent to you within few minutes.</strong>
				</form>
			</div>
		</div>
	</div>
</div>
   <?php
  }
  else
  {
      if($rs[10]==1) {
echo "<br><br><b>Your account is already active.<br><a href=login.php>Click Here</a> to login to your account.<br></b><br>";
	}
	else {

$to=$rs[7];

$validationurl="$siteurl/confirm.php?username=$rs[8]&id=$rs[0]";
$message1=str_ireplace("{validationurl}","$validationurl",$message1);
$message1=str_ireplace("{name}","$rs[1]",$message1);
$message1=str_ireplace("{email}","$rs[7]",$message1);
$message1=str_ireplace("{username}","$rs[8]",$message1);
$message1=str_ireplace("{password}","$rs[9]",$message1);
$message1=str_ireplace("{sitename}","$sitename",$message1);
$message1=str_ireplace("{siteurl}","$siteurl",$message1);

$subject1=str_ireplace("{name}","$rs[1]",$subject1);
$subject1=str_ireplace("{email}","$rs[7]",$subject1);
$subject1=str_ireplace("{username}","$rs[8]",$subject1);
$subject1=str_ireplace("{password}","$rs[9]",$subject1);
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

    echo("<br><br><br><center>Your Verification Email has been sent to your Email Address!<br><br></center>
<div align=left>
If you do not received it within 10-15 minutes, we recommend you <a href=resendv.php>Click Here</a> to receive it again.<br>
If you are using free email address provider like yahoo/hotmail then please don't forget to check your junk/bulk folder as it may be delivered there.
<br><br>
Also don't forget to whitelist our email address $webmasteremail so that you may receive all the future emails properly.
</div>
<br><br><br><br>");
	}
  }
}

include "footer.php";
?>