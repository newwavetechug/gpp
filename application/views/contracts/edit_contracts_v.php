<div class="widget">
    <div class="widget-title">
        <h4><i class="icon-reorder"></i>&nbsp;<?=(!empty($form_title)? $form_title : 'Contract Details') ?></h4>
            <span class="tools">
                <a href="javascript:;" class="icon-chevron-down"></a>
                <a href="javascript:;" class="icon-remove"></a>
            </span>																	
    </div>
    
     <!-- BEGIN FORM-->
     <form action="<?=base_url() . 'contracts/edit_awarded_contract' . ((!empty($i))? '/i/'.$i : '' )?>" enctype="multipart/form-data" method="post" class="form-horizontal">
    <div class="widget-body">
    <!-- Procurement Record view -->
    <div class="widget-title">
        <h4><i class="icon-reorder"></i>&nbsp;Procurement Record</h4>
    </div>
    
     <dl class="dl-horizontal">
        <div class="control-group">
            <label class="control-label">Procurement Ref. No <span>*</span></label>
            <div class="controls">
                <select id="procurement-ref-no" class="input-large m-wrap chosen" name="prefid" tabindex="1">
                    <?=get_select_options($procurement_plan_entries, 'procurement_ref_no', 'procurement_ref_no', (!empty($formdata['procurement_ref_no'])? $formdata['procurement_ref_no'] : '' ))?>
                </select>
            </div>
        </div>
          
          <div id="procurement_plan_details">
			  <?php if(!empty($formdata['procurement_details'])): ?>
              <?php $procurement_details = $formdata['procurement_details']; ?>
                  <div class="control-group">
                      <label class="control-label">Financial Year:</label>
                      <div class="controls">
                          <?=(!empty($procurement_details['financial_year'])? $procurement_details['financial_year'] : '<i>undefined</i>')?>
                          <input type="hidden" name="procurement_details[financial_year]" value="<?=$procurement_details['financial_year']?>" />
                      </div>
                  </div>
                  <div class="control-group">
                      <label class="control-label">Type of Procurement:</label>
                      <div class="controls">
                          <?=(!empty($procurement_details['procurement_type'])? $procurement_details['procurement_type'] : '<i>undefined</i>')?>
                          <input type="hidden" name="procurement_details[procurement_type]" value="<?=$procurement_details['procurement_type']?>" />
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
                      <label class="control-label">Department:</label>
                      <div class="controls">[department]</div>
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
    </dl>
    <!-- End Procurement Record view -->

    <br />

    <!-- Provider view -->
    <div class="widget-title">
        <h4><i class="icon-reorder"></i>&nbsp;Provider Details</h4>
    </div>

     <dl class="dl-horizontal">
        <dt>Name of Provider</dt>
        <dd> New Wave Technologies Company Ltd.</dd>
        <dd> 
            <div class="accordion-group">
                <div class="accordion-heading">
                    <a href="#collapse_3" data-parent="#accordion1" data-toggle="collapse" class="accordion-toggle collapsed">
                        <i class=" icon-plus"></i>
                        More provider details
                    </a>
                </div>
                <div class="accordion-body collapse" id="collapse_3">
                    <div class="accordion-inner">
                        <dl class="dl-horizontal">
                            <dt>Company Address</dt>
                            <dd>128 Old Kira Road.</dd>
                            <dd>Level 3, Kamure Building.</dd>
                            <dt>Company Contact</dt>
                            <dd>+256 41 4389 220. </dd>
                            <dt>Company Email</dt>
                            <dd>info@newwavetech.co.ug.</dd>
                            <dt>Company Website</dt>
                            <dd>www.newwavetech.co.ug.</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </dd>
    </dl>
    <!-- End Provider view -->

    <br />

    <!-- Contract award details -->
    <div class="widget-title">
        <h4><i class="icon-reorder"></i>&nbsp;Contract award details</h4>
    </div><br />
    
     
        <div class="control-group">
            <label class="control-label">Was the procurement subjected to
