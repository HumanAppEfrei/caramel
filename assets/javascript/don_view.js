/* 
 *	Javascript lié aux vues des dons (create, edit et search)
 */

// Gestion des champs supplémentaires de chèque.
if ($("#mode_paiement option:selected").val() != "cheque")
	$("#cheque").hide();

$("#mode_paiement").change(function() {
	if($("#mode_paiement option:selected").val() != "cheque") {
		$("#cheque").hide();
	} else {
		$("#cheque").show();
	}
});

$("form").submit(function() { 
	// Remise à zéro des champs de chèque si nécessaire
	if($("#mode_paiement option:selected").val() != "cheque")
		$("#cheque input[type=text]").val("");
	
	// Alerte en cas d'ofre non sélectionnée
	if($("#offre option:selected").val() == "aucune")
		return window.confirm("Attention, le versement n'a été relié à aucune offre.\nSouhaitez vous continuer ?");
});

// Suppression d'un don de la liste des derniers ajouts
$("button.suppr_don").click( function() { 
	if(!window.confirm('Voulez-vous vraiment supprimer le don #'+$(this).attr("name")+' ?'))
		return false;
	
	$.ajax({
		url: "remove/"+($(this).attr("name"))
		});
		
	$(this).parent().parent().empty();

});


/* *** Flechage *** */

/*
 * @brief Controle les saisie codeDonateur et Montant
 * @return 	true = adherent | false = n'existe pas | nb = doit cotiser nb
 */
function check_con(){
    var codeCon = $("#codeCon").val();
	var montant_saisi = $('#montant').val();
	
	//verifier contact existe ? adherent ?
	if (codeCon != '') {
		var controller = 'don';
		$.ajax({
			url : $("#base_url").val() + '/' + controller + '/check_con',
			type: 'POST',
			data : {
				'codeCon' : codeCon
				},
			success : function(data) {
				if (data) {
					if (data == 'true') {
						if (montant_saisi != '') {
						//adherent
						delAllFleche();
						//generer avec montant
						generate_flech('donation', montant_saisi);
						check_attr();
						} else {
							//message erreur
							$("#msg_flech").html("Veuillez saisir un montant.");
						}
					} else if (data == 'false') {
						//message erreur
						$("#msg_codeCon").html("Veuillez saisir un bon code donateur.");
					} else {
						//doit cotiser data
						//comparer montant saisi et montant a cotiser
						if(montant_saisi != ''){
							if (parseFloat(montant_saisi) > data) {
								delAllFleche();
								//coti+don
								generate_flech('cotisation', data);
								generate_flech('donation', montant_saisi-data);
							} else {
								delAllFleche();
								//coti
								generate_flech('cotisation', montant_saisi);
							}
							check_attr();
						}else{
							//message erreur
							$("#msg_flech").html("Veuillez saisir un montant.");
						}
					}
				}
			},
			error:function(data){ alert(data); }
		});
	}
}

/*
 * @brief Action du focus out sur code Donateur ou Montant
 */
$("#codeCon, #montant").focusout(check_con);

var idFlech=0;

/*
 * @brief Génération d'un fléchage au clique "ajouter"
 */
$("#addFlechage").click(function(){
	var montant = document.getElementsByName('montant')[0].value;
	
	if(montant!=''){
		generate_flech();
		
	}else{
		//message d'erreur
		//document.getElementById("msg_flech").innerHTML="Veuillez saisir un montant valide.";
		$("#msg_flech").html("Veuillez saisir un montant valide.");
	}
});
		
