<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {

	public function index()
	{
		$nav_data = array();
		$nav_data['username'] = $this->session->userdata('username');
        
        // Init date
        
		
		$this->load->view('base/header');
		$this->load->view('base/navigation',$nav_data);
		$this->load->view('base/content');		
		$this->load->view('base/footer');
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */