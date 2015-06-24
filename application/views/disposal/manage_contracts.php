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
        <h4><i class="icon-reorder"></i>&nbsp;Manage  Disposal Contracts</h4>
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
            '<th>Disposal Serial Number </th>'.
            '<th class="hidden-480">Name of Buyer</th>'.
            '<th class="hidden-480">Contract Amount</th>'.
            '<th class="hidden-480" colspan="3">Date Signed </th>'.
            '<th class="hidden-480">Date Added</th>'.
         
            '<th></th>'.
            '</tr>'.
            '</thead>'.
            '<tbody>';
         #   print_r($manage_bes['page_list']);

      foreach($manage_bes['page_list'] as $row)
      {
        
        #print_r($row);
       
      #  print_r($row['bid_id']); exit();
      print '<tr><td width="5%">';
            
       print '</td>'.
             '<td>'.$row['disposal_serial_no'].'</td>';
               print '<td class="hidden-480">';
          
            print $row['providernames'].'</td>'.
            '<td class="hidden-480">'.number_format($row['contractamount']).$row['currency'].'</td>';


   
            print  '<td colspan="3">';
            print   date('Y-M-d',strtotime($row['datesigned']));
            print '</td><td>'.date('Y-M-d',strtotime($row['dateadded'])).'<td><td></td>';
         
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