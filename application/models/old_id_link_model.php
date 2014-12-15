<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Anciens id des liens
 */
class old_id_link_model extends MY_Model
{
    /** @var string Nom de la table */
    protected $table = 'old_id_link';
    /** @var string Cle primaire de la table */
	protected $PKey = 'OLD_CURRENT_ID';

    /**
     * Selectionne tout dans la table
     * @return mixed[] Tous les elements de la table
     */
	public function select() {
		return $this->db->select('*')->from($this->table);
	}

    /**
     * Selectionne tous les resultats de la table
     * @return mixed[] Tous les resultats de la table
     */
	public function get_results() {
		return $this->db->get()->result();
	}

    /**
     * Selectionne un element base sur son id
     * @param string $current_id L'id de l'element selectione
     * @return mixed L'element selectionne
     */
	public function read_current_id($current_id) {
		return $this->db->where('OLD_CURRENT_ID', (string) $current_id);
	}

    /**
     * Selectionne un element base sur son precedent id
     * @param string $past_id L'id de l'element selectione
     * @return mixed L'element selectionne
     */
	public function read_past_id($past_id) {
		return $this->db->where('OLD_PAST_ID', (string) $past_id);
	}

    /**
     * Insere un element ayant un id et un precent id
     * @param string $current_id L'id de l'element
     * @param string $past_id Le precedent id
     */
	public function insert_tuple($current_id,$past_id)
	{
		$this->db->set('OLD_CURRENT_ID',$current_id);
		$this->db->set('OLD_PAST_ID',$past_id);
		$this->db->insert($this->table);
	}

    /**
     * Supprime un element base sur son id
     * @param string $current_id L'id de l'element
     */
	public function delete_with_current_id($current_id)
	{
		$this->db->delete($this->table,array('OLD_CURRENT_ID'=> $current_id));
	}

    /**
     * Supprime un element base sur son precedent id
     * @param string $past_id L'id de l'element
     */
	public function delete_with_past_id($past_id)
	{
		$this->db->delete($this->table,array('OLD_PAST_ID'=> $past_id));
	}

}
