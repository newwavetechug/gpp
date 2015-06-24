<? if(empty($requiredfields)) $requiredfields = array();?>
<style>
.subject_of_procurement { display: none; }
</style>
<script type="text/javascript">
    $(function(){
      var refid = 0;
      console.log("RECORD IS" + refid);
    
       // if(refid > 0)
       // {
          //   console.log(refid);
           // $("#procurementref-no").val().trigger('change');
     
       // }
          
      //  $(".alert").fadeOut
        $("#quantityifb").change(function(){
            var quantityifb = this.value;
            var procurement_details_quantity = $("#procurement_details_quantity").val();
            chekcer(procurement_details_quantity,quantityifb);
           
                       

        });

        $("#bidinv").submit(function(event)
        {
             var quantityifb = $("#quantityifb").val();              
             var procurement_details_quantity = $("#procurement_details_quantity").val();
             chekcer(procurement_details_quantity,quantityifb);

             if(pass == 0)
             event.preventDefault();
        });

        function chekcer(procurement_details_quantity,quantityifb){
            //alert('pass');
             $(".alert").fadeOut('slow');
            str = '';
              var diff = procurement_details_quantity - quantityifb;
                if( diff >= 0 )
                {
                    //alert('pass');
                    pass = 1;
                }
                else
                {
                   // alert('fail');

                     str = "IFB Quantity Can Not Be Greater than Quantity Available for Procurement Entry"
                    

                    
                      $(".alert").fadeIn('slow');
                      $(".alert").html(str);
                      console.log(str);
                      pass = 0; 
                      $('html, body').animate({scrollTop : 0},800);
                }
        }
    })
</script>
<div class="widget">
    <div class="widget-title">
        <h4><i class="fa fa-reorder"></i>&nbsp;<?=(!empty($form_title)? $form_title : '') ?></h4>
            <span class="tools">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
                <a href="javascript:;" class="fa fa-remove"></a>
            </span>
    </div>
    <div class="widget-body">
        <?php 
            if(empty($procurement_plan_entries)): 
                print format_notice('WARNING: There are no procurement entries available for bid invitation');
            else: 
        ?>            
            <!-- BEGIN FORM-->
            <form  id="bidinv" action="<?=base_url() . 'bids/save_bid_invitation' . ((!empty($i))? '/i/'.$i : '' )?>" enctype="multipart/form-data" method="post" class="form-horizontal">
                <div class="form_details">
                    <div class="control-group <?=(in_array('procurement_id', $requiredfields)? 'error': '')?>">
                        <label class="control-label">Subject of procurement<span>*</span></label>
                        <div class="controls">

                              <select id="procurementref-no" class="input-xlarge m-wrap chosen prid" name="procurement_id" tabindex="1">
                                <?=get_select_options($procurement_plan_entries, 'procurement_id', 'subject_of_procurement', (!empty($formdata['procurement_id'])? $formdata['procurement_id'] : '' ))?>
                            </select>
                            <?php 
                            if(!empty($formdata['procurement_id']))
                            {
                                ?>
                           
                            <script>
                            $(function(){

                                  $(".prid").val("<?=$formdata['procurement_id']; ?>").trigger('change');

                                console.log('...');
                             })
                           
                            </script>
                              <?php } ?>
                            <?=(in_array('procurement_ref_no', $requiredfields)? '<span class="help-inline">Please select a procurement reference number</span>': '')?>
                        </div>
                    </div>
                    <div id="procurement_plan_details">
                    <?php
                  #  print_r($formdata);
                    ?>
                        <?php if(!empty($formdata['procurement_details'])): ?>
                        <?php $procurement_details = $formdata['procurement_details']; ?>
                            <div class="control-group  subject_of_procurement">
                                <label class="control-label">Subject of procurement:</label>
                                <div class="controls">
                                    <?=(!empty($procurement_details['subject_of_procurement'])? $procurement_details['subject_of_procurement'] : '<i>undefined</i>')?>
                                    <input type="hidden" name="procurement_details[subject_of_procurement]" value="<?=$procurement_details['subject_of_procurement']?>" />
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label">Source of Funding:</label>
                                <div class="controls">
                                    <?=(!empty($procurement_details['funding_source'])? $procurement_details['funding_source'] : '<i>undefined</i>')?>
                                    <input type="hidden" name="procurement_details[funding_source]" value="<?=$procurement_details['funding_source']?>" />
                                </div>
                            </div>
