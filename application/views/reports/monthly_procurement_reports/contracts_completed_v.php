<?php
//if there are errors
if (isset($errors)) {
    echo error_template($errors);
} else {

    if (isset($notes)) {
        echo info_template($notes);
    }
    //print_array($all_post_params);

    //print_array($results);

    //get to contract value
    $contract_value = array();
    $pdes = array();
    $market_prices = array();

    foreach ($results as $row) {
        $contract_value[] = $row['amount'];
        if (!in_array($row['pdeid'], $pdes)) {
            $pdes[] = $row['pdeid'];
        }
        $market_prices[] = $row['total_actual_payments'];


    }


    //=========all contracts in this period================
    //get to contract value
    $all_contract_value = array();
    $all_pdes = array();
    $all_market_prices = array();

    foreach ($all_contracts as $row) {
        $all_contract_value[] = $row['amount'];

        if (!in_array($row['pdeid'], $all_pdes)) {
            $all_pdes[] = $row['pdeid'];
        }

        $all_market_prices[] = $row['total_actual_payments'];
    }


}
?>
<!-- TAB NAVIGATION -->
<ul class="nav nav-tabs" role="tablist">
    <li class="active"><a href="#tab1" role="tab" data-toggle="tab">Summary</a></li>
    <li><a href="#tab2" role="tab" data-toggle="tab">Details</a></li>

</ul>
<!-- TAB CONTENT -->
<div class="tab-content">
    <div class="active tab-pane fade in" id="tab1">


        <div id="print_this">
            <table class="table table-responsive " id="vertical-1">
                <h2><?= $report_heading ?> <br>
                    <small>Financial Year : <?= $financial_year ?></small>
                </h2>
                <b>Reporting period : </b><?= $reporting_period ?>
                <thead>
                <th></th>
                <th>Value</th>
                <th>Percentage by value</th>
                <th>Amount (UGX)</th>
                <th>Percentage by Amount</th>
                </thead>


                <?php
                if ($this->input->post('pde')) {
                    ?>
                    <tr>
                        <th>PDE</th>
                        <td><?= get_pde_info_by_id($this->input->post('pde'), 'title') ?></td>

                    </tr>
                <?php
                }
                ?>



                <tr>
                    <th>Total Contracts</th>
                    <td><?= count($results) ?></td>
                    <td><?= count($all_contracts) ? round_up((count($results) / count($all_contracts)) * 100) . '%' : '-' ?></td>
                    <td><?= array_sum($contract_value) ?></td>
                    <td><?= count($all_contracts) ? round_up((array_sum($contract_value) / array_sum($all_contract_value)) * 100) . '%' : '-' ?></td>

                </tr>
                <tr>
                    <th>Total Amount Paid</th>
                    <td>-</td>
                    <td>-</td>
                    <td><?= array_sum($market_prices) ?></td>
                    <td><?= count($all_contracts) ? round_up((array_sum($market_prices) / array_sum($all_market_prices)) * 100) . '%' : '-' ?></td>

                </tr>

                <tr>
                    <th>PDES</th>
                    <td><?= count($pdes) ?></td>
                    <td><?= count($all_contracts) ? round_up((count($pdes) / count($all_pdes)) * 100) . '%' : '-' ?></td>
                    <td>-</td>
                    <td>-</td>

                </tr>


            </table>


        </div>


        <p>

            <a class="btn" href="#" onclick="printContent('print_this')"> PRINT </a>
        </p>


    </div>
    <div class="tab-pane fade" id="tab2">
        <h2><?= $report_heading ?> <br>
            <small>Financial year : <?= $financial_year ?></small>
        </h2>
        Reporting period : <?= $reporting_period ?>


        <p>
            <?php
            //print_array($results)


            ?>

        <table id="" class="display table table-hover dt-responsive ">
            <thead>
            <tr>
                <td>Procurement Reference Number</td>


                <td>Subject of disposal</td>
                <td>Method of procurement</td>
                <?php
                if ($this->session->userdata('isadmin') == 'Y') {
                    ?>
                    <td>Provider</td>
                <?php
                }

                ?>
                <td>Date of completion</td>
                <td>Total Amount paid (UGX)</td>
                <td>Contract value (UGX)</td>


            </tr>
            </thead>

            <tbody>
            <?php
            $grand_total_actual_payments = array();
            $grand_amount = array();
            foreach ($results as $row) {
                $grand_total_actual_payments[] = $row['total_actual_payments'];
                $grand_amount[] = $row['amount'];
                ?>
                <tr>
                    <td>
                        <?= get_procurement_plan_entry_info($row['procurement_ref_id'], 'procurement_ref_no') ?>
                    </td>
                    <td>
                        <?= get_procurement_plan_entry_info($row['procurement_ref_id'], 'subject_of_procurement') ?>
                    </td>

                    <td>
                        <?= get_procurement_plan_entry_info($row['procurement_ref_id'], 'procurement_method') ?>
                    </td>
                    <?php
                    if ($this->session->userdata('isadmin') == 'Y') {
                        ?>
                        <td>
                            <?= get_pde_info_by_id($row['pdeid'], 'title') ?>
                        </td>
                    <?php
                    }
                    ?>



                    <td>
                        <?= custom_date_format('d.F.Y', $row['actual_completion_date']) ?>
                    </td>

                    <td>
                        <?= $row['total_actual_payments'] ?>
                    </td>

                    <td>
                        <?= $row['amount'] ?>
                    </td>

                </tr>
            <?php
            }
            ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <?php
                if ($this->session->userdata('isadmin') == 'Y') {
                    ?>
                    <td></td>
                <?php
                }
                ?>
                <td></td>
                <td style="border-top: 1px solid #000; "><b><?= array_sum($grand_total_actual_payments) ?></b></td>
                <td style="border-top: 1px solid #000; "><b><?= array_sum($grand_amount) ?></b></td>

            </tr>


            </tbody>
        </table>
        </p>

        <p>

            <a class="btn " href="#" onClick="$('.display').tableExport({type:'excel',escape:'false'});"> Export</a>
        </p>


    </div>

</div>