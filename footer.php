<?php
if($file=="index.php") {
	?>
<section class="container-fluid section2">
	<div class="container">
		<div class="col-md-2">
            <h3 class="text-center" style="margin-top:0">Latest<br/><b>Joining</b></h3>
		</div>
		<div class="col-md-10">
			<div class="marquee">
				<div class="inner">
				<?php $rsu=mysqli_query($dbconnect,"select Name,Date from users where active=1 order by ID desc limit 0,10");
					while($arru=mysqli_fetch_array($rsu)) {
					$dt=explode(" ",$arru[1]);
					?>
					<span class="single"><img src="images/avtar.jpg" class="payment-avatar" alt="" /><?php echo $arru[0]; ?> - <?php echo $dt[0]; ?></span>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</section>
	<?
}
if(($file!="index.php") && (!isset($_SESSION["username_session"]))) {
	echo "<div class='container'>";
	echo "<div class='margin-vertical-20'></div>";
	$rs=mysqli_query($dbconnect,"select ID,BannerURL from membersbanners where remaining>0 and approved=1 order by rand() limit 0,$showban");
	while($arr=mysqli_fetch_array($rs)) {
		echo "<div class='col-sm-6 text-center'><a href=$siteurl/trr.php?id=$arr[0] target=_blank><img src=$arr[1] class=\"img-responsive\" border=0></a></div>";
		$rsu=mysqli_query($dbconnect,"update membersbanners set remaining=remaining-1 where ID=$arr[0]");
	}
	echo "</div>";
}

	if((isset($_SESSION["username_session"]))&&($file!="index.php")&&($file!="join.php")&&($file!="terms.php")&&($file!="contactus.php")&&($file!="forgot.php")&&($file!="resendv.php")&&($file!="faq.php")&&($file!="confirm.php")&&($file!="remove.php")&&($file!="testimonials.php")){ ?>
			<hr class="row visible-xs" />
		</div>
		<aside class="col-sm-3 col-md-2">
			<div class="row">
				<div class="Text-ads">Text-ads</div>
				<ul class="aside">
<?php 
		$rs=mysqli_query($dbconnect,"select ID,Textad,Textad1 from memberstextads where remaining>0 and approved=1 order by rand() limit 0,$nads");
		if(mysqli_num_rows($rs)>0)
		{
			while($arr=mysqli_fetch_array($rs)) {
				$rsu=mysqli_query($dbconnect,"update memberstextads set remaining=remaining-1 where ID=$arr[0]");
?>
					<li>
						<span class="text">
							<b><?php echo stripslashes($arr[1]); ?></b><br />
							<?php echo stripslashes($arr[2]); ?>
						</span>
						<a class="data" href="<?php echo "$siteurl/tr1.php?id=$arr[0]"; ?>">Click Here Now</a>
					</li>
<?php
			}
		}
		else
			for($i=0;$i<3;$i++)
				echo "
					<li class='text-center'>
						<span class='text'>
							<b>Ad Heading</b><br />
							Line 1<br />
							Line 2<br />
							Line 3
						</span>
						<a class='data' href=''>Click Here Now</a>
					</li>
				";
?>					
					<li>
						<span class="text">Ads by</span>
						<span class='pull-right'><a class="data" href=""><?=$sitename; ?></a></span>
						<div class='clearfix'></div>
					</li>
				</ul>
			</div>
		</aside>
	</div>
</section>
<div class="clearfix"></div>
<?php }
//if((!isset($_SESSION["username_session"]))) {
?>
<div class="clearfix"></div>
<footer class="footer">
	<div class="container">
		<div class="col-sm-4">
			<div class="heading">Company</div>
			<p class="text-justify"><?=$sitename; ?> is helping increase Unity and Wealth, empowering our collective Rise to Prosperity. Join Us!
</p>
		</div>
		<div class="col-sm-4">
			<div class="heading">Quick Links</div>
			<ul>
				<li class="col-xs-6"><a href="index.php">Home</a></li>
				<li class="col-xs-6"><a href="join.php">Join Now</a></li>
				<li class="col-xs-6"><a href="login.php">Login</a></li>
				<li class="col-xs-6"><a href="contactus.php">Contact Us</a></li>
				<li class="col-xs-6"><a href="testimonials.php">Testimonials</a></li>
				<li class="col-xs-6"><a href="terms.php">Terms &amp; Conditions</a></li>
				<li class="col-xs-6"><a href="privacy.php">Privacy Policy</a></li>
			</ul>
		</div>
		<div class="col-sm-4">
			<div class="heading">Stay Connected</div>
			<ul class="social">
				<li>
					<a href="">
						<span class="icon"></span>
						<span class="label"><i class="fa fa-facebook-square fa-5x" aria-hidden="true"></i></span>
					</a>
				</li>
				<li>
					<a href="">
						<span class="icon"></span>
						<span class="label"><i class="fa fa-twitter-square fa-5x" aria-hidden="true"></i></span>
					</a>
				</li>
				<li>
					<a href="">
						<span class="icon"></span>
						<span class="label"><i class="fa fa-youtube-square fa-5x" aria-hidden="true"></i></span>
					</a>
				</li>
				<li>
					<a href="">
						<span class="icon"></span>
						<span class="label"><i class="fa fa-linkedin-square fa-5x" aria-hidden="true"></i></span>
					</a>
				</li>
				</ul>
		</div>
	</div>
	<hr />
	<p class="text-center">Copyright &copy; <?php echo date("Y"); ?> <?php echo $sitename; ?> - All rights reserved.<br>Powered by <a href="https://yourfreeworld.com/script/?id=<?php echo $yfwid; ?>">YourFreeWorld.com Scripts</a></p>
	<div class="clearfix"></div>
</footer>
<?php 
	mysqli_close($dbconnect);
?>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="dist/js/bootstrap.min.js"></script>
    <script src="assets/js/docs.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
	<?php if($file=="index.php") { ?><script src="js/scroller.js"></script><?php } ?>
</body>
</html>