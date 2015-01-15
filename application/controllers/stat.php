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

}
