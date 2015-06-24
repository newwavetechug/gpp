<style>
    form.contract_reports .exception_control, form.contract_reports .completion_control, form.contract_reports .late_control {
        display: none;
    }
</style>
<? if (empty($requiredfields)) $requiredfields = array(); ?>
<form action="<?= current_url() ?>" method="post">
    <div class="control-group">
        <label class="control-label">Report type<span>*</span></label>

        <div class="controls">


            <?php

            #print_r($reporttype);
            if (!empty($reporttype)) {
                $reporttype = $reporttype;
            } else {
                $reporttype = '';
            }
            ?>
            <select id="report_type" class="input-large m-wrap" name="report_type" tabindex="2">
                <option value="" selected="selected">-Select-</option>
                <option
                    value="contracts_awarded" <?php if (!empty($report_type) && $report_type == 'contracts_awarded') { ?> selected <?php } ?> >
                    Contracts awarded (except micro procurement)
                </option>
                <option
                    value="contracts_amended_or_varied" <?php if (!empty($report_type) && $report_type == 'contracts_amended_or_varied') { ?> selected <?php } ?> >
                    Contracts Amended or Varied
                </option>
                <option
                    value="contracts_completed"  <?php if (!empty($report_type) && $report_type == 'contracts_completed') { ?> selected <?php } ?> >
                    Contracts completed
                </option>
                <option
                    value="micro_procurements"  <?php if (!empty($report_type) && $report_type == 'micro_procurements') { ?> selected <?php } ?> >
                    Report on Micro Procurements
                </option>
            </select>
        </div>
    </div>




    <?php if ($this->session->userdata('isadmin') == 'Y'): ?>
        <div class="control-group">
            <label class="control-label">Select PDE </label>

            <div class="controls">
                <?php
                $pdeidd = 0;
                if (!empty($pdeid)) {
                    $pdeidd = $pdeid;
                }

                ?>

                <select name="pde" style="width:100%" class="populate">

                    <optgroup label="Available PDES">
                        <option selected="" value="">Choose PDE</option>
                        <?php

                        foreach (get_active_pdes() as $pde) {

                            ?>
                            <option
                                value="<?= set_value('pde', $pde['pdeid']) ?>" <?php if ($pdeidd == $pde['pdeid']) { ?> selected <?php } ?> ><?= $pde['pdename'] ?></option>
                        <?php
                        }
                        ?>

                    </optgroup>

                </select>
            </div>
        </div>


    <?php endif; ?>

    <div class="control-group">
        <label class="control-label">Financial year:</label>

        <div class="controls">
            <select id="financial_year" class="input-large m-wrap" name="financial_year" tabindex="2">
                <?= get_select_options($financial_years, 'fy', 'label', (!empty($formdata['financial_year']) ? $formdata['financial_year'] : '')) ?>
            </select>
        </div>
    </div>


    <div class="control-group ">
        <label class="control-label">Month:</label>


        <div class="controls">

            <div class="input-append date date-picker"  data-date-format="yyyy-mm-dd"
                 data-date-viewmode="days">
                <input name="from_date"   data-date="<?= date('Y-m-d') ?>" data-date-format="yyyy-mm-dd"
                       data-date-viewmode="days" placeholder="From" class="m-ctrl-medium date-picker input-small from_date"
                       type="text" value="<?= set_value('from_date') ?>"/>

            </div>
            <span class="add-on">to</span>

            <div class="input-append date date-picker" data-date="<?= date('Y-m-d') ?>" data-date-format="yyyy-mm-dd"
                 data-date-viewmode="days">
                <input name="to_date" placeholder="To" data-date="<?= date('Y-m-d') ?>" data-date-format="yyyy-mm-dd"
                       data-date-viewmode="days" class="m-ctrl-medium input-small date-picker to_date" type="text"
                       value="<?= set_value('to_date') ?>"/>

            </div>
        </div>
    </div>



    <div class="form-actions">
        <button type="submit" name="generate_report" id="submit" value="view-report" class="btn blue"><i
                class="icon-ok"></i> View reports
        </button>
    </div>
</form>

<script>
    $(document).ready(function(){



        //when finacial year changes clear month fields
        $('#financial_year').change(function () {
            $(".date-picker").val('');
        });


        $('.from_date').datepicker();
        $('.to_date').datepicker();

    });
</script>




