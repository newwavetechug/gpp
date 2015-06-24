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
<style>
.popup{width:100px; display:none;}
.popup ul { position:relative; margin:0 auto;}
.popup ul li{list-style:none; margin-left:0px;}
.popup ul li{background:#eee; margin:2px;}
.popup ul li a{font-size:10px; text-decoration:none;}
.popup .label-success a{color:#fff;}
.minst{font-size:9px;}
</style>
<div class="widget">
    <div class="widget-title">
        <h4><i class="icon-reorder"></i>&nbsp;Manage  Bidders</h4>
       <!--  <h4>  <a href="#" > View Archived BeB's </a> </h4> -->
            <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <a href="javascript:;" class="icon-remove"></a>
            </span>
    </div>
    <div class="widget-body" id="results">
    	<?php

#print_r($manage_bes);
			if(!empty($manage_bes)):

				print '<table class="table table-striped table-hover">'.
					  '<thead>'.
					  '<tr>'.
					  '<th width="5%"></th>'.
					  '<th>Disposal Ref Number</th>'.
					  '<th class="hidden-480">Name of Buyer</th>'.
					  '<th class="hidden-480">Subject of Disposal</th>'.
					  '<th class="hidden-480" colspan="3">Readout Prices</th>'.
            '<th class="hidden-480">Contract Value</th>'.
					  '<th>Status</th>'.
					  '<th>Date of Award </th>'.
					  '</tr>'.
            '<tr>'.
            '<th width="5%"></th>'.
            '<th> </th>'.
            '<th class="hidden-480"> </th>'.
            '<th class="hidden-480"> </th>'.
            '<th class="hidden-480">Amount</th>'.
            '<th class="hidden-480">Exchange Rate</th>'.
            '<th class="hidden-480">Currency</th>'.            
            '<th class="hidden-480"> </th>'.
            '<th></th>'.
            '<th></th>'.
            '</tr>'.
					  '</thead>'.
					  '<tbody>';
         #   print_r($manage_bes['page_list']);

			foreach($manage_bes['page_list'] as $row)
			{
        
        #print_r($row);
        $bidd = $row['bidid'];
      #  print_r($row['bid_id']); exit();
			print '<tr><td width="5%">';

         /*   switch($row['ispublished'])
            {

              case 'Y':

              break;

              case 'N':
              print '  <div class="label label-success " style="width:90px; clear:both;  "><i class="icon-hdd"></i><a href="javascript:void(0);"  id="'.$row['receiptid'].'"   dataurl="'.base_url().'receipts/ajax_beb_action'.'"  class="dropdown-toggle element publish_beb" data-placement="bottom"  data-toggle="tooltip"  data-original-title="Publish" style="color:#fff;"   dataid="'.$row['receiptid'].'"    > Publish </a></div>';
              break;

              default:
              break;

             }   *//*
        ?>
        <div class="label label-important" style="width:90px; clear:both; "><i class="icon-bolt"></i>
        <a href="javascript:void(0);" class="dropdown-toggle element popcorn" data-placement="bottom" datapop="popup_<?=$row['receiptid']; ?>" data-toggle="tooltip"  data-original-title="Action"> Action </a>
      </div>
       <div class="popup" id="popup_<?=$row['receiptid']; ?>"  style="clear:both;" >
              <ul>
              <li>
              <input type="checkbox" name="adminreview" value="status"  id="<?=$row['receiptid']; ?>"  dataurl="<?php echo base_url().'receipts/ajax_beb_action'; ?>"  dataid="<?=$row['receiptid']; ?>"    <?php if($row['isreviewed'] == 'Y'){ ?>  checked="checked" <?php } ?> class="admin_review">
              <a href="javascript:void(0);">Under Administrative Review</a>
              </li>
              <li><a href="<?=base_url().'bids/publish_bidder/active_procurements/editbeb/'.base64_encode($row['receiptid']);?>" >Edit BeB </a></li>
              <li><a href="javascript:void(0);" id="<?=$row['receiptid']; ?>"  dataurl="<?php echo base_url().'receipts/ajax_beb_action'; ?>" databidid="<?=$row['bidid']; ?>" dataid="<?=$row['receiptid']; ?>"      class="cancel_beb">Cancel BEB </a> </li>
              </ul>
        </div> 
<?php */  print '</td>'.
					   '<td>'.$row['disposal_ref_no'].'</td>';
             $provider = rtrim($row['providernames'],',');

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
					  '<td class="hidden-480">'.$row['subject_of_disposal'].'</td>';



            $readouts = $this->db->query("select * from disposalreadoutprices where receiptid = '".$row['receiptid']."'")->result_array();
            #print_r($readouts);
           
            print  '<td colspan="3">';
             foreach ($readouts as $key => $values) {
              # code...
              print '<table width="100%" class="stripe">'.
              '<td width="30%"> '.number_format($values['readoutprice']).' </td>'.
            '<td width="30%" > '.number_format($values['exchangerate']).' </td>'.
             '<td width="30%"> '.$values['currence'].' </td>'.

               '</table>';

            }
            print '</td><td>'.number_format($row['contractprice']).$row['contractcurrency'].'<td>';
           

            switch($row['isreviewed'])
            {

              case 'Y':
              print (" <span class='label label-info minst'> Under Administrative Review </span>");
              break;


              case 'N':
              print_r("-");
              break;


              default:
              print_r("-");
              break;
            }

            print '</td>'.
					  '<td>'.date('Y-M-d',strtotime($row['dobccaward'])).'</th>'.
					  '</tr>';
				}


				print '</tbody></table>';

				print '<div class="pagination pagination-mini pagination-centered">'.
						pagination($this->session->userdata('search_total_results'), $manage_bes['rows_per_page'], $manage_bes['current_list_page'], base_url().
						"receipts/manage_bebs/p/%d")
					.'</div>';

			else:
        		print format_notice('WARNING: No bid invitations have been added to the system');
        	endif;
        ?>
    </div>
</div>