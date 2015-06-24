<?php
ob_start();
#*********************************************************************************
# All users have to first hit this class before proceeding to whatever section
# they are going to.
#
# It contains the login and other access control functions.
#*********************************************************************************

class Disposal extends CI_Controller {

	# Constructor
	function Disposal()
	{

		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('users_m','user1');
		$this->load->model('sys_email','sysemail');
		$this->session->set_userdata('page_title','Login');

		#MOVER LOADED MODELS
	#	$this->load->model('Currencies_m');
		$this->load->model('Proc_m');
		$this->load->model('Evaluation_methods_m');
		$this->load->model('Remoteapi_m');

			#MOVER LOADED MODELS
		$this->load->model('Currency_m','currency');
		$this->load->model('Disposal_m','disposal');
		$this->load->model('sys_file', 'sysfile');
$this->load->model('Proc_m');
	$this->load->model('Receipts_m');
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


	    function load_disposal_record_form(){

	    $urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		#print_r($data); exit();
		if(!empty($data['edit']))
		{
				$data['formtype'] ='edit';
				$diposal_id = base64_decode($data['edit']);
			    $pde =  $this->session->userdata('pdeid');
				$userid =  $this->session->userdata('userid');
				$searchstring = "1 and 1 and users.userid=".$userid."  and users.pde=".$pde."";

				if(!empty($data['disposalplan']))
				{
					$searchstring .= " and disposal_record.disposal_plan=".base64_decode($data['disposalplan']);
				}

				$searchstring .= " and disposal_plans.isactive='Y' and disposal_record.id=".$diposal_id." order by   disposal_record.dateadded DESC";
				$data['disposal_records'] = $this -> disposal -> fetch_disposal_records($data,$searchstring);
		}

		$data['currency'] = $this -> currency -> get_all();
		#print_r($data['currency']); exit();
		$pde =  $this->session->userdata('pdeid');
		$userid =  $this->session->userdata('userid');
		$searchstring = "1 and 1  and  b.userid=".$userid." and a.isactive='Y'  and b.pde=".$pde."  ";
		/* Get the Serial Number :: */
		$data['serialnumber'] = $this ->disposal -> getserialnumber($pde);
		$data['disposal_plans'] = $this -> disposal -> fetchdisposal_plans($data,$searchstring);
	    $searchstring1 = '';
		$limittext = 10;
		$data['disposal_methods'] = $this -> disposal -> fetch_disposal_methods($data,$searchstring1,$limittext);

		$data['page_title'] = 'Add Disposal Record';
		$data['current_menu'] = 'disposal_notice';
		$data['view_to_load'] = 'disposal/disposal_form_v';
		$data['view_data']['form_title'] = $data['page_title'];
		$this->load->view('dashboard_v', $data);

		}
		function view_disposal_records(){
	    $urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		#print_r($data); exit();
		 #Get the paginated list of the news items
        $data = add_msg_if_any($this, $data);

        $pde =  $this->session->userdata('pdeid');
		$userid =  $this->session->userdata('userid');
		$isadmin = $this->session->userdata('isadmin');
		if($isadmin == 'Y')
		{
			$searchstring = "1 and 1 ";
		}
		else
		{
		$searchstring = "1 and 1 and users.userid=".$userid."  and users.pde=".$pde."";
		}
		
		if(!empty($data['disposalplan']))
		{
			$searchstring .= " and disposal_record.disposal_plan=".base64_decode($data['disposalplan']);
		}
		$searchstring .= " and disposal_plans.isactive='Y' and disposal_record.isactive='Y' order by   disposal_record.dateadded DESC";
		$data['disposal_records'] = $this -> disposal -> fetch_disposal_records($data,$searchstring);



		$data['page_title'] = 'View Disposal Records';
		$data['current_menu'] = 'view_disposal_notices';
		$data['view_to_load'] = 'disposal/view_disposals_v';
		$data['view_data']['form_title'] = $data['page_title'];
        $data['search_url'] = 'disposal/search_disposal';
		$this->load->view('dashboard_v', $data);
		}

		function search_disposal()
		{
			  $urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		$searchstring = "1 and 1 order by   disposal_record.dateadded DESC";
		if($this->input->post('searchQuery'))
		{
			$_POST = clean_form_data($_POST);
			$_POST['searchQuery'] = $searchstring = trim($_POST['searchQuery']);
			$_POST['searchQuery'] .'%"';
			$data = $this-> disposal ->search_disposal_records($data,$searchstring);

		}
		else
		{
				$data['disposal_records'] = $this -> disposal -> fetch_disposal_records($data,$searchstring);
		}


		$data['page_title'] = 'View Disposal Records';
		$data['current_menu'] = 'view_disposal_plan';
		$data['view_to_load'] = 'disposal/view_disposals_v';
		$data['view_data']['form_title'] = $data['page_title'];
        $data['search_url'] = 'disposal/search_disposal';
		$data['area'] = 'disposal_list';
		$this->load->view('includes/add_ons', $data);

		}
	 function save_disposal_record(){

		     $urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		#print_r($data); exit();
		 #Get the paginated list of the news items
        $data = add_msg_if_any($this, $data);
        #print_r($data); exit();
        if(!empty($data['update']))
        {
        	$_POST['disposalrecordid'] = mysql_real_escape_string($data['update']);
        	#print_r($_POST); exit();
        	$saved_disposal = $this -> disposal -> update_disposal($_POST);
		 	print_r($saved_disposal);

        }else
        {
		 $saved_disposal = $this -> disposal -> insert_disposal($_POST);
		 print_r($saved_disposal);
		}


		 }
	 function archive_delete_restore_disposal_record(){}
	 function loead_edit_disposal_form(){}

	 /*
	 load bid inviation on  disposal
	 */
	 function load_bid_invitation_form(){

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
	//	print_r($data);
		if(!empty($data['edit']))
		{
			$bidid = base64_decode($data['edit']);
			//fetch_disposal_bid_invitations
			$searchstring = "  1 AND 1   and  disposal_bid_invitation.id=".$bidid." ";
			$data['bid_inviation'] = $this -> disposal -> fetch_disposal_bid_invitations($data,$searchstring);
			$data['formtype'] = 'edit';

		}
		//exit();
		$pde =  $this->session->userdata('pdeid');
		$userid =  $this->session->userdata('userid');
		$searchstring = "  1 AND 1   and  users.userid=".$userid."  and users.pde=".$pde." ";
		$searchstring .="order by   disposal_record.dateadded DESC";
		$data['disposal_records'] = $this -> disposal -> fetch_active_disposal_records($data,$searchstring);


		$data['page_title'] = 'Add Bid Invitation ';
		$data['current_menu'] = 'disposal_invitation_for_bids';
		$data['view_to_load'] = 'disposal/bid_invitation_v';
		$data['view_data']['form_title'] = $data['page_title'];
		$this->load->view('dashboard_v', $data);
		}
	 function save_bid_invitation(){


		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		 if(!empty($data['update']))
		 {
		 	$_POST['update'] = $data['update'];
		 	#		print_r($_POST); exit();

		 }

		 	$saved_bid_invitation = $this -> disposal -> insert_bid_invitation($_POST);
		    print_r($saved_bid_invitation);



		 }
	 function delete_archive_restore_bid_invitation(){}

	 function check(){
		 $valueposted = $_POST;
		 $status = $this -> disposal -> check_disposal_record($valueposted);
		 print_r($status);
	 }
	 function  view_bid_invitations(){
		 $urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		# Pick all assigned data

		$data = assign_to_data($urldata);
		 $data = add_msg_if_any($this, $data);
		$pde =  $this->session->userdata('pdeid');
		$userid =  $this->session->userdata('userid');
		$searchstring = "1 and 1  and  users.userid=".$userid."  and users.pde=".$pde."";
		$data['disposal_bid_invitaion'] = $this -> disposal -> fetch_disposal_bid_invitations($data,$searchstring);

		$data['page_title'] = 'View Bid Invitations ';
		$data['current_menu'] = 'view_disposal_bid_invitations';
		$data['view_to_load'] = 'disposal/view_bid_invitations_v';
		$data['view_data']['form_title'] = $data['page_title'];
		$data['search_url'] = 'disposal/search_bid_invitation';
		$this->load->view('dashboard_v', $data);
	    }

	 	function search_bid_invitation()
		{
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		$pde =  $this->session->userdata('pdeid');
		$userid =  $this->session->userdata('userid');
		$searchstring = "1 and 1  and  users.userid=".$userid."  and users.pde=".$pde." order by   disposal_bid_invitation.dateadded DESC";
			if($this->input->post('searchQuery'))
			{
				$_POST = clean_form_data($_POST);
				$_POST['searchQuery'] = $searchstring = trim($_POST['searchQuery']);
				$_POST['searchQuery'] .'%"';
				$data = $this-> disposal ->search_disposal_bid_invitations($data,$searchstring);

			}
			else
			{
				$data = $this -> disposal -> fetch_disposal_bid_invitations($data,$searchstring);
			}
		$data['page_title'] = 'View Disposal Records';
		$data['current_menu'] = 'view_disposal_plan';
		$data['view_to_load'] = 'disposal/view_disposals_v';
		$data['view_data']['form_title'] = $data['page_title'];
        $data['search_url'] = 'disposal/search_bid_invitation';
		$data['area'] = 'bid_invitation_list';
		$this->load->view('includes/add_ons', $data);

		}
		function add_bid_response(){

	    $urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		$pde =  $this->session->userdata('pdeid');
		$userid =  $this->session->userdata('userid');
		$searchstring = "1 and 1 and disposal_bid_invitation.id not in(SELECT bid_id FROM disposal_receipts WHERE disposal_receipts.beb='Y'  )  and users.pde = '".$pde."' ";

		#$data['disposal_records'] = $this -> disposal -> fetch_disposal_records($data,$searchstring);
		$data['disposal_invitations'] = $this -> disposal -> fetch_disposal_bid_invitations($data,$searchstring);
		$data['countrylist'] = $this-> Proc_m -> fetchcountries();
		#$data['ropproviders'] =   $this-> Remoteapi_m -> fetchproviders();
		$data['page_title'] = 'Add Bid Response ';
		$data['current_menu'] = 'bid_response';
		$data['view_to_load'] = 'disposal/bid_response_v';
		$data['view_data']['form_title'] = $data['page_title'];
		$this->load->view('dashboard_v', $data);

		}

		#function to save receipits
	function save_bid_response(){

		$segment = $this->uri->segment(3);
		$post = $_POST;

		switch ($segment) {
			case 'update':
				# code...
			 $id = $this->uri->segment(4);
			 $result = $this-> disposal -> updatebidresponse($post,$id);
			 print_r($result);
				break;
			 case 'insert':
			  $result = $this-> disposal -> savebidresponse($post);
			  print_r($result);

				break;

			default:
				# code...

				break;
		}




	}

	 function view_bid_responses()
	{
		 $urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		$pde =  $this->session->userdata('pdeid');
		$userid =  $this->session->userdata('userid');
		$searchstring = "1 and 1  and  users.userid=".$userid."  and users.pde=".$pde." order by   bid_response.dateadded DESC";
		$data['disposal_bid_invitaion'] = $this -> disposal -> fetch_disposal_reference($data,$searchstring);

		$data['page_title'] = 'View Bid Responses ';
		$data['current_menu'] = 'view_bid_responses';
		$data['view_to_load'] = 'disposal/view_bid_responses_v';
		$data['view_data']['form_title'] = $data['page_title'];
		$data['search_url'] = 'disposal/search_bid_invitation';
		$this->load->view('dashboard_v', $data);

	}


  function new_disposal_plan()
  {
  	 $urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
 	 $pde =  $this->session->userdata('pdeid');
     $data = assign_to_data($urldata);
 	 #print_r($data); exit();
     $data['formtype'] = '';
 	 if(!empty($data['edit']))
 	 {

 	 $data['disposalplan'] = $this-> db -> query("select * from disposal_plans where id = ".base64_decode($data['edit']))-> result_array();
 	 #print_r($query); exit();
     $data['page_title'] = 'Edit  Disposal Plan';
     $data['formtype'] ='edit';
     #print_r($data['formtype']); exit();
 	 }
 	 else
 	 {
 	 	 $data['page_title'] = 'New  Disposal Plan';
 	 	  $data['formtype'] ='insert';
 	 }

    #print_r( $data['formtype']); exit();
	 $userid =  $this->session->userdata('userid');

     $data['current_menu'] = 'create_disposal_plan';
     $data['view_to_load'] = 'disposal/new_disposal_plan_v';
     $data['view_data']['form_title'] = $data['page_title'];

     $this->load->view('dashboard_v', $data);

  }
 function save_disposal_plan()
 {
		$segment = $this->uri->segment(3);
		$post = $_POST;


		switch ($segment) {
			case 'update':
				# code...
			 $id = $this->uri->segment(4);


			 $result = $this-> disposal -> update_disposal_plan($post,$id);
			redirect('disposal/view_disposal_plan/m/usave');
			#print_r($result);
			break;
			case 'insert':
			 	#SETTING UP SOME ISSUES

				#first save disposal plan and get the insert id
				$insertid  = $this-> disposal -> save_disposal_plan($post);

				#Upload allowed xsl
				$this->session->set_userdata('local_allowed_extensions', array('.xls', '.xlsx'));
    			$extramsg = "";
    			$MAX_FILE_SIZE = 1000000;
    			$MAX_FILE_ROWS = 1000;

						#detailed plan as well
						if (!empty($_FILES['detailed_plan']['name']))
						{
                            $new_plan_name = 'disposalplan' . 'Upload_' . strtotime('now') . generate_random_letter();

                            $_POST['disposalplan'] = (!empty($_FILES['detailed_plan']['name'])) ? $this->sysfile->local_file_upload($_FILES['detailed_plan'], $new_plan_name, 'documents', 'filename') : '';
                        }


	                    if (!empty($_POST['disposalplan']))
	                     {

                         $file_url = UPLOAD_DIRECTORY . "documents/" . $_POST['disposalplan'];
                      #   exit($file_url);
                         $file_size = filesize($file_url);

                         #Break up file if it is bigger than allowed
                         if ($file_size > $MAX_FILE_SIZE) {
                                $data['file_siblings'] = $this->sysfile->break_up_file($file_url, $MAX_FILE_ROWS);
                                $this->session->set_userdata('file_siblings', $data['file_siblings']);
                                $msg = "WARNING: The uploaded file exceeded single processing requirements and was <br>broken up into " . count($data['file_siblings']) . " files. <br><br>Please click on each file, one at a time, to update the procurement plan and <br><a href='" . base_url() . "grades/manage_grades' class='bluelink' style='font-size:17px;'>click here</a> to refresh.";
                                print_r($msg);

                                } #Move the file data
                        else
                                {

                                    $result_array = read_excel_data($file_url);

                                    #print_r($result_array); exit();
                                    #Remove file after upload
                                    @unlink($file_url);
                                    if(count($result_array)) {

                                    	#1. format insert string
                                        #2. sheet 1 is supplies
                                        if (!empty($result_array['Disposal']) && count($result_array['Disposal']) > 1) {
                                            #$project_plan = $this->procurement_plan_entry_m->create_bulk($plan_data);
                                            $sheet_info = $result_array['Disposal'];
                                            $x = 0;
                                             #exit("movest 11");
                                            foreach ($sheet_info as $key => $value) {
                                            	$x ++;
                                            	if($x <= 5) continue;
                                            	$disposal_serial_number ='';
                                            	$subject_of_disposal ='';
                                            	$method_of_disposal='';
                                            	$asset_location = '';
                                            	$amount ='';
                                            	$currency = '';
                                            	$strategic_asset = '';
                                            	$date_of_approval ='';
                                            	$date_of_aoapproval = '';


                                            	// information
                                            	$disposal_serial_number  = $value['C'];
                                            	if($disposal_serial_number == '')
											continue;

                                            	$subject_of_disposal = $value['B'];
                                            	$method_of_disposal =   $value['F'];
                                            	$asset_location =  $value['G'];
                                            	$amount = $value['D'];
                                            	$currency = $value['E'];
                                            	$strategic_asset = $value['H'];
                                            	$date_of_approval =  $value['I'];
                                            	$date_of_aoapproval = $value['J'];




$_POST['disposal_plan'] = $insertid;
$_POST['disposal_serial_number'] = $disposal_serial_number;
$_POST['subject_of_disposal'] = $subject_of_disposal;

#print_r($method_of_disposal);
$record = $this->db->query(" SELECT * FROM `disposal_method` WHERE `method` LIKE '%".$method_of_disposal."%' limit 1 ")->result_array();

$method_ofdisposal = (!empty($record[0]))  ? $record[0]['id']  : 0;
$q = "select * from  disposal_method where method like '% ".$method_of_disposal." %' limit 1 ";


print_r($method_ofdisposal);
$_POST['method_of_disposal'] = $method_ofdisposal;
$_POST['asset_location'] = $asset_location;
$_POST['amount'] = $amount;
$_POST['currency'] = $currency;
$_POST['strategic_asset'] = $strategic_asset;
$_POST['date_of_approval'] = $date_of_approval;
$_POST['date_of_aoapproval'] = $date_of_aoapproval;




//call the model and send data to the model ::
 $result  = $this-> disposal -> insert_disposal($_POST);


	 }

      								  }
                                    }
                                }
                            }



 if($insertid > 0){
redirect('disposal/view_disposal_plan/m/usave');
}


				break;

			default:
				# code...

				break;
		}

 }
 function view_disposal_plan()
 {
 	     $urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

        # Pick all assigned data
        $data = assign_to_data($urldata);

        #Get the paginated list of the news items
        $data = add_msg_if_any($this, $data);
		#print_r($data);  exit();
		# Pick all assigned data

		$pde =  $this->session->userdata('pdeid');
		$userid =  $this->session->userdata('userid');
		$isadmin = $this->session->userdata('isadmin');
		if($isadmin == 'Y')
		$searchstring = "1 and 1     and a.isactive='Y' order by a.dateadded DESC ";

		else
		$searchstring = "1 and 1  and  b.userid=".$userid."  and b.pde=".$pde."  and a.isactive='Y' order by a.dateadded DESC ";





		$data['disposal_plans'] = $this -> disposal -> fetch_disposal_plans($data,$searchstring);
		//	print_r($searchstring); exit();
		$data['page_title'] = 'View Disposal Plans ';
		$data['current_menu'] = 'view_disposal_plans';
		$data['view_to_load'] = 'disposal/view_disposal_plans_v';
		$data['view_data']['form_title'] = $data['page_title'];
		$data['search_url'] = 'disposal/search_bid_invitation';
		$this->load->view('dashboard_v', $data);
 }

function ajax_fetch_disposal_details(){


   $urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

        # Pick all assigned data
        $data = assign_to_data($urldata);

        #Get the paginated list of the news items
        $data = add_msg_if_any($this, $data);
		#print_r($data);  exit();
		# Pick all assigned data
		$pde =  $this->session->userdata('pdeid');
		$userid =  $this->session->userdata('userid');

	 	#$quyery = $this->db->query("select * from ");
	    $searchstring = " and disposal_bid_invitation.id=".mysql_real_escape_string($_POST['disposalbid_id'])."  and  users.userid=".$userid."  and users.pde=".$pde."  ";
		$data['disposal_plans_details'] = $this -> disposal -> fetch_disposal_details($data,$searchstring,1);

	    #echo "reached";
		$data['datearea'] = 'disposaldetails';
		$this->load->view('disposal/disposal_addons', $data);
		#print_r($_POST);

}

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
		$data['page_title'] = 'Add  Bid Receipt';
		$data['current_menu'] = 'receive_bids';
		$data['view_to_load'] = 'disposal/add_disposal_receipt_v';
		$data['view_data']['form_title'] = $data['page_title'];

	    # $data['ropproviders'] =   $this-> Remoteapi_m -> fetchproviders();
		//fatch countires ;;
	   $data['countrylist'] = $this-> Proc_m -> fetchcountries();
       $data['disposalbid_id'] = $_POST['disposalbid_id'];

		//fetch receipts
		$isadmin= $this->session->userdata['isadmin'];
		$userid = $this->session->userdata['userid'];

		$data['receiptinfo'] =   $this-> Receipts_m -> fetch_disposal_receipts( $_POST['disposalbid_id']);

		$pde    =  $this->session->userdata('pdeid');
		$userid =  $this->session->userdata('userid');

	 	#$quyery = $this->db->query("select * from ");
	    $searchstring = " and disposal_bid_invitation.id=".mysql_real_escape_string($_POST['disposalbid_id'])."  and  users.userid=".$userid."  and users.pde=".$pde."  ";
		$data['disposal_plans_details'] = $this -> db -> query("SELECT b.* FROM disposal_bid_invitation a INNER JOIN disposal_record b ON a.disposal_record = b.id  WHERE a.id =".$_POST['disposalbid_id'])->result_array();

		$this->load->view($data['view_to_load'], $data);

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
		#print_r($bidid); exit();
		# load model ::
		$data['unsuccesful_bidders'] =   $this-> Receipts_m -> fetch_disposal_unsuccessful_bidders($receiptid,$bidid);
       #load data
		$this->load->view('disposal/unsuccessfulproviders_v', $data);

	}

