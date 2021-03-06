<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller pour la Page Campagne
 */
class Campagne extends MY_Controller {

	/**
     * Affichage de la Page
     */
	public function index()
	{
		$nav_data = array();
		$nav_data['username'] = $this->session->userdata('username');

		$this->load->model('campagne_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

			$post_selection = $this->input->post('selection');
			$post_recherche = mysql_real_escape_string($this->input->post('recherche'));

			// Vérifications des données

			$items = $this->campagne_model->select();

			$items = $this->campagne_model->get_results();

			$list_data = array();
			$list_data['items'] = $items;
			$list_data['div'] = "oui";

			$nav_data = array();
			$nav_data['username'] = $this->session->userdata('username');

			$this->load->view('base/header');
			$this->load->view('base/navigation',$nav_data);
			$this->load->view('campagne/quicksearch');
			$this->load->view('campagne/list',$list_data);
			$this->load->view('base/footer');
	}

	/**
     * Creation d'une nouvelle campagne
     */
	public function create()
	{
		$this->load->model('campagne_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$post_form = $this->input->post('is_form_sent');

		if ($post_form)
		{
			// Récupération des données
			$post_code = $this->input->post('code');
			$post_nom = $this->input->post('nom');
			//$post_debut = $this->input->post('anneed')."-".$this->input->post('moisd')."-".$this->input->post('jourd');
			$post_debut = $this->input->post('datedebut');
			//$post_fin = $this->input->post('anneef')."-".$this->input->post('moisf')."-".$this->input->post('jourf');
			$post_fin = $this->input->post('datefin');

			// Si la date de fin est antérieur à celle du début on affiche un message d'erreur
			if(strtotime($post_fin) < strtotime($post_debut)) 
			{
				$message_date_error = "La date de début est postérieur à la date de fin";
			}

			$post_type = $this->input->post('type');
			$post_description = $this->input->post('description');
			$post_objectif = $this->input->post('objectif') != '' ? $this->input->post('objectif') : null;
			$post_web = $this->input->post('web');
			$post_courrier = $this->input->post('courrier');
			$post_email = $this->input->post('email');

			$message_error = "";

			// Vérification
			$this->form_validation->set_rules('code', 'Code', 'trim|required|max_length[10]|is_unique[campagnes.CAM_ID]|alpha_dash|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('nom', 'Nom', 'trim|required|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('datedebut', 'Date de début', 'trim|required|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('datefin', 'Date de fin', 'trim|required|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'trim|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('objectif', 'Objectif', 'trim|encode_php_tags|numeric|xss_clean');

			if(($post_debut != "--" && isValidDate(date_usfr($post_debut)) == false) || ($post_fin != "--" && isValidDate(date_usfr($post_fin)) == false)) 
				$message_error = "Les dates saisies sont incorectes";

			if($this->form_validation->run() && $message_error=="" && $message_date_error=="")
			{
				//var_dump($post_debut);
				//var_dump($post_fin);

				// Envoie dans la BDD
				$options_echappees = array();
				$options_echappees['CAM_ID'] = $post_code;
				$options_echappees['CAM_NOM'] = $post_nom;
				$options_echappees['CAM_DEBUT'] = $post_debut;
				$options_echappees['CAM_FIN'] = $post_fin;
				$options_echappees['CAM_TYPE'] = $post_type;
				$options_echappees['CAM_DESCRIPTION'] = $post_description;
				$options_echappees['CAM_OBJECTIF'] = $post_objectif;
				$options_echappees['CAM_WEB'] = $post_web;
				$options_echappees['CAM_COURRIER'] = $post_courrier;
				$options_echappees['CAM_EMAIL'] = $post_email;

				$options_non_echappees = array();
				$options_non_echappees['CAM_DATEADDED'] = 'NOW()';
				$options_non_echappees['CAM_DATEMODIF'] = 'NOW()';

				$this->campagne_model->create($options_echappees, $options_non_echappees);

				redirect('campagne/edit/'.$post_code, 'refresh');

			}
			else
			{
				//Le formulaire est invalide ou vide
				$nav_data = array();
				$nav_data['username'] = $this->session->userdata('username');

				$list_data = array();
				//$list_data['message_debut'] = $message_debut;
				//$list_data['message_fin'] = $message_fin;
				$list_data['message_error'] = $message_error;
				$list_data['message_date_error'] = $message_date_error;

				$this->load->view('base/header');
				$this->load->view('base/navigation',$nav_data);
				$this->load->view('campagne/quicksearch');
				$this->load->view('campagne/create',$list_data);
				$this->load->view('base/footer');
			}
		}
		else
		{
			// Affichage
			$nav_data = array();
			$nav_data['username'] = $this->session->userdata('username');

			$this->load->view('base/header');
			$this->load->view('base/navigation',$nav_data);
			$this->load->view('campagne/quicksearch');
			$this->load->view('campagne/create');
			$this->load->view('base/footer');
		}
	}

	/**
     * Faire une recherche rapide
     */
	public function quicksearch()
	{
		$this->load->model('campagne_model');
		$post_form = $this->input->post('is_form_sent');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		if ($post_form)
		{
			// Récupération des données
			$post_selection = $this->input->post('selection');
			$post_recherche = mysql_real_escape_string($this->input->post('recherche'));

			// Vérifications des données

			$items = $this->campagne_model->select();

			if($post_recherche!="" && $post_selection=="code") $items = $this->campagne_model->read_id($post_recherche);
			if($post_recherche!="" && $post_selection=="nom") $items = $this->campagne_model->read_name($post_recherche);


			$items = $this->campagne_model->get_results();

			$list_data = array();
			$list_data['items'] = $items;
			$list_data['div'] = "oui";

			$nav_data = array();
			$nav_data['username'] = $this->session->userdata('username');

			$this->load->view('base/header');
			$this->load->view('base/navigation',$nav_data);
			$this->load->view('campagne/quicksearch');
			$this->load->view('campagne/list',$list_data);
			$this->load->view('base/footer');
		}
		else
		{
			$this->index();
		}
	}

	/**
     * Editer une campagne
     * @param $id_campagne (string) L'id de la campagne à éditer
     */
	public function edit($id_campagne)
	{
		$this->load->model('campagne_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$post_form = $this->input->post('is_form_sent');

		if ($post_form)
		{
			// Récupération des données
			$post_nom = $this->input->post('nom');
			//$post_debut = $this->input->post('anneed')."-".$this->input->post('moisd')."-".$this->input->post('jourd');
			$post_debut = $this->input->post('datedebut');
			//$post_fin = $this->input->post('anneef')."-".$this->input->post('moisf')."-".$this->input->post('jourf');
			$post_fin = $this->input->post('datefin');

			// Si la date de fin est antérieur à celle du début on affiche un message d'erreur
			if(strtotime($post_fin) < strtotime($post_debut)) 
			{
				$message_date_error = "La date de début est postérieur à la date de fin";
			}


			$post_type = $this->input->post('type');
			$post_description = $this->input->post('description');
			$post_objectif = $this->input->post('objectif') != '' ? $this->input->post('objectif') : null;
			$post_web = $this->input->post('web');
			$post_courrier = $this->input->post('courrier');
			$post_email = $this->input->post('email');

			$message_error = "";

			//vérification
			$this->form_validation->set_rules('nom', 'Nom', 'trim|required|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('jourd', 'Jour de début', 'trim|max_length[2]|numeric|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('moisd', 'Mois de début', 'trim|max_length[2]|numeric|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('anneed', 'Année de début', 'trim|max_length[4]|numeric|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('jourf', 'Jour de fin', 'trim|max_length[2]|numeric|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('moisf', 'Mois de fin', 'trim|max_length[2]|numeric|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('anneef', 'Année de fin', 'trim|max_length[4]|numeric|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'trim|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('objectif', 'Objectif', 'trim|encode_php_tags|xss_clean');

			if($post_fin != "--" && isValidDate(date_usfr($post_fin)) == false) $message_error = "La date de fin saisie est incorecte";


			if($this->form_validation->run() && $message_error=="" && $message_date_error=="")
			{
				// Envoie dans la BDD
				$options_echappees = array();
				$options_echappees['CAM_NOM'] = $post_nom;
				$options_echappees['CAM_DEBUT'] = $post_debut;
				$options_echappees['CAM_FIN'] = $post_fin;
				$options_echappees['CAM_TYPE'] = $post_type;
				$options_echappees['CAM_DESCRIPTION'] = $post_description;
				$options_echappees['CAM_OBJECTIF'] = $post_objectif;
				$options_echappees['CAM_WEB'] = $post_web;
				$options_echappees['CAM_COURRIER'] = $post_courrier;
				$options_echappees['CAM_EMAIL'] = $post_email;

				$options_non_echappees = array();
				$options_non_echappees['CAM_DATEMODIF'] = 'NOW()';

				$this->campagne_model->update(array('CAM_ID' => $id_campagne),$options_echappees, $options_non_echappees);

				redirect('campagne', 'refresh');
				//redirect('campagne/edit({$id_campagne})', 'refresh');
			}
			else
			{
				$campagne = $this->campagne_model->read('*',array('CAM_ID' => $id_campagne));

				$list_data = array();
				$list_data['campagne'] = $campagne;
				$list_data['message_error'] = $message_error;
				$list_data['message_date_error'] = $message_date_error;

				$nav_data = array();
				$nav_data['username'] = $this->session->userdata('username');

				$this->load->view('base/header');
				$this->load->view('base/navigation',$nav_data);
				$this->load->view('campagne/quicksearch');
				$this->load->view('campagne/menu', $list_data);
				$this->load->view('campagne/edit', $list_data);
				$this->load->view('base/footer');
			}
		}
		else
		{
			$campagne = $this->campagne_model->read('*',array('CAM_ID' => $id_campagne));

			$list_data = array();
			$list_data['campagne'] = $campagne;

			$nav_data = array();
			$nav_data['username'] = $this->session->userdata('username');

			$this->load->view('base/header');
			$this->load->view('base/navigation',$nav_data);
			$this->load->view('campagne/quicksearch');
			$this->load->view('campagne/menu', $list_data);
			$this->load->view('campagne/edit', $list_data);
			$this->load->view('base/footer');
		}
	}

	/**
     * Faire une recherche avancée
     */
	public function search()
	{
		$this->load->model('campagne_model');
		$post_form = $this->input->post('is_form_sent');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		if ($post_form)
		{
			//Récupération des données
			$post_code = $this->input->post('code');
			$post_nom = $this->input->post('nom');
			//$post_debut = $this->input->post('anneed')."-".$this->input->post('moisd')."-".$this->input->post('jourd');
			$post_debut = $this->input->post('datedebut');
			//$post_fin = $this->input->post('anneef')."-".$this->input->post('moisf')."-".$this->input->post('jourf');
			$post_fin = $this->input->post('datefin');
			$post_type = $this->input->post('type');
			$post_web = $this->input->post('web');
			$post_courrier = $this->input->post('courrier');
			$post_email = $this->input->post('email');
			$post_mediatype = $this->input->post('mediatype');

			// Si la date de fin est antérieur à celle du début on swap
			if(strtotime($post_fin) < strtotime($post_debut)) 
			{
				$post_temp = $post_debut;
				$post_debut = $post_fin;
				$post_fin = $post_temp;
			}

			// Vérifications des données

			$items = $this->campagne_model->select();

			if($post_code!="") $items = $this->campagne_model->read_id($post_code);
			$this->form_validation->set_rules('code', '"Code de campagne"', 'trim|encode_php_tags|xss_clean');

			if($post_nom!="") $items = $this->campagne_model->read_name($post_nom);
			$this->form_validation->set_rules('nom', '"Nom de campagne"', 'trim|encode_php_tags|xss_clean');

			/*$pieces = explode("-", $post_debut);
			$pieces2 = explode("-", $post_fin);
			$message = "";

			if($pieces[0]!="" && $pieces[1]!="" && $pieces[2]!="") $items = $this->campagne_model->read_date_debut($post_debut);
			else if($post_debut=="0000-00-0") $message = "Date de début incorrecte";
			if($pieces2[0]!="" && $pieces2[1]!="" && $pieces2[2]!="") $items = $this->campagne_model->read_date_fin($post_fin);
			else if($post_fin=="0000-00-0") $message = "Date de fin incorrecte";*/


			var_dump($post_debut);
			var_dump($post_fin);
			$this->campagne_model->read_date_debut($post_debut);
			$dump = $this->campagne_model->get_results();
			$this->campagne_model->read_date_fin($post_fin);
			$dump = $this->campagne_model->get_results();
			var_dump($dump);

			if($post_type!="") $items = $this->campagne_model->read_type($post_type);

			if ($post_mediatype=="et") $items = $this->campagne_model->read_media_and($post_web, $post_courrier, $post_email);

			if($post_web=="") $post_web = "pasok";
			if($post_courrier=="") $post_courrier = "pasok";
			if($post_email=="") $post_email = "pasok";

			if($post_mediatype=="ou") $items = $this->campagne_model->read_media_or($post_web, $post_courrier, $post_email);

			// print_r("res : ".$this->campagne_model->get_results());
			$items = $this->campagne_model->get_results();

			if($this->form_validation->run() && $message=="")
			{
				// Le formulaire est valide
				$list_data = array();
				$list_data['items'] = $items;
				$list_data['elements'] = $this->campagne_model->count();
				$list_data['div'] = "oui";

				$nav_data = array();
				$nav_data['username'] = $this->session->userdata('username');

				$this->load->view('base/header');
				$this->load->view('base/navigation',$nav_data);
				$this->load->view('campagne/quicksearch');
				$this->load->view('campagne/list',$list_data);

				$this->load->view('base/footer');
			}
			else
			{
				// Le formulaire est invalide ou vide
				$nav_data = array();
				$nav_data['username'] = $this->session->userdata('username');
				$this->load->view('base/header');
				$this->load->view('base/navigation',$nav_data);
				$search_data = array();
				$search_data['message'] = $message;
				$this->load->view('campagne/search',$search_data);

				$this->load->view('base/footer');
			}
		}
		else
		{
			// Affichage
			$nav_data = array();
			$nav_data['username'] = $this->session->userdata('username');
			$this->load->view('base/header');
			$this->load->view('base/navigation',$nav_data);
			$this->load->view('campagne/quicksearch');
			$this->load->view('campagne/search');

			$this->load->view('base/footer');
		}
	}

    /**
     * Supprimer une campagne
     * @param $id_cam (string) L'id de la Campagne à supprimer
     */
	public function remove($id_cam)
	{
		// Si admin

		$id_cam = intval($id_cam);
		$this->load->model('campagne_model');
		$this->load->model('offre_model');

		$this->offre_model->delete(array('CAM_ID' => $id_cam));
		$this->campagne_model->delete(array('CAM_ID' => $id_cam));
		redirect('campagne', 'refresh');
	}

	/**
     * Lister les offres d'une campagne
     * @param $id_cam (string) L'id de la Campagne dont il faut lister les offres
     */
	public function list_offres($id_cam)
	{
		$this->load->model('offre_model');
		$this->load->model('campagne_model');

		$items = $this->offre_model->select();
		$items = $this->offre_model->read_camId($id_cam);
		$items = $this->offre_model->get_results();

		$campagne = $this->campagne_model->select();
		$campagne = $this->campagne_model->read_id($id_cam);
		$campagne = $this->campagne_model->get_results();

		$list_data = array();
		$list_data['items'] = $items;
		$list_data['campagne'] = $campagne;
		$list_data['div'] = "non";

		$nav_data = array();
		$nav_data['username'] = $this->session->userdata('username');

		$this->load->view('base/header');
		$this->load->view('base/navigation',$nav_data);
		$this->load->view('campagne/quicksearch');
		$this->load->view('campagne/menu', $list_data);
		$this->load->view('offre/list_campagne',$list_data);
		$this->load->view('base/footer');
	}
}
