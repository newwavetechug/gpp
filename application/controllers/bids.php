<?php
ob_start();
#**************************************************************************************
# All bid actions directed from this controller
#**************************************************************************************

class Bids extends CI_Controller {

	# Constructor
	function Bids()
	{
		parent::__construct();

		$this->load->model('users_m','users');
		$this->load->model('sys_email','sysemail');
		#date_default_timezone_set(SYS_TIMEZONE);

		#MOVER LOADED MODELS
		$this->load->model('Receipts_m');
		$this->load->model('Proc_m');
		$this->load->model('Evaluation_methods_m');
		$this->load->model('sys_file','sysfile');
		$this->load->model('Disposal_m','disposal');

		access_control($this);
	}



	# Default to view all bids
	function index()
	{
		#Go view all bids
		redirect('bids/manage_bid_invitations');
	}


	# View bids
	# View bids
	function manage_bid_invitations()
	{
		check_user_access($this, 'view_bid_invitations', 'redirect');

		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(2, array('m', 'p'));
		$urldata2 = $this->uri->uri_to_assoc(3, array('m', 'p'));

		# Pick all assigned data
		$data = assign_to_data($urldata);

		if(!empty($urldata2['notifyrop']))
		{
			$data['notifyrop'] = $urldata2['notifyrop'];
		}


		$data = add_msg_if_any($this, $data);
		#print_r($data); exit();

		$data = handle_redirected_msgs($this, $data);

		$search_str = '';
		$level =$status = $this->uri->segment(3);
		#print_r($level); exit();
		$data['level'] = $level;
		/*
		*/
		$jo = array();
		if($this->session->userdata('isadmin') == 'N')
			{
				$userdata = $this->db->get_where('users', array('userid'=>$this->session->userdata('userid')))->result_array();
				$search_str = ' AND procurement_plans.pde_id="'. $userdata[0]['pde'] .'"';
			}
		#activecount
		$query_active = $this->Query_reader->get_query_by_code('numbids', array('orderby'=>'bid_dateadded DESC', 'limittext'=>' limit 1','searchstring'=>'bidinvitations.isactive = "Y"  AND bidinvitations.id not in (SELECT bid_id FROM receipts INNER JOIN bidinvitations ON receipts.bid_id =  bidinvitations.id  INNER JOIN bestevaluatedbidder  ON receipts.receiptid = bestevaluatedbidder.pid  WHERE receipts.beb="Y" ) '.$search_str ));
$data['activecount'] = $this->db->query($query_active)->result_array();
		#archivecount
        $query_inactive = $this->Query_reader->get_query_by_code( 'numbids', array('orderby'=>'bid_dateadded DESC', 'limittext'=>' limit 1',  'searchstring'=>'bidinvitations.isactive = "Y"  AND bidinvitations.id  in (SELECT bid_id FROM receipts INNER JOIN bidinvitations ON receipts.bid_id =  bidinvitations.id  INNER JOIN bestevaluatedbidder   ON receipts.receiptid = bestevaluatedbidder.pid  WHERE receipts.beb="Y" ) '.$search_str ));
 $data['archivecount'] = $this->db->query($query_inactive)->result_array();



		switch ($level) {
			case 'active':
				# code...

				if($this->session->userdata('isadmin') == 'N')
				{
						$userdata = $this->db->get_where('users', array('userid'=>$this->session->userdata('userid')))->result_array();
						$search_str = ' AND procurement_plans.pde_id="'. $userdata[0]['pde'] .'"';
				}

				# $query = $this->Query_reader->get_query_by_code('bid_invitation_details', array('orderby'=>'bid_dateadded DESC', 'searchstring'=>'bidinvitations.isactive = "Y"  AND bidinvitations.id not in (SELECT bid_id FROM receipts INNER JOIN bidinvitations ON receipts.bid_id =  bidinvitations.id  INNER JOIN bestevaluatedbidder
   			# ON receipts.receiptid = bestevaluatedbidder.pid  WHERE receipts.beb="Y" ) '. $search_str,'limittext'=>''))
				#	->result_array();

				# print_r($query); exit();

				# Get the paginated list of bid invitations

				$data['page_list'] = paginate_list($this, $data, 'bid_invitation_details', array('orderby'=>'bid_dateadded DESC', 'searchstring'=>'bidinvitations.isactive = "Y"  AND bidinvitations.id not in (SELECT bid_id FROM receipts INNER JOIN bidinvitations ON receipts.bid_id =  bidinvitations.id  INNER JOIN bestevaluatedbidder
    ON receipts.receiptid = bestevaluatedbidder.pid  WHERE receipts.beb="Y" ) '. $search_str),10);

				break;
			case 'archive':


				 if($this->session->userdata('isadmin') == 'N')
					{
						$userdata = $this->db->get_where('users', array('userid'=>$this->session->userdata('userid')))->result_array();
						$search_str = ' AND procurement_plans.pde_id="'. $userdata[0]['pde'] .'"';
					}

	#$query = $this->Query_reader->get_query_by_code('bid_invitation_details', array('orderby'=>'bid_dateadded DESC', 'searchstring'=>'bidinvitations.isactive = "Y"  AND bidinvitations.id not in (SELECT bid_id FROM receipts INNER JOIN bidinvitations ON receipts.bid_id =  bidinvitations.id  INNER JOIN bestevaluatedbidder
    #ON receipts.receiptid = bestevaluatedbidder.pid  WHERE receipts.beb="Y" ) '. $search_str,'limittext'=>''));
				#	->result_array();

				#print_r($query); exit();

					#Get the paginated list of bid invitations
					   $data['page_list'] = paginate_list($this, $data, 'bid_invitation_details', array('orderby'=>'bid_dateadded DESC', 'searchstring'=>'bidinvitations.isactive = "Y"  AND bidinvitations.id   in (SELECT bid_id FROM receipts INNER JOIN bidinvitations ON receipts.bid_id =  bidinvitations.id  INNER JOIN bestevaluatedbidder
    ON receipts.receiptid = bestevaluatedbidder.pid  WHERE receipts.beb="Y" ) '. $search_str),10);



				break;

			default:
				$data['level'] = 'active';
				# code...
					if($this->session->userdata('isadmin') == 'N')
					{
						$userdata = $this->db->get_where('users', array('userid'=>$this->session->userdata('userid')))->result_array();
						$search_str = ' AND procurement_plans.pde_id="'. $userdata[0]['pde'] .'"';
					}

					#Get the paginated list of bid invitations
				  $data['page_list'] = paginate_list($this, $data, 'bid_invitation_details', array('orderby'=>'bid_dateadded DESC', 'searchstring'=>'bidinvitations.isactive = "Y"  AND bidinvitations.id not in (SELECT bid_id FROM receipts INNER JOIN bidinvitations ON receipts.bid_id =  bidinvitations.id  INNER JOIN bestevaluatedbidder
    ON receipts.receiptid = bestevaluatedbidder.pid  WHERE receipts.beb="Y" ) '. $search_str),10);

							#exit($this->db->last_query());

				break;
		}

			$data['page_title'] = 'Manage Bid Invitations';
		$data['current_menu'] = 'view_bid_invitations';
		$data['view_to_load'] = 'bids/manage_bid_invitations';
		$data['view_data']['form_title'] = $data['page_title'];
		$data['search_url'] = 'bids/search_bid_invitations';

		$this->load->view('dashboard_v', $data);

	}



	# View addenda
	function view_addenda()
	{
		check_user_access($this, 'view_bid_invitations', 'redirect');

		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'p'));

		# Pick all assigned data
		$data = assign_to_data($urldata);

		$data = add_msg_if_any($this, $data);

		$data = handle_redirected_msgs($this, $data);

		$search_str = '';

		if($this->session->userdata('isadmin') == 'N')
		{
			$userdata = $this->db->get_where('users', array('userid'=>$this->session->userdata('userid')))->result_array();
			$search_str = ' AND PP.pde_id="'. $userdata[0]['pde'] .'"';
		}

		if(!empty($data['b']))
		{
			$search_str .= ' AND A.bidid = "'. decryptValue($data['b']) .'" ';
		}

		#Get the paginated list of bid invitations
		$data = paginate_list($this, $data, 'search_addenda', array('orderby'=>'A.dateadded DESC', 'searchstring'=> $search_str));

		$data['page_title'] = 'Manage addenda';
		$data['current_menu'] = 'view_bid_invitations';
		$data['view_to_load'] = 'bids/view_addenda';
		$data['view_data']['form_title'] = $data['page_title'];
		$data['search_url'] = 'bids/search_addenda';

		$this->load->view('dashboard_v', $data);

	}



	#Function to load IFB addenda form
	function load_ifb_addenda_form()
	{
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'b'));

		# Pick all assigned data
		$data = assign_to_data($urldata);

		#check user access
		#1: for editing
		if(!empty($data['i']))
		{
			check_user_access($this, 'edit_bid_invitation', 'redirect');
		}
		#2: for creating
		else
		{
			check_user_access($this, 'create_invitation_for_bids', 'redirect');
		}

		$app_select_str = ' procurement_plan_entries.isactive="Y" ';

		if($this->session->userdata('isadmin') == 'N')
		{
			$userdetails = $this->db->get_where('users', array('userid'=>$this->session->userdata('userid')))->result_array();
			$app_select_str .= ' AND procurement_plans.pde_id ="'. $userdetails[0]['pde'] .'" ';
		}

