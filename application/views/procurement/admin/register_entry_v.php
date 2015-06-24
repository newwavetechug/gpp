<!-- BEGIN RECENT ORDERS PORTLET-->

<div class="widget">
    <div class="widget-title">
        <h4><i class="fa fa-plus"></i> New entry <a style="margin-left: 20px;"  href="<?=base_url() . 'procurement/procurement_plan_entries' . (!empty($v)? '/v/' . $v : '')?>" class="   pull-right"><i class="fa fa-list"> </i> All Entries</a></h4>

                                        <span class="tools">

                                        <a href="javascript:;" class="icon-chevron-down"></a>
                                        <a href="javascript:;" class="icon-remove"></a>
                                        </span>
    </div>
    <div class="widget-body">
        <?=$this->load->view('procurement/admin/forms/add_entry_f')?>

    </div>
</div>
<!-- END RECENT ORDERS PORTLET-->