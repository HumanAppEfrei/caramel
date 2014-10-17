<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Offre extends MY_Controller {

	public function index()
	{
		$post_form = $this->input->post('is_form_sent');
		
		$nav_data = array();
		$nav_data['username'] = $this->session->userdata('username');
		
		$this->load->view('base/header');
		$this->load->view('base/navigation',$nav_data);
		$this->load->view('offre/quicksearch');
		$this->load->view('base/footer');
	}
	
	public function create($id_cam = '')
	{
		$this->load->model('offre_model');
		$this->load->model('campagne_model');
		$this->load->model('segment_model');
		$this->load->model('cible_model');
		
		$post_form = $this->input->post('is_form_sent');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		if ($post_form)
		{
			//Récupération des données
			$post_code = $this->input->post('code');
			$post_libelle = $this->input->post('libelle');
			$post_debut = $this->input->post('anneed')."-".$this->input->post('moisd')."-".$this->input->post('jourd');
			$post_fin = $this->input->post('anneef')."-".$this->input->post('moisf')."-".$this->input->post('jourf');
			$post_description = $this->input->post('description');
			$post_objectif = $this->input->post('objectif');
			$post_campagne = $this->input->post('campagne');
			$post_segments = $this->input->post('segments');
			
			$message_debut = "";
			$message_fin = "";
			$message_seg = "";

			//vérification
			$this->form_validation->set_rules('code', 'Code', 'trim|required|is_unique[offres.OFF_ID]|max_length[255]|alpha_dash|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('libelle', 'Libellé', 'trim|required|alpha_dash_spaces|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('jourd', 'Jour de début', 'trim|required|max_length[2]|numeric|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('moisd', 'Mois de début', 'trim|required|max_length[2]|numeric|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('anneed', 'Année de début', 'trim|required|max_length[4]|numeric|encode_php_tags|xss_clean');
			if($post_debut != "--" && isValidDate(date_usfr($post_debut)) == false) $message_debut = "La date de début saisie est incorecte";
			$this->form_validation->set_rules('jourf', 'Jour de fin', 'trim|required|max_length[2]|numeric|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('moisf', 'Mois de fin', 'trim|required|max_length[2]|numeric|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('anneef', 'Année de fin', 'trim|required|max_length[4]|numeric|encode_php_tags|xss_clean');
			if($post_fin != "--" && isValidDate(date_usfr($post_fin)) == false) $message_fin = "La date de fin saisie est incorecte";
			$this->form_validation->set_rules('description', 'Description', 'trim|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('objectif', 'Objectif', 'trim|encode_php_tags|numeric|xss_clean');
			$this->form_validation->set_rules('campagne', 'Campagne associée', 'trim|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('segments', 'segments associés', 'trim|required|encode_php_tags|xss_clean');
			
			//vérification date dans un intervalle possible :
			$date_camp = $this->campagne_model->read('CAM_DEBUT,CAM_FIN',array('CAM_ID'=>$post_campagne));
			if(compare_Date($date_camp[0]->CAM_DEBUT,$post_debut) < 0) $message_debut = "L'offre ne peut pas débuter avant le début de la campagne";
			if(compare_Date($post_debut,$post_fin) < 0) $message_debut = "La date de début ne peut pas être superieure à la date de fin";
			if(compare_Date($post_fin,$date_camp[0]->CAM_FIN) < 0) $message_fin = "L'offre ne peut pas finir après la fin de la campagne";
			
			if($this->form_validation->run() && $message_debut=="" && $message_fin=="" && $message_seg == "")
			{
				$this->offre_model->begin();
			
				$options_echappees = array();
				$options_echappees['OFF_ID'] = $post_code;
				$options_echappees['OFF_NOM'] = $post_libelle;
				$options_echappees['OFF_DEBUT'] = $post_debut;
				$options_echappees['OFF_FIN'] = $post_fin;
				$options_echappees['OFF_DESCRIPTION'] = $post_description;
				$options_echappees['OFF_OBJECTIF'] = $post_objectif;
				$options_echappees['CAM_ID'] = $post_campagne;
				$options_echappees['SEGS_CODE'] = $post_segments;
				
				$options_non_echappees = array();
				$options_non_echappees['OFF_DATEADDED'] = 'NOW()';
				$options_non_echappees['OFF_DATEMODIF'] = 'NOW()';
				
				$this->offre_model->create($options_echappees, $options_non_echappees);
				
				//création de la cible de l'offre
				$table_segments = explode(',',$post_segments);
				$cible = $this->segment_model->createCible($table_segments);

				foreach($cible as $contact)
				{
					$options_echappees = array();
					$options_echappees['CON_ID'] = $contact["CON_ID"];
					$options_echappees['OFF_ID'] = $post_code;
					$options_echappees['CIB_SEGS'] = $contact["SEGS"];
					$options_non_echappees = array();
					$this->cible_model->create($options_echappees, $options_non_echappees);
				}
				
				$this->offre_model->commit();
				
				//	Le formulaire est valide
				 redirect('offre/edit/'.$post_code, 'refresh');
				
			}
			else
			{
				//	Le formulaire est invalide ou vide
				$nav_data = array();
				$nav_data['username'] = $this->session->userdata('username');
				
				$campagne = $this->campagne_model->select();
				$campagne = $this->campagne_model->read_id($id_cam);
				$campagne = $this->campagne_model->get_results();
				
				$list_campagnes = $this->campagne_model->read_simple('CAM_ID,CAM_NOM');
				$list_data = array();
				$list_data['campagne'] = $campagne;
				$list_data['list_campagnes'] = $list_campagnes;
				$list_data['message_debut'] = $message_debut;
				$list_data['message_fin'] = $message_fin;
				$list_data['message_seg'] = $message_seg;
				
				$this->load->view('base/header');
				$this->load->view('base/navigation',$nav_data);
				$this->load->view('offre/quicksearch');			
				$this->load->view('offre/create',$list_data);		
				$this->load->view('base/footer');
			}
		}
		
		else
		{
			// affichage
			$nav_data = array();
			$nav_data['username'] = $this->session->userdata('username');
			
			$campagne = $this->campagne_model->select();
			$campagne = $this->campagne_model->read_id($id_cam);
			$campagne = $this->campagne_model->get_results();
			
			$list_campagnes = $this->campagne_model->read_simple('CAM_ID,CAM_NOM');
			$list_data = array();
			$list_data['campagne'] = $campagne;
			$list_data['list_campagnes'] = $list_campagnes;
			
			$this->load->view('base/header');
			$this->load->view('base/navigation',$nav_data);
			$this->load->view('offre/quicksearch');
			$this->load->view('offre/create',$list_data);
			$this->load->view('base/footer');
		}
	}
	
	public function quicksearch()
	{
		$this->load->model('offre_model');
		$post_form = $this->input->post('is_form_sent');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		if ($post_form)
		{		
			//Récupération des données
			$post_selection = $this->input->post('selection');
			$post_recherche = mysql_real_escape_string($this->input->post('recherche'));
			
			// Vérifications des données
			
			$items = $this->offre_model->select();
			
			if($post_recherche!="" && $post_selection=="code") $items = $this->offre_model->read_id($post_recherche);
			if($post_recherche!="" && $post_selection=="libelle") $items = $this->offre_model->read_name($post_recherche);
			
			$items = $this->offre_model->get_results();
	
			$list_data = array();
			$list_data['items'] = $items;
			$list_data['div'] = "oui";
		
			$nav_data = array();
			$nav_data['username'] = $this->session->userdata('username');
		
			$this->load->view('base/header');
			$this->load->view('base/navigation',$nav_data);
			$this->load->view('offre/quicksearch');
			$this->load->view('offre/list',$list_data);
			$this->load->view('base/footer');
		}
		else
		{
			$this->index();
		}
	}
	
	public function search()
	{
		$this->load->model('offre_model');
		$post_form = $this->input->post('is_form_sent');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		if ($post_form)
		{
			//Récupération des données
			$post_code = $this->input->post('code');
			$post_nom = $this->input->post('libelle');
			$post_fin = $this->input->post('fin');
			$post_description = $this->input->post('description');
			$post_objectif = $this->input->post('objectif');
			$post_campagne = $this->input->post('campagne');
			$post_don = $this->input->post('don');
			$post_debut = $this->input->post('anneed')."-".$this->input->post('moisd')."-".$this->input->post('jourd');
			$post_fin = $this->input->post('anneef')."-".$this->input->post('moisf')."-".$this->input->post('jourf');
			
			$message_debut = "";
			$message_fin = "";

			//vérification
			$this->form_validation->set_rules('code', 'Code', 'trim|alpha_dash|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('libelle', 'Libellé', 'trim|alpha_dash_spaces|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('jourd', 'Jour de début', 'trim|max_length[2]|numeric|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('moisd', 'Mois de début', 'trim|max_length[2]|numeric|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('anneed', 'Année de début', 'trim|max_length[4]|numeric|encode_php_tags|xss_clean');
			if($post_debut != "--" && isValidDate(date_usfr($post_debut)) == false) $message_debut = "La date de début saisie est incorecte";
			$this->form_validation->set_rules('jourf', 'Jour de fin', 'trim|max_length[2]|numeric|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('moisf', 'Mois de fin', 'trim|max_length[2]|numeric|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('anneef', 'Année de fin', 'trim|max_length[4]|numeric|encode_php_tags|xss_clean');
			if($post_fin != "--" && isValidDate(date_usfr($post_fin)) == false) $message_fin = "La date de fin saisie est incorecte";
			$this->form_validation->set_rules('description', 'Description', 'trim|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('objectif', 'Objectif', 'trim|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('campagne', 'Campagne associée', 'trim|encode_php_tags|xss_clean');
			
			// Traitement des données
			$items = $this->offre_model->select();
			if($post_code!="") $items = $this->offre_model->read_id($post_code);
			if($post_nom!="") $items = $this->offre_model->read_name($post_nom);			
			$items = $this->offre_model->get_results();
			
			if($this->form_validation->run())
			{
				//	Le formulaire est valide
				$list_data = array();
				$list_data['items'] = $items;
				$list_data['div'] = "oui";
			
				$nav_data = array();
				$nav_data['username'] = $this->session->userdata('username');
			
				$this->load->view('base/header');
				$this->load->view('base/navigation',$nav_data);
				$this->load->view('offre/quicksearch');
				$this->load->view('offre/list',$list_data);
				$this->load->view('base/footer');
			}
			else
			{
				//	Le formulaire est invalide ou vide
				$nav_data = array();
				$nav_data['username'] = $this->session->userdata('username');
				
				$this->load->view('base/header');
				$this->load->view('base/navigation',$nav_data);
				$this->load->view('offre/quicksearch');
				$this->load->view('offre/search');
				$this->load->view('base/footer');
			}
		}
		else
		{
			// affichage
			$nav_data = array();
			$nav_data['username'] = $this->session->userdata('username');
			
			$this->load->view('base/header');
			$this->load->view('base/navigation',$nav_data);
			$this->load->view('offre/quicksearch');
			$this->load->view('offre/search');
			$this->load->view('base/footer');
		}
	}
	
	public function edit($id_offre)
	{
		$this->load->model('offre_model');
		$this->load->model('campagne_model');
		$this->load->model('segment_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$post_form = $this->input->post('is_form_sent');
		
		if ($post_form) 
		{
			$post_libelle = $this->input->post('libelle');
			$post_debut = $this->input->post('anneed')."-".$this->input->post('moisd')."-".$this->input->post('jourd');
			$post_fin = $this->input->post('anneef')."-".$this->input->post('moisf')."-".$this->input->post('jourf');
			$post_description = $this->input->post('description');
			$post_objectif = $this->input->post('objectif');
			//$post_campagne = $this->input->post('campagne');
			
			$message_debut = "";
			$message_fin = "";

			//vérification
			$this->form_validation->set_rules('libelle', 'Libellé', 'trim|required|alpha_dash_spaces|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('jourd', 'Jour de début', 'trim|max_length[2]|numeric|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('moisd', 'Mois de début', 'trim|max_length[2]|numeric|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('anneed', 'Année de début', 'trim|max_length[4]|numeric|encode_php_tags|xss_clean');
			if($post_debut != "--" && isValidDate(date_usfr($post_debut)) == false) $message_debut = "La date de début saisie est incorecte";
			$this->form_validation->set_rules('jourf', 'Jour de fin', 'trim|max_length[2]|numeric|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('moisf', 'Mois de fin', 'trim|max_length[2]|numeric|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('anneef', 'Année de fin', 'trim|max_length[4]|numeric|encode_php_tags|xss_clean');
			if($post_fin != "--" && isValidDate(date_usfr($post_fin)) == false) $message_fin = "La date de fin saisie est incorecte";
			$this->form_validation->set_rules('description', 'Description', 'trim|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('objectif', 'Objectif', 'trim|encode_php_tags|xss_clean');
			//$this->form_validation->set_rules('campagne', 'Campagne associée', 'trim|encode_php_tags|xss_clean');
			
			if($this->form_validation->run() && $message_debut=="" && $message_fin=="")
			{
				$options_echappees = array();
				$options_echappees['OFF_NOM'] = $post_libelle;
				$options_echappees['OFF_DEBUT'] = $post_debut;
				$options_echappees['OFF_FIN'] = $post_fin;
				$options_echappees['OFF_DESCRIPTION'] = $post_description;
				$options_echappees['OFF_OBJECTIF'] = $post_objectif;
				//$options_echappees['CAM_ID'] = $post_campagne;
				
				$options_non_echappees = array();
				$options_non_echappees['OFF_DATEADDED'] = 'NOW()';
				$options_non_echappees['OFF_DATEMODIF'] = 'NOW()';
				
				$this->offre_model->update(array('OFF_ID' => $id_offre),$options_echappees, $options_non_echappees);
				
				redirect('offre', 'refresh');
			}
			else
			{	
				$items = $this->offre_model->select();
				$items = $this->offre_model->read_id($id_offre);
				$items = $this->offre_model->get_results();
				
				$list_data = array();
				$list_data['items'] = $items;
				
				$campagne = $this->campagne_model->read('CAM_ID,CAM_NOM',array('CAM_ID'=>$items[0]->CAM_ID));
				$list_data['campagne'] = $campagne[0];
				
				$list_data['segments'] = explode(",",$items[0]->SEGS_CODE);
				
				$list_data['message_debut'] = $message_debut;
				$list_data['message_fin'] = $message_fin;
			
				$nav_data = array();
				$nav_data['username'] = $this->session->userdata('username');
			
				$this->load->view('base/header');
				$this->load->view('base/navigation',$nav_data);
				$this->load->view('offre/quicksearch');
				$this->load->view('offre/edit', $list_data);
				$this->load->view('base/footer');
			}
		}
		else
		{
			$items = $this->offre_model->select();
			$items = $this->offre_model->read_id($id_offre);
			$items = $this->offre_model->get_results();
			
			$list_data = array();
			$list_data['items'] = $items;
			
			$campagne = $this->campagne_model->read('CAM_ID,CAM_NOM',array('CAM_ID'=>$items[0]->CAM_ID));
			$list_data['campagne'] = $campagne[0];
				
			$list_data['segments'] = explode(",",$items[0]->SEGS_CODE);
		
			$nav_data = array();
			$nav_data['username'] = $this->session->userdata('username');
		
			$this->load->view('base/header');
			$this->load->view('base/navigation',$nav_data);
			$this->load->view('offre/quicksearch');
			$this->load->view('offre/edit', $list_data);
			$this->load->view('base/footer');
		}
	}
	
	public function remove($id_OFF)
	{		
		//suppression cible de l'offre
		$this->load->model('cible_model');
		$this->cible_model->delete(array('OFF_ID'=>$id_OFF));
		//suppresion offre
		$this->load->model('offre_model');
		$this->offre_model->delete(array('OFF_ID'=>$id_OFF));
		
		redirect('offre', 'refresh');
	}
	
	//vérification segment existant
	public function ajax_IsSeg($seg)
	{
		$this->load->model('segment_model');
		$IsSeg = $this->segment_model->read("SEG_CODE",array("SEG_CODE"=>$seg));
		if(!$IsSeg) echo "false";
		else echo "true";
	}
	
}