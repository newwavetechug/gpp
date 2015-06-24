<?php if(empty($requiredfields)) $requiredfields = array();

?>
<div class="widget">
<script type="text/javascript">
$(function(){

$("#cntractawardform").submit(function(e){
 
			<?php if(empty($requiredfields))
			{
				?>
				   status = $("#providerstatus").val();
				<?php
			}
			else
			{
				?>
				   status = 8;
				<?php
			}

			?>
		
		 if(status != 0)
         e.preventDefault();
         if(status == 1){
         alert('Attempt to award a contract to suspended provider');
           //push information
          var getUrl = getBaseURL() + 'bids/procurement_record_details/notification/y';   
     
	      getUrl += '/b/get'; 
	      formdata = {proc_id: $("#procurement-ref-no").val()};  

    
            $.ajax({

                url: getUrl,
                type: 'POST',
                data: formdata,
	                 success: function(data)
	                 {	                   
                     console.log(data);                            
                     },
                     error:function(data)
                     {
                     console.log(msg);
                      }

                    });
                }
         
		 })
   
         
	})

 
</script>
     <!-- BEGIN FORM-->
     <form action="<?=base_url() . 'contracts/award_contract' . ((!empty($i))? '/i/'.$i : '' )?>" enctype="multipart/form-data" method="post" class="form-horizontal" id="cntractawardform">
    <div class="widget-body">
    <!-- Procurement Record view -->
    <div class="widget-title">
        <h4><i class="fa fa-reorder"></i>&nbsp;Procurement Record</h4>
    </div>      
        
    <?php if(empty($procurement_plan_entries)): ?>
    <?php print format_notice('ERROR: There are no procurement entries available for contract award'); ?>
    <?php else: ?>
        <div class="control-group">
            <label class="control-label">Procurement Ref. No <span>*</span></label>
            <div class="controls">
          <select id="procurement-ref-no" class="chosen get_beb" name="prefid" tabindex="1">
                    <?=get_select_options($procurement_plan_entries, 'id', 'procurement_ref_no', (!empty($formdata['prefid'])? $formdata['prefid'] : '' ))?>
                </select>
            </div>
        </div>
          
        <div id="procurement_plan_details">
			  <?php if(!empty($formdata['procurement_details'])): ?>
              <?php $procurement_details = $formdata['procurement_details']; ?>
                  <div class="control-group">
                      <label class="control-label">Subject of procurement:</label>
                      <div class="controls">
                          <?=(!empty($procurement_details['subject_of_procurement'])? $procurement_details['subject_of_procurement'] : '<i>undefined</i>')?>
                          <input type="hidden" name="procurement_details[subject_of_procurement]" value="<?=$procurement_details['subject_of_procurement']?>" />
                      </div>
                  </div>
                  <div class="control-group">
                      <label class="control-label">Method of Procurement:</label>
                      <div class="controls">
                          <?=(!empty($procurement_details['procurement_method'])? $procurement_details['procurement_method'] : '<i>undefined</i>')?>
                          <input type="hidden" name="procurement_details[procurement_method]" value="<?=$procurement_details['procurement_method']?>" />
                      </div>
                  </div>
                  <div class="control-group">
                      <label class="control-label">Source of Funding:</label>
                      <div class="controls">
                          <?=(!empty($procurement_details['funding_source'])? $procurement_details['funding_source'] : '<i>undefined</i>')?>
                          <input type="hidden" name="procurement_details[funding_source]" value="<?=$procurement_details['funding_source']?>" />
                      </div>
                  </div>
               <?php endif; ?>
      </div>
    
    <!-- End Procurement Record view -->

    <!-- Contract award details -->
    <div class="widget-title">
        <h4><i class="fa fa-reorder"></i>&nbsp;Contract  details</h4>
    </div><br />
            
	<div class="control-group">
            <label class="control-label">Date signed: <span>*</span></label>
            <div class="controls">
            	<div class="input-append date date-picker" data-date="<?=(!empty($formdata['date_signed'])? custom_date_format('Y-m-d', $formdata['date_signed']) : date('Y-m-d') )?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
				<input name="date_signed" data-date="<?=(!empty($formdata['date_signed'])? custom_date_format('Y-m-d', $formdata['date_signed']) : date('Y-m-d') )?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days" class="m-ctrl-medium date-picker"  type="text" value="<?=(!empty($formdata['date_signed'])? $formdata['date_signed'] : '' )?>">
				<span class="add-on"><i class="fa fa-calendar"></i></span>
				</div>
            </div>
        </div>
        
	<div class="control-group">
            <label class="control-label">Planned date of commencement of
