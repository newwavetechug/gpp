<script type="text/javascript">
	 
	
	<?php 
	if(!empty($notifyrop))
	{
 	$bidinvitation = $notifyrop;
		#$bidinvitation = 99;
		?>

		
		var a = document.createElement('a');
		a.href='<?=base_url().'page/notifyrop/'.$bidinvitation; ?>';
		a.target = '_blank';
		document.body.appendChild(a);
		a.click();
		<?php
	}
	?>


$(document).ready(function() {
	$('.table').dataTable({
		 "paging":   false,
        "ordering": true,
        "info":     false });
	
	/*$('.table tbody').on('click', 'tr', function () {
		var name = $('td', this).eq(0).text();
		alert( 'You clicked on '+name+'\'s row' );
	} );  */
} );


</script>

<div class="widget ">
    <div class="widget-title">
        <!-- <h4><i class="icon-reorder"></i>&nbsp;Manage Bid Invitations</h4> -->
            <span class="tools">
              <!--   <a href="javascript:;" class="fa fa-down"></a>
                <a href="javascript:;" class="fa fa-remove"></a>   -->
            </span>
    </div>
    <?php //if(!empty($level) || ($level == 'active'))  {  echo "active"; }     ?>
			<div class="tabbable" style="padding-left:30px; " id="tabs-45158">
				<ul class="nav nav-tabs">
					<li class=" <?php if(!empty($level) && ($level == 'active'))  {  echo "active"; } ?> " onClick="javascript:location.href='<?=base_url().'bids/manage_bid_invitations/active/'; ?>'">
<?php
#print_r($activecount);
?>
						<a href="<?=base_url().'bids/manage_bid_invitations/active/'; ?>" data-toggle="tab"> <i class="fa fa-folder-open"> </i> ACTIVE <span class="badge badge-info"><?=$activecount[0]['numbids']; ?> </span></a>
					</li>
					<li onClick="javascript:location.href='<?=base_url().'bids/manage_bid_invitations/archive/'; ?>'"  class="<?php if(!empty($level) && ($level == 'archive'))  {  echo "active"; } ?>">
						<a href="<?=base_url().'bids/manage_bid_invitations/archive/'; ?>" data-toggle="tab"> <i class="fa fa-folder"> </i>  ARCHIVED  <span class="badge badge-info"><?=$archivecount[0]['numbids']; ?></span></a>
					
					</li>
				</ul>
			 
			</div>
    
   	

    <div class="widget-body tab-content " id="results">
    	<?php 
    	
			if(!empty($page_list['page_list'])): 
				
				print '<table class="table table-striped table-hover">'.
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

				
				#$xx = 0;
				foreach($page_list['page_list'] as $row)
				{	
					 


					$status_str = '';
					$addenda_str = '[NONE]';
					$delete_str ='';
					$edit_str  = '';
						
				    if(!empty($level) && ($level == 'active'))  {  	
					$delete_str = '<a title="Delete bid invitation" href="javascript:void(0);" onclick="confirmDeleteEntity(\''.base_url().'bids/delete_bid_invitation/i/'.encryptValue($row['bidinvitation_id']).'\', \'Are you sure you want to delete this bid invitation?\nClick OK to confirm, \nCancel to cancel this operation and stay on this page.\')"><i class="fa fa-trash"></i></a>';
					
					$edit_str = '<a title="Edit bid details" href="'. base_url() .'bids/load_bid_invitation_form/i/'.encryptValue($row['bidinvitation_id']).'"><i class="fa fa-edit"></i></a>';					
					}
				
					/*if($row['bid_approved'] == 'Y' && get_date_diff(date('Y-m-d'), $row['bid_submission_deadline'], 'days')<0)
					{
						$status_str = 'Bid evaluation | <a title="Select BEB" href="'. base_url() .'bids/approve_bid_invitation/i/'.encryptValue($row['bidinvitation_id']).'">[Select BEB]</a>';
					} */
					if($row['bid_approved'] == 'N')
					{
						$status_str = 'Not published | <a title="Publish IFB" href="'. base_url() .'bids/approve_bid_invitation/i/'.encryptValue($row['bidinvitation_id']).'">[Publish IFB]</a>';
					}

					#&& get_date_diff(date('Y-m-d'), $row['bid_submission_deadline'], 'days')>0
					elseif($row['bid_approved'] == 'Y' )
					{
						if(get_date_diff(date('Y-m-d'), $row['bid_submission_deadline'], 'days')>0)
						{
							$status_strs = 'Bidding closes in '. get_date_diff(date('Y-m-d'), $row['bid_submission_deadline'], 'days') .' days';
						}
						else
						{
							$status_strs = 'Bidding closed  '. get_date_diff( $row['bid_submission_deadline'], date('Y-m-d'),'days') .' days  ago';
						}
						$status_str =  $status_strs.'| <a title="view IFB document" href="'. base_url() .'bids/view_bid_invitation/i/'.encryptValue($row['bidinvitation_id']).'">[View IFB]</a>';
						
						$addenda_str =  '<a title="view addenda list" href="'. base_url() .'bids/view_addenda/b/'.encryptValue($row['bidinvitation_id']).'">[View Addenda]</a> | <a title="Add addenda" href="'. base_url() .'bids/load_ifb_addenda_form/b/'.encryptValue($row['bidinvitation_id']).'">[Add Addenda]</a>';
					}
					else
					{
											
					}
					
					print '<tr>'.
						  '<td>'. $delete_str .'&nbsp;&nbsp;'. $edit_str .'</td>'.
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
				
				print '</tbody></table>';
				  
				print '<div class="pagination pagination-mini pagination-centered">'.
						pagination($this->session->userdata('search_total_results'), $page_list['rows_per_page'], $page_list['current_list_page'], base_url().	
						"bids/manage_bid_invitations/".$level."/p/%d")
					.'</div>';
		
			else:
        		print format_notice('WARNING: No bid invitations have been added to the system');
        	endif; 
        ?>
    </div>

</div>