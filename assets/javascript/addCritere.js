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
	
	var contrainte = document.getElementById('contrainte');
	
	contrainte.addEventListener('change', function() {

	var comparaison = document.getElementById('comparaison');	
	var ElemValeur = document.getElementById('val');	
	
	ClearChilds(ElemValeur); // On vide le champ valeur
	
				
	
	   // traitement des differentes possibilités
	   var CritereSelect = contrainte.options[contrainte.selectedIndex].value;
		switch (CritereSelect)
		{
			case "CON_ID":
				//modif comparaison
				SetOption(comparaison,new Array("=","!="));
				
				//modif valeur
				var newInput = document.createElement("input");
				newInput.type = "text";
				newInput.name = "valeur";
				newInput.id = "valeur";
				ElemValeur.appendChild(newInput);
			break;
			
			case "CON_DATE":
				//modif comparaison
				SetOption(comparaison,new Array("<",">","=","<=",">="));
				
				//modif valeur
				var newInput1 = document.createElement('input');
				newInput1.type = 'text';
				newInput1.name = 'valeurJ';
				newInput1.id = 'valeurJ';
				newInput1.size = 2;
				newInput1.maxlength = "2";
				newInput1.placeholder = 'jj';
				ElemValeur.appendChild(newInput1);
				
				ElemValeur.innerHTML += '/';
				
				var newInput2 = document.createElement('input');
				newInput2.type = 'text';
				newInput2.name = 'valeurM';
				newInput2.id = 'valeurM';
				newInput2.size = 2;
				newInput2.maxlength = "2";
				newInput2.placeholder = 'mm';
				ElemValeur.appendChild(newInput2);
				
				ElemValeur.innerHTML += '/';
				
				var newInput3 = document.createElement('input');
				newInput3.type = 'text';
				newInput3.name = 'valeurA';
				newInput3.id = 'valeurA';
				newInput3.size = 4;
				newInput3.maxlength = "4";
				newInput3.placeholder = 'aaaa';
				ElemValeur.appendChild(newInput3);
			break;
			
			case "CON_TYPE":
				//modif comparaison
				SetOption(comparaison,new Array("=","!="));
				
				//modif valeur
				var newInput = document.createElement('select');
				newInput.name = 'valeur';
				newInput.id = "valeur";
				ElemValeur.appendChild(newInput);
				
				SetOption(newInput,new Array("morale","physique"));
			break;
			
			case "CON_TYPEC":
				//modif comparaison
				SetOption(comparaison,new Array("=","!="));
				
				//modif valeur
				var newInput = document.createElement('select');
				newInput.name = 'valeur';	
				newInput.id = "valeur";
				ElemValeur.appendChild(newInput);
				var tmp = "Donateur,Prospect,Entreprise,ONG,Association,"+Options_type_contact;
				SetOption(newInput,tmp.split(","));
			break;
			
			case "CON_CITY":
				//modif comparaison
				SetOption(comparaison,new Array("=","!="));
				
				//modif valeur
				var newInput = document.createElement('input');
				newInput.type = 'text';
				newInput.name = 'valeur';
				newInput.id = "valeur";
				ElemValeur.appendChild(newInput);
			break;
			
			case "CON_COUNTRY":
				//modif comparaison
				SetOption(comparaison,new Array("=","!="));
				
				//modif valeur
				var newInput = document.createElement('input');
				newInput.type = 'text';
				newInput.name = 'valeur';
				newInput.id = "valeur";
				ElemValeur.appendChild(newInput);
			break;
			
			case "departement":
				//modif comparaison
				SetOption(comparaison,new Array("=","!="));
				
				//modif valeur
				var newInput = document.createElement('input');
				newInput.type = 'text';
				newInput.name = 'valeur';
				newInput.id = "valeur";
				ElemValeur.appendChild(newInput);
				
				ElemValeur.innerHTML += "<br/>(Entrez un numéro de département)";
			break;
			
			case "CON_NPAI":
				//modif comparaison
				SetOption(comparaison,new Array("="));
				
				//modif valeur
				var newInput = document.createElement('select');
				newInput.name = 'valeur';	
				newInput.id = "valeur";
				ElemValeur.appendChild(newInput);
				
				SetOption(newInput,new Array('vrai','faux'));
			break;
			
			case "CON_DATEADDED":
				//modif comparaison
				SetOption(comparaison,new Array("<",">","=","<=",">="));
				
				//modif valeur
				var newInput1 = document.createElement('input');
				newInput1.type = 'text';
				newInput1.name = 'valeurJ';
				newInput1.id = 'valeurJ';
				newInput1.size = 2;
				newInput1.maxlength = "2";
				newInput1.placeholder = 'jj';
				ElemValeur.appendChild(newInput1);
				
				ElemValeur.innerHTML += '/';
				
				var newInput2 = document.createElement('input');
				newInput2.type = 'text';
				newInput2.name = 'valeurM';
				newInput2.id = 'valeurM';
				newInput2.size = 2;
				newInput2.maxlength = "2";
				newInput2.placeholder = 'mm';
				ElemValeur.appendChild(newInput2);
				
				ElemValeur.innerHTML += '/';
				
				var newInput3 = document.createElement('input');
				newInput3.type = 'text';
				newInput3.name = 'valeurA';
				newInput3.id = 'valeurA';
				newInput3.size = 4;
				newInput3.maxlength = "4";
				newInput3.placeholder = 'aaaa';
				ElemValeur.appendChild(newInput3);
			break;
			
			case "dateVersement":
				//modif comparaison
				SetOption(comparaison,new Array("<",">","=","<=",">="));
				
				//modif valeur
				var newInput1 = document.createElement('input');
				newInput1.type = 'text';
				newInput1.name = 'valeurJ';
				newInput1.id = 'valeurJ';
				newInput1.size = 2;
				newInput1.maxlength = "2";
				newInput1.placeholder = 'jj';
				ElemValeur.appendChild(newInput1);
				
				ElemValeur.innerHTML += '/';
				
				var newInput2 = document.createElement('input');
				newInput2.type = 'text';
				newInput2.name = 'valeurM';
				newInput2.id = 'valeurM';
				newInput2.size = 2;
				newInput2.maxlength = "2";
				newInput2.placeholder = 'mm';
				ElemValeur.appendChild(newInput2);
				
				ElemValeur.innerHTML += '/';
				
				var newInput3 = document.createElement('input');
				newInput3.type = 'text';
				newInput3.name = 'valeurA';
				newInput3.id = 'valeurA';
				newInput3.size = 4;
				newInput3.maxlength = "4";
				newInput3.placeholder = 'aaaa';
				ElemValeur.appendChild(newInput3);
			break;
			
			//cas avec code similaire :
			case "NbDon": 
			case "DonMoyen":
			case "TotalDon":
			
				//modif comparaison
				SetOption(comparaison,new Array("<",">","=","<=",">="));
				
				//modif valeur
				var newInput = document.createElement('input');
				newInput.type = 'text';
				newInput.name = 'valeur';
				newInput.id = "valeur";
				ElemValeur.appendChild(newInput);
				
				//gestion periode utilisée pour les statistiques
				ElemValeur.innerHTML += "<br/><br/><strong>Période</strong> :<br/>Du ";
				
				//Date de début :
					var newDayStart = document.createElement('input');
					newDayStart.type = 'text';
					newDayStart.name = 'DateDebutJ';
					newDayStart.id = 'DateDebutJ';
					newDayStart.size = 2;
					newDayStart.maxlength = "2";
					newDayStart.placeholder = 'jj';
					ElemValeur.appendChild(newDayStart);
					
					ElemValeur.innerHTML += '/';
					
					var newMonthStart = document.createElement('input');
					newMonthStart.type = 'text';
					newMonthStart.name = 'DateDebutM';
					newMonthStart.id = 'DateDebutM';
					newMonthStart.size = 2;
					newMonthStart.maxlength = "2";
					newMonthStart.placeholder = 'mm';
					ElemValeur.appendChild(newMonthStart);
					
					ElemValeur.innerHTML += '/';
					
					var newYearStart = document.createElement('input');
					newYearStart.type = 'text';
					newYearStart.name = 'DateDebutA';
					newYearStart.id = 'DateDebutA';
					newYearStart.size = 4;
					newYearStart.maxlength = "4";
					newYearStart.placeholder = 'aaaa';
					ElemValeur.appendChild(newYearStart);
				
				//Date de fin de période :
					ElemValeur.innerHTML += "<br/>Au ";	
					var newDayEnd = document.createElement('input');
					newDayEnd.type = 'text';
					newDayEnd.name = 'DateFinJ';
					newDayEnd.id = 'DateFinJ';
					newDayEnd.size = 2;
					newDayEnd.maxlength = "2";
					newDayEnd.placeholder = 'jj';
					ElemValeur.appendChild(newDayEnd);
					
					ElemValeur.innerHTML += '/';
					
					var newMonthEnd= document.createElement('input');
					newMonthEnd.type = 'text';
					newMonthEnd.name = 'DateFinM';
					newMonthEnd.id = 'DateFinM';
					newMonthEnd.size = 2;
					newMonthEnd.maxlength = "2";
					newMonthEnd.placeholder = 'mm';
					ElemValeur.appendChild(newMonthEnd);
					
					ElemValeur.innerHTML += '/';
					
					var newYearEnd = document.createElement('input');
					newYearEnd.type = 'text';
					newYearEnd.name = 'DateFinA';
					newYearEnd.id = 'DateFinA';
					newYearEnd.size = 4;
					newYearEnd.maxlength = "4";
					newYearEnd.placeholder = 'aaaa';
					ElemValeur.appendChild(newYearEnd);
			break;
			
			case "segment":
				//modif comparaison
				SetOption(comparaison,new Array("compris dans","non compris dans"));
				
				//modif valeur
				ElemValeur.innerHTML = "Entrer un code segment :<br/>";
				
				var newInput = document.createElement('input');
				newInput.type = 'text';
				newInput.name = 'valeur';
				newInput.id = "valeur";
				ElemValeur.appendChild(newInput);
			break;
			
		default: //l'option selectionnée est une info complémentaire
			var reg=new RegExp("[/:,]+", "g");
			var Critere = CritereSelect.split(reg);
		//alert(Critere.join(" "));
		if(Critere.length > 1)// protection
		{
			switch(Critere[1])
			{
				case "texte":
					//modif comparaison
					SetOption(comparaison,new Array("=","!="));
					
					//modif valeur
					var newInput = document.createElement('input');
					newInput.type = 'text';
					newInput.name = 'valeur';
					newInput.id = "valeur";
					ElemValeur.appendChild(newInput);
				break;
				
				case "liste":
					//modif comparaison
					SetOption(comparaison,new Array("=","!="));
					
					//liste des options
					var list = new Array();
					for(var i=2; i<Critere.length; i++)
					{
						list.push(Critere[i]);
					}
					
					//modif valeur
					var newInput = document.createElement('select');
					newInput.name = 'valeur';	
					newInput.id = "valeur";
					ElemValeur.appendChild(newInput);
					
					SetOption(newInput,list);
				break;
				
				case "checkbox":
					//modif comparaison
					SetOption(comparaison,new Array("=","!="));
					
					//modif valeur
					var newInput = document.createElement('select');
					newInput.name = 'valeur';	
					newInput.id = "valeur";
					ElemValeur.appendChild(newInput);
					
					SetOption(newInput,new Array('vrai','faux'));
				break;
			
			}
		}else alert("Erreur: information complémentaire mal selectionnée");
			
		break;
		}
		  
		  
	}, true);

	var form = document.getElementById('form');
	
