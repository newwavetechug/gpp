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
            <?php
            $isadmin = $this->session->userdata('isadmin');
        		if($isadmin == 'Y')
           {
            ?>
						<th>
							 Procuring and Disposal Entity
						</th>
            <?php } ?>
						<th>
						 Financial Year
						</th>
                       <!--  <th>
							Title
						</th> -->
						<th>
						Entries
						</th>
						<th>
						Dateadded
						</th>


					</tr>
				</thead>
				<tbody>

  				<?php
  			#	print_r($disposal_plans['page_list']);


					 foreach ($disposal_plans['page_list'] as $key => $value) {

					 ?>
                     <tr>
						<td>
						<a title="Delete plan"  id="del_<?=$value['id']; ?>"  class="savedeldisposal"  href="javascript:void(0);" ><i class="fa fa-trash"></i></a>&nbsp;&nbsp;
						<a title="Edit plan details"  href="<?=base_url().'disposal/new_disposal_plan/edit/'.base64_encode($value['id']); ?>"><i class="fa fa-edit"></i></a></td>
						<!-- <a href="#" id="savedelpde_653" class="savedelpde"> -->
            <?php
            if($isadmin == 'Y')
           {
            ?>
           
						<td>
							<?=$value['pdename']; ?>
						</td>
            <?php } ?>
						<td>
							<?=$value['financial_year']; ?>
						</td>
					<!-- 	<td>
						<?=$value['title']; ?>
						</td> -->
						<td>
                        <?php
						$query = $this -> db -> query("SELECT COUNT(*) as entries FROM disposal_record WHERE  disposal_plan =".$value['id'])->result_array();
						#print_r($query);
						 ?>

                        <a href="<?=base_url()."disposal/view_disposal_records/disposalplan/".base64_encode($value['id']); ?>"><span class="badge badge-info"><?=$query[0]['entries']; ?></span>&nbsp;Entries</a>&nbsp;|&nbsp;<a href="<?=base_url()."disposal/load_disposal_record_form/".base64_encode($value['id']); ?>">Create entry</a></td>
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