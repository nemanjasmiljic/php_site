<?php
include "config.php";
$rs=mysqli_query($dbconnect,"select ID,Textad,Textad1 from memberstextads where remaining>0 and approved=1 order by rand() limit 0,$nads");
$wd=(int)(100/$nads);
$i=0;
$dtext="<center><table border=1 cellpadding=4 cellspacing=0 style=border-collapse:collapse width=97% bordercolor=#4B410E><tr>";
while($arr=mysqli_fetch_array($rs)) {

$rsu=mysqli_query($dbconnect,"update memberstextads set remaining=remaining-1 where ID=$arr[0]");

$dtext=$dtext."<td width=$wd% bgcolor=#F9F9F9><p align=center><b><font size=2 face=verdana color=#FF0000>".stripslashes($arr[1])."</font><br></b><font size=1 face=verdana color=#000000>".stripslashes($arr[2])."</font><br><a href=$siteurl/tr1.php?id=$arr[0] target=_blank><font size=1 face=verdana color=#000000>Click Here Now</font></a></td>";
$i++;
}
if($i<$nads) {
for($j=$i;$j<$nads;$j++) {
$dtext=$dtext."<td width=$wd% bgcolor=#F9F9F9><p align=center><b><font size=2 face=verdana color=#FF0000>Advertise Here</font><br></b><font size=1 face=verdana color=#000000>Advertise Here</font><br><a href='$durl' target='_blank'><font size=1 face=verdana color=#000000>Click Here Now</font></a></td>";
}
}

$dtext=$dtext."</tr><tr><td width=96% bgcolor=#F9F9F9 colspan=$nads align=right><a href='$siteurl' target='_blank'><font size=1 face=verdana color=#000000>Ads by $sitename</font></a></td></tr></table></center>";
//$dtext=$dtext."</tr></table></center>";

echo $dtext;
?>