	#function to save receipits
	function savebeb(){
		//call model
		#print_r('bidere');
		$post = $_POST;
		$beb = $post['bebname'];
		$btnstatus = $post['btnstatus'];

		#check to see if the beb exists
			if($beb <= 0)
			{
				print_r("3:Select Best Evaluated Bidder");
				exit();
			}

			#check if to view or to save ::
			switch($btnstatus)
			{
				case 'view':
			#	$result = $this-> Receipts_m -> publishbeb($post);
				print_r("3:View Mode Not Yet Implemented ");
				break;
				default:
				$result = $this-> Receipts_m -> disposalpublishbeb($post);
				print_r($result);
				break;

			}




	}

		#MANAGE BEST EVALUATED BIDDER NOTICES BACKEND
	function manage_bebs(){

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		$data = assign_to_data($urldata);
		$data = add_msg_if_any($this, $data);
		$data = handle_redirected_msgs($this, $data);
		$data['manage_bes'] = $this-> disposal -> fetch_beb_list(0,$data);
		$data['page_title'] = 'Manage  Bidders';
		$data['current_menu'] = 'view_bid_responses';
		$data['view_to_load'] = 'disposal/manage_bebs';
		$data['view_data']['form_title'] = $data['page_title'];
		$this->load->view('dashboard_v', $data);

		}

