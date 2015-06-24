<?php
  # created by  mover
  #included into the play : so it would be nice if its plugged in Ajaxly
  /*
  Check if Pde name Exists in the Db..   server side checks
  */



     $disposal_plan =  '';
       $disposal_serialno ='';
        $subjectofdisposal = '';
         $methodofdisposal =  '';
          $assetlocation =  '';
           $reserveprice =  '';
            $currencsy = '';
            $dateaoapproval = Date("Y-m-d");
            $strategicasset = '';
            #$dateofpsstapproval = '';
            $dateaoapproval='';
            $strategicasset = '';
            $dateofaoapproval  = Date("Y-m-d");
            $dateofapproval = Date("Y-m-d");
            $assetquantity = '';



                  $receiptid = 0;


                  #exit();
             # print_r($disposal_records);
  if((!empty($disposal_records)) && (count($disposal_records) > 0) )
  {
       #  print_r($disposal_records);
     $ref_no =  '';

  foreach ($disposal_records['page_list'] as $key => $row) {
    # code...
         #print_r($row);
        $disposal_plan = $row['disp_plan'];
        $disposal_serialno = $row['disposal_serial_no'];
         $subjectofdisposal =  $row['subject_of_disposal'];
          $methodofdisposal =  $row['method'];
           $assetlocation =  $row['asset_location'];
            $reserveprice =  $row['amount'];
            $currencsy = $row['currence'];
            $dateaoapproval=$row['dateofaoapproval'];
            $strategicasset = $row['strategic_asset'];
            $dateofapproval   = Date("Y-m-d",strtotime($row['date_of_approval']));
            $receiptid = $row['id'];
            $assetquantity = $row['quantity'];

  }


  }

  $i = 'insert';
  $xc = 0;
  if(!empty($formtype))
  {
   # print_r($disposal_records);

     switch($formtype)
     {
        case 'edit':
        $xc = 1;
        $i  = 'update/'.$receiptid;
        break;
     }

  }


  ?>


  <div class="widget">
      <div class="widget-title">
          <h4><i class="fa fa-reorder"></i>&nbsp;<?=$page_title; ?> </h4>
              <span class="tools">
                  <a href="javascript:;" class="fa fa-chevron-down"></a>             <a href="javascript:;" class="fa fa-remove"></a>
              </span>
      </div>
      <div class="widget-body">


      <!-- start -->

  <div class="row-fluid">
    <form action="<?=base_url();?>disposal/save_disposal_record<?= '/'.$i; ?>" class="form-horizontal" id="disposalform" name="disposalform"  data-type="newrecord"  data-cheks="disposal_reference_number<>" data-check-action="<?=base_url();?>disposal/checkelements<?='/'.$i; ?>" data-action="<?=base_url();?>disposal/save_disposal_record<?= '/'.$i; ?>"    data-elements="*disposal_plan<>*disposal_serial_number<>*subject_of_disposal<>*method_of_disposal<>*asset_location<>*amount<>*currency<>date_of_approval<>strategic_asset<>*date_of_aoapproval<>*assetquantity" >

        <div class="span12">
           <div class="row-fluid">
              <?php
              #print_r($disposal_plans);
              ?>
              <div class="control-group">
              <label class="  control-label">Disposal  Plan</label>
              <div class="controls">
              <?php
             # print_r($disposal_plans );
              ?>
  <script type="text/javascript">
  $(function(){
   $(".selectdisposal_plan").change(function(){
    var valued = $(".selectdisposal_plan option:selected").text();
    dataserial = $(this).data('serial');
    //alert(dataserial);
   // dataarray = valued.split("|");
    //alert(dataarray);
    //datet = dataarray[2];
    datayearsarray =valued.split("-");
    dataserial += datayearsarray[0].trim() + "/"+datayearsarray[1].trim()+"/"+getRandomArbitrary(9876543210,1234567890);
    $("#disposal_serial_number").val(dataserial);
    //alert(dataserial);

    //alert(dataarray[0]);
   });

   function getRandomArbitrary(min, max) {
    return Math.floor(Math.random() * (max - min) + min);
}
  })

</script>

        <select data-serial="<?=$serialnumber; ?>"; class=" chosen span4 selectdisposal_plan serial_updater" name="selectdisposal_plan" id="disposal_plan" >
             <option selected="selected" disabled>  Select Disposal Plan </option>
               <?php
               foreach ($disposal_plans as $key => $value) {
                 # code...
                ?>
                <option value="<?=$value['id']; ?>" <?php if(($disposal_plan == $value['title'])&&($xc==1)){ ?> selected <?php } ?>  ><?=$value['financial_year']; ?>
                </option>
                <?php
               }
               ?>
          </select>

            </div>
            </div>
            </div>
             <br/>
            <div class="row-fluid">
              <?php
              #print_r($active_procurements);
              ?>
              <!-- Disposal Serial Number -->
              <div class="control-group">
              <label class="  control-label">Disposal Serial Number</label>
              <div class="controls">
              <input type='text' id="disposal_serial_number" dataurl="<?=base_url().'disposal/check/refno'; ?>"  class="span4 disposal_serial_number  servercheck"   name="disposal_serial_number" id="disposal_serial_number" value="<?=$disposal_serialno; ?>" readonly/>
              </div>
              </div>

            </div>
            <!-- Subject of Disposal -->
             <br/>
             <div class="row-fluid">
               <div class="control-group">
              <label class="control-label" >Subject of Disposal</label>
                <div class="controls">
                <input type='text'   class="span4 subject_of_disposal"  value="<?=$subjectofdisposal; ?>" name="subject_of_disposal" id="subject_of_disposal"/>
              </div>

            </div>
            </div>
            <br/>

              <!-- Method of Disposal -->
              <div class="row-fluid">
               <div class="control-group">
              <label class="control-label" >Method of Disposal</label>
              <div class="controls">

              <?php
              # print_r($disposal_methods['page_list'] );
              ?>
           <select class="chosen span4 method_of_disposal" name="method_of_disposal" id="method_of_disposal">
               <?php
               foreach ($disposal_methods['page_list'] as $key => $value) {
                # code...
                ?>
                <option value="<?=$value['id']; ?>" <?php if($methodofdisposal == $value['method']){?>selected <?php }?> ><?=$value['method'].' '; ?></option>
                <?php
               }
               ?>

            </select>
            </div>

            </div>
            </div>
            <br/>

