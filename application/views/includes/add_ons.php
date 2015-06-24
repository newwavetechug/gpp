<?php
$table_HTML = "";
														
#*********************************************************************************
# Displays forms used in AJAX when processing data on other forms without 
# reloading the whole form.
#*********************************************************************************


#===============================================================================================
# Display for simple message results
#===============================================================================================
if(!empty($area) && in_array($area, array('save_recover_settings_results', 'add_delivery_data')))
{
	$table_HTML .= format_notice($msg);	
}

#===============================================================================================
# Show search results in combo-box
#===============================================================================================
else if(!empty($area) && $area == 'combo_list')
{	
	if(!empty($page_list))
	{		
		if(empty($select_text))
		{
			$select_text = 'Select';
		}
		
		$table_HTML .= get_select_options($page_list, $value_field, $text_field, '', 'Y', $select_text);	
			
	} else {
		$table_HTML .= "<option value=''>No items to show!</option>";	
	}
}


#===============================================================================================
# Search users
#===============================================================================================
else if(!empty($area) && $area == 'users_list')
{
	if(!empty($page_list))
	{		
		$table_HTML .= '<table class="table table-striped table-hover">'.
					  '<thead>'.
					  '<tr>'.
					  '<th width="5%"></th>'.
					  '<th>Name</th>'.
					  '<th class="hidden-480">PDE</th>'.
					  '<th class="hidden-480">User Group</th>'.
					  '<th class="hidden-480">Email Address</th>'.
					  '<th class="hidden-480">Phone No.</th>'.
					  '<th>Date Added</th>'.
					  '</tr>'.
					  '</thead>'.
					  '</tbody>';
				
		  foreach($page_list as $row)
		  {
			  #user's role(s)
			  $user_roles_arr_text = get_user_roles_text($this, $row['userid'], $usergroups);
			  $user_roles_text = (!empty($user_roles_arr_text)? implode(', ', $user_roles_arr_text) :  '<i>NONE</i>');
			  
			  $delete_str = '<a title="Delete user details" href="javascript:void(0);" onclick="confirmDeleteEntity(\''.base_url().'admin/delete_user/i/'.encryptValue($row['userid']).'\', \'Are you sure you want to delete this user?\nClick OK to confirm, \nCancel to cancel this operation and stay on this page.\')"><i class="icon-trash"></i></a>';
			  $edit_str = '<a title="Edit user details" href="'. base_url() .'user/load_user_form/i/'.encryptValue($row['userid']).'"><i class="icon-edit"></i></a>';
			  
			  $table_HTML .= '<tr>'.
					'<td>'. $delete_str .'&nbsp;&nbsp;'. $edit_str .'</td>'.
					'<td>'. (!empty($row['prefix'])? $row['prefix'] . ' ' : '') . $row['firstname'] . ' ' . $row['lastname'] .'</td>'.
					'<td>'. $row['pdename'] .'</td>'.
					'<td>'. $user_roles_text .'</td>'.
					'<td>'. $row['emailaddress'] .'</td>'.
					'<td>'. $row['telephone'] .'</td>'.
					'<td>'. custom_date_format('d M, Y', $row['dateadded']) .'</td>'.
					'</tr>';
		  }
		  
		  $table_HTML .=  '</tbody></table>';	
			
	} else {
		$table_HTML .= format_notice("ERROR: Your search criteria did not match any data");	
	}
}


#===============================================================================================
# Search bid invitations
#===============================================================================================
else if(!empty($area) && $area == 'bid_invitations')
{
	if(!empty($page_list)): 
				
		$table_HTML .=  '<table class="table table-striped table-hover">'.
			  '<thead>'.
			  '<tr>'.
			  '<th width="5%"></th>'.
			  '<th>Procurement Ref. No</th>'.
			  '<th class="hidden-480">Procurement subject</th>'.
			  '<th class="hidden-480">Bid security</th>'.
			  '<th class="hidden-480">Bid invitation date</th>'.
			  '<th class="hidden-480">Addenda</th>'.					  
			  '<th>Status</th>'.
			  '<th>Published by</th>'.
			  '<th>Date Added</th>'.
			  '</tr>'.
			  '</thead>'.
			  '</tbody>';
		
		foreach($page_list as $row)
		{					
			$delete_str = '<a title="Delete bid invitation" href="javascript:void(0);" onclick="confirmDeleteEntity(\''.base_url().'bids/delete_bid_invitation/i/'.encryptValue($row['bidinvitation_id']).'\', \'Are you sure you want to delete this bid invitation?\nClick OK to confirm, \nCancel to cancel this operation and stay on this page.\')"><i class="icon-trash"></i></a>';
			
			$edit_str = '<a title="Edit bid details" href="'. base_url() .'bids/load_bid_invitation_form/i/'.encryptValue($row['bidinvitation_id']).'"><i class="icon-edit"></i></a>';					
			
			$status_str = '';
			
			$delete_str = '<a title="Delete bid invitation" href="javascript:void(0);" onclick="confirmDeleteEntity(\''.base_url().'bids/delete_bid_invitation/i/'.encryptValue($row['bidinvitation_id']).'\', \'Are you sure you want to delete this bid invitation?\nClick OK to confirm, \nCancel to cancel this operation and stay on this page.\')"><i class="icon-trash"></i></a>';
					
			$edit_str = '<a title="Edit bid details" href="'. base_url() .'bids/load_bid_invitation_form/i/'.encryptValue($row['bidinvitation_id']).'"><i class="icon-edit"></i></a>';					
			
			$status_str = '';
			$addenda_str = '[NONE]';
			
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
			
			$table_HTML .=  '<tr>'.
				  '<td>'. $delete_str .'&nbsp;&nbsp;'. $edit_str .'</td>'.
				  '<td>'. $row['procurement_ref_no'] .'</td>'.
				  '<td>'. format_to_length($row['subject_of_procurement'], 80) .'</td>'.
				  '<td>'. (is_numeric($row['bid_security_amount'])? number_format($row['bid_security_amount'], 0, '.', ',') . ' ' . $row['bid_security_currency_title']  : $row['bid_security_amount']) .'</td>'.
				  '<td>'. custom_date_format('d M, Y', $row['invitation_to_bid_date']) .'</td>'.
				  '<td>'. $addenda_str .'</td>'.
				  '<td>'. $status_str. '</td>'.
				  '<td>'. (empty($row['approver_fullname'])? 'N/A' : $row['approver_fullname']).'</td>'.
				  '<td>'. custom_date_format('d M, Y',$row['dateadded']) .'</td>'.
				  '</tr>';
		}
		
		$table_HTML .=  '</tbody></table>';
	
	else:
		$table_HTML .= format_notice('WARNING: No bid invitations have been added to the system');
	endif; 
}


