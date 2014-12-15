<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model pour les contacts IC (a definir)
 */
class Contacts_ic_model extends MY_Model
{
    /** @var string Nom de la table */
    protected $table = 'contacts_ic';
    /** @var string Nom de la cle primaire */
	protected $PKey = 'CON_ID';

    /**
     * Ajoute une colonne dans la table
     * @param string $name Nom de la nouvelle colonne
     * @param string $type Type de la nouvelle colonne
     */
	public function addColumn($name, $type)
	{
		$this->db->query('ALTER TABLE contacts_ic ADD '.$name." ".$type);
	}

    /**
     * Supprime une colonne de la table
     * @param strin $name Nom de la colonne a supprimer
     */
	public function removeColumn($name)
	{
		$this->db->query('ALTER TABLE contacts_ic DROP COLUMN '.$name);
	}

    /**
     * Selectionne toutes les informations de la table
     * @return mixed[] Les informations de la table
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

    /*
     * Recuperer les resultats sous la forme d'un tableau
     * @return mmixed[] Tous les resultats de la table
     */
	public function get_result_array() {
		return $this->db->get()->result_array();
	}

    /**
     * Recupere un element de la table en fonction de son id
     * @param string $id L'id de l'element selectionne
     * @return element L'element selectionee
     */
	public function read_id($id) {
		return $this->db->where('CON_ID', (string) $id);
	}

    /**
     * Supprime un element de la table
     * @param string $id L'id de l'element a supprimer
     */
	public function delete_tuple($id) {
		$this->db->delete($this->table,array('CON_ID'=> $id));
	}

    /**
     * Met a jour un element de la table
     * @param string $id L'id de l'element selectionne
     * @param array $params Les parametres a mettre a jour dans la table
     */
	public function update_tuple($params,$id) {
		$this->db->update($this->table,$params,"CON_ID = ".$id);
	}

    /**
     * Ajoute un element vide dans la table
     * @param string $id L'id de l'element a ajouter
     */
	public function insert_empty_tuple($id) {
		$this->db->set('CON_ID',$id);
		$this->db->insert($this->table);
	}

}
