<?php
//print_array($results)
//print_array($report_heading)

$contract_value=array();
$actual_contract_payment=array();
$estimated_values=array();

$within_contract_value=array();

$contracts_completed_early=array();
$contracts_completed_on_time=array();
$contracts_completed_late=array();

$total_bid_receipts=array();




$procurement_methods=array();

$pdes=array();
$results_pde_filtered=array();
$threshold='1209600';
$less_than_thresh_hold=array();

$suspended_providers=array();

$inconsitent_evalution=array();


// better totals
$available_procurement_methods=array();

//lead time by procurement method
$lead_time_by_procurement_methed=array();



foreach($results as $row){
    $contract_value[]=$row['final_contract_value'];
    $actual_contract_payment[]=$row['total_actual_payments'];
    $estimated_values[]=$row['estimated_amount'];

    //get contracts completed within original congract value
    if($row['final_contract_value']<=$row['estimated_amount']){
        $within_contract_value[]=$row['id'];

    }

    //contracts completed early
    if(strtotime($row['commencement_date'])>strtotime($row['actual_completion_date'])){
        $contracts_completed_early[]=$row['id'];

    }

    //contracts completed on time
    if(strtotime($row['commencement_date'])==strtotime($row['actual_completion_date'])){
        $contracts_completed_on_time[]=$row['id'];

    }

    //contracts completed on late
    if(strtotime($row['commencement_date'])<strtotime($row['actual_completion_date'])){
        $contracts_completed_late[]=$row['id'];

    }
    $total_bid_receipts[]=count(get_bid_receipts_by_bid($row['id']));

    if(!in_array($row['procurement_method'],$procurement_methods)){
        $procurement_methods[$row['procurement_method']]=count(get_bid_receipts_by_procurement_method($row['procurement_method'],$from,$to));
    }



    //better totals
    if(!in_array(get_procurement_method_info_by_id($row['procurement_method'],'title'),$available_procurement_methods)){
        $available_procurement_methods[]=get_procurement_method_info_by_id($row['procurement_method'],'title');
    }


}

//$occurence_procurement_types=array_count_values($procurement_types);


$bids_by_procurement_method=array();
foreach($procurement_methods as $key=>$value){

    $bids_by_procurement_method[]=$value;


}
$total_bids_by_procurement_method=array_sum($bids_by_procurement_method);

//print_array($_POST);
//print_array($available_procurement_methods);

//print_array(json_encode($available_procurement_methods, JSON_NUMERIC_CHECK));

 $prepared_methods="'" . implode("','", $available_procurement_methods) . "'";




?>


    <?php
    switch($this->input->post('report_type')){
        case 'timeliness_of_contract_completion':
            //all contracts this year
            $all_contracts=$all_contracts_in_this_year;

            //print_array($results);

            ?>
            <div id="timelines_1" style="height: 400px"></div>
            <script>
                $(function () {

                    //time lines
                    $('#timelines_1').highcharts({
                        chart: {
                            type: 'pie',
                            credits: {
                                enabled: false
                            },
                            options3d: {
                                enabled: true,
                                alpha: 45,
                                beta: 0
                            }
                        },
                        title: {
                            text: '<?=$report_heading?>'
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                depth: 35,
                                dataLabels: {
                                    enabled: false
                                },
                                showInLegend: true
                            }
                        },
                        series: [{
                            type: 'pie',
                            name: 'Percentage of contracts completed actual completion after actual completion date',
                            data: [

                                {
                                    name: 'Contracts completed after actual completion date',
                                    y: <?=count($results)?>,
                                    sliced: true,
                                    selected: true
                                },
                                ['Contracts completed within actual completion date',       <?=count($all_contracts_in_this_year)- count($results)?>]
                            ]
                        }]
                    });



                });
            </script>
            <?php

            break;
        case 'procurement_lead_time_report':
            //contracts whose planned date of completion is greater than actual date of completion

            ?>
            <div id="lead_times" style="height: 400px"></div>

            <script>
                $(function () {
                    $('#container').highcharts({
                        chart: {
                            type: 'column',
                            margin: 75,
                            options3d: {
                                enabled: true,
                                alpha: 10,
                                beta: 25,
                                depth: 70
                            }
                        },
                        title: {
                            text: '3D chart with null values'
                        },
                        subtitle: {
                            text: 'Notice the difference between a 0 value and a null point'
                        },
                        plotOptions: {
                            column: {
                                depth: 25
                            }
                        },
                        xAxis: {
                            //categories: Highcharts.getOptions().lang.shortMonths
                            categories: [<?=$prepared_methods?>]
                        },
                        yAxis: {
                            title: {
                                text: null
                            }
                        },
                        series: [{
                            name: 'Average lead time ',
                            data: [2, 3, null, 4, 0, 5, 1, 4, 6, 3]
                        }]
                    });




                    //lead times
                    $('#lead_times').highcharts({
                        title: {
                            text: 'Procurement lead times',
                            x: -20 //center
                        },
                        subtitle: {
                            text: 'Source: PPDA',
                            x: -20
                        },
                        xAxis: {
                            categories: [<?=$prepared_methods?>]
                        },
                        yAxis: {
                            title: {
                                text: 'Temperature (°C)'
                            },
                            plotLines: [{
                                value: 0,
                                width: 1,
                                color: '#808080'
                            }]
                        },
                        tooltip: {
                            valueSuffix: '°C'
                        },
                        legend: {
                            layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'middle',
                            borderWidth: 0
                        },
                        series: [{
                            name: 'Tokyo',
                            data: [7.0, 6.9, 9.5]
                        }, {
                            name: 'New York',
                            data: [-0.2, 0.8, 5.7]
                        }, {
                            name: 'Berlin',
                            data: [-0.9, 0.6, 3.5]
                        }, {
                            name: 'London',
                            data: [3.9, 4.2, 5.7]
                        }]
                    });

                });
            </script>
            <?php

            break;
        default:
            ?>


                <div class="span12">
                    <div id="completed_within_original_value" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
                </div>
                <script>
                    $(function () {

                        $(document).ready(function () {



                            // within original value
                            $('#completed_within_original_value').highcharts({
                                chart: {
                                    plotBackgroundColor: null,
                                    plotBorderWidth: null,
                                    plotShadow: false
                                },

                                title: {
                                    text: 'Proportion of contracts completed within original value'
                                },
                                tooltip: {
                                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                                },
                                plotOptions: {
                                    pie: {
                                        allowPointSelect: true,
                                        cursor: 'pointer',
                                        dataLabels: {
                                            enabled: false
                                        },
                                        showInLegend: true
                                    }
                                },
                                series: [{
                                    type: 'pie',
                                    name: 'Contracts',
                                    data: [
                                        ['Contracts completed within original contract value',   <?=count($results)?>],
                                        {
                                            name: 'Contracts completed above original value',
                                            y: <?=count($all_contracts_in_this_year)-count($results)?>,
                                            sliced: true,
                                            selected: true
                                        }
                                    ]
                                }]
                            });
                        });




                    });
                </script>
    <?php
    }
    ?>




