<?php

class Bid_invitation_m extends MY_Model
{
    public $_tablename = 'bidinvitations';
    public $_primary_key = 'id';

    function __construct()
    {

        parent::__construct();
    }

    function get_bid_invitation_info($passed_id, $param)
    {

        //if NO ID
        if ($passed_id == '') {
            return NULL;
        } else {
            //get user info
            $query = $this->db->select()->from($this->_tablename)->where($this->_primary_key, $passed_id)->get();

            if ($query->result_array()) {
                foreach ($query->result_array() as $row) {
                    //filter results
                    switch ($param) {
                        case 'procurement_id':
                            $result = $row['procurement_id'];
                            break;

                        case 'procurement':
                            $result = get_procurement_plan_entry_info($row['procurement_id'], 'title');
                            break;

                        case 'procurement_method':
                            $result = get_procurement_plan_entry_info($row['procurement_id'], 'procurement_method');
                            break;
                        case 'procurement_value':
                            $result = get_procurement_plan_entry_info($row['procurement_id'], 'estimated_amount');
                            break;

                        case 'amount':
                            $result = $row['amount'];
                            break;

                        case 'xrate':
                            $result = $row['xrate'];
                            break;
                        case 'currency_id':
                            $result = $row['currency_id'];
                            break;

                        case 'currency':
                            $result = get_currency_info_by_id($row['currency_id'], 'abbrv');
                            break;

                        case 'dateadded':
                            $result = $row['dateadded'];
                            break;

                        case 'procurement_ref_no':
                            $result = $row['procurement_ref_no'];
                            break;
                        case 'bid_submission_deadline':
                            $result = $row['currency_id'];
                            break;

                        default:
                            $result = $query->result_array();
                    }

                }

                return $result;
            }

        }
    }


    function get_contract_price_info_by_contract($passed_id, $param)
    {

        //if NO ID
        if ($passed_id == '') {
            return NULL;
        } else {
            //get user info
            $query = $this->db->select()->from($this->_tablename)->where('contract_id', $passed_id)->get();
            //echo $this->db->last_query();

            if ($query->result_array()) {
                foreach ($query->result_array() as $row) {
                    //filter results
                    switch ($param) {
                        case 'id':
                            $result = $row['id'];
                            break;

                        case 'amount':
                            $result = $row['amount'];
                            break;

                        case 'xrate':
                            $result = $row['xrate'];
                            break;
                        case 'rate':
                            $result = $row['xrate'];
                            break;
                        case 'currency_id':
                            $result = $row['currency_id'];
                            break;

                        case 'currency':
                            $result = get_currency_info_by_id($row['currency_id'], 'abbrv');
                            break;

                        case 'dateadded':
                            $result = $row['dateadded'];
                            break;

                        default:
                            $result = $query->result_array();
                    }

                }

                return $result;
            }

        }
    }

