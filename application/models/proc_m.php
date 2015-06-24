<?php

class Proc_m extends CI_Model {

	#Constructor
	function Proc_m()
	{
		parent::__construct();
		$this->load->model('Query_reader', 'Query_reader', TRUE);
		$this->load->model('Ip_location', 'iplocator');
	}

	function fetch_annual_procurement_plan($refid=0){
		$data = array('SEARCHSTRING' => ' 1 and 1  and bidinvitations.procurement_ref_no="'.$refid.'"' );
	    $query = $this->Query_reader->get_query_by_code('active_procurements',$data);
	   # print_r($query); exit();
	    $result = $this->db->query($query)->result_array();;
	    return $result;

	}

	#FETCH BIDS ON A GIGEN PROCUREMENT
	function feetch_active_procurement($idx = 0)
	{
		switch ($idx) {
			case 0:
				# code...
			//print_r($this->session->userdata);
			$userid = $this->session->userdata['userid'];
			$pde = mysql_query("select * from  users where userid =".$userid);
			$q = mysql_fetch_array($pde);

			#print_r($q['pde']); exit();
			//if($this->session->userdata[''] =='N'){


		       $data = array('SEARCHSTRING' => ' 1 and 1 and 	users.userid = '.$userid );
			  $query = $this->Query_reader->get_query_by_code('view_bidders_list',$data);
#print_r($query); exit();
			  $result = $this->db->query($query)->result_array();;
			  return $result;
			/*}
			else
			{ */
			 //  $data = array('SEARCHSTRING' => ' 1 and 1 and procurement_plan_statuses.status_id = 3' );
			 //  $query = $this->Query_reader->get_query_by_code('active_procurements',$data);
			 // # print_r($query); exit();
			 //  $result = $this->db->query($query)->result_array();;
			 //  return $result;

			//}

				break;

			default:
				# code...
				break;
		}
	}

	function fetch_active_procurement_list($idx = 0,$data){



		switch ($idx) {
			case 0:

			$userid = $this->session->userdata['userid'];
			$pde = mysql_query("select * from  users where userid =".$userid);
			$q = mysql_fetch_array($pde);
			#edit beb chain proccess ...
			if(isset($data['editbeb']) && !empty($data['editbeb']))
			{
				$bebid = mysql_real_escape_string(base64_decode($data['editbeb']));
				$query = $this->Query_reader->get_query_by_code('search_procurement_by_beb', array('SEARCHSTRING' => ' WHERE  1=1  and 	bestevaluatedbidder.id = '.$bebid.' ','limittext' => ''));
			
	 		    $result = $this->db->query($query)->result_array();
				#fetch Procurement Ref No :: --
				$procurement_ref_no = $result[0]['procurement_ref_no'];
		 	    #print_r($query); exit();
				$results = paginate_list($this, $data, 'activ_procurement_list',  array('SEARCHSTRING' => '          procurement_plan_entries.procurement_ref_no like"'.$procurement_ref_no.'"  ' ));
	    		
				#print_r($results); exit($this->db->last_query());
				return $results;


			#	$record = $this->db->query("SELECT * FROM ")
			#	$result = paginate_list($this, $data, 'active_procurement_list',  array('SEARCHSTRING' => ' and 1 and 1 and 	users.userid = '.$userid.'' ),10);
			#	return $result;

	  	}else
	  	{
			$result = paginate_list($this, $data, 'active_procurement_list',  array('SEARCHSTRING' => '   and 	users.userid = '.$userid.'  and bidinvitations.isapproved="Y"' ));
			#exit($this->db->last_query());
   	  return $result;
	  	}
			break;

			default:
				# code...
				break;
		}
	}
	function fetch_active_procurement_list2($idx = 0)
	{


		switch ($idx) {
			case 0:
			$userid = $this->session->userdata['userid'];
			$pde = mysql_query("select * from  users where userid =".$userid);
			$q = mysql_fetch_array($pde);
			$query = $this->Query_reader->get_query_by_code('active_procurement_list', array('SEARCHSTRING' => '  and 	users.userid = '.$userid.' ','limittext' => ''));
		//	$result = paginate_list($this, $data, 'active_procurement_list',  array('SEARCHSTRING' => ' 1 and 1 and 	users.userid = '.$userid.' and procurement_plan_statuses.status_id = 3' ),10);
   		    $result = $this->db->query($query)->result_array();
			  return $result;
			break;

			default:
				# code...
				break;
		}


	}

