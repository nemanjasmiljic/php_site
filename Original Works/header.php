<?php
include "config.php";
$actual_link = $_SERVER['PHP_SELF'];
$actual_link = explode("/",$actual_link);
$poscount=count($actual_link)-1;
$file=$actual_link[$poscount];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title><?=$sitename; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
	
	<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom styles -->
    <link href="css/front.css" rel="stylesheet" />
<?php if(isset($_SESSION["username_session"])) { ?>
	<link href="css/dashboard.css" rel="stylesheet" />
<?php } ?>
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	 
	<script>
		$(document).ready(function(){
			var stickySidebar = $('.top-fixed').offset().top;

			$(window).scroll(function() {  
				if ($(window).scrollTop() > stickySidebar) {
					$('.top-fixed').addClass('affix');
				}
				else {
					$('.top-fixed').removeClass('affix');
				}  
			});
		});
	</script>
</head>

<body>
<?php 
if(($file=="") || ($file=="index.php") || ($file=="join.php") || ($file=="contactus.php") || ($file=="faq.php") || ($file=="testimonials.php") || ($file=="terms.php")  || ($file=="resendv.php")  || ($file=="confirm.php") || (!isset($_SESSION["username_session"]))) { 
$sname="$sitename Administrator";
$id=$_SESSION[refid_session];
if($id) {
	$rs=mysqli_query($dbconnect,"select Name from users where Username='$id'");
	if(mysqli_num_rows($rs)>0) {
		$arr=mysqli_fetch_array($rs);
		$sname=$arr[0];
	}
}

?>
<header class="container-fluid">
<?php if($file=="index.php") {?>
	<div class="row">
		<div class="header">
			<div class="container">
				<div class="row">
					<div style="height:100vh;display:table;width:100%">
						<div style="display:table-cell;vertical-align:middle">
							<div class="sitename"><?=$sitename; ?></div>
							<div class="siteslogan">Networking and Rising Together</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<? } ?>
	<div class="row">
		<nav class="navbar navbar-main top-fixed">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a href="" class="navbar-brand"><?=$sitename; ?></a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
					<ul class="nav navbar-nav navbar-right">
						<li <?php if($file=="index.php") echo "class=\"active\""; ?>><a href="index.php">Home</a></li>
                        <li <?php if($file=="testimonials.php") echo "class=\"active\""; ?>><a href="testimonials.php">Testimonials</a></li>
                        <li <?php if($file=="faq.php") echo "class=\"active\""; ?>><a href="faq.php">FAQ's</a></li>
                        <li <?php if($file=="contactus.php") echo "class=\"active\""; ?>><a href="contactus.php">Contact Us</a></li>
			<?php if (!isset($_SESSION["username_session"])) { ?>
						<li class='<?php if($file=="join.php") echo "active"; ?>'><a href="join.php">Join</a></li>
						<li class='<?php if($file=="login.php") echo "active"; ?>'><a href="login.php">Login</a></li>
			<?php } else { ?>
						<li class='<?php if($file=="login.php") echo "active"; ?>'><a href="login.php">Welcome <?php echo $_SESSION["username_session"]; ?></a></li>
						<li class='<?php if($file=="logout.php") echo "active"; ?>'><a href="logout.php">Logout</a></li>
			<?php } ?>
					</ul>
				</div>
			</div>
		</nav>
	</div>
</header>
<?php } else { ?>

<header>
	<div class="top">
		<div class="container-fluid">
			<span><?php if($_SESSION["username_session"]!="") echo "Welcome $_SESSION[username_session]!"; ?></span>
			<span class="pull-right">
				<span class="badge">Total Members : <?php $ct=mysqli_fetch_array(mysqli_query($dbconnect,"select count(*) from users where active=1")); echo number_format($ct[0],0); ?></span>
				<span><a href="logout.php">Logout</a></span>
			</span>
			<div class="clearfix"></div>
		</div>
	</div>
</header>

<section class="container-fluid">
	<div class="row">	
		<div class="col-sm-3 col-md-2">
			<div class="row">
				<div class="nav-side-menu">
					<i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
					<div class="menu-list">
						<ul id="menu-content" class="menu-content collapse out">
							<li <? if($file=="login.php") echo "class=\"active\""; ?>><a href="login.php"><i class="fa fa-desktop fa-lg"></i> Overview</a></li>
							<li <? if($file=="purchasepos.php") echo "class=\"active\""; ?>><a href="purchasepos.php"><i class="fa fa-money fa-lg"></i> Purchase Position(s)</a></li>
							<li <? if($file=="stats.php") echo "class=\"active\""; ?>><a href="stats.php"><i class="fa fa-pie-chart fa-lg"></i> Stats</a></li>
							<li <? if($file=="managepos.php") echo "class=\"active\""; ?>><a href="managepos.php"><i class="fa fa-sliders fa-lg"></i> Matrix Positions</a></li>
							<li <? if($file=="withdrawal.php") echo "class=\"active\""; ?>><a href="withdrawal.php"><i class="fa fa-dollar fa-lg"></i> Withdrawal</a></li>
							<li <? if($file=="ads.php") echo "class=\"active\""; ?>><a href="ads.php"><i class="fa fa-image fa-lg"></i> Promotional Center</a></li>
							<li <? if($file=="banners.php") echo "class=\"active\""; ?>><a href="banners.php"><i class="fa fa-user fa-lg"></i> Banner Advertisement</a></li>
							<li <? if($file=="textadv.php") echo "class=\"active\""; ?>><a href="textadv.php"><i class="fa fa-file-text-o fa-lg"></i> Text Ad Advertisement</a></li>
							<li <? if($file=="bonus.php") echo "class=\"active\""; ?>><a href="bonus.php"><i class="fa fa-flask fa-lg"></i> Bonus</a></li>
							<li <? if($file=="update_pf.php") echo "class=\"active\""; ?>><a href="update_pf.php"><i class="fa fa-user fa-lg"></i> Profile</a></li>
							<li <? if($file=="submittestimonials.php") echo "class=\"active\""; ?>><a href="submittestimonials.php"><i class="fa fa-wpforms fa-lg"></i> Submit Testimonials</a></li>
							<li <? if($file=="contactus.php") echo "class=\"active\""; ?>><a href="contactus.php"><i class="glyphicon glyphicon-log-out"></i> Support</a></li>
							<li <? if($file=="logout.php") echo "class=\"active\""; ?>><a href="logout.php"><i class="glyphicon glyphicon-log-out"></i> Logout</a></li>
						</ul>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			<div class="margin-vertical-20 visible-xs"></div>
		</div>
		<div class="col-sm-6 col-md-8">
<?
	if($file=="login.php") $pageName="Overview";
	elseif($file=="purchasepos.php") $pageName="Purchase Position(s)";
	elseif($file=="stats.php") $pageName="Stats";
	elseif($file=="managepos.php") $pageName="Manage Positions";
	elseif($file=="withdrawal.php") $pageName="Withdrawal";
	elseif($file=="ads.php") $pageName="Promotional Center";
	elseif($file=="banners.php") $pageName="Banner Advertisement";
	elseif($file=="textadv.php") $pageName="TextAds Advertisement";
	elseif($file=="bonus.php") $pageName="Bonus";
	elseif($file=="contactus.php") $pageName="Contact Us";
	elseif($file=="update_pf.php") $pageName="Update Profile";
	elseif($file=="submittestimonials.php") $pageName="Submit Testimonials";
?>		
		<div class="row">
			<div class="page-heading">
				<span><?=$pageName?></span>
				<ul class="breadcrumb pull-right">
					<li>You are here : </li>
					<li><a href="#"><i class="fa fa-home"></i></a></li>
					<li><?=$pageName?></li>
				</ul>
				<div class="clearfix"></div>
			</div>
		</div>
<?php } ?>
<?php 
if((($file!="index.php") && (!isset($_SESSION["username_session"]))) || ((($file=="join.php")||($file=="terms.php")||($file=="contactus.php")||($file=="forgot.php")||($file=="resendv.php")||($file=="confirm.php")||($file=="remove.php")||($file=="faq.php")||($file=="testimonials.php")))){ 
?>
<section class="container-fluid section2">
	<div class="container">
		<div class="row">
<?php 
		$rs=mysqli_query($dbconnect,"select ID,Textad,Textad1 from memberstextads where remaining>0 and approved=1 order by rand() limit 0,$nads");
		if(mysqli_num_rows($rs)>0)
		{
			while($arr=mysqli_fetch_array($rs)) {
				$rsu=mysqli_query($dbconnect,"update memberstextads set remaining=remaining-1 where ID=$arr[0]");
?>
			<div class="col-sm-4">
				<p class="text-center">
					<b><?php echo stripslashes($arr[1]); ?></b>
				</p>
				<p class="text-center">
					<?php echo stripslashes($arr[2]); ?><br>
					<a target="_blank" href="<?php echo "$siteurl/tr1.php?id=$arr[0]"; ?>" style="color:#fff">Click Here Now</a>
				</p>
			</div>
<?php
			}
		}
		else
			for($i=0;$i<$nads;$i++)
				echo "<div class='col-sm-4'><p class='text-center'><b>Ad Heading</b><br />
							Line 1<br />
							Line 2<br />
							Line 3<br>
<a href='#' style='color:#fff'>Click Here.</a></p></div>";
?>
			<div class="col-xs-12">
				<a target="_blank" href="<?php echo $siteurl; ?>" class="pull-right"><font size="2" color="#fff">Ads by <?php echo $sitename; ?></font></a>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</section>
<?php } ?>