administrative review? <span>*</span></label>
		 <div class="controls">
            	<label class="radio">
                	<div class="radio" id="uniform-undefined">
                    	<input type="radio" name="optionsRadios1" required value="Y" <?=((!empty($formdata['optionsRadios1']) && $formdata['optionsRadios1'] == 'Y')? 'checked' : '' )?> />
                    </div>
                    Yes
                </label>
                <label class="radio">
                	<div class="radio" id="uniform-undefined">
                    	<input type="radio" checked="" name="optionsRadios1" required value="N" <?=(((!empty($formdata['optionsRadios1']) && $formdata['optionsRadios1'] == 'N') || empty($formdata['optionsRadios1']))? 'checked' : '' )?> />
                    </div>
                    No
                </label>
          	</div>

        </div>
        <div class="control-group">
            <label class="control-label">Date of SG approval if above UGX 200,000,000: </label>
            <div class="controls">
            	<div class="input-append date date-picker" data-date="2015-01-01" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
					<input name="sgapproval" data-date="2015-01-01" data-date-format="yyyy-mm-dd" data-date-viewmode="days" class="m-ctrl-medium date-picker"  type="text" value="<?=(!empty($formdata['date_of_sg_approval'])? $formdata['date_of_sg_approval'] : '' )?>">
					<span class="add-on"><i class="icon-calendar"></i></span>
				</div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Final award notice date: <span>*</span></label>
            <div class="controls">
            	<div class="input-append date date-picker" data-date="2015-01-01" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
					<input name="awardnotice" data-date="2015-01-01" data-date-format="yyyy-mm-dd" data-date-viewmode="days" class="m-ctrl-medium date-picker"  type="text" value="<?=(!empty($formdata['final_award_notice_date'])? $formdata['final_award_notice_date'] : '' )?>">
					<span class="add-on"><i class="icon-calendar"></i></span>
				</div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Date of commencement of
contract: <span>*</span></label>
            <div class="controls">
            	<div class="input-append date date-picker" data-date="2015-01-01" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
					<input name="commencedate" data-date="2015-01-01" data-date-format="yyyy-mm-dd" data-date-viewmode="days" class="m-ctrl-medium date-picker"  type="text" value="<?=(!empty($formdata['commencement_date'])? $formdata['commencement_date'] : '' )?>">
					<span class="add-on"><i class="icon-calendar"></i></span>
				</div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Planned date of contract
completion: <span>*</span></label>
            <div class="controls">
            	<div class="input-append date date-picker" data-date="2015-01-01" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
					<input name="datecompletion" data-date="2015-01-01" data-date-format="yyyy-mm-dd" data-date-viewmode="days" class="m-ctrl-medium date-picker"  type="text" value="<?=(!empty($formdata['completion_date'])? $formdata['completion_date'] : '' )?>">
					<span class="add-on"><i class="icon-calendar"></i></span>
				</div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Contract amount: <span>*</span></label>
            <div class="controls">
                <input type="text" name="amount" value="<?=(!empty($formdata['contract_amount'])? $formdata['contract_amount'] : '' )?>" class="input-xlarge" required/>
                
                <select class="input-large m-wrap" name="currency" required>
                    <option> --Select currency-- </option>
                    <option value="UGX" <?=((!empty($formdata['amount_currency']) && $formdata['amount_currency'] =='UGX')? 'selected="selected"' : '' )?> >UGX</option>
                    <option value="USD" <?=((!empty($formdata['amount_currency']) && $formdata['amount_currency'] =='USD')? 'selected="selected"' : '' )?> >USD</option>
                </select>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" name="save" value="save" class="btn blue"><i class="icon-ok"></i> Edit contract</button>
            <button type="reset" name="cancel" value="cancel" class="btn"><i class="icon-remove"></i> Cancel</button>
        </div>
    </form>
    <!-- END FORM-->

     
    <!-- End contract award view -->
</div>