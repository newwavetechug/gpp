<div class="widget-body form">
    <!-- BEGIN FORM-->
    <form action="#" class="form-horizontal">
        <div class="control-group">
            <label class="control-label">Title <?=text_danger_template('*')?></label>
            <div class="controls">
                <input value="<?=substr(get_procurement_plan_info($plan_id,'title'),0,-11)?>"  required="" id="title" type="text" class="">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Financial Year</label>
            <div class="controls">

                <input class=" span2 date-picker2" id="start_year"  type="text" value="<?=substr(get_procurement_plan_info($plan_id,'financial_year'),0,4)?>" /> - <input class=" span2 date-picker2" id="end_year"  type="text" value="<?=substr(get_procurement_plan_info($plan_id,'financial_year'),5,4)?>" />
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Description</label>
            <div class="controls">
                <textarea class="span12 wysihtml5" id="description" rows="6">
                    <?=get_procurement_plan_info($plan_id,'description')?>
                </textarea>
            </div>
        </div>



        <div class="form-actions">
            <button  id="submit_plan"  type="submit" class="btn btn-success">Submit</button>
            <a class="btn" href="<?=base_url().$this->uri->segment(1)?>">Cancel</a>
        </div>

        <div class="message_alerts">

        </div>
    </form>
    <!-- END FORM-->
</div>
</div>
<!-- END SAMPLE FORM widget-->

<script>
    $(document).ready(function(){

        $(".date-picker2").datepicker( {
            format: " yyyy", // Notice the Extra space at the beginning
            viewMode: "years",
            minViewMode: "years"
        });



        $('#submit_plan').click(function(){

            //loading gif
            $(".message_alerts").html('<img src="<?=base_url()?>images/loading.gif" /> Now loading...');

            var title                        =$('#title').val();
            var start_year                   =$('#start_year').val();
            var end_year                     =$('#end_year').val();
            var description                  =$('#description').val();
            $.ajax({
                url: "<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>",
                type: 'POST',
                data:
                {
                    title :               title,
                    start_year :          start_year,
                    end :                 end_year,
                    description :         description,
                    plan:                 '<?=$plan_id?>',
                    ajax:                 'edit_procurement_plan'
                },
                success: function(msg) {

                    $('.message_alerts').html(msg);

                }
            });


            return false;

        });


    });
</script>