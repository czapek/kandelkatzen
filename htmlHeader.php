<?php
    require "header.php";
?>	
<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
		
	<title>HalfTone Template</title>
	<meta name="description" content="">
	
	<!-- Mobile viewport optimized: h5bp.com/viewport -->
	<meta name="viewport" content="width=device-width">
	
	
	<link rel="stylesheet" media="screen" href="css/superfish.css" /> 
	<link rel="stylesheet" href="css/nivo-slider.css" media="all"  /> 
	<link rel="stylesheet" href="css/tweet.css" media="all"  />
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" media="all" href="css/lessframework.css"/>
	
	
	<!-- All JavaScript at the bottom, except this Modernizr build.
	   Modernizr enables HTML5 elements & feature detects for optimal performance.
	   Create your own custom Modernizr build: www.modernizr.com/download/ -->
	<script src="js/modernizr-2.5.3.min.js"></script>
</head>
<body>
	
	<!-- WRAPPER -->
	<div class="wrapper cf">
		<header class="cf">					
			<div id="logo" class="cf">
				<a href="index.html" ><img src="img/logo.png" alt="" /></a>
			</div>
			
			<!-- nav -->
			<nav class="cf">
				<ul id="nav" class="sf-menu">
					<li class="current-menu-item"><a href="index.html"><span>AKTUELLES</span></a></li>
					<li><a href="catEdit.php"><span>UNBEKANNT</span></a></li>
					<li><a href="page.html"><span>REVIERE</span></a>
						<ul>
							<li><a href="page.html">Kandelstrasse</a></li>
							<li><a href="page-typography.html">Am Himmelreich</a></li>
							<li><a href="page-elements.html">Wilhelmstraße</a></li>
							<li><a href="page-sidebar.html">Carl-Orff-Weg</a></li>
							<li><a href="page-sidebar.html">Hochburger Str.</a></li>
							<li><a href="page-sidebar.html">Moltkestraße</a></li>
						</ul>
					</li>
					<li><a href="catEdit.php"><span>NEUE KATZE</span></a></li>
					<li><a href="blog.html"><span>KONTAKT</span></a></li>
				</ul>
				<div id="combo-holder"></div>
			</nav>
			<!-- ends nav -->			
		</header>