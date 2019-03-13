<?php
    require "header.php";
    require "config.php";	
	
	$connection = new PDO("$dsn", $username, $password, $options);
	
	$sql = "drop table event";	
	$sth = $connection->prepare($sql);
	$sth->execute();	
	
	$sql = "drop table cat";	
	$sth = $connection->prepare($sql);
	$sth->execute();	
	
	
	$sql = "CREATE TABLE cat (	
	id int unsigned NOT NULL AUTO_INCREMENT,
	created DATETIME NOT NULL,
	description VARCHAR(500) NOT NULL,
	ip VARCHAR(50) NOT NULL,
	deleted BOOLEAN NOT NULL DEFAULT FALSE,
	PRIMARY KEY (id)
)";	
	$sth = $connection->prepare($sql);
	$sth->execute();	
	
	$sql = "CREATE TABLE event (	
	id int unsigned NOT NULL AUTO_INCREMENT,
	cat_id int unsigned not null,
	cat_related int unsigned null,
	created DATETIME NOT NULL,
	type VARCHAR(50) NOT NULL,
	sub_type VARCHAR(50) NULL,
	street VARCHAR(250) NOT NULL,
	street_number VARCHAR(50) NOT NULL,
	description VARCHAR(500) NOT NULL,
	owner BOOLEAN NOT NULL DEFAULT FALSE,
	ip VARCHAR(50) NOT NULL,
	deleted BOOLEAN NOT NULL DEFAULT FALSE,
	PRIMARY KEY (id),
	FOREIGN KEY (cat_id) REFERENCES cat(id) ON DELETE CASCADE,
	FOREIGN KEY (cat_related) REFERENCES cat(id) ON DELETE CASCADE
)";	
	$sth = $connection->prepare($sql);
	$sth->execute();	
	
	$sql = "CREATE INDEX idx_event_location ON event(street, street_number, type)";	
	$sth = $connection->prepare($sql);
	$sth->execute();	
		
 	$sql = "CREATE INDEX idx_event_cat_related ON event(cat_related)";	
	$sth = $connection->prepare($sql);
	$sth->execute();	
		
	$sql = "CREATE INDEX idx_event_cat_id ON event(cat_id)";	
	$sth = $connection->prepare($sql);
	$sth->execute();	
		
          
	
?>

