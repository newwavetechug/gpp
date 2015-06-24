<?=$this->load->view('public/includes/header')?>
  
<?php
#print_r($page_list);
?>
<style>
.pagination ul{}
.pagination ul li{ list-style: none;   float: left;}
.pagination ul li a{text-decoration: none; padding:6px;display: block;border:2px solid #eee;}
</style>
    <div class="clearfix content-wrapper" style="padding-top:28px">
        <div class="col-md-12" style="margin:0 auto">
            <div class="clearfix">            
                <div class="col-md-12 column content-area">
                    


<style>
.pagination ul{}
.pagination ul li{ list-style: none;   float: left;}
.pagination ul li a{text-decoration: none; padding:6px;display: block;border:2px solid #eee;}
.bet{background: none repeat scroll 0 0 black;border: medium none;border-radius: 2px;
color: white;display: inline-block;font-size: 14px;padding: 6px 10px;transition: all 0.2s ease-out 0s;
cursor: pointer;line-height: normal;}
</style>
<style type="text/css">
    .searchengine {margin:0; background:#efefef;border:1px solid #e1e1e1; }
    .searchengine > .searchengine-header {}
    .searchengine  > .content {display: none;}
</style>

<script>
$(function(){
    $('.header_toggle').click(function(){
       $(".content").slideToggle();

    if  ($(this).text() == " Minimize This Search Area "){
        
         $(this).text("  Search Suspended Providers  ")
     }
    else{
        
        $(this).text(" Minimize This Search Area ")
     }

    });

})
</script>
<style>
.fixed2 {
  position: fixed;
  width: 75%;
  z-index: 999;
  top: 40px;
  background: #fff;
  border-bottom: 1px solid #eee;
  padding-bottom: 10px;
  padding-top: 10px;
}
</style>
 <script type="text/javascript">
function searchproviders(st)
{
 
formdata = {};
formdata['organisation'] = st;
url = '<?=base_url()."page/suspendedproviders_search"; ?>';
  $("#search").html("Proccessing...");

 $.ajax({
            type: "POST",
            url:  url,
            data:formdata,
            success: function(data, textStatus, jqXHR){
                $(".results").html(data);
              console.log(data);
              $("#search").html("Suspended Providers");

            },
            error:function(data , textStatus, jqXHR)
            {
                alert(data);
            }
        });

}
 

</script>
<!-- start -->
    <div class="clearfix content-wrapper" style="padding-top:0px;">
        <div class="col-md-13" style="margin:0 auto">
            <div class="clearfix">
                <div class="col-md-13 column content-area">
                <div class="page-header col-lg-offset-2" style="margin:0">



    <div class=" page-header col-lg-offset-2 searchengine">
       <div class="seearchingine-header row clearfix">
   <div class="col-md-12 column">
<div class="row clearfix">
<div class="col-md-8 column " style="padding-left:0px;">

   <h3 id="search">Suspended Providers </h3>
</div>
<div class="col-md-4 column" style="padding-top:20px; font-size:20px; ">
<label style="font-size:10px;font-weight:bold;">What Are You Searching For? </label>
   <input type="text"  id="organisation" class="col-md-12" name="organisation" onkeyup="javascript:searchproviders(this.value);">
              </div>
</div>
    </div>
    </div>

 <div class="row content">
 <div class="col-md-13 column">
    <form id="serveipst" method="post"  dataction="<?=base_url()."page/suspendedproviders_search"; ?>" action="<?=base_url()."page/suspendedproviders_search"; ?>"  class="form-search">
        <div class="row">

        <div class="col-md-12">
        

            
                <label class="control-label">Search By Organisation Name  </label>
                <div class="controls">
                     </div>
                 
                </div>

 

        </div>
        <div class="row">
                     
 <div class="col-md-12 ">
             <label class="control-label"></label> <div class="controls">
            <!-- <button type="button" class="btn btn-default" type="submit">Search</button> -->

         <input  class="btn btn-default bet" value="Search" name="search_btn"  id="sumitbutton" type="submit">
              </div>
           
         </div>
        </div>
         </div>

    </form>

    </div>
    </div>
    </div>

</div>


<!-- end -->


<div class="row clearfix results">
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
               //   echo '<span class="label label-info "> indefinite Suspension  </span>';
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
</div> 
                </div>
                 
        </div>
        <?=$this->load->view('public/includes/footer')?>
    </div>  
    </div>
    </body>
</html>