#===============================================================================================
# Search signed contracts
#===============================================================================================
else if(!empty($area) && $area == 'signed_contracts')
{
	if(!empty($page_list)): 
                
		print '<table class="table table-striped table-hover">'.
			  '<thead>'.
			  '<tr>'.
			  '<th width="94px"></th>'.
			  '<th>Date signed</th>'.
			  '<th>Procurement Ref #</th>'.
			  '<th>Subject of procurement</th>'.  
			  '<th>Status</th>'.
			  '<th style="text-align:right">Contract amount (UGX)</th>'.                    
			  '<th class="hidden-480">Date added</th>'.
			  '</tr>'.
			  '</thead>'.
			  '</tbody>';
		
		foreach($page_list as $row)
		{
			$delete_str = '<a title="Delete contract details" href="javascript:void(0);" onclick="confirmDeleteEntity(\''.base_url().'contracts/delete_contract/i/'.encryptValue($row['id']).'\', \'Are you sure you want to delete this contract?\nClick OK to confirm, \nCancel to cancel this operation and stay on this page.\')"><i class="icon-trash"></i></a>';
			
			$edit_str = '<a title="Edit contract details" href="'. base_url() .'contracts/contract_award_form/i/'.encryptValue($row['id']).'"><i class="icon-edit"></i></a>';
			
			$status_str = '';
			$completion_str = '';
			
			if(!empty($row['actual_completion_date']) && str_replace('-', '', $row['actual_completion_date'])>0)
			{
				$status_str = '<span class="label label-success label-mini">Completed</span>';
				$completion_str = '<a title="Click to view contract completion details" href="'. base_url() .'contracts/contract_completion_form/c/'.encryptValue($row['id']).'/v/'. encryptValue('view') .'"><i class="icon-ok"></i> View completion details</a>';
			}
			else
			{
				$status_str = '<span class="label label-warning label-mini">In progress</span>';
				$completion_str = '<a title="Click to enter contract completion details"" href="'. base_url() .'contracts/contract_completion_form/c/'.encryptValue($row['id']) .'"><i class="icon-ok"></i> Mark as complete</a>';
			}
			
			$more_actions = '<div class="btn-group" style="font-size:10px">
							 <a href="#" class="btn btn-primary">more</a><a href="javascript:void(0);" data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="icon-caret-down"></span></a>
							 <ul class="dropdown-menu">
								 <li><a href="#"><i class="icon-ban-circle"></i> Terminate contract</a></li>
								 <li class="divider"></li>
								 <li>'. $completion_str .'</li>
							 </ul>
							</div>';
			
			print '<tr>'.
				  '<td>'. $delete_str .'&nbsp;&nbsp;'. $edit_str .'&nbsp;&nbsp;'. $more_actions .'</td>'.
				  '<td>'. custom_date_format('d M, Y',$row['date_signed']) .'</td>'.
				  '<td>'. format_to_length($row['procurement_ref_no'], 30) .'</td>'.
				  '<td>'. format_to_length($row['subject_of_procurement'], 30) .'</td>'.
				  '<td>'. $status_str .'</td>'.
				  '<td style="text-align:right; font-family:Georgia; font-size:14px">'. addCommas($row['total_price'], 0) .'</td>'.
				  '<td>'. custom_date_format('d M, Y', $row['dateadded']) .' by '. format_to_length($row['authorname'], 10) .'</td>'.
				  '</tr>';
		}
		
		print '</tbody></table>';
	
	else:
		print format_notice('WARNING: Your search criteria does not match any contracts');
	endif; 
}




#===============================================================================================
# Search procurement entries
#===============================================================================================
else if(!empty($area) && $area == 'procurement_entries')
{
	if(!empty($page_list)):				
		print '<table class="table table-striped table-hover">'.
			  '<thead>'.
			  '<tr>'.
			  '<th width="5%"></th>'.
			  '<th>Procurement Ref. No</th>'.
			  '<th class="hidden-480">Subject of procurement</th>'.
			  '<th class="hidden-480">Source of funding</th>'.
			  '<th class="hidden-480">Estimated amount</th>'.	
			  '<th>Author</th>'.
			  '<th>Date Added</th>'.
			  '</tr>'.
			  '</thead>'.
			  '</tbody>';
			  
		$delete_rights = check_user_access($this, 'delete_procurement_entry');
		$edit_rights = check_user_access($this, 'edit_procurement_entry');
		$delete_str = '';
		$edit_str = '';
		
		foreach($page_list as $row)
		{					
			if($delete_rights)				
				$delete_str = '<a title="Delete entry" href="javascript:void(0);" onclick="confirmDeleteEntity(\''.base_url().'procurement/delete_entry/i/'.encryptValue($row['entryid']).'\', \'Are you sure you want to delete this entry?\nClick OK to confirm, \nCancel to cancel this operation and stay on this page.\')"><i class="icon-trash"></i></a>';
			
			if($edit_rights)
				$edit_str = '<a title="Edit entry details" href="'. base_url() .'procurement/load_procurement_entry_form/i/'.encryptValue($row['entryid']).'"><i class="icon-edit"></i></a>';					
										
			print '<tr>'.
				  '<td>'. $delete_str .'&nbsp;&nbsp;'. $edit_str .'</td>'.
				  '<td>'. $row['procurement_ref_no'] .'</td>'.
				  '<td>'. format_to_length($row['subject_of_procurement'], 50) .'</td>'.
				  '<td>'. $row['funding_source'] .'</td>'.
				  '<td>'. (is_numeric($row['estimated_amount'])? number_format($row['estimated_amount'], 0, '.', ',') . ' ' . $row['currency_abbr'] : $row['estimated_amount']) .'</td>'.
				  '<td>'. (empty($row['authorname'])? 'N/A' : $row['authorname']).'</td>'.
				  '<td>'. custom_date_format('d M, Y',$row['dateadded']) .'</td>'.
				  '</tr>';
		}
		
		print '</tbody></table>';
		
		
		print '<div class="pagination pagination-mini pagination-centered">'.
				pagination($this->session->userdata('search_total_results'), $rows_per_page, $current_list_page, base_url().	
				"bids/manage_bid_invitations/p/%d")
			.'</div>';
		
	else:
		
		print format_notice('ERROR: Your search criteria does not match any records');
				
	endif;  
}



#===============================================================================================
# Search user groups
#===============================================================================================
else if(!empty($area) && $area == 'user_groups_list')
{
	if(!empty($page_list))
	{		
		$table_HTML .= '<table class="table table-striped table-hover">'.
					  '<thead>'.
					  '<tr>'.
					  '<th width="5%"></th>'.
					  '<th>User group</th>'.
					  '<th class="hidden-480">No. of Members</th>'.
					  '<th class="hidden-480">Author</th>'.
					  '<th class="hidden-480">Date added</th>'.
					  '</tr>'.
					  '</thead>'.
					  '</tbody>';
				
		foreach($page_list as $row)
		{
			$delete_str = '<a title="Delete user details" href="javascript:void(0);" onclick="confirmDeleteEntity(\''.base_url().'admin/delete_user/i/'.encryptValue($row['usergroupid']).'\', \'Are you sure you want to delete this user group?\nClick OK to confirm, \nCancel to cancel this operation and stay on this page.\')"><i class="icon-trash"></i></a>';
			$edit_str = '<a title="Edit user group details" href="'. base_url() .'admin/user_group_form/i/'.encryptValue($row['usergroupid']).'"><i class="icon-edit"></i></a>';
			
			$table_HTML .= '<tr>'.
				  '<td>'. $delete_str .'&nbsp;&nbsp;'. $edit_str .'</td>'.
				  '<td>'. $row['groupname'] .'</td>'.
				  '<td>'. $row['numOfUsers'] .'</td>'.
				  '<td>'. $row['authorname'] .'</td>'.
				  '<td>'. custom_date_format('d M, Y',$row['dateadded']) .'</td>'.
				  '</tr>';
		}
		
		$table_HTML .= '</tbody></table>';	
			
	} else {
		$table_HTML .= format_notice("ERROR: Your search criteria did not match any data");	
	}
}


