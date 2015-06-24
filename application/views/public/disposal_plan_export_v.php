<ol class="breadcrumb">
    <li>
        <a href="<?=base_url().'page/disposal_plans/details/'.$this->uri->segment(3)?>">Back to Disposal Plans</a>
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
                <th>Subject of disposal</th>
                <th>Quantity</th>
                <th>Entity</th>
                <th>Disposal Method</th>
            </tr>

            </thead>
            <tbody>
            <?php
            foreach ($all_records_paginated as $entry) {
                ?>
                <tr>

                    <td><?= $entry['subject_of_disposal']; ?></td>
                    <td>-</td>
                    <td><?= get_pde_info_by_id($entry['pde'], 'title') ?></td>
                    <td><?= get_disposal_method_info_by_id($entry['method_of_disposal'], 'title') ?></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>