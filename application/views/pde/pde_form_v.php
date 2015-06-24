<!-- BEGIN PAGE CONTENT-->
        <style type="text/css">
        /* Twitter-like glowing box */
 
 
.seterror {
  box-shadow: 0 0 5px rgba(81, 203, 238, 1);
  -webkit-box-shadow: 0 0 5px rgba(81, 203, 238, 1);
  -moz-box-shadow: 0 0 5px rgba(81, 203, 238, 1);
  padding: 3px 0px 3px 3px;
  margin: 5px 1px 3px 0px;
  border: 1px solid rgba(81, 203, 238, 1);;
}
</style>    
<?php
# created by  mover 
#included into the play : so it would be nice if its plugged in Ajaxly
/*
Check if Pde name Exists in the Db..   server side checks 
*/
 


   $pdename =  '';
     $pdeabbreviation = '';
      $pdecategory = '';
       $pdetype =  '';
        $pdecode =  '';
         $pderollcat =  '';
          $pdeaddress =  '';
           $pdetel =  '';
            $pdefax =  '';
             $pdeemail =  '';
              $pdewebsite =  '';
                
               $pdeid = 0;
if((!empty($pdedetails)) && (count($pdedetails) > 0) )
{
   foreach ($pdedetails as $key => $row) {
      # code...
   $pdename =  $row['pdename'];
     $pdeabbreviation =  $row['abbreviation'];
      $pdecategory =  $row['category'];
       $pdetype =  $row['type'];
        $pdecode =  $row['code'];
         $pderollcat =  $row['pde_roll_cat'];
          $pdeaddress =  $row['address'];
           $pdetel =  $row['tel'];
            $pdefax =  $row['fax'];
             $pdeemail =  $row['email'];
              $pdewebsite =  $row['website'];
              
                $pdeid = $row['pdeid'];
   }


}

$i = 'insert';
if(!empty($formtype))
{
   
   switch($formtype)
   {
      case 'edit':
      $i  = 'update/'.$pdeid;    
      break;
   }

}


?>


            <div class="row-fluid">
               <div class="span12">
                  <div class="widget box blue" id="form_wizard_1">
                     <div class="widget-title">
                        <h4>
                           <i class="fa fa-reorder"></i> PDE Registration - <span class="step-title">Step 1 of 2</span>
                        </h4>
                        <span class="tools">
                           <a href="javascript:;" class="fa fa-chevron-down"></a>
                           <a href="javascript:;" class="fa fa-remove"></a>
                        </span>
                     </div>
                     <div class="widget-body form">
                          <div class="form-wizard">
                              <div class="navbar steps">
                                 <div class="navbar-inner">
                                    <ul class="row-fluid">
                                       <li class="span4">
                                          <a href="#tab1" data-toggle="tab" class="step active">
                                          <span class="number">1</span>
                                          <span class="desc"><i class="fa fa-ok"></i> PDE Information  </span>
                                          </a>
                                       </li>
                                       <li class="span8">

                                          <a href="#tab2" data-toggle="tab" class="step">
                                          <span class="number">2</span>
                                          <span class="desc"><i class="fa fa-ok"></i> Accounting Officer , CC & PDU  </span>
                                          </a>
                                       </li>
                                     <!--   <li class="span3">
                                          <a href="#tab3" data-toggle="tab" class="step">
                                          <span class="number">3</span>
                                          <span class="desc"><i class="fa fa-ok"></i> Step 3</span>
                                          </a>
                                       </li> -->
                                      <!--  <li class="span3">
                                          <a href="#tab4" data-toggle="tab" class="step">
                                          <span class="number">4</span>
                                          <span class="desc"><i class="fa fa-ok"></i> Final Step</span>
                                          </a> 
                                       </li> -->
                                    </ul>
                                 </div>
                              </div>
                              <div id="bar" class="progress progress-striped">
                                 <div class="bar"></div>
                              </div>
                              <div class="tab-content">
                             
                                 <div class="tab-pane active" id="tab1">
                                   <form action="#" class="form-horizontal" id="pderegistration" name="pderegistration"  data-type="newrecord"  data-cheks="pdename<>pdecode" data-check-action="<?=base_url();?>pdes/ajax_pde_validation/<?=$i; ?>" data-action="<?=base_url();?>pdes/ajax_formsubmit/1/<?=$i; ?>"    data-elements="*pdename<>*pdeabbreviation<>*pdecategory<>pdetype<>pdecode<>pderollcat<>pdeaddress<>pdetel<>pdefax<>pdeemail<>pdewebsite" >
                        
                                    <h3>PDE Registration : </h3>

                                    <div class="control-group">
                                    <div class="row-fluid">
      <div class="span12">
         <div class="row-fluid">
            <div class="span6">
            
             <strong class="span4">PDE Name : * </strong>
             <input type="hidden" value="<?=$i; ?>" id="fmtype" />
               <input type="hidden" value="<?=$pdename; ?>" id="pdname" />

              <input type="text" value="<?=$pdename; ?>" onChange="javascript:instantcheck(this.value,'<?=base_url();?>pdes/ajax_pde_validation/<?=$i; ?>'  );" class="span8 pdename" id="pdename"  name="pdename" value="" datatype="text" />
            </div>
            <div class="span6">
             
              <strong class="span4">Abbreviation : * </strong>
              <input value="<?=$pdeabbreviation; ?>"   type="text" class="span8 pdeabbreviation" id="pdeabbreviation" value=""  name="pdeabbreviation" datatype="text" />
            </div>
         </div>
