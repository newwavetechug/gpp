<div class="widget">
    <div class="widget-title">
        <h4><i class="fa fa-reorder"></i>&nbsp;Contracts</h4>
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
                      '<th>Contract Title</th>'.                      
					  '<th class="hidden-480">Date added</th>'.
                      '</tr>'.
                      '</thead>'.
                      '</tbody>';
                
                foreach($page_list as $row)
                {				
					$edit_str = '<a title="Publish contract details" href="'. base_url() .'contracts/load_publish_form/i/'.encryptValue($row['id']).'"><i class="fa fa-edit"></i></a>';
                    
                    print '<tr>'.
                          '<td>'. $edit_str .'</td>'.
						  '<td>'. custom_date_format('d M, Y',$row['final_award_notice_date']) .'</td>'.
						  '<td>'. $row['procurement_ref_no'] .'</td>'.
                          '<td>'. $row['subject_of_procurement'] .'</td>'.
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