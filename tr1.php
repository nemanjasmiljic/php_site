<?php
  // CONNECTING TO DATABASE
 include "./config.php";

$id =(int)$_GET[id];
      $sql = "select WebsiteURL from memberstextads where id=". $id;
      $result = mysqli_query($dbconnect,$sql);
if(mysqli_num_rows($result)>0) {
      $arr = mysqli_fetch_array($result);
$rs=mysqli_query($dbconnect,"update memberstextads set hits=hits+1 where id=$id");
mysqli_close($dbconnect);
	header("Location:".$arr[0]);
}
else {
echo "<br><b>Invalid Url</b><br>";
}
mysqli_close($dbconnect);
?>