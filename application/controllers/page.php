<?php
ob_start();

#**************************************************************************************
# All normal website pages that do not require login are directed from this controller
#**************************************************************************************

class Page extends CI_Controller {

    # Constructor
    function Page()
    {
  
        parent::__construct();

        $this->load->model('users_m','users');
        $this->load->model('sys_email','sysemail');
        #date_default_timezone_set(SYS_TIMEZONE);
        $this->load->model('Remoteapi_m');
        $this->load->model('Receipts_m');
        $this->load->model('procurement_plan_m');
        $this->load->model('procurement_plan_entry_m');
        $this->load->model('disposal_m','disposal');
         #$this->load->model('schedule_m');

    }


    # Default to home
    function index()
    {
        #Go home
        redirect('page/home');
    }

    #publish best evaluated bidder to the front end
    function best_evaluated_bidder()
    {
        $urldata = $this->uri->uri_to_assoc(3, array('m'));
        # Pick all assigned data
       
        $data = assign_to_data($urldata);
         if(!empty($urldata['level']) && ($urldata['level'] == 'search'))
        {
            #paginates search egine
          $searchstring =  $this->session->userdata('searchengine3');  
         # print_r($searchstring);
         
          $data['page_list'] = $this->Receipts_m->fetchbeb($data,$searchstring);

          #$data['page_list'] = $this->disposal->fetch_disposal_records($data,$searchstring);
          $data['level'] = 'search';

      }
      else
      {

        $data['page_list'] = $this->Receipts_m->fetchbeb($data);

        $this->db->order_by("title", "asc");
        $data['procurement_types'] = $this->db->get_where('procurement_types', array('isactive' => 'Y'))->result_array();

        $this->db->order_by("title", "asc");
        $data['procurement_methods'] = $this->db->get_where('procurement_methods', array('isactive' => 'Y'))->result_array();

        $this->db->order_by("pdename", "asc");
        $data['pdes'] = $this->db->get_where('pdes', array('isactive' => 'Y', 'status' => 'in'))->result_array();
      }

        $data['title'] = 'National Tender Portal';
        $data['current_menu'] = 'beb';
        $this->load->view('public/beb_v', $data);
    }
    
    function best_evaluated_bidder_search()
    {
        $urldata = $this->uri->uri_to_assoc(3, array('m'));
        # Pick all assigned data
        $data = assign_to_data($urldata);
        
        $searchstring = '';
        
        $procurement_type = mysql_real_escape_string($_POST['procurement_type']);
        if(!empty( $procurement_type))
        {
             $searchstring .= 'and procurement_plan_entries.procurement_type = "'.$procurement_type.'"';
        }
        
        $procurement_method = mysql_real_escape_string($_POST['procurement_method']);
        if(!empty( $procurement_method))
        {
             $searchstring .= 'and procurement_plan_entries.procurement_method= "%'.$procurement_method.'%" ';
        }
        
        $procurement_ref_no = mysql_real_escape_string($_POST['procurement_ref_no']);
        if(!empty( $procurement_ref_no))
        {
             $searchstring .= ' and  procurement_plan_entries.procurement_ref_no="'.$procurement_ref_no.'"  ';
        }
        
        $entity = mysql_real_escape_string($_POST['entity']);
        if(!empty($entity))
        {
             $searchstring .= 'and  b.pdeid = "'.$entity.'"   ';
        }
        
        $date_posted_from = mysql_real_escape_string($_POST['date_posted_from']);
        if(!empty($date_posted_from))
        {
             $searchstring .= 'and bestevaluatedbidder.dateadded >= "'.$date_posted_from.'" ';
        }

        $date_posted_to = mysql_real_escape_string($_POST['date_posted_to']);

        $searchstring .= ' and bestevaluatedbidder.ispublished = "Y"  and  receipts.beb="Y"   order by bestevaluatedbidder.dateadded DESC';

        $this->db->order_by("title", "asc");
        $data['procurement_types'] = $this->db->get_where('procurement_types', array('isactive' => 'Y'))->result_array();

        $this->db->order_by("title", "asc");
        $data['procurement_methods'] = $this->db->get_where('procurement_methods', array('isactive' => 'Y'))->result_array();

        $this->db->order_by("pdename", "asc");
        $data['pdes'] = $this->db->get_where('pdes', array('isactive' => 'Y', 'status' => 'in'))->result_array();

        $data['page_list'] = $result = paginate_list($this, $data, 'fetchbebs', array('SEARCHSTRING' => $searchstring ),10);

        $data['title'] = 'National Tender Portal';
        $data['current_menu'] = 'beb';
        $this->load->view('public/beb_v', $data);


       # print_r($_POST);

    }



