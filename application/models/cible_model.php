<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *  Cible_model est la classe qui definit le model d'une cible.
 */

class Cible_model extends MY_Model
{
    /** @var string Nom de la table en base de donnee */
    protected $table = 'cibles';
    /** @var string Cle primaire dans cette table */
	protected $PKey = 'CIB_ID';

    /**
     * Selectionne tout dans la table
     * @return mixed[] Retourne tous les elements de la table
     */
	public function select() {
		return $this->db->select('*')->from($this->table);
	}

    /**
     * Execute la requete et retourne le(s) resultat(s)
     * @return mixed[] Retourne le(s) resultat(s) de la requete
     */
	public function get_results() {
		return $this->db->get()->result();
	}

    /**
     * Selectionne des cibles en fonction d'une offre
     * @return mixed[] Retourne le(s) cibles(s) de l'offre
     */
	public function get_cible($offre)
	{
		return $this->db->query("SELECT cibles.CON_ID,CON_FIRSTNAME,CON_LASTNAME, DON_MONTANT, DON_ID
								FROM cibles NATURAL JOIN contacts LEFT JOIN dons ON dons.CON_ID = cibles.CON_ID AND dons.OFF_ID = cibles.OFF_ID WHERE cibles.OFF_ID='".$offre."'")
								->result();

	}

    /**
     * Retourne le nombre de cible pour une offre
     * @param string $offre L'id de l'offre selectionnee
     * @return integer Le nombre de cibles pour une offre
     */
	public function comptage_total($offre) {
		return $this->db->query("SELECT cibles.CON_ID,CON_FIRSTNAME,CON_LASTNAME, DON_MONTANT, DON_ID
								FROM cibles NATURAL JOIN contacts LEFT JOIN dons ON dons.CON_ID = cibles.CON_ID AND dons.OFF_ID = cibles.OFF_ID WHERE cibles.OFF_ID='".$offre."'")->num_rows();
	}

    /**
     * Compte le nombre de cibles ayant repondus
     * @param string $offre L'id de l'offre selectionnee
     * @return integer Le nombre de cibles ayant repondus
     */
	public function comptage_repondu($offre) {
		return $this->db->query("SELECT cibles.CON_ID,CON_FIRSTNAME,CON_LASTNAME, DON_MONTANT, DON_ID
								FROM cibles NATURAL JOIN contacts LEFT JOIN dons ON dons.CON_ID = cibles.CON_ID AND dons.OFF_ID = cibles.OFF_ID WHERE dons.DON_MONTANT > 0 AND cibles.OFF_ID='".$offre."'")->num_rows();
	}

    /**
     * A determiner ...
     */
	public function read_doublon($contact, $mission){
		$items = $this->db->select('*')->from($this->table);
		$items = $this->db->where('CON_ID', (string) $contact);
		$items = $this->db->where('MIS_ID', (string) $mission);
		$items = $this->db->get()->result();
		if(empty($items)) return true;
		else return false;
	}

    /**
     * Change l'id d'un element en base
     * @param integer $old_id L'ancien id de l'element
     * @param integer $new_id Le nouveau id de l'element
     */
	public function update_id($old_id,$new_id) {
		$query_data=array('CON_ID'=>$new_id);
		$this->db->update('cibles',$query_data,"CON_ID = ".$old_id);
	}
}
