<?php
include "func.php";
include "config.php";
include "coinpayments.inc.php";
	$cps = new CoinPaymentsAPI();
	$cps->Setup($private_key, $public_key);
	$status=(int)($_POST[status]);
$mailbody="";
foreach($_POST as $k=>$v)
$mailbody .=$k." = ".$v."\n<br>";
$to = "rohit0707@gmail.com";
$subject = "$sitename BitCoin  payment test";
//@mail($to, $subject, $mailbody);	
if($_POST['ipn_mode'] == 'hmac'){
	$cp_merchant_id = $bitcoin_apikey; 
	$cp_ipn_secret = $bitcoin_apisecret; 
	$cp_debug_email = 'rohit0707@gmail.com'; 
	$order_currency = 'BTC'; 
    //process IPN here

	function errorAndDie($error_msg) { 
		global $cp_debug_email; 
		if (!empty($cp_debug_email)) { 
			$report = 'Error: '.$error_msg."\n\n"; 
			$report .= "POST Data\n\n"; 
			foreach ($_POST as $k => $v) { 
				$report .= "|$k| = |$v|\n"; 
			} 
			//mail($cp_debug_email, 'CoinPayments IPN Error', $report); 
		} 
		die('IPN Error: '.$error_msg); 
	} 

	if (!isset($_POST['ipn_mode']) || $_POST['ipn_mode'] != 'hmac') { 
		errorAndDie('IPN Mode is not HMAC'); 
	} 

	if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) { 
		errorAndDie('No HMAC signature sent.'); 
	} 

	$request = file_get_contents('php://input'); 
	if ($request === FALSE || empty($request)) { 
		errorAndDie('Error reading POST data'); 
	} 

	if (!isset($_POST['merchant']) || $_POST['merchant'] != trim($cp_merchant_id)) { 
		errorAndDie('No or incorrect Merchant ID passed'); 
	} 

	$hmac = hash_hmac("sha512", $request, trim($cp_ipn_secret)); 
	if ($hmac != $_SERVER['HTTP_HMAC']) { 
		errorAndDie('HMAC signature does not match'); 
	} 

	// HMAC Signature verified at this point, load some variables. 

	$txn_id = $_POST['txn_id']; 
	$item_name = $_POST['item_name']; 
	$item_number = $_POST['item_number']; 
	$amount1 = floatval($_POST['amount1']); 
	$amount2 = floatval($_POST['amount2']); 
	$currency1 = $_POST['currency1']; 
	$currency2 = $_POST['currency2']; 
	$status = intval($_POST['status']); 
	$status_text = $_POST['status_text']; 
		$trKey=$_POST[invoice];

	//depending on the API of your system, you may want to check and see if the transaction ID $txn_id has already been handled before at this point 

	// Check the original currency to make sure the buyer didn't change it. 
	if ($currency1 != $order_currency) { 
		errorAndDie('Original currency mismatch!'); 
	}     

	if ($status >= 100) { 
		// payment is complete or queued for nightly payout, success 
		//process IPN here
	$amount = floatval($_POST['amount1']); 
	$id=(int)$_POST[custom];
$rs1=mysqli_query($dbconnect,"select * from transaction where ID=".$id);
if(mysqli_num_rows($rs1)>0) {
$arr1=mysqli_fetch_array($rs1);
	$mid=$arr1[3];
	$pmode=$arr1[2];

	$computeTrKey = md5(md5($arr1[0]).md5($arr1[1]).md5($sitename).md5($amount1*773477).md5($arr1[4]));
	if($trKey == $computeTrKey) {

$rs=mysqli_query($dbconnect,"select Username,ref_by from users where Username='$arr1[1]'");
$arr=mysqli_fetch_array($rs);
$user=$arr[0];
$ref_by=$arr[1];

$tablee="matrix$mid";
$rsm=mysqli_query($dbconnect,"select * from membershiplevels where ID=$mid");
$arrm=mysqli_fetch_array($rsm);
$mname=$arrm[1];
$fee=$arrm[2];
$amount=round($amount,5);
$fee=round($fee,5);
$matrixtype=$arrm[3];
$levels=$arrm[4];
$forcedmatrix=$arrm[5];
$refbonus=$arrm[84];
$refbonuspaid=$arrm[83];
$payouttype=$arrm[6];
$matrixbonus=$arrm[7];
$matchingbonus=$arrm[8];
$level1=$arrm[9];
$level2=$arrm[10];
$level3=$arrm[11];
$level4=$arrm[12];
$level5=$arrm[13];
$level6=$arrm[14];
$level7=$arrm[15];
$level8=$arrm[16];
$level9=$arrm[17];
$level10=$arrm[18];
$level1m=$arrm[19];
$level2m=$arrm[20];
$level3m=$arrm[21];
$level4m=$arrm[22];
$level5m=$arrm[23];
$level6m=$arrm[24];
$level7m=$arrm[25];
$level8m=$arrm[26];
$level9m=$arrm[27];
$level10m=$arrm[28];
$level1c=$arrm[29];
$level2c=$arrm[30];
$level3c=$arrm[31];
$level4c=$arrm[32];
$level5c=$arrm[33];
$level6c=$arrm[34];
$level7c=$arrm[35];
$level8c=$arrm[36];
$level9c=$arrm[37];
$level10c=$arrm[38];
$level1cm=$arrm[39];
$level2cm=$arrm[40];
$level3cm=$arrm[41];
$level4cm=$arrm[42];
$level5cm=$arrm[43];
$level6cm=$arrm[44];
$level7cm=$arrm[45];
$level8cm=$arrm[46];
$level9cm=$arrm[47];
$level10cm=$arrm[48];

$textcreditsentry=$arrm[49];
$bannercreditsentry=$arrm[50];
$textcreditscycle=$arrm[51];
$bannercreditscycle=$arrm[52];

$reentry=$arrm[53];
$reentrynum=$arrm[54];
$entry1=$arrm[55];
$entry1num=$arrm[56];
$matrixid1=$arrm[57];
$entry2=$arrm[58];
$entry2num=$arrm[59];
$matrixid2=$arrm[60];
$entry3=$arrm[61];
$entry3num=$arrm[62];
$matrixid3=$arrm[63];
$entry4=$arrm[64];
$entry4num=$arrm[65];
$matrixid4=$arrm[66];
$entry5=$arrm[67];
$entry5num=$arrm[68];
$matrixid5=$arrm[69];
$welcomemail=$arrm[70];
$subject1=stripslashes($arrm[71]);
$message1=stripslashes($arrm[72]);
$eformat1=$arrm[73];
$cyclemail=$arrm[74];
$subject2=stripslashes($arrm[75]);
$message2=stripslashes($arrm[76]);
$eformat2=$arrm[77];
$cyclemailsponsor=$arrm[78];
$subject3=stripslashes($arrm[79]);
$message3=stripslashes($arrm[80]);
$eformat3=$arrm[81];

$f1=$forcedmatrix;
$f2=$forcedmatrix*$forcedmatrix;
$f3=$forcedmatrix*$forcedmatrix*$forcedmatrix;
$f4=$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix;
$f5=$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix;
$f6=$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix;
$f7=$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix;
$f8=$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix;
$f9=$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix;
$f10=$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix;

if($levels==1) $fquery="Level1<$forcedmatrix"; 
elseif($levels==2) $fquery="Level2<$f2";
elseif($levels==3) $fquery="Level3<$f3";
elseif($levels==4) $fquery="Level4<$f4";
elseif($levels==5) $fquery="Level5<$f5";
elseif($levels==6) $fquery="Level6<$f6";
elseif($levels==7) $fquery="Level7<$f7";
elseif($levels==8) $fquery="Level8<$f8";
elseif($levels==9) $fquery="Level9<$f9";
elseif($levels==10) $fquery="Level10<$f10";


$fee1=$fee-0.00001;
if($amount>$fee1) {

mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr1[1]',$mid,now())");

    $sqld = "delete from transaction where ID=".$id;
    $resultd = mysqli_query($dbconnect,$sqld);

}
}
} 
	}
}
?>