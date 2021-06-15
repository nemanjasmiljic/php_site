<?php
  session_start();

include "header.php";
include "config.php";
if (!isset($_SESSION["username_session"])) {
include "loginform.php";
}
else {
  middle();
}

function middle()
{
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


?>
         	<div class="row-fluid">
                <div class="col-sm-12">
                    <h3 align="center">
                        Account Details for <?php echo $name; ?>
                    </h3>
                    <div class="side-content">
                        <div class="col-xs-12">
                            
                            <div class="table-responsive">
                                <table class="table table-hover">
									<tbody>
                                        <tr> 
                                            <td align="left" valign="center"><strong>Total Amount Earned: </strong></td>
                                            <td valign="center"> BTC <?php echo $total; ?><br></td>
                                        </tr>
                                        <tr> 
                                            <td align="left" valign="center"><strong>Total Unpaid Balance: </strong></td>
                                            <td valign="center"> BTC <?php echo $unpaid; ?><br></td>
                                        </tr>
                                        <tr> 
                                            <td align="left" valign="center"><strong>Total Paid Amount: </strong></td>
                                            <td valign="center"> BTC <?php echo $paid; ?><br></td>
                                        </tr>
                                        <tr> 
                                            <td align="left" valign="center"><strong>Referral Bonus Earned: </strong></td>
                                            <td valign="center"> BTC <?php $rs1=mysqli_query($dbconnect,"select sum(Amount) from tlogs where Username='$username' and purpose='Referral Bonus'");
												$arr1=mysqli_fetch_array($rs1);
												$rb=$arr1[0];
												echo number_format($arr1[0],6); ?><br></td>
                                        </tr>
                                        <tr> 
                                            <td align="left" valign="center"><strong>Matching Bonus Earned: </strong></td>
                                            <td valign="center"> BTC <?php $rs1=mysqli_query($dbconnect,"select sum(Amount) from tlogs where Username='$username' and purpose='100% Matching Bonus'");
												$arr1=mysqli_fetch_array($rs1);
												$mb=$arr1[0];
 												echo number_format($arr1[0],6); ?><br></td>
                                        </tr>
                                        <tr> 
                                            <td align="left" valign="center"><strong>Matrix Bonus Earned: </strong></td>
                                            <td valign="center"> BTC <?php 
 												$matrix=$total-$mb-$rb;
  												echo number_format($matrix,6); ?><br></td>
                                        </tr>
                                        <tr> 
                                            <td align="left" valign="center"><strong>Total Positions: </strong></td>
                                            <td valign="center"> <?php 
  												$totalpos=0;
  												$rsm=mysqli_query($dbconnect,"select ID from membershiplevels order by ID");
  												while($arrm=mysqli_fetch_array($rsm)) {
  												$rsm1=mysqli_query($dbconnect,"select ID from matrix$arrm[0] where Username='$username'");
  												$totalpos=$totalpos+mysqli_num_rows($rsm1);
  												}
   												echo $totalpos;?><br></td>
                                        </tr>
                                        <tr> 
                                            <td align="left" valign="center"><strong>Sponsor: </strong></td>
                                            <td valign="center"> <?php 
  												$rs1=mysqli_query($dbconnect,"select * from users where active=1 and Username='$ref'");
  												if(mysqli_num_rows($rs1)>0) {
  												$arr1=mysqli_fetch_array($rs1);
  												echo "<a href=mailto:$arr1[7]>$arr1[1] (Username: $arr1[8])</a>";
  												}
  												else echo "No Sponsor";
   												?><br></td>
                                        </tr>
                                        <tr> 
                                            <td align="left" valign="center"><strong>Direct Referrals: </strong></td>
                                            <td valign="center"> <?php 
  												$rs1=mysqli_query($dbconnect,"select Username from users where active=1 and ref_by='$username'");
   												echo mysqli_num_rows($rs1);
  												if(mysqli_num_rows($rs1)>0) {
  												echo " ( <a href=viewdownlines.php>View Downlines</a>)";
  												} ?><br></td>
                                        </tr>
                        			</tbody>
                                </table>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="margin-vertical-20"></div>
                <div class="clearfix"></div>
            </div>
<?php }
include "footer.php";
?>