<?php

#print_r($procurement_details);

                    if(!empty($procurement_details_quantity)){
                      // $total_ifb_q = $procurement_details['quantity'] - $procurement_details['total_ifb_quantity'];
    
    ?>
                               <div class="control-group">
                                <label class="control-label">Quantity :</label>
                                <div class="controls">
                                    <?=(!empty($procurement_details_quantity)? $procurement_details_quantity : '<i>undefined</i>')?>
                                    <input type="hidden"  id="procurement_details_quantity" name="procurement_details_quantity" value="<?=$procurement_details_quantity; ?>" />
                                </div>
                            </div>

<?php }
?>
                            <div class="control-group">
                                <label class="control-label">Method of procurement:</label>
                                <div class="controls">
                                    <?=(!empty($procurement_details['procurement_method'])? $procurement_details['procurement_method'] : '<i>undefined</i>')?>
                                    <input type="hidden" name="procurement_details[procurement_method]" value="<?=$procurement_details['procurement_method']?>" />
                                </div>
                            </div>
                        
                            <div class="control-group">
                                <label class="control-label">Financial Year:</label>
                                <div class="controls">
                                    <?=(!empty($procurement_details['financial_year'])? $procurement_details['financial_year'] : '<i>undefined</i>')?>
                                    <input type="hidden" name="procurement_details[financial_year]" value="<?=$procurement_details['financial_year']?>" />
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label">Method of Procurement:</label>
                                <div class="controls">
                                    <?=(!empty($procurement_details['procurement_method'])? $procurement_details['procurement_method'] : '<i>undefined</i>')?>
                                    <input type="hidden" name="procurement_details[procurement_method]" value="<?=$procurement_details['procurement_method']?>" />
                                </div>
                            </div>                           
                         <?php endif; ?>
                    </div>
                    <hr/>
                    
                    <div class="control-group <?=(in_array('procurement_ref_no', $requiredfields)? 'error': '')?>">
                        <label class="control-label">Procurement reference number:<span>*</span></label>
                        <div class="controls">
                        <?php
                        if(!empty($formdata['procurement_ref_no'])){
                        $dataarray = explode("/", $formdata['procurement_ref_no']);
                        $formdata['sequencenumber'] =  $dataarray[0]."/". $dataarray[1]."/". $dataarray[2]."/";
                        $formdata['procurement_ref_no'] = $dataarray[3];
                      # print_r($formdata['procurement_ref_no']);
                       }

                        ?>
                         <input type="text" name="sequencenumber" id="sequencenumber" value="<?=(!empty($formdata['sequencenumber'])? $formdata['sequencenumber'] : '' )?>" class="input-large " readonly />
                     
                            <input type="text" name="procurement_ref_no" id="procurement_ref_no" value="<?=(!empty($formdata['procurement_ref_no'])? $formdata['procurement_ref_no'] : '' )?>" class="input-large" />
                        </div>
                    </div>
                    <!-- Budgtet COde -->
                    <div class="control-group <?=(in_array('vote_no', $requiredfields)? 'error': '')?>">
                        <label class="control-label">Budget code:<span>*</span></label>
                        <div class="controls">
                            <input type="text" name="vote_no" value="<?=(!empty($formdata['vote_no'])? $formdata['vote_no'] : '' )?>" class="input-medium" />
                        </div>
                    </div>

                    <!-- Initiated By -->
                    <div class="control-group <?=(in_array('initiated_by', $requiredfields)? 'error': '')?>">
                        <label class="control-label">Initiated by:<span>*</span></label>
                        <div class="controls">
                            <input type="text" name="initiated_by" value="<?=(!empty($formdata['initiated_by'])? $formdata['initiated_by'] : '' )?>" class="input-medium" />
                        </div>
                    </div>

                    <!-- Quantity Bidded   -->
                    <div class="control-group <?=(in_array('quantityifb', $requiredfields)? 'error': '')?>">
                        <label class="control-label">Quantity :<span>*</span></label>
                        <div class="controls">
                            <input type="text" id="quantityifb" name="quantityifb" value="<?=(!empty($formdata['quantityifb'])? $formdata['quantityifb'] : '0' )?>" class="input-medium" />
                        </div>
                    </div>

                    <!-- Date Initiated -->
                    <div class="control-group <?=(in_array('date_initiated', $requiredfields)? 'error': '')?>">
                        <label class="control-label">Date initiated:<span>*</span></label>
                        <div class="controls">
                            <div class="input-append date date-picker" data-date="<?=(!empty($formdata['date_initiated'])? custom_date_format('Y-m-d', $formdata['date_initiated']) : date('Y-m-d'))?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
                                <input name="date_initiated" data-date="<?=(!empty($formdata['date_initiated'])? custom_date_format('Y-m-d', $formdata['date_initiated']) : date('Y-m-d'))?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days" class="m-ctrl-medium date-picker"  type="text" value="<?=(!empty($formdata['date_initiated'])? custom_date_format('Y-m-d', $formdata['date_initiated']) : '' )?>">
                                <span class="add-on">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="control-group <?=(in_array('bid_documents_price', $requiredfields)? 'error': '')?>">
                        <label class="control-label">Price of bidding documents:</label>
                        <div class="controls">
                            <input type="text" name="bid_documents_price" value="<?=(!empty($formdata['bid_documents_price'])? addCommas($formdata['bid_documents_price'], 0) : '' )?>" class="input-medium numbercommas" />
                            <select id="bid-documents-currency" class="input-small m-wrap" name="bid_documents_currency">
                            <?=get_select_options($currencies, 'id', 'title', (!empty($formdata['bid_documents_currency'])? $formdata['bid_documents_currency'] : 1 ))?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group <?=(in_array('bid_security', $requiredfields)? 'error': '')?>">
                        <label class="control-label">Bid security:</label>
                        <div class="controls">
                            <input type="text" name="bid_security_amount" value="<?=(!empty($formdata['bid_security_amount'])? addCommas($formdata['bid_security_amount'], 0) : '' )?>" class="input-medium numbercommas" />
                            <select id="bid-security-currency" class="input-small m-wrap" name="bid_security_currency">
                                <?=get_select_options($currencies, 'id', 'title', (!empty($formdata['bid_security_currency'])? $formdata['bid_security_currency'] : 1 ))?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group <?=(in_array('invitation_to_bid_date', $requiredfields)? 'error': '')?>">
                        <label class="control-label">Invitation to bid date:<span>*</span></label>
                        <div class="controls">
                            <div class="input-append date date-picker" data-date="<?=(!empty($formdata['invitation_to_bid_date'])? custom_date_format('Y-m-d', $formdata['invitation_to_bid_date']) : date('Y-m-d') )?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
                                <input name="invitation_to_bid_date" data-date="<?=(!empty($formdata['invitation_to_bid_date'])? custom_date_format('Y-m-d', $formdata['invitation_to_bid_date']) : date('Y-m-d') )?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days" class="m-ctrl-medium date-picker"  type="text" value="<?=(!empty($formdata['invitation_to_bid_date'])? custom_date_format('Y-m-d', $formdata['invitation_to_bid_date']) : '' )?>">
                                <span class="add-on">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="control-group <?=(in_array('pre_bid_meeting_date', $requiredfields)? 'error': '')?>">
                        <label class="control-label">Pre-bid meeting date: <span>*</span></label>
                        <div class="controls">
                            <div class="input-append date date-picker" data-date="<?=(!empty($formdata['pre_bid_meeting_date'])? custom_date_format('Y-m-d', $formdata['pre_bid_meeting_date']) : date('Y-m-d') )?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
                                <input name="pre_bid_meeting_date" data-date="<?=(!empty($formdata['pre_bid_meeting_date'])? custom_date_format('Y-m-d', $formdata['pre_bid_meeting_date']) : date('Y-m-d') )?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days" class=" m-ctrl-medium date-picker" type="text" value="<?=(!empty($formdata['pre_bid_meeting_date'])? custom_date_format('Y-m-d', $formdata['pre_bid_meeting_date']) : '' )?>" />
                                <span class="add-on"><i class="fa fa-calendar"></i></span>
                            </div>
                            <div class="input-append bootstrap-timepicker-component">
                                <input name="pre_bid_meeting_date_time" class="input-mini m-ctrl-small timepicker-default" value="<?=(!empty($formdata['pre_bid_meeting_date_time'])? $formdata['pre_bid_meeting_date_time'] : (!empty($formdata['pre_bid_meeting_date'])? custom_date_format('h:i A', $formdata['pre_bid_meeting_date']) : '' ) )?>" type="text" />
                                <span class="add-on"><i class="fa fa-clock-o"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="control-group <?=(in_array('bid_submission_deadline', $requiredfields)? 'error': '')?>">
                        <label class="control-label">Deadline of bid submission:<span>*</span></label>
                        <div class="controls">
                            <div class="input-append date date-picker" data-date="<?=(!empty($formdata['bid_submission_deadline'])? custom_date_format('Y-m-d', $formdata['bid_submission_deadline']) : date('Y-m-d') )?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
                                <input name="bid_submission_deadline" data-date="<?=(!empty($formdata['bid_submission_deadline'])? custom_date_format('Y-m-d', $formdata['bid_submission_deadline']) : date('Y-m-d') )?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days" class=" m-ctrl-medium date-picker" type="text" value="<?=(!empty($formdata['bid_submission_deadline'])? custom_date_format('Y-m-d', $formdata['bid_submission_deadline']) : '' )?>" />
                                <span class="add-on"><i class="fa fa-calendar"></i></span>
                            </div>
                            <div class="input-append bootstrap-timepicker-component">
                                <input name="bid_submission_deadline_time" class="input-mini m-ctrl-small timepicker-default" value="<?=(!empty($formdata['bid_submission_deadline_time'])? $formdata['bid_submission_deadline_time'] : (!empty($formdata['bid_submission_deadline'])? custom_date_format('h:i A', $formdata['bid_submission_deadline']) : '' ) )?>" type="text" />
                                <span class="add-on"><i class="fa fa-clock-o"></i></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="control-group <?=(in_array('documents_inspection_address', $requiredfields)? 'error': '')?>">
                        <label class="control-label">Address where documents will be inspected:<span>*</span></label>
                        <div class="controls">
                            <textarea rows="3" name="documents_inspection_address" id="documents_inspection_address" class="input-xxlarge"><?=(!empty($formdata['documents_inspection_address'])? $formdata['documents_inspection_address'] : '' )?></textarea>
                        </div>
                    </div>
                    
                    <div class="control-group <?=(in_array('documents_address_issue', $requiredfields)? 'error': '')?>">
                        <label class="control-label">Address  where documents will be issued:<span>*</span></label>
                        <div class="controls">
                            <textarea rows="3" name="documents_address_issue" id="documents_address_issue" class="input-xxlarge"><?=(!empty($formdata['documents_address_issue'])? $formdata['documents_address_issue'] : '' )?></textarea>
                            <span>
                            <input type="checkbox" name="same_as_above" id="same_as_inspection" value="same" />
                            <label for="same_as_inspection" style="display:inline">
                                Tick if same as above or state
                            </label>
                            </span>
                        </div>
                    </div>
                    
                    <div class="control-group <?=(in_array('bid_receipt_address', $requiredfields)? 'error': '')?>">
                        <label class="control-label">Address bids must be delivered to:<span>*</span></label>
                        <div class="controls">
                            <textarea rows="3" name="bid_receipt_address" id="bid_receipt_address" class="input-xxlarge"><?=(!empty($formdata['bid_receipt_address'])? $formdata['bid_receipt_address'] : '' )?></textarea>
                            <span>
                            <input type="checkbox" name="same_as_above" id="same_as_issue" value="same" />
                            <label for="same_as_issue" style="display:inline">
                                Tick if same as above or state
                            </label>
                            </span>
                        </div>
                    </div>
                    
                    <div class="control-group <?=(in_array('bid_openning_address', $requiredfields)? 'error': '')?>">
                        <label class="control-label">Bid opening address:<span>*</span></label>
                        <div class="controls">
                            <textarea rows="3" name="bid_openning_address" id="bid_openning_address" class="input-xxlarge"><?=(!empty($formdata['bid_openning_address'])? $formdata['bid_openning_address'] : '' )?></textarea>
                            <span>
                            <input type="checkbox" name="same_as_above" id="same_as_deliver" value="same" />
                            <label for="same_as_deliver" style="display:inline">
                                Tick if same as above or state
                            </label>
                            </span>
                        </div>
                    </div>
                    
                    <div class="control-group <?=(in_array('bid_openning_date', $requiredfields) || in_array('bid_openning_date_time', $requiredfields)? 'error': '')?>">
                        <label class="control-label">Bid opening date:<span>*</span></label>
                        <div class="controls">
                            <div class="input-append date date-picker" data-date="<?=(!empty($formdata['bid_openning_date'])? custom_date_format('Y-m-d', $formdata['bid_openning_date']) : date('Y-m-d') )?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
                                <input name="bid_openning_date" data-date="<?=(!empty($formdata['bid_openning_date'])? custom_date_format('Y-m-d', $formdata['bid_openning_date']) : date('Y-m-d') )?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days" class=" m-ctrl-medium date-picker" type="text" value="<?=(!empty($formdata['bid_openning_date'])? custom_date_format('Y-m-d', $formdata['bid_openning_date']) : '' )?>" />
                                <span class="add-on"><i class="fa fa-calendar"></i></span>
                            </div>
                            <div class="input-append bootstrap-timepicker-component">
                                <input name="bid_openning_date_time" class="input-mini m-ctrl-small timepicker-default" value="<?=(!empty($formdata['bid_openning_date_time'])? $formdata['bid_openning_date_time'] : (!empty($formdata['bid_openning_date'])? custom_date_format('h:i A', $formdata['bid_openning_date']) : '' ) )?>" type="text" />
                                <span class="add-on"><i class="fa fa-clock-o"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="control-group <?=(in_array('bid_evaluation_from', $requiredfields) || in_array('bid_evaluation_to', $requiredfields)? 'error': '')?>">
                        <label class="control-label">Bid evaluation period:<span>*</span></label>
                        <div class="controls">
                            <div class="input-append date date-picker" data-date="<?=(!empty($formdata['bid_evaluation_from'])? custom_date_format('Y-m-d', $formdata['bid_evaluation_from']) : date('Y-m-d') )?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
                                <input name="bid_evaluation_from" data-date="<?=(!empty($formdata['bid_evaluation_from'])? custom_date_format('Y-m-d', $formdata['bid_evaluation_from']) : date('Y-m-d') )?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days" placeholder="From" class="m-ctrl-medium date-picker" type="text" value="<?=(!empty($formdata['bid_evaluation_from'])? custom_date_format('Y-m-d', $formdata['bid_evaluation_from']) : '' )?>" />
                                <span class="add-on"><i class="fa fa-calendar"></i></span>
                            </div>
                            <div class="input-append date date-picker" data-date="<?=(!empty($formdata['bid_evaluation_to'])? custom_date_format('Y-m-d', $formdata['bid_evaluation_to']) : date('Y-m-d') )?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
                                <input name="bid_evaluation_to"  placeholder="To" data-date="<?=(!empty($formdata['bid_evaluation_to'])? custom_date_format('Y-m-d', $formdata['bid_evaluation_to']) : date('Y-m-d') )?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days" class="m-ctrl-medium date-picker" type="text" value="<?=(!empty($formdata['bid_evaluation_to'])? custom_date_format('Y-m-d', $formdata['bid_evaluation_to']) : '' )?>" />
                                <span class="add-on"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>         
                    
                    <div class="control-group <?=(in_array('contract_award_date', $requiredfields)? 'error': '')?>">
                        <label class="control-label">Contract award date:<span>*</span></label>
                        <div class="controls">
                            <div class="input-append date date-picker" data-date="<?=(!empty($formdata['contract_award_date'])? custom_date_format('Y-m-d', $formdata['contract_award_date']) : date('Y-m-d') )?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
                                <input name="contract_award_date" data-date="<?=(!empty($formdata['contract_award_date'])? custom_date_format('Y-m-d', $formdata['contract_award_date']) : date('Y-m-d') )?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days" class="m-ctrl-medium date-picker" type="text" value="<?=(!empty($formdata['contract_award_date'])? custom_date_format('Y-m-d', $formdata['contract_award_date']) : '' )?>" />
                                <span class="add-on"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                           
                    <div class="control-group <?=(in_array('display_of_beb_notice', $requiredfields)? 'error': '')?>">
                        <label class="control-label">Display of BEB notice:<span>*</span></label>
                        <div class="controls">
                            <div class="input-append date date-picker" data-date="<?=(!empty($formdata['display_of_beb_notice'])? custom_date_format('Y-m-d', $formdata['display_of_beb_notice']) : date('Y-m-d') )?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
                                <input name="display_of_beb_notice" data-date="<?=(!empty($formdata['display_of_beb_notice'])? custom_date_format('Y-m-d', $formdata['display_of_beb_notice']) : date('Y-m-d') )?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days" class=" m-ctrl-medium date-picker" type="text" value="<?=(!empty($formdata['display_of_beb_notice'])? custom_date_format('Y-m-d', $formdata['display_of_beb_notice']) : '' )?>" />
                                <span class="add-on"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div> 

                     <div class="control-group <?=(in_array('display_of_beb_notice', $requiredfields)? 'error': '')?>">
                        <label class="control-label">Date of Confirmation of funds by Accounting Officer:<span>*</span></label>
                        <div class="controls">
                            <div class="input-append date date-picker" data-date="<?=(!empty($formdata['dateofconfirmationbyao'])? custom_date_format('Y-m-d', $formdata['dateofconfirmationbyao']) : date('Y-m-d') )?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
                                <input name="dateofconfirmationbyao" data-date="<?=(!empty($formdata['dateofconfirmationbyao'])? custom_date_format('Y-m-d', $formdata['dateofconfirmationbyao']) : date('Y-m-d') )?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days" class=" m-ctrl-medium date-picker" type="text" value="<?=(!empty($formdata['dateofconfirmationbyao'])? custom_date_format('Y-m-d', $formdata['dateofconfirmationbyao']) : '' )?>" />
                                <span class="add-on"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div> 

