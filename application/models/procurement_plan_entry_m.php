<?php
class Procurement_plan_entry_m extends MY_Model
{
    public $_tablename='procurement_plan_entries';
    public $_primary_key='id';
    public $validate_plan=array
    (

        array
        (
            'field'   => 'subj_of_procurement',
            'label'   => 'Subject of procurement',
            'rules'   => 'required'
        ),

        array
        (
            'field'   => 'procurement_ref_no',
            'label'   => 'Procurement reference number',
            'rules'   => 'required'
        ),

        array
        (
            'field'   => 'procurement_type',
            'label'   => 'Procurement type',
            'rules'   => 'required'
        ),

        array
        (
            'field'   => 'procurement_method',
            'label'   => 'Procurement Method',
            'rules'   => 'required'
        ),
        array
        (
            'field'   => 'pde_department',
            'label'   => 'PDE department',
            'rules'   => 'required'
        ),
        array
        (
            'field'   => 'source_funding',
            'label'   => 'Source funding',
            'rules'   => 'required'
        ),

        array
        (
            'field'   => 'estimated_amount',
            'label'   => 'Estimated amount',
            'rules'   => 'required|numeric'
        ),

        array
        (
            'field'   => 'currency',
            'label'   => 'Currency',
            'rules'   => 'required'
        ),
        array
        (
            'field'   => 'pre_bid_events_date',
            'label'   => 'Pre-bid events date',
            'rules'   => 'required'
        ),
        array
        (
            'field'   => 'pre_bid_events_date_duration',
            'label'   => 'Duration for pre-bid events',
            'rules'   => 'required|numeric'
        ),




        //===========================
        array
        (
            'field'   => 'cc_approval_date',
            'label'   => 'Contracts committee approval date',
            'rules'   => 'required'
        ),

        array
        (
            'field'   => 'cc_approval_date_duration',
            'label'   => 'Contracts committee approval duration',
            'rules'   => 'required|numeric'
        ),

        array
        (
            'field'   => 'pre_qualification_notice_date',
            'label'   => 'Pre qualification date',
            'rules'   => 'required'
        ),
        array
        (
            'field'   => 'pre_qualification_notice_date_duration',
            'label'   => 'Pre qualification date duration',
            'rules'   => 'required|numeric'
        ),
        array
        (
            'field'   => 'proposal_submission_date',
            'label'   => 'Proposal submission',
            'rules'   => 'required'
        ),
        array
        (
            'field'   => 'proposal_submission_date_duration',
            'label'   => 'Proposal submission duration',
            'rules'   => 'required|numeric'
        ),
        array
        (
            'field'   => 'cc_shortlist_approval',
            'label'   => 'Contract committee shortlist approval date',
            'rules'   => 'required'
        ),

        array
        (
            'field'   => 'cc_shortlist_approval_duration',
            'label'   => 'Contract committee shortlist approval duration',
            'rules'   => 'required'
        ),

        //=============================================
        array
        (
            'field'   => 'bid_issue_date',
            'label'   => 'Bid issue date',
            'rules'   => 'required'
        ),

        array
        (
            'field'   => 'bid_issue_date_duration',
            'label'   => 'Duration of bid issuing',
            'rules'   => 'required|numeric'
        ),

        array
        (
            'field'   => 'bid_submission_date',
            'label'   => 'Bid submission date',
            'rules'   => 'required'
        ),
        array
        (
            'field'   => 'bid_submission_date_duration',
            'label'   => 'Duration of bid submission',
            'rules'   => 'required|numeric'
        ),
        array
        (
            'field'   => 'necessary_approval_date',
            'label'   => 'Date of necessary approval',
            'rules'   => 'required'
        ),
        array
        (
            'field'   => 'necessary_approval_date_duration',
            'label'   => 'Duration of necessary approval',
            'rules'   => 'required|numeric'
        ),
        array
        (
            'field'   => 'contract_award_date',
            'label'   => 'Contract award date',
            'rules'   => 'required'
        ),




        //===========================
        array
        (
            'field'   => 'contract_award_date_duration',
            'label'   => 'Duration of contract award',
            'rules'   => 'required|numeric'
        ),
        array
        (
            'field'   => 'best_evaluated_bidder_date',
            'label'   => 'Best evaluated bidder date',
            'rules'   => 'required'
        ),

        array
        (
            'field'   => 'best_evaluated_bidder_date_duration',
            'label'   => 'Duration for best evaluated bidder',
            'rules'   => 'required|numeric'
        ),

        array
        (
            'field'   => 'contract_signature_date',
            'label'   => 'Contract signature date',
            'rules'   => 'required'
        ),
        array
        (
            'field'   => 'contract_signature_date_duration',
            'label'   => 'Duration for contract signature',
            'rules'   => 'required|numeric'
        ),
        array
        (
            'field'   => 'cc_evaluation_approval',
            'label'   => 'Contracts committee evaluation approval date',
            'rules'   => 'required'
        ),
        array
        (
            'field'   => 'cc_evaluation_approval_duration',
            'label'   => 'Contracts evaluation approval duration',
            'rules'   => 'required|numeric'
        ),
        array
        (
            'field'   => 'negotiation_date',
            'label'   => 'Negotiation date',
            'rules'   => 'required'
        ),

        array
        (
            'field'   => 'negotiation_date_duration',
            'label'   => 'Negotiation duration',
            'rules'   => 'required'
        ),


        array
        (
            'field'   => 'negotiation_approval_date',
            'label'   => 'Negotiation approval date',
            'rules'   => 'required'
        ),

        array
        (
            'field'   => 'negotiation_approval_date_duration',
            'label'   => 'Duration fpr approval of negotiations',
            'rules'   => 'required|numeric'
        ),

        array
        (
            'field'   => 'advanced_payment_date',
            'label'   => 'Date for advanced payment',
            'rules'   => 'required'
        ),
        array
        (
            'field'   => 'advanced_payment_date_duration',
            'label'   => 'Duration for cadvanced',
            'rules'   => 'required|numeric'
        ),
        array
        (
            'field'   => 'substantial_completion_date',
            'label'   => 'Substantial completion date',
            'rules'   => 'required'
        ),
        array
        (
            'field'   => 'substantial_completion_date_duration',
            'label'   => 'substantial completion durstion',
            'rules'   => 'required|numeric'
        ),
        array
        (
            'field'   => 'final_acceptance',
            'label'   => 'Final acceptance date',
            'rules'   => 'required'
        ),

        array
        (
            'field'   => 'final_acceptance_duration',
            'label'   => 'Duration for final acceptance',
            'rules'   => 'required|numeric'
        ),





    );

