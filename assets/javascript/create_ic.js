/* javascript lié à la vue d'ajout de critere à un segment */

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
	
	var type = document.getElementById('type');
	
	type.addEventListener('change', function() {
	
	var spanEx = document.getElementById('exemple');
	ClearChilds(spanEx);
	
	var Emp_choix = document.getElementById('Emplacement_choixlist');
	ClearChilds(Emp_choix);
	
	   // traitement des differentes possibilités
		switch (type.options[type.selectedIndex].value)
		{
			case "texte":
				//modif balise d'exemple
				var newInput = document.createElement("input");
				newInput.type = "text";
				newInput.name = "ex";
				newInput.placeholder = "text";
				spanEx.appendChild(newInput);
			break;
			
			case "liste":
				//modif balise d'exemple
				var newInput = document.createElement("select");
				newInput.name = "ex";
				newInput.placeholder = "text";
				SetOption(newInput,new Array("choix1","choix2","choix3"));
				spanEx.appendChild(newInput);
				
				//ajout d'une entrée pour récupérer les options
				var choixlist = document.getElementById('Emplacement_choixlist');
				var newInput = document.createElement("input");
				newInput.type = "text";
				newInput.id = "choix";
				newInput.placeholder = "option1,option2,option3,...";
				choixlist.innerHTML += "Options du champs : ";
				choixlist.appendChild(newInput);
				
			break;
			
			case "checkbox":
				//modif balise d'exemple
				var newInput = document.createElement("input");
				newInput.type = "checkbox";
				newInput.name = "ex";
				newInput.checked= true;
				spanEx.appendChild(newInput);
			break;
			
		}
		  
		  
	}, true);

	var form = document.getElementById('form');
	
	form.addEventListener('submit',function(e) {
	
	var type = document.getElementById('type');
	
	var valhide = document.getElementById('choixlist');
	
	var choix = document.getElementById('choix');

	if(type.value == "liste")
	{
		valhide.value = choix.value;
	}
	
}, true); 