    # The home page
    function home()
    {
        # Get the passed details into the url data array if any
        $urldata = $this->uri->uri_to_assoc(3, array('m', 'p'));

        # Pick all assigned data
        $data = assign_to_data($urldata);

    #print_r($urldata);

    if(!empty($urldata['level']) && ($urldata['level'] == 'search'))
        {
            #paginates search egine
          $search_str =  $this->session->userdata('searchengines');  
          # print_r($search_str);
          $data = paginate_list($this, $data, 'bid_invitation_details', array('orderby' => 'bid_dateadded DESC', 'searchstring' => $search_str .
                ' AND bidinvitations.isactive = "Y" AND bidinvitations.isapproved="Y" AND bidinvitations.bid_submission_deadline>NOW()'),10);
 
          #$data['page_list'] = $this->disposal->fetch_disposal_records($data,$searchstring);
          $data['level'] = 'search';

      }
      else
      {

        $this->db->order_by("title", "asc");
        $data['procurement_types'] = $this->db->get_where('procurement_types', array('isactive' => 'Y'))->result_array();

        $this->db->order_by("title", "asc");
        $data['procurement_methods'] = $this->db->get_where('procurement_methods', array('isactive' => 'Y'))->result_array();

        $this->db->order_by("pdename", "asc");
        $data['pdes'] = $this->db->get_where('pdes', array('isactive' => 'Y', 'status' => 'in'))->result_array();

        #Search results
        if (!empty($_POST['search_btn'])) {
            $search_str = 'procurement_plan_entries.subject_of_procurement LIKE "%' . $_POST['subject_of_procurement'] . '%"';

            if (!empty($_POST['date_posted_from']) && !empty($_POST['date_posted_to']))
                $search_str .= ' AND bid_invitation_details.bid_date_approved >  "' .
                    custom_date_format('Y-m-d', $_POST['date_posted_from']) . '" - INTERVAL 1 DAY ' .
                    ' AND bid_invitation_details.bid_date_approved <  "' .
                    custom_date_format('Y-m-d', $_POST['date_posted_to']) . '" + INTERVAL 1 DAY ';

            if (!empty($_POST['procurement_type']))
                $search_str .= ' AND procurement_plan_entries.procurement_type =  "' . $_POST['procurement_type'] . '"';

            if (!empty($_POST['procurement_method']))
                $search_str .= ' AND procurement_plan_entries.procurement_method =  "' . $_POST['procurement_method'] . '"';

            if (!empty($_POST['entity']))
                $search_str .= ' AND procurement_plans.pde_id =  "' . $_POST['entity'] . '"';
                
          
            $data = paginate_list($this, $data, 'bid_invitation_details', array('orderby' => 'bid_dateadded DESC', 'searchstring' => $search_str .
                ' AND bidinvitations.isactive = "Y" AND bidinvitations.isapproved="Y" AND bidinvitations.bid_submission_deadline>NOW()'),10);

            $data['formdata'] = $_POST;

        }

        #normal page load
        else
        {
            #get available bids
            $data = paginate_list($this, $data, 'bid_invitation_details', array('orderby' => 'bid_dateadded DESC', 'searchstring' => 'bidinvitations.isactive = "Y" AND bidinvitations.isapproved="Y" AND bidinvitations.bid_submission_deadline>NOW()'),10);
        }
    }

        $this->load->view('public/home_v', $data);
    }

    #login page
    function login()
    {
        # Get the passed details into the url data array if any
        $urldata = $this->uri->uri_to_assoc(3, array('m', 'p'));

        # Pick all assigned data
        $data = assign_to_data($urldata);

        $this->load->view('login_v', $data);
    }

    #Function to process the contact us page
    function process_contactus()
    {
        # Get the passed details into the url data array if any
        $urldata = $this->uri->uri_to_assoc(3, array('m'));
        # Pick all assigned data
        $data = assign_to_data($urldata);

        if($this->input->post('sendmessage'))
        {
            $required_fields = array('emailaddress*EMAILFORMAT', 'name');
            #$_POST['attachmenturl'] = !empty($_FILES['attachmenturl']['name'])? $this->sysfile->local_file_upload($_FILES['attachmenturl'], 'Upload_'.strtotime('now'), 'attachments', 'filename'): '';

            $_POST = clean_form_data($_POST);
            $validation_results = validate_form('', $_POST, $required_fields);

            #Only proceed if the validation for required fields passes
            #if($validation_results['bool'] && is_valid_captcha($this, $_POST['captcha']))
            if($validation_results['bool'])
            {
                #Send the contact message to the administrator and
                $send_result = $this->sysemail->email_form_data(array('fromemail'=>NOREPLY_EMAIL),
                        get_confirmation_messages($this, $_POST, 'website_feedback'));

                if($send_result)
                {
                    $data['msg'] = "Your message has been sent. Thank you for your feedback.";
                    $data['successful'] = 'Y';
                }
                else
                {
                    $data['msg'] = "ERROR: Your message could not be sent. Please contact us using our phone line.";
                }
            }

            if(!$validation_results['bool'])
            {
                $data['msg'] = "WARNING: The highlighted fields are required.";
            }

            $data['requiredfields'] = array_merge($validation_results['requiredfields'], array('captcha'));
            $data['formdata'] = $_POST;

        }

        $data['pagedata'] = $this->Query_reader->get_row_as_array('get_page_by_section', array('section'=>'Support', 'subsection'=>'Contact Us'));
        if(count($data['pagedata']) > 0)
        {
            $data['pagedata']['details'] = str_replace("&amp;gt;", "&gt;", str_replace("&amp;lt;", "&lt;", $data['pagedata']['details']));

            $data['pagedata']['parsedtext'] = $this->wiki_manager->parse_text_to_HTML(htmlspecialchars_decode($data['pagedata']['details'], ENT_QUOTES));
            $result = $this->db->query($this->Query_reader->get_query_by_code('get_subsections_by_section', array('section'=>$data['pagedata']['section'])));
            $data['subsections'] = $result->result_array();
        }


        $data = add_msg_if_any($this, $data);
        $this->load->view('page/contact_us_view', $data);
    }

    function register()
    {
        # Get the passed details into the url data array if any
        $urldata = $this->uri->uri_to_assoc(3, array('m', 's'));
        # Pick all assigned data
        $data = assign_to_data($urldata);

        $data = paginate_list($this, $data, 'get_page_list',  array('searchstring'=>''));
        $data = add_msg_if_any($this, $data);
        $this->load->view('page/register_view', $data);
    }


    #Function to create the catpcha word
    function create_captcha()
    {
        # Get the passed details into the url data array if any
        $urldata = $this->uri->uri_to_assoc(3, array('m', 's'));
        # Pick all assigned data
        $data = assign_to_data($urldata);

        $vals = array(
                    'img_path'   => './images/captcha/',
                    'img_url'    => IMAGE_URL.'captcha/',
                    'img_width'  => 150,
                    'img_height' => 50
                    );

        $cap = create_captcha($vals);

        $data = array(
          'captcha_id'    => '',
          'captcha_time'  => $cap['time'],
          'ip_address'    => $this->input->ip_address(),
          'word'          => $cap['word']
       );


        $this->db->query($this->Query_reader->get_query_by_code('insert_captcha_record', array('captcha_time'=>$data['captcha_time'], 'ip_address'=>$data['ip_address'], 'word'=>$data['word'])));

        $data['capimage'] = $cap['image'];
        $data['area'] = 'catpcha_image_view';

        $data = add_msg_if_any($this, $data);
        $this->load->view('incl/addons', $data);
    }



