<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tables_names_model extends MY_Model {

    protected $table = 'tables_names';
    protected $PKey = 'TABL_ID';

    public function select() {
        $this->db->select('*')->from($this->table);
    }
    
    public function select_tabl_id() {
        $this->db->select('TABL_ID')->from($this->table);
    }

    public function get_results() {
        return $this->db->get()->result();
    }

    public function read_id($id) {
        $this->db->where('TABL_ID', (int) $id);
    }

    public function read_name($tabl_name) {
        $this->db->where('TABL_NAME', (string) $tabl_name);
    }
    
    public function select_tabl_id_where($tabl_name){
        $this->db->select('tabl_id')->from($this->table);
        $this->db->where('tabl_name', $tabl_name);
        return $this->db->get()->result();
    }
}

?>
