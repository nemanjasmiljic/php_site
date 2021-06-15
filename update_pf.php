<?php
  session_start();

  include "header.php";
  include "config.php";
  include "func.php";

if (!isset($_SESSION["username_session"])) {
include "loginform.php";
}
else {

  if (!$_POST) 
  {
	middle();
  }

    elseif ($_POST["fname"]!="" && $_POST["pwd"]!="")

  {
 	if($_SESSION[password_session]==$_POST["pwd"])
	{

    print "<center><b>Your Account has been updated successfully<br></b></center>";
	$db_field[1]=validatet($_POST["fname"]);
        $db_field[2]=validatet($_POST["add"]);
        $db_field[3]=validatet($_POST["city"]);
        $db_field[4]=validatet($_POST["state"]);
        $db_field[5]=validatet($_POST["pzcode"]);
        $db_field[6]=validatet($_POST["country"]);
        $db_field[7]=validatet($_POST["phone"]);
if($_POST[subscribe]==1) {
mysqli_query($dbconnect,"update users set subscribed=1 where Username='$_SESSION[username_session]'");
}
		mysqli_query($dbconnect,"update users set Name='$db_field[1]' where Username='$_SESSION[username_session]'");
		mysqli_query($dbconnect,"update users set Address='$db_field[2]' where Username='$_SESSION[username_session]'");
		mysqli_query($dbconnect,"update users set City='$db_field[3]' where Username='$_SESSION[username_session]'");
		mysqli_query($dbconnect,"update users set State='$db_field[4]' where Username='$_SESSION[username_session]'");
		mysqli_query($dbconnect,"update users set Zip='$db_field[5]' where Username='$_SESSION[username_session]'");
		mysqli_query($dbconnect,"update users set Country='$db_field[6]' where Username='$_SESSION[username_session]'");
		mysqli_query($dbconnect,"update users set Phone='$db_field[7]' where Username='$_SESSION[username_session]'");
        $db_field[10]=validatet($_POST["npwd"]);
        $db_field[11]=validatet($_POST["cpwd"]);
        if($db_field[10]!="") {
         if($db_field[10]==$db_field[11]) {
		$query="update users set Password='$db_field[10]' where Username='$_SESSION[username_session]'";
		$rs = mysqli_query($dbconnect,$query);
$_SESSION["password_session"]=$db_field[10];
         }
        else print "<center><b>Password can't be updated because New Password and Confirm password doesn't match!<br></b></center>";
        }
		$username=$_SESSION["username_session"];
 		$rs = mysqli_query($dbconnect,"select * from users where Username='$username'");
		$arr=mysqli_fetch_array($rs);
		$BitcoinWallet=$arr['BitcoinWallet'];
		if($BitcoinWallet=="") {
			$bitcoin=validatet(str_ireplace(" ","",$_POST['bitcoin']));
			if($_POST['bitcoin'] != '') {
				if(!preg_match ("/^([[:alnum:]]+)$/", $bitcoin))  print 'Incorrect Bitcoin Wallet Address.';
				elseif((strlen($bitcoin)<32)||(strlen($bitcoin)>34)) print "Incorrect Bitcoin wallet, please open up a fresh wallet at <a href=https://www.blockchain.info target=_blank>BlockChain</a>";
				else {
					$db_field[12]=$bitcoin;
					mysqli_query($dbconnect,"update users set BitcoinWallet='$db_field[12]' where Username='$_SESSION[username_session]'");
				}
			}
		}
        }
	else
	{
	    print "<center><b>Invalid Password! Account cannot be updated!<br></b></center>";
	}

    middle();
  } 
  else {
    middle();
  }

}


function middle()
  {
include "config.php";
		$username=$_SESSION["username_session"];
		$rs = mysqli_query($dbconnect,"select * from users where Username='$username'");
		$arr=mysqli_fetch_array($rs);
			$name=$arr['Name'];
			$address=$arr['Address'];
			$city=$arr['City'];
			$state=$arr['State'];
			$zip=$arr['Zip'];
			$country=$arr['Country'];
			$password=$arr['Password'];
			$email=$arr['Email'];
			$phone=$arr['Phone'];
			$BitcoinWallet=$arr['BitcoinWallet'];
$status=$arr[14];
$subs=$arr[19];
?>
            
         	<div class="row-fluid">
                <div class="side-content">
                	<div class="col-xs-12">
                    	<form class="form-horizontal" role="form" action="" method="post">

                            <div class="form-group">
                                <label class="control-label col-sm-3" for="first-name">Full Name:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="first-name" name="fname" value="<?php echo $name; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="email">Email:</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="Email" disabled value="<?php echo $email; ?>">
                                </div>
                            </div>
<?php if($BitcoinWallet=="") { ?>
							<div class="form-group">
								<label class="control-label col-sm-3" for="bitcoin">Bitcoin Wallet Address:</label>
								<div class="col-sm-9">
									<input type="bitcoin" class="form-control" id="bitcoin" placeholder="Enter Bitcoin Wallet Address" name="bitcoin" value="<?php echo validatet($_POST[bitcoin]); ?>"><?php if(isset($bitcoinError)) echo '<br><font face=verdana size=2>'.$bitcoinError.'</font>'; ?>
								</div>
							</div>
<?php } else { ?>
							<div class="form-group">
								<label class="control-label col-sm-3" for="bitcoin">Bitcoin Wallet Address:</label>
								<div class="col-sm-9">
									<input type="bitcoin" class="form-control" id="bitcoin" disabled value="<?php echo $BitcoinWallet; ?>">
								</div>
							</div>
<?php } ?>
<?php if($showaddress==1) { ?>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="email">Address:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="uname" name="add" value="<?php echo $address; ?>">
                                </div>
                            </div>
<?php } ?>
<?php if($showcity==1) { ?>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="city">City:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="city" name="city" value="<?php echo $city; ?>">
                                </div>
                            </div>
<?php } ?>
<?php if($showstate==1) { ?>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="State/Region">State/Region:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="State/Region" name="state" value="<?php echo $state; ?>">
                                </div>
                            </div>
<?php } ?>
<?php if($showcountry==1) { ?>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="email">Country :</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="uname" name="country" value="<?php echo $country; ?>">
                                </div>
                            </div>
<?php } ?>
<?php if($showzip==1) { ?>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="postal-code">Postal Code:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="postal-code" name="pzcode" value="<?php echo $zip; ?>">
                                </div>
                            </div>
<?php } ?>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="email">Phone :</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="uname" name="phone" value="<?php echo $phone; ?>">
                                </div>
                            </div>
<?php if($subs==0) { ?>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="postal-code">Resubscribe to Admin Mailing:</label>
                                <div class="col-sm-9">
                                    <input type="checkbox" class="form-control" name="subscribe" value="1">
                                </div>
                            </div>
<?php } ?>
                            <div class="help-block"><strong>Fill in new password and confirm password if you want to update your password.</strong></div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="pwd">New Password:</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="pwd" name="npwd" placeholder="Enter password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="pwd">Confirm Password:</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="pwd" name="cpwd" placeholder="Confirm password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="pwd">Password:</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Enter password">
                                </div>
                            </div>
                            <div class="help-block">You need to enter your password to update your information.</div>
                            <div class="form-group">        
                                <div class="col-lg-12" align="center">
                                    <button type="submit" class="btn btn-danger btn-lg">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                </div>
				</div>
<?php     return 1;
  }
include "footer.php";
?>