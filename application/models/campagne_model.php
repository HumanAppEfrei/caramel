<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Campagne_model extends MY_Model
{
	protected $table = 'CAMPAGNES';
	protected $PKey = 'CAM_ID';
	
	public function select() {
		return $this->db->select('*')->from($this->table);
	}
	
	public function get_results() {
		return $this->db->get()->result();
	}
	
	public function read_id($id) {
		return $this->db->where('CAM_ID', (string) $id);
	}
	
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

	//requête pour obenir le montant global reçu pour chaque campagne
	public function read_montant_global(){
		return $this->db->query("SELECT C.CAM_NOM AS NOM, SUM( D.`DON_MONTANT` ) AS NUMBER , C.CAM_DEBUT AS DEBUT, C.CAM_FIN AS FIN
			FROM  `dons` D,  `offres` O,  `campagnes` C
				WHERE C.`CAM_ID` = O.`CAM_ID` 
					AND O.`OFF_ID` = D.`OFF_ID` 
						GROUP BY C.`CAM_ID` 
							ORDER BY SUM( D.`DON_MONTANT` ) DESC");
	}
}
