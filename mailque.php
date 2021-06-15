<?
include "config.php";
include "func.php";
$rs1=mysqli_query($dbconnect,"select * from mailqueusers where st<en order by ID limit 0,1");
if(mysqli_num_rows($rs1)>0) {
$arr=mysqli_fetch_array($rs1);
$id=$arr[0];
$st=$arr[1];
$en=$arr[2];
$subject=$arr[3];
$message=$arr[4];
$format=$arr[5];
$memtype=$arr[7];
$usercount=0;
$st1=$st-1;
$en1=$en+1;
for($i=1;$i<=500;$i++) {
if($memtype==3) $result=mysqli_query($dbconnect,"select ID,Name,Email,Username,Password,ref_by,IP,Date from users where subscribed=1 and active=1 and status=2 and ID>$st1 and ID<$en1 order by ID limit 0,1");
elseif($memtype==2) $result=mysqli_query($dbconnect,"select ID,Name,Email,Username,Password,ref_by,IP,Date from users where subscribed=1 and active=1 and status=1 and ID>$st1 and ID<$en1 order by ID limit 0,1");
elseif($memtype==1) $result=mysqli_query($dbconnect,"select ID,Name,Email,Username,Password,ref_by,IP,Date from users where subscribed=1 and active=1 and ID>$st1 and ID<$en1 order by ID limit 0,1");
if(mysqli_num_rows($result)>0) {

$rs=mysqli_fetch_row($result);
$st1=$rs[0];
$d=explode(" ",$rs[1]);

	$body=str_ireplace("{email}",$rs[2],$message);
	$body=str_ireplace("{name}",$rs[1],$body);
	$body=str_ireplace("{username}",$rs[3],$body);
	$body=str_ireplace("{password}",$rs[4],$body);
	  $body=str_ireplace("{fname}",$d[0],$body);
	  $body=str_ireplace("{sponsor}",$rs[5],$body);
	  $body=str_ireplace("{ip}",$rs[6],$body);
	  $body=str_ireplace("{date}",$rs[7],$body);

	$subject1=str_ireplace("{email}",$rs[2],$subject);
	$subject1=str_ireplace("{name}",$rs[1],$subject1);
	$subject1=str_ireplace("{username}",$rs[3],$subject1);
	$subject1=str_ireplace("{password)",$rs[4],$subject1);
	  $subject1=str_ireplace("{fname}",$d[0],$subject1);
	  $subject1=str_ireplace("{sponsor}",$rs[5],$subject1);
	  $subject1=str_ireplace("{ip}",$rs[6],$subject1);
	  $subject1=str_ireplace("{date}",$rs[7],$subject1);

$from=$webmasteremail;
	$message1=$body;
	
if($format==2)
$message1.="<hr>You are receiving this message because you are a member of $sitename.<br>If you would like to no longer wish receive any updates please click on this link: <a href=$siteurl/remove.php?id=$rs[0]&email=$rs[2]>$siteurl/remove.php?id=$rs[0]&email=$rs[2]</a><hr>";
else
$message1.="\n*********************************************************\n
You are receiving this message because you are a member of $sitename.\n
If you would like to no longer wish receive any updates please click on this link: $siteurl/remove.php?id=$rs[0]&email=$rs[2]\n
*********************************************************";

      //mail($rs[2],stripslashes($subject1),stripslashes($message1),$header);
	  send_mailer($rs[2],stripslashes($subject1),stripslashes($message1),$format,$mailertype,$from);

        $usercount=$usercount+1;
        echo($usercount .". Message Successfully Send to:".$rs[2]."<br>");
} else $rsup=mysqli_query($dbconnect,"update mailqueusers set st=".($st1+2)." where ID=".$arr[0]);
 
      } // end of for loop
	  
$rsup=mysqli_query($dbconnect,"update mailqueusers set st=".($st1+1)." where ID=".$arr[0]);
}
?>