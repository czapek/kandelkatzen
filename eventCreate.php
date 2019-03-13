<?php
    require "header.php";
    require "config.php";	
	$message = "Ereignis aus unbekannten Gründen nicht angelegt";	
	
    if (isset($_POST['type']) && strlen ($_POST['type']) > 0) {
        $catId = trim($_POST['catId']);   		
		
		if (isset($_POST['catRelated']) && strlen ($_POST['catRelated']) > 0)		
		    $catRelated = trim($_POST['catRelated']);		
		
		if (isset($_POST['subType']) && strlen ($_POST['subType']) > 0)		
		    $subType = trim($_POST['subType']);
	
		$type = trim($_POST['type']); 
		$street = trim($_POST['street']); 
		$streetNumber = trim($_POST['streetNumber']); 
		$description = trim($_POST['description']);
		$owner = empty($_POST['owner']) ? 0 : 1;
				
		try{
			$connection = new PDO("$dsn", $username, $password, $options);
			
			$sth = $connection->prepare('INSERT INTO event (cat_id, cat_related, type, sub_type, street, street_number, description, owner, created, ip) VALUES (:catId, :catRelated, :type, :subType, :street, :streetNumber, :description, :owner, now(), :ip)');
				$sth->bindParam(':catId', $catId, PDO::PARAM_INT);
				$sth->bindParam(':catRelated', $catRelated, PDO::PARAM_INT);
				$sth->bindParam(':type', $type, PDO::PARAM_STR, 50);
				$sth->bindParam(':subType', $subType, PDO::PARAM_STR, 50);
				$sth->bindParam(':street', $street, PDO::PARAM_STR, 250);
				$sth->bindParam(':streetNumber', $streetNumber, PDO::PARAM_STR, 50);
				$sth->bindParam(':description', $description, PDO::PARAM_STR, 500);
				$sth->bindParam(':owner', $owner, PDO::PARAM_BOOL);
				$sth->bindParam(':ip', getRealIpAddr(), PDO::PARAM_STR, 50);
				$sth->execute();	
 
            $message = "Ereignis erfolgreich angelegt";				
	
		 }catch(PDOException $exception){ 
            $message = $exception->getMessage();
		 } 	
	}else{
		$message = "Typ ist Pflichtfeld";
	}
	
	print '<script type="text/javascript">window.top.location.href = "cat.php?id=' . $catId . '&message=' . urlencode ($message) . '";</script>';	
?>