    function get_invitation_for_bids_by_month($from,$to,$pde=''){
        if($pde){
            $results=$this->custom_query("SELECT
bidinvitations.id,
bidinvitations.vote_no,
bidinvitations.initiated_by,
bidinvitations.date_initiated,
bidinvitations.bid_openning_date,
bidinvitations.pde_id,
bidinvitations.subject_of_procurement,
bidinvitations.cost_estimate,
bidinvitations.invitation_to_bid_date,
bidinvitations.pre_bid_meeting_date,
bidinvitations.cc_approval_date,
bidinvitations.bid_receipt_address,
bidinvitations.documents_inspection_address,
bidinvitations.documents_address_issue,
bidinvitations.bid_openning_address,
bidinvitations.procurement_ref_no,
bidinvitations.procurement_id,
bidinvitations.description_of_works,
bidinvitations.bid_security_amount,
bidinvitations.bid_security_currency,
bidinvitations.bid_documents_price,
bidinvitations.bid_documents_currency,
bidinvitations.author,
bidinvitations.isapproved,
bidinvitations.date_approved,
bidinvitations.dateadded,
bidinvitations.approvedby,
bidinvitations.approval_comments,
bidinvitations.isactive,
bidinvitations.bid_submission_deadline,
bidinvitations.bid_evaluation_to,
bidinvitations.bid_evaluation_from,
bidinvitations.display_of_beb_notice,
bidinvitations.contract_award_date,
bidinvitations.dateofconfirmationoffunds
FROM
(bidinvitations)
INNER JOIN procurement_plan_entries ON bidinvitations.procurement_id = procurement_plan_entries.id
INNER JOIN procurement_plans ON procurement_plan_entries.procurement_plan_id = procurement_plans.id
INNER JOIN pdes ON procurement_plans.pde_id = pdes.pdeid
WHERE
bidinvitations.isactive = 'Y' AND
bidinvitations.isapproved = 'Y' AND
bidinvitations.invitation_to_bid_date >= '".$from."' AND
bidinvitations.invitation_to_bid_date <= '".$to."' AND
pdes.pdeid = ".$pde."
ORDER BY id DESC
");
        }else{
            //if pde is passed
            $results=$this->custom_query("SELECT
bidinvitations.id,
bidinvitations.vote_no,
bidinvitations.initiated_by,
bidinvitations.date_initiated,
bidinvitations.bid_openning_date,
bidinvitations.pde_id,
bidinvitations.subject_of_procurement,
bidinvitations.cost_estimate,
bidinvitations.invitation_to_bid_date,
bidinvitations.pre_bid_meeting_date,
bidinvitations.cc_approval_date,
bidinvitations.bid_receipt_address,
bidinvitations.documents_inspection_address,
bidinvitations.documents_address_issue,
bidinvitations.bid_openning_address,
bidinvitations.procurement_ref_no,
bidinvitations.procurement_id,
bidinvitations.description_of_works,
bidinvitations.bid_security_amount,
bidinvitations.bid_security_currency,
bidinvitations.bid_documents_price,
bidinvitations.bid_documents_currency,
bidinvitations.author,
bidinvitations.isapproved,
bidinvitations.date_approved,
bidinvitations.dateadded,
bidinvitations.approvedby,
bidinvitations.approval_comments,
bidinvitations.isactive,
bidinvitations.bid_submission_deadline,
bidinvitations.bid_evaluation_to,
bidinvitations.bid_evaluation_from,
bidinvitations.display_of_beb_notice,
bidinvitations.contract_award_date,
bidinvitations.dateofconfirmationoffunds
FROM
(bidinvitations)
INNER JOIN procurement_plan_entries ON bidinvitations.procurement_id = procurement_plan_entries.id
INNER JOIN procurement_plans ON procurement_plan_entries.procurement_plan_id = procurement_plans.id
INNER JOIN pdes ON procurement_plans.pde_id = pdes.pdeid
WHERE
bidinvitations.isactive = 'Y' AND
bidinvitations.isapproved = 'Y' AND
bidinvitations.invitation_to_bid_date >= '".$from."' AND
bidinvitations.invitation_to_bid_date <= '".$to."'
ORDER BY id DESC
");

        }


        return $results;

    }

    function get_bid_submission_deadlines_by_month($from,$to,$pde=''){
        if($pde){
            $results=$this->custom_query("SELECT *
FROM
(bidinvitations)
INNER JOIN procurement_plan_entries ON bidinvitations.procurement_id = procurement_plan_entries.id
INNER JOIN procurement_plans ON procurement_plan_entries.procurement_plan_id = procurement_plans.id
INNER JOIN pdes ON procurement_plans.pde_id = pdes.pdeid

AND bid_submission_deadline >= '".$from."'
AND bid_submission_deadline <= '".$to."'
WHERE
bidinvitations.isactive = 'Y' AND
pdes.pdeid = ".$pde."
");
        }else{
            $results=$this->custom_query("SELECT *
FROM
(bidinvitations)
INNER JOIN procurement_plan_entries ON bidinvitations.procurement_id = procurement_plan_entries.id
INNER JOIN procurement_plans ON procurement_plan_entries.procurement_plan_id = procurement_plans.id
INNER JOIN pdes ON procurement_plans.pde_id = pdes.pdeid

AND bid_submission_deadline >= '".$from."'
AND bid_submission_deadline <= '".$to."'
WHERE
bidinvitations.isactive = 'Y'
");
        }


        return $results;
    }


    function get_bids_above_threshhold($from,$to,$pde='',$threshold=14)
{
    if ($pde) {
        $results = $this->custom_query("SELECT
bidinvitations.id,
bidinvitations.vote_no,
bidinvitations.initiated_by,
bidinvitations.date_initiated,
bidinvitations.bid_openning_date,
bidinvitations.pde_id,
bidinvitations.subject_of_procurement,
bidinvitations.cost_estimate,
bidinvitations.invitation_to_bid_date,
bidinvitations.pre_bid_meeting_date,
bidinvitations.cc_approval_date,
bidinvitations.bid_receipt_address,
bidinvitations.documents_inspection_address,
bidinvitations.documents_address_issue,
bidinvitations.bid_openning_address,
bidinvitations.procurement_ref_no,
bidinvitations.procurement_id,
bidinvitations.description_of_works,
bidinvitations.bid_security_amount,
bidinvitations.bid_security_currency,
bidinvitations.bid_documents_price,
bidinvitations.bid_documents_currency,
bidinvitations.author,
bidinvitations.isapproved,
bidinvitations.date_approved,
bidinvitations.dateadded,
bidinvitations.approvedby,
bidinvitations.approval_comments,
bidinvitations.isactive,
bidinvitations.bid_submission_deadline,
bidinvitations.bid_evaluation_to,
bidinvitations.bid_evaluation_from,
bidinvitations.display_of_beb_notice,
bidinvitations.contract_award_date,
bidinvitations.dateofconfirmationoffunds
FROM
bidinvitations
INNER JOIN procurement_plan_entries ON bidinvitations.procurement_id = procurement_plan_entries.id
INNER JOIN procurement_plans ON procurement_plan_entries.procurement_plan_id = procurement_plans.id
INNER JOIN pdes ON procurement_plans.pde_id = pdes.pdeid
WHERE
bidinvitations.bid_submission_deadline - bidinvitations.invitation_to_bid_date > '" . $threshold . "' AND
bidinvitations.date_approved >= '" . $from . "' AND
bidinvitations.date_approved <= '" . $to . "'
pdes.pdeid = '" . $pde . "'
ORDER BY id DESC
");

    } else {
        //if no pde is passed
        $results = $this->custom_query("SELECT
bidinvitations.id,
bidinvitations.vote_no,
bidinvitations.initiated_by,
bidinvitations.date_initiated,
bidinvitations.bid_openning_date,
bidinvitations.pde_id,
bidinvitations.subject_of_procurement,
bidinvitations.cost_estimate,
bidinvitations.invitation_to_bid_date,
bidinvitations.pre_bid_meeting_date,
bidinvitations.cc_approval_date,
bidinvitations.bid_receipt_address,
bidinvitations.documents_inspection_address,
bidinvitations.documents_address_issue,
bidinvitations.bid_openning_address,
bidinvitations.procurement_ref_no,
bidinvitations.procurement_id,
bidinvitations.description_of_works,
bidinvitations.bid_security_amount,
bidinvitations.bid_security_currency,
bidinvitations.bid_documents_price,
bidinvitations.bid_documents_currency,
bidinvitations.author,
bidinvitations.isapproved,
bidinvitations.date_approved,
bidinvitations.dateadded,
bidinvitations.approvedby,
bidinvitations.approval_comments,
bidinvitations.isactive,
bidinvitations.bid_submission_deadline,
bidinvitations.bid_evaluation_to,
bidinvitations.bid_evaluation_from,
bidinvitations.display_of_beb_notice,
bidinvitations.contract_award_date,
bidinvitations.dateofconfirmationoffunds
FROM
bidinvitations
INNER JOIN procurement_plan_entries ON bidinvitations.procurement_id = procurement_plan_entries.id
INNER JOIN procurement_plans ON procurement_plan_entries.procurement_plan_id = procurement_plans.id
INNER JOIN pdes ON procurement_plans.pde_id = pdes.pdeid
WHERE
bidinvitations.bid_submission_deadline - bidinvitations.invitation_to_bid_date > '" . $threshold . "' AND
bidinvitations.date_approved >= '" . $from . "' AND
bidinvitations.date_approved <= '" . $to . "'
ORDER BY id DESC

");



    }
    return $results;
}


    function get_bids_below_threshhold($from,$to,$pde='',$threshold=14)
    {
        if ($pde) {
            $results = $this->custom_query("SELECT
bidinvitations.id,
bidinvitations.vote_no,
bidinvitations.initiated_by,
bidinvitations.date_initiated,
bidinvitations.bid_openning_date,
bidinvitations.pde_id,
bidinvitations.subject_of_procurement,
bidinvitations.cost_estimate,
bidinvitations.invitation_to_bid_date,
bidinvitations.pre_bid_meeting_date,
bidinvitations.cc_approval_date,
bidinvitations.bid_receipt_address,
bidinvitations.documents_inspection_address,
bidinvitations.documents_address_issue,
bidinvitations.bid_openning_address,
bidinvitations.procurement_ref_no,
bidinvitations.procurement_id,
bidinvitations.description_of_works,
bidinvitations.bid_security_amount,
bidinvitations.bid_security_currency,
bidinvitations.bid_documents_price,
bidinvitations.bid_documents_currency,
bidinvitations.author,
bidinvitations.isapproved,
bidinvitations.date_approved,
bidinvitations.dateadded,
bidinvitations.approvedby,
bidinvitations.approval_comments,
bidinvitations.isactive,
bidinvitations.bid_submission_deadline,
bidinvitations.bid_evaluation_to,
bidinvitations.bid_evaluation_from,
bidinvitations.display_of_beb_notice,
bidinvitations.contract_award_date,
bidinvitations.dateofconfirmationoffunds
FROM
bidinvitations
INNER JOIN procurement_plan_entries ON bidinvitations.procurement_id = procurement_plan_entries.id
INNER JOIN procurement_plans ON procurement_plan_entries.procurement_plan_id = procurement_plans.id
INNER JOIN pdes ON procurement_plans.pde_id = pdes.pdeid
WHERE
bidinvitations.bid_submission_deadline - bidinvitations.invitation_to_bid_date < " . $threshold . " AND
bidinvitations.date_approved >= '" . $from . "' AND
bidinvitations.date_approved <= '" . $to . "'
pdes.pdeid = " . $pde . "
ORDER BY id DESC
");
        } else {
            //if no pde is passed
            $results = $this->custom_query("SELECT
bidinvitations.id,
bidinvitations.vote_no,
bidinvitations.initiated_by,
bidinvitations.date_initiated,
bidinvitations.bid_openning_date,
bidinvitations.pde_id,
bidinvitations.subject_of_procurement,
bidinvitations.cost_estimate,
bidinvitations.invitation_to_bid_date,
bidinvitations.pre_bid_meeting_date,
bidinvitations.cc_approval_date,
bidinvitations.bid_receipt_address,
bidinvitations.documents_inspection_address,
bidinvitations.documents_address_issue,
bidinvitations.bid_openning_address,
bidinvitations.procurement_ref_no,
bidinvitations.procurement_id,
bidinvitations.description_of_works,
bidinvitations.bid_security_amount,
bidinvitations.bid_security_currency,
bidinvitations.bid_documents_price,
bidinvitations.bid_documents_currency,
bidinvitations.author,
bidinvitations.isapproved,
bidinvitations.date_approved,
bidinvitations.dateadded,
bidinvitations.approvedby,
bidinvitations.approval_comments,
bidinvitations.isactive,
bidinvitations.bid_submission_deadline,
bidinvitations.bid_evaluation_to,
bidinvitations.bid_evaluation_from,
bidinvitations.display_of_beb_notice,
bidinvitations.contract_award_date,
bidinvitations.dateofconfirmationoffunds
FROM
bidinvitations
INNER JOIN procurement_plan_entries ON bidinvitations.procurement_id = procurement_plan_entries.id
INNER JOIN procurement_plans ON procurement_plan_entries.procurement_plan_id = procurement_plans.id
INNER JOIN pdes ON procurement_plans.pde_id = pdes.pdeid
WHERE
bidinvitations.bid_submission_deadline - bidinvitations.invitation_to_bid_date < " . $threshold . " AND
bidinvitations.date_approved >= '" . $from . "' AND
bidinvitations.date_approved <= '" . $to . "'

");



        }
        return $results;
    }

    function get_bids_equal_to_threshhold($from,$to,$pde='',$threshold=14)
    {
        if ($pde) {
            $results = $this->custom_query("SELECT
bidinvitations.id,
bidinvitations.vote_no,
bidinvitations.initiated_by,
bidinvitations.date_initiated,
bidinvitations.bid_openning_date,
bidinvitations.pde_id,
bidinvitations.subject_of_procurement,
bidinvitations.cost_estimate,
bidinvitations.invitation_to_bid_date,
bidinvitations.pre_bid_meeting_date,
bidinvitations.cc_approval_date,
bidinvitations.bid_receipt_address,
bidinvitations.documents_inspection_address,
bidinvitations.documents_address_issue,
bidinvitations.bid_openning_address,
bidinvitations.procurement_ref_no,
bidinvitations.procurement_id,
bidinvitations.description_of_works,
bidinvitations.bid_security_amount,
bidinvitations.bid_security_currency,
bidinvitations.bid_documents_price,
bidinvitations.bid_documents_currency,
bidinvitations.author,
bidinvitations.isapproved,
bidinvitations.date_approved,
bidinvitations.dateadded,
bidinvitations.approvedby,
bidinvitations.approval_comments,
bidinvitations.isactive,
bidinvitations.bid_submission_deadline,
bidinvitations.bid_evaluation_to,
bidinvitations.bid_evaluation_from,
bidinvitations.display_of_beb_notice,
bidinvitations.contract_award_date,
bidinvitations.dateofconfirmationoffunds
FROM
bidinvitations
INNER JOIN procurement_plan_entries ON bidinvitations.procurement_id = procurement_plan_entries.id
INNER JOIN procurement_plans ON procurement_plan_entries.procurement_plan_id = procurement_plans.id
INNER JOIN pdes ON procurement_plans.pde_id = pdes.pdeid
WHERE
bidinvitations.bid_submission_deadline - bidinvitations.invitation_to_bid_date = " . $threshold . " AND
bidinvitations.date_approved >= '" . $from . "' AND
bidinvitations.date_approved <= '" . $to . "' AND
pdes.pdeid = " . $pde . "
ORDER BY id DESC
");
        } else {
            //if no pde is passed
            $results = $this->custom_query("SELECT
bidinvitations.id,
bidinvitations.vote_no,
bidinvitations.initiated_by,
bidinvitations.date_initiated,
bidinvitations.bid_openning_date,
bidinvitations.pde_id,
bidinvitations.subject_of_procurement,
bidinvitations.cost_estimate,
bidinvitations.invitation_to_bid_date,
bidinvitations.pre_bid_meeting_date,
bidinvitations.cc_approval_date,
bidinvitations.bid_receipt_address,
bidinvitations.documents_inspection_address,
bidinvitations.documents_address_issue,
bidinvitations.bid_openning_address,
bidinvitations.procurement_ref_no,
bidinvitations.procurement_id,
bidinvitations.description_of_works,
bidinvitations.bid_security_amount,
bidinvitations.bid_security_currency,
bidinvitations.bid_documents_price,
bidinvitations.bid_documents_currency,
bidinvitations.author,
bidinvitations.isapproved,
bidinvitations.date_approved,
bidinvitations.dateadded,
bidinvitations.approvedby,
bidinvitations.approval_comments,
bidinvitations.isactive,
bidinvitations.bid_submission_deadline,
bidinvitations.bid_evaluation_to,
bidinvitations.bid_evaluation_from,
bidinvitations.display_of_beb_notice,
bidinvitations.contract_award_date,
bidinvitations.dateofconfirmationoffunds
FROM
bidinvitations
INNER JOIN procurement_plan_entries ON bidinvitations.procurement_id = procurement_plan_entries.id
INNER JOIN procurement_plans ON procurement_plan_entries.procurement_plan_id = procurement_plans.id
INNER JOIN pdes ON procurement_plans.pde_id = pdes.pdeid
WHERE
bidinvitations.bid_submission_deadline - bidinvitations.invitation_to_bid_date = " . $threshold . " AND
bidinvitations.date_approved >= '" . $from . "' AND
bidinvitations.date_approved <= '" . $to . "'

");



        }
        return $results;
    }


    function get_published_bids_by_month($from,$to,$pde=''){

        if($pde){
            $results= $this->custom_query("
        SELECT
receipts.receiptid,
receipts.bid_id,
receipts.providerid,
receipts.details,
receipts.received_by,
receipts.datereceived,
receipts.approved,
receipts.nationality,
receipts.author,
receipts.dateadded,
receipts.beb,
receipts.reason,
receipts.isactive,
receipts.joint_venture,
receipts.readoutprice,
receipts.currence,
providers.providerid,
providers.providernames,
bidinvitations.id,
bidinvitations.vote_no,
bidinvitations.initiated_by,
bidinvitations.date_initiated,
bidinvitations.bid_openning_date,
bidinvitations.pde_id,
bidinvitations.subject_of_procurement,
bidinvitations.cost_estimate,
bidinvitations.invitation_to_bid_date,
bidinvitations.pre_bid_meeting_date,
bidinvitations.cc_approval_date,
bidinvitations.bid_receipt_address,
bidinvitations.documents_inspection_address,
bidinvitations.documents_address_issue,
bidinvitations.bid_openning_address,
bidinvitations.procurement_ref_no,
bidinvitations.procurement_id,
bidinvitations.description_of_works,
bidinvitations.bid_security_amount,
bidinvitations.bid_security_currency,
bidinvitations.bid_documents_price,
bidinvitations.bid_documents_currency,
bidinvitations.author,
bidinvitations.isapproved,
bidinvitations.date_approved,
bidinvitations.dateadded,
bidinvitations.approvedby,
bidinvitations.approval_comments,
bidinvitations.isactive,
bidinvitations.bid_submission_deadline,
bidinvitations.bid_evaluation_to,
bidinvitations.bid_evaluation_from,
bidinvitations.display_of_beb_notice,
bidinvitations.contract_award_date,
bidinvitations.dateofconfirmationoffunds,
procurement_plan_entries.id,
procurement_plan_entries.subject_of_procurement,
procurement_plan_entries.procurement_type,
procurement_plan_entries.procurement_method,
procurement_plan_entries.pde_department,
procurement_plan_entries.funding_source,
procurement_plan_entries.funder_name,
procurement_plan_entries.procurement_ref_no,
procurement_plan_entries.estimated_amount,
procurement_plan_entries.currency,
procurement_plan_entries.exchange_rate,
procurement_plan_entries.pre_bid_events_date,
procurement_plan_entries.pre_bid_events_duration,
procurement_plan_entries.contracts_committee_approval_date,
procurement_plan_entries.contracts_committee_approval_date_duration,
procurement_plan_entries.publication_of_pre_qualification_date,
procurement_plan_entries.publication_of_pre_qualification_date_duration,
procurement_plan_entries.proposal_submission_date,
procurement_plan_entries.proposal_submission_date_duration,
procurement_plan_entries.contracts_committee_approval_of_shortlist_date,
procurement_plan_entries.contracts_committee_approval_of_shortlist_date_duration,
procurement_plan_entries.bid_issue_date,
procurement_plan_entries.bid_issue_date_duration,
procurement_plan_entries.bid_submission_opening_date,
procurement_plan_entries.bid_submission_opening_date_duration,
procurement_plan_entries.secure_necessary_approval_date,
procurement_plan_entries.secure_necessary_approval_date_duration,
procurement_plan_entries.contract_award,
procurement_plan_entries.contract_award_duration,
procurement_plan_entries.performance_security,
procurement_plan_entries.best_evaluated_bidder_date,
procurement_plan_entries.best_evaluated_bidder_date_duration,
procurement_plan_entries.contract_sign_date,
procurement_plan_entries.contract_sign_duration,
procurement_plan_entries.submission_of_evaluation_report_to_cc,
procurement_plan_entries.cc_approval_of_evaluation_report,
procurement_plan_entries.accounting_officer_approval_date,
procurement_plan_entries.cc_approval_of_evaluation_report_duration,
procurement_plan_entries.negotiation_date,
procurement_plan_entries.negotiation_date_duration,
procurement_plan_entries.negotiation_approval_date,
procurement_plan_entries.negotiation_approval_date_duration,
procurement_plan_entries.advanced_payment_date,
procurement_plan_entries.advanced_payment_date_duration,
procurement_plan_entries.mobilise_advance_payment,
procurement_plan_entries.mobilise_advance_payment_duration,
procurement_plan_entries.substantial_completion,
procurement_plan_entries.substantial_completion_duration,
procurement_plan_entries.final_acceptance,
procurement_plan_entries.final_acceptance_duration,
procurement_plan_entries.dateadded,
procurement_plan_entries.dateupdated,
procurement_plan_entries.updated_by,
procurement_plan_entries.isactive,
procurement_plan_entries.procurement_plan_id,
procurement_plan_entries.solicitor_general_approval_date,
procurement_plan_entries.solicitor_general_approval_duration,
procurement_plan_entries.contract_amount_in_ugx,
procurement_plan_entries.bid_closing_date,
procurement_plan_entries.author,
pdes.pdeid,
pdes.pdename,
pdes.abbreviation,
pdes.`status`,
pdes.create_date,
pdes.created_by,
pdes.category,
pdes.type,
pdes.`code`,
pdes.pde_roll_cat,
pdes.address,
pdes.tel,
pdes.fax,
pdes.email,
pdes.website,
pdes.AO,
pdes.AO_phone,
pdes.AO_email,
pdes.CC,
pdes.CC_phone,
pdes.CC_email,
pdes.head_PDU,
pdes.head_PDU_phone,
pdes.head_PDU_email,
pdes.isactive,
procurement_plans.id,
procurement_plans.pde_id,
procurement_plans.financial_year,
procurement_plans.title,
procurement_plans.summarized_plan,
procurement_plans.dateadded,
procurement_plans.dateupdated,
procurement_plans.author,
procurement_plans.isactive,
procurement_plans.description,
procurement_plans.public,
procurement_types.id,
procurement_types.title,
procurement_types.`code`,
procurement_types.slug,
procurement_types.evaluation_time,
procurement_types.dateadded,
procurement_types.dateupdated,
procurement_types.isactive
FROM
receipts
INNER JOIN providers ON receipts.providerid = providers.providerid
INNER JOIN bidinvitations ON receipts.bid_id = bidinvitations.id
INNER JOIN procurement_plan_entries ON bidinvitations.procurement_id = procurement_plan_entries.id
INNER JOIN procurement_plans ON procurement_plan_entries.procurement_plan_id = procurement_plans.id
INNER JOIN pdes ON procurement_plans.pde_id = pdes.pdeid
INNER JOIN procurement_types ON procurement_plan_entries.procurement_type = procurement_types.id
WHERE
receipts.beb = 'Y' AND
receipts.datereceived >= '" . $from . "' AND
receipts.datereceived <= '" . $to . "'  AND
pdes.pdeid = " . $pde . "
ORDER BY
receipts.receiptid DESC
");
        }
        else{
            $results= $this->custom_query("
        SELECT
receipts.receiptid,
receipts.bid_id,
receipts.providerid,
receipts.details,
receipts.received_by,
receipts.datereceived,
receipts.approved,
receipts.nationality,
receipts.author,
receipts.dateadded,
receipts.beb,
receipts.reason,
receipts.isactive,
receipts.joint_venture,
receipts.readoutprice,
receipts.currence,
providers.providerid,
providers.providernames,
bidinvitations.id,
bidinvitations.vote_no,
bidinvitations.initiated_by,
bidinvitations.date_initiated,
bidinvitations.bid_openning_date,
bidinvitations.pde_id,
bidinvitations.subject_of_procurement,
bidinvitations.cost_estimate,
bidinvitations.invitation_to_bid_date,
bidinvitations.pre_bid_meeting_date,
bidinvitations.cc_approval_date,
bidinvitations.bid_receipt_address,
bidinvitations.documents_inspection_address,
bidinvitations.documents_address_issue,
bidinvitations.bid_openning_address,
bidinvitations.procurement_ref_no,
bidinvitations.procurement_id,
bidinvitations.description_of_works,
bidinvitations.bid_security_amount,
bidinvitations.bid_security_currency,
bidinvitations.bid_documents_price,
bidinvitations.bid_documents_currency,
bidinvitations.author,
bidinvitations.isapproved,
bidinvitations.date_approved,
bidinvitations.dateadded,
bidinvitations.approvedby,
bidinvitations.approval_comments,
bidinvitations.isactive,
bidinvitations.bid_submission_deadline,
bidinvitations.bid_evaluation_to,
bidinvitations.bid_evaluation_from,
bidinvitations.display_of_beb_notice,
bidinvitations.contract_award_date,
bidinvitations.dateofconfirmationoffunds,
procurement_plan_entries.id,
procurement_plan_entries.subject_of_procurement,
procurement_plan_entries.procurement_type,
procurement_plan_entries.procurement_method,
procurement_plan_entries.pde_department,
procurement_plan_entries.funding_source,
procurement_plan_entries.funder_name,
procurement_plan_entries.procurement_ref_no,
procurement_plan_entries.estimated_amount,
procurement_plan_entries.currency,
procurement_plan_entries.exchange_rate,
procurement_plan_entries.pre_bid_events_date,
procurement_plan_entries.pre_bid_events_duration,
procurement_plan_entries.contracts_committee_approval_date,
procurement_plan_entries.contracts_committee_approval_date_duration,
procurement_plan_entries.publication_of_pre_qualification_date,
procurement_plan_entries.publication_of_pre_qualification_date_duration,
procurement_plan_entries.proposal_submission_date,
procurement_plan_entries.proposal_submission_date_duration,
procurement_plan_entries.contracts_committee_approval_of_shortlist_date,
procurement_plan_entries.contracts_committee_approval_of_shortlist_date_duration,
procurement_plan_entries.bid_issue_date,
procurement_plan_entries.bid_issue_date_duration,
procurement_plan_entries.bid_submission_opening_date,
procurement_plan_entries.bid_submission_opening_date_duration,
procurement_plan_entries.secure_necessary_approval_date,
procurement_plan_entries.secure_necessary_approval_date_duration,
procurement_plan_entries.contract_award,
procurement_plan_entries.contract_award_duration,
procurement_plan_entries.performance_security,
procurement_plan_entries.best_evaluated_bidder_date,
procurement_plan_entries.best_evaluated_bidder_date_duration,
procurement_plan_entries.contract_sign_date,
procurement_plan_entries.contract_sign_duration,
procurement_plan_entries.submission_of_evaluation_report_to_cc,
procurement_plan_entries.cc_approval_of_evaluation_report,
procurement_plan_entries.accounting_officer_approval_date,
procurement_plan_entries.cc_approval_of_evaluation_report_duration,
procurement_plan_entries.negotiation_date,
procurement_plan_entries.negotiation_date_duration,
procurement_plan_entries.negotiation_approval_date,
procurement_plan_entries.negotiation_approval_date_duration,
procurement_plan_entries.advanced_payment_date,
procurement_plan_entries.advanced_payment_date_duration,
procurement_plan_entries.mobilise_advance_payment,
procurement_plan_entries.mobilise_advance_payment_duration,
procurement_plan_entries.substantial_completion,
procurement_plan_entries.substantial_completion_duration,
procurement_plan_entries.final_acceptance,
procurement_plan_entries.final_acceptance_duration,
procurement_plan_entries.dateadded,
procurement_plan_entries.dateupdated,
procurement_plan_entries.updated_by,
procurement_plan_entries.isactive,
procurement_plan_entries.procurement_plan_id,
procurement_plan_entries.solicitor_general_approval_date,
procurement_plan_entries.solicitor_general_approval_duration,
procurement_plan_entries.contract_amount_in_ugx,
procurement_plan_entries.bid_closing_date,
procurement_plan_entries.author,
pdes.pdeid,
pdes.pdename,
pdes.abbreviation,
pdes.`status`,
pdes.create_date,
pdes.created_by,
pdes.category,
pdes.type,
pdes.`code`,
pdes.pde_roll_cat,
pdes.address,
pdes.tel,
pdes.fax,
pdes.email,
pdes.website,
pdes.AO,
pdes.AO_phone,
pdes.AO_email,
pdes.CC,
pdes.CC_phone,
pdes.CC_email,
pdes.head_PDU,
pdes.head_PDU_phone,
pdes.head_PDU_email,
pdes.isactive,
procurement_plans.id,
procurement_plans.pde_id,
procurement_plans.financial_year,
procurement_plans.title,
procurement_plans.summarized_plan,
procurement_plans.dateadded,
procurement_plans.dateupdated,
procurement_plans.author,
procurement_plans.isactive,
procurement_plans.description,
procurement_plans.public,
procurement_types.id,
procurement_types.title,
procurement_types.`code`,
procurement_types.slug,
procurement_types.evaluation_time,
procurement_types.dateadded,
procurement_types.dateupdated,
procurement_types.isactive
FROM
receipts
INNER JOIN providers ON receipts.providerid = providers.providerid
INNER JOIN bidinvitations ON receipts.bid_id = bidinvitations.id
INNER JOIN procurement_plan_entries ON bidinvitations.procurement_id = procurement_plan_entries.id
INNER JOIN procurement_plans ON procurement_plan_entries.procurement_plan_id = procurement_plans.id
INNER JOIN pdes ON procurement_plans.pde_id = pdes.pdeid
INNER JOIN procurement_types ON procurement_plan_entries.procurement_type = procurement_types.id
WHERE
receipts.beb = 'Y' AND
receipts.datereceived >= '" . $from . "' AND
receipts.datereceived <= '" . $to . "'
ORDER BY
receipts.receiptid DESC

");
        }


        return $results;
    }


    function get_expired_bids_by_month($from,$to,$pde=''){

        if($pde){
            $results= $this->custom_query("
        SELECT
receipts.receiptid,
receipts.bid_id,
receipts.providerid,
receipts.details,
receipts.received_by,
receipts.datereceived,
receipts.approved,
receipts.nationality,
receipts.author,
receipts.dateadded,
receipts.beb,
receipts.reason,
receipts.isactive,
receipts.joint_venture,
receipts.readoutprice,
receipts.currence,
providers.providerid,
providers.providernames,
bidinvitations.id,
bidinvitations.vote_no,
bidinvitations.initiated_by,
bidinvitations.date_initiated,
bidinvitations.bid_openning_date,
bidinvitations.pde_id,
bidinvitations.subject_of_procurement,
bidinvitations.cost_estimate,
bidinvitations.invitation_to_bid_date,
bidinvitations.pre_bid_meeting_date,
bidinvitations.cc_approval_date,
bidinvitations.bid_receipt_address,
bidinvitations.documents_inspection_address,
bidinvitations.documents_address_issue,
bidinvitations.bid_openning_address,
bidinvitations.procurement_ref_no,
bidinvitations.procurement_id,
bidinvitations.description_of_works,
bidinvitations.bid_security_amount,
bidinvitations.bid_security_currency,
bidinvitations.bid_documents_price,
bidinvitations.bid_documents_currency,
bidinvitations.author,
bidinvitations.isapproved,
bidinvitations.date_approved,
bidinvitations.dateadded,
bidinvitations.approvedby,
bidinvitations.approval_comments,
bidinvitations.isactive,
bidinvitations.bid_submission_deadline,
bidinvitations.bid_evaluation_to,
bidinvitations.bid_evaluation_from,
bidinvitations.display_of_beb_notice,
bidinvitations.contract_award_date,
bidinvitations.dateofconfirmationoffunds,
procurement_plan_entries.id,
procurement_plan_entries.subject_of_procurement,
procurement_plan_entries.procurement_type,
procurement_plan_entries.procurement_method,
procurement_plan_entries.pde_department,
procurement_plan_entries.funding_source,
procurement_plan_entries.funder_name,
procurement_plan_entries.procurement_ref_no,
procurement_plan_entries.estimated_amount,
procurement_plan_entries.currency,
procurement_plan_entries.exchange_rate,
procurement_plan_entries.pre_bid_events_date,
procurement_plan_entries.pre_bid_events_duration,
procurement_plan_entries.contracts_committee_approval_date,
procurement_plan_entries.contracts_committee_approval_date_duration,
procurement_plan_entries.publication_of_pre_qualification_date,
procurement_plan_entries.publication_of_pre_qualification_date_duration,
procurement_plan_entries.proposal_submission_date,
procurement_plan_entries.proposal_submission_date_duration,
procurement_plan_entries.contracts_committee_approval_of_shortlist_date,
procurement_plan_entries.contracts_committee_approval_of_shortlist_date_duration,
procurement_plan_entries.bid_issue_date,
procurement_plan_entries.bid_issue_date_duration,
procurement_plan_entries.bid_submission_opening_date,
procurement_plan_entries.bid_submission_opening_date_duration,
procurement_plan_entries.secure_necessary_approval_date,
procurement_plan_entries.secure_necessary_approval_date_duration,
procurement_plan_entries.contract_award,
procurement_plan_entries.contract_award_duration,
procurement_plan_entries.performance_security,
procurement_plan_entries.best_evaluated_bidder_date,
procurement_plan_entries.best_evaluated_bidder_date_duration,
procurement_plan_entries.contract_sign_date,
procurement_plan_entries.contract_sign_duration,
procurement_plan_entries.submission_of_evaluation_report_to_cc,
procurement_plan_entries.cc_approval_of_evaluation_report,
procurement_plan_entries.accounting_officer_approval_date,
procurement_plan_entries.cc_approval_of_evaluation_report_duration,
procurement_plan_entries.negotiation_date,
procurement_plan_entries.negotiation_date_duration,
procurement_plan_entries.negotiation_approval_date,
procurement_plan_entries.negotiation_approval_date_duration,
procurement_plan_entries.advanced_payment_date,
procurement_plan_entries.advanced_payment_date_duration,
procurement_plan_entries.mobilise_advance_payment,
procurement_plan_entries.mobilise_advance_payment_duration,
procurement_plan_entries.substantial_completion,
procurement_plan_entries.substantial_completion_duration,
procurement_plan_entries.final_acceptance,
procurement_plan_entries.final_acceptance_duration,
procurement_plan_entries.dateadded,
procurement_plan_entries.dateupdated,
procurement_plan_entries.updated_by,
procurement_plan_entries.isactive,
procurement_plan_entries.procurement_plan_id,
procurement_plan_entries.solicitor_general_approval_date,
procurement_plan_entries.solicitor_general_approval_duration,
procurement_plan_entries.contract_amount_in_ugx,
procurement_plan_entries.bid_closing_date,
procurement_plan_entries.author,
pdes.pdeid,
pdes.pdename,
pdes.abbreviation,
pdes.`status`,
pdes.create_date,
pdes.created_by,
pdes.category,
pdes.type,
pdes.`code`,
pdes.pde_roll_cat,
pdes.address,
pdes.tel,
pdes.fax,
pdes.email,
pdes.website,
pdes.AO,
pdes.AO_phone,
pdes.AO_email,
pdes.CC,
pdes.CC_phone,
pdes.CC_email,
pdes.head_PDU,
pdes.head_PDU_phone,
pdes.head_PDU_email,
pdes.isactive,
procurement_plans.id,
procurement_plans.pde_id,
procurement_plans.financial_year,
procurement_plans.title,
procurement_plans.summarized_plan,
procurement_plans.dateadded,
procurement_plans.dateupdated,
procurement_plans.author,
procurement_plans.isactive,
procurement_plans.description,
procurement_plans.public,
procurement_types.id,
procurement_types.title,
procurement_types.`code`,
procurement_types.slug,
procurement_types.evaluation_time,
procurement_types.dateadded,
procurement_types.dateupdated,
procurement_types.isactive
FROM
receipts
INNER JOIN providers ON receipts.providerid = providers.providerid
INNER JOIN bidinvitations ON receipts.bid_id = bidinvitations.id
INNER JOIN procurement_plan_entries ON bidinvitations.procurement_id = procurement_plan_entries.id
INNER JOIN procurement_plans ON procurement_plan_entries.procurement_plan_id = procurement_plans.id
INNER JOIN pdes ON procurement_plans.pde_id = pdes.pdeid
INNER JOIN procurement_types ON procurement_plan_entries.procurement_type = procurement_types.id
WHERE
receipts.beb = 'Y' AND
bidinvitations.bid_submission_deadline < '" . mysqldate() . "' AND
receipts.datereceived >= '" . $from . "' AND
receipts.datereceived <= '" . $to . "'  AND
pdes.pdeid = " . $pde . "
ORDER BY
receipts.receiptid DESC
");
        }
        else{
            $results= $this->custom_query("
        SELECT
receipts.receiptid,
receipts.bid_id,
receipts.providerid,
receipts.details,
receipts.received_by,
receipts.datereceived,
receipts.approved,
receipts.nationality,
receipts.author,
receipts.dateadded,
receipts.beb,
receipts.reason,
receipts.isactive,
receipts.joint_venture,
receipts.readoutprice,
receipts.currence,
providers.providerid,
providers.providernames,
bidinvitations.id,
bidinvitations.vote_no,
bidinvitations.initiated_by,
bidinvitations.date_initiated,
bidinvitations.bid_openning_date,
bidinvitations.pde_id,
bidinvitations.subject_of_procurement,
bidinvitations.cost_estimate,
bidinvitations.invitation_to_bid_date,
bidinvitations.pre_bid_meeting_date,
bidinvitations.cc_approval_date,
bidinvitations.bid_receipt_address,
bidinvitations.documents_inspection_address,
bidinvitations.documents_address_issue,
bidinvitations.bid_openning_address,
bidinvitations.procurement_ref_no,
bidinvitations.procurement_id,
bidinvitations.description_of_works,
bidinvitations.bid_security_amount,
bidinvitations.bid_security_currency,
bidinvitations.bid_documents_price,
bidinvitations.bid_documents_currency,
bidinvitations.author,
bidinvitations.isapproved,
bidinvitations.date_approved,
bidinvitations.dateadded,
bidinvitations.approvedby,
bidinvitations.approval_comments,
bidinvitations.isactive,
bidinvitations.bid_submission_deadline,
bidinvitations.bid_evaluation_to,
bidinvitations.bid_evaluation_from,
bidinvitations.display_of_beb_notice,
bidinvitations.contract_award_date,
bidinvitations.dateofconfirmationoffunds,
procurement_plan_entries.id,
procurement_plan_entries.subject_of_procurement,
procurement_plan_entries.procurement_type,
procurement_plan_entries.procurement_method,
procurement_plan_entries.pde_department,
procurement_plan_entries.funding_source,
procurement_plan_entries.funder_name,
procurement_plan_entries.procurement_ref_no,
procurement_plan_entries.estimated_amount,
procurement_plan_entries.currency,
procurement_plan_entries.exchange_rate,
procurement_plan_entries.pre_bid_events_date,
procurement_plan_entries.pre_bid_events_duration,
procurement_plan_entries.contracts_committee_approval_date,
procurement_plan_entries.contracts_committee_approval_date_duration,
procurement_plan_entries.publication_of_pre_qualification_date,
procurement_plan_entries.publication_of_pre_qualification_date_duration,
procurement_plan_entries.proposal_submission_date,
procurement_plan_entries.proposal_submission_date_duration,
procurement_plan_entries.contracts_committee_approval_of_shortlist_date,
procurement_plan_entries.contracts_committee_approval_of_shortlist_date_duration,
procurement_plan_entries.bid_issue_date,
procurement_plan_entries.bid_issue_date_duration,
procurement_plan_entries.bid_submission_opening_date,
procurement_plan_entries.bid_submission_opening_date_duration,
procurement_plan_entries.secure_necessary_approval_date,
procurement_plan_entries.secure_necessary_approval_date_duration,
procurement_plan_entries.contract_award,
procurement_plan_entries.contract_award_duration,
procurement_plan_entries.performance_security,
procurement_plan_entries.best_evaluated_bidder_date,
procurement_plan_entries.best_evaluated_bidder_date_duration,
procurement_plan_entries.contract_sign_date,
procurement_plan_entries.contract_sign_duration,
procurement_plan_entries.submission_of_evaluation_report_to_cc,
procurement_plan_entries.cc_approval_of_evaluation_report,
procurement_plan_entries.accounting_officer_approval_date,
procurement_plan_entries.cc_approval_of_evaluation_report_duration,
procurement_plan_entries.negotiation_date,
procurement_plan_entries.negotiation_date_duration,
procurement_plan_entries.negotiation_approval_date,
procurement_plan_entries.negotiation_approval_date_duration,
procurement_plan_entries.advanced_payment_date,
procurement_plan_entries.advanced_payment_date_duration,
procurement_plan_entries.mobilise_advance_payment,
procurement_plan_entries.mobilise_advance_payment_duration,
procurement_plan_entries.substantial_completion,
procurement_plan_entries.substantial_completion_duration,
procurement_plan_entries.final_acceptance,
procurement_plan_entries.final_acceptance_duration,
procurement_plan_entries.dateadded,
procurement_plan_entries.dateupdated,
procurement_plan_entries.updated_by,
procurement_plan_entries.isactive,
procurement_plan_entries.procurement_plan_id,
procurement_plan_entries.solicitor_general_approval_date,
procurement_plan_entries.solicitor_general_approval_duration,
procurement_plan_entries.contract_amount_in_ugx,
procurement_plan_entries.bid_closing_date,
procurement_plan_entries.author,
pdes.pdeid,
pdes.pdename,
pdes.abbreviation,
pdes.`status`,
pdes.create_date,
pdes.created_by,
pdes.category,
pdes.type,
pdes.`code`,
pdes.pde_roll_cat,
pdes.address,
pdes.tel,
pdes.fax,
pdes.email,
pdes.website,
pdes.AO,
pdes.AO_phone,
pdes.AO_email,
pdes.CC,
pdes.CC_phone,
pdes.CC_email,
pdes.head_PDU,
pdes.head_PDU_phone,
pdes.head_PDU_email,
pdes.isactive,
procurement_plans.id,
procurement_plans.pde_id,
procurement_plans.financial_year,
procurement_plans.title,
procurement_plans.summarized_plan,
procurement_plans.dateadded,
procurement_plans.dateupdated,
procurement_plans.author,
procurement_plans.isactive,
procurement_plans.description,
procurement_plans.public,
procurement_types.id,
procurement_types.title,
procurement_types.`code`,
procurement_types.slug,
procurement_types.evaluation_time,
procurement_types.dateadded,
procurement_types.dateupdated,
procurement_types.isactive
FROM
receipts
INNER JOIN providers ON receipts.providerid = providers.providerid
INNER JOIN bidinvitations ON receipts.bid_id = bidinvitations.id
INNER JOIN procurement_plan_entries ON bidinvitations.procurement_id = procurement_plan_entries.id
INNER JOIN procurement_plans ON procurement_plan_entries.procurement_plan_id = procurement_plans.id
INNER JOIN pdes ON procurement_plans.pde_id = pdes.pdeid
INNER JOIN procurement_types ON procurement_plan_entries.procurement_type = procurement_types.id
WHERE
receipts.beb = 'Y' AND
bidinvitations.bid_submission_deadline < '" . mysqldate() . "' AND
receipts.datereceived >= '" . $from . "' AND
receipts.datereceived <= '" . $to . "'
ORDER BY
receipts.receiptid DESC

");
        }


        return $results;
    }







}