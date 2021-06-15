<?php
session_start();
include "header.php";
include "config.php";
include "func.php";

if($_POST) {
	if($_POST['name'] == '') {
		$nameError = 'You forgot to enter the name.';
	}
	if($_POST['email'] == '') {
		$emailError = 'You forgot to enter the email address.';
	} elseif(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $_POST['email'])) {
		$emailError = 'Enter a valid email address.';
	}
	if($_POST['subject'] == '') {
		$subjectError = 'You forgot to enter the subject.';
	}
	
	if($_POST['message'] == '') {
		$messageError = 'You forgot to enter the message.';
	}
   if( $_SESSION['security_code'] == $_POST['security_code'] && !empty($_SESSION['security_code'] ) ) {
 	} else {
$capError="Invalid Security Code.";
    }


	if(!isset($emailError) && !isset($nameError) && !isset($subjectError) && !isset($messageError) && !isset($capError)) {
      $to = $webmasteremail;
      $subject = "Help Request for ".$sitename;
      $from = validatet($_POST["email"]);
      $message="A Visitor at your website had submitted this help request.

Name:".validatet($_POST[name])."
Email:".validatet($_POST[email])."
Subject:".validatet($_POST["subject"])."
Message:".validatet($_POST["message"]);
    	$header = "From: $from<$from>\n";
	$header .="Content-type: text/plain; charset=iso-8859-1\n";
	$header .= "Reply-To: <$from>\n";
	$header .= "X-Sender: <$from>\n";
	$header .= "X-Mailer: PHP4\n";
	$header .= "X-Priority: 3\n";
	$header .= "Return-Path: <$from>\n";

      //mail($to,$subject,$message,$header);
	  if($mailertype==1) send_mailer($to,$subject,$message,1,$mailertype,$from);
  	  else send_mailer($to,$subject,$message,1,$mailertype,$webmasteremail);


echo "<br><br><br><br><b><font face=verdana size=2>Your Request have been submitted.<br>
One of our Customer Representative will reply you soon.</b><br><br><br><br>";
include "footer.php";
exit;

	}
}

?>
<div class="margin-vertical-40"></div>  

<div class="container">
	<div class="col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
		<div class="panel panel-main">
			<div class="panel-heading"><h4>Contact Us</h4></div>
			<div class="panel-body">
				<form class="form-horizontal" role="form" action="" method="post">
					 <div class='form-group <? if(isset($nameError)) echo "has-error has-feedback";?>'>
						<label class="col-sm-3 control-label">Your Name</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" placeholder="<? if(isset($nameError)) echo $nameError; else echo "Name";?>" title="Your Name" name="name" value="<? echo validatet($_POST[name]); ?>">
							<? if(isset($nameError)) echo "<span class='glyphicon glyphicon-warning-sign form-control-feedback'></span>";?>
						</div>
					</div>
					 <div class='form-group <? if(isset($emailError)) echo "has-error has-feedback";?>'>
						<label class="col-sm-3 control-label">Your E-mail</label>
						<div class="col-sm-9">
							<input type="email" class="form-control" placeholder="<? if(isset($emailError)) echo $emailError; else echo "Email Address";?>" title="Email Address" name="email" value="<? echo validatet($_POST[email]); ?>" />
							<? if(isset($emailError)) echo "<span class='glyphicon glyphicon-warning-sign form-control-feedback'></span>"; ?>
						</div>
					</div>
					 <div class='form-group <? if(isset($subjectError)) echo "has-error has-feedback";?>'>
						<label class="col-sm-3 control-label">Subject</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" placeholder="<? if(isset($subjectError)) echo $subjectError; else echo "Subject";?>" name="subject" value="<? echo validatet($_POST[subject]); ?>" />
							<?php if(isset($subjectError)) echo "<span class='glyphicon glyphicon-warning-sign form-control-feedback'></span>"; ?>
						</div>
					</div>
					 <div class='form-group <? if(isset($messageError)) echo "has-error has-feedback";?>'>
						<label class="col-sm-3 control-label">Message</label>
						<div class="col-sm-9">
							<textarea class="form-control" name="message" placeholder="<? if(isset($messageError)) echo $messageError; else echo "Message";?>"><? echo validatet($_POST[message]); ?></textarea>
							<?php if(isset($messageError)) echo "<span class='glyphicon glyphicon-warning-sign form-control-feedback'></span>"; ?>
						</div>
					</div>
					<div class='form-group <? if(isset($capError)) echo "has-error has-feedback";?>'>
						<label class="col-sm-3 control-label">Security Code</label>
						<div class="col-sm-9">
							<div class="input-group">
								<span class="input-group-addon" id="sizing-addon2" style="padding:0"><img src="CaptchaSecurityImages.php?width=80&height=30&characters=5" /></span>
								<input type="text" class="form-control" placeholder="<?php if(isset($capError)) echo $capError; else echo "Security Code";?>" aria-describedby="sizing-addon2" name="security_code" />
								<?php if(isset($capError)) echo "<span class='glyphicon glyphicon-warning-sign form-control-feedback'></span>"; ?>
							</div>
						</div>
					</div>
					<center><input type="submit" value="Submit" class="btn btn-main btn-lg" /></center>
				</form>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
<div class="margin-vertical-20"></div>
<?
include "footer.php";
?>