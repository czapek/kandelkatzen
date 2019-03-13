<?php
    require "header.php";
?>

<html>
<head>
<title>Upload Resize to MySQL</title>
</head>
<body>


<?php
    require "config.php";    

	$connection = new PDO("$dsn", $username, $password, $options);
	$sql = "select c2.created, c2.id, c2.description,  CONCAT(h.street, \" \", h.street_number) as home from cat c2 left join 
(select * from event where id in
(select max(e.id) from cat c inner join event e on c.id = e.cat_id where c.deleted = false and e.deleted = false and type = 'HOME' group by cat_id)) h on h.cat_id=c2.id
where c2.deleted = false
order by ISNULL(type), street, convert(street_number, int), c2.created desc";	
?>

<h2><?php echo $_GET["message"];?></h2>

<table width="200" border="1">
<tr>
<th> <div align="center">Datum</div></th>
<th> <div align="center">Beschreibung</div></th>
<th> <div align="center">Wohnhaft</div></th>
<th> <div align="center">Katze</div></th>
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
     <a href="cat.php?id=<?php echo $row['id']; ?>"><img src="upload/<?php echo $uniqueName . '_tn.jpg';?>"></a>
<?php } else { ?>
     <a href="cat.php?id=<?php echo $row['id']; ?>">kein Bild</a>
<?php } ?>

</td>
</tr>
<?php
	}
?>

</table>


<br>
<a href="catEdit.php">Neue Katze</a>
</body>
</html>

