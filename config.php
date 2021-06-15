<?php
$databaseConnection = dirname(__FILE__)."/dbconfig.php";

if (file_exists($databaseConnection)) {
	error_reporting(1);
	include "dbconfig.php";

	$ss=mysqli_query($dbconnect,"select * from adminsettings");
	$subm=mysqli_fetch_array($ss);

	$sitename=$subm[0];
	$siteurl=$subm[1];
	$webmasteremail=$subm[2];
	$adminuser=$subm[3] ;
	$adminpass=$subm[4] ;
	$topad=$subm[5];
	$bottomad=$subm[6];
	$paypal=$subm[7]; 
	if(($paypal=="")||($paypal==" ")) $paypal="0";
	$moneybookers=$subm[8];
	if(($moneybookers=="")||($moneybookers==" ")) $moneybookers="0";
	$alertpay=$subm[9];
	if(($alertpay=="")||($alertpay==" ")) $alertpay="0";
	$freemember=$subm[11];
	$startmatrix=$subm[12];
	$minwit=$subm[13];
	$multipurchaseallowed=$subm[14];
	$maxposperlevel=$subm[15];

	$showaddress=$subm[16];
	$showcity=$subm[17];
	$showstate=$subm[18];
	$showzip=$subm[19];
	$showcountry=$subm[20];

	$yfwid=$subm[21];
	$confirmreq=$subm[22];
	$refnotification=$subm[23];

	$subject1=$subm[24];
	$message1=$subm[25];

	$subject2=$subm[26];
	$message2=$subm[27];

	$subject3=$subm[28];
	$message3=$subm[29];

	$subject4=$subm[30];
	$message4=$subm[31];

	$subject5=$subm[32];
	$message5=$subm[33];

	$subject6=$subm[36];
	$message6=$subm[37];

	$subject7=$subm[38];
	$message7=$subm[39];

	$eformat1=$subm[40];
	$eformat2=$subm[41];
	$eformat3=$subm[42];
	$eformat4=$subm[43];
	$eformat5=$subm[44];
	$eformat6=$subm[45];
	$eformat7=$subm[46];

	$freebonus=$subm[34];
	$probonus=$subm[35];

	$extramerchants=$subm[47];

	$merchantname1=stripslashes($subm[48]);
	$merchantcode1=stripslashes($subm[49]);

	$merchantname2=stripslashes($subm[50]);
	$merchantcode2=stripslashes($subm[51]);

	$merchantname3=stripslashes($subm[52]);
	$merchantcode3=stripslashes($subm[53]);

	$merchantname4=stripslashes($subm[54]);
	$merchantcode4=stripslashes($subm[55]);

	$merchantname5=stripslashes($subm[56]);
	$merchantcode5=stripslashes($subm[57]);

	$subject8=$subm[58];
	$message8=$subm[59];
	$eformat8=$subm[60];

	$subject9=$subm[61];
	$message9=$subm[62];
	$eformat9=$subm[63];

	$ipncode=$subm[64];
	$pospurnextlevel=$subm[65];
	$nonmatrixmatch=$subm[66];
	$freerefbonus=$subm[67];

	$stpuser=$subm[68];
	if(($stpuser=="")||($stpuser==" ")) $stpuser="0";
	$stpbuttonname=$subm[69];
	$stppass=$subm[70];
	$merchantAccountNumber=$subm[71];
	$merchantSecurityWord=$subm[72];
	if(($merchantAccountNumber=="")||($merchantAccountNumber==" ")) $merchantAccountNumber="0";

	$bitcoin_apikey=$subm[73];
	$bitcoin_apisecret=$subm[74];
	if(($bitcoin_apikey=="")||($bitcoin_apikey==" ")) $bitcoin_apikey="0";
	$private_key=$subm[75];
	$public_key=$subm[76];
	$phonereq=$subm[77];
	$bitcoinreq=$subm[78];
	$allowlookupforsponsor=$subm[79];

	$mailertype=$subm[80];
	$mailserver=$subm[81];
	$mailport=$subm[82];
	$sslreq=$subm[83];
	$mailuser=$subm[84];
	$mailpass=$subm[85];
	$emailcourtapikey=$subm[86];
	$iapushapiid=$subm[87];
	$iapushkey=$subm[88];
	$sitemaintenance=$subm[89];
	if($sitemaintenance==1) {
		echo "<script>location.href='maintenance.php'</script>";
	}

	$rs=mysqli_query($dbconnect,"select * from badminsettings");
	if(mysqli_num_rows($rs)>0) {
	$arr=mysqli_fetch_array($rs);
	$maxban=$arr[0];
	$showban=$arr[1];
	}
	$rs=mysqli_query($dbconnect,"select * from tadminsettings");
	if(mysqli_num_rows($rs)>0) {
	$arr=mysqli_fetch_array($rs);
	$maxads=$arr[0];
	$nads=$arr[1];
	}
	if (file_exists("createtables.php"))	unlink("createtables.php");
}
else {
    echo "<script>window.location.href='setup.php';</script>";
}
?>