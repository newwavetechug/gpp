<?php
ob_start();
/**
* Created by PhpStorm.
* User: user
* Date: 4/20/14
* Time: 3:04 PM
*
* controls notifications CRUD
*/

class Notification_m extends MY_Model
{

function __construct()
{
// Call the Model constructor
parent::__construct();
}

public $_tablename='notifications';
public $_primary_key='id';

//mark as seen
    public function mark_as_seen($user_id,$msg_id)
    {
    $data=array
    (
    'seen'=>'y'
    );
    $this->db->where('user_id', $user_id);
    $this->db->update('users', $data);

    }

//prevent duplications
public function prevent_duplicate($notification_data){
//the query
$query=$this->db->select()->from('notifications')->where($notification_data)->get()  ;

return $query->num_rows();
}

public function get_unseen_messages($userid,$param)
{
$data = array
(
'user_id'   =>$userid,
'seen'      =>'n',
'trash'     =>'n'
);
$query=$this->db->select()->from($this->_tablename)->where($data)->get();

foreach($query->result_array() as $row)
{
switch($param)
{
//case of notifications
case 'message':
$result=$row['notification'];
break;
case 'alert_type':
$result=$row['alert_type'];
break;
case 'dateadded':
$result=$row['dateadded'];
break;
default:
$result=$query->result_array();
}

return $result;
}
}

//EMAIL ACCESS

function email_access($permission,$pdeid)
{
$usergroup = $this->session->userdata('usergroup');
$receipients_str = '';


if($this->session->userdata('level') =='ppda'){
$data = array('searchstring' => ' permissions.code = "'.$permission.'"  AND groupaccess.groupid ="14" ');
}

else{
$data = array('searchstring' => ' permissions.code = "'.$permission.'"  AND users.pde = "' . $pdeid . '" AND groupaccess.groupid ="'.$usergroup.'"');
}

$query = $this->Query_reader->get_query_by_code('notification_access', $data);
# print_r($query); exit();
$result = $this->db->query($query)->result_array();
$emailarray = array();

if(!empty($result))
{
  
foreach($result as $row)
{
  
if(in_array($row['emailaddress'], $emailarray))
continue;

$receipients_str .= (!empty($receipients_str)? '|' : '') . $row['emailaddress'];
array_push($emailarray,$row['emailaddress']);
}

$receipients_str = '|' . $receipients_str . '|';

}

# print_r($receipients_str); exit();
return $receipients_str;
}



//NOTIFICATION ACCESS
function notification_access($permission, $pdeid)
{
$usergroup = $this->session->userdata('usergroup');
$receipients_str = '';
$receipients_str2 = '';

$datasx = $this->session->userdata('level');
if(!empty($datasx) ){
$data = array('searchstring' => ' groupaccess.groupid ="14" ');
$this->session->unset_userdata('level');
}

else{
$data = array('searchstring' => ' permissions.code = "'.$permission.'"  AND users.pde = "' . $pdeid . '" ');

#AND groupaccess.groupid ="'.$usergroup.'"
}
#$data = array('searchstring' => ' permissions.code = "'.$permission.'"  AND users.pde = "' . $pdeid . '" AND groupaccess.groupid ="'.$usergroup.'"');

$query = $this->Query_reader->get_query_by_code('notification_access', $data);
#  echo "reslute <br/>";
#  print_r($query); exit();
#echo "<br/>";

$result = $this->db->query($query)->result_array();

if(!empty($result))
{
  $emailarray = array();
foreach($result as $row)
{

  if(in_array($row['emailaddress'], $emailarray))
  continue;
  
  $receipients_str .= (!empty($receipients_str)? '|' : '') . $row['userid'];
  $receipients_str2 .= (!empty($receipients_str2)? '|' : '') . $row['emailaddress'];
  
  array_push($emailarray,$row['emailaddress']);

}

$receipients_str = '|' . $receipients_str . '|';
$receipients_str2 = '|' . $receipients_str2 . '|';




# print_r($receipients_str); exit()
}

return $receipients_str."<><><>".$receipients_str2;
}

function push_permission($title,$body,$level,$permission,$entity='')
{

$this->load->library('email');
/* SAVE NOTIFICATION*/
$title = mysql_real_escape_string($title);
$body = mysql_real_escape_string($body);
$level = mysql_real_escape_string($level);

$data = array('TITLE' => $title,'BODY'=>$body,'ISACTIVE'=>'Y','LEVEL'=>$level);

$query = $this->Query_reader->get_query_by_code('insert_notification', $data);
#  echo "<BR/>--------------------------------------<BR/>";
#  echo $query;
#  echo "<BR/>---------------------------------------<BR/>";
#print_r($query); exit();
if($query){
$result = $this->db->query($query);
$insertid = $this->db->insert_id();
#print_r("<BR/> ::::: ".$insertid."<BR/> :::: "); exit();
#INSERT ID

#print_r($insertid);
#echo "<BR/><BR/>"; exit();


/* RECEPIENTS ACCESS */
#  $pdeid =  $this->session->userdata('pdeid');

#  $pdeidd = $this->session->userdata('pdeidd');


$pdeid =  $this->session->userdata('pdeid');


$recipients = $this->notification_access($permission,$pdeid);
$ni_recepient = explode("<><><>",$recipients);
$r1 = $ni_recepient[0];
$r2 = $ni_recepient[1];
// print_r($r2);
// exit();
$recipients = rtrim($r1,'|');
$recipientsarray = explode("|", $recipients);
$emailarray = explode("|", $r2);
#print_r($emailarray);
//  exit();

#  echo "<BR/> ";

#print_r($pdeid .':::::'. $permission);
#echo " ";

for($x = 0; $x < count($recipientsarray); $x ++)
{
if(($recipientsarray[$x] == 0) || ($insertid == 0)) continue;

$datar = array('RECEPIENTID' => $recipientsarray[$x],'NOTIFICATIONID'=>$insertid,'ISACTIVE'=>'Y');
$query = $this->Query_reader->get_query_by_code('insert_notifications_recipients', $datar);
$result = $this->db->query($query);
# print_r($recipientsarray[$x]);

# echo "<br/>";
#send email alerts

$emailaddr = $emailarray[$x];
if($emailaddr =='') continue;
#$emailadress = array('RECEPIENTID' => $recipientsarray[$x],'NOTIFICATIONID'=>$insertid,'ISACTIVE'=>'Y');




$this->email->from('noreply@tenderportal.ppda.go.ug', 'Tender Portal Notifications');
$this->email->to(''.$emailaddr.'');

//$this->email->cc('rmuyinda@newwavetech.co.ug');
#$this->email->bcc('rmuyinda@newwavetech.co.ug');

$this->email->subject(''.$title.'');
$this->email->message(''.$body.'');

$this->email->send();
}



$datasx = $this->session->userdata('level');
if(!empty($datasx) && ($datasx  =='ppda') ){
#   $data = array('searchstring' => ' groupaccess.groupid ="14" ');
$this->session->unset_userdata('level');
}
$pdeidd = $this->session->userdata('pdeidd');

if(!empty($pdeidd))
{
$pdeid  =$pdeidd;
$this->session->unset_userdata('pdeidd');
}



}




}

function number_of_notifications($userid, $searchstring )
{
#$query = $this->Query_reader->get_query_by_code('new_user_notifications',$searchstring );
# print_r($query); exit();

$result_row = $this->Query_reader->get_row_as_array('new_user_notifications', $searchstring);
return $result_row['numOfNotifications'];
}

function number_of_other_notifications($userid, $searchstring )
{
#$query = $this->Query_reader->get_query_by_code('new_user_notifications',$searchstring );
# print_r($query); exit();

$result_row = $this->Query_reader->get_row_as_array('old_notifications', $searchstring);
return $result_row['numOfNotifications'];
}




function sample_new_notifications($userid, $searchstring )
{
$query = $this->Query_reader->get_query_by_code('sample_new_notifications', $searchstring);
$result = $this->db->query($query)->result_array();
return $result;

}
function  update_status($userid,$notification,$status){
$searchstring = array('NOTIFICATION' => $notification ,'USERID'=>$userid,'STATUS'=>$status );
$query = $this->Query_reader->get_query_by_code('insert_notification_status', $searchstring);
#print_r($query); exit();
$result = $this->db->query($query);
return 1;
}

function view_notifications($userid,$data = array())
{
if(empty($data)){

$query = $this->Query_reader->get_query_by_code('view_user_notifications', array('userid' => $userid,'limittext'=>'limit 5'));

$result = $this->db->query($query)->result_array();
return $result;
}

}
function view_notification($notification_id){
$query = $this->Query_reader->get_query_by_code('notification_detail', array('id' => $notification_id ));

$result = $this->db->query($query)->result_array();

$userid = $this->session->userdata('userid');
update_status($userid,$result[0]['id'],'R');

return $result;
}


function fetch_notifications($userid,$limittext=0,$data = array(),$level)
{
//notification_id
# print_r($userid); exit();
#  $query = $this->Query_reader->get_query_by_code('view_user_notifications',  array('searchstring' => '  notifications_recepients.recepient_id ='.$userid.' ','limittext'=>''));
#print_r($query);
switch ($level) {
case 'read':

$data = paginate_list($this, $data, 'view_user_notifications',  array('searchstring' => '   notifications_recepients.recepient_id = '.$userid.' AND notifications_status.status ="R"  ORDER BY notifications.dateadded DESC  ' ),10 );
return $data;
# code...
break;
case 'unread':
$data = paginate_list($this, $data, 'view_user_notifications',  array('searchstring' => '   notifications_recepients.recepient_id = '.$userid.' AND notifications_status.id  is null  ORDER BY notifications.dateadded DESC ' ),10 );
return $data;
break;
case 'starred':

$data = paginate_list($this, $data, 'view_user_notifications',  array('searchstring' => '   notifications_recepients.recepient_id = '.$userid.' AND notifications_status.status ="S" ORDER BY notifications.dateadded DESC  ' ),10 );
return $data;
# code...
break;

case 'trash':

$data = paginate_list($this, $data, 'view_user_notifications',  array('searchstring' => '   notifications_recepients.recepient_id = '.$userid.' AND notifications_status.status ="T" ORDER BY notifications.dateadded DESC ' ),10 );
return $data;
# code...
break;

default:
# code...
$data = paginate_list($this, $data, 'view_user_notifications',  array('searchstring' => '  notifications_recepients.recepient_id ='.$userid.' ORDER BY notifications.dateadded DESC ' ),10 );
return $data;
break;

}
}
function update_viewed_list($notification_id)
{ $userid = $this->session->userdata('userid');
$result_row = $this->Query_reader->get_row_as_array('notification_detail', array('id' => $notification_id));
$viewedby = explode('|',$result_row['viewedby']);
foreach ($viewedby as $key => $value) {
# code...

if($userid == $value)
{
return 0;

}

}
$viewwedby  = $result_row['viewedby'];
$viewby = ( strlen($viewwedby) > 0) ? $viewedby.'|'.$userid :'|'.$userid.'|' ;

$query = mysql_query("UPDATE  notifications set viewedby = '".$viewby."' where id= ".$notification_id) or die("".mysql_error());
return 1;


}

#wekly report
function weeklyreport($level,$data = array()){
switch ($level) {
case 'ppda':



$search_str = '  ';





#Get the paginated list of bid invitations
$results = paginate_list($this, $data, 'weekly_IFB_report',array('orderby'=>'', 'searchstring'=> ''.$search_str  ) ,1000);
# print_r($results); exit();
$table = "<div>";
if(!empty($results['page_list'])):

$table .='<table class="table table-striped table-hover">'.
'<thead>'.
'<tr>'.
'<th width="5%"></th>'.
'<th>Procurement Ref. No</th>'.
'<th class="hidden-480">Subject of procurement</th>'.
'<th class="hidden-480">Bid security</th>'.
'<th class="hidden-480">Bid invitation date</th>'.
'<th class="hidden-480">Addenda</th>'.
'<th>Status</th>'.
'<th>Published by</th>'.
'<th>Date Added</th>'.
'</tr>'.
'</thead>'.
'</tbody>';


foreach($results['page_list'] as $row)
{

$this->session->unset_userdata('pdeid');
$status_str = '';
$addenda_str = '[NONE]';
$delete_str ='';
$edit_str  = '';

if(!empty($level) && ($level == 'active'))  {
$delete_str = '<a title="Delete bid invitation" href="javascript:void(0);" onclick="confirmDeleteEntity(\''.base_url().'bids/delete_bid_invitation/i/'.encryptValue($row['bidinvitation_id']).'\', \'Are you sure you want to delete this bid invitation?\nClick OK to confirm, \nCancel to cancel this operation and stay on this page.\')"><i class="icon-trash"></i></a>';

$edit_str = '<a title="Edit bid details" href="'. base_url() .'bids/load_bid_invitation_form/i/'.encryptValue($row['bidinvitation_id']).'"><i class="icon-edit"></i></a>';
}

if($row['bid_approved'] == 'Y' && get_date_diff(date('Y-m-d'), $row['bid_submission_deadline'], 'days')<0)
{
$status_str = 'Bid evaluation | <a title="Select BEB" href="'. base_url() .'bids/approve_bid_invitation/i/'.encryptValue($row['bidinvitation_id']).'">[Select BEB]</a>';
}
elseif($row['bid_approved'] == 'N')
{
$status_str = 'Not published | <a title="Publish IFB" href="'. base_url() .'bids/approve_bid_invitation/i/'.encryptValue($row['bidinvitation_id']).'">[Publish IFB]</a>';
}
elseif($row['bid_approved'] == 'Y' && get_date_diff(date('Y-m-d'), $row['bid_submission_deadline'], 'days')>0)
{
$status_str = 'Bidding closes in '. get_date_diff(date('Y-m-d'), $row['bid_submission_deadline'], 'days') .' days | <a title="view IFB document" href="'. base_url() .'bids/view_bid_invitation/i/'.encryptValue($row['bidinvitation_id']).'">[View IFB]</a>';

$addenda_str =  '<a title="view addenda list" href="'. base_url() .'bids/view_addenda/b/'.encryptValue($row['bidinvitation_id']).'">[View Addenda]</a> | <a title="Add addenda" href="'. base_url() .'bids/load_ifb_addenda_form/b/'.encryptValue($row['bidinvitation_id']).'">[Add Addenda]</a>';
}
else
{

}

$table .='<tr>'.
'<td></td>'.
'<td>'. format_to_length($row['procurement_ref_no'], 40) .'</td>'.
'<td>'. format_to_length($row['subject_of_procurement'], 50) .'</td>'.
'<td>'. (is_numeric($row['bid_security_amount'])? number_format($row['bid_security_amount'], 0, '.', ',') . ' ' . $row['bid_security_currency_title'] :
(empty($row['bid_security_amount'])? '<i>N/A</i>' : $row['bid_security_amount'])) .'</td>'.
'<td>'. custom_date_format('d M, Y', $row['invitation_to_bid_date']) .'</td>'.
'<td>'. $addenda_str .'</td>'.
'<td>'. $status_str .'</td>'.
'<td>'. (empty($row['approver_fullname'])? 'N/A' : $row['approver_fullname']).'</td>'.
'<td>'. custom_date_format('d M, Y', $row['bid_dateadded']) .'</td>'.
'</tr>';
}

$table .='</tbody></table>';

$table .='<div class="pagination pagination-mini pagination-centered">'.
pagination($this->session->userdata('search_total_results'), $results['rows_per_page'], $results['current_list_page'], base_url().
"bids/manage_bid_invitations/".$level."/p/%d")
.'</div>';

else:
$table .= format_notice('WARNING: No bid invitations expiring this week');
endif;
$table .="</div>";
$adons  = '';
//$entity =  $records['pdeid'];


//$this->session->set_userdata('pdeid',$entity);

$datasx = $this->session->set_userdata('level','ppda');




$entityname = '';

$entityname = '';

$adons  = date('d-m');

$level = "Procurement";
# exit('moooooo');
$titles = "Weekly  report on expiring IFBs of ITP";
$body =  " ".html_entity_decode($table);
$permission = "view_bid_invitations";

$xcv = 0;


push_permission($titles,$body,$level,$permission);


#end
break;
case 'ifb':
$search_str  ='';
# code...

$querys = $this->db->query("select distinct b.pdeid,b.pdename,a.* from pdes b inner join   users a on a.pde = b.pdeid  ")->result_array();

foreach($querys as $row => $records )
{
#get the PDE ID " Idividual Pde Ids ";"
$search_str = ' AND procurement_plans.pde_id="'. $records['pdeid'] .'"';

$results = paginate_list($this, $data, 'weekly_IFB_report',array('orderby'=>'', 'searchstring'=> ''.$search_str  ) ,1000);
# print_r($results); exit();
$table = "<div>";
if(!empty($results['page_list'])):

$table .='<table class="table table-striped table-hover">'.
'<thead>'.
'<tr>'.
'<th width="5%"></th>'.
'<th>Procurement Ref. No</th>'.
'<th class="hidden-480">Subject of procurement</th>'.
'<th class="hidden-480">Bid security</th>'.
'<th class="hidden-480">Bid invitation date</th>'.
'<th class="hidden-480">Addenda</th>'.
'<th>Status</th>'.
'<th>Published by</th>'.
'<th>Date Added</th>'.
'</tr>'.
'</thead>'.
'</tbody>';


foreach($results['page_list'] as $row)
{

$this->session->unset_userdata('pdeid');
$status_str = '';
$addenda_str = '[NONE]';
$delete_str ='';
$edit_str  = '';

if(!empty($level) && ($level == 'active'))  {
$delete_str = '<a title="Delete bid invitation" href="javascript:void(0);" onclick="confirmDeleteEntity(\''.base_url().'bids/delete_bid_invitation/i/'.encryptValue($row['bidinvitation_id']).'\', \'Are you sure you want to delete this bid invitation?\nClick OK to confirm, \nCancel to cancel this operation and stay on this page.\')"><i class="icon-trash"></i></a>';

$edit_str = '<a title="Edit bid details" href="'. base_url() .'bids/load_bid_invitation_form/i/'.encryptValue($row['bidinvitation_id']).'"><i class="icon-edit"></i></a>';
}

if($row['bid_approved'] == 'Y' && get_date_diff(date('Y-m-d'), $row['bid_submission_deadline'], 'days')<0)
{
$status_str = 'Bid evaluation | <a title="Select BEB" href="'. base_url() .'bids/approve_bid_invitation/i/'.encryptValue($row['bidinvitation_id']).'">[Select BEB]</a>';
}
elseif($row['bid_approved'] == 'N')
{
$status_str = 'Not published | <a title="Publish IFB" href="'. base_url() .'bids/approve_bid_invitation/i/'.encryptValue($row['bidinvitation_id']).'">[Publish IFB]</a>';
}
elseif($row['bid_approved'] == 'Y' && get_date_diff(date('Y-m-d'), $row['bid_submission_deadline'], 'days')>0)
{
$status_str = 'Bidding closes in '. get_date_diff(date('Y-m-d'), $row['bid_submission_deadline'], 'days') .' days | <a title="view IFB document" href="'. base_url() .'bids/view_bid_invitation/i/'.encryptValue($row['bidinvitation_id']).'">[View IFB]</a>';

$addenda_str =  '<a title="view addenda list" href="'. base_url() .'bids/view_addenda/b/'.encryptValue($row['bidinvitation_id']).'">[View Addenda]</a> | <a title="Add addenda" href="'. base_url() .'bids/load_ifb_addenda_form/b/'.encryptValue($row['bidinvitation_id']).'">[Add Addenda]</a>';
}
else
{

}

$table .='<tr>'.
'<td></td>'.
'<td>'. format_to_length($row['procurement_ref_no'], 40) .'</td>'.
'<td>'. format_to_length($row['subject_of_procurement'], 50) .'</td>'.
'<td>'. (is_numeric($row['bid_security_amount'])? number_format($row['bid_security_amount'], 0, '.', ',') . ' ' . $row['bid_security_currency_title'] :
(empty($row['bid_security_amount'])? '<i>N/A</i>' : $row['bid_security_amount'])) .'</td>'.
'<td>'. custom_date_format('d M, Y', $row['invitation_to_bid_date']) .'</td>'.
'<td>'. $addenda_str .'</td>'.
'<td>'. $status_str .'</td>'.
'<td>'. (empty($row['approver_fullname'])? 'N/A' : $row['approver_fullname']).'</td>'.
'<td>'. custom_date_format('d M, Y', $row['bid_dateadded']) .'</td>'.
'</tr>';
}

$table .='</tbody></table>';

$table .='<div class="pagination pagination-mini pagination-centered">'.
pagination($this->session->userdata('search_total_results'), $results['rows_per_page'], $results['current_list_page'], base_url().
"bids/manage_bid_invitations/".$level."/p/%d")
.'</div>';

else:
$table .= format_notice('WARNING: No bid invitations expiring this week');
endif;
$table .="</div>";
$adons  = '';
$entity =  $records['pdeid'];


$this->session->set_userdata('pdeid',$entity);
if($records['usergroup'] > 0){
$level =$records['usergroup'];
$this->session->set_userdata('usergroup',$records['usergroup']);
// else
// $datasx = $this->session->set_userdata('level','ppda');
}





$entityname = $records['pdename'];
$adons  = date('d-m');

$level = "Procurement";

$titles = "Weekly  report on expiring IFBs of ".$entityname.$adons;
$body =  " ".html_entity_decode($table);
$permission = "view_bid_invitations";

$xcv = 0;


push_permission($titles,$body,$level,$permission,$records['pdeid']);

}
break;

default:
# code...
break;
#  exit();
}

}