    //validate procurement plan form

    function __construct()
    {
        parent::__construct();

        $this->load->model('users_m');
        $this->load->model('pde_m');

    }

    //visible and trashed

    public function get_all_procurement_plans()//visible is either y or n
    {
        $query=$this->db->select()->from($this->_tablename)->order_by($this->_primary_key,'DESC')->get();

        return $query->result_array();
    }


    //get by passed parameters
    public function get_where($where)
    {
        $query=$this->db->select()->from($this->_tablename)->where($where)->order_by($this->_primary_key,'DESC')->get();

        #echo $this->db->last_query(); exit();
        return $query->result_array();
    }
	

	//get entry info
    function get_plan_entry_info($id='',$param='')
    {
        if($id=='')
        {
            return NULL;
        }
        else
        {
            $this->db->cache_on();
            $query=$this->db->select()->from($this->_tablename) ->where($this->_primary_key,$id)->get();
        }

        if($query->result_array())
        {

            foreach($query->result_array() as $row)
            {
                switch($param)
                {
                    case 'title':
                        $result=$row['subject_of_procurement'];
                        break;

                    case 'subject_of_procurement':
                        $result=$row['subject_of_procurement'];
                        break;

                    case 'procurement_type_id':
                        $result=$row['procurement_type'];
                        break;
                    case 'procurement_type':
                        $result=get_procurement_type_info_by_id($row['procurement_type'],'title');
                        break;

                    case 'procurement_method_id':
                        $result=$row['procurement_method'];
                        break;

                    case 'procurement_method':
                        $result=get_procurement_method_info_by_id($row['procurement_method'],'title');
                        break;

                    case 'department_id':
                        $result=$row['pde_department'];
                        break;

                    case 'department':
                        $result=get_pde_department_info_by_id($row['pde_department'],'title');
                        break;

                    case 'funding_source_id':
                        $result=$row['funding_source'];
                        break;

                    case 'funding_source':
                        $result=get_source_funding_info_by_id($row['funding_source'],'title');
                        break;

                    case 'source_funding_id':
                        $result=$row['funding_source'];
                        break;

                    case 'source_funding':
                        $result=get_source_funding_info_by_id($row['funding_source'],'title');
                        break;

                    case 'procurement_ref_no':
                        $result=$row['procurement_ref_no'];
                        break;
                    case 'estimated_amount':
                        $result=$row['estimated_amount'];
                        break;
                    case 'currency':
                        $result=$result=get_currency_info_by_id($row['currency'],'abbrv');
                        break;
                    case 'currency_id':
                        $result=$result=$row['currency'];
                        break;

                    case 'pre_bid_events_date':
                        $result=$row['pre_bid_events_date'];
                        break;

                    case 'pre_bid_events_duration':
                        $result=$row['pre_bid_events_duration'];
                        break;

                    case 'contracts_committee_approval_date':
                        $result=$row['contracts_committee_approval_date'];
                        break;

                    case 'contracts_committee_approval_date_duration':
                        $result=$row['contracts_committee_approval_date_duration'];
                        break;

                    case 'publication_of_pre_qualification_date':
                        $result=$row['publication_of_pre_qualification_date'];
                        break;

                    case 'publication_of_pre_qualification_date_duration':
                        $result=$row['publication_of_pre_qualification_date_duration'];
                        break;

                    case 'proposal_submission_date':
                        $result=$row['proposal_submission_date'];
                        break;

                    case 'proposal_submission_date_duration':
                        $result=$row['proposal_submission_date_duration'];
                        break;

                    case 'contracts_committee_approval_of_shortlist_date':
                        $result=$row['contracts_committee_approval_of_shortlist_date'];
                        break;

                    case 'contracts_committee_approval_of_shortlist_date_duration':
                        $result=$row['contracts_committee_approval_of_shortlist_date_duration'];
                        break;

                    case 'bid_issue_date_duration':
                        $result=$row['bid_issue_date_duration'];
                        break;

                    case 'bid_submission_opening_date':
                        $result=$row['bid_submission_opening_date'];
                        break;

                    case 'bid_submission_opening_date_duration':
                        $result=$row['bid_submission_opening_date_duration'];
                        break;

                    case 'bid_issue_date':
                        $result=$row['bid_issue_date'];
                        break;

                    case 'secure_necessary_approval_date':
                        $result=$row['secure_necessary_approval_date'];
                        break;

                    case 'secure_necessary_approval_date_duration':
                        $result=$row['secure_necessary_approval_date_duration'];
                        break;

                    case 'contract_award':
                        $result=$row['contract_award'];
                        break;

                    case 'contract_award_duration':
                        $result=$row['contract_award_duration'];
                        break;


                    case 'best_evaluated_bidder_date':
                        $result=$row['best_evaluated_bidder_date'];
                        break;

                    case 'best_evaluated_bidder_date_duration':
                        $result=$row['best_evaluated_bidder_date_duration'];
                        break;

                    case 'contract_sign_date':
                    $result=$row['bid_issue_date'];
                    break;

                    case 'contract_sign_date_duration':
                        $result=$row['contract_sign_duration'];
                        break;
                    case 'cc_approval_of_evaluation_report':
                        $result=$row['cc_approval_of_evaluation_report'];
                        break;
                    case 'cc_approval_of_evaluation_report_duration':
                        $result=$row['cc_approval_of_evaluation_report_duration'];
                        break;
                    case 'negotiation_date':
                        $result=$row['negotiation_date'];
                        break;
                    case 'negotiation_date_duration':
                        $result=$row['negotiation_date_duration'];
                        break;
                    case 'negotiation_approval_date':
                        $result=$row['negotiation_approval_date'];
                        break;
                    case 'negotiation_approval_date_duration':
                        $result=$row['negotiation_approval_date_duration'];
                        break;

                    case 'advanced_payment_date':
                        $result=$row['advanced_payment_date'];
                        break;
                    case 'advanced_payment_date_duration':
                        $result=$row['advanced_payment_date_duration'];
                        break;
                    case 'mobilise_advance_payment':
                        $result=$row['mobilise_advance_payment'];
                        break;
                    case 'mobilise_advance_payment_duration':
                        $result=$row['mobilise_advance_payment_duration'];
                        break;
                    case 'substantial_completion':
                        $result=$row['substantial_completion'];
                        break;
                    case 'substantial_completion_duration':
                        $result=$row['substantial_completion_duration'];
                        break;

                    case 'final_acceptance':
                        $result=$row['final_acceptance'];
                        break;

                    case 'final_acceptance_duration':
                        $result=$row['final_acceptance_duration'];
                        break;



                    case 'procurement_plan_id':
                        $result=$row['procurement_plan_id'];
                        break;

                    case 'procurement_plan':
                        $result=get_procurement_plan_info($row['procurement_plan_id'],'title');
                        break;
                    case 'pde_id':
                        $result=get_procurement_plan_info($row['procurement_plan_id'],'pde_id');
                        break;
                    case 'pde':
                        $result=get_procurement_plan_info($row['procurement_plan_id'],'pde');
                        break;

                    case 'author_id':
                        $result=$row['author'];
                        break;
                    case 'updated_by':
                        $result=$row['updated_by'];
                        break;

                    case 'author':
                        $result=get_user_info($row['author'],'fullname');
                        break;
                    case 'isactive':
                        $result=$row['active'];
                        break;
                    case 'dateadded':
                        $result=$row['dateadded'];
                        break;
                    default:
                        $result=$query->result_array();
                }
            }

            return $result;
        }
        else
        {
            return NULL;
        }
    }
	

