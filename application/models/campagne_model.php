<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Don_model est la classe qui definit le modele d'un don
*/
class Don_model extends MY_Model
{
	/** @var (String) Nom de la table dans la BDD */
        protected $table = 'dons';
        /** @var (String) Cle primaire de cette table */
	protected $PKey = 'DON_ID';
	
	/**
	* Selectionne tous les tuples de la table "dons"
	* @return (Mixed[]) tous les dons, mixed[] signifiant plusieurs types possibles
	**/
	public function select() {
		return $this->db->select('*')->from($this->table);
	}
	
	/**
	* Execution de la requete et retourne le(s) resultat(s)
	* @return (Mixed[]) le(s) resultat(s) de la requete
	**/
	public function get_results() {
		return $this->db->get()->result();
	}
    	
    	/**
	* Execution de la requete (determiner la reelle difference avec get_results())
	* @return (Mixed[]) le(s) resultat(s) de la requete
	**/
    	public function get() {
		return $this->db->get();
	}
	
	/**
	* Selectionne les dons en fonction d'un id
	* @param (Int) l'id saisi
	* @return (Mixed[]) les dons avec le meme id
	**/
	public function read_id($id) {
		return $this->db->where($this->table.'.'.$this->PKey, (string) $id);
	}
	
	/**
	* Selectionne les dons en fonction d'un montant
	* @param (Decimal) le montant saisi
	* @return (Mixed[]) les dons avec un montant superieur au montant saisie
	**/
	public function read_montant_min($min) {
		return $this->db->where('DON_MONTANT >=', $min);
	}
	
	/**
	* Selectionne les dons en fonction d'un montant
	* @param (Decimal) le montant saisi
	* @return (Mixed[]) les dons avec un montant inferieur au montant saisie
	**/
	public function read_montant_max($max) {
		return $this->db->where('DON_MONTANT <=', $max);
	}
	
	/**
	* Selectionne les dons en fonction d'un mode (de paiement : carte bleu, cheque, espece, virement)
	* @param (Varchar) le mode selectionne
	* @return (Mixed[]) les dons avec le meme mode 
	**/
	public function read_mode($mode) {
		return $this->db->where('DON_MODE', (string) $mode);
	}
	
	/**
	* Selectionne les dons en fonction d'un type (de versement : carte, cheque, espece, virement)
	* @param (Varchar) le type selectionne
	* @return (Mixed[]) les dons avec le meme type 
	**/
	public function read_type($type) {
		return $this->db->where('DON_TYPE', (string) $type);
	}
	
	/**
	* Selectionne les dons en fonction d'un numero d'adherent
	* @param (Int) le numero d'adherent
	* @return (Mixed[]) les dons avec le meme numero
	**/
	public function read_numAd($numAd) {
		return $this->db->where($this->table.'.CON_ID', (string) $numAd);
	}
	
	public function read_firstnameAd($firstnameAd) {
		return $this->db->join('contacts as cF', 'cF.CON_ID = DONS.CON_ID')->like('cF.CON_FIRSTNAME', (string) $firstnameAd, 'after');
	}
	
	public function read_lastnameAd($lastnameAd) {
		return $this->db->join('contacts as cL', 'cL.CON_ID = DONS.CON_ID')->like('cL.CON_LASTNAME', (string) $lastnameAd, 'after');
	}

	public function read_Stats() {
		return $this->db->select_avg('DON_MONTANT', 'moyenne')->select_min('DON_MONTANT', 'minimum')->select_max('DON_MONTANT', 'maximum')->select_sum('DON_MONTANT','total')->from($this->table);
	}
	
	public function read_mission($mission) {
		return $this->db->where('DON_MISSION', (string) $mission);
	}
	
	public function read_inId($listId) {
		return $this->db->select('*')->from($this->table)
				->where_in($this->table.'.DON_ID', (array) $listId)
				->get()->result();
	}
	
	public function read_annee_creation($annee) {
		return $this->db->like('DON_DATE', (string) $annee, 'after');
	}
	
