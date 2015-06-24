<div class="column">
        <?php
       /// print_r($suspendedlist); exit();
            if(mysqli_num_rows($suspendedlist) > 0 )
            {
                print '<div class="row titles_h">
                            <div class="col-md-3">
                                <b>Provider</b>
                            </div>
                            <div class="col-md-2">
                                <b>Date Suspended </b>
                            </div>
                             <div class="col-md-2">
                                <b>Suspension End </b>
                            </div>
                             <div class="col-md-2">
                                <b>Days Remaining </b>
                            </div>
                            <div class="col-md-3">
                                <b>Reason for Suspension</b>
                            </div> 
                             
                        </div><hr>';
                        
                while($row = mysqli_fetch_array($suspendedlist) )
                {
                    $today = date('Y-m-d');
                    //strtotime($row['datesuspended'])
                       $diff = abs(strtotime($row['endsuspension']) - strtotime($today));
     $years = floor($diff / (365*60*60*24));
$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
$days = floor($diff/ (60*60*24));
                    print '<div class="row">'.
                            '<div class="col-md-3">'. $row['orgname'] .'</div>'.
                            '<div class="col-md-2"><b>'.custom_date_format('d M, Y',$row['datesuspended']) . '</b></div>'.
                            '<div class="col-md-2">';
                              if($row['indefinite']=='Y')
                            echo  '<span class="label label-info "> INDEFINITE</span>';
                             else 
                            echo '<b>'.custom_date_format('d M, Y',$row['endsuspension']).'</b>' ; 
                            echo '</div>'.
                            '<div class="col-md-2">';
                            if($row['indefinite']=='Y')
                            echo  'Not Applicable';
                             else 
                              echo $days; 
                            echo  '</div>'.
                            '<div class="col-md-3">'.$row['reason'] . '</div>'.
                           #  '<div class="col-md-2">'.custom_date_format('d M, Y',$row['dateadded']). '</div>'.
                            '</div>'.
                            '<hr>';
                }
         //         if($row['indefinite']=='Y')
						   // {
						   // 	echo '<span class="label label-info "> indefinite Suspension  </span>';
						   // }else

                /*    print '<div class="pagination pagination-mini pagination-centered">'.
                        pagination($this->session->userdata('search_total_results'), $page_list['rows_per_page'], $page_list['current_list_page'], base_url().    
                        "page/best_evaluated_bidder/p/%d")
                        .'</div>';  */

                      
            }
            else
            {
                print format_notice("ERROR: There are no Suspended Providers ");
            }
        ?>
    </div>