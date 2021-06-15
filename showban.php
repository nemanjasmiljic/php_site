<?php
include "config.php";
$dtext="";
$rs=mysqli_query($dbconnect,"select ID,BannerURL from membersbanners where remaining>0 and approved=1 order by rand() limit 0,$showban");
while($arr=mysqli_fetch_array($rs)) {
$dtext.="<br><center><a href=$siteurl/trr.php?id=$arr[0] target=_blank><img src=$arr[1] width=468 height=60 border=0></a><br></center><br>";
$rsu=mysqli_query($dbconnect,"update membersbanners set remaining=remaining-1 where ID=$arr[0]");
}
mysqli_close($dbconnect);
echo "document.write('$dtext');"; 
?>