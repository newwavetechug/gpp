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
<div class="row-fluid">
    <div class="span12">
        <!-- BEGIN SAMPLE TABLE widget-->
        <div class="widget">
            <div class="widget-title">
                <h4>
                    <?php
                    //if person can add
                    if(check_user_access($this, 'create_procurement_plan'))
                    {
                        ?>
                        <a style="margin-left: 20px;" href="<?=base_url()?>procurement/procurement_plan_form"><i class="icon-plus"></i> New plan</a>
                    <?php
                    }

                    ?>

                </h4>
                    <span class="tools">
                    <a href="javascript:;" class="icon-chevron-down"></a>
                    <a href="javascript:;" class="icon-remove"></a>
                    </span>
            </div>
            <?php 
            $status = "";
            $status2 = "";
            
            if($this->session->userdata('isadmin') == 'N')
            {
              $status ='hidden'; 
            }

              if($this->session->userdata('isadmin') == 'Y')
            {
              $status2 ='hidden'; 
            }
            ?>
            <div class="widget-body">
                <?php
                    if(!empty($procurement['page_list'])): 
                
                        print '<table class="table table-striped table-hover">'.
                              '<thead>'.
                              '<tr>'.
                              '<th width="5%" class="'.$status2.'"></th>'.
                              '<th class="'.$status.'">Procurement and Disposal Entity</th>'.
                              '<th class="hidden-480">Financial year</th>'.
                             // '<th class="hidden-480">Title</th>'.
                              // '<th class="hidden-480">Summary plan</th>'.
                              '<th class="hidden-480">Entries</th>'.              
                              '<th>Author</th>'.
                              '<th>Date Added</th>'.
                              '</tr>'.
                              '</thead>'.
                              '</tbody>';
            
            $delete_rights = check_user_access($this, 'delete_procurement_plan');
            $edit_rights = check_user_access($this, 'edit_procurement_plan');
            $create_entry_rights = check_user_access($this, 'add_procurement_entry');
                        $delete_str = '';
            $edit_str = '';
            $create_entry_str = ''; 
            
                        foreach($procurement['page_list'] as $row)
                        { 
              if($delete_rights)        
                              $delete_str = '<a title="Delete plan" href="javascript:void(0);" onclick="confirmDeleteEntity(\''.base_url().'procurement/delete_plan/i/'.encryptValue($row['plan_id']).'\', \'Are you sure you want to delete this plan?\nClick OK to confirm, \nCancel to cancel this operation and stay on this page.\')"><i class="fa fa-trash"></i></a>';
                            
              if($edit_rights)  
                              $edit_str = '<a title="Edit plan details" href="'. base_url() .'procurement/procurement_plan_form/i/'.encryptValue($row['plan_id']).'"><i class="fa fa-edit"></i></a>';  
                
              if($create_entry_rights)
                $create_entry_str = '&nbsp;|&nbsp;'.
                    '<a href="'.base_url().'procurement/load_procurement_entry_form/v/'.encryptValue($row['plan_id']).'">'.
                                      'Create entry'. 
                                      '</a>';       
                            
                            $status_str = '';
                            $addenda_str = '[NONE]';
                            
                            print '<tr>'.
                                  '<td class="'.$status2.'">'. $delete_str .'&nbsp;&nbsp;'. $edit_str .'</td>'.
                                  '<td class="'.$status.'" >'. $row['pdename'] .'</td>'.
                                  '<td>'. format_to_length($row['financial_year'], 50) .'</td>'.
                                //  '<td>'. $row['Title'] .'</td>'.
                    //               '<td>'. (!empty($row['summarized_plan'])? '<a target="_new" href="'.
                    // base_url() . 'uploads/documents/summarizedplans/' . $row['summarized_plan'] . 
                    // '">Download plan</a>' : 'NONE ') .'</td>'.
                                  '<td>'.
                                    '<a href="'. base_url().'procurement/procurement_plan_entries/v/'.encryptValue($row['plan_id']). '">'.
                                      '<span class="badge badge-info">'.
                    $row['numOfEntries'].
                                        '</span>'.
                    '&nbsp;Entries'.
                                      '</a>'.
                                      $create_entry_str.
                  '</td>'.
                                  '<td>'. $row['firstname'].' ' . $row['lastname'] .'</td>'.
                                  '<td>'. custom_date_format('d M, Y',$row['dateadded']) .'</td>'.
                                  '</tr>';
                        }
                        
                        print '</tbody></table>';
                        
                        print '<div class="pagination pagination-mini pagination-centered">'.
                                pagination($this->session->userdata('search_total_results'), $procurement['rows_per_page'], $procurement['current_list_page'], base_url().  
                                "procurement/page/p/%d")
                            .'</div>';
                
                    else:
                        print format_notice('WARNING: No procurement plan has been created yet. '.
                                        'Click <a href="'.base_url(). 'procurement/procurement_plan_form">'.
                                         ' here</a> to create the first procurement plan');
                    endif;
                ?>
            </div>

        </div>
        <!-- END SAMPLE TABLE widget-->
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('[data-toggle="popover"]').popover({
            html: true,
            trigger: 'hover'
            });
    });
</script>