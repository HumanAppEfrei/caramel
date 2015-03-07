<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Classe du model pour les contacts
 */
class Contact_model extends MY_Model {

    /** @var string Nom de la table en base de donnee */
    protected $table = 'contacts';
    /** @var string Nom de la cle primaire */
    protected $PKey = 'CON_ID';


    /**
     * Selectionne tous les elements de la table
     * @return mixed[] Retourne tout les elements de la table
     */
    public function select() {
        return $this->db->select('*')->from($this->table);
    }

    /**
     * Selectionne certains elements de la table (a clarifier)
     * @return mixed[] Retourne certains element de la table
     */
    public function select_hist() {
        return $this->db->select('CON_TYPE, CON_TYPEC, CON_CIVILITE, CON_FIRSTNAME, CON_LASTNAME, CON_DATE, CON_EMAIL, CON_TELFIXE,
            CON_TELPORT, CON_COMPL, CON_VOIE_NUM, CON_VOIE_TYPE, CON_VOIE_NOM, CON_BP, CON_CP, CON_CITY, CON_COUNTRY, CON_NPAI, CON_COMMENTAIRE')->from($this->table);
    }

    /**
     * Selectionne les information d'un contact
     * @param string $contact L'id du contact selectionne
     * @return mixed[] Retourne les informations d'un contact
     */
    public function read_contact($contact) {
        $sql = " CON_ID LIKE '%{$contact}%'
				 OR CON_FIRSTNAME LIKE '%{$contact}%'
				 OR CON_LASTNAME LIKE '%{$contact}%'";
        return $this->db->where($sql, NULL, FALSE);
    }

    /**
     * Selectionne les informations a afficher pour une recherche rapide
     * @param string $contact L'id du contact selectionne
     * @return mixed[] Retourne les informations du contact selectionne
     */
	public function read_quicksearch($contact) {
		if ($contact == null)
			return $this->db;

		$sql = "";
		foreach (array_filter(explode(" ", $contact)) as $valeur)
		{
			if(is_numeric($valeur[0]))
			{
				$sql .= "CON_ID LIKE '%{$valeur}%' AND ";
			}
			else if(strlen($valeur) == 1 OR !is_numeric($valeur[1]))
			{
				$sql .= "(CON_FIRSTNAME LIKE '{$valeur}%'
					  OR CON_LASTNAME LIKE '{$valeur}%') AND ";
			}
			else
			{
				$valeur = substr($valeur, 1);
				$sql .= "CON_CP LIKE '%{$valeur}%' AND ";
			}
		}
		$sql .= "1";

		return $this->db->where($sql);
	}

    /**
     * Recupere les resultats de la requete selectionee
     * @return mixed[] Retourne le(s) resultats(s) de la requete
     */
    public function get_results() {
        return $this->db->get()->result();
    }

    /**
     * Selectionne un contact dans la table
     * @param string $id L'id du contact selectionne
     * @return undefined Retourne le contact dans la table
     */
    public function read_id($id) {
        return $this->db->where('CON_ID', (string) $id);
    }

    /**
     * Selectionne les contact d'un type dans la table
     * @param string $type Le type des contacts selectionnes
     * @return undefined Retourne le(s) contact(s) dans la table du type selectionne
     */
    public function read_type($type) {
        return $this->db->where('CON_TYPE', (string) $type);
    }

    /**
     * Selectionne les contact d'un typeC dans la table
     * @param string $type Le typeC des contacts selectionnes
     * @return undefined Retourne le(s) contact(s) dans la table du typeC selectionne
     */
    public function read_typeC($typeC) {
        return $this->db->where('CON_TYPEC', (string) $typeC);
    }

    /**
     * Selectionne les contacts d'un certain sexe
     * @param string $sexe Le sexe selectionne
     * @return mixed[] Retourne le(s) contact(s) du sexe selectionne
     */
    public function read_sexe($sexe) {
        if ($sexe != "homme") {
            return $this->db->where('CON_CIVILITE !=', 'M.');
        } else {
            return $this->db->where('CON_CIVILITE', 'M.');
        }
    }

    /**
     * Selectionne des contacts en fonction du prenom
     * @param string $firstname Le prenom du contact selectionnee
     * @return mixed[] Retourne le(s) contact(s) avec le prenom selectionne
     */
    public function read_firstname($firstname) {
        return $this->db->like('CON_FIRSTNAME', (string) $firstname, 'after');
    }

    /**
     * Selectionne des contacts en fonction du nom de famille
     * @param string $lastname Le nom de famille du contact selectionnee
     * @return mixed[] Retourne le(s) contact(s) avec le nom de famille selectionne
     */
    public function read_lastname($lastname) {
        return $this->db->like('CON_LASTNAME', (string) $lastname, 'after');
    }

