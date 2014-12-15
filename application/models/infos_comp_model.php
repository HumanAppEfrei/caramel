<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model des informations
 */
class Infos_comp_model extends MY_Model
{
    /** @var string Nom de la table */
    protected $table = 'infos_comp';
    /** @var string Cle primaire de la table */
	protected $PKey = 'IC_ID';

    /**
     * Selectionne tout dans la table
     * @return mixed[] Tous les elements de la table
     */
	public function select() {
		return $this->db->select('*')->from($this->table);
	}

    /**
     * Recupere les resultats de la table
     * @return mixed[] Tous les resultats de la table
     */
	public function get_results() {
		return $this->db->get()->result();
	}

    /**
     * Recupere un model en fonction de son id
     * @param string $id Id de l'element selectionne
     * @result mixed L'element selectionne
     */
	public function read_id($id) {
		return $this->db->where('IC_ID', (string) $id);
	}
}
