<script src="<?=base_url()?>js/moverjs.js"></script>
<?php

 function fetchnum_bidders($ref){
	   $st = "SELECT COUNT(*) as sm ,r.bid_id as bid FROM receipts r INNER JOIN bidinvitations as b on r.bid_id = b.id  INNER JOIN procurement_plan_entries c ON b.procurement_id =c.id   WHERE c.procurement_ref_no = '".$ref."'" ;
	   $q1 = mysql_query($st);
		 $q2 =  mysql_fetch_array($q1)or die("".mysql_error());
		 return $q2;
	}

	function fetchnum_nation($local ='local'){
		$st = "SELECT COUNT(*) as sm ,r.bid_id as bid FROM receipts r INNER JOIN bidinvitations as b on r.bid_id = b.id     INNER JOIN procurement_plan_entries c ON b.procurement_id =c.id   WHERE c.nationality like '".$ref."'" ;
		$q1 = mysql_query($st);
	  $q2 =  mysql_fetch_array($q1)or die("".mysql_error());
		return $q2;
	}

	function fetchreceiptstatus($ref){
	$st = "SELECT count(*) as sm  FROM receipts r INNER JOIN bidinvitations as b on r.bid_id = b.id   INNER JOIN procurement_plan_entries c ON b.procurement_id =c.id   WHERE c.procurement_ref_no = '".$ref."' and r.beb ='Y' " ;
	$q1 = mysql_query($st);
	$q2 =  mysql_fetch_array($q1)or die("".mysql_error());
	return $q2;
	}

	?>
	 <style type="text/css"> .accordion-group{ border-left: none;  border-right: none; border-bottom: none; 	} 	</style>

	<div class="widget-body">
	<div class="row-fluid">

		<?php
		if((isset($level)) && (!empty($level)))
		switch ($level) {
		case 'publish_bidder':
		# Evaluate Bidder...
		#procurementdetails
		#print_r($procurementdetails);
		#bebresult
		$type_oem = 0;
		$ddate_octhe = Date('d/m/Y');
		$num_orb = 0;
		$date_oce_r = Date('d/m/Y');
		$date_oaoterbt_cc = Date('d/m/Y');
		$beb_expiry_date = Date('d/m/Y');
        $final_evaluation_report_approval_date =  Date('d/m/Y');
		$evaluation_commencement_date  =  Date('d/m/Y');
		$nationality = '';
		$currency = '';
        $pid = '';
        $num_bids_local = '';
		$contractprice ='';


			if((isset($bebresult) )&& (!empty($bebresult))){
			#	print_r($bebresult);
				$type_oem = $bebresult[0]['type_oem'];
				$ddate_octhe = Date('d/m/Y',strtotime($bebresult[0]['ddate_octhe']));
				$num_orb = $bebresult[0]['num_orb'];
				$date_oce_r	= Date('d/m/Y',strtotime($bebresult[0]['date_oce_r']));
				$date_oaoterbt_cc =  Date('d/m/Y',strtotime($bebresult[0]['date_oaoterbt_cc']));
				$beb_expiry_date =  Date('d/m/Y',strtotime($bebresult[0]['beb_expiry_date']));
				$final_evaluation_report_approval_date = Date('d/m/Y',strtotime($bebresult[0]['final_evaluation_report_approval_date']));
                $evaluation_commencement_date = Date('d/m/Y',strtotime($bebresult[0]['evaluation_commencement_date']));
				$nationality = $bebresult[0]['nationality'];
				$currency =  $bebresult[0]['currency'];
				$pid = $bebresult[0]['pid'];
				$contractprice = $bebresult[0]['contractprice'];
				$num_bids_local = $bebresult[0]['num_orb_local'];


			}

			?>
		<input type="hidden" name="recepid" id="recepid" class="recepid" value="<?=$pid; ?>" />
		<div class="widget-body form">
		 <?php
          $varible = (!empty($lots)) ? '<>*ifbslot' : '' ;

          if(!empty($lots)){ 	?>   	<script> $(function(){ lott = 1; });  	</script> 	<?php   }
          else{ ?> 	<script> $(function(){ lott = 0; });</script> 	<?php  } ?>
          

		<form action="#" class="form-horizontal" id="evaluatebebdisposal" name="evaluatebebdisposal"  data-type="newrecord"  data-cheks="pdename<>pdecode" data-check-action="<?=base_url();?>bids/savebeb/" data-action="<?=base_url();?>disposal/savebeb"    data-elements="*bidid<>*pid<>*disposaltrefno<>*evaluationmethods<>*dob_commencement<>*dob_evaluation<>dob_cc<>*bebname<>beb_nationality<>*contractprice<>*currence<>*dob_cc_award<?=$varible;?>" >

				<div class="accordion" id="accordion-562508">
				<div class="accordion-group">
				<div class="accordion-heading">
				<a class="accordion-toggle" href="#" data-toggle="collapse" data-parent="#accordion-562508"  >Disposal  Record</a>
				</div>
				<div id="procurement_record" class="accordion-body   in">
				<div class="accordion-inner">
				<input type="hidden" value="<?=$bidid; ?> " id="bidid"/>
	<?php
	#print_r($disposal_plans_details);
	?>

	<input type="hidden" value="<?=$disposal_plans_details['page_list'][0]['disposal_record'] ?> " id="pid"/>
	<input type="hidden" value="<?=$disposal_plans_details['page_list'][0]['disposal_ref_no'] ?> " id="disposaltrefno"/>
	<input type="hidden" value="<?=$disposal_plans_details['page_list'][0]['disposal_record'] ?> " id="bidi"/>

								 <div class="row-fluid">
								 <div class="control-group">
								 <label class="control-label">Disposal Reference Number</label>
								 <div class="controls">
								 <label class="span6">   <?=$disposal_plans_details['page_list'][0]['disposal_ref_no'] ?> </label>
								 </div>
								 <label class="span4"> </label><a id="dts" href="javascript:togglediv('moredetails','dts'); void(0);" class="link span6 "> More details  </a>
								 </div>
								 </div>
								 <!-- moredetails
								  -->

								 <div class="row-fluid" id="moredetails" style="display:none;">
								 <div id="procurement_plan_details" style="width:100%; margin:auto;">
								 
								 <!-- strat -->

										<div class="row-fluid">
								 		<div class="control-group">
								 			<label class="control-label"> Financial year: </label>
								 			<div class="controls"> <?=$disposal_plans_details['page_list'][0]['financial_year'] ?>
								 			</div>
								 			</div>
											</div>

											<div class="row-fluid">
								 			<div class="control-group">
								 				<label class="control-label"> Subject of Disposal: </label>
								 				<div class="controls"><?=$disposal_plans_details['page_list'][0]['subject_of_disposal'] ?>
								 				</div>
								 			 </div>


												<div class="row-fluid">
								 				<div class="control-group">
								 					<label class="control-label"> Method of Disposal: </label>
								 					<div class="controls">    <?=$disposal_plans_details['page_list'][0]['method'] ?> 
								 					</div>
								 				</div>
								</div>
								<div class="row-fluid">
								 				<div class="control-group">
								 					<label class="control-label"> Reserve Price :</label>
								 					<div class="controls">  <?=number_format($disposal_plans_details['page_list'][0]['amount']).' '.$disposal_plans_details['page_list'][0]['currence']; ?>    </div>
												 </div>
								</div>
								<div class="row-fluid">
								 				<div class="control-group">
								 					<label class="control-label"> Asset Location : </label>
								 					<div class="controls">  <?=$disposal_plans_details['page_list'][0]['asset_location'] ?>    </div>
												 </div>
								</div>

							 



       							<input type="hidden" id="procfefno" dataid="pp_<?=$disposal_plans_details['page_list'][0]['pdeid'] ?>" value="pp_<?=$disposal_plans_details['page_list'][0]['pdeid'] ?>" />

								 <!-- end -->
								 	</div>
									</div>
									</div>

							</div>
						  </div>
					    </div>

				 
<!-- start-->

					<div class="accordion-group">
					<div class="accordion-heading">
					<a class="accordion-toggle"  href="#" data-toggle="collapse" data-parent="#accordion-562508"  >Bid Activity Schedule</a>
					</div>
					<div id="bid_activity" class="accordion-body  in ">
					<div class="accordion-inner">
					<?php
					 # print_r($bidinformation);
					 ?>
					 

					 <div class="row-fluid">
					 <div class="control-group">
					 <label class="control-label">
								 Number of bids submission
					 </label>

					 <div class="controls"><a   href="#"> <?php print_r($localbids['sm']+$foreignbids['sm']);
									?> </a>
					 </div>
					 </div>
					 </div>
						<div class="row-fluid">
						<div class="control-group">
						<label class="control-label"> Local bids</label>
						<div class="controls">
						<a href="#" class="link span2 "><?php print_r($localbids['sm']); ?> </a>
						</div>
						</div>
						</div>
					</div>
<!-- end -->

					<div class="accordion-group">
					<div class="accordion-heading">
							 <a class="accordion-toggle" href="#" data-toggle="collapse" data-parent="#accordion-562508"  >Bid Evaluation</a>
					</div>
					<div id="bid_evaluation" class="accordion-body  in ">
					<div class="accordion-inner">
					<div class="row-fluid">

	        <div class="control-group">
	        <label class="control-label">Basis of evaluation</label>
	        <div class="controls">

					<select  class="  chosen evaluationmethods span6"   data-placeholder="Type of Evaluation" tabindex="1" name="evaluationmethods" id="evaluationmethods">
					<?php
					foreach ($evaluation_methods as $key => $value) {
					?>
					<option value="<?=$value['evaluation_method_id']; ?>" <?php if($value['evaluation_method_id'] == $type_oem) {?> <?php }?> ><?=$value['evaluation_method_name']; ?></option>
					<?php
					 }
					 ?>
					</select>

	         </div>
	         </div>

	         <div class="control-group">
	         <label class="control-label"> Date of evaluation</label>
	         <div class="controls">
	         <input class=" m-ctrl-medium date-picker   dob_commencement span6"     type="text" value="<?=$ddate_octhe; ?>" id="dob_commencement" name="dob_commencement" />
	         </div>
	         </div>
             
             <!-- 
	         <div class="control-group">
	         <label class="control-label"> Number of technically responsive bids evaluated /  of which were local </label>
	         <div class="controls">
	         <input type="text" class=" span6 num_bids" value="<?=$num_orb; ?>"  datatype="numeric" name="num_bids" id="num_bids">
	         <input type="text" class=" input-medium  num_bids_local" value="<?=$num_bids_local; ?>"  datatype="numeric" name="num_bids_local" id="num_bids_local">
	         
	         </div>
	         </div> -->

	         <div class="control-group">
	         <label class="control-label">Date of final evaluation report</label>
	         <div class="controls">
	         <input class=" m-ctrl-medium date-picker   dob_evaluation span6"     name="dob_evaluation" id="dob_evaluation"  type="text" value="<?=$date_oce_r; ?>" />
		     </div>
	         </div>

	         <div class="control-group">
	         <label class="control-label">Date of approval of the final  evaluation report by the contracts committee</label>
	         <div class="controls">
	         <input class=" m-ctrl-medium date-picker  dob_cc span6"      type="text" value="<?=$date_oaoterbt_cc; ?>" id="dob_cc" name="dob_cc" />
		     </div>
	         </div>
					 <?php
							#print_r($evaluation_methods);
					 ?>
						</div>
						</div>
						</div>
				  	    </div>


					    <div class="accordion-group">
						<div class="accordion-heading">
						<a class="accordion-toggle"  href="#" data-toggle="collapse" data-parent="#accordion-562508"  >Letter of Bid Acceptance Details </a>
						</div>
						<div id="bidder_details_contactprice" class="accordion-body  in ">
						<div class="accordion-inner">
						<div class="row-fluid">


                  <?php
              #    print_r($lots);

                  if(!empty($lots))
                  {
                  ?>


                    <div class="control-group">
                    <label class=" control-label" >
                    Select Lot
                    </label>
                    <div class="controls">
                      <?php
                    //  print_r($lots[0]);
                      ?>

                      <select class="span6 ifbslot" id="ifbslot" name="ifbslot" dataref="selecc">
                      <option value="0"> Select  </option>
                      <?php
                      foreach ($lots as   $record) {
                      ?>
                      <option value="<?php  print_r($record['id']); ?>" >

                        <?= print_r($record['lot_title']); ?> </option>
                      <?php
                      }
                      ?>
                      </select>

                      </div>
                      </div>

                      <?php } ?>

	 				   <div class="control-group">
	                   <label class="control-label"> Name of Buyer</label>
	                   <div class="controls">

	                   <?php
	                  # print_r($providerslist);
	                   ?>

	                    <select class="span6 chosen selectedbeb bebname" id="bebname" name="bebname" data-placeholder="BEB Name" tabindex="1" onChange="javascript:updatelist2(this.value)">
						<option value="0"> Select Bidder</option>
						<?php
						foreach ($providerslist as $key => $value) {
	    $providers  = rtrim($value['providernames'],",");
		$query = mysql_query("select * from providers where providerid in (".$providers.") ");
		$row = mysql_query("SELECT * FROM `providers` where providerid in ($providers) ") or die("".mysql_error());
	 	$provider = "";
	 	$x = 0;
		while($vaue = mysql_fetch_array($row))
		{
			$x ++;
			$provider  .=strpos($vaue['providernames'] ,"0") !== false ? '' : $vaue['providernames'].' , ';

		}		
		$prvider = rtrim($provider,' ,');
		if($provider == ' ')
				continue;

		if($x > 1)
		$prvider = $prvider.' &nbsp [JV] ';
	    $x = 0;
		?>
    <option value="<?=$value['receiptid'] ?>"><?=$prvider; ?>     </option>
    <?php
		#print_r($prvider);

	}?>
		 </select>
	   </div>
		 <?php
		 #print_r($providerslist[0]);
		 ?>
		</div>

								 <div class="control-group">
	                             <label class="control-label"> Country of Registration</label>
	                             <div class="controls">
	                             <select class="span6 chosen beb_nationality" name="beb_nationality" data-placeholder="Nationality" tabindex="1" id="beb_nationality">
											<?php
											$que = mysql_query("SELECT * FROM countries") or die("".mysql_error());
											while ($ans = mysql_fetch_array($que)) {
												# code...
												if($ans['country_name'] == 'uganda')
												{
													?>
													<option selected value="<?=$ans['country_name']; ?>" <?php if($ans['country_name'] == $nationality){ ?> selected <?php } ?>> <?=$ans['country_name'] ?> </option>

													<?php
												}else
												{
												?>
													<option value="<?=$ans['country_name']; ?>"> <?=$ans['country_name'] ?> </option>
												<?php
											}
											}
											?>


								 </select>
	                             </div>




							</div>

							<!-- Date of Contract Award -->
 <div class="control-group">
	                             <label class="control-label"> Date of Contract Award</label>
	                             <div class="controls">
	                              <input class=" m-ctrl-medium date-picker  dob_cc_award span6"      type="text" value="<?=$date_oaoterbt_cc; ?>" id="dob_cc_award" name="dob_cc_award" />	  
	                             </div>

<!-- end -->

								  	<?php
								  	#print_r($providerslist[0]);
								  	?>

								 </div>


						</div>
					</div>


			<div class="accordion-group">
			<div class="accordion-heading">
			 <a class="accordion-toggle" href="#" data-toggle="collapse" data-parent="#accordion-562508" >Contract Price</a>
			 </div>
			 <div id="unsuccessful_bidders" class="accordion-body  in ">
			 <div class="accordion-inner">
			 <div class="row-fluid">
			 <div class="row-fluid">

        <div class="control-group">
		<label class=" control-label">  Contract Price *:  </label>
        <div class="controls">
	    <input type="text" class=" span6 contractprice numbercommas " datatype="numeric" id="contractprice" name="contractprice" value="<?=$contractprice; ?>">
        &nbsp;

      <?php
       $recod = mysql_query("select * from currencies ") or die("".mysql_error()) ;
       ?>

      <select class="input-medium chosen currence" data-placeholder="currence " id="currence" name="currence" tabindex="1">
      <?php
      while($cur  =  mysql_fetch_array($recod)){
       ?>
      <option><?php print_r($cur['title']); ?> </option>
      <?php
        }
        ?>
      </select>
      </div>
	  </div>
	  </div>



						</div>
						</div>
					    </div>


					<div class="accordion-group">
					<div class="accordion-heading">
					<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-562508"  >Unsuccessful Bidders</a>
					</div>
					<div id="unsuccessful_bidders" class="accordion-body  in ">
					<div class="accordion-inner">
					<div class="row-fluid" id="unbidderlist">
					<?php


	#print_r($unsuccesful_bidders);

				?>
				<!--
						<table class="table table-striped" id="sample_1">
					<thead>
						<tr>
							<th>
								#
							</th>
							<th>
								Bidders Name
							</th>
							<th>
								Bidder Nationality
							</th>
							<th>
								Reason
							</th>




						</tr>
					</thead>
					<tbody>
-->
						<?php
						/*
						$x = 0;
						foreach ($unsuccesful_bidders as $key => $value) {
							# code...
							$x ++;
							?>
							<tr id="<?=$value['receiptid'] ?>" dataid="<?=$value['receiptid'] ?>">
							<td>
							 <?= $x; ?>
							</td>
							<td>
								 <?=$value['providernames'] ?>
							</td>
							<td>
								 <?=$value['nationality'] ?>
							</td>
							<td>
								<select class="span12 " data-placeholder="Nationality" tabindex="1" onChange="javascript:reason(this.value,<?=$value['receiptid'] ?>)">
								   <option value="0">Select Reason </option>
								   <option value="Over priced" > Over priced </option>
								 </select>
							</td>
						</tr>
							<?php
						} */

						?>



	<!-- </table> -->
	<div class="alert alert-info">
                  <button data-dismiss="alert" class="close">×</button> 
      No Best Evaluated Bidder Selected
       </div>
 

					 </div>



							</div>


						</div>
					</div>
			<!--	<button type="submit" name="view" value="view" class="btn blue plishtype"><i class="icon-folder-open"></i> View</button>
			-->
				<button type="submit" name="save" value="save" class="btn blue plishtype"><i class=" icon-folder-close"></i> Save</button>
				<button type="submit" name="publish" value="publish" class="btn plishtype"><i class="icon-qrcode"></i> Publish </button>




				</div>
			</form>
			</div>
			<?php
				break;

			case 'active_procurements':
				# code...
			?>
			<div class="row-fluid">
			<div class="span12">

	<table class="table table-striped">
					<thead>
						<tr>
							<th>
								#
							</th>
							<th>
								Procurement Ref #
							</th>
							<th>
								Subject of iFB
							</th>
							<th>
								No of Bids
							</th>



						</tr>
					</thead>
					<tbody>
				<?php

			#	print_r($active_procurements);
				foreach ($active_procurements['page_list'] as $key => $value) {
					# code...
					?>
						<?php  $q = fetchnum_bidders($value['procurement_ref_no']);
							   $status = fetchreceiptstatus($value['procurement_ref_no']);
						?>

					<tr  >
							<td>

							 <?php
								#print_r($status['sm']);
								if( $status['sm'] > 0)
									{

										}
										else{
							 $pqs = $value['procurement_ref_no'];
							 if($q[1] > 0){
							 ?>
							<a href="<?= base_url() . 'bids/publish_bidder/publish_bidder/'.$q[1].'/'.base64_encode($pqs); ?>"> Evaluate </a>
							<?php } }?>
							</td>
							<td>
								<?=$value['procurement_ref_no']; ?>
							</td>
							<td>
								<?php
								//$value['subject_of_procurement']; ?>

							</td>
							<td>
								<?php
								#print_r($status['sm']);
								if( $status['sm'] > 0)
									{
										?>
										<span class="label label-success">BEB Approved</span>
										<?php
												}
								else
								{
								$zx = $q[1];
								if($zx > 0)
								{
									$ss = $q[1];

								?>
								<a href="<?= base_url() . 'bids/publish_bidder/view_bidders_list/'.$ss.'/'.base64_encode($value['procurement_ref_no']); ?>" publish_bidder>

								<span class="badge badge-info"><?php echo($q[0]);  ?></span>  Providers
								 </a>
								 <?php
								 }else
								{
									 ?>
									 <span class="label label-danger">No Proposals &nbsp;</span>

									 <?php
								}


								   } ?>
							</td>



						</tr>
					<?php
				}
				?>



					</tbody>
				</table>


				<?php print '<div class="pagination pagination-mini pagination-centered">'.
						pagination($this->session->userdata('search_total_results'), $active_procurements['rows_per_page'], $active_procurements['current_list_page'], base_url()."bids/publish_bidder/active_procurements/p/%d")
						.'</div>';

						?>
			</div>
		</div>
			<?php
				break;
				case 'view_bidders_list':
				?>
		<div class="span12">
	<?php
	 #print_r($bidderslist);
	  ?>
	<table class="table table-striped">
					<thead>
						<tr>
							<th>
								#
							</th>
							<th>
								Procurement Ref #
							</th>
							<th>
								Service Provider
							</th>
							<th>
								Details
							</th>
							<th>
								Date Submitted
							</th>

							<th>
								Recieved By
							</th>
							<th> Nationality </th>
							<th> Date Added </th>
								<th> Evaluated </th>


						</tr>
					</thead>
					<tbody>
				<?php

				foreach ($bidderslist as $key => $value) {
					# code...
					?>
					<tr  >
							<td>
								<?php  $q = fetchnum_bidders($page_title); ?>
								<a href="<?= base_url() . 'bids/publish_bidder/publish_bidder/'.$q[1].'/'.base64_encode($page_title); ?>"> Evaluate </a>

							</td>
							<td>
								<?=$value['procurement_ref_no']; ?>
							</td>
							<td>
								<?=$value['providernames']; ?>
							</td>
							<td>
								 <?=$value['details']; ?>
							</td>
							<td>
								<?=$value['datereceived']; ?>
							</td>

							<td>
								 <?=$value['received_by']; ?>
							</td>
							<td>
								 <?=$value['nationality']; ?>
							</td>
							<td>
								 <?=$value['dateadded']; ?>

							</td>
							<td>

								  <?php


								  switch ($value['beb']) {
								  	case 'p':
								  		# code...
								  	?>
								  	<span class="label label-info">Pending</span>
								  	<?php
								  		break;
								  		case 'Y':
								  		# code...
								  		?>
								  		<span class="label label-success">Approved</span>
								  		<?php
								  		break;
								  			case 'N':
								  			?>
								  			<span class="label label-warning">Suspended</span>
								  			<?php
								  		# code...
								  		break;
								  	default:
								  		# code...
								  		break;
								  }

								  ?>

							</td>

						</tr>
					<?php
				}
				?>



					</tbody>
				</table>
			</div>
				<?php
				break;
				default:
				break;
		}
		?>

	</div>
	<br/>
	<br/>

	<script type="text/javascript">
	$(function(){

    $('.numbercommas').keyup(function(e){
        if (/[^\d,]/g.test(this.value))
        {
          this.value = this.value.replace(/[^\d,]/g, '');
        }

        $(this).val(addCommas($(this).val()));
    });
	})</script>