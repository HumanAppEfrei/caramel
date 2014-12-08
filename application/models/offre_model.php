<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Offre_model extends MY_Model
{
    protected $table = 'offres';
	protected $PKey = 'OFF_ID';

	/**
	 * Effectue la requete "SELECT * FROM offres"
	 * @return toutes les lignes de la table 'offres'
	 **/
	public function select() {
		return $this->db->select('*')->from($this->table);
	}
	
	/**
	 * Effectue la requete "SELECT OFF_ID, OFF_NOM, OFF_FIN, DON_MONTANT, DON_ID FROM offres"
	 * @return tous les attributs d'une offre'
	 **/
	public function select_off_att()
	{
		return $this->db->select('offres.OFF_ID, OFF_NOM, OFF_FIN, DON_MONTANT, DON_ID')->from($this->table);
	}

	public function get_results() {
		return $this->db->get()->result();
	}

	public function get_results_att() {
		return $this->db->result();
	}
	
	/**
	 * Liste toutes les offres dont l'id est egale a $id
	 * @param $id correspond a l'id de l'offre que l'on cherche a lister
	 * @return toutes les lignes ou OFF_ID = $id
	 **/
	public function read_id($id) {
		return $this->db->where('OFF_ID', (string) $id);
	}
	
	/**
	 * Liste toutes les offres dont le nom est egale a $name
	 * @param $name (string) correspond au nom de l'offre que l'on cherche a lister
	 * @return toutes les lignes ou OFF_NOM = $name
	 **/
	public function read_name($name) {
		return $this->db->like('OFF_NOM', (string) $name, 'both');
	}

	/**
	 * Liste toutes les offres dont l'id de la campagne est egale a $id
	 * @param $id correspond a l'identifiant de la campagne de l'offre que l'on cherche a lister
	 * @return toutes les lignes ou CAM_ID = $id
	 **/
	public function read_camId($id) {
		return $this->db->where('CAM_ID', (string) $id);
	}

	/**
	 * Liste toutes les offres dont le nom est egale a $name
	 * @param $name (string) correspond au nom de l'offre que l'on cherche a lister
	 * @return toutes les lignes ou OFF_NOM = $name
	 **/
	public function read_donsID() {
		return $this->db->join('dons', 'dons.OFF_ID = offres.OFF_ID');
	}

	public function nb_offres() {
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function nb_rep() {
		return $this->db->where('dons.DON_MONTANT > 0');
	}

	
	public function offre_rattache($con_id) {

		return $this->db->join('cibles', 'offres.OFF_ID = cibles.OFF_ID', 'LEFT OUTER');
	}

	public function reponses_associees($con_id) {
		return $this->db->join('dons', 'dons.CON_ID = cibles.CON_ID AND dons.OFF_ID = cibles.OFF_ID ', 'LEFT OUTER')->where('cibles.CON_ID', (string) $con_id);
	}
	
	public function read_annee_creation($annee) {
		return $this->db->like('OFF_DATEADDED', (string) $annee, 'after');
	}
	
	public function read_mois_creation($mois) {
		$mois = "-" . $mois . "-";
		return $this->db->like('OFF_DATEADDED', (string) $mois, 'both');
	}
}