<!-- Asset Location -->
              <div class="row-fluid">
              <div class="control-group">
               <label class="control-label">Asset Location </label>
               <div class="controls">
               <input type='text'   class="span4 asset_location"  value="<?=$assetlocation; ?>" name="asset_location" id="asset_location"/>
               </div>
               </div>
               </div>
               <br/>
<!-- Quantity -->

   <div class="row-fluid">
              <div class="control-group">
               <label class="control-label">Quantity </label>
               <div class="controls">
               <input type='text'   class="span4 assetquantity numbercommas"  value="<?=$assetquantity; ?>" name="assetquantity" id="assetquantity"  datatype="money"/>
               </div>
               </div>
               </div>
               <br/>
<!-- Reserve Price -->

            <div class="row-fluid">
            <div class="control-group">
            <label class="control-label">Reserve Price</label>
            <div class="controls">
            <input type='text'   class="span4 amount numbercommas" value="<?=$reserveprice; ?>" name="amount" id="amount" datatype="money"/>
              <?php
                    #  print_r($currency);
              ?>
            <select type='text'   class="span2 currency chosen"   name="currency" id="currency">
                          <?php
                          foreach ($currency as $key => $value) {
                          # code...
                          ?>
                          <option value="<?=$value['abbr']; ?>" <?php if($currencsy == $value['abbr']) {?> selected<?php } else{ ?> <?=$value['abbr'] == 'UGX' ? 'selected':'';  } ?>> <?=$value['abbr']; ?> </option>
                           <?php
                          }
                          ?>
            </select>
            </div>
            </div>
            </div>

  <!-- Date of AO approval -->
              <br/>
              <div class="row-fluid  ">
              <div class="control-group">
              <label class="control-label">Date of AO approval</label>
              <div class="controls">


        <div class="input-append date date-picker" data-date="<?=date('Y-m-d',strtotime($dateofaoapproval)); ?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
        <input name="date_of_aoapproval"  data-date="<?=date('Y-m-d',strtotime($dateofaoapproval)); ?>" id="date_of_aoapproval" data-date-format="yyyy-mm-dd" data-date-viewmode="days" class="m-ctrl-medium date-picker" type="text" value="<?=date('Y-m-d',strtotime($dateofaoapproval)); ?>">
        <span class="add-on"><i class="fa fa-calendar"></i></span>
        </div>

            </div>
            </div>
            </div>
            <br/>

             <div class="row-fluid">
             <div class="control-group">
             <script type="text/javascript">
             onClick="javascript:$('#ppstapproval').fadeToggle();"
             $(function(){
             $("#strategic_asset").click(function(){
              if(this.checked){
                $('.ppstapproval').removeClass('hidden');
                $(this).val('Y');
              }else{
                  $('.ppstapproval').addClass('hidden');
                  $(this).val('N');
              }

             });
             })
             </script>
             <?php
             #print_r($strategicasset);
             ?>
              <label class="control-label">
                <input type="checkbox" id="strategic_asset" name="strategic_asset" <?php if($strategicasset=='Y'){?>checked <?php } ?> value="<?= $strategicasset=='Y'? 'Y':'N' ?>" > Is this a strategic asset?</label>
                 </div>

              <div class="row-fluid ppstapproval  <?= $strategicasset=='Y'? '':'hidden' ?>">
              <div class="control-group">
              <label class="control-label">Date of PSST approval</label>
              <div class="controls">


          <div class="input-append date date-picker" data-date="<?=$dateofapproval; ?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
          <input name="date_of_approval"  data-date="<?=$dateofapproval; ?>" id="date_of_approval" data-date-format="yyyy-mm-dd" data-date-viewmode="days" class="m-ctrl-medium date-picker" type="text" value="<?=$dateofapproval; ?>">
          <span class="add-on"><i class="fa fa-calendar"></i></span>
          </div>

                </div>
              </div>
            </div>
            <br/>





             <div class="row-fluid">
             <button type="submit" name="save" value="save" class="btn blue"><i class="fa fa-ok"></i> Save</button>
             <button type="submit" name="save" value="save" class="btn blue"><i class="fa fa-tick"></i> Submit Entry</button>
             <button type="submit" name="save" value="save" class="btn blue"><i class="fa fa-ok"></i> Submit and Add New </button>

                  &nbsp; &nbsp;&nbsp;
                 <button type="reset" name="cancel" onClick="javascript:location.href='<?=base_url()."disposal/view_disposal_records"; ?>' " value="cancel" class="btn"><i class="fa fa-remove"></i> Cancel</button>
             </div>

           </div>

        </div>
      </form>
  </div>
  </div>