<div class="widget">
    <div class="widget-title">
        <h4><i class="icon-reorder"></i>&nbsp;Un Confirmed Providers</h4>
            <span class="tools">
                <a href="javascript:;" class="icon-chevron-down"></a>
                <a href="javascript:;" class="icon-remove"></a>
            </span>
    </div>
    <div class="widget-body">


    <!-- start -->

<div class="row-fluid">
		<div class="span12">
			<div id="results" >
		<?php $this->load->view('includes/modal'); ?>
			<div class="tabbable" id="tabs-358950">
				 <?php
#print_r($receiptinfo);
?>
 
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
							Organisation
						</th>
						<th>
						Tin
						</th>
						<th>
							Vat
						</th>
							<th>
							Legal Status
						</th>
 
						<th>
							 <em class="glyphicon glyphicon-user"></em>
						</th>
						 
					</tr>
				</thead>
				<tbody>
				
 
	<?php
	 
	while($row = mysqli_fetch_array($unconfirmed)){
		 
			?>
			<tr>
<td><?=$row['orgname']; ?></td><td><?=$row['tin']; ?></td><td><?=$row['vat']; ?></td> <td><?=$row['legalstatus']; ?></td> <td>..</td>
			</tr>
			<?php
			# code...
		}
	?>
					 
				</tbody>
			</table>
	
 
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
							Organisation
						</th>
						<th>
						Tin
						</th>
						<th>
							Vat
						</th>
							<th>
							Legal Status
						</th>

						<th>
							Code
						</th>
						<th>
							 <em class="glyphicon glyphicon-user"></em>
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
	 
</div>
     
     </div>