#===============================================================================================
# Procurement plan report
#===============================================================================================
else if(!empty($area) && $area == 'procurement_plan_report')
{
	if(!empty($page_list)): 					
		$table_HTML .= '<table width="100%" border=0 cellpadding=5>
						  <tr>
							<td colspan="2" style="text-align: center; text-decoration: underline; font-size:14px;" nowrap>
								<strong>'. (!empty($report_heading)? $report_heading : '') .'</strong>
							</td>
						  </tr>'.
						  (!empty($sub_heading)? 						  
						  '<tr>'.
						  '<td colspan="2" style="text-align:center; font-size:12px;"><i>'. $sub_heading .'</i></div>'.
						  '</tr>'						  
						  : '' ).						
						  '<tr>'.
						  '<td style="text-align:right; font-weight:bold; width:130px">Financial year:</td>'.
						  '<td style="text-align:left">'. (!empty($financial_year)? $financial_year : '') .'</td>'.
						  '</tr>'.
						  (!empty($report_period)?
						  '<tr>'.
						  '<td style="text-align:right; font-weight:bold; width:130px">Reporting period:</td>'.
						  '<td style="text-align:left">'. (!empty($report_period)? $report_period : '') .'</td>'.
						  '</tr>' : '').						  
						'</table>';
	
		$table_HTML .= '<table style="margin-top:10px; border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="5">'.
			  '<thead>'.
			  '<tr>'.
			  '<th style="font-size: 12px; vertical-align:middle; text-align: left; border-bottom: 2px solid #000; padding-bottom:5px;font-family: Calibri, arial, sans-serif;">Date approved</th>'.
			  '<th style="font-size: 12px; vertical-align:middle; text-align: left; border-bottom: 2px solid #000; padding-bottom:5px;font-family: Calibri, arial, sans-serif;">PDE Name</th>'.
			  
			  ((!empty($formdata['aggregate_by']) && in_array($formdata['aggregate_by'], array('both', 'volume')))?
			  '<th style="font-size: 12px; vertical-align:middle; text-align: right; border-bottom: 2px solid #000; padding-bottom:5px;font-family: Calibri, arial, sans-serif;">Procurement entries</th>'
			  : '').
			  
			  ((!empty($formdata['aggregate_by']) && in_array($formdata['aggregate_by'], array('both', 'value')))?
			  '<th style="font-size: 12px; vertical-align:middle; text-align: right; border-bottom: 2px solid #000; padding-bottom:5px;font-family: Calibri, arial, sans-serif;">Estimated value</th>'
			  : '').
			  '</tr>'.
			  '</thead>'.
			  '</tbody>';
		
		$total_procurements_value = 0;
		$total_activities = 0;
		
		foreach($page_list as $row)
		{	  						
			$table_HTML .=  '<tr>'.
					'<td style="text-align: left; border-bottom: solid #000 1px; font-size:12px; font-family: Calibri, arial, sans-serif;">'. (is_numeric($row['plan_id'])? custom_date_format('d M, Y',$row['plan_dateadded']) : '<i>N/A</i>')  .'</td>'.
				  '<td style="text-align: left; border-bottom: solid #000 1px; font-size:12px; font-family: Calibri, arial, sans-serif;">'. $row['pdename'] .'</td>'.
				  				  
				  ((!empty($formdata['aggregate_by']) && in_array($formdata['aggregate_by'], array('both', 'volume')))?
			 '<td style="text-align: right; border-bottom: solid #000 1px; font-size:12px; font-family: Calibri, arial, sans-serif;">'. (is_numeric($row['numOfEntries'])? number_format($row['numOfEntries'], 0, '.', ',') : $row['numOfEntries']) .'</td>'
			  : '').
				  
				  ((!empty($formdata['aggregate_by']) && in_array($formdata['aggregate_by'], array('both', 'value')))?
			  '<td style="text-align: right; border-bottom: solid #000 1px; font-size:12px; font-family: Calibri, arial, sans-serif;">'. (is_numeric($row['estimatedValue'])? number_format($row['estimatedValue'], 0, '.', ',') : $row['estimatedValue']) .'</td>'
			  : '').
				  '</tr>';
				  
				  $total_procurements_value += (is_numeric($row['estimatedValue'])? $row['estimatedValue']  : 0);
				  $total_activities += (is_numeric($row['numOfEntries'])? $row['numOfEntries'] : 0);
		}
				
		$table_HTML .=  '<tr>'.
				  '<td>&nbsp;</td>'.
				  '<td">&nbsp;</td>'.				  				  
				  ((!empty($formdata['aggregate_by']) && in_array($formdata['aggregate_by'], array('both', 'volume')))?
			 		'<td style="text-align:right; font-weight:bold; font-size: 16px; font-family: Georgia">'. addCommas($total_activities, 0) .'</td>'
			  : '').				  
				  ((!empty($formdata['aggregate_by']) && in_array($formdata['aggregate_by'], array('both', 'value')))?
			  	'<td style="text-align:right; font-weight:bold; font-size: 16px; font-family: Georgia">'. addCommas($total_procurements_value, 0) .'</td>'
			  : '').
				  
				  '</tr>';
		
		$table_HTML .=  '</tbody></table>';
			
	elseif(!empty($formdata)):
		$table_HTML .= format_notice('Your search criteria does not match any results');
	endif; 

}


#===============================================================================================
# Late procurements report
#===============================================================================================
else if(!empty($area) && $area == 'late_procurements_report')
{
	if(!empty($page_list)): 					
		$table_HTML .= '<table width="100%" border=0 cellpadding=5>
						  <tr>
							<td colspan="2" style="text-align: center; text-decoration: underline; font-size:14px;" nowrap>
								<strong>REPORT ON LATE PROCUREMENTS</strong>
							</td>
						  </tr>'.
						  (!empty($sub_heading)? 						  
						  '<tr>'.
						  '<td colspan="2" style="text-align:center; font-size:12px;"><i>'. $sub_heading .'</i></div>'.
						  '</tr>'						  
						  : '' ).						
						  '<tr>'.
						  '<td style="text-align:right; font-weight:bold; width:130px">Financial year:</td>'.
						  '<td style="text-align:left">'. (!empty($financial_year)? $financial_year : '') .'</td>'.
						  '</tr>'.
						  (!empty($report_period)?
						  '<tr>'.
						  '<td style="text-align:right; font-weight:bold; width:130px">Reporting period:</td>'.
						  '<td style="text-align:left">'. (!empty($report_period)? $report_period : '') .'</td>'.
						  '</tr>' : '').						  
						'</table>';
	
		$table_HTML .= '<table style="margin-top:10px; border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="5">'.
			  '<thead>'.
			  '<tr>'.
			  '<th style="font-size: 12px; vertical-align:middle; text-align: left; border-bottom: 2px solid #000; padding-bottom:5px;font-family: Calibri, arial, sans-serif;">#</th>'.
			  '<th style="font-size: 12px; vertical-align:middle; text-align: left; border-bottom: 2px solid #000; padding-bottom:5px;font-family: Calibri, arial, sans-serif;">PDE Name</th>'.
			  '<th style="font-size: 12px; vertical-align:middle; text-align: left; border-bottom: 2px solid #000; padding-bottom:5px;font-family: Calibri, arial, sans-serif;">Procurement Ref. No</th>'.
			  '<th style="font-size: 12px; vertical-align:middle; text-align: left; border-bottom: 2px solid #000; padding-bottom:5px;font-family: Calibri, arial, sans-serif;">Planned IFB date</th>'.					  
			  '<th style="font-size: 12px; vertical-align:middle; text-align: left; border-bottom: 2px solid #000; padding-bottom:5px;font-family: Calibri, arial, sans-serif;">Actual IFB date</th>'.
			  '<th style="font-size: 12px; vertical-align:middle; text-align: left; border-bottom: 2px solid #000; padding-bottom:5px;font-family: Calibri, arial, sans-serif;">Days delayed</th>'.
			  '</tr>'.
			  '</thead>'.
			  '</tbody>';
			  
		$count = 0;
		
		foreach($page_list as $row)
		{	  
			$table_HTML .=  '<tr>'.
				  '<td style="text-align: left; border-bottom: solid #000 1px; font-size:12px; font-family: Calibri, arial, sans-serif;">'. (++$count) .'</td>'.
				  '<td style="text-align: left; border-bottom: solid #000 1px; font-size:12px; font-family: Calibri, arial, sans-serif;">'. $row['pdename'] .'</td>'.
				  '<td style="text-align: left; border-bottom: solid #000 1px; font-size:12px; font-family: Calibri, arial, sans-serif;">'. $row['procurement_ref_no'] .'</td>'.
				  '<td style="text-align: left; border-bottom: solid #000 1px; font-size:12px; font-family: Calibri, arial, sans-serif;">'. custom_date_format('d M, Y',$row['bid_issue_date']) .'</td>'.
				  '<td style="text-align: left; border-bottom: solid #000 1px; font-size:12px; font-family: Calibri, arial, sans-serif;">'.custom_date_format('d M, Y',$row['invitation_to_bid_date']) . '</td>'.
				  '<td style="text-align: left; border-bottom: solid #000 1px; font-size:12px; font-family: Calibri, arial, sans-serif;">'. $row['days_delayed'] .'</td>'.
				  '</tr>';
		}
		
		$table_HTML .=  '</tbody></table>';
			
	elseif(!empty($formdata)):
		$table_HTML .= format_notice('Your search criteria does not match any results');
	endif; 

}


