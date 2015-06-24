<div class="widget-body form">
<!-- BEGIN FORM-->
<form action="<?=base_url() . 'procurement/save_procurement_plan' . ((!empty($i))? '/i/'.$i : '' )?>" class="form-horizontal" enctype="multipart/form-data" method="post">
<!-- <div class="control-group">
    <label class="control-label">Title:</label>
    <div class="controls">
        <input required="" value="<?php if(!empty($formdata['title'])) echo $formdata['title'];?>" id="title" name="title" type="text" class="">
    </div>
</div> -->

    <div class="control-group">
        <label class="control-label">Financial Year:</label>
        <div class="controls">

            <input class=" span2 date-picker2" id="start_year" name="start_year"  type="text" value="<?php if(!empty($formdata['start_year'])) echo $formdata['start_year'];?>" /> - <input class=" span2 date-picker2" id="end_year" name="end_year"  type="text" value="<?php if(!empty($formdata['end_year'])) echo $formdata['end_year'];?>" />
        </div>
    </div>

 <!--    <div class="control-group">
        <label class="control-label">Description:</label>
        <div class="controls">
            <textarea class="span12 wysihtml5" name="description" id="description" rows="6"><?php if(!empty($formdata['description'])) echo $formdata['description'];?></textarea>
        </div>
    </div>
     -->
    <!-- <div class="control-group">
        <label class="control-label">Summarized Plan:</label>
        <div class="controls">
            <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="input-append">
                    <div class="uneditable-input">
                        <i class="icon-file fileupload-exists"></i>
                        <span class="fileupload-preview"></span>
                    </div>
                     <span class="btn btn-file">
                     <span class="fileupload-new">Select file</span>
                     <span class="fileupload-exists">Change</span>
                     <input type="file" class="default" name="summarized_plan" id="summarized_plan" />
                     </span>
                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                </div>
                <span class="help-inline">Allowed formats: .xls, .xlsx</span>
                <span class="help-inline"><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a></span>
            </div>
            <?php if(!empty($formdata['summarized_plan'])): ?>
                     <span class="help-inline"><a target="_new" href="<?=base_url() . 'uploads/documents/summarizedplans/' . $formdata['summarized_plan'] ?>">Download current file</a></span>
            <?php endif; ?>
            <span class="help-inline"><a target="_new" class="btn btn-xs btn-primary" style="font-size:10px; text-transform:uppercase;" href="<?=base_url() . 'downloads/summarized_procurement_plan_template.xls' ?>">Download summarized procurement plan template</a></span>
        </div>
    </div>   -->
    
    <div class="control-group">
          <label class="control-label">Detailed plan:</label>
          <div class="controls">
              <div class="fileupload fileupload-new" data-provides="fileupload">
                  <div class="input-append">
                      <div class="uneditable-input">
                          <i class="icon-file fileupload-exists"></i>
                          <span class="fileupload-preview"></span>
                      </div>
                     <span class="btn btn-file">
                     <span class="fileupload-new">Select file</span>
                     <span class="fileupload-exists">Change</span>
                     <input type="file" class="default" name="detailed_plan" id="detailed_plan" />
                     </span>
                      <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                  </div>
                  <span class="help-inline">Allowed formats: .xls, .xlsx</span>
              </div>
              <span class="help-inline">
                <a target="_new" class="btn btn-xs btn-primary" style="font-size:10px; text-transform:uppercase;" href="<?=base_url() . 'downloads/detailed_procurement_plan_template.xls' ?>">
                  Download Detailed Procurement Plan Template
                </a>
              </span>
          </div>
      </div>



<div class="form-actions">
    <button  id="submit_plan" name="save_plan" value="save_plan"  type="submit" class="btn btn-success">Submit</button>
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
        }).on('changeDate', function (ev) {
      if($(this).attr('id') == 'start_year'){
        var dateParts = ev.date.toString().split(' ');
        $("#end_year").val(parseInt(dateParts[3]) + 1);
      }     
    });
    
    /*
        $('#submit_plan').submit(function(){

            //loading gif
            $(".message_alerts").html('<img src="<?#base_url()?>images/loading.gif" /> Now loading...');

            var title                        =$('#title').val();
            var start_year                   =$('#start_year').val();
            var end_year                     =$('#end_year').val();
            var description                  =$('#description').val();
      var detailed_plan =  $("#detailed_plan")[0].files[0];
      var summarized_plan = $("#summarized_plan")[0].files[0];
      
            $.ajax({
                url: "<?php #echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>",
                type: 'POST',
                data:
                {
                    title :               title,
                    start_year :          start_year,
                    end :                 end_year,
                    description :         description,
                    ajax:                 'add_procurement_plan',
          detailed_plan: detailed_plan,
          summarized_plan: summarized_plan
                },
                success: function(msg) {

                    $('.message_alerts').html(msg);

                }
            });
            return false;

        });
    */

    });
</script>