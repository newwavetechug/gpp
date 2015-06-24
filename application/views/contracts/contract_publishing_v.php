<div class="widget">
     <!-- BEGIN FORM-->
     <form action="<?=base_url() . 'contracts/load_publish_form' . ((!empty($i))? '/i/'.$i : '' )?>" enctype="multipart/form-data" method="post" class="form-horizontal">
        <div class="widget-body">
        <!-- Procurement Record view -->
        <div class="widget-title">
            <h4><i class="icon-reorder"></i>&nbsp;Procurement Record</h4>
        </div>
        
        <dl class="dl-horizontal">
            <dt>Approved Procurement</dt>
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
                        <a href="#collapse_1" data-parent="#accordion1" data-toggle="collapse" class="accordion-toggle collapsed">
                            <i class=" icon-plus"></i>
                            More provider details
                        </a>
                    </div>
                    <div class="accordion-body collapse" id="collapse_1">
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
        </div>
        
        <div class="control-group">
            <label class="control-label">Date of commencement of contract:</label>
        </div>
        
        <div class="control-group">
            <label class="control-label">Planned date of contract completion:</label>
            <dl class="dl-horizontal">
                <dd> New Wave Technologies Company Ltd.</dd>
                <dd> 
                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a href="#collapse_4" data-parent="#accordion1" data-toggle="collapse" class="accordion-toggle collapsed">
                                <i class=" icon-plus"></i>
                                More provider details
                            </a>
                        </div>
                        <div class="accordion-body collapse" id="collapse_4">
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
        </div>
        
        <!-- Contract completion details -->
        <div class="widget-title">
            <h4><i class="icon-reorder"></i>&nbsp;Contract completion details</h4>
        </div><br />
        
        <div class="control-group">
            <label class="control-label">Final contract value: <span>*</span></label>
            <div class="controls">
            	<input type="text" name="contract_value" class="input-xlarge" required/>
                &nbsp;&nbsp;&nbsp;     <span style="font-size: 14px;font-weight: normal;">Currency</span>
                							    <select class="input-large m-wrap" name="contract_currency" required>
                                                	<option> --Select currency-- </option>
                                                    <option value="UGX">UGX</option>
                                                    <option value="USD">USD</option>
                                                </select>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Was there advance payment: <span>*</span></label>
            <div class="controls">
            	<label class="radio"></label>
                <input type="radio" required name="advance_payment" value="Y"/> Yes
                <label class="radio"></label>
                <input type="radio" required name="advance_payment" value="N"/> No
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Date of advance payment: <span>*</span></label>
            <div class="controls">
            	<div class="input-append date date-picker" data-date="2015-01-01" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
					<input name="advance_date" data-date="2015-01-01" data-date-format="yyyy-mm-dd" data-date-viewmode="days" class="m-ctrl-medium date-picker" type="text">
					<span class="add-on"><i class="icon-calendar"></i></span>
				</div>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Total actual payments up to the end of the reporting period: <span>*</span></label>
            <div class="controls">
                <input type="text" name="pay_amount" class="input-xlarge" required/>&nbsp;&nbsp;&nbsp;     <span style="font-size: 14px;font-weight: normal;">Currency</span>
                							    <select class="input-large m-wrap" name="actual_currency" required>
                                                	<option> --Select currency-- </option>
                                                    <option value="UGX">UGX</option>
                                                    <option value="USD">USD</option>
                                                </select>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Date of actual completion: <span>*</span></label>
            <div class="controls">
            	<div class="input-append date date-picker" data-date="2015-01-01" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
					<input name="actual_completion" data-date="2015-01-01" data-date-format="yyyy-mm-dd" data-date-viewmode="days" class="m-ctrl-medium date-picker"  type="text">
					<span class="add-on"><i class="icon-calendar"></i></span>
				</div>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Comment on performance rating of provider: <span>*</span></label>
            <div class="controls">
                <select class="input-large m-wrap" name="comment" required>
                    <option> --Select-- </option>
                    <option>Satisfactory</option>
                    <option>Unsatisfactory</option>
                    <option>Other</option>
                </select>
            </div>
        </div>
        
        <!-- Contract management details -->
        <div class="widget-title">
            <h4><i class="icon-reorder"></i>&nbsp;Contract management details</h4>
        </div><br />
        
        <div class="control-group">
            <label class="control-label">Name of contract manager: <span>*</span></label>
            <div class="controls">
                <input type="text" name="manager" class="input-xlarge" required/>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Performance Security ?: <span>*</span></label>
            <div class="controls">
            	<input type="file" name="performance_security" class="default" required />
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Reference no. of commencement letter: <span>*</span></label>
            <div class="controls">
                <input type="text" name="ref_no_letter" class="input-xlarge" required/>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Upload commencement letter: <span>*</span></label>
            <div class="controls">
                <input type="file" name="commencement_letter" class="default" required />
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Implementation plan: <span>*</span></label>
            <div class="controls">
                <input type="file" name="implementation_plan" class="default" required />
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Contract progress report: <span>*</span></label>
            <div class="controls">
                <input type="file" name="progress_report" class="default" required />
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" name="save" value="save" class="btn blue"><i class="icon-ok"></i> Save</button>
            <button type="reset" name="cancel" value="cancel" class="btn"><i class="icon-remove"></i> Cancel</button>
        </div>
    </form>
    <!-- END FORM-->

     
    <!-- End contract award view -->

</div>