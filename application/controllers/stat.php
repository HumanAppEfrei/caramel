<?php

/* on va voir */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Stat extends MY_Controller {

    /**
     * Fonction d'affichage de la page des statistiques
     */
    public function index() {
        parent::__construct();

        $post_form = $this->input->post('is_form_sent');


        $nav_data = array();
        $nav_data['username'] = $this->session->userdata('username');

        $this->load->view('base/header');
        $this->load->view('base/navigation', $nav_data);
        $this->load->view('stat/menu');
        //chargement du footer.
        $this->load->view('base/footer');
    }

    /**
     * Affichage de la page des adherents
     */
    public function adherents() {

        $this->load->model('contact_model');

        //je ne sais pas encore à quoi ca sert.
        $post_form = $this->input->post('is_form_sent');

        //rangement des données utilisateurs dans un tableau
        $nav_data = array();
        $nav_data['username'] = $this->session->userdata('username');

        //requête pour connaître évolution nb adhérents
        $this->contact_model->select();
        $list_data['stat_evolution_nombre_adhérents'] =$this->contact_model->read_evolution_nombre_adherents()->result();

        //requête pour connaître évolution nb donateurs
        $this->contact_model->select();
        $list_data['stat_evolution_donateurs'] =$this->contact_model->read_evolution_donateurs()->result();


        //Chargement des vues de navigation standard.
        $this->load->view('base/header');
        $this->load->view('base/navigation', $nav_data);
        $this->load->view('stat/menu');
        $this->load->view('stat/adherents/graphe_view_adherents', $list_data);
        //chargement du footer.
        $this->load->view('base/footer');
    }

    /**
     * Affichage de la page des versements
     */
    public function versements(){
        $this->load->model('don_model');

        //je ne sais pas encore à quoi ca sert.
        $post_form = $this->input->post('is_form_sent');

        //rangement des données utilisateurs dans un tableau
        $nav_data = array();
        $nav_data['username'] = $this->session->userdata('username');

        //requête pour camembert percentage type versement
        $this->don_model->select();
        $list_data['stat_percent_type_versement'] =$this->don_model->percent_type_versement()->result();

        //requête pour camembert percentage mode versement
        $this->don_model->select();
        $list_data['stat_percent_mode_versement'] =$this->don_model->percent_mode_versement()->result();

        //Chargement des vues de navigation standard.
        $this->load->view('base/header');
        $this->load->view('base/navigation', $nav_data);
        $this->load->view('stat/menu');
        $this->load->view('stat/versements/graphe_view_versements', $list_data);
        //chargement du footer.
        $this->load->view('base/footer');
    }

    /**
     * Affichage de la page des campagnes
     */
    public function campagnes(){
        $this->load->model('campagne_model');

        //je ne sais pas encore à quoi ca sert.
        $post_form = $this->input->post('is_form_sent');

        //rangement des données utilisateurs dans un tableau
        $nav_data = array();
        $nav_data['username'] = $this->session->userdata('username');

        //requête pour camembert percentage type versement
        $this->campagne_model->select();
        $list_data['stat_montant_global'] =$this->campagne_model->read_montant_global()->result();

        //requête pour nombre de campagnes
        $this->campagne_model->select();
        $list_data['stat_nb_campagne'] =$this->campagne_model->read_nombre_total()->result();

        //Chargement des vues de navigation standard.
        $this->load->view('base/header');
        $this->load->view('base/navigation', $nav_data);
        $this->load->view('stat/menu');
        $this->load->view('stat/campagnes/graphe_view_campagne', $list_data);
        //chargement du footer.
        $this->load->view('base/footer');
    }

    /**
     * Affichage de la page des offres
     */
    public function offres(){
        $this->load->model('offre_model');

        //je ne sais pas encore à quoi ca sert.
        $post_form = $this->input->post('is_form_sent');

        //rangement des données utilisateurs dans un tableau
        $nav_data = array();
        $nav_data['username'] = $this->session->userdata('username');

        //le nombre d'offre crée les 12 derniers mois
        $this->offre_model->select();
        $list_data['stat_nombre_offre_12_mois']=$this->offre_model->read_nombre_offre_12_mois()->result();

        //le nombre d'offre crée les 10 derniers années
        $this->offre_model->select();
        $list_data['stat_nombre_offre_10_ans']=$this->offre_model->read_nombre_offre_10_ans()->result();

        //le nombre d'offre crée les 10 derniers années
        $this->offre_model->select();
        $list_data['stat_somme_recoltee_offre']=$this->offre_model->read_somme_recoltee_offre()->result();

        //Chargement des vues de navigation standard.
        $this->load->view('base/header');
        $this->load->view('base/navigation', $nav_data);
        $this->load->view('stat/menu');
        $this->load->view('stat/offres/graphe_view_offre', $list_data);
        //chargement du footer.
        $this->load->view('base/footer');
    }

    /**
     * Affiche le top pour les dons.
     */
    public function top(){

        $this->load->model('don_model');

        //je ne sais pas encore à quoi ca sert.
        $post_form = $this->input->post('is_form_sent');

        //rangement des données utilisateurs dans un tableau
        $nav_data = array();
        $nav_data['username'] = $this->session->userdata('username');

        //requête pour le top10.
        $list_data = array();
        $this->don_model->select();
        $this->don_model->read_stat_top10_montant_avec_nom();
        $list_data['stat_top10_montant'] = $this->don_model->get_results();

        //requête pour camembert percentage
        $this->don_model->select();
        $list_data['stat_percent_type_versement'] =$this->don_model->percent_type_versement()->result();

        //requête top 10 des villes ayant donné le plus
        $this->don_model->select();
        $list_data['stat_top10_cumule'] =$this->don_model->read_stat_top10_montant_cumule()->result();

        //requête top 10 des villes ayant donné le plus
        $this->don_model->select();
        $list_data['stat_top10_ville'] =$this->don_model->read_stat_top10_ville()->result();

        //Chargement des vues de navigation standard.
        $this->load->view('base/header');
        $this->load->view('base/navigation', $nav_data);
        $this->load->view('stat/menu');
        $this->load->view('stat/top/graphe_view_top', $list_data);
        //chargement du footer.
        $this->load->view('base/footer');
    }

    public function test(){
        // donnees de navigation, a inclure dans toute fonction des controlleurs
        $nav_data = array();
        $nav_data['username'] = $this->session->userdata('username');

        // on charge la table 'don' via le model 'don_model'
        $this->load->model('don_model');
        // on appelle la methode de ce model
        // voir models/don_model.php
        $this->don_model->read_all_montant_with_date();

        // creation d'un nouveau tableau pour contenir les resultats
        $list_data = array();
        // ajout des resultats dans le tableau
        $list_data['dons'] = $this->don_model->get_results();

        //Chargement des vues de navigation standard.
        $this->load->view('base/header');
        $this->load->view('base/navigation', $nav_data);
        $this->load->view('stat/menu');

        // appel de la page base.php dans le repertoire de vues stat/test
        $this->load->view('stat/test/base', $list_data);

        $this->load->view('base/footer');
    }

    public function stat_campagne(){
        // Donnees de navigation, a inclure dans toute fonction des controlleurs
        $nav_data = array();
        $nav_data['username'] = $this->session->userdata('username');

        // On charge la table 'don' via le model 'don_model'
        $this->load->model('campagne_model');

        // Creation d'un nouveau tableau pour contenir les resultats
        $list_data = array();

        // on récupère les noms et les ids de toutes les campagnes
        $this->campagne_model->read_all_campagne_name();
        $list_data['campagne_name'] = $this->campagne_model->get_results();

        //var_dump($list_data);

        // on recupere la campagne selectionnee dans la vue
        $search = $this->input->post('campagne_select');

        if (! ($search==null)) {

            $list_data['campagne_choisie_id'] = $search;

            $this->campagne_model->read_montant_global($search);
            $list_data['montant'] = $this->campagne_model->get_results();

            // On récupère l'objectif fixé
            $this->campagne_model->read_objectif($search);
            $list_data['objectif'] = $this->campagne_model->get_results();

            // on récupère l'ensemble des dons de la campagne
            $this->campagne_model->read_resultat_par_mois($search);
            $tab_dons = $this->campagne_model->get_results();

            // puis on regroupe ces dons par mois et on calcule le montant total par mois
            $sommes_dons =  array();
            foreach ($tab_dons as $don) {
                $date=explode("-", $don->DON_DATE);
                $key=$date[0]."-".$date[1];
                if (!isset($sommes_dons[$key]))
                {
                    $sommes_dons[$key]=(int)$don->DON_MONTANT;
                }else{
                    $sommes_dons[$key]+=(int)$don->DON_MONTANT;
                }

            }
            // on trie les mois par ordre croissant
            ksort($sommes_dons);

            $list_data['historique']=$sommes_dons;
        }

        // Chargement des vues de navigation standard
        $this->load->view('base/header');
        $this->load->view('base/navigation', $nav_data);
        $this->load->view('stat/menu');

        // appel de la page base.php dans le repertoire de vues stat/test
        $this->load->view('stat/stats_campagnes', $list_data);

        $this->load->view('base/footer');
    }

    /*
     *  répartition des dons en fonction de leur mode de paiement
     */
    public function versements_par_mode(){
        //donnees de navigation, a inclure dans toute fonction des controlleurs
        $nav_data = array();
        $nav_data['username'] = $this->session->userdata('username');

        // on charge la table 'don' via le model 'don_model'
        $this->load->model('don_model');

        // creation d'un nouveau tableau pour contenir les resultats
        $list_data = array();

        // recupération des dates entre lesquelles on veut voir les dates
        $debut = $this->input->post('debut');
        $fin = $this->input->post('fin');
        $campagne = $this->input->post('campagne-select');

        //var_dump($debut);
        //var_dump($fin);

        // recupération des dons de type virement
        $researched_mode = (string) virement;
        $this->don_model->read_montant_from_mode($researched_mode, $debut, $fin, $campagne);
        $list_data['virements'] = $this->don_model->get_results();  // ajout des resultats dans le tableau

        // recuperation des dons de type cheque
        $researched_mode = (string) cheque;
        $this->don_model->read_montant_from_mode($researched_mode, $debut, $fin, $campagne);
        $list_data['cheques'] = $this->don_model->get_results();

        // recuperation des dons de type especes
        $researched_mode = (string) espece;
        $this->don_model->read_montant_from_mode($researched_mode, $debut, $fin,$campagne);
        $list_data['especes'] = $this->don_model->get_results();

        // recuperation des dons de type carte
        $researched_mode = (string) carte;
        $this->don_model->read_montant_from_mode($researched_mode, $debut, $fin,$campagne);
        $list_data['cartes'] = $this->don_model->get_results();

        $this->load->model('campagne_model');
        $this->campagne_model->select();
        $campagnes = array();
        foreach ($this->campagne_model->get_results() as $campagne)
        {
            $campagnes[$campagne->CAM_ID] = $campagne->CAM_NOM;
        }

        $list_data['campagnes'] = $campagnes;
        //Chargement des vues de navigation standard.
        $this->load->view('base/header');
        $this->load->view('base/navigation', $nav_data);
        $this->load->view('stat/menu');

        // appel de la vue affichant les courbes pour chaque mode
        $this->load->view('stat/dons_par_mode', $list_data);

        $this->load->view('base/footer');

    }
}
