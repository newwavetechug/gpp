<?php

class Receipts_m extends MY_Model {

    public $_tablename = 'receipts';
    public $_primary_key = 'receiptid';

	#Constructor
	function Receipts_m()
	{
		parent::__construct();
		$this->load->model('Query_reader', 'Query_reader', TRUE);
		$this->load->model('Ip_location', 'iplocator');
	}
    
//fetch providers
	/*
the
	*/
#procurement providers
	function fetchproviders($bidid =0)
	{

		$data = array('SEARCHSTRING' => ' and  bidinvitations.id = '.$bidid,'approved'=>'Y');
		$query = $this->Query_reader->get_query_by_code('fetch_receipted_providers',$data);
		#print_r($query); exit();
		$result = $this->db->query($query)->result_array();
		return $result;
		 
	}
 
	
	#When Lots 
    function findlottedproviders($post){
    if(!empty($post)){
    	$lotid = $post['lotid'];
    	$bidid = $post['bidid'];

    	$data = array('SEARCHSTRING' => ' and  bidinvitations.id = '.$bidid,'received_lots.id'=>$lotid);
	    $query = $this->Query_reader->get_query_by_code('fetch_receipts_with_lots',$data);		 
		$result = $this->db->query($query)->result_array();
		$st = "";
		$providers = "";

	foreach ($result as $key => $value) {			
    if(((strpos($value['providerid'] ,",")!== false)) &&  (preg_match('/[0-9]+/', $value['providerid'] )))
	{
		$providers  = rtrim($value['providerid'],",");
		$query = mysql_query("select * from providers where providerid in (".$providers.") ");
		$row = mysql_query("SELECT * FROM `providers` where providerid in ($providers) ") or die("".mysql_error());
	 	$provider = "";

		while($vaue = mysql_fetch_array($row))
		{
			$provider  .=strpos($vaue['providernames'] ,"0") !== false ? '' : $vaue['providernames'].' , ';
		}

		$prvider = rtrim($provider,' ,');		 
        $st .="<option value=".$value['receiptid'].">".$prvider." &nbsp [JV]  </option>";  
		#print_r($prvider);
	    }

	    else
	    {
		$query = mysql_query("select * from providers where providerid = ".$value['providerid']);
		$records = mysql_fetch_array($query);		 
        $st .= "<option value=".$value['receiptid'].">".$records['providernames']."</option>";   
	    }

		}
		return $st;
    }	

	}

	#FETCH BIDS ON A GIGEN PROCUREMENT
	function fetchreceipts($bidid = 0)
	{



		if($bidid == 0)
		{

			$data = array('SEARCHSTRING' => ' 1 and 1 and bidinvitations.id ='.$bidid );
			  $query = $this->Query_reader->get_query_by_code('view_all_bidders_list',$data);
			# print_r($query); exit();
			  $result = $this->db->query($query)->result_array();
			  return $result;
		}
		else
		{


		 $data = array('SEARCHSTRING' => ' 1 and 1 and bidinvitations.id ='.$bidid );
			  $query = $this->Query_reader->get_query_by_code('view_all_bidders_list',$data);
			 #print_r($query); exit();
			  $result = $this->db->query($query)->result_array();
			  return $result;
		}


	}
	function fetctpdereceipts($bidid=0,$approved='Y'){
			 $data = array('approved' =>  $approved,'searchstring'=>' and bidinvitations.id = '.$bidid.'  ORDER BY  receipts.dateadded  DESC');
			 $query = $this->Query_reader->get_query_by_code('fetch_receipted_providers',$data);
			# print_r($query); exit();
			  $result = $this->db->query($query)->result_array();
			  return $result;
	}

