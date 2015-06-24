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
          <h4><i class="fa fa-reorder"></i>&nbsp;<?=$page_title; ?> </h4>
              <span class="tools">
                  <a href="javascript:;" class="fa fa-chevron-down"></a>
                  <a href="javascript:;" class="fa fa-remove"></a>
              </span>
      </div>
      <div class="widget-body">


      <!-- start -->

  <div class="row-fluid">
  <?php
  #print_r($disposal_bid_invitaion);
  #exit();

  ?>
  <div id="results">
   	<table class="table  table-striped">
				<thead>
					<tr>
						<th>

						</th>
						<th>
							 <em class=" "></em>
						</th>
						<th>
						Date of Approval of Form 28
						</th>
						<th>
						 Disposal Serial Number
						</th>
						<th>
						 Disposal Reference Number
						</th>
                        <th>
							Subject of Disposal
						</th>
						<th>
						  Bid Document Issue Date
						</th>
						<th>
						Deadline of Submission
						</th>


						<th>
						 Remaining Days
						</th>

                         <th>
                         Date Added
                          </th>
                            <th> </th>
					</tr>
				</thead>
				<tbody>

  				<?php


					 #print_r($disposal_bid_invitaion['page_list']);
					 foreach ($disposal_bid_invitaion['page_list'] as $key => $value) {

					 ?>
                     <tr>
						<td>
							<a title="Delete plan" href="javascript:void(0);" ><i class="fa fa-trash"></i></a>&nbsp;&nbsp;
						<a title="Edit plan details" href="<?=base_url().'disposal/load_bid_invitation_form/edit/'.base64_encode($value['id']); ?>"><i class="fa fa-edit"></i></a></td>

						</td>
						<td>
							 <em class="glyphicon glyphfa fa-user"></em>
						</td>
						<td>
							<?=custom_date_format('d M, Y',$value['bid_opening_date']); ?>
						</td>
						<td>
							<?=$value['disposal_serial_no']; ?>
						</td>
						<td>
							<?=$value['disposal_ref_no']; ?>
						</td>

						<td>
						<?=$value['subject_of_disposal']; ?>
						</td>
						<td>
						<?=custom_date_format('d M, Y',$value['bid_document_issue_date']); ?>
						</td>


					 	  <td>
					 	  <?php
					 	  $curent_date = date("Y/m/d");
							$end_date = strtotime($value['bid_opening_date']."+ ".$value['bid_duration']." days");
					        echo	custom_date_format('d M, Y', date("m/d/Y h:i:s",$end_date));
					 	  ?>
					 	  </td>
                            <td>
							<?php
							$curent_date = date("Y/m/d");
							$end_date = strtotime($value['bid_opening_date']."+ ".$value['bid_duration']." days");
						    $days_remaining = $end_date -   strtotime(date("Y/m/d"));
						    $dsremaing = $days_remaining/(60*60*24);

						    if($dsremaing  < 0 )
						    {
						     echo "expired by ".ltrim ($dsremaing,'-')." days";
						    }
						    else  if($dsremaing  == 0 )
						    {
						    	echo "Expring today";
						    }
						    else
						    {
						    	echo $dsremaing;
						    }


							?>
							</td>

                            <td>
                            <?=custom_date_format('d M, Y',$value['dateadded']); ?>
                            </td>

					</tr>
                     <?php
					}

 				 ?>

				</tbody>
			</table>
            </div>

  </div>
  <!-- end -->
  </div>