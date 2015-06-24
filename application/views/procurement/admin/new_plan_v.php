<!-- BEGIN RECENT ORDERS PORTLET-->
    <div class="widget">
        <div class="widget-title">
            <h4><i class="icon-bar-chart"></i> New plan <a style="margin-left: 20px;" href="<?=base_url()?>procurement"><i class="icon-plus"></i> All plans <span class="badge badge-info"><?=count(get_active_procurement_plans($pde_id))?></span></a></h4>
                                        <span class="tools">
                                        <a href="javascript:;" class="icon-chevron-down"></a>
                                        <a href="javascript:;" class="icon-remove"></a>
                                        </span>
        </div>
        <div class="widget-body">
            <?=$this->load->view('procurement/admin/forms/add_plan_f')?>

        </div>
    </div>
    <!-- END RECENT ORDERS PORTLET-->