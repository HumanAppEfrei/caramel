<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model
{
	protected $table = '';
	protected $PKey = '';

	/**
     *  Insère une nouvelle ligne dans la base de données.
     *  Les paramètres sont des tableaux associatifs qui doivent porter comme clés des noms de champs en BDD.
     *  @param $options_echappees (array) options à insérer. Elles seront échappées.
     *  @param $option_non_echappees (array) options à insérer. Elles se seront pas échappées.
     *  @return (boolean) false s'il y a eu un problème, true si l'ajout a été effectué.
     **/
	public function create($options_echappees = array(), $options_non_echappees = array() )
    {
		if (empty($options_echappees) AND empty($options_non_echappees)) {
			return false;
		}
        
		return (bool) $this->db->set($options_echappees)
							->set($options_non_echappees, null, false)
							->insert($this->table);
	}
	
	/**
     *  Récupère des données dans la base de données.
     *  @param $select (string) clause select de la requête à effectuer (champs voulus dans le résultat).
     *  @param $where (array) clause where de la requête à effectuer sous forme de tableau associatif.
     *  @return (array) tableau des résultats retournés.
     **/
	public function read($select = '*', $where = array()) {
		return $this->db->select($select)
						->from($this->table)
						->where($where)
						->get()
						->result();
	}
	
	public function read_by_page($select = '*', $where = array(), $nb = null, $debut = null) {
		return $this->db->select($select)
						->from($this->table)
						->where($where)
						->limit($nb, $debut)
						->get()
						->result();
	}
	
	public function read_simple($select = '*') {
		return $this->db->select($select)
						->from($this->table)
						->get()
						->result();
	}
	
	public function read_all() {
		return $this->db->select('*')->from($this->table)->get()->result();
	}

	/**
	 *	Modifie une ou plusieurs lignes dans la base de données.
	 **/
	public function update($where, $options_echappees = array(), $options_non_echappees = array()) {
		// Vérification des données à mettre à jour
		if(empty($options_echappees) AND empty($options_non_echappees)) {
			return false;
		}
		
		return (bool) $this->db->set($options_echappees)
								->set($options_non_echappees, null,false)
								->where($where)
								->update($this->table);
	}
	

	/** 
	 *	Supprime une ou plusieurs lignes de la base de données.
	 **/
	public function delete($where) {
	
		return (bool) $this->db->where($where)
								->delete($this->table);
	}


	/** 
	 *	Retourne le nombre de résultats.
	 **/
	// Si $champ est un array, la variable $valeur sera ignorée par la méthode where()
	public function count($champ = array(), $valeur = null) {
 		return (int) $this->db->where($champ, $valeur) 
 								->from($this->table)
								->count_all_results();
	}
	
	/**
	 *	Retourne l'id de la dernière entrée dans la table
	 **/
	// Marche pour des tables avec clé primaire auto
	public function LastEntryId() {
		if($this->PKey)
		{
			return $this->db->query('SELECT '.$this->PKey.'
									FROM '.$this->table.'
									ORDER BY '.$this->PKey.' DESC
									LIMIT 1 ')->result();
		}
        else
            return false;
	}
	
	public function lastQuery() {
		return $this->db->last_query();
	}
	
	/* gestion des transactions */
	public function begin() {
		$this->db->trans_begin();
	}
	
	public function commit() {
		 $this->db->trans_commit();
	}
}