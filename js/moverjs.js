// alert messages ::


  var nxt = 0;
  function togglediv(divid,anchorid)
  {
    $('#moredetails').toggle('slow');
    if(nxt  == 0){
    $("#"+anchorid).html('Hide Details');
    nxt ++;
  }
  else{
     $("#"+anchorid).html('Show Details ');
     nxt --;
  }
  }
  var alertmsg1 = function(msg){
    $(".alert").fadeOut('slow');
    $(".alert").fadeIn('slow');$(".alert").html(msg);
    scrollers1();

    }
    var alertmsgs1 = function(){
        $(".alert").fadeOut('slow');
    }


     //scroll to top ::
     var scrollers1 = function(){
    $('html, body').animate({scrollTop : 0},800);
     }

//reason given
 receipt_ans = {};
function reason(reason,receiptid){

 if(reason == 0){
   delete receipt_ans[receiptid];

}else
{
 receipt_ans[receiptid] = reason;
}


  console.log(receipt_ans);

}
 receipt_detail = {};
 function reasondetail(detail,receiptid)
  {
    receipt_detail[receiptid] = detail;
    console.log(receipt_detail);
  }



    var alertmsgs = function(msg){
    $(".alert").fadeOut('slow');
    $(".alert").fadeIn('slow');$(".alert").html(msg);
    scrollerss();

    }
    var cancelmsgs = function(){
        $(".alert").fadeOut('slow');
    }


     //scroll to top ::
     var scrollerss = function(){
    $('html, body').animate({scrollTop : 0},800);
     }


function updatelist(st){

 // if(st <= 0) return false;
 if((lott == 1) && (lot_id == 0) )
 {
  alertmsgs("Select Lot"); return ;
 }
  var bidi = $("#bidi").val();
  var url = baseurl()+"receipts/filterbids/"+st+"/"+bidi;
  // alert(url); return false;
  $("#unbidderlist").html("proccessing ...");
$.ajax({
        type: "POST",
        url:  url,
        success: function(data, textStatus, jqXHR){
          console.log(data);
         $("#unbidderlist").html(data);

        },
        error:function(data , textStatus, jqXHR)
        {
            alert(data);
        }
    });


}

//disposal bid issues 
function updatelist2(st){

 // if(st <= 0) return false;
 if((lott == 1) && (lot_id == 0) )
 {
  alertmsgs("Select Lot"); return ;
 }
  var bidi = $("#bidid").val();
  var url = baseurl()+"disposal/filterbids/"+st+"/"+bidi;
  // alert(url); return false;
  $("#unbidderlist").html("proccessing ...");
$.ajax({
        type: "POST",
        url:  url,
        success: function(data, textStatus, jqXHR){
          console.log(data);
         $("#unbidderlist").html(data);

        },
        error:function(data , textStatus, jqXHR)
        {
            alert(data);
        }
    });


}


approved ="Y";
function appved(st)
{
  approved = st;
}