		if(!empty($data['b']))
		{
			#the bid details
			$app_select_str .= ' AND bidinvitations.id ="'. decryptValue($data['b']) . '"';
			$data['procurement_details'] = $this->Query_reader->get_row_as_array('procurement_plan_details', array('searchstring'=>$app_select_str, 'limittext'=>'', 'orderby'=>' procurement_plan_entries.dateadded ' ));

			$data['bid_invitation_details'] = $this->Query_reader->get_row_as_array('search_table', array('table'=>'bidinvitations', 'limittext'=>'', 'orderby'=>'id', 'searchstring'=>' id="'. decryptValue($data['b'])  .'" AND isactive="Y"'));
		}

		#exit($this->db->last_query());

		#user is editing
		if(!empty($data['i']))
		{
			$addenda_id = decryptValue($data['i']);
			$data['formdata'] = $this->Query_reader->get_row_as_array('search_table', array('table'=>'addenda', 'limittext'=>'', 'orderby'=>'id', 'searchstring'=>' id="'. $addenda_id .'" AND isactive="Y"'));

            #get procurement plan details
            if(!empty($data['formdata']['procurement_ref_no']))
            {
                $data['formdata']['procurement_details'] = $this->Query_reader->get_row_as_array('procurement_plan_details', array('searchstring'=>$app_select_str . ' AND procurement_plan_entries.procurement_ref_no="'. $data['formdata']['procurement_ref_no'] .'"', 'limittext'=>'', 'orderby'=>' procurement_plan_entries.dateadded ' ));
            }
		}

		$data['page_title'] = (!empty($data['i'])? 'Edit addenda' : 'Add IFB addenda');
		$data['current_menu'] = 'view_bid_invitations';
		$data['view_to_load'] = 'bids/ifb_addenda_form';
		$data['view_data']['form_title'] = $data['page_title'];

