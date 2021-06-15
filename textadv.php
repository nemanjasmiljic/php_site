<?php
  session_start();

include "header.php";
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
	$id=$_SESSION["username_session"];
	$rs = mysqli_query($dbconnect,"select * from users where Username='$id'");
	$arr=mysqli_fetch_array($rs);
	$email=$arr[7];
$totban=$arr[20];
$banused=$arr[21];
$tottext=$arr[22];
$textused=$arr[23];
$id=(int)$_POST[id];
?>
         	<div class="row-fluid">
                
				<div class="col-lg-12">
<?php
$unused=$tottext-$textused;
if(!$_POST) echo "<p><b>Text Ads Credits Available $unused</b></p>";

  $sql = "Select * from memberstextads where Username='". $_SESSION["username_session"] ."'";
  $result1 = mysqli_query($dbconnect,$sql);
  $numm1 = mysqli_num_rows($result1);


if($_POST[b]=="Add") {
  $a[1]=trim($_POST[burl]);
  $a[1]=addslashes($a[1]);
  $a[2]=validatet($_POST[wurl]);
  $a[3]=trim($_POST[textad]);
$a[3]=addslashes($a[3]);
$credits=(int)$_POST[credits];
if($a[1]=="") {
echo "<b><br>Invalid Text</b><br>";
}
elseif(($a[2]=="")||($a[2]=="http://")) {
echo "<b><br>Invalid Website Url</b><br>";
}
elseif($credits>$unused) {
echo "<b><br>You don't have enough credits to add this Text Ad</b><br>";
}
elseif($credits<1) {
echo "<b><br>Invalid credits!</b><br>";
}
else {
$sql_i="insert into memberstextads(Username,Textad,WebsiteURL,assigned,remaining,hits,approved,Date,Textad1) values('$_SESSION[username_session]','$a[1]','$a[2]',$credits,$credits,0,0,now(),'$a[3]')";
$rsi=mysqli_query($dbconnect,$sql_i);
mysqli_query($dbconnect,"update users set textadsused=textadsused+$credits where Username='$_SESSION[username_session]'");
echo "<br><br><b>Your text ad has been submited, and is waiting for the admin approval.</b><br>";
}
}
elseif($_POST[b]=="Preview") {
$credits=(int)$_POST[credits];
if($_POST[burl]=="") {
echo "<b><br>Invalid Text Ad</b><br>";
}
elseif($_POST[burl1]=="") {
echo "<b><br>Line1 Text Ad can't be blank</b><br>";
}
elseif($_POST[burl2]=="") {
echo "<b><br>Line2 Text Ad can't be blank</b><br>";
}
elseif($_POST[burl3]=="") {
echo "<b><br>Line3 Text Ad can't be blank</b><br>";
}
elseif(($_POST[wurl]=="")||($_POST[wurl]=="http://")) {
echo "<b><br>Invalid Website Url</b><br>";
}
elseif($credits>$unused) {
echo "<b><br>You don't have enough credits to add this Text Ad</b><br>";
}
elseif($credits<1) {
echo "<b><br>Invalid credits!</b><br>";
}
else { 
  $a[2]=trim($_POST[wurl]);
$a[2]=str_ireplace("\"","",$a[2]);
$a[2]=str_ireplace("'","",$a[2]);

$textad=addslashes("$_POST[burl1]<br>$_POST[burl2]<br>$_POST[burl3]");
echo "<form action='' method=post><input type=hidden name=burl value=\"$_POST[burl]\"><input type=hidden name=textad value=\"$textad\"><input type=hidden name=wurl value=$a[2]><input type=hidden name=credits value=$credits>";
echo "<a href='$a[2]' target=_blank>".stripslashes($_POST[burl])."</a><br>".stripslashes($textad);
echo "<br>If this text ad is appearing correct, then press the Add button. If it is not appearing correct, then go back to the previous page, and change the text ad.<br><input type=submit name=b value=Add></form>";
}
}
elseif($_POST[b]=="Edit") {
if($_POST[edit1]=="") {
$rs=mysqli_query($dbconnect,"select * from memberstextads where ID=$id and Username='$_SESSION[username_session]'");
if(mysqli_num_rows($rs)>0) {
$arr=mysqli_fetch_array($rs);
$textad=split("<br>",$arr[9]);
$line1=$textad[0];
$line2=$textad[1];
$line3=$textad[2];
?>
                    <div class="row" style="font-weight:bold; line-height:35px; height:35px; text-align:center;background-color:#ff6600;color:#fff">
                        <div class="col-lg-12">Update Text Ad</div>
                    </div>
                    <div class="margin-vertical-10"></div>
                    <form class="form-horizontal" role="form" method="post" action="">
					<input type="hidden" name="id" value="<?php echo $id; ?>">
					<input type="hidden" name="edit1" value="edit">
                        <div class="form-group">
                            <label class="col-sm-3" for="subject">Subject</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="subj" name="burl" maxlength="20" placeholder="Enter subject" value="<?php echo $arr[2]; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3" for="Line1">Line 1 text Ad</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="Line1" name="burl1" maxlength="24" placeholder="Enter Line 1" value="<?php echo $line1; ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3" for="Line2">Line 2 text Ad</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="Line2" name="burl2" maxlength="24" placeholder="Enter Line 2" value="<?php echo $line2; ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3" for="Line3">Line 3 text Ad</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="Line3" name="burl3" maxlength="24" placeholder="Enter Line 3" value="<?php echo $line3; ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3" for="Line3">Website Url:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="web" name="wurl" value="<?php echo $arr[3]; ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3" for="Line3">Credits Available:</label>
                            <div class="col-sm-9">
                                <?php echo $arr[5]; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3" for="Line3">Add Credits:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="web" name="credits" /><br>
								( To subtract credits use '-' sign before credits)
                            </div>
                        </div>
                        <center><button type="submit" name="b" value="Edit" class="btn btn-danger btn-lg">Update</button></center>
                    </form><?
}
}
else {
$rs=mysqli_query($dbconnect,"select * from memberstextads where ID=$id and Username='$_SESSION[username_session]'");
if(mysqli_num_rows($rs)>0) {
$arr=mysqli_fetch_array($rs);
$credits=$arr[4];
$rem=$arr[5];
$credits1=(int)$_POST[credits];
$newcredits=$credits1;//-$rem;

if($_POST[burl]=="") {
echo "<b><br>Invalid Text Ad</b><br>";
}
elseif($_POST[burl1]=="") {
echo "<b><br>Line1 Text Ad can't be blank</b><br>";
}
elseif($_POST[burl2]=="") {
echo "<b><br>Line2 Text Ad can't be blank</b><br>";
}
elseif($_POST[burl3]=="") {
echo "<b><br>Line3 Text Ad can't be blank</b><br>";
}
elseif(($_POST[wurl]=="")||($_POST[wurl]=="http://")) {
echo "<b><br>Invalid Website Url</b><br>";
}
elseif($credits1>$unused) {
echo "<b><br>You don't have enough credits to add this Text Ad</b><br>";
}
elseif($credits1<-$rem) {
echo "<b><br>Invalid credits!</b><br>";
}
else {
  $a[1]=trim($_POST[burl]);
$a[1]=addslashes($a[1]);
  $a[2]=trim($_POST[wurl]);
$a[2]=str_ireplace("\"","",$a[2]);
$a[2]=str_ireplace("'","",$a[2]);

$textad="$_POST[burl1]<br>$_POST[burl2]<br>$_POST[burl3]";
$textad=addslashes($textad);
if(($a[1]!=$arr[2])||($a[2]!=$arr[3])||($textad!=$arr[9])) {
$sql_i="update memberstextads set Textad='$a[1]',Textad1='$textad',WebsiteURL='$a[2]',approved=0 where ID=$id and Username='$_SESSION[username_session]'";
$rsi=mysqli_query($dbconnect,$sql_i);
echo "<br><br><b>Your text ad has been added, and is waiting for the admin approval .</b><br>";
}
$sql_i="update memberstextads set assigned=assigned+$newcredits,remaining=remaining+$newcredits where ID=$id and Username='$_SESSION[username_session]'";
$rsi=mysqli_query($dbconnect,$sql_i);
mysqli_query($dbconnect,"update users set textadsused=textadsused+$credits1 where Username='$_SESSION[username_session]'");


echo "<br><br><b>Credits updated successfully.</b><br>";

}
}
}
}
elseif($_POST[b]=="Delete") {
$rs=mysqli_query($dbconnect,"select * from memberstextads where ID=$id and Username='$_SESSION[username_session]'");
if(mysqli_num_rows($rs)>0) {
$arr=mysqli_fetch_array($rs);
	$rem=$arr[5];
    mysqli_query($dbconnect,"update users set textadsused=textadsused-$rem where Username='$_SESSION[username_session]'");
}
$rs=mysqli_query($dbconnect,"delete from memberstextads where ID=$id and Username='$_SESSION[username_session]'");
echo "<br><br><b>Text ad Successfully Deleted</b><br><br>";
}



