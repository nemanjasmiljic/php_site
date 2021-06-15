<?php
	$dbhost='localhost';
	$dbname='rise2pro_bmatrix';
	$dbuser='rise2pro_bmatrix';
	$dbpass='B34;sl2+1ww8';
	$dbconnect=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
	if (mysqli_connect_errno())
	{
		echo 'Failed to connect to MySQL: ' . mysqli_connect_error();
		echo "<script>window.location.href='setup.php';</script>";
	}
?>