#===============================================================================================
# Invitation for bids report
#===============================================================================================
else if(!empty($area) && $area == 'invitation_for_bids_reports')
{
	if(!empty($page_list)): 					
		$table_HTML .= '<table width="100%" border=0 cellpadding=5>
						  <tr>
							<td colspan="2" style="text-align: center; text-decoration: underline; font-size:14px;" nowrap>
								<strong>'. (!empty($report_heading)? $report_heading : '') .'</strong>
							</td>
						  </tr>'.
						  (!empty($sub_heading)? 						  
						  '<tr>'.
						  '<td colspan="2" style="text-align:center; font-size:12px;"><i>'. $sub_heading .'</i></div>'.
						  '</tr>'						  
						  : '' ).						
						  '<tr>'.
						  '<td style="text-align:right; font-weight:bold; width:130px">Financial year:</td>'.
						  '<td style="text-align:left">'. (!empty($financial_year)? $financial_year : '') .'</td>'.
						  '</tr>'.
						  (!empty($report_period)?
						  '<tr>'.
						  '<td style="text-align:right; font-weight:bold; width:130px">Reporting period:</td>'.
						  '<td style="text-align:left">'. (!empty($report_period)? $report_period : '') .'</td>'.
						  '</tr>' : '').						  
						'</table>';
	
		$table_HTML .= '<table style="margin-top:10px; border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="5">'.
			  '<thead>'.
			  '<tr>'.
			  '<th style="font-size: 12px; vertical-align:middle; text-align: left; border-bottom: 2px solid #000; padding-bottom:5px;font-family: Calibri, arial, sans-serif;">PDE Name</th>'.
			  '<th style="font-size: 12px; vertical-align:middle; text-align: left; border-bottom: 2px solid #000; padding-bottom:5px;font-family: Calibri, arial, sans-serif;">Procurement ref. no.</th>'.
			  '<th style="font-size: 12px; vertical-align:middle; text-align: left; border-bottom: 2px solid #000; padding-bottom:5px;font-family: Calibri, arial, sans-serif;">Subject of procurement</th>'.
			  ($formdata['ifb_report_type'] == 'BER'? '<th style="font-size: 12px; vertical-align:middle; text-align: left; border-bottom: 2px solid #000; padding-bottom:5px;font-family: Calibri, arial, sans-serif;">Procurement method <br />(Threshhold)</th>' : '').
			  ($formdata['ifb_report_type'] == 'PIFB'? '<th style="font-size: 12px; vertical-align:middle; text-align: right; border-bottom: 2px solid #000; padding-bottom:5px;font-family: Calibri, arial, sans-serif;">Estimated cost</th>' : '').		  
			  ($formdata['ifb_report_type'] == 'PIFB'? '<th style="font-size: 12px; vertical-align:middle; text-align: left; border-bottom: 2px solid #000; padding-bottom:5px;font-family: Calibri, arial, sans-serif;">IFB Date</th>' : '').
			  '<th style="font-size: 12px; vertical-align:middle; text-align: left; border-bottom: 2px solid #000; padding-bottom:5px;font-family: Calibri, arial, sans-serif;">Bid submission dead line</th>'.
			  ($formdata['ifb_report_type'] == 'BER'? '<th style="font-size: 12px; vertical-align:middle; text-align: left; border-bottom: 2px solid #000; padding-bottom:5px;font-family: Calibri, arial, sans-serif;">Bid submission duration</th>' : '').	
			  ($formdata['ifb_report_type'] == 'PIFB'? '<th style="font-size: 12px; vertical-align:middle; text-align: left; border-bottom: 2px solid #000; padding-bottom:5px;font-family: Calibri, arial, sans-serif;">No. of bids received</th>' : '').
			  '</tr>'.
			  '</thead>'.
			  '</tbody>';
		
		foreach($page_list as $row)
		{
			$table_HTML .= '<tr>'.
				  '<td style="text-align: left; border-bottom: solid #000 1px; font-size:12px; font-family: Calibri, arial, sans-serif;">'. $row['pdename'] .'</td>'.
				  '<td style="text-align: left; border-bottom: solid #000 1px; font-size:12px; font-family: Calibri, arial, sans-serif;">'. $row['procurement_ref_no'] .'</td>'.
				  '<td style="text-align: left; border-bottom: solid #000 1px; font-size:12px; font-family: Calibri, arial, sans-serif;">'. $row['subject_of_procurement'] .'</td>'.
				  ($formdata['ifb_report_type'] == 'BER'? '<td style="text-align: left; border-bottom: solid #000 1px; font-size:12px; font-family: Calibri, arial, sans-serif;">'. $row['procurement_method_title'] . ' (' . $row['biddingperiod'] .')</td>' : '').
				  ($formdata['ifb_report_type'] == 'PIFB'? '<td style="text-align: right; border-bottom: solid #000 1px; font-size:12px; font-family: Calibri, arial, sans-serif;">'. (is_numeric($row['estimated_amount'])? number_format(($row['estimated_amount'] * $row['exchange_rate']), 0, '.', ',') : $row['estimated_amount']) . '</td>' : '').
				  ($formdata['ifb_report_type'] == 'PIFB'? '<td style="text-align: left; white-space: nowrap; border-bottom: solid #000 1px; font-size:12px; font-family: Calibri, arial, sans-serif;">'. custom_date_format('d M, Y',$row['invitation_to_bid_date']) . '</td>' : '').
				  '<td style="text-align: left; border-bottom: solid #000 1px; font-size:12px; font-family: Calibri, arial, sans-serif;">'. custom_date_format('d M, Y',$row['bid_submission_deadline']) . ' at ' . custom_date_format('h:i A',$row['bid_submission_deadline']). '</td>'.
				  ($formdata['ifb_report_type'] == 'BER'? '<td style="text-align: left; border-bottom: solid #000 1px; font-size:12px; font-family: Calibri, arial, sans-serif;">'. $row['bid_submission_duration'] .'</td>' : '').	
				  ($formdata['ifb_report_type'] == 'PIFB'? '<td style="text-align: left; border-bottom: solid #000 1px; font-size:12px; font-family: Calibri, arial, sans-serif;">'. $row['numOfBids'] .'</td>' : '').
				  '</tr>';
		}
		
		$table_HTML .=  '</tbody></table>';
			
	elseif(!empty($formdata)):
		$table_HTML .= format_notice('Your search criteria does not match any results');
	endif; 

}


