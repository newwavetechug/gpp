<div class="widget">
    <div class="widget-title">
        <h4><i class="icon-reorder"></i>&nbsp;<?=(!empty($form_title)? $form_title : 'Initiate procurement') ?></h4>
            <span class="tools">
                <a href="javascript:;" class="icon-chevron-down"></a>
                <a href="javascript:;" class="icon-remove"></a>
            </span>
    </div>
    <div class="widget-body">
        <!-- BEGIN FORM-->
        <form action="<?=base_url() . 'procurement/initiate_procurement' . ((!empty($i))? '/i/'.$i : '' )?>" enctype="multipart/form-data" method="post" class="form-horizontal">
        	<div class="form_details">
            	<div class="control-group">
                    <label class="control-label">Procurement Ref. No <span>*</span></label>
                    <div class="controls">
                        <select id="procurement-ref-no" class="input-large m-wrap" name="procurement_ref_no" tabindex="1">
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
                <hr/>
                <div class="control-group">
                    <label class="control-label">Vote/Head No.:</label>
                    <div class="controls">
                        <input type="text" name="vote_no" value="<?=(!empty($formdata['vote_no'])? $formdata['vote_no'] : '' )?>" class="input-xlarge" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Initiated by:</label>
                    <div class="controls">
                        <input type="text" name="initiated_by" value="<?=(!empty($formdata['initiated_by'])? $formdata['initiated_by'] : '' )?>" class="input-xlarge" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Date initiated:</label>
                    <div class="controls">
                    	<div class="input-append date date-picker" data-date="2015-01-01" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
							<input name="date_initiated" data-date="2015-01-01" data-date-format="yyyy-mm-dd" data-date-viewmode="days" class="m-ctrl-medium date-picker"  type="text" value="<?=(!empty($formdata['date_initiated'])? $formdata['date_initiated'] : '' )?>">
							<span class="add-on">
                            	<i class="icon-calendar"></i>
                            </span>
						</div>
                    </div>
                </div>                                  
            <div class="form-actions">
                <button type="submit" name="save" value="save" class="btn blue"><i class="icon-ok"></i> Save</button>
                <button type="button" name="cancel" value="cancel" class="btn"><i class="icon-remove"></i> Cancel</button>
            </div>
        </form>
        <!-- END FORM-->
    </div>
</div>