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



</script><div class="widget">
    <div class="widget-title">
        <h4><i class="icon-reorder"></i>&nbsp;Manage  PDE Types</h4>
            <span class="tools">
                <a href="javascript:;" class="icon-chevron-down"></a>
                <a href="javascript:;" class="icon-remove"></a>
            </span>
    </div>
    <div class="widget-body">


    <!-- start -->

<div class="row-fluid">
		<div class="span12">
			<div id="results">
		<?php $this->load->view('includes/modal'); ?>
			<div class="tabbable" id="tabs-358950">
				<ul class="nav nav-tabs">
					<li class="active tabselction" dataurl="pdetypes/ajax_fetchpdetypes/active" datadiv="dvq" id="pde_active_v">
						<a href="#panel-active" data-toggle="tab"> Active </a>
					</li>
					<li class="disabled tabselction" dataurl="pdetypes/ajax_fetchpdetypes/archive" datadiv="dvq2" id="pde_active_v2">
						<a href="#panel-inactive" data-toggle="tab"> Archived </a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active  dvq" id="panel-active">
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
<?php print '<div class="pagination pagination-mini pagination-centered">'.
						pagination($this->session->userdata('search_total_results'), $rows_per_page, $current_list_page, base_url().	
						"admin/manage_pdetypes/p/%d")
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
							PDE Type  
						</th>
						<th>
						Date Created
						</th>
						 

						<th>
							Author
						</th>
						<th>
							 <em class="glyphicon glyphicon-user"></em>
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
		<tr  id="archive_<?=$row['pdetypeid']; ?>">
							<td  class="actived">
							<?=$xx; ?>
						</td>
						<td  class="actived">
							<?=$row['pdetype']; ?>
						</td>
						 
						<td  class="actived">
							<?=$row['datecreated']; ?>
						</td>
						<td  class="actived">
							 
						</td>
						 
							<td>
							<a href="#" id="restore_<?=$row['pdetypeid'];?>" class="savedelpdetype"> <i class="icon-share-alt"></i></a>
						 <a href="#" id="del_<?=$row['pdetypeid'];?>" class="savedelpdetype"> <i class="icon-remove-sign"></i></a>


							</td>
						</tr>
					 
				<?php
			}
			 ?>
				 
				
					 
					 
					 
				</tbody>
			</table>
			<?php print '<div class="pagination pagination-mini pagination-centered">'.
						pagination($this->session->userdata('search_total_results'), $rows_per_page, $current_list_page, base_url().	
						"admin/manage_pdetypes/p/%d")
						.'</div>'; 

						?> 
						<!-- End -->
					</div>
				</div>
			</div>

		</div>
		</div>
	</div>

 
		</div>
	 
</div>