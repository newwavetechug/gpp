<?php

function get_bid_invitation_info($passed_id, $param)
{
    $ci =& get_instance();
    $ci->load->model('bid_invitation_m');


    return $ci->bid_invitation_m->get_bid_invitation_info($passed_id, $param);

}

function get_bids_due_to_expire_next_week()
{
    $ci =& get_instance();
    $ci->load->model('bid_invitation_m');
    $from=mysqldate();
    $to=date('d-M-Y',strtotime(mysqldate())+604800) ;


    return $ci->bid_invitation_m->get_bid_submission_deadlines_by_month($from,$to);

}


