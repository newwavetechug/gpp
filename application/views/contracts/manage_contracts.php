<script type="text/javascript">
     $(document).on('click','.printer',function(){
 
 
    $(".table").printArea();
    
  })


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
                    $delete_str = '<a title="Delete contract details" href="javascript:void(0);" onclick="confirmDeleteEntity(\''.base_url().'contracts/delete_contract/i/'.encryptValue($row['id']).'\', \'Are you sure you want to delete this contract?\nClick OK to confirm, \nCancel to cancel this operation and stay on this page.\')"><i class="fa fa-trash"></i></a>';
          
          $edit_str = '<a title="Edit contract details" href="'. base_url() .'contracts/contract_award_form/i/'.encryptValue($row['id']).'"><i class="fa fa-edit"></i></a>';
          
          $status_str = '';
          $completion_str = '';
          
          if(!empty($row['actual_completion_date']) && str_replace('-', '', $row['actual_completion_date'])>0)
          {
            $status_str = '<span class="label label-success label-mini">Completed</span>';
            $completion_str = '<a title="Click to view contract completion details" href="'. base_url() .'contracts/contract_completion_form/c/'.encryptValue($row['id']).'/v/'. encryptValue('view') .'"><i class="fa fa-eye"></i></a>';
          }
          else
          {
            $status_str = '<span class="label label-warning label-mini">Awarded</span>';
            $completion_str = '<a title="Click to enter contract completion details"" href="'. base_url() .'contracts/contract_completion_form/c/'.encryptValue($row['id']) .'"><i class="fa fa-check"></i></a>';
          }
               
        $termintate_str = '<a href="#"><i class="fa fa-times-circle"></i></a>';     
          $more_actions = '<div class="btn-group" style="font-size:10px">
                                     <a href="#" class="btn btn-primary">more</a><a href="javascript:void(0);" data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="fa fa-caret-down"></span></a>
                                     <ul class="dropdown-menu">
                                         <li><a href="#"><i class="fa fa-times-circle"></i></a></li>
                                         <li class="divider"></li>
                                         <li>'. $completion_str .'</li>
                                     </ul>
                                  </div>';
          
                    print '<tr>'.
                          '<td>';
                          if($this->session->userdata('isadmin') == 'N')
                          print  $delete_str .'&nbsp;&nbsp;'. $edit_str .'&nbsp;&nbsp;'. $termintate_str .' &nbsp; &nbsp; '.$completion_str;
                        
                          print ' </td>'.
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
                print format_notice('WARNING: No contracts have been signed in the system');
            endif; 
        ?>
    </div>
</div>