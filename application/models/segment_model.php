<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model d'un segment
 */
class Segment_model extends MY_Model
{
    protected $table = 'segments';
	protected $PKey = 'SEG_ID';
	
	public function select() {
		return $this->db->select('*')->from($this->table);
	}
	
	public function get_results() {
		return $this->db->get()->result();
	}
        
        public function get() {
		return $this->db->get();
	}

	public function read_code($code) {
		return $this->db->where('SEG_CODE', (string) $code);
	}
	
	public function read_libelle($libelle) {
		return $this->db->like('SEG_LIBELLE', (string) $libelle, 'after');
	}
	
	//permet de verifier si un segment est contenu dans un autre (evite les boucles de segments)
	public function contientSeg($segTeste,$segCode) {
		//recup�ration des criteres du segment test�
		$this->load->model('segment_model');
		$this->load->model('critere_model');
		$criteres = $this->critere_model->read('CRIT_ATTRIBUT,CRIT_VAL',array('SEG_CODE' => $segTeste));
		
		$bool = false;
		
		foreach($criteres as $critere)
		{
			if($critere->CRIT_ATTRIBUT == "segment")
			{
				if($critere->CRIT_VAL == $segCode) return true;
				else $bool = $bool || $this->segment_model->contientSeg($critere->CRIT_VAL,$segCode);
			}
		}
		return $bool;
			
	}
	
	//Bloque la modification d'un segment et de sa descendance
	public function blockSegEdit($segCode)
	{
		$this->load->model('segment_model');
		$this->load->model('critere_model');
		
		//Blocage du segment de l'offre (modifications ne sont plus permises)
		$this->segment_model->update(array('SEG_CODE'=>$segCode),array('SEG_EDIT'=>false));
		
		// et de sa descendance :
		$criteres = $this->critere_model->read('CRIT_ATTRIBUT,CRIT_VAL',array('SEG_CODE' => $segCode));
		foreach($criteres as $critere)
		{
			if($critere->CRIT_ATTRIBUT == "segment")
			{
				$this->segment_model->blockSegEdit($critere->CRIT_VAL);
			}
		}
	}

