<?php 

#**************************************************************************************
# All service provider actions directed from this controller
#**************************************************************************************

class Providers extends CI_Controller {
	
	# Constructor
	function Providers() 
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

		##END
		date_default_timezone_set(SYS_TIMEZONE);
		$data = array();		
		access_control($this);
	}
	
	
	
	# Default to view all providers
	function index()
	{
		#Go view all providers
		redirect('providers/view_providers');
	}
	
	
	# View providers
	function view_providers()
	{
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'p'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
								
	}	
	
	
	#Function to load provider form
	function load_provider_form()
	{
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);

	}
	
	function save_provider()
	{
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 's'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
			
		$data = add_msg_if_any($this, $data);;
	}	
	
	
	#Function to delete a provider's details
	function delete_provider()
	{
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 's'));
		
		# Pick all assigned data
		$data = assign_to_data($urldata);
	}
	
	
	#Function to suspend a provider
	function suspend_provider()
	{
		 $urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		$pde =  $this->session->userdata('pdeid');
		$userid =  $this->session->userdata('userid');		 
	     
		$data['countrylist'] = $this-> Proc_m -> fetchcountries(); 
		$data['ropproviders'] =   $this-> Remoteapi_m -> fetchproviders_list();

        //print_array($data['ropproviders']);
		$data['page_title'] = 'Suspend Provider ';
		$data['current_menu'] = 'suspend_provider';
		$data['view_to_load'] = 'providers/suspend_provider_v';
		$data['view_data']['form_title'] = $data['page_title'];         
		$this->load->view('dashboard_v', $data);
	}
	function unconfirmed(){
	  #form type
   // $data['unconfirmed'] = $this-> remotely ->un_confirmed_providers();
    $data['formtype'] = 'edit';
    $data['page_title'] = 'Un Confirmed Providers ';
    $data['current_menu'] = 'manage_pdes';
    $data['view_to_load'] = 'providers/uncomfirmed_prov_v';
    $this->load->view('dashboard_v', $data);
	}
	 function save_suspended_provider(){
		//print_r("Reached"); exit();
			$segment = $this->uri->segment(3);		 
		$post = $_POST;
         #print_r($post); exit();
		switch ($segment) {
			case 'update':
				# code...
			 $id = $this->uri->segment(4);
			 $result = $this-> Remoteapi_m -> update_suspesion($post,$id);
			 print_r($result);
				break;
			 case 'insert':
			  $saved_disposal = $this -> Remoteapi_m -> save_suspended_provider($post);
			  print_r($saved_disposal);
				break;
			
			default:
				# code...
				break;
		}
	}
	
	function manage_suspended_providers(){
        #echo "Manage Suspended Providers";
        check_user_access($this, 'manage_suspended_providers', 'redirect');
		$start= 0;
		$range = 100000; 
		 $data['suspended_proviers'] = $this -> Remoteapi_m -> suspended_providers($start,$range);
		# print_r($data['suspended_proviers']); exit();
		 $data['page_title'] = 'Suspended Providers ';
		$data['current_menu'] = 'manage_suspended_providers';
		$data['view_to_load'] = 'providers/manage_suspended_providers_v';
		$data['view_data']['form_title'] = $data['page_title'];         
		$this->load->view('dashboard_v', $data);
		 
	}
	function load_edit_provider_form()
	{
	check_user_access($this, 'edit_provider', 'redirect');
		# Get the passed details into the url data array if any
		$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		# Pick all assigned data
		$data = assign_to_data($urldata);

		$data = add_msg_if_any($this, $data);		
		$data = handle_redirected_msgs($this, $data);
		$suspendid= decryptValue($this->uri->segment(3));
	#print_r($suspendid); exit();
		$data['suspension_details'] = $this-> Remoteapi_m -> fetch_suspended_provider($suspendid);
		#print_r($data['suspension_details'] ); exit();	
		#print_r($result);
		$data['formtype'] = "edit";
		#$data['active_procurements'] = $this-> Proc_m -> fetch_active_procurement_list2($idx=0); 
		$data['page_title'] = 'Suspend Provider ';
		$data['current_menu'] = 'suspend_provider';
		$data['view_to_load'] = 'providers/suspend_provider_v';
		$data['view_data']['form_title'] = $data['page_title'];
		$data['ropproviders'] =   $this-> Remoteapi_m -> fetchproviders();
        $data['countrylist'] = $this-> Proc_m -> fetchcountries(); 
		
		$this->load->view('dashboard_v', $data);
	}
	function delproviders_ajax()
	{
	$urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));
		# Pick all assigned data
		$data = assign_to_data($urldata);
		print_r($data);
	check_user_access($this, 'del_provider', 'redirect');
	
		//check_user_access($this, 'del_receipts', 'redirect');	
		$deltype =  $this->uri->segment(3);  
	    $receiptid =  $this->uri->segment(4);  
	    $result  = $this-> Remoteapi_m -> remove_restore_provider($deltype,$data['archive']);        
	    echo  $result;   
	}
	
	
}
?>