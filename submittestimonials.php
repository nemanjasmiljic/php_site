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
?>

         	<div class="row-fluid">
				<h3>Want to say something about our Service</h3>
                
<?php
if(!$_POST) { ?>
				<div class="col-lg-12">
                    <p class="text-center"><strong>Your Testimonial:</strong></p>
                    <form role="form" action="" method="post">
                        <div class="form-group">
                            <textarea type="text" name="data" class="form-control" rows="7" cols="40"></textarea>
                        </div>
                        <center><input type="submit" class="btn btn-lg btn-danger" value="Submit" /></center>
                    </form>
                </div>
                
				<div class="clearfix"></div>
<?php } else { 
$a[1]=$_SESSION[username_session];
$a[2]=addslashes($_POST["data"]);

if(($a[1]=="")||($a[2]=="")) {
echo "<br><b>Testimonial can't be blank</b>";
}
else {
	$rs=mysqli_query($dbconnect,"select ID from testimonials where Name='$a[1]'");
	if(mysqli_num_rows($rs)>2) echo "<br><b>You are not allowed to submit more than 3 testimonials.";
	else {
$sql_i="insert into testimonials values ('$a[0]','$a[1]','$a[2]',0,now())";
$rs=mysqli_query($dbconnect,$sql_i);
echo("<br><br><b><font face=verdana size=2>Thanks for taking the time to submit your valuable testimonials about our service. <br>&nbsp;<br>&nbsp;<br>&nbsp;<br></b></font>");
	}
}
}
?>
</div>
<?php
}
include "footer.php";
?>