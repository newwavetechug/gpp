<script type="text/javascript">
     $(document).on('click','.printer',function(){
 
 
    $(".table").printArea();
    
  })


$(document).ready(function() {
  $('.table').dataTable({
     "paging":   true,
        "ordering": true,
        "info":     false });
  
  /*$('.table tbody').on('click', 'tr', function () {
    var name = $('td', this).eq(0).text();
    alert( 'You clicked on '+name+'\'s row' );
  } );  */
} );



</script><div class="widget">
    <div class="widget-title">
        <h4><i class="fa fa-reorder"></i>&nbsp;<?=$page_title; ?></h4>
            <span class="tools">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
                <a href="javascript:;" class="fa fa-remove"></a>
            </span>
    </div>
    <div class="widget-body" id="results">
    	<?php 
    	#$ros = mysqli_fetch_array($suspended_proviers);
    	#print_r($ros); 
    	
    		$xv = check_user_access($this, 'edit_provider','returnbool');
    		
    	 
    	
			if(!empty($suspended_proviers)): 
				
				print '<table class="table table-striped table-hover">'.
					  '<thead>'.
					  '<tr>'.
					  '<th width="5%"> </th>'.
					  '<th>Organisation</th>'.
					  '<th class="hidden-480">Date of Suspension</th>'.
					  '<th class="hidden-480">Date of End of Suspension</th>'.
					    '<th class="hidden-480">Days Remaining</th>'.
					  '<th class="hidden-480"> Date Added</th>'.
					  '<th class="hidden-480">Author</th>'.
					  '<th> </th>'.
					  '</tr>'.
					  '</thead>'.
					  '</tbody>';
			 while ($row = mysqli_fetch_array($suspended_proviers)) {
    		# code...
    	//   	<a href="<?=base_url().'receipts/load_edit_receipt_form/'.encryptValue($value['receiptid']);  "> <i class="fa fa-edit"></i></a>
    	$date = date('Y-m-d');
     $diff = abs(strtotime($row['endsuspension']) - strtotime($date));
     $years = floor($diff / (365*60*60*24));
$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
$days = floor($diff/ (60*60*24));
					 print '<tr>'.
						  '<td>';  
						   if($xv == true)
    		{
				print '<a href="'.base_url().'providers/load_edit_provider_form/'.encryptValue($row['recordid']).'"> <i class="fa fa-edit"></i></a>'.
					  '<a href="#" id="archive_'.$row['recordid'].'" class="savedelprovider"> <i class="fa fa-trash"></i></a>';
            }
					   print'</td>';
	     
					   
						 print '<td>'.$row['orgname'].'</td>'.						 
						  '<td>'. custom_date_format('d M, Y',$row['datesuspended']) .'</td>'.
						  '<td>'. custom_date_format('d M, Y',$row['endsuspension']) .'</td>'.
						   '<td> ';
						   if($row['indefinite']=='Y')
						   {
						   	echo '<span class="label label-info "> Indefinite Suspension  </span>';
						   }else
						   echo ''.$days.'  </td>'.
						  '<td>'.custom_date_format('d M, Y',$row['dateadded'])  .'</td>'.
						  '<td>  -  </td>'.
						   
						  '<td>  </td>'.
						  '</tr>';
				}
				
				
				print '</tbody></table>';
				
		 
		
			else:
        		print format_notice('WARNING: No Providers have been Suspended Yet ');
        	endif; 
        ?>
    </div>
</div>