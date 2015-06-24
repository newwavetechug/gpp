<?php
ob_start();
?>
<?php

/**
 * Created by PhpStorm.
 * User: cengkuru
 * Date: 1/15/2015
 * Time: 10:31 AM
 */
class Procurement extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('procurement_plan_m');
        $this->load->model('procurement_plan_entry_m');
        $this->load->model('notification_m');
        $this->load->model('procurement_plan_status_m');
        $this->load->model('notification_m');
        $this->load->model('sys_file', 'sysfile');

        access_control($this);
    }

    //procurement dashboard
    //admin home page
    function index()
    {
        //redirect to page
        redirect(base_url() . $this->uri->segment(1) . '/page');
    }

    function page()
    {
        # Get the passed details into the url data array if any
        $urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

        # Pick all assigned data
        $data = assign_to_data($urldata);
       # print_r($data);
       # exit();

        #Get the paginated list of the news items
        $data = add_msg_if_any($this, $data);

        //if user has permission
        if (check_user_access($this, 'view_procurement_plans')) 
        {
            $search_str = '';
            if($this->session->userdata('isadmin') == 'N')
            {
                $userdata = $this->db->get_where('users', array('userid'=>$this->session->userdata('userid')))->result_array();
                $search_str = ' AND PP.pde_id="'. $userdata[0]['pde'] .'"';
            }
        
            
            #Get the paginated list of plans
             $data['procurement'] = paginate_list($this, $data, 'procurement_plans', array('orderby'=>'PP.financial_year DESC', 'searchstring'=>$search_str));
            #exit($this->db->last_query());
            $data['page_title'] = 'Manage procurement plans';
            $data['current_menu'] = 'view_procurement_plans';
            $data['view_to_load'] = 'procurement/admin/all_procurement_plans_v';
            $data['view_data']['form_title'] = $data['page_title'];
            $this->load->view('dashboard_v', $data);
            
        } else {
            //load access denied page
            load_restriction_page();

        }


    }


    function procurement_plan_form()
    {
        #check user access
        if (!empty($data['i']))
        {
            check_user_access($this, 'edit_procurement_plan', 'redirect');
        }
        else
        {
            check_user_access($this, 'create_procurement_plan', 'redirect');
        }
        
        
        # Get the passed details into the url data array if any
        $urldata = $this->uri->uri_to_assoc(3, array('m'));

        # Pick all assigned data
        $data = assign_to_data($urldata);

        #user is editing
        if (!empty($data['i'])) {
            $plan_id = decryptValue($data['i']);
            $data['formdata'] = $this->Query_reader->get_row_as_array('search_table', array('table' => 'procurement_plans', 'limittext' => '', 'orderby' => 'id', 'searchstring' => ' id="' . $plan_id . '" AND isactive="Y"'));

            #get procurement plan details
            if (empty($data['formdata']) || (!empty($data['formdata']['pde_id']) && $data['formdata']['pde_id'] != $this->session->userdata('userid') && $this->session->userdata('isadmin') == 'Y'))
            {
                $data['msg'] = "ERROR: Invalid procurement plan access";
                $this->session->set_userdata('sres', $data['msg']);
                redirect('user/dashboard/m/sres');
            }
            else
            {
               #format financial year
               $financial_year = explode('-', $data['formdata']['financial_year']);
               $data['formdata']['start_year'] = $financial_year[0];
               $data['formdata']['end_year'] = $financial_year[1];
            }
        }

        $data['page_title'] = (!empty($data['i'])? 'Edit ' : ' New ' ) . get_pde_info_by_id(get_user_info_by_id($this->session->userdata('userid'), 'pde'), 'title') . ' Procurement Plan';
        $data['current_menu'] = 'create_procurement_plan';
        $data['pde_title'] = get_pde_info_by_id(get_user_info_by_id($this->session->userdata('userid'), 'pde'), 'title');
        $data['pde_id'] = get_user_info_by_id($this->session->userdata('userid'), 'pde');
        $data['view_to_load'] = 'procurement/admin/new_plan_v';
        $data['view_data']['form_title'] = $data['page_title'];
        $this->load->view('dashboard_v', $data);
    }


    function save_procurement_plan()
    {
        #check user access
        if (!empty($data['i']))
        {
            check_user_access($this, 'edit_procurement_plan', 'redirect');
        }
        else
        {
            check_user_access($this, 'create_procurement_plan', 'redirect');
        }

        # Get the passed details into the url data array if any
        $urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

        # Pick all assigned data
        $data = assign_to_data($urldata);

        //if there is an ajax post
        if ($this->input->post('ajax') || $this->input->post('save_plan')) {

            $data['msg'] = '';

            $this->form_validation->set_rules($this->procurement_plan_m->validate_plan);

            $data['formdata'] = $_POST;

            if ($this->form_validation->run() == FALSE) {
                //if there were errors add them to the errors array
                $data['msg'] .= validation_errors();

            } else {
                // print_array($_POST);
                //ensure that no previous year is entered
                if ($this->input->post('start_year') < 1900) {
                    $data['msg'] = 'ERROR: You can not make a plan for past years';
                } else {
                    $financial_year = trim($this->input->post('start_year')) . '-' . trim($this->input->post('end_year'));
                    //check for duplicity

                    if($this->session->userdata('isadmin') == 'Y' && !empty($data['i']))
                    {
                        $plan_info = $this->Query_reader->get_row_as_array('search_table', array('table' => 'procurement_plans', 'limittext' => '', 'orderby' => 'id', 'searchstring' => ' id="' . decryptValue($data['i']) . '" AND isactive="Y"'));
                        $plan_pde = $plan_info['pde_id'];
                    }
                    else
                    {
                        $plan_pde = $this->session->userdata('pdeid');
                    }

                    $similar_plan = $this->db->query($this->Query_reader->get_query_by_code('search_table', array('table'=>' procurement_plans', 'orderby'=>'   dateadded', 'limittext' =>'',
                                    'searchstring' => ' financial_year = "'. $financial_year .'" AND pde_id = "'. $plan_pde .'" AND isactive="Y"' . (!empty($data['i'])? ' AND id !="' . decryptValue($data['i']) . '"' : ''))))->result_array();
                    #exit($this->db->last_query());
                    if ($similar_plan) {
                        $data['msg'] = 'ERROR: There is already a plan for the year ' . $financial_year;
                    } //ensure its an annual plan
                    elseif ($this->input->post('end_year') <> ($this->input->post('start_year') + 1)) {
                        $data['msg'] = 'ERROR: Invalid end year';
                        //print_array($_POST);
                    } else {
                        $plan_data = array
                        (
                            'pde_id' => get_user_info_by_id($this->session->userdata('userid'), 'pde'),
                            'financial_year' => $financial_year,
                            'title' => $this->input->post('title'),
                            'author' => $this->session->userdata('userid'),
                            'description' => $this->input->post('description'),
                            //'dateupdated'=>''

                        );

                        $this->session->set_userdata('local_allowed_extensions', array('.xls', '.xlsx'));
                        $extramsg = "";
                        $MAX_FILE_SIZE = 1000000;
                        $MAX_FILE_ROWS = 1000;

                        #summarized plan
                        if (!empty($_FILES['summarized_plan']['name'])) {
                            $new_file_name = 'summarizedplan_' . $_POST['start_year'] . '_' . $_POST['end_year'] . '_' .
                                strtotime('now') . generate_random_letter();

                            $plan_data['summarized_plan'] = (!empty($_FILES['summarized_plan']['name'])) ? $this->sysfile->local_file_upload($_FILES['summarized_plan'], $new_file_name, 'documents/summarizedplans', 'filename') : '';

                        }
                        
                        #detailed plan as well
                        if (!empty($_FILES['detailed_plan']['name']))
                        {
                            $new_plan_name = 'detailed_plan_' . 'Upload_' . strtotime('now') . generate_random_letter();

                            $_POST['detailed_plan'] = (!empty($_FILES['detailed_plan']['name'])) ? $this->sysfile->local_file_upload($_FILES['detailed_plan'], $new_plan_name, 'documents', 'filename') : '';
                        }


                        #user is editing
                        if(!empty($_FILES['summarized_plan']['name']) && empty($plan_data['summarized_plan']))
                        {
                            $data['msg'] = 'ERROR: '.$this->sysfile->processing_errors;
                        }
                        elseif(!empty($_FILES['detailed_plan']['name']) && empty($_POST['detailed_plan']))
                        {
                            $data['msg'] = 'ERROR: '.$this->sysfile->processing_errors;
                        }
                        elseif(!empty($data['i']))
                        {
                            $project_plan = decryptValue($data['i']);
                            $result = $this->procurement_plan_m->update($project_plan, $plan_data);
                            $result = decryptValue($data['i']);
                        }
                        #new plan
                        else
                        {
                            $project_plan = $this->procurement_plan_m->create($plan_data);
                            $result = $project_plan;
                        }



                        if (!empty($result) && $result) {
                            if (!empty($_POST['detailed_plan'])) {
                                $file_url = UPLOAD_DIRECTORY . "documents/" . $_POST['detailed_plan'];
                                $file_size = filesize($file_url);

                                #Break up file if it is bigger than allowed
                                if ($file_size > $MAX_FILE_SIZE) {
                                    $data['file_siblings'] = $this->sysfile->break_up_file($file_url, $MAX_FILE_ROWS);
                                    $this->session->set_userdata('file_siblings', $data['file_siblings']);
                                    $msg = "WARNING: The uploaded file exceeded single processing requirements and was <br>broken up into " . count($data['file_siblings']) . " files. <br><br>Please click on each file, one at a time, to update the procurement plan and <br><a href='" . base_url() . "grades/manage_grades' class='bluelink' style='font-size:17px;'>click here</a> to refresh.";
                                } #Move the file data
                                else {
                                    $result_array = read_excel_data($file_url);

                                    #Remove file after upload
                                    @unlink($file_url);

                                    if (count($result_array)) {
                                        #1. format insert string

                                        #2. sheet 1 is supplies
                                        if (!empty($result_array['Supplies']) && count($result_array['Supplies']) > 9) {
                                            #$project_plan = $this->procurement_plan_entry_m->create_bulk($plan_data);
                                            $sheet_info = $result_array['Supplies'];

                                            $supplies_ins_str = '';

                                            $last_proc_ref_no = procurement_plan_ref_number_hint($this->session->userdata('pdeid'), 1, $financial_year, $project_plan);
                                            $last_proc_ref_no_parts = explode('/', $last_proc_ref_no);
                                            $last_proc_ref_figure = intval(end($last_proc_ref_no_parts));

                                            $rows = array();
                                            $row_ctr = 0;
                                            for ($i = 10; $i < count($sheet_info); $i++) {
                                                if (!empty($sheet_info[$i]['A']) && is_numeric($sheet_info[$i]['A']) && !empty($sheet_info[$i]['C'])) {
                                                    $rows[$row_ctr]['subject_of_procurement'] = $sheet_info[$i]['C'];
                                                    $rows[$row_ctr]['procurement_type'] = 1;
                                                    $rows[$row_ctr]['procurement_method'] = (($sheet_info[$i]['F'] = 'ODB') ? 2 : $sheet_info[$i]['F']);
                                                    $rows[$row_ctr]['pde_department'] = $sheet_info[9]['D'];
                                                    $rows[$row_ctr]['funding_source'] = $sheet_info[9]['E'];
                                                    $rows[$row_ctr]['funder_name'] = $sheet_info[9]['E'];

                                                    $last_proc_ref_no_parts[count($last_proc_ref_no_parts) - 1] = pad_string(++$last_proc_ref_figure, 4);
                                                    $rows[$row_ctr]['procurement_ref_no'] = implode('/', $last_proc_ref_no_parts);

                                                    $rows[$row_ctr]['estimated_amount'] = preg_replace("/[^0-9\.]/", '', $sheet_info[$i]['D']);
                                                    $rows[$row_ctr]['currency'] = 'usd';
                                                    $rows[$row_ctr]['pre_bid_events_date'] = format_excel_date($sheet_info[$i]['G']);
                                                    $rows[$row_ctr]['pre_bid_events_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[7]['G']);
                                                    $rows[$row_ctr]['contracts_committee_approval_date'] = format_excel_date($sheet_info[$i]['H']);
                                                    $rows[$row_ctr]['contracts_committee_approval_date_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[7]['H']);
                                                    $rows[$row_ctr]['publication_of_pre_qualification_date'] = format_excel_date($sheet_info[$i]['I']);
                                                    $rows[$row_ctr]['publication_of_pre_qualification_date_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[7]['I']);
                                                    $rows[$row_ctr]['proposal_submission_date'] = format_excel_date($sheet_info[$i]['J']);
                                                    $rows[$row_ctr]['proposal_submission_date_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[7]['J']);
                                                    $rows[$row_ctr]['contracts_committee_approval_of_shortlist_date'] = format_excel_date($sheet_info[$i]['L']);
                                                    $rows[$row_ctr]['contracts_committee_approval_of_shortlist_date_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[7]['L']);
                                                    $rows[$row_ctr]['bid_issue_date'] = format_excel_date($sheet_info[$i]['N']);
                                                    $rows[$row_ctr]['bid_issue_date_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[7]['N']);
                                                    $rows[$row_ctr]['bid_submission_opening_date'] = format_excel_date($sheet_info[$i]['N']);
                                                    $rows[$row_ctr]['bid_submission_opening_date_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[7]['N']);
                                                    $rows[$row_ctr]['secure_necessary_approval_date'] = '';
                                                    $rows[$row_ctr]['secure_necessary_approval_date_duration'] = '';

                                                    $rows[$row_ctr]['contract_award'] = format_excel_date($sheet_info[$i]['Y']);
                                                    $rows[$row_ctr]['contract_award_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[7]['Y']);
                                                    $rows[$row_ctr]['best_evaluated_bidder_date'] = format_excel_date($sheet_info[$i]['V']);
                                                    $rows[$row_ctr]['best_evaluated_bidder_date_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[7]['V']);
                                                    $rows[$row_ctr]['contract_sign_date'] = format_excel_date($sheet_info[$i]['V']);
                                                    $rows[$row_ctr]['contract_sign_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[7]['V']);
                                                    $rows[$row_ctr]['cc_approval_of_evaluation_report'] = format_excel_date($sheet_info[$i]['N']);
                                                    $rows[$row_ctr]['cc_approval_of_evaluation_report_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[7]['N']);
                                                    $rows[$row_ctr]['negotiation_date'] = format_excel_date($sheet_info[$i]['O']);
                                                    $rows[$row_ctr]['negotiation_date_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[7]['O']);
                                                    $rows[$row_ctr]['negotiation_approval_date'] = format_excel_date($sheet_info[$i]['P']);
                                                    $rows[$row_ctr]['negotiation_approval_date_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[7]['P']);
                                                    $rows[$row_ctr]['advanced_payment_date'] = '';
                                                    $rows[$row_ctr]['advanced_payment_date_duration'] = '';
                                                    $rows[$row_ctr]['mobilise_advance_payment'] = '';
                                                    $rows[$row_ctr]['mobilise_advance_payment_duration'] = '';
                                                    $rows[$row_ctr]['substantial_completion'] = '';
                                                    $rows[$row_ctr]['substantial_completion_duration'] = '';
                                                    $rows[$row_ctr]['final_acceptance'] = '';
                                                    $rows[$row_ctr]['final_acceptance_duration'] = '';
                                                    $rows[$row_ctr]['procurement_plan_id'] = $project_plan;
                                                    $rows[$row_ctr]['author'] = $this->session->userdata('userid');

                                                    $row_ctr++;
                                                }
                                            }

                                            $this->procurement_plan_entry_m->create_bulk($rows);
                                        }

                                        #3. sheet 2 is works
                                        if (!empty($result_array['Works'])) {
                                            #$project_plan = $this->procurement_plan_m->create_bulk($plan_data);

                                            #$project_plan = $this->procurement_plan_entry_m->create_bulk($plan_data);
                                            $sheet_info = $result_array['Supplies'];

                                            $supplies_ins_str = '';

                                            $last_proc_ref_no = procurement_plan_ref_number_hint($this->session->userdata('pdeid'), 1, $financial_year, $project_plan);
                                            $last_proc_ref_no_parts = explode('/', $last_proc_ref_no);
                                            $last_proc_ref_figure = intval(end($last_proc_ref_no_parts));

                                            $rows = array();
                                            $row_ctr = 0;
                                            for ($i = 7; $i < count($sheet_info); $i++) {
                                                if (!empty($sheet_info[$i]['A']) && is_numeric($sheet_info[$i]['A']) && !empty($sheet_info[$i]['C'])) {
                                                    $rows[$row_ctr]['subject_of_procurement'] = $sheet_info[$i]['C'];
                                                    $rows[$row_ctr]['procurement_type'] = 2;
                                                    $rows[$row_ctr]['procurement_method'] = (($sheet_info[$i]['F'] = 'ODB') ? 2 : $sheet_info[$i]['F']);
                                                    $rows[$row_ctr]['pde_department'] = $sheet_info[9]['D'];
                                                    $rows[$row_ctr]['funding_source'] = $sheet_info[9]['E'];
                                                    $rows[$row_ctr]['funder_name'] = $sheet_info[9]['E'];

                                                    $last_proc_ref_no_parts[count($last_proc_ref_no_parts) - 1] = pad_string(++$last_proc_ref_figure, 4);
                                                    $rows[$row_ctr]['procurement_ref_no'] = implode('/', $last_proc_ref_no_parts);

                                                    $rows[$row_ctr]['estimated_amount'] = preg_replace("/[^0-9\.]/", '', $sheet_info[$i]['D']);
                                                    $rows[$row_ctr]['currency'] = 'usd';
                                                    $rows[$row_ctr]['pre_bid_events_date'] = format_excel_date($sheet_info[$i]['G']);
                                                    $rows[$row_ctr]['pre_bid_events_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[7]['G']);
                                                    $rows[$row_ctr]['contracts_committee_approval_date'] = format_excel_date($sheet_info[$i]['H']);
                                                    $rows[$row_ctr]['contracts_committee_approval_date_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[7]['H']);
                                                    $rows[$row_ctr]['publication_of_pre_qualification_date'] = format_excel_date($sheet_info[$i]['I']);
                                                    $rows[$row_ctr]['publication_of_pre_qualification_date_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[7]['I']);
                                                    $rows[$row_ctr]['proposal_submission_date'] = format_excel_date($sheet_info[$i]['J']);
                                                    $rows[$row_ctr]['proposal_submission_date_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[7]['J']);
                                                    $rows[$row_ctr]['contracts_committee_approval_of_shortlist_date'] = format_excel_date($sheet_info[$i]['L']);
                                                    $rows[$row_ctr]['contracts_committee_approval_of_shortlist_date_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[7]['L']);
                                                    $rows[$row_ctr]['bid_issue_date'] = format_excel_date($sheet_info[$i]['N']);
                                                    $rows[$row_ctr]['bid_issue_date_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[7]['N']);
                                                    $rows[$row_ctr]['bid_submission_opening_date'] = format_excel_date($sheet_info[$i]['N']);
                                                    $rows[$row_ctr]['bid_submission_opening_date_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[7]['N']);
                                                    $rows[$row_ctr]['secure_necessary_approval_date'] = '';
                                                    $rows[$row_ctr]['secure_necessary_approval_date_duration'] = '';

                                                    $rows[$row_ctr]['contract_award'] = format_excel_date($sheet_info[$i]['Y']);
                                                    $rows[$row_ctr]['contract_award_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[7]['Y']);
                                                    $rows[$row_ctr]['best_evaluated_bidder_date'] = format_excel_date($sheet_info[$i]['V']);
                                                    $rows[$row_ctr]['best_evaluated_bidder_date_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[7]['V']);
                                                    $rows[$row_ctr]['contract_sign_date'] = format_excel_date($sheet_info[$i]['V']);
                                                    $rows[$row_ctr]['contract_sign_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[7]['V']);
                                                    $rows[$row_ctr]['cc_approval_of_evaluation_report'] = format_excel_date($sheet_info[$i]['N']);
                                                    $rows[$row_ctr]['cc_approval_of_evaluation_report_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[7]['N']);
                                                    $rows[$row_ctr]['negotiation_date'] = format_excel_date($sheet_info[$i]['O']);
                                                    $rows[$row_ctr]['negotiation_date_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[7]['O']);
                                                    $rows[$row_ctr]['negotiation_approval_date'] = format_excel_date($sheet_info[$i]['P']);
                                                    $rows[$row_ctr]['negotiation_approval_date_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[7]['P']);
                                                    $rows[$row_ctr]['advanced_payment_date'] = '';
                                                    $rows[$row_ctr]['advanced_payment_date_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[7]['AC']);
                                                    $rows[$row_ctr]['mobilise_advance_payment'] = format_excel_date($sheet_info[$i]['AA']);
                                                    $rows[$row_ctr]['mobilise_advance_payment_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[7]['AA']);
                                                    $rows[$row_ctr]['substantial_completion'] = format_excel_date($sheet_info[$i]['AB']);
                                                    $rows[$row_ctr]['substantial_completion_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[7]['AB']);
                                                    $rows[$row_ctr]['final_acceptance'] = format_excel_date($sheet_info[$i]['AC']);
                                                    $rows[$row_ctr]['final_acceptance_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[7]['AC']);
                                                    $rows[$row_ctr]['procurement_plan_id'] = $project_plan;
                                                    $rows[$row_ctr]['author'] = $this->session->userdata('userid');

                                                    $row_ctr++;
                                                }
                                            }

                                            $this->procurement_plan_entry_m->create_bulk($rows);
                                        }

                                        #4. sheet 3 is services
                                        if (!empty($result_array['Services'])) {
                                            $sheet_info = $result_array['Services'];

                                            $supplies_ins_str = '';

                                            $last_proc_ref_no = procurement_plan_ref_number_hint($this->session->userdata('pdeid'), 1, $financial_year, $project_plan);
                                            $last_proc_ref_no_parts = explode('/', $last_proc_ref_no);
                                            $last_proc_ref_figure = intval(end($last_proc_ref_no_parts));

                                            $rows = array();
                                            $row_ctr = 0;
                                            for ($i = 8; $i < count($sheet_info); $i++) {
                                                if (!empty($sheet_info[$i]['A']) && is_numeric($sheet_info[$i]['A']) && !empty($sheet_info[$i]['C'])) {
                                                    $rows[$row_ctr]['subject_of_procurement'] = $sheet_info[$i]['C'];
                                                    $rows[$row_ctr]['procurement_type'] = 3;
                                                    $rows[$row_ctr]['procurement_method'] = (($sheet_info[$i]['F'] = 'ODB') ? 2 : $sheet_info[$i]['F']);
                                                    $rows[$row_ctr]['pde_department'] = $sheet_info[9]['D'];
                                                    $rows[$row_ctr]['funding_source'] = $sheet_info[9]['E'];
                                                    $rows[$row_ctr]['funder_name'] = $sheet_info[9]['E'];

                                                    $last_proc_ref_no_parts[count($last_proc_ref_no_parts) - 1] = pad_string(++$last_proc_ref_figure, 4);
                                                    $rows[$row_ctr]['procurement_ref_no'] = implode('/', $last_proc_ref_no_parts);

                                                    $rows[$row_ctr]['estimated_amount'] = preg_replace("/[^0-9\.]/", '', $sheet_info[$i]['D']);
                                                    $rows[$row_ctr]['currency'] = 'usd';
                                                    $rows[$row_ctr]['pre_bid_events_date'] = format_excel_date($sheet_info[$i]['G']);
                                                    $rows[$row_ctr]['pre_bid_events_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[7]['G']);
                                                    $rows[$row_ctr]['contracts_committee_approval_date'] = format_excel_date($sheet_info[$i]['H']);
                                                    $rows[$row_ctr]['contracts_committee_approval_date_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[8]['H']);
                                                    $rows[$row_ctr]['publication_of_pre_qualification_date'] = format_excel_date($sheet_info[$i]['I']);
                                                    $rows[$row_ctr]['publication_of_pre_qualification_date_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[8]['I']);
                                                    $rows[$row_ctr]['proposal_submission_date'] = format_excel_date($sheet_info[$i]['J']);
                                                    $rows[$row_ctr]['proposal_submission_date_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[8]['J']);
                                                    $rows[$row_ctr]['contracts_committee_approval_of_shortlist_date'] = format_excel_date($sheet_info[$i]['L']);
                                                    $rows[$row_ctr]['contracts_committee_approval_of_shortlist_date_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[8]['L']);
                                                    $rows[$row_ctr]['bid_issue_date'] = format_excel_date($sheet_info[$i]['N']);
                                                    $rows[$row_ctr]['bid_issue_date_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[8]['N']);
                                                    $rows[$row_ctr]['bid_submission_opening_date'] = format_excel_date($sheet_info[$i]['N']);
                                                    $rows[$row_ctr]['bid_submission_opening_date_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[8]['N']);
                                                    $rows[$row_ctr]['bid_closing_date'] = preg_replace("/[^0-9\.]/", '', $sheet_info[8]['O']);

                                                    $rows[$row_ctr]['submission_of_evaluation_report_to_cc'] = format_excel_date($sheet_info[$i]['P']);
                                                    $rows[$row_ctr]['submission_of_evaluation_report_to_cc_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[8]['P']);

                                                    $rows[$row_ctr]['secure_necessary_approval_date'] = '';
                                                    $rows[$row_ctr]['secure_necessary_approval_date_duration'] = '';

                                                    $rows[$row_ctr]['contract_award'] = format_excel_date($sheet_info[$i]['X']);
                                                    $rows[$row_ctr]['contract_award_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[8]['X']);
                                                    $rows[$row_ctr]['best_evaluated_bidder_date'] = format_excel_date($sheet_info[$i]['V']);
                                                    $rows[$row_ctr]['best_evaluated_bidder_date_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[8]['V']);
                                                    $rows[$row_ctr]['contract_sign_date'] = format_excel_date($sheet_info[$i]['Y']);
                                                    $rows[$row_ctr]['contract_sign_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[8]['Y']);
                                                    $rows[$row_ctr]['cc_approval_of_evaluation_report'] = format_excel_date($sheet_info[$i]['N']);
                                                    $rows[$row_ctr]['cc_approval_of_evaluation_report_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[8]['N']);
                                                    $rows[$row_ctr]['contract_amount_in_ugx'] = preg_replace("/[^0-9\.]/", '', $sheet_info[$i]['U']);

                                                    $rows[$row_ctr]['negotiation_date'] = format_excel_date($sheet_info[$i]['R']);
                                                    $rows[$row_ctr]['negotiation_date_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[8]['R']);
                                                    $rows[$row_ctr]['negotiation_approval_date'] = format_excel_date($sheet_info[$i]['S']);
                                                    $rows[$row_ctr]['negotiation_approval_date_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[8]['S']);
                                                    $rows[$row_ctr]['advanced_payment_date'] = format_excel_date($sheet_info[$i]['AA']);
                                                    $rows[$row_ctr]['advanced_payment_date_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[8]['AA']);
                                                    $rows[$row_ctr]['mobilise_advance_payment'] = format_excel_date($sheet_info[$i]['AA']);
                                                    $rows[$row_ctr]['mobilise_advance_payment_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[8]['AA']);
                                                    $rows[$row_ctr]['substantial_completion'] = '';
                                                    $rows[$row_ctr]['substantial_completion_duration'] = '';
                                                    $rows[$row_ctr]['final_acceptance'] = '';
                                                    $rows[$row_ctr]['final_acceptance_duration'] = '';
                                                    $rows[$row_ctr]['procurement_plan_id'] = $project_plan;
                                                    $rows[$row_ctr]['author'] = $this->session->userdata('userid');

                                                    $rows[$row_ctr]['solicitor_general_approval_date'] = format_excel_date($sheet_info[$i]['AA']);
                                                    $rows[$row_ctr]['solicitor_general_approval_duration'] = preg_replace("/[^0-9\.]/", '', $sheet_info[8]['Y']);;
                                                    $row_ctr++;
                                                }
                                            }

                                            $this->procurement_plan_entry_m->create_bulk($rows);
                                        }
                                    }
                                }
                            }

                            //generate notification
                            #$recipients = get_users_by_group(20, get_user_info_by_id($this->session->userdata('userid'), 'pde'));
                            #$message = 'New financial plan <b>' . $this->input->post('title') . '</b> for the year ' . $financial_year . ' had been added by <b>' . get_user_info_by_id($this->session->userdata('userid'), 'fullname') . '</b> on ' . mysqldate();

                            #send_notification($recipients, 'New Annual Procurement Plan Created', 'Annual Plan Creation Alert', $message);

                            $this->session->set_userdata('usave', 'You have successfully created the ' . $financial_year . ' procurement plan');

                            redirect("procurement/page/m/usave");
                        } elseif(empty($data['msg'])) {
                            $data['msg'] = 'ERROR: Plan was not created. Please try again';
                            //echo $this->db->_error_message();
                        }
                        //===================================================================================
                    }
                }
            }

        }

        $data['page_title'] = (!empty($data['i'])? 'Edit ' : ' New ' ) . get_pde_info_by_id(get_user_info_by_id($this->session->userdata('userid'), 'pde'), 'title') . ' Procurement plan';
        $data['current_menu'] = 'create_procurement_plan';
        $data['pde_title'] = get_pde_info_by_id(get_user_info_by_id($this->session->userdata('userid'), 'pde'), 'title');
        $data['pde_id'] = get_user_info_by_id($this->session->userdata('userid'), 'pde');
        $data['view_to_load'] = 'procurement/admin/new_plan_v';
        $data['view_data']['form_title'] = $data['page_title'];
        $this->load->view('dashboard_v', $data);


    }


    function load_procurement_entry_form()
    {
        #check user access
        #1: for editing
        if(!empty($data['i']))
        {
            check_user_access($this, 'edit_procurement_entry', 'redirect');
        }
        #2: for creating
        else
        {
            check_user_access($this, 'add_procurement_entry', 'redirect');
        }
        
        # Get the passed details into the url data array if any
        $urldata = $this->uri->uri_to_assoc(3, array('m', 'i'));

        # Pick all assigned data
        $data = assign_to_data($urldata);

        # Pick all assigned data
        $data = assign_to_data($urldata);

        $data = add_msg_if_any($this, $data);

        $data = handle_redirected_msgs($this, $data);

        check_user_access($this, 'create_procurement_plan', 'redirect');

        #user is editing
        if(!empty($data['i']))
        {
            $entry_id = decryptValue($data['i']);
            $data['formdata'] = $this->Query_reader->get_row_as_array('search_table', array('table'=>'procurement_plan_entries', 'limittext'=>'', 'orderby'=>'id', 'searchstring'=>' id="'. $entry_id .'" AND isactive="Y"'));
            
            $data['v'] = encryptValue($data['formdata']['procurement_plan_id']);
        }

        //verify pde
        $plan_info = $this->procurement_plan_m->get_by_id(decryptValue($data['v']));

        if ($plan_info) {

            if ($plan_info) {
                //get the plan id
                foreach ($plan_info as $plan) {
                    $pde_id = $plan['pde_id'];
                    $financial_year = $plan['financial_year'];
                }
                $data['page_title'] = get_pde_info_by_id($pde_id, 'title') . ' financial year (' . $financial_year . ') entries';
                $data['current_menu'] = 'view_procurement_plans';
                $data['plan_info'] = $plan_info;
                $data['financial_year'] = $financial_year;
                $data['view_to_load'] = 'procurement/admin/register_entry_v';
                $data['view_data']['form_title'] = $data['page_title'];


                $data['plan_id'] = decryptValue($this->uri->segment(4));
                $data['pde_id'] = $pde_id;

                //print_array($data);


                //load view
                $this->load->view('dashboard_v', $data);
            } else {
                echo error_template('No plan for this year');
            }

        } else {
            //if pde does not exist
            //TODO redirect to a more good looking page
            echo error_template('No data to display');
        }
    }


    function procurement_plan_entries()
    {
        #check user access
        check_user_access($this, 'view_procurement_plan_entries', 'redirect');
        
        # Get the passed details into the url data array if any
        $urldata = $this->uri->uri_to_assoc(3, array('m', 'p', 'v'));

        # Pick all assigned data
        $data = assign_to_data($urldata);

      #  print_r($data); exit();
        $data = add_msg_if_any($this, $data);

        $data = handle_redirected_msgs($this, $data);

        //verify pde
        if(!empty($data['v']))
        {
            $procurementplan = decryptValue($data['v']);
           # echo $procurementplan;
           # exit();
            $data['v'] = $data['v'];
            $search_str = '';

            if($this->session->userdata('isadmin') == 'N')
            {
                $userdata = $this->db->get_where('users', array('userid'=>$this->session->userdata('userid')))->result_array();
                $search_str = ' AND procurement_plans.pde_id="'. $userdata[0]['pde'] .'"';
            }

            $plan_info = $this->Query_reader->get_row_as_array('search_table', array('table'=>'procurement_plans', 'limittext'=>'', 'orderby'=>'id', 'searchstring'=>' id="'. decryptValue($data['v']) . '" ' . $search_str .' AND isactive="Y"'));
            
            
           # if(!empty($plan_info))
           # {
                #Get the paginated list of plan entries
                $data['procurement_entries'] = paginate_list($this, $data, 'procurement_entries', array('orderby'=>'PPE.dateadded DESC', 'searchstring'=>' AND PP.id = "'. $procurementplan .'"'));
                #exit($this->db->last_query());
                $data['page_title'] = get_procurement_plan_info($plan_info['id'], 'title') . ' entries';
                $data['current_menu'] = 'view_procurement_plans';
                $data['plan_info'] = $plan_info;
                $data['view_to_load'] = 'procurement/admin/procurement_plan_entries_v';
                $data['view_data']['form_title'] = $data['page_title'];
                $data['plan_id'] =$plan_info['id'];
                $data['search_url'] = 'procurement/search_procurement_entries/plan/'.encryptValue($plan_info['id']);
               
                //load view
                $this->load->view('dashboard_v', $data);
          /*  }
            else
            {
                $data['msg'] = "ERROR: Invalid procurement entry access";
                $this->session->set_userdata('sres', $data['msg']);
                
                redirect('user/dashboard/m/sres');
            }    */                    
        }       
    }
    
    
    # Searcg procurement entries
    function search_procurement_entries()
    {
        #check user access
        check_user_access($this, 'view_procurement_plan_entries', 'redirect');
        
        # Get the passed details into the url data array if any
        $urldata = $this->uri->uri_to_assoc(3, array('m', 'plan', 't'));
        
        # Pick all assigned data
        $data = assign_to_data($urldata);
        
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
            
            $search_string .= (!empty($data['plan'])? ' AND PP.id ="'. decryptValue($data['plan']) .'" ' : ''). 
                             ' AND (PPE.procurement_ref_no like "%'. $_POST['searchQuery'] .
                             '%" OR PPE.subject_of_procurement like "%' . $_POST['searchQuery'] . '%" '.
                             'OR PPE.estimated_amount like "%'. $_POST['searchQuery'] .'%" '.
                             'OR funding_sources.title like "%'. $_POST['searchQuery'] .'%" '.
                             'OR U.firstname like "%'. $_POST['searchQuery'] .'%" OR '.
                             'U.lastname like "%' . $_POST['searchQuery'] . '%") ';
        
        }

        $data = paginate_list($this, $data, 'procurement_entries', array('orderby'=>'PPE.dateadded DESC', 'searchstring'=>$search_string));
                
        $data['area'] = 'procurement_entries';
        
        $this->load->view('includes/add_ons', $data);
                                
    }
    

    function save_procurement_entry()
    {
        #check user access
        #1: for editing
        if(!empty($data['i']))
        {
            check_user_access($this, 'edit_procurement_entry', 'redirect');
        }
        #2: for creating
        else
        {
            check_user_access($this, 'add_procurement_entry', 'redirect');
        }
        
        # Get the passed details into the url data array if any
        $urldata = $this->uri->uri_to_assoc(3, array('m', 'p', 'v'));

        # Pick all assigned data
        $data = assign_to_data($urldata);

        $data = add_msg_if_any($this, $data);

        $data = handle_redirected_msgs($this, $data);

        $plan_info = $this->procurement_plan_m->get_by_id(decryptValue($data['v']));

        if(!empty($plan_info)) $plan_info = $plan_info[0];

        #print_array($_POST);
        if (!empty($_POST['save_entry']) || !empty($_POST['save_and_new'])) {

            $data['formdata'] = $_POST;

            $required_fields = array('subject_of_procurement', 'pde_department', 'procurement_type', 'estimated_amount', 'currency', 'funding_source', 'procurement_method', 'contracts_committee_approval_date', 'contracts_committee_approval_of_shortlist_date', 'bid_issue_date', 'bid_closing_date', 'submission_of_evaluation_report_to_cc', 'cc_approval_of_evaluation_report','quantity');
            
            if(!empty($_POST['currency']) && $_POST['currency']>1)                      
                $required_fields = array_merge($required_fields, array('exchange_rate'));

            #$_POST = clean_form_data($_POST);

            $validation_results = validate_form('', $_POST, $required_fields);

            #Only proceed if the validation for required fields passes
            if ($validation_results['bool']) {

                $procurement_plan_data = array
                (
                    'subject_of_procurement' => $this->input->post('subject_of_procurement'),
                    'procurement_type' => $this->input->post('procurement_type'),
                    'procurement_method' => $this->input->post('procurement_method'),
                    'pde_department' => $this->input->post('pde_department'),
                    'funding_source' => $this->input->post('funding_source'),
                    'estimated_amount' => removeCommas($this->input->post('estimated_amount')),
                    'currency' => $this->input->post('currency'),
                    'exchange_rate' => ($_POST['currency'] == 1)? 1 : $this->input->post('exchange_rate'),
                    'pre_bid_events_date' => custom_date_format('Y-m-d', $this->input->post('pre_bid_events_date')),

                    'contracts_committee_approval_date' => custom_date_format('Y-m-d', $this->input->post('contracts_committee_approval_date')),
                    'publication_of_pre_qualification_date' => custom_date_format('Y-m-d', $this->input->post('publication_of_pre_qualification_date')),
                    'proposal_submission_date' => custom_date_format('Y-m-d', $this->input->post('proposal_submission_date')),
                    'contracts_committee_approval_of_shortlist_date' => custom_date_format('Y-m-d', $this->input->post('contracts_committee_approval_of_shortlist_date')),
                    'bid_issue_date' => custom_date_format('Y-m-d', $this->input->post('bid_issue_date')),

                    'bid_submission_opening_date' => custom_date_format('Y-m-d', $this->input->post('bid_issue_date')),
                    'bid_closing_date' => custom_date_format('Y-m-d', $this->input->post('bid_closing_date')),
                    'submission_of_evaluation_report_to_cc' => custom_date_format('Y-m-d', $this->input->post('submission_of_evaluation_report_to_cc')),

                    'secure_necessary_approval_date' => custom_date_format('Y-m-d', $this->input->post('necessary_approval_date')),

                    'contract_award' => custom_date_format('Y-m-d', $this->input->post('contract_award')),

                    'best_evaluated_bidder_date' => custom_date_format('Y-m-d', $this->input->post('best_evaluated_bidder_date')),

                    'contract_sign_date' => custom_date_format('Y-m-d', $this->input->post('contract_sign_date')),

                    'cc_approval_of_evaluation_report' => custom_date_format('Y-m-d', $this->input->post('cc_approval_of_evaluation_report')),

                    'negotiation_date' => custom_date_format('Y-m-d', $this->input->post('negotiation_date')),

                    'negotiation_approval_date' => custom_date_format('Y-m-d', $this->input->post('negotiation_approval_date')),
                    
                    'performance_security' => custom_date_format('Y-m-d', $this->input->post('performance_security')),
                    
                    'accounting_officer_approval_date' => custom_date_format('Y-m-d', $this->input->post('accounting_officer_approval_date')),
                    
                    'best_evaluated_bidder_date' => custom_date_format('Y-m-d', $this->input->post('best_evaluated_bidder_date')),

                    'advanced_payment_date' => custom_date_format('Y-m-d', $this->input->post('advanced_payment_date')),
                    
                    'solicitor_general_approval_date' => custom_date_format('Y-m-d', $this->input->post('solicitor_general_approval_date')),

                    'mobilise_advance_payment' => custom_date_format('Y-m-d', $this->input->post('mobilise_advance_payment')),

                    'substantial_completion' => custom_date_format('Y-m-d', $this->input->post('substantial_completion')),

                    'final_acceptance' => custom_date_format('Y-m-d', $this->input->post('final_acceptance')),
                    
                    'procurement_plan_id' => $plan_info['id'],
                   'quantity'=> $this->input->post('quantity')
                );
                
                #check if the procurement already exists
                $similar_proc_ref_no = $this->Query_reader->get_row_as_array('search_table', array('table' => ' procurement_plan_entries', 'orderby' => 'procurement_ref_no', 'limittext' => '', 'searchstring' => ' procurement_plan_id = "'. $plan_info['id'] .'" AND pde_department ="'. $_POST['pde_department'] .'" AND subject_of_procurement = "' . $_POST['subject_of_procurement'] . '"' . (!empty($data['i']) ? ' AND id !="' . decryptValue($data['i']) . '"' : '')));
                
                if(!empty($similar_proc_ref_no))
                {
                    $data['msg'] = 'ERROR: An entry with a similar subject of procurement <b><i>('. $_POST['subject_of_procurement'] .')</i></b> has already been created already exists.';
                }
                #User is editing
                else if(!empty($data['i']))
                {
                    $procurement_plan_data['updated_by'] = $this->session->userdata('userid');
                    $result = $this->db->update('procurement_plan_entries', clean_form_data($procurement_plan_data), array('id'=>decryptValue($data['i'])));
                }
                #new entry
                else
                {
                    #$procurement_plan_data['procurement_ref_no'] = procurement_plan_ref_number_hint($plan_info['pde_id'], $this->input->post("procurement_type"), $plan_info['financial_year'], decryptValue($data['v']));
                    $procurement_plan_data['author'] = $this->session->userdata('userid');
                    $result = $this->procurement_plan_entry_m->create($procurement_plan_data);
                }

                #exit($this->db->last_query());
              
                #event has been added successfully
                if(!empty($result) && $result)
                {
                    $data['msg'] = "SUCCESS: The procurement entry details have been saved.";
                    $this->session->set_userdata('sres', $data['msg']);

                    #user clicked publish
                    if(!empty($_POST['save_and_new']))
                    {
                        redirect('procurement/load_procurement_entry_form/m/sres' . ((!empty($data['v']))? "/v/".$data['v'] : ''));
                    }
                    else
                    {
                        redirect('procurement/procurement_plan_entries/m/sres' . ((!empty($data['v']))? "/v/".$data['v'] : ''));
                    }
                }
                elseif(empty($data['msg']))
                {
                    $data['msg'] = "ERROR: The procurement entry details could not be saved or were not saved correctly.";
                }
            }

            if ((empty($validation_results['bool']) || (!empty($validation_results['bool']) && !$validation_results['bool']))
                && empty($data['msg'])
            ) {
                $data['msg'] = "WARNING: The highlighted fields are required.";
            }

            $data['requiredfields'] = $validation_results['requiredfields'];
        }


            if ($plan_info) {

                if ($plan_info) {
                    //get the plan id
                    $pde_id = $plan_info['pde_id'];
                    $financial_year = $plan_info['financial_year'];
                   
                    $data['page_title'] = get_pde_info_by_id($pde_id, 'title') . ' financial year (' . $financial_year . ') entries';
                    $data['current_menu'] = 'view_procurement_plans';
                    $data['plan_info'] = $plan_info;
                    $data['financial_year'] = $financial_year;
                    $data['view_to_load'] = 'procurement/admin/register_entry_v';
                    $data['view_data']['form_title'] = $data['page_title'];


                    $data['plan_id'] = decryptValue($this->uri->segment(4));
                    $data['pde_id'] = $pde_id;

                    //print_array($data);


                    //load view
                    $this->load->view('dashboard_v', $data);
                } else {
                    echo error_template('No plan for this year');
                }

            } else {
                //if pde does not exist
                //TODO redirect to a more good looking page
                echo error_template('No data to display');
            }

    }

    #initiate procurement
    function initiate_procurement()
    {
        # Get the passed details into the url data array if any
        $urldata = $this->uri->uri_to_assoc(3, array('m', 's'));

        # Pick all assigned data
        $data = assign_to_data($urldata);

        $data = add_msg_if_any($this, $data);

        if (!empty($_POST['save'])) {
            $required_fields = array('vote_no', 'date_initiated', 'initiated_by');

            $_POST = clean_form_data($_POST);

            $validation_results = validate_form('', $_POST, $required_fields);

            #Only proceed if the validation for required fields passes
            if ($validation_results['bool']) {
                #check if an active procurement initialization already exists for selected procurement ref no
                $similar_bid_invitation = $this->db->query($this->Query_reader->get_query_by_code('search_table', array('table' => 'initiate_procurements', 'orderby' => 'procurement_ref_no', 'limittext' => '', 'searchstring' => ' procurement_ref_no = "' . $_POST['procurement_ref_no'] . '" AND isactive="Y"' . (!empty($data['i']) ? ' AND id !="' . decryptValue($data['i']) . '"' : ''))))->result_array();


                if (!empty($similar_bid_invitation)) {
                    $data['msg'] = "WARNING: The procurement initialization for the selected procurement reference number has already started.";
                } else {
                    $_POST['author'] = $this->session->userdata('userid');
                    $_POST['approval_status'] = 'Pending';

                    if (!empty($data['i'])) {
                        #$result = $this->db->query($this->Query_reader->dbupdate_str('events', $_POST, decryptValue($data['i']), 'id'));
                    } else {
                        $result = $this->db->query($this->Query_reader->get_query_by_code('initiate_procurement', $_POST));
                    }
                }

                #procurement has been initiated successfully
                if (!empty($result) && $result) {
                    $data['msg'] = "SUCCESS: The procurement has been initiated successfully.";
                    $this->session->set_userdata('sres', $data['msg']);

                    redirect('procurement/procurement_plan_entries' . (!empty($_POST['proc_no']) ? "/v/" . $_POST['proc_no'] : '') . '/m/sres');
                } else if (empty($data['msg'])) {
                    $data['msg'] = "ERROR: The procurement could not be initiated or was not initiated correctly.";
                }
            }

            if ((empty($validation_results['bool']) || (!empty($validation_results['bool']) && !$validation_results['bool']))
                && empty($data['msg'])
            ) {
                $data['msg'] = "WARNING: The highlighted fields are required.";
            }

            $data['requiredfields'] = $validation_results['requiredfields'];
        }

        $data['formdata'] = $_POST;

        $app_select_str = ' procurement_plan_entries.isactive="Y" ';

        if ($this->session->userdata('isadmin') == 'N') {
            $userdetails = $this->db->get_where('users', array('userid' => $this->session->userdata('userid')))->result_array();
            $app_select_str .= ' AND pde_id ="' . $userdetails[0]['pde'] . '"';
        }

        $data['procurement_plan_entries'] = $this->db->query($this->Query_reader->get_query_by_code('procurement_plan_details', array('searchstring' => $app_select_str, 'limittext' => '', 'orderby' => ' procurement_plan_entries.dateadded ')))->result_array();


        $data['page_title'] = (!empty($data['i']) ? 'Edit procurement initiation details' : 'Procurement initiation details');
        $data['current_menu'] = 'initiate_procurement';
        $data['view_to_load'] = 'procurement/initiate_procurement_form';
        $data['view_data']['form_title'] = $data['page_title'];

        $this->load->view('dashboard_v', $data);
    }

    #initiate procurement
    function load_initiate_procurement_form()
    {
        # Get the passed details into the url data array if any
        $urldata = $this->uri->uri_to_assoc(3, array('m'));

        # Pick all assigned data
        $data = assign_to_data($urldata);

        $app_select_str = ' procurement_plan_entries.isactive="Y" ';

        if ($this->session->userdata('isadmin') == 'N') {
            $userdetails = $this->db->get_where('users', array('userid' => $this->session->userdata('userid')))->result_array();
            $app_select_str .= ' AND procurement_plans.pde_id ="' . $userdetails[0]['pde'] . '"';
        }
        
        $data['procurement_plan_entries'] = $this->db->query($this->Query_reader->get_query_by_code('procurement_plan_details', array('searchstring' => $app_select_str, 'limittext' => '', 'orderby' => ' procurement_plan_entries.dateadded ')))->result_array();
        //exit($this->db->last_query());

        #user is editing
        if (!empty($data['i'])) {
            $bid_id = decryptValue($data['i']);
            $data['formdata'] = $this->Query_reader->get_row_as_array('search_table', array('table' => 'bidinvitations', 'limittext' => '', 'orderby' => 'id', 'searchstring' => ' id="' . $bid_id . '" AND isactive="Y"'));

            #get procurement plan details
            if (!empty($data['formdata']['procurement_ref_no'])) {
                $data['formdata']['procurement_details'] = $this->Query_reader->get_row_as_array('procurement_plan_details', array('searchstring' => $app_select_str . ' AND procurement_ref_no="' . $data['formdata']['procurement_ref_no'] . '"', 'limittext' => '', 'orderby' => ' procurement_plan_entries.dateadded '));
            }
        }

        $data['page_title'] = (!empty($data['i']) ? 'Edit procurement initiation details' : 'Procurement initiation details');
        $data['current_menu'] = 'initiate_procurement';
        $data['view_to_load'] = 'procurement/initiate_procurement_form';
        $data['view_data']['form_title'] = $data['page_title'];

        $this->load->view('dashboard_v', $data);

    }

    //view full report on a particular entry
    function full_report()
    {

        //check if person is authorised to view report
        //load view variables
        if (get_user_info_by_id($this->session->userdata('userid'), 'pde_id') == get_procurement_plan_entry_info(decryptValue($this->uri->segment(4)), 'pde_id')) {
            $data['page_title'] = get_procurement_plan_entry_info(decryptValue($this->uri->segment(4)), 'title');
            $data['current_menu'] = 'view_procurement_plans';
            $data['entry_id'] = decryptValue($this->uri->segment(4));
            $data['view_to_load'] = 'procurement/admin/entry_report_v';
            $data['view_data']['form_title'] = $data['page_title'];

            //echo get_procurement_plan_entry_info(decryptValue($this->uri->segment(5)), 'title');

            //load view
            $this->load->view('dashboard_v', $data);
        } else {
            //load view variables
            $data['page_title'] = "Oops";
            $data['current_menu'] = 'dashboard';
            $data['view_to_load'] = 'error_pages/500_v';
            $data['view_data']['form_title'] = $data['page_title'];
            $data['message'] = 'Only authorised PDU members can view this page';


            //load view
            $this->load->view('dashboard_v', $data);
        }


    }


    #Function to delete a plan's details
    function delete_plan()
    {
        #check user access
        check_user_access($this, 'delete_procurement_plan', 'redirect');

        # Get the passed details into the url data array if any
        $urldata = $this->uri->uri_to_assoc(3, array('m', 's'));

        # Pick all assigned data
        $data = assign_to_data($urldata);

        if(!empty($data['i'])){
            $result = $this->db->query($this->Query_reader->get_query_by_code('deactivate_item', array('item'=>' procurement_plans', 'id'=>decryptValue($data['i'])) ));
            
            #deactivate the entries
            if($result)
            {
                $this->db->where('procurement_plan_id', decryptValue($data['i']));
                $this->db->update('procurement_plan_entries', array('isactive'=>'N'));
            }
        }

        if(!empty($result) && $result){
            $this->session->set_userdata('dbid', "The plan and it's entries have been successfully deleted.");
        }
        else if(empty($data['msg']))
        {
            $this->session->set_userdata('dbid', "ERROR: The procurement plan could not be deleted or were not deleted correctly.");
        }

        if(!empty($data['t']) && $data['t'] == 'super'){
            $tstr = "/t/super";
        }else{
            $tstr = "";
        }
        redirect(base_url()."procurement/page/m/dbid".$tstr);
    }


    //delete entry
    function delete_entry()
    {
        #check user access
        check_user_access($this, 'delete_procurement_entry', 'redirect');
        
        # Get the passed details into the url data array if any
        $urldata = $this->uri->uri_to_assoc(3, array('m', 's', 'i'));

        # Pick all assigned data
        $data = assign_to_data($urldata);
        
        $redirect_url = '';

        if(!empty($data['i'])){
            
            $search_str = '';
        
            if($this->session->userdata('isadmin') == 'N')
            {
                $userdetails = $this->db->get_where('users', array('userid'=>$this->session->userdata('userid')))->result_array(); 
                $search_str .= ' AND PP.pde_id ="'. $userdetails[0]['pde'] .'"';
            }
            
            $entry_details = $this->Query_reader->get_row_as_array('procurement_entries', array('table'=>'procurement_plan_entries', 
            'searchstring'=>' AND PPE.id = "' . decryptValue($data['i']) . '" AND PPE.isactive="Y" ' . $search_str, 'orderby'=> 'PPE.id', 'limittext'=>''));
            
            if(!empty($entry_details))
            {
                $result = $this->db->query($this->Query_reader->get_query_by_code('deactivate_item', array('item'=>'procurement_plan_entries', 'id'=>$entry_details['entryid'])));
                $redirect_url = "procurement/procurement_plan_entries/v/".encryptValue($entry_details['procurement_plan_id'])."/m/dbid";    
                        
            }           
            else
            {
                $msg = "ERROR: Invalid function access";
                $this->session->set_userdata('dbid', $msg);
                $redirect_url = "user/dashboard/m/dbid";
                exit('hmm');
            }
        }

        if(!empty($result) && $result){
            $this->session->set_userdata('dbid', "The procurement entry has been successfully deleted.");
        }
        else if(empty($msg))
        {
            $this->session->set_userdata('dbid', "ERROR: The procurement entry could not be deleted or were not deleted correctly.");
        }
        
        redirect(base_url().$redirect_url);

    }


    //view plan details
    function plan_details()
    {

        //echo decryptValue($this->uri->segment(3));
        //verify plan
        if (get_procurement_plan_info(decryptValue($this->uri->segment(3)), '')) {
            $data['page_title'] = get_procurement_plan_info(decryptValue($this->uri->segment(3)), 'title');
            $data['current_menu'] = 'view_procurement_plans';
            $data['plan_id'] = decryptValue($this->uri->segment(3));
            $data['view_to_load'] = 'procurement/admin/plan_details_v';
            $data['view_data']['form_title'] = $data['page_title'];

            //load view
            $this->load->view('dashboard_v', $data);
        } else {
            //if pde does not exist
            show_404();
        }


    }

}