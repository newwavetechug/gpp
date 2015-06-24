<div class="widget">
    <div class="widget-title">
        <h4><i class="icon-reorder"></i>&nbsp;Manage addenda</h4>
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
					  '<th>Financial year</th>'.
					  '<th>Procurement Ref. No</th>'.
					  '<th class="hidden-480">Procurement subject</th>'.
					  '<th class="hidden-480">Addenda title</th>'.
					  '<th class="hidden-480">Author</th>'.
					  '<th class="hidden-480">Date added</th>'.
					  '<th></th>'.
					  '</tr>'.
					  '</thead>'.
					  '</tbody>';
				
				foreach($page_list as $row)
				{					
					$delete_str = '<a title="Delete addenda" href="javascript:void(0);" onclick="confirmDeleteEntity(\''.base_url().'bids/delete_addenda/b/'. encryptValue($row['bidid']) .'/i/'.encryptValue($row['addenda_id']).'\', \'Are you sure you want to delete this addenda?\nClick OK to confirm, \nCancel to cancel this operation and stay on this page.\')"><i class="fa fa-trash"></i></a>';
					
					$edit_str = '<a title="Edit addenda details" href="'. base_url() .'bids/load_ifb_addenda_form/i/'.encryptValue($row['addenda_id']).'/b/'. encryptValue($row['bidid']) .'"><i class="fa fa-edit"></i></a>';
					
					$addenda_url = (empty($row['fileurl'])? '<i>N/A</i>' : '<a target="_new" href="'. base_url() . 'uploads/documents/addenda/' . $row['fileurl'] .'">Download current file</a>');					
										
					
					print '<tr>'.
						  '<td>'. $delete_str .'&nbsp;&nbsp;'. $edit_str .'</td>'.
						  '<td>'. $row['financial_year'] .'</td>'.
						  '<td>'. $row['procurement_ref_no'] .'</td>'.
						  '<td>'. format_to_length($row['subject_of_procurement'], 50) .'</td>'.
						  '<td>'. format_to_length($row['title'], 50) .'</td>'.
						  '<td>'. $row['authorname'] .'</td>'.
						  '<td>'. custom_date_format('d M, Y',$row['dateadded']) .'</td>'.
						  '<td>'. $addenda_url .'</td>'.
						  '</tr>';
				}
				
				print '</tbody></table>';
				
				print '<div class="pagination pagination-mini pagination-centered">'.
						pagination($this->session->userdata('search_total_results'), $rows_per_page, $current_list_page, base_url().	
						"bids/manage_bid_invitations/p/%d")
					.'</div>';
		
			else:
        		print format_notice('WARNING: No addenda has been added for the selected IFB. Click <i><a title="view IFB document" href="'. base_url() .'bids/load_ifb_addenda_form/b/'. $b.'">here</a></i> to add an addendum');
        	endif; 
        ?>
    </div>
</div>