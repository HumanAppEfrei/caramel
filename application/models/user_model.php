<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends MY_Model
{
    protected $table = 'users';
	protected $PKey = 'USER_ID';
	
	//rajouter USER_EMAIL
	public function add_user($firstname,$lastname,$login,$password,$email, $type = 'VISIT')
	{
		$verif = $this->get_user($login);
		
		if( !is_string($firstname) OR !is_string($lastname) OR
            !is_string($password) OR !is_string($login) OR !is_string($type) OR
            !is_string($email) OR
            count($verif)>0)
        {
            return false;
		}
		else {
			return $this->db->set('USER_FIRSTNAME',	 $firstname)
				->set('USER_LASTNAME', 	 $lastname)
				->set('USER_LOGIN', $login)
				->set('USER_PASSWORD', $this->encrypt->encode($password))
				->set('USER_EMAIL', $email)
				->set('USER_DATEADDED', 'NOW()',false)
				->set('USER_TYPE', $type)
				->insert($this->table);
		}
	}
	
	public function count()
	{
		return $this->db->count_all($this->table);
	}
	
	public function remove_user()
	{
		
	}
	
	//récupérer un tableau des variables à modifier
	public function edit_user()
	{
		
	}
	
	public function list_users($nb = 10, $debut = 0)
	{
		return $this->db->select('*')
				->from($this->table)
				->limit($nb, $debut)
				->order_by('USER_LASTNAME', 'USER_FIRSTNAME')
				->get()
				->result();
	}
	
	public function get_user($login)
	{
		return $this->db->select('*')
				->from($this->table)
				->where('USER_LOGIN', $login)
				->limit(1)
				->get()
				->result();
	}
}