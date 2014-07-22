<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cible_model extends MY_Model
{
    protected $table = 'cibles';
	protected $PKey = 'CIB_ID';
	
	public function select() {
		return $this->db->select('*')->from($this->table);
	}
	
	public function get_results() {
		return $this->db->get()->result();
	}
	
	public function get_cible($offre)
	{
		return $this->db->query("SELECT cibles.CON_ID,CON_FIRSTNAME,CON_LASTNAME, DON_MONTANT, DON_ID
								FROM cibles NATURAL JOIN CONTACTS LEFT JOIN DONS ON DONS.CON_ID = cibles.CON_ID AND DONS.OFF_ID = cibles.OFF_ID WHERE cibles.OFF_ID='".$offre."'")
								->result();
	
	}
	
	public function comptage_total($offre) {
		return $this->db->query("SELECT cibles.CON_ID,CON_FIRSTNAME,CON_LASTNAME, DON_MONTANT, DON_ID
								FROM cibles NATURAL JOIN CONTACTS LEFT JOIN DONS ON DONS.CON_ID = cibles.CON_ID AND DONS.OFF_ID = cibles.OFF_ID WHERE cibles.OFF_ID='".$offre."'")->num_rows();
	}

	public function comptage_repondu($offre) {
		return $this->db->query("SELECT cibles.CON_ID,CON_FIRSTNAME,CON_LASTNAME, DON_MONTANT, DON_ID
								FROM cibles NATURAL JOIN CONTACTS LEFT JOIN DONS ON DONS.CON_ID = cibles.CON_ID AND DONS.OFF_ID = cibles.OFF_ID WHERE DONS.DON_MONTANT > 0 AND cibles.OFF_ID='".$offre."'")->num_rows();
	}

	public function read_doublon($contact, $mission){
		$items = $this->db->select('*')->from($this->table);
		$items = $this->db->where('CON_ID', (string) $contact);
		$items = $this->db->where('MIS_ID', (string) $mission);
		$items = $this->db->get()->result();
		if(empty($items)) return true;
		else return false;
	}
	
	public function update_id($old_id,$new_id) {
		$query_data=array('CON_ID'=>$new_id);
		$this->db->update('cibles',$query_data,"CON_ID = ".$old_id);
	}
}