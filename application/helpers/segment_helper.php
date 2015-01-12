<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Convertit une contrainte utilisateur en string correspondant
* @param $contrainte (var) Contrainte à convertir au format approprié
* @return (string) La contrainte en format string
**/
if ( ! function_exists('convert_contrainte'))
{
	function convert_contrainte($contrainte) { 
	
		switch($contrainte)
		{
			case "CON_ID":
				return "Numéro d'adhérent";
			break;
			
			case "CON_DATE":
				return "Date de naissance";
			break;
			
			case "CON_TYPE":
				return "Type de personne";
			break;
			
			case "CON_TYPEC":
				return "Type de client";
			break;
			
			case "CON_CITY":
				return "Ville";
			break;
			
			case "CON_COUNTRY":
				return "Pays";
			break;
			
			case "departement":
				return "Département";
			break;
			
			case "CON_NPAI":
				return "NPAI";
			break;
			
			case "CON_DATEADDED":
				return "Date d'inscription";
			break;

			case "dateVersement":
				return "Date dernier versement";
			break;
			
			case "NbDon":
				return "Nombre de Don";
			break;
			
			case "DonMoyen":
				return "Don moyen";
			break;
			
			case "TotalDon":
				return "Total de dons";
			break;
			
			case "segment":
				return "Segment";
			break;
			
			default: // IC
			$label = explode(":",$contrainte); // CHANGES Méthode explode() au lieu de split() parce que dépréciée
			if(count($label) > 1) return $label[1];
			else return $contrainte;
			break;
		}
	}
}

/**
* Convertit une valeur utilisateur en string correspondant
* @param $contrainte (string) La contrainte émise
* @param $type (string) Le type
* @param $valeur (?) La valeur
* @return (array) A déterminer...
**/
if ( ! function_exists('convert_valeur'))
{
	function convert_valeur($contrainte, $type, $valeur) { 
	
		if($contrainte == 'CON_NPAI' || $type=="IC" && ($valeur == "on" || $valeur == "0"))
		{
			if($valeur == "on") return array('VRAI',''); 
			else return array('FAUX','');
		}else if($contrainte == 'NbDon' || $contrainte == 'DonMoyen' || $contrainte == 'TotalDon')
		{
			$tmp = explode(':',$valeur);
			$val = $tmp[0];
			$tmp = explode('/',$tmp[1]);
			return array($val,'Du '.date_usfr($tmp[0]).' au '.date_usfr($tmp[1]));
			
		}else if($contrainte == 'dateVersement' || $contrainte == 'CON_DATEADDED' || $contrainte == 'CON_DATE')
		{
			return array(date_usfr($valeur),'');
		}else{
			return array($valeur,'');
		}
	}
}

/**
* Convertit le résultat d'une requête
* @param $segmentResult (var) La requête à convertir
* @return (array) Les résultats de la requête sous forme de liste
**/
if ( ! function_exists('convResulRequest'))
{
	function convResulRequest($segmentResult) { 
		
		$segresul = array('none');
		foreach($segmentResult as $SR) array_push($segresul,$SR->CON_ID);
		return $segresul;
	
	}
}
