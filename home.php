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
			<li><a href="index.php"><span>AKTUELLES</span></a></li>
			<li><a href="unknown.php"><span>UNBEKANNT</span></a></li>
			<li class="current-menu-item"><a href="home.php"><span>REVIERE</span></a>
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
	        		<p>Hier sind alle Katzen aufgelistet die bereits ein Revier zugeordnet haben. Ein Revier setzt sich aus Straßennamen und Hausnummer zusammen.</p></br>
					
					
<?php
  
    $home = $_GET["home"];
	$connection = new PDO("$dsn", $username, $password, $options);
	if(isset($home))
		$homesql = "h.street = :home";
	else
	    $homesql = "h.street is not null";
	
	$sql = "select c2.created, c2.id, c2.description,  CONCAT(h.street, \" \", h.street_number) as home, n.names from cat c2 
left join (select cat_id, type,  street, street_number from event where id in (select max(e.id) from cat c inner join event e on c.id = e.cat_id where c.deleted = false and e.deleted = false and type = \"HOME\" group by cat_id)) h on h.cat_id=c2.id
left join (select cat_id, GROUP_CONCAT(e.description ORDER BY owner desc, e.id desc SEPARATOR \", \") as names from cat c inner join event e on c.id = e.cat_id where c.deleted = false and e.deleted = false and type = \"NAME\" group by cat_id) n on n.cat_id = c2.id
where c2.deleted = false and " . $homesql . " 
order by ISNULL(type), street, convert(street_number, int), c2.created desc";	
$sth = $connection->prepare($sql);	
if(isset($home))
   $sth->bindParam(':home', $home, PDO::PARAM_STR, 50);

require "catListElement.php";
?>						
				</div>
				<!-- ENDS entry-content -->

			</div><!-- ENDS page-content -->
						
		</div>
		<!-- ENDS MAIN -->
			
<?php
    require "htmlFooter.php";
?>						
