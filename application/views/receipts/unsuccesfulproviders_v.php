<?php


#print_r($unsuccesful_bidders);

			?>
					<table class="table table-striped" id="sample_1">
				<thead>
					<tr>
						<th>
							#
						</th>
						<th>
							Bidders Name
						</th>
						<th>
							Country of Origin 
						</th>
						<th>
							Reason
						</th>
						
						 


					</tr>
				</thead>
				<tbody>

					<?php
					$x = 0;
					foreach ($unsuccesful_bidders as $key => $value) {
						# code...
						$x ++;
						?>
						<tr id="<?=$value['receiptid'] ?>" dataid="<?=$value['receiptid'] ?>">
						<td>
						 <?= $x; ?> 
						</td>
						<td>
                        
                                        <?php 
						
					//	print_r($value['providers']);
					//if (strpos($a,',') !== false)
	 	if(((strpos($value['providernames'] ,",")!== false)) || (preg_match('/[0-9]+/', $value['providernames'] )))
					{
						$providers  = rtrim($value['joint_venture'],",");
						//print_r($providers);
	 	$row = mysql_query("SELECT * FROM `providers` where providerid in ($providers) ") or die("".mysql_error());
		//print_r($row);
		 
	$provider = "";
		while($vaue = mysql_fetch_array($row))
		{
			$provider  .=strpos($vaue['providernames'] ,"0") !== false ? '' : $vaue['providernames'].' , ';
		}
		$prvider = rtrim($provider,' ,');
		print_r($prvider.'&nbsp; <span class="label label-info">Joint Venture</span>' );   
					}
					else
					{		 echo $value['providernames'];
					}
					?>	
						
						</td>
						<td>
							 <?=$value['nationality'] ?> 
						</td>
						<td>
							<select class="span12 " data-placeholder="Nationality" tabindex="1" onChange="javascript:reason(this.value,<?=$value['receiptid'] ?>,'beb_<?=$x; ?>')">
							   <option value="0">Select Reason </option>
							   <option value="Administrative" >Administrative</option>
                                 <option value="Technical" >Technical</option>
                                   <option value="Price" >Price</option>											 
							 </select> 
							 <input type="text" onChange="javascript:reasondetail(this.value,<?=$value['receiptid'] ?>);" class="span12" placeholder="Reason" id="beb_<?=$x; ?>">
						</td>
					</tr>
						<?php
					}

					?>
					


</table>