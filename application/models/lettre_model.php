<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class lettre_model extends MY_Model
{
    protected $table = 'lettre';
	protected $PKey = 'LET_ID';
	
	public function select() {
		return $this->db->select('*')->from($this->table);
	}
	
	public function get_results() {
		return $this->db->get()->result();
	}

	public function read_id($id) {
		return $this->db->where('LET_ID', (string) $id);
	}
	
	public function read_fid($fid) {
		return $this->db->where('LET_TYP_ID', (string) $fid);
	}
	
	public function read_name($name) {
		return $this->db->where('LET_NAME', (string) $name);
	}
	
	public function read_content($content) {
		return $this->db->where('LET_CONTENT', (string) $content);
	}
}