$(function(){

/* SIGN A CONTRACT */
  //bid disposal invitation
  $( "#signcontract" ).submit(function(e) {
  
    e.preventDefault();
       if(ranking == 0)
    {
      //alert(ranking);
       return false;

     }
       var form = this;
        var formid = form.id;
        var datatype = $("#"+formid).attr('data-type');
         //action url to commit your data
        var dataaction =   $("#"+formid).attr('data-action');
        // alert(dataaction);
        // return false;
        var dataelements =   $("#"+formid).attr('data-elements');
        console.log(dataelements);
       // alert(dataelements);
          //server side checks ::--
         var serversidecheckss =  $("#"+formid).attr('data-cheks');
         //the url where you are going to use for server side checks on data
         var datacheckaction =  $("#"+formid).attr('data-check-action');

         url = dataaction;
         console.log(dataelements);
     // alert(dataelements);
     // return false;


           if(dataelements.length > 0)
            {
                var fieldNameArr=dataelements.split("<>");
            }
            else
            {
                fieldNameArr = Array();
            }

             var elementfield  ='';
             var formdata = {};
             var commitcheckdata = {};

             if((dataelements!= ' ') &&(dataelements.length > 0))
            {
                for(var i=0;i<fieldNameArr.length;i++)
                 {
                    //CHECK TO SEE IF ELEMEMENTS ARE REQUIRED
                     var lke = fieldNameArr[i].split("*");
                      elementfield = lke[1];
                      formvalue = $("#"+elementfield).val();
                         if(fieldNameArr[i].charAt(0)=="*"){
                          if(formvalue.length <= 0)
                          {
                          alertmsg('Fill Blanks'); return false;
                          }
                      }

                        else
                        {
                            elementfield = fieldNameArr[i];
                            formvalue = $("#"+elementfield).val();
                        }

                   var datatype =  $("#"+elementfield).attr('datatype');


                    switch(datatype)
                    {
                      case 'numeric':
                      var t = $.isNumeric(formvalue);
                      if(t == true)
                      {

                      }
                      else
                      {
                        alertmsg('Enter Digits'); return false;

                      }
                      break;
                        case 'text':
                        break;
                        case 'tel':

                        if(formvalue.length > 0)
                        {
                        var valu = validatephone(formvalue);
                        if(valu == false)
                        {
                            alertmsg('Invalid Phone, Digits are allowed, Not More than 10 digits'); return false;
                        }


                        }
                        break;
                        case 'web':

                        if(formvalue.length > 0)
                        {
                        var valu = validateweb(formvalue);
                        if(valu == false)
                        {
                             alertmsg('Invalid Web Url '); return false;
                        }

                        }
                        break;
                        case 'email':

                        if(formvalue.length > 0)
                        {
                            var valu = validateemail(formvalue);
                            if(valu == false)
                            {

                                alertmsg('Ivalid Email Address'); return false;
                            }


                        }
                        break;
                        case 'phone':
                        if(formvalue.length > 0)
                        {
                        var valu = validatephone(formvalue);
                        if(valu == false)
                        {
                            alertmsg('Invalid Phone, Digits are allowed, Not More than 10 digits'); return false;
                        }

                        }
                        break;
                        default:
                        break;
                    }

                    // ADDING ELEMETNTS TO THE FORM
                    formdata[elementfield] =formvalue;
                     }
                     formdata['answered'] = receipt_ans;
                    console.log(formdata);
            }

            //send to server
alertmsg('Proccessing ... ');

    $.ajax({
        type: "POST",
        url:  url,
        data: formdata,
        success: function(data, textStatus, jqXHR){
          console.log(data);
    //alert(data); exit();
          if(data == 1)
          {
             alertmsg('Record Saved Succesfully');
             location.href=baseurl()+"disposal/manage_contracts/m/usave";
          }else
          {
         alertmsg(data);
          console.log(data);
        }

        },
        error:function(data , textStatus, jqXHR)
        {
            console.log('Data Error'+data+textStatus+jqXHR);
            alert(data);
        }
    });




});


/* END */
/* delete disposal records
*/
$('.savedeldisposalrecord').on('click', function(){


    var decider = this.id;
    var idq =  decider.split('_');

     switch(idq[0])
     {
        
        case 'del':
        url = baseurl()+'disposal/deldisposalrecord_ajax/delete/'+idq[1];
        console.log(url);
        var b = confirm('You Are About to  Delete a Record')
        if(b == true){
         var rslt = ajx_delete(url,decider);
        }
        break;
        default:

        break;
     }

});


/*
*/
jm = 0;
function jm(st)
{
jm = st;
}


/*
HANDING THE DELETE FUNCTIONALITY ON DISPOSAL
  */
  // MANAGE DELETE RESORE AND UPDATE FUC
$('.savedeldisposal').on('click', function(){


    var decider = this.id;
    var idq =  decider.split('_');

     switch(idq[0])
     {
        case 'savedelpdetype':
        url = baseurl()+'pdetypes/delpdetype_ajax/archive/'+idq[1];
        console.log(url);

        var b = confirm('You Are About to Delete a Record')
        if(b == true){
         var rslt = ajx_delete(url,decider);
        }
        break;
        case 'restore':
        url = baseurl()+'pdetypes/delpdetype_ajax/restore/'+idq[1];
        console.log(url);
        var b = confirm('You Are About to Restore a Record')
        if(b == true){
         var rslt = ajx_delete(url,decider);
        }
        break;
        case 'del':
        url = baseurl()+'disposal/delp_ajax/delete/'+idq[1];
        console.log(url);
        var b = confirm('You Are About to  Delete a Record')
        if(b == true){
         var rslt = ajx_delete(url,decider);
        }
        break;
        default:

        break;
     }

});

  /*
  END
  */
lot_id = 0;
//search for ifb 
$(document).on('change','.ifbslot',function(){
 formdata = {}
 lott = 1;
 var bidi = $("#bidi").val();
lot_id = $(this).val();
if(lot_id <= 0) return ; 
formdata['lotid'] = lot_id;
formdata['bidid'] = bidi;

url = baseurl()+'receipts/populatelots';
console.log(formdata);
//search url 
$.ajax({
      type: "POST",
      url:  url,
      data: formdata,
      success: function(data, textStatus, jqXHR){
       console.log(data);
      // alert(data);
    $("#bebname").find('option').remove().end();
    $("#bebname").append(data);
      },
      error:function(data , textStatus, jqXHR) {
      console.log(data);
      }
  });
  // end 


});

$(".popcorn").click(function(){
  var datid = $(this).attr('datapop');
  $("#"+datid).fadeToggle('slow');

});
// publish_beb
$(".publish_beb").click(function(){

  formdata = {}
  var datid = $(this).attr('dataid');
  var url =  $(this).attr('dataurl');
  var databidid = $(this).attr('databidid');
  formdata['dataid'] = datid;
  formdata['action'] = "publishbeb";
  formdata['status'] =   'Y';
  console.log(formdata);

  $.ajax({
      type: "POST",
      url:  url,
      data: formdata,
      success: function(data, textStatus, jqXHR){

        if(data == 1)
        {
          location.reload();
        }else
        {
          alert(data);
        }

      },
      error:function(data , textStatus, jqXHR) {

         console.log(data);
      }
  });

});

//cancel criteria
$(".cancel_beb").click(function(){

  formdata = {}
  var datid = $(this).attr('dataid');
  var url =  $(this).attr('dataurl');
  var databidid = $(this).attr('databidid');
  formdata['dataid'] = datid;
  formdata['action'] = "cancelbeb";
  formdata['databidid'] = databidid;
  var isit = confirm("You Are About to Cancel a BEB !");
  if(isit == false) return false;

  $.ajax({
      type: "POST",
      url:  url,
      data: formdata,
      success: function(data, textStatus, jqXHR){

        if(data == 1)
        {
          location.reload();
        }else
        {
          alert(data);
        }

      },
      error:function(data , textStatus, jqXHR) {

         console.log(data);
      }
  });

});

//admin review
$(".admin_review").click(function(){
  formata = {}
  var datid = $(this).attr('dataid');
  var url =  $(this).attr('dataurl');
  formata['dataid'] = datid;
  formata['action'] = "underreview";
  formata['status'] =  this.checked ? 'Y': 'N' ;
  console.log(formata);

    


  $.ajax({
      type: "POST",
      url:  url,
      data: formata,
      success: function(data, textStatus, jqXHR){

        if(data == 1)
        {
          location.reload();
        }else
        {
          alert(data);
        }

      },
      error:function(data , textStatus, jqXHR) {
         console.log(data);
      }
  });

});



$( ".date-picker" ).datepicker();
$(".plishtype").click(function(){
 btntype = $(this).val();
});
$(".select").chosen({ width: '350px' });

$('.savedelprovider').on('click', function(){


    var decider = this.id;
    var idq =  decider.split('_');

     switch(idq[0])
     {
        case 'archive':
        url = baseurl()+'providers/delproviders_ajax/archive/'+idq[1];
        var b = confirm('You Are About to Delete a Record')
        if(b == true){
         var rslt = ajx_delete(url,decider);
        }
        break;
        case 'restore':
        url = baseurl()+'providers/delproviders_ajax/restore/'+idq[1];
        var b = confirm('You Are About to Restore a Record')
        if(b == true){
         var rslt = ajx_delete(url,decider);
        }
        break;
        case 'del':
        url = baseurl()+'providers/delproviders_ajax/del/'+idq[1];
        var b = confirm('You Are About to Paramanently Delete a Record')
        if(b == true){
         var rslt = ajx_delete(url,decider);
        }
        break;
        default:

        break;
     }

});
//provider_suspension
$( "#provider_suspension" ).submit(function(e) {
       e.preventDefault();
       var form = this;
       var formid = form.id;
       var datatype = $("#"+formid).attr('data-type');
       var dataaction =   $("#"+formid).attr('data-action');
       var dataelements =   $("#"+formid).attr('data-elements');
       console.log(dataelements);
       var serversidecheckss =  $("#"+formid).attr('data-cheks');
         //the url where you are going to use for server side checks on data
       var datacheckaction =  $("#"+formid).attr('data-check-action');
       var datacomp =  $("#"+formid).attr('datacompare');

       url = dataaction;
       console.log(dataelements);

           if(dataelements.length > 0)
            {
                var fieldNameArr=dataelements.split("<>");
            }
            else
            {
                fieldNameArr = Array();
            }

             var elementfield  ='';
             var formdata = {};
             var commitcheckdata = {};
             formdata['status'] = cheked;

             if((dataelements!= ' ') &&(dataelements.length > 0))
            {
                for(var i=0;i<fieldNameArr.length;i++)
                 {

                    //CHECK TO SEE IF ELEMEMENTS ARE REQUIRED
                     var lke = fieldNameArr[i].split("*");
                      elementfield = lke[1];
                      // alert(elementfield);  
                       if((elementfield == 'suspensionduration') && (cheked > 0))
                        continue;
                       if((elementfield == 'indifintedatestart') && (cheked <= 0))
                        continue;
                         console.log(elementfield);
                         formvalue = $("#"+elementfield).val();
                         if(fieldNameArr[i].charAt(0)=="*"){
                          if(formvalue.length <= 0)
                          {
                          alertmsg('Fill Blanks');
               return false;
                          }
                      }

                        else
                        {
                            elementfield = fieldNameArr[i];
                            formvalue = $("#"+elementfield).val();
                        }

                   var datatype =  $("#"+elementfield).attr('datatype');


                    switch(datatype)
                    {
                        case 'text':
                        break;
                        case 'tel':

                        if(formvalue.length > 0)
                        {
                        var valu = validatephone(formvalue);
                        if(valu == false)
                        {
                            alertmsg('Invalid Phone, Digits are allowed, Not More than 10 digits'); return false;
                        }


                        }
                        break;
                        case 'web':

                        if(formvalue.length > 0)
                        {
                        var valu = validateweb(formvalue);
                        if(valu == false)
                        {
                             alertmsg('Invalid Web Url '); return false;
                        }

                        }
                        break;
                        case 'email':

                        if(formvalue.length > 0)
                        {
                            var valu = validateemail(formvalue);
                            if(valu == false)
                            {

                                alertmsg('Ivalid Email Address'); return false;
                            }


                        }
                        break;
                        case 'phone':
                        if(formvalue.length > 0)
                        {
                        var valu = validatephone(formvalue);
                        if(valu == false)
                        {
                            alertmsg('Invalid Phone, Digits are allowed, Not More than 10 digits'); return false;
                        }

                        }
                        break;

            case 'money':
              if(formvalue.length > 0)
                        {
              //alert(fieldNameArr[i]);
                        var valu = isNumber(formvalue);
          //alert('mover');
                        if(valu == false)
                        {
                            alertmsg('Invalid Entry, Enter Digits');
              $("#"+elementfield).css('border', 'solid 3px #FFE79B');
              return false;
                        }
            }

            break;
             case 'numeric':


            break;
                        default:
                        break;
                    }

                    // ADDING ELEMETNTS TO THE FORM
                    formdata[elementfield] =formvalue;
                     }
                    console.log(formdata);
            }


    console.log(url);
    alertmsg('Proccessing ... ');
    $.ajax({
        type: "POST",
        url:  url,
        data: formdata,
        success: function(data, textStatus, jqXHR){
         console.log(data);
          if(data == 1)
          {
            alertmsg('Record Saved Succesfully ');
            location.href=baseurl()+"providers/manage_suspended_providers";
          }

          else{

            var dct = data.split(":");

            if(dct[0] == 3)
            {
              alertmsg(dct[1]);
            }else
            alertmsg('Something Went Wrong Contact Site Administrator ');
          }

            console.log(data);   return false;


        },
        error:function(data , textStatus, jqXHR)
        {
            console.log('Data Error'+data+textStatus+jqXHR);
            alert(data);
        }
    });
  });

//disposal plan  disposal_plan
displan = 0;
$( "#disposal_plan" ).submit(function(e) {

 // alert("ready CLoser");
 if(displan == 1)
 {

  $(this).submit();

 }
 else
 {
    

       var form = this;
        var formid = form.id;
        var datatype = $("#"+formid).attr('data-type');
         //action url to commit your data
        var dataaction =   $("#"+formid).attr('data-action');
        // alert(dataaction);
        // return false;
        var dataelements =   $("#"+formid).attr('data-elements');
        console.log(dataelements);
       // alert(dataelements);
          //server side checks ::--
         var serversidecheckss =  $("#"+formid).attr('data-cheks');
         //the url where you are going to use for server side checks on data
         var datacheckaction =  $("#"+formid).attr('data-check-action');
         var datacomp =  $("#"+formid).attr('datacompare');

         url = dataaction;
         console.log(dataelements);
     // alert(dataelements);
     // return false;
           if(dataelements.length > 0)
            {
              var file_compare = datacomp.split("<>");
            }
            else
            {
              file_compare = Array();
            }
           if(dataelements.length > 0)
            {
                var fieldNameArr=dataelements.split("<>");
            }
            else
            {
                fieldNameArr = Array();
            }

             var elementfield  ='';
             var formdata = {};
             var commitcheckdata = {};

             if((dataelements!= ' ') &&(dataelements.length > 0))
            {
                for(var i=0;i<fieldNameArr.length;i++)
                 {
                    //CHECK TO SEE IF ELEMEMENTS ARE REQUIRED
                     var lke = fieldNameArr[i].split("*");
                      elementfield = lke[1];
                      formvalue = $("#"+elementfield).val();
                         if(fieldNameArr[i].charAt(0)=="*"){
                          if(formvalue.length <= 0)
                          {
                          alertmsg('Fill Blanks');
                          e.preventDefault();
               return false;
                          }
                      }

                        else
                        {
                            elementfield = fieldNameArr[i];
                            formvalue = $("#"+elementfield).val();
                        }

                   var datatype =  $("#"+elementfield).attr('datatype');


                    switch(datatype)
                    {
                        case 'text':
                        break;
                        case 'tel':

                        if(formvalue.length > 0)
                        {
                        var valu = validatephone(formvalue);
                        if(valu == false)
                        {
                          e.preventDefault();
                            alertmsg('Invalid Phone, Digits are allowed, Not More than 10 digits'); return false;
                        }


                        }
                        break;
                        case 'web':

                        if(formvalue.length > 0)
                        {
                        var valu = validateweb(formvalue);
                        if(valu == false)
                        {
                          e.preventDefault();
                             alertmsg('Invalid Web Url '); return false;
                        }

                        }
                        break;
                        case 'email':

                        if(formvalue.length > 0)
                        {
                            var valu = validateemail(formvalue);
                            if(valu == false)
                                {
                                e.preventDefault();
                                alertmsg('Ivalid Email Address'); return false;
                            }


                        }
                        break;
                        case 'phone':
                        if(formvalue.length > 0)
                        {
                        var valu = validatephone(formvalue);
                        if(valu == false)
                        {
                            e.preventDefault();
                            alertmsg('Invalid Phone, Digits are allowed, Not More than 10 digits'); return false;
                        }

                        }
                        break;

            case 'money':
              if(formvalue.length > 0)
                        {
              //alert(fieldNameArr[i]);
                        var valu = isNumber(formvalue);
          //alert('mover');
                        if(valu == false)
                        {
                          e.preventDefault();
                            alertmsg('Invalid Entry, Enter Digits');
              $("#"+elementfield).css('border', 'solid 3px #FFE79B');
              return false;
                        }
            }

            break;
             case 'numeric':


            break;
                        default:
                        break;
          }

          // ADDING ELEMETNTS TO THE FORM
          formdata[elementfield] =formvalue;
        }
      console.log(formdata);

                     // check date range
    // datacomparealert
    //  alert(formdata[file_compare[1]]); return false;
      if((formdata[file_compare[1]] - formdata[file_compare[0]]) <= 0)
      {
        alertmsg('Financial Year Difference Is Incorrect');
        $("#"+file_compare[1]).css('border', 'solid 3px #FFE79B');
        $("#"+file_compare[0]).css('border', 'solid 3px #FFE79B');
        e.preventDefault();
        return false;
      }
      else
      {
        if(clean > 0)
         {
          alertmsg('Disposal Plan Exits for this Financial Year ');
           $("#"+file_compare[1]).css('border', 'solid 3px #FFE79B');
          $("#"+file_compare[0]).css('border', 'solid 3px #FFE79B');
         e.preventDefault();
         }
        $("#"+file_compare[1]).css('border', 'solid 1px #eee');
        $("#"+file_compare[0]).css('border', 'solid 1px #eee');
      }


      displan = 1;
      $("#btnotp").click();
      $(this).submit();
      alert(displan);
      console.log(formdata);


}

   





//$(this).submit();

/* every thing normal */


// $(this).find('input type=checkbox ')

// return ;
// alert(url); return false;
//return false;
            //send to server
  //  if(isvalid ==0)
  // {
  //   alertmsg('Solve issues on the form '); return false;
  // }
  /*
alertmsg('Proccessing ... ');
 
    $.ajax({
        type: "POST",
        url:  url,
        data: formdata,
        success: function(data, textStatus, jqXHR){
          console.log(data);

          if(data == 1)
          {
            alertmsg('Record Saved Succesfully ');
            location.href=baseurl()+"disposal/view_disposal_plan/m/usave";

          }

          else{

            var dct = data.split(":");

            if(dct[0] == 3)
            {
              alertmsg(dct[1]);
            }else
            alertmsg('Something Went Wrong Contact Site Administrator ');
          }

            console.log(data);   return false;


        },
        error:function(data , textStatus, jqXHR)
        {
            console.log('Data Error'+data+textStatus+jqXHR);
            alert(data);
        }
    }); */
  }
  });


  //BId Response
  //bid receipt information
$( "#bid_response_disposal" ).submit(function(e) {
 // alert("ready CLoser");
    e.preventDefault();

       var form = this;
        var formid = form.id;
        var datatype = $("#"+formid).attr('data-type');
         //action url to commit your data
        var dataaction =   $("#"+formid).attr('data-action');
        // alert(dataaction);
        // return false;
        var dataelements =   $("#"+formid).attr('data-elements');
        console.log(dataelements);
       // alert(dataelements);
          //server side checks ::--
         var serversidecheckss =  $("#"+formid).attr('data-cheks');
         //the url where you are going to use for server side checks on data
         var datacheckaction =  $("#"+formid).attr('data-check-action');

         url = dataaction;
         console.log(dataelements);
     // alert(dataelements);
     // return false;


           if(dataelements.length > 0)
            {
                var fieldNameArr=dataelements.split("<>");
            }
            else
            {
                fieldNameArr = Array();
            }

             var elementfield  ='';
             var formdata = {};
             var commitcheckdata = {};

             if((dataelements!= ' ') &&(dataelements.length > 0))
            {
                for(var i=0;i<fieldNameArr.length;i++)
                 {
                    //CHECK TO SEE IF ELEMEMENTS ARE REQUIRED
                     var lke = fieldNameArr[i].split("*");
                      elementfield = lke[1];
                      formvalue = $("#"+elementfield).val();
                         if(fieldNameArr[i].charAt(0)=="*"){
                          if(formvalue.length <= 0)
                          {
                          alertmsg('Fill Blanks');
               return false;
                          }
                      }

                        else
                        {
                            elementfield = fieldNameArr[i];
                            formvalue = $("#"+elementfield).val();
                        }

                   var datatype =  $("#"+elementfield).attr('datatype');


                    switch(datatype)
                    {
                        case 'text':
                        break;
                        case 'tel':

                        if(formvalue.length > 0)
                        {
                        var valu = validatephone(formvalue);
                        if(valu == false)
                        {
                            alertmsg('Invalid Phone, Digits are allowed, Not More than 10 digits'); return false;
                        }


                        }
                        break;
                        case 'web':

                        if(formvalue.length > 0)
                        {
                        var valu = validateweb(formvalue);
                        if(valu == false)
                        {
                             alertmsg('Invalid Web Url '); return false;
                        }

                        }
                        break;
                        case 'email':

                        if(formvalue.length > 0)
                        {
                            var valu = validateemail(formvalue);
                            if(valu == false)
                            {

                                alertmsg('Ivalid Email Address'); return false;
                            }


                        }
                        break;
                        case 'phone':
                        if(formvalue.length > 0)
                        {
                        var valu = validatephone(formvalue);
                        if(valu == false)
                        {
                            alertmsg('Invalid Phone, Digits are allowed, Not More than 10 digits'); return false;
                        }

                        }
                        break;

            case 'money':
              if(formvalue.length > 0)
                        {
              //alert(fieldNameArr[i]);
                        var valu = isNumber(formvalue);
          //alert('mover');
                        if(valu == false)
                        {
                            alertmsg('Invalid Entry, Enter Digits');
              $("#"+elementfield).css('border', 'solid 3px #FFE79B');
              return false;
                        }
            }

            break;
                        default:
                        break;
                    }

                    // ADDING ELEMETNTS TO THE FORM
                    formdata[elementfield] =formvalue;
                     }
                    console.log(formdata);
            }

console.log(url);
//return false;
            //send to server
  //  if(isvalid ==0)
  // {
  //   alertmsg('Solve issues on the form '); return false;
  // }
alertmsg('Proccessing ... ');

    $.ajax({
        type: "POST",
        url:  url,
        data: formdata,
        success: function(data, textStatus, jqXHR){
          console.log(data);

          if(data == 1)
          {
            alertmsg('Record Saved Succesfully ');
            location.href=baseurl()+"disposal/view_disposal_records";

          }

          else{

            var dct = data.split(":");

            if(dct[0] == 3)
            {
              alertmsg(dct[1]);
            }else
            alertmsg('Something Went Wrong Contact Site Administrator ');
          }

            console.log(data);   return false;


        },
        error:function(data , textStatus, jqXHR)
        {
            console.log('Data Error'+data+textStatus+jqXHR);
            alert(data);
        }
    });
  });

	//initialize datepicker
  $('input[name="bid_duration"]').daterangepicker()
   $('.dtpicker').daterangepicker();



   //sign contract

   //bid disposal invitation
  $( "#signcontract" ).submit(function(e) {
    e.preventDefault();
    if(ranking == 0)
    {
     
       return false;

     }
       var form = this;
        var formid = form.id;
        var datatype = $("#"+formid).attr('data-type');
         //action url to commit your data
        var dataaction =   $("#"+formid).attr('data-action');
        // alert(dataaction);
        // return false;
        var dataelements =   $("#"+formid).attr('data-elements');
        console.log(dataelements);
       // alert(dataelements);
          //server side checks ::--
         var serversidecheckss =  $("#"+formid).attr('data-cheks');
         //the url where you are going to use for server side checks on data
         var datacheckaction =  $("#"+formid).attr('data-check-action');

         url = dataaction;
         console.log(dataelements);
     // alert(dataelements);
     // return false;


           if(dataelements.length > 0)
            {
                var fieldNameArr=dataelements.split("<>");
            }
            else
            {
                fieldNameArr = Array();
            }

             var elementfield  ='';
             var formdata = {};
             var commitcheckdata = {};

             if((dataelements!= ' ') &&(dataelements.length > 0))
            {
                for(var i=0;i<fieldNameArr.length;i++)
                 {
                    //CHECK TO SEE IF ELEMEMENTS ARE REQUIRED
                     var lke = fieldNameArr[i].split("*");
                      elementfield = lke[1];

                      formvalue = $("#"+elementfield).val();

                      if(elementfield == 'contractamount')
                      {                       
                        formdata['contractamount'] = 0;
                        continue;
                      }
                       if(elementfield == 'currency')
                      {                       
                        formdata['currency'] = 'NAN';
                        continue;
                      }
                       

                      if(fieldNameArr[i].charAt(0)=="*"){
                          if(formvalue.length <= 0)
                          {
                          alertmsg('Fill Blanks'); return false;
                          }
                      }

                        else
                        {
                            elementfield = fieldNameArr[i];
                            formvalue = $("#"+elementfield).val();
                        }

                   var datatype =  $("#"+elementfield).attr('datatype');


                    switch(datatype)
                    {
                      case 'numeric':
                      var t = $.isNumeric(formvalue);
                      if(t == true)
                      {

                      }
                      else
                      {
                        alertmsg('Enter Digits'); return false;

                      }
                      break;
                        case 'text':
                        break;
                        case 'tel':

                        if(formvalue.length > 0)
                        {
                        var valu = validatephone(formvalue);
                        if(valu == false)
                        {
                            alertmsg('Invalid Phone, Digits are allowed, Not More than 10 digits'); return false;
                        }


                        }
                        break;
                        case 'web':

                        if(formvalue.length > 0)
                        {
                        var valu = validateweb(formvalue);
                        if(valu == false)
                        {
                             alertmsg('Invalid Web Url '); return false;
                        }

                        }
                        break;
                        case 'email':

                        if(formvalue.length > 0)
                        {
                            var valu = validateemail(formvalue);
                            if(valu == false)
                            {

                                alertmsg('Ivalid Email Address'); return false;
                            }


                        }
                        break;
                        case 'phone':
                        if(formvalue.length > 0)
                        {
                        var valu = validatephone(formvalue);
                        if(valu == false)
                        {
                            alertmsg('Invalid Phone, Digits are allowed, Not More than 10 digits'); return false;
                        }

                        }
                        break;
                        default:
                        break;
                    }

                    // ADDING ELEMETNTS TO THE FORM
                    formdata[elementfield] =formvalue;
                     }
                     formdata['answered'] = receipt_ans;
                    console.log(formdata);
            }
 
            //send to server
alertmsg('Proccessing ... ');

    $.ajax({
        type: "POST",
        url:  url,
        data: formdata,
        success: function(data, textStatus, jqXHR){
          console.log(data);
    //alert(data); exit();
          if(data == 1)
          {
             alertmsg('Record Saved Succesfully');
             location.href=baseurl()+"disposal/view_bid_invitations/m/usave";
          }else
          {
         alertmsg(data);
          console.log(data);
        }

        },
        error:function(data , textStatus, jqXHR)
        {
            console.log('Data Error'+data+textStatus+jqXHR);
            alert(data);
        }
    });




});


   //end contract 


  //bid disposal invitation
  $( "#disposal_bid_invitation" ).submit(function(e) {
    e.preventDefault();
       var form = this;
        var formid = form.id;
        var datatype = $("#"+formid).attr('data-type');
         //action url to commit your data
        var dataaction =   $("#"+formid).attr('data-action');
        // alert(dataaction);
        // return false;
        var dataelements =   $("#"+formid).attr('data-elements');
        console.log(dataelements);
       // alert(dataelements);
          //server side checks ::--
         var serversidecheckss =  $("#"+formid).attr('data-cheks');
         //the url where you are going to use for server side checks on data
         var datacheckaction =  $("#"+formid).attr('data-check-action');

         url = dataaction;
         console.log(dataelements);
     // alert(dataelements);
     // return false;


           if(dataelements.length > 0)
            {
                var fieldNameArr=dataelements.split("<>");
            }
            else
            {
                fieldNameArr = Array();
            }

             var elementfield  ='';
             var formdata = {};
             var commitcheckdata = {};

             if((dataelements!= ' ') &&(dataelements.length > 0))
            {
                for(var i=0;i<fieldNameArr.length;i++)
                 {
                    //CHECK TO SEE IF ELEMEMENTS ARE REQUIRED
                     var lke = fieldNameArr[i].split("*");
                      elementfield = lke[1];

                      formvalue = $("#"+elementfield).val();

                    

                      if(fieldNameArr[i].charAt(0)=="*"){
                          if(formvalue.length <= 0)
                          {
                          alertmsg('Fill Blanks'); return false;
                          }
                      }

                        else
                        {
                            elementfield = fieldNameArr[i];
                            formvalue = $("#"+elementfield).val();
                        }

                   var datatype =  $("#"+elementfield).attr('datatype');


                    switch(datatype)
                    {
                      case 'numeric':
                      var t = $.isNumeric(formvalue);
                      if(t == true)
                      {

                      }
                      else
                      {
                        alertmsg('Enter Digits'); return false;

                      }
                      break;
                        case 'text':
                        break;
                        case 'tel':

                        if(formvalue.length > 0)
                        {
                        var valu = validatephone(formvalue);
                        if(valu == false)
                        {
                            alertmsg('Invalid Phone, Digits are allowed, Not More than 10 digits'); return false;
                        }


                        }
                        break;
                        case 'web':

                        if(formvalue.length > 0)
                        {
                        var valu = validateweb(formvalue);
                        if(valu == false)
                        {
                             alertmsg('Invalid Web Url '); return false;
                        }

                        }
                        break;
                        case 'email':

                        if(formvalue.length > 0)
                        {
                            var valu = validateemail(formvalue);
                            if(valu == false)
                            {

                                alertmsg('Ivalid Email Address'); return false;
                            }


                        }
                        break;
                        case 'phone':
                        if(formvalue.length > 0)
                        {
                        var valu = validatephone(formvalue);
                        if(valu == false)
                        {
                            alertmsg('Invalid Phone, Digits are allowed, Not More than 10 digits'); return false;
                        }

                        }
                        break;
                        default:
                        break;
                    }

                    // ADDING ELEMETNTS TO THE FORM
                    formdata[elementfield] =formvalue;
                     }
                     formdata['answered'] = receipt_ans;
                    console.log(formdata);
            }
 
            //send to server
alertmsg('Proccessing ... ');

    $.ajax({
        type: "POST",
        url:  url,
        data: formdata,
        success: function(data, textStatus, jqXHR){
          console.log(data);
    //alert(data); exit();
          if(data == 1)
          {
             alertmsg('Record Saved Succesfully');
             location.href=baseurl()+"disposal/view_bid_invitations/m/usave";
          }else
          {
         alertmsg(data);
          console.log(data);
        }

        },
        error:function(data , textStatus, jqXHR)
        {
            console.log('Data Error'+data+textStatus+jqXHR);
            alert(data);
        }
    });




});


isvalid = 0;
// work on checking if the Disposal Ref Number already Exists in the database
  $(".servercheck").change( function(){

	  var formdata = {};
      var vale = this.value;
 	  var did = this.id;
      var dataurl =$("#"+did).attr("dataurl");
	  formdata['itemcheck'] = vale;
	    $("#"+did).css('border', 'solid 1px #eee');
	  alertmsg('Proccessing ... ');
      console.log(formdata);
	 // alert(dataurl); return false;
	  $.ajax({
        type: "POST",
        url:  dataurl,
        data: formdata,
        success: function(data, textStatus, jqXHR){
          console.log(data);
		if(data > 0)
		{
			alertmsg('Disposal Ref Number already Exists ');
		    $("#"+did).css('border', 'solid 3px #FFE79B');
			isvalid = 0;
			return false;
		}
		isvalid = 1;
		  cancelmsg();

        },
        error:function(data , textStatus, jqXHR)
        {
            alert(data);
        }
    });

});
//bid receipt information
$( "#disposalform" ).submit(function(e) {
    e.preventDefault();

       var form = this;
        var formid = form.id;
        var datatype = $("#"+formid).attr('data-type');
         //action url to commit your data
        var dataaction =   $("#"+formid).attr('data-action');
        // alert(dataaction);
        // return false;
        var dataelements =   $("#"+formid).attr('data-elements');
        console.log(dataelements);
       // alert(dataelements);
          //server side checks ::--
         var serversidecheckss =  $("#"+formid).attr('data-cheks');
         //the url where you are going to use for server side checks on data
         var datacheckaction =  $("#"+formid).attr('data-check-action');

         url = dataaction;
         console.log(dataelements);
     // alert(dataelements);
     // return false;


           if(dataelements.length > 0)
            {
                var fieldNameArr=dataelements.split("<>");
            }
            else
            {
                fieldNameArr = Array();
            }

             var elementfield  ='';
             var formdata = {};
             var commitcheckdata = {};

             if((dataelements!= ' ') &&(dataelements.length > 0))
            {
                for(var i=0;i<fieldNameArr.length;i++)
                 {
                    //CHECK TO SEE IF ELEMEMENTS ARE REQUIRED
                     var lke = fieldNameArr[i].split("*");
                      elementfield = lke[1];
                      console.log(elementfield);
                      formvalue = $("#"+elementfield).val();
                         if(fieldNameArr[i].charAt(0)=="*"){
                          console.log(elementfield)
                          if(formvalue.length <= 0)
                          {
                          alertmsg('Fill Blanks');
						   return false;
                          }
                      }

                        else
                        {
                            elementfield = fieldNameArr[i];
                            formvalue = $("#"+elementfield).val();
                        }

                   var datatype =  $("#"+elementfield).attr('datatype');


                    switch(datatype)
                    {
                        case 'text':
                        break;
                        case 'tel':

                        if(formvalue.length > 0)
                        {
                        var valu = validatephone(formvalue);
                        if(valu == false)
                        {
                            alertmsg('Invalid Phone, Digits are allowed, Not More than 10 digits'); return false;
                        }


                        }
                        break;
                        case 'web':

                        if(formvalue.length > 0)
                        {
                        var valu = validateweb(formvalue);
                        if(valu == false)
                        {
                             alertmsg('Invalid Web Url '); return false;
                        }

                        }
                        break;
                        case 'email':

                        if(formvalue.length > 0)
                        {
                            var valu = validateemail(formvalue);
                            if(valu == false)
                            {

                                alertmsg('Ivalid Email Address'); return false;
                            }


                        }
                        break;
                        case 'phone':
                        if(formvalue.length > 0)
                        {
                        var valu = validatephone(formvalue);
                        if(valu == false)
                        {
                            alertmsg('Invalid Phone, Digits are allowed, Not More than 10 digits'); return false;
                        }

                        }
                        break;

						case 'money':
						  if(formvalue.length > 0)
                        {
							//alert(fieldNameArr[i]);
              formvalue =   formvalue.replace(/\D/g, ''); 
                        var valu = isNumber(formvalue);
					//alert('mover');
                        if(valu == false)
                        {
                            alertmsg('Invalid Entry, Enter Digits');
							$("#"+elementfield).css('border', 'solid 3px #FFE79B');
							return false;
                        }
						}

						break;
                        default:
                        break;
                    }

                    // ADDING ELEMETNTS TO THE FORM
                    formdata[elementfield] =formvalue;
                     }
                    console.log(formdata);
            }

console.log(url);
//return false;
            //send to server
	 /* if(isvalid ==0)
	{
		alertmsg('Solve issues on the form '); return false;
	} */
alertmsg('Proccessing ... ');

    $.ajax({
        type: "POST",
        url:  url,
        data: formdata,
        success: function(data, textStatus, jqXHR){
          console.log(data);

          if(data == 1)
          {
            alertmsg('Record Saved Succesfully ');
            location.href=baseurl()+"disposal/view_disposal_records/m/usave";

          }

          else{

            var dct = data.split(":");

            if(dct[0] == 3)
            {
              alertmsg(dct[1]);
            }else
            alertmsg('Something Went Wrong Contact Site Administrator ');
          }

            console.log(data);   return false;


        },
        error:function(data , textStatus, jqXHR)
        {
            console.log('Data Error'+data+textStatus+jqXHR);
            alert(data);
        }
    });




});


function isNumber(input){
    var RE = /^-{0,1}\d*\.{0,1}\d+$/;
    return (RE.test(input));
}

// evaluate disposal

//bid receipt information
$( "#evaluatebebdisposal" ).submit(function(e) {
    e.preventDefault();
       var form = this;
        var formid = form.id;
        var datatype = $("#"+formid).attr('data-type');
         //action url to commit your data
        var dataaction =   $("#"+formid).attr('data-action');
        // alert(dataaction);
        // return false;
        var dataelements =   $("#"+formid).attr('data-elements');
        console.log(dataelements);
       // alert(dataelements);
          //server side checks ::--
         var serversidecheckss =  $("#"+formid).attr('data-cheks');
         //the url where you are going to use for server side checks on data
         var datacheckaction =  $("#"+formid).attr('data-check-action');

         url = dataaction;
         console.log(dataelements);
     // alert(dataelements);
     // return false;

           if(dataelements.length > 0)
            {
                var fieldNameArr=dataelements.split("<>");
            }
            else
            {
                fieldNameArr = Array();
            }

             var elementfield  ='';
             var formdata = {};
             var commitcheckdata = {};

             if((dataelements!= ' ') &&(dataelements.length > 0))
            {
                for(var i=0;i<fieldNameArr.length;i++)
                 {
                    //CHECK TO SEE IF ELEMEMENTS ARE REQUIRED
                     var lke = fieldNameArr[i].split("*");
                      elementfield = lke[1];
          //take care of the lots thing
          if(elementfield == 'ifbslot')
           {
             if($("#"+elementfield).val() <= 0 ){
               alertmsg("Select Lot");
               $("#"+elementfield).css('border', 'solid 3px #FFE79B');
               return false;
             }else
             {
               lots = 1;
               $("#"+elementfield).css('border', 'solid 1px #eee');
             }
           }


                      formvalue = $("#"+elementfield).val();
                         if(fieldNameArr[i].charAt(0)=="*"){
                          if(formvalue.length <= 0)
                          {
                          alertmsg('Fill Blanks'); return false;
                          }
                    }

                    else
                    {
                            elementfield = fieldNameArr[i];
                            formvalue = $("#"+elementfield).val();
                    }

                   var datatype =  $("#"+elementfield).attr('datatype');


                    switch(datatype)
                    {
                      case 'numeric':
                      
                         if(formvalue.length > 3)
                      {
                          if (/\D/g.test(formvalue))
                          {
                          //Filter non-digits from input value.
                          formvalue =  formvalue.replace(/\D/g, '');
                          }
                                               
                      }
                      var t = $.isNumeric(formvalue);
                      if(t == true)
                      {

                      }
                      else
                      {
                        alertmsg('Enter Digits'); return false;

                      }
                      break;
                        case 'text':
                        break;
                        case 'tel':

                        if(formvalue.length > 0)
                        {
                        var valu = validatephone(formvalue);
                        if(valu == false)
                        {
                            alertmsg('Invalid Phone, Digits are allowed, Not More than 10 digits'); return false;
                         }


                        }
                        break;
                        case 'web':

                        if(formvalue.length > 0)
                        {
                        var valu = validateweb(formvalue);
                        if(valu == false)
                        {
                             alertmsg('Invalid Web Url '); return false;
                        }

                        }
                        break;
                        case 'email':

                        if(formvalue.length > 0)
                        {
                            var valu = validateemail(formvalue);
                            if(valu == false)
                            {

                                alertmsg('Ivalid Email Address'); return false;
                            }


                        }
                        break;
                        case 'phone':
                        if(formvalue.length > 0)
                        {
                        var valu = validatephone(formvalue);
                        if(valu == false)
                        {
                            alertmsg('Invalid Phone, Digits are allowed, Not More than 10 digits'); return false;
                        }

                        }
                        break;
                        default:
                        break;
                    }

                    // ADDING ELEMETNTS TO THE FORM
                    formdata[elementfield] =formvalue;
                     }
                     formdata['answered'] = receipt_ans;
                     formdata['btnstatus'] = btntype;
                    console.log(formdata);
            }

  //send to server
alertmsg('Proccessing ... ');

    $.ajax({
        type: "POST",
        url:  url,
        data: formdata,
        success: function(data, textStatus, jqXHR){

          if(data == 1)
          {
             alertmsg('Record Saved Succesfully');
             location.href=baseurl()+"disposal/manage_bebs";
          }else
          {
         alertmsg(data);
          console.log(data);
        }

        },
        error:function(data , textStatus, jqXHR)
        {
            console.log('Data Error'+data+textStatus+jqXHR);
            alert(data);
        }
    });




});


//end of evaluate disposal bid


//bid receipt information
$( "#evaluatebeb" ).submit(function(e) {
    e.preventDefault();
       var form = this;
        var formid = form.id;
        var datatype = $("#"+formid).attr('data-type');
         //action url to commit your data
        var dataaction =   $("#"+formid).attr('data-action');
        // alert(dataaction);
        // return false;
        var dataelements =   $("#"+formid).attr('data-elements');
        console.log(dataelements);
       // alert(dataelements);
          //server side checks ::--
         var serversidecheckss =  $("#"+formid).attr('data-cheks');
         //the url where you are going to use for server side checks on data
         var datacheckaction =  $("#"+formid).attr('data-check-action');

         url = dataaction;
         console.log(dataelements);
     // alert(dataelements);
     // return false;

           if(dataelements.length > 0)
            {
                var fieldNameArr=dataelements.split("<>");
            }
            else
            {
                fieldNameArr = Array();
            }

             var elementfield  ='';
             var formdata = {};
             var commitcheckdata = {};

             if((dataelements!= ' ') &&(dataelements.length > 0))
            {
                for(var i=0;i<fieldNameArr.length;i++)
                 {
                    //CHECK TO SEE IF ELEMEMENTS ARE REQUIRED
                     var lke = fieldNameArr[i].split("*");
                      elementfield = lke[1];
          //take care of the lots thing
          if(elementfield == 'ifbslot')
           {
             if($("#"+elementfield).val() <= 0 ){
               alertmsg("Select Lot");
               $("#"+elementfield).css('border', 'solid 3px #FFE79B');
               return false;
             }else
             {
               lots = 1;
               $("#"+elementfield).css('border', 'solid 1px #eee');
             }
           }


                      formvalue = $("#"+elementfield).val();
                         if(fieldNameArr[i].charAt(0)=="*"){
                          if(formvalue.length <= 0)
                          {
                          alertmsg('Fill Blanks'); return false;
                          }
                    }

                    else
                    {
                            elementfield = fieldNameArr[i];
                            formvalue = $("#"+elementfield).val();
                    }

                   var datatype =  $("#"+elementfield).attr('datatype');


                    switch(datatype)
                    {
                      case 'numeric':
                      if(formvalue.length > 3)
                      {
                          if (/\D/g.test(formvalue))
                          {
                          //Filter non-digits from input value.
                          formvalue =  formvalue.replace(/\D/g, '');
                          }
                                               
                      }
                      var t = $.isNumeric(formvalue);
                      if(t == true)
                      {

                      }
                      else
                      {
                        alertmsg('Enter Digits'); return false;

                      }
                      break;
                        case 'text':
                        break;
                        case 'tel':

                        if(formvalue.length > 0)
                        {
                        var valu = validatephone(formvalue);
                        if(valu == false)
                        {
                            alertmsg('Invalid Phone, Digits are allowed, Not More than 10 digits'); return false;
                         }


                        }
                        break;
                        case 'web':

                        if(formvalue.length > 0)
                        {
                        var valu = validateweb(formvalue);
                        if(valu == false)
                        {
                             alertmsg('Invalid Web Url '); return false;
                        }

                        }
                        break;
                        case 'email':

                        if(formvalue.length > 0)
                        {
                            var valu = validateemail(formvalue);
                            if(valu == false)
                            {

                                alertmsg('Ivalid Email Address'); return false;
                            }


                        }
                        break;
                        case 'phone':
                        if(formvalue.length > 0)
                        {
                        var valu = validatephone(formvalue);
                        if(valu == false)
                        {
                            alertmsg('Invalid Phone, Digits are allowed, Not More than 10 digits'); return false;
                        }

                        }
                        break;
                        default:
                        break;
                    }

                    // ADDING ELEMETNTS TO THE FORM
                    formdata[elementfield] =formvalue;
                     }
                     formdata['answered'] = receipt_ans;
                      formdata['answered_detail'] = receipt_detail;
                     formdata['btnstatus'] = btntype;
                    console.log(formdata);
            }

  //send to server
alertmsg('Proccessing ... ');

    $.ajax({
        type: "POST",
        url:  url,
        data: formdata,
        success: function(data, textStatus, jqXHR){

          if(data == 1)
          {
             alertmsg('Record Saved Succesfully');
             location.href=baseurl()+"receipts/manage_bebs";
          }else
          {
         alertmsg(data);
          console.log(data);
        }

        },
        error:function(data , textStatus, jqXHR)
        {
            console.log('Data Error'+data+textStatus+jqXHR);
            alert(data);
        }
    });




});


//bid receipt information
$( "#bidreceipt" ).submit(function(e) {
    e.preventDefault();

       var form = this;
        var formid = form.id;
        var datatype = $("#"+formid).attr('data-type');
         //action url to commit your data
        var dataaction =   $("#"+formid).attr('data-action');
        // alert(dataaction);
        // return false;
        var dataelements =   $("#"+formid).attr('data-elements');
        console.log(dataelements);
       // alert(dataelements);
          //server side checks ::--
         var serversidecheckss =  $("#"+formid).attr('data-cheks');
         //the url where you are going to use for server side checks on data
         var datacheckaction =  $("#"+formid).attr('data-check-action');

         url = dataaction;
         console.log(dataelements);
     // alert(dataelements);
     // return false;


           if(dataelements.length > 0)
            {
                var fieldNameArr=dataelements.split("<>");
            }
            else
            {
                fieldNameArr = Array();
            }

             var elementfield  ='';
             var formdata = {};
             var commitcheckdata = {};

             if((dataelements!= ' ') &&(dataelements.length > 0))
            {
                for(var i=0;i<fieldNameArr.length;i++)
                 {
                    //CHECK TO SEE IF ELEMEMENTS ARE REQUIRED
                     var lke = fieldNameArr[i].split("*");
                      elementfield = lke[1];
                      formvalue = $("#"+elementfield).val();
                         if(fieldNameArr[i].charAt(0)=="*"){
                          if(formvalue.length <= 0)
                          {
                          alertmsg('Fill Blanks'); return false;
                          }
                      }

                        else
                        {
                            elementfield = fieldNameArr[i];
                            formvalue = $("#"+elementfield).val();
                        }

                   var datatype =  $("#"+elementfield).attr('datatype');


                    switch(datatype)
                    {
                        case 'text':
                        break;
                        case 'tel':

                        if(formvalue.length > 0)
                        {
                        var valu = validatephone(formvalue);
                        if(valu == false)
                        {
                            alertmsg('Invalid Phone, Digits are allowed, Not More than 10 digits'); return false;
                        }


                        }
                        break;
                        case 'web':

                        if(formvalue.length > 0)
                        {
                        var valu = validateweb(formvalue);
                        if(valu == false)
                        {
                             alertmsg('Invalid Web Url '); return false;
                        }

                        }
                        break;
                        case 'email':

                        if(formvalue.length > 0)
                        {
                            var valu = validateemail(formvalue);
                            if(valu == false)
                            {

                                alertmsg('Ivalid Email Address'); return false;
                            }


                        }
                        break;
                        case 'phone':
                        if(formvalue.length > 0)
                        {
                        var valu = validatephone(formvalue);
                        if(valu == false)
                        {
                            alertmsg('Invalid Phone, Digits are allowed, Not More than 10 digits'); return false;
                        }

                        }
                        break;
                        default:
                        break;
                    }

                    // ADDING ELEMETNTS TO THE FORM
                    formdata[elementfield] =formvalue;
                     }
                    console.log(formdata);
            }

console.log(url);
//return false;
            //send to server
alertmsg('Proccessing ... ');

    $.ajax({
        type: "POST",
        url:  url,
        data: formdata,
        success: function(data, textStatus, jqXHR){
          //alert(data);

          if(data == 1)
          {
            alertmsg('Record Saved Succesfully ');
            location.href=baseurl()+"receipts/manage_receipts";

          }

          else{

            var dct = data.split(":");

            if(dct[0] == 3)
            {
              alertmsg(dct[1]);
            }else
            alertmsg('Something Went Wrong Contact Site Administrator ');
          }

            console.log(data);   return false;


        },
        error:function(data , textStatus, jqXHR)
        {
            console.log('Data Error'+data+textStatus+jqXHR);
            alert(data);
        }
    });




});



//bid receipt information
$( "#bidreceipt" ).submit(function(e) {
    e.preventDefault();
       var form = this;
        var formid = form.id;
        var datatype = $("#"+formid).attr('data-type');
         //action url to commit your data
        var dataaction =   $("#"+formid).attr('data-action');
        // alert(dataaction);
        // return false;
        var dataelements =   $("#"+formid).attr('data-elements');
        console.log(dataelements);
       // alert(dataelements);
          //server side checks ::--
         var serversidecheckss =  $("#"+formid).attr('data-cheks');
         //the url where you are going to use for server side checks on data
         var datacheckaction =  $("#"+formid).attr('data-check-action');

         url = dataaction;
         console.log(dataelements);
     // alert(dataelements);
     // return false;


           if(dataelements.length > 0)
            {
                var fieldNameArr=dataelements.split("<>");
            }
            else
            {
                fieldNameArr = Array();
            }

             var elementfield  ='';
             var formdata = {};
             var commitcheckdata = {};

             if((dataelements!= ' ') &&(dataelements.length > 0))
            {
                for(var i=0;i<fieldNameArr.length;i++)
                 {
                    //CHECK TO SEE IF ELEMEMENTS ARE REQUIRED
                     var lke = fieldNameArr[i].split("*");
                      elementfield = lke[1];
                      formvalue = $("#"+elementfield).val();
                         if(fieldNameArr[i].charAt(0)=="*"){
                          if(formvalue.length <= 0)
                          {
                          alertmsg('Fill Blanks'); return false;
                          }
                      }

                        else
                        {
                            elementfield = fieldNameArr[i];
                            formvalue = $("#"+elementfield).val();
                        }

                   var datatype =  $("#"+elementfield).attr('datatype');


                    switch(datatype)
                    {
                        case 'text':
                        break;
                        case 'tel':

                        if(formvalue.length > 0)
                        {
                        var valu = validatephone(formvalue);
                        if(valu == false)
                        {
                            alertmsg('Invalid Phone, Digits are allowed, Not More than 10 digits'); return false;
                        }


                        }
                        break;
                        case 'web':

                        if(formvalue.length > 0)
                        {
                        var valu = validateweb(formvalue);
                        if(valu == false)
                        {
                             alertmsg('Invalid Web Url '); return false;
                        }

                        }
                        break;
                        case 'email':

                        if(formvalue.length > 0)
                        {
                            var valu = validateemail(formvalue);
                            if(valu == false)
                            {

                                alertmsg('Ivalid Email Address'); return false;
                            }


                        }
                        break;
                        case 'phone':
                        if(formvalue.length > 0)
                        {
                        var valu = validatephone(formvalue);
                        if(valu == false)
                        {
                            alertmsg('Invalid Phone, Digits are allowed, Not More than 10 digits'); return false;
                        }

                        }
                        break;
                        default:
                        break;
                    }

                    // ADDING ELEMETNTS TO THE FORM
                    formdata[elementfield] =formvalue;
                     }
                    console.log(formdata);
            }

console.log(url);
//return false;
            //send to server
alertmsg('Proccessing ... ');

    $.ajax({
        type: "POST",
        url:  url,
        data: formdata,
        success: function(data, textStatus, jqXHR){
          //alert(data);

          if(data == 1)
          {
            alertmsg('Record Saved Succesfully ');
            location.href=baseurl()+"receipts/manage_receipts";

          }

          else{

            var dct = data.split(":");

            if(dct[0] == 3)
            {
              alertmsg(dct[1]);
            }else
            alertmsg('Something Went Wrong Contact Site Administrator ');
          }

            console.log(data);   return false;


        },
        error:function(data , textStatus, jqXHR)
        {
            console.log('Data Error'+data+textStatus+jqXHR);
            alert(data);
        }
    });




});


// end

//working on tab select
$(".tabselction").on('click', function(event){

  var id = $(this).closest('li').attr('id');
  var dataurl =  baseurl()+$(this).closest('li').attr('dataurl');
  var datadiv =   $(this).closest('li').attr('datadiv');



  //get dataurl
  $("."+datadiv).html('Proccessing...');

  $.ajax({
                  type: "POST",
                  url:  dataurl,
                  success: function(data, textStatus, jqXHR){
                  console.log(data);
                  $("."+datadiv).html(data);

                  },
                  error:function(data , textStatus, jqXHR)
                  {
                      console.log('Data Error'+data+textStatus+jqXHR);
                      alertmsg(data);
                  }
              });


});


//handle submit events
$(".pdetypeform").on('submit', function(event){
   event.preventDefault();
	  mailesr(this);

});

//simple movervs
function mailesr(e){
cancelmsg();
 var form = e;
        var formid = form.id;
        var datatype = $("#"+formid).attr('data-type');
         //action url to commit your data
        var dataaction =   $("#"+formid).attr('data-action');
        // alert(dataaction);
        // return false;
        var dataelements =   $("#"+formid).attr('data-elements');
        console.log(dataelements);
       // alert(dataelements);
          //server side checks ::--
         var serversidecheckss =  $("#"+formid).attr('data-cheks');
         //the url where you are going to use for server side checks on data
         var datacheckaction =  $("#"+formid).attr('data-check-action');

             url = dataaction;

            if(dataelements.length > 0)
            {
                var fieldNameArr=dataelements.split("<>");
            }
            else
            {
                fieldNameArr = Array();
            }
             var elementfield  ='';
             var formdata = {};
             var commitcheckdata = {};

            if((dataelements!= ' ') &&(dataelements.length > 0))
            {
                //ITERATE THROUGH DATA ELEMENTS
                 for(var i=0;i<fieldNameArr.length;i++)
                 {
                    //CHECK TO SEE IF ELEMEMENTS ARE REQUIRED
                     var lke = fieldNameArr[i].split("*");
                      elementfield = lke[1];
                      formvalue = $("#"+elementfield).val();
                         if(fieldNameArr[i].charAt(0)=="*"){
                          if(formvalue.length <= 0)
                          {
                          alertmsg('Fill Blanks'); return false;
                          }
                      }

                        else
                        {
                            elementfield = fieldNameArr[i];
                            formvalue = $("#"+elementfield).val();
                        }

                   var datatype =  $("#"+elementfield).attr('datatype');


                    switch(datatype)
                    {
                        case 'text':
                        break;
                        case 'tel':

                        if(formvalue.length > 0)
                        {
                        var valu = validatephone(formvalue);
                        if(valu == false)
                        {
                            alertmsg('Invalid Phone, Digits are allowed, Not More than 10 digits'); return false;
                        }


                        }
                        break;
                        case 'web':

                        if(formvalue.length > 0)
                        {
                        var valu = validateweb(formvalue);
                        if(valu == false)
                        {
                             alertmsg('Invalid Web Url '); return false;
                        }

                        }
                        break;
                        case 'email':

                        if(formvalue.length > 0)
                        {
                            var valu = validateemail(formvalue);
                            if(valu == false)
                            {

                                alertmsg('Ivalid Email Address'); return false;
                            }


                        }
                        break;
                        case 'phone':
                        if(formvalue.length > 0)
                        {
                        var valu = validatephone(formvalue);
                        if(valu == false)
                        {
                            alertmsg('Invalid Phone, Digits are allowed, Not More than 10 digits'); return false;
                        }

                        }
                        break;
                        default:
                        break;
                    }

                    // ADDING ELEMETNTS TO THE FORM
                    formdata[elementfield] =formvalue;
                     }
                  console.log(formdata);

           $.ajax({
                  type: "POST",
                  url:  url,
                  data: formdata,
                  success: function(data, textStatus, jqXHR){
                  console.log(data);

                      if(data == 1){
                      alertmsg("Record Saved Succesfully");
                      location.href = baseurl()+'admin/manage_pdetypes';
                      }
                      else{
                         alertmsg(data);
                      }

                  },
                  error:function(data , textStatus, jqXHR)
                  {
                      console.log('Data Error'+data+textStatus+jqXHR);
                      alertmsg(data);
                  }
              });


    }


		}
//end

//submit form to the server
var submitf2orm = function(formdata,url){

    $.ajax({
        type: "POST",
        url:  url,
        data: formdata,
        success: function(data, textStatus, jqXHR){
//alert(data);
            return data;
            console.log(data+textStatus+jqXHR);
        },
        error:function(data , textStatus, jqXHR)
        {
            console.log('Data Error'+data+textStatus+jqXHR);
            console.log(data);
        }
    });
}
   alertmsg = function(msg){
    $(".alert").fadeOut('slow');
    $(".alert").fadeIn('slow');$(".alert").html(msg);
    scrollers();

    }
      cancelmsg = function(){
        $(".alert").fadeOut('slow');
    }


     //scroll to top ::
     var scrollers = function(){
    $('html, body').animate({scrollTop : 0},800);
     }



// MANAGE DELETE RESORE AND UPDATE FUC
$('.savedelpdetype').on('click', function(){


    var decider = this.id;
    var idq =  decider.split('_');

     switch(idq[0])
     {
        case 'savedelpdetype':
        url = baseurl()+'pdetypes/delpdetype_ajax/archive/'+idq[1];
        console.log(url);

        var b = confirm('You Are About to Delete a Record')
        if(b == true){
         var rslt = ajx_delete(url,decider);
        }
        break;
        case 'restore':
        url = baseurl()+'pdetypes/delpdetype_ajax/restore/'+idq[1];
        console.log(url);
        var b = confirm('You Are About to Restore a Record')
        if(b == true){
         var rslt = ajx_delete(url,decider);
        }
        break;
        case 'del':
        url = baseurl()+'pdetypes/delpdetype_ajax/delete/'+idq[1];
        console.log(url);
        var b = confirm('You Are About to Paramanently Delete a Record')
        if(b == true){
         var rslt = ajx_delete(url,decider);
        }
        break;
        default:

        break;
     }

});

//level 3 update
var receiptsid = 0;
receiptsid = $("#recepid").val();
if(receiptsid > 0 ){
  $(".bebname").val(''+receiptsid+'').trigger('change');
}


});