<!-- bid validity period -->
<script type="text/javascript">
    $(function(){
        $(".bidvalidity_q").click(function(){
           
          if($(this).is(':checked'))
            {
            $(".bidvalidatey").removeClass('hidden');   
            $(this).val('y');      
            }
            else
            {
           $(".bidvalidatey").addClass('hidden'); 
              $(this).val('n');    
            }
        })
    })
</script>
                <div class="control-group">
                        <label class="control-label"> Does it have bid validity ? <span></span></label>
                        <div class="controls">
                        <input type="checkbox" value="n" name="hasbidvalididy" class="bidvalidity_q"/>
                        </div>
                    </div> 

<!-- end of validity period -->
<!-- bid validity period -->
                <div class="control-group  bidvalidatey  hidden">
                        <label class="control-label"> Date </label>
                        <div class="controls">
                         <div class="input-append date date-picker" data-date="<?=(!empty($formdata['bidvalidtity'])? custom_date_format('Y-m-d', $formdata['bidvalidtity']) : date('Y-m-d') )?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
                                <input name="bidvalidtity" data-date="<?=(!empty($formdata['bidvalidtity'])? custom_date_format('Y-m-d', $formdata['bidvalidtity']) : date('Y-m-d') )?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days" class=" m-ctrl-medium date-picker" type="text" value="<?=(!empty($formdata['bidvalidtity'])? custom_date_format('Y-m-d', $formdata['bidvalidtity']) : '' )?>" />
                                <span class="add-on"><i class="fa fa-calendar"></i></span>
                            </div>
                            
                     <!--     <input name="bidvalidtity"  placeholder="Days" class="input-large" value="0" type="text" />
                   -->       </div>
                    </div> 

<!-- end of validity period -->


                <div class="form-actions">
                    <button type="button" name="cancel" value="cancel" class="btn"><i class="fa fa-remove"></i> Cancel</button>
                    <button type="submit" name="save" value="save" class="btn blue"><i class="fa fa-ok"></i> Save</button>
                    <button type="submit" name="approve" value="approve" class="btn blue"><i class="fa fa-file"></i> Publish IFB</button>
                </div>
            </form>
            <!-- END FORM-->    
        <?php endif; ?>
        
    </div>
</div>