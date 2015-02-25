<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Classe de contact
 */
class Contact extends MY_Controller {

    /**
     * Affichage de la page des contacts
     */
    public function index() {
        $post_form = $this->input->post('is_form_sent');

        $nav_data = array();
        $nav_data['username'] = $this->session->userdata('username');

        $this->load->view('base/header');
        $this->load->view('base/navigation', $nav_data);
        $this->load->view('contact/quicksearch');

		$this->load->model("pagination_model");
        $this->load->model('contact_model');

			$post_recherche = $this->input->get('search', TRUE);

		//configuration de la pagination
				$url = "index.php/contact/quicksearch?search=";
		$config = array();
		$config = $this->pagination_model->template($url,$post_recherche);

		$this->contact_model->select();
		$this->contact_model->read_quicksearch($post_recherche);
        //pagination
		$config['total_rows'] = $this->db->count_all_results();
        $this->pagination->initialize($config);
			$items = $this->contact_model->select();
			$items = $this->contact_model->read_quicksearch($post_recherche);
			$items = $this->contact_model->fetch_contact($config["per_page"],$this->input->get("per_page"));

			$list_data = array();
			$list_data['items'] = $items;
			$list_data['div'] = "oui";
			$list_data['pagination'] = $this->pagination->create_links();
			$nav_data = array();
			$nav_data['username'] = $this->session->userdata('username');

			$this->load->view('contact/list', $list_data);
			$this->load->view('base/footer');
    }