    #Show this when javascript is not enabled
    function javascript_not_enabled()
    {
        # Get the passed details into the url data array if any
        $urldata = $this->uri->uri_to_assoc(3, array('m', 's'));
        # Pick all assigned data
        $data = assign_to_data($urldata);

        format_notication("WARNING: Javascript not enabled.<BR><BR><a href='".base_url()."'>&lsaquo;&lsaquo; GO BACK TO HOME</a>");
    }


    #Function to show the contact us page
    function contact_us()
    {
        # Get the passed details into the url data array if any
        $urldata = $this->uri->uri_to_assoc(3, array('m', 's'));
        # Pick all assigned data
        $data = assign_to_data($urldata);

        $data = add_msg_if_any($this, $data);
        $this->load->view('page/contact_us_view', $data);
    }



    #Function to show the about us page
    function about_us()
    {
        # Get the passed details into the url data array if any
        $urldata = $this->uri->uri_to_assoc(3, array('m', 's'));
        # Pick all assigned data
        $data = assign_to_data($urldata);

        $data = add_msg_if_any($this, $data);
        $this->load->view('page/about_view', $data);
    }

    #Function to show the privacy policy
    function privacy_policy()
    {
        # Get the passed details into the url data array if any
        $urldata = $this->uri->uri_to_assoc(3, array('m', 's'));

        # Pick all assigned data
        $data = assign_to_data($urldata);

        $data = add_msg_if_any($this, $data);
        $this->load->view('page/privacy_policy_view', $data);
    }

    #Function to show the terms and conditions
    function terms_and_conditions()
    {
        # Get the passed details into the url data array if any
        $urldata = $this->uri->uri_to_assoc(3, array('m', 's'));

        # Pick all assigned data
        $data = assign_to_data($urldata);

        $data = add_msg_if_any($this, $data);

        $this->load->view('incl/terms_and_conditions_view', $data);
    }

