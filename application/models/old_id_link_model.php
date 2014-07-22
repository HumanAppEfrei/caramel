<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class old_id_link_model extends MY_Model
{
    protected $table = 'old_id_link';
	protected $PKey = 'OLD_CURRENT_ID';
	
	public function select() {
		return $this->db->select('*')->from($this->table);
	}
	
	public function get_results() {
		return $this->db->get()->result();
	}
	
	public function read_current_id($current_id) {
		return $this->db->where('OLD_CURRENT_ID', (string) $current_id);
	}
	
	public function read_past_id($past_id) {
		return $this->db->where('OLD_PAST_ID', (string) $past_id);
	}
	
	public function insert_tuple($current_id,$past_id)
	{
		$this->db->set('OLD_CURRENT_ID',$current_id);
		$this->db->set('OLD_PAST_ID',$past_id);
		$this->db->insert($this->table); 
	}
	
	public function delete_with_current_id($current_id)
	{
		$this->db->delete($this->table,array('OLD_CURRENT_ID'=> $current_id));
	}
	
	public function delete_with_past_id($past_id)
	{
		$this->db->delete($this->table,array('OLD_PAST_ID'=> $past_id));
	}
	
}