	/** genere la liste des contacts � partir du code segment **/
	public function createRequest($segCode, $array = null) {
		
		//r�cup�ration des criteres du segments	
		$this->load->model('critere_model');
		$this->load->model('contacts_ic_model');
		$criteres = $this->critere_model->read('*',array('SEG_CODE' => $segCode));
		
		//recuperation liens entre criteres
		$links = array();
		$critere = current($criteres);
		while($critere)
		{
			$id1 = $critere->CRIT_ID;
			if($critere = next($criteres))
			{
				$id2 = $critere->CRIT_ID;
				$links["'".$id1.",".$id2."'"] = $this->critere_model->getLink($id1,$id2);
			}
		}
		
		//premier parcours des criteres : analyse et appel des sous requetes(segments)
		$listSousSegments = array();
		$listDateVersement = array();
		$listNbDon = array();
		$listDonMoyen = array();
		$listTotalDon = array();
		$listIC = array();
		foreach($criteres as $critere)
		{
			if($critere->CRIT_ATTRIBUT=='segment')
			{
				$Result = $this->createRequest($critere->CRIT_VAL); 
				array_push($listSousSegments,convResulRequest($Result));
				
			}else if($critere->CRIT_ATTRIBUT=='dateVersement'){
			
				$dateVersements = $this->GetDateVersement();
				$listOK =array('none'); //evite les erreurs de requete si la liste est vide ('none' permet juste � l'array de ne pas etre vide)
				foreach($dateVersements as $dateVersement)
				{
					if($critere->CRIT_COMP == ">")
					{
						if($dateVersement['DateVersement'] > date_frus($critere->CRIT_VAL)) array_push($listOK,$dateVersement['CON_ID']);
						
					}else if($critere->CRIT_COMP == "<") 
					{
						if($dateVersement['DateVersement']  < date_frus($critere->CRIT_VAL) && $dateVersement['DateVersement'] != '0000-00-00') array_push($listOK,$dateVersement['CON_ID']);
					}else // "="
					{
						if($dateVersement['DateVersement']  == date_frus($critere->CRIT_VAL)) array_push($listOK,$dateVersement['CON_ID']);
					}
				}
				array_push($listDateVersement,$listOK);
				
			}else if($critere->CRIT_ATTRIBUT=='NbDon'){
			
				$Nbdons = $this->GetNbDon($critere->CRIT_VAL);
				$listOK =array('none'); //evite les erreurs de requete si la liste est vide ('none' permet juste � l'array de ne pas etre vide)
				foreach($Nbdons as $NbDon)
				{
					if($critere->CRIT_COMP == ">")
					{
						if($NbDon['NbDon']  > $critere->CRIT_VAL) array_push($listOK,$NbDon['CON_ID'] );
						
					}else if($critere->CRIT_COMP == "<") 
					{
						if($NbDon['NbDon']   < $critere->CRIT_VAL) array_push($listOK,$NbDon['CON_ID']);
					}else // "="
					{
						if($NbDon['NbDon']   == $critere->CRIT_VAL) array_push($listOK,$NbDon['CON_ID'] );
					}
				}
				array_push($listNbDon,$listOK);
			
			}else if($critere->CRIT_ATTRIBUT=='DonMoyen'){
			
				$DonMoyens = $this->GetDonMoyen($critere->CRIT_VAL);
				$listOK =array('none'); //evite les erreurs de requete si la liste est vide ('none' permet juste � l'array de ne pas etre vide)
				foreach($DonMoyens as $DonMoyen)
				{
					if($critere->CRIT_COMP == ">")
					{
						if($DonMoyen->moyenne > $critere->CRIT_VAL) array_push($listOK,$DonMoyen->CON_ID);
						
					}else if($critere->CRIT_COMP == "<") 
					{
						if($DonMoyen->moyenne < $critere->CRIT_VAL) array_push($listOK,$DonMoyen->CON_ID);
					}else // "="
					{
						if($DonMoyen->moyenne == $critere->CRIT_VAL) array_push($listOK,$DonMoyen->CON_ID);
					}
				}
				array_push($listDonMoyen,$listOK);	
				
			}else if($critere->CRIT_ATTRIBUT=='TotalDon'){
			
				$Totaldons = $this->GetTotalDon($critere->CRIT_VAL);
				$listOK =array('none'); //evite les erreurs de requete si la liste est vide ('none' permet juste � l'array de ne pas etre vide)
				foreach($Totaldons as $TotalDon)
				{
					if($critere->CRIT_COMP == ">")
					{
						if($TotalDon->total > $critere->CRIT_VAL) array_push($listOK,$TotalDon->CON_ID);
						
					}else if($critere->CRIT_COMP == "<") 
					{
						if($TotalDon->total < $critere->CRIT_VAL) array_push($listOK,$TotalDon->CON_ID);
					}else // "="
					{
						if($TotalDon->total == $critere->CRIT_VAL) array_push($listOK,$TotalDon->CON_ID);
					}
				}
				array_push($listTotalDon,$listOK);	
				
			}else if($critere->CRIT_TYPE=='IC'){
				
				$tmp = explode(":",$critere->CRIT_ATTRIBUT);
				$champsComplementaire = $tmp[0];
				$ICs = $this->contacts_ic_model->read("CON_ID",array($champsComplementaire=>$critere->CRIT_VAL));
				$listOK =array('none'); //evite les erreurs de requete si la liste est vide ('none' permet juste � l'array de ne pas etre vide)
				foreach($ICs as $IC)
				{
					array_push($listOK,$IC->CON_ID);
				}
				array_push($listIC,$listOK);	
			}
		} //Fin de l'analyse : toutes les donn�es utiles sont charg�es
		
		
		//Deuxieme parcours criteres : cr�ation de la requete du segment courant
		if (!isset($array)){
                    $request = $this->db->select('C.CON_ID, C.CON_LASTNAME, C.CON_FIRSTNAME')->from('contacts C');
                }//debut requete
		else{
                    // pour exporter fichier csv
                    $request = $this->db->select($array)->from('contacts c');
                     if (in_array("DON_ID",$array)){
                         $request = $this->db->join('dons','dons.con_id = c.con_id');     
                     }
                }
                
		//initialisation des listes pr�charg�es : (remise du pointer array au d�but)
		$SousSegment = reset($listSousSegments);
		$DateVersement = reset($listDateVersement);
		$NbDon = reset($listNbDon);
		$DonMoyen = reset($listDonMoyen);
		$TotalDon = reset($listTotalDon);
		$respecte_IC = reset($listIC);
	
		$critID_prev = '';
		foreach($criteres as $critere)
		{
			if($critere->CRIT_TYPE == "base")
			{
				if($critID_prev=='' || $links["'".$critID_prev.",".$critere->CRIT_ID."'"]=="et")
					$request = $this->db->where($critere->CRIT_ATTRIBUT.' '.$critere->CRIT_COMP,$critere->CRIT_VAL);
				else // pas premier critere et link = 'ou'
					$request = $this->db->or_where($critere->CRIT_ATTRIBUT.' '.$critere->CRIT_COMP,$critere->CRIT_VAL);
			
			}else if($critere->CRIT_TYPE == "dep")
			{
				if($critID_prev=='' || $links["'".$critID_prev.",".$critere->CRIT_ID."'"]=="et")
					if($critere->CRIT_COMP == "=")
						$request = $this->db->like('CON_CP',$critere->CRIT_VAL,'after');
					else
						$request = $this->db->not_like('CON_CP',$critere->CRIT_VAL,'after');
				else // pas premier critere et link = 'ou'
					if($critere->CRIT_COMP == "=")
						$request = $this->db->or_like('CON_CP',$critere->CRIT_VAL,'after');
					else{
						$request = $this->db->or_not_like('CON_CP',$critere->CRIT_VAL,'after');
					}
			
			}else if($critere->CRIT_TYPE == "IC")
			{
				if($critID_prev=='' || $links["'".$critID_prev.",".$critere->CRIT_ID."'"]=="et")
					if($critere->CRIT_COMP == "=")
						$request = $this->db->where_in('C.CON_ID',$respecte_IC);
					else
						$request = $this->db->where_not_in('C.CON_ID',$respecte_IC);
				else // pas premier critere et link = 'ou'
					if($critere->CRIT_COMP == "=")
						$request = $this->db->or_where_in('C.CON_ID',$respecte_IC);
					else{
						$request = $this->db->or_where_not_in('C.CON_ID',$respecte_IC);
					}
				$respecte_IC = next($listIC);
			}else{
				switch($critere->CRIT_ATTRIBUT){
				
					case "segment":
						if($critID_prev=='' || $links["'".$critID_prev.",".$critere->CRIT_ID."'"]=="et")
							if($critere->CRIT_COMP == "compris dans")
								$request = $this->db->where_in('C.CON_ID',$SousSegment);
							else
								$request = $this->db->where_not_in('C.CON_ID',$SousSegment);
						else // pas premier critere et link = 'ou'
							if($critere->CRIT_COMP == "compris dans")
								$request = $this->db->or_where_in('C.CON_ID',$SousSegment);
							else{
								$request = $this->db->or_where_not_in('C.CON_ID',$SousSegment);
							}
						$SousSegment = next($listSousSegments);
					break;
					
					case "dateVersement":
						if($critID_prev=='' || $links["'".$critID_prev.",".$critere->CRIT_ID."'"]=="et")
							$request = $this->db->where_in('C.CON_ID',$DateVersement);
						else{ // pas premier critere et link = 'ou'
							$request = $this->db->or_where_in('C.CON_ID',$DateVersement);
						}
						$DateVersement = next($listDateVersement);
					break;
					
					case "NbDon":
						if($critID_prev=='' || $links["'".$critID_prev.",".$critere->CRIT_ID."'"]=="et")
							$request = $this->db->where_in('C.CON_ID',$NbDon);
						else{ // pas premier critere et link = 'ou'
							$request = $this->db->or_where_in('C.CON_ID',$NbDon);
						}	
						$NbDon = next($listNbDon);
					break;
					
					case "DonMoyen":
						if($critID_prev=='' || $links["'".$critID_prev.",".$critere->CRIT_ID."'"]=="et")
							$request = $this->db->where_in('C.CON_ID',$DonMoyen);
						else{ // pas premier critere et link = 'ou'
							$request = $this->db->or_where_in('C.CON_ID',$DonMoyen);
						}
						$DonMoyen = next($listDonMoyen);
					break;
					
					case "TotalDon":
						if($critID_prev=='' || $links["'".$critID_prev.",".$critere->CRIT_ID."'"]=="et")
							$request = $this->db->where_in('C.CON_ID',$TotalDon);
						else{ // pas premier critere et link = 'ou'
							$request = $this->db->or_where_in('C.CON_ID',$TotalDon);
						}
						$TotalDon = next($listTotalDon);
					break;
				
				}	
			
			}
		$critID_prev = $critere->CRIT_ID;
		
		}
    
                if (!isset($array)){
                    // la requete est prete, on l'execute et renvoie le nouveau segment (resultat de la requete)
                    return $this->segment_model->get_results();
                }
                else {
                    return $this->segment_model->get();
                }	
	}
	
