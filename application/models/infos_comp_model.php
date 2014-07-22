<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Infos_comp_model extends MY_Model
{
    protected $table = 'infos_comp';
	protected $PKey = 'IC_ID';
	
	public function select() {
		return $this->db->select('*')->from($this->table);
	}
	
	public function get_results() {
		return $this->db->get()->result();
	}
	
	public function read_id($id) {
		return $this->db->where('IC_ID', (string) $id);
	}
}