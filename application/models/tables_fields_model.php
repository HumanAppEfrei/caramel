<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Model pour les champs des tables
 */
class Tables_fields_model extends MY_Model {

    /** @var string Nom de la table */
    protected $table = 'tables_fields';
    /** @var string Nom de la cle primaire */
    protected $PKey = 'TABL_FIELD_ID';

    /**
     * Selectionne tout dans la table
     * @return (mixed) tout le contenu de la table
     */
    public function select() {
        $this->db->select('*')->from($this->table);
    }

    /**
     * Selectionne tous les ids de la table
     * @return (array[integer]) Tous les ids de la table
     */
    public function select_field_id() {
        $this->db->select('TABL_FIELD_ID')->from($this->table);
    }

    /**
     * Recupere tous les resultats de la table
     * @return (mixed) tout les resultats de la table
     */
    public function get_results() {
        return $this->db->get()->result();
    }

    /**
     * Recupere les champs de la table suivant un id
     * @param $field_id (integer) L'id de l'element souhaite
     */
    public function read_field_id($field_id) {
        $this->db->where('TABL_FIELD_ID', (int) $field_id);
    }

    /**
     * Recupere les champs de la table suivant un id
     * @param $tabl_id (integer) L'id de la table souhaitee
     */
    public function read_tabl_id($tabl_id) {
        $this->db->where('TABL_ID', (int) $tabl_id);
    }

    /**
     * Recupere les champs de la table suivant un nom
     * @param $field_name (string) Le nom du champ souhaite
     */
    public function read_field_name($field_name) {
        $this->db->where('TABL_FIELD_NAME', (string) $field_name);
    }

    /**
     * Recupere les informations de la table suivant un champ
     * @param $field (mixed) Le champ souhaite
     */
    public function read_field($field) {
        $this->db->where('TABL_FIELD', (string) $field);
    }

}

?>
