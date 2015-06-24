<ol class="breadcrumb">
    <li>
        <a href="<?=base_url().'page/procurement_plans/details/'.$this->uri->segment(3)?>">Back To Procurement Plans</a>
    </li>

</ol>
<div class="widget widget-table">
    <div  class="btn-group pull-right">
        <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data
        </button>
        <ul class="dropdown-menu">


            <li><a href="#" onClick="$('#customers2').tableExport({type:'excel',escape:'false'});"><img
                        src='<?= base_url() ?>assets/img/icons/xls.png' width="24"/> XLS</a></li>
            <li><a href="#" onClick="$('#customers2').tableExport({type:'doc',escape:'false'});"><img
                        src='<?= base_url() ?>assets/img/icons/word.png' width="24"/> Word</a></li>

        </ul>
    </div>
    <div class="widget-header"><h3><i class="fa fa-table"></i> <?=$pagetitle?></h3> </div>

    <div class="widget-content">

        <table id="customers2" class="table table-sorting table-striped table-hover datatable" cellpadding="0" cellspacing="0"
               width="100%">
            <thead>
             <tr>
                <th>Quantity</th>
                <th>Subject Of Procurement</th>
                <th>Procurement Type</th>
                <th>Procurement Method</th>
                <th>Source of Funds</th>
                <th>Estimated Cost</th>
            </tr>

            </thead>
            <tbody>
            <?php
                foreach ($all_entries_paginated as $entry) {
                    ?>
                    <tr>
                        <td>-</td>
                        <td><?= $entry['subject_of_procurement']; ?></td>
                        <td><?= get_procurement_type_info_by_id($entry['procurement_type'], 'title') ?></td>
                        <td><?= get_procurement_method_info_by_id($entry['procurement_type'], 'title') ?></td>
                        <td><?= get_source_funding_info_by_id($entry['funding_source'], 'title') ?></td>
                        <td style="text-align: right;"><?= number_format($entry['estimated_amount']); ?>   <?= get_currency_info_by_id($entry['currency'], 'title') ?></td>
                    </tr>
            <?php
                }
            ?>
            </tbody>
        </table>
    </div>
</div>