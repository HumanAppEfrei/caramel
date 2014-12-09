<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model des types d'utilisateurs
 */
class type_model extends MY_Model
{
    /** @var string $table Nom de la table */
    protected $table = 'type';
    /** @var string $PKey Cle primaire de la table */
	protected $PKey = 'TYP_ID';

    /**
     * Fonction qui selection tout les types dans la table.
     * @return mixed[] Les types presents dans la table
     */
	public function select() {
		return $this->db->select('*')->from($this->table);
	}

    /**
     * Fonction qui recupere tous les noms des types dans la table
     * @return string[] Les noms presents dans la table.
     */
	public function get_names() {
		return $this->db->select('TYP_NAME')->from($this->table)->get()->result();
	}

    /**
     * Fonction qui recupere tous les resultats dans la table
     * @return mixed[] Les resultats presents dans la table.
     */
	public function get_results() {
		return $this->db->get()->result();
	}

    /**
     * Fonction qui recupere tous les ids dans la table
     * @param string $id L'id de l'utilisateur selectionne
     * @return string[] Les ids presents dans la table.
     */
	public function read_id($id) {
		return $this->db->where('TYP_ID', (string) $id);
	}

    /**
     * Fonction qui recupere un utilisateur en fonction de son nom
     * @param string $name Le nom de l'utilisateur selectionne
     * @return mixed[] Les informations presents dans la table.
     */
	public function read_name($name) {
		return $this->db->where('TYP_NAME', (string) $name);
	}
}