    //display active procurement plans
    function procurement_plans()
    {
    $this->db->order_by("pdename", "asc");
      $urldata = $this->uri->uri_to_assoc(3, array('m', 's'));

        # Pick all assigned data
        $data = assign_to_data($urldata);
       #print_r($urldata); exit();
        $data['pdes'] = $this->db->get_where('pdes', array('isactive' => 'Y', 'status' => 'in'))->result_array();
        //switch by parameter passed
        if(!empty($urldata['level']) && ($urldata['level'] == 'search'))
        {
            #paginates search egine
         $searchstring =  $this->session->userdata('searchengine');
       #  print_r($searchstring);

         $data['searchresult'] = paginate_list($this, $data,'procurement_search_list', array('SEARCHSTRING' => $searchstring));
       
          $data['current_menu'] = 'procurement_plans';
        $data['view_to_load'] = 'public/active_plans/active_plans_v';
 $this->load->view('public/home_v', $data);
        }
        else
        {

        switch ($this->uri->segment(3)) {
            //if its details
            case "details":

                //verify that plan exists
                $plan_info = get_procurement_plan_info(decryptValue($this->uri->segment(4)), '');
                if ($plan_info) {
                    //print_array($plan_info);
                    //show active plans
                    $data['pagetitle'] = get_procurement_plan_info(decryptValue($this->uri->segment(4)), 'title');
                    $data['current_menu'] = 'active_plans';
                    $data['view_to_load'] = 'public/active_plans/plan_details_v';
                    $data['plan_id'] = decryptValue($this->uri->segment(4));

                    $limit = NUM_OF_ROWS_PER_PAGE;
                    $where = array(
                        'procurement_plan_id' => decryptValue($this->uri->segment(4)),
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

  $data['current_menu'] = 'procurement_plans';
                    //load view
                    $this->load->view('public/home_v', $data);
                } else {
                    show_404();
                }
                break;

            //if its to see entry details
            case "entry_details":
                //show active plans
                $data['pagetitle'] = get_procurement_plan_entry_info(decryptValue($this->uri->segment(4)), 'title');
                $data['current_menu'] = 'active_plans';
                $data['view_to_load'] = 'public/active_plans/entry_details_v';
                $data['entry_id'] = decryptValue($this->uri->segment(4));
                //load view
                $data['current_menu'] = 'procurement_plans';
                $this->load->view('public/home_v', $data);
                break;
            default:
                //show active plans
                $data['pagetitle'] = 'Annual Procurement Plans';
                $data['current_menu'] = 'procurement_plans';

                $where = array
                (
                    'isactive' => 'y'
                );

                #show plans for the current financial yea
                $where['financial_year'] = ((date('m')>5)? date('Y') . '-' . (date('Y') + 1) : (date('Y') - 1) . '-' . date('Y'));
                $data['current_financial_year'] = ((date('m') > 5) ? date('Y') . '-' . (date('Y') + 1) : (date('Y') - 1) . '-' . date('Y'));

                $data['all_plans'] = $this->procurement_plan_m->get_where($where);
                $data['all_plans_paginated'] = $this->procurement_plan_m->get_paginated_by_criteria($num = NUM_OF_ROWS_PER_PAGE, $this->uri->segment(3), $where);
                //pagination configs
                $config = array
                (
                    'base_url' => base_url() . $this->uri->segment(1) . '/page',//contigure page base_url
                    'total_rows' => count($data['all_plans']),
                    'per_page' => NUM_OF_ROWS_PER_PAGE,
                    'num_links' => '3',
                    'use_page_numbers' => TRUE,
                    'full_tag_open' => '<div class="btn-group">',
                    'full_tag_close' => '</div>',
                    'anchor_class' => 'class="btn" ',
                    'cur_tag_open' => '<div class="btn">',
                    'cur_tag_close' => '</div>',
                    'uri_segment' => '3'

                );
                //initialise pagination
                $this->pagination->initialize($config);

                //add to data array
                $data['pages'] = $this->pagination->create_links();
                //load view

                $data['view_to_load'] = 'public/active_plans/active_plans_v';
                //load view

$this->load->view('public/home_v', $data);
               
          }
       }

      
    }

    #Function to show a selected bid's details
    function bid_details()
    {
        # Get the passed details into the url data array if any
        $urldata = $this->uri->uri_to_assoc(3, array('m', 'p', 'i'));

        # Pick all assigned data
        $data = assign_to_data($urldata);

        if (!empty($data['i'])) {
            $app_select_str = ' procurement_plan_entries.isactive="Y" ';

            $bid_id = decryptValue($data['i']);
            $data['formdata'] = $this->Query_reader->get_row_as_array('search_table', array('table' => 'bidinvitations', 'limittext' => '', 'orderby' => 'id', 'searchstring' => ' id="' . $bid_id . '" AND isactive="Y"'));

            if (empty($data['formdata']) || $data['formdata']['isapproved'] == 'N' || empty($data['formdata']['cc_approval_date'])) {
                $data['msg'] = "WARNING: The bid invitation has not been approved";
                $this->session->set_userdata('sres', $data['msg']);

                redirect('bids/manage_bid_invitations/m/sres');
            }

            #get procurement plan details
            if (!empty($data['formdata']['procurement_id'])) {
                $data['formdata']['procurement_details'] = $this->Query_reader->get_row_as_array('procurement_plan_details', array('searchstring' => $app_select_str . ' AND procurement_plan_entries.id="' . $data['formdata']['procurement_id'] . '"', 'limittext' => '', 'orderby' => ' procurement_plan_entries.dateadded '));
                #print_array($data['formdata']['procurement_details']);
                #exit($this->db->last_query());
            }
        }

        $data['current_menu'] = 'view_bid_invitations';
        $data['view_to_load'] = 'public/includes/bid_details';

        $this->load->view('public/home_v', $data);
    }


    #Function to show a selected bid's list of addenda
    function addenda_list()
    {
        # Get the passed details into the url data array if any
        $urldata = $this->uri->uri_to_assoc(3, array('m', 'p', 'a'));

        # Pick all assigned data
        $data = assign_to_data($urldata);

        #normal page load
        if(!empty($data['a']))
        {
            $bid_id = decryptValue($data['a']);

            #bid_details
            $data['bid_details'] = $this->Query_reader->get_row_as_array('bid_invitation_details', array('orderby'=>'bid_dateadded DESC', 'searchstring'=>'bidinvitations.isactive = "Y" AND bidinvitations.id="'. $bid_id .'"', 'limittext'=>''));

            #get available bids
            $data = paginate_list($this, $data, 'search_addenda', array('orderby' => 'A.id', 'searchstring' => ' AND A.bidid="'. $bid_id .'" AND BI.isactive="Y"'));
            #exit($this->db->last_query());
        }

        $data['current_menu'] = 'view_bid_invitations';
        $data['view_to_load'] = 'public/includes/addenda_list';

        $this->load->view('public/home_v', $data);
    }


    #Function to show awarded contracts
    function awarded_contracts()
    {
          $urldata = $this->uri->uri_to_assoc(3, array('m'));
        # Pick all assigned data
       
          $data = assign_to_data($urldata);
         if(!empty($urldata['level']) && ($urldata['level'] == 'search'))
        {
         
         #paginates search egine
         $searchstring =  $this->session->userdata('searchengineA');  
         # print_r($searchstring);
         $data = paginate_list($this, $data, 'get_published_contracts', array('orderby' => 'date_signed DESC', 'searchstring' => $searchstring), 10);
                
        // $data = paginate_list($this, $data, 'get_published_contracts', array('orderby' => 'date_signed DESC', 'searchstring' => $searchstring), 10);
         #$data['page_list'] = $this->disposal->fetch_disposal_records($data,$searchstring);
         $data['level'] = 'search';

         $data['view_to_load'] = 'public/includes/awarded_contracts';
         $data['current_menu'] = 'awarded_contracts';
         $this->load->view('public/home_v', $data);
       
      }
      else
      {
        $this->db->order_by("pdename", "asc");
        $data['pdes'] = $this->db->get_where('pdes', array('isactive' => 'Y', 'status' => 'in'))->result_array();
        # Get the passed details into the url data array if any
        $urldata = $this->uri->uri_to_assoc(3, array('m', 'p'));

        # Pick all assigned data
        $data = assign_to_data($urldata);

        #Show contract details
        switch ($this->uri->segment(3)) {
            //if its details
            case "details":
                //verify that contract exists
                $contract_info = get_contract_detail_info(decryptValue($this->uri->segment(4)), '');
                if ($contract_info) {

                    $contractid = decryptValue($this->uri->segment(4));
                    $data['details'] = $this->Query_reader->get_row_as_array('get_published_contracts', array('searchstring' => ' AND C.id = "'. $contractid .'"', 'limittext'=>'', 'orderby'=>'date_signed'));
                    $data['current_menu'] = 'awarded_contracts';
                    $data['view_to_load'] = 'public/includes/contract_details_v';
                    $this->load->view('public/home_v', $data);
                }
            break;

            default:
                #get available contracts
                $data = paginate_list($this, $data, 'get_published_contracts', array('orderby' => 'date_signed DESC', 'searchstring' => ''), 10);
                
                $data['view_to_load'] = 'public/includes/awarded_contracts';
                $data['current_menu'] = 'awarded_contracts';
                $this->load->view('public/home_v', $data);
        }
        }
    }


    #publish best evaluated bidder to the front end
    function suspended_providers()
    {
        $urldata = $this->uri->uri_to_assoc(3, array('m'));
        # Pick all assigned data
        $data = assign_to_data($urldata);
        //  $this->load->model('Remoteapi_m');

        $data['suspendedlist'] = $this->Remoteapi_m->suspended_providers(0, 10000);
        $data['title'] = 'National Tender Portal';
        $data['current_menu'] = 'suspended_providers';
        $this->load->view('public/suspended_providers_v', $data);

    }
    #page
    function beb_notice()
    {
            $urldata = $this->uri->uri_to_assoc(3, array('m'));
            # Pick all assigned data
            $data = assign_to_data($urldata);
            //  $this->load->model('Remoteapi_m');
            $post = $_POST;
            #print_r($post['receiptid']); exit();
            $data['beb'] = paginate_list($this, $data, 'view_bebs',  array('SEARCHSTRING' => ' and bestevaluatedbidder.bidid = bidinvitations.id and receipts.receiptid ='.$post['receiptid'] ),10);
            $this->load->view('public/bebnotice', $data);
        }

    function disposal_plans(){

        $urldata = $this->uri->uri_to_assoc(3, array('m'));
        # Pick all assigned data
        $data = assign_to_data($urldata);

        if(!empty($urldata['level']) && ($urldata['level'] == 'search'))
        {
            #paginates search egine
         $searchstring =  $this->session->userdata('searchengine');          
         $data['page_list'] = $this->disposal->fetch_disposal_records($data,$searchstring);
        $data['leve'] = 'search';

      }
      else
      {
        $this->db->order_by("title", "asc");
        $data['procurement_types'] = $this->db->get_where('procurement_types', array('isactive' => 'Y'))->result_array();

        $this->db->order_by("title", "asc");
        $data['procurement_methods'] = $this->db->get_where('procurement_methods', array('isactive' => 'Y'))->result_array();

        $this->db->order_by("pdename", "asc");
        $data['pdes'] = $this->db->get_where('pdes', array('isactive' => 'Y', 'status' => 'in'))->result_array();


        if (!empty($data['details'])) {
            $disposalplan = base64_decode($data['details']);
            $searchstring = ' 1 =1 and disposal_plans.id = ' . $disposalplan . '';
            $data['details'];
                        $data['page_list'] = $this->disposal->fetch_disposal_records($data,$searchstring);
                    
        } else {
            $searchstring = ' 1 =1 ';
            $currentyear = ((date('m') > 5) ? date('Y') . '-' . (date('Y') + 1) : (date('Y') - 1) . '-' . date('Y'));
            $searchstring .= ' and financial_year like "%' . $currentyear . '%"';
                        $data['page_list'] =   paginate_list($this, $data, 'fetched_disposal_plans', array('searchstring'=>$searchstring),10);
            
        }

      }
        $data['title'] = 'National Tender Portal';
        $data['current_menu'] = 'disposal_plans';
        $this->load->view('public/disposal', $data);


        }
        function suspendedproviders_search()
        {
              $urldata = $this->uri->uri_to_assoc(3, array('m'));
        # Pick all assigned data
        $data = assign_to_data($urldata);
      
        $organisation = $_POST['organisation'];
        #  print_r($organisation); 
      #  exit();
        //  $this->load->model('Remoteapi_m');
        $searchstring = "and if(a.orgid>0,b.orgname like '%".mysql_real_escape_string($organisation)."%',a.orgid like '%".mysql_real_escape_string($organisation)."%') ";

        $data['suspendedlist'] = $this->Remoteapi_m->suspended_providers2($searchstring);
        $data['title'] = 'National Tender Portal';
        $data['current_menu'] = 'suspended_providers';
        $this->load->view('providers/susadons', $data);
        }

    function procurement_plans_search()
    {
        $this->db->order_by("pdename", "asc");
        $data['pdes'] = $this->db->get_where('pdes', array('isactive' => 'Y', 'status' => 'in'))->result_array();
        //switch by parameter passed
        switch ($this->uri->segment(3)) {
            //if its details
            case "details":
                //verify that plan exists
                $plan_info = get_procurement_plan_info(decryptValue($this->uri->segment(4)), '');
                if ($plan_info) {
                    //print_array($plan_info);
                    //show active plans
                    $data['pagetitle'] = get_procurement_plan_info(decryptValue($this->uri->segment(4)), 'title');
                    $data['current_menu'] = 'active_plans';
                    $data['view_to_load'] = 'public/active_plans/plan_details_v';
                    $data['plan_id'] = decryptValue($this->uri->segment(4));




                    $limit = NUM_OF_ROWS_PER_PAGE;
                    $where = array(
                        'procurement_plan_id' => decryptValue($this->uri->segment(4)),
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

                break;

            //if its to see entry details
            case "entry_details":
                //show active plans
                $data['pagetitle'] = get_procurement_plan_entry_info(decryptValue($this->uri->segment(4)), 'title');
                $data['current_menu'] = 'active_plans';
                $data['view_to_load'] = 'public/active_plans/entry_details_v';
                $data['entry_id'] = decryptValue($this->uri->segment(4));
                //load view
                $this->load->view('public/home_v', $data);
                break;
            default:

            $financial_year = mysql_real_escape_string($_POST['procurement_method']);
            $entity = mysql_real_escape_string($_POST['entity']);
                //show active plans
                $data['pagetitle'] = 'Annual Procurement Plans';
                $data['current_menu'] = 'procurement_plans';

                $where = array
                (
                    'isactive' => 'y',
                    'financial_year'=>'like "%'.$financial_year.'%"'
                );

                #show plans for the current financial year
                $where['financial_year'] = ((date('m')>5)? date('Y') . '-' . (date('Y') + 1) : (date('Y') - 1) . '-' . date('Y'));

                $data['all_plans'] = $this->procurement_plan_m->get_where($where);
                $data['all_plans_paginated'] = $this->procurement_plan_m->get_paginated_by_criteria($num = NUM_OF_ROWS_PER_PAGE, $this->uri->segment(3), $where);
                //pagination configs
                $config = array
                (
                    'base_url' => base_url() . $this->uri->segment(1) . '/page',//contigure page base_url
                    'total_rows' => count($data['all_plans']),
                    'per_page' => NUM_OF_ROWS_PER_PAGE,
                    'num_links' => '3',
                    'use_page_numbers' => TRUE,
                    'full_tag_open' => '<div class="btn-group">',
                    'full_tag_close' => '</div>',
                    'anchor_class' => 'class="btn" ',
                    'cur_tag_open' => '<div class="btn">',
                    'cur_tag_close' => '</div>',
                    'uri_segment' => '3'

                );
                //initialise pagination
                $this->pagination->initialize($config);

                //add to data array
                $data['pages'] = $this->pagination->create_links();
                //load view

                $data['view_to_load'] = 'public/active_plans/active_plans_v';
                //load view
                $this->load->view('public/home_v', $data);
        }

    }

    function verifybeb()
    {
        $data['view_to_load'] = 'public/includes/verifybeb_v';
        $this->load->view('public/home_v', $data);

    }

    function searchbeb()
    {
        $urldata = $this->uri->uri_to_assoc(3, array('m'));
        # Pick all assigned data
        $data = assign_to_data($urldata);
        #print_r( $this->uri->segment(3));
        $level = $this->uri->segment(3);
        switch ($level) {
            case 'verify':
                # code...
                $post = $_POST;
                $serialno = mysql_real_escape_string($post['serialno']);
                #$result = paginate_list($this, $data, 'fetchbebs', array('SEARCHSTRING' => ' and bestevaluatedbidder.ispublished = "Y"  and  receipts.beb="Y" order by bestevaluatedbidder.dateadded DESC'),10);
                $query = $this->Query_reader->get_query_by_code('fetchbebs', array('SEARCHSTRING' => 'and bestevaluatedbidder.ispublished = "Y"  and  receipts.beb="Y"  and  bestevaluatedbidder.seerialnumber like "' . $serialno . '%" order by bestevaluatedbidder.dateadded DESC', 'limittext' => '', 'orderby' => ''));
                $result = $this->db->query($query)->result_array();
                #print_r($serialno);
                if (!empty($result)) {
                    $post['receiptid'] = $result[0]['receiptid'];
                    #$post = $_POST;
                    #print_r($post['receiptid']); exit();
                    $data['beb'] = paginate_list($this, $data, 'view_bebs', array('SEARCHSTRING' => ' and bestevaluatedbidder.bidid = bidinvitations.id and receipts.receiptid =' . $post['receiptid']), 10);
                    $this->load->view('public/bebnotice', $data);
                } else {
                    print_r("0");
                }
                #print_r($query); exit();

                #   $query = $this->db->query()->result_array;

                break;

            default:
                # code...
                break;
        }
        }


    function generate_pdf(){
        $where = array(
            'procurement_plan_id' => decryptValue('MjQ='),
            'isactive' => 'Y'
        );
        $data['all_entries'] = $this->procurement_plan_entry_m->get_where($where);
        $this->load->view('pdfreport',$data);
    }

     function scheduler(){

        $this->schedule_m->add_user();

    }


   function search_procurement()
    {

         $urldata = $this->uri->uri_to_assoc(3, array('m'));
        # Pick all assigned data
        $data = assign_to_data($urldata);
        #procurement_search_list
         # $query = $this->Query_reader->get_query_by_code('fetchbebs', array('SEARCHSTRING' => 'and bestevaluatedbidder.ispublished = "Y"  and  receipts.beb="Y"  and  bestevaluatedbidder.seerialnumber like "'.$serialno.'%" order by bestevaluatedbidder.dateadded DESC','limittext' => '','orderby' => ''));
       # $result = $this->db->query($query)->result_array();
       // print_r($_POST);
       // echo "<br/>";
       // exit();
        #unset sesion ::
       
       if(!empty($_POST))
       {
        $searchstring = '1 = 1';
        if(!empty($_POST['procurement_entity']) && ( $_POST['procurement_entity'] > 0 ))
        {
            $searchstring .= ' AND pdes.pdeid ='.mysql_real_escape_string($_POST['procurement_entity']);
        }

        if(!empty($_POST['procurement_type']) && ($_POST['procurement_type'] > 0))
        {
             $searchstring .= ' AND procurement_types.id ='.mysql_real_escape_string($_POST['procurement_type']);
        }

         if(!empty($_POST['procurement_method']) && ($_POST['procurement_method'] > 0))
        {
             $searchstring .= ' AND procurement_methods.id ='.mysql_real_escape_string($_POST['procurement_method']);
        }

         if(!empty($_POST['procurement_method']) && ($_POST['procurement_method'] > 0))
        {
             $searchstring .= ' AND procurement_methods.id ='.mysql_real_escape_string($_POST['procurement_method']);
        }

         if(!empty($_POST['sourceof_funding']) && ($_POST['sourceof_funding'] > 0))
        {
             $searchstring .= ' AND funding_sources.id ='.mysql_real_escape_string($_POST['sourceof_funding']);
        }

         if(!empty($_POST['subjectof_procurement']))
        {
            $subject_of_procurement= mysql_real_escape_string($_POST['subjectof_procurement']);
            $searchstring .= ' AND  procurement_plan_entries.subject_of_procurement like "%'.$subject_of_procurement.'%" ';
        }
         if(!empty($_POST['financial_year']))
        {
            $financial_year= mysql_real_escape_string($_POST['financial_year']);
            $searchstring .= ' AND  procurement_plans.financial_year like "%'.$financial_year.'%" ';
        }
#print_r($searchstring);
#exit();
      
        $this->session->set_userdata('searchengine',$searchstring);
        $data['searchresult'] = paginate_list($this, $data,'procurement_search_list', array('SEARCHSTRING' => $searchstring));
       
       # print_r($data['searchresult']); exit();
         #exit('reached');
        #$data['result'] = $this->db->query($query)->result_array();
        $this->load->view('public/active_plans/entry_details_search_v', $data);


       }
    }

     function search_currentbids()
     {
        # Get the passed details into the url data array if any
        $urldata = $this->uri->uri_to_assoc(3, array('m', 'p'));
        
        # Pick all assigned data
        $data = assign_to_data($urldata);

        #Search results
         $search_str = '1 =1 ';
            if(!empty($_POST['subjectof_procurement']))
               $search_str = 'procurement_plan_entries.subject_of_procurement LIKE "%' .mysql_real_escape_string($_POST['subjectof_procurement']) . '%"';

           #  if (!empty($_POST['date_posted_from']) && !empty($_POST['date_posted_to']))
              #  $search_str .= ' AND bid_invitation_details.bid_date_approved >  "' . custom_date_format('Y-m-d', $_POST['date_posted_from']) . '" - INTERVAL 1 DAY ' .' AND bid_invitation_details.bid_date_approved <  "' . custom_date_format('Y-m-d', $_POST['date_posted_to']) . '" + INTERVAL 1 DAY ';

            if(!empty($_POST['procurement_type']))
               $search_str .= ' AND procurement_plan_entries.procurement_type =  "' .mysql_real_escape_string($_POST['procurement_type']). '"';

            if(!empty($_POST['procurement_method']) && ($_POST['procurement_method'] > 0))
               $search_str .= ' AND procurement_plan_entries.procurement_method =  "' .mysql_real_escape_string($_POST['procurement_method']). '"';

            if(!empty($_POST['procurement_entity']) && ( $_POST['procurement_entity'] > 0 ))
               $search_str .= ' AND procurement_plans.pde_id =  "' .mysql_real_escape_string($_POST['procurement_entity']) . '"';

            if(!empty($_POST['financial_year']))
            {
                $financial_year= mysql_real_escape_string($_POST['financial_year']);
                $search_str .= ' AND  procurement_plans.financial_year like "%'.$financial_year.'%" ';
            }

            if(!empty($_POST['sourceof_funding']) && ($_POST['sourceof_funding'] > 0))
                $search_str .= ' AND funding_sources.id ='.mysql_real_escape_string($_POST['sourceof_funding']);
                
            if(!empty($_POST['admin_review']) && ($_POST['admin_review'] > 0))
                $search_str .= ' AND bestevaluatedbidder.ispublished = "'.$_POST['admin_review'].'"';
            
            $this->session->set_userdata('searchengines',$search_str);
            
            $data = paginate_list($this, $data, 'bid_invitation_details', array('orderby' => 'bid_dateadded DESC', 'searchstring' => $search_str .
                ' AND bidinvitations.isactive = "Y" AND bidinvitations.isapproved="Y" AND bidinvitations.bid_submission_deadline>NOW()'),10);

            #  $data['formdata'] = $_POST;

             $this->load->view('public/includes/search_latest_bids', $data);


       }


       function search_best_evaluated_bidder()
       {
            $urldata = $this->uri->uri_to_assoc(3, array('m'));
            
            # Pick all assigned data
            $data = assign_to_data($urldata);
            $searchstring = '';
     
            if(!empty($_POST))
            {
                #$searchstring = '1 = 1';
                if(!empty($_POST['procurement_entity']) && ( $_POST['procurement_entity'] > 0 ))
                {
                    $searchstring .= ' AND  b.pdeid ='.mysql_real_escape_string($_POST['procurement_entity']);
                }

                if(!empty($_POST['procurement_type']) && ($_POST['procurement_type'] > 0))
                {
                     $searchstring .= ' AND E.id ='.mysql_real_escape_string($_POST['procurement_type']);
                }

                if(!empty($_POST['procurement_method']) && ($_POST['procurement_method'] > 0))
                {
                     $searchstring .= ' AND F.id ='.mysql_real_escape_string($_POST['procurement_method']);
                }

                if(!empty($_POST['procurement_method']) && ($_POST['procurement_method'] > 0))
                {
                     $searchstring .= ' AND F.id ='.mysql_real_escape_string($_POST['procurement_method']);
                }

                if(!empty($_POST['sourceof_funding']) && ($_POST['sourceof_funding'] > 0))
                {
                     $searchstring .= ' AND I.id ='.mysql_real_escape_string($_POST['sourceof_funding']);
                }

                if(!empty($_POST['subjectof_procurement']))
                {
                    $subject_of_procurement= mysql_real_escape_string($_POST['subjectof_procurement']);
                    
                    $searchstring .= ' AND  procurement_plan_entries.subject_of_procurement like "%'.$subject_of_procurement.'%" ';
                }
                
                if(!empty($_POST['financial_year']))
                {
                    $financial_year= mysql_real_escape_string($_POST['financial_year']);
                    $searchstring .= ' AND  a.financial_year like "%'.$financial_year.'%" ';
                }
                
                if(!empty($_POST['best_beb']))
                {
                    $provider_beb = mysql_real_escape_string($_POST['best_beb']);
                    // $query = $this->db->query("SELECT providerid FROM providers WHERE providernames LIKE '%".$provider_beb."%'")->result_array();
                    
                    // foreach($query as $row)
                    // {
                    //     //print_r($row['providerid']);
                    //     $searchstring .=' AND receipts.providerid ='.$row['providerid'];
                    // }
                   $searchstring .= ' AND  if(receipts.providerid > 0, receipts.providerid  in (select  providerid from providers where providernames like "%'.$provider_beb.'%" ) , joint_venture.providers in(select  providerid from providers where providernames like "%'.$provider_beb.'%")  )     ' ;
                    
                }
                
                if(!empty($_POST['admin_review']))
                {
                    $post_status_dropdown = $_POST['admin_review'];
                    $searchstring .=' AND bestevaluatedbidder.isreviewed = "'.$post_status_dropdown.'"';
                }
                 $this->session->set_userdata('searchengine3',$searchstring);
       }
       

        $data['page_list'] = $this->Receipts_m->fetchbeb($data,$searchstring);

        $this->db->order_by("title", "asc");
        $data['procurement_types'] = $this->db->get_where('procurement_types', array('isactive' => 'Y'))->result_array();

        $this->db->order_by("title", "asc");
        $data['procurement_methods'] = $this->db->get_where('procurement_methods', array('isactive' => 'Y'))->result_array();

        $this->db->order_by("pdename", "asc");
        $data['pdes'] = $this->db->get_where('pdes', array('isactive' => 'Y', 'status' => 'in'))->result_array();

        $data['title'] = 'National Tender Portal';
        $data['current_menu'] = 'beb';
        $this->load->view('public/searchbeb_v', $data);

    }


    function search_awarded_contracts()
    {
        $urldata = $this->uri->uri_to_assoc(3, array('m'));
        
        #Pick all assigned data
        $data = assign_to_data($urldata);
        $searchstring = '';
        
        if(!empty($_POST))
        {
            #    $searchstring = '1 = 1';
            if(!empty($_POST['procurement_entity']) && ( $_POST['procurement_entity'] > 0 ))
            {
                $searchstring .= ' AND  pdes.pdeid ='.mysql_real_escape_string($_POST['procurement_entity']);
            }

            if(!empty($_POST['procurement_type']) && ($_POST['procurement_type'] > 0))
            {
                 $searchstring .= ' AND PPE.procurement_type ='.mysql_real_escape_string($_POST['procurement_type']);
            }

            if(!empty($_POST['procurement_method']) && ($_POST['procurement_method'] > 0))
            {
                 $searchstring .= ' AND PPE.procurement_method ='.mysql_real_escape_string($_POST['procurement_method']);
            }

            if(!empty($_POST['sourceof_funding']) && ($_POST['sourceof_funding'] > 0))
            {
                 $searchstring .= ' AND PPE.funding_source ='.mysql_real_escape_string($_POST['sourceof_funding']);
            }

            if(!empty($_POST['subjectof_procurement']))
            {
                $subject_of_procurement= mysql_real_escape_string($_POST['subjectof_procurement']);
                $searchstring .= ' AND  PPE.subject_of_procurement like "%'.$subject_of_procurement.'%" ';
            }
        
            if(!empty($_POST['financial_year']))
            {
                $financial_year= mysql_real_escape_string($_POST['financial_year']);
                $searchstring .= ' AND  PP.financial_year like "%'.$financial_year.'%" ';
            }
            
            if(!empty($_POST['service_providers']))
            {
                $contract_providers = mysql_real_escape_string($_POST['service_providers']);
                $searchstring .=' AND providernames LIKE "%'.$contract_providers.'%"';
            }
            
            if(!empty($_POST['contracts_status']))
            {
                switch($_POST['contracts_status'])
                {
                    case 'A':
                        $searchstring .= ' AND actual_completion_date IS NULL OR actual_completion_date = " "';
                    break;
                    
                    case 'C':
                        $searchstring .= ' AND actual_completion_date != " " OR actual_completion_date IS NOT NULL';
                    break;
                }
                
            }
       }
        $this->session->set_userdata('searchengineA',$searchstring);

         #$query = $this->Query_reader->get_query_by_code('get_published_contracts',  array('orderby' => 'date_signed DESC', 'searchstring' => $searchstring,'limittext'=>''));
        # print_r($query); exit();

        $data = paginate_list($this, $data, 'get_published_contracts', array('orderby' => 'date_signed DESC', 'searchstring' => $searchstring), 10);
        
        $data['view_to_load'] = 'public/includes/awarded_contracts';
        $data['current_menu'] = 'awarded_contracts';
        $this->load->view('public/includes/search_awarded_contracts', $data);
    }

    function search_diposal_plans()
    {
          $urldata = $this->uri->uri_to_assoc(3, array('m'));
        # Pick all assigned data
        $data = assign_to_data($urldata);
        $this->db->order_by("title", "asc");
        $data['procurement_types'] = $this->db->get_where('procurement_types', array('isactive' => 'Y'))->result_array();

        $this->db->order_by("title", "asc");
        $data['procurement_methods'] = $this->db->get_where('procurement_methods', array('isactive' => 'Y'))->result_array();

          $this->db->order_by("pdename", "asc");
          $data['pdes'] = $this->db->get_where('pdes', array('isactive' => 'Y', 'status' => 'in'))->result_array();

          $searchstring = '1 = 1 ';
          if(!empty($_POST))
          {
                   if(!empty($_POST['disposing_entity']) && ( $_POST['disposing_entity'] > 0 ))
                    {
                        $searchstring .= ' AND  pdes.pdeid ='.mysql_real_escape_string($_POST['disposing_entity']);
                    }

                    if(!empty($_POST['disposing_method']) && ( $_POST['disposing_method'] > 0 ))
                    {
                        $searchstring .= ' AND  disposal_method.id ='.mysql_real_escape_string($_POST['disposing_method']);
                    }

                    if(!empty($_POST['financial_year']))
                    {
                        $searchstring .= ' AND  disposal_plans.financial_year  like "%'.mysql_real_escape_string($_POST['financial_year']).'%"';
                    }

                        if(!empty($_POST['subjectof_disposal']))
                    {
                        $searchstring .= ' AND  disposal_record.subject_of_disposal like "%'.mysql_real_escape_string($_POST['subjectof_disposal']).'%"';
                    }
          }

        # Adding Search Engine :: 
        $this->session->set_userdata('searchengine',$searchstring);
        $data['page_list'] = $this->disposal->fetch_disposal_records($data,$searchstring);
        $data['title'] = 'National Tender Portal';
        $data['current_menu'] = 'disposal_plans';
        $this->load->view('public/search_disposal', $data);

    }

     function testemailsendtorop()
     {
        echo "INITIALIZING";
        $data =  $this-> Remoteapi_m -> emaillist_providers();
       print_r($data);
        echo "END";
     }
     
     function weeklyreport()
     {
     weeklyreport();
     echo "Finalized @ ";
            
     }
     
     # SEND EMAIL ALERTS TO ROP
     function notifyrop()
     {
      # echo "reached";
       $segment = $this->uri->segment(3);
    #   echo($segment);
    if(!empty($segment)){
       
       $bidinvitation =     $segment;
       if(!empty($bidinvitation ))
       {
        
       notifyropp($bidinvitation);
       }
     }


     }



}