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

    if  ($(this).text() == " Minimize this search area "){
        
         $(this).text("  What are you searching for?  ")
     }
    else{
        
        $(this).text(" Minimize this search area ")
     }

    });


       searchdata = {};
  $(".searchengine").on('change','.disposing_entity,.disposing_method,.subjectof_disposal,.subjectof_disposal,.procurement_method,.disposing_entityadv,.sourceof_funding,.financial_year',function(){
   var atribute = $(this).attr('dataattr');  
   console.log(atribute);
   
   //console.log(atribute);
   var values = $(this).val();
   //alert(values);
   switch(atribute)
   {

     case 'disposing_entity':     
     if(values > 0)
     searchdata['disposing_entity'] = values;
     else
        delete searchdata['disposing_entity'];
     break;


     case 'disposing_method':
      if(values > 0)
      searchdata['disposing_method'] = values;
      else
        delete searchdata['disposing_method'];
     break;

      case 'subjectof_disposal':      
       
      searchdata['subjectof_disposal'] = values;
     
     break;


      case 'disposing_entity':
      if(values > 0)
      searchdata['disposing_entity'] = values;
      else
        delete searchdata['disposing_entity'];
     break;

      case 'procurement_method':
      if(values > 0)
      searchdata['procurement_method'] = values;
      else
        delete searchdata['procurement_method'];
      break;


  case 'sourceof_funding':
      if(values > 0)
      searchdata['sourceof_funding'] = values;
      else
        delete searchdata['sourceof_funding'];
      break;

  case 'financial_year':
      if(values != '0')
      searchdata['financial_year'] = values;
      else
        delete searchdata['financial_year'];
      break;



     default:
     break;
   }

   //send information to server
  

   console.log("Proccessing ... ");
   $(".searchstatus").html("Proccessing ...")

      url = $(".searchengine").attr('dataurl');
// ajax posting
   $.ajax({
         type: "POST",
         url:  url,
         data:searchdata,   
         success: function(data, textStatus, jqXHR){
         console.log(data);
         $(".searchstatus").html("");
         $(".search_results").html(data);
        },
        error:function(data , textStatus, jqXHR)
        {
            console.log(data);
        }
    });




    
  });



})
</script>

    <div class="clearfix content-wrapper" style="padding-top:28px;">
        <div class="col-md-12" style="margin:0 auto">
            <div class="clearfix">
                <div class="col-md-13 column content-area">


                    <?php
                 #   if (!isset($details)) {
                        ?>
                <!-- start -->
<div class="col-md-13 column content-area">
    <div class="page-header col-lg-offset-2" style="margin:0px 0px">
    <div class=" page-header col-lg-offset-2 searchengine" style="margin:0px 0px" dataurl="<?=base_url()."page/search_diposal_plans"; ?>">
    <div class="seearchingine-header row clearfix" style="margin:0px 0px" >
    <div class="col-md-12 column">
    <div class="row clearfix">
    <div class="col-md-8 column " style="padding-left:0px;">

<h3>Disposal Plans</h3>
</div>

<div class="col-md-4 column" style="padding-top:20px; font-size:20px; ">
<a href="javascript:void(0);" style="text-decoration:none; color:#000; font-size:15px;" class="header_toggle"> What are you searching for?  </a>
</div>

</div>
    </div>
    </div>

 <div class="row content">
 <div class="col-md-13 column form-group searchcontent">

 <div class="row clearfix">
        <div class="col-md-4 column">
        <div class="row " style="padding-top:0px; padding-bottom:0px; padding-left:5px;">
         <b> Simple Search </b>
         </div>
        <div class="row ">
        <?php #print_r(get_pde_list()); ?> 
 
         <select  dataattr="disposing_entity" class="col-md-12 chosen chozen  selectpicker form-control disposing_entity" id="disposing_entitys"> 
             <option value="0" >Disposing Entity </option>
              <?php
                  $records = get_pde_list();
                  foreach ($records as $key => $row) {
                                        # code...
                    ?>
                    <option value="<?=$row['pdeid']; ?>"> <?=$row['pdename']; ?> </option>
                    <?php
                    }                  
                  ?>
         </select>
        </div>
         <div class="row ">
         <?php           
           $disposaltype = fetch_disposal_methods();
         ?>
         <select  dataattr="disposing_method" class="col-md-12 chosen chozen  form-control disposing_method" id="disposing_methods">
           <option value="0" >Disposing Method </option>
         <?php
            foreach ($disposaltype as $key => $row) {
                # code...
                ?>
                <option value="<?=$row['id']; ?>"> <?=$row['method']; ?> </option>
                <?php
            }
         ?>
           
         </select>
        </div>
        </div>
        <div class="col-md-8 column" style="border-left:1px solid #ddd;">
           <div class="row " style="padding-top:0px; padding-bottom:0px; padding-left:10px;">
         <b> Advanced  Search  </b>
         </div>

        <div class="row ">
         <div class="col-md-12 column">
          
              <input type="text" class="col-md-12 form-control subjectof_disposal"  dataattr="subjectof_disposal" id="subjectof_disposal" placeholder="Subject of Disposal">
            </div>
        </div>

          <div class="row ">

         <div class="col-md-5 column">
              <select   dataattr="disposing_entity" class="col-md-12 form-control disposing_entity" placeholder="Subject of procurement " id="disposing_entityadv">
            <option value="0" >Disposing  Entity </option>
                <?php
                  $records = get_pde_list();
                  foreach ($records as $key => $row) {                                      
                    ?>
                    <option value="<?=$row['pdeid']; ?>"> <?=$row['pdename']; ?> </option>
                    <?php
                    }                  
                  ?>
                 
             </select>
        </div>

        <div class="col-md-5 column">
        <?php
       # print_r(fetch_financialyears_list()); 
        $financial_years = fetch_disposal_years();?>
              <select   dataattr="financial_year"  class="col-md-12 form-control financial_year" id="financial_year" placeholder="Subject of procurement">
                 <option value="0" >Financial Year </option>
          <?php
                 
                  foreach ($financial_years as $key => $row) {
                                        # code...
                    ?>
                    <option value="<?=$row['financial_year']; ?>"> <?=$row['financial_year']; ?> </option>
                    <?php
                    }                  
                  ?>
             </select>
        </div>
        </div>

         <div class="row ">
         <div class="col-md-5 column">
              <select   dataattr="disposing_method" class="col-md-12 form-control disposing_method" id="disposing_methodadv"  >
            <option value="0" >Disposing Method </option>
               <?php
            foreach ($disposaltype as $key => $row) {
                # code...
                ?>
                <option value="<?=$row['id']; ?>"> <?=$row['method']; ?> </option>
                <?php
            }
         ?>

             </select>
        </div>

         
        </div>


        
              <div class="row ">

            <div class="col-md-5 column"> 
                <button onClick="javascript:location.href='<?=base_url().'page/disposal_plans/details'; ?>';" type="button" class="btn btn-default  "><i class="fa fa-list" > </i>LIST ALL</button>
               </div>
               
                

            </div>



            </div>

        </div>
    </div>
  
    </div>
    </div>
    </div>

