<div class="widget">
    <div class="widget-title">
        <h4><i class="icon-reorder"></i>&nbsp;Awarded Contracts</h4>
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
                      '<th width="50px"></th>'.
					  '<th>Date awarded</th>'.
					  '<th>Procurement Ref #</th>'.
                      '<th>Subject of procurement</th>'.  
					  '<th>Status</th>'.                    
					  '<th class="hidden-480">Date added</th>'.
                      '</tr>'.
                      '</thead>'.
                      '</tbody>';
                
                foreach($page_list as $row)
                {
                    //$delete_str = '<a title="Delete contract details" href="javascript:void(0);" onclick="confirmDeleteEntity(\''.base_url().'admin/delete_user/i/'.encryptValue($row['id']).'\', \'Are you sure you want to delete this contract?\nClick OK to confirm, \nCancel to cancel this operation and stay on this page.\')"><i class="icon-trash"></i></a>';
					
					//$edit_str = '<a title="Edit contract details" href="'. base_url() .'contracts/award_contract/i/'.encryptValue($row['id']).'"><i class="icon-edit"></i></a>';
					
					$status_str = '';
					
					if(!empty($row['actual_completion_date']) && str_replace('-', '', $row['actual_completion_date'])>0)
					{
						$status_str = '<span class="label label-success label-mini">Completed</span> &nbsp;<a title="Click to view contract completion details" href="'. base_url() .'contracts/contract_completion_form/c/'.encryptValue($row['id']).'/v/'. encryptValue('view') .'">View completion details</a>';
					}
					else
					{
						$status_str = '<span class="label label-warning label-mini">In progress</span> &nbsp;<a title="Click to enter contract completion details"" href="'. base_url() .'contracts/contract_completion_form/c/'.encryptValue($row['id']) .'">Complete contract</a>';
					}
                    
                    print '<tr>'.
                          '<td>&nbsp;</td>'. //$delete_str .'&nbsp;&nbsp;'. //$edit_str .'</td>'.
						  '<td>'. custom_date_format('d M, Y',$row['final_award_notice_date']) .'</td>'.
						  '<td>'. $row['procurement_ref_no'] .'</td>'.
                          '<td>'. $row['subject_of_procurement'] .'</td>'.
                          '<td>'. $status_str .'</td>'.
                          '<td>'. custom_date_format('d M, Y',$row['dateawarded']) .' by '. $row['authorname'] .'</td>'.
                          '</tr>';
                }
                
                print '</tbody></table>';
        
            else:
                print format_notice('WARNING: No contracts have been signed in the system');
            endif; 
        ?>
    </div>
</div>