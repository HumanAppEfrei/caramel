<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Model du nom d'une table
 */
class Tables_names_model extends MY_Model {

    /** @var string $table Nom de la table */
    protected $table = 'tables_names';
    /** @var string $PKey Cle primaire de la table */
    protected $PKey = 'TABL_ID';

    /**
     * Selectionne tous dans la table
     * @return mixed[] Les informations presents dans la table.
     */
    public function select() {
        $this->db->select('*')->from($this->table);
    }

    /**
     * Selectionne tous les ids de la table
     * @return string[] Les ids de la table
     */
    public function select_tabl_id() {
        $this->db->select('TABL_ID')->from($this->table);
    }

    /**
     * Selectionne tous les resultats
     * @return mixed[] Les resultats presents dans la table.
     */
    public function get_results() {
        return $this->db->get()->result();
    }
    /**
     * Selection un nom base sur un id
     * @param string $id L'id selectionne
     * @return mixed[] Les informations sur le nom selectionne
     */
    public function read_id($id) {
        $this->db->where('TABL_ID', (int) $id);
    }

    /**
     * Selectionne un nom base sur le nom d'une table
     * @param string $tabl_name Nom de la table selectionee
     * @return mixed[] Les informations sur le nom selectione
     */
    public function read_name($tabl_name) {
        $this->db->where('TABL_NAME', (string) $tabl_name);
    }

    /**
     * Selectionne les informations base sur le nom d'une table
     * @param string $tabl_name Le nom de la table selectionne
     * @return mixed[] Les informations sur la table selectionne
     */
    public function select_tabl_id_where($tabl_name){
        $this->db->select('tabl_id')->from($this->table);
        $this->db->where('tabl_name', $tabl_name);
        return $this->db->get()->result();
    }
}

?>
