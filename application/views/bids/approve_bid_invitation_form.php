<? if(empty($requiredfields)) $requiredfields = array();?>
<div class="widget">
    <div class="widget-title">
        <h4><i class="fa fa-reorder"></i>&nbsp;<?=(!empty($form_title)? $form_title : '') ?></h4>
            <span class="tools">
                <a href="javascript:;" class="icon-chevron-down"></a>
                <a href="javascript:;" class="icon-remove"></a>
            </span>
    </div>
    <div class="widget-body">
        <?=format_notice('INFO: Please enter the Contracts Committee date to publish the IFB. Successfully submitting this form will make the IFB available on the website for the public to view.')?>
        <!-- BEGIN FORM-->
        <form id="bid-invitation-approval-form" action="<?=base_url() . 'bids/approve_bid_invitation' . ((!empty($i))? '/i/'.$i : '' )?>" enctype="multipart/form-data" method="post" class="form-horizontal">
                <div class="control-group">
                    <label class="control-label">Procurement Ref. No <span>*</span></label>
                    <div class="controls">
                        <?=(!empty($formdata['procurement_ref_no'])? $formdata['procurement_ref_no'] : '' )?>
                    </div>
                </div>
                <div id="procurement_plan_details">
                    <?php if(!empty($formdata['procurement_details'])): ?>
                    <?php $procurement_details = $formdata['procurement_details']; ?>
                        <div class="control-group">
                            <label class="control-label">Subject of procurement:</label>
                            <div class="controls">
                                <?=(!empty($procurement_details['subject_of_procurement'])? $procurement_details['subject_of_procurement'] : '<i>undefined</i>')?>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <label class="control-label">Method of Procurement:</label>
                            <div class="controls">
                                <?=(!empty($procurement_details['procurement_method'])? $procurement_details['procurement_method'] : '<i>undefined</i>')?>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <label class="control-label">Source of Funding:</label>
                            <div class="controls">
                                <?=(!empty($procurement_details['funding_source'])? $procurement_details['funding_source'] : '<i>undefined</i>')?>
                            </div>
                        </div>
                     <?php endif; ?>
                </div>
                <hr/>
                <div class="control-group">
                    <label class="control-label">Price of bidding documents:</label>
                    <div class="controls">
                    <?php 
                    #print_r($formdata)
                    ?>
                        <?=(is_numeric($formdata['bid_documents_price'])? number_format($formdata['bid_documents_price'], 0, '.', ',') : $formdata['bid_documents_price']) . ' '. strtoupper($formdata['bid_documents_currency'])?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Bid security:</label>
                    <div class="controls">
                        <?=(is_numeric($formdata['bid_security_amount'])? number_format($formdata['bid_security_amount'], 0, '.', ',') : $formdata['bid_security_amount'])?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Invitation to bid date:</label>
                    <div class="controls">
                        <?=(!empty($formdata['invitation_to_bid_date'])? custom_date_format('l d M, Y', $formdata['invitation_to_bid_date']) : '<i>Not specified</i>' )?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Pre-bid meeting date: <span>*</span></label>
                    <div class="controls">
                        <?=(!empty($formdata['pre_bid_meeting_date'])? custom_date_format('l d M, Y', $formdata['pre_bid_meeting_date']) . ' at ' . custom_date_format('h:i A', $formdata['pre_bid_meeting_date']): '<i>Not specified</i>' )?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Deadline of bid submission:<span>*</span></label>
                    <div class="controls">
                        <?=(!empty($formdata['bid_submission_deadline'])? custom_date_format('l d M, Y', $formdata['bid_submission_deadline']) . ' at ' . custom_date_format('h:i A', $formdata['bid_submission_deadline']) : '' )?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Bid evaluation period:<span>*</span></label>
                    <div class="controls">
                        <?=(!empty($formdata['bid_evaluation_from'])? 'From ' . custom_date_format('l d M, Y', $formdata['bid_evaluation_from']).
                            ' to ' : '' ).
                        (!empty($formdata['bid_evaluation_to'])? custom_date_format('l d M, Y', $formdata['bid_evaluation_to']) : '' )?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Bid openning date:<span>*</span></label>
                    <div class="controls">
                        <?=(!empty($formdata['bid_openning_date'])? custom_date_format('l d M, Y', $formdata['bid_openning_date']) . ' at ' .
                        custom_date_format('h:i A', $formdata['bid_openning_date']) : '<i>Not specified</i>' )?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Display of BEB notice:<span>*</span></label>
                    <div class="controls">
                        <?=(!empty($formdata['display_of_beb_notice'])? custom_date_format('l d M, Y', $formdata['display_of_beb_notice']) : '' )?>
                    </div>
                    <input name="editid" value="<?=$i?>" type="hidden" />
                </div>
                <div class="control-group">
                    <label class="control-label">Contract award date:<span>*</span></label>
                    <div class="controls">
                        <?=(!empty($formdata['contract_award_date'])? custom_date_format('l d M, Y', $formdata['contract_award_date']) : '' )?>
                    </div>
                </div>
                
                <div class="control-group <?=(in_array('cc_approval_date', $requiredfields)? 'error': '')?>">
                    <label class="control-label">Contract Committee approval date:</label>
                    <div class="controls">
                        <div class="input-append date date-picker" data-date="<?=(!empty($formdata['cc_approval_date']) && str_replace('-', '', $formdata['cc_approval_date'])>0? custom_date_format('Y-m-d', $formdata['cc_approval_date']) : date('Y-m-d'))?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
                            <input name="cc_approval_date" data-date="<?=(!empty($formdata['cc_approval_date']) && str_replace('-', '', $formdata['cc_approval_date'])>0? custom_date_format('Y-m-d', $formdata['cc_approval_date']) : date('Y-m-d'))?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days" class="m-ctrl-medium date-picker"  type="text" value="<?=(!empty($formdata['cc_approval_date']) && str_replace('-', '', $formdata['cc_approval_date'])>0? custom_date_format('Y-m-d', $formdata['cc_approval_date']) : '' )?>">
                            <span class="add-on">
                                <i class="fa fa-calendar"></i>
                            </span>
                        </div>
                    </div>
                </div>                                        
            <div class="form-actions">
                <button id="approve-bid-invitation" type="submit" name="save" value="save" class="btn blue">
                    <i class="fa fa-ok"></i> Publish IFB
                </button>
                <button type="button" name="cancel" value="cancel" class="btn"><i class="fa fa-remove"></i> Cancel</button>
            </div>
        </form>
        <!-- END FORM-->
    </div>
</div>