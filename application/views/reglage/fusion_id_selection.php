<div class="well" id="fusion_id_selection"><h2>Dédoublonnage Manuel</h2>


	<pretty>
		<p>
			Pour fusionner les données d\'un doublon de contacts, veuillez entrer les deux IDs concernés ci dessous :
		</p>

		<form method="post" <?php echo ('action="'.site_url("admin/dedoublonnage").'"'); ?> onsubmit="return verif_form(this);">
		<!-- <form method="post" action="./dedoublonnage"> -->
			<p>
				<input type="text" name="ID1" id="ID1" placeholder="Numéro Adhérent 1" required/>
				<input type="text" name="ID2" id="ID2" placeholder="Numéro Adhérent 2" required/>
				<input type="reset" value="Vider les champs" />
				
			</p>
			
			<?php
				if(isset($Test_ID1)&&isset($Test_ID2))
				{
					if($Test_ID1==false) echo('<p><strong>Le numéro d\'adhérent '.$ID1.' est inexisant !</strong></p>');
					if($Test_ID2==false) echo('<p><strong>Le numéro d\'adhérent '.$ID2.' est inexisant !</strong></p>');
				}
				
				if(isset($contact_ID)&&isset($old_contact_ID))
				{
					echo('<p><strong>Les contacts '.$contact_ID.' et '.$old_contact_ID.' ont bien été fusionné sous l\'identifiant '.$contact_ID.'</strong></p>');
				}
			?>
			
			<input name= "is_form_sent1" type="hidden" value="true">
		   <!--<input type="submit" value="Envoyer" >-->
		   <button type="submit" class="btn">Fusionner</button>
		   
		</form>
					
	</pretty>
	
	<script LANGUAGE="Javascript">//type="text/javascript"
		<!--
		 
		   function verif_form(f)
			{
			   var id1 =document.getElementById("ID1").value;
			   var id2 =document.getElementById("ID2").value;
			  
			   if(id1==id2)
			   {
					alert("Les 2 identifiants sont identiques ! ");
					return false;
				}
				else{
					return true;
				}
			}
		 
		-->
	</script>

</div>