	public function read_mois_creation($mois) {
		$mois = "-" . $mois . "-";
		return $this->db->like('DON_DATE', (string) $mois, 'both');
	}
	
	public function read_campagne($campagne) {
		return $this->db->join('offres', 'offres.OFF_ID = DONS.OFF_ID')->where('offres.CAM_ID', (string) $campagne);
	}
	
	public function update_id($old_id,$new_id) {
		$query_data=array('CON_ID'=>$new_id);
		$this->db->update($this->table,$query_data,"CON_ID = ".$old_id);
	}

	
	public function read_offre($offre) {
		return $this->db->where('dons.OFF_ID', (string) $offre);
	}
	
	public function insert_flech($id,$type,$montant){
		$data_flech=array(
			'DON_ID'=>$id,
			'FLECH_MONTANT'=>$montant,
			'FLECH_TYPE' =>$type
		);
		//insert
		$this->db->insert('flechages', $data_flech); 
	}
    
    // Retourne les dons dont l'ID du reçu fiscal associé est $recu_id
    public function read_recu_id($recu_id) {
        return $this->db->where('dons.DON_RECU_ID', $recu_id);
    }
    
    public function get_user_state($id, $annee){
		// compter don de l'année de l'user
		$sql=" SELECT SUM(DON_MONTANT) as don
			FROM DONS 
			WHERE CON_ID=".$id.
			" AND YEAR(DON_DATE)=".$annee;
			
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0) return $query->row();
		else return 0;
	}
    
    //limite le nombre de resultat
    public function fetch_don($limit,$start){
        $this->db->limit($limit,$start);
        $query= $this->db->get();
        
        if ($query->num_rows()>0){
            foreach($query->result() as $row){
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
	
	public function last_don(){
		$sql = "SELECT MAX(DON_ID) as id
			FROM DONS ";
			
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0) return $query->row();
		else return 0;
	}

	//requête pour le top 10 des dons, avec les noms des donateurs correspondants.
	public function read_stat_top10_montant_avec_nom(){
		return $this->db->select('DON_MONTANT','CON_FIRSTNAME', 'CON_LASTNAME')->join('contacts', 'contacts.CON_ID = dons.CON_ID')->order_by('DON_MONTANT', 'desc')->limit(10);
	}

	//requête pour le top 10 des donateurs, tous dons cumulés, avec leurs nom
	public function read_stat_top10_montant_cumule(){
		return $this->db->query("SELECT SUM(`DON_MONTANT` ) AS NUMBER , C.`CON_FIRSTNAME` , C.`CON_LASTNAME` 
			FROM  `dons` D,  `contacts` C
				WHERE C.`CON_ID` = D.`CON_ID` 
					GROUP BY C.`CON_ID` 
						ORDER BY SUM(  `DON_MONTANT` ) DESC 
							LIMIT 0 , 10");
	}

	//requête top 10 villes donateurs
	public function read_stat_top10_ville(){
		return $this->db->query("SELECT  `CON_CITY` , SUM(  `DON_MONTANT` ) AS NUMBER
			FROM  `dons` 
				JOIN contacts ON contacts.`CON_ID` = dons.`CON_ID` 
					GROUP BY  `CON_CITY` 
						ORDER BY SUM(`DON_MONTANT`) DESC 
							LIMIT 0 , 10");
	}

	//requête pour avoir la répartition des types de dons (nature, cotisation, don)
	//query plus simple
	public function percent_type_versement(){
		return $this->db->query("SELECT  DON_TYPE , COUNT(  DON_TYPE ) AS NUMBER FROM  dons GROUP BY  DON_TYPE ORDER BY COUNT(  DON_TYPE ) DESC");
	}

	//requête pour avoir la répartition du mode de versement
	public function percent_mode_versement(){
		return $this->db->query("SELECT `DON_MODE` , COUNT(  `DON_MODE` ) AS NUMBER
			FROM  `dons` 
				GROUP BY `DON_MODE`
					ORDER BY COUNT(  `DON_MODE` ) DESC");
	}
}
