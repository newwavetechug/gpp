<div class="row-fluid">
    <div class="span12">
        <div class="widget">
            <div class="widget-title">
                <h4><i class="icon-edit"></i><a href=""> Edit content</a></h4>
                           <span class="tools">
                               <i class="icon-plus"></i><a href="<?=base_url().$this->uri->segment(1).'/new_entry/'?>m/<?=encryptValue(get_procurement_plan_entry_info(decryptValue($this->uri->segment(4)),'procurement_plan_id'))?>"> New entry</a>
                           <a href="javascript:;" class="icon-chevron-down"></a>
                           <a href="javascript:;" class="icon-remove"></a>
                           </span>
            </div>
            <div class="widget-body">

                <div class="space20"></div>
                <div class="row-fluid invoice-list">
                    <div class="span4">
                        <h5><?=strtoupper($page_title)?></h5>
                        <p>
                            <b><?=get_procurement_plan_entry_info($entry_id,'procurement_plan')?></b>
                        </p>
                        <p>
                            Reference number: <?=get_procurement_plan_entry_info($entry_id,'procurement_ref_no')?><br>
                            Procurement Type: <?=get_procurement_plan_entry_info($entry_id,'procurement_type')?><br>
                            Procurement Method: <?=get_procurement_plan_entry_info($entry_id,'procurement_method')?><br>
                            Department: <?=get_procurement_plan_entry_info($entry_id,'department')?><br>
                            Source funding: <?=get_procurement_plan_entry_info($entry_id,'funding_source')?><br>

                        </p>
                        <p>
                            <b>Estimated Amount: <?=get_procurement_plan_entry_info($entry_id,'estimated_amount')?></b>
                        </p>
                    </div>


                </div>

                <div class="row-fluid">
                    <div class="widget">
                        <div class="widget-title">
                            <h4></i>Pre-qualification period</h4>

                        </div>
                        <div class="widget-body">
                            <table class="table table-hover">
                                <thead>
                                <tr>

                                    <th>Activity</th>

                                    <th>Start date</th>

                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Pre-bid events</td>
                                    <td><?=substr(get_procurement_plan_entry_info($entry_id,'pre_bid_events_date'),0,10)?><br><small><b>Duration</b>: <?=get_procurement_plan_entry_info($entry_id,'pre_bid_events_duration')?> day(s)</small></td>
                                    <td>
                                        <span class=""><?=days_time_left((get_procurement_plan_entry_info($entry_id,'pre_bid_events_duration')*60*60*60)+date_to_seconds(get_procurement_plan_entry_info($entry_id,'pre_bid_events_date')))?></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Contracts Committee approval </td>
                                    <td><?=substr(get_procurement_plan_entry_info($entry_id,'contracts_committee_approval_date'),0,10)?><br><small><b>Duration</b>: <?=get_procurement_plan_entry_info($entry_id,'pre_bid_events_duration')?> day(s)</small></td>
                                    <td>
                                        <span class=""><?=days_time_left((get_procurement_plan_entry_info($entry_id,'contracts_committee_approval_date_duration')*60*60*60)+date_to_seconds(get_procurement_plan_entry_info($entry_id,'contracts_committee_approval_date')))?></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>publication of pre qualification</td>
                                    <td><?=substr(get_procurement_plan_entry_info($entry_id,'publication_of_pre_qualification_date'),0,10)?><br><small><b>Duration</b>: <?=get_procurement_plan_entry_info($entry_id,'publication_of_pre_qualification_date_duration')?> day(s)</small></td>
                                    <td>
                                        <span class=""><?=days_time_left((get_procurement_plan_entry_info($entry_id,'publication_of_pre_qualification_date_duration')*60*60*60)+date_to_seconds(get_procurement_plan_entry_info($entry_id,'publication_of_pre_qualification_date')))?></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Contracts Committee approval date</td>
                                    <td><?=substr(get_procurement_plan_entry_info($entry_id,'contracts_committee_approval_date'),0,10)?><br><small><b>Duration</b>: <?=get_procurement_plan_entry_info($entry_id,'pre_bid_events_duration')?> day(s)</small></td>
                                    <td>
                                        <span class=""><?=days_time_left((get_procurement_plan_entry_info($entry_id,'contracts_committee_approval_date_duration')*60*60*60)+date_to_seconds(get_procurement_plan_entry_info($entry_id,'contracts_committee_approval_date')))?></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Proposal submission</td>
                                    <td><?=substr(get_procurement_plan_entry_info($entry_id,'proposal_submission_date'),0,10)?><br><small><b>Duration</b>: <?=get_procurement_plan_entry_info($entry_id,'proposal_submission_date_duration')?> day(s)</small></td>
                                    <td>
                                        <span class=""><?=days_time_left((get_procurement_plan_entry_info($entry_id,'proposal_submission_date_duration')*60*60*60)+date_to_seconds(get_procurement_plan_entry_info($entry_id,'proposal_submission_date')))?></span>
                                    </td>
                                </tr>


                                <tr>
                                    <td>contracts committee_approval of shortlist_date</td>
                                    <td><?=substr(get_procurement_plan_entry_info($entry_id,'contracts_committee_approval_of_shortlist_date'),0,10)?><br><small><b>Duration</b>: <?=get_procurement_plan_entry_info($entry_id,'contracts_committee_approval_of_shortlist_date_duration')?> day(s)</small></td>
                                    <td>
                                        <span class=""><?=days_time_left((get_procurement_plan_entry_info($entry_id,'contracts_committee_approval_of_shortlist_date_duration')*60*60*60)+date_to_seconds(get_procurement_plan_entry_info($entry_id,'contracts_committee_approval_of_shortlist_date')))?></span>
                                    </td>
                                </tr>







                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <div class="row-fluid">
                    <div class="widget">
                        <div class="widget-title">
                            <h4></i>Pre-qualification period</h4>

                        </div>
                        <div class="widget-body">
                            <table class="table table-hover">
                                <thead>
                                <tr>

                                    <th>Activity</th>

                                    <th>Start date</th>

                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Pre-bid events</td>
                                    <td><?=substr(get_procurement_plan_entry_info($entry_id,'pre_bid_events_date'),0,10)?><br><small><b>Duration</b>: <?=get_procurement_plan_entry_info($entry_id,'pre_bid_events_duration')?> day(s)</small></td>
                                    <td>
                                        <span class=""><?=days_time_left((get_procurement_plan_entry_info($entry_id,'pre_bid_events_duration')*60*60*60)+date_to_seconds(get_procurement_plan_entry_info($entry_id,'pre_bid_events_date')))?></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Contracts Committee approval </td>
                                    <td><?=substr(get_procurement_plan_entry_info($entry_id,'contracts_committee_approval_date'),0,10)?><br><small><b>Duration</b>: <?=get_procurement_plan_entry_info($entry_id,'pre_bid_events_duration')?> day(s)</small></td>
                                    <td>
                                        <span class=""><?=days_time_left((get_procurement_plan_entry_info($entry_id,'contracts_committee_approval_date_duration')*60*60*60)+date_to_seconds(get_procurement_plan_entry_info($entry_id,'contracts_committee_approval_date')))?></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>publication of pre qualification</td>
                                    <td><?=substr(get_procurement_plan_entry_info($entry_id,'publication_of_pre_qualification_date'),0,10)?><br><small><b>Duration</b>: <?=get_procurement_plan_entry_info($entry_id,'publication_of_pre_qualification_date_duration')?> day(s)</small></td>
                                    <td>
                                        <span class=""><?=days_time_left((get_procurement_plan_entry_info($entry_id,'publication_of_pre_qualification_date_duration')*60*60*60)+date_to_seconds(get_procurement_plan_entry_info($entry_id,'publication_of_pre_qualification_date')))?></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Contracts Committee approval date</td>
                                    <td><?=substr(get_procurement_plan_entry_info($entry_id,'contracts_committee_approval_date'),0,10)?><br><small><b>Duration</b>: <?=get_procurement_plan_entry_info($entry_id,'pre_bid_events_duration')?> day(s)</small></td>
                                    <td>
                                        <span class=""><?=days_time_left((get_procurement_plan_entry_info($entry_id,'contracts_committee_approval_date_duration')*60*60*60)+date_to_seconds(get_procurement_plan_entry_info($entry_id,'contracts_committee_approval_date')))?></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Proposal submission</td>
                                    <td><?=substr(get_procurement_plan_entry_info($entry_id,'proposal_submission_date'),0,10)?><br><small><b>Duration</b>: <?=get_procurement_plan_entry_info($entry_id,'proposal_submission_date_duration')?> day(s)</small></td>
                                    <td>
                                        <span class=""><?=days_time_left((get_procurement_plan_entry_info($entry_id,'proposal_submission_date_duration')*60*60*60)+date_to_seconds(get_procurement_plan_entry_info($entry_id,'proposal_submission_date')))?></span>
                                    </td>
                                </tr>


                                <tr>
                                    <td>contracts committee_approval of shortlist_date</td>
                                    <td><?=substr(get_procurement_plan_entry_info($entry_id,'contracts_committee_approval_of_shortlist_date'),0,10)?><br><small><b>Duration</b>: <?=get_procurement_plan_entry_info($entry_id,'contracts_committee_approval_of_shortlist_date_duration')?> day(s)</small></td>
                                    <td>
                                        <span class=""><?=days_time_left((get_procurement_plan_entry_info($entry_id,'contracts_committee_approval_of_shortlist_date_duration')*60*60*60)+date_to_seconds(get_procurement_plan_entry_info($entry_id,'contracts_committee_approval_of_shortlist_date')))?></span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <div class="row-fluid">
                    <div class="widget">
                        <div class="widget-title">
                            <h4></i>Bidding period</h4>

                        </div>
                        <div class="widget-body">
                            <table class="table table-hover">
                                <thead>
                                <tr>

                                    <th>Activity</th>

                                    <th>Start date</th>

                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>




                                <tr>
                                    <td>Bid submission opening </td>
                                    <td><?=substr(get_procurement_plan_entry_info($entry_id,'bid_submission_opening_date'),0,10)?><br><small><b>Duration</b>: <?=get_procurement_plan_entry_info($entry_id,'bid_submission_opening_date_duration')?> day(s)</small></td>
                                    <td>
                                        <span class=""><?=days_time_left((get_procurement_plan_entry_info($entry_id,'bid_submission_opening_date_duration')*60*60*60)+date_to_seconds(get_procurement_plan_entry_info($entry_id,'bid_submission_opening_date')))?></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Bid issue date</td>
                                    <td><?=substr(get_procurement_plan_entry_info($entry_id,'bid_issue_date'),0,10)?><br><small><b>Duration</b>: <?=get_procurement_plan_entry_info($entry_id,'bid_issue_date_duration')?> day(s)</small></td>
                                    <td>
                                        <span class=""><?=days_time_left((get_procurement_plan_entry_info($entry_id,'bid_issue_date_duration')*60*60*60)+date_to_seconds(get_procurement_plan_entry_info($entry_id,'bid_issue_date')))?></span>
                                    </td>
                                </tr>





                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>


                <div class="row-fluid">
                    <div class="widget">
                        <div class="widget-title">
                            <h4></i>Bid evaluation period</h4>

                        </div>
                        <div class="widget-body">
                            <table class="table table-hover">
                                <thead>
                                <tr>

                                    <th>Activity</th>

                                    <th>Start date</th>

                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>


                                <tr>
                                    <td>cc approval of evaluation_report</td>
                                    <td><?=substr(get_procurement_plan_entry_info($entry_id,'cc_approval_of_evaluation_report'),0,10)?><br><small><b>Duration</b>: <?=get_procurement_plan_entry_info($entry_id,'cc_approval_of_evaluation_report_duration')?> day(s)</small></td>
                                    <td>
                                        <span class=""><?=days_time_left((get_procurement_plan_entry_info($entry_id,'cc_approval_of_evaluation_report_duration')*60*60*60)+date_to_seconds(get_procurement_plan_entry_info($entry_id,'cc_approval_of_evaluation_report')))?></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>negotiation_date</td>
                                    <td><?=substr(get_procurement_plan_entry_info($entry_id,'negotiation_date'),0,10)?><br><small><b>Duration</b>: <?=get_procurement_plan_entry_info($entry_id,'negotiation_date_duration')?> day(s)</small></td>
                                    <td>
                                        <span class=""><?=days_time_left((get_procurement_plan_entry_info($entry_id,'negotiation_date_duration')*60*60*60)+date_to_seconds(get_procurement_plan_entry_info($entry_id,'negotiation_date')))?></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>negotiation approval date</td>
                                    <td><?=substr(get_procurement_plan_entry_info($entry_id,'negotiation_approval_date'),0,10)?><br><small><b>Duration</b>: <?=get_procurement_plan_entry_info($entry_id,'negotiation_approval_date_duration')?> day(s)</small></td>
                                    <td>
                                        <span class=""><?=days_time_left((get_procurement_plan_entry_info($entry_id,'negotiation_approval_date_duration')*60*60*60)+date_to_seconds(get_procurement_plan_entry_info($entry_id,'negotiation_approval_date')))?></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>advanced payment date</td>
                                    <td><?=substr(get_procurement_plan_entry_info($entry_id,'advanced_payment_date'),0,10)?><br><small><b>Duration</b>: <?=get_procurement_plan_entry_info($entry_id,'advanced_payment_date_duration')?> day(s)</small></td>
                                    <td>
                                        <span class=""><?=days_time_left((get_procurement_plan_entry_info($entry_id,'advanced_payment_date_duration')*60*60*60)+date_to_seconds(get_procurement_plan_entry_info($entry_id,'advanced_payment_date')))?></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>mobilise advance payment</td>
                                    <td><?=substr(get_procurement_plan_entry_info($entry_id,'mobilise_advance_payment'),0,10)?><br><small><b>Duration</b>: <?=get_procurement_plan_entry_info($entry_id,'mobilise_advance_payment_duration')?> day(s)</small></td>
                                    <td>
                                        <span class=""><?=days_time_left((get_procurement_plan_entry_info($entry_id,'mobilise_advance_payment_duration')*60*60*60)+date_to_seconds(get_procurement_plan_entry_info($entry_id,'mobilise_advance_payment')))?></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>substantial completion</td>
                                    <td><?=substr(get_procurement_plan_entry_info($entry_id,'substantial_completion'),0,10)?><br><small><b>Duration</b>: <?=get_procurement_plan_entry_info($entry_id,'substantial_completion_duration')?> day(s)</small></td>
                                    <td>
                                        <span class=""><?=days_time_left((get_procurement_plan_entry_info($entry_id,'substantial_completion_duration')*60*60*60)+date_to_seconds(get_procurement_plan_entry_info($entry_id,'substantial_completion')))?></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>final acceptance</td>
                                    <td><?=substr(get_procurement_plan_entry_info($entry_id,'final_acceptance'),0,10)?><br><small><b>Duration</b>: <?=get_procurement_plan_entry_info($entry_id,'final_acceptance_duration')?> day(s)</small></td>
                                    <td>
                                        <span class=""><?=days_time_left((get_procurement_plan_entry_info($entry_id,'final_acceptance_duration')*60*60*60)+date_to_seconds(get_procurement_plan_entry_info($entry_id,'final_acceptance')))?></span>
                                    </td>
                                </tr>



                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>


                <div class="row-fluid">
                    <div class="widget">
                        <div class="widget-title">
                            <h4></i>Negotiation period</h4>

                        </div>
                        <div class="widget-body">
                            <table class="table table-hover">
                                <thead>
                                <tr>

                                    <th>Activity</th>

                                    <th>Start date</th>

                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>


                                <tr>
                                    <td>secure necessary approval date</td>
                                    <td><?=substr(get_procurement_plan_entry_info($entry_id,'secure_necessary_approval_date'),0,10)?><br><small><b>Duration</b>: <?=get_procurement_plan_entry_info($entry_id,'secure_necessary_approval_date_duration')?> day(s)</small></td>
                                    <td>
                                        <span class=""><?=days_time_left((get_procurement_plan_entry_info($entry_id,'secure_necessary_approval_date_duration')*60*60*60)+date_to_seconds(get_procurement_plan_entry_info($entry_id,'secure_necessary_approval_date')))?></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>contract award</td>
                                    <td><?=substr(get_procurement_plan_entry_info($entry_id,'contract_award'),0,10)?><br><small><b>Duration</b>: <?=get_procurement_plan_entry_info($entry_id,'contract_award_duration')?> day(s)</small></td>
                                    <td>
                                        <span class=""><?=days_time_left((get_procurement_plan_entry_info($entry_id,'contract_award_duration')*60*60*60)+date_to_seconds(get_procurement_plan_entry_info($entry_id,'contract_award')))?></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>best evaluated bidder date</td>
                                    <td><?=substr(get_procurement_plan_entry_info($entry_id,'best_evaluated_bidder_date'),0,10)?><br><small><b>Duration</b>: <?=get_procurement_plan_entry_info($entry_id,'best_evaluated_bidder_date_duration')?> day(s)</small></td>
                                    <td>
                                        <span class=""><?=days_time_left((get_procurement_plan_entry_info($entry_id,'best_evaluated_bidder_date_duration')*60*60*60)+date_to_seconds(get_procurement_plan_entry_info($entry_id,'best_evaluated_bidder_date')))?></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>contract sign date</td>
                                    <td><?=substr(get_procurement_plan_entry_info($entry_id,'contract_sign_date'),0,10)?><br><small><b>Duration</b>: <?=get_procurement_plan_entry_info($entry_id,'contract_sign_date_duration')?> day(s)</small></td>
                                    <td>
                                        <span class=""><?=days_time_left((get_procurement_plan_entry_info($entry_id,'contract_sign_date_duration')*60*60*60)+date_to_seconds(get_procurement_plan_entry_info($entry_id,'contract_sign_date')))?></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>cc approval of evaluation_report</td>
                                    <td><?=substr(get_procurement_plan_entry_info($entry_id,'cc_approval_of_evaluation_report'),0,10)?><br><small><b>Duration</b>: <?=get_procurement_plan_entry_info($entry_id,'cc_approval_of_evaluation_report_duration')?> day(s)</small></td>
                                    <td>
                                        <span class=""><?=days_time_left((get_procurement_plan_entry_info($entry_id,'cc_approval_of_evaluation_report_duration')*60*60*60)+date_to_seconds(get_procurement_plan_entry_info($entry_id,'cc_approval_of_evaluation_report')))?></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>negotiation_date</td>
                                    <td><?=substr(get_procurement_plan_entry_info($entry_id,'negotiation_date'),0,10)?><br><small><b>Duration</b>: <?=get_procurement_plan_entry_info($entry_id,'negotiation_date_duration')?> day(s)</small></td>
                                    <td>
                                        <span class=""><?=days_time_left((get_procurement_plan_entry_info($entry_id,'negotiation_date_duration')*60*60*60)+date_to_seconds(get_procurement_plan_entry_info($entry_id,'negotiation_date')))?></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>negotiation approval date</td>
                                    <td><?=substr(get_procurement_plan_entry_info($entry_id,'negotiation_approval_date'),0,10)?><br><small><b>Duration</b>: <?=get_procurement_plan_entry_info($entry_id,'negotiation_approval_date_duration')?> day(s)</small></td>
                                    <td>
                                        <span class=""><?=days_time_left((get_procurement_plan_entry_info($entry_id,'negotiation_approval_date_duration')*60*60*60)+date_to_seconds(get_procurement_plan_entry_info($entry_id,'negotiation_approval_date')))?></span>
                                    </td>
                                </tr>



                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>


                <div class="row-fluid">
                    <div class="widget">
                        <div class="widget-title">
                            <h4></i>Contract implementation period</h4>

                        </div>
                        <div class="widget-body">
                            <table class="table table-hover">
                                <thead>
                                <tr>

                                    <th>Activity</th>

                                    <th>Start date</th>

                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>


                                <tr>
                                    <td>mobilise advance payment</td>
                                    <td><?=substr(get_procurement_plan_entry_info($entry_id,'mobilise_advance_payment'),0,10)?><br><small><b>Duration</b>: <?=get_procurement_plan_entry_info($entry_id,'mobilise_advance_payment_duration')?> day(s)</small></td>
                                    <td>
                                        <span class=""><?=days_time_left((get_procurement_plan_entry_info($entry_id,'mobilise_advance_payment_duration')*60*60*60)+date_to_seconds(get_procurement_plan_entry_info($entry_id,'mobilise_advance_payment')))?></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>substantial completion</td>
                                    <td><?=substr(get_procurement_plan_entry_info($entry_id,'substantial_completion'),0,10)?><br><small><b>Duration</b>: <?=get_procurement_plan_entry_info($entry_id,'substantial_completion_duration')?> day(s)</small></td>
                                    <td>
                                        <span class=""><?=days_time_left((get_procurement_plan_entry_info($entry_id,'substantial_completion_duration')*60*60*60)+date_to_seconds(get_procurement_plan_entry_info($entry_id,'substantial_completion')))?></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>final acceptance</td>
                                    <td><?=substr(get_procurement_plan_entry_info($entry_id,'final_acceptance'),0,10)?><br><small><b>Duration</b>: <?=get_procurement_plan_entry_info($entry_id,'final_acceptance_duration')?> day(s)</small></td>
                                    <td>
                                        <span class=""><?=days_time_left((get_procurement_plan_entry_info($entry_id,'final_acceptance_duration')*60*60*60)+date_to_seconds(get_procurement_plan_entry_info($entry_id,'final_acceptance')))?></span>
                                    </td>
                                </tr>



                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>





                <div class="space20"></div>
                <div class="row-fluid text-center">
                    <?php
                    //if person can edit
                    if(check_my_access('edit_procurement_plan'))
                    {
                        ?>
                        <a href="<?=base_url().$this->uri->segment(1).'/edit_entry/i/'.encryptValue($entry_id)?>" class="btn btn-primary btn-large hidden-print"><i class="icon-edit"></i> Edit entry <i class="m-icon-big-swapright m-icon-white"></i></a>
                    <?php

                    }
                    ?>

                    <a onclick="javascript:window.print();" class="btn btn-success btn-large hidden-print">Print <i class="icon-print icon-big"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>