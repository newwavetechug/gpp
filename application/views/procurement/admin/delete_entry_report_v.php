<div class="widget">
<div class="widget-title">
    <h4><i class="icon-bar-chart"></i> Delete entry </h4>

                                        <span class="tools">

                                        <a href="javascript:;" class="icon-chevron-down"></a>
                                        <a href="javascript:;" class="icon-remove"></a>
                                        </span>
</div>
<div class="widget-body">
    <div class="message_alerts">
        <div class="alert alert-block alert-warning fade in">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <h4 class="alert-heading">Warning!</h4>
            <p>
                Are you sure about deleting this entry?

            </p>
            <a class="btn btn-primary delete_" href="">Yes</a> <a class="btn btn-default" href="<?=base_url().$this->uri->segment(1)?>">Cancel</a>
        </div>
    </div>

</div>
</div>

<script>
    $('.delete_').click(function(){
        //get data values

        var _id='<?=$entry_id?>';



        var action_data =
        {
            id:_id,
            ajax:'form_delete_entry'
        };
        //loading gif
        $(".message_alerts").html('<img src="<?=base_url()?>images/loading.gif" /> Now loading...');


        $.ajax({
            url: "<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2)) ?>",
            type: 'POST',
            data: action_data,
            success: function(msg) {

                $('.message_alerts').html(msg);

                var count = 1;
                var countdown = setInterval(function(){
                    $("countdown").html(count + " seconds remaining!");
                    if (count == 0) {
                        clearInterval(countdown);
                        window.open("<?=base_url().$this->uri->segment(1)?>", "_self");

                    }
                    count--;
                }, 1000);

            }
        });

        return false;


    });
</script>
