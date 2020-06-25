<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Erreur</title>

	<!-- FONTS -->
	<link href='http://fonts.googleapis.com/css?family=Signika:400,300,600,700' rel='stylesheet' type='text/css'>
	<!-- EXTERNAL STYLESHEETS -->
	<script src="https://kit.fontawesome.com/42ce300797.js" crossorigin="anonymous"></script>
	<!-- ANIMATION -->
	<link href="../public/css/animation.css" rel="stylesheet" type="text/css" />
	<!-- MAIN STYLESHEETS -->
	<link rel="stylesheet" href="../public/css/404.css">
	<!-- Favicons -->
	<link rel="icon" href="../public/img/carsery.png">
</head>
<body>
	<!-- ANIMATION -->
	<div class="fix-wrp">
		<div class="animate-wrp">
			<div class="sky">
				<div class="car-wheels"></div>
				<div class="car">
					<div class="msg"><b><span>Oops!</span>Je me suis peut-être tromper.</b></div>
				</div>
				<div class="car-wheels c1"></div>
				<div class="car1 c1"></div>
				<div class="cloud"></div>
				<div class="cloud2"></div>
				<div class="cloud1"></div>
				<div class="grass1"></div>
				<div class="grass"></div>
				<div class="grass2"></div>
				<div class="mountain"></div>
				<div class="mountain1"></div>
				<div class="tree"></div>
				<div class="tree-front"></div>
				<div class="road"></div>
				<div class="road-front"></div>
			</div>	
		</div>
	</div>
	<!--/animate-wrp -->

	<!-- MAIN WRAPPER -->
	<div class="main-wrapper">
		<!-- CONTAINER -->
		<div class="container">
			
			<!-- CLOUD MESSAGE -->
			<div class="cloud-message">
				<?php include "views/".$this->view.".view.php"; ?>
				<img src="../public/img/cloud-large1.png" alt="cloud" />
			</div>
			<!--/cloud message -->
			
			<!-- NAVIGATION LINKS -->
			<div class="nav-wrapper">
				<a href="/">Accueil</a>
                <a href="javascript:history.go(-1)">Précédent</a>
			</div>
			<!--/nav-wrapper -->
			
			<!-- SOCIAL LINKS -->
			<div class="social-links">
				<a href="#"><i class="fab fa-facebook"></i></a>
				<a href="#"><i class="fab fa-twitter"></i></a>
				<a href="#"><i class="fab fa-google-plus"></i></a>
				<a href="#"><i class="fab fa-linkedin"></i></a>
				<a href="#"><i class="fab fa-youtube"></i></a>
				<a href="#"><i class="fab fa-vimeo-square"></i></a>
				<a href="#"><i class="fab fa-dribbble"></i></a>
				<a href="#"><i class="fab fa-skype"></i></a>
				<a href="#"><i class="fa fa-rss"></i></a>					
			</div>
			<!--/social-links -->
			<p class="copyrights">Copyright © 2020 Carsery All Right Reserved</p>
		</div>
		<!--/container -->
	</div>
	<!--/main-wrapper -->
	
	<!-- COMMON SCRIPT -->
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
	<script src="../public/js/404.js"></script>
</body>
</html>