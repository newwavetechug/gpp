<?php if(empty($requiredfields)) $requiredfields = array();?>
<div class="widget-body form">
    <!-- BEGIN FORM-->
    <form action="<?=base_url() . 'procurement/save_procurement_entry' . ((!empty($i))? '/i/'.$i : '' ) . ((!empty($v))? '/v/'.$v : '' )?>" class="form-horizontal" method="post">
        <div class="accordion" id="accordion1">
            <div class="accordion-group">
                <div class="accordion-heading">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1"
                       href="#collapse_1">
                        <i class=" fa fa-plus"></i>
                        Basic information
                    </a>
                </div>
                <div id="collapse_1" class="accordion-body collapse in">
                    <div class="accordion-inner">
                        <div class="ref_number_area">

                        </div>
                        <div class="control-group <?=(in_array('subject_of_procurement', $requiredfields)? 'error': '')?>">
                            <label class="control-label">Subject of procurement <?= text_danger_template('*') ?></label>

                            <div class="controls">
                                <input id="subject_of_procurement" name="subject_of_procurement" type="text" value="<?=(!empty($formdata['subject_of_procurement'])? $formdata['subject_of_procurement'] : '')?>" class="span6">
                            </div>
                        </div>


                        <div class="control-group <?=(in_array('quantity', $requiredfields)? 'error': '')?>">
                            <label class="control-label">Quantity <?= text_danger_template('*') ?></label>

                            <div class="controls">
                                  <input type="text" name="quantity" value="<?=(!empty($formdata['quantity'])? addCommas($formdata['quantity'], 0) : '' )?>" class="input-large numbercommas " />
                            
                            </div>
                        </div>

                        
                        <div class="control-group <?=(in_array('pde_department', $requiredfields)? 'error': '')?>">
                            <label class="control-label">Responsible <br /> department <?= text_danger_template('*') ?></label>

                            <div class="controls">
                                <input id="pde_department" name="pde_department" type="text" value="<?=(!empty($formdata['pde_department'])? $formdata['pde_department'] : '')?>" class="span4">
                            </div>
                        </div>

                        <div class="control-group <?=(in_array('procurement_type', $requiredfields)? 'error': '')?>">
                            <label class="control-label">Type of procurement <?= text_danger_template('*') ?></label>

                            <div class="controls">
                                <select id="procurement_type" name="procurement_type" class="input-large" data-placeholder="Choose a Category">
                                    <?=get_select_options(get_active_procurement_types(), 'id', 'title', (!empty($formdata['procurement_type'])? $formdata['procurement_type'] : '' ))?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="control-group <?=(in_array('estimated_amount', $requiredfields)? 'error': '')?>">
                            <label class="control-label">Estimated amount <?= text_danger_template('*') ?>
                            </label>

                            <div class="controls">
                                <select id="currency" class="input-small m-wrap" name="currency">
                            <?=get_select_options(get_active_currencies(), 'id', 'title', (!empty($formdata['currency'])? $formdata['currency'] : '1' ))?>                            
                                </select>
                                <input style="display:none" class=" input-small numbercommas" value="<?=(!empty($formdata['exchange_rate'])? addCommas($formdata['exchange_rate'], 0) : '' )?>" name="exchange_rate" placeholder="Exchange rate" type="text" />
                                <input type="text" name="estimated_amount" value="<?=(!empty($formdata['estimated_amount'])? addCommas($formdata['estimated_amount'], 0) : '' )?>" class="input-medium numbercommas" />
                            
                            </div>
                        </div>
                        
                        <div class="control-group <?=(in_array('funding_source', $requiredfields)? 'error': '')?>">
                            <label class="control-label">Source of funding <?= text_danger_template('*') ?></label>

                            <div class="controls">
                                <select id="funding-source" class="input-large" name="funding_source" data-placeholder="Choose a Category" tabindex="1">
                                    <?=get_select_options(get_active_source_funding(), 'id', 'title', (!empty($formdata['funding_source'])? $formdata['funding_source'] : '' ))?>
                                </select>
                            </div>
                        </div>

                        <div class="control-group <?=(in_array('procurement_method', $requiredfields)? 'error': '')?>">
                            <label class="control-label">Procurement method <?= text_danger_template('*') ?></label>

                            <div class="controls">
                                <select id="procurement-method" class="input-large" name="procurement_method" data-placeholder="Choose a Category" tabindex="1">
                                    <?=get_select_options(get_active_procurement_methods(), 'id', 'title', (!empty($formdata['procurement_method'])? $formdata['procurement_method'] : '' ))?>
                                </select>
                            </div>
                        </div>



                     
                    </div>
                </div>
            </div>

            <div class="accordion-group">
                <div class="accordion-heading">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1"
                       href="#collapse_2">
                        <i class=" fa fa-plus"></i>
                        Procurement Initiation Approvals
                    </a>
                </div>
                <div id="collapse_2" class="accordion-body collapse">
                    <div class="accordion-inner">
                        <!--
                        <div class="control-group">
                            <label class="control-label">Pre-bid Events date</label>

                            <div class="controls">
                                <div class="input-append date date-picker" data-date="<? #date('m-d-Y') ?>"
                                     data-date-format="dd-mm-yyyy" data-date-viewmode="">
                                    <input id="pre_bid_events_date" class=" m-ctrl-medium date-picker" size="16"
                                           type="text" value=""><span class="add-on"><i
                                            class="fa fa-calendar"></i></span>
                                    <input required="" id="pre_bid_events_date_duration" placeholder="duration"
                                           type="text" class="span3 "> Days
                                </div>
                            </div>
                        </div>
                        -->
                        <div class="control-group <?=(in_array('contracts_committee_approval_date', $requiredfields)? 'error': '')?>">
                            <label class="control-label">Contracts committee approval date</label>

                            <div class="controls">
                                <div class="input-append date date-picker" data-date="<?=(!empty($formdata['contracts_committee_approval_date'])? custom_date_format('Y-m-d', $formdata['contracts_committee_approval_date']) : date('Y-m-d'))?>"
                                     data-date-format="dd/ mm/yyyy" data-date-viewmode="days">
                                    <input id="contracts-committee-approval-date" name="contracts_committee_approval_date" class=" m-ctrl-medium date-picker" size="16" type="text" value="<?=(!empty($formdata['contracts_committee_approval_date'])? $formdata['contracts_committee_approval_date'] : '')?>"><span class="add-on"><i
                                            class="fa fa-calendar"></i></span>

                                </div>
                            </div>
                        </div>
                        
                        <div class="control-group <?=(in_array('contracts_committee_approval_of_shortlist_date', $requiredfields)? 'error': '')?>">
                            <label class="control-label">Contracts committee approval of shortlist & bidding
                                document</label>

                            <div class="controls">
                                <div class="input-append date date-picker" data-date="<?=(!empty($formdata['contracts_committee_approval_of_shortlist_date'])? custom_date_format('Y-m-d', $formdata['contracts_committee_approval_of_shortlist_date']) : date('Y-m-d'))?>"
                                     data-date-format="dd/ mm/yyyy" data-date-viewmode="days">
                                    <input id="contracts_committee_approval_of_shortlist_date" name="contracts_committee_approval_of_shortlist_date" class="m-ctrl-medium date-picker" size="16" type="text" value="<?=(!empty($formdata['contracts_committee_approval_of_shortlist_date'])? $formdata['contracts_committee_approval_of_shortlist_date'] : '')?>"><span class="add-on"><i
                                            class="fa fa-calendar"></i></span>

                                </div>
                            </div>
                        </div>
                        
                        <div class="control-group <?=(in_array('publication_of_pre_qualification_date', $requiredfields)? 'error': '')?>">
                            <label class="control-label">Publication of pre-qualification notice date</label>

                            <div class="controls">
                                <div class="input-append date date-picker" data-date="<?=(!empty($formdata['publication_of_pre_qualification_date'])? custom_date_format('Y-m-d', $formdata['publication_of_pre_qualification_date']) : date('Y-m-d'))?>"
                                     data-date-format="dd/ mm/yyyy" data-date-viewmode="days">
                                    <input id="publication_of_pre_qualification_date" class=" m-ctrl-medium date-picker" name="publication_of_pre_qualification_date" size="16" type="text" value="<?=(!empty($formdata['publication_of_pre_qualification_date'])? $formdata['publication_of_pre_qualification_date'] : '')?>"><span class="add-on"><i
                                            class="fa fa-calendar"></i></span>

                                </div>
                            </div>
                        </div>
                        <div class="control-group <?=(in_array('proposal_submission_date', $requiredfields)? 'error': '')?>">
                            <label class="control-label">Closing date of pre-qualification proposal submission</label>

                            <div class="controls">
                                <div class="input-append date date-picker" data-date="<?=(!empty($formdata['proposal_submission_date'])? custom_date_format('Y-m-d', $formdata['proposal_submission_date']) : date('Y-m-d'))?>"
                                     data-date-format="dd/ mm/yyyy" data-date-viewmode="days">
                                    <input id="proposal_submission_date" name="proposal_submission_date" class=" m-ctrl-medium date-picker" size="16"
                                           type="text" value="<?=(!empty($formdata['proposal_submission_date'])? $formdata['proposal_submission_date'] : '')?>"><span class="add-on"><i
                                            class="fa fa-calendar"></i></span>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="accordion-group">
                <div class="accordion-heading">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1"
                       href="#collapse_3">
                        <i class=" fa fa-plus"></i>
                        Bidding period
                    </a>
                </div>
                <div id="collapse_3" class="accordion-body collapse">
                    <div class="accordion-inner">
                        <div class="control-group <?=(in_array('bid_issue_date', $requiredfields)? 'error': '')?>">
                            <label class="control-label">Bid invitation date</label>

                            <div class="controls">
                                <div class="input-append date date-picker" data-date="<?=(!empty($formdata['bid_issue_date'])? custom_date_format('Y-m-d', $formdata['bid_issue_date']) : date('Y-m-d'))?>"
                                     data-date-format="dd/ mm/yyyy" data-date-viewmode="days">
                                    <input id="bid_issue_date" class="m-ctrl-medium date-picker" size="16" type="text" name="bid_issue_date" value="<?=(!empty($formdata['bid_issue_date'])? $formdata['bid_issue_date'] : '')?>"><span class="add-on"><i class="fa fa-calendar"></i></span>

                                </div>
                            </div>
                        </div>
                        <div class="control-group <?=(in_array('bid_closing_date', $requiredfields)? 'error': '')?>">
                            <label class="control-label">Bid closing date</label>

                            <div class="controls">
                                <div class="input-append date date-picker" data-date="<?=(!empty($formdata['bid_closing_date'])? custom_date_format('Y-m-d', $formdata['bid_closing_date']) : date('Y-m-d'))?>"
                                     data-date-format="dd/ mm/yyyy" data-date-viewmode="days">
                                    <input id="bid_closing_date" class=" m-ctrl-medium date-picker" size="16" name="bid_closing_date" type="text" value="<?=(!empty($formdata['bid_closing_date'])? $formdata['bid_closing_date'] : '')?>"><span class="add-on"><i
                                            class="fa fa-calendar"></i></span>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="accordion-group">
                <div class="accordion-heading">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1"
                       href="#collapse_6">
                        <i class=" fa fa-plus"></i>
                        Evaluation of bids
                    </a>
                </div>
                <div id="collapse_6" class="accordion-body collapse">
                    <div class="accordion-inner">
                        <div class="control-group <?=(in_array('submission_of_evaluation_report_to_cc', $requiredfields)? 'error': '')?>">
                            <label class="control-label">Submission of Evaluation Report to CC</label>

                            <div class="controls">
                                <div class="input-append date date-picker" data-date="<?=(!empty($formdata['submission_of_evaluation_report_to_cc'])? custom_date_format('Y-m-d', $formdata['submission_of_evaluation_report_to_cc']) : date('Y-m-d'))?>"
                                     data-date-format="dd/ mm/yyyy" data-date-viewmode="days">
                                    <input id="submission_of_evaluation_report_to_cc" name="submission_of_evaluation_report_to_cc" class=" m-ctrl-medium date-picker" size="16"
                                           type="text" value="<?=(!empty($formdata['submission_of_evaluation_report_to_cc'])? $formdata['submission_of_evaluation_report_to_cc'] : '')?>"><span class="add-on"><i class="fa fa-calendar"></i></span>

                                </div>
                            </div>
                        </div>
                        
                        <div class="control-group <?=(in_array('cc_approval_of_evaluation_report', $requiredfields)? 'error': '')?>">
                            <label class="control-label">Approval of evaluation report by contracts committee</label>

                            <div class="controls">
                                <div class="input-append date date-picker" data-date="<?=(!empty($formdata['cc_approval_of_evaluation_report'])? custom_date_format('Y-m-d', $formdata['cc_approval_of_evaluation_report']) : date('Y-m-d'))?>"
                                     data-date-format="dd/ mm/yyyy" data-date-viewmode="days">
                                    <input id="cc_approval_of_evaluation_report" class="m-ctrl-medium date-picker" size="16" name="cc_approval_of_evaluation_report" type="text" value="<?=(!empty($formdata['cc_approval_of_evaluation_report'])? $formdata['cc_approval_of_evaluation_report'] : '')?>"><span class="add-on"><i class="fa fa-calendar"></i></span>

                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
            
            <div class="accordion-group">
                <div class="accordion-heading">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1"
                       href="#collapse_7">
                        <i class=" fa fa-plus"></i>
                        Negotiations
                    </a>
                </div>
                <div id="collapse_7" class="accordion-body collapse">
                    <div class="accordion-inner">
                        <div class="control-group <?=(in_array('negotiation_date', $requiredfields)? 'error': '')?>">
                            <label class="control-label">Negotiation date</label>

                            <div class="controls">
                                <div class="input-append date date-picker" data-date="<?=(!empty($formdata['negotiation_date'])? custom_date_format('Y-m-d', $formdata['negotiation_date']) : date('Y-m-d'))?>"
                                     data-date-format="dd/ mm/yyyy" data-date-viewmode="days">
                                    <input id="negotiation_date" class="m-ctrl-medium date-picker" size="16" name="negotiation_date" type="text" value="<?=(!empty($formdata['negotiation_date'])? $formdata['negotiation_date'] : '')?>"><span class="add-on"><i
                                            class="fa fa-calendar"></i></span>

                                </div>
                            </div>
                        </div>

                        <div class="control-group <?=(in_array('negotiation_approval_date', $requiredfields)? 'error': '')?>">
                            <label class="control-label">Approval of negotiations report contract committee </label>

                            <div class="controls">
                                <div class="input-append date date-picker" data-date="<?=(!empty($formdata['negotiation_approval_date'])? custom_date_format('Y-m-d', $formdata['negotiation_approval_date']) : date('Y-m-d'))?>"
                                     data-date-format="dd/ mm/yyyy" data-date-viewmode="days">
                                    <input id="negotiation_approval_date" name="negotiation_approval_date" class="m-ctrl-medium date-picker" size="16" type="text" value="<?=(!empty($formdata['negotiation_approval_date'])? $formdata['negotiation_approval_date'] : '')?>">
                                        <span class="add-on"><i class="fa fa-calendar"></i></span>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            
            <div class="accordion-group">
                <div class="accordion-heading">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1"
                       href="#collapse_beb_window">
                        <i class=" fa fa-plus"></i>
                        BEB window and Administrative review
                    </a>
                </div>
                <div id="collapse_beb_window" class="accordion-body collapse">
                  <div class="accordion-inner">
                    <div class="control-group <?=(in_array('best_evaluated_bidder_date', $requiredfields)? 'error': '')?>">
                            <label class="control-label">Best evaluated bidder notice date</label>

                            <div class="controls">
                                <div class="input-append date date-picker" data-date="<?=(!empty($formdata['best_evaluated_bidder_date'])? custom_date_format('Y-m-d', $formdata['best_evaluated_bidder_date']) : date('Y-m-d'))?>"
                                     data-date-format="dd/ mm/yyyy" data-date-viewmode="days">
                                    <input id="best_evaluated_bidder_date" name="best_evaluated_bidder_date" class=" m-ctrl-medium date-picker" size="16" type="text" value="<?=(!empty($formdata['best_evaluated_bidder_date'])? $formdata['best_evaluated_bidder_date'] : '')?>"><span class="add-on"><i
                                            class="fa fa-calendar"></i></span>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-group">
                <div class="accordion-heading">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1"
                       href="#collapse_4">
                        <i class=" fa fa-plus"></i>
                        Contract finalization
                    </a>
                </div>
                <div id="collapse_4" class="accordion-body collapse">
                    <div class="accordion-inner">

                        <div class="control-group <?=(in_array('performance_security', $requiredfields)? 'error': '')?>">
                            <label class="control-label">Performance security</label>

                            <div class="controls">
                                <div class="input-append date date-picker" data-date="<?=(!empty($formdata['performance_security'])? custom_date_format('Y-m-d', $formdata['performance_security']) : date('Y-m-d'))?>"
                                     data-date-format="dd/ mm/yyyy" data-date-viewmode="days">
                                    <input id="performance_security" class=" m-ctrl-medium date-picker" size="16" name="performance_security" type="text" value="<?=(!empty($formdata['performance_security'])? $formdata['performance_security'] : '')?>"><span class="add-on"><i
                                            class="fa fa-calendar"></i></span>

                                </div>
                            </div>
                        </div>
                                       
                        <div class="control-group <?=(in_array('solicitor_general_approval_date', $requiredfields)? 'error': '')?>">
                            <label class="control-label">Solicitor general's approval date</label>

                            <div class="controls">
                                <div class="input-append date date-picker" data-date="<?=(!empty($formdata['solicitor_general_approval_date'])? custom_date_format('Y-m-d', $formdata['solicitor_general_approval_date']) : date('Y-m-d'))?>"
                                     data-date-format="dd/ mm/yyyy" data-date-viewmode="days">
                                    <input id="solicitor_general_approval_date" class=" m-ctrl-medium date-picker" size="16" name="solicitor_general_approval_date" type="text" value="<?=(!empty($formdata['solicitor_general_approval_date'])? $formdata['solicitor_general_approval_date'] : '')?>"><span class="add-on"><i
                                            class="fa fa-calendar"></i></span>

                                </div>
                            </div>
                        </div>
                        
                        <div class="control-group <?=(in_array('accounting_officer_approval_date', $requiredfields)? 'error': '')?>">
                            <label class="control-label">Accounting officer's approval date</label>

                            <div class="controls">
                                <div class="input-append date date-picker" data-date="<?=(!empty($formdata['accounting_officer_approval_date'])? custom_date_format('Y-m-d', $formdata['accounting_officer_approval_date']) : date('Y-m-d'))?>"
                                     data-date-format="dd/ mm/yyyy" data-date-viewmode="days">
                                    <input id="accounting_officer_approval_date" class=" m-ctrl-medium date-picker" size="16" name="accounting_officer_approval_date" type="text" value="<?=(!empty($formdata['accounting_officer_approval_date'])? $formdata['accounting_officer_approval_date'] : '')?>"><span class="add-on"><i
                                            class="fa fa-calendar"></i></span>

                                </div>
                            </div>
                        </div>
                        
                        <div class="control-group <?=(in_array('contract_award', $requiredfields)? 'error': '')?>">
                            <label class="control-label">Contract award date</label>

                            <div class="controls">
                                <div class="input-append date date-picker" data-date="<?=(!empty($formdata['contract_award'])? custom_date_format('Y-m-d', $formdata['contract_award']) : date('Y-m-d'))?>"
                                     data-date-format="dd/ mm/yyyy" data-date-viewmode="days">
                                    <input id="contract_award" class=" m-ctrl-medium date-picker" size="16" name="contract_award" type="text" value="<?=(!empty($formdata['contract_award'])? $formdata['contract_award'] : '')?>"><span class="add-on"><i
                                            class="fa fa-calendar"></i></span>

                                </div>
                            </div>
                        </div>
                        
                        <div class="control-group <?=(in_array('contract_sign_date', $requiredfields)? 'error': '')?>">
                            <label class="control-label">Contract signature date</label>

                            <div class="controls">
                                <div class="input-append date date-picker" data-date="<?=(!empty($formdata['contract_sign_date'])? custom_date_format('Y-m-d', $formdata['contract_sign_date']) : date('Y-m-d'))?>"
                                     data-date-format="dd/ mm/yyyy" data-date-viewmode="days">
                                    <input id="contract_sign_date" class=" m-ctrl-medium date-picker" size="16" name="contract_sign_date" type="text" value="<?=(!empty($formdata['contract_sign_date'])? $formdata['contract_sign_date'] : '')?>"><span class="add-on"><i
                                            class="fa fa-calendar"></i></span>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            

            <div class="accordion-group">
                <div class="accordion-heading">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1"
                       href="#collapse_8">                   <i class=" fa fa-plus"></i>
                        Contract implementation
                    </a>
                </div>
              
                <div id="collapse_8" class="accordion-body collapse">
                    <div class="accordion-inner">

  

                        <div class="control-group suppliescontrol <?=(in_array('opening_of_credit_letter', $requiredfields)? 'error': '')?>" <?=(!empty($formdata['procurement_type']) && in_array($formdata['procurement_type'], array(1)) ? 'style="display:block;"' : '') ?> >
                            <label class="control-label">Opening of letter of credit</label>
 
                            <div class="controls">
                                <div class="input-append date date-picker" data-date="<?=(!empty($formdata['opening_of_credit_letter'])? custom_date_format('Y-m-d', $formdata['opening_of_credit_letter']) : date('Y-m-d'))?>"
                                     data-date-format="dd/ mm/yyyy" data-date-viewmode="days">
                                    <input id="opening_of_credit_letter" name="opening_of_credit_letter" class=" m-ctrl-medium date-picker" size="16" type="text" value="<?=(!empty($formdata['opening_of_credit_letter'])? $formdata['opening_of_credit_letter'] : '')?>"><span class="add-on"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                         
                        <div class="control-group suppliescontrol <?=(in_array('arrival_of_goods', $requiredfields)? 'error': '')?>" <?=(!empty($formdata['procurement_type']) && in_array($formdata['procurement_type'], array(1))? 'style="display:block;"' : '')?>>
                            <label class="control-label">Arrival of goods</label>

                            <div class="controls">
                                <div class="input-append date date-picker" data-date="<?=(!empty($formdata['arrival_of_goods'])? custom_date_format('Y-m-d', $formdata['arrival_of_goods']) : date('Y-m-d'))?>"
                                     data-date-format="dd/ mm/yyyy" data-date-viewmode="days">
                                    <input id="arrival_of_goods" name="arrival_of_goods" class=" m-ctrl-medium date-picker" size="16" type="text" value="<?=(!empty($formdata['arrival_of_goods'])? $formdata['arrival_of_goods'] : '')?>"><span class="add-on"><i class="fa fa-calendar"></i></span>
                                </div>
                                
                            </div>
                        </div>
                        
                        <div class="control-group suppliescontrol <?=(in_array('inspection_final_acceptance', $requiredfields)? 'error': '')?>" <?=(!empty($formdata['procurement_type']) && in_array($formdata['procurement_type'], array(1))? 'style="display:block;"' : '')?>>
                            <label class="control-label">Final acceptance/delivery notes</label>

                            <div class="controls">
                                <div class="input-append date date-picker" data-date="<?=(!empty($formdata['inspection_final_acceptance'])? custom_date_format('Y-m-d', $formdata['inspection_final_acceptance']) : date('Y-m-d'))?>"
                                     data-date-format="dd/ mm/yyyy" data-date-viewmode="days">
                                    <input id="inspection_final_acceptance" name="inspection_final_acceptance" class=" m-ctrl-medium date-picker" size="16" type="text" value="<?=(!empty($formdata['inspection_final_acceptance'])? $formdata['inspection_final_acceptance'] : '')?>"><span class="add-on"><i class="fa fa-calendar"></i></span>
                                </div>
                             </div>
                        </div>
                    
                        <div class="control-group works_control nonconsultancycontrol <?=(in_array('mobilise_advance_payment', $requiredfields)? 'error': '')?>" <?=(!empty($formdata['procurement_type']) && in_array($formdata['procurement_type'], array(3, 2))? 'style="display:block;"' : '')?>>
                            <label class="control-label">Mobilise advance payment date</label>

                            <div class="controls">
                                <div class="input-append date date-picker" data-date="<?=(!empty($formdata['mobilise_advance_payment'])? custom_date_format('Y-m-d', $formdata['mobilise_advance_payment']) : date('Y-m-d'))?>"
                                     data-date-format="dd/ mm/yyyy" data-date-viewmode="days">
                                    <input id="advanced_payment_date" name="mobilise_advance_payment" class=" m-ctrl-medium date-picker" size="16"
                                           type="text" value="<?=(!empty($formdata['mobilise_advance_payment'])? $formdata['mobilise_advance_payment'] : '')?>"><span class="add-on"><i
                                            class="fa fa-calendar"></i></span>

                                </div>
                            </div>
                        </div>
                        
                        <div class="control-group nonconsultancycontrol <?=(in_array('draft_report', $requiredfields)? 'error': '')?>" <?=(!empty($formdata['procurement_type']) && $formdata['procurement_type'] == 2? 'style="display:block;"' : '')?>>
                            <label class="control-label">Draft report</label>

                            <div class="controls">
                                <div class="input-append date date-picker" data-date="<?=(!empty($formdata['draft_report'])? custom_date_format('Y-m-d', $formdata['draft_report']) : date('Y-m-d'))?>"
                                     data-date-format="dd/ mm/yyyy" data-date-viewmode="days">
                                    <input id="draft_report" name="draft_report" class="m-ctrl-medium date-picker" size="16" type="text" value="<?=(!empty($formdata['draft_report'])? $formdata['draft_report'] : '')?>">
                                        <span class="add-on"><i
                                        class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="control-group nonconsultancycontrol <?=(in_array('final_report', $requiredfields)? 'error': '')?>" <?=(!empty($formdata['procurement_type']) && $formdata['procurement_type'] == 2? 'style="display:block;"' : '')?>>
                            <label class="control-label">Final report</label>

                            <div class="controls">
                                <div class="input-append date date-picker" data-date="<?=(!empty($formdata['final_report'])? custom_date_format('Y-m-d', $formdata['final_report']) : date('Y-m-d'))?>"
                                     data-date-format="dd/ mm/yyyy" data-date-viewmode="days">
                                    <input id="final_report" name="final_report" class="m-ctrl-medium date-picker" size="16" type="text" value="<?=(!empty($formdata['final_report'])? $formdata['final_report'] : '')?>">
                                        <span class="add-on"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="control-group workscontrol <?=(in_array('substantial_completion', $requiredfields)? 'error': '')?>" <?=(!empty($formdata['procurement_type']) && $formdata['procurement_type'] == 3? 'style="display:block;"' : '')?>>
                            <label class="control-label">Substantial completion</label>

                            <div class="controls">
                                <div class="input-append date date-picker" data-date="<?=(!empty($formdata['substantial_completion'])? custom_date_format('Y-m-d', $formdata['substantial_completion']) : date('Y-m-d'))?>"
                                     data-date-format="dd/ mm/yyyy" data-date-viewmode="days">
                                    <input id="substantial_completion" name="substantial_completion" class=" m-ctrl-medium date-picker" size="16"
                                           type="text" value="<?=(!empty($formdata['substantial_completion'])? $formdata['substantial_completion'] : '')?>"><span class="add-on"><i
                                            class="fa fa-calendar"></i></span>

                                </div>
                            </div>
                        </div>

                        <div class="control-group workscontrol <?=(in_array('final_acceptance', $requiredfields)? 'error': '')?>" <?=(!empty($formdata['procurement_type']) && $formdata['procurement_type'] == 3? 'style="display:block;"' : '')?>>
                            <label class="control-label">Final acceptance</label>

                            <div class="controls">
                                <div class="input-append date date-picker" data-date="<?=(!empty($formdata['final_acceptance'])? custom_date_format('Y-m-d', $formdata['final_acceptance']) : date('Y-m-d'))?>"
                                     data-date-format="dd/ mm/yyyy" data-date-viewmode="days">
                                    <input id="final_acceptance" class=" m-ctrl-medium date-picker" size="16" name="final_acceptance" type="text" value="<?=(!empty($formdata['final_acceptance'])? $formdata['final_acceptance'] : '')?>"><span class="add-on"><i
                                            class="fa fa-calendar"></i></span>

                                </div>
                            </div>
                        </div>  
                    
                    </div>
                </div>
            </div>

        </div>
        <label class="checkbox line">
            <div class="checker" id="uniform-undefined"><span class=""><input id="checkBox" type="checkbox" value=""
                                                                              style="opacity: 0;"></span></div>
            I confirm that data entered for annual procurement plan is correct
        </label>

        <div class="message_alerts">

        </div>
        <div class="form-actions">
            <button disabled="disabled" id="submit_plan" value="save_entry" name="save_entry" type="submit" class="btn btn-success">
                Save
            </button>
            <?php if(empty($i)): ?>
            &nbsp;
            <button disabled="disabled" id="submit_plan_add" value="save_entry" name="save_and_new" type="submit" class="btn btn-success">
                Save and Add
            </button>
            <?php endif; ?>
            &nbsp;
            <a class="btn btn-cancel" href="<?= base_url() . $this->uri->segment(1) ?>">Cancel</a>
        </div>
    </form>
    <!-- END FORM-->