	function fetchcountries(){

	$query = $this->db->query('SELECT *  FROM countries');
	return $query->result_array();

   }

     # FETCH Best Evaluated Bidder  LIST
    function fetch_beb_list($idx = 0,$data=array() ){
    #	exit('erere');

		switch ($idx) {
			case 0:
			switch ($data['level']) {

#fetching Archived BEBs

				case 'archive':
					# code...
					$userid = $this->session->userdata['userid'];
						$pde = mysql_query("select * from  users where userid =".$userid);
						$q = mysql_fetch_array($pde);
						#$query = $this->Query_reader->get_query_by_code('view_bebs',  array('SEARCHSTRING' => ' and 1 and 1    and bidinvitations.procurement_id   in ( select procurement_ref_id FROM contracts  ) 	and users.userid = '.$userid.' ORDER BY bestevaluatedbidder.dateadded DESC','limittext'=>'limit 10' ));
						#print_r($query); exit();
						if($this->session->userdata('isadmin') == 'N'){
							$result = paginate_list($this, $data, 'view_bebs',  array('SEARCHSTRING' => ' and 1 and 1 and bidinvitations.procurement_id  in ( select procurement_ref_id FROM contracts  )	and users.userid = '.$userid.' ORDER BY bestevaluatedbidder.dateadded DESC' ),10);
			   	        return $result;
						}
						else
						{
							$result = paginate_list($this, $data, 'view_bebs',  array('SEARCHSTRING' => ' and 1 and 1 and bidinvitations.procurement_id  in ( select procurement_ref_id FROM contracts  )	 ORDER BY bestevaluatedbidder.dateadded DESC' ),10);
			   	        return $result;
						}
						

					break;

#fetch active BEBs
			case 'active':
	 
						$userid = $this->session->userdata['userid'];
						$pde = mysql_query("select * from  users where userid =".$userid);
						$q = mysql_fetch_array($pde);
						#$query = $this->Query_reader->get_query_by_code('view_bebs',  array('SEARCHSTRING' => ' and 1 and 1    and bidinvitations.procurement_id not in ( select procurement_ref_id FROM contracts  ) 	and users.userid = '.$userid.' ORDER BY bestevaluatedbidder.dateadded DESC','limittext'=>10 ));
						#print_r($query); exit();

	
					   if($this->session->userdata('isadmin') == 'N'){
						$result = paginate_list($this, $data, 'view_bebs',  array('SEARCHSTRING' => ' and 1 and 1    and bidinvitations.procurement_id not in ( select procurement_ref_id FROM contracts  ) 	and users.userid = '.$userid.' ORDER BY bestevaluatedbidder.dateadded DESC' ),10);
			   	        return $result;
			   	        }
			   	        else
			   	        {
			   	        $result = paginate_list($this, $data, 'view_bebs',  array('SEARCHSTRING' => ' and 1 and 1    and bidinvitations.procurement_id not in ( select procurement_ref_id FROM contracts  ) 	  ORDER BY bestevaluatedbidder.dateadded DESC' ),10);
			   	        return $result;			   	        	
			   	        }

					break;	


				default:
						$userid = $this->session->userdata['userid'];
						$pde = mysql_query("select * from  users where userid =".$userid);
						$q = mysql_fetch_array($pde);

						  if($this->session->userdata('isadmin') == 'N'){
						$result = paginate_list($this, $data, 'view_bebs',  array('SEARCHSTRING' => ' and 1 and 1  and bidinvitations.procurement_id not in ( select procurement_ref_id FROM contracts  ) and 	users.userid = '.$userid.' ORDER BY bestevaluatedbidder.dateadded DESC' ),10);
			   	        return $result;
			   	       }
				   	    else
				   	    {
				   	    	$result = paginate_list($this, $data, 'view_bebs',  array('SEARCHSTRING' => ' and 1 and 1  and bidinvitations.procurement_id not in ( select procurement_ref_id FROM contracts  )  ORDER BY bestevaluatedbidder.dateadded DESC' ),10);
			   	        return $result;
				   	    }
				break;
			}
			

		break;

			default:
				# code...
				break;
		}
	}





}

?>