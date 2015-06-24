<?=$this->load->view('public/includes/header')?>

<?php
#print_r($page_list);
?>
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
        
         $(this).text("  Search Available Notices  ")
     }
    else{
        
        $(this).text(" Minimize This Search Area ")
     }

    });

})
</script>

    <div class="clearfix content-wrapper" style="padding-top:28px;">
        <div class="col-md-12" style="margin:0 auto">
            <div class="clearfix">
                <div class="col-md-13 column content-area">
                <div class="page-header col-lg-offset-2" style="margin:0">



    <div class=" page-header col-lg-offset-2 searchengine">
       <div class="seearchingine-header row clearfix">
   <div class="col-md-12 column">
<div class="row clearfix">
<div class="col-md-8 column " style="padding-left:0px;">

  <h3  style="margin-left:10px;">Disposal Plans </h3>
</div>
<div class="col-md-4 column" style="padding-top:20px; font-size:20px; ">
   <a href="javascript:void(0);" style="text-decoration:none; color:#000;" class="header_toggle"> Search Available Notices </a>
</div>
</div>
    </div>
    </div>

 <div class="row content">
 <div class="col-md-13 column">
    <form id="search-tenders" method="post"  action="<?=base_url()."page/best_evaluated_bidder_search"; ?>"  class="form-search">
        <div class="row">

        <div class="col-md-4">
        

            <div class="col-md-10" style="margin-top:5px;">
                <label class="control-label">Disposal  method</label>
                <div class="controls">
                    <select id="procurement-method" class=" col-md-12" name="procurement_method" tabindex="1"  style=" ">
                        <?=get_select_options($procurement_methods, 'id', 'title', (!empty($formdata['procurement_method'])? $formdata['procurement_method'] : '' ))?>
                    </select>
                </div>
                </div>
                </div>

             <div class="col-md-4">
             <div class="col-md-12">
                <label class="control-label">  Rereference  Number </label>
                <div class="controls">
                    <input type="text" name="procurement_ref_no" value=""  class="input-medium span12">

                </div>
            </div>

            <div class="col-md-12" style="margin-top:5px; padding-right:5px;  ">

                <label class="control-label">Entity</label>
                <div class="controls ">
                    <select id="procurement-ref-no" class="col-md-6" name="entity" tabindex="1" style=" ">
                        <?=get_select_options($pdes, 'pdeid', 'pdename', (!empty($formdata['entity'])? $formdata['entity'] : '' ))?>
                    </select>
                </div>
            </div>
         </div>


       <div class="col-md-4">
            <div class="col-md-12">
                <label class="control-label">Search by Dates:</label>
                <div class="controls">
                    <div class="input-append date date-picker col-md-6" style="padding-left:0px;" data-date="<?=(!empty($formdata['date_posted_from'])? custom_date_format('Y-m-d', $formdata['date_posted_from']) : date('Y-m-d') )?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
                        <input name="date_posted_from" data-date="<?=(!empty($formdata['date_posted_from'])? custom_date_format('Y-m-d', $formdata['date_posted_from']) : date('Y-m-d') )?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days" placeholder="From" class="m-ctrl-medium date-picker" type="text" value="<?=(!empty($formdata['date_posted_from'])? custom_date_format('Y-m-d', $formdata['date_posted_from']) : '' )?>"  style="width:90px;"/>
                        <span class="add-on"><i class="icon-calendar"></i></span>
                    </div>
                    <div class="input-append date date-picker col-md-6" data-date="<?=(!empty($formdata['date_posted_to'])? custom_date_format('Y-m-d', $formdata['bid_evaluation_to']) : date('Y-m-d') )?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
                        <input name="date_posted_to"  placeholder="To" data-date="<?=(!empty($formdata['date_posted_to'])? custom_date_format('Y-m-d', $formdata['date_posted_to']) : date('Y-m-d') )?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days" class="m-ctrl-medium date-picker" type="text" value="<?=(!empty($formdata['date_posted_to'])? custom_date_format('Y-m-d', $formdata['date_posted_to']) : '' )?>"  style="width:90px;"/>
                        <span class="add-on"><i class="icon-calendar"></i></span>
                    </div>
                </div>
            </div><br/>
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
<?=$this->load->view('public/parts/model_v')?>

<div class="row clearfix current_tenders">
    <div class="column ">

        <?php
    #   print_r($page_list['page_list']);
       /// print_r($page_list); exit();
            if(!empty($page_list['page_list']))
            {
                print '<div class="row titles_h">

                            <div class="col-md-3">
                                <b>Financial Year</b>
                            </div>
                              <div class="col-md-3">
                                <b>Procuring/Disposing Entity</b>
                            </div>
                               <div class="col-md-3">
                                <b>Disposal Plan </b>
                            </div>
                             <div class="col-md-3">
                                <b>Date Posted</b>
                            </div>
                             <div class="col-md-1">
                              -
                            </div>
                            

                            
                            
                        </div><hr>';

#print_r($page_list['page_list']);
foreach($page_list['page_list'] as $row)
{
  // custom_date_format('d M, Y', $row['dateadded']) 
print '<div class="row col-md-13">'.
      '<div class="col-md-3">'.$row['financial_year'].'</div>'.
            '<div class="col-md-3 procurement_pde"> '.$row['pdename'].' </div>'.
            '<div class="col-md-3"> <a class="btn btn-xs btn-primary center" target="_new" href="http://itp.nwtdemos.com/uploads/documents/summarizedplans/summarizedplan_ 2014_2015_1427797123Q.xls">Download plan</a> </div>'.
            '<div class="col-md-3 "> <strong>'.date("d M, Y",strtotime($row['dateadded']) + (60*60*24*10)).'</strong>';
            
    
                            print '</div>'.
                                '<div class="col-md-1 "> '.                              
                                 '</div>'.
                                   

                          
                            
              '</div>'.
              '<hr>';
    }

                    print '<div class="pagination pagination-mini pagination-centered">'.
                        pagination($this->session->userdata('search_total_results'), $page_list['rows_per_page'], $page_list['current_list_page'], base_url().
                        "page/best_evaluated_bidder/p/%d")
                        .'</div>';

             //   <a id="modal-703202" href="#modal-container-703202" role="button" class="btn" data-toggle="modal">Launch demo modal</a>
            }
            else
            {
                print format_notice("ERROR: There are no Disposal Plans");
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