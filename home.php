<?php
    require "htmlHeader.php";
?>	
	<!-- MAIN -->
		<div role="main" id="main" class="cf">
			
			<!-- page-content -->
			<div class="page-content">
			
				
				<!-- entry-content -->	
	        	<div class="entry-content cf">
	        		
	        		<h2 class="heading">Willkommen bei den Kandelkatzen</h2>
	        		<p>Wolltet ihr nicht auch schon immer mal wissen wo sich eure Katze als rumtreibt oder wo die Rumtreiber in eurerm Garten alle herkommen.
					Vielleicht wird ja die ein oder andere Katze sehnlichst vermisst oder ihr macht euch selber Sorgen wo die eigene Katze seit gestern geblieben ist. Vielleicht hält sie ja nur auf nachbars Sofa
					ein ausdauerndes Nickerchen weil die Nacht mal wieder so anstrengend war, dass sie einfach überall einschlafen könnte.</br>
					Hier könnt ihr rund um die Kandelstraße eure Katzenbegenungen mit anderen Teilen und müsst euch in Zukunft vielleicht weniger Sorgen machen ohne gleich zu komplizierten technischen Hilfsmitteln zu greifen.
					Auf der Startseite seht ihr immer 5 neusten Einträge. Vermisstenmeldungen stehen dabei immer an erster Stelle.</p></br>
					
					
<?php
    require "config.php";    

	$connection = new PDO("$dsn", $username, $password, $options);
	$sql = "select c2.created, c2.id, c2.description,  CONCAT(h.street, \" \", h.street_number) as home, n.names from cat c2 
left join (select cat_id, type,  street, street_number from event where id in (select max(e.id) from cat c inner join event e on c.id = e.cat_id where c.deleted = false and e.deleted = false and type = \"HOME\" group by cat_id)) h on h.cat_id=c2.id
left join (select cat_id, GROUP_CONCAT(e.description ORDER BY owner desc, e.id desc SEPARATOR \", \") as names from cat c inner join event e on c.id = e.cat_id where c.deleted = false and e.deleted = false and type = \"NAME\" group by cat_id) n on n.cat_id = c2.id
where c2.deleted = false
order by ISNULL(type), street, convert(street_number, int), c2.created desc";	
?>



<?php
	 foreach ($connection->query($sql) as $row) {
		 $uniqueName = str_pad($row['id'], 10, "0", STR_PAD_LEFT);
?>
<div class="one-half">
<h4 class="heading"><?php echo htmlentities($row['created']);?></h4>
<?php if(file_exists ("upload/" . $uniqueName . ".jpg")){ ?>
     <a href="cat.php?id=<?php echo $row['id']; ?>"><img src="upload/<?php echo $uniqueName . '_tn.jpg';?>"></a>
<?php } else { ?>
     <a href="cat.php?id=<?php echo $row['id']; ?>">kein Bild</a>
<?php } ?>
</div>
<div class="one-half last">
<h4 class="heading"><?php echo htmlentities($row['home']);?></h4>
<p><?php echo htmlentities($row['names']);?><tp>
<p><?php echo htmlentities($row['description']);?></p>
</div>
<?php
	}
?>	
				
										
				</div>
				<!-- ENDS entry-content -->

			</div><!-- ENDS page-content -->
						
		</div>
		<!-- ENDS MAIN -->
			
<?php
    require "htmlFooter.php";
?>						
