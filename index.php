<?php
    require "htmlHeader.php";
	require "config.php";  
?>	
<div class="wrapper cf">
<header class="cf">					
	<div id="logo" class="cf">
		<a href="index.html" ><img src="img/logo.png" alt="" /></a>
	</div>
	
	<!-- nav -->
	<nav class="cf">
		<ul id="nav" class="sf-menu">
			<li class="current-menu-item"><a href="index.php"><span>AKTUELLES</span></a></li>
			<li><a href="unknown.php"><span>UNBEKANNT</span></a></li>
			<li><a href="home.php"><span>REVIERE</span></a>
				<ul>
					<li><a href="home.php?home=<?php echo urlencode ( 'Kandelstrasse' ); ?>">Kandelstrasse</a></li>
					<li><a href="home.php?home=<?php echo urlencode ( 'Am Himmelreich' ); ?>">Am Himmelreich</a></li>
					<li><a href="home.php?home=<?php echo urlencode ( 'Wilhelmstraße' ); ?>">Wilhelmstraße</a></li>
					<li><a href="home.php?home=<?php echo urlencode ( 'Carl-Orff-Weg' ); ?>">Carl-Orff-Weg</a></li>
					<li><a href="home.php?home=<?php echo urlencode ( 'Hochburger Str.' ); ?>">Hochburger Str.</a></li>
					<li><a href="home.php?home=<?php echo urlencode ( 'Moltkestraße' ); ?>">Moltkestraße</a></li>
				</ul>
			</li>
			<li><a href="catEdit.php"><span>NEUE KATZE</span></a></li>
			<li><a href="contact.php"><span>KONTAKT</span></a></li>
		</ul>
		<div id="combo-holder"></div>
	</nav>
	<!-- ends nav -->			
</header>
	<!-- MAIN -->
		<div role="main" id="main" class="cf">
			
			<!-- page-content -->
			<div class="page-content">
			
				
				<!-- entry-content -->	
	        	<div class="entry-content cf">
	        		
	        		<h2 class="heading">Willkommen bei den Kandelkatzen</h2>
	        		<p>Wolltet ihr nicht auch schon immer mal wissen wo sich eure Katze als rumtreibt oder wo die Rumtreiber in eurerm Garten alle herkommen.
					Hier könnt ihr rund um die Kandelstraße eure Katzenbegenungen mit anderen Teilen und müsst euch in Zukunft vielleicht weniger Sorgen machen ohne gleich zu komplizierten technischen Hilfsmitteln zu greifen.
					Auf der Startseite seht ihr immer 5 neusten Einträge. Vermisstenmeldungen stehen dabei immer an erster Stelle.</p><p>Auf der Startseite findest du immer die 5 neusten Einträge.</p>
					
					
<?php
  

	$connection = new PDO("$dsn", $username, $password, $options);	
	$sql = "select c2.id, e2.created, type, CONCAT(street, ' ', street_number) as home, e2.description from cat c2 inner join event e2 on e2.cat_id = c2.id where e2.id in
(select max(e.id) from cat c inner join event e on e.cat_id = c.id where c.deleted = false and e.deleted = false group by c.id) order by created desc limit 5";	
$sth = $connection->prepare($sql);	


require "catEventListElement.php";
?>						
				</div>
				<!-- ENDS entry-content -->

			</div><!-- ENDS page-content -->
						
		</div>
		<!-- ENDS MAIN -->
			
<?php
    require "htmlFooter.php";
?>						