	#get bid information
	function fetchbidinformation($bidid=0)
	{
		 $data = array('SEARCHSTRING' => ' 1=1 and bidinvitations.id='.$bidid);
			  $query = $this->Query_reader->get_query_by_code('fetchbidinfo',$data);
			  #$q = mysql_query($query) or die("".mysql_error());
			 #print_r($query); exit();
			  $result = $this->db->query($query)->result_array();;
			  return $result;
	}
	function count_bids($nationality ='local',$bidid = 0)
	{
		if($nationality == 'uganda'){
		 $query = mysql_query("SELECT  COUNT(*) as sm FROM  receipts WHERE bid_id = " .$bidid." AND nationality  ='".$nationality."' ");

		}
		else
		{
		 $query = mysql_query("SELECT  COUNT(*) as sm FROM  receipts WHERE bid_id = " .$bidid." AND nationality != 'uganda' ");

		}

	       $result  = mysql_fetch_array($query);
	       return $result;
	}

	 
	#save bidreceipt
	 function savebidreceipt($post)
	{
			$procurementrefno = $post['procurementrefno'];
			$nationality = $post['nationality'];
			$servicep_lead  = 0;

			if(!empty($post['jv']))
			{

		  	$providers =  '';
			  #print_r($post['jv']);
		  	$providerlead = $post['pr'];

			foreach($post['jv'] as $key => $value)
			{
				$serviceprovider = '';
				//print_r($key.'___');
				$prvider = explode('_',$key);
				$srvprov = $prvider[0];
				$serviceprovider = 0;
				if(	$srvprov =='serviceprovider')
				{
				$serviceprovider = $value;
				//print_r($serviceprovider); exit();
				}
				 $query = 0;
			  //if($serviceprovider > 0)
	 		  $query = mysql_query("SELECT * FROM providers where providernames  like '".$serviceprovider."'  limit 1") or die("".mysql_error());



		$providenms  ='';
		if(mysql_num_rows($query) > 0)
		{
			while ($res = mysql_fetch_array($query)) {
				# code...
				$providerid = $res['providerid'];
				$providenms = $res['providernames'];
				$providers .=  $providerid.',';
			}
			if($serviceprovider == $providerlead){
				 $servicep_lead = $res['providerid'];
	  	}

		}
		else{
			if(($serviceprovider != 0) || ($serviceprovider != '') || ($serviceprovider != '0'))
			{
			// usual procedure ::
			$query = mysql_query("INSERT INTO providers(providernames) values ('".$serviceprovider."') ") or die("".mysql_error());
			$providerid = mysql_insert_id();
			$providers .=  $providerid.',';

			#check if this is a project lead ::
			if($serviceprovider == $providerlead){
				 $servicep_lead = 	$providerid;
			}

			}
	  	}

			}

		$datesubmitted = $post['datesubmitted'];
	//	$dd = explode("-", $datesubmitted);
	//	$ddat = $dd[2].'-'.$dd['1'].'-'.$dd[0];
		$datesubmitted = date("Y-m-d",strtotime($post['datesubmitted']));
		$receivedby = $post['receivedby'];
		$readoutprice = isset($post['readoutprice']) ? $post['readoutprice']: 0 ;
		$currency = isset($post['currency']) ? $post['currency'] : '' ;

		//get bid information ::
			$bidid  = 0;
		$query = mysql_query("SELECT a.* FROM bidinvitations a inner join  procurement_plan_entries b on a.procurement_id = b.id  where a.procurement_ref_no like '".$procurementrefno."' limit 1");

		while ($res = mysql_fetch_array($query)) {
			# code...
			$bidid = $res['id'];
		}

	  $randl = rand(234789,90290);
	  $rand2 = rand(90867,62726);

		$rand =  rand($randl,$rand2);

		$jv_number = "jv_".$rand;
		$nationality = $post['nationality'];


		$query =mysql_query("INSERT INTO receipts(bid_id,received_by,datereceived,nationality,joint_venture,readoutprice,currence) values('".$bidid."','".$receivedby."','".$datesubmitted."','".$nationality."','".$jv_number."','".$readoutprice."','".$currency."') ") or die("sdsds".mysql_error());
		if($query)
		{
			//get the insert ID
			$insert_id = mysql_insert_id();

			//adding bid response to a given  lot number
			if($post['lots'] > 0)
			{
			#	$receiptid = 	$insert_id;
				$ifbslot = $post['ifbslot'];
				$query = mysql_query("INSERT INTO received_lots(receiptid,lotid) VALUES('".$insert_id."','".$ifbslot."')") or die("".mysql_error());
			}

			$query = mysql_query("insert into joint_venture(jv,providers,provider_lead) values ( (select joint_venture as jv  from receipts where receiptid = '".$insert_id."'),'".$providers."','".$servicep_lead."' )") or die(".....".mysql_error());

		if(!empty($post['pricing']))
		{
			$amount = '';
			$cutt = '';
			$exchangerate = '';

			#print_r($post['jv']);
			foreach($post['pricing'] as $key => $value)
			{


				//print_r($key.'___');
				$pp = explode('_',$key);
				$ppv = $pp[0];

				if(	$ppv =='currency')
				{
				$cutt .= $value.',';
				}
				if(	$ppv =='readoutprice')
				{
				$amount .= $value.',';
				}
				if(	$ppv =='exchangerate')
				{
				$exchangerate .= $value.',';
				}


			}
			$aty = explode(',',$cutt);
			$aty2 = explode(',',$amount);
			$aty3 = explode(',',$exchangerate);
			$length = count($aty2);
			$x = 0;
			while($x < $length)
			{
				$prvider = explode('_',$key);
                $query = mysql_query("INSERT INTO  readoutprices(readoutprice,currence,exchangerate,receiptid) values ('".$aty2[$x]."','".$aty[$x]."','".$aty3[$x]."','".$insert_id."') ")or die("".mysql_error());
				$x ++;
			}




		}
		else
		{

   			$query = mysql_query("INSERT INTO  readoutprices(readoutprice,currence,receiptid) values ('".$readoutprice."','".$currency."','".$insert_id."') ")or die("".mysql_error());
		}

		// if lots get information about lots
		return 1;

		}else
		{
			return 0 ;
		}




			print_r($providers);
			exit();
		}
		else
		{
		$serviceprovider = $post['serviceprovider'];
		$nationality = $post['nationality'];

		$datesubmitted = $post['datesubmitted'];

	  $datesubmitted = date("Y-m-d",strtotime($post['datesubmitted']));
		$receivedby = $post['receivedby'];
		#$approved = $post['approved'];
	  $readoutprice = isset($post['readoutprice']) ?$post['readoutprice'] : '' ;
		$currency = isset($post['currency']) ? $post['currency'] : 0;
		// save information
		// check if name exists in the  providers table

		$query = mysql_query("SELECT * FROM providers where providernames  like '".$serviceprovider."'  limit 1") or die("".mysql_error());
		$providenms  ='';

		if(mysql_num_rows($query) > 0)
		{
			while ($res = mysql_fetch_array($query)) {
				# code...
				$providerid = $res['providerid'];
				$providenms = $res['providernames'];
			}
		}
		else{

			// usual procedure ::
			$query = mysql_query("INSERT INTO providers(providernames) values ('".$serviceprovider."') ") or die("".mysql_error());
			$providerid = mysql_insert_id();
		}
		//get bid information ::
			$bidid  = 0;
			$query = mysql_query("SELECT a.* FROM bidinvitations a inner join  procurement_plan_entries b on a.procurement_id = b.id  where a.procurement_ref_no like '".$procurementrefno."' limit 1");

		 
		while ($res = mysql_fetch_array($query)) {
			# code...
			$bidid = $res['id'];
		}

		//check to see if the provider already submitted
		$query = mysql_query("SELECT * FROM receipts WHERE  providerid = ".$providerid." and  bid_id = ".$bidid."") or die("".mysql_error());

		if(mysql_num_rows($query) > 0){
			return "3:".$providenms."Have a bid proposal existing on  Procurement Ref No - ".$procurementrefno ;
		}
			else{
		//save the bid
		$query =mysql_query("INSERT INTO receipts(bid_id,providerid,received_by,datereceived,nationality,readoutprice,currence) values('".$bidid."','".$providerid."','".$receivedby."','".$datesubmitted."','".$nationality."','".$readoutprice."','".$currency."') ") or die("".mysql_error());

		$insertid = mysql_insert_id();
	#	print_r($insertid);
		if($post['lots'] > 0)
		{

			$ifbslot = $post['ifbslot'];
			$query = mysql_query("INSERT INTO received_lots(receiptid,lotid) VALUES(".$insertid.",'".$ifbslot."')") or die("".mysql_error());
		}

		if(!empty($post['pricing']))
		{
			$amount = '';
			$cutt = '';
			$exchangerate ='';

			#print_r($post['jv']);
			foreach($post['pricing'] as $key => $value)
			{


				//print_r($key.'___');
				$pp = explode('_',$key);
				$ppv = $pp[0];

				if(	$ppv =='currency')
				{
				$cutt .= $value.',';
				}
				if(	$ppv =='readoutprice')
				{
				$amount .= $value.',';
				}
				if($ppv =='exchangerate')
				{
				$exchangerate .= $value.',';
				}


			}

			$aty = explode(',',$cutt);
			$aty2 = explode(',',$amount);
			$aty3 = explode(',',$exchangerate);

			$length = count($aty2);
			$x = 0;
			while($x < $length)
			{
				$prvider = explode('_',$key);


				$query =  mysql_query("INSERT INTO  readoutprices(readoutprice,currence,exchangerate,receiptid) values ('".$aty2[$x]."','".$aty[$x]."','".$aty3[$x]."','".$insertid."') ");
				#print_r($query); exit();

				$x ++;
			}



		}
		else
		{

 			$query = mysql_query("INSERT INTO  readoutprices(readoutprice,currence,receiptid) values ('".$readoutprice."','".$currency."','".$insertid."') ")or die("".mysql_error());
		}
		if($query)
		{


			return 1;
		}else
		{
			return 0 ;
		}
			}
	}



	}


