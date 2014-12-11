<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model des reglages
 */
class Reglage_model extends MY_Model
{
    /** @var string Nom de la table */
    protected $table = 'reglages';
    /** @var string Nom de la cle primaire */
	protected $PKey = 'REG_ID';

    /**
     * Recupere un reglage en fonction de son code
     * @param string $regCode Le code du reglage
     * @return mixed Le reglage selectionne
     */
	public function read($regCode) {
		return $this->db->select('*')->from($this->table)->where(array('REG_CODE'=>$regCode))->get()->result();
	}


}