#===============================================================================================
# Best evaluated bidder reports
#===============================================================================================
else if(!empty($area) && $area == 'best_evaluated_bidder_reports')
{
	if(!empty($page_list)): 					
		$table_HTML .= '<table width="100%" border=0 cellpadding=5>
						  <tr>
							<td colspan="2" style="text-align: center; text-decoration: underline; font-size:14px;" nowrap>
								<strong>'. (!empty($report_heading)? $report_heading : '') .'</strong>
							</td>
						  </tr>'.
						  (!empty($sub_heading)? 						  
						  '<tr>'.
						  '<td colspan="2" style="text-align:center; font-size:12px;"><i>'. $sub_heading .'</i></div>'.
						  '</tr>'						  
						  : '' ).						
						  '<tr>'.
						  '<td style="text-align:right; font-weight:bold; width:130px">Financial year:</td>'.
						  '<td style="text-align:left">'. (!empty($financial_year)? $financial_year : '') .'</td>'.
						  '</tr>'.
						  '<tr>'.
						  '<td style="text-align:right; font-weight:bold; width:130px">Reporting period:</td>'.
						  '<td style="text-align:left">'. (!empty($report_period)? $report_period : '') .'</td>'.
						  '</tr>'.						  
						'</table>';
	
		$table_HTML .= '<table width="100%" cellspacing="0" cellpadding="5" style="margin-top:13px; border-collapse: collapse;">'.
					  '<thead>'.
					  '<tr>'.	
					  '<th style="font-size: 12px; vertical-align:middle; text-align: left; border-bottom: 2px solid #000; padding-bottom:5px;font-family: Calibri, arial, sans-serif;"">Date published</th>'.
					  ($formdata['beb_report_type'] == 'EBN'? '<th style="font-size: 12px; vertical-align:middle; text-align: left; border-bottom: 2px solid #000; padding-bottom:5px;font-family: Calibri, arial, sans-serif;"">BEB Expiry date</th>' : '').
					  '<th style="font-size: 12px; vertical-align:middle; text-align: left; border-bottom: 2px solid #000; padding-bottom:5px;font-family: Calibri, arial, sans-serif;">PDE name</th>'.
					  '<th style="font-size: 12px; vertical-align:middle; text-align: left; border-bottom: 2px solid #000; padding-bottom:5px;font-family: Calibri, arial, sans-serif;">Procurement ref. no.</th>'.
					  '<th style="font-size: 12px; vertical-align:middle; text-align: left; border-bottom: 2px solid #000; padding-bottom:5px;font-family: Calibri, arial, sans-serif;">Subject of procurement</th>'.					  
					  '<th style="font-size: 12px; vertical-align:middle; text-align: left; border-bottom: 2px solid #000; padding-bottom:5px;font-family: Calibri, arial, sans-serif;">Provider</th>'.
					  ($formdata['beb_report_type'] == 'PBEB'? '<th style="font-size: 12px; vertical-align:middle; text-align: right; border-bottom: 2px solid #000; padding-bottom:5px;font-family: Calibri, arial, sans-serif;">Estimated cost (UGX)</th>' : '').		  
					  '<th style="font-size: 12px; vertical-align:middle; text-align: right; border-bottom: 2px solid #000; padding-bottom:5px;font-family: Calibri, arial, sans-serif;">Proposed contract amount (UGX)</th>'.
					  '</tr>'.
					  '</thead>'.
					  '</tbody>';
					  
		$grand_estimated_cost = 0;
		$grand_contract_amount = 0;
		
		foreach($page_list as $row)
		{			
			#if multiple providers..
			$providername = $row['providernames'];
			if(!empty($row['joint_venture'])):
				$providername = '';
				$jv_info = $this->db->query('SELECT * FROM joint_venture WHERE jv = "'. $row['joint_venture'] .'"')->result_array();
				
				if(!empty($jv_info[0]['providers'])):
					$providers = $this->db->query('SELECT * FROM providers WHERE providerid IN ('. rtrim($jv_info[0]['providers'], ',') .')')->result_array();							
					foreach($providers as $provider):
						$providername .= (!empty($providername)? ', ' : ''). $provider['providernames'];
					endforeach;
										
				endif;
			
			endif;
			
			$grand_estimated_cost += (is_numeric($row['estimated_amount'])? $row['estimated_amount'] : 0);
			$grand_contract_amount += (is_numeric($row['contractprice'])? $row['contractprice'] : 0);
			  
			$table_HTML .= '<tr>'.
				  '<td style="text-align: left; border-bottom: solid #000 1px; font-size:12px; font-family: Calibri, arial, sans-serif; white-space:nowrap">'. custom_date_format('d M, Y', $row['beb_dateadded']) .'</td>'.
				  ($formdata['beb_report_type'] == 'EBN'? '<td style="text-align: left; border-bottom: solid #000 1px; font-size:12px; font-family: Calibri, arial, sans-serif; white-space:nowrap">'. custom_date_format('d M, Y', $row['beb_expiry_date']) .'</td>' : '').
				  '<td style="text-align: left; border-bottom: solid #000 1px; font-size:12px; font-family: Calibri, arial, sans-serif;">'. $row['pdename'] .'</td>'.
				  '<td style="text-align: left; border-bottom: solid #000 1px; font-size:12px; font-family: Calibri, arial, sans-serif;">'. $row['procurement_ref_no'] .'</td>'.
				  '<td style="text-align: left; border-bottom: solid #000 1px; font-size:12px; font-family: Calibri, arial, sans-serif;">'. $row['subject_of_procurement'] .'</td>'.
				  '<td style="text-align: left; border-bottom: solid #000 1px; font-size:12px; font-family: Calibri, arial, sans-serif;">'. ucwords(strtolower($providername)) .'</td>'.
				  ($formdata['beb_report_type'] == 'PBEB'? '<td style="text-align: right; border-bottom: solid #000 1px; font-size:12px; font-family: Calibri, arial, sans-serif;">'. (is_numeric($row['estimated_amount'])? number_format($row['estimated_amount'], 0, '.', ',') : '') .'</td>' : '').
				  '<td style="text-align: right; border-bottom: solid #000 1px; font-size:12px; font-family: Calibri, arial, sans-serif;">'. (is_numeric($row['contractprice'])? number_format($row['contractprice'], 0, '.', ',') : '')  . '</td>'.
				  '</tr>';
		}
		
		
		$table_HTML .= '<tr>'.
			  '<td>&nbsp;</td>'.
			  ($formdata['beb_report_type'] == 'EBN'? '<td>&nbsp;</td>' : '').
			  '<td>&nbsp;</td>'.
			  '<td>&nbsp;</td>'.
			  '<td>&nbsp;</td>'.
			  '<td>&nbsp;</td>'.
			  ($formdata['beb_report_type'] == 'PBEB'?
				'<td style="text-align:right; font-weight:bold; font-size: 16px; font-family: Georgia">'. addCommas($grand_estimated_cost, 0) .'</td>' : '') .
			  '<td style="text-align:right; font-weight:bold; font-size: 16px; font-family: Georgia">'. addCommas($grand_contract_amount, 0)  . '</td>'.
			  '</tr>';
		
		
		$table_HTML .= '</tbody></table>';
			
	elseif(!empty($formdata)):
		$table_HTML .= format_notice('Your search criteria does not match any results');
	endif; 

}