		#check disposal financial years
		function checkfinancialyears()
		{


			//edit
			#$bidid = $this->uri->segment(4);
				$result = $this-> disposal -> checkfinancialyears($_POST);
			print_r($result);


		}

		#signing of a contract  ::
		function signcontract(){

		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		$data = assign_to_data($urldata);
		$data = add_msg_if_any($this, $data);

		$pde =  $this->session->userdata('pdeid');
		$userid =  $this->session->userdata('userid');
		$searchstring = " and  1 AND 1   and  users.userid=".$userid." and disposal_record.isactive='Y' and disposal_plans.isactive='Y' AND disposal_record.id NOT IN (SELECT disposalrecord FROM disposal_contract WHERE disposal_contract.isactive='Y')   and users.pde=".$pde." order by   disposal_record.dateadded DESC";

		$data['disposal_records'] = $this -> disposal -> fetchdisposalrecords_contract($data,$searchstring);

		$data['currency'] = $this -> currency -> get_all();
		$data['page_title'] = 'Sign Disposal  Contract  ';
		$data['current_menu'] = 'bid_activity';
		$data['view_to_load'] = 'disposal/signcontract_v';
		$data['view_data']['form_title'] = $data['page_title'];
		$this->load->view('dashboard_v', $data);



		}

	   #PERFORM DELETE FUNCTIONALITY ON PDES & RESTORE ON DISPOSAL PLANS
	   function delp_ajax()
	   {
	    $deltype =  $this->uri->segment(3);
	    $pdeid =  $this->uri->segment(4);
		#	print_r($deltype); exit();
	    $result  = $this-> disposal -> remove_restore_disposalplan($deltype,$pdeid);
	    echo  $result;
	   }
	   #DELETE DISPOSAL RECORD AJAXCLY
	    function deldisposalrecord_ajax()
	   {
	    $deltype =  $this->uri->segment(3);
	    $pdeid =  $this->uri->segment(4);
	    $result  = $this-> disposal -> remove_restore_disposalplan_record($deltype,$pdeid);
	    echo  $result;
	   }




