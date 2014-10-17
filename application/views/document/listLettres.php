
<?php foreach( $lettres as $lettre)
{ ?>

	<option value="<?php echo  $lettre->LET_ID ;?>" ><?php echo  $lettre->LET_NAME ;?></option>

	<?php } ?>