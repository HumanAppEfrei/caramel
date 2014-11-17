<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Offre_model extends MY_Model
{
    protected $table = 'offres';
	protected $PKey = 'OFF_ID';

	public function select() {
		return $this->db->select('*')->from($this->table);
	}
	
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
	
	public function read_id($id) {
		return $this->db->where('OFF_ID', (string) $id);
	}
	
	public function read_name($name) {
		return $this->db->like('OFF_NOM', (string) $name, 'both');
	}
	
	public function read_camId($id) {
		return $this->db->where('CAM_ID', (string) $id);
	}

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

	//requête qui retourne le nombre d'offre crée sur les 12 derniers mois.
	public function read_nombre_offre_12_mois(){
		return $this->db->query("SELECT EXTRACT(YEAR_MONTH FROM `OFF_DATEADDED`) AS DATE, COUNT(`OFF_ID` ) AS NUMBER
			FROM offres
				GROUP BY EXTRACT(YEAR_MONTH FROM `OFF_DATEADDED`) 
					ORDER BY EXTRACT(YEAR_MONTH FROM `OFF_DATEADDED`)  DESC
						LIMIT 0,12");
	}

	//requête qui retourne le nombre d'offre crée lors des 10 années passées
	public function read_nombre_offre_10_ans(){
		return $this->db->query("SELECT EXTRACT(YEAR FROM `OFF_DATEADDED`) AS YEAR, COUNT(`OFF_ID` ) AS NUMBER
			FROM offres
				GROUP BY EXTRACT(YEAR FROM `OFF_DATEADDED`) 
					ORDER BY EXTRACT(YEAR FROM `OFF_DATEADDED`)  DESC
						LIMIT 0,10");
	}

	// requête qui retourne la somme récoltée par offre
	public function read_somme_recoltee_offre(){
		return $this->db->query("SELECT O.`OFF_NOM` AS NOM, SUM(D.`DON_MONTANT`) AS VALUE
			FROM `dons` D, `offres` O 
				WHERE D.`OFF_ID`=O.`OFF_ID`
					GROUP BY O.`OFF_NOM` ASC");
	}
}