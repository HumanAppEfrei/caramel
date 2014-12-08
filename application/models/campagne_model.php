<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/** BUT : Manipuler les informations de la table "Campagne" */
class Campagne_model extends MY_Model
{
    	protected $table = 'campagnes';
	protected $PKey = 'CAM_ID';
	
	/**
     	*  Recuperation de tous les tuples de la base
	*  @return tous les tuples en question
        **/
	public function select() {
		return $this->db->select('*')->from($this->table);
	}
	
	/**
     	*  Recuperation de tous les resultats repondant a une requete donnee
	*  @return (array object) tous les resultats en question
        **/
	public function get_results() {
		return $this->db->get()->result();
	}
	
	/**
     	*  Recuperation de tous les tuples de la table correspondant à l'id insere
     	*  @param identifiant à lire
	*  @return tous les tuples en question (CAM_ID = $id)
        **/
	public function read_id($id) {
		return $this->db->where('CAM_ID', (string) $id);
	}
	
	/**
     	*  Recuperation de tous les tuples de la table correspondant au nom insere
     	*  @param nom à lire
	*  @return tous les tuples en question (CAM_ID = $id)
        **/
	public function read_name($name) {
		// $sql=" CAM_NOM LIKE '%{$name}%'";
		// return $this->db->where($sql,NULL, FALSE);
		return $this->db->like('CAM_NOM', (string) $name, 'after');
	}
	
	public function read_date_debut($first_date){
		return $this->db->where('CAM_DEBUT >=', $first_date);
	}
	
	public function read_date_fin($second_date){
		return $this->db->where('CAM_FIN <=', $second_date);
	}
	
	public function read_type($type){
		return $this->db->where('CAM_TYPE', (string) $type);
	}
	
	public function read_media_or($web, $courrier, $email){
		$where = "(CAM_WEB LIKE '%".$web."%'
		OR CAM_COURRIER LIKE '%".$courrier."%'
		OR CAM_EMAIL LIKE '%".$email."%')";
		if($web=="pasok" && $courrier=="pasok" && $email=="pasok");
		else $this->db->where($where);
	}
	
	public function read_media_and($web, $courrier, $email){
		$where = "(CAM_WEB LIKE '%".$web."%'
		AND CAM_COURRIER LIKE '%".$courrier."%'
		AND CAM_EMAIL LIKE '%".$email."%')";
		$this->db->where($where);
	}
	
	public function read_web($web){
		return $this->db->where('CAM_WEB', (string) $web);
	}
	
	public function read_courrier($courrier){
		return $this->db->where('CAM_COURRIER', (string) $courrier);
	}
	
	public function read_email($email){
		return $this->db->where('CAM_EMAIL', (string) $email);
	}
}
