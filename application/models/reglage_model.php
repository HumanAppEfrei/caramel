<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reglage_model extends MY_Model
{
    protected $table = 'reglages';
	protected $PKey = 'REG_ID';
	
	public function read($regCode) {
		return $this->db->select('*')->from($this->table)->where(array('REG_CODE'=>$regCode))->get()->result();
	}
	
	
}