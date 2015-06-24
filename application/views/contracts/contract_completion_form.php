<? if(empty($requiredfields)) $requiredfields = array();?>
<div class="widget">
    <div class="widget-title">
        <h4><i class="icon-reorder"></i>&nbsp;<?=(!empty($form_title)? $form_title : 'User details') ?></h4>
            <span class="tools">
                <a href="javascript:;" class="icon-chevron-down"></a>
                <a href="javascript:;" class="icon-remove"></a>
            </span>
    </div>
    <div class="widget-body">
        <!-- BEGIN FORM-->
        <form id="contract-completion-form" action="<?=base_url() . 'contracts/complete_contract' . ((!empty($c))? '/c/'.$c : '' ) . ((!empty($i))? '/i/'.$i : '' )?>" enctype="multipart/form-data" method="post" class="form-horizontal">
            	<div class="control-group">
                    <label class="control-label">Procurement Ref. No <span>*</span></label>
                    <div class="controls">
                    	<?=(!empty($procurement_details['procurement_ref_no'])? $procurement_details['procurement_ref_no'] : '' )?>
                    </div>
                </div>
                <div id="procurement_plan_details">
                    <div class="control-group">
                        <label class="control-label">Financial Year:</label>
                        <div class="controls">
                            <?=(!empty($procurement_details['financial_year'])? $procurement_details['financial_year'] : '<i>undefined</i>')?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Type of Procurement:</label>
                        <div class="controls">
                            <?=(!empty($procurement_details['procurement_type'])? $procurement_details['procurement_type'] : '<i>undefined</i>')?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Method of Procurement:</label>
                        <div class="controls">
                            <?=(!empty($procurement_details['procurement_method'])? $procurement_details['procurement_method'] : '<i>undefined</i>')?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Department:</label>
                        <div class="controls">[department]</div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Source of Funding:</label>
                        <div class="controls">
                            <?=(!empty($procurement_details['funding_source'])? $procurement_details['funding_source'] : '<i>undefined</i>')?>
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="control-group">
                    <label class="control-label">Service provider:</label>
                    <div class="controls">
                        <?=(!empty($contract_details['provider'])? $contract_details['provider'] : '<i>undefined</i>')?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Contract commencement date:</label>
                    <div class="controls">
                        <?=(!empty($contract_details['commencement_date'])? custom_date_format('d M, Y', $contract_details['commencement_date']) : '<i>undefined</i>')?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Planned contract completion date:</label>
                    <div class="controls">
                        <?=(!empty($contract_details['completion_date'])? custom_date_format('d M, Y', $contract_details['completion_date']) : '<i>undefined</i>')?>
                    </div>
                </div>
                <hr/>
<div class="control-group">
                    <label class="control-label">Final contract value:</label>
                    <div class="controls">
                        <input type="text" name="final_contract_value" value="<?=(!empty($formdata['final_contract_value'])? addCommas($formdata['final_contract_value'], 0) : '' )?>" class="input-medium numbercommas" />
                        <select id="final_contract_value_currency" class="input-small m-wrap" name="final_contract_value_currency">
                            <?=get_select_options($currencies, 'id', 'title', (!empty($formdata['final_contract_value_currency'])? $formdata['final_contract_value_currency'] : 1 ))?>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Was there advance payment?:</label>
                    <div class="controls">
                        <select id="bid-documents-currency" class="input-small m-wrap" name="advance_payment">
                          <option value="" selected="selected">-Select-</option>
                          <option value="Y" <?=(!empty($formdata['advance_payment']) && $formdata['advance_payment'] =='Y'? 'selected="selected"' : '' )?>>Yes</option>
                          <option value="N" <?=(!empty($formdata['advance_payment']) && $formdata['advance_payment'] =='N'? 'selected="selected"' : '' )?>>No</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Date of advance payment:</label>
                    <div class="controls">
          <div class="input-append date date-picker" data-date="<?=(!empty($formdata['advance_payment_date']) && str_replace('-', '', $formdata['advance_payment_date'])>0? custom_date_format('Y-m-d', $formdata['advance_payment_date']) : date('Y-m-d') )?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
                            <input name="advance_payment_date" data-date="<?=(!empty($formdata['advance_payment_date']) && str_replace('-', '', $formdata['advance_payment_date'])>0? custom_date_format('Y-m-d', $formdata['advance_payment_date']) : date('Y-m-d') )?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days" class="m-ctrl-medium date-picker"  type="text" value="<?=(!empty($formdata['advance_payment_date']) && str_replace('-', '', $formdata['advance_payment_date'])>0? custom_date_format('Y-m-d', $formdata['advance_payment_date']) : '' )?>">
                            <span class="add-on">
                                <i class="fa fa-calendar"></i>
                            </span>
                        </div>
                  </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Total actual payments made: <span>*</span></label>
                    <div class="controls">
                      <input type="text" name="total_actual_payments" value="<?=(!empty($formdata['total_actual_payments'])? addCommas($formdata['total_actual_payments'], 0) : '' )?>" class="input-medium numbercommas" />
<select id="total_actual_payments_currency" class="input-small m-wrap" name="total_actual_payments_currency">
                                <?=get_select_options($currencies, 'id', 'title', (!empty($formdata['total_actual_payments_currency'])? $formdata['total_actual_payments_currency'] : 1 ))?>
                            </select>
                  </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Date of actual completion:<span>*</span></label>
                    <div class="controls">
          <div class="input-append date date-picker" data-date="<?=(!empty($formdata['actual_completion_date']) && str_replace('-', '', $formdata['actual_completion_date'])>0? custom_date_format('Y-m-d', $formdata['actual_completion_date']) : date('Y-m-d') )?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
                            <input name="actual_completion_date" data-date="<?=(!empty($formdata['actual_completion_date']) && str_replace('-', '', $formdata['actual_completion_date'])>0? custom_date_format('Y-m-d', $formdata['actual_completion_date']) : date('Y-m-d') )?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days" class="m-ctrl-medium date-picker"  type="text" value="<?=(!empty($formdata['actual_completion_date']) && str_replace('-', '', $formdata['actual_completion_date'])>0? custom_date_format('Y-m-d', $formdata['actual_completion_date']) : '' )?>">
                            <span class="add-on">
                                <i class="fa fa-calendar"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Performance rating of provider:<span>*</span></label>
                    <div class="controls">
                    	<input required="" value="<?php if(!empty($formdata['performance_rating'])) echo $formdata['performance_rating'];?>" id="performance_rating" name="performance_rating" type="text" class="">
                    </div>
                </div>
          <div class="control-group">
    <label class="control-label">Name of contract manager:<span>*</span></label>
                    <div class="controls">
                    	<input required="" value="<?php if(!empty($formdata['contract_manager'])) echo $formdata['contract_manager'];?>" id="contract_manager" name="contract_manager" type="text" class="">
                    </div>
                </div>
                                          
      <div class="form-actions">
                <button id="approve-bid-invitation" type="submit" name="save" value="save" class="btn green">
                	<i class="fa fa-ok"></i>Save
                </button>
                <button type="button" name="cancel" value="cancel" class="btn"><i class="fa fa-remove"></i> Cancel</button>
            </div>
        </form>
        <!-- END FORM-->
    </div>
</div>