	     function fetchdisposal_buyerinfo(){
	   	$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		$data = assign_to_data($urldata);

		//$data = add_msg_if_any($this, $data);
		#print_r($_POST); exit();
		$record = mysql_real_escape_string($_POST['disposalrecord']);
		$st = "SELECT z.* FROM disposal_record a INNER JOIN disposal_method b ON a.method_of_disposal = b.id   INNER JOIN  disposal_bid_invitation c ON a.id = c.disposal_record INNER JOIN  disposal_receipts z ON c.id = z.bid_id INNER JOIN bestevaluatedbidder_disposal d ON d.pid = z.receiptid  where b.status='Y' and a.id=".$record." ";
		#print_r($st); exit();
		$query = $this->db->query($st)->result_array();
			if(!empty($query))
		{
           # print_r($query);
			$qs= '';
           	$providers = $query[0]['providerid'];
	            $qs =  $this->db->query("SELECT * FROM  providers where  providerid = ".$providers." ")->result_array();


            	$providerids = '';

          		# print_r($qs);
               //$this->session->set_userdata('receiptid',$query[0]['receiptid']);
                echo  "8:<ul>";
            	foreach ($qs as $value) {
            		echo "<li>".$value['providernames']."</li>";
            		$providerids .=$value['providerid'].',';
            		echo "<input type='hidden' id='beneficiary' value='".$value['providerid']."'/>";
            		$this->session->set_userdata('disposalproviders',$value['providerid']);

            		}
            	echo "</ul> ";

            	exit();
		}
		else
		{
			$query = $this->db->query("SELECT a.* FROM disposal_record a  INNER JOIN  disposal_method b ON a.method_of_disposal = b.id  where b.status='N' and a.id=".$record."   ")->result_array();
			$this->session-> unset_userdata('disposalproviders');

		}
		 if(!empty($query))
		 {
		 	print_r("7:s");
		 	/*
		 	foreach ($query as $key => $record) {
		 		# code...
		 		print_r($record);
		 	}
		 	*/
		 }
		 else
		 {
		 	echo "4:No Records Found, Publish LBA ";
		 }


	   }


