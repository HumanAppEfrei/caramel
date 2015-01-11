<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends MY_Controller {

    /*
     *  Affichage de la page appelee par le bouton "engrenage".
     *  Appelle les vues necessaires.
     *
     *  Cette page sert a traiter
     *
     *      - les critères personnalisés utilisés dans les segments
     *      - les informations complementaires liees aux contacts
     *      - le dedoublonnage de deux contacts (fusion de leurs informations)
     *      - l'inscription de nouveaux utilisateurs
     */
    public function index() {
        $nav_data = array('username' => $this->session->userdata('username'));

        $this->load->view('base/header');
        $this->load->view('base/navigation', $nav_data);
        $this->load->view('base/reglages');
        $this->load->view('base/footer');
    }


    /*
     *  Appelle les vues permettant d'afficher les criteres de segments deja crees.
     */
    public function reglage() {
        $this->load->model('reglage_model');

        $nav_data = array('username' => $this->session->userdata('username'));
        $data = array('reglages' => $this->reglage_model->read_all());

        $this->load->view('base/header');
        $this->load->view('base/navigation', $nav_data);
        $this->load->view('reglage/list', $data);
        $this->load->view('base/footer');
    }

    /*
     *  Fonction d'edition des criteres déjà crees.
     *  Met à jour la BDD
     *
     *  @param string $reg code du critere a editer.
     */
    public function editReg($reg) {
        $this->load->model('reglage_model');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        $post_form = $this->input->post('is_form_sent');
        if ($post_form) {
            // Récupération des données
            $post_valeur = $this->input->post('valeurAjoutee');

            // Vérifications des données
            $this->form_validation->set_rules('valeurAjoutee', 'valeur ajoutée', 'trim|required|alpha_dash|encode_php_tags|xss_clean');

            if ($this->form_validation->run()) {
                // Envoie dans la BDD
                $items = $this->reglage_model->read($reg);
                if ($items[0]->REG_LIST)
                    $chaine = $items[0]->REG_LIST . ',' . $post_valeur;
                else
                    $chaine = $post_valeur;

                $this->reglage_model->update(array("REG_CODE" => $reg), array("REG_LIST" => $chaine));
            }
            $items = $this->reglage_model->read($reg);

            $list_data = array();
            $list_data['RegCode'] = $items[0]->REG_CODE;
            $list_data['NomReglage'] = $items[0]->REG_DESCRIP;

            $valeurs = array();
            if ($items[0]->REG_LIST)
                $valeurs = explode(',', $items[0]->REG_LIST);

            $list_data['valeurs'] = $valeurs;

            $nav_data = array('username' => $this->session->userdata('username'));

            $this->load->view('base/header');
            $this->load->view('base/navigation', $nav_data);
            $this->load->view('reglage/edit', $list_data);
            $this->load->view('base/footer');
        }
        else {
            $items = $this->reglage_model->read($reg);
            $list_data = array();
            $list_data['RegCode'] = $items[0]->REG_CODE;
            $list_data['NomReglage'] = $items[0]->REG_DESCRIP;
            $valeurs = array();
            if ($items[0]->REG_LIST)
                $valeurs = explode(',', $items[0]->REG_LIST);
            $list_data['valeurs'] = $valeurs;

            $nav_data = array();
            $nav_data['username'] = $this->session->userdata('username');

            $this->load->view('base/header');
            $this->load->view('base/navigation', $nav_data);
            $this->load->view('reglage/edit', $list_data);

            $this->load->view('base/footer');
        }
    }

    /*
     *  Suppression d'un critere.
     *  Met à jour la BDD
     *  @param  string $RegCode code du reglage a supprimer
     *          ?? $valeur à définir (voir application/view/reglage/edit.php)
     */
    public function removeReg($RegCode, $valeur) {
        $this->load->model('reglage_model');
        $items = $this->reglage_model->read($RegCode);

        $Valeurs = explode(',', $items[0]->REG_LIST);
        $id_elem = array_search($valeur, $Valeurs);
        unset($Valeurs[$id_elem]);
        $Valeurs = array_values($Valeurs);
        $chaine = implode(',', $Valeurs);
        $this->reglage_model->update(array("REG_CODE" => $RegCode), array("REG_LIST" => $chaine));

        redirect('admin/editReg/' . $RegCode, 'refresh');
    }

    /*
     *  Liste les information supplementaires de contacts deja creees
     */
    public function infoComplementaires() {
        $this->load->model('infos_comp_model');

        $nav_data = array('username' => $this->session->userdata('username'));
        $data = array('infos_comp' => $this->infos_comp_model->read_all());

        $this->load->view('base/header');
        $this->load->view('base/navigation', $nav_data);
        $this->load->view('infos_comp/list', $data);
        $this->load->view('base/footer');
    }

    /*
     *  A VALIDER: cette fonction semble être obsolette.
     *  Elle fait appel à la vue document_type/view qui n'existe pas
     */
    public function document_type() {
        $nav_data = array();
        $nav_data['username'] = $this->session->userdata('username');

        $this->load->view('base/header');
        $this->load->view('base/navigation', $nav_data);
        $this->load->view('document_type/view');
        $this->load->view('base/footer');
    }

    /*
     *  Creation d'une nouvelle information complémentaire
     *  Met à jour la BDD
     */
    public function createIC() {
        $this->load->model('infos_comp_model');
        $this->load->model('contacts_ic_model');
        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $post_form = $this->input->post('is_form_sent');

        if ($post_form) {
            $post_name = $this->input->post('nom');
            $post_type = $this->input->post('type');

            // Vérifications
            $this->form_validation->set_rules('nom', 'nom', 'trim|max_length[255]|required|is_unique[infos_comp.IC_LABEL]|alpha_dash_spaces|encode_php_tags|xss_clean');
            if ($post_type == "liste") {
                $this->form_validation->set_rules('choixlist', 'options de la liste', 'trim|required|alpha_dash_spaces_commas|encode_php_tags|xss_clean');
                $post_type = $post_type . ":" . $this->input->post('choixlist');
            }

            if ($this->form_validation->run()) {
                //génération d'une nouvelle ID :
                $ic_ids = $this->infos_comp_model->read('IC_ID');
                print_r($ic_ids);

                if ($ic_ids) {
                    $last_ic_id = end($ic_ids);
                    $exploseID = explode('_', $last_ic_id->IC_ID);
                    $exploseID[1]++;
                    $ID_IC = $exploseID[0] . '_' . $exploseID[1];
                }else
                    $ID_IC = "IC_1";

                // Envoie dans la BDD
                $options_echappees = array();
                $options_echappees['IC_ID'] = $ID_IC;
                $options_echappees['IC_LABEL'] = $post_name;
                $options_echappees['IC_TYPE'] = $post_type;

                //création du champs dans la table des infos complémentaires
                $this->infos_comp_model->create($options_echappees);
                //ajout d'une colonne dans la table CONTACTS_IC
                $this->contacts_ic_model->addColumn($ID_IC, 'VARCHAR(255)');

                //Le formulaire est valide
                redirect('admin/infoComplementaires', 'refresh');
            }
            else {
                //Le formulaire est invalide ou vide
                $nav_data = array('username' => $this->session->userdata('username'));

                $this->load->view('base/header');
                $this->load->view('base/navigation', $nav_data);
                $this->load->view('infos_comp/create');
                $this->load->view('base/footer');
            }
        } else {
            // affichage
            $nav_data = array('username' => $this->session->userdata('username'));

            $this->load->view('base/header');
            $this->load->view('base/navigation', $nav_data);
            $this->load->view('infos_comp/create');
            $this->load->view('base/footer');
        }
    }

    /*
     *  Suppression d'une information complementaire
     *  Met à jour la BDD
     *  @param  string IC_ID ID de l'information complementaire a supprimer
     */
    public function removeIC($IC_ID) {
        $this->load->model('infos_comp_model');
        $this->load->model('contacts_ic_model');

        $this->infos_comp_model->delete(array("IC_ID" => $IC_ID));
        $this->contacts_ic_model->removeColumn($IC_ID);

        redirect('admin/infoComplementaires', 'refresh');
    }


    /*
     *  Fusion des informations de deux contacts, saisis a la main par leur identifiant.
     *  Met à jour la BDD
     */
    public function dedoublonnage() {
        $this->load->model('contact_model');
        $this->load->model('old_id_link_model');
        $this->load->model('contacts_ic_model');
        $this->load->model('infos_comp_model');
        $this->load->model('don_model');
        $this->load->model('cible_model');

        $nav_data = array('username' => $this->session->userdata('username'));

        $post_form1 = $this->input->post('is_form_sent1');
        $post_form2 = $this->input->post('is_form_sent2');

        if ($post_form1) {//(après avoir rentré les 2 identifiants)
            $ID1 = $this->input->post('ID1');
            $ID2 = $this->input->post('ID2');
            $Test_ID1 = false;
            $Test_ID2 = false;

            if ($ID1 != $ID2) {
                //verification de l'existance des ID dans la BDD
                $contact1 = $this->contact_model->select();
                $contact1 = $this->contact_model->read_id($ID1);
                $contact1 = $this->contact_model->get_results();
                if (count($contact1, 0) > 0)
                    $Test_ID1 = true;

                $contact2 = $this->contact_model->select();
                $contact2 = $this->contact_model->read_id($ID2);
                $contact2 = $this->contact_model->get_results();

                if (count($contact2, 0) > 0)
                    $Test_ID2 = true;

                $list_data = array();

                if (($Test_ID1 == true) && ($Test_ID2 == true)) {
                    //si aucun problème avec les ID
                    $list_data['contact1'] = $contact1;
                    $list_data['contact2'] = $contact2;

                    //récupération des infos complémentaires
                    $ic_contact1 = $this->contacts_ic_model->select();
                    $ic_contact1 = $this->contacts_ic_model->read_id($ID1);
                    $ic_contact1 = $this->contacts_ic_model->get_result_array();

                    if (count($ic_contact1) == 0) {//si il n'existe pas de ligne corrspondant au contact1 dans contacts_ic
                        $this->contacts_ic_model->insert_empty_tuple($ID1);
                        $ic_contact1 = $this->contacts_ic_model->select();
                        $ic_contact1 = $this->contacts_ic_model->read_id($ID1);
                        $ic_contact1 = $this->contacts_ic_model->get_result_array();
                    }

                    $ic_contact2 = $this->contacts_ic_model->select();
                    $ic_contact2 = $this->contacts_ic_model->read_id($ID2);
                    $ic_contact2 = $this->contacts_ic_model->get_result_array();

                    if (count($ic_contact2) == 0) {//si il n'existe pas de ligne corrspondant au contact2 dans contacts_ic
                        $this->contacts_ic_model->insert_empty_tuple($ID2);
                        $ic_contact2 = $this->contacts_ic_model->select();
                        $ic_contact2 = $this->contacts_ic_model->read_id($ID2);
                        $ic_contact2 = $this->contacts_ic_model->get_result_array();
                    }

                    $list_data['ic_contact1'] = $ic_contact1;
                    $list_data['ic_contact2'] = $ic_contact2;

                    $info_comp = $this->infos_comp_model->select();
                    $info_comp = $this->infos_comp_model->get_results();

                    $ic_array = array();
                    foreach ($info_comp as $row) {
                        $list_data[$row->IC_ID] = $row->IC_LABEL;
                        array_push($ic_array, $row->IC_ID);
                    }
                    $list_data['ic_array'] = $ic_array;

                    $this->load->view('base/header');
                    $this->load->view('base/navigation', $nav_data);
                    $this->load->view('reglage/fusion_comparaison', $list_data); //chargement de la vue comparaison avec les données des 2 contacts
                    $this->load->view('base/footer');
                } else {
                    //si problème avec un ID
                    $list_data['Test_ID1'] = $Test_ID1;
                    $list_data['Test_ID2'] = $Test_ID2;
                    $list_data['ID1'] = $ID1;
                    $list_data['ID2'] = $ID2;

                    $this->load->view('base/header');
                    $this->load->view('base/navigation', $nav_data);
                    $this->load->view('reglage/fusion_id_selection', $list_data);
                    $this->load->view('base/footer');
                }
            } else {
                $this->load->view('base/header');
                $this->load->view('base/navigation', $nav_data);
                $this->load->view('reglage/fusion_id_selection');
                $this->load->view('base/footer');
            }
        } else if ($post_form2) {
            //(après avoir remplis les champs du 2ème formulaire)
            //récupération des données du formulaire en local
            $post_ID1 = $this->input->post('ID1');
            $post_ID2 = $this->input->post('ID2');
            $post_civilite = $this->input->post('choix_civilite');
            $post_lastname = $this->input->post('choix_nom');
            $post_firstname = $this->input->post('choix_prenom');
            $post_date = $this->input->post('choix_date');
            $post_email = $this->input->post('choix_email');
            $post_telFixe = $this->input->post('choix_telfix');
            $post_telPort = $this->input->post('choix_telport');
            $post_type = $this->input->post('choix_type');
            $post_typeC = $this->input->post('choix_typec');
            $post_complement = $this->input->post('choix_compl');
            $post_voie_num = $this->input->post('choix_voienum');
            $post_voie_type = $this->input->post('choix_voietype');
            $post_voie_nom = $this->input->post('choix_voienom');
            $post_bp = $this->input->post('choix_bp');
            $post_cp = $this->input->post('choix_cp');
            $post_city = $this->input->post('choix_city');
            $post_country = $this->input->post('choix_country');
            $post_npai = $this->input->post('choix_npai');
            $post_rftype = $this->input->post('choix_rftype');
            $post_rfenvoi = $this->input->post('choix_rfenvoi');
            $post_rfsol = $this->input->post('choix_solicitation');
            $post_commentaire = $this->input->post('choix_commentaire');

            $info_comp = $this->infos_comp_model->select(); //récupération des noms des infos complémentaires
            $info_comp = $this->infos_comp_model->get_results();

            //récupération des données des infos complémentaires des 2 contacts
            $ic_contact1 = $this->contacts_ic_model->select();
            $ic_contact1 = $this->contacts_ic_model->read_id($post_ID1);
            $ic_contact1 = $this->contacts_ic_model->get_result_array();

            $ic_contact2 = $this->contacts_ic_model->select();
            $ic_contact2 = $this->contacts_ic_model->read_id($post_ID2);
            $ic_contact2 = $this->contacts_ic_model->get_result_array();

            $ic_array = array();
            foreach ($info_comp as $row) {//pour chaque infos complémentaires: choix entre la données du contact 1 ou 2
                $tmp = $row->IC_ID;
                ${'choix_' . $tmp} = $this->input->post('choix_' . $tmp);
                ${'final_' . $tmp} = ${'ic_contact' . ${'choix_' . $tmp}}[0][$tmp];
                $ic_array[$tmp] = ${'final_' . $tmp};
            }

            if ($post_ID1 > $post_ID2) {//choix de l'ID à garder et de l'ID à supprimer
                $final_ID = $post_ID2;
                $delete_ID = $post_ID1;
            } else {
                $final_ID = $post_ID1;
                $delete_ID = $post_ID2;
            }

            //récupération des données des 2 contacts
            $contact1 = $this->contact_model->select();
            $contact1 = $this->contact_model->read_id($post_ID1);
            $contact1 = $this->contact_model->get_results();

            $contact2 = $this->contact_model->select();
            $contact2 = $this->contact_model->read_id($post_ID2);
            $contact2 = $this->contact_model->get_results();

            //choix entre la donnée du contact 1 ou 2
            $final_civilite = ${"contact" . $post_civilite}[0]->CON_CIVILITE;
            $final_lastname = ${"contact" . $post_lastname}[0]->CON_LASTNAME;
            $final_firstname = ${"contact" . $post_firstname}[0]->CON_FIRSTNAME;
            $final_date = ${"contact" . $post_date}[0]->CON_DATE;
            $final_email = ${"contact" . $post_email}[0]->CON_EMAIL;
            $final_telFixe = ${"contact" . $post_telFixe}[0]->CON_TELFIXE;
            $final_telPort = ${"contact" . $post_telPort}[0]->CON_TELPORT;
            $final_type = ${"contact" . $post_type}[0]->CON_TYPE;
            $final_typeC = ${"contact" . $post_typeC}[0]->CON_TYPEC;
            $final_complement = ${"contact" . $post_complement}[0]->CON_COMPL;
            $final_voie_num = ${"contact" . $post_voie_num}[0]->CON_VOIE_NUM;
            $final_voie_type = ${"contact" . $post_voie_type}[0]->CON_VOIE_TYPE;
            $final_voie_nom = ${"contact" . $post_voie_nom}[0]->CON_VOIE_NOM;
            $final_bp = ${"contact" . $post_bp}[0]->CON_BP;
            $final_cp = ${"contact" . $post_cp}[0]->CON_CP;
            $final_city = ${"contact" . $post_city}[0]->CON_CITY;
            $final_country = ${"contact" . $post_country}[0]->CON_COUNTRY;
            $final_npai = ${"contact" . $post_npai}[0]->CON_NPAI;
            $final_rftype = ${"contact" . $post_rftype}[0]->CON_RF_TYPE;
            $final_rfenvoi = ${"contact" . $post_rfenvoi}[0]->CON_RF_ENVOI;
            $final_rfsol = ${"contact" . $post_rfsol}[0]->CON_SOLICITATION;
            $final_commentaire = ${"contact" . $post_commentaire}[0]->CON_COMMENTAIRE;

            //rangement des données finales de la requete dans un array
            $query_data = array(
                'CON_TYPE' => $final_type,
                'CON_TYPEC' => $final_typeC,
                'CON_CIVILITE' => $final_civilite,
                'CON_FIRSTNAME' => $final_firstname,
                'CON_LASTNAME' => $final_lastname,
                'CON_DATE' => $final_date,
                'CON_EMAIL' => $final_email,
                'CON_TELFIXE' => $final_telFixe,
                'CON_TELPORT' => $final_telPort,
                'CON_COMPL' => $final_complement,
                'CON_VOIE_NUM' => $final_voie_num,
                'CON_VOIE_TYPE' => $final_voie_type,
                'CON_VOIE_NOM' => $final_voie_nom,
                'CON_BP' => $final_bp,
                'CON_CP' => $final_cp,
                'CON_CITY' => $final_city,
                'CON_COUNTRY' => $final_country,
                'CON_NPAI' => $final_npai,
                'CON_RF_TYPE' => $final_rftype,
                'CON_RF_ENVOI' => $final_rfenvoi,
                'CON_SOLICITATION' => $final_rfsol,
                'CON_COMMENTAIRE' => $final_commentaire);

            $this->contact_model->update_tuple($query_data, $final_ID); //mise à jour de la table contact avec les données de query_data
            $this->old_id_link_model->insert_tuple($final_ID, $delete_ID); //ranger $delete_ID dans la table old_ID_link
            $this->contacts_ic_model->update_tuple($ic_array, $final_ID); //mise à jour de contact_ic avec les infos complémentaires du contact à conserver
            $this->contacts_ic_model->delete_tuple($delete_ID); //suppresion de la ligne des infos complémentaires du contact à supprimer
            $this->don_model->update_id($delete_ID, $final_ID); //rangement des dons du contact à supprimer dans celui à conserver
            $this->cible_model->update_id($delete_ID, $final_ID); //mise à jour de l'ID du contact dans la table cible
            $this->contact_model->delete_tuple($delete_ID); // Après ces changements on peut supprimer le contact dans la table contact

            $list_data = array();
            $list_data['contact_ID'] = $final_ID;
            $list_data['old_contact_ID'] = $delete_ID;

            $this->load->view('base/header');
            $this->load->view('base/navigation', $nav_data);
            $this->load->view('reglage/fusion_id_selection', $list_data); //affichage de la confirmation dans fusion_id_selection
            $this->load->view('base/footer');
        } else {
            //affichage du premier formulaire
            $this->load->view('base/header');
            $this->load->view('base/navigation', $nav_data);
            $this->load->view('reglage/fusion_id_selection');
            $this->load->view('base/footer');
        }
    }

    /*
     *  Incription d'un nouvel utilisateur a partir d'un formulaire.
     *  Met a jour la BDD.
     *  Refuse l'ajout en cas d'erreur dans le formulaire ou de nom d'utilisateur deja existant
     */
    public function user_signup() {
        $this->load->helper('form');

        if ($this->input->post('form_sent')) { // Formulaire envoyé
            $this->load->library('form_validation');
            $post_inputs = array(
                'lastname' => $this->input->post('lastname'),
                'firstname' => $this->input->post('firstname'),
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'passwd' => $this->input->post('passwd'),
                'passwd_chk' => $this->input->post('passwd_chk')
            );

            // Définition des règles du formulaire
            $this->form_validation->set_rules(array(
                array(
                    'field' => 'lastname',
                    'label' => 'Nom',
                    'rules' => 'trim|required|max_length[30]|alpha|xss_clean'
                ),
                array(
                    'field' => 'firstname',
                    'label' => 'Prénom',
                    'rules' => 'trim|required|max_length[30]|alpha|xss_clean'
                ),
                array(
                    'field' => 'username',
                    'label' => "Nom d'utilisateur",
                    'rules' => 'trim|required|max_length[20]|alpha_dash|xss_clean'
                ),
                array(
                    'field' => 'email',
                    'label' => 'Adresse email',
                    'rules' => 'trim|required|valid_email|xss_clean'
                ),
                array(
                    'field' => 'passwd',
                    'label' => 'Mot de passe',
                    'rules' => 'trim|required|xss_clean'
                ),
                array(
                    'field' => 'passwd_chk',
                    'label' => "Vérification du mot de passe",
                    'rules' => 'trim|required|matches[passwd]|xss_clean'
                )
            ));
            $this->form_validation->set_error_delimiters('', '<br/>');

            // Si le formulaire est bon, on redirige à l'admin
            if ($this->form_validation->run()) {
                $this->load->database();

                // Vérification de l'existance du nom d'utilisateur
                $query = $this->db->query("SELECT user_id FROM users WHERE user_login='" . $post_inputs['username'] . "'");
                if ($query->num_rows() == 0) {
                    $this->load->model('user_model');
                    if ($this->user_model->add_user($post_inputs['firstname'], $post_inputs['lastname'], $post_inputs['username'], $post_inputs['passwd'], $post_inputs['email'])) {
                        $this->session->set_flashdata('success', "L'utilisateur a bien été ajouté.");
                    } else {
                        $this->session->set_flashdata('error', "Une erreur est survenue, veuillez réessayer.");
                    }

                    redirect('admin/index', 'refresh');
                }

                $this->session->set_flashdata('error', "Ce nom d'utilisateur existe déjà.");
            }
        }

        // À partir d'ici, soit le formulaire n'a pas encore été affiché,
        // soit il contenait des erreurs.

        $nav_data = array();
        $nav_data['username'] = $this->session->userdata('username');

        $this->load->view('base/header');
        $this->load->view('base/navigation', $nav_data);
        $this->load->view('reglage/user_signup');
        $this->load->view('base/footer');
    }


    /*
     *  Fonction d'édition de la BDD.
     *  @param "all":   affiche toutes les tables, un bouton pour les modifier
     *                  TODO: comprendre le fonctionnement du bouton "peupler"
     *  @param nom d'un table:  affiche les champs de la table et permet de les renommer via un formulaire
     *
     */
    public function database($table) {
        $this->load->model('tables_names_model');
        $this->load->model('tables_fields_model');
        $nav_data = array('username' => $this->session->userdata('username'));

        if ($table == 'all') {
            //script de population
            $added_table = 0;
            $added_field = 0;
            if (isset($_POST['populate'])) {
                //parcours la liste des tables
                $tables = $this->db->list_tables();
                foreach ($tables as $key => $value) {
                    //vérifie si le nom de la table est répertorié
                    $this->db->select('tabl_id')->from('tables_names');
                    $this->db->where('tabl_name', $value);
                    $res = $this->db->get()->result();

                    if (count($res) != 0) {
                        $tabl_id = $res[0]->tabl_id;
                    }

                    //si le nom n'est pas répertorié, on l'ajoute
                    if (count($res) == 0) {
                        $data = array('tabl_name' => $value);
                        $this->db->insert('tables_names', $data);
                        $added_table++;

                        //récupère la clé primaire de tables_names
                        $this->db->select('tabl_id')->from('tables_names');
                        $this->db->where('tabl_name', $value);
                        $res = $this->db->get()->result();
                        $tabl_id = $res[0]->tabl_id;
                    }

                    //parcours la liste des champs de la table concernée
                    $fields = $this->db->list_fields($value);
                    foreach ($fields as $key => $value) {
                        $this->db->select('tabl_field_id')->from('tables_fields');
                        $this->db->where('tabl_field', $value);
                        $res = $this->db->get()->result();

                        //si le nom du champ n'est pas répertorié, on l'ajoute
                        if (count($res) == 0) {
                            $data = array(
                                'tabl_id' => $tabl_id,
                                'tabl_field' => $value,
                                'tabl_field_name' => $value
                            );
                            $this->db->insert('tables_fields', $data);
                            $added_field++;
                        }
                    }
                }

                //paramètre pour l'affichage du message avant la liste
                $tables_array['to_display'] = true;
                $tables_array['added_table'] = $added_table;
                $tables_array['added_field'] = $added_field;
            }

            //on enlève les tables inutiles
            $this->db->select('tabl_name')->from('tables_names');
            $queried_tables_object = $this->db->get()->result();

            //transformer tableau d'objet en tableau de string
            $queried_tables = array();
            foreach ($queried_tables_object as $key => $value) {
                $queried_tables[$key] = $value->tabl_name;
            }

            $ignored_tables = array(
                'contacts_ic',
                'criteres',
                'criteres_link',
                'historique',
                'liste_ville',
                'old_id_link',
                'tables_names',
            );

            //calcule la différence entre ces deux tableaux;
            $tables = array_diff($queried_tables, $ignored_tables);
            $tables_array = array('tables' => $tables);

            $this->load->view('base/header');
            $this->load->view('base/navigation', $nav_data);
            $this->load->view('reglage/list_tables', $tables_array);
            $this->load->view('base/footer');
        } else {
            //retrouve le tabl_id à partir du nom de la table
            $this->tables_names_model->select_tabl_id();
            $this->tables_names_model->read_name($table);
            $queried_table = $this->tables_names_model->get_results();
            $tabl_id = $queried_table[0]->TABL_ID;

            //affiche tous les champs de la table
            if (!isset($_POST['submit'])) {
                //retrouve tous les champs de cette table
                $this->tables_fields_model->select();
                $this->tables_fields_model->read_tabl_id($tabl_id);
                $queried_fields = $this->tables_fields_model->get_results();

                $fields_array = array('table' => $table, 'fields' => $queried_fields);

                $this->load->view('base/header');
                $this->load->view('base/navigation', $nav_data);
                $this->load->view('reglage/list_fields', $fields_array);
                $this->load->view('base/footer');
            } else {
                //traite le formulaire
                unset($_POST['submit']);
                foreach ($_POST as $key => $value) {
                    $update_data = array('TABL_FIELD_NAME' => $value);
                    $this->tables_fields_model->update(array('TABL_FIELD_ID' => $key, 'TABL_ID' => $tabl_id), $update_data);
                }
                redirect(site_url('admin/database') . '/' . $table);
            }
        }
    }

}
