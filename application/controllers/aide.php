<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aide extends MY_Controller {

    public function index() {
        $nav_data = array('username' => $this->session->userdata('username'),"lol"=>"lil");
		var_dump($nav_data);

        $this->load->view('base/header');
        $this->load->view('base/navigation', $nav_data);
        $this->load->view('aide/documentation_utilisateur', $nav_data);
        $this->load->view('base/footer');
    }
	
	public function general() {
		$this->load->view('aide/documentation_utilisateur');
	}

}
