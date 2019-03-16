<?php
    require "htmlHeader.php";
	require "config.php";   
	$catId = trim($_GET["catId"]);
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
<h1><?php echo $_GET["message"];?></h1>
<a href="cat.php?id=<?php echo $catId;?>">Zurück</a>
<table>
 <tr>	 
		 <th>id</th>
		 <th>cat_id</th>
		 <th>cat_related</th>
		 <th>created</th>
		 <th>type</th>
		 <th>sub_type</th>
		 <th>street</th>
		 <th>street_number</th>
		 <th>description</th>
		 <th>owner</th>
		 <th>ip</th>
		 <th>deleted</th>
</tr>
<?php    
	$connection = new PDO("$dsn", $username, $password, $options);
	$sth = $connection->prepare('select * from event where cat_id = :catId order by id desc');	
	$sth->bindParam(':catId', $catId, PDO::PARAM_INT);
	
    if ($sth->execute()) {
		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
?>				
         <tr>	 
		 <td><?php echo htmlentities($row['id']);?></td>
		 <td><?php echo htmlentities($row['cat_id']);?></td>
		 <td><?php echo htmlentities($row['cat_related']);?></td>
		 <td><?php echo htmlentities($row['created']);?></td>
		 <td><?php echo htmlentities($row['type']);?></td>
		 <td><?php echo htmlentities($row['sub_type']);?></td>
		 <td><?php echo htmlentities($row['street']);?></td>
		 <td><?php echo htmlentities($row['street_number']);?></td>
		 <td><?php echo htmlentities($row['description']);?></td>
		 <td><?php if($row['owner']) echo "vom Besitzer";?></td>
		 <td><?php echo htmlentities($row['ip']);?></td>
		 <td><a href="eventDelete.php?catId=<?php echo $catId;?>&id=<?php echo $row['id'];?>"><?php if($row['deleted']) echo "unsichtbar"; else echo "sichtbar";?></a></td>
		 </tr>
<?php
	   }
	}	
?>
</table>

<?php
    require "htmlFooter.php";
?>						
