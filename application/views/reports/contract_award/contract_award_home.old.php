<?php
//print_array($results);
//print_array($this->session->all_userdata());
//print_array(get_pde_info_by_id($this->session->userdata('pdeid'),'title'))

if(isset($errors)){
    echo error_template($errors);
}

if(isset($all_contracts_paginated)){
    echo $pages;
    //print_array($all_contracts);
    ?>
    <table  id=""  class="display table table-hover dt-responsive ">
        <thead>
        <tr>
            <th class="hidden-480">Procurement ref.no</th>
            <th class="hidden-480">Provider</th>
            <th class="hidden-480">Subject of procurement</th>
            <th class="hidden-480">Type of procurement</th>
            <th>Contract value</th>
            <th>Actual payment</th>
        </tr>
        </thead>
        <tbody>
        <?php

        //print_array($results);
        foreach($all_contracts_paginated as $row){
            ?>
            <tr>
                <td><?=get_procurement_plan_entry_info($row['procurement_ref_id'],'procurement_ref_no')?></td>
                <td class="hidden-480"><?=get_procurement_plan_entry_info($row['procurement_ref_id'],'pde')?></td>

                <td class="hidden-480"><?=get_procurement_plan_entry_info($row['procurement_ref_id'],'subject_of_procurement')?></td>
                <td class="hidden-480"><?=get_procurement_plan_entry_info($row['procurement_ref_id'],'procurement_type')?></td>
                <td><?=$row['final_contract_value']?></td>
                <td><?=$row['total_actual_payments']?></td>
            </tr>
            <?php


        }
        ?>

        </tbody>
    </table>
<?php
}


