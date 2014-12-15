<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model des criteres
 */
class Critere_model extends MY_Model
{
    /** @var string Nom de la table */
    protected $table = 'criteres';
    /** @var string Nom de la cle primaire */
	protected $PKey = 'CRIT_ID';

    /**
     * Selectionne tout dans la table
     * @return mixed[] Tous les elements de la table
     */
	public function select() {
		return $this->db->select('*')->from($this->table);
	}

    /**
     * Selectionne les resultats de la table
     * @return mixed[] Les resutats de la table
     */
	public function get_results() {
		return $this->db->get()->result();
	}

	///gestion CRITERES LINK
    /**
     * Ajoute un lien dans la table
     * @param string $crit1 Le premier critere
     * @param string $crit2 Le deuxieme critere
     * @param string $link Le lien du critere
     */
	public function addLink($crit1,$crit2,$link) {
		$this->db->set(array('CRIT_ID1' => $crit1,'CRIT_ID2' => $crit2,'LINK' => $link))
				 ->insert('criteres_link');

	}

    /**
     * Met a jour un lien dans la table
     * @param string $crit1 Le premier critere
     * @param string $crit2 Le deuxieme critere
     * @param string $link Le lien du critere
     */
	public function updateLink($crit1,$crit2,$link) {
		$this->db->set(array('LINK' => $link))
					->where(array('CRIT_ID1' => $crit1,'CRIT_ID2' => $crit2))
					->or_where(array('CRIT_ID2' => $crit1))
					->where(array('CRIT_ID1' => $crit2))
					->update('criteres_link');

	}

    /**
     * Recupere un lien de la table en fonction des criteres
     * @param string $crit1 Le premier critere
     * @param string $crit2 Le deuxieme critere
     * @return string Le lien selectionne
     */
	public function getLink($crit1,$crit2) {
		 $resul = $this->db->select('LINK')
						->from('criteres_link')
						->where(array('CRIT_ID1' => $crit1,'CRIT_ID2' => $crit2))
						->or_where(array('CRIT_ID2' => $crit1))
						->where(array('CRIT_ID1' => $crit2))
						->get()
						->result();
			if(empty($resul)) return false;
			return $resul[0]->LINK;

	}

    /**
     * Recupere tous les liens en fonctions de parametres
     * @param string $select Colonnes de la table a selectionner
     * @param array $where Les conditions de selection
     * @return mixed[] Les liens selectionnes
     */
	public function readLinks($select = '*', $where = array()) {

		return $this->db->select($select)
						->from('criteres_link')
						->where($where)
						->get()
						->result();

	}

    /**
     * Verifie si un critere est unique
     * @param string $critID L'id a rechercher dans la table
     * @return true|false Si l'id est deja present dans la table
     */
	public function is_unique_critID($critID) {

		$resul = $this->read('CRIT_ID',array('CRIT_ID' => $critID));

		if($resul) return false;
		return true;

	}


    /**
     * Genere un id unique
     * @param string $segCode Le segment de code qui va servir a la generation
     * @return string Id unique genere
     */
	public function Generate_CritereID($segCode) {

		$resul = $segCode.'_1';
		$cpt=1;
		while(!$this->is_unique_critID($resul))
		{
			$cpt++;
			$resul = $segCode.'_'.$cpt;
		}

		return $resul;

	}

}