	/** genere une cible � partir d'une liste de segment : array[CON_ID,SEGS]
	SEGS est la liste des segments qui ont permis d'obtenir le contact (ID segments s�par�s par des virgules) 
	**/
	public function createCible($table_segs)
	{
		//Pour le premier segment
		$cible = array();
		$contacts = $this->createRequest($table_segs[0]);
		foreach($contacts as $contact)
		{
			$con_ajout = array("CON_ID"=>$contact->CON_ID,"SEGS"=>$table_segs[0]);
			array_push($cible,$con_ajout);
		}
		
		//Pour les suivants
		for($i=1; $i < count($table_segs) ; $i++)
		{ 	
			$cibleTmp = $this->createRequest($table_segs[$i]);
			$cibleTaille = count($cible); 
			foreach($cibleTmp as $contactTmp)
			{
				//gerer le fait qu'un contact peut deja appartenir � un segment trait� pr�c�dement
				$j = 0;
				$continue = true;
				while($j < $cibleTaille && $continue)
				{
					if($cible[$j]["CON_ID"] == $contactTmp->CON_ID) // dans ce cas, il suffit de rajouter le segment associ� � la liste des segments
					{
						$cible[$j]["SEGS"] = $cible[$j]["SEGS"].",".$table_segs[$i];
						$continue = false;
					}
					$j++;
				}
				
				//Si le contact n'�tait pas deja pr�sent, on le rajoute � la cible
				if($continue)
				{
					$con_ajout = array("CON_ID"=>$contactTmp->CON_ID,"SEGS"=>$table_segs[$i]);
					array_push($cible,$con_ajout);
				}
			}
		}
		
		return $cible;
	}
	
