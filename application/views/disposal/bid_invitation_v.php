<script type="text/javascript">
     $(document).on('click','.printer',function(){


    $(".table").printArea();

  })


$(document).ready(function() {
  $('.table').dataTable({
     "paging":   false,
        "ordering": true,
        "info":     false });

  /*$('.table tbody').on('click', 'tr', function () {
    var name = $('td', this).eq(0).text();
    alert( 'You clicked on '+name+'\'s row' );
  } );  */
} );



</script>

   <?php
  # created by  mover
  #included into the play : so it would be nice if its plugged in Ajaxly
  /*
  Check if Pde name Exists in the Db..   server side checks
  */

#print_r($bid_inviation);

            $ref_no =  '';
            $disposalserialno ='';
            $biddocumentissuedate = Date('Y-m-d');
            $bid_opening_date =   Date('Y-m-d');
            $subject_of_disposal =  '';
            $date_of_approval_form28 =  date('Y-m-d');
            $date_of_initiation_form28 = date('Y-m-d');
            $cc_approval_date = '';
            $disposal_ref_no = '';
            $bidenddate = date('Y-m-d');
            $receiptid = 0;
            $disposal_id = 0;


                  #exit();
  if((!empty($bid_inviation)) && (count($bid_inviation) > 0) )
  {
     #  print_r($bid_inviation['page_list']);
       $ref_no =  '';
       foreach ($bid_inviation['page_list'] as $key => $row) {
       # code...
        $disposalserialno = $row['disposal_serial_no'];
        $biddocumentissuedate = date('Y-m-d',strtotime($row['bid_document_issue_date']));
        $bid_opening_date =  $row['bid_opening_date'];
        $subject_of_disposal = $row['subject_of_disposal'];
        $date_of_approval_form28 = date('Y-m-d',strtotime($row['date_of_approval_form28']));
        $date_of_initiation_form28 = date('Y-m-d',strtotime($row['date_of_initiation_form28']));
        $cc_approval_date =   date('Y-m-d',strtotime($row['cc_approval_date']));
        $disposal_ref_no = $row['disposal_ref_no'];
        $bidenddate =  date('Y-m-d',(strtotime($row['bid_opening_date'].' + '.$row['bid_duration'].' days' )));

        $disposal_id = $row['id'] ;
     }


  }

