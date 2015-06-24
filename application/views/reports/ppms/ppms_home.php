<?php
//print_array($_POST);
//print_array($this->session->all_userdata());
//print_array(get_pde_info_by_id($this->session->userdata('pdeid'),'title'))
//print_array($results);
if(isset($errors)){
    echo error_template($errors);
}

if(isset($results)){
//print_array($_POST);
    //switch by report type
    switch($this->input->post('report_type')){
        //case ot timelines of contract completion
        case "timeliness_of_contract_completion":
            //load the timeliness_of_contract_completion report view
            $this->load->view('reports/ppms/timeliness_of_contract_completion_v');
            break;
        //procurement_lead_time_report
        case "procurement_lead_time_report":
            $this->load->view('reports/ppms/procurement_lead_time_report_v');
            break;
        //contracts_completed_within_original_value
        case "contracts_completed_within_original_value":
            $this->load->view('reports/ppms/contracts_completed_within_original_value_v');
            break;
        case "average_number_of_bids_per_contract":
            $this->load->view('reports/ppms/average_number_of_bids_per_contract_v');
            break;
        default:
            echo info_template('Select report type from the form on the left');
    }
}
