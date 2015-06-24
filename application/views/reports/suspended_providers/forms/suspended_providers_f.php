<form action="<?=current_url()?>"  method="post">





    <div class="control-group">
        <label class="control-label">Financial year:</label>
        <div class="controls">
            <select id="financial_year" class="input-large m-wrap" name="financial_year" tabindex="2">
                <?=get_select_options($financial_years, 'fy', 'label', (!empty($formdata['financial_year'])? $formdata['financial_year'] : '' ))?>
            </select>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">Month:</label>
        <div class="controls">
            <select id="month" class="input-large m-wrap" name="months" tabindex="2">


                <?php
                $months = months_array();
                foreach ($months as $key => $value) {
                    ?>
                    <option value="<?= $key ?>"><?= $value ?></option>
                <?php
                }
                ?>
            </select>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" name="generate_ppms" id="submit"value="view-report" class="btn blue"><i class="icon-ok"></i> View reports</button>
    </div>
</form>
