<?php
//print_array($_POST);
//print_array($this->session->all_userdata());
//print_array(get_pde_info_by_id($this->session->userdata('pdeid'),'title'))
?>

<!-- TAB NAVIGATION -->
<ul class="nav nav-tabs" role="tablist">
    <li class="active"><a href="#tab1" role="tab" data-toggle="tab">Report summary</a></li>
    <li><a href="#tab2" role="tab" data-toggle="tab">Report Details</a></li>

</ul>
<!-- TAB CONTENT -->
<div class="tab-content">
    <div class="active tab-pane fade in" id="tab1">
        <?php
        //print_array($_POST);
        //print_array($results)
        $pdes=array();
        $compliant_pdes=array();
        $late_procurement=array();

        $total_estimated_values=array();

        $total_entries=array();

        foreach($results as $row){
            if(!in_array($row['pde_id'],$pdes)){
                $pdes[]=$row['pde_id'];
            }

            if(!in_array($row['pde_id'],$compliant_pdes)){

                //get compliant pdes
                $where=array(
                    'pdeid'=>$row['pde_id']
                );

                if(get_compliant_pdes($where)){
                    $compliant_pdes[]=$row['pde_id'];

                }

            }

            //get latest entry by pde
            foreach(get_late_procurements($financial_year) as $entry){
                if($entry['pdeid']==$row['pde_id']){

                    if(!in_array($row['pde_id'],$late_procurement)){
                        $late_procurement[]=$row['pde_id'];

                    }
                }

            }

            $entries =get_procurement_plan_entries_by_plan($row['id']);

            foreach($entries as $entry){
                $total_estimated_values[]=$entry['estimated_amount'];
            }

            $total_entries[]=count(get_procurement_plan_entries_by_plan($row['id']));




        }



        //get non compliant pdes
        $non_compliant_pdes=array();
        foreach(get_active_pdes() as $pde){
            if(!in_array($pde['pdeid'],$compliant_pdes)){
                $non_compliant_pdes[]=$pde['pdeid'];
            }
        }


        //print_array(get_compliant_pdes($where))

        //print_array(get_late_procurements($financial_year))

        //print_array($late_procurement)

        ?>

        <div id="print_this">
            <table class="table table-responsive " id="vertical-1">
                <h2>Report Summary</h2>

                <tr>
                    <th >Financial year</th>
                    <td class="active"><?=$financial_year?></td>
                </tr>

                <tr>
                    <th>Total Procurement Plans</th>
                    <td class="number"><?=count($results)?></td>
                </tr>

                <?php
                if($this->input->post('pde')){
                    ?>
                    <tr>

                        <th>Compliance</th>
                        <td>
                            <?php
                            if(in_array($this->input->post('pde'),$compliant_pdes)){
                                ?>
                                <i class=" text-success text_success"> Compliant</i>
                            <?php

                            }else{
                                ?>
                                <i  class=" text-important text_danger"> Not Compliant</i>
                            <?php

                            }
                            ?>
                        </td>
                    </tr>
                    <?php

                }else{
                    ?>
                    <tr class="text_success">

                        <th>Compliant PDES</th>
                        <td class="number"><?=count($compliant_pdes)?></td>
                    </tr>
                    <tr style="color: #E74955">

                        <th>Non-Compliant PDES</th>
                        <td class="number"><?=count($non_compliant_pdes)?></td>
                    </tr>
                <?php
                }
                ?>

                <?php
                if($this->input->post('pde')){
                    ?>
                    <tr>

                        <th>Late procurement</th>
                        <td>
                            <?php
                            if(in_array($this->input->post('pde'),$late_procurement)){
                                ?>
                                <i style="color: #E74955" class="text-important"> Late</i>
                            <?php

                            }else{
                                ?>
                                <i style="color: #90C31E;" class=" text-success"> Not Late</i>
                            <?php

                            }
                            ?>
                        </td>
                    </tr>
                <?php

                }else{
                    ?>
                    <tr style="color: #E74955">

                        <th>Late procurements</th>
                        <td class="number "><?=count($late_procurement)?></td>
                    </tr>
                <?php
                }
                ?>


                <tr>

                    <th>Total procurement plan Entries</th>
                    <td class="number"><?=array_sum($total_entries)?></td>
                </tr>








                <tr>
<?php 
#print_r($total_estimated_values); 
?>
                    <th>Total Procurement plan estimated Value (UGX)</th>
                    <td ><?=number_format(array_sum($total_estimated_values))?></td>
                </tr>




            </table>
        </div>
        <p>

            <a class="btn btn-primary" href="#" onclick="printContent('print_this')"><img
                    src='<?= base_url() ?>assets/img/icons/pdf.png' width="24"/> Print </a>
        </p>



    </div>
    <div class="tab-pane fade" id="tab2">
        <h2>Financial year :<?=$financial_year?></h2>

        <p>
            <?php
            //print_array($results)


            ?>

        <table  class="table table-stripped table-hover summary_report">
            <thead>
            <tr>
                <th>Procurement plan</th>
                <th>Plan Entries</th>
                <th>PDE</th>
                <th>Compliance</th>
                <th>Late Procurement</th>
                <th>Estimated value<br>(UGX)</th>


            </tr>
            </thead>
            <tbody>
            <?php
            //print_array($results);
            $totals=array();
            $total_entries=array();
            foreach($results as $row){
                ?>
                <tr>
                    <td><?=$row['title']?></td>
                    <td>
                        <?php
                        $total_entries[]=count(get_active_procurement_plan_entries_by($row['id']));
                        ?>
                        <a href="<?=base_url()?>procurement/procurement_plan_entries/v/<?=encryptValue($row['id'])?>">
                            <?=count(get_active_procurement_plan_entries_by($row['id']))?>
                        </a>
                        </td>

                    <td><?=get_pde_info_by_id($row['pde_id'],'title')?></td>
                    <td>
                        <?php
                        if(in_array($row['pde_id'],$compliant_pdes)){
                            ?>

                            Yes
                        <?php
                        }else{
                            ?>
                            No
                        <?php
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if(in_array($row['pde_id'],$late_procurement)){
                            ?>

                            Yes
                        <?php
                        }else{
                            ?>
                            No
                        <?php
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        //print_array(get_procurement_plan_entries_by_plan($row['id']))
                        $total=array();
                        foreach(get_procurement_plan_entries_by_plan($row['id']) as $entry){
                            $total[]=$entry['estimated_amount'];
                            $totals[]=$entry['estimated_amount'];

                        }
                        echo array_sum($total);
                        ?>
                    </td>

                </tr>
            <?php

            }
            ?>
            <tr>
                <th>Total</th>
                <th><?=array_sum($total_entries)?></th>
                <th></th>
                <th></th>
                <th></th>
                <th><?=number_format(array_sum($totals))?></th>


            </tr>
            </tbody>
        </table>
        </p>

        <p>

            <a class="btn btn-primary" href="#" onClick="$('.display').tableExport({type:'excel',escape:'false'});"><img
                    src='<?= base_url() ?>assets/img/icons/xls.png' width="24"/> Export to Excel</a>
        </p>


    </div>

</div>

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



