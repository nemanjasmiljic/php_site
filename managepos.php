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
	$username=$_SESSION["username_session"];
	$rs = mysqli_query($dbconnect,"select * from users where Username='$id'");
	$arr=mysqli_fetch_array($rs);
	$status=$arr[14];
?>
         	<div class="row-fluid">
<?php
$totalpos=0;
$rsm=mysqli_query($dbconnect,"select ID,Name,fee,levels from membershiplevels order by ID");
while($arrm=mysqli_fetch_array($rsm)) {
$levels=$arrm[3];
$rsm1=mysqli_query($dbconnect,"select * from matrix$arrm[0] where Username='$username' order by ID");
$totalpos=$totalpos+mysqli_num_rows($rsm1);

if(mysqli_num_rows($rsm1)>0) {
$rc=0;
    echo("<br><strong>$arrm[1]:</strong><br><br>
	<div class=\"table-responsive\">
		<table class=\"table table-hover\">
		<tbody><tr><td align=center><font face=verdana size=2><b>#</b></font></td><td align=center><font face=verdana size=2><b>Matrix ID</b></font></td>");

for($i=1;$i<=$levels;$i++)
echo "<td align=center><font face=verdana size=2><b>Level$i</b></font></td>";

echo("<td align=center><font face=verdana size=2><b>Total Earned</b></font></td><td align=center><font face=verdana size=2><b>Purchased Date</b></font></td><td align=center><font face=verdana size=2><b>Completed</b></font></td></tr>");
    while($rs=mysqli_fetch_row($rsm1))
    {
$rc++;
if($rs[16]==$rs[18]) $cycled="No";
else $cycled="Yes ( $rs[18] )";
      echo("<tr><td align=center><font face=verdana size=2>".$rc."</font></td><td align=center><font face=verdana size=2>". $rs[0]."</font></td>");

for($i=1;$i<=$levels;$i++) {
if($rs[3+$i]>0) 
echo "<td align=center><font face=verdana size=2><a href=moreinfo.php?m=$arrm[0]&l=$i&id=$rs[0]>".$rs[3+$i]."</a></font></td>";
else 
echo "<td align=center><font face=verdana size=2>".$rs[3+$i]."</font></td>";
}

echo("<td align=center><font face=verdana size=2>BTC ". $rs[15]."</font></td><td align=center><font face=verdana size=2>". $rs[16]."</font></td><td align=center><font face=verdana size=2>".$cycled."</font></td></tr>");
    }
    echo("</tbody></table></div>");
 }

}
if($totalpos==0) {
	echo "<p><strong>No Matrix Position Details Found</strong></p>";
}
?>
       </div>
<?php   return 1;
} include "footer.php";
?>