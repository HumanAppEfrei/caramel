<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller de la page home
 */
class Home extends MY_Controller {

    /**
     * Affichage de la page home
     */
	public function index()
	{
		$nav_data = array();
		$nav_data['username'] = $this->session->userdata('username');

        // teste si l'utilisateur s'est déjà connecté à l'outil
        $this->load->model('user_model');
        $nav_data['first_conn'] = $this->user_model->get_first_conn($nav_data['username']);

        // si c'est la premiere connexion on met à 0 le champs correspondant dans la BDD
        $this->user_model->set_first_conn($nav_data['username']);

		$this->load->view('base/header');
		$this->load->view('base/navigation',$nav_data);
		$this->load->view('base/content');
        $this->load->view('base/footer', $nav_data);

	}
}
