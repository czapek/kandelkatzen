<?php
    require "header.php";
    require "config.php";	
	
	$message = "Katze aus unbekannten Gründen nicht angelegt";	
    if (isset($_POST['description']) && strlen ($_POST['description']) > 0) {
		
		try{
			$description = trim($_POST['description']);   
			$connection = new PDO("$dsn", $username, $password, $options);
			
			if (isset($_POST['id'])) {
				$id = trim($_POST['id']);  
				$deleted = empty($_POST['deleted']) ? 0 : 1;
				
				$sth = $connection->prepare('select description from cat where id = :id');
				$sth->bindParam(':id', $id, PDO::PARAM_INT);
				$sth->execute();
				$row = $sth->fetch();
				$descriptionOld = $row['description'];
				
				$sth = $connection->prepare('UPDATE cat set description = :description, deleted = :deleted where id = :id');
				$sth->bindParam(':description', $description, PDO::PARAM_STR, 500);
				$sth->bindParam(':id', $id, PDO::PARAM_INT);
				$sth->bindParam(':deleted', $deleted, PDO::PARAM_BOOL);
				$sth->execute();	

                $uniqueName = str_pad($id, 10, "0", STR_PAD_LEFT);
                $uniqueFilename = $uniqueName . ".jpg";				
					
				if(file_exists ("upload/".$uniqueFilename) && ($descriptionOld != $description || trim($_FILES["fileUpload"]["tmp_name"]) != ""))
			    {
					$street = "";
					$streetNumber = "";
					$type = "UPDATE";
							
					if($descriptionOld != $description && trim($_FILES["fileUpload"]["tmp_name"]) != "")
						$subType = "beides";
					else if($descriptionOld != $description)
						$subType = "beschreibung";
					else
						$subType = "bild";
					
					$sth = $connection->prepare('INSERT INTO event (cat_id, type, sub_type, street, street_number, description, created, ip) VALUES (:catId, :type, :subType, :street, :streetNumber, :description, now(), :ip)');
					$sth->bindParam(':catId', $id, PDO::PARAM_INT);
					$sth->bindParam(':type', $type, PDO::PARAM_STR, 50);
					$sth->bindParam(':subType', $subType, PDO::PARAM_STR, 50);
					$sth->bindParam(':street', $street, PDO::PARAM_STR, 250);
					$sth->bindParam(':streetNumber', $streetNumber, PDO::PARAM_STR, 50);
					$sth->bindParam(':description', $descriptionOld, PDO::PARAM_STR, 500);
					$sth->bindParam(':ip', getRealIpAddr(), PDO::PARAM_STR, 50);
					$sth->execute();		
					$idEvent = $connection->lastInsertId();			
					$uniqueNameMove = str_pad($idEvent, 10, "0", STR_PAD_LEFT);				
                }					
			}else{
			    $sth = $connection->prepare('INSERT INTO cat (description, created, ip) VALUES (:description, now(), :ip)');
				$sth->bindParam(':description', $description, PDO::PARAM_STR, 500);
				$sth->bindParam(':ip', getRealIpAddr(), PDO::PARAM_STR, 50);
				$sth->execute();
				$id = $connection->lastInsertId(); 
			}
			
			$uniqueName = str_pad($id, 10, "0", STR_PAD_LEFT);	
		
			if(trim($_FILES["fileUpload"]["tmp_name"]) != "")
			{	
				$uniqueFilenameThumb = $uniqueName . "_tn.jpg";
				$uniqueFilename = $uniqueName . ".jpg";
				
				if($uniqueNameMove != null){
					 $uniqueFilenameThumbMove = $uniqueNameMove . "E_tn.jpg";
				     $uniqueFilenameMove = $uniqueNameMove . "E.jpg";
					 
					 if(file_exists ("upload/".$uniqueFilenameThumb))
					    rename("upload/".$uniqueFilenameThumb, "upload/".$uniqueFilenameThumbMove);
					 if(file_exists ("upload/".$uniqueFilename))
					    rename("upload/".$uniqueFilename, "upload/".$uniqueFilenameMove);			
					
					$sth = $connection->prepare('UPDATE event set sub_type = :subType where id = :id');
					$sth->bindParam(':subType', $subType, PDO::PARAM_STR, 500);
					$sth->bindParam(':id', $idEvent, PDO::PARAM_INT);
					$sth->execute();
				}
				
				$images = $_FILES["fileUpload"]["tmp_name"];
				copy($_FILES["fileUpload"]["tmp_name"],"upload/".$uniqueFilename);

				$size=GetimageSize($images);		
				if($size[0] > $size[1]){		
					$width=150;
					$width2=600;
					$height=round($width*$size[1]/$size[0]);
					$height2=round($width2*$size[1]/$size[0]);
				}else{
					$height=150;
					$height2=600;
					$width=round($height*$size[0]/$size[1]);
					$width2=round($height2*$size[0]/$size[1]);
				}
				$images_orig = ImageCreateFromJPEG($images);
				$photoX = ImagesX($images_orig);
				$photoY = ImagesY($images_orig);
				$images_fin = ImageCreateTrueColor($width, $height);
				$images_fin2 = ImageCreateTrueColor($width2, $height2);
				ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);
				ImageCopyResampled($images_fin2, $images_orig, 0, 0, 0, 0, $width2+1, $height2+1, $photoX, $photoY);
				ImageJPEG($images_fin,"upload/".$uniqueFilenameThumb);
				ImageDestroy($images_orig);
				ImageJPEG($images_fin2,"upload/".$uniqueFilename);			
				ImageDestroy($images_fin);	
				ImageDestroy($images_fin2);
			}   
			$message = "Katze erfolgreich angelegt";	
        }catch(PDOException $exception){ 
            $message = $exception->getMessage();
		} 			
	}else{
		$message = "Beschreibung ist Pflichtfeld";
	}
    print '<script type="text/javascript">window.top.location.href = "cat.php?id=' . $id . '&message=' . urlencode ($message) . '";</script>';
?>

