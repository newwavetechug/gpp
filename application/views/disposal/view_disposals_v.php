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
		          <h4><i class="fa fa-reorder"></i>&nbsp;<?=$page_title; ?>  &nbsp; <a style="margin-left: 20px;" href="<?=base_url().'disposal/load_disposal_record_form'; ?>" > <i class="fa fa-plus"></i>  Add Dispoal Record </a>
		          </h4>
		               <span class="tools">
		                  <a href="javascript:;" class="fa fa-chevron-down"></a>
		                  <a href="javascript:;" class="fa fa-remove"></a>
		              </span>
		      </div>
		      <div class="widget-body">

		     <!-- start -->

		  <div class="row-fluid">
		  <?php
		  #print_r($disposal_records['page_list']);
		  ?>
		  <div id="results">
		   	<table class="table  table-striped">
						<thead>
							<tr>
								<th>

								</th>
								<?php
								$isadmin = $this->session->userdata('isadmin');
								if($isadmin == 'Y')
								{
								?>
							 <th>
								Disposing and Procuring Entity
							</th>
							<?php
						   }
						?>
								<th>
								Disposal Plan
								</th>


								<th>
									Disposal Serial Number
								</th>
								<th>
								Subject of Disposal
								</th>

								<th>
								Disposal Method
								</th>

								<th>
									Asset Location
								</th>

								<th>
								Amount
								</th>

								<th>
								Currency
								</th>
								 <th>
								Date of Accounting Officer
								Approval
								</th>
								<th>
								If Strategic Asset
								[Date of PSST Approval]
								</th>


		                        <th> Date Updated </th>

							</tr>
						  </thead>
						<tbody>

		  				<?php


							 foreach ($disposal_records['page_list'] as $key => $value) {

							 ?>
		            <tr>
								<td>
									<?php
									if($isadmin == 'N')
									{
										?>
								 
								<a title="Delete plan"   id="del_<?=$value['id']; ?>"  class="savedeldisposalrecord"  href="javascript:void(0);" ><i class="fa fa-trash"></i></a>&nbsp;&nbsp;
								<a title="Edit plan details" href="<?=base_url().'disposal/load_disposal_record_form/edit/'.base64_encode($value['id']); ?>"><i class="fa fa-edit"></i></a></td>
								<?php } ?>
								</td>
								<?php

								if($isadmin == 'Y')
								{
									?>
								<td>
									<?=$value['pdename']; ?>
								</td>
								<?php
									}
									?>

								<td>
									<?=$value['financial_year']; ?>
								</td>

								<td>
									<?=$value['disposal_serial_no']; ?>
								</td>
								<td>
								<?=$value['subject_of_disposal']; ?>
								</td>
								<td>
									<?=$value['method']; ?>
								</td>
								<td>
								<?=$value['asset_location']; ?>
								</td>

								<td>
									<?=number_format($value['amount']); ?>
								</td>
									<td>
									<?=$value['currence']; ?>
								</td>
							 		<td><?=custom_date_format('d M, Y',$value['dateofaoapproval']); ?></td>
							 		<td><?php
										switch ($value['strategic_asset']) {
											case 'Y':
												# code...
											print_r(custom_date_format('d M, Y',$value['date_of_approval']));
												break;
											print_r("-");
											default:
												# code...
												break;
										}
				                 ?></td>
		                            <td><?=custom_date_format('d M, Y',$value['dateadded']); ?> </th>

							</tr>
		                     <?php
							}

		 				 ?>

						</tbody>
					</table>

		            </div>
		<?php
		#print_r($disposal_records);
		                    print '<div class="pagination pagination-mini pagination-centered">'.
		                        pagination($this->session->userdata('search_total_results'), $disposal_records['rows_per_page'], $disposal_records['current_list_page'], base_url().
		                        "disposal/view_disposal_records/p/%d")
		                        .'</div>';
		        ?>



		  </div>
		  <!-- end -->
		  </div>