    public function get_paginated($num=20,$start)
    {
        //echo $this->$_primary_key.'foo';
        //build query
        $q=$this->db->select()->from($this->_tablename)->limit($num,$start)->where('trash','n')->order_by($this->_primary_key,'DESC')->get();
        //echo $this->db->last_query();

        //return result
        return $q->result_array();

    }

    //get paginated
    public function get_paginated_by_criteria($num=20,$start,$criteria)
    {
        //build query
        $q=$this->db->select()->from($this->_tablename)->limit($num,$start)->where($criteria)->order_by($this->_primary_key,'DESC')->get();
     #   echo $this->db->last_query();
       # exit();

        //return result
        return $q->result_array();

    }
    //create
    public function create($data)
    {
        $this->db->insert($this->_tablename,$data);
        //echo $this->db->last_query();
        return $this->db->insert_id();

    }
	
	//create bulk
    public function create_bulk($rows)
    {
		$query = 'INSERT IGNORE INTO procurement_plan_entries '.
				 '(subject_of_procurement, procurement_type, procurement_method, pde_department, funding_source, funder_name, procurement_ref_no, '.
				 'estimated_amount, currency, pre_bid_events_date, pre_bid_events_duration, contracts_committee_approval_date, '.
				 'contracts_committee_approval_date_duration, publication_of_pre_qualification_date, '.
				 'publication_of_pre_qualification_date_duration, proposal_submission_date, proposal_submission_date_duration, '.
				 'contracts_committee_approval_of_shortlist_date, contracts_committee_approval_of_shortlist_date_duration, '.
				 'bid_issue_date, bid_issue_date_duration, bid_submission_opening_date, bid_submission_opening_date_duration, '.
				 'secure_necessary_approval_date, secure_necessary_approval_date_duration, contract_award, contract_award_duration , '.
				 'best_evaluated_bidder_date, best_evaluated_bidder_date_duration, contract_sign_date, contract_sign_duration, '.
				 'cc_approval_of_evaluation_report, cc_approval_of_evaluation_report_duration, negotiation_date, negotiation_date_duration, '.
				 'negotiation_approval_date, negotiation_approval_date_duration, advanced_payment_date, advanced_payment_date_duration, '.
				 'mobilise_advance_payment, mobilise_advance_payment_duration, substantial_completion, substantial_completion_duration, '.
				 'final_acceptance, final_acceptance_duration, procurement_plan_id, author, solicitor_general_approval_duration, '.
				 'solicitor_general_approval_date, contract_amount_in_ugx, bid_closing_date) VALUES ';
				 
		$query_values ='"_SUBJECT_OF_PROCUREMENT_","_PROCUREMENT_TYPE_","_PROCUREMENT_METHOD_","_PDE_DEPARTMENT_","_FUNDING_SOURCE_",'.
					   '"_FUNDER_NAME_", "_PROCUREMENT_REF_NO_","_ESTIMATED_AMOUNT_","_CURRENCY_","_PRE_BID_EVENTS_DATE_",'.					   					   '"_PRE_BID_EVENTS_DURATION_","_CONTRACTS_COMMITTEE_APPROVAL_DATE_","_CONTRACTS_COMMITTEE_APPROVAL_DATE_DURATION_",'.
					   '"_PUBLICATION_OF_PRE_QUALIFICATION_DATE_","_PUBLICATION_OF_PRE_QUALIFICATION_DATE_DURATION_",'.
					   '"_PROPOSAL_SUBMISSION_DATE_","_PROPOSAL_SUBMISSION_DATE_DURATION_",'.
					   '"_CONTRACTS_COMMITTEE_APPROVAL_OF_SHORTLIST_DATE_","_CONTRACTS_COMMITTEE_APPROVAL_OF_SHORTLIST_DATE_DURATION_",'.
					   '"_BID_ISSUE_DATE_","_BID_ISSUE_DATE_DURATION_","_BID_SUBMISSION_OPENING_DATE_","_BID_SUBMISSION_OPENING_DATE_DURATION_",'.
					   '"_SECURE_NECESSARY_APPROVAL_DATE_","_SECURE_NECESSARY_APPROVAL_DATE_DURATION_","_CONTRACT_AWARD_",'.
					   '"_CONTRACT_AWARD_DURATION_","_BEST_EVALUATED_BIDDER_DATE_","_BEST_EVALUATED_BIDDER_DATE_DURATION_",'.
					   '"_CONTRACT_SIGN_DATE_","_CONTRACT_SIGN_DURATION_","_CC_APPROVAL_OF_EVALUATION_REPORT_",'.
					   '"_CC_APPROVAL_OF_EVALUATION_REPORT_DURATION_","_NEGOTIATION_DATE_","_NEGOTIATION_DATE_DURATION_",'.
					   '"_NEGOTIATION_APPROVAL_DATE_","_NEGOTIATION_APPROVAL_DATE_DURATION_","_ADVANCED_PAYMENT_DATE_",'.
					   '"_ADVANCED_PAYMENT_DATE_DURATION_","_MOBILISE_ADVANCE_PAYMENT_","_MOBILISE_ADVANCE_PAYMENT_DURATION_",'.
					   '"_SUBSTANTIAL_COMPLETION_","_SUBSTANTIAL_COMPLETION_DURATION_","_FINAL_ACCEPTANCE_",'.
					   '"_FINAL_ACCEPTANCE_DURATION_","_PROCUREMENT_PLAN_ID_","_AUTHOR_", "_SOLICITOR_GENERAL_APPROVAL_DURATION_", '.
					   '"_SOLICITOR_GENERAL_APPROVAL_DATE_", "_CONTRACT_AMOUNT_IN_UGX_", "_BID_CLOSING_DATE_"';
		
		$query_val_str = '';
		  
		 foreach($rows as $row_values)
		 {
			 $temp_query_values = $query_values;
			 			 
			 if(is_array($row_values))
			 {
				 foreach($row_values as $key => $value)
				 {
					$temp_query_values = str_replace('"_'. strtoupper($key) . '_"', '"'. $value .'"', $temp_query_values);
				 }
				 $query_val_str .= ((!empty($query_val_str))? ', ' : '') . '(' . $temp_query_values . ')';
			 }
		 }
		 
		 $final_query = $query . $query_val_str;
				 		
		if(empty($query_val_str)) return 0;
		
        return $this->db->query($final_query);
        
		//echo $this->db->last_query();
        //return $this->db->insert_id();

    }

