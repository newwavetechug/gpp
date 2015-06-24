<?php
#print_r($procurementdetails[0]);
if($datearea =="procurementdetails" )
{
?>
<form action="#" class="form-horizontal">
<div id="pp_ <?=$procurementdetails[0]['pde_id'] ?>" style="width:70%;" >
							<div class="row-fluid">
								 		<div class="control-group">
								 			<label class="control-label"><strong> Financial year:</strong> </label>
								 			<div class="controls"> <?=$procurementdetails[0]['financial_year'] ?>
								 			</div></div>
							</div

							<div class="row-fluid">
								 			<div class="control-group">
								 				<label class="control-label"><strong> Type of procurement:</strong> </label>
								 				<div class="controls"><?=$procurementdetails[0]['proctype'] ?>
								 				</div>
								 			</div>


								<div class="row-fluid">
								 				<div class="control-group">
								 					<label class="control-label"><strong> Method of procurement:</strong> </label>
								 					<div class="controls"><?=$procurementdetails[0]['procurement_method'] ?>
								 					</div>
								 				</div>
								</div>

								<div class="row-fluid">
								 				<div class="control-group">
								 					<label class="control-label"><strong> Subject of procurement:</strong> </label>
								 					<div class="controls"> <?=$procurementdetails[0]['subject_of_procurement'] ?>  </div>
												 </div>
								</div>

								<div class="row-fluid">
													<div class="control-group">
								 						<label class="control-label"><strong> Source of funding:</strong> </label>
								 						<div class="controls"><?=$procurementdetails[0]['fundingsource'] ?>							 															 						</div>
								 					</div>
								</div>



       <input type="hidden" id="procfefno" dataid="pp_<?=$procurementdetails[0]['pde_id']; ?>" value="pp_<?=$procurementdetails[0]['procurement_ref_no'] ?>  " />

</div>

</div>



   <?php
}
			?>