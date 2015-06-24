<?php

#*********************************************************************************
# All users have to first hit this class before proceeding to whatever section
# they are going to.
#
# It contains the login and other access control functions.
#*********************************************************************************

class Receipts extends CI_Controller {

	# Constructor
	function Receipts()
	{


		//**********  Back button will not work, after logout  **********//
			header("cache-Control: no-store, no-cache, must-revalidate");
			header("cache-Control: post-check=0, pre-check=0", false);
			// HTTP/1.0
			header("Pragma: no-cache");
			// Date in the past
			header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
			// always modified
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	  	//**********  Back button will not work, after logout  **********//


		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('users_m','user1');
		$this->load->model('sys_email','sysemail');
		$this->session->set_userdata('page_title','Login');


		#MOVER LOADED MODELS
		$this->load->model('Receipts_m');
		$this->load->model('Proc_m');
		$this->load->model('Evaluation_methods_m');
		$this->load->model('Remoteapi_m');


		##END
		date_default_timezone_set(SYS_TIMEZONE);
		$data = array();
		access_control($this);
	}


	#Default to login
	function index()
	{
		redirect('page/home');
	}

	#fetch pfoviders
	function fetchproviders()
	{

		// $query = mysql_query("select * from providers ");
		// $st = "";
		// while($q = mysql_fetch_array($query)){
		// 	$st .=$q['providernames']."<>";
		// }
		$data =   $this-> Remoteapi_m -> fetchproviders();

		//print_r($st);
	}


	function filterbids(){

		#access_control($this, array('admin'));
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		$data = add_msg_if_any($this, $data);
		$data = handle_redirected_msgs($this, $data);

		# fetch receipts Id ::
		$receiptid = $this->uri->segment(3);
		$bidid = $this->uri->segment(4);
		# load model ::
		$data['unsuccesful_bidders'] =   $this-> Receipts_m -> fetch_unsuccesful_bidders($receiptid,$bidid);
    #load data
		$this->load->view('receipts/unsuccesfulproviders_v', $data);

	}


	#manage Receipts
	function manage_receipts(){
  	//check_user_access($this, 'view_receipts', 'redirect');
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		# Pick all assigned data
		$data = assign_to_data($urldata);

		$data = add_msg_if_any($this, $data);
		$data = handle_redirected_msgs($this, $data);
		$isadmin= $this->session->userdata['isadmin'];
		$userid = $this->session->userdata['userid'];

		$data['receiptinfo'] =   $this-> Receipts_m -> pde_receipt_information($isadmin,$userid,$data);
		$data['page_title'] = 'Manage Receipts';
		$data['current_menu'] = 'view_bids_received';
		$data['view_to_load'] = 'receipts/manage_receipts_v';
		$data['view_data']['form_title'] = $data['page_title'];
    $data['search_url'] = 'receipts/search_receipts';
		$this->load->view('dashboard_v', $data);
	}