#===============================================================================================
# Contracts signed reports
#===============================================================================================
else if(!empty($area) && $area == 'signed_contracts_reports')
{
	if(!empty($page_list)): 					
		$table_HTML .= '<table width="100%" border=0 cellpadding=5>
						  <tr>
							<td colspan="2" style="text-align: center; text-decoration: underline; font-size:14px;" nowrap>
								<strong>'. $report_heading .'</strong>
							</td>
						  </tr>'.
						  (!empty($sub_heading)? 						  
						  '<tr>'.
						  '<td colspan="2" style="text-align:center; font-size:12px;"><i>'. $sub_heading .'</i></div>'.
						  '</tr>'						  
						  : '' ).						
						  '<tr>'.
						  '<td style="text-align:right; font-weight:bold; width:130px">Financial year:</td>'.
						  '<td style="text-align:left">'. $financial_year .'</td>'.
						  '</tr>'.
						  '<tr>'.
						  '<td style="text-align:right; font-weight:bold; width:130px">Reporting period:</td>'.
						  '<td style="text-align:left">'. $report_period .'</td>'.
						  '</tr>'.						  
						'</table>';
						
						
		$table_HTML .= '<table style="margin-top:10px; border-collapse: collapse;" cellpadding=5 cellspacing=0>'.
						  '<thead>'.
						  '<tr>'.
						  (($formdata['contracts_report_type'] == 'AC')? '<th style="font-size: 12px; vertical-align:middle; text-align: left; border-bottom: 2px solid #000; padding-bottom:5px;font-family: Calibri, arial, sans-serif;">Date signed</th>' : '').							  
						  (in_array($formdata['contracts_report_type'], array('CDC', 'LC'))? '<th style="font-size: 12px; vertical-align:middle; text-align: left; border-bottom: 2px solid #000; padding-bottom:5px;font-family: Calibri, arial, sans-serif;">Planned date of completion</th>' : '').
						  
						  '<th style="font-size: 12px; vertical-align:middle; text-align: left; border-bottom: 2px solid #000; padding-bottom:5px;font-family: Calibri, arial, sans-serif;">PDE name</th>'.
						  '<th style="font-size: 12px; vertical-align:middle; text-align: left; border-bottom: 2px solid #000; padding-bottom:5px;font-family: Calibri, arial, sans-serif;">Procurement ref. no.</th>'.
						  '<th style="font-size: 12px; vertical-align:middle; text-align: left; border-bottom: 2px solid #000; padding-bottom:5px;font-family: Calibri, arial, sans-serif;">Subject of procurement</th>'.	
						  #'<th class="hidden-480">Status</th>'.	
						  '<th style="font-size: 12px; vertical-align:middle; text-align: left; border-bottom: 2px solid #000; padding-bottom:5px;font-family: Calibri, arial, sans-serif;">Service provider</th>'.
						  (in_array($formdata['contracts_report_type'], array('LC'))? '<th style="font-size: 12px; vertical-align:middle; text-align: left; border-bottom: 2px solid #000; padding-bottom:5px;font-family: Calibri, arial, sans-serif;">Days delayed</th>' : '').
						  (in_array($formdata['contracts_report_type'], array('CC'))? '<th style="font-size: 12px; vertical-align:middle; text-align: left; border-bottom: 2px solid #000; padding-bottom:5px;font-family: Calibri, arial, sans-serif;">Date of completion</th>' : '').
						  (in_array($formdata['contracts_report_type'], array('CC'))? '<th style="font-size: 12px; vertical-align:middle; text-align: right; border-bottom: 2px solid #000; padding-bottom:5px;font-family: Calibri, arial, sans-serif;">Total amount paid (UGX)</th>' : '').
						  '<th style="font-size: 12px; vertical-align:middle; text-align: right; border-bottom: 2px solid #000; padding-bottom:5px;font-family: Calibri, arial, sans-serif;">Contract value (UGX)</th>'.
						  '</tr>'.
						  '</thead>'.
						  '</tbody>';
		
		$grand_contracts_value = 0;
		$grand_total_amount_paid = 0;
		
		foreach($page_list as $row)
		{
			if(!empty($row['actual_completion_date']) && str_replace('-', '', $row['actual_completion_date'])>0)
			{
				$status_str = 'COMPLETE';
			}
			else
			{
				$status_str = 'IN PROGRESS';
			}
			
			#if multiple providers..
			$providername = $row['providernames'];
			if(!empty($row['joint_venture'])):
				$providername = '';
				$jv_info = $this->db->query('SELECT * FROM joint_venture WHERE jv = "'. $row['joint_venture'] .'"')->result_array();
				
				if(!empty($jv_info[0]['providers'])):
					$providers = $this->db->query('SELECT * FROM providers WHERE providerid IN ('. rtrim($jv_info[0]['providers'], ',') .')')->result_array();							
					foreach($providers as $provider):
						$providername .= (!empty($providername)? ', ' : ''). $provider['providernames'];
					endforeach;
										
				endif;
			
			endif;
		
			$table_HTML .= '<tr>'.
				  
				  (($formdata['contracts_report_type'] == 'AC')? '<td style="text-align: left; border-bottom: solid #000 1px; font-size:12px; font-family: Calibri, arial, sans-serif;">'. custom_date_format('d M, Y', $row['date_signed']) .'</td>' : '').							  
				  (in_array($formdata['contracts_report_type'], array('CDC', 'LC'))? '<td style="text-align: left; border-bottom: solid #000 1px; font-size:12px; font-family: Calibri, arial, sans-serif;">'. custom_date_format('d M, Y', $row['completion_date']) .'</td>' : '').
													
				  '<td style="text-align: left; border-bottom: solid #000 1px; font-size:12px; font-family: Calibri, arial, sans-serif;">'. format_to_length($row['pdename'], 30) .'</td>'.
				  '<td style="text-align: left; border-bottom: solid #000 1px; font-size:12px; font-family: Calibri, arial, sans-serif;">'. $row['procurement_ref_no'] .'</td>'.
				  '<td style="text-align: left; border-bottom: solid #000 1px; font-size:12px; font-family: Calibri, arial, sans-serif;">'. $row['subject_of_procurement'] .'</td>'.
				  #'<td>'. $status_str .'</td>'.
				  '<td style="text-align: left; border-bottom: solid #000 1px; font-size:12px; font-family: Calibri, arial, sans-serif;">'. $providername .'</td>'.
				  (in_array($formdata['contracts_report_type'], array('LC'))? '<td style="text-align: left; border-bottom: solid #000 1px; font-size:12px; font-family: Calibri, arial, sans-serif;">'. get_date_diff((empty($row['actual_completion_date'])? date('Y-m-d') : $row['actual_completion_date']), $row['completion_date'], 'days') .'</td>' : '').
				  
				  (in_array($formdata['contracts_report_type'], array('CC'))? '<td style="text-align: left; border-bottom: solid #000 1px; font-size:12px; font-family: Calibri, arial, sans-serif;">'. custom_date_format('d M, Y', $row['actual_completion_date']) .'</td>' : '').
				  (in_array($formdata['contracts_report_type'], array('CC'))? '<td style="text-align: right; border-bottom: solid #000 1px; font-size:12px; font-family: Calibri, arial, sans-serif;">'. addCommas($row['total_amount_paid'], 0) .'</td>' : '').
				  
				  '<td style="text-align: right; border-bottom: solid #000 1px; font-size:12px; font-family: Calibri, arial, sans-serif;">'. addCommas($row['total_price'], 0) .'</td>'.
				  '</tr>';
			
			$grand_contracts_value += $row['total_price'];
			$grand_total_amount_paid += $row['total_amount_paid'];
		}
		
		$table_HTML .= '<tr>'.							  
			  (($formdata['contracts_report_type'] == 'AC')? '<td>&nbsp;</td>' : '').							  
			  (in_array($formdata['contracts_report_type'], array('CDC', 'LC'))? '<td>&nbsp;</td>' : '').
												
			  '<td>&nbsp;</td>'.
			  '<td>&nbsp;</td>'.
			  '<td>&nbsp;</td>'.
			  #'<td>'. $status_str .'</td>'.
			  '<td>&nbsp;</td>'.
			  (in_array($formdata['contracts_report_type'], array('LC'))? '<td>&nbsp;</td>' : '').
			  (in_array($formdata['contracts_report_type'], array('CC'))? '<td>&nbsp;</td>' : '').
			  (in_array($formdata['contracts_report_type'], array('CC'))? '<td style="text-align:right; font-weight:bold; font-size: 14px; font-family: Georgia">'. addCommas($grand_total_amount_paid, 0) .'</td>' : '').
			  '<td style="text-align:right; font-weight:bold; font-size: 16px; font-family: Georgia">'. addCommas($grand_contracts_value, 0) .'</td>'.
			  '</tr>';
		
		$table_HTML .=  '</tbody></table>';
			
	elseif(!empty($formdata)):
		$table_HTML .= format_notice('Your search criteria does not match any results');
	endif; 

}



