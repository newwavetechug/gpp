<div class="widget">
    <div class="widget-title">
        <h4><i class="icon-reorder"></i>&nbsp;Procurement plans</h4>
            <span class="tools">
                <a href="javascript:;" class="icon-chevron-down"></a>
                <a href="javascript:;" class="icon-remove"></a>
            </span>
    </div>
    <div class="widget-body" id="results">
    	<?php 
			if(!empty($page_list)): 
				
				print '<table class="table table-striped table-hover">'.
					  '<thead>'.
					  '<tr>'.
					  '<th width="5%"></th>'.
					  '<th>Procurement Ref. No</th>'.
					  '<th class="hidden-480">PDE</th>'.
					  '<th class="hidden-480">Procurement subject</th>'.
					  '<th class="hidden-480">Procurement type</th>'.
					  '<th class="hidden-480">Status</th>'.
					  '<th>Date Added</th>'.
					  '</tr>'.
					  '</thead>'.
					  '</tbody>';
				
				foreach($page_list as $row)
				{					
					$delete_str = '<a title="Delete procurement" href="javascript:void(0);" onclick="confirmDeleteEntity(\''.base_url().'bids/delete_bid_invitation/i/'.encryptValue($row['procurement_id']).'\', \'Are you sure you want to delete this bid invitation?\nClick OK to confirm, \nCancel to cancel this operation and stay on this page.\')"><i class="icon-trash"></i></a>';
					
					$edit_str = '<a title="Edit procurement details" href="'. base_url() .'bids/load_bid_invitation_form/i/'.encryptValue($row['procurement_id']).'"><i class="icon-edit"></i></a>';
										
					$status_str = '';
					
					
					if($row['bid_approved'] == 'Y' && get_date_diff(date('Y-m-d'), $row['bid_submission_deadline'], 'days')<0)
					{
						$status_str = 'Bid evaluation | <a title="Select BEB" href="'. base_url() .'bids/approve_bid_invitation/i/'.encryptValue($row['bid_invitation_id']).'">[Select BEB]</a>';
					}
					elseif($row['bid_approved'] == 'N')
					{
						$status_str = 'Pending Approval | <a title="Approve bid details" href="'. base_url() .'bids/approve_bid_invitation/i/'.encryptValue($row['bid_invitation_id']).'">[Approve invitation]</a>';
					}
					elseif($row['bid_approved'] == 'Y' && get_date_diff(date('Y-m-d'), $row['bid_submission_deadline'], 'days')>0)
					{
						$status_str = 'Bidding expires in '. get_date_diff(date('Y-m-d'), $row['bid_submission_deadline'], 'days') .' days | <a title="halt bidding" href="'. base_url() .'bids/approve_bid_invitation/i/'.encryptValue($row['bid_invitation_id']).'">[Halt bidding]</a>';
					}
					elseif($row['initiation_status'] == 'Y')
					{
						$status_str = 'Procurement initiated | <a title="Create IFB" href="'. base_url() .'bids/approve_bid_invitation/i/'.encryptValue($row['bid_invitation_id']).'">[Create IFB]</a>';
					}
					elseif($row['initiation_status'] == 'N')
					{
						$status_str = 'Pending initiation approval | <a title="Approve initiation" href="'. base_url() .'bids/approve_bid_invitation/i/'.encryptValue($row['bid_invitation_id']).'">[Approve initiation]</a>';
					}
					else
					{
						$status_str = 'Procurement not initiated | <a title="Initiate procurement" href="'. base_url() .'bids/approve_bid_invitation/i/'.encryptValue($row['bid_invitation_id']).'">[Initiate]</a>';
					}
					
					print '<tr>'.
						  '<td>'. $delete_str .'&nbsp;&nbsp;'. $edit_str .'</td>'.						  
						  '<td>'. $row['procurement_ref_no'] .'</td>'.
						  '<td>'. $row['pdename'] .'</td>'.
						  '<td>'. format_to_length($row['subject_of_procurement'], 80) .'</td>'.
						  '<td>'. $row['procurement_type']  .'</td>'.
						  '<td>'. $status_str. '</td>'.
						  '<td>'. custom_date_format('d M, Y', $row['date_procurement_added']) .'</td>'.
						  '</tr>';
				}
				
				
				print '</tbody></table>';
				
				print '<div class="pagination pagination-mini pagination-centered">'.
						pagination($this->session->userdata('search_total_results'), $rows_per_page, $current_list_page, base_url().	
						"user/dashboard/p/%d")
					.'</div>';
		
			else:
        		print format_notice('WARNING: No procurement entries have been added to the system');
        	endif; 
        ?>
    </div>
</div>