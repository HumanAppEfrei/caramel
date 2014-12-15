<?php

/**
 * Controlleur de la validation
 */
class validationController extends CI_Controller {
    /**
     * Fonction d'affichage de la page par defaut
     */
	function index()
	{
		$this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('myform');
		}
		else
		{
			$this->load->view('formsuccess');
		}
	}
}
?>
