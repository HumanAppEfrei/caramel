<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class type_model extends MY_Model
{
    protected $table = 'type';
	protected $PKey = 'TYP_ID';
	
	public function select() {
		return $this->db->select('*')->from($this->table);
	}
	
	public function get_names() {
		return $this->db->select('TYP_NAME')->from($this->table)->get()->result();
	}
	
	public function get_results() {
		return $this->db->get()->result();
	}

	public function read_id($id) {
		return $this->db->where('TYP_ID', (string) $id);
	}
	
	public function read_name($name) {
		return $this->db->where('TYP_NAME', (string) $name);
	}
}