	#save disposal bidreceipt
	 function savedisposalbidreceipt($post)
	{
			$disposalbidid = $post['disposalbid_id'];
			$nationality = $post['nationality'];
			$servicep_lead  = 0;

			if(!empty($post['jv']))
			{

		  	$providers =  '';
			  #print_r($post['jv']);
		  	$providerlead = $post['pr'];

			foreach($post['jv'] as $key => $value)
			{
				$serviceprovider = '';
				//print_r($key.'___');
				$prvider = explode('_',$key);
				$srvprov = $prvider[0];
				$serviceprovider = 0;
				if(	$srvprov =='serviceprovider')
				{
				$serviceprovider = $value;
				//print_r($serviceprovider); exit();
				}
				 $query = 0;
			  //if($serviceprovider > 0)
	 		  $query = mysql_query("SELECT * FROM providers where providernames  like '".$serviceprovider."'  limit 1") or die("".mysql_error());



		$providenms  ='';
		if(mysql_num_rows($query) > 0)
		{
			while ($res = mysql_fetch_array($query)) {
				# code...
				$providerid = $res['providerid'];
				$providenms = $res['providernames'];
				$providers .=  $providerid.',';
			}
			if($serviceprovider == $providerlead){
				 $servicep_lead = $res['providerid'];
	  	}

		}
		else{
			if(($serviceprovider != 0) || ($serviceprovider != '') || ($serviceprovider != '0'))
			{
			// usual procedure ::
			$query = mysql_query("INSERT INTO providers(providernames) values ('".$serviceprovider."') ") or die("".mysql_error());
			$providerid = mysql_insert_id();
			$providers .=  $providerid.',';

			#check if this is a project lead ::
			if($serviceprovider == $providerlead){
				 $servicep_lead = 	$providerid;
			}

			}
	  	}

			}

		$datesubmitted = $post['datesubmitted'];
	//	$dd = explode("-", $datesubmitted);
	//	$ddat = $dd[2].'-'.$dd['1'].'-'.$dd[0];
		$datesubmitted = date("Y-m-d",strtotime($post['datesubmitted']));
		$receivedby = $post['receivedby'];
		$readoutprice = isset($post['readoutprice']) ? $post['readoutprice']: 0 ;
		$currency = isset($post['currency']) ? $post['currency'] : '' ;

		//get bid information ::
		$bidid  = 0;
		/*
$query =   " select a.* from disposal_bid_invitation a    INNER JOIN disposal_record  b   ON a.disposal_record = b.id   where a.id '".$disposalbidid."' limit 1";
print_r($query); exit(); */
$query = mysql_query(" select a.* from disposal_bid_invitation a    INNER JOIN disposal_record  b   ON a.disposal_record = b.id   where a.id = '".$disposalbidid."' limit 1");




	    while ($res = mysql_fetch_array($query)) {
			# code...
			$bidid = $res['id'];
		}

		  $randl = rand(234789,90290);
		  $rand2 = rand(90867,62726);
		  $rand =  rand($randl,$rand2);
		  $jv_number = "djv_".$rand;
		  $nationality = $post['nationality'];


		$query =mysql_query("INSERT INTO disposal_receipts(bid_id,received_by,datereceived,nationality,joint_venture,readoutprice,currence) values('".$bidid."','".$receivedby."','".$datesubmitted."','".$nationality."','".$jv_number."','".$readoutprice."','".$currency."') ") or die("sdsds".mysql_error());
		
		if($query)
		{
			//get the insert ID
			$insert_id = mysql_insert_id();

			//adding bid response to a given  lot number
			if($post['lots'] > 0)
			{
			    #$receiptid = 	$insert_id;
				$ifbslot = $post['ifbslot'];
				$query = mysql_query("INSERT INTO received_lots(receiptid,lotid) VALUES('".$insert_id."','".$ifbslot."')") or die("".mysql_error());
			}

			$query = mysql_query("insert into joint_venture(jv,providers,provider_lead) values ( (select joint_venture as jv  from disposal_receipts where receiptid = '".$insert_id." limit 1'),'".$providers."','".$servicep_lead."' )") or die(".....".mysql_error());

		if(!empty($post['pricing']))
		{
			$amount = '';
			$cutt = '';
			$exchangerate = '';

			#print_r($post['jv']);
			foreach($post['pricing'] as $key => $value)
			{


				//print_r($key.'___');
				$pp = explode('_',$key);
				$ppv = $pp[0];

				if(	$ppv =='currency')
				{
				$cutt .= $value.',';
				}
				if(	$ppv =='readoutprice')
				{
				$amount .= $value.',';
				}
				if(	$ppv =='exchangerate')
				{
				$exchangerate .= $value.',';
				}


			}
			$aty = explode(',',$cutt);
			$aty2 = explode(',',$amount);
			$aty3 = explode(',',$exchangerate);
			$length = count($aty2);
			$x = 0;
			while($x < $length)
			{
				$prvider = explode('_',$key);
                $query = mysql_query("INSERT INTO  disposalreadoutprices(readoutprice,currence,exchangerate,receiptid) values ('".$aty2[$x]."','".$aty[$x]."','".$aty3[$x]."','".$insert_id."') ")or die("".mysql_error());
				$x ++;
			}




		}
		else
		{

   			$query = mysql_query("INSERT INTO  disposalreadoutprices(readoutprice,currence,receiptid) values ('".$readoutprice."','".$currency."','".$insert_id."') ")or die("".mysql_error());
		}

		// if lots get information about lots
		return 1;

		}else
		{
			return 0 ;
		}




			print_r($providers);
			exit();
		}
		else
		{
	   #print_r($post); exit();
		$serviceprovider = $post['serviceprovider'];
		$nationality = $post['nationality'];

		$datesubmitted = $post['datesubmitted'];

	  $datesubmitted = date("Y-m-d",strtotime($post['datesubmitted']));
		$receivedby = $post['receivedby'];
		#$approved = $post['approved'];
	  $readoutprice = isset($post['readoutprice']) ?$post['readoutprice'] : '' ;
		$currency = isset($post['currency']) ? $post['currency'] : 0;
		// save information
		// check if name exists in the  providers table

		$query = mysql_query("SELECT * FROM providers where providernames  like '".$serviceprovider."'  limit 1") or die("".mysql_error());
		$providenms  ='';

		if(mysql_num_rows($query) > 0)
		{
			while ($res = mysql_fetch_array($query)) {
				# code...
				$providerid = $res['providerid'];
				$providenms = $res['providernames'];
			}
		}
		else{

			// usual procedure ::
			$query = mysql_query("INSERT INTO providers(providernames) values ('".$serviceprovider."') ") or die("".mysql_error());
			$providerid = mysql_insert_id();
		}
		//get bid information ::
			$bidid  = 0;
			$query = mysql_query("select a.* from disposal_bid_invitation a    INNER JOIN disposal_record  b   ON a.disposal_record = b.id   where a.id ='".$disposalbidid."' limit 1");
			// $query = "select a.* from disposal_bid_invitation a    INNER JOIN disposal_record  b   ON a.disposal_record = b.id   where b.id = '".$disposalbidid."' limit 1";
			// print_r($query); exit();
		 
		while ($res = mysql_fetch_array($query)) {
			# code...
			$bidid = $res['id'];
		}

		//check to see if the provider already submitted
		$query = mysql_query("SELECT * FROM disposal_receipts WHERE  providerid = ".$providerid." and  bid_id = ".$bidid."") or die("".mysql_error());

		if(mysql_num_rows($query) > 0){
			return "3:".$providenms."Have a bid proposal existing on  Procurement Ref No - ".$disposalbidid ;
		}
			else{
		//save the bid
		$query =mysql_query("INSERT INTO disposal_receipts(bid_id,providerid,received_by,datereceived,nationality,readoutprice,currence) values('".$bidid."','".$providerid."','".$receivedby."','".$datesubmitted."','".$nationality."','".$readoutprice."','".$currency."') ") or die("".mysql_error());

		$insertid = mysql_insert_id();
	#	print_r($insertid);
		if($post['lots'] > 0)
		{

			$ifbslot = $post['ifbslot'];
			$query = mysql_query("INSERT INTO received_lots(receiptid,lotid) VALUES(".$insertid.",'".$ifbslot."')") or die("".mysql_error());
		}

		if(!empty($post['pricing']))
		{
			$amount = '';
			$cutt = '';
			$exchangerate ='';

			#print_r($post['jv']);
			foreach($post['pricing'] as $key => $value)
			{


				//print_r($key.'___');
				$pp = explode('_',$key);
				$ppv = $pp[0];

				if(	$ppv =='currency')
				{
				$cutt .= $value.',';
				}
				if(	$ppv =='readoutprice')
				{
				$amount .= $value.',';
				}
				if($ppv =='exchangerate')
				{
				$exchangerate .= $value.',';
				}


			}

			$aty = explode(',',$cutt);
			$aty2 = explode(',',$amount);
			$aty3 = explode(',',$exchangerate);

			$length = count($aty2);
			$x = 0;
			while($x < $length)
			{
				$prvider = explode('_',$key);


				$query =  mysql_query("INSERT INTO  disposalreadoutprices(readoutprice,currence,exchangerate,receiptid) values ('".$aty2[$x]."','".$aty[$x]."','".$aty3[$x]."','".$insertid."') ");
				#print_r($query); exit();

				$x ++;
			}



		}
		else
		{

 			$query = mysql_query("INSERT INTO  disposalreadoutprices(readoutprice,currence,receiptid) values ('".$readoutprice."','".$currency."','".$insertid."') ")or die("".mysql_error());
		}
		if($query)
		{


			return 1;
		}else
		{
			return 0 ;
		}
			}
	}



	}




