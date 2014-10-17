<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/** 
 * Convertit une date au format américain vers le format français
 * @param $date (string) Date au format américain aaaa-mm-dd
 * @param $withHoursMinutesSeconds (boolean) Indique si la date est suffixée par hh:mm:ss
 * @return (string) Date au format français jj-mm-aaaa
 **/
if ( ! function_exists('date_usfr'))
{
	function date_usfr($date, $withHoursMinutesSeconds = false)
	{
		$hour = '';
		if ($withHoursMinutesSeconds) {
			$date_parts = explode(' ', $date);
			$date = $date_parts[0];
			$hour = ' '.$date_parts[1];
		}

		$date_parts = explode("-", $date); // CHANGES Méthode explode() au lieu de split() parce que dépréciée
		$annee = $date_parts[0]; 
		$mois = $date_parts[1];
		$jour = $date_parts[2];
		
		if (strlen($jour) == 1) $jour = '0'.$jour;
		if (strlen($mois) == 1) $mois = '0'.$mois;
					
		return "$jour"."-"."$mois"."-"."$annee".$hour;
	}
}

/** 
 * Convertit une date au format français vers le format américain
 * @param $date (string) Date au format français jj-mm-aaaa
 * @return (string) Date au format américain aaaa-mm-dd
 **/
if ( ! function_exists('date_frus'))
{
	function date_frus($date) { 
		$date_parts = explode("-", $date);
		$jour = $date_parts[0];
		$mois = $date_parts[1];
		$annee = $date_parts[2];
		
		if (strlen($jour) == 1) $jour = '0'.$jour;
		if (strlen($mois) == 1) $mois = '0'.$mois;
		
		return "$annee"."-"."$mois"."-"."$jour"; 
	} 
}

/** 
 * Vérifie la validité d'une date au format français
 * @param $date (string) Date au format français jj-mm-aaaa
 * @return (boolean) true si la date est valide, false sinon.
 **/
if ( ! function_exists('isValidDate'))
{
	function isValidDate($date)
	{
		if (!isset($date))
			return false;

		$date_parts = explode("-", $date); // CHANGES Méthode explode() au lieu de split() parce que dépréciée

		if (sizeof($date_parts) != 3)
			return false;
		 
		$jour = $date_parts[0]; 
		$mois = $date_parts[1]; 
		$annee = $date_parts[2]; 

		if (!is_numeric($jour) || !is_numeric($mois) || !is_numeric($annee))
			return false;

		if (strlen($jour) > 2 || strlen($mois) > 2  || strlen($annee) > 4)
			return false;

		if ($jour < 1)
			return false;
		if($mois < 1 || $mois > 12)
			return false;

		if ($mois == 4 || $mois == 6 || $mois == 9 || $mois == 11)
		{
			if ($jour > 30)
				return false;

			return true;

		}
		else if ($mois == 2) {
			if ($jour > 29)
				return false;

			if ($jour == 29 && $annee%4 != 0) // Années bissextiles
				return false;

			return true;
		}
		else {
			if ($jour > 31)
				return false;

			return true;
		}
	} 
}

/** 
 * Compare deux dates (format français) sur leur antériorité
 * @param $date1 (string) Date au format français jj-mm-aaaa
 * @param $date2 (string) Date au format français jj-mm-aaaa
 * @return (integer) -2 si l'une des date est invalide ;
 *		-1 si $date1 est supérieure (plus récente) à $date2 ;
 *		1 si $date2 est supérieure (plus récente) à $date1 ;
 *		0 si elles sont égales
 **/
if ( ! function_exists('compare_Date'))
{
	function compare_Date($date1, $date2)
	{
		if (!isset($date1) || !isset($date2))
			return -2;

		if ($date1 == $date2)
			return 0;

		$date1_parts = explode("-",$date1); 
		$date2_parts = explode("-",$date2); 

		if (sizeof($date1_parts) != 3 || sizeof($date2_parts) != 3)
			return -2;

		if ($date1_parts[2] > $date2_parts[2])
			return -1;
		else if ($date1_parts[2] < $date2_parts[2])
			return 1;
		else {
			if ($date1_parts[1] > $date2_parts[1])
				return -1;
			else if ($date1_parts[1] < $date2_parts[1])
				return 1;
			else {
				if ($date1_parts[0] > $date2_parts[0])
					return -1;
				else if ($date1_parts[0] < $date2_parts[0])
					return 1;
			}
		}
	} 
}