print
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


  <div class="widget">
      <div class="widget-title">
          <h4><i class="fa fa-reorder"></i>&nbsp;<?=$page_title; ?> </h4>
              <span class="tools">
                  <a href="javascript:;" class="fa fa-chevron-down"></a>
                  <a href="javascript:;" class="fa fa-remove"></a>
              </span>
      </div>
      <div class="widget-body">


     <div class="row-fluid">
    <form action="#" class="form-horizontal" id="disposal_bid_invitation" name="disposal_bid_invitation"  data-type="newrecord"  data-cheks="pdename<>pdecode" data-check-action=" " data-action="<?=base_url();?>disposal/save_bid_invitation<?= '/'.$i; ?>"    data-elements="*disposal_serial_no<>*disposal_reference_no<>*bid_document_issue_date<>*deadline_for_submition<>*cc_date_of_approval<>*date_of_approval_form28<>*date_of_initiation_form28" >

        <div class="span12">
            <div class="row-fluid">
              <?php
              #print_r($active_procurements);
              ?>
              <div class="control-group">
              <label class="  control-label">Search Disposal Item</label>
              <div class="controls">
               <?php
			         #print_r($disposal_records['page_list']);
			         ?>
               <select  class="span4 chosen disposal_serial_no"  id="disposal_serial_no" name="disposal_serial_no"  data-placeholder="Disposal Reference  Numbers " tabindex="1">


                <?php
                if(!empty($disposalserialno))
                {
                  ?>
                     <option value="0" selected="selected"><?=$disposalserialno; ?> </option>

                  <?php
                }
                else{
               # print_r($disposal_records);

        				 foreach ($disposal_records['page_list'] as $key => $value) {
                ?>
                <option value="<?=$value['id']; ?>"><?=$value['subject_of_disposal']." | ".$value['disposal_serial_no']; ?> </option>
                <?php
                    }
             			}

				        ?>
               </select>
            </div>
            </div>
            </div>
            <!-- date of form28 approval and initiation -->

            <div class="row-fluid">
            <div class="control-group">
            <label class="control-label">Date of Initiation of Form 28  </label>
            <div class="controls">
            <div class="input-append date date-picker" data-date="<?=date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
            <input name="date_of_initiation_form28" data-date="<?=date('Y-m-d'); ?>" class="date_of_initiation_form28" id="date_of_initiation_form28" data-date-format="yyyy-mm-dd" data-date-viewmode="days" class="m-ctrl-medium date-picker" type="text" value="<?=$date_of_initiation_form28 ?>">
            <span class="add-on"><i class="fa fa-calendar"></i></span>
            </div>
            </div> </div>
            </div>

            <div class="row-fluid">
            <div class="control-group">
            <label class="control-label">Date of Approval of Form 28 </label>
            <div class="controls">
            <div class="input-append date date-picker" data-date="<?=date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
            <input name="date_of_approval_form28" data-date="<?=date('Y-m-d'); ?>" class="date_of_approval_form28" id="date_of_approval_form28" data-date-format="yyyy-mm-dd" data-date-viewmode="days" class="m-ctrl-medium date-picker" type="text" value="<?=$date_of_approval_form28; ?>">
            <span class="add-on"><i class="fa fa-calendar"></i></span>
            </div>
            </div>
            </div>
            </div>
            <!-- end of staff -->




             <div class="row-fluid">
              <div class="control-group">
              <label class="control-label" >Disposal Reference Number</label>
              <div class="controls">
               <input class=" m-ctrl-medium   disposal_reference_no span4" name="disposal_reference_no" id="disposal_reference_no" type="text" value="<?=$disposal_ref_no; ?>">
            </div>
            </div> </div>

             <!-- Contracts Committee Approval Date -->
            <div class="row-fluid">
            <div class="control-group">
            <label class="control-label">Contracts Committee  Approval Date</label>
            <div class="controls">
            <div class="input-append date date-picker" data-date="<?=date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
            <input name="cc_date_of_approval" data-date="<?=date('Y-m-d'); ?>" class="cc_date_of_approval" id="cc_date_of_approval" data-date-format="yyyy-mm-dd" data-date-viewmode="days" class="m-ctrl-medium date-picker" type="text" value="<?=$cc_approval_date; ?>">
            <span class="add-on"><i class="fa fa-calendar"></i></span>
            </div>
            </div>
            </div>
            </div>
            <!-- end -->


             <div class="row-fluid">
             <div class="control-group">
              <label class="control-label">Bid Document Issue Date</label>
              <div class="controls">
             <div class="input-append date date-picker" data-date="<?=date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
              <input name="bid_document_issue_date" data-date="<?=date('Y-m-d'); ?>" class="bid_document_issue_date" id="bid_document_issue_date" data-date-format="yyyy-mm-dd" data-date-viewmode="days" class="m-ctrl-medium date-picker" type="text" value="<?=$biddocumentissuedate; ?>">
            <span class="add-on"><i class="fa fa-calendar"></i></span>
            </div>
              </div></div>
            </div>


              <div class="row-fluid">
              <div class="control-group">
              <label class="control-label">Deadline of Submition</label>
              <div class="controls">

              <div class="input-append date date-picker" data-date="<?=date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
              <input name="deadline_for_submition" data-date="<?=date('Y-m-d'); ?>" class="deadline_for_submition" id="deadline_for_submition" data-date-format="yyyy-mm-dd" data-date-viewmode="days" class="m-ctrl-medium date-picker" type="text" value="<?=$bidenddate;?>">
            <span class="add-on"><i class="fa fa-calendar"></i></span>
            </div>

              </div> </div>
            </div>









             <div class="row-fluid">
              <button type="submit" name="save" value="save" class="btn blue"><i class="fa fa-ok"></i> Save</button>
                   &nbsp; &nbsp;&nbsp;
                 <button type="reset" name="cancel" value="cancel" class="btn"><i class="fa fa-remove"></i> Cancel</button>
             </div>

           </div>

        </div>
      </form>
  </div>
  </div>