    /**
     * Creation d'un contact
     */
    public function create() {
        $this->load->model('contact_model');
        $this->load->model('reglage_model');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $post_form = $this->input->post('is_form_sent');

        if ($post_form) {
            // Récupération des données
            $post_type = $this->input->post('type');
            $post_typeC = $this->input->post('typeC');
            $post_civilite = $this->input->post('civilite');
            $post_firstname = $this->input->post('firstname');
            $post_firstname = explode('-', $post_firstname);
            $arraytemp = array();
            $i = 0;
            foreach ($post_firstname as $firstname_temp) {
                $arraytemp[$i] = ucfirst($firstname_temp);
                $i++;
            }
            $post_firstname = implode('-', $arraytemp);
            $post_lastname = $this->input->post('lastname');
            $post_lastname = strtoupper($post_lastname);
            $post_date = $this->input->post('annee') . "-" . $this->input->post('mois') . "-" . $this->input->post('jour');
            $post_email = $this->input->post('email');
            $post_telFixe = $this->input->post('telFixe');
            $post_telPort = $this->input->post('telPort');
            $post_complement = $this->input->post('complement');
            $post_voie_num = $this->input->post('voie_num');
            $post_voie_type = $this->input->post('voie_type');
            $post_voie_nom = $this->input->post('voie_nom');
            $post_bp = $this->input->post('bp');
            $post_cp = $this->input->post('cp');
            $post_city = $this->input->post('city');
            $post_country = $this->input->post('country');
            $post_npai = '0';
            $post_commentaire = $this->input->post('commentaire');

            $nb = strlen($post_civilite);
            $nb = $nb + 1; // espace
            $nb = $nb + strlen($post_firstname);
            $nb = $nb + 1; // espace
            $nb = $nb + strlen($post_lastname);

            $nb_local = strlen($post_cp);
            $nb_local = $nb_local + 1; // espace
            $nb_local = $nb_local + strlen($post_city);

            $message_identification = "";
            $message_localite = "";
            $message_date = "";

            // Vérifications
            if ($post_type == "physique") {
                $this->form_validation->set_rules('firstname', 'Prénom', 'trim|max_length[38]|required|alpha_dash_no_num|encode_php_tags|xss_clean');
            } else {
                $this->form_validation->set_rules('firstname', 'Prénom', 'trim|max_length[38]|alpha_dash_no_num|encode_php_tags|xss_clean');
            }
            $this->form_validation->set_rules('lastname', 'Nom', 'trim|max_length[38]|required|alpha_dash_no_num|encode_php_tags|xss_clean');
            if ($nb > 38) {
                $message_identification = "Le champ Identification ne peut contenir plus de 38 caractères.";
            }
            $this->form_validation->set_rules('complement', 'Complément', 'trim|max_length[38]|alpha_dash_spaces|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('complement2', 'Complément 2', 'trim|max_length[38]|alpha_dash_spaces|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('voie_num', 'Numéro de voie', 'trim|max_length[4]|numeric|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('voie', 'Voie', 'trim|max_length[38]|alpha_dash_spaces|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('bp', 'Boite Postale', 'trim|max_length[38]|numeric|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('cp', 'Code Postal', 'trim|max_length[38]|numeric|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('city', 'Ville', 'trim|max_length[38]|alpha_dash_spaces|encode_php_tags|xss_clean');
            if ($nb_local > 38)
                $message_localite = "Le champ Localité (CP + Ville) ne peut contenir plus de 38 caractères.";
            $this->form_validation->set_rules('country', 'Country', 'trim|max_length[38]|alpha_dash_spaces|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('email', 'EMail', 'trim|valid_email|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('jour', 'Jour', 'trim|max_length[2]|numeric|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('mois', 'Mois', 'trim|max_length[2]|numeric|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('annee', 'Année', 'trim|max_length[4]|numeric|encode_php_tags|xss_clean');
            if ($post_date != "--" && isValidDate(date_usfr($post_date)) == false)
                $message_date = "La date saisie est incorecte";
            $this->form_validation->set_rules('telFixe', 'Téléphone fixe', 'trim|numeric|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('telPort', 'Téléphone portable', 'trim|numeric|encode_php_tags|xss_clean');

            if ($this->form_validation->run() && $message_identification == "" && $message_localite == "" && $message_date == "") {
                // Envoie dans la BDD
                $options_echappees = array();
                $options_echappees['CON_TYPE'] = $post_type;
                $options_echappees['CON_TYPEC'] = $post_typeC;
                $options_echappees['CON_CIVILITE'] = $post_civilite;
                $options_echappees['CON_FIRSTNAME'] = $post_firstname;
                $options_echappees['CON_LASTNAME'] = $post_lastname;
                $options_echappees['CON_DATE'] = ($post_date == '--') ? null : $post_date;
                $options_echappees['CON_EMAIL'] = $post_email;
                $options_echappees['CON_TELFIXE'] = $post_telFixe;
                $options_echappees['CON_TELPORT'] = $post_telPort;
                $options_echappees['CON_COMPL'] = $post_complement;
                $options_echappees['CON_VOIE_NUM'] = $post_voie_num == '' ? null : $post_voie_num;
                $options_echappees['CON_VOIE_TYPE'] = $post_voie_type;
                $options_echappees['CON_VOIE_NOM'] = $post_voie_nom;
                $options_echappees['CON_BP'] = $post_bp;
                $options_echappees['CON_CP'] = $post_cp;
                $options_echappees['CON_CITY'] = $post_city;
                $options_echappees['CON_COUNTRY'] = $post_country;
                $options_echappees['CON_NPAI'] = $post_npai;
                $options_echappees['CON_COMMENTAIRE'] = $post_commentaire;
                $options_echappees['CON_RF_TYPE'] = 'never';
                $options_echappees['CON_SOLICITATION'] = 'not';
                $options_non_echappees = array();
                $options_non_echappees['CON_DATEADDED'] = 'NOW()';
                $options_non_echappees['CON_DATEMODIF'] = 'NOW()';

                $this->contact_model->create($options_echappees, $options_non_echappees);

                //	Le formulaire est valide
                $contact = $this->contact_model->LastEntryId();
                redirect('contact/edit/' . $contact[0]->CON_ID, 'refresh');
            } else {
                //	Le formulaire est invalide ou vide
                $list_data = array();
                $list_data['message_identification'] = $message_identification;
                $list_data['message_localite'] = $message_localite;
                $list_data['message_date'] = $message_date;

                //ajout parametres de champ concernant contact
                $Options_civil = $this->reglage_model->read('CON_CIVIL');
                $Options_morale = $this->reglage_model->read('CON_MORALE');
                $Options_physique = $this->reglage_model->read('CON_PHYSIQUE');

                if ($Options_civil)
                    $list_data['Options_civil'] = explode(',', $Options_civil[0]->REG_LIST);
                if ($Options_morale)
                    $list_data['Options_morale'] = explode(',', $Options_morale[0]->REG_LIST);
                if ($Options_physique)
                    $list_data['Options_physique'] = explode(',', $Options_physique[0]->REG_LIST);

                $nav_data = array();
                $nav_data['username'] = $this->session->userdata('username');

                $this->load->view('base/header');
                $this->load->view('base/navigation', $nav_data);
                $this->load->view('contact/quicksearch');
                $this->load->view('contact/create', $list_data);
                $this->load->view('base/footer');
            }
        } else {
            $nav_data = array();
            $nav_data['username'] = $this->session->userdata('username');

            //ajout parametres de champ concernant contact
            $Options_civil = $this->reglage_model->read('CON_CIVIL');
            $Options_morale = $this->reglage_model->read('CON_MORALE');
            $Options_physique = $this->reglage_model->read('CON_PHYSIQUE');

            $list_data = array();
            if ($Options_civil)
                $list_data['Options_civil'] = explode(',', $Options_civil[0]->REG_LIST);
            if ($Options_morale)
                $list_data['Options_morale'] = explode(',', $Options_morale[0]->REG_LIST);
            if ($Options_physique)
                $list_data['Options_physique'] = explode(',', $Options_physique[0]->REG_LIST);

            $this->load->view('base/header');
            $this->load->view('base/navigation', $nav_data);
            $this->load->view('contact/quicksearch');
            $this->load->view('contact/create', $list_data);
            $this->load->view('base/footer');
        }
    }

    /**
     * Rechercher rapide
     */
    public function quicksearch() {
		$this->load->model("pagination_model");
        $this->load->model('contact_model');
        $post_form = $this->input->post('is_form_sent');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		if ($post_form){
			$post_recherche = mysql_real_escape_string($this->input->post('recherche'));
		}
		else {
			$post_recherche = $this->input->get('search', TRUE);
		}

		//configuration de la pagination
        $url = "index.php/contact/quicksearch?search=";
		$config = array();
		$config = $this->pagination_model->template($url,$post_recherche);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;


		//Récupération des données
		// $post_selection = $this->input->post('selection');

		$this->contact_model->select();
		$this->contact_model->read_quicksearch($post_recherche);
        //pagination
		$config['total_rows'] = $this->db->count_all_results();
        $this->pagination->initialize($config);
		// Vérifications des données
		if ($this->input->get("per_page") > ($config['total_rows'])){
			$this->index();
		}
		else {
			$items = $this->contact_model->select();
			//$items = $this->contact_model->read_contact($post_recherche);
			$items = $this->contact_model->read_quicksearch($post_recherche);
			$items = $this->contact_model->fetch_contact($config["per_page"],$this->input->get("per_page"));

			$list_data = array();
			$list_data['items'] = $items;
			$list_data['div'] = "oui";
			$list_data['pagination'] = $this->pagination->create_links();
			$nav_data = array();
			$nav_data['username'] = $this->session->userdata('username');

			$this->load->view('base/header');
			$this->load->view('base/navigation', $nav_data);
			$this->load->view('contact/quicksearch');
			$this->load->view('contact/list', $list_data);
			$this->load->view('base/footer');
			}
    }

    /**
     * Recherche avancee
     */
    public function search() {
        $this->load->model('contact_model');
        $post_form = $this->input->post('is_form_sent');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($post_form) {
            //Récupération des données
            $post_numAd = $this->input->post('numAd');
            $post_type = $this->input->post('type');
            $post_typeC = $this->input->post('typeC');
            $post_sexe = $this->input->post('sexe');
            $post_firstname = $this->input->post('firstname');
            $post_lastname = $this->input->post('lastname');
            $post_age1 = $this->input->post('age1');
            $post_age2 = $this->input->post('age2');
            $post_mail = $this->input->post('email');
            $post_telFixe = $this->input->post('telFixe');
            $post_telPort = $this->input->post('telPort');
            $post_complement = $this->input->post('complement');
            //$post_complement2 = $this->input->post('complement2');
            $post_voie = $this->input->post('voie');
            $post_bp = $this->input->post('bp');
            $post_cp = $this->input->post('cp');
            $post_city = $this->input->post('city');
            $post_country = $this->input->post('country');
            $post_commentaire = $this->input->post('commentaire');

            // Vérifications
            $this->form_validation->set_rules('numAd', '"Numéro d adhérent"', 'trim|numeric|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('firstname', 'Prénom', 'trim|max_length[38]|alpha_dash_no_num|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('lastname', 'Nom', 'trim|max_length[38]|alpha_dash_no_num|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('complement', 'Complément', 'trim|max_length[38]|alpha_dash_spaces|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('complement2', 'Complément 2', 'trim|max_length[38]|alpha_dash_spaces|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('voie', 'Voie', 'trim|max_length[38]|alpha_dash_spaces|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('bp', 'Boite Postale', 'trim|max_length[38]|numeric|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('cp', 'Code Postal', 'trim|max_length[38]|numeric|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('city', 'Ville', 'trim|max_length[38]|alpha_dash_spaces|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('country', 'Country', 'trim|max_length[38]|alpha_dash_spaces|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('email', 'EMail', 'trim|valid_email|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('age1', 'Age 1', 'trim|max_length[3]|numeric|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('age2', 'Age 2', 'trim|max_length[3]|numeric|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('telFixe', 'Téléphone fixe', 'trim|numeric|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('telPort', 'Téléphone portable', 'trim|numeric|encode_php_tags|xss_clean');

            // Traitement des données
            $msg_alert = "";
            $items = $this->contact_model->select();
            if ($post_numAd != "")
                $items = $this->contact_model->read_id($post_numAd);
            if ($post_type != "")
                $items = $this->contact_model->read_type($post_type);
            if ($post_typeC != "")
                $items = $this->contact_model->read_typeC($post_typeC);
            if ($post_sexe != "")
                $items = $this->contact_model->read_sexe($post_sexe);
            if ($post_firstname != "")
                $items = $this->contact_model->read_firstname($post_firstname);
            if ($post_lastname != "")
                $items = $this->contact_model->read_lastname($post_lastname);
            if ($post_age1 != "") {
                if ($post_age1 <= 0 || $post_age1 >= 200) {
                    $msg_alert = "L'age doit etre compris entre 0 et 200";
                } else {
                    $items = $this->contact_model->read_age1($post_age1);
                }
            }
            if ($post_age2 != "") {
                if ($post_age2 < 0 || $post_age2 > 200) {
                    $msg_alert = "L'age doit etre compris entre 0 et 200";
                } else {
                    $items = $this->contact_model->read_age2($post_age2);
                }
            }
            if ($post_mail != "")
                $items = $this->contact_model->read_mail($post_mail);
            if ($post_telFixe != "")
                $items = $this->contact_model->read_fixe($post_telFixe);
            if ($post_telPort != "")
                $items = $this->contact_model->read_portable($post_telPort);
            if ($post_complement != "")
                $items = $this->contact_model->read_complement($post_complement);
            //if($post_complement2!="") $items = $this->contact_model->read_complement2($post_complement2);
            if ($post_voie != "")
                $items = $this->contact_model->read_voie($post_voie);
            if ($post_bp != "")
                $items = $this->contact_model->read_bp($post_bp);
            if ($post_cp != "")
                $items = $this->contact_model->read_cp($post_cp);
            if ($post_city != "")
                $items = $this->contact_model->read_ville($post_city);
            if ($post_country != "")
                $items = $this->contact_model->read_pays($post_country);
            if ($post_commentaire != "")
                $items = $this->contact_model->read_commentaire($post_commentaire);
            $items = $this->contact_model->get_results();

            if ($this->form_validation->run() && $msg_alert == "") {
                //	Le formulaire est valide
                $list_data = array();
                $list_data['items'] = $items;
                $list_data['div'] = "oui";

                $nav_data = array();
                $nav_data['username'] = $this->session->userdata('username');

                $this->load->view('base/header');
                $this->load->view('base/navigation', $nav_data);
                $this->load->view('contact/quicksearch');
                $this->load->view('contact/list', $list_data);
                $this->load->view('base/footer');
            } else {
                //	Le formulaire est invalide ou vide
                $nav_data = array();
                $nav_data['username'] = $this->session->userdata('username');
                $list_data['msg_alert'] = $msg_alert;

                $this->load->view('base/header');
                $this->load->view('base/navigation', $nav_data);
                $this->load->view('contact/quicksearch');
                $this->load->view('contact/search', $list_data);
                $this->load->view('base/footer');
            }
        } else {
            // affichage
            $nav_data = array();
            $nav_data['username'] = $this->session->userdata('username');

            $this->load->view('base/header');
            $this->load->view('base/navigation', $nav_data);
            $this->load->view('contact/quicksearch');
            $this->load->view('contact/search');
            $this->load->view('base/footer');
        }
    }

    /**
     * Edition d'un contact en fonction de son id
     * @param string $id L'id du contact a editer
     */
    public function edit($id_con) {
        $this->load->model('contact_model');
        $this->load->model('reglage_model');
        $this->load->model('historique_model');
        $this->load->model('tables_names_model');
        $this->load->model('tables_fields_model');
        $this->load->helper('dateconv_helper');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        $message_identification = $message_localite = $message_date = null;

        if ($this->input->post('is_form_sent')) {
            //Règles de validation du formulaire
            if ($this->input->post('type') == "physique")
                $this->form_validation->set_rules('firstname', 'Prénom', 'trim|required|alpha_dash_no_num|encode_php_tags|xss_clean');
            else
                $this->form_validation->set_rules('firstname', 'Prénom', 'trim|max_length[38]|alpha_dash_no_num|encode_php_tags|xss_clean');

            if (strlen($this->input->post('civilite')) + strlen($this->input->post('firstname')) + strlen($this->input->post('lastname')) + 2 > 38)
                $message_identification = "Le champ Identification (Civilité + Nom + Prénom) ne peut contenir plus de 38 caractères.";

            if (strlen($this->input->post('cp')) + strlen($this->input->post('city')) + 1 > 38)
                $message_localite = "Le champ Localité (CP + Ville) ne peut contenir plus de 38 caractères.";

            $post_date = $this->input->post('annee') . "-" . $this->input->post('mois') . "-" . $this->input->post('jour');
            if ($post_date != "--" && isValidDate(date_usfr($post_date)) == false)
                $message_date = "La date saisie est incorecte";

            $this->form_validation->set_rules('lastname', 'Nom', 'trim|required|alpha_dash_no_num|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('complement', 'Complément', 'trim|max_length[38]|alpha_dash_spaces|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('complement2', 'Complément 2', 'trim|max_length[38]|alpha_dash_spaces|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('voie', 'Voie', 'trim|max_length[38]|alpha_dash_spaces|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('bp', 'Boite Postale', 'trim|max_length[38]|numeric|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('cp', 'Code Postal', 'trim|max_length[38]|numeric|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('city', 'Ville', 'trim|max_length[38]|alpha_dash_spaces|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('country', 'Country', 'trim|max_length[38]|alpha_dash_spaces|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('email', 'EMail', 'trim|valid_email|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('jour', 'Jour', 'trim|max_length[2]|numeric|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('mois', 'Mois', 'trim|max_length[2]|numeric|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('annee', 'Année', 'trim|max_length[4]|numeric|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('telFixe', 'Téléphone fixe', 'trim|numeric|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('telPort', 'Téléphone portable', 'trim|numeric|encode_php_tags|xss_clean');
        }

        //Enregistrement en base de données
        if ($this->input->post('is_form_sent') && $this->form_validation->run() && $message_identification == "" && $message_date == "" && $message_localite == "") {
            $escaped_data = array();
            $escaped_data['CON_TYPE'] = $this->input->post('type');
            $escaped_data['CON_TYPEC'] = $this->input->post('typeC');
            $escaped_data['CON_CIVILITE'] = $this->input->post('civilite');
            $escaped_data['CON_FIRSTNAME'] = $this->input->post('firstname');
            $escaped_data['CON_LASTNAME'] = $this->input->post('lastname');
            $escaped_data['CON_DATE'] = $this->input->post('date') == '--' ? null : $this->input->post('date');
            $escaped_data['CON_EMAIL'] = $this->input->post('email');
            $escaped_data['CON_TELFIXE'] = $this->input->post('telFixe');
            $escaped_data['CON_TELPORT'] = $this->input->post('telPort');
            $escaped_data['CON_COMPL'] = $this->input->post('complement');
            $escaped_data['CON_VOIE_NUM'] = $this->input->post('voie_num') == '' ? null : $this->input->post('voie_num');
            $escaped_data['CON_VOIE_TYPE'] = $this->input->post('voie_type');
            $escaped_data['CON_VOIE_NOM'] = $this->input->post('voie_nom');
            $escaped_data['CON_BP'] = $this->input->post('bp');
            $escaped_data['CON_CP'] = $this->input->post('cp');
            $escaped_data['CON_CITY'] = $this->input->post('city');
            $escaped_data['CON_COUNTRY'] = $this->input->post('country');
            $escaped_data['CON_NPAI'] = $this->input->post('npai');
            $escaped_data['CON_COMMENTAIRE'] = $this->input->post('commentaire');
            $non_escaped_data = array('CON_DATEMODIF' => 'NOW()');

            //Historique
            $this->contact_model->select_hist();
            $this->contact_model->read_id($id_con);
            $contact = $this->contact_model->get_results();

            $old_data = get_object_vars($contact[0]);

            $this->tables_names_model->select_tabl_id();
            $this->tables_names_model->read_name('contacts');
            $tabl_id = $this->tables_names_model->get_results();

            $hist_tabl_id = get_object_vars($tabl_id[0]);
            $hist_tabl_id = $hist_tabl_id['TABL_ID'];

            foreach ($old_data as $key => $value) {
                if ($old_data[$key] != $escaped_data[$key]) {
                    $hist_data = array();
                    $hist_data['HIST_TABL_ID'] = $hist_tabl_id;
                    $hist_data['HIST_TABL_PKEY'] = $id_con;

                    $this->tables_fields_model->select_field_id();
                    $this->tables_fields_model->read_field($key);
                    $field_id = $this->tables_fields_model->get_results();

                    $hist_field_id = get_object_vars($field_id[0]);
                    $hist_data['HIST_FIELD_ID'] = $hist_field_id['TABL_FIELD_ID'];

                    $hist_data['HIST_FIELD_VALUE'] = $value;
                    $hist_data['HIST_MODIF_TYPE'] = 0;
                    $non_escaped_hist_data['HIST_DATETIME'] = 'NOW()';

                    $this->historique_model->create($hist_data, $non_escaped_hist_data);
                }
            }

            $this->contact_model->update(array('CON_ID' => $id_con), $escaped_data, $non_escaped_data);
            redirect(current_url(), 'refresh');
        } else {
            $contact = $this->contact_model->select();
            $contact = $this->contact_model->read_id($id_con);
            $contact = $this->contact_model->get_results();

            $data = array('contact' => $contact);
            $nav_data = array('username' => $this->session->userdata('username'));

            $Options_civil = $this->reglage_model->read('CON_CIVIL');
            $Options_morale = $this->reglage_model->read('CON_MORALE');
            $Options_physique = $this->reglage_model->read('CON_PHYSIQUE');

            if ($Options_civil)
                $data['Options_civil'] = explode(',', $Options_civil[0]->REG_LIST);
            if ($Options_morale)
                $data['Options_morale'] = explode(',', $Options_morale[0]->REG_LIST);
            if ($Options_physique)
                $data['Options_physique'] = explode(',', $Options_physique[0]->REG_LIST);

            $this->load->view('base/header');
            $this->load->view('base/navigation', $nav_data);
            $this->load->view('contact/quicksearch');
            $this->load->view('contact/menu', $data);
            $this->load->view('contact/edit', $data);
            $this->load->view('base/footer');
        }
    }

    /**
     * Fonction de suppression d'un contact
     * @param string $segCode L'id du sement a supprimer
     */
    public function remove($id_con) {
        $id_con = intval($id_con);
        $this->load->model('contact_model');
        $this->load->model('cible_model');
        $this->cible_model->delete(array('CON_ID' => $id_con));
        $this->contact_model->delete(array('CON_ID' => $id_con));
        redirect('contact', 'refresh');
    }

    /**
     * Fonction d'affichage de la liste des dons en fonction d'un contact
     * @param string $id L'id du contact selectionne
     */
    public function list_dons($id_con) {
        $this->load->model('don_model');
        $this->load->model('contact_model');

        $items = $this->don_model->select();
        $items = $this->don_model->read_numAd($id_con);
        $items = $this->don_model->get_results();

        $stats = $this->don_model->read_stats();
        $stats = $this->don_model->read_numAd($id_con);
        $stats = $this->don_model->get_results();

        $contact = $this->contact_model->select();
        $contact = $this->contact_model->read_id($id_con);
        $contact = $this->contact_model->get_results();

        $list_data = array();
        $list_data['items'] = $items;
        $list_data['stats'] = $stats;
        $list_data['contact'] = $contact;
        $list_data['not_for_contact'] = false;

        // Calcul des statistiques sur les reçus fiscaux
        $list_data['nbDonsSansRecu'] = 0;
        $list_data['urlDonsSansRecu'] = "";
        foreach ($items as $don) {
            if ($don->DON_RECU_ID == null) {
                $list_data['nbDonsSansRecu']++;
                $list_data['urlDonsSansRecu'] .= $don->DON_ID."-";
            }
        }
        $list_data['urlDonsSansRecu'] = rtrim($list_data['urlDonsSansRecu'], '-');


        $nav_data = array();
        $nav_data['username'] = $this->session->userdata('username');

        $this->load->view('base/header');
        $this->load->view('base/navigation', $nav_data);
        $this->load->view('contact/quicksearch');
        $this->load->view('contact/menu', $list_data);
        $this->load->view('don/list', $list_data);
        $this->load->view('base/footer');
    }

    /**
     * Liste et affiche les informations complementaires d'un contact
     * @param string $id_con L'id du contact selectionne
     */
    public function infos_comp($id_con) {
        $this->load->model('infos_comp_model');
        $this->load->model('contact_model');
        $this->load->model('contacts_ic_model');
        $post_form = $this->input->post('is_form_sent');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($post_form) {
            $items = $this->infos_comp_model->select();
            $items = $this->infos_comp_model->get_results();

            foreach ($items as $item) {
                $data = $this->input->post($item->IC_ID);
                $options_echappees = array();
                $options_echappees[$item->IC_ID] = $data;
                $options_non_echappees = array();

                $infos_comp_contact = $this->contacts_ic_model->select();
                $infos_comp_contact = $this->contacts_ic_model->read_id($id_con);
                $infos_comp_contact = $this->contacts_ic_model->get_results();

                if (!empty($infos_comp_contact))
                    $this->contacts_ic_model->update(array('CON_ID' => $id_con), $options_echappees, $options_non_echappees);
                else {
                    $options_echappees['CON_ID'] = $id_con;
                    $this->contacts_ic_model->create($options_echappees, $options_non_echappees);
                }
            }
            redirect('contact/infos_comp/' . $id_con, 'refresh');
        } else {
            $items = $this->infos_comp_model->select();
            $items = $this->infos_comp_model->get_results();

            $infos_comp_contact = $this->contacts_ic_model->select();
            $infos_comp_contact = $this->contacts_ic_model->read_id($id_con);
            $infos_comp_contact = $this->contacts_ic_model->get_results();

            $contact = $this->contact_model->select();
            $contact = $this->contact_model->read_id($id_con);
            $contact = $this->contact_model->get_results();

            $list_data = array();
            $list_data['items'] = $items;
            $list_data['contact'] = $contact;
            $list_data['infos_comp_contact'] = $infos_comp_contact;

            $nav_data = array();
            $nav_data['username'] = $this->session->userdata('username');

            $this->load->view('base/header');
            $this->load->view('base/navigation', $nav_data);
            $this->load->view('contact/quicksearch');
            $this->load->view('contact/menu', $list_data);
            $this->load->view('infos_comp/list_contact', $list_data);
            $this->load->view('base/footer');
        }
    }

    /**
     * Liste les offres d'un contact
     * @param string $id_con L'id du contact selectionne
     */
    public function list_offres($id_con) {
        $this->load->model('offre_model');
        $this->load->model('contact_model');
        $this->load->model('don_model');



        //Liste offres associées au contact
        $nb_offres_att = $this->offre_model->select_off_att();
        $nb_offres_att = $this->offre_model->offre_rattache($id_con);
        $nb_offres_att = $this->offre_model->reponses_associees($id_con);
        $nb_offres_att = $this->offre_model->nb_offres();

        $items = $this->offre_model->select_off_att();
        $items = $this->offre_model->offre_rattache($id_con);
        $items = $this->offre_model->reponses_associees($id_con);
        $items = $this->offre_model->get_results();

        $list_reponses = $this->offre_model->select_off_att();
        $list_reponses = $this->offre_model->offre_rattache($id_con);
        $list_reponses = $this->offre_model->reponses_associees($id_con);
        $list_reponses = $this->offre_model->nb_rep();
        $nb_offres_rep = $this->offre_model->nb_offres();


        $contact = $this->contact_model->select();
        $contact = $this->contact_model->read_id($id_con);
        $contact = $this->contact_model->get_results();

        $list_data = array();
        $list_data['items'] = $items;
        $list_data['contact'] = $contact;
        $list_data['nb_reponses'] = $nb_offres_rep; //$nb_reponses;
        $list_data['nb_offres'] = $nb_offres_att; //$nb_offres;
        $list_data['div'] = "non";

        $nav_data = array();
        $nav_data['username'] = $this->session->userdata('username');

        $this->load->view('base/header');
        $this->load->view('base/navigation', $nav_data);
        $this->load->view('contact/quicksearch');
        $this->load->view('contact/menu', $list_data);
        $this->load->view('offre/list_contact', $list_data);
        $this->load->view('base/footer');
    }

    /**
     * Affiche l'historique des actions d'un contact
     * @param string $id_con L'id du contact selectionne
     */
    public function historique($id_con) {
        $this->load->model('contact_model');
        $this->load->model('historique_model');
        $this->load->model('tables_names_model');
        $this->load->model('tables_fields_model');

        $this->contact_model->select();
        $this->contact_model->read_id($id_con);
        $contact = $this->contact_model->get_results();
        $data = array('contact' => $contact);

        //récupération du tabl_id
        $tabl_id_array = $this->tables_names_model->select_tabl_id_where('contacts');
        $tabl_id_array = get_object_vars($tabl_id_array[0]);
        $tabl_id = $tabl_id_array['tabl_id'];

        $this->historique_model->read_contacts_historic($id_con, $tabl_id);
        $history = $this->historique_model->get_results();
        $history_array = array('history' => $history, 'contact' => $contact);

        $this->load->view('base/header');
        $this->load->view('base/navigation', $this->session->userdata('username'));
        $this->load->view('contact/quicksearch');
        $this->load->view('contact/menu', $data);
        $this->load->view('contact/history', $history_array);
        $this->load->view('base/footer');
    }

    /**
     * Restaure les donnees de l'historique
     * @param string $id_con L'id du contact selectionne
     * @param date $date La date de debut de restauration
     * @param time $time Le temps de restauration
     */
    public function restauration($id_con, $date, $time) {
        $this->load->model('contact_model');
        $this->load->model('historique_model');
        $this->load->model('tables_names_model');
        $this->load->model('tables_fields_model');

        if (isset($_POST['submit'])) {
            unset($_POST['submit']);

            //historique
            $this->contact_model->select_hist();
            $this->contact_model->read_id($id_con);
            $contact = $this->contact_model->get_results();
            $contact = get_object_vars($contact[0]);

            //prise en compte de la population pour l'attribution des id
            $this->tables_names_model->select_tabl_id();
            $this->tables_names_model->read_name('contacts');
            $tabl_id = $this->tables_names_model->get_results();
            $hist_tabl_id = get_object_vars($tabl_id[0]);
            $hist_tabl_id = $hist_tabl_id['TABL_ID'];

            //intersection entre éléments du formulaire et données contact
            $contact_modified_field = array();
            foreach ($_POST as $key => $value) {
                foreach ($contact as $contact_key => $contact_value) {
                    if ($key == $contact_key) {
                        $contact_modified_field[$contact_key] = $contact_value;
                    }
                }
            }

            //création de l'historique pour chaque champ modifié
            foreach ($contact_modified_field as $key => $value) {
                $hist_data = array();
                $hist_data['HIST_TABL_ID'] = $hist_tabl_id;
                $hist_data['HIST_TABL_PKEY'] = $id_con;

                $this->tables_fields_model->select_field_id();
                $this->tables_fields_model->read_field($key);
                $field_id = $this->tables_fields_model->get_results();

                $hist_field_id = get_object_vars($field_id[0]);
                $hist_data['HIST_FIELD_ID'] = $hist_field_id['TABL_FIELD_ID'];

                $hist_data['HIST_FIELD_VALUE'] = $value;
                $hist_data['HIST_MODIF_TYPE'] = 1;
                $non_escaped_hist_data['HIST_DATETIME'] = 'NOW()';

                $this->historique_model->create($hist_data, $non_escaped_hist_data);
            }
            //restauration
            $this->contact_model->update(array('CON_ID' => $id_con,), $_POST);
            redirect(site_url('contact/historique') . '/' . $id_con);
        } else {
            $this->contact_model->select();
            $this->contact_model->read_id($id_con);
            $contact = $this->contact_model->get_results();
            $data = array('contact' => $contact);

            //prise en compte de la population pour l'attribution des id
            $this->tables_names_model->select_tabl_id();
            $this->tables_names_model->read_name('contacts');
            $tabl_id = $this->tables_names_model->get_results();
            $hist_tabl_id = get_object_vars($tabl_id[0]);
            $hist_tabl_id = $hist_tabl_id['TABL_ID'];

            $this->historique_model->read_contacts_historic($id_con, $hist_tabl_id);
            $history = $this->historique_model->get_results();
            $history_array = array('history' => $history, 'contact' => $contact, 'date' => $date, 'time' => $time);

            $this->load->view('base/header');
            $this->load->view('base/navigation', $this->session->userdata('username'));
            $this->load->view('contact/quicksearch');
            $this->load->view('contact/menu', $data);
            $this->load->view('contact/restauration', $history_array);
            $this->load->view('base/footer');
        }
    }
}
