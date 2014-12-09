<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller {

	/**
     * Fonction d'affichage de la page par defaut
	 */
	public function index()
	{
		$nav_data = array();
		$nav_data['username'] = $this->session->userdata('username');

		$this->load->view('base/header');
		$this->load->view('base/navigation',$nav_data);

		$this->load->view('base/content');

		$this->load->view('base/footer');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
