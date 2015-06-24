<?php
ob_start();

#**************************************************************************************
# All contract functions are passed through this controller
#**************************************************************************************


class Contracts extends CI_Controller {

	# Constructor
	function Contracts() 
	{	
		parent::__construct();
		$this->load->model('users_m','user1');
		$this->load->model('currency_m');
		
		access_control($this);
	}
	
	# Default to view all contracts
	function index()
	{
		#Go view all bids
		redirect('contracts/view_contracts');
	}

	# load the contract award form
	function contract_award_form()
	{
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'b'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		$app_select_str = '';
		
		if($this->session->userdata('isadmin') == 'N')
		{
			$userdetails = $this->db->get_where('users', array('userid'=>$this->session->userdata('userid')))->result_array(); 
			$app_select_str .= ' AND PP.pde_id ="'. $userdetails[0]['pde'] .'"';
		}	
		
		
		#user is editing
		if(!empty($data['i']))
		{
			$contract_id = decryptValue($data['i']);
			$data['formdata'] = $this->Query_reader->get_row_as_array('search_table', array('table'=>'contracts', 'limittext'=>'', 'orderby'=>'id', 'searchstring'=>' id="'. $contract_id .'" AND isactive="Y"'));
			            
            #get procurement plan details
            if(!empty($data['formdata']['procurement_ref_id']))
            {                           
                $data['formdata']['procurement_details'] = $this->Query_reader->get_row_as_array('procurement_plan_details', array('searchstring'=>' procurement_plan_entries.id="'. $data['formdata']['procurement_ref_id'] .'"', 'limittext'=>'', 'orderby'=>' procurement_plan_entries.dateadded '));
				
				$app_select_str .= ' AND PPE.id ="'. $data['formdata']['procurement_ref_id'] .'" ';
				$data['formdata']['prefid'] = $data['formdata']['procurement_ref_id'];
				
				$data['procurement_plan_entries'][0]['id'] = $data['formdata']['procurement_ref_id'];
				$data['procurement_plan_entries'][0]['procurement_ref_no'] = $data['formdata']['procurement_details']['procurement_ref_no'];
            }
			
			#Get the contract prices
			$data['formdata']['contract_amount'] = $this->db->query($this->Query_reader->get_query_by_code('contract_price_detail', array('searchstring'=>' AND CP.contract_id="'. $contract_id .'"')))->result_array();
		}
		else
		{
			$data['procurement_plan_entries'] = $this->db->query($this->Query_reader->get_query_by_code('uncontracted_procurements', array('searchstring'=>$app_select_str, 'limittext'=>'', 'orderby'=>' PPE.procurement_ref_no ' )))->result_array();
		}
				
		
		#exit($this->db->last_query());
		
		$data['currencies'] = $this->db->get_where('currencies', array('isactive'=>'Y'))->result_array();
		
		$data['page_title'] = (!empty($data['i'])? 'Edit contract details' : 'Award contract');
		$data['current_menu'] = 'award_contract';
		$data['view_to_load'] = 'contracts/contract_award_form';
		$data['form_title'] = $data['page_title'];

		$this->load->view('dashboard_v', $data);
	}
	
	
	#Function to load the contract completion form
	function contract_completion_form()
	{		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i', 'b', 'c'));
		
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
		
				
		if(!empty($data['c']))
		{
			$contract_id = decryptValue($data['c']);
			$data['contract_details'] = $this->Query_reader->get_row_as_array('search_table', array('table'=>'contracts', 'limittext'=>'', 'orderby'=>'id', 'searchstring'=>' id="'. $contract_id .'" AND isactive="Y"'));
			
			#get the service provider
			$data['contract_details']['provider'] = $this->get_provider_names($data['contract_details']['procurement_ref_id']);
			
			$data['formdata'] = $data['contract_details'];
			            
            #get procurement plan details
            if(!empty($data['contract_details']['procurement_ref_id']))
            {                           
                $data['procurement_details'] = $this->Query_reader->get_row_as_array('procurement_plan_details', array('searchstring'=> ' procurement_plan_entries.id="'. $data['contract_details']['procurement_ref_id'] .'"', 'limittext'=>'', 'orderby'=>' procurement_plan_entries.dateadded ' ));
            }
		}
				
		$data['currencies'] = $this->db->get_where('currencies', array('isactive'=>'Y'))->result_array();
		
		$data['page_title'] = 'Contract completion details';
		$data['current_menu'] = 'view_contracts';
		$data['view_to_load'] = 'contracts/contract_completion_form';
		$data['view_data']['form_title'] = $data['page_title'];
		
		$this->load->view('dashboard_v', $data);

	}
	
	
	private function get_provider_names($procurement_entry_id)
	{
		$provider_info = $this->Query_reader->get_row_as_array('get_IFB_BEB', array('searchstring'=> ' AND BI.procurement_id="'.
						$procurement_entry_id .'" AND beb="Y"'));	
					
		$provider_name = (!empty($provider_info['providerid'])? $provider_info['providername'] : '');
				
		if(!empty($provider_info) && empty($provider_info['providerid'])):
			$jv_info = $this->db->query('SELECT * FROM joint_venture WHERE jv = "'. $provider_info['joint_venture'] .'"')->result_array();
			
			if(!empty($jv_info[0]['providers'])):
				$providers = $this->db->query('SELECT * FROM providers WHERE providerid IN ('. rtrim($jv_info[0]['providers'], ',') .')')->result_array();
				
				foreach($providers as $provider):
					$provider_name .= (!empty($provider_name)? ', ' : '') . $provider['providernames'];
				endforeach;
									
			endif;
		endif;
		
		return $provider_name;
	}
	
	
	#Complete contract
	function complete_contract()
	{
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 's', 'i', 'c'));
				
		# Pick all assigned data
		$data = assign_to_data($urldata);
			
		$data = add_msg_if_any($this, $data);
		
		if($this->input->post('save'))
		{
			$required_fields = array('final_contract_value', 'final_contract_value_currency', 'total_actual_payments', 'total_actual_payments_currency', 'actual_completion_date', 'performance_rating', 'contract_manager');
			
			$data['formdata'] = $_POST;
			$_POST = clean_form_data($_POST);
			$validation_results = validate_form('', $_POST, $required_fields);

			#Only proceed if the validation for required fields passes
			if($validation_results['bool'])
			{
				/*Determine problem with query
				echo $this->db->_error_message();
				*/
				
				$_POST['final_contract_value'] = removeCommas($_POST['final_contract_value']);
				$_POST['total_actual_payments'] = removeCommas($_POST['total_actual_payments']);
				
				#format data keys
				foreach($_POST as $key => $value)
					$_POST[str_replace('_', '', $key)] = $value;
				
				$_POST = array_merge($_POST, array('id'=>decryptValue($data['c']), 'completionauthor' => $this->session->userdata('userid')));
				$result = $this->db->query($this->Query_reader->get_query_by_code('complete_contract', $_POST));
				
				#exit($this->db->last_query());	

				#Format and send the errors
				if(!empty($result) && $result){
					$this->session->set_userdata('usave', "The contract has been marked as complete");
					redirect("contracts/manage_contracts/m/usave");
				}
				else if(empty($data['msg']))
				{
					$data['msg'] = "ERROR: The contract could not be completed or was not completed correctly.";
				}

			}
			# End validation

			if((empty($validation_results['bool']) || (!empty($validation_results['bool']) && !$validation_results['bool'])) && empty($data['msg']) )
            {
                $data['msg'] = "WARNING: The highlighted fields are required.";
            }
			
            $data['requiredfields'] = $validation_results['requiredfields'];
            $data['contractdetails'] = $_POST;
		}
		
		if(!empty($data['c']))
		{
			$contract_id = decryptValue($data['c']);
			$data['contract_details'] = $this->Query_reader->get_row_as_array('search_table', array('table'=>'contracts', 'limittext'=>'', 'orderby'=>'id', 'searchstring'=>' id="'. $contract_id .'" AND isactive="Y"'));
			            
            #get procurement plan details
            if(!empty($data['contract_details']['procurement_ref_id']))
            {                           
                $data['procurement_details'] = $this->Query_reader->get_row_as_array('procurement_plan_details', array('searchstring'=> ' procurement_plan_entries.id="'. $data['contract_details']['procurement_ref_id'] .'"', 'limittext'=>'', 'orderby'=>' procurement_plan_entries.dateadded ' ));
				
				#get the service provider
				$data['contract_details']['provider'] = $this->get_provider_names($data['contract_details']['procurement_ref_id']);
            }
		}
		
		$data['page_title'] = 'Contract completion details';
		$data['current_menu'] = 'view_contracts';
		$data['view_to_load'] = 'contracts/contract_completion_form';
		$data['view_data']['form_title'] = $data['page_title'];
		
		$this->load->view('dashboard_v', $data);
		
	}
	

	#Save awarded contract
	function award_contract()
	{
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 's', 'i'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
			
		$data = add_msg_if_any($this, $data);
		
		if($this->input->post('save'))
		{
			$required_fields = array('date_signed', 'commencement_date', 'completion_date');
			
			$data['formdata'] = $_POST;
			if(empty($_POST['contract_amount']))
			{
				$validation_results['bool'] = FALSE;
				$validation_results['requiredfields'] = 'contract_amount';
			}
			else
			{
				$_POST = clean_form_data($_POST);
				$validation_results = validate_form('', $_POST, $required_fields);
			}

			#Only proceed if the validation for required fields passes
			if($validation_results['bool'])
			{
				#Check if a contract with a similar name already exists
				$contract_name_query = $this->Query_reader->get_query_by_code('search_table', array('table'=>'contracts', 'limittext'=>'', 'orderby'=>'id', 'searchstring'=>' procurement_ref_id="'. $_POST['prefid'].'" AND isactive="Y"'));;
				$contract_name_query_result = $this->db->query($contract_name_query);
				
								
				if($contract_name_query_result->num_rows() < 1){
					$_POST = array_merge($_POST, array('author' => $this->session->userdata('userid')));
					$result = $this->db->query($this->Query_reader->get_query_by_code('award_contract', $_POST));	
										
					if($result)
					{
						$contract_id = $this->db->insert_id();
						
						#Add the contract prices
						foreach($_POST['contract_amount'] as $contract_amount)
						{
							$amount_values = explode('__', $contract_amount);
							$this->db->insert('contract_prices', array('contract_id'=> $contract_id, 
																		'amount'=>removeCommas($amount_values[0]),
																		'xrate'=>removeCommas($amount_values[2]),
																		'currency_id'=>removeCommas($amount_values[1]),
																		'author'=> $this->session->userdata('userid')));
						}
					}
				}
				else
				{
					$data['msg'] = "ERROR: A contract has already been awarded for the selected procurement ref number.";
				}

				#exit($this->db->_error_message());
				
				#Format and send the errors
				if(!empty($result) && $result){
					$this->session->set_userdata('usave', "The contract data has been successfully saved.");
					redirect("contracts/manage_contracts/m/usave");
				}
				else if(empty($data['msg']))
				{
					$data['msg'] = "ERROR: The contract could not be saved or was not saved correctly.";
				}

			}
			# End validation

			if((empty($validation_results['bool']) || (!empty($validation_results['bool']) && !$validation_results['bool'])) && empty($data['msg']) )
            {
                $data['msg'] = "WARNING: The highlighted fields are required.";
            }
			
            $data['requiredfields'] = $validation_results['requiredfields'];
            $data['contractdetails'] = $_POST;
		}
		
		$app_select_str = '';
		
		if($this->session->userdata('isadmin') == 'N')
		{
			$userdetails = $this->db->get_where('users', array('userid'=>$this->session->userdata('userid')))->result_array(); 
			$app_select_str .= ' AND PP.pde_id ="'. $userdetails[0]['pde'] .'"';
		}
		
		$data['procurement_plan_entries'] = $this->db->query($this->Query_reader->get_query_by_code('uncontracted_procurements', array('searchstring'=>$app_select_str, 'limittext'=>'', 'orderby'=>' PPE.procurement_ref_no ' )))->result_array();
		
		$data['currencies'] = $this->db->get_where('currencies', array('isactive'=>'Y'))->result_array();

		$data['page_title'] = (!empty($data['i'])? 'Edit contract details' : 'Award contract');
		$data['current_menu'] = 'award_contract';
		$data['view_to_load'] = 'contracts/contract_award_form';
		$data['form_title'] = $data['page_title'];
		
		$this->load->view('dashboard_v', $data);
		
	}


	function manage_contracts()
	{
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
		
		#Get the paginated list of users
		$data = paginate_list($this, $data, 'get_published_contracts', array('orderby'=>'C.date_signed DESC', 'searchstring'=>' AND C.isactive="Y"' . $search_str));
		
		#exit($this->db->last_query());
		
		$data = handle_redirected_msgs($this, $data);
		$data = add_msg_if_any($this, $data);
		
		$data['page_title'] = 'Manage contracts';
		$data['current_menu'] = 'view_contracts';
		$data['view_to_load'] = 'contracts/manage_contracts';
		$data['search_url'] = 'contracts/search_contracts';
		$data['form_title'] = $data['page_title'];
        
		$this->load->view('dashboard_v', $data);
	}


	#Search contracts
	function search_contracts()
	{
		#check_user_access($this, 'view_bid_invitations', 'redirect');
		
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'p'));
		
		# Pick all assigned data
		$data = @assign_to_data($urldata);
		
		$search_string = '';
		
		if($this->session->userdata('isadmin') == 'N')
		{
			$userdata = $this->db->get_where('users', array('userid'=>$this->session->userdata('userid')))->result_array();
			$search_string = ' AND PP.pde_id="'. $userdata[0]['pde'] .'"';
		}
		
		if($this->input->post('searchQuery'))
		{
			$_POST = clean_form_data($_POST);
			$_POST['searchQuery'] = trim($_POST['searchQuery']);
			
			$search_string .= ' AND (BI.procurement_ref_no like "%'. $_POST['searchQuery'] .
							 '%" OR PPE.subject_of_procurement like "%' . $_POST['searchQuery'] . '%" '.
							 'OR pdes.pdename like "%' . $_POST['searchQuery'] . '%" '.
							 'OR users.firstname like "%'. $_POST['searchQuery'] .'%" OR '.
							 'users.lastname like "%' . $_POST['searchQuery'] . '%") ';
			
			$data = paginate_list($this, $data, 'get_published_contracts', array('orderby'=>'C.date_signed DESC', 'searchstring'=>' AND C.isactive="Y"' . $search_string));
		}
		else
		{
			$data = paginate_list($this, $data, 'get_published_contracts', array('orderby'=>'C.date_signed DESC', 'searchstring'=>' AND C.isactive="Y"' . $search_string));
		}
		
		$data['area'] = 'signed_contracts';
		
		$this->load->view('includes/add_ons', $data);
								
	}

	
	#Function to delete a contract
	function delete_contract()
	{
		#check user access
		check_user_access($this, 'delete_contract', 'redirect');
				
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 's', 'i', 'b'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
		
		if(!empty($data['i'])){
			$result = $this->db->query($this->Query_reader->get_query_by_code('deactivate_item', array('item'=>'contracts', 'id'=>decryptValue($data['i'])) ));
		}
		
		if(!empty($result) && $result){
			#deactivate the contract prices as well
			$this->db->update('contract_prices', array('isactive'=>'Y'), array('contract_id'=>decryptValue($data['i'])));
			
			$this->session->set_userdata('dbid', "The contract details have been successfully deleted.");
		}
		else if(empty($data['msg']))
		{
			$this->session->set_userdata('dbid', "ERROR: The contract details could not be deleted or were not deleted correctly.");
		}
		
		redirect(base_url()."contracts/manage_contracts/m/dbid/");
	}


}


?>