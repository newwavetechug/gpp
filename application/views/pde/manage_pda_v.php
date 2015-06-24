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
        <h4><i class="fa fa-reorder"></i>&nbsp;Manage  PDE's</h4>
            <span class="tools">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
                <a href="javascript:;" class="fa fa-remove"></a>
            </span>
    </div>
    <div class="widget-body">


    <!-- start -->

<div class="row-fluid">
		<div class="span12">
		<?php #$this->load->view('includes/modal'); ?>
			<div class="tabbable" id="tabs-358950">
<div id="results"> 
				<ul class="nav nav-tabs">
					<li class=" <?php if($level=='active') { ?> active <?php } else { ?> disabled <?php }  ?> tabselction" dataurl="pdes/ajax_fetchpdes/active" datadiv="dvq" id="v">
						<a href="#panel-active" data-toggle="tab" onClick="javascript:location.href='<?=base_url()."admin/manage_pdes/level/".$level."/"; ?>' "> Active </a>
					</li>
					<li class="<?php if($level=='archive') { ?> active <?php } else { ?> disabled <?php }  ?> tabselction" dataurl="pdes/ajax_fetchpdes/archive" datadiv="dvq2" id="df">
						<a href="#panel-inactive" data-toggle="tab"  onClick="javascript:location.href='<?=base_url()."admin/manage_pdes/level/".$level."/"; ?>' "> Archived </a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active dvq" id="panel-active">
					<!--start -->
<!-- <form class="form-search">
				 <button class="btn btn-medium" type="button">Add + </button> &nbsp; &nbsp; <label> Search </label> : &nbsp; <input type="text" class="input-medium search-query" /><button type="submit" class="btn">Go</button> <button type="submit" class="btn">Print</button>
			</form> -->
					<!-- end -->
					 <!-- Active Table COntent -->
	<table class="table  table-striped">
				<thead>
					<tr>
						<th>
							#
						</th>
						<th>
							 <em class="glyphicon glyphfa fa-user"></em>
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
						 <a href="<?=base_url().'pdes/load_edit_pde_form/'.base64_encode($row['pdeid']); ?>"> <i class="fa fa-edit"></i></a>
						 <a href="#" id="savedelpde_<?=$row['pdeid'];?>" class="savedelpde"> <i class="fa fa-trash"></i></a>

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
	<?php print '<div class="pagination pagination-mini pagination-centered">'.
						pagination($this->session->userdata('search_total_results'), $rows_per_page, $current_list_page, base_url().	
						"admin/manage_pdes/p/%d")
						.'</div>'; 

						?> 
					 <!-- End -->
					</div>
					<div class="tab-pane disabled disable dvq2" id="panel-inactive">
						<!-- Archive -->

	<!--start -->
<!-- <form class="form-search">
				 <button class="btn btn-medium" type="button">Add + </button> &nbsp; &nbsp; <label> Search </label> : &nbsp; <input type="text" class="input-medium search-query" /><button type="submit" class="btn">Go</button> <button type="submit" class="btn">Print</button>
			</form> -->
					<!-- end -->
							<table class="table  table-striped disabled">
				<thead>
					<tr>
						<th>
							#
						</th>
						<th>
							PDE Name  
						</th>
						<th>
						Abbreviation
						</th>
						<th>
							Status
						</th>

						<th>
							Code
						</th>
						<th>
							 <i class="fa fa-user"></i>
						</th>
						 
					</tr>
				</thead>
				<tbody>
		<?php
		$x = 0;
	foreach($page_list as $row)
	{
		$x ++;
		?>
		<tr  id="archive_<?=$row['pdeid']; ?>">
							<td class="actived"  id="pdaname_<?=$row['pdeid']; ?>">
								<?=$x; ?>
							</td >
							<td class="actived"  id="pdaname_<?=$row['pdeid']; ?>">
								<?=$row['pdename']; ?>
							</td>
							<td class="actived"  id="pdaname_<?=$row['pdeid']; ?>">
								<?=$row['abbreviation']; ?>
							</td>
							<td class="actived"  id="pdaname_<?=$row['pdeid']; ?>">
								<?=$row['category']; ?>
							</td>
							<td class="actived"  id="pdaname_<?=$row['pdeid']; ?>">
								<?=$row['code']; ?>
							</td>
							<td>
							<a href="#" id="restore_<?=$row['pdeid'];?>" class="savedelpde"> <i class="fa fa-share-alt"></i></a>
						 <a href="#" id="del_<?=$row['pdeid'];?>" class="savedelpde"> <i class="fa fa-remove-sign"></i></a>


							</td>
						</tr>
					 
				<?php
			}
			 ?>
				 
				
					 
					 
					 
				</tbody>
			</table>
						<!-- End -->
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>

 
		</div>
	 
</div>