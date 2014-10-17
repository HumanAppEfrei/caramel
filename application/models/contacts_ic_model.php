<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contacts_ic_model extends MY_Model
{
    protected $table = 'contacts_ic';
	protected $PKey = 'CON_ID';
	
	public function addColumn($name, $type)
	{
		$this->db->query('ALTER TABLE contacts_ic ADD '.$name." ".$type);
	}
	
	public function removeColumn($name)
	{
		$this->db->query('ALTER TABLE contacts_ic DROP COLUMN '.$name);
	}
	
	public function select() {
		return $this->db->select('*')->from($this->table);
	}
	
	public function get_results() {
		return $this->db->get()->result();
	}
	
	public function get_result_array() {
		return $this->db->get()->result_array();
	}
	
	public function read_id($id) {
		return $this->db->where('CON_ID', (string) $id);
	}
	
	public function delete_tuple($id) {
		$this->db->delete($this->table,array('CON_ID'=> $id));
	}
	
	public function update_tuple($params,$id) {
		$this->db->update($this->table,$params,"CON_ID = ".$id);
	}
	
	public function insert_empty_tuple($id) {
		$this->db->set('CON_ID',$id);
		$this->db->insert($this->table);
	}
	
}