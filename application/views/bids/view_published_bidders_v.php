<div class="widget">
    <div class="widget-title">
        <h4><i class="icon-reorder"></i>&nbsp;Manage  Receipts </h4>
            <span class="tools">
                <a href="javascript:;" class="icon-chevron-down"></a>
                <a href="javascript:;" class="icon-remove"></a>
            </span>
    </div>
    <div class="widget-body">


    <!-- start -->

<div class="row-fluid">
		<div class="span12">
		<?php $this->load->view('includes/modal'); ?>
			<div class="tabbable" id="tabs-358950">
				<ul class="nav nav-tabs">
					<li class="active tabselction" dataurl="pdes/ajax_fetchpdes/active" datadiv="dvq" id="pde_active_v">
						<a href="#panel-active" data-toggle="tab"> Active </a>
					</li>
					<li class="disabled tabselction" dataurl="pdes/ajax_fetchpdes/archive" datadiv="dvq2" id="pde_active_v2">
						<a href="#panel-inactive" data-toggle="tab"> Archived </a>
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
							 <em class="fa  fa-user"></em>
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
				 
					 
					 
				</tbody>
			</table>
	
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
							 <em class="fa fa-user"></em>
						</th>
						 
					</tr>
				</thead>
				<tbody>
	 
				
					 
					 
					 
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