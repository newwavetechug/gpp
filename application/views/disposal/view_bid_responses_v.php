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
          <h4><i class="icon-reorder"></i>&nbsp;<?=$page_title; ?> </h4>
              <span class="tools">
                  <a href="javascript:;" class="icon-chevron-down"></a>
                  <a href="javascript:;" class="icon-remove"></a>
              </span>
      </div>
      <div class="widget-body">


      <!-- start -->

  <div class="row-fluid">
  <?php 
 # print_r($disposal_bid_invitaion);
  #exit();
  ?>
  <div id="results">
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
						 Disposal Reference Number
						</th>
                        <th>
							Provider 
						</th>
						<th>
						Nationality
						</th>
						<th>
						Date Submitted
						</th>
						<th>
						Received By
						</th>

						<th>
						Author
						</th> 
                         <th>
                         Date Added
                          </th>
                            <th> </th>
					</tr>
				</thead>
				<tbody>
				 
  				<?php
  
	
					 foreach ($disposal_bid_invitaion['page_list'] as $key => $value) {
					 
					 ?>
                     <tr>
						<td>
							#
						</td>
						<td>
							 <em class="glyphicon glyphicon-user"></em>
						</td>
						<td>
							<?=$value['disposal_ref_no']; ?>
						</td>
						<td>
						<?=$value['providernames']; ?>
						</td>
						<td>
                        <?=$value['nationality']; ?>
					 
						</td>

						<td>
							<?=custom_date_format('d M, Y',$value['datesubmitted']); ?>
						</td>
					 	  <td>
					 	  <?=$value['receivedby']; ?>
					 	  </td> 
                            <td>
							-
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