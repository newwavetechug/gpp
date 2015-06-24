<?php

class Contracts_m extends   MY_Model
{
    public $_tablename='contracts';
    public $_primary_key='id';
	
    function __construct()
    {
        parent::__construct();
		
		$this->load->model('users_m');
    }

     public function get_contract_info($contracts_id,$param)
    {
        //$this->db->cache_on();
        $query=$this->db->select()->from($this->_tablename) ->where($this->_primary_key,$contracts_id)->get();

        //print_array($this->db->last_query());

        $info_array=$query->result_array();

       // print_array($info_array);

        //if there is a result
        if(count($info_array))
        {

            foreach($info_array as $row)
            {
                switch ($param)
                {
                    case 'emergency_procurement':
                        $result = $row['emergency_procurement'];
                        break;
                    case 'direct_procurement':
                        $result = $row['direct_procurement'];
                        break;
                    case 'procurement_ref_no':
                        $result = $row['procurement_ref_no'];
                        break;
                    case 'admin_review':
                        $result = $row['admin_review'];
                        break;
                    case 'date_of_sg_approval':
                        $result = $row['date_of_sg_approval'];
                        break;
					case 'final_award_notice_date':
						$result = $row['final_award_notice_date'];
						break;
					case 'commencement_date':
						$result = $row['commencement_date'];
						break;
					case 'contract_amount':
						$result = $row['contract_amount'];
						break;
					case 'amount_currency':
						$result = $row['amount_currency'];
						break;
					case 'exchange_rate':
						$result = $row['exchange_rate'];
						break;
                    case 'author_id':
                        $result = $row['author'];
                        break;
                    case 'author':
                        $result = get_user_info_by_id($row['author'],'fullname');
                        break;
                    case 'isactive':
                        $result = $row['isactive'];
                        break;
                    case 'dateawarded':
                        $result = $row['dateawarded'];
                        break;
                    case 'procurement_ref_id':
                        $result = $row['procurement_ref_id'];
                        break;
                    default:
                        //no parameter is passed display all user info
                        $result = $info_array;
                }
            }

            return $result;

        }
        else
        {
            return NULL;
        }

    }
    
    