<br/>
          <div class="row-fluid">
            <div class="span6">
            
             <strong class="span4">Category : * </strong>
              <SELECT  class="span8 pdecategory "  id="pdecategory" name="pdecategory" datatype="select">
              <option value="local government" <?php if(($pdecategory != '')  && ($pdecategory == 'local government')){ ?>selected<?php } ?>  >Local Government</option>                
               <option value="central government" <?php if(($pdecategory != '')  && ($pdecategory == 'central government')){ ?> selected <?php } ?> >Central Government</option>
               
               </SELECT> 
            </div>
            <div class="span6">
             
             <strong class="span4">PDE Types : * </strong>
              <SELECT  class="span8 pdetype "  id="pdetype" name="pdetype" datatype="select">
                <?php

                if((!empty($pdetypes)) && (count($pdetypes) > 0))
               foreach ($pdetypes as $key => $row) {
                  if(($pdetype != '')&& ($pdetype >0) && ($pdetype == $row['pdetypeid']))
                  {
                     ?>
                  <option value="<?=$row['pdetypeid']; ?>" selected><?=$row['pdetype']; ?></option>
                     <?php

                  }else{
                  ?>
                   <option value="<?=$row['pdetypeid']; ?>"><?=$row['pdetype']; ?></option>
                  <?php
                  }

               }
                ?>
               </SELECT>
            </div>
         </div>
<br/>
          <div class="row-fluid">
            <div class="span6">
            
             <strong class="span4">Code : * </strong>
               <input type="text" value="<?=$pdecode; ?>"  class="span8 pdecode" id="pdecode"  name="pdecode" datatype="text" value=""  />
            </div>
            <div class="span6">
             
              <strong class="span4">PDE Roll Category : * </strong>
              <input type="text"  value="<?=$pderollcat; ?>"   class="span8 pderollcat" id="pderollcat"  value="" name="pderollcat"   datatype="text"   />
            </div>
         </div>
<br/>
          <div class="row-fluid">
            <div class="span6">
            
             <strong class="span4">Address : *</strong>
              <input type="text"value="<?=$pdeaddress; ?>" class="span8 pdeaddress" name="pdeaddress" class="pdeaddress" id="pdeaddress"  datatype="text"  />
            </div>
            <div class="span6">
             
              <strong class="span4">Telephone : *</strong>
              <input type="text"  value="<?=$pdetel; ?>"  class="span8 pdetel" id="pdetel" class="pdetel" datatype="tel" />
            </div>
         </div>
<br/>
          <div class="row-fluid">
            <div class="span6">
            
             <strong class="span4">Fax : </strong>
              <input type="text" value="<?=$pdefax; ?>"  class="span8 pdefax" name="pdefax" id="pdefax" datatype="fax"  />
            </div>
            <div class="span6">
             
              <strong class="span4">Email :  </strong>
              <input type="text" class="span8 pdeemail"  value="<?=$pdeemail; ?>"   name="pdeemail" id="pdeemail" datatype="email" />
            </div>
         </div>
