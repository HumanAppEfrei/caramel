<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tables_fields_model extends MY_Model {

    protected $table = 'tables_fields';
    protected $PKey = 'TABL_FIELD_ID';

    public function select() {
        $this->db->select('*')->from($this->table);
    }

    public function select_field_id() {
        $this->db->select('TABL_FIELD_ID')->from($this->table);
    }

    public function get_results() {
        return $this->db->get()->result();
    }

    public function read_field_id($field_id) {
        $this->db->where('TABL_FIELD_ID', (int) $field_id);
    }

    public function read_tabl_id($tabl_id) {
        $this->db->where('TABL_ID', (int) $tabl_id);
    }

    public function read_field_name($field_name) {
        $this->db->where('TABL_FIELD_NAME', (string) $field_name);
    }

    public function read_field($field) {
        $this->db->where('TABL_FIELD', (string) $field);
    }

}

?>
