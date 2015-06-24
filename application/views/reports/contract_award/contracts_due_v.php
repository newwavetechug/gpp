<?php
/**
 * Created by PhpStorm.
 * User: EMMA
 * Date: 6/11/15
 * Time: 4:05 AM
 */
//print_array('foo');
?>

<div class="">

<!-------->
<div id="" class=" span12">
<ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
    <?php
    if(isset($graph_view)){
        ?>
        <li ><a href="#report_graphic" data-toggle="tab">Report graphic</a></li>
    <?php
    }
    ?>
    <li class="active" ><a href="#report_summary" data-toggle="tab">Report summary</a></li>

    <li ><a href="#report_details" data-toggle="tab">Report details</a></li>

</ul>
<div id="my-tab-content" class="tab-content">
<div class="tab-pane active" id="report_summary">


    <div id="print_this">
        <?php
        /*
         * [0] => Array
        (
            [completion_date] => 2015-06-03
            [contract_amount] =>
            [final_contract_value] =>
            [total_actual_payments] =>
            [actual_completion_date] =>
            [isactive] => Y
            [subject_of_procurement] => Procurement of office tables_2015
            [funding_source] => 2
            [id] => 24
            [pdename] => New Wave Technologies Ltd
            [title] => Open Domestic Bidding
        )
         */
        //print_array($results);
        $total_amounts=array();
        $total_actual_payments=array();
        $total_pdes=array();
        $bidding_methods=array();

//        foreach($results as $row){
//            foreach($row as $t){
//                $total_amounts[]=$t['contract_amount'];
//                $total_actual_payments[]=$t['final_contract_value]'];
//                if(!in_array($t['pdename'],$total_pdes)){
//                    $total_pdes[]=$t['pdename'];
//                }
//
//                if(!in_array($t['title'],$bidding_methods)){
//                    $bidding_methods[]=$t['title'];
//                }
//
//            }
//
//        }

        foreach($results as $key=>$val){
            $total_amounts[]=$val['final_contract_value'];
            $total_actual_payments[]=$val['total_actual_payments'];
           if(!in_array($val['pdename'],$total_pdes)){
                $total_pdes[]=$val['pdename'];
            }

            if(!in_array($val['title'],$bidding_methods)){
                $bidding_methods[]=$val['title'];
            }
        }



        ?>
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

                <td class="number"><?=count($results)?></td>
                <td ><b>Value: </b><small>UGX: </small> <span style="text-align: right;"><?=array_sum($total_amounts)?> </span><b class="offset1">Actual payment: </b><small>UGX: </small> <span style="text-align: right;"><?=array_sum($total_actual_payments)?></span></td>
                <td></td>
            </tr>

            <tr>
                <th>Total PDEs</th>

                <td class="number"><?=count($total_pdes)?></td>
                <td></td>
            </tr>


        </table>

        <hr>
        <h4>Aggregation by procurement method</h4>
        <table class="table table-responsive " id="vertical-1">
            <th></th>
            <th>Contracts</th>
            <th>Contract value</th>
            <th>Actual value paid</th>
            <?php
            foreach($bidding_methods as $row){
                ?>
                <tr>
                    <th><?=$row?></th>

                    <td >
                        <?php
                        $ag_total_contracts=array();
                        $total_actual_payments=array();
                        $total_pdes=array();
                        $total_amounts=array();

                        foreach($results as $key=>$val){
                            if($val['title']==$row){
                                $ag_total_contracts[]=$val['id'];
                                $total_actual_payments[]=$val['total_actual_payments'];

                                $total_amounts[]=$val['final_contract_value'];
                            }
                        }

                        echo count($ag_total_contracts);



                        ?>
                    </td>
                    <td><?=array_sum($total_amounts)?></td>

                    <td><?=array_sum($total_actual_payments)?></td>
                </tr>
            <?php
            }

            ?>
        </table>





    </div>
    <p>

        <a class="btn" href="#" onclick="printContent('print_this')"> Print </a>
    </p>



</div>

<?php
if(isset($graph_view)){
    ?>
    <div class="tab-pane active" id="report_graphic">

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
    //print_array($results);
    if(count($results)){
        ?>
        <h3><?=$report_heading?> </h3>

        Reporting period : <?=$reporting_period?>


        <p>


        <table  id=""  class="display table table-hover dt-responsive ">
            <thead>
            <tr>

                <?php
                /*
       * [0] => Array
      (
          [completion_date] => 2015-06-03
          [contract_amount] =>
          [final_contract_value] =>
          [total_actual_payments] =>
          [actual_completion_date] =>
          [isactive] => Y
          [subject_of_procurement] => Procurement of office tables_2015
          [funding_source] => 2
          [id] => 24
          [pdename] => New Wave Technologies Ltd
          [title] => Open Domestic Bidding
      )
       */
                if($this->session->userdata('isadmin')=='Y'){
                    ?>
                    <th>PDE</th>
                <?php
                }

                ?>
                    <th >Procurement ref number</th>
                <th >Subject of procurement</th>
                <th>Procurement method</th>
                <th>Funding Source</th>
                <th>Contract value</th>
                <th>Actual payment</th>
                <th>Date of completion</th>




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
                        <td><?=$row['pdename']?></td>
                    <?php
                    }

                    ?>

                    <td><?=$row['procurement_ref_no']?></td>
                    <td><?=$row['subject_of_procurement']?></td>
                    <td><?=$row['title']?></td>
                    <td><?=get_source_funding_info_by_id($row['funding_source'],'title')?></td>
                    <td><?=$row['final_contract_value']?></td>
                    <td><?=$row['total_actual_payments']?></td>
                    <td><?=$row['completion_date']?></td>

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


</div>