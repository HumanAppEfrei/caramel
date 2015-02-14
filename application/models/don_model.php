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
     * @param (Int) un id
     * @return (Mixed[]) les dons avec le meme id
     **/
    public function read_id($id) {
        return $this->db->where($this->table.'.'.$this->PKey, (string) $id);
    }

    /**
     * Selectionne les dons en fonction d'un montant
     * @param (Decimal) un montant
     * @return (Mixed[]) les dons avec un montant superieur au montant saisi
     **/
    public function read_montant_min($min) {
        return $this->db->where('DON_MONTANT >=', $min);
    }

    /**
     * Selectionne tous les montants des dons
     * @return (Mixed[]) les montants des dons
     **/
    public function read_all_montant_with_date(){
        return $this->db->select('DON_MONTANT')->select('DON_DATE')->from($this->table);
    }

    /**
     * Selectionne les dons en fonction d'un montant
     * @param (Decimal) un montant
     * @return (Mixed[]) les dons avec un montant inferieur au montant saisi
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
     * Selectionne les montants des dons en fonction d'un mode de paiement (carte bleu, cheque, espece, virement)
     * @param (Varchar) le mode selectionne
     * @return (Mixed[]) les dons avec le meme mode
     **/
    public function read_montant_from_mode($mode) {
        return $this->db->select('DON_MONTANT')->select('DON_DATE')->where('DON_MODE', (string) $mode)->from($this->table);
    }

    /**
     * Selectionne les dons en fonction d'un type (de versement : nature forcément...)
     * @param (Varchar) le type defini
     * @return (Mixed[]) les dons avec le meme type
     **/
    public function read_type($type) {
        return $this->db->where('DON_TYPE', (string) $type);
    }

    /**
     * Selectionne les dons en fonction d'un numero d'adherent
     * @param (Int) un numero d'adherent
     * @return (Mixed[]) les dons avec le meme numero (va dans la table "contact" pour comparer avec ID)
     **/
    public function read_numAd($numAd) {
        return $this->db->where($this->table.'.CON_ID', (string) $numAd);
    }

    /**
     * Selectionne les dons en fonction du prenom donateur
     * @param (String) un prenom donateur
     * @return (Mixed[]) les dons avec le meme prenom donateur
     **/
    public function read_firstnameAd($firstnameAd) {
        return $this->db->join('contacts as cF', 'cF.CON_ID = dons.CON_ID')->like('cF.CON_FIRSTNAME', (string) $firstnameAd, 'after');
    }

    /**
     * Selectionne les dons en fonction du nom donateur
     * @param (String) un nom donateur
     * @return (Mixed[]) les dons avec le meme nom donateur
     **/
    public function read_lastnameAd($lastnameAd) {
        return $this->db->join('contacts as cL', 'cL.CON_ID = dons.CON_ID')->like('cL.CON_LASTNAME', (string) $lastnameAd, 'after');
    }

    /**
     * Calcul la moyenne de tous les montants des dons
     * @return (Decimal) la moyenne des montants des dons
     **/
    public function read_Stats() {
        return $this->db->select_avg('DON_MONTANT', 'moyenne')->select_min('DON_MONTANT', 'minimum')->select_max('DON_MONTANT', 'maximum')->select_sum('DON_MONTANT','total')->from($this->table);
    }

    /**
     * Selectionne les dons en fonction d'une mission
     * @param (?) une mission
     * @return (Mixed[]) les dons avec la meme mission
     **/
    public function read_mission($mission) {
        return $this->db->where('DON_MISSION', (string) $mission);
    }

    /**
     * Selectionne tous les dons en fonction de plusieurs id
     * @param (String) une liste d'id
     * @return (Mixed[]) les dons avec les memes id
     **/
    public function read_inId($listId) {
        return $this->db->select('*')->from($this->table)
            ->where_in($this->table.'.DON_ID', (array) $listId)
            ->get()->result();
    }

    /**
     * Selectionne tous les dons en fonction de leur annee de creation
     * @param (Date) une annee
     * @return (Mixed[]) les dons avec la meme date de creation
     **/
    public function read_annee_creation($annee) {
        return $this->db->like('DON_DATE', (string) $annee, 'after');
    }

    /**
     * Selectionne tous les dons en fonction de leur mois de creation
     * @param (Date) un mois
     * @return (Mixed[]) les dons avec le meme mois de creation
     **/
    public function read_mois_creation($mois) {
        $mois = "-" . $mois . "-";
        return $this->db->like('DON_DATE', (string) $mois, 'both');
    }

    /**
     * Selectionne tous les dons en fonction de leur campagne associee
     * @param (String) une campagne
     * @return (Mixed[]) les dons avec la campagne associee
     **/
    public function read_campagne($campagne) {
        return $this->db->join('offres', 'offres.OFF_ID = dons.OFF_ID')->where('offres.CAM_ID', (string) $campagne);
    }

    /**
     * Mettre a jour l'id d'un don
     * @param (Int) l'ancien id et le nouvel id
     **/
    public function update_id($old_id,$new_id) {
        $query_data=array('CON_ID'=>$new_id);
        $this->db->update($this->table,$query_data,"CON_ID = ".$old_id);
    }

    /**
     * Selectionne tous les dons en fonction de leur offre associee
     * @param (String) une offre
     * @return (Mixed[]) les dons avec l'offre associee
     **/
    public function read_offre($offre) {
        return $this->db->where('dons.OFF_ID', (string) $offre);
    }

    /**
     * Insert une liaision interne entre ces 3 variables (flechage)
     * @param (Mixed[]) un id, un type de versement, et une offre
     **/
    public function insert_flech($id,$type,$montant){
        $data_flech=array(
            'DON_ID'=>$id,
            'FLECH_MONTANT'=>$montant,
            'FLECH_TYPE' =>$type
        );
        //insert
        $this->db->insert('flechages', $data_flech);
    }

    /**
     * Selectionne tous les dons en fonction d'un ID de reçu fiscal
     * @param (Int) un reçu fiscal
     * @return (Mixed[]) les dons avec le meme ID
     **/
    public function read_recu_id($recu_id) {
        return $this->db->where('dons.DON_RECU_ID', $recu_id);
    }

    /**
     * Obtenir le montant total d'un contact verse sur l'annee
     * @param (Int) un id et une annee
     * @return (Decimal) le montant total
     **/
    public function get_user_state($id, $annee){
        $sql=" SELECT SUM(DON_MONTANT) as don
            FROM dons
            WHERE CON_ID=".$id.
            " AND YEAR(DON_DATE)=".$annee;

        $query = $this->db->query($sql);

        if($query->num_rows()>0) return $query->row();
        else return 0;
    }

    /**
     * Selectionne un don a partir d'une limite et d'un depart
     * @param (?) une limite
     * @return (Mixed[]) ?
     **/
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

    /**
     * Selectionne le dernier don rentre dans la base
     * @return (Mixed[]) le dernier don (rien si aucun don dans la base)
     **/
    public function last_don(){
        $sql = "SELECT MAX(DON_ID) as id
            FROM dons ";

        $query = $this->db->query($sql);

        if($query->num_rows()>0) return $query->row();
        else return 0;
    }

    /**
     * Selectionne les 10 meilleurs dons avec les noms/prenoms des donateurs correspondants
     * @return (Mixed[]) le top 10 des meilleurs dons
     **/
    public function read_stat_top10_montant_avec_nom(){
        return $this->db->select('DON_MONTANT','CON_FIRSTNAME', 'CON_LASTNAME')->join('contacts', 'contacts.CON_ID = dons.CON_ID')->order_by('DON_MONTANT', 'desc')->limit(10);
    }

    /**
     * Selectionne les 10 meilleurs donateurs, tous dons cumulés
     * @return (Mixed[]) le top 10 des meilleurs donateurss
     **/
    public function read_stat_top10_montant_cumule(){
        return $this->db->query("SELECT SUM(`DON_MONTANT` ) AS NUMBER , C.`CON_FIRSTNAME` , C.`CON_LASTNAME`
            FROM  `dons` D,  `contacts` C
            WHERE C.`CON_ID` = D.`CON_ID`
            GROUP BY C.`CON_ID`
            ORDER BY SUM(  `DON_MONTANT` ) DESC
            LIMIT 0 , 10");
    }

    /**
     * Selectionne les 10 meilleures villes donateurs
     * @return (Mixed[]) le top 10 des meilleures villes
     **/
    public function read_stat_top10_ville(){
        return $this->db->query("SELECT  `CON_CITY` , SUM(  `DON_MONTANT` ) AS NUMBER
            FROM  `dons`
            JOIN contacts ON contacts.`CON_ID` = dons.`CON_ID`
            GROUP BY  `CON_CITY`
            ORDER BY SUM(`DON_MONTANT`) DESC
            LIMIT 0 , 10");
    }

    /**
     * Selectionne les dons repartis par nombre de types de dons (un don quoi.. INCOHERENCE DE CETTE FONCTION)
     * @return (Mixed[]) les dons repartis
     **/
    public function percent_type_versement(){
        return $this->db->query("SELECT `DON_TYPE` , COUNT( `DON_TYPE` ) AS NUMBER
            FROM `dons`
            GROUP BY `DON_TYPE`
            ORDER BY COUNT( `DON_TYPE` ) DESC");
    }

    /**
     * Selectionne les dons repartis par nombre de mode de paiement (cheque, carte, nature, etc...)
     * @return (Mixed[]) les dons repartis
     **/
    public function percent_mode_versement(){
        return $this->db->query("SELECT `DON_MODE` , COUNT( `DON_MODE` ) AS NUMBER
            FROM  `dons`
            GROUP BY `DON_MODE`
            ORDER BY COUNT( `DON_MODE` ) DESC");
    }
}