form.addEventListener('submit',function(e) { //lors d'un submit :
	
	var valhide = document.getElementById('valeurCOMEBACK');
	
	var contrainte = document.getElementById('contrainte');
	
	if(contrainte.value == 'CON_DATEADDED' || contrainte.value =="dateVersement" || contrainte.value =="CON_DATE")
	{
		var valJ = document.getElementById('valeurJ');
		var valM = document.getElementById('valeurM');
		var valA = document.getElementById('valeurA');
		valhide.value = valJ.value+"-"+valM.value+"-"+valA.value;
	}else if(contrainte.value == 'NbDon' || contrainte.value =="DonMoyen" || contrainte.value =="TotalDon")
	{
		var val = document.getElementById('valeur');
		var val1J = document.getElementById('DateDebutJ');
		var val1M = document.getElementById('DateDebutM');
		var val1A = document.getElementById('DateDebutA');
		var val2J = document.getElementById('DateFinJ');
		var val2M = document.getElementById('DateFinM');
		var val2A = document.getElementById('DateFinA');
		
		valhide.value = val.value+":"+val1J.value+"-"+val1M.value+"-"+val1A.value+"/"+val2J.value+"-"+val2M.value+"-"+val2A.value;
	
	}else{	
		var val = document.getElementById('valeur');
		valhide.value = val.value;
	}
	
}, true); 