<?php
    require "header.php";
    require "config.php";
?>
<html>
<head>
<title>Cat</title>
</head>
<body>
<?php	
	$id = trim($_GET["id"]);
	$connection = new PDO("$dsn", $username, $password, $options);
	$sth = $connection->prepare('select c.description, CONCAT(street, \' \', street_number) as home from cat c left join event e on c.id = e.cat_id where c.id = :id and (e.type = \'HOME\' or e.type is null) order by e.id desc limit 1');
	$sth->bindParam(':id', $id, PDO::PARAM_INT);
	$sth->execute();
	$row = $sth->fetch();
	$description = $row['description'];
	$home = $row['home'];
	
	$sth = $connection->prepare('select GROUP_CONCAT(description ORDER BY owner desc, id desc SEPARATOR \', \') as names from event where cat_id = :id and deleted = false and type = \'NAME\' order by id');
	$sth->bindParam(':id', $id, PDO::PARAM_INT);
	$sth->execute();
	$row = $sth->fetch();
	$names = $row['names'];
	
	$uniqueName = str_pad($id, 10, "0", STR_PAD_LEFT);
	
    if(file_exists ("upload/" . $uniqueName . ".jpg")){ ?>
     <p><a href="index.php"><img src="upload/<?php echo $uniqueName . '.jpg';?>" border="0"></a></p>
<?php } else { ?>
     <p>kein Bild</p>
<?php } 

    $sth = $connection->prepare("select cat_related, GROUP_CONCAT(sub_type SEPARATOR ', ') as sub_type from ((select cat_id as cat_related, concat('bei dieser als ', sub_type , ' bekannt') as sub_type from event where cat_related = :id and deleted = false) union (select cat_related, concat('ist hier ', sub_type) as sub_type from event where cat_id = :id and deleted = false)) c where c.cat_related is not null and c.cat_related <> :id group by cat_related");
	$sth->bindParam(':id', $id, PDO::PARAM_INT);
    if ($sth->execute()) {
		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
			$uniqueName = str_pad($row['cat_related'], 10, "0", STR_PAD_LEFT);
	        ?>
			<a href="cat.php?id=<?php echo $row['cat_related'];?>"><img title="<?php echo htmlentities($row['sub_type']);?>" src="upload/<?php echo $uniqueName . '_tn.jpg';?>" border="0"></a>
			<?php		
		}		
	}

	$sth = $connection->prepare('select id, created, street, street_number, description, owner from event where cat_id = :id and type = \'UPDATE\' and sub_type in (\'bild\',\'beides\') and deleted = false order by created desc limit 5');
	$sth->bindParam(':id', $id, PDO::PARAM_INT);
    if ($sth->execute()) {
		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
		
		$idEvent = $row['id'];
		$uniqueNameEvent = str_pad($idEvent, 10, "0", STR_PAD_LEFT);
?>
        <a href="upload/<?php echo $uniqueNameEvent . 'E.jpg';?>"><img src="upload/<?php echo $uniqueNameEvent . 'E_tn.jpg';?>" border="0"></a>
<?php
		}
	}	
?>
</br>
<p>Katze Nr. <?php echo $id;?> wird genannt: <?php echo htmlentities($names);?></p>
<p><?php echo htmlentities($home);?></p>
<p><?php echo htmlentities($description);?></p>
<p><a href="catEdit.php?id=<?php echo $id;?>">Update Image and Description</a></p>
<p><a href="events.php?catId=<?php echo $id;?>">Alle Ereignisse verwalten</a></p>
<p><a href="index.php">Startseite</a></p>


</br>
</br>
<h2>Revier</h2>
<table>
<?php
	$sth = $connection->prepare('select created, street, street_number, description, owner from event where cat_id = :id and type = \'HOME\' and deleted = false order by created desc limit 5');
	$sth->bindParam(':id', $id, PDO::PARAM_INT);
    if ($sth->execute()) {
		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
		
		if($street == null){
		 $street = $row['street'];
		 $streetNumber = $row['street_number'];
		}
?>
         <tr>
		 <td><?php echo $row['created'];?></td>
		 <td><?php echo htmlentities($row['street']);?></td>
		 <td><?php echo htmlentities($row['street_number']);?></td>
		 <td><?php echo htmlentities($row['description']);?></td>
		 <td><?php echo htmlentities($row['owner']);?></td>
		 </tr>
<?php
		}
	}	
