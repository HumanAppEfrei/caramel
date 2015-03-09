<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Controller pour la page don
 */
class Don extends MY_Controller {
    /**
     * Affichage de la page des dons
     */
    public function index()
    {
        $nav_data = array();
		$nav_data['username'] = $this->session->userdata('username');

		$this->load->view('base/header');
		$this->load->view('base/navigation',$nav_data);
		$this->load->view('don/quicksearch');

		$this->load->model('pagination_model');
		$this->load->model('don_model');
		$this->load->library('form_validation');

		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$post_form = $this->input->post('is_form_sent');

		$post_search_value = $this->input->get('search', TRUE);
		$url = "index.php/don/quicksearch?search=";
		$config = array();
		$config = $this->pagination_model->template($url,$post_search_value);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$config['total_rows'] = $this->db->count_all_results();
		$this->pagination_model->initialize($config);

		$this->don_model->select();
		$items = $this->don_model->fetch_don($config["per_page"],$this->input->get("per_page"));

		$list_data = array();
		$list_data['items'] = $items;
		$list_data['not_for_contact'] = true;
		$list_data['pagination'] = $this->pagination_model->create_links();
		$nav_data = array();
		$nav_data['username'] = $this->session->userdata('username');

		$this->load->view('don/list', $list_data);
		$this->load->view('base/footer');

    }

