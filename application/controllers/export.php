<?php

/**
 * .
 * User: mover
 *
 */
class Export extends CI_Controller
{

    function __construct()
    {
        //load ci controller
        parent::__construct();
        //load Models
        $this->load->model('users_m', 'users');
        $this->load->model('sys_email', 'sysemail');
        #date_default_timezone_set(SYS_TIMEZONE);
        $this->load->model('Remoteapi_m');
        $this->load->model('Receipts_m');
        $this->load->model('procurement_plan_m');
        $this->load->model('procurement_plan_entry_m');
        $this->load->model('disposal_m', 'disposal');
        $this->load->model('disposal_record_m');
        $this->load->model('bid_invitation_m');


    }

    /*
       INITILIZATION 
    */
    function index()
    {

        redirect(base_url());
    }

    function procurement_plan_details()
    {
        //verify that plan exists
        $id = decryptValue($this->uri->segment(3));
        $plan_info = get_procurement_plan_info($id, '');
        if ($plan_info) {
            //print_array($plan_info);
            //show active plans
            $data['pagetitle'] = get_procurement_plan_info($id, 'title');
            $data['current_menu'] = 'active_plans';
            $data['view_to_load'] = 'public/active_plans/plan_details_export_v';
            $data['plan_id'] = $id;

            $limit = NUM_OF_ROWS_PER_PAGE;
            $where = array(
                'procurement_plan_id' => $id,
                'isactive' => 'Y'
            );
            $data['all_entries'] = $this->procurement_plan_entry_m->get_where($where);
            $data['all_entries_paginated'] = $this->procurement_plan_entry_m->get_paginated_by_criteria($num = $limit, $this->uri->segment(5), $where);
            $this->load->library('pagination');
            //pagination configs
            $config = array
            (
                'base_url' => base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/',//contigure page base_url
                'total_rows' => count($data['all_entries']),
                'per_page' => $limit,
                'num_links' => $limit,
                'use_page_numbers' => TRUE,
                'full_tag_open' => '<div class="btn-group">',
                'full_tag_close' => '</div>',
                'anchor_class' => 'class="btn" ',
                'cur_tag_open' => '<div class="btn">',
                'cur_tag_close' => '</div>',
                'uri_segment' => '5'

            );
            //initialise pagination
            $this->pagination->initialize($config);

            //add to data array
            $data['pages'] = $this->pagination->create_links();
            //load view


            //load view
            $this->load->view('public/home_v', $data);
        } else {
            show_404();
        }


    }

    function disposal_plan_details()
    {
        //verify that plan exists
        $id = decryptValue($this->uri->segment(3));
        $plan_info = get_disposal_record_info_by_disposal_plan($id, '');
        if ($plan_info) {
            //print_array($plan_info);
            //show active plans
            $pieces = explode('/', get_disposal_record_info_by_disposal_plan($id, 'serial'));
            //print_array($pieces);

            $data['pagetitle'] = $pieces[2] . '-' . $pieces[3] . '  ' . get_disposal_record_info_by_disposal_plan($id, 'pde') . ' Disposal plan';
            $data['current_menu'] = 'disposal_plans';
            $data['view_to_load'] = 'public/disposal_plan_export_v';
            $data['plan_id'] = $id;

            $limit = NUM_OF_ROWS_PER_PAGE;
            $where = array(
                'disposal_plan' => $id,
                'isactive' => 'Y'
            );
            $data['all_records'] = $this->disposal_record_m->get_where($where);
            $data['all_records_paginated'] = $this->disposal_record_m->get_paginated_by_criteria($num = $limit, $this->uri->segment(5), $where);
            $this->load->library('pagination');
            //pagination configs
            $config = array
            (
                'base_url' => base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/',//contigure page base_url
                'total_rows' => count($data['all_records']),
                'per_page' => $limit,
                'num_links' => $limit,
                'use_page_numbers' => TRUE,
                'full_tag_open' => '<div class="btn-group">',
                'full_tag_close' => '</div>',
                'anchor_class' => 'class="btn" ',
                'cur_tag_open' => '<div class="btn">',
                'cur_tag_close' => '</div>',
                'uri_segment' => '5'

            );
            //initialise pagination
            $this->pagination->initialize($config);

            //add to data array
            $data['pages'] = $this->pagination->create_links();
            //load view


            //load view
            $this->load->view('public/home_v', $data);
        } else {
            show_404();
        }


    }

    function current_tenders()
    {

        $data['pagetitle']='Bidding opportunities';



            $data['current_menu'] = 'current_tenders';
            $data['view_to_load'] = 'public/current_tenders_export_v';


            $limit = NUM_OF_ROWS_PER_PAGE;
            $where = array(
                'bid_submission_deadline >=' => mysqldate(),
                'isactive' => 'Y'
            );
            $data['all_records'] = $this->bid_invitation_m->get_where($where);
            $data['all_records_paginated'] = $this->bid_invitation_m->get_paginated_by_criteria($num = $limit, $this->uri->segment(5), $where);
            $this->load->library('pagination');
            //pagination configs
            $config = array
            (
                'base_url' => base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/',//contigure page base_url
                'total_rows' => count($data['all_records']),
                'per_page' => $limit,
                'num_links' => $limit,
                'use_page_numbers' => TRUE,
                'full_tag_open' => '<div class="btn-group">',
                'full_tag_close' => '</div>',
                'anchor_class' => 'class="btn" ',
                'cur_tag_open' => '<div class="btn">',
                'cur_tag_close' => '</div>',
                'uri_segment' => '5'

            );
            //initialise pagination
            $this->pagination->initialize($config);

            //add to data array
            $data['pages'] = $this->pagination->create_links();
            //load view


            //load view
            $this->load->view('public/home_v', $data);



    }


}