	//update bid receipt
	function updatebidreceipt($post,$idx)
	{
		$procurementrefno = $post['procurementrefno'];
		$serviceprovider = $post['serviceprovider'];
		$nationality = $post['nationality'];
		$datesubmitted = $post['datesubmitted'];
		$dd = explode("-", $datesubmitted);
		$ddat = $dd[2].'-'.$dd['1'].'-'.$dd[0];
		$datesubmitted = $ddat;
		$receivedby = $post['receivedby'];
		#$approved = $post['approved'];

		// save information
		// check if name exists in the  providers table

		$query = mysql_query("SELECT * FROM providers where providernames  like '".$serviceprovider."'  limit 1") or die("".mysql_error());
		 $providenms  ='';
		if(mysql_num_rows($query) > 0)
		{
			while ($res = mysql_fetch_array($query)) {
				# code...
				$providerid = $res['providerid'];
				$providenms = $res['providernames'];
			}
		}
		else{
			$query = mysql_query("INSERT INTO providers(providernames) values ('".$serviceprovider."') ") or die("".mysql_error());
			$providerid = mysql_insert_id();
		}
		//get bid information ::
			$bidid  = 0;
		$query = mysql_query("SELECT * FROM bidinvitations where procurement_ref_no like '".$procurementrefno."' limit 1");

		while ($res = mysql_fetch_array($query)) {
			# code...
			$bidid = $res['id'];
		}

		#UPDATE BID
		$query =mysql_query("UPDATE  receipts set bid_id='".$bidid."',providerid='".$providerid."',received_by='".$receivedby."',datereceived='".$datesubmitted."',nationality='".$nationality."' where receiptid = ".$idx) or die("".mysql_error());
		if($query)
		{
			return 1;
		}else
		{
			return 0 ;
		}



	}


	// fetch receipt iformation in a given pde
	/*

	*/
	function pde_receipt_information($isadmin ='N',$userid = 0,$data){

  	if($isadmin == 'Y'){
		//	$query = $this->Query_reader->get_query_by_code('fetchproviders_pde', array('SEARCHSTRING' => ' order by receipts.dateadded DESC '));
			//$result = $this->db->query($query)->result_array();
			$result = paginate_list($this, $data, 'fetchproviders_pde', array('SEARCHSTRING' => ' order by receipts.dateadded DESC'),10);
			return $result;
		}
		else
		{
			$issactive = "Y";
			$result = paginate_list($this, $data, 'fetchproviders_pde', array('SEARCHSTRING' => '  and  users.userid ='.$userid.' and receipts.isactive = "'.$issactive.'" order by receipts.dateadded DESC'),10);

			//$query = $this->Query_reader->get_query_by_code('fetchproviders_pde', array('SEARCHSTRING' => '  and  users.userid ='.$userid.' and receipts.isactive = "'.$issactive.'" order by receipts.dateadded DESC'));
			// print_r($query); exit();
			// $result = $this->db->query($query)->result_array();
			return $result;
		}
	}