		$this->load->view('dashboard_v', $data);

	}


	#Function to save an addenda
	function save_ifb_addenda()
	{
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'b'));

		# Pick all assigned data
		$data = assign_to_data($urldata);

		#check user access
		#1: for editing
		if(!empty($data['i']))
		{
			check_user_access($this, 'edit_bid_invitation', 'redirect');
		}
		#2: for creating
		else
		{
			check_user_access($this, 'create_invitation_for_bids', 'redirect');
		}


		if(!empty($_POST['save_addenda']))
		{
            $required_fields = array('title', 'refno');

			$_POST = clean_form_data($_POST);

			$validation_results = validate_form('', $_POST, $required_fields);

			#Only proceed if the validation for required fields passes
			if($validation_results['bool'])
			{
				#check if a document with the specified reference number exists for this IFB
				$similar_ref_no = $this->db->query($this->Query_reader->get_query_by_code('search_table', array('table'=>'addenda', 'orderby'=>'bidid', 'limittext' =>'','searchstring' => ' bidid = "'.decryptValue($data['b']).'" AND refno ="'. $_POST['refno'].
				'" AND isactive="Y"' . (!empty($data['i'])? ' AND id !="' . decryptValue($data['i']) . '"' : ''))))->result_array();


				if(!empty($similar_ref_no))
				{
					$data['msg'] = "WARNING: An addenda for the selected IFB with a similar reference number exists";
				}
				else
				{
					if(!empty($_FILES['addenda']['name']))
					{
						$this->session->set_userdata('local_allowed_extensions', array('.pdf'));
						$extramsg = "";
						$MAX_FILE_SIZE = 1000000;
						$new_file_name = 'addenda_' . strtotime('now') . decryptValue($data['b']) . generate_random_letter();

						$_POST['fileurl'] = (!empty($_FILES['addenda']['name'])) ? $this->sysfile->local_file_upload($_FILES['addenda'], $new_file_name , 'documents/addenda', 'filename') : '';

					}

					if(!empty($data['i']))
					{
						$_POST = array_merge($_POST, array('id'=>decryptValue($data['i'])));
						$_POST['updatestr'] = '';

						if(!empty($_FILES['addenda']['name']) && !empty($_POST['fileurl']))
						{
							$_POST['updatestr'] = ', fileurl = "'. $new_file_name .'" ';
							$result = $this->db->query($this->Query_reader->get_query_by_code('update_addenda', $_POST));

						}
						elseif(!empty($_FILES['addenda']['name']) && empty($_POST['fileurl']))
						{
							$data['msg'] = 'ERROR: '.$this->sysfile->processing_errors;
						}
						else
						{
							$result = $this->db->query($this->Query_reader->get_query_by_code('update_addenda', $_POST));
						}

					}
					else
					{
						$_POST['author'] = $this->session->userdata('userid');
						$_POST['bidid'] = decryptValue($data['b']);

						if(!empty($_POST['fileurl']))
						{
							$result = $this->db->query($this->Query_reader->get_query_by_code('create_addenda', $_POST));
							$addenda_id = $this->db->insert_id();
						}
						elseif(empty($_FILES['addenda']['name']))
						{
							$data['msg'] = 'ERROR: Please select a file to upload';
						}
						else
						{
							$data['msg'] = 'ERROR: '.$this->sysfile->processing_errors;
						}
					}
				}

           		#event has been added successfully
            	if(!empty($result) && $result)
				{
					/*
					#Notify approvers
					$procurement_details = $this->Query_reader->get_row_as_array('procurement_plan_details', array('searchstring'=>' procurement_plan_entries.procurement_ref_no ="'. $_POST['procurement_ref_no'] .'"', 'limittext'=>'', 'orderby'=>' procurement_plan_entries.dateadded ' ));

					if(!empty($procurement_details))
					{
						$this->load->model('notification_m', 'notifications');

						$receipients = $this->notifications->notification_access('approve_invitation_for_bids', $procurement_details['pde_id']);

						if(!empty($receipients))
						{
							$msg_title = 'Request to approve Invitation for Bids';

							$msg_body = 'Hello'.
									'<p>An Invitation for bids process that needs your approval has been initiated by '.
									$this->session->userdata('firstname') . ' ' . $this->session->userdata('lastname') .'.</p>'.
									'<p>The procurement reference number '. $_POST['procurement_ref_no'] .' and subject of procurement is '.
									$procurement_details['subject_of_procurement'] .'. To view more details and approve/reject the IFB click '.
									'<a href="'. base_url() .'bids/approve_bid_invitation/i/'. encryptValue($bid_invitation_id) .'">here</a>'.' </p>'.
									'<p>regards, <br /> System message</p>';


							$notification_result = $this->db->insert('notifications', array('triggeredby'=>$this->session->userdata('userid'),
													'title'=>$msg_title, 'body'=>$msg_body, 'receipients'=>$receipients, 'msgtype'=>'IFB_Approval_Request'));
						}
					}
					*/

					$data['msg'] = "SUCCESS: The addenda details have been saved.";
					$this->session->set_userdata('sres', $data['msg']);


					redirect('bids/view_addenda/m/sres' . ((!empty($data['b']))? "/b/".$data['b'] : ''));

				 }
				 else if(empty($data['msg']))
				 {
					$data['msg'] = "ERROR: The addenda details could not be saved or were not saved correctly.";
				 }
            }


            if((empty($validation_results['bool']) || (!empty($validation_results['bool']) && !$validation_results['bool']))
			&& empty($data['msg']) )
			{
				$data['msg'] = "WARNING: The highlighted fields are required.";
				$data['requiredfields'] = $validation_results['requiredfields'];

			}

		}

		$data['formdata'] = $_POST;


		$app_select_str = ' procurement_plan_entries.isactive="Y" ';

		if($this->session->userdata('isadmin') == 'N')
		{
			$userdetails = $this->db->get_where('users', array('userid'=>$this->session->userdata('userid')))->result_array();
			$app_select_str .= ' AND procurement_plans.pde_id ="'. $userdetails[0]['pde'] .'" ';
		}

		if(!empty($data['b']))
		{
			#the bid details
			$app_select_str .= ' AND bidinvitations.id ="'. decryptValue($data['b']) . '"';
			$data['procurement_details'] = $this->Query_reader->get_row_as_array('procurement_plan_details', array('searchstring'=>$app_select_str, 'limittext'=>'', 'orderby'=>' procurement_plan_entries.dateadded ' ));

			$data['bid_invitation_details'] = $this->Query_reader->get_row_as_array('search_table', array('table'=>'bidinvitations', 'limittext'=>'', 'orderby'=>'id', 'searchstring'=>' id="'. decryptValue($data['b'])  .'" AND isactive="Y"'));
		}

		#exit($this->db->last_query());

		#user is editing
		if(!empty($data['i']))
		{
			$addenda_id = decryptValue($data['i']);
			$data['formdata'] = $this->Query_reader->get_row_as_array('search_table', array('table'=>'addenda', 'limittext'=>'', 'orderby'=>'id', 'searchstring'=>' id="'. $addenda_id .'" AND isactive="Y"'));

            #get procurement plan details
            if(!empty($data['formdata']['procurement_ref_no']))
            {
                $data['formdata']['procurement_details'] = $this->Query_reader->get_row_as_array('procurement_plan_details', array('searchstring'=>$app_select_str . ' AND procurement_plan_entries.procurement_ref_no="'. $data['formdata']['procurement_ref_no'] .'"', 'limittext'=>'', 'orderby'=>' procurement_plan_entries.dateadded ' ));
            }
		}

		$data['page_title'] = (!empty($data['i'])? 'Edit addenda' : 'Add IFB addenda');
		$data['current_menu'] = 'view_bid_invitations';
		$data['view_to_load'] = 'bids/ifb_addenda_form';
		$data['view_data']['form_title'] = $data['page_title'];

		$this->load->view('dashboard_v', $data);

	}


	#Function to delete an addenda
	function delete_addenda()
	{
		#check user access
		check_user_access($this, 'delete_invitation_for_bid', 'redirect');

		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 's', 'i', 'b'));

		# Pick all assigned data
		$data = assign_to_data($urldata);

		if(!empty($data['i']) && !empty($data['b'])){
			$result = $this->db->query($this->Query_reader->get_query_by_code('deactivate_item', array('item'=>'addenda', 'id'=>decryptValue($data['i'])) ));
		}

		if(!empty($result) && $result){
			$this->session->set_userdata('dbid', "The addenda details have been successfully deleted.");
		}
		else if(empty($data['msg']))
		{
			$this->session->set_userdata('dbid', "ERROR: The addenda details could not be deleted or were not deleted correctly.");
		}

		redirect(base_url()."bids/view_addenda/m/dbid/b/".$data['b']);
	}


	# Searcg bid invitations
	function search_bid_invitations()
	{
		check_user_access($this, 'view_bid_invitations', 'redirect');

		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'p'));

		# Pick all assigned data
		$data = @assign_to_data($urldata);

		$search_string = '';

		if($this->session->userdata('isadmin') == 'N')
		{
			$userdata = $this->db->get_where('users', array('userid'=>$this->session->userdata('userid')))->result_array();
			$search_string = ' AND procurement_plans.pde_id="'. $userdata[0]['pde'] .'"';
		}

		if($this->input->post('searchQuery'))
		{
			$_POST = clean_form_data($_POST);
			$_POST['searchQuery'] = trim($_POST['searchQuery']);

			$search_string .= ' AND (procurement_plan_entries.procurement_ref_no like "%'. $_POST['searchQuery'] .
							 '%" OR procurement_plan_entries.subject_of_procurement like "%' . $_POST['searchQuery'] . '%" '.
							 'OR bidinvitations.bid_security_amount like "%'. $_POST['searchQuery'] .'%" '.
							 'OR pdes.pdename like "%' . $_POST['searchQuery'] . '%" '.
							 'OR users.firstname like "%'. $_POST['searchQuery'] .'%" OR '.
							 'users.lastname like "%' . $_POST['searchQuery'] . '%") ';


			$data = paginate_list($this, $data, 'bid_invitation_details', array('orderby'=>'bid_dateadded DESC', 'searchstring'=>'bidinvitations.isactive = "Y" '. $search_string));
		}
		else
		{
			$data = paginate_list($this, $data, 'bid_invitation_details', array('orderby'=>'bid_dateadded DESC', 'searchstring'=>'bidinvitations.isactive = "Y" '. $search_string));
		}

		$data['area'] = 'bid_invitations';

		$this->load->view('includes/add_ons', $data);

	}


	#Function to load invitation for bid form
	function load_bid_invitation_form()
	{
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

		# Pick all assigned data
		$data = assign_to_data($urldata);

		#check user access
		#1: for editing
		if(!empty($data['i']))
		{
			check_user_access($this, 'edit_bid_invitation', 'redirect');
		}
		#2: for creating
		else
		{
			check_user_access($this, 'create_invitation_for_bids', 'redirect');
		}

		$app_select_str = ' procurement_plan_entries.isactive="Y" ';

		if($this->session->userdata('isadmin') == 'N')
		{
			$userdetails = $this->db->get_where('users', array('userid'=>$this->session->userdata('userid')))->result_array();
			$app_select_str .= ' AND procurement_plans.pde_id ="'. $userdetails[0]['pde'] .'"';
		}

		if(!empty($data['i']))
		{
			$app_select_str .= ' AND bidinvitations.id ="'. decryptValue($data['i']) .'" ';

		}
		else
		{
		 	$app_select_str .=  'AND if((procurement_plan_entries.total_ifb_quantity  < procurement_plan_entries.quantity  && procurement_plan_entries.total_ifb_quantity > 0) , bidinvitations.id is  not null, bidinvitations.id is null) ';
		 	//(procurement_plan_entries.total_ifb_quantity < procurement_plan_entries.quantity, COALESCE(bidinvitations.id, 0) < 1 ,COALESCE(bidinvitations.id, 0) > 1 )';
		}
	#	$query  = $this->Query_reader->get_query_by_code('ProcurementPlanDetails', array('searchstring'=>$app_select_str, 'limittext'=>'', 'orderby'=>' procurement_plan_entries.dateadded ' ));
	 #print_r($query); exit();


		$query = $this->Query_reader->get_query_by_code('ProcurementPlanDetails', array('searchstring'=>$app_select_str, 'limittext'=>'', 'orderby'=>' procurement_plan_entries.dateadded ' ));
        #print_r($query); exit();

	 	$data['procurement_plan_entries'] = $this->db->query($this->Query_reader->get_query_by_code('ProcurementPlanDetails', array('searchstring'=>$app_select_str, 'limittext'=>'', 'orderby'=>' procurement_plan_entries.dateadded ' )))->result_array();

		#exit($this->db->last_query());

		#user is editing
		if(!empty($data['i']))
		{
			$bid_id = decryptValue($data['i']);
			$data['formdata'] = $this->Query_reader->get_row_as_array('search_table', array('table'=>'bidinvitations', 'limittext'=>'', 'orderby'=>'id', 'searchstring'=>' id="'. $bid_id .'" AND isactive="Y"'));

            #get procurement plan details
            if(!empty($data['formdata']['procurement_ref_no']))
            {
            	//exit('pass');
                $data['formdata']['procurement_details'] = $this->Query_reader->get_row_as_array('ProcurementPlanDetails', array('searchstring'=>$app_select_str . ' AND procurement_plan_entries.procurement_ref_no="'. $data['formdata']['procurement_ref_no'] .'"', 'limittext'=>'', 'orderby'=>' procurement_plan_entries.dateadded ' ));
            }    
		}

		$data['currencies'] = $this->db->get_where('currencies', array('isactive'=>'Y'))->result_array();

		$data['page_title'] = (!empty($data['i'])? 'Edit Bid Invitation Details' : 'Add Bid Invitation Details');
		$data['current_menu'] = 'create_invitation_for_bids';
		$data['view_to_load'] = 'bids/bid_invitation_form';
		$data['view_data']['form_title'] = $data['page_title'];

		$this->load->view('dashboard_v', $data);

	}

	#function to validate IFB form data
	function validate_ifb_form($formdata)
	{
		$result = 0;
		$msg = '';
		$error_fields = array();

		#pre-bid meeting date
		if(strtotime($formdata['pre_bid_meeting_date']) < strtotime($formdata['invitation_to_bid_date']))
		{
			$msg = 'Pre bid meeting date should be later than invitation to bid date';
			$error_fields = array('pre_bid_meeting_date', 'invitation_to_bid_date');
		}

		#Invitation to bid date
		elseif(strtotime($formdata['invitation_to_bid_date']) < strtotime($formdata['date_initiated']))
		{
			$msg = 'Invitation to bid date should be later than procurement initiation date';
			$error_fields = array('date_initiated', 'invitation_to_bid_date');
		}

		#bid submission deadline
		elseif(strtotime($formdata['bid_submission_deadline']) < strtotime($formdata['pre_bid_meeting_date']))
		{
			$msg = 'Bid submission deadline should be later than pre-bid meeting date';
			$error_fields = array('pre_bid_meeting_date', 'bid_submission_deadline');
		}

		#bid openning date
		elseif(strtotime($formdata['bid_openning_date']) < strtotime($formdata['bid_submission_deadline']))
		{
			$msg = 'Bid openning date should be later than bid submission deadline';
			$error_fields = array('bid_openning_date', 'bid_submission_deadline');
		}

		#bid evaluation start date
		elseif(strtotime($formdata['bid_evaluation_from']) < strtotime($formdata['bid_openning_date']))
		{
			$msg = 'Bid evaluation start date should be later than bid openning date';
			$error_fields = array('bid_openning_date', 'bid_evaluation_from');
		}

		#bid evaluation end date
		elseif(strtotime($formdata['bid_evaluation_to']) < strtotime($formdata['bid_evaluation_from']))
		{
			$msg = 'Bid evaluation end date should be later than bid evaluation start date';
			$error_fields = array('bid_evaluation_to', 'bid_evaluation_from');
		}

		#display of BEB notice date
		elseif(strtotime($formdata['display_of_beb_notice']) < strtotime($formdata['bid_evaluation_to']))
		{
			$msg = 'BEB notice display date should be later than bid evaluation close date';
			$error_fields = array('bid_evaluation_to', 'display_of_beb_notice');
		}

		#contract award date
		elseif(strtotime($formdata['display_of_beb_notice']) < strtotime($formdata['contract_award_date']))
		{
			$msg = 'BEB notice display date must be later than contract award date';
			$error_fields = array('contract_award_date', 'display_of_beb_notice');
		}
		else
		{
			$result = 1;
		}

		return array('result'=>$result, 'msg'=>$msg, 'error_fields'=>$error_fields);

	}

	#save bid invitation
	function save_bid_invitation()
	{
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 's'));

		# Pick all assigned data
		$data = assign_to_data($urldata);

		$data = add_msg_if_any($this, $data);

		#check user access
		#1: for editing
		if(!empty($data['i']))
		{
			check_user_access($this, 'edit_bid_invitation', 'redirect');
		}
		#2: for creating
		else
		{
			check_user_access($this, 'create_invitation_for_bids', 'redirect');
		}


		if(!empty($_POST['save']) || !empty($_POST['approve']))
		{

            $required_fields = array('procurement_id', 'invitation_to_bid_date', 'pre_bid_meeting_date', 'bid_submission_deadline', 'display_of_beb_notice', 'bid_receipt_address', 'documents_inspection_address', 'documents_address_issue', 'bid_openning_address', 'bid_openning_date', 'bid_evaluation_from', 'bid_evaluation_to', 'display_of_beb_notice', 'contract_award_date', 'initiated_by', 'vote_no', 'date_initiated','dateofconfirmationbyao','sequencenumber','procurement_details_quantity','quantityifb');

           # $query = mysql_query("SELECT * FROM procurement_plan_entries WHERE 	id='".$_POST['procurement_id']."' limit 1 ") ;
		   # $reslt = mysql_fetch_array($query);
			#$total_procurement_quantity =  $reslt['total_ifb_quantity'];
			#$procurement_quantity =  $reslt['quantity'];

			#print_r($_POST); exit();
			$_POST = clean_form_data($_POST);

			$validation_results = validate_form('', $_POST, $required_fields);
			$bid_validation_results = $this->validate_ifb_form($_POST);
 
			$data['procurement_details_quantity'] = $_POST['procurement_details_quantity'];
			/*  validation for procurement format */

			#exit();
			 /* end */
            $_POST['procurement_ref_no'] = $_POST['sequencenumber'].$_POST['procurement_ref_no'];
			#Only proceed if the validation for required fields passes
			if($validation_results['bool'] && $bid_validation_results['result'])
			{
				#check if an active bid invitation already exists for selected procurement ref no
				$similar_bid_invitation = $this->db->query($this->Query_reader->get_query_by_code('search_bidinvitation', array( 'orderby'=>'A.procurement_ref_no', 'limittext' =>'','searchstring' => ' A.procurement_id = "'.$_POST['procurement_id'].'" AND  B.total_ifb_quantity >= B.quantity  AND A.isactive="Y"' . (!empty($data['i'])? ' AND A.id !="' . decryptValue($data['i']) . '"' : ''))))->result_array();


				if(!empty($similar_bid_invitation))
				{
					$data['msg'] = "WARNING: A bid invitation for the selected procurement reference number already exists.";
				}
				else
				{

					#format time dependent dates
					#1. bid_submission_deadline_time
					if(!empty($_POST['bid_submission_deadline_time']))
						$_POST['bid_submission_deadline'] = $_POST['bid_submission_deadline'].
																' ' .date("H:i", strtotime($_POST['bid_submission_deadline_time'])) . ':00';

					#2. bid_submission_deadline_time
					if(!empty($_POST['bid_openning_date_time']))
						$_POST['bid_openning_date'] = $_POST['bid_openning_date'].
																' ' .date("H:i", strtotime($_POST['bid_openning_date_time'])) . ':00';

					#3. pre_bid_meeting_date_time
					if(!empty($_POST['pre_bid_meeting_date_time']))
						$_POST['pre_bid_meeting_date'] = $_POST['pre_bid_meeting_date'].
																' ' .date("H:i", strtotime($_POST['pre_bid_meeting_date_time'])) . ':00';

		            #4, bid validity finding::
				    if(!empty($_POST['hasbidvalididy']) &&(($_POST['hasbidvalididy']) == 'y') )
				    {
     				 $_POST['validity']  =removeCommas($_POST['hasbidvalididy']);
     				 $_POST['validityperiod']  = date('Y-m-d',strtotime($_POST['bidvalidtity']));
				    }


					#print_r($_POST);
					$_POST['bid_documents_price'] = removeCommas($_POST['bid_documents_price']);
					$_POST['bid_security_amount'] = removeCommas($_POST['bid_security_amount']);
					#$_POST['dateofconfirmationbyao'] = date('Y-m-d',$_POST['dateofconfirmationbyao']);
					#$_POST['procurement_ref_no'] = $_POST['sequencenumber'].$_POST['procurement_ref_no'];
					
 
					 
					$query = $this->db->query("SELECT * FROM procurement_plan_entries WHERE id='".$_POST['procurement_id']."' ") -> result_array();
					if(!empty($query))
					{
						#print_r($query); 
						$entryquantity = $query[0]['quantity'];
						$total_ifb_quantity = $query[0]['total_ifb_quantity'];
						$totall = $_POST['quantityifb'] + $total_ifb_quantity;
						 
					}


					//exit();
					if(!empty($data['i']))
					{
						#exit('reached');
						$_POST = array_merge($_POST, array('invitation_id'=>decryptValue($data['i'])));

						$result = $this->db->query($this->Query_reader->get_query_by_code('update_bid_invitation', $_POST));
						#exit($this->db->last_query());
						$bid_invitation_id =  decryptValue($data['i']);
						$query = mysql_query("UPDATE   procurement_plan_entries SET total_ifb_quantity ='".$totall."' WHERE  	id='".$_POST['procurement_id']."' limit 1 ") or die("".mysql_error()) ;
		    
					}
					else
					{
						$_POST['author'] = $this->session->userdata('userid');
						//$bidinviatns = $this->Query_reader->get_query_by_code('add_bid_invitation', $_POST);
						$result = $this->db->query($this->Query_reader->get_query_by_code('add_bid_invitation', $_POST));

						$bid_invitation_id = $this->db->insert_id();
						$query = mysql_query("UPDATE   procurement_plan_entries SET total_ifb_quantity ='".$totall."' WHERE  	id='".$_POST['procurement_id']."' limit 1 ") or die("".mysql_error()) ;
		    
					}
				}

           		#event has been added successfully
            	if(!empty($result) && $result)
				{
					/*
					#Notify approvers
					$procurement_details = $this->Query_reader->get_row_as_array('procurement_plan_details', array('searchstring'=>' procurement_plan_entries.procurement_ref_no ="'. $_POST['procurement_ref_no'] .'"', 'limittext'=>'', 'orderby'=>' procurement_plan_entries.dateadded ' ));

					if(!empty($procurement_details))
					{
						$this->load->model('notification_m', 'notifications');

						$receipients = $this->notifications->notification_access('approve_invitation_for_bids', $procurement_details['pde_id']);

						if(!empty($receipients))
						{
							$msg_title = 'Request to approve Invitation for Bids';

							$msg_body = 'Hello'.
									'<p>An Invitation for bids process that needs your approval has been initiated by '.
									$this->session->userdata('firstname') . ' ' . $this->session->userdata('lastname') .'.</p>'.
									'<p>The procurement reference number '. $_POST['procurement_ref_no'] .' and subject of procurement is '.
									$procurement_details['subject_of_procurement'] .'. To view more details and approve/reject the IFB click '.
									'<a href="'. base_url() .'bids/approve_bid_invitation/i/'. encryptValue($bid_invitation_id) .'">here</a>'.' </p>'.
									'<p>regards, <br /> System message</p>';


							$notification_result = $this->db->insert('notifications', array('triggeredby'=>$this->session->userdata('userid'),
													'title'=>$msg_title, 'body'=>$msg_body, 'receipients'=>$receipients, 'msgtype'=>'IFB_Approval_Request'));
						}
					}
					*/

					$data['msg'] = "SUCCESS: The bid invitation details have been saved.";
					$this->session->set_userdata('sres', $data['msg']);

					#user clicked publish
					if(!empty($_POST['approve']))
					{
						redirect('bids/approve_bid_invitation/m/sres/i/' . encryptValue($bid_invitation_id). ((!empty($data['v']))? "/v/".$data['v'] : ''));
					}
					else
					{
						if(!empty($bid_invitation_id))
						{
							#all I need is credentials
							$data['notifyrop'] =  $bid_invitation_id;
						}
						redirect('bids/manage_bid_invitations/m/sres' . ((!empty($data['v']))? "/v/".$data['v'] : ''));
					}

				 }
				 else if(empty($data['msg']))
				 {
					$data['msg'] = "ERROR: The bid invitation details could not be saved or were not saved correctly.";

					/*
					if(!empty($_POST['procurement_ref_no']))
					$data['formdata']['procurement_details'] = $this->Query_reader->get_row_as_array('search_table', array('table'=>'procurement_plan_entries', 'orderby'=>'procurement_ref_no', 'limittext' =>'','searchstring' => ' id = "'.$_POST['procurement_ref_no'].'" AND isactive="Y"'));
					*/
				 }
            }


            if((empty($validation_results['bool']) || (!empty($validation_results['bool']) && !$validation_results['bool']))
			&& empty($data['msg']) )
			{
				$data['msg'] = "WARNING: The highlighted fields are required.";
				$data['requiredfields'] = $validation_results['requiredfields'];

			}
			elseif(!$bid_validation_results['result'] && empty($data['msg']))
			{
				$data['msg'] = "WARNING: " . $bid_validation_results['msg'];
				$data['requiredfields'] = $bid_validation_results['error_fields'];
			}

		}

		$data['formdata'] = $_POST;
		#print_array($_POST); exit();
		$app_select_str = ' procurement_plan_entries.isactive="Y" ';

		if($this->session->userdata('isadmin') == 'N')
		{
			$userdetails = $this->db->get_where('users', array('userid'=>$this->session->userdata('userid')))->result_array();
			$app_select_str .= ' AND procurement_plans.pde_id ="'. $userdetails[0]['pde'] .'"';
		}

		if(!empty($data['i']))
		{
			$app_select_str .= ' AND bidinvitations.id ="'. decryptValue($data['i']) .'" ';
		}
		else
		{
			$app_select_str .=  ' AND IF(procurement_plan_entries.total_ifb_quantity >= procurement_plan_entries.quantity,COALESCE(bidinvitations.id, 0) < 1,COALESCE(bidinvitations.id, 0) > 1 ) ';
			#$app_select_str .= ' AND COALESCE(bidinvitations.id, 0) < 1';
		}

		$data['procurement_plan_entries'] = $this->db->query($this->Query_reader->get_query_by_code('ProcurementPlanDetails', array('searchstring'=>$app_select_str, 'limittext'=>'', 'orderby'=>' procurement_plan_entries.dateadded ' )))->result_array();

		$data['currencies'] = $this->db->get_where('currencies', array('isactive'=>'Y'))->result_array();

		$data['page_title'] = (!empty($data['i'])? 'Edit bid invitation' : 'Create bid invitation');
		$data['current_menu'] = 'create_invitation_for_bids';
		$data['view_to_load'] = 'bids/bid_invitation_form';
		$data['view_data']['form_title'] = $data['page_title'];
		//print_r($data);

		$this->load->view('dashboard_v', $data);

	}


	#approve bid invitation
	function approve_bid_invitation()
	{
		#check user access
		check_user_access($this, 'publish_invitation_for_bids', 'redirect');

		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 's'));

		# Pick all assigned data
		$data = assign_to_data($urldata);
			#print_r($data); exit();

		$data = add_msg_if_any($this, $data);


		if(!empty($_POST['save']) && !empty($_POST['editid']))
		{
            $required_fields = array('cc_approval_date');

			$_POST = clean_form_data($_POST);

			$validation_results = validate_form('', $_POST, $required_fields);

			#Only proceed if the validation for required fields passes
			if($validation_results['bool'])
			{
				if(!empty($data['i']))
				{
					$_POST['approvedby'] = $this->session->userdata('userid');
					$bid_invitation_id = 	$_POST['bidinvitation_id'] = decryptValue($_POST['editid']);


					#$query =$this->Query_reader->get_query_by_code('publish_bid_invitation', $_POST)	;
					#print_r($query); exit();

					$result = $this->db->query($this->Query_reader->get_query_by_code('publish_bid_invitation', $_POST));
					#exit($this->db->last_query());
				}

           		#bid invitation has been approved successfully
            	if(!empty($result) && $result)
				{

							#all I need is credentials
							$data['notifyrop'] =  $bid_invitation_id;


					$data['msg'] = "SUCCESS: The bid invitation has been published and is now visible to the public.";
					$this->session->set_userdata('sres', $data['msg']);

					redirect('bids/manage_bid_invitations/notifyrop/'.$bid_invitation_id.'/m/sres' . ((!empty($data['v']))? "/v/".$data['v'] : ''));

				 }
				 else if(empty($data['msg']))
				 {
					$data['msg'] = "ERROR: The bid invitation could not be published or was not published correctly.";
				 }
            }

            if((empty($validation_results['bool']) || (!empty($validation_results['bool']) && !$validation_results['bool']))
			&& empty($data['msg']) )
			{
				$data['msg'] = "WARNING: The highlighted fields are required.";
			}

			$data['requiredfields'] = $validation_results['requiredfields'];
		}


		if(!empty($data['i']))
		{
			$app_select_str = ' procurement_plan_entries.isactive="Y" ';

			if($this->session->userdata('isadmin') == 'N')
			{
				$userdetails = $this->db->get_where('users', array('userid'=>$this->session->userdata('userid')))->result_array();
				$app_select_str .= ' AND procurement_plans.pde_id ="'. $userdetails[0]['pde'] .'"';
			}

			$bid_id = decryptValue($data['i']);
			$data['formdata'] = $this->Query_reader->get_row_as_array('search_table', array('table'=>'bidinvitations', 'limittext'=>'', 'orderby'=>'id', 'searchstring'=>' id="'. $bid_id .'" AND isactive="Y"'));

            #get procurement plan details
            if(!empty($data['formdata']['procurement_ref_no']))
            {
                $data['formdata']['procurement_details'] = $this->Query_reader->get_row_as_array('procurement_plan_details', array('searchstring'=>$app_select_str . ' AND procurement_plan_entries.procurement_ref_no="'. $data['formdata']['procurement_ref_no'] .'"', 'limittext'=>'', 'orderby'=>' procurement_plan_entries.dateadded ' ));
            }
		}

		if(!empty($_POST['approval_comments']))
		$data['formdata']['approval_comments'] = $_POST['approval_comments'];

		$data['page_title'] = 'Approve bid invitation';
		$data['current_menu'] = 'view_bid_invitations';
		$data['view_to_load'] = 'bids/approve_bid_invitation_form';
		$data['view_data']['form_title'] = $data['page_title'];

		$this->load->view('dashboard_v', $data);

	}


	#view bid invitation
	function view_bid_invitation()
	{
		#check user access
		check_user_access($this, 'publish_invitation_for_bids', 'redirect');

		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 's'));

		# Pick all assigned data
		$data = assign_to_data($urldata);

		$data = add_msg_if_any($this, $data);

		if(!empty($data['i']))
		{
			$app_select_str = ' procurement_plan_entries.isactive="Y" ';

			if($this->session->userdata('isadmin') == 'N')
			{
				$userdetails = $this->db->get_where('users', array('userid'=>$this->session->userdata('userid')))->result_array();
				$app_select_str .= ' AND procurement_plans.pde_id ="'. $userdetails[0]['pde'] .'"';
			}

			$bid_id = decryptValue($data['i']);
			$data['formdata'] = $this->Query_reader->get_row_as_array('search_table', array('table'=>'bidinvitations', 'limittext'=>'', 'orderby'=>'id', 'searchstring'=>' id="'. $bid_id .'" AND isactive="Y"'));

			if(empty($data['formdata']) || $data['formdata']['isapproved'] == 'N' || empty($data['formdata']['cc_approval_date']))
			{
				$data['msg'] = "WARNING: The bid invitation has not been approved";
				$this->session->set_userdata('sres', $data['msg']);

				redirect('bids/manage_bid_invitations/m/sres');
			}

            #get procurement plan details
            if(!empty($data['formdata']['procurement_ref_no']))
            {
                $data['formdata']['procurement_details'] = $this->Query_reader->get_row_as_array('procurement_plan_details', array('searchstring'=>$app_select_str . ' AND procurement_plan_entries.id="'. $data['formdata']['procurement_id'] .'"', 'limittext'=>'', 'orderby'=>' procurement_plan_entries.dateadded ' ));
            }

			if(!empty($data['v']) && $data['v'] == 'doc'):
				$this->load->view('bids/invitation_for_bids_pdf', $data);

				$html = $this->output->get_output();
				report_to_pdf($this, $html, 'IFB_document_'.strtotime(date('Y-m-d h:i')));
				return;
			endif;

		}

		$data['page_title'] = 'Preview bid invitation';
		$data['current_menu'] = 'view_bid_invitations';
		$data['view_to_load'] = 'bids/view_bid_invitation';
		$data['view_data']['form_title'] = $data['page_title'];

		$this->load->view('dashboard_v', $data);

	}

	#function to print IFB
	function ifb_to_pdf()
	{
		#check user access
		check_user_access($this, 'publish_invitation_for_bids', 'redirect');

		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 's'));

		# Pick all assigned data
		$data = assign_to_data($urldata);

		$data = add_msg_if_any($this, $data);

		if(!empty($data['i']))
		{
			$app_select_str = ' procurement_plan_entries.isactive="Y" ';

			if($this->session->userdata('isadmin') == 'N')
			{
				$userdetails = $this->db->get_where('users', array('userid'=>$this->session->userdata('userid')))->result_array();
				$app_select_str .= ' AND procurement_plans.pde_id ="'. $userdetails[0]['pde'] .'"';
			}

			$bid_id = decryptValue($data['i']);
			$data['formdata'] = $this->Query_reader->get_row_as_array('search_table', array('table'=>'bidinvitations', 'limittext'=>'', 'orderby'=>'id', 'searchstring'=>' id="'. $bid_id .'" AND isactive="Y"'));

			if(empty($data['formdata']) || $data['formdata']['isapproved'] == 'N' || empty($data['formdata']['cc_approval_date']))
			{
				$data['msg'] = "WARNING: The bid invitation has not been approved";
				$this->session->set_userdata('sres', $data['msg']);

				redirect('bids/manage_bid_invitations/m/sres');
			}

            #get procurement plan details
            if(!empty($data['formdata']['procurement_ref_no']))
            {
                $data['formdata']['procurement_details'] = $this->Query_reader->get_row_as_array('procurement_plan_details', array('searchstring'=>$app_select_str . ' AND procurement_plan_entries.procurement_ref_no="'. $data['formdata']['procurement_ref_no'] .'"', 'limittext'=>'', 'orderby'=>' procurement_plan_entries.dateadded ' ));
            }
		}

		$data['page_title'] = 'Preview bid invitation';
		$data['current_menu'] = 'view_bid_invitations';
		$data['view_to_load'] = 'bids/view_bid_invitation';
		$data['view_data']['form_title'] = $data['page_title'];

		$this->load->view('dashboard_v', $data);
	}