if(!$_POST) {
if($numm1<$maxads) { ?>
                    <div class="row" style="font-weight:bold; line-height:35px; height:35px; text-align:center;background-color:#ff6600;color:#fff">
                        <div class="col-lg-12">Add New Text Ad</div>
                    </div>
                    <div class="margin-vertical-10"></div>
                    <form class="form-horizontal" role="form" method="post" action="">
                        <div class="form-group">
                            <label class="col-sm-3" for="subject">Subject</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="subj" name="burl" maxlength="20" placeholder="Enter subject" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3" for="Line1">Line 1 text Ad</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="Line1" name="burl1" maxlength="24" placeholder="Enter Line 1" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3" for="Line2">Line 2 text Ad</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="Line2" name="burl2" maxlength="24" placeholder="Enter Line 2" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3" for="Line3">Line 3 text Ad</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="Line3" name="burl3" maxlength="24" placeholder="Enter Line 3" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3" for="Line3">Website Url:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="web" name="wurl" value="http://" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3" for="Line3">Assign Credits:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="web" name="credits" value="<?php echo $unused; ?>" />
                            </div>
                        </div>
                        <center><button type="submit" name="b" value="Preview" class="btn btn-danger btn-lg">Preview</button></center>
                    </form>
<?php
}



if($numm1>0) {
?>
<div class="margin-vertical-20"></div>
                    <div class="row" style="font-weight:bold; line-height:35px; height:35px; text-align:center;background-color:#ff6600;color:#fff">
                        <div class="col-lg-12">Below are the Text Ad(s) added by you:</div>
                    </div>
<?
$rsb=mysqli_query($dbconnect,"select * from memberstextads where Username='$_SESSION[username_session]'");

if(mysqli_num_rows($rsb)>0) {
while($arrb=mysqli_fetch_array($rsb)) {
?>
                    
                    <div class="row">
                        <div class="col-lg-6" style="line-height:30px"></div>
                        <div class="col-lg-6" style="line-height:30px"><a href="<?php echo $arrb[3]; ?>" target=_blank><?php echo stripslashes($arrb[2]); ?></a></div>
                    </div>
                    <div class="row" style="line-height:30px;background-color:#ccc">
                        <div class="col-lg-6">Ad</div>
                        <div class="col-lg-6">
						<div class="row"><div class="col-lg-12"><?php echo stripslashes($arrb[9]); ?></div></div>
                        </div>
                    </div>
                    <div class="row" style="line-height:30px">
                        <div class="col-lg-6">No. of credits:</div>
                        <div class="col-lg-6"><?php echo $arrb[4]; ?></div>
                    </div>
                    <div class="row" style="line-height:30px;background-color:#ccc">
                        <div class="col-lg-6">No. of credits used:</div>
                        <div class="col-lg-6"><?php echo ($arrb[4]-$arrb[5]); ?></div>
                    </div>
                    <div class="row" style="line-height:30px">
                        <div class="col-lg-6">No. of clicks:</div>
                        <div class="col-lg-6"><?php echo $arrb[6]; ?></div>
                    </div>
                    <div class="row" style="line-height:30px;background-color:#ccc">
                        <div class="col-lg-6"><?php if($arrb[7]==0) {
echo "Waiting for admin approval";
}
else {
echo "<form action='' method=post><input type=hidden name=id value=$arrb[0]><input type=submit name=b value=Edit> &nbsp; &nbsp; <input type=submit name=b value=Delete></form>";
}
?></div>
                        <div class="col-lg-6"></div>
                    </div><br>
<?
}

}
else {
echo "<br>No TextAds Stats Available<br>";
}
}

}


?>
                </div>
                
				<div class="clearfix"></div>
            </div>
<?php }
include "footer.php";
?>