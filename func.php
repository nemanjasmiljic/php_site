<?php
function validatet($ad) {
  $ad=trim($ad);
  $ad=str_ireplace("'","",$ad);
  $ad=str_ireplace("\"","",$ad);
  $ad=str_ireplace("\\","",$ad);
  $ad=str_ireplace("<script","",$ad);
  $ad=str_ireplace("</script","",$ad);
  $ad=str_ireplace("<iframe","",$ad);
  $ad=str_ireplace("</iframe","",$ad);
  $ad=str_ireplace("&lt;script","",$ad);
  $ad=str_ireplace("&lt;IFRAME","",$ad);
  $ad=str_ireplace("&lt;/script","",$ad);
  $ad=str_ireplace("&lt;/IFRAME","",$ad);

  return $ad;
}
function send_mailer($to,$subject,$message,$format,$mtype,$from) {
	include "config.php";
	$subject=stripslashes($subject);
	$message=stripslashes($message);
	
	if($mtype==1) {	
		$from=$webmasteremail;
    	$header = "From: $sitename<$from>\n";
if($format==1)	$header .="Content-type: text/plain; charset=utf-8\n";
else	$header .="Content-type: text/html; charset=utf-8\n";
		$header .= "Reply-To: <$from>\n";
		$header .= "X-Sender: <$from>\n";
		$header .= "X-Mailer: PHP4\n";
		$header .= "X-Priority: 3\n";
		$header .= "Return-Path: <$from>\n";
		mail($to,$subject,$message,$header);
	}elseif($mtype==2) {
		require_once 'swift/lib/swift_required.php';
		$sslt="";
		if($sslreq==1) $sslt="ssl";
		$transport = Swift_SmtpTransport::newInstance($mailserver, $mailport, $sslt)
		  ->setUsername($mailuser)
		  ->setPassword($mailpass);
		$mailer = Swift_Mailer::newInstance($transport);
		if($format==1)	$ftype="text/plain";
		else			$ftype="text/html";
		$message = Swift_Message::newInstance($subject)
		  ->setFrom(array($from => $sitename))
		  ->setReplyTo($from)
		  ->setReturnPath($from)
		  ->setTo(array($to))
		  ->setBody($message,$ftype);
		$result = $mailer->send($message);
	}
}

function authenticateemail($key,$email) {
	$email = urlencode($email);

	$url = "https://api.e-mailcourt.com/?key=$key&email=$email";
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	curl_close($ch);
	
	$json = json_decode($response, true);

	if (is_bool($json['Result']) === true) return TRUE;
	elseif($json['Result']=="failed") return $json['err'];
	else return "Unknown";
}
?>