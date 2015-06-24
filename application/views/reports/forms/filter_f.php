<div style="margin-left: 0px;" class="">
    <form  action="<?=current_url()?>"  method="post" >



        <?php if($this->session->userdata('isadmin') == 'Y'): ?>
            <div class="control-group">
                <label class="control-label">Select PDE <span>*</span></label>
                <div class="controls">
                    <select id="pde" name="pde" class="input-large m-wrap" tabindex="1">
                        <?=get_select_options($pdes, 'pdeid', 'pdename', (!empty($formdata['pde'])? $formdata['pde'] : '' ))?>
                    </select>
                </div>
            </div>
        <?php endif; ?>

        <div class="control-group">
            <label class="control-label">Financial year:</label>
            <div class="controls">
                <select id="financial_year" class="input-large m-wrap" name="financial_year" tabindex="2">
                    <?=get_select_options($financial_years, 'fy', 'label', (!empty($formdata['financial_year'])? $formdata['financial_year'] : '' ))?>
                </select>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" name="generate" id="submit" value="view-report" class="btn blue"><i class="icon-ok"></i> View report</button>
        </div>
    </form>
</div>