<br/>
           <div class="row-fluid">
            <div class="span6">
            
             <strong class="span4">Website  : </strong>
              <input type="text" class="span8 pdewebsite" value="<?=$pdewebsite; ?>"  id="pdewebsite" name="pdewebsite" datatype="web" />
            </div>
           
         </div>



      </div>

   </div>



                                       
                                    </div>
                                    </form>
                                 
                                 
                                 </div>

                               <div class="tab-pane" id="tab2">
                               <form action="#" class="form-horizontal" id="pderegistration2" name="pderegistration2"  data-type="editrecord"  data-cheks="AO<>CC<>HPDU<>AOID<>CCID<>PDUID<>pp" data-check-action="<?=base_url();?>pdes/ajax_validate_usergroups/2/<?=$i; ?>" data-action="<?=base_url();?>pdes/ajax_formsubmit/2/<?=$i; ?>"    data-elements="AO<>CC<>PDU<>AOID<>CCID<>PDUID" >

   
                     
                                    <h4>Accounting Officer, Contracts Committee , PDU Registration   </h4>
 <div class="row-fluid">
 
 <?php
#print_r($users);
function populateusers($users,$usergroup =0,$roles =0,$pdeid=0)
{
  $st ='';
  if($roles == 0){
 
  foreach ($users as $key => $row) {
    # code...
    $st .= '<option value="'.$row['userid'].'" >'.$row['firstname'].' '.$row['lastname'].'</option>';
  }
  return $st;
}
elseif ((!empty($roles)) && (count($roles) > 0) ) {
  # code...
  $stp = 0;
  $xx = 1;
   foreach ($users as $key => $row) {
    # code...
     foreach ($roles as $key => $value) {
      $stp = 0;
    # Interating through the roles for every user...
      if(($value['userid'] == $row['userid']) && ($value['groupid'] == $usergroup) && ($value['pdeid'] == $pdeid)){
        $stp = 1;  break;
      }

  }
   
  if($stp == 1){
    $st .= '<option value="'.$row['userid'].'"  id="'.$xx.'_'.$usergroup.'"  datagroup="'.$usergroup.'"  selected>'.$row['firstname'].' '.$row['lastname'].'</option>';
  $stp = 0;
  }else
  {
   $st .= '<option value="'.$row['userid'].'"   id="'.$xx.'_'.$usergroup.'"   datagroup="'.$usergroup.'"   >'.$row['firstname'].' '.$row['lastname'].'</option>';    
  }
  $xx ++;
}
 
  return $st; 
}
}


$x = 1;
foreach ($usergroups as $key => $row) {
 if($row['groupname'] == 'Administrator')
  {
    continue;
  }
?>
<br/>

 <div class="row-fluid">
            <div class="span12">
            
             <strong class="span4"><?=$row['groupname']; ?> </strong>
             <?php
             switch ($formtype) {
               case 'edit':
                 # code...
               ?>
                <input type="hidden" id="<?=$row['abbreviation'].'ID'; ?>" value="<?=$row['id'];?>">
              <select datatype="select" multiple class="span8 userselect_multiple"  id="<?=$row['id'] ?>"  data-group="<?=$row['id'] ?>" datacode="<?=$row['abbreviation'] ?>">
               <option value="0"> Select User </option> 
               <?=populateusers($users,$row['id'],$assignedroles,$pdeid); ?>
              </select>
               <?php
                 break;
               
               default:
                 # code...
               ?>
                <input type="hidden" id="<?=$row['abbreviation'].'ID'; ?>" value="<?=$row['id'];?>">
              <select datatype="select" class="span8 userselect"  id="<?=$row['id'] ?>"  data-group="<?=$row['id'] ?>" datacode="<?=$row['abbreviation'] ?>">
             <option value="0"> Select User </option>
               <?=populateusers($users); ?>
              </select>
              <?php
                 break;
             }
             ?>
            

            </div>
             
         </div>
<?php
  
  # code...
  $x ++;
}
 ?> 
 
         </div>
                                    
                                    
                                 </div>
                                
                                  
                              </div>
                              <div class="form-actions clearfix">
                               <!--   <a href="javascript:;" class="btn button-previous disabled">
                                 <i class="fa fa-angle-left"></i> Back 
                                 </a> -->
                                 <a href="javascript:;" class="btn btn-primary blue button-next">
                                 Continue <i class="fa fa-angle-right"></i>
                                 </a>
                                 <a href="javascript:;" class="btn btn-success button-submit">
                                 Finish <i class="fa fa-ok"></i>
                                 </a>
                              </div>
                           </div> 
                           </form>                      
                     </div> 

                      
                  </div>
               </div>
            </div>
            <!-- END PAGE CONTENT-->