if(isset($results)){
   echo info_template('Use form on the left to filter results');

}else{
    ?>
    <div id="report-results">
        <?php
        if(!empty($page_list)):
            print '<div class="row-fluid">'.
                '<div class="span" style="text-align:center"><h4>'. $report_heading .'</h4></div>'.
                '</div>'.
                (!empty($sub_heading)?
                    '<div class="row-fluid">'.
                    '<div class="span" style="text-align:center"><h5><i>'. $sub_heading .'</i></h5></div>'.
                    '</div>'
                    : '' ).
                '<div class="row-fluid">'.
                '<div class="span2 pull-left" style="text-align:right; font-weight:bold">Financial year:</div>'.
                '<div class="span6 pull-left" style="text-align:left">'. $financial_year .'</div>'.
                '</div>'.
                '<div class="row-fluid">'.
                '<div class="span2 pull-left" style="text-align:right; font-weight:bold">Reporting period:</div>'.
                '<div class="span6 pull-left" style="text-align:left">'. $report_period .'</div>'.
                '</div>';

            print '<table id=""  class="display table table-striped table-hover">'.
                '<thead>'.
                '<tr>'.
                (($formdata['contracts_report_type'] == 'AC')? '<th class="hidden-480">Date signed</th>' : '').
                (in_array($formdata['contracts_report_type'], array('CDC', 'LC'))? '<th class="hidden-480">Planned date of completion</th>' : '').

                '<th align="left">PDE name</th>'.
                '<th class="hidden-480">Procurement ref. no.</th>'.
                '<th class="hidden-480">Subject of procurement</th>'.
                #'<th class="hidden-480">Status</th>'.
                '<th class="hidden-480">Service provider</th>'.
                (in_array($formdata['contracts_report_type'], array('LC'))? '<th class="hidden-480">Days delayed</th>' : '').
                (in_array($formdata['contracts_report_type'], array('CC'))? '<th class="hidden-480">Date of completion</th>' : '').
                (in_array($formdata['contracts_report_type'], array('CC'))? '<th style="text-align:right">Total amount paid (UGX)</th>' : '').
                '<th style="text-align:right">Contract value (UGX)</th>'.
                '</tr>'.
                '</thead>'.
                '</tbody>';

            $grand_contracts_value = 0;
            $grand_total_amount_paid = 0;

            foreach($page_list as $row)
            {
                if(!empty($row['actual_completion_date']) && str_replace('-', '', $row['actual_completion_date'])>0)
                {
                    $status_str = 'COMPLETE';
                }
                else
                {
                    $status_str = 'IN PROGRESS';
                }

                #if multiple providers..
                $providername = $row['providernames'];
                if(!empty($row['joint_venture'])):
                    $providername = '';
                    $jv_info = $this->db->query('SELECT * FROM joint_venture WHERE jv = "'. $row['joint_venture'] .'"')->result_array();

                    if(!empty($jv_info[0]['providers'])):
                        $providers = $this->db->query('SELECT * FROM providers WHERE providerid IN ('. rtrim($jv_info[0]['providers'], ',') .')')->result_array();
                        foreach($providers as $provider):
                            $providername .= (!empty($providername)? ', ' : ''). $provider['providernames'];
                        endforeach;

                    endif;

                endif;

                print '<tr>'.

                    (($formdata['contracts_report_type'] == 'AC')? '<td>'. custom_date_format('d M, Y', $row['date_signed']) .'</td>' : '').
                    (in_array($formdata['contracts_report_type'], array('CDC', 'LC'))? '<td>'. custom_date_format('d M, Y', $row['completion_date']) .'</td>' : '').

                    '<td>'. format_to_length($row['pdename'], 30) .'</td>'.
                    '<td>'. $row['procurement_ref_no'] .'</td>'.
                    '<td>'. $row['subject_of_procurement'] .'</td>'.
                    #'<td>'. $status_str .'</td>'.
                    '<td>'. format_to_length($providername, 40) .'</td>'.
                    (in_array($formdata['contracts_report_type'], array('LC'))? '<td>'. get_date_diff((empty($row['actual_completion_date'])? date('Y-m-d') : $row['actual_completion_date']), $row['completion_date'], 'days') .'</td>' : '').

                    (in_array($formdata['contracts_report_type'], array('CC'))? '<td>'. custom_date_format('d M, Y', $row['actual_completion_date']) .'</td>' : '').
                    (in_array($formdata['contracts_report_type'], array('CC'))? '<td style="text-align:right; font-family: Georgia">'. addCommas($row['total_amount_paid'], 0) .'</td>' : '').

                    '<td style="text-align:right; font-family: Georgia">'. addCommas($row['total_price'], 0) .'</td>'.
                    '</tr>';

                $grand_contracts_value += $row['total_price'];
                $grand_total_amount_paid += $row['total_amount_paid'];
            }

            print '<tr>'.

                (($formdata['contracts_report_type'] == 'AC')? '<td>&nbsp;</td>' : '').
                (in_array($formdata['contracts_report_type'], array('CDC', 'LC'))? '<td>&nbsp;</td>' : '').

                '<td>&nbsp;</td>'.
                '<td>&nbsp;</td>'.
                '<td>&nbsp;</td>'.
                #'<td>'. $status_str .'</td>'.
                '<td>&nbsp;</td>'.
                (in_array($formdata['contracts_report_type'], array('LC'))? '<td>&nbsp;</td>' : '').
                (in_array($formdata['contracts_report_type'], array('CC'))? '<td>&nbsp;</td>' : '').
                (in_array($formdata['contracts_report_type'], array('CC'))? '<td style="text-align:right; font-weight:bold; font-size: 14px; font-family: Georgia">'. addCommas($grand_total_amount_paid, 0) .'</td>' : '').
                '<td style="text-align:right; font-weight:bold; font-size: 14px; font-family: Georgia">'. addCommas($grand_contracts_value, 0) .'</td>'.
                '</tr>';

            print '</tbody></table>';

            print '<div class="pagination pagination-mini pagination-centered">'.
                pagination($this->session->userdata('search_total_results'), $rows_per_page, $current_list_page, base_url().
                    "#")
                .'</div>';

        elseif(!empty($formdata)):
            print format_notice('WARNING: Your search criteria does not match any results');
        endif;
        ?>
    </div>
<?php
}



