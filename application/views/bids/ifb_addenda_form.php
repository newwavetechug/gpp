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
        <form id="bid-invitation-approval-form" action="<?=base_url() . 'bids/save_ifb_addenda' . ((!empty($b))? '/b/'.$b : '' ) . ((!empty($i))? '/i/'.$i : '' )?>" enctype="multipart/form-data" method="post" class="form-horizontal">
            	<div class="control-group">
                    <label class="control-label">Procurement Ref. No <span>*</span></label>
                    <div class="controls">
                    	<?=(!empty($procurement_details['procurement_ref_no'])? $procurement_details['procurement_ref_no'] : '' )?>
                    </div>
                </div>
                <div id="procurement_plan_details">
                  <div class="control-group">
                        <label class="control-label">Subject of procurement:</label>
                        <div class="controls">
                            <?=(!empty($procurement_details['subject_of_procurement'])? $procurement_details['subject_of_procurement'] : '<i>undefined</i>')?>
                        </div>
                    </div>
                </div>
                <hr/>
          <?php if(!empty($i)): ?>
                    	<input name="editid" value="<?=$i?>" type="hidden" />
<?php endif; ?>
                
                <div class="control-group">
                    <label class="control-label">Title: <?=text_danger_template('*')?></label>
                    <div class="controls">
                        <input required="" value="<?php if(!empty($formdata['title'])) echo $formdata['title'];?>" id="title" name="title" type="text" class="">
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label">Addendum No.: <?=text_danger_template('*')?></label>
                    <div class="controls">
                        <input required="" value="<?php if(!empty($formdata['refno'])) echo $formdata['refno'];?>" id="refno" name="refno" type="text" class="">
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label">Notes:</label>
                    <div class="controls">
                        <textarea class="span6 wysihtml5" name="description" id="description" rows="6"><?php if(!empty($formdata['description'])) echo $formdata['description'];?></textarea>
                    </div>
                </div>
                    
                <div class="control-group">
                    <label class="control-label">Addenda: <?=text_danger_template('*')?></label>
                    <div class="controls">
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="input-append">
                                <div class="uneditable-input">
                                    <i class="icon-file fileupload-exists"></i>
                                    <span class="fileupload-preview"><? if(!empty($formdata['fileurl'])) echo $formdata['fileurl'];?></span>
                                </div>
                                 <span class="btn btn-file">
                                 <span class="fileupload-new">Select file</span>
                                 <span class="fileupload-exists">Change</span>
                                 <input type="file" class="default" name="addenda" id="addenda" />
                                 </span>
                                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                            </div>
                            <span class="help-inline">Allowed formats: .pdf</span>
                        </div>
                        <?php if(!empty($formdata['fileurl'])): ?>
                        <span class="help-inline"><a target="_new" href="<?=base_url() . 'uploads/documents/addenda/' . $formdata['fileurl'] ?>">Download current file</a></span>
                        <?php endif; ?>
                    </div>
                </div>
                                            
            <div class="form-actions">
                <button id="approve-bid-invitation" type="submit" name="save_addenda" value="save" class="btn green">
                	<i class="icon-ok"></i> Save Addenda
                </button>
                <button type="button" name="cancel" value="cancel" class="btn"><i class="icon-remove"></i> Cancel</button>
            </div>
        </form>
        <!-- END FORM-->
    </div>
</div>