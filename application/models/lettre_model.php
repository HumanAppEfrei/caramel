<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model de lettre
 */
class lettre_model extends MY_Model
{
    /** @var string Nom de la table */
    protected $table = 'lettre';
    /** @var string Cle primaire de la table */
	protected $PKey = 'LET_ID';

    /**
     * Selectionne tout dans la table
     * @return mixed[] Tous les resultats de la table
     */
	public function select() {
		return $this->db->select('*')->from($this->table);
	}

	/**
     * Selectionne tous les resultats dans la table
     * @return mixed[] Tous les resultats de la table
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
		return $this->db->where('LET_ID', (string) $id);
	}

	/**
     * Recupere un element de la table en fonction de son fid
     * @param string $fid L'fid de l'element selectionee
     * @return mixed L'element selectionne
     */
	public function read_fid($fid) {
		return $this->db->where('LET_TYP_ID', (string) $fid);
	}

	/**
     * Recupere un element de la table en fonction de son name
     * @param string $name Le nom de l'element selectionee
     * @return mixed L'element selectionne
     */
	public function read_name($name) {
		return $this->db->where('LET_NAME', (string) $name);
	}

	/**
     * Recupere un element de la table en fonction de son content
     * @param string $content Le contenu de l'element selectionee
     * @return mixed L'element selectionne
     */
	public function read_content($content) {
		return $this->db->where('LET_CONTENT', (string) $content);
	}
}
