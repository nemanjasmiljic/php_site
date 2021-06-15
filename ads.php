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
                <p><strong>Text Link:</strong></p>
                <p><a href="<?php echo $siteurl; ?>/?r=<?php echo $_SESSION["username_session"]; ?>" target=_blank><?php echo $siteurl; ?>/?r=<?php echo $_SESSION["username_session"]; ?></a></p>
<?php $rs=mysqli_query($dbconnect,"select * from banners order by ID");
if(mysqli_num_rows($rs)>0) { ?>
               <p><strong>Banner Links</strong></p>
<?php while($arr=mysqli_fetch_array($rs)) { ?>
<div class="col-lg-12">
                    <p><a href="<?php echo $siteurl;?>/?r=<?php echo $_SESSION["username_session"];?>"><img src="<?php echo $arr[1];?>" border="0"></a></p>
					<p>
                        <textarea class="form-control"><a href="<?php echo $siteurl;?>/?r=<?php echo $_SESSION["username_session"];?>"><img src="<?php echo $arr[1]?>" border="0"></a></textarea>
                    </p>
                </div>
<?php } } ?>

<?php $rs=mysqli_query($dbconnect,"select * from soloads order by ID");
if(mysqli_num_rows($rs)>0) { 
if(mysqli_num_rows($rs)==1) $cont="is a <b>solo ad</b>"; else $cont="are <b>solo ads</b>"
?>
<p>Following <?php echo $cont; ?> copy template that you can copy and paste into your web site and/or send out to safelists or your mailing lists to promote <?php echo $sitename; ?>.
Personal recommendations always work well in marketing.You can even write a personal testimonial after you have used our services to gain a better response from your promotions. 
</p>

<?php $i=0;
$refurl="$siteurl/?r=$_SESSION[username_session]";
$url="<a href='$refurl' target=_blank>$refurl</a>";
 while($arr=mysqli_fetch_array($rs)) { 
$i++; ?>
                <p><strong>Solo Ad #<?php echo $i; ?></strong></p>
                <p>Subject: <?php echo stripslashes($arr[1]); ?></p>
<?php 
$arr[2]=str_ireplace("\n","<br>",$arr[2]);
$arr[2]=str_ireplace("{refurl}",$refurl,$arr[2]);
$arr[2]=str_ireplace("{name}",$name,$arr[2]);
$arr[2]=str_ireplace("{username}",$username,$arr[2]);
echo stripslashes($arr[2]);
echo "<br><br>";
}
 } 
?>
				<div class="clearfix"></div>
            </div>
<?php   return 1;
} include "footer.php";
?>