/*
 * @brief Personnaliser le fléchage
 * @param type : le type de fléchage
 * @param montant : le montant par défaut pour le fléchage
 */
 function generate_flech(type, montant){
	type = typeof type !== 'undefined' ? type : 'donation';
	montant = typeof montant !== 'undefined' ? montant : 0;
	
	//personnalisation input montant
	var select = '<select name="flechage['+idFlech+']" >';
	var input_montant = '<input class="form-control montant_attr" name="montant_flechage[]" placeholder="Montant"  onfocusout="check_attr()"/>';
	if(montant != 0){
		input_montant = '<input class="form-control montant_attr" name="montant_flechage[]" value="'+montant+'" placeholder="Montant" onfocusout="check_attr()"/>';
	}
	
	//personnalisation selection
	switch(type){
		case 'cotisation':
			option = '<option value="cotisation" selected >Cotisation</option>\
						 <option value="donation" >Donation</option>\
						 <option value="achat" >Achat</option>\
						 <option value="offre" >Offre</option>\
						 <!--Projet et ces sous liste-->\
						 <option value="projet" >Projet</option>';
		break;
		case 'donation':
			option = '<option value="cotisation" >Cotisation</option>\
						 <option value="donation" selected>Donation</option>\
						 <option value="achat" >Achat</option>\
						 <option value="offre" >Offre</option>\
						 <!--Projet et ces sous liste-->\
						 <option value="projet" >Projet</option>';
		break;
		default:
		break;
	}
	build_flech(input_montant,option);
 }
 
 
 /*
  *  @brief construire le fléchage
  */
 function build_flech(input,option){
	$( "#addFlechBlock" ).append('<div class="flechage" id="attr_'+idFlech+'"> \
					<span class="sr-only">Montant : </span>'+input+
					'<span class="sr-only">Fléchage : </span>\
					<select name="flechage['+idFlech+']" >'+option+
					'</select>	\
				<a name="annuler_flech'+idFlech+'" onClick="delFleche(\'addFlechBlock\',\'flech_'+idFlech+'\')">Annuler </a>\
				<input name ="idFlech_list[]" type="hidden" value= '+idFlech+' " /> \
				</div>');

	console.log($( "#addFlechBlock p:last-child" ));
	$( "#addFlechBlock .flechage:last-child" ).attr('id','flech_'+idFlech);
	idFlech++;
	// document.getElementById("msg_flech").innerHTML=""; 
	$("#msg_flech").html(""); 
 }
		
/*
 * @brief Vérifie la validité du fléchage
 */
function check_attr(){
	var attr_montants = document.getElementsByName('montant_flechage[]');
	var don_montant = parseInt(document.getElementsByName('montant')[0].value);
	var montant=0;
	
	for(var i=0; i<attr_montants.length; i++){
		if(attr_montants[i].value!=''){
			montant+=parseInt(attr_montants[i].value);
		}
	}
	
	if(montant> don_montant){
		alert("Attention la somme des montants du fléchage dépasse celui du montant du don");
		document.getElementById("sauvegarder").disabled=true;
		document.getElementsByName("flech_valide")[0].value="false";
		// document.getElementById("msg_save").innerHTML=(montant-don_montant)+" euro(s) fléché en trop.";
		$("#msg_save").html((montant-don_montant)+" euro(s) fléchés en trop.");
	}else if(montant<don_montant){
		document.getElementById("sauvegarder").disabled=true;
		document.getElementsByName("flech_valide")[0].value="false";
		// document.getElementById("msg_save").innerHTML="Vous avez encore "+(don_montant-montant)+"euro(s) à flécher.";
		$("#msg_save").html("Vous avez encore "+(don_montant-montant)+"euro(s) à flécher.");
	}else{
		document.getElementById("sauvegarder").disabled=false;
		document.getElementsByName("flech_valide")[0].value="true";
		$("#msg_save").html("");
	}
}
		
/*
 * @brief Supprimer une fleche
 */
function delFleche(parent, child){
	var obj = document.getElementById(parent);
	var old = document.getElementById(child);
	
	obj.removeChild(old);
	check_attr();
}

/*
 * @brief Supprimer tout le flechage
 */
 function delAllFleche(){
	var obj = document.getElementById('addFlechBlock');
	var fleches = document.getElementsByName('idFlech_list[]');
	for(var i=0; i<fleches.length; ++i){
			var old = document.getElementById('flech_'+fleches[i].value);
			obj.removeChild(old);
	}
}