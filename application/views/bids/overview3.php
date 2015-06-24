<?php

	function fetchnum_bidders($ref){
		$st = "SELECT COUNT(*) as sm ,r.bid_id as bid FROM receipts r INNER JOIN bidinvitations as b on r.bid_id = b.id  WHERE b.procurement_ref_no = '".$ref."'" ;

		$q1 = mysql_query($st);
		# print_r($st);
		 $q2 =  mysql_fetch_array($q1)or die("".mysql_error());

		 return $q2;
	}
	function fetchnum_nation($local ='local'){
		$st = "SELECT COUNT(*) as sm ,r.bid_id as bid FROM receipts r INNER JOIN bidinvitations as b on r.bid_id = b.id  WHERE b.nationality like '".$ref."'" ;

		$q1 = mysql_query($st);
		# print_r($st);
		 $q2 =  mysql_fetch_array($q1)or die("".mysql_error());

		 return $q2;
	}
	function fetchreceiptstatus($ref){
		$st = "SELECT count(*) as sm  FROM receipts r INNER JOIN bidinvitations as b on r.bid_id = b.id  WHERE b.procurement_ref_no = '".$ref."' and r.beb ='Y' " ;
		$q1 = mysql_query($st);
		# print_r($st);
		$q2 =  mysql_fetch_array($q1)or die("".mysql_error());
		return $q2;
	}

	?>

