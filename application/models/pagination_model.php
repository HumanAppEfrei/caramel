<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Model pour la pagination
 */
class Pagination_model extends MY_Model {




    /**
     * Cree une config en fonction de l'url et des informations de post
     * @param string $url L'url demandee
     * @param string $post Les informations de post
     * @return array Les informations de de pagination
     */
	public function template($url,$post){
		$this->load->helper("url");
		$this->load->library("pagination");
		$config = array();
        $config["base_url"] = base_url(). $url .$post;
        $config["per_page"] = 20;
        $config["uri_segment"] = 3;
        $config['first_link'] = 'Première';
        $config['last_link'] = 'Dernière';
		$config['full_tag_open']= '<div class = "pagination pagination-centered"> <ul>';
		$config['full_tag_close']= '</ul></div>';
		$config['first_tag_open'] ='<li>';
		$config['first_tag_close'] ='</li>';
		$config['last_tag_open'] ='<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open']='<li class="disabled"><a>';
		$config['cur_tag_close']='</li class="disabled"></a>';
		$config['page_query_string'] = TRUE;

		return $config;
	}

    /**
     * Initialise la pagination
     * @param unknown $config La configuration a initialiser
     */
	public function initialize($config){
		$this->pagination->initialize($config);
	}

    /**
     * Cree des liens
     * @return unknown Les liens crees
     */
	public function create_links(){
		return $this->pagination->create_links();
	}

}