    public function last_entered_procurement_ref_number($data)
    {
        //get the latest
        $query=$this->db->select()->from($this->_tablename)->where($data)->order_by($this->_primary_key,'DESC')->limit('1')->get();
        $str='';
        foreach($query->result_array() as $row)
        {
            $str.= $row['procurement_ref_no'];
        }

        //echo $this->db->last_query();
        return $str;
    }


    //get entry info
    function get_plan_entry_info_by_ref_num($id = '', $param = '')
    {
        if ($id == '') {
            return NULL;
        } else {
            $this->db->cache_on();
            $query = $this->db->select()->from($this->_tablename)->where('procurement_ref_no', $id)->get();
        }

        if ($query->result_array()) {

            foreach ($query->result_array() as $row) {
                switch ($param) {
                    case 'title':
                        $result = $row['subject_of_procurement'];
                        break;

                    case 'subject_of_procurement':
                        $result = $row['subject_of_procurement'];
                        break;

                    case 'procurement_type_id':
                        $result = $row['procurement_type'];
                        break;
                    case 'procurement_type':
                        $result = get_procurement_type_info_by_id($row['procurement_type'], 'title');
                        break;

                    case 'procurement_method_id':
                        $result = $row['procurement_method'];
                        break;

                    case 'procurement_method':
                        $result = get_procurement_method_info_by_id($row['procurement_method'], 'title');
                        break;

                    case 'department_id':
                        $result = $row['pde_department'];
                        break;

                    case 'department':
                        $result = get_pde_department_info_by_id($row['pde_department'], 'title');
                        break;

                    case 'funding_source_id':
                        $result = $row['funding_source'];
                        break;

                    case 'funding_source':
                        $result = get_source_funding_info_by_id($row['funding_source'], 'title');
                        break;

                    case 'source_funding_id':
                        $result = $row['funding_source'];
                        break;

                    case 'source_funding':
                        $result = get_source_funding_info_by_id($row['funding_source'], 'title');
                        break;

                    case 'id':
                        $result = $row['id'];
                        break;
                    case 'estimated_amount':
                        $result = $row['estimated_amount'];
                        break;
                    case 'currency':
                        $result = $result = get_currency_info_by_id($row['currency'], 'abbrv');
                        break;
                    case 'currency_id':
                        $result = $result = $row['currency'];
                        break;

                    case 'pre_bid_events_date':
                        $result = $row['pre_bid_events_date'];
                        break;

                    case 'pre_bid_events_duration':
                        $result = $row['pre_bid_events_duration'];
                        break;

                    case 'contracts_committee_approval_date':
                        $result = $row['contracts_committee_approval_date'];
                        break;

                    case 'contracts_committee_approval_date_duration':
                        $result = $row['contracts_committee_approval_date_duration'];
                        break;

                    case 'publication_of_pre_qualification_date':
                        $result = $row['publication_of_pre_qualification_date'];
                        break;

                    case 'publication_of_pre_qualification_date_duration':
                        $result = $row['publication_of_pre_qualification_date_duration'];
                        break;

                    case 'proposal_submission_date':
                        $result = $row['proposal_submission_date'];
                        break;

                    case 'proposal_submission_date_duration':
                        $result = $row['proposal_submission_date_duration'];
                        break;

                    case 'contracts_committee_approval_of_shortlist_date':
                        $result = $row['contracts_committee_approval_of_shortlist_date'];
                        break;

                    case 'contracts_committee_approval_of_shortlist_date_duration':
                        $result = $row['contracts_committee_approval_of_shortlist_date_duration'];
                        break;

                    case 'bid_issue_date_duration':
                        $result = $row['bid_issue_date_duration'];
                        break;

                    case 'bid_submission_opening_date':
                        $result = $row['bid_submission_opening_date'];
                        break;

                    case 'bid_submission_opening_date_duration':
                        $result = $row['bid_submission_opening_date_duration'];
                        break;

                    case 'bid_issue_date':
                        $result = $row['bid_issue_date'];
                        break;

                    case 'secure_necessary_approval_date':
                        $result = $row['secure_necessary_approval_date'];
                        break;

                    case 'secure_necessary_approval_date_duration':
                        $result = $row['secure_necessary_approval_date_duration'];
                        break;

                    case 'contract_award':
                        $result = $row['contract_award'];
                        break;

                    case 'contract_award_duration':
                        $result = $row['contract_award_duration'];
                        break;


                    case 'best_evaluated_bidder_date':
                        $result = $row['best_evaluated_bidder_date'];
                        break;

                    case 'best_evaluated_bidder_date_duration':
                        $result = $row['best_evaluated_bidder_date_duration'];
                        break;

                    case 'contract_sign_date':
                        $result = $row['bid_issue_date'];
                        break;

                    case 'contract_sign_date_duration':
                        $result = $row['contract_sign_duration'];
                        break;
                    case 'cc_approval_of_evaluation_report':
                        $result = $row['cc_approval_of_evaluation_report'];
                        break;
                    case 'cc_approval_of_evaluation_report_duration':
                        $result = $row['cc_approval_of_evaluation_report_duration'];
                        break;
                    case 'negotiation_date':
                        $result = $row['negotiation_date'];
                        break;
                    case 'negotiation_date_duration':
                        $result = $row['negotiation_date_duration'];
                        break;
                    case 'negotiation_approval_date':
                        $result = $row['negotiation_approval_date'];
                        break;
                    case 'negotiation_approval_date_duration':
                        $result = $row['negotiation_approval_date_duration'];
                        break;

                    case 'advanced_payment_date':
                        $result = $row['advanced_payment_date'];
                        break;
                    case 'advanced_payment_date_duration':
                        $result = $row['advanced_payment_date_duration'];
                        break;
                    case 'mobilise_advance_payment':
                        $result = $row['mobilise_advance_payment'];
                        break;
                    case 'mobilise_advance_payment_duration':
                        $result = $row['mobilise_advance_payment_duration'];
                        break;
                    case 'substantial_completion':
                        $result = $row['substantial_completion'];
                        break;
                    case 'substantial_completion_duration':
                        $result = $row['substantial_completion_duration'];
                        break;

                    case 'final_acceptance':
                        $result = $row['final_acceptance'];
                        break;

                    case 'final_acceptance_duration':
                        $result = $row['final_acceptance_duration'];
                        break;


                    case 'procurement_plan_id':
                        $result = $row['procurement_plan_id'];
                        break;

                    case 'procurement_plan':
                        $result = get_procurement_plan_info($row['procurement_plan_id'], 'title');
                        break;
                    case 'pde_id':
                        $result = get_procurement_plan_info($row['procurement_plan_id'], 'pde_id');
                        break;
                    case 'pde':
                        $result = get_procurement_plan_info($row['procurement_plan_id'], 'pde');
                        break;

                    case 'author_id':
                        $result = $row['author'];
                        break;
                    case 'updated_by':
                        $result = $row['updated_by'];
                        break;

                    case 'author':
                        $result = get_user_info($row['author'], 'fullname');
                        break;
                    case 'isactive':
                        $result = $row['active'];
                        break;
                    case 'dateadded':
                        $result = $row['dateadded'];
                        break;
                    default:
                        $result = $query->result_array();
                }
            }

            return $result;
        } else {
            return NULL;
        }
    }

}