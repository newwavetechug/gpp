<style>
    form.contract_reports .exception_control, form.contract_reports .completion_control, form.contract_reports .late_control { display:none; }
</style>
<? if(empty($requiredfields)) $requiredfields = array();?>
<form action="<?=base_url() . 'reports/invitation_for_bids_reports'?>" enctype="multipart/form-data" method="post" class="ifb_reports ">
    <div class="control-group">
        <label class="control-label">Report type<span>*</span></label>
        <div class="controls">
            <select id="ifb-report-type" class="input-large m-wrap" name="ifb_report_type" tabindex="2">
                <option selected="selected">-Select-</option>
                <option value="PIFB" <?=(!empty($formdata['ifb_report_type']) && $formdata['ifb_report_type'] == 'PIFB'? 'selected="selected"' : '' )?>>Published IFBs</option>
                <option value="IFBD" <?=(!empty($formdata['ifb_report_type']) && $formdata['ifb_report_type'] == 'IFBD'? 'selected="selected"' : '' )?>>Bid submission deadlines</option>
                <option value="BER" <?=(!empty($formdata['ifb_report_type']) && $formdata['ifb_report_type'] == 'BER'? 'selected="selected"' : '' )?>>Bid exception reports</option>
            </select>
        </div>
    </div>

    <div class="control-group exception_control" <?=(!empty($formdata['ifb_report_type']) && $formdata['ifb_report_type'] == 'BER'? 'style="display:block"' : '' )?>>
        <label class="control-label">Exception type<span>*</span></label>
        <div class="controls">
            <select id="exception-type" class="input-large m-wrap" name="exception_type" tabindex="2">                <option selected="selected">-Select-</option>

                <option value="ETT" <?=(!empty($formdata['exception_type']) && $formdata['exception_type'] == 'ETT'? 'selected="selected"' : '' )?>>Bids equal threshold period (14 days)</option>
                <option value="GTT" <?=(!empty($formdata['exception_type']) && $formdata['exception_type'] == 'GTT'? 'selected="selected"' : '' )?>>Bids greater than threshold period (14 days)</option>
                <option value="LTT" <?=(!empty($formdata['exception_type']) && $formdata['exception_type'] == 'LTT'? 'selected="selected"' : '' )?>>Bids less than threshold period (14 days)</option>
                <option value="DTC" <?=(!empty($formdata['exception_type']) && $formdata['exception_type'] == 'DTC'? 'selected="selected"' : '' )?>>Bid invitations due to close next week</option>
            </select>
        </div>
    </div>

    <?php if($this->session->userdata('isadmin') == 'Y'): ?>
        <div class="control-group">
            <label class="control-label">Select PDE <span>*</span></label>

            <div class="controls">

                <select name="pde" required=""  style="width:100%" class="populate" >

                    <optgroup label="Available PDES">
                        <option selected="" value="">Choose PDE</option>
                        <?php
                        foreach(get_active_pdes() as $pde){
                            ?>
                            <option value="<?=$pde['pdeid']?>"><?=$pde['pdename']?></option>
                        <?php
                        }
                        ?>

                    </optgroup>

                </select>
            </div>
        </div>


    <?php endif; ?>

    <div class="control-group neutral_control">
        <label class="control-label">Financial year:</label>
        <div class="controls">
            <?php
            $start_year=2010;
            $end_year=$start_year +10;
            echo financial_year_dropdown($start_year, $end_year , $id='financial_year', $class='input-large m-wrap', $selected=null)
            ?>

        </div>
    </div>

    <div class="control-group published_ifb_control" <?=(!empty($formdata['ifb_report_type']) && $formdata['ifb_report_type'] == 'PIFB'? 'style="display:block"' : '' )?>>
        <label class="control-label">Date IFB published:</label>
        <div class="controls">
            <div class="input-append date date-picker" data-date="2015-01-01" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
                <input name="ifb_from_date" data-date="2015-01-01" data-date-format="yyyy-mm-dd" data-date-viewmode="days" placeholder="From" class="m-ctrl-medium date-picker input-small" type="text" value="<?=(!empty($formdata['ifb_from_date'])? $formdata['ifb_from_date'] : '' )?>" />
                <span class="add-on"><i class="fa fa-calendar"></i></span>
            </div>
            <div class="input-append date date-picker" data-date="2015-01-01" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
                <input name="ifb_to_date"  placeholder="To" data-date="2015-01-01" data-date-format="yyyy-mm-dd" data-date-viewmode="days" class="m-ctrl-medium input-small date-picker" type="text" value="<?=(!empty($formdata['ifb_to_date'])? $formdata['ifb_to_date'] : '' )?>" />
                <span class="add-on"><i class="fa fa-calendar"></i></span>
            </div>
        </div>
    </div>

    <div class="control-group bid_submission_control" <?=(!empty($formdata['ifb_report_type']) && $formdata['ifb_report_type'] == 'IFBD'? 'style="display:block"' : '' )?>>
        <label class="control-label">Bid submission deadline:</label>
        <div class="controls">
            <div class="input-append date date-picker" data-date="2015-01-01" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
                <input name="bsd_from_date" data-date="2015-01-01" data-date-format="yyyy-mm-dd" data-date-viewmode="days" placeholder="From" class="m-ctrl-medium date-picker input-small" type="text" value="<?=(!empty($formdata['bsd_from_date'])? $formdata['bsd_from_date'] : '' )?>" />
                <span class="add-on"><i class="fa fa-calendar"></i></span>
            </div>
            <div class="input-append date date-picker" data-date="2015-01-01" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
                <input name="bsd_to_date"  placeholder="To" data-date="2015-01-01" data-date-format="yyyy-mm-dd" data-date-viewmode="days" class="m-ctrl-medium input-small date-picker" type="text" value="<?=(!empty($formdata['bsd_to_date'])? $formdata['bsd_to_date'] : '' )?>" />
                <span class="add-on"><i class="fa fa-calendar"></i></span>
            </div>
        </div>
    </div>



    <div style="display: none;" class="my_datepicker">
        <div  class="control-group ">
            <label class="control-label">Bid Exception range:</label>
            <div class="controls">
                <div class="input-append date date-picker" data-date="2015-01-01" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
                    <input name="ber_from_date" data-date="2015-01-01" data-date-format="yyyy-mm-dd" data-date-viewmode="days" placeholder="From" class="m-ctrl-medium date-picker input-small" type="text" value="<?=(!empty($formdata['ber_from_date'])? $formdata['ber_from_date'] : '' )?>" />
                    <span class="add-on"><i class="fa fa-calendar"></i></span>
                </div>
                <div class="input-append date date-picker" data-date="2015-01-01" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
                    <input name="ber_to_date"  placeholder="To" data-date="2015-01-01" data-date-format="yyyy-mm-dd" data-date-viewmode="days" class="m-ctrl-medium input-small date-picker" type="text" value="<?=(!empty($formdata['ber_to_date'])? $formdata['ber_to_date'] : '' )?>" />
                    <span class="add-on"><i class="fa fa-calendar"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <button type="submit" name="view" value="view-report" class="btn blue"><i class="fa fa-ok"></i> View report</button>

    </div>
</form>
<script>
    $(document).ready(function(){
        //by default hide the ber date picker
        //id there is a change in reporttype dropdwon


        $('#ifb-report-type').change(function(){
           //if chage is BER reveal dropdown
            if($('#ifb-report-type').val()=='BER'){
                $('.my_datepicker').hide('slow');
            }



        });

        //when reports due next week are choses
        $('#exception-type').change(function(){
            if($('#exception-type').val()=='DTC'){
                $('.my_datepicker').hide('slow');
            }else{
                //otherwise hide
                $('.my_datepicker').show('slow');
            }

        });

    });
</script>