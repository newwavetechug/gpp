<? $procurement_details = $formdata['procurement_details']; ?>
<div class="page-header col-lg-offset-2" style="margin:0">
    <h3>Tender Details</h3>
     <a href="<?=base_url().'page/home'; ?>" class="btn btn-default bet"> Return to Current Tenders</a>
    <a class=" btn btn-default print"   style='cursor:pointer;'><i class="fa fa-print  fa-1x">Print</i></a>
</div>
<div class="row clearfix current_tenders printarea">
    <div class="column">
        <div class="widget-body" style="   ">            
        
        <div id="doc-wrapper">
            <div class="row-fluid" style="text-align:center; font-weight:700; font-size:14px">
                <div class="col-md-13">
                    <?=strtoupper('BID NOTICE UNDER ' . $procurement_details['procurement_method'])?>
                </div>
            </div>
            
            <div id="doc-content" style="font-size:14px">
                <div class="row-fluid">
                    <div class="col-md-13"><?=$procurement_details['pdename']?></div>
                </div>
                
                <div class="row-fluid">
                    <div class="col-md-13"><?=custom_date_format('d M, Y', $formdata['invitation_to_bid_date'])?></div>
                </div>
                
                <div class="row-fluid">
                    <div class="col-md-13">
                        <?=$procurement_details['subject_of_procurement']. ' - ' .$procurement_details['procurement_ref_no']?>
                    </div>
                </div>
                
                <div class="row-fluid">
                    <div class="col-md-12">
                        <ul class="ifb-doc-list">
                            <li><?=$procurement_details['pdename']?> has <?=(($procurement_details['funding_source'] == 1)? 'allocated funds' : 'received funds ' . (empty($procurement_details['funder_name'])? '' : ' from ' .$procurement_details['funder_name']))?> to be used for the acquisition of <?=$procurement_details['subject_of_procurement']?></li>
                            
                            <li>The Entity invites sealed bids from eligible bidders for the provision of the above supplies</li>
                            
                            <li>Bidding will be conducted in accordance with the open <?=$procurement_details['procurement_method']?> method contained in the Public Procurement and Disposal of Public Assets Act, 2003, and is open to all bidders.</li>
                            
                            <li>Interested eligible bidders may obtain further information and inspect the bidding documents at the address given below at 8(a) from [insert office hours].</li>
                            
                            <li>The Bidding documents in English may be purchased by interested bidders on the submission of a written application to the address below at 8(b) and upon payment of a non-refundable fee of <?=add_commas($formdata['bid_documents_price'], 0) . ' ' .strtoupper($formdata['bid_documents_currency'])?>. The method of payment will be [insert method of payment]</li>
                            
                            <li>Bids must be delivered to the address below at 8(c) at or before <?=custom_date_format('l, d M, Y h:i A', $formdata['bid_submission_deadline'])?>. 
                            
                            <?php if(!empty($formdata['bid_security_amount'])): ?>
                            All bids must be accompanied by a bid security of <?=((is_numeric($formdata['bid_security_amount']))? add_commas($formdata['bid_security_amount'], 0) : $formdata['bid_security_amount']) . ' ' .strtoupper($formdata['bid_security_currency'])?> or a bid securing declaration. Bid securities or bid securing declarations must be valid until (insert day, month and year). 
                            <?php endif; ?>
                            Late bids shall be rejected. Bids will be opened in the presence of the bidders' representatives who choose to attend at the address below at 8(d) on <?=custom_date_format('l, d M, Y', $formdata['bid_openning_date']) . ' at ' .custom_date_format('h:i A', $formdata['bid_openning_date'])?></li>
                            
                            <li>
                            <?php if(!empty($formdata['pre_bid_meeting_date'])): ?>
                            There shall be a pre - bid meeting on <?=custom_date_format('l, d M, Y', $formdata['pre_bid_meeting_date']) . ' at ' .custom_date_format('h:i A', $formdata['pre_bid_meeting_date'])?>
                            
                            <?php else: ?>
                            There shall not be a pre - bid meeting
                            <?php endif; ?>
                            </li>
                            
                            <li>
                                <table>
                                    <tr>
                                        <td>(a)</td>
                                        <td align="left">Documents may be inspected at:</td>
                                        <td><?=$formdata['documents_inspection_address']?></td>
                                    </tr>
                                    <tr>
                                        <td>(b)</td>
                                        <td align="left">Documents will be issued from:</td>
                                        <td><?=$formdata['documents_address_issue']?></td>
                                    </tr>
                                    <tr>
                                        <td>(c)</td>
                                        <td align="left">Bids must be delivered to:</td>
                                        <td><?=$formdata['bid_receipt_address']?></td>
                                    </tr>
                                    <tr>
                                        <td>(d)</td>
                                        <td align="left">Address of bid openning:</td>
                                        <td><?=$formdata['bid_openning_address']?></td>
                                    </tr>
                                </table>
                            </li>
                            
                            <li>
                                <div>The planned procurement schedule (subject to changes) is as follows:</div>
                                <table cellpadding="4" border="1">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Activity</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td>a.</td>
                                        <td>Publish bid notice</td>
                                        <td>
                                            <?=custom_date_format('l, d M, Y', $formdata['invitation_to_bid_date'])?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>b.</td>
                                        <td>Pre-bid meeting where applicable</td>
                                        <td><?=custom_date_format('l, d M, Y h:i A', $formdata['pre_bid_meeting_date'])?></td>
                                    </tr>
                                    <tr>
                                        <td>c.</td>
                                        <td>Bid closing date </td>
                                        <td><?=custom_date_format('l, d M, Y h:i A', $formdata['bid_submission_deadline'])?></td>
                                    </tr>
                                    <tr>
                                        <td>d.</td>
                                        <td>Evaluation process</td>
                                        <td><?='From ' . custom_date_format('l, d M, Y', $formdata['bid_evaluation_from']) . ' to '. custom_date_format('l, d M, Y', $formdata['bid_evaluation_to'])?></td>
                                    </tr>
                                    <tr>
                                        <td>e.</td>
                                        <td>Display and communication of best evaluated bidder notice</td>
                                        <td><?=custom_date_format('l, d M, Y', $formdata['display_of_beb_notice'])?></td>
                                    </tr>
                                    <tr>
                                        <td>f.</td>
                                        <td>Contract award and signature</td>
                                        <td><?=custom_date_format('l, d M, Y', $formdata['contract_award_date'])?></td>
                                    </tr>
                                </table>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
         </div>        
    </div>
    <a href="<?=base_url().'page/home'; ?>" class="btn btn-default bet"> Return to Current Tenders</a>
    <?php
         $url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."";

            print  ''.
                    '&nbsp;<a href="https://twitter.com/share" class="twitter-share-button  " data-url="'.$url.'" data-size="small" data-hashtags="tenderportal_ug" data-count="none" data-dnt="none"></a> &nbsp; <div class="g-plusone" data-action="share" data-size="medium" data-annotation="none" data-height="24" data-href="'.$url.'"></div>&nbsp;<div class="fb-share-button" data-href="'.$url.'" data-layout="button" data-size="medium"></div>'
         
         ?>
    </div>
</div>