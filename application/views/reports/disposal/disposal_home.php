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
            //print_array($results);
            /*
             * [0] => Array
        (
            [id] => 2
            [disposal_plan] => 2
            [disposal_serial_no] => 1290392/82023/232
            [subject_of_disposal] => Sale of Office Furniture
            [asset_location] => Kampala
            [amount] => 3000000000000
            [isactive] => Y
            [method] => Public Auction
            [currence] => UGX
            [title] =>
            [dateadded] => 2015-06-01 17:09:25
            [pdetype] => Medical Services
            [pdename] => New Wave Technologies Ltd
        )

             */

            // print_array($results);

            $disposal_values=array();

            $disposal_methods=array();
            $disposal_method_no_repeat=array();

            $contract_value=array();

            $contracts_awarded=array();

            $pdes=array();
            $results_pde_filtered=array();




            foreach($results as $row) {
                $disposal_values[] = $row['amount'];
                //echo $row['estimated_amount'];

                if (!in_array($row['pdename'], $pdes)) {
                    $pdes[] = $row['pdename'];
                }

                //disposal methods
                if ($row['method']) {
                    $disposal_methods[] = $row['method'];
                    if (!in_array($row['method'], $disposal_method_no_repeat)) {
                        $disposal_method_no_repeat[] = $row['method'];
                    }
                }

                $contract_value[]= get_disposal_contract_info_by_id_disposal_record($row['id'],'contractamount');
                if(get_disposal_contract_info_by_id_disposal_record($row['id'],'contractamount')){
                    $contracts_awarded[]=get_disposal_contract_info_by_id_disposal_record($row['id'],'id');
                }




            }

            //print_array($disposal_methods);

            $occurence_disposal_methods=array_count_values($disposal_methods);

            //print_array($occurence_disposal_methods)



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





                    <tr>
                        <th>Aggregation by disposal method</th>
                        <td>

                            <ul class="unstyled">
                                <?php
                                //print_array(get_active_disposal_methods());
                                foreach($disposal_method_no_repeat as $method){

                                        ?>
                                        <li class="list-group-item"><?=$method?> <span class="number">&nbsp; &nbsp; <?=$occurence_disposal_methods[$method]?></span> </li>
                                    <?php


                                }
                                ?>
                            </ul>

                        </td>
                    </tr>
                    <?php
                    if($this->session->userdata('isadmin')=='Y'){
                        ?>
                        <tr>
                            <th>PDEs</th>
                            <td class="number"><?=count($pdes)?></td>
                        </tr>
                    <?php
                    }

                    ?>


                    <tr>
                        <th>Total Disposal plans</th>
                        <td class="number"><?=count($results)?></td>
                    </tr>
                    <tr>
                        <th>Total Contracts awarded</th>
                        <td class="number"><?=(count($contracts_awarded))?></td>
                    </tr>




                    <tr>
                        <th>Total Reserve price value (UGX)</th>
                        <td class="number"><?=(array_sum($disposal_values))?></td>
                    </tr>



                    <tr>
                        <th>Total Contract value (UGX)</th>
                        <td><?=array_sum($contract_value)==0?'No contracts awarded':'<span class="number">'.array_sum($contract_value).'</span>'?></td>
                    </tr>


                </table>
            </div>
            <p>

                <a class="btn" href="#" onclick="printContent('print_this')"> PRINT </a>
            </p>



        </div>
        <div class="tab-pane fade" id="tab2">
            <h2><?=$report_heading?> <br><small>Financial year : <?=$financial_year?></small></h2>
            Reporting period : <?=$reporting_period?>


            <p>
                <?php
                //print_array($results)


                ?>

            <table  id=""  class="display table table-hover dt-responsive ">
                <thead>
                <tr>
                    <?php
                    if($this->session->userdata('isadmin')=='Y'){
                        ?>
                        <th>PDE</th>
                    <?php
                    }

                    ?>

                    <td>Disposal reference number</td>
                    <th>Subject of disposal</th>
                    <th>Method of disposal</th>
                    <td>Date of approval</td>
                    <th>Name of Buyer</th>
                    <th>Reserve price (UGX)</th>
                    <th>Contract price (UGX)</th>


                </tr>
                </thead>
                <tbody>
                <?php

                //print_array($results);
                /*
           * [0] => Array
      (
          [id] => 2
          [disposal_plan] => 2
          [disposal_serial_no] => 1290392/82023/232
          [subject_of_disposal] => Sale of Office Furniture
          [asset_location] => Kampala
          [amount] => 3000000000000
          [isactive] => Y
          [method] => Public Auction
          [currence] => UGX
          [title] =>
          [dateadded] => 2015-06-01 17:09:25
          [pdetype] => Medical Services
          [pdename] => New Wave Technologies Ltd
      )

           */
                foreach($results as $row){

                    ?>



                    <tr>
                        <?php
                        if($this->session->userdata('isadmin')=='Y'){
                            ?>
                            <td><?= $row['pdename'] ?></td>
                        <?php
                        }
                        ?>

                        <td><?=$row['disposal_serial_no']?></td>
                        <td><?=$row['subject_of_disposal']?></td>
                        <td><?=$row['method']?></td>
                        <td><?=custom_date_format('d / F / Y',$row['dateadded'])?></td>




                        <td><?=get_disposal_contract_info_by_id_disposal_record($row['id'],'beneficiary')==''?'No Contract Awarded':get_disposal_contract_info_by_id_disposal_record($row['id'],'beneficiary')?></td>
                        <td style="text-align: right;"><?=$row['amount']?>

                        </td>
                        <td style="text-align: right;"><?=get_disposal_contract_info_by_id_disposal_record($row['id'],'contractamount')==''?'No Contract Awarded':get_disposal_contract_info_by_id_disposal_record($row['id'],'contractamount')?>

                        </td>

                    </tr>


                <?php



                }
                ?>

                </tbody>
            </table>
            </p>

            <p>

                <a class="btn " href="#" onClick="$('.display').tableExport({type:'excel',escape:'false'});"> Export</a>
            </p>


        </div>

    </div>

<?php
}
?>





