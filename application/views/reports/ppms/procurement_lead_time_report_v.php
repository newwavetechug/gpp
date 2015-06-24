<?php

if(isset($notes)){
    echo info_template($notes);
}
/**
 * Created by PhpStorm.
 * User: EMMA
 * Date: 6/2/15
 * Time: 1:14 PM
 */
//print_array($results);
//print_array($all_post_params);

//print_array($all_contracts_in_this_year);

$total_contract_value=array();
$total_estimated_value=array();

$available_procurement_methods=array();

$total_pdes=array();



foreach( $results as $row){
    $total_contract_value[]=$row['final_contract_value'];
    $total_estimated_value[]=$row['estimated_amount'];

    //get available procurement methods
    if(!in_array($row['procurement_method'],$available_procurement_methods)){
        $available_procurement_methods[]=$row['procurement_method'];
    }


    //get pdes
    if(!in_array($row['pdeid'],$total_pdes)){
        $total_pdes[]=$row['pdeid'];
    }


}


//print_array(array_sum($total_contract_value));




$contracts_by_procurement_method=array();

//print_array($available_procurement_methods);

foreach($available_procurement_methods as $method){
    //get contracts for each method for the same duration
    $contracts_by_procurement_method[$method]=get_contracts_by_procurement_method($method,$from,$to);
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
                            <th>Total Contracts</th>
                            <td ><?=count($results)?></td>
                            <td></td>
                        </tr>

                        <?php
                        if($this->session->userdata('isadmin')=='Y'){
                            ?>
                            <tr style="border-bottom: 2px solid #C5C5C5;">
                                <th>Total PDES</th>
                                <td ><?=count($total_pdes)?></td>
                                <td></td>
                            </tr>
                        <?php
                        }
                        ?>




                        <?php
                        foreach( $available_procurement_methods as $key=>$value){

                            //get values ny type

                            //print_array($contracts_by_procurement_method)
                            ?>
                            <tr >
                                <th><?=get_procurement_method_info_by_id($value,'title')?></th>
                                <td>
                                    <?php
                                    $contracts=array();
                                    $cont_value=array();
                                    $lead_times=array();
                                    foreach($results as $row){
                                        if($row['procurement_method']==$value){
                                            $contracts[]=$row['id'];
                                            $cont_value[]=$row['final_contract_value'];

                                            $lead_times[]=seconds_to_days(strtotime($row['contract_award_date'])-strtotime($row['dateofconfirmationoffunds']));
                                        }
                                    }

                                    echo count($contracts). ' <small>Contracts</small>  <b class="offset1">'.count($results)>0?round_up((count($contracts)/count($results))*100):''.'%</b> <span class="offset1">Value: <small>UGX</small> '.array_sum($cont_value).'</span> <b style="text-align:right;" class="pull-right" >'.round_up((array_sum($cont_value)/array_sum($total_contract_value))*100).'%</b>';
                                    ?>


                                </td>
                                <td>Average lead time:
                                    <?php
                                    $lead_times=array();
                                    $contracts=array();
                                    foreach($results as $row){
                                        if($row['procurement_method']==$value){
                                            $contracts[]=$row['id'];


                                            $lead_times[]=seconds_to_days(strtotime($row['dateofconfirmationoffunds'])-strtotime($row['contract_award_date']));
                                        }
                                    }
                                    echo '<b class="offset1">'.round_up(array_sum($lead_times)/count($contracts)).' </b> Days'
                                    ?>
                                </td>

                            </tr>
                        <?php
                        }

                        ?>




                    </table>

                </div>
                <p>

                    <a class="btn" href="#" onclick="printContent('print_this')">PRINT</a>
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
                            <th class="hidden-480">Procurement ref.no</th>
                            <th class="hidden-480">Subject of procurement</th>
                            <th class="hidden-480">Method of procurement</th>

                            <th>Accounting Officer signature date <br>(UGX)</th>
                            <th class="hidden-480">Contract award date<br>(UGX)</th>
                            <th class="hidden-480">Lead time<br>(DAYS)</th>

                            <th class="hidden-480">Estimated Amount<br>(UGX)</th>
                            <th class="hidden-480">Fina Amount<br>(UGX)</th>





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
                                    <td><?=get_pde_info_by_id($row['pdeid'],'title')?></td>
                                <?php
                                }

                                ?>
                                <td><?=$row['procurement_ref_no']?></td>
                                <td><?=$row['subject_of_procurement']?></td>
                                <td><?=get_procurement_method_info_by_id($row['procurement_method'],'title')?></td>

                                <td><?=custom_date_format('d.F.Y',$row['dateofconfirmationoffunds'])?></td>
                                <td><?=custom_date_format('d.F.Y',$row['contract_award_date'])?></td>
                                <td><?=seconds_to_days(strtotime($row['dateofconfirmationoffunds'])-strtotime($row['contract_award_date']))?></td>
                                <td><?=$row['estimated_amount']?></td>
                                <td><?=$row['final_contract_value']?></td>



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