contract: <span>*</span></label>
            <div class="controls">
            	<div class="input-append date date-picker" data-date="<?=(!empty($formdata['commencement_date'])? custom_date_format('Y-m-d', $formdata['commencement_date']) : date('Y-m-d') )?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
				<input name="commencement_date" data-date="<?=(!empty($formdata['commencement_date'])? custom_date_format('Y-m-d', $formdata['commencement_date']) : date('Y-m-d') )?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days" class="m-ctrl-medium date-picker" type="text" value="<?=(!empty($formdata['commencement_date'])? $formdata['commencement_date'] : '' )?>" id="start_date">
				<span class="add-on"><i class="fa fa-calendar"></i></span>
				</div>
            </div>
        </div>
        
		<div class="control-group">
            <label class="control-label">Duration of contract (no. of days): <span>*</span></label>
            <div class="controls">
                <input type="text" id="days" name="duration" placeholder="Days" value="<?=(!empty($formdata['duration'])? $formdata['duration'] : '' )?>" class="input-small" required/>
            </div>
        </div>
        
<div class="control-group">
            <label class="control-label">Planned date of contract
completion: <span>*</span></label>
            <div class="controls">
					<input name="completion_date"class="input-large" type="text" value="<?=(!empty($formdata['completion_date'])? $formdata['completion_date'] : '' )?>" id="end_date" placeholder="Completion Date" readonly>
				</div>
            </div>
        </div>
    <!-- End contract award view -->
    
    <!-- Contract amount -->
    <div class="widget-title">
        <h4><i class="fa fa-reorder"></i>&nbsp;Contract amounts</h4>
    </div><br />
    <input type="hidden" name="amounts_str" value="" id="amounts-str" />
    
    <div class="control-group add_contract_price">
            <label class="control-label">Amount: <span>*</span></label>
            <div class="controls">
            	<select class="input-small m-wrap" name="currency" required>
            		<?=get_select_options($currencies, 'id', 'title', (!empty($formdata['currency'])? $formdata['currency'] : 1 ))?>
            	</select>
                <input style="display:none" class=" input-small numbercommas" name="rate" placeholder="Exchange rate" type="text" />
                <div class="input-append">
                    <input class=" input-medium numbercommas" name="amount" placeholder="amount" type="text" />
                    <div class="btn-group">
                        <a class="btn">
                            Add amount
                        </a>
                    </div>
                </div>                
                <span class="help-inline">&nbsp;</span>
           </div>
    </div>
    
    <div class="control-group">
            <label class="control-label">&nbsp;</label>
            <div class="controls contract_prices" style="width:50%">
            
            	<div class="alert alert-info" <?=(!empty($formdata['contract_amount'])? 'style="display:none"' : '')?>>
                	<button data-dismiss="alert" class="close">×</button> 
                    No contract prices entered yet. 
                    To add a contract price, select the appropriate currency, enter the amount and click 'Add amount' to add the contract price
                </div>
            
                
                <table class="table table-condensed table-striped table-bordered" <?=(!empty($formdata['contract_amount'])? '' : 'style="display:none"')?>>
                    <thead>
                    <tr>
                    	<th style="width:5%"></th>
                        <th style="width:15%">
                            Amount
                        </th>
                        <th style="width:10%" class="hidden-phone">
                            Currency
                        </th>
                        <th style="width:10%" class="right-align-text hidden-phone">
                            X Rate
                        </th>
                        <th style="width:20%; text-align:right" class="right-align-text hidden-phone">
                            Amount in UGX
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    	<?php
                        	if(!empty($formdata['contract_amount'])):
                        		foreach($formdata['contract_amount'] as $contract_amount)
								{
									if(is_array($contract_amount)):
										$contract_amount_arr[0] = $contract_amount['amount'];
										$contract_amount_arr[1] = $contract_amount['currency_id'];
										$contract_amount_arr[2] = $contract_amount['xrate'];
										$contract_amount_arr[3] = $contract_amount['title'];
										
									else:
										$contract_amount_arr = explode('__', $contract_amount);
									
									endif;									
									
									print '<tr>'.
										 '<td style="text-align:center">'.
										 '<a title="Click to remove" href="javascript:void(0);">'.
										 '<i class="fa fa-remove"></i></a>'.
										 '<input type="hidden" name="contract_amount[]" value="'.$contract_amount_arr[0].
										 '__' .$contract_amount_arr[1] .'__'. $contract_amount_arr[2] .'__'. $contract_amount_arr[3] .'" />'.
										 '</td>'.
										 '<td>'.addCommas($contract_amount_arr[0], 0).'</td>'.
										 '<td class="hidden-phone" style="font-size:11px"><strong>'. $contract_amount_arr[3] .'</strong></td>'.
										 '<td class="right-align-text hidden-phone">'.
										 '<input type="hidden" class="curId" value="'. $contract_amount_arr[1] .'" />'.
										 '<span class"number">'. addCommas($contract_amount_arr[2], 0) .'</span></td>'.
										 '<td style="text-align:right" class="right-align-text hidden-phone">'.
										 '<span class"number">'.
										 addCommas(removeCommas($contract_amount_arr[0]) * removeCommas($contract_amount_arr[2]), 0).
										 '</span>'.
										 '</td></tr>';
									
								}
							endif;
						?>                    
                    </tbody>
                </table>
            </div>
    </div>
      
    
    
    <div class="form-actions">
    	<button type="submit" name="save" value="save" class="btn blue"><i class="fa fa-ok"></i> Save</button>
        <button type="reset" name="cancel" value="cancel" class="btn"><i class="fa fa-remove"></i> Cancel</button>
    </div>
    <?php endif; ?>
    
   	</form>
    <!-- END FORM-->
    
    <!-- End contract amount -->
    </div>
    
    <script type="text/javascript">
		(function($, window, document, undefined){
			$("#days").on("keyup", function(){
			   var date = new Date($("#start_date").val()),
				   days = parseInt($("#days").val(), 10);
				
				if(!isNaN(date.getTime()) && !isNaN(days)){
					date.setDate(date.getDate() + days);
					
					$("#end_date").val(date.toInputFormat());
				} else {
					$("#end_date").val('');  
				}
			});

			Date.prototype.toInputFormat = function() {
			   var yyyy = this.getFullYear().toString();
			   var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
			   var dd  = this.getDate().toString();
			   return yyyy + "-" + (mm[1]?mm:"0"+mm[0]) + "-" + (dd[1]?dd:"0"+dd[0]); // padding
			};
			
			function initDeleteLinks()
			{
				$('.contract_prices>table tr td>a').on('click', function(){
					$(this).closest('tr').remove();
					if(!$('.contract_prices>table tbody tr').length)
					{
						$('.contract_prices>table').hide();
						$('.contract_prices .alert').show();
					}
				});
			}
			
			function showHideXchangeRate()
			{
				if($('.add_contract_price select').val() == 1)
				{
					$('.add_contract_price input[name="rate"]').hide();
				}
				else
				{
					$('.add_contract_price input[name="rate"]').show();
				}				
			}
			
			function findExistingCurrency(curId)
			{
				var result = false;
				
				$(".contract_prices>table tbody tr").each(function(){							
					if($(this).find('input.curId').val() == curId)	
						result = true;
				});
				
				return result;
			}
			
			$('.add_contract_price a.btn').click(function(){
					var curId = $('.add_contract_price select').val();
					var amount = $('.add_contract_price input[name="amount"]').val();
					var xchange = ((curId == 1)? 1 : $('.add_contract_price input[name="rate"]').val());
					var curText = $('.add_contract_price select :selected').text();					
					var ugxAmount = addCommas((parseInt(xchange.toString().split(',').join("")) * parseInt(amount.split(',').join(""))));
					
					if(amount == '')
					{
						$('.add_contract_price').addClass('error');
						$('.add_contract_price .help-inline').html('Null amounts are not allowed');
					}
					else if(curId >1 && xchange == '')
					{
						$('.add_contract_price').addClass('error');
						$('.add_contract_price .help-inline').html('Please enter the exchange rate');
					}
					else if(findExistingCurrency(curId))
					{
						$('.add_contract_price').addClass('error');
						$('.add_contract_price .help-inline').html('An amount with the selected currency has already been added');
					}
					else
					{
						
						$('.add_contract_price').removeClass('error');
						$('.add_contract_price .help-inline').html('');
						$('.contract_prices>table').show();
						
						$('.contract_prices>table tbody').append('<tr><td style="text-align:center">'+
																 '<a title="Click to remove" href="javascript:void(0);">'+
																 '<i class="fa fa-remove"></i></a>'+
																 '<input type="hidden" name="contract_amount[]" value="'+amount+'__'+curId+'__'+xchange+'__'+curText+'" />'+
																 '</td>'+
																 '<td>'+amount+'</td>'+
																 '<td class="hidden-phone" style="font-size:11px"><strong>'+curText+'</strong></td>'+
																 '<td class="right-align-text hidden-phone">'+
																 '<input type="hidden" class="curId" value="'+curId+'" />'+
																 '<span class"number">'+xchange+'</span>'+
																 '</td><td style="text-align:right" class="right-align-text hidden-phone">'+
																 '<span class"number">'+ugxAmount+'</span></td></tr>');
																 
						$('.add_contract_price input[name="amount"]').val('');
						$('.add_contract_price input[name="rate"]').val('');
						$('.contract_prices .alert').hide();
						initDeleteLinks();
					}
				});
								
				
				$('.add_contract_price select').change(showHideXchangeRate);
				
				showHideXchangeRate();
				
				initDeleteLinks();
							
		})(jQuery, this, document);
	</script>