    function notifyrop($bidinvitation)
    {

    $bidinvitation = $bidinvitation;

      #################################################

      # Get the passed details into the url data array if any
      $urldata = $this->uri->uri_to_assoc(2, array('m', 'p'));

      # Pick all assigned data
      $data = assign_to_data($urldata);

      $data = add_msg_if_any($this, $data);
      #print_r($data); exit();

      $data = handle_redirected_msgs($this, $data);

      $search_str = '';
      $level =$status = $this->uri->segment(3);
      $data['level'] = $level;


      $search_str = ' AND bidinvitations.id="'. $bidinvitation.'"';
      $records  = paginate_list($this, $data, 'bid_invitation_details', array('orderby'=>'bid_dateadded DESC', 'searchstring'=>'bidinvitations.isactive = "Y"  AND bidinvitations.id not in (SELECT bid_id FROM receipts INNER JOIN bidinvitations ON receipts.bid_id =  bidinvitations.id  INNER JOIN bestevaluatedbidder
      ON receipts.receiptid = bestevaluatedbidder.pid  WHERE receipts.beb="Y" ) '. $search_str),10);

       #bid invitation details
       $recorded_data = $records['page_list'][0];


       #procurement type::
       $procurementType = $recorded_data['procurement_type'];

       if(($procurementType == 'Non consultancy services') || ($procurementType == 'Consultancy Services'))
       {
         $procurementType = "Services";
       }
    #connect to ROP to fetch providers with that procurement method.
     $this->load->model('Remoteapi_m');
   $emaillist = $this->Remoteapi_m->emaillist_providers($procurementType);

  #  print_r($recorded_data);

    $str= '<table>'.
        '<tr> <th colspan="2"><h2> RE: BID INVITATION </h2> </th> </tr>'.
        '<tr> <th> PROCUREMENT AND DISPOSING ENTITY </th> <td>'.$recorded_data['pdename'].'<td> </tr>'.
        '<tr> <th> FINANCIAL YEAR </th> <td>'.  $recorded_data['financial_year'].'<td> </tr>'.
        '<tr> <th> PROCUREMENT REFERENCE NUMBER </th> <td>'.$recorded_data['procurement_ref_no'].'<td> </tr>'.
        '<tr> <th> SUBJECT OF PROCUREMENT </th> <td>'.$recorded_data['subject_of_procurement'].'<td> </tr>'.
        '<tr> <th> PROCUREMENT TYPE </th> <td>'.$recorded_data['procurement_type'].'<td> </tr>'.
        '<tr> <th> PROCUREMENT METHOD </th> <td>'.$recorded_data['procurement_method'].'<td> </tr>'.
        '<tr> <th> SOURCE OF FUNDING </th> <td>'.$recorded_data['funding_source'].'<td> </tr>'.
        '<tr> <th>BID SUBMISSION DEADLINE </th> <td>'.date('m -d,Y',strtotime($recorded_data['bid_submission_deadline'])).'<td> </tr>'.

       '</table>'.
      ' NOTE : <BR/>'.
      ' FOR MORE INFORMATION : ';

   $strbody = html_entity_decode($str);
  #  $this->load->library('email');
 echo "sending starts <br/> <br/>";
 echo "<ul>";
  while($row = mysqli_fetch_array($emaillist))
   {


     $this->email->from('noreply@tenderportal.ppda.go.ug', 'Tender Portal Notifications');
     $this->email->to(''.$row['email'].'');

  //   $this->email->cc('rmuyinda@newwavetech.co.ug');
     #$this->email->bcc('rmuyinda@newwavetech.co.ug');

     $this->email->subject('RE: BID INVITATION');
     $this->email->message(''.$strbody.'');

    $this->email->send();
    echo "<li>".$row['email']."</li>";

  }

  echo "</ul><br/><br/>Sending Finished";

       #fetch data about these guys

       ## fetch records ###
      # print_r($records['page_list'][0]);

    ##################################################


# end
}

function push_permission_ppda($title,$body,$level,$permission,$entity='')
{

$this->load->library('email');
/* SAVE NOTIFICATION*/
$title = mysql_real_escape_string($title);
$body = mysql_real_escape_string($body);
$level = mysql_real_escape_string($level);

$data = array('TITLE' => $title,'BODY'=>$body,'ISACTIVE'=>'Y','LEVEL'=>$level);

$query = $this->Query_reader->get_query_by_code('insert_notification', $data);

if($query){
$result = $this->db->query($query);
$insertid = $this->db->insert_id();

$pdeid =  $this->session->userdata('pdeid');


$recipients = $this->notification_access($permission,$pdeid);

$usergroup = $this->session->userdata('usergroup');
$receipients_str = '';
$receipients_str2 = '';

$data = array('searchstring' => ' groupaccess.groupid ="14" ');

$query = $this->Query_reader->get_query_by_code('notification_access', $data);

$result = $this->db->query($query)->result_array();

$emailarray = array();
if(!empty($result))
{
foreach($result as $row)
{
if(in_array($row['emailaddress'], $emailarray))
continue;

$receipients_str .= (!empty($receipients_str)? '|' : '') . $row['userid'];
$receipients_str2 .= (!empty($receipients_str2)? '|' : '') . $row['emailaddress'];

array_push($emailarray,$row['emailaddress']);
}

$receipients_str = '|' . $receipients_str . '|';
$receipients_str2 = '|' . $receipients_str2 . '|';




# print_r($receipients_str); exit()
}

$recipients =    $receipients_str."<><><>".$receipients_str2;


$ni_recepient = explode("<><><>",$recipients);
$r1 = $ni_recepient[0];
$r2 = $ni_recepient[1];
// print_r($r2);
// exit();
$recipients = rtrim($r1,'|');
$recipientsarray = explode("|", $recipients);
$emailarray = explode("|", $r2);
#print_r($emailarray);


for($x = 0; $x < count($recipientsarray); $x ++)
{
if(($recipientsarray[$x] == 0) || ($insertid == 0)) continue;

$datar = array('RECEPIENTID' => $recipientsarray[$x],'NOTIFICATIONID'=>$insertid,'ISACTIVE'=>'Y');
$query = $this->Query_reader->get_query_by_code('insert_notifications_recipients', $datar);
$result = $this->db->query($query);
# print_r($recipientsarray[$x]);

$emailaddr = $emailarray[$x];
if($emailaddr =='') continue;
#$emailadress = array('RECEPIENTID' => $recipientsarray[$x],'NOTIFICATIONID'=>$insertid,'ISACTIVE'=>'Y');




$this->email->from('noreply@tenderportal.ppda.go.ug', 'Tender Portal Notifications');
$this->email->to(''.$emailaddr.'');

//$this->email->cc('rmuyinda@newwavetech.co.ug');
#$this->email->bcc('rmuyinda@newwavetech.co.ug');

$this->email->subject(''.$title.'');
$this->email->message(''.$body.'');

$this->email->send();
}





}




}



}
