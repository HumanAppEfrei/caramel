<?php
/**
 * Classe du controller de signin (gestion du login d'un utilisateur)
 */
class Signin extends CI_Controller
{

    /**
     * Affiche la page de login par defaut.
     */
	public function index()
	{
     	$username = $this->session->userdata('username');
     	if ($username === false) {

     		$view_data = array();
     		$view_data['alert'] = $this->session->flashdata('alert');
     		$this->load->view('signin',$view_data);

     	}
     	else {
     		redirect('home', 'refresh');
     	}
	}

    /**
     * Creation de l'utilisateur admin ( une seule fois a la creation du site )
     */
	public function create_admin() {
		$this->load->model('user_model');
		$this->user_model->add_user('John','Doe','admin','admin','john.doe@mail.com','ADMIN');
		redirect('login', 'refresh');
	}


    /**
     * Creation d'un utilisateur, appele a la validation du formulaire
     */
	public function create_user() {

		$this->load->model('user_model');

		$post_firstname = $this->input->post('firstname');
		$post_lastname = $this->input->post('lastname');
		$post_username = $this->input->post('username');
		$post_email = $this->input->post('email');
		$post_password = $this->input->post('password');
		$post_passwordverif = $this->input->post('passwordverif');


		if($post_password != $post_passwordverif) {
			$this->session->set_flashdata('alert', 'Les champs de mot de passe ne sont pas identiques.');
			redirect('login', 'refresh');
		}

		if($this->user_model->add_user($post_firstname, $post_lastname, $post_username, $post_password, $post_email) === false){
			$this->session->set_flashdata('alert', 'Une erreur s\'est produite.');
			redirect('login', 'refresh');
		}
		else {
			$this->session->set_flashdata('alert', 'Votre demande a été prise en compte.');
			redirect('login', 'refresh');
		}

	}

}


//$this->session->set_flashdata('item', 'value');
//$this->session->flashdata('item');
