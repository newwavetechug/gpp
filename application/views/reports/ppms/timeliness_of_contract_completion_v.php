    <?php
    /**
     * Created by PhpStorm.
     * User: EMMA
     * Date: 6/2/15
     * Time: 1:14 PM
     */
    //print_array($results);

    //print_array($all_contracts_in_this_year);
    /*
     * [0] => Array
            (
                [id] => 12
                [advance_payment] => Y
                [advance_payment_date] => 2015-04-22
                [commencement_letter] => _COMMENCEMENTLETTER_
                [contract_progress_report] => _CONTRACTPROGRESSREPORT_
                [implementation_plan] => _IMPLEMENTATIONPLAN_
                [commencement_letter_ref_no] => _COMMENCEMENTLETTERREFNO_
                [completion_author] => 20
                [procurement_ref_no] => BOU/SUPS/2015-16/0009
                [provider_id] => 0
                [direct_procurement] => N
                [emergency_procurement] => N
                [admin_review] => _I
                [date_of_sg_approval] => 0000-00-00
                [final_award_notice_date] => 0000-00-00
                [commencement_date] => 2015-06-17
                [completion_date] => 2015-09-15
                [exchange_rate] =>
                [days_duration] =>
                [contract_amount] =>
                [date_signed] => 2015-05-21
                [amount_currency] =>
                [final_contract_value] => 760000000
                [final_contract_value_currency] => 1
                [total_actual_payments] => 10000000000
                [total_actual_payments_currency] => 1
                [actual_completion_date] => 2015-08-19
                [performance_rating] => Very good
                [contract_manager] => John Saturday
                [contract_management_report] => _CONTRACTMANAGEMENTREPORT_
                [pdeid] => 12
                [author] => 20
                [dateawarded] => 2015-04-17 07:09:42
                [dateadded] => 2015-04-17 07:09:42
                [isactive] => Y
                [procurement_ref_id] => 77
                [subject_of_procurement] => Procurement of vehiccles
                [procurement_method] => 9
                [pde_department] => Administration
                [funding_source] => 1
                [funder_name] =>
                [estimated_amount] => 300000000
                [procurement_plan_id] => 38
                [pde_id] => 12
                [financial_year] => 2017-2018
                [title] => Government of Uganda
                [pdename] => Bank of Uganda
                [contract_id] => 8
                [amount] => 4000
            )

    )
    Report graphic
    Report summary
    Report details
    Array
    (
        [0] => Array
            (
                [id] => 12
                [procurement_ref_no] =>
                [completion_date] => 2015-09-15
                [commencement_date] => 2015-06-17
                [days_duration] =>
                [contract_amount] =>
                [final_contract_value] => 760000000
                [final_contract_value_currency] => 1
                [total_actual_payments] => 10000000000
                [total_actual_payments_currency] => 1
                [actual_completion_date] => 2015-08-19
                [performance_rating] => Very good
                [isactive] => Y
                [procurement_ref_id] => 77
                [subject_of_procurement] => Procurement of vehiccles
                [procurement_type] => 1
                [procurement_method] => 9
                [pde_department] => Administration
                [funding_source] => 1
                [funder_name] =>
                [estimated_amount] => 300000000
                [currency] => 1
                [procurement_plan_id] => 38
                [title] => BoU App 2017 - 2018
                [evaluation_time] => 20
                [pde_id] => 12
                [financial_year] => 2017-2018
                [pdename] => Bank of Uganda
                [pdetype] => Government Department/Agencies
                [provider_id] => 0
                [providerid] => 18
            )
     */

    $total_contract_value=array();

    $total_annual_contract_value=array();

    $total_pdes=array();
    $total_annual_pdes=array();

    $available_procurement_methods=array();

    //print_array($results);

    foreach( $results as $row){
        $total_contract_value[]=$row['final_contract_value'];
        if(!in_array($row['pde_id'],$total_pdes)){
            $total_pdes[]=$row['pde_id'];
        }

        //get available procurement methods
        if(!in_array($row['procurement_method'],$available_procurement_methods)){
            $available_procurement_methods[]=$row['procurement_method'];
        }


    }

    foreach( $all_contracts_in_this_year as $row){
        $total_annual_contract_value[]=$row['final_contract_value'];

        if(!in_array($row['pde_id'],$total_annual_pdes)){
            $total_annual_pdes[]=$row['pde_id'];
        }

    }
    ?>

    <div class="">

        <!-------->
        <div id="" class=" span12">
            <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
                <?php
                /*
                if(isset($graph_view)){
                    ?>
                    <li ><a href="#report_graphic" data-toggle="tab">Report graphic</a></li>
                <?php
                } */
                ?>
                <li class="active" ><a href="#report_summary" data-toggle="tab">Report summary</a></li>

                <li><a href="#report_details" data-toggle="tab">Report details</a></li>

            </ul>
            <div id="my-tab-content" class="tab-content">
                <div class="tab-pane active" id="report_summary">


                <div id="print_this">
                <table class="table table-responsive " id="vertical-1">
                <h3><?=$report_heading?> </h3>

                <tr>
                    <th>Financial year</th>

                    <td><?=$financial_year?></td>
                    <td></td>
                </tr>

                <tr>
                    <th>Reporting Period</th>

                    <td><?=$reporting_period?></td>
                    <td></td>
                </tr>
                <?php
                if($this->input->post('pde')){
                    ?>
                    <tr>
                        <th>PDE</th>

                        <td><?=get_pde_info_by_id($this->input->post('pde'),'title')?></td>
                        <td></td>
                    </tr>
                <?php
                }
                ?>
                <tr>
                    <th>Total Number Of Contracts</th>

                    <td  ><?= count($all_contracts_in_this_year); ?> 

                    &nbsp; 

                     <?php
                        //to prevent division by zero
                        if(count($all_contracts_in_this_year)){
                            ?>
                            <span style="margin-left: 20px;" class="pull-right"><b>Total Value (UGX): </b><span style="text-align: right;" class=" "><?= number_format(array_sum($total_annual_contract_value))?></span> </span>

                        <?php
                        }
                        ?>

                    </td>
                    <td> 
                     
                    </td>
                </tr>

                <tr>
                    <th>Number Of Contracts completed beyond planned date of completion </th>

                    <td >

                        <span><?=count($results)?></span>
                        

                        <?php
                       $contract_value1 = 0;
                        if(!empty($results))
                        {
                            foreach ($results as $key => $value) {
                                # code...
                                $contract_value1 = $contract_value1 + $value['final_contract_value'];
                            }

                        }
                                            //to prevent division by zero
                        if(count($all_contracts_in_this_year)){
                            $num1 = count($results);
                            $total_nums = count($all_contracts_in_this_year);
                            $percentnum = round(($num1/$total_nums) * 100,2);
                            $percentval = round(($contract_value1/ array_sum($total_annual_contract_value)) * 100,2);
                             
                            ?>
                            <span style="margin-left: 20px;" class="pull-right"><b>Value (UGX): </b><span style="text-align: right;" ><?=$contract_value1;?></span> &nbsp; &nbsp; <small > <b>Percentage:</b> <?=$percentval; ?> %</small></span>
                            <span class="pull-right"> &nbsp;&nbsp; </span>   
                            <span class="pull-right"><span style="text-align: right;"  ><b>Percentage:</b> <?=$percentnum; ?></span>%</span> 
                           <!--  <span class="pull-right"><span style="text-align: right;"  ><?=$percentnum; ?></span>%</span> -->
                        <?php
                        }
                        ?>

                        

                    </td>
                    <?php
                    if($this->session->userdata('isadmin')=='Y'){
                        ?>
                        <td>Total PDES : <span class=""> <?=count($total_pdes)?></span></td>
                    <?php
                    }
                    ?>


                </tr>


                <tr>
                    <th>Number Of Contracts completed within  planned date of completion </th>


                    <td >
                  
                        <span class=""><?=count($all_contracts_in_this_year) - count($results)?></span>
                        

                    <?php
                    #  $remain = count($all_contracts_in_this_year) - count($results);
                     # $percentage_d = ($remain/ $all_contracts_in_this_year) *100;

                        ?>
                        <?php
                        $percentvalue2= 0;
                        //to prevent division by zero
                            $diff = array_sum($total_annual_contract_value)-array_sum($total_contract_value);
                            if($diff > 0)
                            {
                            $percentvalue2 = round((($diff)/ array_sum($total_annual_contract_value)) * 100,2);
                        }
                          ?>
                            <span style="margin-left: 20px;" class="pull-right"><b>Total Value (UGX): </b><span style="text-align: right;" class=" "><?=number_format(array_sum($total_annual_contract_value)-array_sum($total_contract_value));?></span>  <small><b>Percentage</b> <?=$percentvalue2; ?> % </small></span>
                           
                           <?php
                           $diff2 = count($all_contracts_in_this_year) - count($results);
                            $percent2 = 0;
                            if($diff2 > 0)
                            {
                           $percent2 = round( $diff2/count($all_contracts_in_this_year) * 100,2) ;
                           }
                           ?>
                            <span class="pull-right"><span style="text-align: right;"  ><b>Percentage:</b> <?=$percent2;  ?></span>%</span>

                        <?php
                        
                        ?>

                    </td>
                    <?php

                    if($this->session->userdata('isadmin')=='Y'){
                        ?>
                        <td>Total PDES : <span class=""> <?=count($total_annual_pdes)?></span></td>
                    <?php
                    }
                    ?>

                </tr>
    <!-- 
                <tr>
                    <th>Total Contract value </th>

                    <td >


                        <?php
                        //to prevent division by zero
                        if(count($all_contracts_in_this_year)){
                            ?>
                            <span style="margin-left: 20px;" class="pull-right"><b>Sub total: </b><span style="text-align: right;" class=" "><?= array_sum($total_annual_contract_value)?></span> <small>(UGX)</small></span>

                        <?php
                        }
                        ?>

                    </td>
                    <td></td>
                </tr>
     -->





                </table>


                </div>
                <p>

                    <a class="btn " href="#" onclick="printContent('print_this')"> PRINT </a>
                </p>



                </div>

                <?php
               /* if(isset($graph_view)){
                    ?>
                    <div class="tab-pane " id="report_graphic">

                        <?=$this->load->view($graph_view)?>
                    </div>
                <?php
                } */
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
                        <h2>Contracts completed beyond planned date of completion  <br><small>Financial year : <?=$financial_year?></small></h2>
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

                            <a class="btn" href="#" onClick="$('.display').tableExport({type:'excel',escape:'false'});"> EXPORT </a>
                        </p>
                    <?php
                    }else{
                        //print_array($results);
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