	public function GetDonMoyen($valeur) {
		
		//r�cup�ration dates dans valeur:
		$tmp = explode(":",$valeur);				
		$tmp = explode("/",$tmp[1]);
		$DateDebut = $tmp[0];
		$DateFin = $tmp[1];
		
		$result = $this->db->select('contacts.CON_ID')->select_avg('DON_MONTANT', 'moyenne')
						->from('contacts')->join('dons','contacts.CON_ID = dons.CON_ID','left')
						->where(array('DON_DATEADDED >'=>$DateDebut,'DON_DATEADDED <'=>$DateFin))->group_by('contacts.CON_ID')
						->get()->result();
			
		foreach($result as $rs) if(!$rs->moyenne) $rs->moyenne=0;

		return $result;
	
	}
	
	public function GetNbDon($valeur) {
	
		//r�cup�ration dates dans valeur:
		$tmp = explode(":",$valeur);				
		$tmp = explode("/",$tmp[1]);
		$DateDebut = $tmp[0];
		$DateFin = $tmp[1];
		
		$listContact = $this->db->select('CON_ID')->from('contacts')->group_by('CON_ID')->get()->result();
	
		$listResult = array();
		$result = array();
		foreach($listContact as $contact)
		{

			$result['CON_ID'] = $contact->CON_ID;
			$result['NbDon'] = $this->db->select('CON_ID')->from('dons')
									->where(array('CON_ID'=>$contact->CON_ID,'DON_DATEADDED >'=>$DateDebut,'DON_DATEADDED <'=>$DateFin))
									->count_all_results();
			
			array_push($listResult,$result);
		}
	
		return $listResult;
	}
	
	public function GetTotalDon($valeur) {
	
		//r�cup�ration dates dans valeur:
		$tmp = explode(":",$valeur);				
		$tmp = explode("/",$tmp[1]);
		$DateDebut = $tmp[0];
		$DateFin = $tmp[1];
		
		$result = $this->db->select('contacts.CON_ID')->select_sum('DON_MONTANT', 'total')
						->from('contacts')->join('dons','contacts.CON_ID = dons.CON_ID','left')
						->where(array('DON_DATEADDED >'=>$DateDebut,'DON_DATEADDED <'=>$DateFin))->group_by('contacts.CON_ID')
						->get()->result();
			
		foreach($result as $rs) if(!$rs->total) $rs->total=0;
		
		return $result;
	}
	
	public function GetDateVersement(){
		$listContact = $this->db->select('CON_ID')->from('contacts')->group_by('CON_ID')->get()->result();
	
		$listResult = array();
		$result = array();
		foreach($listContact as $contact)
		{

			$result['CON_ID'] = $contact->CON_ID;
			$tmp = $this->db->select_max('DON_DATEADDED','maxDate')->from('dons')
									->where(array('CON_ID'=>$contact->CON_ID))->get()->result();
									
			$result['DateVersement'] = $tmp[0]->maxDate?$tmp[0]->maxDate:'0000-00-00';
			
			array_push($listResult,$result);
		}
	
		return $listResult;
	}

}