?>
</table>
</br>
<form name="form1" method="post" action="eventCreate.php" enctype="multipart/form-data">
	 <label>Wohnt im Revier (Strasse, Nummer) <input type="text" name="street" id="street" value="<?php echo htmlentities($street);?>">, 
	 <input type="text" name="streetNumber" id="streetNumber" value="<?php echo htmlentities($streetNumber);?>"></label>
	 <label>als <input type="text" size="33" name="description" id="description" value=""></label>
	 <label>Ich bin der Besitzer <input type="checkbox" name="owner" checked /></label>
	 <input type="hidden" name="catId" id="catId" value="<?php echo $id;?>">
     <input type="hidden" name="catRelated" id="catRelated" value="">
     <input type="hidden" name="type" id="type" value="HOME">	 
	 <input name="btnSubmit" type="submit" value="Erstelle Zuhause">
</form>

</br>
</br>
<h2>Wird genannt</h2>
<table>
<?php
	$sth = $connection->prepare('select created, street, street_number, description, owner from event where cat_id = :id and type = \'NAME\' and deleted = false order by created desc limit 5');
	$sth->bindParam(':id', $id, PDO::PARAM_INT);
    if ($sth->execute()) {
		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
?>
         <tr>
		 <td><?php echo $row['created'];?></td>
		 <td><?php echo htmlentities($row['street']);?></td>
		 <td><?php echo htmlentities($row['street_number']);?></td>
		 <td><?php echo htmlentities($row['description']);?></td>
		 <td><?php echo htmlentities($row['owner']);?></td>
		 </tr>
<?php
		}
	}	
?>
</table>
</br>
<form name="form1" method="post" action="eventCreate.php" enctype="multipart/form-data">
	 <label>Wird im Revier (Strasse, Nummer) <input type="text" name="street" id="street" value="<?php echo htmlentities($street);?>">, 
	 <input type="text" name="streetNumber" id="streetNumber" value="<?php echo htmlentities($streetNumber);?>"></label>
	 <label> so gerufen: <input type="text" size="33" name="description" id="description" value=""></label>
	 <label>Ich bin der Besitzer <input type="checkbox" name="owner" checked /></label>
	 <input type="hidden" name="catId" id="catId" value="<?php echo $id;?>">
     <input type="hidden" name="catRelated" id="catRelated" value="">
     <input type="hidden" name="type" id="type" value="NAME">	 
	 <input name="btnSubmit" type="submit" value="Erstelle Name">
</form>

</br>
</br>
<h2>Notruf</h2>
<table>
<?php
	$sth = $connection->prepare('select created, street, street_number, sub_type, description, owner from event where cat_id = :id and type = \'MISSED\' and deleted = false order by created desc limit 5');
	$sth->bindParam(':id', $id, PDO::PARAM_INT);
    if ($sth->execute()) {
		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
		
		if($street == null){
		 $street = $row['street'];
		 $streetNumber = $row['street_number'];
		}
?>
         <tr>
		 <td><?php echo $row['created'];?></td>
		 <td><?php echo htmlentities($row['sub_type']);?></td>
		 <td><?php echo htmlentities($row['street']);?></td>
		 <td><?php echo htmlentities($row['street_number']);?></td>
		 <td><?php echo htmlentities($row['description']);?></td>
		 <td><?php echo htmlentities($row['owner']);?></td>
		 </tr>
<?php
		}
	}	
?>
</table>
</br>
<form name="form1" method="post" action="eventCreate.php" enctype="multipart/form-data">
	 <select name="subType" size="1"><option>verschwunden</option><option>aufgetaucht</option><option>verstorben</option></select>
	 im Revier <input type="text" name="street" id="street" value="<?php echo htmlentities($street);?>">, 
	 <input type="text" name="streetNumber" id="streetNumber" value="<?php echo htmlentities($streetNumber);?>"> 	 
	 <label>Kontakt: <input type="text" size="33" name="description" id="description" value=""></label>
	 <label>Ich bin der Besitzer <input type="checkbox" name="owner" checked /></label>
	 <input type="hidden" name="catId" id="catId" value="<?php echo $id;?>">
     <input type="hidden" name="catRelated" id="catRelated" value="">
     <input type="hidden" name="type" id="type" value="MISSED">	 
	 <input name="btnSubmit" type="submit" value="Erstelle Notruf">
</form>

</br>
</br>
<h2>Fremde Katze im Revier</h2>
<table>
<?php
	$sth = $connection->prepare('select cat_related, created, street, street_number, sub_type, description, owner from event where cat_id = :id and type = \'VISIT\' and deleted = false order by created desc limit 5');
	$sth->bindParam(':id', $id, PDO::PARAM_INT);
    if ($sth->execute()) {
		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
		
		if($street == null){
		 $street = $row['street'];
		 $streetNumber = $row['street_number'];
		}
?>
         <tr>
		 <td><?php echo $row['created'];?></td>
		 <td><a href="cat.php?id=<?php echo htmlentities($row['cat_related']);?>">Katze <?php echo htmlentities($row['cat_related']);?></a> ist</td>
		 <td><?php echo htmlentities($row['sub_type']);?> in der</td>
		 <td><?php echo htmlentities($row['street']);?></td>
		 <td><?php echo htmlentities($row['street_number']);?></td>
		 <td><?php echo htmlentities($row['description']);?></td>
		 <td><?php echo htmlentities($row['owner']);?></td>
		 </tr>
<?php
		}
	}	
?>
</table>
</br>
<form name="form1" method="post" action="eventCreate.php" enctype="multipart/form-data">
	 <a href="catSelect.php?id=<?php echo trim($_GET["id"]);?>">Die Katze Nr. 
     <?php 
	 	 if(!isset($_GET["catRelated"]))
			 $catRelated = "???";
		 else
			 $catRelated = trim($_GET["catRelated"]);
	 
		 echo $catRelated;
	 ?>
	 </a> <input type="hidden" size="5" name="catRelated" id="catRelated" readonly value="<?php echo trim($_GET["catRelated"]);?>">
	 <label> ist <select name="subType" size="1">
	 <option value="Fremdesser">Fremdesser</option>
	 <option value="Kumpel">Kumpel</option>
	 <option value="Besucher">Besucher</option>
	 <option value="eimalig aufgetaucht">eimalig aufgetaucht</option>
	 <option value="geduldet" selected>geduldet im Revier</option>
	 <option value="Konkurrent">Konkurrent</option>
	 </select></label>
	 <input type="hidden" name="street" id="street" value="<?php echo htmlentities($street);?>">
	 <input type="hidden" name="streetNumber" id="streetNumber" value="<?php echo htmlentities($streetNumber);?>"> 	 
	 <label>Sonstiges: <input type="text" size="33" name="description" id="description" value=""></label>
     <input type="hidden" name="owner" />
	 <input type="hidden" name="catId" id="catId" value="<?php echo $id;?>">
     <input type="hidden" name="type" id="type" value="VISIT">	 
	 <input name="btnSubmit" type="submit" value="Erstelle Besucher">
</form>


</br>
</br>
<h2>Twitter</h2>
<table>
<?php
	$sth = $connection->prepare('select created, description, owner from event where cat_id = :id and type = \'TWITTER\' and deleted = false order by created desc limit 5');
	$sth->bindParam(':id', $id, PDO::PARAM_INT);
    if ($sth->execute()) {
		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
?>
         <tr>
		 <td><?php echo $row['created'];?></td>
		 <td><?php echo htmlentities($row['description']);?></td>
		 <td><?php echo htmlentities($row['owner']);?></td>
		 </tr>
<?php
		}
	}	
?>
</table>
</br>
<form name="form1" method="post" action="eventCreate.php" enctype="multipart/form-data">
	 <label>Will aus dem Revier (Strasse, Nummer) <input type="text" name="street" id="street" value="<?php echo htmlentities($street);?>"> 
	 <input type="text" name="streetNumber" id="streetNumber" value="<?php echo htmlentities($streetNumber);?>"></label>
	 <label>bekanntgeben dass, <input type="text" size="33" maxlength="250" name="description" id="description" value=""></label>
	 <label>Ich bin der Besitzer <input type="checkbox" name="owner" checked /></label>
	 <input type="hidden" name="catId" id="catId" value="<?php echo $id;?>">
     <input type="hidden" name="catRelated" id="catRelated" value="">
     <input type="hidden" name="type" id="type" value="TWITTER">	 
	 <input name="btnSubmit" type="submit" value="Erstelle Nachricht">
</form>
<h1><?php echo $_GET["message"];?></h1>
</body>
</html>