</div>

                <!-- end -->

                    <?php # } ?>
<?=$this->load->view('public/parts/model_v')?>

 

  <div class="searchstatus"> </div>

<div class="row clearfix current_tenders  search_results">
<?php 
if(!empty($level) && ($level == 'search'))
{
 $this->load->view('public/search_disposal');
}
else
{
?>
    <div class="column col-md-13">

        <?php
        if (isset($details)) {
            ?>


            <a class="pull-right  btn btn-sm btn-danger" href="<?=base_url().'export/disposal_plan_details/'.$this->uri->segment(4)?>" >Export This Page</a>


            <?php
            echo '<div class="row invoice-list"> <div class="page-header col-lg-offset-2" style="margin:0">
                       <h3>' . $page_list['page_list'][0]['financial_year'] . ' Disposal Plan for ' . $page_list['page_list'][0]['pdename'];

            echo '</h3></div>';
            echo '<p>
                <b>Financial Year: </b>' . $page_list['page_list'][0]['financial_year'] . '<br>
                <b>Entity: </b> ' . $page_list['page_list'][0]['pdename'] . '<br>
                 
            </p>';

            print '
                            <div class="col-md-3">
                                <b>Subject of Disposal </b>
                            </div>

                            <div class="col-md-3">
                                <b>Quantity</b>
                            </div>
                            
                            <div class="col-md-3">
                                <b>The Entity </b>
                            </div>

                            <div class="col-md-3">
                                <b>Disposal Method </b>
                            </div>
                            </div>


                             <hr>';

            #print_r($page_list['page_list']['disp_plan']);
            foreach ($page_list['page_list'] as $row) {
                print '<div class="row">' .
                    '<div class="col-md-3">' . $row['subject_of_disposal'] . '</div>' .
                    '<div class="col-md-3 procurement_pde"> '.number_format($row['quantity']).' </div>' .
                    '<div class="col-md-3 ">' . $row['pdename'] . '</div>' .
                    '<div class="col-md-3">' . $row['method'] . '</div>' .
                    '</div>' .
                    '<hr>';
            }


        } else {
    #   print_r($page_list['page_list']);
       /// print_r($page_list); exit();
            if(!empty($page_list['page_list']))
            {
                print '<div class="row titles_h">

                           
                              <div class="col-md-8">
                                <b>Procuring/Disposing Entity</b>
                            </div>
                              
                            
                             <div class="col-md-4">
                              
                            </div>
                            

                            
                            
                        </div><hr>';

#print_r($page_list['page_list']);
foreach($page_list['page_list'] as $row)
{
  // custom_date_format('d M, Y', $row['dateadded']) 
    print '<div class="row  column col-md-13">' .

        '<div class="col-md-8 procurement_pde"> ' . $row['pdename'] . ' </div>' .

        '<div class="col-md-4 "> <a class="btn btn-xs btn-primary center"  href="' . base_url() . 'page/disposal_plans/details/' . base64_encode($row['disposalpln_id']) . '">Details of the ' . $row['financial_year'] . ' Annual Disposal Plan </a>' .
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
        }
        ?>
    </div>

     <?php

      }

    ?>
</div>
                </div>

        </div>
        <?=$this->load->view('public/includes/footer')?>
    </div>
    </div>

    </body>
</html>