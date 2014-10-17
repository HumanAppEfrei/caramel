<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contact_model extends MY_Model {

    protected $table = 'contacts';
    protected $PKey = 'CON_ID';

    public function select() {
        return $this->db->select('*')->from($this->table);
    }

    public function select_hist() {
        return $this->db->select('CON_TYPE, CON_TYPEC, CON_CIVILITE, CON_FIRSTNAME, CON_LASTNAME, CON_DATE, CON_EMAIL, CON_TELFIXE,
            CON_TELPORT, CON_COMPL, CON_VOIE_NUM, CON_VOIE_TYPE, CON_VOIE_NOM, CON_BP, CON_CP, CON_CITY, CON_COUNTRY, CON_NPAI, CON_COMMENTAIRE')->from($this->table);
    }

    public function read_contact($contact) {
        $sql = " CON_ID LIKE '%{$contact}%'
				 OR CON_FIRSTNAME LIKE '%{$contact}%'
				 OR CON_LASTNAME LIKE '%{$contact}%'";
        return $this->db->where($sql, NULL, FALSE);
    }
	
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

    public function get_results() {
        return $this->db->get()->result();
    }

    public function read_id($id) {
        return $this->db->where('CON_ID', (string) $id);
    }

    public function read_type($type) {
        return $this->db->where('CON_TYPE', (string) $type);
    }

    public function read_typeC($typeC) {
        return $this->db->where('CON_TYPEC', (string) $typeC);
    }

    public function read_sexe($sexe) {
        if ($sexe != "homme") {
            return $this->db->where('CON_CIVILITE !=', 'M.');
        } else {
            return $this->db->where('CON_CIVILITE', 'M.');
        }
    }

    public function read_firstname($firstname) {
        return $this->db->like('CON_FIRSTNAME', (string) $firstname, 'after');
    }

    public function read_lastname($lastname) {
        return $this->db->like('CON_LASTNAME', (string) $lastname, 'after');
    }

    public function read_age1($age1) {
        $today = getdate();
        $year = $today['year'] - $age1;
        $date2 = $year . "-" . $today['mon'] . "-" . $today['mday'];
        return $this->db->where('CON_DATE <=', $date2);
    }

    public function read_age2($age2) {
        $today = getdate();
        $year = $today['year'] - $age2;
        $date1 = $year . "-" . $today['mon'] . "-" . $today['mday'];
        return $this->db->where('CON_DATE >', $date1);
    }

    public function read_annee($annee1, $annee2) {
        $sql_1 = "YEAR(CON_DATE) between '{$annee1}' and '{$annee2}'";
        return $this->db->where($sql_1, null, false);
    }

    public function read_date11($date11) {
        $sql_2 = "YEAR(CON_DATEADDED) = '{$date11}' ";
        return $this->db->where($sql_2, null, false);
    }

    public function read_date12($date12) {
        $sql_3 = "YEAR(CON_DATEADDED) >= '{$date12}' ";
        return $this->db->where($sql_3, null, false);
    }

    public function read_mail($mail) {
        return $this->db->like('CON_EMAIL', (string) $mail, 'after');
    }

    public function read_fixe($fixe) {
        return $this->db->like('CON_TELFIXE', (string) $fixe, 'after');
    }

    public function read_portable($portable) {
        return $this->db->like('CON_TELPORT', (string) $portable, 'after');
    }

    public function read_complement($complement) {
        return $this->db->like('CON_COMPL', (string) $complement, 'after');
    }

    public function read_complement2($complement2) {
        return $this->db->like('CON_COMPL2', (string) $complement2, 'after');
    }

    public function read_bp($bp) {
        return $this->db->like('CON_BP', (string) $bp, 'after');
    }

    public function read_cp($cp) {
        return $this->db->like('CON_CP', (string) $cp, 'after');
    }

    public function read_ville($ville) {
        return $this->db->like('CON_CITY', (string) $ville, 'after');
    }

    public function read_pays($pays) {
        return $this->db->like('CON_COUNTRY', (string) $pays, 'after');
    }

    public function read_commentaire($commentaire) {
        return $this->db->like('CON_COMMENTAIRE', (string) $commentaire, 'after');
    }

    public function update_tuple($params, $id) {
        $this->db->update('contacts', $params, "CON_ID = " . $id);
    }

    public function delete_tuple($id) {
        $this->db->delete('contacts', array('CON_ID' => $id));
    }

    /*     * *   Fonctions pour la generation de pdf    *** */

    public function generate_prenom($id) {
        $prenom = $this->read('CON_FIRSTNAME', array('CON_ID' => $id));
        return $prenom[0]->CON_FIRSTNAME;
    }

    public function generate_nom($id) {
        $nom = $this->read('CON_LASTNAME', array('CON_ID' => $id));
        return $nom[0]->CON_LASTNAME;
    }

    public function generate_civilite($id) {
        $nom = $this->read('CON_CIVILITE', array('CON_ID' => $id));
        return $nom[0]->CON_CIVILITE;
    }

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

}
