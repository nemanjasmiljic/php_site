<?php
  session_start();

include "header.php";
include "config.php";
include "func.php";
if (!isset($_SESSION["username_session"])) {
include "loginform.php";
}
else {
middle();
} 

function middle()
{
include "config.php";
$rs=mysqli_query($dbconnect,"select * from users where Username='$_SESSION[username_session]'");
$arr=mysqli_fetch_array($rs);
$status=$arr[14];
$unpaid=$arr[16];
?>
         	<div class="row-fluid">
<?php
if(!$_POST) {
?>
                <div class="col-sm-12">
                    <p>Your Unpaid Balance: BTC <?php echo $unpaid; ?></p>
<?php if($unpaid>0) { ?>
                    <form class="form-horizontal" action="" method="post">
                        <div class="form-group">
                            <label class="col-sm-3">Request Withdrawal</label>
                            <div class="col-sm-9">
                                $<input type="text" name="amount" class="form-control" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">Payment Mode :</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="pmode">
<?php 
if(($bitcoin_apikey!='0')||($bitcoin_apikey!='')) {
   echo "<option value=bitcoin>Bitcoin</option>";
}
 if($extramerchants>0) 	echo "<option value=\"$merchantname1\">$merchantname1</option>";
 if($extramerchants>1) 	echo "<option value=\"$merchantname2\">$merchantname2</option>";
 if($extramerchants>2) 	echo "<option value=\"$merchantname3\">$merchantname3</option>";
 if($extramerchants>3) 	echo "<option value=\"$merchantname4\">$merchantname4</option>";
 if($extramerchants>4) 	echo "<option value=\"$merchantname5\">$merchantname5</option>";

?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">Payment ID</label>
                            <div class="col-sm-9">
                                <input type="text" name="pid" class="form-control" required />
                            </div>
                        </div>
						<div class="help-block">Enter your payment processor email address or account id.</div>
                        <center><button type="submit" class="btn btn-danger btn-lg">Withdraw Money</button></center>
                    </form>
<?php } ?>
</div>
				<div class="clearfix"></div>
                <div class="margin-vertical-20"></div>
				<h2>Withdrawal History</h2>
<?php
    $sql="Select * from wtransaction where Username='$_SESSION[username_session]' order by ID";
    $wrs=mysqli_query($dbconnect,$sql);
    if(mysqli_num_rows($wrs)>0) {
    $rc=0;
    ?>
	                <div class="row-fluid">
                	<div class="table-responsive">
                        <table class="table table-hover">
                        	<thead>
								<tr background="images/bg.jpg">
                                    <th>ID</th>
                                    <th>PaymentMode</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Status</th>
                          		</tr>
                          	</thead>
                            <tbody>
<?
    while($rs=mysqli_fetch_row($wrs))
    {
	$rc=$rc+1;
	if($rs[4]==1) {
		$status="Approved";
	}
	else {
		$status="Pending";
	}
      echo("<tr><td align=center><font face=verdana size=2>".$rc."</font></td><td style=\"word-break:break-all\"><font face=verdana size=2>". $rs[2]."</font></td><Td align=center><font face=verdana size=2>BTC ". $rs[3]."</font></td><Td align=center><font face=verdana size=2>". $rs[5]."</font></td><Td align=center><font face=verdana size=2>". $status."</font></td></tr>");
    }
    echo("</tbody></table></div></div>");
    }
    else {
	echo "<p><strong><center>No Records Found</center></strong></p>";
    }
}
else {
$amount=$_POST[amount];
$pmode=validatet($_POST[pmode]);
$pid=validatet($_POST[pid]);
$pmode1=$pmode.":".$pid;
if($amount<0) {
echo "<br><b>Invalid Amount</b><br>";
}
elseif(!is_numeric($amount)) {
echo "<br><b>Invalid Amount</b><br>";
}
elseif($amount>$unpaid) {
echo "<br><b>You cannot withdraw more money than your Unpaid Balance! </b><br>";
}
elseif($pid=="") {
echo "<br><b>Payment ID can't be blank</b><br>";
}
else {
echo "<br><b>Your Request for withdrawal of BTC ".$amount." through $pmode have been successfully recorded and it will be get processed within 2-3 days.</b><br>";
$sql_i="insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$_SESSION[username_session]','$pmode1','$amount',0,now())";
$rs=mysqli_query($dbconnect,$sql_i);
$rs=mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$amount where Username='$_SESSION[username_session]'");

$rs2=mysqli_query($dbconnect,"select * from users where Username='$_SESSION[username_session]'");
$rs=mysqli_fetch_array($rs2);
  $to = $rs[7];

$message1="Dear $rs[1]

You have requested a withdrawal of BTC $amount through $pmode1.
 
This email is for your information and security purpose only. 

$sitename";

$subject1="Re: Your Withdrawal Request at $sitename";
      $message=stripslashes($message1);
      $subject=stripslashes($subject1);

$from=$webmasteremail;
    	$header = "From: $sitename<$from>\n";
	$header .="Content-type: text/plain; charset=iso-8859-1\n";
	$header .= "Reply-To: <$from>\n";
	$header .= "X-Sender: <$from>\n";
	$header .= "X-Mailer: PHP4\n";
	$header .= "X-Priority: 3\n";
	$header .= "Return-Path: <$from>\n";

  //mail($to,$subject,$message,$header);
  send_mailer($to,$subject,$message,1,$mailertype,$from);

}
}

?>
</div>
<?php   return 1;
} include "footer.php";
?>