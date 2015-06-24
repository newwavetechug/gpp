<?php
  # created by  mover 
  #included into the play : so it would be nice if its plugged in Ajaxly
  /*
  Check if Pde name Exists in the Db..   server side checks 
  */
   


     $ref_no =  '';
       $serviceprovider ='';
        $pdecategory = '';
         $nationality =  '';
          $datesubmitted =  '';
           $receivedby =  '';
            $approved = 'Y';
                  
                  $receiptid = 0;

               
                  #exit();
  if((!empty($receiptinfo)) && (count($receiptinfo) > 0) )
  {
       #  print_r($receiptinfo); 
     $ref_no =  ''; 
       $serviceprovider = $receiptinfo['providernames'];

        $pdecategory = '';
         $nationality =  $receiptinfo['nationality'];
          $datesubmitted =  '';
           $receivedby =  $receiptinfo['received_by'];
            $approved =  $receiptinfo['approved'];

              $receiptid = $receiptinfo['receiptid'];


  }

  $i = 'insert';
  if(!empty($formtype))
  {
     
     switch($formtype)
     {
        case 'edit':
        $i  = 'update/'.$receiptid;    
        break;
     }

  }


  ?>

<?php
#print_r($disposal_records);
?>
  <div class="widget">
      <div class="widget-title">
          <h4><i class="icon-reorder"></i>&nbsp;<?=$page_title; ?> </h4>
              <span class="tools">
                  <a href="javascript:;" class="icon-chevron-down"></a>
                  <a href="javascript:;" class="icon-remove"></a>
              </span>
      </div>
      <div class="widget-body">


     <div class="row-fluid">
    <form action="#" class="form-horizontal" id="signcontract" name="signcontract"  data-type="newrecord"  data-cheks="pdename<>pdecode" data-check-action=" " data-action="<?=base_url();?>disposal/save_contract<?= '/'.$i; ?>"    data-elements="*disposalitem<>beneficiary<>*contractamount<>*currency<>*datesigned" >
                                      
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
        <script type="text/javascript">
        ranking = 0;
       function checkdisposal(st){
        //alert(st);
         $(".providerss").addClass("hidden");
         $(".provider_namel").fadeIn('fast'); 
          
        alertmsg('Proccessing ... ');
        url = baseurl()+"disposal/fetchdisposal_buyerinfo";
        formdata = {};
        if(st <= 0)
          return;

    formdata['disposalrecord'] = st;   
    $.ajax({
        type: "POST",
        url:  url,
        data: formdata,
        success: function(data, textStatus, jqXHR){          
        console.log(data);
        var dst = data.split(":");
        if(dst[0] == 4)
        {
          ranking = 0;
           alertmsg(dst[1]);
        }
       else if(data[0] == 8)
        {
          $(".providerss").removeClass("hidden");

           $(".providerss").html(data.substr(2,100000)); 
           $(".provider_namel").fadeOut('fast');   
           ranking = 1;      
        }   

         else if(data[0] == 7)
        {
          alertmsg('');
           ranking = 1;      
        }   

        else{
          ranking = 0;
        }    

        },
        error:function(data , textStatus, jqXHR)
        {
            console.log('Data Error'+data+textStatus+jqXHR);
            alert(data);
        }
       });


       }
        </script>
               <select  class="span4 chosen disposalitem"  onchange="javascript:checkdisposal(this.value);" id="disposalitem" name="disposalitem"  data-placeholder="Disposal Reference  Numbers " tabindex="1">
               <option>Select </option>
                <?php
                 # print_r($disposal_records);
        				 foreach ($disposal_records['page_list'] as $key => $value) {
                ?>
                <option value="<?=$value['id']; ?>"><?=$value['subject_of_disposal']." | ".$value['disposal_serial_no']; ?> </option>
                <?php
             			}
	 
				        ?>
               </select>
            </div>    
            </div>            
            </div>
            <!-- date of form28 approval and initiation -->

            <div class="row-fluid">
            <div class="control-group">             
            <label class="control-label">Buyer/Beneficiary </label>
            <div class="controls  buyers">
              <input class=" m-ctrl-medium   beneficiary  provider_namel span4" name="beneficiary" id="beneficiary" type="text" value="">
             <br/>
             <div class=" alert-info providerss hidden span4 ">
             </div>
            </div> </div>                   
            </div>  
            <!-- contract amount-->


            <div class="row-fluid">
            <div class="control-group">             
            <label class="control-label">Contract Amount </label>
            <div class="controls">
              <input class=" m-ctrl-medium   provider_name contractamount  numbercommas span4" name="contractamount" id="contractamount" type="text" value="">
              <?php
                    #  print_r($currency); 
              ?>
              <select type='text'   class="span2 currency chosen" value="<?=$serviceprovider; ?>" name="currency" id="currency">
              <?php
              foreach ($currency as $key => $value) {
              # code...
                    
                    ?>
                          <option value="<?=$value['abbr']; ?>" <?=$value['abbr'] == 'UGX' ? 'selected':'';  ?>> <?=$value['abbr']; ?> </option>
                          
                          <?php
                    }
                      ?>
              </select> 
            </div> </div>                   
            </div>  
            <!-- end -->

            <div class="row-fluid">
            <div class="control-group">             
            <label class="control-label">Date Signed</label>
            <div class="controls">
            <div class="input-append date date-picker" data-date="<?=date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
            <input name="datesigned" data-date="<?=date('Y-m-d'); ?>" class="datesigned" id="datesigned" data-date-format="yyyy-mm-dd" data-date-viewmode="days" class="m-ctrl-medium date-picker" type="text" value="<?=date('Y-m-d'); ?>">
            <span class="add-on"><i class="icon-calendar"></i></span>
            </div>
            </div> 
            </div>                   
            </div>  
            <!-- end of staff -->

           
            
             
          

  

        


  

             <div class="row-fluid">
              <button type="submit" name="save" value="save" class="btn blue"><i class="icon-ok"></i> Save</button>
                   &nbsp; &nbsp;&nbsp;
                 <button type="reset" name="cancel" value="cancel" class="btn"><i class="icon-remove"></i> Cancel</button>
             </div>

           </div>

        </div>
      </form>
  </div>
  </div>