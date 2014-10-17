<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stat extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->association();
	}
	
	public function association()
	{
		$post_form = $this->input->post('is_form_sent');
		$list_data = array();
		$post_assoc = $this->input->post("association");
		$list_data["association"] = $post_assoc;
		$post_exp_vers = $this->input->post('exp_vers');
		$list_data['exp_vers'] = $post_exp_vers;
		$list_data['exp_offre'] = $post_exp_vers;
		
		$nav_data = array();
		$nav_data['username'] = $this->session->userdata('username');
		
		$this->load->view('base/header');
		$this->load->view('base/navigation',$nav_data);
		$this->load->view('stat/menu');
		$this->load->view('stat/association/select_assoc',$list_data);
		//$this->load->view('stat/association/base');
		if ($post_form)
		{
			if($post_exp_vers == "valeur"){ 
				$result = $this->val_versements_by_year("association");
				$list_data['objectif'] = $result[2];
			}
			else if($post_exp_vers == "volume") $result = $this->nb_versements_by_year("association");
			$list_data['cols_versements_by_year'] = $result[0];
			$list_data['rows_versements_by_year'] = $result[1];
			if($post_exp_vers == "valeur") $result = $this->val_versements_by_month("association");
			else if($post_exp_vers == "volume") $result = $this->nb_versements_by_month("association");
			$list_data['cols_versements_by_month'] = $result[0];
			$list_data['rows_versements_by_month'] = $result[1];
			if($post_exp_vers == "valeur") $result = $this->val_versements_by_type("association");
			else if($post_exp_vers == "volume") $result = $this->nb_versements_by_type("association");
			$list_data['cols_versements_by_type'] = $result[0];
			$list_data['rows_versements_by_type'] = $result[1];
			if($post_exp_vers == "valeur") $result = $this->val_versements_by_mode("association");
			else if($post_exp_vers == "volume") $result = $this->nb_versements_by_mode("association");
			$list_data['cols_versements_by_mode'] = $result[0];
			$list_data['rows_versements_by_mode'] = $result[1];			
			$this->load->view('stat/campagnes/versements',$list_data);


			if($post_exp_vers == "valeur"){ 
				$result = $this->val_versements_by_year("association");
				$list_data['objectif'] = $result[2];
			}
			else if($post_exp_vers == "volume") $result = $this->nb_offres_by_year("association");
			$list_data['cols_offres_by_year'] = $result[0];
			$list_data['rows_offres_by_year'] = $result[1];
			if($post_exp_vers == "valeur") $result = $this->nb_offres_by_month("association");
			else if($post_exp_vers == "volume") $result = $this->nb_offres_by_month("association");
			$list_data['cols_offres_by_month'] = $result[0];
			$list_data['rows_offres_by_month'] = $result[1];
			$result = $this->nb_dons_by_offre("association");
			$list_data['cols_dons_by_offre'] = $result[0];
			$list_data['rows_dons_by_offre'] = $result[1];	
			$this->load->view('stat/campagnes/offres_v2',$list_data);

			$nb_top = 10;

			$list_data['nb_top'] = $nb_top;

			if($post_exp_vers == "valeur"){ 
				$result = $this->val_versements_by_year("association");
				$list_data['objectif'] = $result[2];
			}
			$result = $this->top_donateurs_by_largeur_dons("association", $nb_top);
			$list_data['cols_top_by_largeur'] = $result[0];
			$list_data['rows_top_by_largeur'] = $result[1];
			if($post_exp_vers == "valeur") $result = $this->top_donateurs_by_montant_dons("association", $nb_top);
			else if($post_exp_vers == "volume") $result = $this->top_donateurs_by_nb_dons("association", $nb_top);
			$list_data['cols_top_by_dons'] = $result[0];
			$list_data['rows_top_by_dons'] = $result[1];
			$result = $this->top_donateurs_by_nb_offre("association", $nb_top);
			$list_data['cols_top_by_offre'] = $result[0];
			$list_data['rows_top_by_offre'] = $result[1];	
			$this->load->view('stat/campagnes/donateurs',$list_data);

			if($post_exp_vers == "valeur") $result = $this->val_versements_by_segment("association");
			else if($post_exp_vers == "volume") $result = $this->nb_versements_by_segment("association");
			$list_data['cols_seg_by_dons'] = $result[0];
			$list_data['rows_seg_by_dons'] = $result[1];
			$result = $this->nb_contacts_by_segment("association");
			$list_data['cols_contact_by_seg'] = $result[0];
			$list_data['rows_contact_by_seg'] = $result[1];
			$this->load->view('stat/campagnes/segments',$list_data);
			$this->load->view('base/footer');
		}
	}
	
	public function campagnes()
	{
		$this->load->model('campagne_model');
		$post_form = $this->input->post('is_form_sent');
		
		$items = $this->campagne_model->select();
		$items = $this->campagne_model->get_results();
		$list_data = array();
		$list_data['list_campagnes'] = $items;
		$post_campagne = $this->input->post('campagne');
		$list_data['campagne'] = $post_campagne;
		$post_exp_vers = $this->input->post('exp_vers');
		$list_data['exp_vers'] = $post_exp_vers;
		$list_data['exp_offre'] = $post_exp_vers;
		
		$nav_data = array();
		$nav_data['username'] = $this->session->userdata('username');
		
		$this->load->view('base/header');
		$this->load->view('base/navigation',$nav_data);
		$this->load->view('stat/menu');
		$this->load->view('stat/campagnes/select_cam',$list_data);
		if ($post_form)
		{

			if($post_exp_vers == "valeur"){ 
				$result = $this->val_versements_by_year($post_campagne);
				$list_data['objectif'] = $result[2];
			}
			else if($post_exp_vers == "volume") $result = $this->nb_versements_by_year($post_campagne);
			$list_data['cols_versements_by_year'] = $result[0];
			$list_data['rows_versements_by_year'] = $result[1];
			if($post_exp_vers == "valeur") $result = $this->val_versements_by_month($post_campagne);
			else if($post_exp_vers == "volume") $result = $this->nb_versements_by_month($post_campagne);
			$list_data['cols_versements_by_month'] = $result[0];
			$list_data['rows_versements_by_month'] = $result[1];
			if($post_exp_vers == "valeur") $result = $this->val_versements_by_type($post_campagne);
			else if($post_exp_vers == "volume") $result = $this->nb_versements_by_type($post_campagne);
			$list_data['cols_versements_by_type'] = $result[0];
			$list_data['rows_versements_by_type'] = $result[1];
			if($post_exp_vers == "valeur") $result = $this->val_versements_by_mode($post_campagne);
			else if($post_exp_vers == "volume") $result = $this->nb_versements_by_mode($post_campagne);
			$list_data['cols_versements_by_mode'] = $result[0];
			$list_data['rows_versements_by_mode'] = $result[1];			
			$this->load->view('stat/campagnes/versements',$list_data);


			if($post_exp_vers == "valeur"){ 
				$result = $this->val_versements_by_year($post_campagne);
				$list_data['objectif'] = $result[2];
			}
			else if($post_exp_vers == "volume") $result = $this->nb_offres_by_year($post_campagne);
			$list_data['cols_offres_by_year'] = $result[0];
			$list_data['rows_offres_by_year'] = $result[1];
			if($post_exp_vers == "valeur") $result = $this->nb_offres_by_month($post_campagne);
			else if($post_exp_vers == "volume") $result = $this->nb_offres_by_month($post_campagne);
			$list_data['cols_offres_by_month'] = $result[0];
			$list_data['rows_offres_by_month'] = $result[1];
			$result = $this->nb_dons_by_offre($post_campagne);
			$list_data['cols_dons_by_offre'] = $result[0];
			$list_data['rows_dons_by_offre'] = $result[1];	
			$this->load->view('stat/campagnes/offres_v2',$list_data);

			$nb_top = 10;

			$list_data['nb_top'] = $nb_top;

			if($post_exp_vers == "valeur"){ 
				$result = $this->val_versements_by_year($post_campagne);
				$list_data['objectif'] = $result[2];
			}
			$result = $this->top_donateurs_by_largeur_dons($post_campagne, $nb_top);
			$list_data['cols_top_by_largeur'] = $result[0];
			$list_data['rows_top_by_largeur'] = $result[1];
			if($post_exp_vers == "valeur") $result = $this->top_donateurs_by_montant_dons($post_campagne, $nb_top);
			else if($post_exp_vers == "volume") $result = $this->top_donateurs_by_nb_dons($post_campagne, $nb_top);
			$list_data['cols_top_by_dons'] = $result[0];
			$list_data['rows_top_by_dons'] = $result[1];
			$result = $this->top_donateurs_by_nb_offre($post_campagne, $nb_top);
			$list_data['cols_top_by_offre'] = $result[0];
			$list_data['rows_top_by_offre'] = $result[1];	
			$this->load->view('stat/campagnes/donateurs',$list_data);


			if($post_exp_vers == "valeur") $result = $this->val_versements_by_segment($post_campagne);
			else if($post_exp_vers == "volume") $result = $this->nb_versements_by_segment($post_campagne);
			$list_data['cols_seg_by_dons'] = $result[0];
			$list_data['rows_seg_by_dons'] = $result[1];
			$result = $this->nb_contacts_by_segment($post_campagne);
			$list_data['cols_contact_by_seg'] = $result[0];
			$list_data['rows_contact_by_seg'] = $result[1];
			$this->load->view('stat/campagnes/segments',$list_data);
			
		}
		$this->load->view('stat/end_menu');
		$this->load->view('base/footer');
	}
	
	public function val_versements_by_year($cam_id)
	{
		$this->load->model('don_model');
		$this->load->model('campagne_model');
		
		$cols = array();
		
		$items = $this->don_model->select();
		$items = $this->don_model->get_results();
		
		$date = date("d-m-Y");
		$split = @split("-",$date);
		$year = intval($split[2]);
		$year = $year - 14;
		
		for($i = 0; $i < 15; $i++){
			$cols[$i] = "$year";
			$year = $year + 1;
		}
		
		sort($cols);
		
		$rows = array();
		
		foreach($cols as $col){
			$items = $this->don_model->read_stats();
			$items = $this->don_model->read_annee_creation($col);
			if($cam_id != "association")$items = $this->don_model->read_campagne($cam_id);
			$items = $this->don_model->get_results();
			
			$rows[$col] = $items[0]->total;
			if($col != $cols[0]) $rows[$col] = $items[0]->total + $prec;
			$prec = $rows[$col];
		}
		
		$items = $this->campagne_model->select();
		if($cam_id != "association")$items = $this->campagne_model->read_id($cam_id);
		$items = $this->campagne_model->get_results();
		
		$objectif = $items[0]->CAM_OBJECTIF;
		
		return array($cols, $rows, $objectif);
	}
	
	public function nb_versements_by_year($cam_id)
	{
		$this->load->model('don_model');
		
		$cols = array();
		
		$items = $this->don_model->select();
		$items = $this->don_model->get_results();
		
		$date = date("d-m-Y");
		$split = @split("-",$date);
		$year = intval($split[2]);
		$year = $year - 14;
		
		for($i = 0; $i < 15; $i++){
			$cols[$i] = "$year";
			$year = $year + 1;
		}
		
		sort($cols);
		
		$rows = array();
		
		foreach($cols as $col){
			$items = $this->don_model->select();
			$items = $this->don_model->read_annee_creation($col);
			if($cam_id != "association")$items = $this->don_model->read_campagne($cam_id);
			$items = $this->don_model->get_results();
			
			$num = count($items);
			
			$rows[$col] = $num;
		}
		
		return array($cols, $rows);
	}
	
	public function val_versements_by_month($cam_id)
	{
		$this->load->model('don_model');
		
		$cols = array();
		
		$items = $this->don_model->select();
		$items = $this->don_model->get_results();
		
		for($i = 1; $i < 13; $i++){
			if($i < 10) $cols[$i-1] = "0" . "$i";
			else $cols[$i-1] = "$i";
		}
		
		$rows = array();
		
		$date = date("d-m-Y");
		$split = @split("-",$date);
		$year = $split[2];
		$total = 0;
		$year2 = $year-16;
		for($i = $year2; $i < $year; $i++)
		{
			$items = $this->don_model->read_stats();
			$items = $this->don_model->read_annee_creation($i);
			if($cam_id != "association")$items = $this->don_model->read_campagne($cam_id);
			$items = $this->don_model->get_results();
			$total = $total + $items[0]->total;
		}

		foreach($cols as $col){
			$items = $this->don_model->read_stats();
			$items = $this->don_model->read_mois_creation($col);
			$items = $this->don_model->read_annee_creation($year);
			if($cam_id != "association")$items = $this->don_model->read_campagne($cam_id);
			$items = $this->don_model->get_results();
			$total = $total + $items[0]->total;
			$rows[$col] = $total;
		}

		$items = $this->campagne_model->select();
		if($cam_id != "association")$items = $this->campagne_model->read_id($cam_id);
		$items = $this->campagne_model->get_results();
		
		$objectif = $items[0]->CAM_OBJECTIF;
		
		return array($cols, $rows);
	}
	
	public function nb_versements_by_month($cam_id)
	{
		$this->load->model('don_model');
		
		$cols = array();
		
		$items = $this->don_model->select();
		$items = $this->don_model->get_results();
		
		for($i = 1; $i < 13; $i++){
			if($i < 10) $cols[$i-1] = "0" . "$i";
			else $cols[$i-1] = "$i";
		}
		
		$rows = array();
		
		$date = date("d-m-Y");
		$split = @split("-",$date);
		$year = $split[2];
		
		foreach($cols as $col){
			$items = $this->don_model->select();
			$items = $this->don_model->read_mois_creation($col);
			$items = $this->don_model->read_annee_creation($year);
			if($cam_id != "association")$items = $this->don_model->read_campagne($cam_id);
			$items = $this->don_model->get_results();
			$num = count($items);
			
			$rows[$col] = $num;
		}
		
		return array($cols, $rows);
	}
	
	public function val_versements_by_type($cam_id)
	{
		$this->load->model('don_model');
		
		$i = 0;
		$cols = array();
		
		$items = $this->don_model->select();
		$items = $this->don_model->get_results();
		
		foreach($items as $item){
			$col = $item->DON_TYPE;
			if(!in_array($col, $cols)) {
				$cols[$i] = $col;
				$i = $i + 1;
			}
		}
		
		sort($cols);
		
		$rows = array();
		$num_tot = 0;
		
		foreach($cols as $col){
			$items = $this->don_model->read_stats();
			$items = $this->don_model->read_type($col);
			if($cam_id != "association")$items = $this->don_model->read_campagne($cam_id);
			$items = $this->don_model->get_results();
			$num = $items[0]->total;
			
			$num_tot = $num_tot + $num;
			$rows[$col] = $num;
		}
		
		foreach($cols as $col){
			$rows[$col] = 100 * $rows[$col] / $num_tot;
		}
		
		return array($cols, $rows);
	}
	
	public function nb_versements_by_type($cam_id)
	{
		$this->load->model('don_model');
		
		$i = 0;
		$cols = array();
		
		$items = $this->don_model->select();
		$items = $this->don_model->get_results();
		
		foreach($items as $item){
			$col = $item->DON_TYPE;
			if(!in_array($col, $cols)) {
				$cols[$i] = $col;
				$i = $i + 1;
			}
		}
		
		sort($cols);
		
		$rows = array();
		$num_tot = 0;
		
		foreach($cols as $col){
			$items = $this->don_model->select();
			$items = $this->don_model->read_type($col);
			if($cam_id != "association")$items = $this->don_model->read_campagne($cam_id);
			$items = $this->don_model->get_results();
			$num = count($items);
			
			$num_tot = $num_tot + $num;
			$rows[$col] = $num;
		}
		
		foreach($cols as $col){
			$rows[$col] = 100 * $rows[$col] / $num_tot;
		}
		
		return array($cols, $rows);
	}
	
	public function val_versements_by_mode($cam_id)
	{
		$this->load->model('don_model');
		
		$i = 0;
		$cols = array();
		
		$items = $this->don_model->select();
		$items = $this->don_model->get_results();
		
		foreach($items as $item){
			$col = $item->DON_MODE;
			if(!in_array($col, $cols)) {
				$cols[$i] = $col;
				$i = $i + 1;
			}
		}
		
		sort($cols);
		
		$rows = array();
		$num_tot = 0;
		
		foreach($cols as $col){
			$items = $this->don_model->read_stats();
			$items = $this->don_model->read_mode($col);
			if($cam_id != "association")$items = $this->don_model->read_campagne($cam_id);
			$items = $this->don_model->get_results();
			$num = $items[0]->total;
			
			$num_tot = $num_tot + $num;
			$rows[$col] = $num;
		}
		
		foreach($cols as $col){
			$rows[$col] = 100 * $rows[$col] / $num_tot;
		}
		
		return array($cols, $rows);
	}
	
	public function nb_versements_by_mode($cam_id)
	{
		$this->load->model('don_model');
		
		$i = 0;
		$cols = array();
		
		$items = $this->don_model->select();
		$items = $this->don_model->get_results();
		
		foreach($items as $item){
			$col = $item->DON_MODE;
			if(!in_array($col, $cols)) {
				$cols[$i] = $col;
				$i = $i + 1;
			}
		}
		
		sort($cols);
		
		$rows = array();
		$num_tot = 0;
		
		foreach($cols as $col){
			$items = $this->don_model->select();
			$items = $this->don_model->read_mode($col);
			if($cam_id != "association")$items = $this->don_model->read_campagne($cam_id);
			$items = $this->don_model->get_results();
			$num = count($items);
			
			$num_tot = $num_tot + $num;
			$rows[$col] = $num;
		}
		
		foreach($cols as $col){
			$rows[$col] = 100 * $rows[$col] / $num_tot;
		}
		
		return array($cols, $rows);
	}
	
	public function val_versements_by_segment($cam_id)
	{
		$this->load->model('don_model');
		$this->load->model('cible_model');
		$this->load->model('offre_model');
		$this->load->model('segment_model');

		$liste_segment = $this->segment_model->select();
		$liste_segment = $this->segment_model->get_results();
		$seg_list = array();
		$row = array();
		$cols = array();
		$i = 0;
		$j = 0;

		//On ne cherche qu'à garder les segments qui n'en contiennent pas d'autre
		foreach($liste_segment as $seg) //***
		{
			$save = true;
			foreach($liste_segment as $seg2)
			{
				if($seg != $seg2)
					if($this->segment_model->contientSeg($seg->SEG_CODE,$seg2->SEG_CODE))
					{
						$save = false; //On ne garde pas le segment
					}
			}
			if($save) { $seg_list[$i] = $seg; $i = $i+1; }
		}//****boucle optionnelle, remplacer $liste_segment par $seg_list dans les lignes suivantes pour l'utiliser


		//Pour chaque segment on récupère la liste de contact et on additionne leurs versements 
		foreach($liste_segment as $seg)
		{
			$seg_test = array();
			$seg_test[0] = $seg->SEG_CODE;

			$liste_contact = $this->segment_model->createCible($seg_test);
			$total_versement = 0;
			foreach($liste_contact as $con)
			{
				$items = $this->don_model->select();
				if($cam_id != "association")$items = $this->don_model->read_campagne($cam_id);
				$items = $this->don_model->read_numAd($con["CON_ID"]);
				$items = $this->don_model->get_results();

				foreach($items as $item)
				{
					$total_versement = $total_versement + $item->DON_MONTANT;
				}
			}
			$row[$seg->SEG_CODE] = $total_versement;
			$cols[$j] = $seg->SEG_CODE;
			$j = $j+1;
		}
		
		return array($cols, $row);
	}
	
	public function nb_versements_by_segment($cam_id)
	{
		$this->load->model('don_model');
		$this->load->model('cible_model');
		$this->load->model('offre_model');
		$this->load->model('segment_model');

		$liste_segment = $this->segment_model->select();
		$liste_segment = $this->segment_model->get_results();
		$seg_list = array();
		$row = array();
		$cols = array();
		$i = 0;
		$j = 0;

		//On ne cherche qu'à garder les segments qui n'en contiennent pas d'autre
		foreach($liste_segment as $seg)//**********
		{
			$save = true;
			foreach($liste_segment as $seg2)
			{
				if($seg != $seg2)
					if($this->segment_model->contientSeg($seg->SEG_CODE,$seg2->SEG_CODE))
					{
						$save = false; //On ne garde pas le segment
					}
			}
			if($save) { $seg_list[$i] = $seg; $i = $i+1; }
		}//****boucle optionnelle, remplacer $liste_segment par $seg_list dans les lignes suivantes pour l'utiliser


		//Pour chaque segment on récupère la liste de contact et on additionne leurs versements 
		foreach($liste_segment as $seg)
		{
			$seg_test = array();
			$seg_test[0] = $seg->SEG_CODE;

			$liste_contact = $this->segment_model->createCible($seg_test);
			$total_versement = 0;
			foreach($liste_contact as $con)
			{
				$items = $this->don_model->select();
				$items = $this->don_model->read_numAd($con["CON_ID"]);
				if($cam_id != "association")$items = $this->don_model->read_campagne($cam_id);
				$items = $this->don_model->get_results();

				$nb_dons = count($items);
				$total_versement = $total_versement + $nb_dons;
			}

			$row[$seg->SEG_CODE] = $total_versement;
			$cols[$j] = $seg->SEG_CODE;
			$j = $j+1;
		}
		
		return array($cols, $row);
	}



	public function nb_contacts_by_segment($cam_id)
	{
		$this->load->model('cible_model');
		$this->load->model('offre_model');
		$this->load->model('segment_model');

		$liste_segment = $this->segment_model->select();
		$liste_segment = $this->segment_model->get_results();
		$seg_list = array();
		$row = array();
		$cols = array();
		$i = 0;
		$j = 0;

		//On ne cherche qu'à garder les segments qui n'en contiennent pas d'autre
		foreach($liste_segment as $seg)//********
		{
			$save = true;
			foreach($liste_segment as $seg2)
			{
				if($seg != $seg2)
					if($this->segment_model->contientSeg($seg->SEG_CODE,$seg2->SEG_CODE))
					{
						$save = false; //On ne garde pas le segment
					}
			}
			if($save) { $seg_list[$i] = $seg; $i = $i+1; }
		}//****boucle optionnelle, remplacer $liste_segment par $seg_list dans les lignes suivantes pour l'utiliser

		//Pour chaque segment on récupère la liste de contact
		foreach($liste_segment as $seg)
		{
			$seg_test = array();
			$seg_test[0] = $seg->SEG_CODE;

			$liste_contact = $this->segment_model->createCible($seg_test);
			$row[$seg->SEG_CODE] = count($liste_contact);
			$cols[$j] = $seg->SEG_CODE;
			$j = $j+1;
		}
		
		return array($cols, $row);
	}


	public function nb_offres_by_year($cam_id)
	{
		$this->load->model('offre_model');
		
		$i = 0;
		$cols = array();
		
		$items = $this->offre_model->select();
		$items = $this->offre_model->get_results();
		
		$date = date("d-m-Y");
		$split = @split("-",$date);
		$year = intval($split[2]);
		$year = $year - 14;
		
		for($i = 0; $i < 15; $i++){
			$cols[$i] = "$year";
			$year = $year + 1;
		}
		
		sort($cols);
		
		$rows = array();
		
		foreach($cols as $col){
			$items = $this->offre_model->select();
			$items = $this->offre_model->read_annee_creation($col);
			if($cam_id != "association")$items = $this->offre_model->read_camID($cam_id);
			$items = $this->offre_model->get_results();
			$num = count($items);	
			$rows[$col] = $num;

		}
		
		// $list_data = array();
		// $list_data['cols_nb_dons_by_year'] = $cols;
		// $list_data['rows_nb_dons_by_year'] = $rows;
		
		return array($cols, $rows);
		
		// $this->load->view('stat/campagnes/dons_histo',$list_data);
	}

	public function nb_offres_by_month($cam_id)
	{
		$this->load->model('offre_model');
		
		$i = 0;
		$cols = array();
		
		$items = $this->offre_model->select();
		$items = $this->offre_model->get_results(); 
		for($i = 1; $i < 13; $i++){
			if($i < 10) $cols[$i-1] = "0" . "$i";
			else $cols[$i-1] = "$i";
		}
		
		$rows = array();
		
		$date = date("d-m-Y");
		$split = @split("-",$date);
		$year = $split[2];

		foreach($cols as $col){
			$items = $this->offre_model->select();
			$items = $this->offre_model->read_mois_creation($col);
			$items = $this->offre_model->read_annee_creation($year);
			//if($year != "") $items = $this->don_model->read_annee_creation($year);
			if($cam_id != "association")$items = $this->offre_model->read_camID($cam_id);
			$items = $this->offre_model->get_results();
			$num = count($items);
			
			$rows[$col] = $num;
		}
		
		//$list_data = array();
		//$list_data['cols_nb_offre_by_year'] = $cols;
		//$list_data['rows_nb_offre_by_year'] = $rows;
		
		return array($cols, $rows);
		
		//$this->load->view('stat/campagnes/dons_histo',$list_data);
	}


	public function nb_dons_by_offre($cam_id)
	{
		$this->load->model('offre_model');
		$this->load->model('don_model');

		$items = $this->offre_model->select();
		$items = $this->offre_model->get_results();
		$rows = array();
		$cols = array();
		$i=0;
		foreach($items as $item)
		{
			$dons = $this->don_model->select();
			$dons = $this->don_model->read_offre($item->OFF_ID);
			if($cam_id != "association")$dons = $this->don_model->read_campagne($cam_id);
			$dons = $this->don_model->get_results();
			$col = count($dons);
			$rows[$item->OFF_ID] =  $col;
			$cols[$i] = $item->OFF_ID;
			$i = $i+1;
		}

		//$list_data = array();
		//$list_data['cols_nb_dons_by_offre'] = $items;
		//$list_data['rows_nb_dons_by_offre'] = $rows;
		return array($cols, $rows);
		
	}


	public function top_donateurs_by_nb_dons($cam_id, $nb_top)
	{
		$this->load->model('contact_model');
		$this->load->model('don_model');

		$items = $this->contact_model->select();
		$items = $this->offre_model->get_results();
		$rows = array();
		$cols = array();
		$cols2 = array();
		$total = 0;
		foreach($items as $item)
		{
			$dons = $this->don_model->select();
			$dons = $this->don_model->read_id($item->CON_ID);
			if($cam_id != "association")$dons = $this->don_model->read_campagne($cam_id);
			$dons = $this->don_model->get_results();
			$col = count($dons);
			$total = $total + $col;
			$cols[$item->CON_ID] = $col;
		}
		arsort($cols);
		$i = 0;
		$reste = 0;
		foreach($cols as $contact_ID => $nombre_dons)
		{
			if($i < $nb_top)
			{
				$cols2[$i] = $contact_ID;
				$rows[$contact_ID] = $nombre_dons;
				$i = $i + 1;
			}
			else $reste = $reste + $nombre_dons;
		}
		//$cols2[$nb_top] = 'reste';
		//$rows['reste'] = $reste;
		return array($cols2, $rows);
	}

	public function top_donateurs_by_montant_dons($cam_id, $nb_top)
	{
		$this->load->model('contact_model');
		$this->load->model('don_model');

		$items = $this->contact_model->select();
		$items = $this->offre_model->get_results();
		$rows = array();
		$cols = array();
		$cols2 = array();
		foreach($items as $item)
		{
			$montant = 0;
			$dons = $this->don_model->select();
			$dons = $this->don_model->read_id($item->CON_ID);
			if($cam_id != "association")$dons = $this->don_model->read_campagne($cam_id);
			$dons = $this->don_model->get_results();
			foreach($dons as $don)
			{
				$montant = $montant + $don->DON_MONTANT;
			}
			$cols[$item->CON_ID] = $montant;
		}
		arsort($cols);
		$i = 0;
		$reste = 0;
		foreach($cols as $contact_ID => $montant)
		{
			if($i < $nb_top)
			{
				$cols2[$i] = $contact_ID;
				$rows[$contact_ID] = $montant;
				$i = $i + 1;
			}
			else $reste = $reste + $montant;
		}
		//$cols2[$nb_top] = 'reste';
		//$rows['reste'] = $reste;
		return array($cols2, $rows);
	}

	public function top_donateurs_by_largeur_dons($cam_id, $nb_top)
	{
		$this->load->model('contact_model');
		$this->load->model('don_model');

		$items = $this->contact_model->select();
		$items = $this->offre_model->get_results();
		$rows = array();
		$cols = array();
		$cols2 = array();
		foreach($items as $item)
		{
			$montant = 0;
			$dons = $this->don_model->select();
			$dons = $this->don_model->read_id($item->CON_ID);
			if($cam_id != "association")$dons = $this->don_model->read_campagne($cam_id);
			$dons = $this->don_model->get_results();
			foreach($dons as $don)
			{
				$montant = max($montant, $don->DON_MONTANT);
			}
			$cols[$item->CON_ID] = $montant;
		}
		arsort($cols);
		$i = 0;
		$reste = 0;
		foreach($cols as $contact_ID => $montant)
		{
			if($i < $nb_top)
			{
				$cols2[$i] = $contact_ID;
				$rows[$contact_ID] = $montant;
				$i = $i + 1;
			}
			else $reste = $reste + $montant;
		}
		//$cols2[$nb_top] = 'reste';
		//$rows['reste'] = $reste;
		return array($cols2, $rows);
	}

	public function top_donateurs_by_nb_offre($cam_id, $nb_top)
	{
		$this->load->model('contact_model');
		$this->load->model('offre_model');

		$items = $this->contact_model->select();
		$items = $this->contact_model->get_results();
		$rows = array();
		$cols = array();
		$cols2 = array();
		foreach($items as $item)
		{
			$offres = $this->offre_model->select();
			$offres = $this->offre_model->offre_rattache($item->CON_ID);
			$offres = $this->offre_model->reponses_associees($item->CON_ID);
			if($cam_id != "association")$offres = $this->offre_model->read_camID($cam_id);
			$offres = $this->offre_model->get_results();
			$col = count($offres);
			$cols[$item->CON_ID] = $col;
		}
		arsort($cols);
		$i = 0;
		foreach($cols as $contact_ID => $nombre_offres)
		{
			if($i < $nb_top)
			{
				$cols2[$i] = $contact_ID;
				$rows[$contact_ID] = $nombre_offres;
				$i = $i + 1;
			}
		}
		return array($cols2, $rows);
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */