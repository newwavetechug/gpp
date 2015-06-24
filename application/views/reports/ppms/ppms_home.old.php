<?php
//print_array($results);
//print_array($this->session->all_userdata());
//print_array(get_pde_info_by_id($this->session->userdata('pdeid'),'title'))

if(isset($errors)){
    echo error_template($errors);
}

//if there are results to display
if(isset($results)){
    //if there is a report type
    if(isset($report_type)){
        switch($report_type){
            case 'timeliness_of_contract_completion':
                ?>

                <table  id=""  class="display table table-hover dt-responsive ">
                    <thead>
                    <tr>
                        <th>PDE</th>
                        <th>Procurement ref.no</th>
                        <th>Procurement type</th>
                        <th>Procurement method</th>
                        <th>Subject of procurement</th>
                        <th>Procurement value <br>(UGX)</th>
                        <th class="hidden-480">Planned date of completion</th>
                        <th class="hidden-480">Actual date of completion</th>
                        <th class="hidden-480">Status<br>(Days)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    //print_array($results);
                    foreach($results as $row){
                        //if pde filter is set
                        if(isset($filter_by_pde)){
                            if($filter_by_pde==get_procurement_plan_entry_info($row['procurement_ref_id'],'pde_id')){
                                ?>
                                <tr>
                                    <td><?=get_procurement_plan_entry_info($row['procurement_ref_id'],'pde')?></td>
                                    <td><?=get_procurement_plan_entry_info($row['procurement_ref_id'],'procurement_ref_no')?></td>
                                    <td><?=get_procurement_plan_entry_info($row['procurement_ref_id'],'procurement_type')?></td>
                                    <td><?=get_procurement_plan_entry_info($row['procurement_ref_id'],'procurement_method')?></td>
                                    <td><?=get_procurement_plan_entry_info($row['procurement_ref_id'],'subject_of_procurement')?></td>
                                    <td><?=get_procurement_plan_entry_info($row['procurement_ref_id'],'estimated_amount')?></td>
                                    <td class="hidden-480"><?=date('d-F-Y',(strtotime($row['commencement_date'])+$row['days_duration']*24*60*60))?></td>
                                    <td class="hidden-480"><?=custom_date_format('d-M-Y',$row['completion_date'])?></td>
                                    <td class="hidden-480"><?=((strtotime(date('d-M-Y',(strtotime($row['commencement_date'])+$row['days_duration']*24*60*60)))-strtotime(custom_date_format('d-M-Y',$row['completion_date'])))/86400)<0?substr((strtotime(date('d-M-Y',(strtotime($row['commencement_date'])+$row['days_duration']*24*60*60)))-strtotime(custom_date_format('d-M-Y',$row['completion_date'])))/86400,1).'<span class="label label-important pull-right"> late</span>':((strtotime(date('d-F-Y',(strtotime($row['commencement_date'])+$row['days_duration']*24*60*60)))-strtotime(custom_date_format('d-F-Y',$row['completion_date'])))/86400).' <span class="label label-success pull-right"> early</span>'?></td>
                                </tr>
                            <?php
                            }


                        }else{
                            ?>
                            <tr>
                                <td><?=get_procurement_plan_entry_info($row['procurement_ref_id'],'pde')?></td>
                                <td><?=get_procurement_plan_entry_info($row['procurement_ref_id'],'procurement_ref_no')?></td>
                                <td><?=get_procurement_plan_entry_info($row['procurement_ref_id'],'procurement_type')?></td>
                                <td><?=get_procurement_plan_entry_info($row['procurement_ref_id'],'procurement_method')?></td>
                                <td><?=get_procurement_plan_entry_info($row['procurement_ref_id'],'subject_of_procurement')?></td>
                                <td style="text-align: right;"><?=get_procurement_plan_entry_info($row['procurement_ref_id'],'estimated_amount')?></td>
                                <td class="hidden-480"><?=date('d-F-Y',(strtotime($row['commencement_date'])+$row['days_duration']*24*60*60))?></td>
                                <td class="hidden-480"><?=custom_date_format('d-M-Y',$row['completion_date'])?></td>
                                <td class="hidden-480"><?=((strtotime(date('d-M-Y',(strtotime($row['commencement_date'])+$row['days_duration']*24*60*60)))-strtotime(custom_date_format('d-M-Y',$row['completion_date'])))/86400)<0?substr((strtotime(date('d-M-Y',(strtotime($row['commencement_date'])+$row['days_duration']*24*60*60)))-strtotime(custom_date_format('d-M-Y',$row['completion_date'])))/86400,1).'<span class="label label-important pull-right"> late</span>':((strtotime(date('d-F-Y',(strtotime($row['commencement_date'])+$row['days_duration']*24*60*60)))-strtotime(custom_date_format('d-F-Y',$row['completion_date'])))/86400).' <span class="label label-success pull-right"> early</span>'?></td>
                            </tr>
                        <?php

                        }



                    }
                    ?>

                    </tbody>
                </table>


                <?php
                break;

            case 'contracts_completed_within_original_value':
                ?>

                <table id="" class="display" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Date of completion</th>
                        <th>PDE</th>
                        <th>Procurement ref.no</th>
                        <th>Procurement type</th>
                        <th>Procurement method</th>
                        <th>Subject of procurement</th>
                        <th>Contract price (UGX)</th>
                        <th>Actual payment (UGX)</th>
                        <th>Value of variation (UGX)</th>
                        <th>Percentage variation</th>

                    </tr>
                    </thead>


                    <tbody>
                    <?php

                    $actual_price_total = array();
                    $actual_payment_total = array();
                    $value_of_variation = array();

                    foreach ($results as $row) {

                        //get those those whose percentage is lower
                        $actual_price = get_contract_price_info_by_contract($row['id'], 'amount') * get_contract_price_info_by_contract($row['id'], 'rate');
                        $actual_payment = get_contract_total_payment_info_by_contract($row['id'], 'amount') * get_contract_total_payment_info_by_contract($row['id'], 'rate');


                                if ($actual_price > $actual_payment) {
                                    if(isset($filter_by_pde)){
                                        if($filter_by_pde==get_procurement_plan_entry_info($row['procurement_ref_id'], 'pde_id')){
                                            ?>
                                            <tr>
                                                <td><?= custom_date_format('d-M-Y', $row['completion_date']) ?></td>
                                                <td><?= get_procurement_plan_entry_info($row['procurement_ref_id'], 'pde') ?></td>
                                                <td><?=get_procurement_plan_entry_info($row['procurement_ref_id'],'procurement_ref_no')?></td>

                                                <td><?=get_procurement_plan_entry_info($row['procurement_ref_id'],'procurement_type')?></td>
                                                <td><?=get_procurement_plan_entry_info($row['procurement_ref_id'],'procurement_method')?></td>

                                                <td ><?= get_procurement_plan_entry_info($row['procurement_ref_id'], 'subject_of_procurement') ?></td>
                                                <td style="text-align: right;">
                                                    <?php
                                                    $actual_price_total[] = $actual_price;
                                                    echo number_format($actual_price, 0);
                                                    ?>
                                                </td>
                                                <td style="text-align: right;">
                                                    <?php
                                                    $actual_payment_total[] = $actual_payment;
                                                    echo number_format($actual_payment);
                                                    ?>
                                                </td>
                                                <td style="text-align: right;">
                                                    <?php
                                                    $value_of_variation[] = $actual_price - $actual_payment;
                                                    echo number_format(($actual_price - $actual_payment));
                                                    ?>
                                                </td>
                                                <td style="text-align: right;">- <?= round((($actual_price - $actual_payment) / $actual_price) * 100, 0, PHP_ROUND_HALF_UP) . '%' ?></td>


                                            </tr>
                                        <?php

                                        }

                                    }else{
                                        ?>
                                        <tr>
                                            <td><?= custom_date_format('d-M-Y', $row['completion_date']) ?></td>
                                            <td><?= get_procurement_plan_entry_info($row['procurement_ref_id'], 'pde') ?></td>
                                            <td><?=get_procurement_plan_entry_info($row['procurement_ref_id'],'procurement_ref_no')?></td>

                                            <td><?=get_procurement_plan_entry_info($row['procurement_ref_id'],'procurement_type')?></td>
                                            <td><?=get_procurement_plan_entry_info($row['procurement_ref_id'],'procurement_method')?></td>

                                            <td ><?= get_procurement_plan_entry_info($row['procurement_ref_id'], 'subject_of_procurement') ?></td>
                                            <td style="text-align: right;">
                                                <?php
                                                $actual_price_total[] = $actual_price;
                                                echo number_format($actual_price, 0);
                                                ?>
                                            </td>
                                            <td style="text-align: right;">
                                                <?php
                                                $actual_payment_total[] = $actual_payment;
                                                echo number_format($actual_payment);
                                                ?>
                                            </td>
                                            <td style="text-align: right;">
                                                <?php
                                                $value_of_variation[] = $actual_price - $actual_payment;
                                                echo number_format(($actual_price - $actual_payment));
                                                ?>
                                            </td>
                                            <td style="text-align: right;">- <?= round((($actual_price - $actual_payment) / $actual_price) * 100, 0, PHP_ROUND_HALF_UP) . '%' ?></td>


                                        </tr>
                                    <?php
                                    }

                                }





                    }

                    ?>
                    <tr>
                        <td ></td>
                        <td ></td>
                        <td ></td>
                        <td ></td>
                        <td ></td>
                        <td ></td>
                        <td style="text-align: right; border-top: 1px solid;">
                            <b><?= number_format(array_sum($actual_price_total)) ?></b></td>
                        <td style="text-align: right; border-top: 1px solid;">
                            <b><?= number_format(array_sum($actual_payment_total)) ?></b></td>
                        <td style="text-align: right; border-top: 1px solid;">
                            <b><?= number_format(array_sum($value_of_variation)) ?></b></td>
                        <td ></td>
                    </tr>

                    </tbody>
                </table>


                <?php
                break;

            case 'average_number_of_bids_per_contract':
                ?>

                <table id="" class="display" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Date approved</th>
                        <th>Contract</th>
                        <th>Reference number</th>
                        <th>Procurement type</th>
                        <th>Procurement method</th>
                        <th>Procurement value <br>(UGX)</th>
                        <th>Bids recieved</th>

                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    $total=array();


                    foreach ($results as $row) {
                        $total[]= get_procurement_plan_entry_info($row['procurement_id'], 'estimated_amount');

                        if(isset($filter_by_pde)){
                            if($filter_by_pde==get_procurement_plan_entry_info($row['procurement_id'], 'pde_id')){

                                ?>
                                <tr>
                                    <td><?= custom_date_format('d-M-Y', $row['date_approved']) ?></td>
                                    <td ><?= get_procurement_plan_entry_info($row['procurement_id'], 'subject_of_procurement') ?></td>
                                    <td><?=$row['procurement_ref_no']?></td>
                                    <td ><?= get_procurement_plan_entry_info($row['procurement_id'], 'procurement_type') ?></td>
                                    <td ><?= get_procurement_plan_entry_info($row['procurement_id'], 'procurement_method') ?></td>
                                    <td style="text-align: right;"><?= get_procurement_plan_entry_info($row['procurement_id'], 'estimated_amount') ?></td>
                                    <td><?=count(get_bid_receipts_by_bid($row['id']))?></td>
                                </tr>
                            <?php

                            }

                        }
                        else{
                            ?>
                            <tr>
                                <td><?= custom_date_format('d-M-Y', $row['date_approved']) ?></td>
                                <td ><?= get_procurement_plan_entry_info($row['procurement_id'], 'subject_of_procurement') ?></td>
                                <td><?=$row['procurement_ref_no']?></td>
                                <td ><?= get_procurement_plan_entry_info($row['procurement_id'], 'procurement_type') ?></td>
                                <td ><?= get_procurement_plan_entry_info($row['procurement_id'], 'procurement_method') ?></td>
                                <td style="text-align: right;"><?= get_procurement_plan_entry_info($row['procurement_id'], 'estimated_amount') ?></td>
                                <td><?=count(get_bid_receipts_by_bid($row['id']))?></td>
                            </tr>
                        <?php
                        }



                            }




                    ?>

                    <tr>
                        <td></td>
                        <td ></td>
                        <td></td>
                        <td ></td>
                        <td ></td>
                        <td style="text-align: right; border-top: solid 1px; font-weight: bold;"><?= array_sum($total)?></td>
                        <td></td>
                    </tr>

                    </tbody>
                </table>


                <?php
                break;
        }
    }else{
        ?>

        <table  id=""  class="display table table-hover dt-responsive">
            <thead>
            <tr>
                <th>PDE</th>
                <th>Procurement ref.no</th>
                <th>Procurement type</th>
                <th>Procurement method</th>
                <th>Subject of procurement</th>
                <th>Procurement value <br>(UGX)</th>
                <th class="hidden-480">Planned date of completion</th>
                <th class="hidden-480">Actual date of completion</th>
                <th class="hidden-480">Status<br>(Days)</th>
            </tr>
            </thead>
            <tbody>
            <?php

            //print_array($results);
            foreach($results as $row){
                //if pde filter is set
                if(isset($filter_by_pde)){
                    if($filter_by_pde==get_procurement_plan_entry_info($row['procurement_ref_id'],'pde_id')){
                        ?>
                        <tr>
                            <td><?=get_procurement_plan_entry_info($row['procurement_ref_id'],'pde')?></td>
                            <td><?=get_procurement_plan_entry_info($row['procurement_ref_id'],'procurement_ref_no')?></td>
                            <td><?=get_procurement_plan_entry_info($row['procurement_ref_id'],'procurement_type')?></td>
                            <td><?=get_procurement_plan_entry_info($row['procurement_ref_id'],'procurement_method')?></td>
                            <td><?=get_procurement_plan_entry_info($row['procurement_ref_id'],'subject_of_procurement')?></td>
                            <td><?=get_procurement_plan_entry_info($row['procurement_ref_id'],'estimated_amount')?></td>
                            <td class="hidden-480"><?=date('d-F-Y',(strtotime($row['commencement_date'])+$row['days_duration']*24*60*60))?></td>
                            <td class="hidden-480"><?=custom_date_format('d-M-Y',$row['completion_date'])?></td>
                            <td class="hidden-480"><?=((strtotime(date('d-M-Y',(strtotime($row['commencement_date'])+$row['days_duration']*24*60*60)))-strtotime(custom_date_format('d-M-Y',$row['completion_date'])))/86400)<0?substr((strtotime(date('d-M-Y',(strtotime($row['commencement_date'])+$row['days_duration']*24*60*60)))-strtotime(custom_date_format('d-M-Y',$row['completion_date'])))/86400,1).'<span class="label label-important pull-right"> late</span>':((strtotime(date('d-F-Y',(strtotime($row['commencement_date'])+$row['days_duration']*24*60*60)))-strtotime(custom_date_format('d-F-Y',$row['completion_date'])))/86400).' <span class="label label-success pull-right"> early</span>'?></td>
                        </tr>
                    <?php
                    }


                }else{
                    ?>
                    <tr>
                        <td><?=get_procurement_plan_entry_info($row['procurement_ref_id'],'pde')?></td>
                        <td><?=get_procurement_plan_entry_info($row['procurement_ref_id'],'procurement_ref_no')?></td>
                        <td><?=get_procurement_plan_entry_info($row['procurement_ref_id'],'procurement_type')?></td>
                        <td><?=get_procurement_plan_entry_info($row['procurement_ref_id'],'procurement_method')?></td>
                        <td><?=get_procurement_plan_entry_info($row['procurement_ref_id'],'subject_of_procurement')?></td>
                        <td style="text-align: right;"><?=get_procurement_plan_entry_info($row['procurement_ref_id'],'estimated_amount')?></td>
                        <td class="hidden-480"><?=date('d-F-Y',(strtotime($row['commencement_date'])+$row['days_duration']*24*60*60))?></td>
                        <td class="hidden-480"><?=custom_date_format('d-M-Y',$row['completion_date'])?></td>
                        <td class="hidden-480"><?=((strtotime(date('d-M-Y',(strtotime($row['commencement_date'])+$row['days_duration']*24*60*60)))-strtotime(custom_date_format('d-M-Y',$row['completion_date'])))/86400)<0?substr((strtotime(date('d-M-Y',(strtotime($row['commencement_date'])+$row['days_duration']*24*60*60)))-strtotime(custom_date_format('d-M-Y',$row['completion_date'])))/86400,1).'<span class="label label-important pull-right"> late</span>':((strtotime(date('d-F-Y',(strtotime($row['commencement_date'])+$row['days_duration']*24*60*60)))-strtotime(custom_date_format('d-F-Y',$row['completion_date'])))/86400).' <span class="label label-success pull-right"> early</span>'?></td>
                    </tr>
                <?php

                }



            }
            ?>

            </tbody>
        </table>


    <?php

    }

}else{
    echo info_template('No results to display');
}



