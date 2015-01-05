<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Classe de base de tous les models de l'application
 */
class MY_Model extends CI_Model
{
    /** @var string Nom de la table */
	protected $table = '';
    /** @var string Nom de la table */
	protected $PKey = '';

	/**
     *  Insere une nouvelle ligne dans la base de donnees.
     *  Les parametres sont des tableaux associatifs qui doivent porter comme cles des noms de champs en BDD.
     *  @param $options_echappees (array) options a inserer. Elles seront echappees.
     *  @param $option_non_echappees (array) options a inserer. Elles se seront pas echappees.
     *  @return (boolean) false s'il y a eu un probleme, true si l'ajout a ete effectue.
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
     *  Recupere des donnees dans la base de donnees.
     *  @param $select (string) clause select de la requête a effectuer (champs voulus dans le resultat).
     *  @param $where (array) clause where de la requête a effectuer sous forme de tableau associatif.
     *  @return (array) tableau des resultats retournes.
     **/
	public function read($select = '*', $where = array()) {
		return $this->db->select($select)
						->from($this->table)
						->where($where)
						->get()
						->result();
	}

	/**
     *  Recupere un certain nombre de pages
     *  @param $select (string) clause select de la requête a effectuer (champs voulus dans le resultat).
     *  @param $where (array) clause where de la requête a effectuer sous forme de tableau associatif.
     *  @param $nb (integer) limite inferieure de la selection
     *  @param $debut (integer) limite supperieure de la selection
     *  @return (array) tableau des resultats retournes.
     **/
	public function read_by_page($select = '*', $where = array(), $nb = null, $debut = null) {
		return $this->db->select($select)
						->from($this->table)
						->where($where)
						->limit($nb, $debut)
						->get()
						->result();
	}

	/**
     *  Recupere des donnees dans la base de donnees.
     *  @return (array) tableau des resultats retournes.
     **/
	public function read_simple($select = '*') {
		return $this->db->select($select)
						->from($this->table)
						->get()
						->result();
	}

	/**
     *  Recupere des donnees dans la base de donnees.
     *  @return (array) tableau des resultats retournes.
     **/
	public function read_all() {
		return $this->db->select('*')->from($this->table)->get()->result();
	}

	/**
	 *	Modifie une ou plusieurs lignes dans la base de donnees.
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
	 *	Supprime une ou plusieurs lignes de la base de donnees.
     *	@param $where (string) condition de selection pour la suppression
     *	@return (boolean) true si la suppression a bien eu lieu, false sinon
	 **/
	public function delete($where) {

		return (bool) $this->db->where($where)
								->delete($this->table);
	}


	/**
	 *	Retourne le nombre de resultats.
     *	@param $champ (string) le champ a chercher
     *	@param $valeur (mixed) la valeur a chercher
     *	@return (integer) le nombre d'elements de la table
	 **/
	// Si $champ est un array, la variable $valeur sera ignoree par la methode where()
	public function count($champ = array(), $valeur = null) {
 		return (int) $this->db->where($champ, $valeur)
 								->from($this->table)
								->count_all_results();
	}

	/**
	 *	Retourne l'id de la derniere entree dans la table
     *	@return (integer) l'id du dernier element de la table
	 **/
	// Marche pour des tables avec cle primaire auto
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

    /**
     * Retourne la derniere requete de la base de donnee
     * @return (mixed) la derniere requete sur la base de donnee
     */
	public function lastQuery() {
		return $this->db->last_query();
	}

    /**
     * Commence une transaction
     */
	public function begin() {
		$this->db->trans_begin();
	}

    /**
     * Commit une transaction
     */
	public function commit() {
		 $this->db->trans_commit();
	}
}
