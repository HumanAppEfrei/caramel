<?php

//Faire système de message (redéfinir controlleur?) avec Flashdata
class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('username') === false)
        {
            redirect('login', 'refresh');
        }
    }
}