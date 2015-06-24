<?php
/**
 * Created by PhpStorm.
 * User: EMMA
 * Date: 6/2/15
 * Time: 1:14 PM
 */
//print_array($results);

//print_array($all_contracts_in_this_year);

$total_contract_value=array();

$total_annual_contract_value=array();

foreach( $results as $row){
    $total_contract_value[]=$row['final_contract_value'];

}

foreach( $all_contracts_in_this_year as $row){
    $total_annual_contract_value[]=$row['final_contract_value'];

}
?>
<div class="">

    <!-------->
    <div id="">
        <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
            <li class="active"><a href="#report_summary" data-toggle="tab">Report summary</a></li>

            <li><a href="#report_details" data-toggle="tab">Report details</a></li>
            <?php
            if(isset($graph_view)){
                ?>
                <li><a href="#report_graphic" data-toggle="tab">Report graphic</a></li>
            <?php
            }
            ?>
        </ul>
        <div id="my-tab-content" class="tab-content">
            <div class="tab-pane active" id="report_summary">


                <div id="print_this">
                    <table class="table table-responsive " id="vertical-1">
                        <h3><?=$report_heading?> </h3>

                        <tr>
                            <th>Financial year</th>
                            <td><?=$financial_year?></td>
                        </tr>

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
                            <th>Total Contracts</th>
                            <td class="number"><?=count($results)?></td>
                        </tr>



                        <?php

                            $total_results=count($results);

                        if(count($all_contracts_in_this_year)){

                            $total_results_percentage=(count($results)/count($all_contracts_in_this_year))*100;
                            $total_results_2=count($all_contracts_in_this_year)-$total_results;
                            $total_percentage_2=($total_results_2/count($all_contracts_in_this_year))*100;
                        }



                        ?>
                        <tr>
                            <th>Contracts whose planned completion date is greater actual completion date </th>
                            <td >

                                <span class="number"><?=$total_results?></span>
                                <?php
                                //to prevent division by zero
                                if(count($all_contracts_in_this_year)){
                                    ?>
                                    <span style="margin-left: 20px;" class="pull-right"><b>Total Value (UGX): </b><span style="text-align: right;"><?=number_format(array_sum($total_contract_value));?></span>  </span>
                                    <span class="pull-right"><span  ><b>PERCENTAGE:</b> <?=round_up((count($results)/count($all_contracts_in_this_year))*100)?></span>%</span>
                                <?php
                                }
                                ?>

                            </td>
                        </tr>






                        <?php

                        ?>


                    </table>

                </div>
                <p>

                    <a class="btn" href="#" onclick="printContent('print_this')"> PRINT </a>
                </p>



            </div>

            <?php
            if(isset($graph_view)){
                ?>
                <div class="tab-pane" id="report_graphic">

                    <?=$this->load->view($graph_view)?>
                </div>
            <?php
            }
            ?>
            <div class="tab-pane" id="yellow">
                <h1>Yellow</h1>
                <p>yellow yellow yellow yellow yellow</p>
            </div>
            <div class="tab-pane" id="report_details">
                <?php
                //if there are results
                if(count($results)){
                    ?>
                    <h2><?=$report_heading?> <br><small>Financial year : <?=$financial_year?></small></h2>
                    Reporting period : <?=$reporting_period?>


                    <p>


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
                            <th>Final value <br>(UGX)</th>
                            <th class="hidden-480">Actual payment <br>(UGX)</th>
                            <th class="hidden-480">Lead time<br>(DAYS)</th>

                            <th class="hidden-480">Procurement ref.no</th>
                            <th class="hidden-480">Subject of procurement</th>
                            <th class="hidden-480">Method of procurement</th>
                        </tr>
                        </thead>
                        <?php
                        //print_array($results);
                        foreach($results as $row){
                            ?>
                            <tr>

                                <?php
                                if($this->session->userdata('isadmin')=='Y'){
                                    ?>
                                    <td><?=get_pde_info_by_id($row['pde_id'],'title')?></td>
                                <?php
                                }

                                ?>
                                <td><?=$row['final_contract_value']?></td>
                                <td><?=$row['total_actual_payments']?></td>
                                <td><?=seconds_to_days(strtotime($row['completion_date'])-strtotime($row['commencement_date']))?></td>

                                <td><?=get_procurement_plan_entry_info($row['procurement_ref_id'],'procurement_ref_no')?></td>
                                <td><?=get_procurement_plan_entry_info($row['procurement_ref_id'],'subject_of_procurement')?></td>
                                <td><?=get_procurement_plan_entry_info($row['procurement_ref_id'],'procurement_method')?></td>

                            </tr>
                        <?php
                        }



                        ?>



                        </tbody>
                    </table>


                    </p>

                    <p>

                        <a class="btn " href="#" onClick="$('.display').tableExport({type:'excel',escape:'false'});"> EXPORT</a>
                    </p>
                <?php
                }else{
                    echo(info_template("No data to display"));
                }
                ?>

            </div>
            <div class="tab-pane" id="blue">
                <h1>Blue</h1>
                <p>blue blue blue blue blue</p>
            </div>
        </div>
    </div>


</div> <!-- container -->