    /**
     * Selectionne des contacts avec un age inferieur ou egal a celui selectionne
     * @param string $age1 L'age du contact selectionnee
     * @return mixed[] Retourne le(s) contact(s) avec l'age selectionne
     */
    public function read_age1($age1) {
        $today = getdate();
        $year = $today['year'] - $age1;
        $date2 = $year . "-" . $today['mon'] . "-" . $today['mday'];
        return $this->db->where('CON_DATE <=', $date2);
    }

    /**
     * Selectionne des contacts avec un age superieur a celui selectionne
     * @param string $age2 L'age du contact selectionnee
     * @return mixed[] Retourne le(s) contact(s) avec l'age selectionne
     */
    public function read_age2($age2) {
        $today = getdate();
        $year = $today['year'] - $age2;
        $date1 = $year . "-" . $today['mon'] . "-" . $today['mday'];
        return $this->db->where('CON_DATE >', $date1);
    }

    /**
     * Selectionne des contacts entre deux annees
     * @param string $annee1 L'annee de debut de selection
     * @param string $annee2 L'annee de fin de selection
     * @return mixed[] Retourne le(s) contact(s) entre les annees
     */
    public function read_annee($annee1, $annee2) {
        $sql_1 = "YEAR(CON_DATE) between '{$annee1}' and '{$annee2}'";
        return $this->db->where($sql_1, null, false);
    }

    /**
     * Selectionne des contacts avec une date d'ajout inferieur ou egal a celle selectionnee
     * @param string $date11 La date d'ajout du contact selectionnee
     * @return mixed[] Retourne le(s) contact(s) avec la date selectionnee
     */
    public function read_by_date($date) {
        //$sql_2 = "YEAR(CON_DATEADDED) = '{$date}' ";
        //return $this->db->where($sql_2, null, false);
        var_dump($this->db->where("DATE_FORMAT(CON_DATEADDED, %Y %m)", $date));
        return null;
        //return $this->db->where("YEAR(CON_DATEADDED)", "YEAR({$date})");
    }

    /**
     * Selectionne des contacts avec une date d'ajout superieur a celle selectionnee
     * @param string $date12 La date d'ajout du contact selectionnee
     * @return mixed[] Retourne le(s) contact(s) avec la date selectionnee
     */
    public function read_date12($date12) {
        $sql_3 = "YEAR(CON_DATEADDED) >= '{$date12}' ";
        return $this->db->where($sql_3, null, false);
    }

    /**
     * Selectionne des contacts en fonction d'un email
     * @param string $mail L'email selectionnee
     * @return mixed[] Retourne le(s) contact(s) selectionnes
     */
    public function read_mail($mail) {
        return $this->db->like('CON_EMAIL', (string) $mail, 'after');
    }

    /**
     * Selectionne des contacts en fonction d'un telephone fixe
     * @param string $fixe Le telephone fixe selectionnee
     * @return mixed[] Retourne le(s) contact(s) selectionnes
     */
    public function read_fixe($fixe) {
        return $this->db->like('CON_TELFIXE', (string) $fixe, 'after');
    }

    /**
     * Selectionne des contacts en fonction d'un telephone portable
     * @param string $portable Le telephone portable selectionnee
     * @return mixed[] Retourne le(s) contact(s) selectionnes
     */
    public function read_portable($portable) {
        return $this->db->like('CON_TELPORT', (string) $portable, 'after');
    }

    /**
     * Selectionne des contacts en fonction d'un complement
     * @param string $complement Le complement selectionnee
     * @return mixed[] Retourne le(s) contact(s) selectionnes
     */
    public function read_complement($complement) {
        return $this->db->like('CON_COMPL', (string) $complement, 'after');
    }

    /**
     * Selectionne des contacts en fonction d'un complement2
     * @param string $complement2 Le complement2 selectionnee
     * @return mixed[] Retourne le(s) contact(s) selectionnes
     */
    public function read_complement2($complement2) {
        return $this->db->like('CON_COMPL2', (string) $complement2, 'after');
    }

    /**
     *  definir
     */
    public function read_bp($bp) {
        return $this->db->like('CON_BP', (string) $bp, 'after');
    }

    /**
     * Selectionne des contacts en fonction d'un code postal
     * @param string $cp Le code postal selectionnee
     * @return mixed[] Retourne le(s) contact(s) selectionnes
     */
    public function read_cp($cp) {
        return $this->db->like('CON_CP', (string) $cp, 'after');
    }

    /**
     * Selectionne des contacts en fonction d'une ville
     * @param string $ville La ville selectionnee
     * @return mixed[] Retourne le(s) contact(s) selectionnes
     */
    public function read_ville($ville) {
        return $this->db->like('CON_CITY', (string) $ville, 'after');
    }