	function procurement_receipt_information($isadmin ='N',$userid = 0,$data,$procurement = 0){

/*
 $issactive = "Y";
			$result = paginate_list($this, $data, 'fetchproviders_pde', array('SEARCHSTRING' => '  and  users.userid ='.$userid.' and receipts.isactive = "'.$issactive.'" order by receipts.dateadded DESC'),10);
			*/
	 	#  $query = $this->Query_reader->get_query_by_code('fetchproviders_pde', array('SEARCHSTRING1' => ' and procurement_plan_entries.procurement_ref_no ="'.$procurement.'"   ','SEARCHSTRING2' => ' and procurement_plan_entries.procurement_ref_no ="'.$procurement.'"   '));
	 #print_r($query); exit();   
		// $result = $this->db->query($query)->result_array();
		 $result = paginate_list($this, $data, 'fetchproviders_pde', array('SEARCHSTRING1' => ' and bidinvitations.procurement_ref_no ="'.$procurement.'"   ','SEARCHSTRING2' => ' and bidinvitations.procurement_ref_no ="'.$procurement.'"   '),100);
		 return $result;

	}

		function procurement_receipt_information_jv($isadmin ='N',$userid = 0,$data,$procurement = 0){

		// $result = $this->db->query($query)->result_array();
		 $result = paginate_list($this, $data, 'fetchproviders_jv', array('SEARCHSTRING' => ' and bidinvitations.procurement_ref_no ="'.$procurement.'" order by receipts.dateadded DESC '),100);
		# print_r($result); exit();
		 return $result;

	}




function search_receipts($isadmin ='N',$userid = 0,$data,$search)
{
	 $search_string = 'and ( procurement_plan_entries.procurement_ref_no  like "%'. $search .'%" OR  providers.providernames  like "%'. $search .'%"   OR  receipts.datereceived  like "%'. $search .'%"   OR  receipts.received_by  like "%'. $search .'%" OR  receipts.dateadded  like "%'. $search .'%" OR  receipts.nationality  like "%'. $search .'%" )';

	if($isadmin == 'Y'){

			$result = paginate_list($this, $data, 'fetchproviders_pde', array('SEARCHSTRING' => ' '.$search_string.' order by receipts.dateadded DESC'),10);

			return $result;
		}
		else
		{
			$issactive = "Y";
			$result = paginate_list($this, $data, 'fetchproviders_pde', array('SEARCHSTRING' => ' '.$search_string.' and  users.userid ='.$userid.' and receipts.isactive = "'.$issactive.'" order by receipts.dateadded DESC'),10);
			return $result;
		}
}
/*
 array('SEARCHSTRING1' => ' and procurement_plan_entries.procurement_ref_no ="'.$procurement.'"   ','SEARCHSTRING2' => ' and bidinvitations.procurement_ref_no ="'.$procurement.'"   ') */
	function fetch_unsuccesful_bidders($receiptid=0,$bidid =0){
		 	$query = $this->Query_reader->get_query_by_code('fetchproviders_pde', array('SEARCHSTRING1' => ' and  receipts.bid_id ='.$bidid.' and receipts.receiptid !='.$receiptid.'','limittext' => '','SEARCHSTRING2' => ' and  receipts.bid_id ='.$bidid.' and receipts.receiptid !='.$receiptid.''));
			# print_r($query); exit();
		 	$result = $this->db->query($query)->result_array();
		 	return $result;
	}

	function publishbeb($post)
	{
		#print_r($post); exit();
		$lotid = 0;
		if(isset($post['ifbslot']))
		{
			$lotid =  mysql_real_escape_string($post['ifbslot']);
			if(empty($lotid))
			{
             return "3: Select Lot"; 
			}
			 
		}
		
	/*random generator */
	$var1 = 1234567890;
        $var2 = 6723566799;
        $serialnumber = rand($var1,$var2);
        /* end */

             $pdeid = $this->session->userdata('pdeid'); 
            $pdes = $this->db->query("select * from pdes where pdeid=".$pdeid." limit 1 ")->result_array();
            $abbr = $pdes[0]['abbreviation'];
            $abbr .= $serialnumber; 
           

		$pid = mysql_real_escape_string($post['pid']);
        $procurementrefno = mysql_real_escape_string($post['procurementrefno']);
		$evaluationmethod = mysql_real_escape_string($post['evaluationmethods']);
		$dob_commencement = mysql_real_escape_string($post['dob_commencement']);
		$time = strtotime($dob_commencement);
		$dob_commencement = date('Y-m-d',$time);
		$num_bids = mysql_real_escape_string($post['num_bids']);
		$dob_evaluation = mysql_real_escape_string($post['dob_evaluation']);
		$time = strtotime($dob_evaluation);
		$dob_evaluation = date('Y-m-d',$time);
		$dob_cc = mysql_real_escape_string($post['dob_cc']);
		$time = strtotime($dob_cc);
		$dob_cc = date('Y-m-d',$time);


		//$dob_cc = $dss[2].'-'. $dss[1].'-'. $dss[0];
		$bebname = mysql_real_escape_string($post['bebname']);
		$beb_nationality = mysql_real_escape_string($post['beb_nationality']);
		$contractprice = mysql_real_escape_string($post['contractprice']);
		$currency = mysql_real_escape_string($post['currence']);
		$bidid =   mysql_real_escape_string($post['bidid']);
		$ispublished = mysql_real_escape_string($post['btnstatus']) == 'publish' ? 'Y' : 'N';
		#$revviewed = mysql_real_escape_string($post['btnstatus']) == 'publish' ? 'Y' : 'N';
		$numorblocal = mysql_real_escape_string($post['num_bids_local']);


		$data = $this->session->all_userdata();
		$author = $data['userid'];
		//evaluationmethod
		$var = $this->session->userdata;

		$bebid ='';
		if((isset($var['bebid'] )) && (!empty($var['bebid'])))
		{
			$bebid = $var['bebid'];
		}

 		   $data = array(
           'pid' => $bebname,
           'bidid' => $bidid,
           //'create_date' => NOW(),// current date time stamp
           'evaluationmethod' => $evaluationmethod, // get the currently logged in session :: user id
           'dateofcommencement' => $dob_commencement,
           'numbids' => $num_bids,
           'dobevaluation' => $dob_evaluation,
           'datecc' => $dob_cc,
           'bebname' => $bebname,
           'bebnationality' => $beb_nationality,
           'contractprice' => $contractprice,
           'currency' => $currency,
           'author' => $author,
		   'ispublished' => $ispublished,
		   'bebid' => $bebid,
		   'lot' => $lotid,
		   'numorblocal' => $numorblocal,
		   'serialnumber' => $abbr 
        	);


		#updatebeb
		if((isset($var['bebid'] )) && (!empty($var['bebid']))){
		$query = $this->Query_reader->get_query_by_code('updatebeb',  $data);
		$result = $this->db->query($query);
		$this->session->unset_userdata('bebid');
		}
		else{
        $query = $this->Query_reader->get_query_by_code('insertbeb',  $data);
        $result = $this->db->query($query);
		}

	     //$query = mysql_query("INSERT INTO bestevaluatedbidder(pid,bidid,type_oem,ddate_octhe,num_orb,date_oce_r,date_oaoterbt_cc,bebid,nationality,contractprice,currency,author) values('".$pid."','".$bidid."','".$evaluationmethod."','".$dob_commencement."',
	     //'".$num_bids."','".$dob_evaluation."','".$dob_cc."','".$bebname."','".$beb_nationality."','".$contractprice."','".$currency."','".$author."') ") or die("".mysql_error());
	     // after saving update the receipts information ::
		 //update receipts set beb =  N or Y depending ..
		$query = mysql_query("UPDATE receipts set beb ='Y'  where receiptid = $bebname  and bid_id = $bidid") or die("".mysql_error());
		$query = mysql_query("UPDATE receipts set beb ='N' where receiptid != $bebname  and bid_id = $bidid") 	or die("".mysql_error());
  	// then get the list and update  the list


	//answerd: reason why not successful
	if(!empty($post['answered'])){
	$answerd = $post['answered'];
	foreach ($answerd as $key => $value) {
		# update the questionaire for everu single entry
		$query  = mysql_query("UPDATE receipts set reason = '".$value."' where receiptid = ".$key) or die("".mysql_error());
		}
	}

		if(!empty($post['answered_detail'])){
	$answerd = $post['answered_detail'];
	foreach ($answerd as $key => $value) {
		# update the questionaire for everu single entry
		$query  = mysql_query("UPDATE receipts set reason_detail = '".$value."' where receiptid = ".$key) or die("".mysql_error());
		}
	}

	
		return 1;

	}

