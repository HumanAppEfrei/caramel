<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Document extends MY_Controller {

    public function index() {
        $nav_data = array('username' => $this->session->userdata('username'));

        $this->load->view('base/header');
        $this->load->view('base/navigation', $nav_data);
        $this->load->view('document/quicksearch');
        $this->load->view('document/main');
        $this->load->view('base/footer');
    }

    /* Partie Type */

    public function type() {
        $this->load->model('type_model');

        $type_data = array('types' => $this->type_model->read_all());
        $quickSearch_data = array('modeChoice' => 'Types');
        $nav_data = array('username' => $this->session->userdata('username'));

        $this->load->view('base/header');
        $this->load->view('base/navigation', $nav_data);
        $this->load->view('document/quicksearch', $quickSearch_data);
        $this->load->view('document/type', $type_data);
        $this->load->view('base/footer');
    }

    public function create_type() {
        $this->load->model('type_model');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        $this->form_validation->set_rules('name', 'Nom', 'trim|max_length[50]|is_unique[type.TYP_NAME]|required|alpha_dash_no_num|encode_php_tags|xss_clean');

        if ($this->input->post('is_form_sent') && $this->form_validation->run()) {
            $data_values = array('TYP_NAME' => $this->input->post('name'));
            $this->type_model->create($data_values);

            redirect('document/type', 'refresh');
        } else {
            $nav_data = array('username' => $this->session->userdata('username'));

            $this->load->view('base/header');
            $this->load->view('base/navigation', $nav_data);
            $this->load->view('document/create_type');
            $this->load->view('base/footer');
        }
    }

    public function edit_type($typeID) {
        $this->load->model('type_model');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        $this->form_validation->set_rules('typ_name', 'type', 'trim|required|alpha_dash|max_length[50]|encode_php_tags|xss_clean');

        if ($this->input->post('is_form_sent') && $this->form_validation->run()) {
            $data_values = array('TYP_NAME' => $this->input->post('typ_name'));
            $this->type_model->update(array('TYP_ID' => $typeID), $data_values);

            redirect('/document/type/', 'refresh');
        } else {
            $nav_data = array('username' => $this->session->userdata('username'));
            $type = $this->type_model->read("*", array("TYP_ID" => $typeID));
            $data = array('type' => $type[0]);

            $this->load->view('base/header');
            $this->load->view('base/navigation', $nav_data);
            $this->load->view('document/edit_type', $data);
            $this->load->view('base/footer');
        }
    }

    public function remove_type($typeID) {
        $this->load->model('type_model');
        $this->load->model('lettre_model');
        $this->lettre_model->delete(array('LET_TYPE_ID' => $typeID));
        $this->type_model->delete(array('TYP_ID' => $typeID));

        redirect('/document/type/', 'refresh');
    }

    public function quicksearch() {
        if ($this->input->post('is_form_sent')) {
            $post_selection = $this->input->post('selection');

            if ($post_selection == "Types")
                redirect('/document/type/', 'refresh');
            else if ($post_selection == "Lettres")
                redirect('/document/lettre/', 'refresh');
            else
                redirect('/document/generate/', 'refresh');
        } else {
            $this->index();
        }
    }

    /* Partie Lettre */

    public function lettre() {
        $this->load->model('type_model');

        $nav_data = array('username' => $this->session->userdata('username'));
        $type_data = array('types' => $this->type_model->read_all());
        $quickSearch_data = array('modeChoice' => 'Lettres');

        $this->load->view('base/header');
        $this->load->view('base/navigation', $nav_data);
        $this->load->view('document/quicksearch', $quickSearch_data);
        $this->load->view('document/lettre', $type_data);
        $this->load->view('base/footer');
    }

    public function create_letter($typeID) {
        $this->load->model('lettre_model');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        $this->form_validation->set_rules('titre', 'Titre', 'trim|required|alpha_dash|max_length[11]|encode_php_tags|xss_clean');

        if ($this->input->post('is_form_sent') && $this->form_validation->run()) {
            $data_values = array();
            $data_values['LET_TYPE_ID'] = $typeID;
            $data_values['LET_NAME'] = $this->input->post('titre');
            // Le "=" ne passe pas bien la transmission post, on a donc modifié la chaine avant le submit
            $data_values['LET_CONTENT'] = str_replace("&|&", "=", $this->input->post('TinyTextHTML'));
            $this->lettre_model->create($data_values);

            redirect('/document/lettre/', 'refresh');
        } else {
            $nav_data = array('username' => $this->session->userdata('username'));
            $data = array('typeID' => $typeID);

            $this->load->view('base/header');
            $this->load->view('base/navigation', $nav_data);
            $this->load->view('document/create_letter', $data);
            $this->load->view('base/footer');
        }
    }

    public function edit_letter($lettreID) {
        $this->load->model('lettre_model');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        $this->form_validation->set_rules('titre', 'Titre', 'trim|required|alpha_dash|max_length[11]|encode_php_tags|xss_clean');

        if ($this->input->post('is_form_sent') && $this->form_validation->run()) {
            $data_values = array();
            $data_values['LET_NAME'] = $this->input->post('titre');
            // Le "=" ne passe pas bien la transmission post, on a donc modifié la chaine avant le submit
            $data_values['LET_CONTENT'] = str_replace("&|&", "=", $this->input->post('TinyTextHTML'));
            $this->lettre_model->update(array('LET_ID' => $lettreID), $data_values);

            redirect('/document/lettre/', 'refresh');
        } else {
            $nav_data = array('username' => $this->session->userdata('username'));
            $lettre = $this->lettre_model->read("*", array("LET_ID" => $lettreID));
            $data = array('lettre' => $lettre[0]);

            $this->load->view('base/header');
            $this->load->view('base/navigation', $nav_data);
            $this->load->view('document/edit_letter', $data);
            $this->load->view('base/footer');
        }
    }

    public function remove_letter($lettreID) {
        $this->load->model('lettre_model');
        $this->lettre_model->delete(array('LET_ID' => $lettreID));
        redirect('/document/lettre/', 'refresh');
    }

    public function ajax_listLettres($typeID) {
        $this->load->model('lettre_model');
        $lettres = $this->lettre_model->read("LET_ID,LET_NAME", array("LET_TYPE_ID" => $typeID));
        $data = array('lettres' => $lettres);

        $this->load->view('document/listLettres', $data);
    }

    public function generate_lettre($lettre_id) {
        $this->load->library('form_validation');
        $this->load->library('mpdf');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->load->model('lettre_model');
        $this->load->model('contact_model');
        $this->load->model('segment_model');
        $this->load->model('offre_model');
        $this->load->model('cible_model');

        $erreur = "";

        if ($this->input->post('is_form_sent')) {
            $post_identifiant = $this->input->post('identifiant');
            $post_selection = $this->input->post('selection');

            // Verifications
            $this->form_validation->set_rules('identifiant', 'Identifiant', 'trim|required|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('selection', 'selection', 'trim|encode_php_tags|xss_clean');

            if ($post_selection == "contact")
                $test = $this->contact_model->read("CON_ID", array("CON_ID" => $post_identifiant));
            if ($post_selection == "segment")
                $test = $this->segment_model->read("SEG_CODE", array("SEG_CODE" => $post_identifiant));
            if ($post_selection == "offre")
                $test = $this->offre_model->read("OFF_ID", array("OFF_ID" => $post_identifiant));

            if (!$test)
                $erreur = '<div class="error">Identifiant non reconnu</div>';

            if ($this->form_validation->run() && $erreur == "") {
                //récupération du code html de la lettre :
                $lettre = $this->lettre_model->read("LET_NAME,LET_CONTENT", array("LET_ID" => $lettre_id));
                $html = $lettre[0]->LET_CONTENT;
                $filename = $lettre[0]->LET_NAME . "_" . $post_identifiant.".pdf";

                //récupération des contacts concernés
                $contacts_ids = array();
                switch ($post_selection) {
                    case "contact":
                        $contacts_ids = $this->contact_model->read("CON_ID", array("CON_ID" => $post_identifiant));
                        break;

                    case "offre":
                        $contacts_ids = $this->cible_model->read("CON_ID", array("OFF_ID" => $post_identifiant));
                        break;

                    case "segment":
                        $contacts_ids = $this->segment_model->createRequest($post_identifiant);
                        break;
                }

                $sautDePage = false;
                foreach ($contacts_ids as $contact_id) {
                    //Modification du HTML (pour chaque variables définies)
                    $html_modif = str_replace('$prenom_contact$', $this->contact_model->generate_prenom($contact_id->CON_ID), $html);
                    $html_modif = str_replace('$nom_contact$', $this->contact_model->generate_nom($contact_id->CON_ID), $html_modif);
                    $html_modif = str_replace('$civilite_contact$', $this->contact_model->generate_civilite($contact_id->CON_ID), $html_modif);
                    $html_modif = str_replace('$adresse_contact$', $this->contact_model->generate_adresse($contact_id->CON_ID), $html_modif);
                    /** + autres variables à ajouter 
                      $html = str_replace('$NOM_VARIABLE$',$this->contact_model->GENERATE_VARIABLE($contact_id->CON_ID),$html_modif);
                      Il faut alors implementer la fonction GENERATE_VARIABLE dans contact model
                     * */
                    // écriture du PDF
                    if ($sautDePage)
                        $this->mpdf->AddPage();
                    $this->mpdf->WriteHTML($html_modif);
                    $sautDePage = true;
                }

                //Génération du pdf
                $this->mpdf->Output($filename, 'D');
            }
        }
        $nav_data = array();
        $nav_data['username'] = $this->session->userdata('username');

        $data = array();
        $data['lettreID'] = $lettre_id;
        $data['error'] = $erreur;

        $this->load->view('base/header');
        $this->load->view('base/navigation', $nav_data);
        $this->load->view('document/generate', $data);
        $this->load->view('base/footer');
    }
}
