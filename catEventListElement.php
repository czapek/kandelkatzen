<?php
	if ($sth->execute()) {
		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
		 $uniqueName = str_pad($row['id'], 10, "0", STR_PAD_LEFT);
?>
<hr>
<h4 class="heading"><?php echo formatDate($row['created']);?></h4>
<table style="margin-bottom: 20px;">
<tr><td>
<?php if(file_exists ("upload/" . $uniqueName . ".jpg")){ ?>
     <a href="cat.php?id=<?php echo $row['id']; ?>"><img src="upload/<?php echo $uniqueName . '_tn.jpg';?>" style="border: 3px solid;"></a>
<?php } else { ?>
    <a href="cat.php?id=<?php echo $row['id']; ?>"><img width="150px" src="img/simonsCat.gif" style="border: 3px solid;"></a>
<?php } ?>
</td><td style="vertical-align: top; padding-left:10px;">

<?php echo htmlentities($row['type']);?>: <?php echo htmlentities($row['home']);?> <?php echo htmlentities($row['description']);?></br>

</td></tr>
</table>
<?php
	}
}
?>	
<hr>