<?php
#print_r($disposal_plans_details['page_list'][0]);

if($datearea =="disposaldetails" )
{
?>
<form action="#" class="form-horizontal">
<div id="pp_ <?=$disposal_plans_details['page_list'][0]['pdeid'] ?>" style="width:70%;" >

							<div class="row-fluid">
								 			<div class="control-group">
								 				<label class="control-label"><strong> Subject of Disposal:</strong> </label>
								 				<div class="controls"><?=$disposal_plans_details['page_list'][0]['subject_of_disposal'] ?>
								 				</div>
								 			</div>
							</div>

							<div class="row-fluid">
								 		<div class="control-group">
								 			<label class="control-label"><strong> Financial year:</strong> </label>
								 			<div class="controls"> <?=$disposal_plans_details['page_list'][0]['financial_year'] ?>
								 			</div></div>
							</div>

						


								<div class="row-fluid">
								 				<div class="control-group">
								 					<label class="control-label"><strong> Method of Disposal:</strong> </label>
								 					<div class="controls">    <?=$disposal_plans_details['page_list'][0]['method'] ?> 
								 					</div>
								 				</div>
								</div>

								<div class="row-fluid">
								 				<div class="control-group">
								 					<label class="control-label"><strong> Reserve Price :</strong> </label>
								 					<div class="controls">  <?=number_format($disposal_plans_details['page_list'][0]['amount']).' '.$disposal_plans_details['page_list'][0]['currence']; ?>    </div>
												 </div>
								</div>


								<div class="row-fluid">
								 				<div class="control-group">
								 					<label class="control-label"><strong> Asset Location :</strong> </label>
								 					<div class="controls">  <?=$disposal_plans_details['page_list'][0]['asset_location'] ?>    </div>
												 </div>
								</div>

							 



       <input type="hidden" id="procfefno" dataid="pp_<?=$disposal_plans_details['page_list'][0]['pdeid'] ?>" value="pp_<?=$disposal_plans_details['page_list'][0]['pdeid'] ?>" />

</div>

</div>



   <?php
}
			?>
