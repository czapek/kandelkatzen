<?php
    require "header.php";
    require "config.php";
	
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

<html>
<head>
<title>Katze erstellen oder bearbeiten</title>
</head>
<body>
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
</body>
</html>