//start

#function to show procurement plan record details
		function procurement_recorddetails()
		{
			# Get the passed details into the url data array if any
			$urldata = $this->uri->uri_to_assoc(3, array('m', 'b'));

			# Pick all assigned data
			$data = assign_to_data($urldata);
			$notify = 0;
			if(!empty($data['notification'])){
				$notify = 1;
			}


			if($this->input->post('proc_id'))
			{
				$_POST = clean_form_data($_POST);

				$app_select_str = ' procurement_plan_entries.isactive="Y" ';

				if($this->session->userdata('isadmin') == 'N')
				{
					$userdetails = $this->db->get_where('users', array('userid'=>$this->session->userdata('userid')))->result_array();
					$app_select_str .= ' AND procurement_plans.pde_id ="'. $userdetails[0]['pde'] .'"';
				}

				#$query = $this->Query_reader->get_query_by_code('ProcurementPlanDetails', array('searchstring'=>$app_select_str . ' AND procurement_plan_entries.id="'. $_POST['proc_id'] .'"', 'limittext'=>'', 'orderby'=>' procurement_plan_entries.dateadded ' ));
				#print_r($query); exit();
				//procurement details

				#$data['procurement_details'] = $this->Query_reader->get_row_as_array('ProcurementPlanDetails', array('searchstring'=>$app_select_str . '  AND  receipts.beb="Y" AND procurement_plan_entries.id="'. $_POST['proc_id'] .'"', 'limittext'=>'', 'orderby'=>' procurement_plan_entries.dateadded ' ));

				$data['procurement_details'] = $this->Query_reader->get_row_as_array('procurement_plan_details', array('searchstring'=>$app_select_str . ' AND  receipts.beb="Y"  AND procurement_plan_entries.id="'. $_POST['proc_id'] .'"', 'limittext'=>'', 'orderby'=>' procurement_plan_entries.dateadded ' ));

				#get provider info
				if(!empty($data['b'])):
					$data['provider'] = $this->Query_reader->get_row_as_array('get_IFB_BEB', array('searchstring'=> ' AND BI.procurement_id="'.
						$_POST['proc_id'] .'" AND beb="Y"'));

					if(!empty($data['provider']) && empty($data['provider']['providerid'])):
						$jv_info = $this->db->query('SELECT * FROM joint_venture WHERE jv = "'. $data['provider']['joint_venture'] .'"')->result_array();
						if(!empty($jv_info[0]['providers'])):
							$providers = $this->db->query('SELECT * FROM providers WHERE providerid IN ('. rtrim($jv_info[0]['providers'], ',') .')')->result_array();
							$data['provider']['providernames'] = '';

							foreach($providers as $provider):
								$data['provider']['providernames'] .= (!empty($data['provider']['providernames'])? ', ' : '').
									$provider['providernames'];
							endforeach;

						endif;
					endif;

					#exit($this->db->last_query());
				endif;
			}

			// $data['area'] = 'procurement_record_details';

			// $this->load->view('includes/add_ons', $data);


			if($notify == 1){

								print_r($data['provider']['providername']);


							if(!empty($data['provider']['providername'])){
						print_r($data['provider']['providerid']);
						$providerid = $data['provider']['providerid'];
						if(is_numeric($providerid))
						{

							$procurementdetails = $this->db->query('SELECT * FROM providers WHERE providerid IN ('.rtrim($data['provider']['providerid'],',').') ' ) -> result_array();

						}
						else
						{
							#$query = 'SELECT * FROM providers WHERE providerid IN (SELECT  TRIM(TRAILING "," FROM providers) FROM  joint_venture	 WHERE jv = "'.$data['provider']['providername'].'" ) ';
							#echo $query;
								$procurementdetails = $this->db->query('SELECT * FROM providers WHERE providerid IN (SELECT  TRIM(TRAILING "," FROM providers) FROM  joint_venture	 WHERE jv = "'.$data['provider']['providername'].'" ) ' ) -> result_array();

						}

							#print_r($procurementdetails);
							$providers = '<ul>';
							$xc = '';
							#$suspended = '';
							$status = 0;
							foreach ($procurementdetails as $key => $value) {

									#check provider
									$xc = searchprovidervalidity($value['providernames']);
								if(!empty($xc))
								{
									$status =1;
									$providers .= "<li> ".$value['providernames']." ".'</li>';
									# $suspended .= $value['providernames'].',';
								}
								}

						$providers .= '<ul>';



							$rand  = rand(23454,83938);

						$this->session->set_userdata('level','ppda');
						$userid = $this->session->userdata('userid');
						$query1 = $this->db->query("SELECT CONCAT(firstname,',',lastname) AS names FROM  users WHERE userid=".$userid ." limit 1")-> result_array();
								$level = "Disposal";
										$entity =  $this->session->userdata('pdeid');
						$query = $this->db->query("SELECT * FROM pdes WHERE pdeid=".$entity." limit 1")-> result_array();
						$entityname = $query[0]['pdename'];

						$titles = " Attemp to award a contract to    suspended provider(s) by ".$entityname."  -CO ".$rand." ";

						$body =  " <h2> SUSPENDED  PROVIDER</H2> ";
						$body .="<table><tr><th> Organisation(S) </th><td>".$providers." </td></tr>";
						$body .="<tr><th>Admininstrator </th><td>".$query1[0]['names']." </td></tr>";
						$body .="<tr><th> Date </th><td>".Date('Y m-d')." </td></tr>";
						$body .= "</table>";
						$permission = "view_disposal_plans";

						push_permission($titles,$body,$level,$permission);



		}
		}
			else{
			$data['area'] = 'procurement_record_details';

			$this->load->view('includes/add_ons', $data);
		}

		}