</div>


</div>
<!-- END SAMPLE FORM widget-->

<script>
    $(document).ready(function(){
        function showHideXrate()
        {
            if($('#currency').val() == 1)
            {
                $('input[name="exchange_rate"]').hide();
            }
            else
            {
                $('input[name="exchange_rate"]').show();
            }
        }

        showHideXrate();
        
        $("#currency").change(showHideXrate);
        
        //toggle button status depending on checkbox confirmation
        $('#checkBox').click(function(){

            //verify if checkbox is checked
            if($('#checkBox').attr('checked'))
            {
                $("#submit_plan, #submit_plan_add").removeAttr("disabled");
            }
            else
            {
                $("#submit_plan, #submit_plan_add").attr("disabled", "disabled");
            }

        });
        
        
        //hide reference number
        $('.ref_number_area').hide();
        //when a usertype is chosen
        $("#procurement_type").change(function(){
            if($("#procurement_type").val())
            {
                var procurement_type =$("#procurement_type").val();
                
                if($(this).val() == 1){
                    $('.non_consultancy_control').hide();
                    $('.works_control').hide();
                    $('.supplies_control').show();
                
                } else if($(this).val() == 2){
                    $('.supplies_control').hide();
                    $('.works_control').hide();     
                    $('.non_consultancy_control').show();           
                    
                } else if($(this).val() == 3){
                    $('.supplies_control').hide();
                    $('.non_consultancy_control').hide();
                    $('.works_control').show();
                    
                }
            }
        });
           $('.date-picker').datepicker({ dateFormat: 'dd/mm/yyyy' }).val();
    });
</script>