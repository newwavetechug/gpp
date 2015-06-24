<style type="text/css">
    .ui-menu
  {
    background: #eee; z-index: 999;
  }
  .ui-menu .ui-menu-item a{
     
      height:14px;
      font-size:13px;
  }
  </style>

 
   

   <?php
  # print_array(mysqli_fetch_array($ropproviders));
  # created by  mover 
  #included into the play : so it would be nice if its plugged in Ajaxly
  /*
  Check if Pde name Exists in the Db..   server side checks 
  */
   
  


     $ref_no =  '';
       $orgname='';
        $datesuspended= '';
         $nationality =  '';
          $reason=  '';
           $receivedby =  '';
            $approved = 'Y';
                  
                  $recordid = 0;
                  $orgid = 0;
                  $decider = 0;

               
              # print_r($suspension_details);
                  #exit();
  if((!empty($suspension_details)) && (count($suspension_details) > 0) )
  {
   #print_r($suspension_details); 
   $row = mysqli_fetch_array($suspension_details);
   print_r(mysqli_fetch_array($suspension_details)); 
  # exit();

         $orgname = $row ['orgname'];
        # print_r($orgname);
         $datesuspended=  $row ['datesuspended'];
         $endsuspension=  $row ['endsuspension'];        
         $reason=  $row ['reason'];
         $recordid = $row['recordid'];
         $orgid = $row['orgid'];
         $decider = $row['decider'];
   


  }

  $i = 'insert';
  if(!empty($formtype))
  {
     
     switch($formtype)
     {
        case 'edit':
        $i  = 'update/'.$recordid ;    
        break;
     }

  }


  ?>


  <div class="widget">
      <div class="widget-title">
          <h4><i class="fa fa-reorder"></i>&nbsp;<?= $page_title; ?> </h4>
      <span class="tools">
      <a href="javascript:" class="fa fa-chevron-down"></a>
      <a href="javascript:" class="fa fa-remove"></a>
      </span>
      </div>
      <div class="widget-body">


      <!-- start -->

  <div class="row-fluid">
    <form action="#" class="form-horizontal" id="provider_suspension" name="provider_suspension"  data-type="newrecord"  data-cheks="pdename<>pdecode" data-check-action="<?=base_url();?>providers/<?='/'.$i; ?>" data-action="<?=base_url();?>providers/save_suspended_provider<?= '/'.$i; ?>"
          data-elements="provider2<>provider<>*suspensionduration<>*reason<>*indifintedatestart">
        <div class="span12">
            <div class="row-fluid">             
                <div class="control-group">
                    <label class=" control-label">Add Provider </label>

                    <div class="controls ">
                    <?php
                   # echo $decider; exit();
                    ?>
                        <input type="text" id="provider2" value="<?php if($decider ==0){ echo $orgname;} ?>">
                        <?php
                // print_r($ropproviders); 
                //   $query = mysqli_fetch_array($ropproviders);
                #print_r($orgname);

                ?>


                    </div>

                </div>
            </div>
            <br/>

            <div class="row-fluid">
                <div class="control-group">
                    <label class=" control-label">or Select from the ROP </label>

                    <div class="controls ">

                        <?php
                        // print_r($ropproviders);
                        //   $query = mysqli_fetch_array($ropproviders);
                        #print_r($orgname);

                        ?>

                        <select class="span4 chosen provider" id="provider" name="provider"
                                data-placeholder="Providers List " tabindex="1">
              
                  <?php
                
                switch($formtype)
                {
                case 'edit':
                echo '<option value="<?=$orgid;?>">'.$orgname.'</option>';
                break;
                default :
                    while ($row = mysqli_fetch_array($ropproviders)) {
                    # code...
                    ?>
                    <option value="<?=$row['recordid']; ?>"><?=$row['orgname']; ?> </option>
                    <?php
               
                }
                  break;
                    
                  } 
                  
                  ?>
                        </select>
                    </div>

              </div>
            </div> <br/>


            <script type="text/javascript">
                $(function () {
                    cheked = 0;
                    $("#indefin").click(function () {

                        if (this.checked) {
                            cheked = 1;
                            $(".suspensiondiv").removeClass('hidden');
                            $(".suspensionperiodiv").addClass('hidden');
                        } else {
                            cheked = 0;
                            $(".suspensiondiv").addClass('hidden');
                            $(".suspensionperiodiv").removeClass('hidden');

                        }
                    })
                });
            </script>

            <div class="row-fluid">
                <div class="control-group">
                    <label class="control-label"><input type="checkbox" name="indefin" id="indefin"/> Is it Indefinite?</label>

                    <div class="controls  suspensiondiv hidden">
                        <input name="indifintedatestart" data-date="2015-05-04" id="indifintedatestart"
                               data-date-format="yyyy-mm-dd" data-date-viewmode="days" class="m-ctrl-medium date-picker"
                               type="text" value="2015-05-04">


                    </div>
                </div>
            </div>


            <div class="row-fluid suspensionperiodiv">
                <div class="control-group">
              <label class="control-label" >Suspension Period : *</label>
              <div class="controls">
                  <?php /*   $orgname= $row ['orgname'];
         $datesuspended=  $row ['datesuspended'];
         $endsuspension=  $row ['endsuspension'];        
         $reason=  $row ['reason'];    */  
         ?>   
        
            <input type="text" value="<?php if(isset($formtype) && $formtype=='edit'){ ?><?=date('m/d/Y',strtotime($datesuspended)); ?> - <?=date('m/d/Y',strtotime($endsuspension)); } ?>" class="span8 suspensionduration dtpicker" value="" name="suspensionduration" id="suspensionduration" placeholder="From - To ">
              
            </div> 
            </div>
            </div>
            <br/>
            <br/>

            <div class="row-fluid">
              <div class="control-group">
              <label class="control-label">Reason : *</label>
               <div class="controls ">
             <textarea class="span8 reason" id="reason" name="reason" rows="8">
             <?= $reason; ?>
             </textarea>
            </div>
              </div>                     
            </div>
            

  <br/>
  <br/>
  <div class="row-fluid">
          <button type="submit" name="save" value="save" class="btn blue"><i class="fa fa-ok"></i> Suspend</button>

        &nbsp; &nbsp;&nbsp;
                 <button type="reset" name="cancel" value="cancel" class="btn"><i class="fa fa-remove"></i> Cancel</button>
          </div>

      </div>
    </form>
  </div>
  </div>