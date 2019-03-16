<?php
    require "htmlHeader.php";
	require "config.php";  
?>	
<!-- WRAPPER -->
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
			<li class="current-menu-item"><a href="catEdit.php"><span>NEUE KATZE</span></a></li>
			<li><a href="contact.php"><span>KONTAKT</span></a></li>
		</ul>
		<div id="combo-holder"></div>
	</nav>
	<!-- ends nav -->			
</header>
<?php
	$description = "eine neue Katze";
	if(isset($_GET["id"]))
	{
		$id = trim($_GET["id"]);
		$connection = new PDO("$dsn", $username, $password, $options);
		$sth = $connection->prepare('select description, deleted from cat where id = :id');
		$sth->bindParam(':id', $id, PDO::PARAM_INT);
		$sth->execute();
		$row = $sth->fetch();
		$description = $row['description'];
		$deleted = $row['deleted'];
		$uniqueName = str_pad($id, 10, "0", STR_PAD_LEFT);
		
		if(file_exists ("upload/" . $uniqueName . ".jpg")){ ?>
		 <p><a href="index.php"><img src="upload/<?php echo $uniqueName . '.jpg';?>" border="0"></a></p>
<?php } else { ?>
     <p>kein Bild</p>
<?php } } ?>

		<form name="form1" method="post" action="catCreate.php" enctype="multipart/form-data">

		 <label>Beschreibung: 
			<input type="text" name="description" id="description" value="<?php echo htmlspecialchars ($description);?>">
		 </label><br>
		 
<?php 	if(isset($_GET["id"])){ ?>
		 <input type="hidden" name="id" id="id" value="<?php echo $_GET["id"];?>">
		 <label>Gelöscht<input type="checkbox" name="deleted" id="deleted" <?php if($deleted) echo "checked";?> /></label><br>	 
<?php }  ?>
		 <input type="file" name="fileUpload"><br>
		 <input name="btnSubmit" type="submit" value="Katze">

	</form>
<?php
    require "htmlFooter.php";
?>						