#===============================================================================================
# Procurement record details
#===============================================================================================
else if(!empty($area) && $area == 'procurement_record_details')
{
	if(!empty($procurement_details))
	{		
		$table_HTML .= '<div class="control-group subject_of_procurement">'.
                       '<label class="control-label">Subject of procurement:</label>'.
                       '<div class="controls">'.
					   (!empty($procurement_details['subject_of_procurement'])? $procurement_details['subject_of_procurement'] : '<i>undefined</i>').
					   '<input type="hidden" name="procurement_details[subject_of_procurement]" value="'.$procurement_details['subject_of_procurement'] .'" />'.
					   '</div>'.
                       '</div>'.
					   
					   '<div class="control-group">'.
                       '<label class="control-label">Financial year:</label>'.
                       '<div class="controls">'.
					   (!empty($procurement_details['financial_year'])? $procurement_details['financial_year'] : '<i>undefined</i>').
                       '<input type="hidden" name="procurement_details[financial_year]" value="'.$procurement_details['financial_year'] .'" />'.
                       '</div>'.
                       '</div>'.
					   
					   '<div class="control-group">'.
                       '<label class="control-label">Source of funding:</label>'.
                       '<div class="controls">'.
                       (!empty($procurement_details['funding_source'])? $procurement_details['funding_source'] : '<i>undefined</i>').
                       '<input type="hidden" name="procurement_details[funding_source]" value="'.$procurement_details['funding_source'].'"/>'.
					   '</div>'.
                       '</div>';

					if(!empty($procurement_details['quantity'])){
						$total_ifb_q = $procurement_details['quantity'] - $procurement_details['total_ifb_quantity'];
		   $table_HTML .= '<div class="control-group">'.
                       '<label class="control-label">Quantity:</label>'.
                       '<div class="controls">'.
                       (!empty($total_ifb_q)? $total_ifb_q : '<i>undefined</i>').
                       '<input type="hidden" id="procurement_details_quantity" name="procurement_details_quantity" value="'.$total_ifb_q.'"/>'.
					   '</div>'.
                       '</div>';
                     }
                  
						
		   $table_HTML .='<div class="control-group">'.
                       '<label class="control-label">Method of procurement:</label>'.
                       '<div class="controls">'.
                       (!empty($procurement_details['procurement_method'])? $procurement_details['procurement_method'] : '<i>undefined</i>').
                       '<input type="hidden" name="procurement_details[procurement_method]" value="'. $procurement_details['procurement_method'].'" />'.
					   '</div>'.
                       '</div>';
				
					   if(!empty($procurement_details['providers'])):
					   #$st = 'SELECT * FROM providers WHERE providerid in('.$procurement_details['providers'].')';
					   # print_r($st);
 
					  $procurementdetails = $this->db->query('SELECT * FROM providers WHERE providerid IN ('.$procurement_details['providers'].') ' ) -> result_array();
					  #print_r($procurementdetails);	
					  $providers = '<ul>';
					  $xc = '';
					 # $suspended = '';
					  $status = 0;
					  foreach ($procurementdetails as $key => $value) {
					 	# code...
					 	//check provider 
					 	 $xc = searchprovidervalidity($value['providernames']);
					 	 

							if(!empty($xc))
							{
								$status =1;
								 $providers .= "<li><div class='label label-warning' title='Suspended Provider' >".$value['providernames']."</div>".'&nbsp; &nbsp; <div class="alert alert-important " style="width:150px; margin-left:5px;">   <button data-dismiss="alert" class="close">×</button> This is a suspended provider    </div> </li>';
								# $suspended .= $value['providernames'].',';
							}
							else
							{
							 $providers .= "<li>".$value['providernames']."</li>";
							}

					 }

					  $providers .= '<ul>';
					 # print_r($procurement_details);
					  $str = '';
					if($procurement_details['bidvalidity'] == 'y')
					{
					 	$enddatebidvalidity =  strtotime($procurement_details['bidvalidityperiod']);
					 	#echo "<BR/>:::::::<BR/>";
					 	#print_r($enddatebidvalidity);
					 	if(strtotime($enddatebidvalidity) < strtotime(date('Y-m-d')))
					 	{
					 			 		$str ='<div class="alert alert-info " style="width:250px; margin-left:5px;">   <button data-dismiss="alert" class="close">×</button> Validity Period Expired  on '.date('d M, Y',strtotime($procurement_details['bidvalidityperiod'])).'  </div>' ;
					 	}
					 #	echo "<BR/>:::::::<BR/>";
					 }


					#notify in case of suspended provider
					   $table_HTML .= '<input type="hidden" value="'.$status.'" id="providerstatus" >';
		
					   $table_HTML .= '<div class="control-group">'.
                       		'<label class="control-label">Selected provider:</label>'.
                       		'<div class="controls">'.
                       		 rtrim($providers,',').
                       		'<input type="hidden" name="provider" value="'.$procurement_details['providers'].'"/>'.
							'<input type="hidden" name="provider_info" value="'.(empty($procurement_details['id'])? 0 :$procurement_details['id']).'"/>'.
					   		'</div>'.
                       		'</div>';                         		
                       $table_HTML .= $str;
					   endif;
			
	} else {
		$table_HTML .= format_notice("ERROR: Could not find the procurement record details.");	
	}
}







#===============================================================================================
# Manage PDEs record details
#===============================================================================================
else if(!empty($area) && $area == 'pde_list')
{
#	print_r($page_list);
	if(!empty($page_list))
	{		

?>
<table class="table  table-striped">
				<thead>
					<tr>
						<th>
							#
						</th>
						<th>
							 <em class="glyphicon glyphicon-user"></em>
						</th>
						<th>
							PDE Name
						</th>
						<th>
						Abbreviation
						</th>
						<th>
							Category
						</th>

						<th>
							Code
						</th>
						
						 
					</tr>
				</thead>
				<tbody>
				<?php
				$xx = 0;
				//print_r($active['page_list']); exit();
foreach($page_list as $row)
{
	$xx ++;
	?>
	<tr  id="active_<?=$row['pdeid']; ?>">

		<td>
           <a href="<?=base_url().'pdes/load_edit_pde_form/'.base64_encode($row['pdeid']); ?>"> <i class="icon-edit"></i></a>
           <a href="#" id="savedelpde_<?=$row['pdeid'];?>" class="savedelpde"> <i class="icon-trash"></i></a>
		</td>

						<td  class="actived">
							<?=$xx; ?>
						</td>
						<td  class="actived">
							<?=$row['pdename']; ?>
						</td>
						<td  class="actived">
							<?=$row['abbreviation']; ?>
						</td>
						<td  class="actived">
							<?=$row['category']; ?>
						</td>
						<td  class="actived">
							<?=$row['code']; ?>
						</td>
						
					</tr>
				 
	<?php
}
				?>
					 
					 
				</tbody>
			</table>
 
<?php
					 
	} else {
		$table_HTML .= format_notice("ERROR: Could not find the PDE record details.");	
	}
}






