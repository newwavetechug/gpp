<style>
.popup{width:100px; display:none;}
.popup ul { position:relative; margin:0 auto;}
.popup ul li{list-style:none; margin-left:0px;}
.popup ul li{background:#eee; margin:2px;}
.popup ul li a{font-size:10px; text-decoration:none;}
.popup .label-success a{color:#fff;}
.minst{font-size:9px;}
</style>
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

<script type="text/javascript">
  function reviewlevel(st,options)
  {
    
    formdata = {};
    formdata['bebid'] =st;
    formdata['options'] = options;
    var url = baseurl()+"receipts/updatbeboptions";


        alertmsg("proccessing ...");
        $.ajax({
        type: "POST",
        url:  url,
        data:formdata,
        success: function(data, textStatus, jqXHR){
        if(data == 1)
        {
          location.href=baseurl()+"receipts/manage_bebs/m/usave";
        }
        else{
          console.log(data);
        }

        },
        error:function(data , textStatus, jqXHR)
        {
           console.log(" ERROR CODE "+data)
        }
    });

  }
</script>
<div class="widget">
    <div class="widget-title">
        <h4><i class="fa fa-reorder"></i>&nbsp;Manage Best Evaluated Bidders</h4>
            <span class="tools">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
                <a href="javascript:;" class="fa fa-remove"></a>
            </span>
    </div>
    
    <!-- Archived and Active -->

    <div class="tabbable" style="padding-left:30px;" id="tabs-45158">
        <ul class="nav nav-tabs">
          <li class=" <?php if(!empty($level) && ($level == 'active'))  {  echo "active"; } ?> " onClick="javascript:location.href='<?=base_url().'receipts/manage_bebs/active/'; ?>'">

            <a href="<?=base_url().'receipts/manage_bebs/active/'; ?>" data-toggle="tab"> <i class="fa fa-folder-open"> </i> Active </a>
          </li>
          <li onClick="javascript:location.href='<?=base_url().'receipts/manage_bebs/archive/'; ?>'"  class="<?php if(!empty($level) && ($level == 'archive'))  {  echo "active"; } ?>">
            <a href="<?=base_url().'receipts/manage_bebs/archive/'; ?>" data-toggle="tab"> <i class=" fa fa-folder"> </i>  Archived</a>
          </li>
        </ul>
       
      </div>
      <!-- End --> 
    
    <div class="widget-body" id="results">
      <?php

      if(!empty($manage_bes)):

        print '<table class="table table-striped table-hover">'.
            '<thead>'.
            '<tr>'.
            '<th width="5%"></th>'.
            '<th>Procurement Ref Number</th>'.
            '<th class="hidden-480">Selected Provider</th>'.
            '<th class="hidden-480">Subject of Procurement</th>'.
            '<th class="hidden-480">Value</th>'.
            '<th>Status</th>'.
            '<th>Date Added</th>'.
            '</tr>'.
            '</thead>'.
            '<tbody>';

      foreach($manage_bes['page_list'] as $row)
      {
        $bidd = $row['bid_id'];
      #  print_r($row['bid_id']); exit();
      print '<tr><td width="5%">';

          
        ?>
      
        <div class="btn-group" style="font-size:10px">
        <?php
        if(!empty($level) && ($level == 'active') ){

           switch($row['ispublished'])
            {

              case 'Y':
              
         #   print '    <a href="javascript:void(0);"  id="'.$row['id'].'"   dataurl="'.base_url().'receipts/ajax_beb_action'.'"  class="dropdown-toggle element unpublish_beb" data-placement="bottom"  data-toggle="tooltip"  data-original-title="Publish"    dataid="'.$row['id'].'"  title="Unpublish BEB" widget-title="Unpublish BEB"  style="color:yellow"  > <i class="fa fa-eye"> </i> </a> ';
          
              break;

              case 'N':
               print '    <a href="javascript:void(0);"  id="'.$row['id'].'"   dataurl="'.base_url().'receipts/ajax_beb_action'.'"  class="dropdown-toggle element publish_beb" data-placement="bottom"  data-toggle="tooltip"  data-original-title="Publish"    dataid="'.$row['id'].'"  title="Publish BEB" widget-title="Publish BEB"  style="color:green"  > <i class="fa fa-eye"> </i> </a> ';
         break;

              default:
               
              break;

             }


if($this->session->userdata('isadmin') == 'N')
{
        ?>
     <a href="<?=base_url().'bids/publish_bidder/active_procurements/editbeb/'.base64_encode($row['id']);?>" ><i class='fa fa-edit'> </i></a>
     <a href="javascript:void(0);" id="<?=$row['id']; ?>"  dataurl="<?php echo base_url().'receipts/ajax_beb_action'; ?>" databidid="<?=$row['bid_id']; ?>" dataid="<?=$row['id']; ?>"      class="cancel_beb"><i class="fa fa-trash"></i> </a> 
                                  
<?php 
}} ?> 

        </div>
    
    
       
    <!-- <div class="popup" id="popup_<?=$row['id']; ?>"  style="clear:both;" >
              <ul>
              <li>
              <input type="checkbox" name="adminreview" value="status"  id="<?=$row['id']; ?>"  dataurl="<?php echo base_url().'receipts/ajax_beb_action'; ?>"  dataid="<?=$row['id']; ?>"    <?php if($row['isreviewed'] == 'Y'){ ?>  checked="checked" <?php } ?> class="admin_review">
              <a href="javascript:void(0);">Under Administrative Review</a>
              </li>
              <li><a href="<?=base_url().'bids/publish_bidder/active_procurements/editbeb/'.base64_encode($row['id']);?>" >Edit BeB </a></li>
              <li><a href="javascript:void(0);" id="<?=$row['id']; ?>"  dataurl="<?php echo base_url().'receipts/ajax_beb_action'; ?>" databidid="<?=$row['bid_id']; ?>" dataid="<?=$row['id']; ?>"      class="cancel_beb">Cancel BEB </a> </li>
              </ul>
        </div> -->
<?php  print '</td>'.
             '<td>'.$row['procurement_ref_no'].'</td>';
             $provider = rtrim($row['providers'],',');

             $result =   $this-> db->query("SELECT providernames FROM providers where providerid in(".$provider.")")->result_array();
             print '<td class="hidden-480">';
             $providerlist = '';
             $x = 0;

             foreach($result as $key => $record){
              $providerlist .= $x > 0 ? $record['providernames'].',' : $record['providernames'];
              $x ++ ;
             }

            //print_r($providerlist);
            $providerlists = ($x > 1 )? rtrim($providerlist,',').' <span class="label label-info">Joint Venture</span> ' : $providerlist;

            print $providerlists.'</td>'.
            '<td class="hidden-480">'.$row['subject_of_procurement'].'</td>'.
            '<td class="hidden-480">'.number_format($row['contractprice']).$row['currency'].'</td>'.
            '<td>';
            ?>
          <label style="font-size:10px; text-decoration:none;">  <input type="checkbox" name="adminreview" value="status"  id="<?=$row['id']; ?>"  dataurl="<?php echo base_url().'receipts/ajax_beb_action'; ?>"  dataid="<?=$row['id']; ?>"    <?php if($row['isreviewed'] == 'Y'){ ?>  checked="checked" <?php } ?> class="admin_review">
                      <a href="javascript:void(0); ">Under Admin Review</a></label>
                      <?php

            switch($row['isreviewed'])
            {

              case 'Y':
              print (" <span class='label label-info minst'> Under Administrative Review </span>");
            ?>

  <?php
        if(!empty($level) && ($level == 'active') ){

        ?>
         
            <select class="chosen-select" style="width:135px;" onChange="javascript:reviewlevel(<?=$row['id'];?>,this.value);" >
            <option selected disabled="true"> Select </option>
            <option <?php if($row['review_level'] == 'Account Officer') { echo "selected"; } ?>   >Account Officer </option>
            <?php
              if($this->session->userdata('isadmin') == 'Y'){
            ?>
            <option <?php if($row['review_level'] == 'PPDA') { echo "selected"; } ?> >PPDA</option>                      
            <option <?php if($row['review_level'] == 'Tribunal') { echo "selected"; } ?>  >Tribunal </option>
           <?php } ?>
            </select>

            <?php
            }
              break;


              case 'N':
              print_r("-");
              break;


              default:
              print_r("-");
              break;
            }

            print '</th>'.
            '<td>'.date('Y-M-d',strtotime($row['dateadded'])).'</th>'.
            '</tr>';
        }


        print '</tbody></table>';

        print '<div class="pagination pagination-mini pagination-centered">'.
            pagination($this->session->userdata('search_total_results'), $manage_bes['rows_per_page'], $manage_bes['current_list_page'], base_url().
            "receipts/manage_bebs/".$level."/p/%d")
          .'</div>';

      else:
            print format_notice('WARNING: No bid invitations have been added to the system');
          endif;
        ?>
    </div>
</div>