//end
	#function to show procurement plan record details
	function procurement_record_details()
	{
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'b'));

		# Pick all assigned data
		$data = assign_to_data($urldata);
		$notify = 0;
	   if(!empty($data['notification'])){
	   	$notify = 1;
		}


		if($this->input->post('proc_id'))
		{
			$_POST = clean_form_data($_POST);

			$app_select_str = ' procurement_plan_entries.isactive="Y" ';

			if($this->session->userdata('isadmin') == 'N')
			{
				$userdetails = $this->db->get_where('users', array('userid'=>$this->session->userdata('userid')))->result_array();
				$app_select_str .= ' AND procurement_plans.pde_id ="'. $userdetails[0]['pde'] .'"';
			}

			#$query = $this->Query_reader->get_query_by_code('ProcurementPlanDetails', array('searchstring'=>$app_select_str . ' AND procurement_plan_entries.id="'. $_POST['proc_id'] .'"', 'limittext'=>'', 'orderby'=>' procurement_plan_entries.dateadded ' ));
			#print_r($query); exit();
            //procurement details

            #$data['procurement_details'] = $this->Query_reader->get_row_as_array('ProcurementPlanDetails', array('searchstring'=>$app_select_str . '  AND  receipts.beb="Y" AND procurement_plan_entries.id="'. $_POST['proc_id'] .'"', 'limittext'=>'', 'orderby'=>' procurement_plan_entries.dateadded ' ));

			$data['procurement_details'] = $this->Query_reader->get_row_as_array('ProcurementPlanDetails', array('searchstring'=>$app_select_str . '  AND procurement_plan_entries.id="'. $_POST['proc_id'] .'"', 'limittext'=>'', 'orderby'=>' procurement_plan_entries.dateadded ' ));

			#get provider info
			if(!empty($data['b'])):
				$data['provider'] = $this->Query_reader->get_row_as_array('get_IFB_BEB', array('searchstring'=> ' AND BI.procurement_id="'.
					$_POST['proc_id'] .'" AND beb="Y"'));

				if(!empty($data['provider']) && empty($data['provider']['providerid'])):
					$jv_info = $this->db->query('SELECT * FROM joint_venture WHERE jv = "'. $data['provider']['joint_venture'] .'"')->result_array();
					if(!empty($jv_info[0]['providers'])):
						$providers = $this->db->query('SELECT * FROM providers WHERE providerid IN ('. rtrim($jv_info[0]['providers'], ',') .')')->result_array();
						$data['provider']['providernames'] = '';

						foreach($providers as $provider):
							$data['provider']['providernames'] .= (!empty($data['provider']['providernames'])? ', ' : '').
								$provider['providernames'];
						endforeach;

					endif;
				endif;

				#exit($this->db->last_query());
			endif;
		}

		// $data['area'] = 'procurement_record_details';

		// $this->load->view('includes/add_ons', $data);


		if($notify == 1){

              print_r($data['provider']['providername']);


					  if(!empty($data['provider']['providername'])){
					 print_r($data['provider']['providerid']);
					 $providerid = $data['provider']['providerid'];
					 if(is_numeric($providerid))
					 {

					  $procurementdetails = $this->db->query('SELECT * FROM providers WHERE providerid IN ('.rtrim($data['provider']['providerid'],',').') ' ) -> result_array();

					 }
					 else
					 {
					 	#$query = 'SELECT * FROM providers WHERE providerid IN (SELECT  TRIM(TRAILING "," FROM providers) FROM  joint_venture	 WHERE jv = "'.$data['provider']['providername'].'" ) ';
					 	#echo $query;
					 	  $procurementdetails = $this->db->query('SELECT * FROM providers WHERE providerid IN (SELECT  TRIM(TRAILING "," FROM providers) FROM  joint_venture	 WHERE jv = "'.$data['provider']['providername'].'" ) ' ) -> result_array();

					 }

					  #print_r($procurementdetails);
					  $providers = '<ul>';
					  $xc = '';
					  #$suspended = '';
					  $status = 0;
					  foreach ($procurementdetails as $key => $value) {

					 	    #check provider
					 	    $xc = searchprovidervalidity($value['providernames']);
							if(!empty($xc))
							{
								$status =1;
								$providers .= "<li> ".$value['providernames']." ".'</li>';
								# $suspended .= $value['providernames'].',';
							}
					    }

					 $providers .= '<ul>';



             $rand  = rand(23454,83938);

        	 $this->session->set_userdata('level','ppda');
        	 $userid = $this->session->userdata('userid');
        	 $query1 = $this->db->query("SELECT CONCAT(firstname,',',lastname) AS names FROM  users WHERE userid=".$userid ." limit 1")-> result_array();
        	 	  $level = "Disposal";
  			          $entity =  $this->session->userdata('pdeid');
				  $query = $this->db->query("SELECT * FROM pdes WHERE pdeid=".$entity." limit 1")-> result_array();
				  $entityname = $query[0]['pdename'];

				  $titles = " Attemp to award a contract to    suspended provider(s) by ".$entityname."  -CO ".$rand." ";

				  $body =  " <h2> SUSPENDED  PROVIDER</H2> ";
				  $body .="<table><tr><th> Organisation(S) </th><td>".$providers." </td></tr>";
				  $body .="<tr><th>Admininstrator </th><td>".$query1[0]['names']." </td></tr>";
				  $body .="<tr><th> Date </th><td>".Date('Y m-d')." </td></tr>";
				  $body .= "</table>";
				  $permission = "view_disposal_plans";

 				  push_permission($titles,$body,$level,$permission);



	}
	}
		else{
		$data['area'] = 'procurement_record_details';

		$this->load->view('includes/add_ons', $data);
	}

}




	#Function to delete a provider's details
	function delete_bid_invitation()
	{
		#check user access
		check_user_access($this, 'delete_invitation_for_bid', 'redirect');

		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 's'));

		# Pick all assigned data
		$data = assign_to_data($urldata);

		if(!empty($data['i'])){
			$result = $this->db->query($this->Query_reader->get_query_by_code('deactivate_item', array('item'=>'bidinvitations', 'id'=>decryptValue($data['i'])) ));
		}

		if(!empty($result) && $result){
			$this->session->set_userdata('dbid', "The bid invitation details have been successfully deleted.");
		}
		else if(empty($data['msg']))
		{
			$this->session->set_userdata('dbid', "ERROR: The bid invitation details could not be deleted or were not deleted correctly.");
		}

		if(!empty($data['t']) && $data['t'] == 'super'){
			$tstr = "/t/super";
		}else{
			$tstr = "";
		}
		redirect(base_url()."bids/manage_bid_invitations/m/dbid".$tstr);
	}


	#Function to load invitation for bid form
	function load_approve_bid_invitation_form()
	{
		#check user access
		check_user_access($this, 'approve_invitation_for_bids', 'redirect');

		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m'));

		# Pick all assigned data
		$data = assign_to_data($urldata);

		$app_select_str = ' procurement_plan_entries.isactive="Y" ';

		if($this->session->userdata('isadmin') == 'N')
		{
			$userdetails = $this->db->get_where('users', array('userid'=>$this->session->userdata('userid')))->result_array();
			$app_select_str .= ' AND procurement_plans.pde_id ="'. $userdetails[0]['pde'] .'"';
		}

		$data['procurement_plan_entries'] = $this->db->query($this->Query_reader->get_query_by_code('procurement_plan_details', array('searchstring'=>$app_select_str, 'limittext'=>'', 'orderby'=>' procurement_plan_entries.dateadded ' )))->result_array();

		#exit($this->db->last_query());

		if(!empty($data['i']))
		{
			$app_select_str = ' procurement_plan_entries.isactive="Y" ';

			if($this->session->userdata('isadmin') == 'N')
			{
				$userdetails = $this->db->get_where('users', array('userid'=>$this->session->userdata('userid')))->result_array();
				$app_select_str .= ' AND procurement_plans.pde_id ="'. $userdetails[0]['pde'] .'"';
			}

			$bid_id = decryptValue($data['i']);
			$data['formdata'] = $this->Query_reader->get_row_as_array('search_table', array('table'=>'bidinvitations', 'limittext'=>'', 'orderby'=>'id', 'searchstring'=>' id="'. $bid_id .'" AND isactive="Y"'));

            #get procurement plan details
            if(!empty($data['formdata']['procurement_ref_no']))
            {
                $data['formdata']['procurement_details'] = $this->Query_reader->get_row_as_array('procurement_plan_details', array('searchstring'=>$app_select_str . ' AND procurement_plan_entries.procurement_ref_no="'. $data['formdata']['procurement_ref_no'] .'"', 'limittext'=>'', 'orderby'=>' procurement_plan_entries.dateadded ' ));
            }
		}

		if(!empty($data['formdata']['approval_comments']))
		$data['formdata']['approval_comments'] = $_POST['approval_comments'];

		$data['page_title'] = 'Approve bid invitation';
		$data['current_menu'] = 'manage_bid_invitations';
		$data['view_to_load'] = 'bids/approve_bid_invitation_form';
		$data['view_data']['form_title'] = $data['page_title'];

		$this->load->view('dashboard_v', $data);

	}




