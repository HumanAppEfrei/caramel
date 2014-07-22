<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Historique_model extends MY_Model {

    protected $table = 'historique';
    protected $PKey = 'HIST_ID';

    public function select() {
        $this->db->select('*')->from($this->table);
    }

    public function get_results() {
        return $this->db->get()->result();
    }

    public function read_id($id) {
        $this->db->where('HIST_ID', (int) $id);
    }

    public function read_contacts_historic($id_con, $hist_tabl_id) {
        $this->db->select('historique.hist_datetime, historique.hist_modif_type, historique.hist_field_value, tables_fields.tabl_field, tables_fields.tabl_field_name')->from($this->table);
        $this->db->join('tables_fields', 'tables_fields.tabl_field_id = historique.hist_field_id');
        $this->db->where('historique.hist_tabl_id', (int) $hist_tabl_id);
        $this->db->where('historique.hist_tabl_pkey', $id_con);
        $this->db->order_by('historique.hist_id', 'desc');
    }
}

?>