	//disposal function 
	function disposalpublishbeb($post)
	{
		#print_r($post); exit();
		$lotid = 0;
		if(isset($post['ifbslot']))
		{
			$lotid =  mysql_real_escape_string($post['ifbslot']);
			if(empty($lotid))
			{
             return "3: Select Lot"; 
			}
			 
		}


		$pid = mysql_real_escape_string($post['pid']);
        $disposaltrefno = mysql_real_escape_string($post['disposaltrefno']);
		$evaluationmethod = mysql_real_escape_string($post['evaluationmethods']);
		$dob_commencement = mysql_real_escape_string($post['dob_commencement']);
		$time = strtotime($dob_commencement);
		$dob_commencement = date('Y-m-d',$time);
 		$num_bids = 0;
		$dob_evaluation = mysql_real_escape_string($post['dob_evaluation']);
		$time = strtotime($dob_evaluation);
		$dob_evaluation = date('Y-m-d',$time);
		$dob_cc = mysql_real_escape_string($post['dob_cc']);
		$time = strtotime($dob_cc);
		$dob_cc = date('Y-m-d',$time);
		$dob_cc_award =$post['dob_cc_award'];
		$dob_cc_award = date('Y-m-d',strtotime($dob_cc_award));


		//$dob_cc = $dss[2].'-'. $dss[1].'-'. $dss[0];
		$bebname = mysql_real_escape_string($post['bebname']);
		$beb_nationality = mysql_real_escape_string($post['beb_nationality']);
		$contractprice = mysql_real_escape_string($post['contractprice']);
		$currency = mysql_real_escape_string($post['currence']);
		$bidid =   mysql_real_escape_string($post['bidid']);
		$ispublished = mysql_real_escape_string($post['btnstatus']) == 'publish' ? 'Y' : 'N';
		#$revviewed = mysql_real_escape_string($post['btnstatus']) == 'publish' ? 'Y' : 'N';
		$numorblocal = 0;


		$data = $this->session->all_userdata();
		$author = $data['userid'];
		//evaluationmethod
		$var = $this->session->userdata;

		$bebid ='';
		if((isset($var['bebid'] )) && (!empty($var['bebid'])))
		{
			$bebid = $var['bebid'];
		}

 		   $data = array(
           'pid' => $bebname,
           'bidid' => $bidid,
           //'create_date' => NOW(),// current date time stamp
           'evaluationmethod' => $evaluationmethod, // get the currently logged in session :: user id
           'dateofcommencement' => $dob_commencement,
           'numbids' => $num_bids,
           'dobevaluation' => $dob_evaluation,
           'datecc' => $dob_cc,
           'bebname' => $bebname,
           'bebnationality' => $beb_nationality,
           'contractprice' => $contractprice,
           'currency' => $currency,
           'author' => $author,
		   'ispublished' => $ispublished,
		   'bebid' => $bebid,
		   'lot' => $lotid,
		   'numorblocal' => $numorblocal,
		   'dobccaward' => $dob_cc_award
        	);

 
		#updatebeb
		if((isset($var['bebid'] )) && (!empty($var['bebid']))){
		$query = $this->Query_reader->get_query_by_code('updatebeb',  $data);
		$result = $this->db->query($query);
		$this->session->unset_userdata('bebid');
		}
		else{
        $query = $this->Query_reader->get_query_by_code('insertbebdisposal',  $data);
        $result = $this->db->query($query);
		}

	     //$query = mysql_query("INSERT INTO bestevaluatedbidder(pid,bidid,type_oem,ddate_octhe,num_orb,date_oce_r,date_oaoterbt_cc,bebid,nationality,contractprice,currency,author) values('".$pid."','".$bidid."','".$evaluationmethod."','".$dob_commencement."',
	     //'".$num_bids."','".$dob_evaluation."','".$dob_cc."','".$bebname."','".$beb_nationality."','".$contractprice."','".$currency."','".$author."') ") or die("".mysql_error());
	     // after saving update the receipts information ::
		 //update receipts set beb =  N or Y depending ..
		$query = mysql_query("UPDATE disposal_receipts set beb ='Y'  where receiptid = $bebname  and bid_id = $bidid") or die("".mysql_error());
		$query = mysql_query("UPDATE disposal_receipts set beb ='N' where receiptid != $bebname  and bid_id = $bidid") 	or die("".mysql_error());
  	// then get the list and update  the list


	//answerd: reason why not successful
	if(!empty($post['answered'])){
	$answerd = $post['answered'];
	foreach ($answerd as $key => $value) {
		# update the questionaire for everu single entry
		$query  = mysql_query("UPDATE receipts set reason = '".$value."' where receiptid = ".$key) or die("".mysql_error());
		}
	}
		return 1;

	}
	//end disposal 