/*****************************************************
MOVER
*****************************************************/


	#add new Receipt to a given Procurment
	function publish_bidder(){

	$status = $this->uri->segment(3);

  //unsertting editbeb session


	switch ($status) {
	case 'publish_bidder':
  	# code... providerslist
	  #check user access
   	#check_user_access($this, 'publish_bidder', 'redirect');

    #$this->session-> userdata(array('bebid'=>$bebid));
    $bidid= $this->uri->segment(4);

	  $procurement_ref_no = base64_decode($this->uri->segment(5));
	  # get procurement information :
	  $data['procurementdetails'] = $this-> Proc_m -> fetch_annual_procurement_plan($procurement_ref_no);

	  //print_r($data['procurementdetails']); exit();
	  // $data['procurement_details'] = $this->Query_reader->get_row_as_array('procurement_plan_details', array('searchstring'=> ' AND procurement_plan_entries.procurement_ref_no="'. $procurement_ref_no .'"', 'limittext'=>'', 'orderby'=>' procurement_plan_entries.dateadded ' ));

	  #get bid information
	  $data['bidinformation'] = $this-> Receipts_m -> fetchbidinformation($bidid);
	  #get receipts information
	  $data['receiptinfo'] = $this-> Receipts_m -> fetchreceipts($bidid);

	  #count bids
	  $data['localbids'] = $this-> Receipts_m -> count_bids('uganda',$bidid);
	  $data['foreignbids'] = $this-> Receipts_m -> count_bids('Foreign',$bidid);
	  #fetch evaluation methods
	  $data['evaluation_methods'] = $this-> Evaluation_methods_m -> fetchevaluationmethods();
	  #fetch providers
	  $data['providerslist'] = $this-> Receipts_m -> fetchproviders($bidid);
		# $data['unsuccesful_bidders'] =   $this-> Receipts_m -> fetch_unsuccesful_bidders(0,$bidid);

		# Pick all assigned data

		$var = $this->session->userdata;
		if(isset($var['bebid']) && !empty($var['bebid']))
		{
			$bebid = $var['bebid'];
			$data['bebresult'] = $this -> db -> query("SELECT * FROM bestevaluatedbidder WHERE id=".$bebid)-> result_array();
			$data['formtype']='editbeb';
			#print_r($data['bebresult']);
		}


		$data['lots'] = $this-> Receipts_m->fetchlots($_POST['procurementrefno']);

	  $data['bidid'] = $bidid;
	  $data['page_title'] = 'Publish Best Evaluated Bidder ';
	  $data['level'] = $status;
	  $data['view_to_load'] = 'bids/publish_bidder_v';
	  $this->load->view( $data['view_to_load'], $data);
		break;



	case 'view_bidders_list':
	# code...
	#check user access
 	#check_user_access($this, 'view_bidders_list', 'redirect');

	 $bid_id = $this->uri->segment(4);
	 $procurement_ref_no = base64_decode($this->uri->segment(5));
	 $data['page_title'] = $procurement_ref_no;
	 $data['bidderslist'] = $this-> Receipts_m -> fetctpdereceipts($bid_id);
	 #print_r($data['bidderslist']); exit();
	 $data['level'] = $status;
	break;




	case 'active_procurements':

	  # check_user_access($this, 'active_procurements', 'redirect');

		$urldata = $this->uri->uri_to_assoc(4, array('m'));
		$data = assign_to_data($urldata);

	   //$var = $this->session->userdata;
		 if(!isset($data['editbeb']) || empty($data['editbeb']))	{
			$this->session->unset_userdata('bebid');
			#exit("Interesting .... ");
		  }

		# Pick all assigned data
		$data = assign_to_data($urldata);
		$data = add_msg_if_any($this, $data);
		$data = handle_redirected_msgs($this, $data);
	  $data['active_procurements'] = $this-> Proc_m -> fetch_active_procurement_list($idx=0,$data);

		if(isset($data['editbeb']) && !empty($data['editbeb']))
		{
			$bebid = mysql_real_escape_string(base64_decode($data['editbeb']));
			$this->session->set_userdata(array('bebid'=>$bebid));

	  	$query = $this->Query_reader->get_query_by_code('search_procurement_by_beb', array('SEARCHSTRING' => ' WHERE  1=1  and 	bestevaluatedbidder.id = '.$bebid.' ','limittext' => ''));

	  	#print_r($query); exit();
			$result = $this->db->query($query)->result_array();
	  	#fetch Procurement Ref No :: --
  		$data['procurement_refno'] = $result[0]['procurement_ref_no'];
  		#print_r($data['procurement_refno']); exit();

		}



	  $data['page_title'] = 'Select procurement ';
    $data['level'] = $status;
 		$data['current_menu'] = 'select_beb';
 		$data['view_to_load'] = 'bids/overview3';
 		// $data['view_to_load'] = 'bids/publish_bidder_v';
		$data['view_data']['form_title'] = $data['page_title'];
		$this->load->view('dashboard_v', $data);
	break;


	  default:
		# code...
		break;
}




	}

	#add new Receipt to a given Procurment
	function disposal_publish_bidder(){

	$status = $this->uri->segment(3);

  //unsertting editbeb session
	$urldata = $this->uri->uri_to_assoc(4, array('m'));
		$data = assign_to_data($urldata);

	switch ($status) {
	case 'publish_bidder':

     $pde =  $this->session->userdata('pdeid');
	 $userid =  $this->session->userdata('userid');

       $searchstring = " and disposal_bid_invitation.id=".mysql_real_escape_string($_POST['disposalbid_id'])."  and  users.userid=".$userid."  and users.pde=".$pde."  ";
	   $data['disposal_plans_details'] = $this -> disposal -> fetch_disposal_details($data,$searchstring,1);


	  #get bid information
	  #$data['bidinformation'] = $this-> Receipts_m -> fetch_bid_information($bidid);

	  #get receipts information
	  #$data['receiptinfo'] = $this-> Receipts_m -> fetchreceipts($bidid);

	  #count bids
	  $data['localbids'] = $this-> Receipts_m -> count_bids_disposal('uganda',$_POST['disposalbid_id']);
	  $data['foreignbids'] = $this-> Receipts_m -> count_bids_disposal('Foreign',$_POST['disposalbid_id']);
	  #fetch evaluation methods

	  $data['evaluation_methods'] = $this-> Evaluation_methods_m -> disposalfetchevaluationmethods();
	  #fetch providers
	  $data['providerslist'] =   $this-> Receipts_m -> fetch_disposal_receipts( $_POST['disposalbid_id']);
	  //data['providerslist'] = $this-> Receipts_m -> fetchproviders($bidid);
		# $data['unsuccesful_bidders'] =   $this-> Receipts_m -> fetch_unsuccesful_bidders(0,$bidid);

		# Pick all assigned data

		$var = $this->session->userdata;
		if(isset($var['bebid']) && !empty($var['bebid']))
		{
			$bebid = $var['bebid'];
			$data['bebresult'] = $this -> db -> query("SELECT * FROM bestevaluatedbidder WHERE id=".$bebid)-> result_array();
			$data['formtype']='editbeb';
			#print_r($data['bebresult']);
		}


	 # $data['lots'] = $this-> Receipts_m->fetchlots($_POST['procurementrefno']);

	  $data['bidid'] = $_POST['disposalbid_id'];
	  $data['page_title'] = 'Publish Best Evaluated Bidder ';
	  $data['level'] = $status;
	  $data['view_to_load'] = 'disposal/disposal_bidder_v';
	  $this->load->view( $data['view_to_load'], $data);
		break;



	case 'view_bidders_list':
	# code...
	#check user access
 	#check_user_access($this, 'view_bidders_list', 'redirect');

	 $bid_id = $this->uri->segment(4);
	 $procurement_ref_no = base64_decode($this->uri->segment(5));
	 $data['page_title'] = $procurement_ref_no;
	 $data['bidderslist'] = $this-> Receipts_m -> fetctpdereceipts($bid_id);
	 #print_r($data['bidderslist']); exit();
	 $data['level'] = $status;
	break;




	case 'active_procurements':

	  # check_user_access($this, 'active_procurements', 'redirect');

		$urldata = $this->uri->uri_to_assoc(4, array('m'));
		$data = assign_to_data($urldata);

	   //$var = $this->session->userdata;
		 if(!isset($data['editbeb']) || empty($data['editbeb']))	{
			$this->session->unset_userdata('bebid');
			#exit("Interesting .... ");
		  }

		# Pick all assigned data
		$data = assign_to_data($urldata);
		$data = add_msg_if_any($this, $data);
		$data = handle_redirected_msgs($this, $data);
	    $data['active_procurements'] = $this-> Proc_m -> fetch_active_procurement_list($idx=0,$data);

		if(isset($data['editbeb']) && !empty($data['editbeb']))
		{
			$bebid = mysql_real_escape_string(base64_decode($data['editbeb']));
			$this->session->set_userdata(array('bebid'=>$bebid));

	  	$query = $this->Query_reader->get_query_by_code('search_procurement_by_beb', array('SEARCHSTRING' => ' WHERE  1=1  and 	bestevaluatedbidder.id = '.$bebid.' ','limittext' => ''));

	  	#print_r($query); exit();
			$result = $this->db->query($query)->result_array();
	  	#fetch Procurement Ref No :: --
  		$data['procurement_refno'] = $result[0]['procurement_ref_no'];
  		#print_r($data['procurement_refno']); exit();

		}



	  $data['page_title'] = 'Select procurement ';
    $data['level'] = $status;
 		$data['current_menu'] = 'select_beb';
 		$data['view_to_load'] = 'bids/overview3';
 		// $data['view_to_load'] = 'bids/publish_bidder_v';
		$data['view_data']['form_title'] = $data['page_title'];
		$this->load->view('dashboard_v', $data);
	break;


	  default:
		# code...
		break;
       }


	}




	 #Manage PDES
	function view_published_bids()
	{
		//access_control($this, array('admin'));

		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		# Pick all assigned data
		$data = assign_to_data($urldata);

		# FETCH ACTIVE AND INACTIVE PDES
		 $data  = $this-> pde_m -> fetch_pdes('in',$data);
         // = $this-> pde_m -> fetch_pdes('out',$data);
        // $this->load->view('pde/manage_pda_v',$data);

		#Get the paginated list of users
		 //$query = $this->Query_reader->get_query_by_code('fetchpdes', array('STATUS' => $status ,'ORDERBY' => 'ORDER BY   pdeid','searchstring'=>'','LIMITTEXT'=>'LIMIT 10') );

		$data = add_msg_if_any($this, $data);

		$data = handle_redirected_msgs($this, $data);

		$data['page_title'] = 'Manage PDE\'s';
		$data['current_menu'] = 'manage_pdes';
		$data['view_to_load'] = 'pde/manage_pda_v';
		$data['view_data']['form_title'] = $data['page_title'];

		$this->load->view('dashboard_v', $data);


	}

		#manage Receipts
	function manage_receipts(){

		$urldata = $this->uri->uri_to_assoc(3, array('m'));
		# Pick all assigned data
		$data = assign_to_data($urldata);

		$data = add_msg_if_any($this, $data);
		$data = handle_redirected_msgs($this, $data);

		$data['page_title'] = 'Manage Receipts';
		$data['current_menu'] = 'manage_bid_receipts';
		$data['view_to_load'] = 'receipts/manage_receipts_v';
		$data['view_data']['form_title'] = $data['page_title'];

		$this->load->view('dashboard_v', $data);
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
				print_r("Select Best Evaluated Bidder");
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
				$result = $this-> Receipts_m -> publishbeb($post);
				print_r($result);
				break;

			}




	}

    function ajax_fetch_procurement_details()
	{
	 $post = $_POST;
	//	print_r($post); exit();
     $procurementrefno = $post['procurementrefno'];
	 $data['procurementdetails'] = $this-> Proc_m ->fetch_annual_procurement_plan($procurementrefno);
	 $data['datearea'] = 'procurementdetails';
	 $this->load->view('bids/bids_addons', $data);
	// print_r($data['procurementdetails']);
	}

	function loadprocurementrefno()
	{
	if((!empty( $_POST['proc_id'])) &&( $_POST['proc_id'] > 0 ))
	{

		 $data = array('ID' => $_POST['proc_id'] );
		//create_procurementref_no
		 $query = $this->Query_reader->get_query_by_code('create_procurementref_no',  $data);
		# print_r($query); exit();
		 $result = $this->db->query($query)->result_array();
		 if(!empty($result)){
		 print_r($result[0]['concateddate']);
		#print_r($_POST);
		}
		else
		{
		echo "0";
		}

	}
	}




}
?>
