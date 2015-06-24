<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BEB NOTICE</title>
<script src="<?=base_url()?>js/jquery.PrintArea.js" type="text/JavaScript" language="javascript"></script>      
<link type="text/css" rel="stylesheet" href="<?=base_url()?>js/PrintArea.css" />
  <script type="text/javascript">
   $(function(){

    //print functionality in the header
    $('.print').click(function(){
        //alert('Ready to Print');
        w = window.outerWidth-10;
        $(".printarea").css("width", '100%');
        $(".printarea").printArea();
         });
})
    </script>

</head>

<body>

 <style> 
  body{padding:0px;}
  #wrappers {  width:900px; margin: auto; }
  #wrappers .headers{   text-align:center;  }
    #bebnotice-table {  border: solid thin;  border-collapse: collapse;}
#bebnotice-table caption {  padding-bottom: 0.5em;}#bebnotice-table th,#bebnotice-table td {  border: solid thin;
  padding: 0.5rem 2rem;}#bebnotice-table td {  white-space: nowrap;}
#bebnotice-table tbody td:first-child::after {  content: leader(". "); '}
body {  padding: 1rem;} </style>
<div class = "wrappers printarea" id="wrappers">

  <?php
#  print_r($beb);
  ?>
<H1 class="headers"> BEST EVALUATED BIDDER NOTICE</H1>
<p>
The Bidder  name below  has been evaluated  as the best evaluated bidder  for the  procurement of  equipment detailed below.  It is the intention of  the Procuring  and Disposing Entity to place  a contract  with the bidder  named after ten working days from the date for  the display  given below

</p>
<table width="100%" border="1" id="bebnotice-table">
  <tr>
    <th width="56%" align="left" scope="row">Procurement Reference Number:</th>
    <td width="44%"><?=$beb['page_list'][0]['procurement_ref_no']; ?></td>
  </tr>
  <tr>
    <th align="left" scope="row">Subject of Procurement</th>
    <td><?=$beb['page_list'][0]['subject_of_procurement']; ?></td>
  </tr>
  <tr>
    <th align="left" scope="row">Method of Procurement</th>
    <td><?=$beb['page_list'][0]['procurementmethod']; ?> </td>
  </tr>
  <tr>
    <th align="left" scope="row">Best Evaluated Bidder Names</th>
    <td>
      <?php
      $provider = rtrim($beb['page_list'][0]['providers'],',');
      $result =   $this-> db->query("SELECT providernames FROM providers where providerid in(".$provider.")")->result_array();

      $providerlist = '';
      $x = 0;
      foreach($result as $key => $record){
        $providerlist .= $x > 0 ? $record['providernames'].',' : $record['providernames'];
        $x ++ ;
      }

      $providerlists = ($x > 1 )? rtrim($providerlist,',').' <span class="label label-info">Joint Venture</span> ' : $providerlist;
      print $providerlists;




      ?></td>
  </tr>

</table>
<br/>
<table  width="100%" border="1" id="bebnotice-table">
  <tr>
    <th width="56%" align="left" scope="row">Date of Display</th>
    <td width="44%"><?=date("Y-M-d",strtotime($beb['page_list'][0]['dateadded']))?></td>
  </tr>
  <tr>
    <th align="left" scope="row">Date of Removal</th>
    <td><?php
      echo date("Y-M-d",strtotime($beb['page_list'][0]['dateadded']) + (60*60*24*10))?></td>
  </tr>
</table>
<p>
<h1> Unsuccesful Bidders </h1>
</p>
<?php
$unsuccesful_bidders = mysql_query("select * from receipts where bid_id=".$beb['page_list'][0]['bid_id']." and beb != 'Y' ") or die("".mysql_error());
if(mysql_num_rows($unsuccesful_bidders) > 0)
{

?>

<table  width="100%" border="1" id="bebnotice-table">
  <tr>
   <th> # </th>
    <th align="left" scope="row">NAME OF THE BIDDER</th>
    <th>REASON FOR BEING UNSUCCESSFUL</th>
  </tr>

<?php
while($row = mysql_fetch_array($unsuccesful_bidders))
{

  $provider = $row['providerid'] > 0 ? $row['providerid'] : mysql_fetch_array(mysql_query("select providers from joint_venture where jv = '".$row['joint_venture']."' limit 1"));

?>
  <tr>
   <td> </td>
    <td align="left" scope="row"> <?php
    if( $row['providerid']  > 0 )
    {
    $provder =   mysql_query("select * from providers where providerid = ".$row['providerid']."") or die("".mysql_error());
    $addition = '';
   }else
     {
    $provder=    mysql_query("select * from providers where providerid in (".rtrim($provider['providers'],", ").")") or die("".mysql_error());
    $addition = '<span class="label label-info">Joint Venture</span>';
    }
     $p_record = '';
     while($rows = mysql_fetch_array($provder))
     {
       $p_record .=$rows['providernames'].',';
     }
      print_r(rtrim($p_record,',').$addition);
     ?>
     </td>
    <td><?=$row['reason']; ?>
    <br/>
    <?=$row['reason_detail']; ?>
    </td>
  </tr>
  <?php } ?>
</table>
<?php
}
else
{
  echo "No Unsuccessful Bidders";
}
?>
<label style="font-size:15px;">
Serial Number : <?=$beb['page_list'][0]['seerialnumber'];?>
</label>
</div>
 
</body>
</html>