<style>
.swMain > ul li > a.selected .stepNumber { border-color: #5293C4;}
.naw{  margin-top:-25px;  width:80%; min-width:400px; display: none;}
.naw a{ float:left; text-decoration:none;     width:60px; text-align:center; cursor:pointer;
  background-color: white;  border: 9px solid #CED1D6;
  color: #546474;
  display: inline-block;  font-size: 15px;
  height: 40px;  line-height: 30px;  position: relative;  text-align: center;
  width: 45px;  z-index: 2;   font-size:15px; vertical-align:middle;
  border-color: #5293C4; display:table-cell;	vertical-align:middle;}
.naw a:first-child{ font-size:30px; padding-top:5px; margin-left:10px;}
.naw a:nth-child(2){margin-left:420px; float:left; font-size:30px; padding-top:5px;}
.naw a:nth-child(3){margin-left:420px;	font-size:30px;	padding-top:5px;}
.naw span{ float:left; text-decoration:none;}
.naw2 {clear:both; display: none;}
.naw2 span:first-child{font-size:12px; padding-top:5px; margin-left:0px;}
.naw2 span:nth-child(2){  font-size:12px; padding-top:5px; margin-left:360px;}
.naw2 span:nth-child(3){  font-size:12px; padding-top:5px; margin-left:390px;}
.progress{ clear:both;}
</style>

<div class="naw "> <a id="10"> 1 </a>  <a id="50">  2 </a>  <a id="100">  3 </a> </div>

<div class="progress">
<div class="bar" datavalue="10" style="width: 10%;"></div>
</div>
<div class="naw2 "><span> Select procurement  </span><span> Add received bids </span><span> Select BEB </span> </div>

<div class="widget">
<div class="widget-title">
<h4><i class="fa fa-reorder"></i>&nbsp;<?=$page_title; ?></h4>
 <span class="tools">
	   <a href="javascript:;" class="icon-chevron-down"></a>
	   <a href="javascript:;" class="icon-remove"></a>
 </span>
 </div>

 <div class="level_fetcher">
	  <div class="widget-body procurements">
	  <div class="row-fluid">
		<div class="row-fluid">
    <form action="#" class="form-horizontal">
		<div class="span12">
     <div id="bid_evaluation" class="accordion-body  in ">
					<div class="accordion-inner">
					<div class="row-fluid">
	        <div class="control-group">
	        <label class="control-label"> <strong> Procurement Reference No. *:</strong></label>
	        <div class="controls">
  				<?php # print_r($active_procurements);    ?>
          <select  class="  chosen evaluationmethod span6 active_procurements"   data-placeholder=" Active Procurements " tabindex="1" name="evaluationmethod" id="evaluationmethod">
          <option value="0"> Select </option>
          <?php  foreach ($active_procurements['page_list'] as $key => $value) {  ?>  <option value="<?=$value['procurement_ref_no']; ?>"> <?=$value['procurement_ref_no']; ?> </option>
          <?php } ?> </select>
				  </div>
	        </div>
					</div>
					</div>

                        </div>
                        </div>
                        </form>
                        </div>


                <div class="procurement_details">
                </div>




		 </div>
     </div>

     <div class="receiptsp"> </div>
      <div class="bebp"> </div>
     </div>
  </div>
  <div class="btn-toolbar">
  <div class="btn-group">
      <a class="btn  btn-medium disabled" id="prev" dataval="" href="#">Prev </a>
       &nbsp;
      <a class="btn  btn-medium disabled" id="next" dataval="" href="#">Next </a>

  </div>
	</div>
	<?php

	if(isset($editbeb) && !empty($editbeb))
	{
 	$prc = $procurement_refno;
	}
	else
	{
	$prc = 0;
	}
  ?>
	<input type="hidden" id="procrt" value="<?=$prc;?>" />


	<script>

	 /*TACKLING PROVIDER VALIDITY OR NOT CHECK
	   */
       xs =0;
			xvv = 0;
	  function chckprovider(st)
	     {


	     if(st.length <= 0)
	      return;

	     	formdata = {};
	     	url = "<?=base_url().'receipts/searchproviders';?>";
	     	formdata['providernames'] = st;
			console.log(formdata);
	     	//checking proccessing ::
	     	alertmsg("Checking  Service Provider ["+formdata['providernames']+"]  Validity ... ");

				xvv = 1;
			$.ajax({
		    type: "POST",
		    url:  url,
			data:formdata,
		    success: function(data, textStatus, jqXHR){
			 
					xvv= 0;
		    	if(data == 1)
		    	{
		    		xs = 1;
		    		cancelmsg();
		    	}
		    	else
		    	{
		    		xs = 0;
		    		alertmsg("The Service Provider "+formdata['providernames']+" Was Suspended ");
		    	}
		    	console.log(data);
		     },
		    error:function(data , textStatus, jqXHR)
		    {
				console.log(data);
		    }
		    });

	     }
	     /*END OF CHECK
	     */


	$(function(){

	 var formdata = {};
	 $('.naw a').click(function(){
		 //$(".progress .bar").css("width",this.id+"%");
		});
		$('.active_procurements').on('change',function(){
			//alert(this.value);
		var selectedval = this.value;
		formdata['procurementrefno'] = selectedval;
	  $("#next").addClass("disabled");
	  alertmsgs();
		console.log(formdata);
		if(selectedval != 0) {
				//alert(this.value);
		if(('.procurement_details').length  != 0)
		{
		$('.procurement_details').fadeIn('slow');
		}
		$('.procurement_details').html('Processing..');

    var url = baseurl()+"bids/ajax_fetch_procurement_details/";
  // alert(url); return false;

    $.ajax({
    type: "POST",
    url:  url,
		data:formdata,
    success: function(data, textStatus, jqXHR){
    console.log(data);
		  //alert(data);
    $(".procurement_details").html(data);
		$("#procfefno").length > 0 ? $("#next").removeClass("disabled") : $("#next").addClass("disabled");
    },
    error:function(data , textStatus, jqXHR)
    {
		console.log(data);
    }
    });
		}else
		{
		$('.procurement_details').fadeOut('slow');
		}
		});


			$("#next").click(function(){
			 var nxt = $(".bar").attr("datavalue");
			if($(this).hasClass('disabled'))
			{
			switch(nxt)
			{
					case '10':
					alertmsg("Select a Procurement"); return false;
					break;
					case '50':
					break;
					case '100':
					break;
					default:
					break;
		}
		}

	    $("#prev").hasClass('disabled') ? $("#prev").removeClass('disabled') : '' ;
			if(nxt == 10){
			 $(".progress .bar").css("width", "50%");
			 $(".level_fetcher > .procurements").fadeOut('slow');
			 $(".level_fetcher > .receiptsp").fadeIn('slow');
			 // $(".level_fetcher > .receiptsp").html("Proccessing");
			 $(".widget-title > h4").html("ADD Received Bids");
			 $(".page-title ").html("Add Bid Response");
			 $(".bar").attr("datavalue",50);
		   //console.log(formdata); exit();
		   datalit = '<div class="alert alert-info">'+
                  '<button data-dismiss="alert" class="close">×</button>'+
                   '  <i class="fa-li fa fa-spinner fa-spin"></i> Proccessing ...  </div>';
        $(".level_fetcher > .receiptsp").html(datalit);
		url = baseurl()+'receipts/add_receipt';

	    $.ajax({
        type: "POST",
        url:  url,
        data: formdata,
        success: function(data, textStatus, jqXHR){
        $(".level_fetcher > .receiptsp").html(data);
        },
        error:function(data , textStatus, jqXHR)
        {
        console.log('Data Error'+data+textStatus+jqXHR);
        alert(data);
        }
    });
		}

			else if(nxt == 50){
			$(".widget-title > h4").html("Select Best Evaluated Bidder");
			$(".page-title ").html("Select Best Evaluated Bidder");
			$(".progress .bar").css("width", "100%");
			procrefno = $("#procrefno").val();
			// alert(procrefno)


	 $(".bar").attr("datavalue",50);
		//	 console.log(formdata); exit();
		var bidi = $("#bidid").val();
		url =  baseurl()+'bids/publish_bidder/publish_bidder/'+bidi+'/'+procrefno;
		console.log(url);
		//alert(url);

		   datalit = '<div class="alert alert-info">'+
                  '<button data-dismiss="alert" class="close">×</button>'+
                   '  <i class="fa-li fa fa-spinner fa-spin"></i> Proccessing ...  </div>';
        $(".level_fetcher > .receiptsp").html(datalit);

		$.ajax({
        type: "POST",
        url:  url,
        data: formdata,
        success: function(data, textStatus, jqXHR){
             $(".level_fetcher > .receiptsp").html(data);
			 $("#next").addClass("disabled");
			 $(".bar").attr("datavalue","10");

        },
        error:function(data , textStatus, jqXHR)
        {
            console.log('Data Error'+data+textStatus+jqXHR);
            alert(data);
        }
    });
		}
			 else {}


			});

     alertmsg = function(msg){
    $(".alert").fadeOut('slow');
    $(".alert").fadeIn('slow');$(".alert").html(msg);
    scrollers();

    }
     alertmsgs = function(){
        $(".alert").fadeOut('slow');
    }
   cancelmsg = function(){
        $(".alert").fadeOut('slow');
    }

     //scroll to top ::
     var scrollers = function(){
    $('html, body').animate({scrollTop : 0},800);
     }

		//initialze procurements
		var procurement = $("#procrt").val();

		if(procurement !=  0){
		$(".active_procurements").val(''+procurement+'').trigger('change');
		//	alert(procurement);
		}


	})
</script>
