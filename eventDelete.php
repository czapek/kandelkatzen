<?php
    require "header.php";
    require "config.php";	
	$message = "Ereignis aus unbekannten Gründen nicht angelegt";		
	$catId = trim($_GET["catId"]);	  
	$id = trim($_GET["id"]);	
	
	try{
		$connection = new PDO("$dsn", $username, $password, $options);		
		$sth = $connection->prepare('update event set deleted = not deleted where id = :id');
			$sth->bindParam(':id', $id, PDO::PARAM_INT);
			$sth->execute();	

		$message = "Ereignis erfolgreich bearbeitet";		
	 }catch(PDOException $exception){ 
		$message = $exception->getMessage();
	 } 		
	
	print '<script type="text/javascript">window.top.location.href = "events.php?id=' . $id . '&catId=' . $catId . '&message=' . urlencode ($message) . '";</script>';	
?>

