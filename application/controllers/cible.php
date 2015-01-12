<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cible extends MY_Controller {
	
	public function affich($offre_id)
	{
	//	$line_page = 25; //Nombre de lignes par pages
		$this->load->model('cible_model');
		$this->load->model('offre_model');
		
		$campagne_id = intval($offre_id);
		
	/*	$post_form = $this->input->post('is_form_sent');
		if ($post_form)
		{
			$page = $this->input->post('page');
		}
		else {
			$page = 0;
		} */
		
		$items = $this->cible_model->get_cible($offre_id);

		$nb_cibles = $this->cible_model->comptage_total($offre_id);
		$nb_reponses = $this->cible_model->comptage_repondu($offre_id);
		$list_data = array();
		//$list_data['page'] = $page;
		$list_data['items'] = $items;
		$list_data['nb_cibles'] = $nb_cibles;
		$list_data['nb_reponses'] = $nb_reponses;
		$list_data['offreInfo'] = $this->offre_model->read('OFF_ID,OFF_NOM',array('OFF_ID' => $offre_id));
		
		$nav_data = array();
		$nav_data['username'] = $this->session->userdata('username');
		
		$this->load->view('base/header');
		$this->load->view('base/navigation',$nav_data);
		
		$this->load->view('cible/list',$list_data);	
		$this->load->view('base/footer');

	}
	
	public function search($campagne_id)
	{
		$this->load->model('contact_model');
		$this->load->model('campagne_model');
		$post_form = $this->input->post('is_form_sent');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		if ($post_form)
		{
			//Récupération des données
			$post_numAd = $this->input->post('numAd');
			$post_firstname = $this->input->post('firstname');
			$post_lastname = $this->input->post('lastname');
			$post_personne = $this->input->post('personne');
			$post_type = $this->input->post('type');	
			$post_statut = $this->input->post('statut');
			$post_sexe = $this->input->post('sexe');
			$post_age = $this->input->post('age');
			$post_mail = $this->input->post('mail');
			$post_fixe = $this->input->post('fixe');
			$post_portable = $this->input->post('portable');
			$post_adresse = $this->input->post('adresse');
			$post_cp = $this->input->post('cp');
			$post_ville = $this->input->post('ville');
			$post_pays = $this->input->post('pays');
			$post_commentaire = $this->input->post('commentaire');
			
			// Vérifications des données
			
			$items = $this->contact_model->select();
			
			if($post_numAd!="") $items = $this->contact_model->read_id($post_numAd);
			$this->form_validation->set_rules('numAd', '"Numéro d adhérent"', 'trim|numeric|encode_php_tags|xss_clean');
			
			if($post_firstname!="") $items = $this->contact_model->read_firstname($post_firstname);
			$this->form_validation->set_rules('firstname', '"Prénom"', 'trim|alpha_dash|encode_php_tags|xss_clean');
			
			if($post_lastname!="") $items = $this->contact_model->read_lastname($post_lastname);
			$this->form_validation->set_rules('lastname', '"Nom"', 'trim|alpha_dash|encode_php_tags|xss_clean');
			
			if($post_personne!="") $items = $this->contact_model->read_personne($post_personne);
			
			if($post_type!="") $items = $this->contact_model->read_type($post_type);

			if($post_statut!="") $items = $this->contact_model->read_statut($post_statut);

			if($post_sexe!="") $items = $this->contact_model->read_sexe($post_sexe);
			
			if($post_age!="") $items = $this->contact_model->read_age($post_age);
			$this->form_validation->set_rules('age', '"Age"', 'trim|numeric|encode_php_tags|xss_clean');
			
			if($post_mail!="") $items = $this->contact_model->read_mail($post_mail);
			
			if($post_fixe!="") $items = $this->contact_model->read_fixe($post_fixe);
			$this->form_validation->set_rules('fixe', '"Téléphone fixe"', 'trim|numeric|encode_php_tags|xss_clean');
			
			if($post_portable!="") $items = $this->contact_model->read_portable($post_portable);
			$this->form_validation->set_rules('portable', '"Téléphone portable"', 'trim|numeric|encode_php_tags|xss_clean');
			
			if($post_adresse!="") $items = $this->contact_model->read_adresse($post_adresse);
			
			if($post_cp!="") $items = $this->contact_model->read_cp($post_cp);
			$this->form_validation->set_rules('cp', '"Code postal"', 'trim|numeric|encode_php_tags|xss_clean');
			
			if($post_ville!="") $items = $this->contact_model->read_ville($post_ville);	

			if($post_pays!="") $items = $this->contact_model->read_pays($post_pays);
			
			if($post_commentaire!="") $items = $this->contact_model->read_commentaire($post_commentaire);			
			
			$items = $this->contact_model->get_results();
			
			if($this->form_validation->run())
			{
				//	Le formulaire est valide
				$list_data = array();
				$list_data['items'] = $items;
				$list_data['campagneInfo'] = $this->campagne_model->read('CAM_ID,CAM_NOM',array('CAM_ID' => $campagne_id));
				$list_data['elements'] = $this->contact_model->count();
			
				$nav_data = array();
				$nav_data['username'] = $this->session->userdata('username');
			
				$this->load->view('base/header');
				$this->load->view('base/navigation',$nav_data);
		
				$this->load->view('cible/add',$list_data);
			
				$this->load->view('base/footer'); 
			}
			else
			{
				//	Le formulaire est invalide ou vide
				$list_data = array();
				$list_data['campagne_id'] = $campagne_id;
				$nav_data = array();
				$nav_data['username'] = $this->session->userdata('username');
				$this->load->view('base/header');
				$this->load->view('base/navigation',$nav_data);
				$this->load->view('cible/search',$list_data);
	
				$this->load->view('base/footer');
			}
		}
		else
		{
			// affichage
			$list_data = array();
			$list_data['campagne_id'] = $campagne_id;
			$nav_data = array();
			$nav_data['username'] = $this->session->userdata('username');
			$this->load->view('base/header');
			$this->load->view('base/navigation',$nav_data);
			$this->load->view('cible/search',$list_data);
	
			$this->load->view('base/footer');
		}
	}
	
	public function add($campagne_id)
	{
		$this->load->model('cible_model');
		$this->load->model('contact_model');
		$post_form = $this->input->post('is_form_sent');	
		$items = $this->contact_model->select();
		$items = $this->contact_model->get_results();
		foreach($items as $contact) {
			if($this->input->post($contact->CON_ID) == "ok" && $this->cible_model->read_doublon($contact->CON_ID, $campagne_id)) {
				$options_echappees = array();
				$options_echappees['CON_ID'] = $contact->CON_ID;
				$options_echappees['CAM_ID'] = $campagne_id;
				$options_non_echappees = array();
				$options_non_echappees['CIB_DATEADDED'] = 'NOW()';
				$options_non_echappees['CIB_DATEMODIF'] = 'NOW()';
				$this->cible_model->create($options_echappees, $options_non_echappees);
			}
		}
		redirect('cible/affich/'.$campagne_id, 'refresh');
	}
	
	
	public function remove($id_cam,$id_con)
	{
		$id_cam = intval($id_cam);
		$id_con = intval($id_con);
		$this->load->model('cible_model');
		$this->cible_model->delete(array('CAM_ID' => $id_cam,'CON_ID' => $id_con));
		redirect('cible/affich/'.$id_cam, 'refresh');
	}
	
	
}
