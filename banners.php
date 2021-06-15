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
$unused=$totban-$banused;
if(!$_POST) {
echo "<p><strong>Banner Credits Available $unused</strong></p>";
if($unused>0) {  ?>
                    <div class="row" style="font-weight:bold; line-height:35px; height:35px; text-align:center;background-color:#ff6600;color:#fff">
                        <div class="col-lg-12">Add New Banner</div>
                    </div>
                    <div class="row" style="font-weight:bold; line-height:35px; height:35px; text-align:center;background-color:#ff6600;color:#fff">
                        <div class="col-lg-12">Banner Url is the location of the image of the banner.<br>
Make sure your banner shows correctly before approving it.</div>
                    </div>
                    <div class="margin-vertical-10"></div>
                    <form class="form-horizontal" role="form" method="post" action="">
                        <div class="form-group">
                            <label class="col-sm-3" for="subject">Banner Url</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="subject" name="burl" value="http://" placeholder="Enter subject" />
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
echo "<div align=left>";
$rsb=mysqli_query($dbconnect,"select * from membersbanners where Username='$_SESSION[username_session]' and approved<2");
?>
<div class="margin-vertical-20"></div>
                    <div class="row" style="font-weight:bold; line-height:35px; height:35px; text-align:center;background-color:#ff6600;color:#fff">
                        <div class="col-lg-12">Below are the Banner Ad(s) added by you:</div>
                    </div>
<?php
if(mysqli_num_rows($rsb)>0) {
while($arrb=mysqli_fetch_array($rsb)) {
?>
                    <div class="row">
                        <div class="col-lg-6" style="line-height:30px">Banner</div>
                        <div class="col-lg-6" style="line-height:30px"><a href="<?php echo $arrb[3]; ?>" target=_blank><?php echo "<img src=$arrb[2] width=468 height=60 border=0>"; ?></a></div>
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
<?php

}


}
else {
echo "<br>No Stats Available<br>";
}
 
 }
else {
if($_POST[b]=="Add") {
$burl=validatet($_POST[burl]);
$wurl=validatet($_POST[wurl]);
$burl=str_ireplace("<a href=","",$burl);
$burl=str_ireplace("</a>","",$burl);
$burl=str_ireplace("<img src=","",$burl);
$wurl=str_ireplace("<a href=","",$wurl);
$wurl=str_ireplace("</a>","",$wurl);
$wurl=str_ireplace("<img src=","",$wurl);
$credits=(int)$_POST[credits];
if(($burl=="")||($burl=="http://")) {
echo "<b><br>Invalid Banner Url</b><br>";
}
elseif(($wurl=="")||($wurl=="http://")) {
echo "<b><br>Invalid Website Url</b><br>";
}
elseif($credits>$unused) {
echo "<b><br>You don't have enough credits to add this banner</b><br>";
}
elseif($credits<1) {
echo "<b><br>Invalid credits!</b><br>";
}
else {
$sql_i="insert into membersbanners(Username,BannerURL,WebsiteURL,assigned,remaining,hits,approved,Date) values('$_SESSION[username_session]','$burl','$wurl',$credits,$credits,0,0,now())";
$rsi=mysqli_query($dbconnect,$sql_i);
mysqli_query($dbconnect,"update users set bannersused=bannersused+$credits where Username='$_SESSION[username_session]'");
echo "<br><br><b>Your banner has been added and is waiting for the admin approval.</b><br>";
}

}
elseif($_POST[b]=="Preview") {
$burl=validatet($_POST[burl]);
$wurl=validatet($_POST[wurl]);
$burl=str_ireplace("<a href=","",$burl);
$burl=str_ireplace("</a>","",$burl);
$burl=str_ireplace("<img src=","",$burl);
$wurl=str_ireplace("<a href=","",$wurl);
$wurl=str_ireplace("</a>","",$wurl);
$wurl=str_ireplace("<img src=","",$wurl);
$credits=(int)$_POST[credits];
echo "<br><b>Banner Credits Available $unused</b><br>";
if(($burl=="")||($burl=="http://")) {
echo "<b><br>Invalid Banner Url</b><br>";
}
elseif(($wurl=="")||($wurl=="http://")) {
echo "<b><br>Invalid Website Url</b><br>";
}
elseif($credits>$unused) {
echo "<b><br>You don't have enough credits to add this banner</b><br>";
}
elseif($credits<1) {
echo "<b><br>Invalid credits!</b><br>";
}
else { 
echo "<form action='' method=post><input type=hidden name=burl value=$burl><input type=hidden name=wurl value=$wurl><input type=hidden name=credits value=$credits>";
echo "<a href=$wurl><img src=$burl border=0 width=468 height=60></a>";
echo "<br>If this banner is appearing correctly, then press the Add button. If it is not appearing correctly, then go back to the previous page, and change the banner.<br><input type=submit name=b value=Add></form>";
}
}
elseif($_POST[b]=="Edit") {
if($_POST[edit1]=="") {
$rs=mysqli_query($dbconnect,"select * from membersbanners where ID=$id and Username='$_SESSION[username_session]'");
if(mysqli_num_rows($rs)>0) {
$arr=mysqli_fetch_array($rs);
?>
                    <div class="row" style="font-weight:bold; line-height:35px; height:35px; text-align:center;background-color:#ff6600;color:#fff">
                        <div class="col-lg-12">Update Banner Ad</div>
                    </div>
                    <div class="row" style="font-weight:bold; line-height:35px; height:35px; text-align:center;background-color:#ff6600;color:#fff">
                        <div class="col-lg-12">Banner Url is the location of the image of the banner.<br>
Make sure your banner shows correctly before approving it.</div>
                    </div>
                    <div class="margin-vertical-10"></div>
<?php
echo "<p><strong>Banner Credits Available $unused</strong></p>";
?>
                    <form class="form-horizontal" role="form" method="post" action="">
					<input type="hidden" name="id" value="<?php echo $id; ?>">
					<input type="hidden" name="edit1" value="edit">
                        <div class="form-group">
                            <label class="col-sm-3" for="subject">Banner Url</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="subj" name="burl" maxlength="20" placeholder="Banner Url" value="<?php echo $arr[2]; ?>"/>
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
$rs=mysqli_query($dbconnect,"select * from membersbanners where ID=$id and Username='$_SESSION[username_session]'");
if(mysqli_num_rows($rs)>0) {
$arr=mysqli_fetch_array($rs);
$credits=$arr[4];
$rem=$arr[5];
$credits1=$_POST[credits];
$newcredits=$credits1;//-$rem;
$burl=validatet($_POST[burl]);
$wurl=validatet($_POST[wurl]);
$burl=str_ireplace("<a href=","",$burl);
$burl=str_ireplace("</a>","",$burl);
$burl=str_ireplace("<img src=","",$burl);
$wurl=str_ireplace("<a href=","",$wurl);
$wurl=str_ireplace("</a>","",$wurl);
$wurl=str_ireplace("<img src=","",$wurl);

if(($burl=="")||($burl=="http://")) {
echo "<b><br>Invalid Banner Url</b><br>";
}
elseif(($wurl=="")||($wurl=="http://")) {
echo "<b><br>Invalid Website Url</b><br>";
}
elseif($credits1>$unused) {
echo "<b><br>You don't have enough credits to add this banner</b><br>";
}
elseif($credits1<-$rem) {
echo "<b><br>Invalid credits!</b><br>";
}
else {
if(($burl!=$arr[2])||($wurl!=$arr[3])) {
$sql_i="update membersbanners set BannerURL='$burl',WebsiteURL='$wurl',approved=0 where ID=$id and Username='$_SESSION[username_session]'";
$rsi=mysqli_query($dbconnect,$sql_i);
echo "<br><br><b>Your banner has been successfully updated, and is waiting for the admin approval.</b><br>";
}
$sql_i="update membersbanners set assigned=assigned+$newcredits,remaining=remaining+$newcredits where ID=$id and Username='$_SESSION[username_session]'";
$rsi=mysqli_query($dbconnect,$sql_i);
mysqli_query($dbconnect,"update users set bannersused=bannersused+$credits1 where Username='$_SESSION[username_session]'");


echo "<br><br><b>Credits updated successfully.</b><br>";
}


}
}
}
elseif($_POST[b]=="Delete") {
$rs=mysqli_query($dbconnect,"update membersbanners set approved=2 where ID=$id and Username='$_SESSION[username_session]'");
$rs=mysqli_query($dbconnect,"select * from membersbanners where ID=$id and Username='$_SESSION[username_session]'");
if(mysqli_num_rows($rs)>0) {
$arr=mysqli_fetch_array($rs);
	$rem=$arr[5];
    mysqli_query($dbconnect,"update users set bannersused=bannersused-$rem where Username='$_SESSION[username_session]'");
}

echo "<br><br><b>Banner Successfully Deleted</b><br><br>";
}
}
?>
                </div>
                
				<div class="clearfix"></div>
            </div>
		</div>
<?php }
include "footer.php";
?>