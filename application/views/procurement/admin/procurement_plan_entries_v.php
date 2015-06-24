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
                    <h4><i class="icon-reorder"></i><!-- Total <span class="badge badge-info"><? #count($all_entries) ?></span>-->
                        <?php
                        //if person can add
                        if(check_user_access($this, 'add_procurement_entry'))
                        {
                            ?>
                            <a style="margin-left: 20px;" href="<?=base_url() . 'procurement/load_procurement_entry_form/v/'.$v?>" class="fa fa-plus">New entry</a>
                        <?php
                        }

                        ?>

                    </h4>
                        <span class="tools">


                        <a href="javascript:;" class="icon-chevron-down"></a>
                        <a href="javascript:;" class="icon-remove"></a>
                        </span>
                </div>
                <div class="widget-body" id="results">
                	<?php
                    	if(!empty($procurement_entries['page_list'])):

						print '<table class="table table-striped table-hover">'.
							  '<thead>'.
							  '<tr>'.
							  '<th width="5%"></th>'.
							  '<th class="hidden-480">Subject of procurement</th>'.
							  '<th class="hidden-480">Source of funding</th>'.
							  '<th class="hidden-480">Estimated amount</th>'.
                '<th class="hidden-480">QUANTITY</th>'.
							  '<th>Author</th>'.
							  '<th>Date Added</th>'.
							  '</tr>'.
							  '</thead>'.
							  '</tbody>';

						$delete_rights = check_user_access($this, 'delete_procurement_entry');
						$edit_rights = check_user_access($this, 'edit_procurement_entry');
                        $delete_str = '';
						$edit_str = '';

						foreach($procurement_entries['page_list'] as $row)
						{
							if($delete_rights)
								$delete_str = '<a title="Delete entry" href="javascript:void(0);" onclick="confirmDeleteEntity(\''.base_url().'procurement/delete_entry/i/'.encryptValue($row['entryid']).'\', \'Are you sure you want to delete this entry?\nClick OK to confirm, \nCancel to cancel this operation and stay on this page.\')"><i class="fa fa-trash"></i></a>';

							if($edit_rights)
								$edit_str = '<a title="Edit entry details" href="'. base_url() .'procurement/load_procurement_entry_form/i/'.encryptValue($row['entryid']).'"><i class="fa fa-edit"></i></a>';

							print '<tr>'.
								  '<td>'. $delete_str .'&nbsp;&nbsp;'. $edit_str .'</td>'.
								  '<td>'. format_to_length($row['subject_of_procurement'], 50) .'</td>'.
								  '<td>'. $row['funding_source'] .'</td>'.
								  '<td>'. (is_numeric($row['estimated_amount'])? number_format($row['estimated_amount'], 0, '.', ',') . ' ' . $row['currency_abbr'] : $row['estimated_amount']) .'</td>'.
                  '<td>'. (is_numeric($row['estimated_amount'])? number_format($row['quantity'], 0, '.', ',')  : $row['quantity']) .'</td>'.
								  '<td>'. (empty($row['authorname'])? 'N/A' : $row['authorname']).'</td>'.
								  '<td>'. custom_date_format('d M, Y',$row['dateadded']) .'</td>'.
								  '</tr>';
						}

						print '</tbody></table>';

						print '<div class="pagination pagination-mini pagination-centered">'.
								pagination($this->session->userdata('search_total_results'), $procurement_entries['rows_per_page'], $procurement_entries['current_list_page'], base_url().
								"procurement/procurement_plan_entries/v/".$v."/p/%d")
							.'</div>';

					else:
						print format_notice('WARNING: There are no procurement entries for the '. $plan_info['financial_year'] .'. <br />'.
										'Click <a href="'.base_url(). 'procurement/load_procurement_entry_form/v/'. encryptValue($plan_info['id']).'">'.
										 '<i>here</i></a> to create the first entry');
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
