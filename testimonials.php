<?php
session_start();
include "header.php";
include "config.php";
?>
         	<div class="margin-vertical-40"></div>  
         	<div class="container">
                <h2 class="text-center">Testimonials</h2>
<?
$p=$_GET[p];
if($p=="viewall")	$rs1=mysqli_query($dbconnect,"Select * from testimonials where status=1 order by rand()");
else				$rs1=mysqli_query($dbconnect,"Select * from testimonials where status=1 order by rand() limit 0,5");
if(mysqli_num_rows($rs1)>0) {
	$i=0;
?>
				<p class="text-center">Read some of the comments from our satisfied members below.</P>
<?php
	while($arr=mysqli_fetch_array($rs1)) {
		$i++;
		if($i%2<>0)
		{
?>

				<div class="testimonial">
					<div class="col-sm-8 col-md-9">
						<div class="test">
							<p><?php echo str_ireplace("\n","<br>",stripslashes($arr[2])); ?></p>
							<img src="images/qc_red.png" class="right" />
						</div>
					</div>
					<div class="col-sm-4 col-md-3">
						<center><img src="images/avtar.jpg" class="img-responsive img-circle user" /></center>
						<footer><h4><?=$arr[1]?></h4><?=$arr[4]?></footer>
					</div>
					<div class="clearfix"></div>
				</div>
<?		}else {?>
				<div class="testimonial">
					<div class="col-sm-4 col-md-3">
						<center><img src="images/avtar.jpg" class="img-responsive img-circle user" /></center>
						<footer><h4><?=$arr[1]?></h4><?=$arr[4]?></footer>
					</div>
					<div class="col-sm-8 col-md-9">
						<div class="test">
							<img src="images/qc_red.png" class="left" />
							<p><?php echo str_ireplace("\n","<br>",stripslashes($arr[2])); ?></p>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
<?php
		} 
	}
	if($p!="viewall") {
		$rs1=mysqli_query($dbconnect,"Select * from testimonials where status=1 order by rand()");
		$num=mysqli_num_rows($rs1);
		if($num>5)		echo "<div align=right><a href=testimonials.php?p=viewall>Click Here to view all testimonials</a></div>";
	}
} else {
?>
				<p class="text-center">No Record Found!</P>
<?php } ?>
</div>
<div class="margin-vertical-20"></div>
<?
include "footer.php";
?>