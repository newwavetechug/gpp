<form action="<?=base_url() . 'reports/invitation_for_bids_reports'?>"  method="post" class="form-horizontal">


    <div class="control-group">
        <label class="control-label">Financial year:</label>
        <div class="controls">
            <select id="financial_year" class="input-large m-wrap" name="financial_year" tabindex="2">
                <?=get_select_options($financial_years, 'fy', 'label', (!empty($formdata['financial_year'])? $formdata['financial_year'] : '' ))?>
            </select>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" name="view" id="submit" value="view-report" class="btn blue"><i class="icon-ok"></i> View report</button>
    </div>
</form>

<div class="message">

</div>


<script>
    $(document).ready(function () {

        $('#report_type').change(function(){

        });



        $('#submit').click(function () {

            //loading gif
            $(".message").html('<img src="<?=base_url()?>images/loading.gif" /> Now loading...');


            var report_type = $('#report_type').val();
            var pde = $('#pde').val();
            var financial_year = $('#financial_year').val();


            $.ajax({
                url: "<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>",
                type: 'POST',
                data: {
                    report_type: report_type,
                    pde: pde,
                    financial_year: financial_year,
                    ajax: 'generate_report'
                },
                success: function (msg) {

                    $('.message').html(msg);

                }
            });


            return false;

        });


    });
</script>