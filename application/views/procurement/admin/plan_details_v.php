<div class="row-fluid">
   <div class="span12">
	  <div class="widget">
			<div class="widget-title">
			   <h4><i class="icon-edit"></i>Plan Details</h4>
			   <span class="tools">
			   <a href="javascript:;" class="icon-chevron-down"></a>
			   <a href="javascript:;" class="icon-remove"></a>
                    <a href="<?= base_url() . $this->uri->segment(1) ?>">All plans</a>
			   </span>


            </div>
			<div class="widget-body">
                <div class="space20"></div>
                <div class="row-fluid invoice-list">

                        <h5><?=$page_title?></h5>
                        <p>
                            <b>Financial year: </b> <?=get_procurement_plan_info($plan_id,'financial_year')?><br>
                            <b>Entity: </b> <?=get_procurement_plan_info($plan_id,'pde')?><br>
                            <b>Date added: </b> <?= get_procurement_plan_info($plan_id, 'dateadded') ?> </b><br>
                            <b>Added
                                by: </b><?= get_procurement_plan_info($plan_id, 'author') . ' <small>' . get_usergroup_by_user(get_procurement_plan_info($plan_id, 'author_id')) . '</small>' ?>
                            <br>




                        </p>


                </div>
                <div class="space20"></div>
                <div class="space20"></div>
                <div class="row-fluid">
                    <?php
                    if(get_active_procurement_plan_entries_by($plan_id))
                    {
                        ?>
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>

                                <th>Subject</th>
                                <th class="hidden-480">Procurement type</th>
                                <th class="hidden-480">Funding source</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach(get_active_procurement_plan_entries_by($plan_id) as $entry)
                            {
                                ?>
                                <tr>

                                    <td><?=$entry['subject_of_procurement']?></td>
                                    <td class="hidden-480"><?=get_procurement_type_info_by_id($entry['procurement_type'],'title')?></td>

                                    <td class="hidden-480"><?=get_source_funding_info_by_id($entry['funding_source'],'title')?></td>
                                    <td><?=$entry['estimated_amount'].' '.get_currency_info_by_id($entry['currency'],'abbrv')?></td>
                                </tr>
                            <?php
                            }
                            ?>


                            </tbody>
                        </table>

                    <?php
                    }
                    else
                    {
                        echo info_template('Plan has no entries yet');

                        echo check_my_access('add_procurement_entry') == TRUE ? '<a class="btn btn-xs btn-primary" href="' . base_url() . $this->uri->segment(1) . '/new_entry/m/' . $this->uri->segment(3) . '">Add entry</a>' : '';
                    }
                    ?>

                </div>

				</div>
			</div>
	  </div>
   </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('[data-toggle="popover"]').popover({
            html: true,
            trigger: 'hover'
        });


        $('.endorse').click(function(){

            //loading gif
            $(".message_alerts").html('<img src="<?=base_url()?>images/loading.gif" /> Now loading...');

            $.ajax({
                url: "<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>",
                type: 'POST',
                data:
                {

                    plan_id :         '<?=$plan_id?>',
                    ajax:                 'endorse_plan'
                },
                success: function(msg) {

                    $('.message_alerts').html(msg);
//                    $('.actns').hide();
                    var count = 1;
                    var countdown = setInterval(function(){
                        $("countdown").html(count + " seconds remaining!");
                        if (count == 0) {
                            clearInterval(countdown);
                            window.open("<?=current_url()?>", "_self");

                        }
                        count--;
                    }, 1000);

                }
            });


            return false;

        });
    });
</script>