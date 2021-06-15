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
			<div class="panel-heading"><h4>Password Reminder</h4></div>
			<div class="panel-body">
				<form action=forgot.php method=post>
					<p align="center"> <strong>Please enter&nbsp;the Email address you used to register at <font color="#000040"><b><?php echo($sitename) ; ?></b></font> and then press submit.</strong></p>
					<input class="form-control" name="Email" size="30" />
					<center><input type="submit" class="btn btn-main" value="Submit"></center>
					<p><strong>Your Password will be sent to you within few minutes.</strong>
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
  if ($total < 1)
  {
    echo("<b><br><br><br><center>Sorry , this Email Address doesn't exist in our member database .<br></center></b>");
    ?>
<div class="margin-vertical-40"></div>  
<div class="container">
	<div class="col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
		<div class="panel panel-main">
			<div class="panel-heading"><h4>Password Reminder</h4></div>
			<div class="panel-body">
				<form action=forgot.php method=post>
					<p align="center"> <strong>Please enter&nbsp;the Email address you used to register at <font color="#000040"><b><?php echo($sitename) ; ?></b></font> and then press submit.</strong></p>
					<input class="form-control" name="Email" size="30" />
					<center><input type="submit" class="btn btn-main" value="Submit"></center>
					<p><strong>Your Password will be sent to you within few minutes.</strong>
				</form>
			</div>
		</div>
	</div>
</div>
   <?php
  }
  else
  {
  $rs  =  mysqli_fetch_row($result);

  $to = $rs[7];

$message1=$message5;
$message1=str_ireplace("{name}","$rs[1]",$message1);
$message1=str_ireplace("{email}","$rs[7]",$message1);
$message1=str_ireplace("{username}","$rs[8]",$message1);
$message1=str_ireplace("{password}","$rs[9]",$message1);
$message1=str_ireplace("{sitename}","$sitename",$message1);
$message1=str_ireplace("{siteurl}","$siteurl",$message1);

$subject1=str_ireplace("{name}","$rs[1]",$subject5);
$subject1=str_ireplace("{email}","$rs[7]",$subject1);
$subject1=str_ireplace("{username}","$rs[8]",$subject1);
$subject1=str_ireplace("{password}","$rs[9]",$subject1);
$subject1=str_ireplace("{sitename}","$sitename",$subject1);
$subject1=str_ireplace("{siteurl}","$siteurl",$subject1);
      $message=stripslashes($message1);
      $subject=stripslashes($subject1);

$from=$webmasteremail;
    	$header = "From: $sitename<$from>\n";
if($eformat5==1) 
	$header .="Content-type: text/plain; charset=iso-8859-1\n";
else
	$header .="Content-type: text/html; charset=iso-8859-1\n";
	$header .= "Reply-To: <$from>\n";
	$header .= "X-Sender: <$from>\n";
	$header .= "X-Mailer: PHP4\n";
	$header .= "X-Priority: 3\n";
	$header .= "Return-Path: <$from>\n";

  //mail($to,$subject,$message,$header);
  send_mailer($to,$subject,$message,$eformat5,$mailertype,$from);

    echo("<br><br><br><b><center>Your Password had been send to your Email Address!<br></center></b><br><br><br><br><br><br><br>");
  }
}
echo("<BR><BR>");
include "footer.php";
?>