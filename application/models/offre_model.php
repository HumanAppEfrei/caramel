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

	/**
	 * Execution de la requete et retourne le(s) resultat(s)
	 * @return (Mixed[]) le(s) resultat(s) de la requete 
	 */
	public function get_results() {
		return $this->db->get()->result();
	}

	/**
	 * Execution de la requete et retourne le(s) resultat(s)
	 * @return (Mixed[]) le(s) resultat(s) de la requete 
	 */
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

	/**
	 * Retourne le nombre total d'offres 
	 * @return (Int) le nombre total de lignes de la table
	 **/
	public function nb_offres() {
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	/**
	 * Retourne toutes les reponses aux offres.
	 * @return (Mixed[]) l'ensemble des dons ayant un montant superieur a 0
	 */
	public function nb_rep() {
		return $this->db->where('dons.DON_MONTANT > 0');
	}


	/**
	 * Retourne toutes les offres rattachees a un id
	 * @param (Id) l'id des offres recherchees
 	 * @return (Mixed[]) l'ensemble des offres ayant l'id recherche 
	 */
	public function offre_rattache($con_id) {

		return $this->db->join('cibles', 'offres.OFF_ID = cibles.OFF_ID', 'LEFT OUTER');
	}

	/**
	 * Retourne les dons d'un contact associes a une certaine offre
	 * @param (Id) l'id du contact recherche
 	 * @return (Mixed[]) l'ensemble des dons ayant l'id recherche 
	 */
	public function reponses_associees($con_id) {
		return $this->db->join('dons', 'dons.CON_ID = cibles.CON_ID AND dons.OFF_ID = cibles.OFF_ID ', 'LEFT OUTER')->where('cibles.CON_ID', (string) $con_id);
	}

	/**
	 * Selectionne toutes les offres en fonction de leur annee de creation
	 * @param (Date) une annee
	 * @return (Mixed[]) les dons avec la meme annee de creation
	 */
	public function read_annee_creation($annee) {
		return $this->db->like('OFF_DATEADDED', (string) $annee, 'after');
	}

	/**
	 * Selectionne toutes les offres en fonction de leur mois de creation
	 * @param (Date) un mois
	 * @return (Mixed[]) les dons avec le meme mois de creation
	 */
	public function read_mois_creation($mois) {
		$mois = "-" . $mois . "-";
		return $this->db->like('OFF_DATEADDED', (string) $mois, 'both');
	}

	/**
	 * Retourne le nombre d'offre cree sur les 12 derniers mois
	 * @return le nombre d'offre (int) cree sur les 12 derniers mois'
	 */
	public function read_nombre_offre_12_mois(){
		return $this->db->query("SELECT EXTRACT(YEAR_MONTH FROM `OFF_DATEADDED`) AS DATE, COUNT(`OFF_ID` ) AS NUMBER
			FROM offres
				GROUP BY EXTRACT(YEAR_MONTH FROM `OFF_DATEADDED`)
					ORDER BY EXTRACT(YEAR_MONTH FROM `OFF_DATEADDED`)  DESC
						LIMIT 0,12");
	}

	/**
	 * Retourne le nombre d'offres cree lors des 10 dernieres annees'
	 * @return (Int) le nombre d'offres cree lors des 10 annees passees
	 */
	public function read_nombre_offre_10_ans(){
		return $this->db->query("SELECT EXTRACT(YEAR FROM `OFF_DATEADDED`) AS YEAR, COUNT(`OFF_ID` ) AS NUMBER
			FROM offres
				GROUP BY EXTRACT(YEAR FROM `OFF_DATEADDED`)
					ORDER BY EXTRACT(YEAR FROM `OFF_DATEADDED`)  DESC
						LIMIT 0,10");
	}
	
	/**
	 * Retourne la somme des dons recoltee sur une offre
	 * @return (Decimal) la somme recoltee par une offre
	 */
	public function read_somme_recoltee_offre(){
		return $this->db->query("SELECT O.`OFF_NOM` AS NOM, SUM(D.`DON_MONTANT`) AS VALUE
			FROM `dons` D, `offres` O
				WHERE D.`OFF_ID`=O.`OFF_ID`
					GROUP BY O.`OFF_NOM` ASC");
	}
}
