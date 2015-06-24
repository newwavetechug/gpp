<?php


$financialyear = '';
$title = '';
$dateadded = '';
$description = '';
$disposal_id = '';

$start = '';
$end = '';


if(!empty($disposalplan))
{

  $financialyear = $disposalplan[0]['financial_year'];
  $title = $disposalplan[0]['title'];
  $dateadded = $disposalplan[0]['dateadded'];
  $description = $disposalplan[0]['description'];
  $financialyeararray = explode("-", $financialyear);
  $start = $financialyeararray[0];
  $end = $financialyeararray[1];
  $disposal_id  = $disposalplan[0]['id'];

}

  $i = 'insert';
  if(!empty($formtype))
  {

     switch($formtype)
     {
        case 'edit':
        $i  = 'update/'.$disposal_id;
        break;
     }

  }

?>
<script>
    $(document).ready(function(){

        $(".date-picker2").datepicker( {
            format: " yyyy", // Notice the Extra space at the beginning
            viewMode: "years",
            minViewMode: "years"
        });

$("#start_year").focusout(function(){
sty = parseInt($(this).val()) + 1;
$("#end_year").val(sty);
  checkyears($(this).val());
})

$ ("#end_year").focusout(function(){
sty = parseInt($(this).val()) - 1;
$("#start_year").val(sty);
checkyears(sty);
})

  clean  = 0;
  function checkyears(financial_year){
  var endyear = parseInt(financial_year) + 1;
  formdata = {};

  var url = baseurl()+"disposal/checkfinancialyears/<?=$i;?>";
  formdata['financialyear'] = financial_year;
  alertmsg('Proccessing .... ');

  $.ajax({
  type: "POST",
  url:  url,
  data:formdata,
  success: function(data, textStatus, jqXHR){
  console.log(data);


  if(data == 1){
  alertmsg("Diposal Plan  ["+financial_year+"-"+endyear+"]  Financial Year Already Exists");
  clean = 1;}
  else{cancelmsg();clean = 0;}
  },
  error:function(data , textStatus, jqXHR)
  {
  console.log(data);
  }
  });

  }
 });
</script>


    <!-- BEGIN RECENT ORDERS PORTLET-->
    <div class="widget">
    <div class="widget-title">
    <h4><i class="fa fa-bar-chart"></i> <?=$page_title; ?> <a style="margin-left: 20px;" href="<?=base_url()?>disposal/view_disposal_plan"><i class="fa fa-plus"></i>  All Disposal Plans  </a></h4>
    <span class="tools">
    <a href="javascript:;" class="fa fa-chevron-down"></a>
    <a href="javascript:;" class="fa fa-remove"></a>
    </span>
    </div>

  <div class="widget-body">
  <div class="widget-body form">
<!-- BEGIN FORM-->
  <form action="<?=base_url();?>disposal/save_disposal_plan<?= '/'.$i; ?>"   class="form-horizontal" id="disposal_plan" name="disposal_plan"  data-type="newrecord"  data-cheks="disposal_reference_number<>" data-check-action="<?=base_url();?>disposal/save_disposal_plan<?='/'.$i; ?>" data-action="<?=base_url();?>disposal/save_disposal_plan<?= '/'.$i; ?>" datacompare="start_year<>end_year"    data-elements="*start_year<>*end_year"  method="post" enctype="multipart/form-data" >

<!--   <div class="control-group">
  <label class="control-label">Title * </label>
  <div class="controls">
  <input  id="title" name="title" type="text" class="title" value="<?=$title; ?>">
  </div>
  </div> -->

    <div class="control-group">
    <label class="control-label">Financial Year</label>
    <div class="controls">
    <input class=" span2 date-picker2" id="start_year" name="start_year"  datatype="numeric" type="text" value="<?=$start; ?>" /> - <input class=" span2 date-picker2" id="end_year" name="end_year"  datatype="numeric"  type="text" value="<?=$end; ?>" />
    </div>
    </div>
<!--
    <div class="control-group">
    <label class="control-label">Description</label>
    <div class="controls">
    <textarea class="span10 wysihtml5 description" name="description" id="description" rows="6">
    <?=$description; ?>
    </textarea>
    </div>
    </div> -->

      <div class="control-group">
      <label class="control-label">Disposal Plan</label>
      <div class="controls">
      <div class="fileupload fileupload-new" data-provides="fileupload">
      <div class="input-append">
      <div class="uneditable-input">
      <i class="fa fa-file fileupload-exists"></i>
      <span class="fileupload-preview"></span>
      </div>

                     <span class="btn btn-file">
                     <span class="fileupload-new">Select file</span>
                     <span class="fileupload-exists">Change</span>
                     <input type="file" class="default detailed_plan" name="detailed_plan" id="detailed_plan" />
                     </span>
                     <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                     </div>

                  <span class="help-inline">Allowed formats: .xls, .xlsx</span>
                  <br/><br/>

                  <a target="_self" class="btn btn-xs btn-primary" style="font-size:10px; text-transform:uppercase;" href="<?=base_url().'downloads/disposal/disposalplan.xlsx'; ?>   ">Download disposal plan template</a>
                  </div>
    </div>
    </div>




<div class="form-actions">
<button type="submit" name="save" value="save" class="btn blue btnostp" id="btnostp"><i class="fa fa-ok"></i>  Save</button>
<button type="reset" name="cancel" value="cancel" class="btn"><i class="fa fa-remove"></i> Cancel</button>
</div>

</form>
<!-- END FORM-->
</div>
</div>
<!-- END SAMPLE FORM widget-->



    </div>
    </div>
    <!-- END RECENT ORDERS PORTLET-->