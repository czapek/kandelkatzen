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
<?php

	$connection = new PDO("$dsn", $username, $password, $options);
	$sql = "select c2.created, c2.id, c2.description,  CONCAT(h.street, \" \", h.street_number) as home from cat c2 left join 
(select * from event where id in
(select max(e.id) from cat c inner join event e on c.id = e.cat_id where c.deleted = false and e.deleted = false and type = 'HOME' group by cat_id)) h on h.cat_id=c2.id
where c2.deleted = false and c2.id <> " . $_GET["id"] . "
order by ISNULL(type), street, convert(street_number, int), c2.created desc";	
?>

<h2><?php echo $_GET["message"];?></h2>
<table width="200" border="1">
<tr>
<th> <div align="center">Datum</div></th>
<th> <div align="center">Beschreibung</div></th>
<th> <div align="center">Wohnhaft</div></th>

<th> <div align="center"></div></th>
</tr>

<?php
	 foreach ($connection->query($sql) as $row) {
		 $uniqueName = str_pad($row['id'], 10, "0", STR_PAD_LEFT);
?>
<tr>
<td><?php echo htmlentities($row['created']);?></td>
<td><?php echo htmlentities($row['home']);?></td>
<td><?php echo htmlentities($row['description']);?></td>
<td>


<?php if(file_exists ("upload/" . $uniqueName . ".jpg")){ ?>
     <a href="cat.php?id=<?php echo $_GET["id"]; ?>&catRelated=<?php echo $row['id']; ?>"><img src="upload/<?php echo $uniqueName . '_tn.jpg';?>" border="0"></a>
<?php } else { ?>
     kein Bild
<?php } ?>

</td>
<td><a href="cat.php?id=<?php echo $_GET["id"]; ?>&catRelated=<?php echo $row['id']; ?>">auswählen</a></td>
</tr>
<?php
	}
?>

</table>


<?php
    require "htmlFooter.php";
?>						

