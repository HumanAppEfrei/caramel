<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Segment extends MY_Controller {

    /**
     * Fonction d'affichage de la page des segments
     */
    public function index() {
        $post_form = $this->input->post('is_form_sent');

        $nav_data = array();
        $nav_data['username'] = $this->session->userdata('username');

        $this->load->view('base/header');
        $this->load->view('base/navigation', $nav_data);
        $this->load->view('segment/quicksearch');
        $this->load->view('base/footer');
    }

    /**
     * Creation d'un nouveau segment
     */
    public function create() {
        $this->load->model('segment_model');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        $post_form = $this->input->post('is_form_sent');
        if ($post_form) {
            $post_code = $this->input->post('code');
            $post_libelle = $this->input->post('libelle');

            // Vérifications
            $this->form_validation->set_rules('code', 'Code', 'trim|required|max_length[15]|is_unique[segments.SEG_CODE]|alpha_dash|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('libelle', 'Libellé', 'trim|required|alpha_dash_space|encode_php_tags|xss_clean');

            if ($this->form_validation->run()) {
                // Envoie dans la BDD
                $options_echappees = array();
                $options_echappees['SEG_CODE'] = $post_code;
                $options_echappees['SEG_LIBELLE'] = $post_libelle;
                $options_echappees['SEG_EDIT'] = true;

                $options_non_echappees = array();
                $options_non_echappees['SEG_DATEADDED'] = 'NOW()';
                $options_non_echappees['SEG_DATEMODIF'] = 'NOW()';

                $this->segment_model->create($options_echappees, $options_non_echappees);

                //	Le formulaire est valide
                redirect('segment/edit/' . $post_code, 'refresh');  // on passe à la création des criteres du segment (dans edit)
            } else {
                //	Le formulaire est invalide ou vide
                // affichage
                $nav_data = array();
                $nav_data['username'] = $this->session->userdata('username');

                $this->load->view('base/header');
                $this->load->view('base/navigation', $nav_data);
                $this->load->view('segment/quicksearch');
                $this->load->view('segment/create');
                $this->load->view('base/footer');
            }
        } else {
            // affichage
            $nav_data = array();
            $nav_data['username'] = $this->session->userdata('username');

            $this->load->view('base/header');
            $this->load->view('base/navigation', $nav_data);
            $this->load->view('segment/quicksearch');
            $this->load->view('segment/create');
            $this->load->view('base/footer');
        }
    }

    /**
     * Recherche rapide dans les segments
     */
    public function quicksearch() {
        $this->load->model('segment_model');
        $post_form = $this->input->post('is_form_sent');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($post_form) {
            //Récupération des données
            $post_selection = $this->input->post('selection');
            $post_recherche = mysql_real_escape_string($this->input->post('recherche'));

            // Vérifications des données

            $items = $this->segment_model->select();

            if ($post_recherche != "" && $post_selection == "code")
                $items = $this->segment_model->read_code($post_recherche);
            if ($post_recherche != "" && $post_selection == "libelle")
                $items = $this->segment_model->read_libelle($post_recherche);

            $items = $this->segment_model->get_results();

            $list_data = array();
            $list_data['items'] = $items;

            $nav_data = array();
            $nav_data['username'] = $this->session->userdata('username');

            $this->load->view('base/header');
            $this->load->view('base/navigation', $nav_data);
            $this->load->view('segment/quicksearch');
            $this->load->view('segment/list', $list_data);
            $this->load->view('base/footer');
        }
        else {
            $this->index();
        }
    }

    /**
     * Fonction de recherche approfondie
     */
    public function search() {
        $this->load->model('segment_model');
        $post_form = $this->input->post('is_form_sent');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($post_form) {
            //Récupération des données
            $post_code = $this->input->post('code');
            $post_libelle = $this->input->post('libelle');

            // Vérifications des données

            $items = $this->segment_model->select();

            if ($post_code != "")
                $items = $this->segment_model->read_code($post_code);
            $this->form_validation->set_rules('code', 'Code', 'trim|alpha_dash|encode_php_tags|xss_clean');

            if ($post_libelle != "")
                $items = $this->segment_model->read_libelle($post_libelle);
            $this->form_validation->set_rules('libelle', 'Libellé', 'trim|alpha_dash_space|encode_php_tags|xss_clean');

            $items = $this->segment_model->get_results();

            if ($this->form_validation->run()) {
                //	Le formulaire est valide
                $list_data = array();
                $list_data['items'] = $items;
                $list_data['elements'] = $this->segment_model->count();

                $nav_data = array();
                $nav_data['username'] = $this->session->userdata('username');

                $this->load->view('base/header');
                $this->load->view('base/navigation', $nav_data);
                $this->load->view('segment/quicksearch');
                $this->load->view('segment/list', $list_data);
                $this->load->view('base/footer');
            } else {
                //	Le formulaire est invalide ou vide
                $nav_data = array();
                $nav_data['username'] = $this->session->userdata('username');
                $this->load->view('base/header');
                $this->load->view('base/navigation', $nav_data);
                $this->load->view('segment/quicksearch');
                $this->load->view('segment/search');
                $this->load->view('base/footer');
            }
        } else {
            // affichage
            $nav_data = array();
            $nav_data['username'] = $this->session->userdata('username');
            $this->load->view('base/header');
            $this->load->view('base/navigation', $nav_data);
            $this->load->view('segment/quicksearch');
            $this->load->view('segment/search');
            $this->load->view('base/footer');
        }
    }

    /**
     * Fonction d'edition de code en fonction d'un id
     * @param string $segCode L'id du sement a editer
     */
    public function edit($segCode) {
        $this->load->model('segment_model');
        $this->load->model('critere_model');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        $post_form = $this->input->post('is_form_sent');
        if ($post_form) {
            $post_libelle = $this->input->post('libelle');

            // Vérifications
            $this->form_validation->set_rules('libelle', 'Libellé', 'trim|alpha_dash_space|encode_php_tags|xss_clean');

            if ($this->form_validation->run()) {
                // Envoie dans la BDD
                $options_echappees = array();
                $options_echappees['SEG_LIBELLE'] = $post_libelle;

                //recuperation des criteres du segment (pour modif liens)
                $criteres = $this->critere_model->read('*', array('SEG_CODE' => $segCode));

                //modification des liens
                $links = array();
                $critere = reset($criteres);
                while ($critere) {
                    $id1 = $critere->CRIT_ID;
                    if ($critere = next($criteres)) {
                        $id2 = $critere->CRIT_ID;
                        $this->critere_model->updateLink($id1, $id2, $this->input->post($id1 . "_" . $id2));
                    }
                }

                $options_non_echappees = array();
                $options_non_echappees['SEG_DATEMODIF'] = 'NOW()';

                $this->segment_model->update(array('SEG_CODE' => $segCode), $options_echappees, $options_non_echappees);

                redirect('segment', 'refresh');
            } else {
                //	Le formulaire est invalide ou vide
                //recuperation dans la table segment
                $items = $this->segment_model->select();
                $items = $this->segment_model->read_code($segCode);
                $items = $this->segment_model->get_results();

                $list_data = array();
                $list_data['items'] = $items;

                //recuperation des criteres du segment
                $criteres = $this->critere_model->read('*', array('SEG_CODE' => $segCode));

                $list_data['criteres'] = $criteres;

                //recuperation liens entre criteres
                $links = array();
                $critere = reset($criteres);
                while ($critere) {
                    $id1 = $critere->CRIT_ID;
                    if ($critere = next($criteres)) {
                        $id2 = $critere->CRIT_ID;
                        $links["'" . $id1 . "," . $id2 . "'"] = $this->critere_model->getLink($id1, $id2);
                    }
                }

                $list_data['links'] = $links;

                $nav_data = array();
                $nav_data['username'] = $this->session->userdata('username');

                $this->load->view('base/header');
                $this->load->view('base/navigation', $nav_data);
                $this->load->view('segment/quicksearch');
                $this->load->view('segment/edit', $list_data);
                $this->load->view('base/footer');
            }
        } else {
            //recuperation dans la table segment
            $items = $this->segment_model->select();
            $items = $this->segment_model->read_code($segCode);
            $items = $this->segment_model->get_results();

            $list_data = array();
            $list_data['items'] = $items;

            //recuperation des criteres du segment
            $criteres = $this->critere_model->read('*', array('SEG_CODE' => $segCode));

            $list_data['criteres'] = $criteres;

            //recuperation liens entre criteres
            $links = array();
            $critere = reset($criteres);
            while ($critere) {
                $id1 = $critere->CRIT_ID;

                if ($critere = next($criteres)) {
                    $id2 = $critere->CRIT_ID;
                    $links["'" . $id1 . "," . $id2 . "'"] = $this->critere_model->getLink($id1, $id2);
                }
            }

            $list_data['links'] = $links;

            $nav_data = array();
            $nav_data['username'] = $this->session->userdata('username');

            $this->load->view('base/header');
            $this->load->view('base/navigation', $nav_data);
            $this->load->view('segment/quicksearch');
            $this->load->view('segment/edit', $list_data);
            $this->load->view('base/footer');
        }
    }

    /**
     * Fonction d'ajout d'un critere a un segment
     * @param string $segCode L'id du sement a editer
     * @param string $idCritPrecedent L'ancien id du segment
     */
    public function addCritere($segCode, $idCritPrecedent = '') {
        $this->load->model('contact_model');
        $this->load->model('critere_model');
        $this->load->model('segment_model');
        $this->load->model('reglage_model');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        //protection pour ne pas pouvoir modifier les criteres d'un segment bloqué
        $IsSegBlocked = $this->segment_model->read('SEG_EDIT', array('SEG_CODE' => $segCode));
        if (!($IsSegBlocked && $IsSegBlocked[0]->SEG_EDIT))
            redirect('segment/edit/' . $segCode, 'refresh');

        $post_form = $this->input->post('is_form_sent');
        if ($post_form) {
            $post_contrainte = $this->input->post('contrainte');
            $post_comp = $this->input->post('comparaison');
            $post_valeur = $this->input->post('valeurCOMEBACK');
            $type_critere = "base";

            // Vérifications et modification en fonction de la contrainte
            $erreur = "";

            $this->form_validation->set_rules('valeurCOMEBACK', 'valeur', 'trim|required|encode_php_tags|xss_clean');

            switch ($post_contrainte) {

                case "CON_ID":
                    $this->form_validation->set_rules('valeurCOMEBACK', 'valeur', 'trim|required|alpha_dash|encode_php_tags|xss_clean');

                    //verification existance dans la BDD
                    $test = $this->contact_model->read("CON_ID", array("CON_ID" => $post_valeur));
                    if (!$test)
                        $erreur = '<div class="error">Numéro de contact invalide</div>';
                    break;

                case "CON_DATE":
                    if (verif_Date($post_valeur)) {
                        $split = @split("-", $post_valeur);
                        $jour = $split[0];
                        $mois = $split[1];
                        $annee = $split[2];

                        if (strlen($jour) == 1)
                            $jour = '0' . $jour;
                        if (strlen($mois) == 1)
                            $mois = '0' . $mois;

                        $post_valeur = $annee . '-' . $mois . '-' . $jour; //format date us (base de donnée)
                    } else
                        $erreur = '<div class="error">La date saisie n\'existe pas</div>';

                    $type_critere = "base";
                    break;

                case "CON_TYPE":
                    break;

                case "CON_TYPEC":
                    break;

                case "CON_CITY":
                    $this->form_validation->set_rules('valeurCOMEBACK', 'valeur', 'trim|required|alpha_numeric|encode_php_tags|xss_clean');
                    break;

                case "CON_COUNTRY":
                    $this->form_validation->set_rules('valeurCOMEBACK', 'valeur', 'trim|required|alpha|encode_php_tags|xss_clean');
                    break;

                case "departement":
                    $this->form_validation->set_rules('valeurCOMEBACK', 'valeur', 'trim|required|numeric|exact_length[2]|encode_php_tags|xss_clean');
                    $type_critere = "dep";
                    break;

                case "CON_NPAI":
                    if ($post_valeur == 'vrai')
                        $post_valeur = 'on';
                    else
                        $post_valeur = '0';
                    break;

                case "CON_DATEADDED":
                    if (verif_Date($post_valeur)) {
                        $split = @split("-", $post_valeur);
                        $jour = $split[0];
                        $mois = $split[1];
                        $annee = $split[2];

                        if (strlen($jour) == 1)
                            $jour = '0' . $jour;
                        if (strlen($mois) == 1)
                            $mois = '0' . $mois;

                        $post_valeur = $annee . '-' . $mois . '-' . $jour; //format date us (base de donnée)
                    } else
                        $erreur = '<div class="error">La date saisie n\'existe pas</div>';

                    break;

                case "dateVersement":

                    if (verif_Date($post_valeur))
                        $post_valeur = date_frus($post_valeur); //format date us (base de donnée)
                    else
                        $erreur = '<div class="error">La date saisie n\'existe pas</div>';

                    $type_critere = "suivi";
                    break;

                //cas multiple (stat)
                case "NbDon":
                case "DonMoyen":
                case "TotalDon":
                    echo "test!!!!!!!!!!!!!!!!!!!!!!!!!!!!!";
                    $this->form_validation->set_rules('valeurCOMEBACK', 'valeur', 'trim|required|encode_php_tags|xss_clean');

                    //redécoupage résultat:
                    $tmp = explode(":", $post_valeur);
                    $valeur = $tmp[0];

                    $tmp = explode("/", $tmp[1]);
                    $DateDebut = $tmp[0];
                    $DateFin = $tmp[1];

                    echo "<br/>" . $valeur;
                    echo "<br/>" . $DateDebut;
                    echo "<br/>" . $DateFin;

                    //analyse du résultat:
                    if (!is_numeric($valeur) && $valeur >= 0)
                        $erreur = '<div class="error">La valeur est requise, doit être numérique et positive</div>';
                    if (!verif_Date($DateDebut))
                        $erreur = $erreur . '<div class="error">La date de début de période saisie n\'existe pas</div>';
                    if (!verif_Date($DateFin))
                        $erreur = $erreur . '<div class="error">La date de fin de période saisie n\'existe pas</div>';

                    if (!$erreur)
                        $post_valeur = $valeur . ":" . date_frus($DateDebut) . "/" . date_frus($DateFin);
                    $type_critere = "stat";
                    break;

                case "segment":
                    $this->form_validation->set_rules('valeurCOMEBACK', 'valeur', 'trim|required|alpha_dash|encode_php_tags|xss_clean');
                    $type_critere = "segment";

                    //verification existance dans la BDD
                    $test = $this->segment_model->read("SEG_CODE", array("SEG_CODE" => $post_valeur));
                    if (!$test)
                        $erreur = '<div class="error">Numéro de segment invalide</div>';
                    //verrou de segment recursif
                    if ($segCode == $post_valeur)
                        $erreur = '<div class="error">Vous ne pouvez selectionner le segment courant</div>';
                    else if ($this->segment_model->contientSeg($post_valeur, $segCode))
                        $erreur = '<div class="error">erreur : le segment selectionné contient le segment courant</div>';
                    break;

                default: // on a une information complémentaire de contact

                    $this->form_validation->set_rules('valeurCOMEBACK', 'valeur', 'trim|required|encode_php_tags|xss_clean');

                    $contrainte = explode(":", $post_contrainte);
                    $tmp = explode("/", $contrainte[0]);
                    if (count($tmp) > 1) {
                        //on va chercher le nom associé au critere (et le type pour traiter le cas des checkbox)
                        $this->load->model('infos_comp_model');
                        $IC = $this->infos_comp_model->read("IC_LABEL,IC_TYPE", array("IC_ID" => $tmp[0]));

                        $post_contrainte = $tmp[0] . ":" . $IC[0]->IC_LABEL;
                        $type_critere = "IC";

                        //cas checkbox :
                        if ($IC[0]->IC_TYPE == "checkbox") {
                            if ($post_valeur == 'vrai')
                                $post_valeur = 'on';
                            else
                                $post_valeur = '0';
                        }
                    }else {
                        $erreur = '<div class="error">Erreur: Attribut IC mal transmis. Contactez un technicien.</div>';
                    }
                    break;
            }


            if ($this->form_validation->run() && !$erreur) {

                //recherche d'un id critere libre (pas d'auto incrémente pour pouvoir créer un lien après -> besoin de l'id)
                $critereID = $this->critere_model->Generate_CritereID($segCode);

                // Envoie dans la BDD
                $options_echappees = array();
                $options_echappees['CRIT_ID'] = $critereID;
                $options_echappees['SEG_CODE'] = $segCode;
                $options_echappees['CRIT_TYPE'] = $type_critere;
                $options_echappees['CRIT_ATTRIBUT'] = $post_contrainte;
                $options_echappees['CRIT_COMP'] = $post_comp;
                $options_echappees['CRIT_VAL'] = $post_valeur;

                $this->critere_model->create($options_echappees);

                //plus création lien
                if ($idCritPrecedent)
                    $this->critere_model->addLink($idCritPrecedent, $critereID, "et"); // 'et' créé par defaut
                redirect('segment/edit/' . $segCode, 'refresh');
            }else {
                //	Le formulaire est invalide ou vide

                $list_data = array();
                $list_data['segCode'] = $segCode;
                $list_data['erreur'] = $erreur;
                $list_data['ID_prevCrit'] = $idCritPrecedent;

                //chargement liste des infos complémentaire contacts
                $this->load->model('infos_comp_model');
                $list_data['list_IC'] = $this->infos_comp_model->read_all();

                //ajout options de champ parametrable ( = type de contact)
                $Options_morale = $this->reglage_model->read('CON_MORALE');
                $Options_physique = $this->reglage_model->read('CON_PHYSIQUE');
                $Options_type_contact = '';
                if ($Options_morale && $Options_morale[0]->REG_LIST)
                    $Options_type_contact = $Options_morale[0]->REG_LIST;
                if ($Options_physique && $Options_physique[0]->REG_LIST) {
                    if ($Options_type_contact)
                        $Options_type_contact = $Options_type_contact . ',' . $Options_physique[0]->REG_LIST;
                    else
                        $Options_type_contact = $Options_physique[0]->REG_LIST;
                }
                $list_data['Options_type_contact'] = $Options_type_contact;

                $nav_data = array();
                $nav_data['username'] = $this->session->userdata('username');

                $this->load->view('base/header');
                $this->load->view('base/navigation', $nav_data);
                $this->load->view('segment/quicksearch');
                $this->load->view('segment/critere', $list_data);
                $this->load->view('base/footer');
            }
        }
        else {
            $list_data = array();
            $list_data['segCode'] = $segCode;
            $list_data['ID_prevCrit'] = $idCritPrecedent;

            //chargement liste des infos complémentaire contacts
            $this->load->model('infos_comp_model');
            $list_data['list_IC'] = $this->infos_comp_model->read_all();

            //ajout options de champ parametrable ( = type de contact)
            $Options_morale = $this->reglage_model->read('CON_MORALE');
            $Options_physique = $this->reglage_model->read('CON_PHYSIQUE');
            $Options_type_contact = '';
            if ($Options_morale && $Options_morale[0]->REG_LIST)
                $Options_type_contact = $Options_morale[0]->REG_LIST;
            if ($Options_physique && $Options_physique[0]->REG_LIST) {
                if ($Options_type_contact)
                    $Options_type_contact = $Options_type_contact . ',' . $Options_physique[0]->REG_LIST;
                else
                    $Options_type_contact = $Options_physique[0]->REG_LIST;
            }
            $list_data['Options_type_contact'] = $Options_type_contact;

            $nav_data = array();
            $nav_data['username'] = $this->session->userdata('username');

            $this->load->view('base/header');
            $this->load->view('base/navigation', $nav_data);
            $this->load->view('segment/quicksearch');
            $this->load->view('segment/critere', $list_data);
            $this->load->view('base/footer');
        }
    }

    /**
     * Fonction qui supprime un critere du segment choisi
     * @param string $code L'id du segment choisi
     * @param string $critere Le critere a supprimer
     */
    public function removeCritere($code, $critere) {
        $this->load->model('critere_model');

        //raccord des criteres restants
        $crit1 = $this->critere_model->readLinks('CRIT_ID1', array('CRIT_ID2' => $critere));

        $crit2 = $this->critere_model->readLinks('CRIT_ID2', array('CRIT_ID1' => $critere));

        if ($crit1 && $crit2)
            $this->critere_model->addLink($crit1[0]->CRIT_ID1, $crit2[0]->CRIT_ID2, 'et');

        $this->critere_model->delete(array('SEG_CODE' => $code, 'CRIT_ID' => $critere));
        redirect('segment/edit/' . $code, 'refresh');
    }

    /**
     * Fonction qui supprime un segment de la table
     * @param string $code L'id du segment choisi
     */
    public function remove($code) {
        $this->load->model('segment_model');
        //On teste si on peut supprimer le segment sans causer de pb dans offre (segment non relié)
        $seg = $this->segment_model->read('SEG_EDIT', array('SEG_CODE' => $code));
        if ($seg[0]->SEG_EDIT) {
            $this->segment_model->delete(array('SEG_CODE' => $code));
            redirect('segment', 'refresh');
        } else {
            redirect('segment', 'refresh');
        }
    }


    /**
     * Affiche la page des potentiels en fonction du segment selectionne
     * @param string $code L'id du segment selectionne
     */
    public function potentiel($code) {
        $this->load->model('segment_model');
        $this->load->model('critere_model');
        $cible = $this->segment_model->createRequest($code);
        //$cible = $this->segment_model->get_results();

        $list_data = array();
        $list_data['items'] = $cible;
        $list_data['div'] = "oui";
        $list_data['segment'] = $code;

        $nav_data = array();
        $nav_data['username'] = $this->session->userdata('username');


        $this->load->view('base/header');
        $this->load->view('base/navigation', $nav_data);
        $this->load->view('segment/list_potentiel', $list_data);
        $this->load->view('base/footer');
    }

    //Afficher page d'exporter
    /**
     * Affiche la page d'export en fonction du segment selectionne
     * @param string $code L'id du segment selectionne
     */
    public function export($code) {
        $this->load->model('reglage_model');

        $nav_data = array();
        $nav_data['username'] = $this->session->userdata('username');

        $data = array();
        $data["codeSegment"] = $code;
        $this->load->view('base/header');
        $this->load->view('base/navigation', $nav_data);

        $this->load->view('segment/export', $data);

        $this->load->view('base/footer');
    }

    //Exporter les contacts
    /**
     * Fonction d'exportation du segment
     */
    public function exportation() {

        $this->load->model('segment_model');
        $option = $this->input->post("option");
        $code = $this->input->post("code");

        $datas = array();
        array_push($datas,"c.CON_ID");
        array_push($datas,"CON_TYPE");
        array_push($datas,"CON_TYPEC");

        foreach ($option as $value) {

            if($value == "nom"){
                array_push($datas, "CON_CIVILITE");
                array_push($datas, "CON_FIRSTNAME");

            }
            else if ($value == "prenom"){
                array_push($datas, "CON_LASTNAME");
            }
            else if ($value == "date_naissance"){
                array_push($datas, "CON_DATE");
            }
            else if ($value == "email"){
                array_push($datas, "CON_EMAIL");
            }
            else if ($value == "tel"){
                array_push($datas, "CON_TELFIXE");
                array_push($datas, "CON_TELPORT");
            }

            else if ($value == "adresse"){
                array_push($datas, "CON_COMPL");
                array_push($datas, "CON_VOIE_NUM");
                array_push($datas, "CON_VOIE_TYPE");
                array_push($datas, "CON_VOIE_NOM");
                array_push($datas, "CON_BP");
                array_push($datas, "CON_CP");
                array_push($datas, "CON_CITY");
                array_push($datas, "CON_COUNTRY");
            }

            else if ($value == "date_ajout"){
                array_push($datas, "CON_DATEADDED");
            }
            else if ($value == "date_modif"){
                array_push($datas, "CON_DATEMODIF");
            }

        }
        array_push($datas, "CON_RF_ENVOI");
        array_push($datas, "CON_SOLICITATION");
        array_push($datas, "CON_COMMENTAIRE");

        if ($value == "dons"){
            array_push($datas, "DON_ID");
            array_push($datas, "DON_MONTANT");
            array_push($datas, "DON_DEVISE");
            array_push($datas, "DON_MODE");
            array_push($datas, "DON_DATEADDED");
            array_push($datas, "DON_TYPE");
            array_push($datas, "OFF_ID");
            array_push($datas, "DON_DATE");
        }
        $query = $this->segment_model->createRequest($code,$datas);

        $this->load->dbutil();
        $csv = $this->dbutil->csv_from_result($query,";");

        header('Content-Type: application/csv');
        header('Content-Disposition: attachement; filename="export_contact.CSV"');
        echo $csv;
    }

}