    /**
     * Selectionne des contacts en fonction d'un pays
     * @param string $pays Le pays selectionnee
     * @return mixed[] Retourne le(s) contact(s) selectionnes
     */
    public function read_pays($pays) {
        return $this->db->like('CON_COUNTRY', (string) $pays, 'after');
    }

    /**
     * Selectionne des contacts en fonction d'un commentaire
     * @param string $commentaire Le commentaire selectionnee
     * @return mixed[] Retourne le(s) contact(s) selectionnes
     */
    public function read_commentaire($commentaire) {
        return $this->db->like('CON_COMMENTAIRE', (string) $commentaire, 'after');
    }

    /**
     * Met a jour un contact avec des parametres particuliers
     * @param ??? $params Les parametres a appliquer
     * @param string $id L'id du contact selectionne
     */
    public function update_tuple($params, $id) {
        $this->db->update('contacts', $params, "CON_ID = " . $id);
    }

    /**
     * Supprime un contact
     * @param string $id L'id du contact selectionne
     */
    public function delete_tuple($id) {
        $this->db->delete('contacts', array('CON_ID' => $id));
    }

    /*     * *   Fonctions pour la generation de pdf    *** */

    /**
     * Selectionne le prenom d'un contact
     * @param string $id L'id du client selectionne
     * @return mixed[] Retourne le prenom du contact selectionne
     */
    public function generate_prenom($id) {
        $prenom = $this->read('CON_FIRSTNAME', array('CON_ID' => $id));
        return $prenom[0]->CON_FIRSTNAME;
    }

    /**
     * Selectionne le nom de famille d'un contact
     * @param string $id L'id du client selectionne
     * @return mixed[] Retourne le nom du contact selectionne
     */
    public function generate_nom($id) {
        $nom = $this->read('CON_LASTNAME', array('CON_ID' => $id));
        return $nom[0]->CON_LASTNAME;
    }

    /**
     * Selectionne la civilite d'un contact
     * @param string $id L'id du client selectionne
     * @return mixed[] Retourne la civilite du contact selectionne
     */
    public function generate_civilite($id) {
        $nom = $this->read('CON_CIVILITE', array('CON_ID' => $id));
        return $nom[0]->CON_CIVILITE;
    }

    /**
     * Selectionne l'adresse d'un contact
     * @param string $id L'id du client selectionne
     * @return mixed[] Retourne l'adresse du contact selectionne
     */
    public function generate_adresse($id) {
        $contact = $this->read('CON_CIVILITE,CON_FIRSTNAME,CON_LASTNAME,CON_COMPL,CON_VOIE_NUM,CON_VOIE_TYPE,CON_VOIE_NOM,CON_CP,CON_BP,CON_CITY,CON_COUNTRY', array('CON_ID' => $id));
        foreach ($contact as $con) {
            $adresse = $con->CON_CIVILITE . " " . $con->CON_FIRSTNAME . " " . $con->CON_LASTNAME . "<br/>";
            if ($con->CON_COMPL)
                $adresse = $adresse . $con->CON_COMPL . "<br/>";
            $adresse = $adresse . $con->CON_VOIE_NUM . " " . $con->CON_VOIE_TYPE . " " . $con->CON_VOIE_NOM . "<br/>";
            if ($con->CON_BP)
                $adresse = $adresse . "BP " . $con->CON_BP . "<br/>";
            $adresse = $adresse . $con->CON_CP . " " . $con->CON_CITY . "<br/>";
            $adresse = $adresse . $con->CON_COUNTRY;

            return $adresse;
        }
    }

    /**
     * Selectionne un certain nombde de contact
     * @param integer $limit La limite de selection
     * @param integer $start Le debut de la selection
     * @return mixed[] Retourne le(s) contact(s)
     */
	//limite le nombre de resultat
    public function fetch_contact($limit,$start){
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

    //requête évolution du nombre d'adhérents
    public function read_evolution_nombre_adherents(){
        return $this->db->query("SELECT EXTRACT(YEAR FROM `CON_DATEADDED`) AS YEAR, COUNT(`CON_ID`) AS NOMBRE
            FROM `contacts`
                GROUP BY EXTRACT(YEAR FROM `CON_DATEADDED`)
                    ORDER BY EXTRACT(YEAR FROM `CON_DATEADDED`) LIMIT 0,10");
    }

    //requête évolution nombre de donateurs
    public function read_evolution_donateurs(){
        return $this->db->query("SELECT EXTRACT(YEAR FROM `CON_DATEADDED`) AS YEAR, COUNT(`CON_ID`) AS NOMBRE
            FROM `contacts`
                WHERE CON_TYPEC =\"donateur\"
                    GROUP BY EXTRACT(YEAR FROM `CON_DATEADDED`)
                        ORDER BY EXTRACT(YEAR FROM `CON_DATEADDED`)");
    }
}
