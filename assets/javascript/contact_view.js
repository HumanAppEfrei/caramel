/* javascript lié aux vues contact (create,edit,search)*/

function ClearChilds(elem)
{
	while(elem.firstChild){
	elem.removeChild(elem.firstChild);
	}; 
} 

function SetOption(elem, options)
{	
	ClearChilds(elem);
	
	for( var cpt=0; cpt<options.length; cpt++)
	{
		var newOption = document.createElement('option');
		var newOptionText = document.createTextNode(options[cpt]);
		newOption.value = options[cpt];
		
		newOption.appendChild(newOptionText);
		elem.appendChild(newOption);
	}
} 

function ManageType(Options_morale,Options_physique)
{	
var typeP = document.getElementById('type');	
	var typeC = document.getElementById('typeC');

		var naissance = document.getElementById('naissance');
		var cache = document.getElementById('cachecache');	
		var nom = document.getElementById('nom');

		if(typeP.options[typeP.selectedIndex].value == "physique") //cas personne physique
		{	
			var tmp = "Donateur,Prospect";
			if(Options_physique) tmp = tmp+","+Options_physique;
			SetOption(typeC,tmp.split(","));
			naissance.style.visibility='visible';
			cache.style.visibility='visible';
			
			nom.innerHTML = "Nom* :";
		
		}else {												  //cas personne morale
			
			var tmp = "Entreprise,ONG,Association";
			if(Options_morale) tmp = tmp+","+Options_morale;
			SetOption(typeC,tmp.split(","));
			SetOption(typeC,new Array("Entreprise", "ONG", "Association"));
			
			//on cache civilité, prénom et date de naissance :
			naissance.style.visibility='hidden';
			cache.style.visibility='hidden';
			
			nom.innerHTML = "Raison Sociale* :";
		}
}

	ManageType(Options_morale,Options_physique);
	var Type = document.getElementById('type');
	
	Type.addEventListener('change', function() {
		ManageType(Options_morale,Options_physique);
	},true);
	
	
//gestion dynamique choix envoi RF :
	if($("#rf_type option:selected").val() == "never")
	{
		$("#rf_envoi").hide();
	}
	$("#rf_type").change( function() {
	
	if($("#rf_type option:selected").val() == "never")
	{
		$("#rf_envoi").hide();
	}else{
		$("#rf_envoi").show();
	}
	}); 
	
	function DuplicateProposal(URL_ajax)
	{
		var firstname;
		var lastname;
		var tel_fixe;
		var tel_port;
		var email;
		
		
		if(document.getElementById("firstname") == null)
		{
			firstname="";
		}else{
			firstname=document.getElementById("firstname").value;
		}
		
		if(document.getElementById("lastname") == null)
		{
			lastname="";
		}else{
			lastname=document.getElementById("lastname").value;
		}
		
		if(document.getElementById("telFixe") == null)
		{
			tel_fixe="";
		}else{
			tel_fixe=document.getElementById("telFixe").value;
		}
		
		if(document.getElementById("telPort") == null)
		{
			tel_port="";
		}else{
			tel_port=document.getElementById("telPort").value;
		}
		
		if(document.getElementById("email") == null)
		{
			email="";
		}else{
			email=document.getElementById("email").value;
		}
		
		var form_data = {
		lastname : lastname,
		firstname : firstname,
		tel_fixe : tel_fixe,
		tel_port : tel_port,
		email : email,
		ajax : '1'
		};
		
		//requete ajax 1
		var req= $.ajax({
		url : URL_ajax,
		type : 'POST',
		dataType : 'html',
		async : false,
		data : form_data,
		success: function(data){$("#list_doublons").html(data);}
		});
			
	}
	
if (typeof (URL_ajax) != 'undefined') {

	var famille_text=document.getElementById('lastname');
	var nom_text=document.getElementById('firstname');
	var tel_fixe=document.getElementById('telFixe');
	var tel_port=document.getElementById('telPort');
	var email=document.getElementById('email');
	
	famille_text.addEventListener('change', function() {
	DuplicateProposal(URL_ajax);
	},true);
	nom_text.addEventListener('change', function() {
	DuplicateProposal(URL_ajax);
	},true);
	tel_fixe.addEventListener('change', function() {
	DuplicateProposal(URL_ajax);
	},true);
	tel_port.addEventListener('change', function() {
	DuplicateProposal(URL_ajax);
	},true);
	email.addEventListener('change', function() {
	DuplicateProposal(URL_ajax);
	},true);
	
}