	//function fetch receipts based on receipt id

	function fetchreceiptid($receiptid){
	$query = mysql_query("SELECT a.*,b.providernames FROM receipts as a inner join providers  as b  on a.providerid  = b.providerid inner join bidinvitations as c on  a.bid_id = c.id   where a.receiptid = ".$receiptid) or die("".mysql_error());
	return $query;
	}

	  function remove_restore_receipt($type,$receiptid){

    	switch ($type) {
    		case 'restore':
    			# code...
    		 $query = $this->Query_reader->get_query_by_code('archive_restorereceipts', array('ID'=>$receiptid,'STATUS' => 'Y' ));
			$result = $this->db->query($query);
			if($result)
			 	return 1;

    			break;
    	    case 'archive':
    	    $query = $this->Query_reader->get_query_by_code('archive_restorereceipts', array('ID'=>$receiptid,'STATUS' => 'N' ));
			   // print_r($query);
          $result = $this->db->query($query);
			 if($result)
			 	return 1;
			else
			 return 0;
    	    break;
    	    case 'del':
			#echo "0"; exit();
    	     $query = $this->Query_reader->get_query_by_code('delete_receipt', array('ID'=>$receiptid));

			 $result = $this->db->query($query);
			 if($result)
			 	return 1;
    	    break;
    		default:
    			# code...
    			break;
    	}

    }

    #mover codes
  function fetchbeb($data,$searchstring='')
	{
	# and bestevaluatedbidder.ispublished = "Y"  and  receipts.beb="Y" order by bestevaluatedbidder.dateadded DESC
	
	/*$query = $this->Query_reader->get_query_by_code('fetchbebs', array('SEARCHSTRING' => $searchstring.' and bestevaluatedbidder.ispublished = "Y"  and  receipts.beb="Y" order by bestevaluatedbidder.dateadded DESC','limittext' => '' ));
	 print_r($query); exit(); */
	 
         $result = paginate_list($this, $data, 'fetchbebs', array('SEARCHSTRING' => $searchstring.' and bestevaluatedbidder.ispublished = "Y"  and  receipts.beb="Y" order by bestevaluatedbidder.dateadded DESC'),10);
		 return $result;

			$issactive = "Y";
		    $result = paginate_list($this, $data, 'fetchbebs', array('SEARCHSTRING' => 'and bestevaluatedbidder.ispublished = "Y"  and  receipts.beb="Y" order by bestevaluatedbidder.dateadded DESC'),1);
			return $result;

	}
	function manage_beb_action($post)
	{
		$action = mysql_real_escape_string($post['action']);
		$bebid =  mysql_real_escape_string($post['dataid']);
		switch($action){

			// Mark and Unmark Under Review
			case 'underreview':
			$status =  mysql_real_escape_string($post['status']);
			$query = $this->db->query("UPDATE bestevaluatedbidder SET isreviewed = '".$status."'  where id=".$bebid);
			$msg = '1';
			return $msg;
			break;

			//cance BEB proccess
			case 'cancelbeb':
			$databidid =  mysql_real_escape_string($post['databidid']);
			$query = $this->db->query("DELETE FROM  bestevaluatedbidder   where id=".$bebid) or die("Manage Bebs : ".mysql_error());
			$query = $this->db->query("UPDATE receipts SET beb ='P', reason='' where bid_id=".$databidid) or die("Manage Bebs : ".mysql_error());
			$msg = '1';
			return $msg;
			break;

			case 'publishbeb':
			$status =  mysql_real_escape_string($post['status']);
			$query = $this->db->query("UPDATE bestevaluatedbidder SET ispublished = '".$status."'  where id=".$bebid);
			$msg = '1';
			return $msg;
			break;



			default:
			break;

		}
	}

	#Fetch Lots on a given Reference Number ;
	function fetchlots($procurementrefno)
	{
		$procurement = mysql_real_escape_string($procurementrefno);
		$query = $this->Query_reader->get_query_by_code('fetch_lots', array('SEARCHSTRING' => 'procurement_plan_entries.procurement_ref_no ="'.$procurement.'"','limittext' => '','orderby' => ''));
	 #print_r($query); exit();
		$result = $this->db->query($query)->result_array();
		return $result;

	}

   function fetch_disposal_receipts($bidid)
   {
		
		#$procurement = mysql_real_escape_string($procurementrefno);
		$query = $this->Query_reader->get_query_by_code('fetch_disposal_receipts', array('SEARCHSTRING' => ' where disposal_bid_invitation.id = \''.$bidid.' \' ','orderby' => ''));
	   # print_r($query); exit();
		$result = $this->db->query($query)->result_array();
		return $result;

   }   

   function count_bids_disposal($nationality ='local',$bidid = 0)
	{
		if($nationality == 'uganda'){
		 $query = mysql_query("SELECT  COUNT(*) as sm FROM  disposal_receipts WHERE bid_id = " .$bidid." AND nationality  ='".$nationality."' ");

		}
		else
		{
		 $query = mysql_query("SELECT  COUNT(*) as sm FROM  disposal_receipts WHERE bid_id = " .$bidid." AND nationality != 'uganda' ");

		}

	       $result  = mysql_fetch_array($query);
	       return $result;
	}


   function fetch_bid_information($bidid){
   	
   	   #$query = $this->Query_reader->get_query_by_code('fetch_disposal_receipts', array('SEARCHSTRING' => ' where disposal_bid_invitation.id = \''.$bidid.' \' ','orderby' => ''));
	   # print_r($query); exit();
		$result = $this->db->query("SELECT * FROM disposal_bid_invitation where disposal_bid_invitation.id = ".$bidid)->result_array();
		return $result;
   }

