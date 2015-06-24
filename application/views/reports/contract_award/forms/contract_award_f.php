<style>
    form.contract_reports .exception_control, form.contract_reports .completion_control, form.contract_reports .late_control { display:none; }
</style>
<? if(empty($requiredfields)) $requiredfields = array();?>
<!-- BEGIN FORM-->
<form action="<?=current_url()?>" enctype="multipart/form-data" method="post" class="contract_reports ">
    <div class="control-group">
        <label class="control-label">Report type<span>*</span></label>
        <div class="controls">
            <select id="contracts-report-type" class="input-large m-wrap" name="contracts_report_type" tabindex="2">
                <option selected="selected">-Select-</option>
                <option value="AC" <?=(!empty($formdata['contracts_report_type']) && $formdata['contracts_report_type'] == 'AC'? 'selected="selected"' : '' )?>>Awarded contracts</option>
                <option value="CDC" <?=(!empty($formdata['contracts_report_type']) && $formdata['contracts_report_type'] == 'CDC'? 'selected="selected"' : '' )?>>Contracts due for completion</option>
                <option value="CC" <?=(!empty($formdata['contracts_report_type']) && $formdata['contracts_report_type'] == 'CC'? 'selected="selected"' : '' )?>>Completed Contracts</option>
                <option value="LC" <?=(!empty($formdata['contracts_report_type']) && $formdata['contracts_report_type'] == 'LC'? 'selected="selected"' : '' )?>>Time elapsed contracts</option>
            </select>
        </div>
    </div>

    <div class="control-group exception_control" <?=(!empty($formdata['beb_report_type']) && $formdata['beb_report_type'] == 'BER'? 'style="display:block"' : '' )?>>
        <label class="control-label">Exception type<span>*</span></label>
        <div class="controls">
            <select id="exception-type" class="input-large m-wrap" name="exception_type" tabindex="2">
                <option selected="selected">-Select-</option>
                <option value="ETET" <?=(!empty($formdata['exception_type']) && $formdata['exception_type'] == 'ETET'? 'selected="selected"' : '' )?>>Evaluation times exceeding threshhold</option>
                <option value="BATSP" <?=(!empty($formdata['exception_type']) && $formdata['exception_type'] == 'BATSP'? 'selected="selected"' : '' )?>>
                    BEB Awards to suspended providers</option>
                <option value="IEM" <?=(!empty($formdata['exception_type']) && $formdata['exception_type'] == 'IEM'? 'selected="selected"' : '' )?>>Inconsistent evaluation methods</option>
            </select>
        </div>
    </div>


    <?php if($this->session->userdata('isadmin') == 'Y'): ?>
        <div class="control-group">
            <label class="control-label">Select PDE <span>*</span></label>

            <div class="controls">

                <select name="pde"   style="width:100%" class="populate" >

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


    <div class="control-group contract_award_control">
        <label class="control-label">Date:</label>
        <div class="controls">
            <div class="input-append date date-picker" data-date="<?=date('Y-m-d')?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
                <input name="contract_award_from_date" data-date="<?=date('Y-m-d')?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days" placeholder="From" class="m-ctrl-medium date-picker input-small" type="text" value="<?=(!empty($formdata['contract_award_from_date'])? $formdata['contract_award_from_date'] : '' )?>" />
                <span class="add-on"><i class="fa fa-calendar"></i></span>
            </div>
            <div class="input-append date date-picker" data-date="<?=date('Y-m-d')?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days">
                <input name="contract_award_to_date"  placeholder="To" data-date="<?=date('Y-m-d')?>" data-date-format="yyyy-mm-dd" data-date-viewmode="days" class="m-ctrl-medium input-small date-picker" type="text" value="<?=(!empty($formdata['contract_award_to_date'])? $formdata['contract_award_to_date'] : '' )?>" />
                <span class="add-on"><i class="fa fa-calendar"></i></span>
            </div>
        </div>
    </div>


    <div class="form-actions">
        <button type="submit" name="view" value="view-report" class="btn blue"><i class="fa fa-ok"></i> View report</button>
    </div>
</form>
<!-- END FORM-->