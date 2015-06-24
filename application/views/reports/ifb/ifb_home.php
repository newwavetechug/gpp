<?php
//print_array($_POST);
//print_array($this->session->all_userdata());
//print_array(get_pde_info_by_id($this->session->userdata('pdeid'),'title'))

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
                [id] => 55
                [vote_no] => werpp
                [initiated_by] => rogers
                [date_initiated] => 2015-05-08
                [bid_openning_date] => 2015-05-08 13:01:00
                [pde_id] => 0
                [subject_of_procurement] => _SUBJECT_OF_PROCUREMENT_
                [cost_estimate] => _COST_ESTIMATE_
                [invitation_to_bid_date] => 2015-05-08 00:00:00
                [pre_bid_meeting_date] => 2015-05-08 13:05:00
                [cc_approval_date] => 2015-05-08
                [bid_receipt_address] => q
                [documents_inspection_address] => q
                [documents_address_issue] => q
                [bid_openning_address] => q
                [procurement_ref_no] => BOU/WRKS/2014-2015/34409AP
                [procurement_id] => 94
                [description_of_works] => _DESCRIPTION_OF_WORKS_
                [bid_security_amount] => 2300
                [bid_security_currency] => 1
                [bid_documents_price] => 89000
                [bid_documents_currency] => 1
                [author] => 20
                *[isapproved] => Y
                [date_approved] => 2015-05-08 06:28:07
                [dateadded] => 2015-05-08 09:27:46
                [approvedby] => 20
                [approval_comments] =>
                [isactive] => Y
                [bid_submission_deadline] => 2015-05-08 13:07:00
                [bid_evaluation_to] => 2015-05-09
                [bid_evaluation_from] => 2015-05-08 00:00:00
                [display_of_beb_notice] => 2015-05-11 00:00:00
                [contract_award_date] => 2015-05-10 00:00:00
                [dateofconfirmationoffunds] => 2015-05-13 00:00:00
            )
             */

            $bid_values=array();
            $expired_bids=array();
            $less_than_thresh_hold=array();
            $threshold='1209600';

            $procurement_types=array();

            $pdes=array();
            $results_pde_filtered=array();

            $suspended_providers=array();



            //print_array($results);

            //get total bid invivation value

            //print_array($_POST);
            //print_array($last_query);

            //print_array($this->input->post('pde'));

            //when filtering every thing
            foreach($results as $row){
                $bid_values[]=get_procurement_plan_entry_info($row['procurement_id'],'estimated_amount');

                if(!in_array(get_procurement_plan_entry_info($row['procurement_id'],'pde'),$pdes)){
                    $pdes[]=get_procurement_plan_entry_info($row['procurement_id'],'pde');
                }

                //expired bids
                if(strtotime($row['bid_submission_deadline'])<now()){
                    $expired_bids[]=$row['id'];
                }

                //less than threshhold
                if((strtotime($row['bid_submission_deadline'])-strtotime($row['invitation_to_bid_date']))<$threshold){
                    $less_than_thresh_hold[]=$row['id'];
                }

                //procurement types
                if(get_procurement_plan_entry_info($row['procurement_id'],'procurement_type')){
                    $procurement_types[]=get_procurement_plan_entry_info($row['procurement_id'],'procurement_type');
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







                    <tr style="color: #e74955">
                        <th>Bids below threshold (<?=seconds_to_days($threshold)?>)</th>
                        <td class=" "><?=number_format(count($less_than_thresh_hold));?></td>
                    </tr>

                    <tr style="color: #809116;">
                        <th>Bids above threshold (<?=seconds_to_days($threshold)?>)</th>
                        <td class=" "><?=number_format(count($results)-count($less_than_thresh_hold));?></td>
                    </tr>

                    <tr style="color: #809116;">
                        <th>Bids still active</th>
                        <td class=" "><?=number_format(count($results)-count($expired_bids));?></td>
                    </tr>

                    <tr style="color: #e74955">
                        <th>Bids past deadline</th>
                        <td class=" "><?=number_format(count($expired_bids));?></td>
                    </tr>



                    <tr>
                        <th>Bids due to close next week</th>
                        <td class=" "><?=number_format(count(get_bids_due_to_expire_next_week()));?></td>
                    </tr>


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
                        <td  ><?=number_format(count($pdes));?></td>
                    </tr>

                    <tr>
                        <th>Total Bid invitations</th>
                        <td  ><?=number_format(count($results));?></td>
                    </tr>


                    <tr>
                        <th>Total Bid value (UGX)</th>
                        <td  ><?=number_format(array_sum($bid_values))?></td>
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

                <a class="btn" href="#" onClick="$('.display').tableExport({type:'excel',escape:'false'});">  EXPORT</a>
            </p>


        </div>

    </div>

<?php
}
?>

<script type="text/javascript">
    $(document).ready(function(){
        $("#report tr:odd").addClass("odd");
        $("#report tr:not(.odd)").hide();
        $("#report tr:first-child").show();

        $("#report tr.odd").click(function(){
            $(this).next("tr").toggle();
            $(this).find(".arrow").toggleClass("up");
        });
        //$("#report").jExpand();
    });
</script>