	#search  Receipts
	function  search_receipts(){

		$urldata = $this->uri->uri_to_assoc(3, array('m'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		$data = handle_redirected_msgs($this, $data);
		$isadmin= $this->session->userdata['isadmin'];
		$userid = $this->session->userdata['userid'];

		if($this->input->post('searchQuery'))
		{
			$_POST = clean_form_data($_POST);
			$_POST['searchQuery'] = $searchstring = trim($_POST['searchQuery']);
			$_POST['searchQuery'] .'%"';
			$data = $this-> Receipts_m ->search_receipts($isadmin,$userid, $data,$searchstring);

		}
		else
		{
			 $data = $this-> Receipts_m ->pde_receipt_information($isadmin,$userid,$data);

		}

		#print_r($data); exit();
		$data['area'] = 'receipts_list';
		$this->load->view('includes/add_ons', $data);

	}


	  #add new Receipt to a given Procurment
  	function add_receipt(){
	  # check_user_access($this, 'add_receipt', 'redirect');
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data
		$data = assign_to_data($urldata);
		$data = add_msg_if_any($this, $data);
		$data = handle_redirected_msgs($this, $data);

		# ADD  PAGE TITLE AND THE REST  ::
		$data['formtype'] = "insert";
		$data['active_procurements'] = $this-> Proc_m -> fetch_active_procurement_list2($idx=0);
		$data['page_title'] = 'Add  Bid Receipt';
		$data['current_menu'] = 'receive_bids';
		$data['view_to_load'] = 'receipts/add_receipt_v';
		$data['view_data']['form_title'] = $data['page_title'];


         $data['procurement_ref_no'] = $_POST['procurementrefno'];
         $qq = mysql_query("select a.* from bidinvitations  a inner join procurement_plan_entries b  ON a.procurement_id = b.id  where a.procurement_ref_no = '".$_POST['procurementrefno']."'  limit 1");
         $data['rowa'] = mysql_fetch_array($qq);	  

          $data['countrylist'] = $this-> Proc_m -> fetchcountries();
       

		//fetch receipts
		$isadmin= $this->session->userdata['isadmin'];
		$userid = $this->session->userdata['userid'];
		$data['receiptinfo'] =   $this-> Receipts_m -> procurement_receipt_information($isadmin,$userid,$data,$_POST['procurementrefno']);
        #exit("reached");
		//$data['receiptinfo_jv'] =   $this-> Receipts_m -> procurement_receipt_information_jv($isadmin,$userid,$data,$_POST['procurementrefno']);
        $data['lots'] = $this-> Receipts_m->fetchlots($_POST['procurementrefno']);
 		$data['recod'] = mysql_query("select * from currencies ") or die("".mysql_error()) ;
            
	    $data['ropproviders'] =   $this-> Remoteapi_m -> fetchproviders();
		 
		


 
              
             
		#print_r($data['lots']); exit();
    #get information regarding  LOTS or not based on the bid id


		$this->load->view($data['view_to_load'], $data);

	}

	#function to save receipits procurement 
	function save_bidreceipt(){


		$segment = $this->uri->segment(3);
		$post = $_POST;
		#print_r($post); exit();

		switch ($segment) {

		case 'update':
			 $id = $this->uri->segment(4);
			 $result = $this-> Receipts_m -> updatebidreceipt($post,$id);
			 print_r($result);
		break;

		case 'insert':
			  $result = $this-> Receipts_m -> savebidreceipt($post);
			  print_r($result);
		 break;

		default:
				# code...
		break;
		}



	}

	#function to handle disposal bid receipts
	function save_disposal_bidreceipt(){


		$segment = $this->uri->segment(3);
		$post = $_POST;
		#print_r($post); exit();

		switch ($segment) {

		case 'update':
			 $id = $this->uri->segment(4);
			 $result = $this-> Receipts_m -> updatebidreceipt($post,$id);
			 print_r($result);
		break;

		case 'insert':
			  $result = $this-> Receipts_m -> savedisposalbidreceipt($post);
			  print_r($result);
		 break;

		default:
				# code...
		break;
		}

	}
	function load_edit_receipt_form(){

//decryptValue
		//edit_receipts


		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		# Pick all assigned data
		$data = assign_to_data($urldata);

		$data = add_msg_if_any($this, $data);
		$data = handle_redirected_msgs($this, $data);


		$receiptid = decryptValue($this->uri->segment(3));
		$data['receiptinfo'] = mysql_fetch_array($this-> Receipts_m -> fetchreceiptid($receiptid));
		#print_r($result);
		$data['formtype'] = "edit";
		$data['active_procurements'] = $this-> Proc_m -> fetch_active_procurement_list2($idx=0);
		$data['page_title'] = 'Add  Bid Receipt';
		$data['current_menu'] = 'manage_bid_receipts';
		$data['view_to_load'] = 'receipts/add_receipt_v';
		$data['view_data']['form_title'] = $data['page_title'];
		$data['ropproviders'] =   $this-> Remoteapi_m -> fetchproviders();
    $data['countrylist'] = $this-> Proc_m -> fetchcountries();

		$this->load->view('dashboard_v', $data);


	}
	function delreceipts_ajax()
	{
	    #check_user_access($this, 'del_receipts', 'redirect');
	    $deltype =  $this->uri->segment(3);
	    $receiptid =  $this->uri->segment(4);
	    $result  = $this-> Receipts_m -> remove_restore_receipt($deltype,$receiptid);
	    echo  $result;
	}

 	#MANAGE BEST EVALUATED BIDDER NOTICES BACKEND
	function manage_bebs(){

		$urldata = $this->uri->uri_to_assoc(4, array('m', 'i'));
		$data = assign_to_data($urldata);
		$data = add_msg_if_any($this, $data);
		$data = handle_redirected_msgs($this, $data);
		$level =$status = $this->uri->segment(3);
		if(!empty($level))
		$data['level'] = $level;
		if(empty($data['level']))
		{
			$data['level'] ='active';
		}
		
		$data['manage_bes'] = $this-> Proc_m -> fetch_beb_list(0,$data);
		$data['page_title'] = 'Manage Best Evaluated Bidders';
		$data['current_menu'] = 'manage_bebs';
		$data['view_to_load'] = 'bids/manage_bebs';
		$data['view_data']['form_title'] = $data['page_title'];
		$this->load->view('dashboard_v', $data);

		}

		function ajax_beb_action()
		{
		#	print_r($_POST);
		$result = $this -> Receipts_m -> manage_beb_action($_POST);
	 	print_r($result);
		#	print_r('Reached');
		}

       #fetch 
		function populatelots(){

		 
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		$data = add_msg_if_any($this, $data);
		$data = handle_redirected_msgs($this, $data);

        $result = $this -> Receipts_m -> findlottedproviders($_POST);
		// # fetch receipts Id ::
		// $post = $_POST;
		// $lotid = $post['lotid'];
		// #$query = $this->db->query("SELECT * FROM ");
		print_r($result);

		 
	}
		function updatbeboptions()
	{
		#print_r($_POST);
		$review_level = mysql_real_escape_string($_POST['options']);
		$bebid = mysql_real_escape_string($_POST['bebid']);
		$query = $this->db->query("UPDATE bestevaluatedbidder SET review_level='".$review_level."'  where id = ".$bebid."");
		 $this->session->set_userdata('usave', 'You have successfully Updated a BEB Admin Review Level  to  '.$review_level ); 

		print_r("1");
	}
	#search provider if exists or not :: 
	function searchproviders()
	{
		
		$providernames = mysql_real_escape_string($_POST['providernames']);
        	$result =   $this-> Remoteapi_m -> checkifsuspended($providernames );
        	if(count($result) >0)
        	{
        	 print_r("0");
        $rand  = rand(23454,83938);
        	
        	 $this->session->set_userdata('level','ppda');
        	 $userid = $this->session->userdata('userid');
        	 $query1 = $this->db->query("SELECT CONCAT(firstname,',',lastname) AS names FROM  users WHERE userid=".$userid ." limit 1")-> result_array();
        	 	  $level = "Disposal";
  			          $entity =  $this->session->userdata('pdeid');
				  $query = $this->db->query("SELECT * FROM pdes WHERE pdeid=".$entity." limit 1")-> result_array();
				  $entityname = $query[0]['pdename'];
				  $titles = " Attemp to add bid response of a Suspended provider by ".$entityname." CODE [ PR ".$rand."] ";
				  $body =  " <h2> SUSPENDED PROVIDER</H2> ";
				  $body .="<table><tr><th> Organisation </th><td>".$result['orgname']." </td></tr>";
				  $body .="<tr><th> Reason </th><td>".$result['reason']." </td></tr>";
				  $body .="<tr><th> Date Suspended</th><td>".$result['datesuspended']." </td></tr>";
				  $body .="<tr><th> End of Suspension </th><td>";
				  if($result['indefinite'] =='Y')
				  {
				   $body .= "Indefinite </td></tr>";
				  }else
				  {
				   $body .=  $result['endsuspension']." </td></tr>";
				  }
				  $body .="<tr><th>Admininstrator </th><td>".$query1[0]['names']." </td></tr>";
				  $body .="<tr><th> Date </th><td>".Date('Y m-d')." </td></tr>";
				  $body .= "</table>";
				  $permission = "view_disposal_plans";
				  
				  $this->session->set_userdata('level','ppda');
				   print_r($result);
 				  push_permission_ppda($titles,$body,$level,$permission);
 				  
 				  
 				  
        	}
        	else
        	{
        	
        	print_r("1");
        	}
		#print_r($result);
		 
	}



}


/* End of file admin.php */
/* Location: ./system/application/controllers/admin.php */
?>