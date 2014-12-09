<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model d'un utilisateur
 */
class User_model extends MY_Model
{
    protected $table = 'users';
	protected $PKey = 'USER_ID';

	//rajouter USER_EMAIL
    /**
     * Fonction d'ajout d'un utilisateur
     * @param string $firstname Le prenom de l'utilisateur
     * @param string $lastname Le nom de l'utilisateur
     * @param string $login Le pseudo de l'utilisateur
     * @param string $password Le mot de passe de l'utilisateur
     * @param string $email L'email de l'utilisateur
     * @param string $type Le type de l'utilisateur
     * @return false|request La requete d'ajout de l'utilisateur
     */
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

    /**
     * Fonction de compte du nombre d'utilisateurs
     * @return integer Le nombre d'utilisateurs
     */
	public function count()
	{
		return $this->db->count_all($this->table);
	}
    /**
     * Fonction qui supprime un utilisateur (a implementer)
     */
	public function remove_user()
	{

	}

	//récupérer un tableau des variables à modifier
    /**
     * Fonction d'edition d'un utilisateur (a implementer)
     */
	public function edit_user()
	{

	}

    /**
     * Fonction qui liste des utilisateurs avec une limite
     * @param int $nb Nombre d'utilisateurs a lister
     * @param int $debut Numero du premier utilisateur a lister
     * @return mixed[] Les utilisateurs selectionnes
     */
	public function list_users($nb = 10, $debut = 0)
	{
		return $this->db->select('*')
				->from($this->table)
				->limit($nb, $debut)
				->order_by('USER_LASTNAME', 'USER_FIRSTNAME')
				->get()
				->result();
	}

    /**
     * Fonction qui recupere un utilisateur base sur son login
     * @param string $login Le login de l'utilisateur
     * @return User L'utilisateur selectionne
     */
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
