<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de" ng-app='kolbFotografie'>
	<head> 
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Julian Kolb | Kamera & Motiondesign</title>
		<meta name="description" content="Julian Kolb | Kameramann aus Köln | Film / Fotografie / Motion Design" />
		<meta name="keywords" content="Kamera, Kameramann, Fotos, Fotografie, Video, Reisen, Kolb, Julian, Design, Motion, Graphics, Doku, Film, Freiberuflich" />
		<meta name="author" content="www.jonas-brueggen.de" />
		<meta name="viewport" content="width=device-width">
		<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
		<!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Titillium+Web:400,700"> -->

		<link rel="stylesheet" href="css/jk_main.css" type="text/css" />

		<link rel="stylesheet" href="css/featherlight.min.css" type="text/css" />
		<link rel="stylesheet" href="css/jquery-jvectormap-2.0.3.min.css" type="text/css" />
		<script src="https://code.jquery.com/jquery-latest.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.10/angular.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.10/angular-animate.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.10/angular-route.min.js"></script>
		<!-- build:js js/jk.min.js async -->
		<script type="text/javascript" src="js/scripts.js"></script>
		<script type="text/javascript" src="js/angularController.js"></script>
		<script src="js/screen_detect.js"></script>
		<!-- endbuild -->

		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-118173565-1"></script>
		<script type="text/javascript">
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());
			gtag('config', 'UA-118173565-1');
		</script>

	</head>
	<body>
		<div class="page_loader">
			<div class="loader"></div>
		</div>
		<div id="container" class="hide_container">
			<div id="mobile_titlebar" class="closedmenu">
				<h1 class="title" id="mobile_pagetitle">Julian Kolb</h1>
				<div id="jk_logo_mobil" onclick="toggleMobileMenu();">
					<img id="jk_logo_mobil_img" src="img/menu/menu.png" />
				</div>
			</div>
			<header id="sidebar">
				<nav class="navbar" ng-controller="HeaderController">
					<div id="jk_logo">
						<a href="#/">
							<img src="img/logo_main.svg" />
						</a>
					</div>
					<div id="navi_main">
						<ul class="main_list">
							<li ng-class="{ active: isActive('/')}"><a href="#/">Home</a></li>
							<li ng-class="{ 'active expanded': isActive('/fotografie')}">
								<a href="#/fotografie">Fotografie</a>
								<div class="expander" onclick="this.parentElement.classList.toggle('expanded');">
									<div class="horizontal"></div>
									<div class="vertical"></div>
								</div>
								<?php
								$sublistHtml = '';
								$counter = 0;
								$pictureDir = 'content/fotos/';
								$files = scandir($pictureDir);
								sort($files);
								foreach ($files as $file) {
									if ($file != '.' && $file != '..' && $file != '_HomeFoto') {
										$sublistHtml .= '<li ng-class="{ active: isActive(\'/fotografie/:'.$file.'\')}"><a href="#/fotografie/:'.$file.'">'.$file.'</a></li>'."\n";
										$counter++;
									}
								}
								$maxheight = ($counter*29).'px';
								echo '<ul style="max-height:'.$maxheight.'" class="sublist">'.$sublistHtml.'</ul>';
								?>
							</li>
							<li ng-class="{ 'active expanded': isActive('/film')}">
								<a href="#/film">Film</a>
								<div class="expander" onclick="this.parentElement.classList.toggle('expanded');">
									<div class="horizontal"></div>
									<div class="vertical"></div>
								</div>
								<?php
								$sublistHtml = '';
								$counter = 0;
								$row = 0;
								$filmcsv = 'content/filme.csv';
								$categories = array();
								if (($handle = fopen($filmcsv, "r")) !== FALSE) {
									while (($data = fgetcsv($handle, 0, ";", '"', '"')) !== FALSE) {
										if ($row > 0){
											$categories[] = $data[0];
										}
										$row++;
									}
									fclose($handle);
								}
								$categories = array_unique($categories);
								foreach ($categories as $value) {
									$counter++;
									$sublistHtml .= '<li ng-class="{ active: isActive(\'/film/:'.$value.'\')}"><a href="#/film/:'.$value.'">'.$value.'</a></li>'."\n";
								}
								$maxheight = ($counter*29).'px';
								echo '<ul style="max-height:'.$maxheight.'" class="sublist">'.$sublistHtml.'</ul>';
								?>
							</li>
							<li ng-class="{ active: isActive('/kontakt')}"><a href="#/kontakt">Kontakt</a></li>
						</ul>
					</div>
					<div id="jk_ref_links">
						<?php
						$row = 0;
						$size = 20;
						$socialcsv = 'content/social_links/social_links.csv';
						if (($handle = fopen($socialcsv, "r")) !== FALSE) {
							while (($data = fgetcsv($handle, 0, ";", '"', '"')) !== FALSE) {

								if($row > 0) {

									$currentLink = $data[0];
									$currentXPos = ($row-1)*$size;

									echo '<a href="'.$currentLink.'" style="background-position-x:-'.$currentXPos.'px" target="_blank"></a>';
								}

								$row++;

							}
							$bg_size = ($row-1)*$size;
							echo'<style>#jk_ref_links a { background-size:'.$bg_size.'px; width:'.$size.'px; height:'.$size.'px;}#jk_ref_links a:hover{ background-position-y:-'.$size.'px; }</style>';
							fclose($handle);
						}
						?>
					</div>
				</nav>
			</header>
			<div ng-view class="reveal_animation" id="main">
			</div>
		</div>
	</body>
	<!-- startup and loader javascript -->
<script>
	//some startup scripts
	function startup() {
		document.getElementsByClassName('loader')[0].classList.add("global_hide");
		document.getElementsByClassName('page_loader')[0].classList.add("global_hide");
		document.getElementById('container').classList.remove("hide_container");
		console.log("onload!");
	};

	WebFontConfig = {
		google: { families: [ 'Titillium+Web' ] }
	};

	(function() {
		var wf = document.createElement('script');
		wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
		wf.type = 'text/javascript';
		wf.async = 'true';
		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(wf, s);
	})();

	(new Image()).src = "img/menu/menu-to-logo.gif";
	(new Image()).src = "img/menu/logo-to-menu.gif";

	// scripts are loaded async, so wait for them to be loaded, then execute the startup!
	window.addEventListener("load", function() {
		startup();
	});
</script>
</html>