 /**
     * Creation d'un nouveau don
     * @param string $id_con L'id du contact donnateur
     */
    public function create($id_con = '')
    {
        $this->load->model('don_model');
        $this->load->model('contact_model');
        $this->load->model('offre_model');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $post_form = $this->input->post('is_form_sent');

        if ($post_form)
        {
            // Récupération des données
            $post_num_contact = $this->input->post('codeCon');
            $post_type_versement = $this->input->post('type_versement');
            $post_montant = $this->input->post('montant');
            $post_mode_paiement = $this->input->post('mode_paiement');
            $post_cheq_num = $this->input->post('cheq_num');
            $post_cheq_compte = $this->input->post('cheq_compte');
            $post_cheq_banq_emission = $this->input->post('cheq_banq_emission');
            $post_cheq_banq_depot = $this->input->post('cheq_banq_depot');
            $post_cheq_date_depot = $this->input->post('cheq_depot_annee')."-".$this->input->post('cheq_depot_mois')."-".$this->input->post('cheq_depot_jour');
            $post_date = $this->input->post('annee')."-".$this->input->post('mois')."-".$this->input->post('jour');
            $post_offre = $this->input->post('offre');
            $post_commentaire = $this->input->post('commentaire');
            $post_montant_flechage = $this->input->post('montant_flechage');
            $post_flechage = $this->input->post('flechage');
            $post_flech_valide = $this->input->post('flech_valide');
            $post_ajout = $this->input->post('ajouts');

            $this->form_validation->set_rules('codeCon', 'Code du Donateur', 'trim|required|numeric|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('montant', 'Montant', 'trim|required|is_natural_no_zero|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('cheq_num', 'Numéro de chèque', 'trim|numeric|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('cheq_compte', 'Numéro de compte', 'trim|numeric|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('cheq_banq_emission', 'Banque d\'émission', 'trim|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('cheq_banq_depot', 'Banque de dépôt', 'trim|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('cheq_depot_jour', 'Jour de dépôt', 'integer|trim|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('cheq_depot_mois', 'Mois de dépôt', 'integer|trim|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('cheq_depot_annee', 'Année de dépôt', 'integer|trim|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('mode', 'mode de versement', 'trim|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('type', 'type de versement', 'trim|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('offre', 'offre liée au versement', 'trim|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('commentaire', 'Commentaires', 'trim|encode_php_tags|xss_clean');

            // Vérification de la date
            $message_date = "";
            if ($post_date == "--") {
                $message_date = "La date du versement doit être renseignée.";
            } else if (!isValidDate(date_usfr($post_date))) {
                $message_date = "La date du versement est invalide";
            }

            if ($post_mode_paiement == "cheque") {
                if ($post_cheq_date_depot == "--") {
                    $message_cheq_date = "La date de dépôt du chèque doit être renseignée";
                } else if (!isValidDate(date_usfr($post_cheq_date_depot))) {
                    $message_cheq_date = "La date de dépôt du chèque est invalide";
                }
            } else {
                $post_cheq_date_depot = null;
            }

			$message_flech="";
			if($post_flech_valide!="true" && $post_montant_flechage==null && $post_flechage==null){
				$message_flech = "Le fléchage ne correspond pas au montant du don.";
			}

            // Vérification du code contact
            $nb = $this->contact_model->count('CON_ID', $post_num_contact);
            $check_contact = ($nb != 0);

            $form_ok = false;
            if($this->form_validation->run() && $post_flech_valide=="true"  && $check_contact && !$message_date /*&& !$message_dateE*/)
            {
                $form_ok = true;

                // Préparation à l'enregistrement
                $options_echappees = array();
                $options_echappees['DON_MONTANT'] = $post_montant;
                $options_echappees['DON_TYPE'] = $post_type_versement;
                $options_echappees['OFF_ID'] = $post_offre;
                $options_echappees['DON_MODE'] = $post_mode_paiement;
                $options_echappees['DON_C_NUM'] = $post_cheq_num;
                $options_echappees['DON_C_COMPTE'] = $post_cheq_compte;
                $options_echappees['DON_C_BANQ_EMISSION'] = $post_cheq_banq_emission;
                $options_echappees['DON_C_BANQ_DEPOT'] = $post_cheq_banq_depot;
                $options_echappees['DON_C_DATE_DEPOT'] = $post_cheq_date_depot;
                $options_echappees['DON_COMMENTAIRE'] = $post_commentaire;
                $options_echappees['CON_ID'] = $post_num_contact;
                $options_echappees['DON_DATE'] = $post_date;

                $options_non_echappees = array();
                $options_non_echappees['DON_DATEADDED'] = 'NOW()';

                $this->don_model->create($options_echappees, $options_non_echappees);

				/*
				 * Traitement du flechage
				 */
                $post_flechage_tmp = array();
                foreach ($post_flechage as $i => $type) {
                    array_push($post_flechage_tmp, $type);
                }

				$don_id = $this->don_model->last_don();
				foreach($post_montant_flechage as $i=>$montant) {
					if($montant != null) {
						$this->don_model->insert_flech($don_id->id, $post_flechage_tmp[$i], $montant);
					}
				}
            }

            $contact = $this->contact_model->select();
            $contact = $this->contact_model->read_id($id_con);
            $contact = $this->contact_model->get_results();

            $list_data = array();
            $list_data['contact'] = $contact;
            $list_data['list_offres'] = $this->offre_model->read_simple('OFF_ID, OFF_NOM');
            $list_data['check_contact'] = $check_contact;
            $list_data['message_date'] = $message_date;
            $list_data['message_flech'] = $message_flech;
            $list_data['type_versement'] = $post_type_versement;
            $list_data['mode_paiement'] = $post_mode_paiement;

            // Récupération des derniers dons ajoutés
            if($form_ok)
            {
                $don = $this->don_model->LastEntryId();
                $post_ajout = $post_ajout.$don[0]->DON_ID;
            }
            $dons_ajoutes = explode(',', $post_ajout);
            $list_data['dons_ajoutes'] = $this->don_model->read_inId($dons_ajoutes);

            $nav_data = array();
            $nav_data['username'] = $this->session->userdata('username');

            $this->load->view('base/header');
            $this->load->view('base/navigation', $nav_data);
            $this->load->view('don/quicksearch');
            $this->load->view('don/create', $list_data);
            $this->load->view('base/footer');
        }
        else    // Formulaire non posté
        {
            $this->contact_model->select();
            $this->contact_model->read_id($id_con);
            $contact = $this->contact_model->get_results();

            $nav_data = array();
            $nav_data['username'] = $this->session->userdata('username');

            $list_data = array();
            $list_data['contact'] = (sizeof($contact) == 0) ? null : $contact[0];   // Si on a récupéré un contact, on le fournit directement
            $list_data['list_offres'] = $this->offre_model->read_simple('OFF_ID, OFF_NOM');
            $list_data['type_versement'] = '';
            $list_data['mode_paiement'] = '';

            $this->load->view('base/header');
            $this->load->view('base/navigation', $nav_data);
            $this->load->view('don/quicksearch');
            $this->load->view('don/create', $list_data);
            $this->load->view('base/footer');
        }
    }

 /**
     * Fait une recherche rapide
     */
    public function quicksearch()
    {
		$this->load->model('pagination_model');
        $this->load->model('don_model');
        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $post_form = $this->input->post('is_form_sent');

        if ($post_form){
			$post_search_value = mysql_real_escape_string($this->input->post('search-value'));
		}
		else {
			$post_search_value = $this->input->get('search', TRUE);
		}
		//configuration de la pagination
		$url = "index.php/don/quicksearch?search=";
		$config = array();
		$config = $this->pagination_model->template($url,$post_search_value);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$post_search_type = $this->input->post('search-type');


		$items = $this->don_model->select();
		if ($post_search_value != "" && $post_search_type == "code") {
			$items = $this->don_model->read_id($post_search_value);
		} else if ($post_search_value != "" && $post_search_type == "source") {
			$items = $this->don_model->read_numAd($post_search_value);
		}
		$config['total_rows'] = $this->db->count_all_results();
		$this->pagination_model->initialize($config);

		// Vérifications des données (pagination)
		if ($this->input->get("per_page") > ($config['total_rows'])){
			$this->index();
		}
		else {

			$items = $this->don_model->select();
			if ($post_search_value != "" && $post_search_type == "code") {
				$items = $this->don_model->read_id($post_search_value);
			} else if ($post_search_value != "" && $post_search_type == "source") {
				$items = $this->don_model->read_numAd($post_search_value);
			}
			$items = $this->don_model->fetch_don($config["per_page"],$this->input->get("per_page"));

			$list_data = array();
			$list_data['items'] = $items;
			$list_data['not_for_contact'] = true;
			$list_data['pagination'] = $this->pagination_model->create_links();
			$nav_data = array();
			$nav_data['username'] = $this->session->userdata('username');

			$this->load->view('base/header');
			$this->load->view('base/navigation', $nav_data);
			$this->load->view('don/quicksearch');
			$this->load->view('don/list', $list_data);
			$this->load->view('base/footer');
		}

    }

    /**
     * Edite un don
     * @param string $id_don L'id du don a editer
     */
    public function edit($id_don)
    {
        $this->load->model('don_model');
        $this->load->model('contact_model');
        $this->load->model('offre_model');

        // Formulaire envoyé ?
        $post_form = $this->input->post('is_form_sent');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($post_form)
        {
            // Récupération des données
            $post_cheq_num = $this->input->post('cheq_num');
            $post_cheq_compte = $this->input->post('cheq_compte');
            $post_cheq_banq_emission = $this->input->post('cheq_banq_emission');
            $post_cheq_banq_depot = $this->input->post('cheq_banq_depot');
            $post_cheq_date_depot = $this->input->post('cheq_depot_annee')."-".$this->input->post('cheq_depot_mois')."-".$this->input->post('cheq_depot_jour');
            $post_commentaire = $this->input->post('commentaire');

            // Verification et redirection formulaire si mauvais
            $this->form_validation->set_rules('cheq_num', 'Numéro de chèque', 'trim|numeric|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('cheq_compte', 'Numéro de compte', 'trim|numeric|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('cheq_banq_emission', 'Banque d\'émission', 'trim|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('cheq_banq_depot', 'Banque de dépôt', 'trim|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('cheq_depot_jour', 'Jour de dépôt', 'integer|trim|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('cheq_depot_mois', 'Mois de dépôt', 'integer|trim|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('cheq_depot_annee', 'Année de dépôt', 'integer|trim|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('commentaire', 'Commentaires', 'trim|encode_php_tags|xss_clean');

            if (!isValidDate(date_usfr($post_cheq_date_depot))) {
                $message_cheq_depot = "La date de dépôt du chèque est invalide";
            }

            if($this->form_validation->run() && !isset($message_cheq_depot))
            {
                // Envoi à la BDD
                $options_echappees = array();
                $options_echappees['DON_C_NUM'] = $post_cheq_num;
                $options_echappees['DON_C_COMPTE'] = $post_cheq_compte;
                $options_echappees['DON_C_BANQ_EMISSION'] = $post_cheq_banq_emission;
                $options_echappees['DON_C_BANQ_DEPOT'] = $post_cheq_banq_depot;
                $options_echappees['DON_C_DATE_DEPOT'] = $post_cheq_date_depot;
                $options_echappees['DON_COMMENTAIRE'] = $post_commentaire;

                $options_non_echappees = array();

                $this->don_model->update(array('DON_ID' => $id_don),$options_echappees, $options_non_echappees);

                redirect('don/edit/'.$id_don, 'refresh');
            }else{
                //	Le formulaire est invalide ou vide
                $list_data = array();
                $this->don_model->select();
                $this->don_model->read_id($id_don);
                $list_data['items'] = $this->don_model->get_results();
                $list_data['offre'] = $this->offre_model->read('OFF_NOM,OFF_ID', array ('OFF_ID' => $list_data['items'] [0]->OFF_ID));
                $list_data['offre'] = $list_data['offre'][0];

                // on rajoute le numéro d'adhérant associé
                $list_data['Num_Ad'] = $this->contact_model->get_numAd($list_data['items'] [0]->CON_ID);

                $nav_data = array();
                $nav_data['username'] = $this->session->userdata('username');

                $this->load->view('base/header');
                $this->load->view('base/navigation',$nav_data);
                $this->load->view('don/quicksearch');
                $this->load->view('don/edit', $list_data);
                $this->load->view('base/footer');
            }
        }

        // Ancienne version github (???)
        //else {  // Formulaire non posté

        // Nouvelle version
        else {
            // affichage
            $items = $this->don_model->select();
            $items = $this->don_model->read_id($id_don);
            $items = $this->don_model->get_results();
        // Fin de discordance des version

            $list_data = array();
            $this->don_model->select();
            $this->don_model->read_id($id_don);
            $list_data['items'] = $this->don_model->get_results();

            if($list_data['items'][0]->OFF_ID != "aucune")
            {
                $list_data['offre'] = $this->offre_model->read('OFF_NOM,OFF_ID', array ('OFF_ID' => $list_data['items'][0]->OFF_ID));
                $list_data['offre'] = $list_data['offre'][0];
            }

            $nav_data = array();
            $nav_data['username'] = $this->session->userdata('username');

            $this->load->view('base/header');
            $this->load->view('base/navigation',$nav_data);
            $this->load->view('don/quicksearch');
            $this->load->view('don/edit', $list_data);
            $this->load->view('base/footer');
        }
    }

 /**
     * Fait une recherche avancee
     */
    public function search()
    {
        $this->load->model('don_model');
        $this->load->model('contact_model');
        $this->load->model('offre_model');
        $post_form = $this->input->post('is_form_sent');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($post_form)
        {
            //Récupération des données
            $post_code = $this->input->post('code');
            $post_codeCon = $this->input->post('codeCon');
            $post_nomCon = $this->input->post('nomCon');
            $post_prenomCon = $this->input->post('prenomCon');
            $post_min = $this->input->post('min');
            $post_max = $this->input->post('max');
            $post_mode_paiement = $this->input->post('mode');
            $post_type_versement = $this->input->post('type-versement');
            $post_offre = $this->input->post('offre');

            // Vérifications des données
            $items = $this->don_model->select();

            if($post_code != "") $items = $this->don_model->read_id($post_code);
            $this->form_validation->set_rules('code', '"Code de don"', 'trim|numeric|encode_php_tags|xss_clean');

            if($post_codeCon!="") $items = $this->don_model->read_numAd($post_codeCon);
            $this->form_validation->set_rules('codeCon', '"Code du donnateur"', 'trim|numeric|encode_php_tags|xss_clean');

            if($post_nomCon!="") $items = $this->don_model->read_lastnameAd($post_nomCon);
            $this->form_validation->set_rules('nomCon', '"Nom du donnateur"', 'trim|alpha_dash|encode_php_tags|xss_clean');

            if($post_prenomCon!="") $items = $this->don_model->read_firstnameAd($post_prenomCon);
            $this->form_validation->set_rules('prenomCon', '"Prénom du donnateur"', 'trim|alpha_dash|encode_php_tags|xss_clean');

            if($post_min!="") $items = $this->don_model->read_montant_min($post_min);
            $this->form_validation->set_rules('min', '"Minimum"', 'trim|numeric|encode_php_tags|xss_clean');

            if($post_max!="") $items = $this->don_model->read_montant_max($post_max);
            $this->form_validation->set_rules('max', '"Maximum"', 'trim|numeric|encode_php_tags|xss_clean');

            if($post_mode_paiement!="") $items = $this->don_model->read_mode($post_mode_paiement);

            if($post_type_versement!="") $items = $this->don_model->read_type($post_type_versement);

            $split = @split(":",$post_offre);
            $offre_code = $split[0];
            if($offre_code!="") $items =  $this->don_model->read_offre($offre_code);

            $items = $this->don_model->get_results();

            if($this->form_validation->run())
            {
                //	Le formulaire est valide
                $list_data = array();
                $list_data['items'] = $items;
                $list_data['div'] = "oui";
                $list_data['elements'] = $this->don_model->count();
                $list_data['not_for_contact'] = true;

                $nav_data = array();
                $nav_data['username'] = $this->session->userdata('username');

                $this->load->view('base/header');
                $this->load->view('base/navigation',$nav_data);
                $this->load->view('don/quicksearch');
                $this->load->view('don/list',$list_data);
                $this->load->view('base/footer');
            }
            else
            {
                //	Le formulaire est invalide ou vide
                $list_data = array();
                $list_data['list_offres'] = $this->offre_model->read_simple('OFF_ID,OFF_NOM');

                $nav_data = array();
                $nav_data['username'] = $this->session->userdata('username');
                $this->load->view('base/header');
                $this->load->view('base/navigation',$nav_data);
                $this->load->view('don/quicksearch');
                $this->load->view('don/search',$list_data);
                $this->load->view('base/footer');
            }
        }
        else
        {
            // affichage
            $list_data = array();
            $list_data['list_offres'] = $this->offre_model->read_simple('OFF_ID,OFF_NOM');

            $nav_data = array();
            $nav_data['username'] = $this->session->userdata('username');
            $this->load->view('base/header');
            $this->load->view('base/navigation',$nav_data);
            $this->load->view('don/quicksearch');
            $this->load->view('don/search',$list_data);
            $this->load->view('base/footer');
        }


    }

    /**
     * Supprime un don
     * @param string $id_don L'id du don a supprimer
     */
    public function remove($id_don)
    {
        $id_don = intval($id_don);
        $this->load->model('don_model');
        $this->don_model->delete(array('DON_ID' => $id_don));
        redirect('/don/quicksearch');
    }

    /* CHANGES Suppression des engagements
    public function respect($id_don)
    {
        $this->load->model('don_model');
        $options_echappees = array();
        //$options_echappees['DON_RESPECT'] = '1';

        $options_non_echappees = array();
        $options_non_echappees['DON_DATERESPECT'] = 'NOW()';
        $this->don_model->update(array('DON_ID' => $id_don),$options_echappees, $options_non_echappees);
        redirect('don/edit/'.$id_don, 'refresh');
    }

    public function unrespect($id_don)
    {
        $this->load->model('don_model');
        $options_echappees = array();
        //$options_echappees['DON_RESPECT'] = '0';

        $options_non_echappees = array();
        $options_non_echappees['DON_DATERESPECT'] = 'null';
        $this->don_model->update(array('DON_ID' => $id_don),$options_echappees, $options_non_echappees);
        redirect('don/edit/'.$id_don, 'refresh');
    } */

 /**
     * Creation d'un recu fiscal
     * @param string $id_don L'id du don selectionne
     */
    public function recu_fiscal($id_don)
    {
        /***
        * Un reçu porte comme ID celui du don qu'il concerne (don #32 = reçu fiscal #32).
        * Si un reçu porte sur plusieurs dons, son ID est celui du dernier don de la liste (dons #32, #33, #56 = reçu fiscal #56).
        *
        * Le paramètre $id_don est un string contenant soit un simple entier pour un don unique,
        * soit une chaine id1-id2-...-idn pour un reçu groupé ("groupe fiscal").
        ***/

        $pathToView = 'application/views/don';

        $this->load->library('mpdf');
        $this->load->model('don_model');
        $this->load->model('offre_model');
        $this->load->model('contact_model');

        // URL avec numéro unique ?
        $url_groupe = strpos($id_don, '-');
        if ($url_groupe === false) {
            // Récupération du don
            $this->don_model->select();
            $this->don_model->read_id($id_don);
            $don_url = $this->don_model->get_results()[0];

            // Recupération du groupe fiscal
            if ($don_url->DON_RECU_ID != null) {
                $this->don_model->select();
                $this->don_model->read_recu_id($don_url->DON_RECU_ID);
                $grp_fiscal = $this->don_model->get_results();
            } else {
                $grp_fiscal = array($don_url);
            }
        } else {
            // Récupération de tous les dons
            $id_dons = explode('-', $id_don);
            $grp_fiscal = array();

            foreach($id_dons as $id) {
                $this->don_model->select();
                $this->don_model->read_id($id);
                $grp_fiscal[] = $this->don_model->get_results()[0];
                // Est-ce que le don a déjà un reçu ?
                if ($grp_fiscal[count($dons) - 1]->DON_RECU_ID != null)
                    $grp_valide = false;
            }
        }

        // Mise à jour des dons (numéro de reçu fiscal)
        if ($don_url->DON_RECU_ID == null OR $url_groupe !== false) {
            foreach($grp_fiscal as $don) {
                $options_echappees = array();
                $options_echappees['DON_RECU_ID'] = $grp_fiscal[count($grp_fiscal) - 1]->DON_ID;
                $this->don_model->update(array('DON_ID' => $don->DON_ID), $options_echappees);
            }
        }

        // Calcul du montant total des dons et vérification du mode de paiement
        $montant_total = 0;
        $mode_paiement = $grp_fiscal[0]->DON_MODE;
        foreach ($grp_fiscal as $don) {
            $montant_total += $don->DON_MONTANT;
            $mode_paiement = ($don->DON_MODE != $mode_paiement) ? "multiple" : $mode_paiement;
        }

        $dernier_don = $grp_fiscal[count($grp_fiscal) - 1];

        // Récupération de l'offre si le don est seul
        if (count($grp_fiscal) == 1) {
            $this->offre_model->select();
            $this->offre_model->read_id($dernier_don->OFF_ID);
            $offre = $this->offre_model->get_results();
            $offre = $offre[0];
        }

        // Récupération du contact et de son adresse
        $this->contact_model->select();
        $this->contact_model->read_id($dernier_don->CON_ID);
        $contact = $this->contact_model->get_results()[0];
        $adresse = $this->contact_model->generate_adresse($contact->CON_ID);

        // Génération du PDF
        $filename = "Recu_fiscal_".$dernier_don->DON_ID.".pdf";
        $this->mpdf->SetImportUse();
        $this->mpdf->UseTemplate(
            $this->mpdf->ImportPage(
                $this->mpdf->SetSourceFile($pathToView.'/recu_fiscal_template.pdf')));

        // Récupère le code HTML depuis le fichier recuFiscal.php
        ob_start();
        include $pathToView.'/recuFiscal.php';
        $html = ob_get_contents();
        ob_end_clean();

        $this->mpdf->WriteHTML($html);
        $this->mpdf->Output($filename, 'I');
    }

    /**
     * Verification de l'existence du donnateur
     */
	public function check_con() {
		$cotisation = 8;
		$this->load->model('contact_model');
		$this->load->model('don_model');

		$codeCon = $_POST['codeCon'];

		//recuperation contact
		$this->contact_model->select();
        $this->contact_model->read_id($codeCon);
        $contact = $this->contact_model->get_results();

		if($contact != '') {
			//requete montant
			$today = date('Y');
			$donation = $this->don_model->get_user_state($codeCon, $today);
			// echo $donation->don;
			if ($donation->don >= $cotisation) {
				// adherent
				echo 'true';
			} else {
				// doit cotiser
				echo $cotisation - $donation->don;
			}
		} else {
			//Donateur inexistant dans la base de donnees
			echo 'false';
		}
	}

    /**
     * Exporte les dons d'un donateur
     * @param string $id_con L'id du contact donateur
     */
    public function export($id_con) {
        $this->load->model('don_model');
        $this->load->model('contact_model');

        $array_contact = array();
        $array_contact = $this->contact_model->select();
        $array_contact = $this->contact_model->read_id($id_con);
        $array_contact = $this->db->get();
        $con = $array_contact->row();

        $id_contact = $con->CON_ID;
        $firstname_contact = $con->CON_FIRSTNAME;
        $lastname_contact = $con->CON_LASTNAME;

        $query = $this->don_model->select();
        $query = $this->don_model->read_numAd($id_con);
        $query = $this->don_model->get();

        $this->load->dbutil();
        $csv = $this->dbutil->csv_from_result($query,";");
        $fileName = $id_contact . '_' .
              $lastname_contact . '_' . $firstname_contact . '_dons.CSV';

        header('Content-Type: application/csv');
        header('Content-Disposition: attachement; filename='.$fileName);
        echo $csv;
    }
}

/* End of file don.php */
/* Location: ./application/controllers/don.php */

