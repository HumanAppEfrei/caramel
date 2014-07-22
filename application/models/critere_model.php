<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Critere_model extends MY_Model
{
    protected $table = 'criteres';
	protected $PKey = 'CRIT_ID';
	
	public function select() {
		return $this->db->select('*')->from($this->table);
	}
	
	public function get_results() {
		return $this->db->get()->result();
	}
	
	///gestion CRITERES LINK
	public function addLink($crit1,$crit2,$link) {
		$this->db->set(array('CRIT_ID1' => $crit1,'CRIT_ID2' => $crit2,'LINK' => $link))
				 ->insert('criteres_link');
	
	}
	
	public function updateLink($crit1,$crit2,$link) {
		$this->db->set(array('LINK' => $link))
					->where(array('CRIT_ID1' => $crit1,'CRIT_ID2' => $crit2))
					->or_where(array('CRIT_ID2' => $crit1))
					->where(array('CRIT_ID1' => $crit2))
					->update('criteres_link');
	
	}
	
	public function getLink($crit1,$crit2) {
		 $resul = $this->db->select('LINK')
						->from('criteres_link')
						->where(array('CRIT_ID1' => $crit1,'CRIT_ID2' => $crit2))
						->or_where(array('CRIT_ID2' => $crit1))
						->where(array('CRIT_ID1' => $crit2))
						->get()
						->result();
			if(empty($resul)) return false;	
			return $resul[0]->LINK;		
	
	}
	
	public function readLinks($select = '*', $where = array()) {
	
		return $this->db->select($select)
						->from('criteres_link')
						->where($where)
						->get()
						->result();
	
	}
	
	public function is_unique_critID($critID) { 
	
		$resul = $this->read('CRIT_ID',array('CRIT_ID' => $critID));
		
		if($resul) return false;
		return true;
		 
	}


	public function Generate_CritereID($segCode) { 
	
		$resul = $segCode.'_1';
		$cpt=1;
		while(!$this->is_unique_critID($resul))
		{
			$cpt++;
			$resul = $segCode.'_'.$cpt;
		}
		
		return $resul;

	}	
	
}