<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Model de l'historique des transactions
 */
class Historique_model extends MY_Model {

    /** @var string Nom de la table */
    protected $table = 'historique';
    /** @var string Cle primaire de la table */
    protected $PKey = 'HIST_ID';

    /**
     * Selectionne tout dans la table
     * @return mixed[] Les elements de la table
     */
    public function select() {
        $this->db->select('*')->from($this->table);
    }

    /**
     * Recupere les resultats de la table
     * @return mixed[] Les resultats de la table
     */
    public function get_results() {
        return $this->db->get()->result();
    }

    /**
     * Recupere un element de la table en fonction de son id
     * @param string $id L'id de l'element selectionee
     * @return mixed L'element selectionne
     */
    public function read_id($id) {
        $this->db->where('HIST_ID', (int) $id);
    }

    /**
     * Recupere l'historique d'un contact
     * @param string $id_con L'id du contact selectionne
     * @param string $hist_tabl_id L'id de la table d'historique
     */
    public function read_contacts_historic($id_con, $hist_tabl_id) {
        $this->db->select('historique.hist_datetime, historique.hist_modif_type, historique.hist_field_value, tables_fields.tabl_field, tables_fields.tabl_field_name')->from($this->table);
        $this->db->join('tables_fields', 'tables_fields.tabl_field_id = historique.hist_field_id');
        $this->db->where('historique.hist_tabl_id', (int) $hist_tabl_id);
        $this->db->where('historique.hist_tabl_pkey', $id_con);
        $this->db->order_by('historique.hist_id', 'desc');
    }
}

?>
