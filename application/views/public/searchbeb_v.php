<?php
#print_r($page_list);
?>
 

    <div class="clearfix content-wrapper" style="padding-top:28px;">
        <div class="col-md-13" style="margin:0 auto">
            <div class="clearfix">
                <div class="col-md-13 column content-area">
                <div class="page-header col-lg-offset-2" style="margin:0">

<!--start -->
 
 
 


<div class="row clearfix current_tenders ">
    <div class="column ">

        <?php
    #   print_r($page_list['page_list']);
       /// print_r($page_list); exit();
            if(!empty($page_list['page_list']))
            {
                print '<div class="row ">

                            <div class="col-md-1">
                                <b>Date Posted</b>
                            </div>
                              <div class="col-md-2">
                                <b>Procuring/Disposing Entity</b>
                            </div>
                               <div class="col-md-2">
                                <b>Procurement Reference Number </b>
                            </div>
                             <div class="col-md-2">
                                <b>Selected Provider</b>
                            </div>
                              <div class="col-md-1">
                                <b>Subject </b>
                            </div>
                            
                             <div class="col-md-1">
                                <b>Date  BEB Expires</b>
                            </div>
                            <div class="col-md-1">
                                <b>Status</b>
                            </div>


                           
                             <div class="col-md-2">
                                <b>BEB Price </b>
                            </div>
                            
                        </div><hr>';

#print_r($page_list['page_list']);
foreach($page_list['page_list'] as $row)
{
$expirydate = date("d M, Y",strtotime($row['dateadded']) + (60*60*24*10));
   $todaydate = date("d M Y");
   $status = $row['isreviewed'];
  if( ($expirydate < $todaydate ) )
  {
    if($status == 'N')
    continue;
  }
 
print '<div class="row col-md-13">'.
      '<div class="col-md-1">'. custom_date_format('d M, Y', $row['dateadded']) .'</div>'.
            '<div class="col-md-2 procurement_pde"> '.$row['pdename'].' </div>'.
            '<div class="col-md-2">'. $row['procurement_ref_no']. '</div>'.
            '<div class="col-md-2 procurement_pde">';
            # $row['providernames']
    if(((strpos($row['providernames'] ,",")!== false)) || (preg_match('/[0-9]+/', $row['providernames'] )))
      {

      $label = '';
      $providers  = rtrim($row['providernames'],",");
      $rows= mysql_query("SELECT * FROM `providers` where providerid in ($providers) ") or die("".mysql_error());
      $provider = "";
      $x = 0;
      $xl = 0;
         
        while($vaue = mysql_fetch_array($rows))
        {
            $x ++;
             if(mysql_num_rows($rows) > 1)
            {
                 $lead = '';
                  #print_r($provider_array);
              if ($row['providerlead'] ==   $vaue['providerid']) {
                       $lead = '&nbsp; <span class="label" title="Project Lead " style="cursor:pointer;background:#fff;color:orange;padding:0px;margin:0px; margin-left:-15px; font-size:18px; " >&#42;</span>';
              #break;
                    }
                    else{
                      $lead = '';
                     
                  }
             
                $provider  .= "<li>";
                $provider  .=   strpos($vaue['providernames'] ,"0") !== false ? '' :  $lead.$vaue['providernames'];
                $provider  .= "</li>";
             
            }else{
             $provider  .=strpos($vaue['providernames'] ,"0") !== false ? '' : $vaue['providernames'];
            }
        }

         if(mysql_num_rows($rows) > 1){
            $provider .= "</ul>";}
         else{
         $provider = rtrim($provider,' ,');
          }

      if($x > 1)
        $label = '<span class="label label-info">Joint Venture</span>';
        print_r($provider.'&nbsp; '.$label );
    $x  = 0 ;
    $label = '';
    }
                     else{  echo $row['providernames'];}

                            print '</div>'.
                                '<div class="col-md-1 procurement_subject"> '.$row['subject_of_procurement'].' <br/> '.
                               '<a id="modal-703202" href="#modal-container-703202" data-value="'.$row['receiptid'].'"  data-ref="'.base_url().'page/beb_notice"  role="button" class="btn  btn-xs btn-primary beb" data-toggle="modal">
                             View  details</a></div>'.
                                  '<div class="col-md-1"><strong>'.date("d M, Y",strtotime($row['dateadded']) + (60*60*24*10)).'</strong></div>'.
                                  '<div class="col-md-1" style="padding:5px;" >' ;

                                    switch($row['isreviewed'])
                                        {

                                          case 'Y':
                                          print (" <span class='label label-info '> For Admin Review: <br/> ".$row['review_level']." </span> <br/>");
                                        #  print "<span class='label label-info'".$row['review_level']."</span>";
                                          //class="label label-info"
                                          break;


                                          case 'N':
                                           print (" <span class='btn btn-xs btn-success'> Active </span>");
                                    
                                          break;


                                          default:
                                          print("-");
                                          break;
                                        }

                                  print '</div>'.


                          
                              '<div class="col-md-2" style="pading:5px; font-family:Georgia; font-size:13px;">';
                              $readout = mysql_query("SELECT * FROM readoutprices WHERE receiptid=".$row['receiptid']."");
                            
                            if(mysql_num_rows($readout) > 0 )
                            {
                              echo "<ul>";
                              while ( $valsue = mysql_fetch_array($readout)) {
                                if($valsue['readoutprice']<=0)
                                  continue;
                                # code...
                                 echo "<li>".number_format($valsue['readoutprice']).$valsue['currence']."</li>";
                              }
                              echo "</ul>";
                            }


                              echo '</div>'.
                                 
              '</div>'.
              '<hr>';
    }

                    print '<div class="pagination pagination-mini pagination-centered">'.
                        pagination($this->session->userdata('search_total_results'), $page_list['rows_per_page'], $page_list['current_list_page'], base_url().
                        "page/best_evaluated_bidder/p/%d/level/search")
                        .'</div>';

             //   <a id="modal-703202" href="#modal-container-703202" role="button" class="btn" data-toggle="modal">Launch demo modal</a>
            }
            else
            {
                print format_notice("ERROR: There are no verified bids");
            }
        ?>
    </div>
</div>
                </div>

        </div>
        
    </div>
    </div>

    