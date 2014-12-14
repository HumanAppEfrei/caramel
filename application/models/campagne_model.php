<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Campagne_model est la classe qui definit le modele d'une campagne
 */
class Campagne_model extends MY_Model
{
	/** @var (String) Nom de la table dans la BDD */
	protected $table = 'CAMPAGNES';
	/** @var (String) Cle primaire de cette table */
	protected $PKey = 'CAM_ID';
	
	/**
     	*  Selectionne tous les tuples de la table Campagne
	*  @return (Mixed[]) toutes les campagnes, mixed[] signifiant plusieurs types possibles
        **/
	public function select() {
		return $this->db->select('*')->from($this->table);
	}
	
	/**
     	*  Execution de la requete et retourne le(s) resultat(s)
	*  @return (Mixed[]) le(s) resultat(s) de la requete
        **/
	public function get_results() {
		return $this->db->get()->result();
	}
	
	/**
     	*  Selectionne les campagnes en fonction d'un id
     	*  @param (Varchar) l'id saisi
	*  @return (Mixed[]) les campagnes avec le meme id
        **/
	public function read_id($id) {
		return $this->db->where('CAM_ID', (string) $id);
	}
	
	/**
     	*  Selectionne les campagnes en fonction d'un nom
     	*  @param (String) le nom saisi
	*  @return (Mixed[]) les campagnes avec le meme nom (determiner l'utilisation de "after")
        **/
	public function read_name($name) {
		// $sql=" CAM_NOM LIKE '%{$name}%'";
		// return $this->db->where($sql,NULL, FALSE);
		return $this->db->like('CAM_NOM', (string) $name, 'after');
	}
	
	/**
     	*  Selectionne les campagnes en fonction d'une date
     	*  @param (Date) la date saisie
	*  @return (Mixed[]) les campagnes avec une date de debut posterieure a la date saisie
        **/
	public function read_date_debut($first_date){
		return $this->db->where('CAM_DEBUT >=', $first_date);
	}
	
	/**
     	*  Selectionne les campagnes en fonction d'une date
     	*  @param (Date) la date saisie
	*  @return (Mixed[]) les campagnes avec une date de fin anterieure a la date saisie
        **/
	public function read_date_fin($second_date){
		return $this->db->where('CAM_FIN <=', $second_date);
	}
	
	/**
     	*  Selectionne les campagnes en fonction d'un type (fidelisation, prospection)
     	*  @param (String) le type selectionne
	*  @return (Mixed[]) les campagnes avec le meme type
        **/
	public function read_type($type){
		return $this->db->where('CAM_TYPE', (string) $type);
	}
	
	/**
     	*  Selectionne les campagnes en fonction d'une des categories (web, courrier, email) avec la fonction OU
     	*  @param (String) les categories (vide ou coche)
	*  @return (Mixed[]) les campagnes avec au moins une categorie identique, rien quand 0 selectionnee 
        **/
	public function read_media_or($web, $courrier, $email){
		$where = "(CAM_WEB LIKE '%".$web."%'
		OR CAM_COURRIER LIKE '%".$courrier."%'
		OR CAM_EMAIL LIKE '%".$email."%')";
		if($web=="pasok" && $courrier=="pasok" && $email=="pasok");
		else $this->db->where($where);
	}
	
	/**
     	*  Selectionne les campagnes en fonction d'une des categories (web, courrier, email) avec la fonction ET
     	*  @param (String) les categories (vide ou coche)
	*  @return (Mixed[]) les campagnes avec les memes categories
        **/
	public function read_media_and($web, $courrier, $email){
		$where = "(CAM_WEB LIKE '%".$web."%'
		AND CAM_COURRIER LIKE '%".$courrier."%'
		AND CAM_EMAIL LIKE '%".$email."%')";
		$this->db->where($where);
	}
	
	/**
     	*  Selectionne les campagnes en fonction de la categorie web
     	*  @param (String) la categorie web (vide ou coche)
	*  @return (Mixed[]) les campagnes avec la meme categorie
        **/
	public function read_web($web){
		return $this->db->where('CAM_WEB', (string) $web);
	}
	
	/**
     	*  Selectionne les campagnes en fonction de la categorie courrier
     	*  @param (String) la categorie courrier (vide ou coche)
	*  @return (Mixed[]) les campagnes avec la meme categorie
        **/
	public function read_courrier($courrier){
		return $this->db->where('CAM_COURRIER', (string) $courrier);
	}
	
	/**
     	*  Selectionne les campagnes en fonction de la categorie email
     	*  @param (String) la categorie email (vide ou coche)
	*  @return (Mixed[]) les campagnes avec la meme categorie
        **/
	public function read_email($email){
		return $this->db->where('CAM_EMAIL', (string) $email);
	}

	/**
     	*  Selectionne le montant global reçu (dons, offres) pour chaque campagne
	*  @return (Mixed[]) les campagnes avec leur montant global reçu ainsi que leur nom et leurs dates debut/fin
        **/
	public function read_montant_global(){
		return $this->db->query("SELECT C.CAM_NOM AS NOM, SUM( D.`DON_MONTANT` ) AS NUMBER , C.CAM_DEBUT AS DEBUT, C.CAM_FIN AS FIN
			FROM  `dons` D,  `offres` O,  `campagnes` C
				WHERE C.`CAM_ID` = O.`CAM_ID` 
					AND O.`OFF_ID` = D.`OFF_ID` 
						GROUP BY C.`CAM_ID` 
							ORDER BY SUM( D.`DON_MONTANT` ) DESC");
	}
}