	//fetch unsuccessful bidders
   function fetch_disposal_unsuccessful_bidders($receiptid,$bidid)
   {
		
		#$procurement = mysql_real_escape_string($procurementrefno);
		$query = $this->Query_reader->get_query_by_code('fetch_disposal_receipts', array('SEARCHSTRING' => ' where disposal_bid_invitation.id = \''.$bidid.' \'  and  disposal_receipts.receiptid != \''.$receiptid.'\' ' ,'orderby' => ''));
	   #print_r($query); exit();
		$result = $this->db->query($query)->result_array();
		return $result;

   }
   
   
   
    function get_receipts_by_procurement_method($procurement_method_id,$from='',$to=''){

        //ifranges are set
        if($from && $to)
        {
            $results=$this->custom_query("
        SELECT
receipts.receiptid,
receipts.bid_id,
receipts.providerid,
receipts.details,
receipts.received_by,
receipts.datereceived,
receipts.approved,
receipts.nationality,
receipts.author,
receipts.dateadded,
receipts.beb,
receipts.reason,
receipts.isactive,
receipts.joint_venture,
receipts.readoutprice,
receipts.currence,
bidinvitations.procurement_id,
bidinvitations.procurement_ref_no,
bidinvitations.cost_estimate,
bidinvitations.subject_of_procurement,
bidinvitations.pde_id,
bidinvitations.id,
procurement_plan_entries.id,
procurement_plan_entries.subject_of_procurement,
procurement_plan_entries.procurement_type,
procurement_plan_entries.procurement_method,
procurement_plan_entries.pde_department,
procurement_plan_entries.funding_source,
procurement_plan_entries.funder_name,
procurement_plan_entries.procurement_ref_no,
procurement_plan_entries.estimated_amount,
procurement_plan_entries.procurement_plan_id,
procurement_plans.pde_id,
procurement_plans.title,
procurement_plans.financial_year,
procurement_plans.id,
pdes.pdeid,
pdes.pdename,
providers.providerid,
providers.providernames,
procurement_methods.title,
procurement_methods.id
FROM
receipts
INNER JOIN bidinvitations ON receipts.bid_id = bidinvitations.id
INNER JOIN procurement_plan_entries ON bidinvitations.procurement_id = procurement_plan_entries.id
INNER JOIN procurement_plans ON procurement_plan_entries.procurement_plan_id = procurement_plans.id
INNER JOIN pdes ON procurement_plans.pde_id = pdes.pdeid
INNER JOIN providers ON receipts.providerid = providers.providerid
INNER JOIN procurement_methods ON procurement_methods.id = procurement_plan_entries.procurement_method
WHERE
procurement_methods.id = " . $procurement_method_id . " AND
receipts.datereceived >= '" . $from . "' AND
receipts.datereceived <= '" . $to . "'  AND
receipts.isactive = 'Y'");
        }
        else{
            $results=$this->custom_query("
        SELECT
receipts.receiptid,
receipts.bid_id,
receipts.providerid,
receipts.details,
receipts.received_by,
receipts.datereceived,
receipts.approved,
receipts.nationality,
receipts.author,
receipts.dateadded,
receipts.beb,
receipts.reason,
receipts.isactive,
receipts.joint_venture,
receipts.readoutprice,
receipts.currence,
bidinvitations.procurement_id,
bidinvitations.procurement_ref_no,
bidinvitations.cost_estimate,
bidinvitations.subject_of_procurement,
bidinvitations.pde_id,
bidinvitations.id,
procurement_plan_entries.id,
procurement_plan_entries.subject_of_procurement,
procurement_plan_entries.procurement_type,
procurement_plan_entries.procurement_method,
procurement_plan_entries.pde_department,
procurement_plan_entries.funding_source,
procurement_plan_entries.funder_name,
procurement_plan_entries.procurement_ref_no,
procurement_plan_entries.estimated_amount,
procurement_plan_entries.procurement_plan_id,
procurement_plans.pde_id,
procurement_plans.title,
procurement_plans.financial_year,
procurement_plans.id,
pdes.pdeid,
pdes.pdename,
providers.providerid,
providers.providernames,
procurement_methods.title,
procurement_methods.id
FROM
receipts
INNER JOIN bidinvitations ON receipts.bid_id = bidinvitations.id
INNER JOIN procurement_plan_entries ON bidinvitations.procurement_id = procurement_plan_entries.id
INNER JOIN procurement_plans ON procurement_plan_entries.procurement_plan_id = procurement_plans.id
INNER JOIN pdes ON procurement_plans.pde_id = pdes.pdeid
INNER JOIN providers ON receipts.providerid = providers.providerid
INNER JOIN procurement_methods ON procurement_methods.id = procurement_plan_entries.procurement_method
WHERE
procurement_methods.id = " . $procurement_method_id . " AND
receipts.isactive = 'Y'");
        }
        return $results;
    }




    function get_receipts_by_bid($bid_id){
        $results=$this->custom_query("
        SELECT
receipts.receiptid,
receipts.bid_id,
receipts.providerid,
receipts.details,
receipts.received_by,
receipts.datereceived,
receipts.approved,
receipts.nationality,
receipts.author,
receipts.dateadded,
receipts.beb,
receipts.reason,
receipts.isactive,
receipts.joint_venture,
receipts.readoutprice,
receipts.currence,
bidinvitations.procurement_id,
bidinvitations.procurement_ref_no,
bidinvitations.cost_estimate,
bidinvitations.subject_of_procurement,
bidinvitations.pde_id,
bidinvitations.id,
procurement_plan_entries.id,
procurement_plan_entries.subject_of_procurement,
procurement_plan_entries.procurement_type,
procurement_plan_entries.procurement_method,
procurement_plan_entries.pde_department,
procurement_plan_entries.funding_source,
procurement_plan_entries.funder_name,
procurement_plan_entries.procurement_ref_no,
procurement_plan_entries.estimated_amount,
procurement_plan_entries.procurement_plan_id,
procurement_plans.pde_id,
procurement_plans.title,
procurement_plans.financial_year,
procurement_plans.id,
pdes.pdeid,
pdes.pdename,
providers.providerid,
providers.providernames
FROM
receipts
INNER JOIN bidinvitations ON receipts.bid_id = bidinvitations.id
INNER JOIN procurement_plan_entries ON bidinvitations.procurement_id = procurement_plan_entries.id
INNER JOIN procurement_plans ON procurement_plan_entries.procurement_plan_id = procurement_plans.id
INNER JOIN pdes ON procurement_plans.pde_id = pdes.pdeid
INNER JOIN providers ON receipts.providerid = providers.providerid
WHERE
receipts.bid_id = " . $bid_id . " AND
receipts.isactive = 'Y'");

        return $results;
    }




}

?>