    function get_contracts_by_financial_year($from,$to,$pde=''){
 

        if($pde){
            $results= $this->custom_query("
        SELECT
contracts.id,
contracts.advance_payment,
contracts.advance_payment_date,
contracts.commencement_letter,
contracts.contract_progress_report,
contracts.implementation_plan,
contracts.commencement_letter_ref_no,
contracts.completion_author,
contracts.procurement_ref_no,
contracts.provider_id,
contracts.direct_procurement,
contracts.emergency_procurement,
contracts.admin_review,
contracts.date_of_sg_approval,
contracts.final_award_notice_date,
contracts.commencement_date,
contracts.completion_date,
contracts.exchange_rate,
contracts.days_duration,
contracts.contract_amount,
contracts.date_signed,
contracts.amount_currency,
contracts.final_contract_value,
contracts.final_contract_value_currency,
contracts.total_actual_payments,
contracts.total_actual_payments_currency,
contracts.actual_completion_date,
contracts.performance_rating,
contracts.contract_manager,
contracts.contract_management_report,
contracts.pdeid,
contracts.author,
contracts.dateawarded,
contracts.dateadded,
contracts.isactive,
contracts.procurement_ref_id,
procurement_plan_entries.subject_of_procurement,
procurement_plan_entries.procurement_method,
procurement_plan_entries.pde_department,
procurement_plan_entries.funding_source,
procurement_plan_entries.funder_name,
procurement_plan_entries.procurement_ref_no,
procurement_plan_entries.estimated_amount,
procurement_plan_entries.procurement_plan_id,
procurement_plans.id,
procurement_plans.pde_id,
procurement_plans.financial_year,
procurement_plans.title,
pdes.pdeid,
pdes.pdename,
procurement_plan_entries.id,
procurement_types.id,
procurement_types.title,
procurement_methods.id,
procurement_methods.title,
funding_sources.id,
funding_sources.title,
contract_prices.id,
contract_prices.contract_id,
contract_prices.amount
FROM
contracts
INNER JOIN procurement_plan_entries ON contracts.procurement_ref_id = procurement_plan_entries.id
INNER JOIN procurement_plans ON procurement_plan_entries.procurement_plan_id = procurement_plans.id
INNER JOIN pdes ON procurement_plans.pde_id = pdes.pdeid
INNER JOIN procurement_types ON procurement_plan_entries.procurement_type = procurement_types.id
INNER JOIN procurement_methods ON procurement_plan_entries.procurement_method = procurement_methods.id
INNER JOIN funding_sources ON procurement_plan_entries.funding_source = funding_sources.id
INNER JOIN contract_prices ON contracts.id = contract_prices.id

WHERE
contracts.isactive = 'Y' AND
contracts.commencement_date >= '" . $from . "' AND
contracts.commencement_date <= '" . $to . "' AND
pdes.pdeid = '" . $pde . "'
ORDER BY
contracts.id DESC
");
        }
        else{
            $results= $this->custom_query("
        SELECT
contracts.id,
contracts.advance_payment,
contracts.advance_payment_date,
contracts.commencement_letter,
contracts.contract_progress_report,
contracts.implementation_plan,
contracts.commencement_letter_ref_no,
contracts.completion_author,
contracts.procurement_ref_no,
contracts.provider_id,
contracts.direct_procurement,
contracts.emergency_procurement,
contracts.admin_review,
contracts.date_of_sg_approval,
contracts.final_award_notice_date,
contracts.commencement_date,
contracts.completion_date,
contracts.exchange_rate,
contracts.days_duration,
contracts.contract_amount,
contracts.date_signed,
contracts.amount_currency,
contracts.final_contract_value,
contracts.final_contract_value_currency,
contracts.total_actual_payments,
contracts.total_actual_payments_currency,
contracts.actual_completion_date,
contracts.performance_rating,
contracts.contract_manager,
contracts.contract_management_report,
contracts.pdeid,
contracts.author,
contracts.dateawarded,
contracts.dateadded,
contracts.isactive,
contracts.procurement_ref_id,
procurement_plan_entries.subject_of_procurement,
procurement_plan_entries.procurement_method,
procurement_plan_entries.pde_department,
procurement_plan_entries.funding_source,
procurement_plan_entries.funder_name,
procurement_plan_entries.procurement_ref_no,
procurement_plan_entries.estimated_amount,
procurement_plan_entries.procurement_plan_id,
procurement_plans.id,
procurement_plans.pde_id,
procurement_plans.financial_year,
procurement_plans.title,
pdes.pdeid,
pdes.pdename,
procurement_plan_entries.id,
procurement_types.id,
procurement_types.title,
procurement_methods.id,
procurement_methods.title,
funding_sources.id,
funding_sources.title,
contract_prices.id,
contract_prices.contract_id,
contract_prices.amount
FROM
contracts
INNER JOIN procurement_plan_entries ON contracts.procurement_ref_id = procurement_plan_entries.id
INNER JOIN procurement_plans ON procurement_plan_entries.procurement_plan_id = procurement_plans.id
INNER JOIN pdes ON procurement_plans.pde_id = pdes.pdeid
INNER JOIN procurement_types ON procurement_plan_entries.procurement_type = procurement_types.id
INNER JOIN procurement_methods ON procurement_plan_entries.procurement_method = procurement_methods.id
INNER JOIN funding_sources ON procurement_plan_entries.funding_source = funding_sources.id
INNER JOIN contract_prices ON contracts.id = contract_prices.id

WHERE
contracts.isactive = 'Y' AND
contracts.commencement_date >= '" . $from . "' AND
contracts.commencement_date <= '" . $to . "'
ORDER BY
contracts.id DESC

");
        }


        return $results;
    }

    function get_timeliness_of_contract_completion($from,$to,$pde=''){
        /*
         * percentage of contracts completed whose planned date of completion  is >=  to the actual completion date
         */
        $searchstring = "";
        if(!empty($pde))
        {
            $searchstring = "AND pdes.pdeid = " . $pde . "" ;
        }


       // if($pde){
            $results= $this->custom_query("
        SELECT
contracts.id,
contracts.procurement_ref_no,
contracts.completion_date,
contracts.commencement_date,
contracts.days_duration,
contracts.contract_amount,
contracts.final_contract_value,
contracts.final_contract_value_currency,
contracts.total_actual_payments,
contracts.total_actual_payments_currency,
contracts.actual_completion_date,
contracts.performance_rating,
contracts.isactive,
contracts.procurement_ref_id,
procurement_plan_entries.subject_of_procurement,
procurement_plan_entries.procurement_type,
procurement_plan_entries.procurement_method,
procurement_plan_entries.pde_department,
procurement_plan_entries.funding_source,
procurement_plan_entries.funder_name,
procurement_plan_entries.estimated_amount,
procurement_plan_entries.currency,
procurement_plan_entries.procurement_plan_id,
procurement_types.title,
procurement_types.evaluation_time,
procurement_methods.title,
funding_sources.title,
procurement_plans.pde_id,
procurement_plans.financial_year,
procurement_plans.title,
pdes.pdename,
pdetypes.pdetype,
contracts.provider_id
FROM
contracts
INNER JOIN procurement_plan_entries ON contracts.procurement_ref_id = procurement_plan_entries.id
INNER JOIN procurement_types ON procurement_plan_entries.procurement_type = procurement_types.id
INNER JOIN procurement_methods ON procurement_plan_entries.procurement_method = procurement_methods.id
INNER JOIN funding_sources ON procurement_plan_entries.funding_source = funding_sources.id
INNER JOIN procurement_plans ON procurement_plan_entries.procurement_plan_id = procurement_plans.id
INNER JOIN pdes ON procurement_plans.pde_id = pdes.pdeid
INNER JOIN pdetypes ON pdes.type = pdetypes.pdetypeid
WHERE
contracts.isactive = 'Y' AND
contracts.completion_date >= contracts.actual_completion_date AND
 contracts.commencement_date >= '" . $from . "'   AND
 contracts.commencement_date  <=  '" . $to . "'  " .$searchstring."
ORDER BY
contracts.id DESC
");

//         }
//         else{
//             $results= $this->custom_query("
//         SELECT
// contracts.id,
// contracts.procurement_ref_no,
// contracts.completion_date,
// contracts.commencement_date,
// contracts.days_duration,
// contracts.contract_amount,
// contracts.final_contract_value,
// contracts.final_contract_value_currency,
// contracts.total_actual_payments,
// contracts.total_actual_payments_currency,
// contracts.actual_completion_date,
// contracts.performance_rating,
// contracts.isactive,
// contracts.procurement_ref_id,
// procurement_plan_entries.subject_of_procurement,
// procurement_plan_entries.procurement_type,
// procurement_plan_entries.procurement_method,
// procurement_plan_entries.pde_department,
// procurement_plan_entries.funding_source,
// procurement_plan_entries.funder_name,
// procurement_plan_entries.estimated_amount,
// procurement_plan_entries.currency,
// procurement_plan_entries.procurement_plan_id,
// procurement_types.title,
// procurement_types.evaluation_time,
// procurement_methods.title,
// funding_sources.title,
// procurement_plans.pde_id,
// procurement_plans.financial_year,
// procurement_plans.title,
// pdes.pdename,
// pdetypes.pdetype,
// contracts.provider_id
// FROM
// contracts
// INNER JOIN procurement_plan_entries ON contracts.procurement_ref_id = procurement_plan_entries.id
// INNER JOIN procurement_types ON procurement_plan_entries.procurement_type = procurement_types.id
// INNER JOIN procurement_methods ON procurement_plan_entries.procurement_method = procurement_methods.id
// INNER JOIN funding_sources ON procurement_plan_entries.funding_source = funding_sources.id
// INNER JOIN procurement_plans ON procurement_plan_entries.procurement_plan_id = procurement_plans.id
// INNER JOIN pdes ON procurement_plans.pde_id = pdes.pdeid
// INNER JOIN pdetypes ON pdes.type = pdetypes.pdetypeid
// WHERE
// contracts.completion_date >= contracts.actual_completion_date AND
// contracts.isactive = 'Y' AND
// contracts.completion_date >= contracts.actual_completion_date AND
//  contracts.commencement_date >= '" . $from . "'   AND
//  contracts.commencement_date  <=  '" . $to . "'  AND
// ORDER BY
// contracts.id DESC

// ");
//         }


        return $results;
    }

    function get_contracts_completed_within_original_value($from,$to,$pde=''){

        if($pde){
            $results= $this->custom_query("
        SELECT
contracts.id,
contracts.procurement_ref_no,
contracts.commencement_date,
contracts.completion_date,
contracts.days_duration,
contracts.contract_amount,
contracts.final_contract_value,
contracts.total_actual_payments,
contracts.actual_completion_date,
contracts.performance_rating,
contracts.author,
contracts.dateawarded,
contracts.dateadded,
contracts.isactive,
contracts.procurement_ref_id,
procurement_plan_entries.subject_of_procurement,
procurement_plan_entries.procurement_method,
procurement_plan_entries.estimated_amount,
procurement_plan_entries.procurement_type,
procurement_plans.pde_id,
pdes.pdename
FROM
contracts
INNER JOIN procurement_plan_entries ON contracts.procurement_ref_id = procurement_plan_entries.id
INNER JOIN procurement_plans ON procurement_plan_entries.procurement_plan_id = procurement_plans.id
INNER JOIN pdes ON procurement_plans.pde_id = pdes.pdeid
WHERE
contracts.isactive = 'Y' AND
contracts.final_contract_value <= procurement_plan_entries.estimated_amount AND
'" . $from . "' >=  contracts.commencement_date  AND
 '" . $to . "'  <=  contracts.completion_date AND
pdes.pdeid = " . $pde . "
ORDER BY
contracts.id DESC
");
        }
        else{
            $results= $this->custom_query("
        SELECT
contracts.id,
contracts.procurement_ref_no,
contracts.commencement_date,
contracts.completion_date,
contracts.days_duration,
contracts.contract_amount,
contracts.final_contract_value,
contracts.total_actual_payments,
contracts.actual_completion_date,
contracts.performance_rating,
contracts.author,
contracts.dateawarded,
contracts.dateadded,
contracts.isactive,
contracts.procurement_ref_id,
procurement_plan_entries.subject_of_procurement,
procurement_plan_entries.procurement_method,
procurement_plan_entries.estimated_amount,
procurement_plan_entries.procurement_type,
procurement_plans.pde_id,
pdes.pdename
FROM
contracts
INNER JOIN procurement_plan_entries ON contracts.procurement_ref_id = procurement_plan_entries.id
INNER JOIN procurement_plans ON procurement_plan_entries.procurement_plan_id = procurement_plans.id
INNER JOIN pdes ON procurement_plans.pde_id = pdes.pdeid
WHERE
contracts.isactive = 'Y' AND
contracts.final_contract_value <= procurement_plan_entries.estimated_amount AND
'" . $from . "' >=  contracts.commencement_date  AND
 '" . $to . "'  <=  contracts.completion_date 
ORDER BY
contracts.id DESC

");
        }


        return $results;
    }


    //get contacts by contract method
    function get_contracts_by_contracts_by_procurement_method($procurement_method,$from,$to,$pde=''){

        if($pde){
            $results= $this->custom_query("
        SELECT
contracts.id,
contracts.commencement_date,
contracts.completion_date,
contracts.contract_amount,
contracts.final_contract_value,
contracts.total_actual_payments,
contracts.actual_completion_date,
contracts.procurement_ref_id,
contracts.isactive,
procurement_plan_entries.procurement_method,
procurement_plan_entries.procurement_plan_id,
procurement_plans.pde_id,
pdes.pdename,
bidinvitations.cost_estimate,
bidinvitations.contract_award_date,
bidinvitations.dateofconfirmationoffunds,
contract_prices.amount
FROM
contracts
INNER JOIN procurement_plan_entries ON contracts.procurement_ref_id = procurement_plan_entries.id
INNER JOIN procurement_plans ON procurement_plan_entries.procurement_plan_id = procurement_plans.id
INNER JOIN pdes ON procurement_plans.pde_id = pdes.pdeid
INNER JOIN bidinvitations ON contracts.procurement_ref_id = bidinvitations.procurement_id
INNER JOIN contract_prices ON contract_prices.contract_id = contracts.id
WHERE

procurement_plan_entries.procurement_method = " . $procurement_method . " AND
contracts.isactive = 'Y' AND
contracts.commencement_date >= '" . $from . "' AND
contracts.commencement_date <= '" . $to . "' AND
pdes.pdeid = " . $pde . "
ORDER BY
contracts.id DESC
");
        }
        else{
            $results= $this->custom_query("
        SELECT
contracts.id,
contracts.commencement_date,
contracts.completion_date,
contracts.contract_amount,
contracts.final_contract_value,
contracts.total_actual_payments,
contracts.actual_completion_date,
contracts.procurement_ref_id,
contracts.isactive,
procurement_plan_entries.procurement_method,
procurement_plan_entries.procurement_plan_id,
procurement_plans.pde_id,
pdes.pdename,
bidinvitations.cost_estimate,
bidinvitations.contract_award_date,
bidinvitations.dateofconfirmationoffunds,
contract_prices.amount
FROM
contracts
INNER JOIN procurement_plan_entries ON contracts.procurement_ref_id = procurement_plan_entries.id
INNER JOIN procurement_plans ON procurement_plan_entries.procurement_plan_id = procurement_plans.id
INNER JOIN pdes ON procurement_plans.pde_id = pdes.pdeid
INNER JOIN bidinvitations ON contracts.procurement_ref_id = bidinvitations.procurement_id
INNER JOIN contract_prices ON contract_prices.contract_id = contracts.id
WHERE

procurement_plan_entries.procurement_method = " . $procurement_method . " AND
contracts.isactive = 'Y' AND
contracts.commencement_date >= '" . $from . "' AND
contracts.commencement_date <= '" . $to . "'
ORDER BY
contracts.id DESC

");
        }


        return $results;
    }


    function get_contracts_due_by_month($from,$to,$pde=''){

        if($pde){
            $results= $this->custom_query("
        SELECT
contracts.completion_date,
contracts.contract_amount,
contracts.final_contract_value,
contracts.total_actual_payments,
contracts.actual_completion_date,
contracts.isactive,
procurement_plan_entries.subject_of_procurement,
procurement_plan_entries.funding_source,
contracts.id,
pdes.pdename,
procurement_methods.title,
procurement_plan_entries.procurement_ref_no
FROM
contracts
INNER JOIN procurement_plan_entries ON contracts.procurement_ref_id = procurement_plan_entries.id
INNER JOIN procurement_plans ON procurement_plan_entries.procurement_plan_id = procurement_plans.id
INNER JOIN pdes ON procurement_plans.pde_id = pdes.pdeid
INNER JOIN procurement_methods ON procurement_plan_entries.procurement_method = procurement_methods.id
WHERE
contracts.isactive = 'Y' AND
contracts.completion_date >= '" . $from . "' AND
contracts.completion_date <= '" . $to . "' AND
pdes.pdeid = '" . $pde . "'
ORDER BY
contracts.id DESC
");
        }
        else{
            $results= $this->custom_query("
        SELECT
contracts.completion_date,
contracts.contract_amount,
contracts.final_contract_value,
contracts.total_actual_payments,
contracts.actual_completion_date,
contracts.isactive,
procurement_plan_entries.subject_of_procurement,
procurement_plan_entries.funding_source,
contracts.id,
pdes.pdename,
procurement_methods.title,
procurement_plan_entries.procurement_ref_no
FROM
contracts
INNER JOIN procurement_plan_entries ON contracts.procurement_ref_id = procurement_plan_entries.id
INNER JOIN procurement_plans ON procurement_plan_entries.procurement_plan_id = procurement_plans.id
INNER JOIN pdes ON procurement_plans.pde_id = pdes.pdeid
INNER JOIN procurement_methods ON procurement_plan_entries.procurement_method = procurement_methods.id
WHERE
contracts.isactive = 'Y' AND
contracts.completion_date >= '" . $from . "' AND
contracts.completion_date <= '" . $to . "'
ORDER BY
contracts.id DESC

");
        }

        //print_array($this->db->last_query());


        return $results;
    }


    //get signed contracts
    function get_signed_contracts_by_financial_year($from,$to,$pde=''){

        if($pde){
            $results= $this->custom_query("
        SELECT
contracts.id,
contracts.completion_author,
contracts.procurement_ref_no,
contracts.completion_date,
contracts.exchange_rate,
contracts.days_duration,
contracts.contract_amount,
contracts.date_signed,
contracts.final_contract_value,
contracts.total_actual_payments,
contracts.actual_completion_date,
contracts.performance_rating,
contracts.contract_manager,
contracts.author,
contracts.dateawarded,
contracts.dateadded,
contracts.isactive,
contracts.procurement_ref_id,
procurement_plan_entries.subject_of_procurement,
procurement_plan_entries.funder_name,
procurement_plan_entries.procurement_ref_no,
pdes.pdeid,
pdes.pdename,
procurement_plan_entries.procurement_type,
procurement_plan_entries.id,
procurement_plan_entries.funding_source
FROM
contracts
INNER JOIN procurement_plan_entries ON contracts.procurement_ref_id = procurement_plan_entries.id
INNER JOIN procurement_plans ON procurement_plan_entries.procurement_plan_id = procurement_plans.id
INNER JOIN pdes ON procurement_plans.pde_id = pdes.pdeid
WHERE
contracts.isactive = 'Y' AND
contracts.commencement_date >= '" . $from . "' AND
contracts.commencement_date <= '" . $to . "' AND
pdes.pdeid = '" . $pde . "'
ORDER BY
contracts.id DESC
");
        }
        else{
            $results= $this->custom_query("
        SELECT
contracts.id,
contracts.completion_author,
contracts.procurement_ref_no,
contracts.completion_date,
contracts.exchange_rate,
contracts.days_duration,
contracts.contract_amount,
contracts.date_signed,
contracts.final_contract_value,
contracts.total_actual_payments,
contracts.actual_completion_date,
contracts.performance_rating,
contracts.contract_manager,
contracts.author,
contracts.dateawarded,
contracts.dateadded,
contracts.isactive,
contracts.procurement_ref_id,
procurement_plan_entries.subject_of_procurement,
procurement_plan_entries.funder_name,
procurement_plan_entries.procurement_ref_no,
pdes.pdeid,
pdes.pdename,
procurement_plan_entries.procurement_type,
procurement_plan_entries.id,
procurement_plan_entries.funding_source
FROM
contracts
INNER JOIN procurement_plan_entries ON contracts.procurement_ref_id = procurement_plan_entries.id
INNER JOIN procurement_plans ON procurement_plan_entries.procurement_plan_id = procurement_plans.id
INNER JOIN pdes ON procurement_plans.pde_id = pdes.pdeid
WHERE
contracts.isactive = 'Y' AND
contracts.date_signed >= '" . $from . "' AND
contracts.date_signed <= '" . $to . "'
ORDER BY
contracts.id DESC

");
        }


        return $results;
    }

    //contracts awarded except micro procurements
    function get_contracts_awarded_except_micro_procurements($from, $to, $pde = '', $micro_limit)
    {

        if ($pde) {
            $results = $this->custom_query("
        SELECT
contracts.id,
contracts.dateawarded,
contracts.procurement_ref_id,
procurement_plan_entries.subject_of_procurement,
procurement_plan_entries.procurement_method,
procurement_plan_entries.procurement_type,
procurement_plan_entries.funding_source,
procurement_plan_entries.procurement_ref_no,
contract_prices.amount,
pdes.pdeid,
pdes.pdename,
pdes.category,
contracts.total_actual_payments
FROM
contracts
INNER JOIN procurement_plan_entries ON contracts.procurement_ref_id = procurement_plan_entries.id
INNER JOIN contract_prices ON contracts.id = contract_prices.contract_id
INNER JOIN procurement_plans ON procurement_plans.id = procurement_plan_entries.procurement_plan_id
INNER JOIN pdes ON procurement_plans.pde_id = pdes.pdeid
WHERE
contracts.isactive = 'Y' AND
contract_prices.amount > $micro_limit AND
contracts.dateawarded >= '" . $from . "' AND
contracts.dateawarded <= '" . $to . "' AND
pdes.pdeid = '" . $pde . "'
ORDER BY
contracts.id DESC
");
        } else {
            $results = $this->custom_query("
        SELECT
contracts.id,
contracts.dateawarded,
contracts.procurement_ref_id,
procurement_plan_entries.subject_of_procurement,
procurement_plan_entries.procurement_method,
procurement_plan_entries.procurement_type,
procurement_plan_entries.funding_source,
procurement_plan_entries.procurement_ref_no,
contract_prices.amount,
pdes.pdeid,
pdes.pdename,
pdes.category,
contracts.total_actual_payments
FROM
contracts
INNER JOIN procurement_plan_entries ON contracts.procurement_ref_id = procurement_plan_entries.id
INNER JOIN contract_prices ON contracts.id = contract_prices.contract_id
INNER JOIN procurement_plans ON procurement_plans.id = procurement_plan_entries.procurement_plan_id
INNER JOIN pdes ON procurement_plans.pde_id = pdes.pdeid
WHERE
contracts.isactive = 'Y' AND
contract_prices.amount > $micro_limit AND
contracts.dateawarded >= '" . $from . "' AND
contracts.dateawarded <= '" . $to . "'
ORDER BY
contracts.id DESC

");
        }

        //print_array($this->db->last_query());


        return $results;
    }

    //get awarded contracts
    function get_contracts_all_awarded($from, $to, $pde = '')
    {

        if ($pde) {
            $results = $this->custom_query("
        SELECT
contracts.id,
contracts.dateawarded,
contracts.procurement_ref_id,
procurement_plan_entries.subject_of_procurement,
procurement_plan_entries.procurement_method,
procurement_plan_entries.procurement_type,
procurement_plan_entries.funding_source,
procurement_plan_entries.procurement_ref_no,
contract_prices.amount,
pdes.pdeid,
pdes.pdename,
pdes.category,
contracts.total_actual_payments
FROM
contracts
INNER JOIN procurement_plan_entries ON contracts.procurement_ref_id = procurement_plan_entries.id
INNER JOIN contract_prices ON contracts.id = contract_prices.contract_id
INNER JOIN procurement_plans ON procurement_plans.id = procurement_plan_entries.procurement_plan_id
INNER JOIN pdes ON procurement_plans.pde_id = pdes.pdeid
WHERE
contracts.isactive = 'Y' AND

contracts.dateawarded >= '" . $from . "' AND
contracts.dateawarded <= '" . $to . "' AND
pdes.pdeid = '" . $pde . "'
ORDER BY
contracts.id DESC
");
        } else {
            $results = $this->custom_query("
        SELECT
contracts.id,
contracts.dateawarded,
contracts.procurement_ref_id,
procurement_plan_entries.subject_of_procurement,
procurement_plan_entries.procurement_method,
procurement_plan_entries.procurement_type,
procurement_plan_entries.funding_source,
procurement_plan_entries.procurement_ref_no,
contract_prices.amount,
pdes.pdeid,
pdes.pdename,
pdes.category,
contracts.total_actual_payments
FROM
contracts
INNER JOIN procurement_plan_entries ON contracts.procurement_ref_id = procurement_plan_entries.id
INNER JOIN contract_prices ON contracts.id = contract_prices.contract_id
INNER JOIN procurement_plans ON procurement_plans.id = procurement_plan_entries.procurement_plan_id
INNER JOIN pdes ON procurement_plans.pde_id = pdes.pdeid
WHERE
contracts.isactive = 'Y' AND
contracts.dateawarded >= '" . $from . "' AND
contracts.dateawarded <= '" . $to . "'
ORDER BY
contracts.id DESC

");
        }

        //print_array($this->db->last_query());


        return $results;
    }


    //contracts awarded except micro procurements
    function get_contracts_awarded_only_micro_procurements($from, $to, $pde = '', $micro_limit)
    {

        if ($pde) {
            $results = $this->custom_query("
        SELECT
contracts.id,
contracts.dateawarded,
contracts.procurement_ref_id,
procurement_plan_entries.subject_of_procurement,
procurement_plan_entries.procurement_method,
procurement_plan_entries.procurement_type,
procurement_plan_entries.funding_source,
procurement_plan_entries.procurement_ref_no,
contract_prices.amount,
pdes.pdeid,
pdes.pdename,
pdes.category,
contracts.total_actual_payments,
contracts.actual_completion_date
FROM
contracts
INNER JOIN procurement_plan_entries ON contracts.procurement_ref_id = procurement_plan_entries.id
INNER JOIN contract_prices ON contracts.id = contract_prices.contract_id
INNER JOIN procurement_plans ON procurement_plans.id = procurement_plan_entries.procurement_plan_id
INNER JOIN pdes ON procurement_plans.pde_id = pdes.pdeid
WHERE
contracts.isactive = 'Y' AND
contract_prices.amount < $micro_limit AND
contracts.dateawarded >= '" . $from . "' AND
contracts.dateawarded <= '" . $to . "' AND
pdes.pdeid = '" . $pde . "'
ORDER BY
contracts.id DESC
");
        } else {
            $results = $this->custom_query("
        SELECT
contracts.id,
contracts.dateawarded,
contracts.procurement_ref_id,
procurement_plan_entries.subject_of_procurement,
procurement_plan_entries.procurement_method,
procurement_plan_entries.procurement_type,
procurement_plan_entries.funding_source,
procurement_plan_entries.procurement_ref_no,
contract_prices.amount,
pdes.pdeid,
pdes.pdename,
pdes.category,
contracts.total_actual_payments,
contracts.actual_completion_date
FROM
contracts
INNER JOIN procurement_plan_entries ON contracts.procurement_ref_id = procurement_plan_entries.id
INNER JOIN contract_prices ON contracts.id = contract_prices.contract_id
INNER JOIN procurement_plans ON procurement_plans.id = procurement_plan_entries.procurement_plan_id
INNER JOIN pdes ON procurement_plans.pde_id = pdes.pdeid
WHERE
contracts.isactive = 'Y' AND
contract_prices.amount < $micro_limit AND
contracts.dateawarded >= '" . $from . "' AND
contracts.dateawarded <= '" . $to . "'
ORDER BY
contracts.id DESC

");
        }

        //print_array($this->db->last_query());


        return $results;
    }

    //completed contracts
    function get_completed_contracts($from, $to, $pde = '')
    {

        if ($pde) {
            $results = $this->custom_query("
        SELECT
contracts.id,
contracts.dateawarded,
contracts.procurement_ref_id,
procurement_plan_entries.subject_of_procurement,
procurement_plan_entries.procurement_method,
procurement_plan_entries.procurement_type,
procurement_plan_entries.funding_source,
procurement_plan_entries.procurement_ref_no,
contract_prices.amount,
pdes.pdeid,
pdes.pdename,
pdes.category,
contracts.total_actual_payments,
contracts.actual_completion_date
FROM
contracts
INNER JOIN procurement_plan_entries ON contracts.procurement_ref_id = procurement_plan_entries.id
INNER JOIN contract_prices ON contracts.id = contract_prices.contract_id
INNER JOIN procurement_plans ON procurement_plans.id = procurement_plan_entries.procurement_plan_id
INNER JOIN pdes ON procurement_plans.pde_id = pdes.pdeid
WHERE
contracts.isactive = 'Y' AND
contracts.actual_completion_date IS NOT NULL AND
contracts.actual_completion_date >= '" . $from . "' AND
contracts.actual_completion_date <= '" . $to . "' AND
pdes.pdeid = '" . $pde . "'
ORDER BY
contracts.id DESC
");
        } else {
            $results = $this->custom_query("
        SELECT
contracts.id,
contracts.dateawarded,
contracts.procurement_ref_id,
procurement_plan_entries.subject_of_procurement,
procurement_plan_entries.procurement_method,
procurement_plan_entries.procurement_type,
procurement_plan_entries.funding_source,
procurement_plan_entries.procurement_ref_no,
contract_prices.amount,
pdes.pdeid,
pdes.pdename,
pdes.category,
contracts.total_actual_payments,
contracts.actual_completion_date
FROM
contracts
INNER JOIN procurement_plan_entries ON contracts.procurement_ref_id = procurement_plan_entries.id
INNER JOIN contract_prices ON contracts.id = contract_prices.contract_id
INNER JOIN procurement_plans ON procurement_plans.id = procurement_plan_entries.procurement_plan_id
INNER JOIN pdes ON procurement_plans.pde_id = pdes.pdeid
WHERE
contracts.isactive = 'Y' AND
contracts.actual_completion_date IS NOT NULL AND
contracts.actual_completion_date >= '" . $from . "' AND
contracts.actual_completion_date <= '" . $to . "'
ORDER BY
contracts.id DESC

");
        }

        //print_array($this->db->last_query());


        return $results;
    }




    //procurement lead time
    //get awarded contracts
    function get_procurement_lead_times($from, $to, $pde = '')
    {

        if ($pde) {
            $results = $this->custom_query("SELECT
bidinvitations.id,
bidinvitations.invitation_to_bid_date,
bidinvitations.procurement_ref_no,
bidinvitations.procurement_id,
bidinvitations.contract_award_date,
bidinvitations.dateofconfirmationoffunds,
pdes.pdename,
pdes.pdeid,
procurement_plan_entries.subject_of_procurement,
procurement_plan_entries.procurement_type,
procurement_plan_entries.procurement_method,
procurement_plan_entries.pde_department,
procurement_plan_entries.funding_source,
procurement_plan_entries.funder_name,
procurement_plan_entries.procurement_ref_no,
procurement_plan_entries.estimated_amount,
contracts.final_contract_value,
contracts.date_signed,
contracts.contract_amount,
contracts.total_actual_payments
FROM
bidinvitations
INNER JOIN contracts ON bidinvitations.procurement_id = contracts.procurement_ref_id
INNER JOIN procurement_plan_entries ON contracts.procurement_ref_id = procurement_plan_entries.id
INNER JOIN procurement_plans ON procurement_plan_entries.procurement_plan_id = procurement_plans.id
INNER JOIN pdes ON pdes.pdeid = procurement_plans.pde_id
contracts.isactive = 'Y' AND

contracts.dateawarded >= '" . $from . "' AND
contracts.dateawarded <= '" . $to . "' AND
pdes.pdeid = '" . $pde . "'
ORDER BY
contracts.id DESC
");
        } else {
            $results = $this->custom_query("SELECT
bidinvitations.id,
bidinvitations.invitation_to_bid_date,
bidinvitations.procurement_ref_no,
bidinvitations.procurement_id,
bidinvitations.contract_award_date,
bidinvitations.dateofconfirmationoffunds,
pdes.pdename,
pdes.pdeid,
procurement_plan_entries.subject_of_procurement,
procurement_plan_entries.procurement_type,
procurement_plan_entries.procurement_method,
procurement_plan_entries.pde_department,
procurement_plan_entries.funding_source,
procurement_plan_entries.funder_name,
procurement_plan_entries.procurement_ref_no,
procurement_plan_entries.estimated_amount,
contracts.final_contract_value,
contracts.date_signed,
contracts.contract_amount,
contracts.total_actual_payments
FROM
bidinvitations
INNER JOIN contracts ON bidinvitations.procurement_id = contracts.procurement_ref_id
INNER JOIN procurement_plan_entries ON contracts.procurement_ref_id = procurement_plan_entries.id
INNER JOIN procurement_plans ON procurement_plan_entries.procurement_plan_id = procurement_plans.id
INNER JOIN pdes ON pdes.pdeid = procurement_plans.pde_id
WHERE
contracts.isactive = 'Y' AND
contracts.dateawarded >= '" . $from . "' AND
contracts.dateawarded <= '" . $to . "'
ORDER BY
contracts.id DESC

");
        }

        //print_array($this->db->last_query());


        return $results;
    }



}