	  function save_contract()
	   {
	   	#print_r($_POST);
	   	$disposalitem = mysql_real_escape_string($_POST['disposalitem']);
	   	$beneficiary = mysql_real_escape_string($_POST['beneficiary']);
	   	$xct = $this->session->userdata('disposalproviders');
	   	#print_r($xct); exit();
	   	if(($xct)>0)
	   	{
                 $beneficiary  = $this->session->userdata('disposalproviders');
                 $this->session-> unset_userdata('disposalproviders');
	   	}
	   	else
	   	{
	   		$rest = mysql_query("SELECT * FROM providers WHERE providernames like '".$beneficiary."' limit 1 ");
	   		if(mysql_num_rows($rest) > 0)
	   		{
			$row = mysql_fetch_array($rest);
			$beneficiary = $row['providerid'];
	   		}
	   		else
	   		{
	   		 $st_query = mysql_query("INSERT INTO  providers(providernames) where  VALUES('".$beneficiary."')");
	   		 $beneficiary = mysql_insert_id();
	   		 }
	   	}

	   	$contractamount = mysql_real_escape_string($_POST['contractamount']);
	   	$currency = mysql_real_escape_string($_POST['currency']);
	   	$datesigned = date('Y-m-d',strtotime($_POST['datesigned']));
	 $st = "INSERT INTO disposal_contract(disposalrecord,beneficiary,contractamount,currency,datesigned,isactive) values('".$disposalitem."','".$beneficiary."','".$contractamount."','".$currency."','".$datesigned."','Y') ";
	 #print_r($st);exit();
	     	$query = $this->db->query($st);
	    print_r("1");
	   }

	     function manage_contracts(){

	       $urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		$data = assign_to_data($urldata);
		$data = add_msg_if_any($this, $data);
		$data = handle_redirected_msgs($this, $data);
		$data['manage_bes'] = $this-> disposal -> manage_disposal_contracts(0,$data);
		#print_r($data['manage_bes']);
		$data['page_title'] = 'Manage Disposal Contracts ';
		$data['current_menu'] = 'view_bid_responses';
		$data['view_to_load'] = 'disposal/manage_contracts';
		$data['view_data']['form_title'] = $data['page_title'];
		$this->load->view('dashboard_v', $data);

	   }





}

?>