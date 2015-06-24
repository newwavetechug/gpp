<?php
//print_array($_POST);
//print_array($this->session->all_userdata());
//print_array(get_pde_info_by_id($this->session->userdata('pdeid'),'title'))
if(isset($errors)){
    echo error_template($errors);
}

if(isset($results)){
    ?>

    <!-- TAB NAVIGATION -->
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#tab1" role="tab" data-toggle="tab">Report Summary</a></li>
        <li><a href="#tab2" role="tab" data-toggle="tab">Report Details</a></li>

    </ul>
    <!-- TAB CONTENT -->
    <div class="tab-content">
        <div class="active tab-pane fade in" id="tab1">
            <?php
            /*
             * [0] => Array
        (
            [receiptid] => 100
            [bid_id] => 53
            [providerid] => 10
            [details] =>
            [received_by] => rogers
            [datereceived] => 2015-05-07
            [approved] => Y
            [nationality] => Uganda
            [author] => 20
            [dateadded] => 2015-05-05 12:58:58
            [beb] => Y
            [reason] =>
            [isactive] => y
            [joint_venture] =>
            [readoutprice] => 450000
            [currence] => UGX
            [providernames] => MFI  DOCUMENT SOLUTIONS LIMITED
            [id] => 43
            [vote_no] => POSET
            [initiated_by] => Rogers
            [date_initiated] => 2015-05-07
            [bid_openning_date] => 2015-05-07 01:01:00
            [pde_id] => 12
            [subject_of_procurement] => Purchase of Cars
            [cost_estimate] => _COST_ESTIMATE_
            [invitation_to_bid_date] => 2015-05-07 00:00:00
            [pre_bid_meeting_date] => 2015-05-07 01:01:00
            [cc_approval_date] => 2015-05-07
            [bid_receipt_address] => thursday
            [documents_inspection_address] => thursday
            [documents_address_issue] => thursday
            [bid_openning_address] => thursday
            [procurement_ref_no] =>
            [procurement_id] => 92
            [description_of_works] => _DESCRIPTION_OF_WORKS_
            [bid_security_amount] => 1000000
            [bid_security_currency] => 0
            [bid_documents_price] => 34000
            [bid_documents_currency] => 1
            [isapproved] => Y
            [date_approved] => 2015-05-07 09:41:47
            [approvedby] => 20
            [approval_comments] =>
            [bid_submission_deadline] => 2015-05-07 01:01:00
            [bid_evaluation_to] => 2015-05-08
            [bid_evaluation_from] => 2015-05-07 00:00:00
            [display_of_beb_notice] => 2015-05-11 00:00:00
            [contract_award_date] => 2015-05-07 00:00:00
            [dateofconfirmationoffunds] => 2015-05-22 00:00:00
            [procurement_type] => 3
            [procurement_method] => 2
            [pde_department] => Works
            [funding_source] => 2
            [funder_name] =>
            [estimated_amount] => 30000000
            [currency] => 1
            [exchange_rate] => 1
            [pre_bid_events_date] => 1970-01-01 00:00:00
            [pre_bid_events_duration] => 0
            [contracts_committee_approval_date] => 2015-05-06
            [contracts_committee_approval_date_duration] => 0
            [publication_of_pre_qualification_date] => 2015-05-06 00:00:00
            [publication_of_pre_qualification_date_duration] => 0
            [proposal_submission_date] => 2015-05-06 00:00:00
            [proposal_submission_date_duration] => 0
            [contracts_committee_approval_of_shortlist_date] => 2015-05-06
            [contracts_committee_approval_of_shortlist_date_duration] => 0
            [bid_issue_date] => 2015-05-06
            [bid_issue_date_duration] => 0
            [bid_submission_opening_date] => 2015-05-06
            [bid_submission_opening_date_duration] => 0
            [secure_necessary_approval_date] => 1970-01-01 00:00:00
            [secure_necessary_approval_date_duration] => 0
            [contract_award] => 2015-05-06 00:00:00
            [contract_award_duration] => 0
            [performance_security] => 2015-05-06
            [best_evaluated_bidder_date] => 2015-05-06
            [best_evaluated_bidder_date_duration] => 0
            [contract_sign_date] => 2015-05-06
            [contract_sign_duration] => 0
            [submission_of_evaluation_report_to_cc] => 2015-05-06
            [cc_approval_of_evaluation_report] => 2015-05-06
            [accounting_officer_approval_date] => 2015-05-06
            [cc_approval_of_evaluation_report_duration] => 0
            [negotiation_date] => 2015-05-06
            [negotiation_date_duration] => 0
            [negotiation_approval_date] => 2015-05-06
            [negotiation_approval_date_duration] => 0
            [advanced_payment_date] => 1970-01-01
            [advanced_payment_date_duration] => 0
            [mobilise_advance_payment] => 2015-05-06
            [mobilise_advance_payment_duration] => 0
            [substantial_completion] => 2015-05-06
            [substantial_completion_duration] => 0
            [final_acceptance] => 2015-05-06
            [final_acceptance_duration] => 0
            [dateupdated] =>
            [updated_by] => 0
            [procurement_plan_id] => 43
            [solicitor_general_approval_date] => 2015-05-06
            [solicitor_general_approval_duration] =>
            [contract_amount_in_ugx] =>
            [bid_closing_date] => 2015-05-06
            [pdeid] => 12
            [pdename] => Bank of Uganda
            [abbreviation] => BOU
            [status] => in
            [create_date] => 2015-02-18 16:04:06
            [created_by] => 1
            [category] => central government
            [type] => 6
            [code] => X
            [pde_roll_cat] =>
            [address] =>  -
            [tel] => 0000000000
            [fax] =>
            [email] =>
            [website] =>
            [AO] => _AO_
            [AO_phone] => _AOPHONE_
            [AO_email] => _AOEMAIL_
            [CC] => _CC_
            [CC_phone] => _CCPHONE_
            [CC_email] =>
            [head_PDU] => _HEADPDU_
            [head_PDU_phone] => _HEADPDUPHONE_
            [head_PDU_email] => _HEADPDUEMAIL_
            [financial_year] => 2170-2171
            [title] => Testing 2
            [summarized_plan] =>
            [description] => 0
            [public] => n
        )
             */

           // print_array($results);

            $bid_values=array();
            $expired_bids=array();

            $procurement_types=array();

            $pdes=array();
            $results_pde_filtered=array();
            $threshold='1209600';
            $less_than_thresh_hold=array();

            $suspended_providers=array();

            $inconsitent_evalution=array();



            foreach($results as $row){
                $bid_values[]=$row['estimated_amount'];
                //echo $row['estimated_amount'];

                if(!in_array($row['pdeid'],$pdes)){
                    $pdes[]=$row['pdeid'];
                }

                //procurement types
                if($row['procurement_type']){
                    $procurement_types[]=get_procurement_plan_entry_info($row['procurement_id'],'procurement_type');
                }

                //expired bids
                if(strtotime($row['bid_submission_deadline'])<now()){
                    $expired_bids[]=$row['id'];
                }

                //less than threshhold
                if((strtotime($row['bid_submission_deadline'])-strtotime($row['invitation_to_bid_date']))<$threshold){
                    $less_than_thresh_hold[]=$row['id'];
                }

                if((date('d',strtotime($row['bid_submission_deadline'])-strtotime($row['invitation_to_bid_date'])))!=get_procurement_type_info_by_id(get_procurement_plan_entry_info($row['procurement_id'],'procurement_type'),'evaluation_time')){
                    $inconsitent_evalution[]=$row['id'];
                }

                //get suspended provoders
            if(check_live_server()){
                foreach($rop_suspended_providers as $provider){
                    //if names match
                    if($provider==get_provider_info_by_id($row['providerid'],'title')){
                        if(!in_array($row['providerid'],$suspended_providers)){
                            $suspended_providers[]=$row['providerid'];
                        }

                    }
                }
            }


            }

            $occurence_procurement_types=array_count_values($procurement_types);



            ?>

            <div id="print_this">
                <table class="table table-responsive " id="vertical-1">
                    <h2><?=$report_heading?> <br><small>Financial Year : <?=$financial_year?></small></h2>

                    <tr>
                        <th>Reporting Period</th>
                        <td><?=$reporting_period?></td>
                    </tr>
                    <?php
                    if($this->input->post('pde')){
                        ?>
                        <tr>
                            <th>PDE</th>
                            <td><?=get_pde_info_by_id($this->input->post('pde'),'title')?></td>
                        </tr>
                    <?php
                    }
                    ?>
                    <tr class="text_danger">
                        <th>Bids with inconsistent evaluation time </th>
                        <td class="number"><?=count($inconsitent_evalution)?></td>
                    </tr>

                    <tr class="text_danger">
                        <th>Bids below threshold (<?=seconds_to_days($threshold)?>)</th>
                        <td class="number"><?=count($less_than_thresh_hold)?></td>
                    </tr>

                    <tr class="text_success">
                        <th>Bids above threshold (<?=seconds_to_days($threshold)?>)</th>
                        <td class="number"><?=count($results)-count($less_than_thresh_hold)?></td>
                    </tr>

                    <tr class="text_success">
                        <th>Bids still active</th>
                        <td class="number"><?=count($results)-count($expired_bids)?></td>
                    </tr>

                    <tr class="text_danger">
                        <th>Bids past deadline</th>
                        <td class="number"><?=count($expired_bids)?></td>
                    </tr>



                    <?php


                    if(check_live_server()){
                        ?>
                        <tr class="text_danger">
                            <th>Bids awarded to suspended providers</th>
                            <td class="number"><?=count($suspended_providers)?></td>
                        </tr>
                    <?php
                    }
                    ?>






                    <tr>
                        <th>Bids by procurement type</th>
                        <td>

                            <ul class="unstyled">
                                <?php
                                foreach(get_active_procurement_types() as $type){
                                    if(in_array($type['title'],$procurement_types)){
                                        ?>
                                        <li class="list-group-item"><?=$type['title']?><span>&nbsp; &nbsp;<?=$occurence_procurement_types[$type['title']]?></span> </li>
                                    <?php

                                    }
                                }
                                ?>
                            </ul>

                        </td>
                    </tr>
                    <tr>
                        <th>PDEs</th>
                        <td class="number"><?=count($pdes)?></td>
                    </tr>

                    <tr>
                        <th>Total Bid invitations</th>
                        <td class="number"><?=count($results)?></td>
                    </tr>


                    <tr>
                        <th>Total Bid value (UGX)</th>
                        <td class="number"><?=array_sum($bid_values)?></td>
                    </tr>


                </table>
            </div>
            <p>

                <a class="btn" href="#" onclick="printContent('print_this')"> PRINT </a>
            </p>



        </div>
        <div class="tab-pane fade" id="tab2">
            <h2><?=$report_heading?> <br><small>Financial year : <?=$financial_year?></small></h2>
            Reportinf period : <?=$reporting_period?>


            <p>
                <?php
                //print_array($results)


                ?>

            <table  id=""  class="display table table-hover dt-responsive ">
                <thead>
                <tr>
                    <th>PDE</th>

                    <th>Procurement ref.no</th>
                    <th class="hidden-480">Subject of procurement</th>
                    <th class="hidden-480">Procurement Value</th>

                    <th class="hidden-480">Invitation date</th>
                    <th class="hidden-480">Submission deadline</th>

                </tr>
                </thead>
                <tbody>
                <?php

                //print_array($results);
                foreach($results as $row){

                    ?>
                    <tr>
                        <td class="hidden-480"><?=get_procurement_plan_entry_info($row['procurement_id'],'pde')?></td>
                        <td><?=$row['procurement_ref_no']?></td>
                        <td class="hidden-480"><?=get_procurement_plan_entry_info($row['procurement_id'],'title')?></td>
                        <td class="hidden-480"><?=number_format(get_procurement_plan_entry_info($row['procurement_id'],'estimated_amount'))?></td>
                        <td><?= custom_date_format('d-M-Y', $row['invitation_to_bid_date']) ?></td>
                        <td><?= custom_date_format('d-M-Y', $row['bid_submission_deadline']) ?></td>

                    </tr>

                <?php



                }
                ?>

                </tbody>
            </table>
            </p>

            <p>

                <a class="btn " href="#" onClick="$('.display').tableExport({type:'excel',escape:'false'});">EXPORT</a>
            </p>


        </div>

    </div>

<?php
}
?>