#===============================================================================================
# Manage Pdetypes record details
#===============================================================================================
else if(!empty($area) && $area == 'pdetype_list')
{
#	print_r($page_list);
	if(!empty($page_list))
	{		

?><table class="table  table-striped">
				<thead>
					<tr>
						<th>
							#
						</th>
						<th>
							 <em class="glyphicon glyphicon-user"></em>
						</th>
						<th>
							PDE Type
						</th>
						<th>
						Date Created
						</th>
						<th>Author </th>
						 
						
						 
					</tr>
				</thead>
				<tbody>
				<?php
				$xx = 0;
foreach($page_list as $row)
{
	$xx ++;
	?>
	<tr  id="active_<?=$row['pdetypeid']; ?>">

		<td>
						 <a href="<?=base_url().'pdetypes/load_edit_pde_form/'.base64_encode($row['pdetypeid']); ?>"> <i class="icon-edit"></i></a>
						 <a href="#" id="savedelpdetype_<?=$row['pdetypeid'];?>" class="savedelpdetype"> <i class="icon-trash"></i></a>

		</td>

						<td  class="actived">
							<?=$xx; ?>
						</td>
						<td  class="actived">
							<?=$row['pdetype']; ?>
						</td>
						 
						<td  class="actived">
							<?=$row['datecreated']; ?>
						</td>
						<td></td>
						 
						
					</tr>
				 
	<?php
}
				?>
					 
					 
				</tbody>
			</table>
 
<?php
					 
	} else {
		$table_HTML .= format_notice("ERROR: Could not find the PDE Type record details.");	
	}
}






#===============================================================================================
# Manage Receipts record details
#===============================================================================================
else if(!empty($area) && $area == 'receipts_list')
{
#	print_r($page_list);
	if(!empty($page_list))
	{		

?>
<table class="table  table-striped">
				<thead>
					<tr>
						<th>
							#
						</th>
						<th>
							 <em class="glyphicon glyphicon-user"></em>
						</th>
						<th>
							Procurement Ref No
						</th>
						<th>
						Service Provider
						</th>
						<th>
							Date Submitted
						</th>

						<th>
							Received By
						</th>
						<th>
							Nationality
						</th>

						<th>
							Date Added
						</th>
						<th>
							Evaluated
						</th>
						
						 
					</tr>
				</thead>
				<tbody>
					<?php
					$numcount = 0;

					#print_r($receiptinfo); exit();
foreach ($page_list as $key => $value) {
	# code...
	$numcount  ++;
	?>
	 <tr>
						<td>
							<?=$numcount; ?>

						</td>
						<td width="10">
							 <?php
							  
							 
							  switch ($value['beb']) {
							  	case 'p':
							  		# code...
							  	?>
							  		<a href="<?=base_url().'receipts/load_edit_receipt_form/'.encryptValue($value['receiptid']); ?>"> <i class="icon-edit"></i></a>
					
							  	<?php
							   
							  		break;
							  		case 'Y':
							  		# code...
							  		?>
							  			<a href="<?=base_url().'receipts/load_edit_receipt_form/'.encryptValue($value['receiptid']); ?>"> <i class="icon-edit"></i></a>
					
							  		<?php
							  		 
							  		break;
							  			case 'N':
							  			 ?>
							  			 	<a href="<?=base_url().'receipts/load_edit_receipt_form/'.encryptValue($value['receiptid']); ?>"> <i class="icon-edit"></i></a>
					
							  			 <?php
							  		# code...
							  		break;
							  	default:
							  	?>
							 	<a href="<?=base_url().'receipts/load_edit_receipt_form/'.encryptValue($value['receiptid']); ?>"> <i class="icon-edit"></i></a>
						  <a href="#" id="savedelreceipt_<?=$value['receiptid'];?>" class="savedelreceipt"> <i class="icon-trash"></i></a>

							  	<?php
							  		# code...
							  		break;
							  }
 
							  ?>
						  
						</td>
						<td>
							 <?=$value['procurement_ref_no']; ?>
						</td>
						<td>
							 <?=$value['providernames']; ?>						 
						</td>
						<td>
							 <?=$value['datereceived']; ?>								 
						</td>  							
						<td>
							 <?=$value['received_by']; ?>	 
						</td>
						<td>
							   <?=$value['nationality']; ?>
						</td>
						<td>
							  <?=$value['dateadded']; ?>
							 
						</td>

						<td>
							  
							  <?php
							  
							 
							  switch ($value['beb']) {
							  	case 'p':
							  		# code...
							  	?>
							  	<span class="label label-info">Pending</span>
							  	<?php
							  		break;
							  		case 'Y':
							  		# code...
							  		?>
							  		<span class="label label-success">Approved</span>
							  		<?php
							  		break;
							  			case 'N':
							  			?>
							  			<span class="label label-warning">Unsuccessful </span>
							  			<?php
							  		# code...
							  		break;
							  	default:
							  		# code...

							  	?>
							  			<span class="label label-info">Pending </span>
							  			<?php
							  		break;
							  }
 
							  ?>
							 
						</td>

						
						 
					</tr>
					 

	<?php
}


					?>
				
				 
					 
					 
				</tbody>
			</table>
 
<?php
					 
	} else {
		$table_HTML .= format_notice("ERROR: Could not find the Receipts record details.");	
	}
}




if(!empty($table_HTML))
{	
	#echo htmlentities($table_HTML);
	echo $table_HTML;
}
?>



<script>
 
	 // MANAGE DELETE RESORE AND UPDATE FUC
$('.savedelpde').on('click', function(){
 
 
    var decider = this.id;
    var idq =  decider.split('_');
      
     switch(idq[0])
     {
        case 'savedelpde':
        url = baseurl()+'pdes/delpdes_ajax/archive/'+idq[1];
        var b = confirm('You Are About to Delete a Record')
        if(b == true){
         var rslt = ajx_delete(url,decider);
        }
        break;
        case 'restore':
        url = baseurl()+'pdes/delpdes_ajax/restore/'+idq[1];
        var b = confirm('You Are About to Restore a Record')
        if(b == true){           
         var rslt = ajx_delete(url,decider);
        }
        break;
        case 'del':
        url = baseurl()+'pdes/delpdes_ajax/delete/'+idq[1];
        var b = confirm('You Are About to Paramanently Delete a Record')
        if(b == true){           
         var rslt = ajx_delete(url,decider);
        }
        break;
        default:
         
        break;
     }
     
});


// MANAGE DELETE RESORE AND UPDATE FUC
$('.savedelpdetype').on('click', function(){


    var decider = this.id;
    var idq =  decider.split('_');

     switch(idq[0])
     {
        case 'savedelpdetype':
        url = baseurl()+'pdetypes/delpdetype_ajax/archive/'+idq[1];
        console.log(url);

        var b = confirm('You Are About to Delete a Record')
        if(b == true){
         var rslt = ajx_delete(url,decider);
        }
        break;
        case 'restore':
        url = baseurl()+'pdetypes/delpdetype_ajax/restore/'+idq[1];
        console.log(url);
        var b = confirm('You Are About to Restore a Record')
        if(b == true){           
         var rslt = ajx_delete(url,decider);
        }
        break;
        case 'del':
        url = baseurl()+'pdetypes/delpdetype_ajax/delete/'+idq[1];
        console.log(url);
        var b = confirm('You Are About to Paramanently Delete a Record')
        if(b == true){           
         var rslt = ajx_delete(url,decider);
        }
        break;
        default:
         
        break;
     }
     
});


 
</script>