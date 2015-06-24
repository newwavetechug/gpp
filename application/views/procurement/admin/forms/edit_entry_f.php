<div class="widget-body form">
    <!-- BEGIN FORM-->
    <form action="#" class="form-horizontal">
        <div class="control-group">
            <label class="control-label">Subject of procurement <?= text_danger_template('*') ?></label>

            <div class="controls">
                <input required=""
                       value="<?= substr(get_procurement_plan_entry_info($entry_id, 'subject_of_procurement'), 0, -5) ?>"
                       id="subj_of_procurement" type="text" class="span6 validate">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Type of procurement <?= text_danger_template('*') ?></label>

            <div class="controls">
                <select id="procurement_type" class="span6 " data-placeholder="Choose a Category" tabindex="1">
                    <option class="text-danger" selected
                            value="<?= get_procurement_plan_entry_info($entry_id, 'procurement_type_id') ?>"><?= get_procurement_plan_entry_info($entry_id, 'procurement_type') ?></option>
                    <?php
                    foreach (get_active_procurement_types() as $type) {
                        ?>
                        <option value="<?= $type['id'] ?>"><?= $type['title'] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Method of procurement <?= text_danger_template('*') ?></label>

            <div class="controls">
                <select id="procurement_method" class="span6 " data-placeholder="Choose a Category" tabindex="1">
                    <option
                        value="<?= get_procurement_plan_entry_info($entry_id, 'procurement_method_id') ?>"><?= get_procurement_plan_entry_info($entry_id, 'procurement_method') ?></option>
                    <?php
                    foreach (get_active_procurement_methods() as $method) {
                        ?>
                        <option value="<?= $method['id'] ?>"><?= $method['title'] ?></option>
                    <?php
                    }

                    ?>

                </select>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label">PDE Department <?= text_danger_template('*') ?></label>

            <div class="controls">
                <select id="pde_department" class="span6 " data-placeholder="Choose a Category" tabindex="1">
                    <option
                        value="<?= get_procurement_plan_entry_info($entry_id, 'department_id') ?>"><?= get_procurement_plan_entry_info($entry_id, 'department') ?></option>
                    <?php
                    foreach (get_active_pde_departments() as $department) {
                        ?>
                        <option value="<?= $department['id'] ?>"><?= $department['title'] ?></option>
                    <?php
                    }

                    ?>

                </select>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Source funding <?= text_danger_template('*') ?></label>

            <div class="controls">
                <select id="source_funding" class="span6 " data-placeholder="Choose a Category" tabindex="1">
                    <option selected value="<?= get_procurement_plan_entry_info($entry_id, 'source_funding_id') ?>"><?= get_procurement_plan_entry_info($entry_id, 'source_funding') ?></option>
                    <?php
                    foreach (get_active_source_funding() as $funding) {
                        ?>
                        <option value="<?= $funding['id'] ?>"><?= $funding['title'] ?></option>
                    <?php
                    }

                    ?>

                </select>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Procurement reference
                Number     <span class="text-error">
        *    </span>
            </label>

            <div class="controls">
                <input required="" value="<?= get_procurement_plan_entry_info($entry_id, 'procurement_ref_no') ?>" id="procurement_ref_no" type="text"
                       class="span6 validate">
            </div>
        </div>


        <div class="control-group">
            <label class="control-label">Estimated amount<?= text_danger_template('*') ?></label>

            <div class="controls">
                <input value="<?= get_procurement_plan_entry_info($entry_id, 'estimated_amount') ?>" required="" id="estimated_amount" type="text" class="span6 validate">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Currency<?= text_danger_template('*') ?></label>

            <div class="controls">
                <select id="currency" class="span6 " data-placeholder="Choose a Category" tabindex="1">
                    <option value="<?= get_procurement_plan_entry_info($entry_id, 'currency_id') ?>"><?= get_procurement_plan_entry_info($entry_id, 'currency') ?></option>
                    <?php
                    foreach (get_active_currencies() as $currency) {
                        ?>
                        <option value="<?= $currency['id'] ?>"><?= $currency['abbr'] ?></option>
                    <?php
                    }

                    ?>

                </select>
            </div>
        </div>
        <hr>

        <div class="page-header">
            Pre-bid qualification section <span class="label label-primary">Not Mandatory</span>
        </div>

        <div class="control-group">
            <label class="control-label">Pre-bid Events date</label>

            <div class="controls">
                <div class="input-append date date-picker" data-date="<?= date('m-d-Y') ?>"
                     data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                    <input id="pre_bid_events_date" class=" m-ctrl-medium date-picker" size="16" type="text"
                           value="<?= substr(get_procurement_plan_entry_info($entry_id, 'pre_bid_events_date'),0,10) ?>"><span class="add-on"><i class="icon-calendar"></i></span>
                    <input required="" value="<?= get_procurement_plan_entry_info($entry_id, 'pre_bid_events_duration') ?>" id="pre_bid_events_date_duration" placeholder="duration" type="text"
                           class="span3 "> Days
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Contracts committee approval date</label>

            <div class="controls">
                <div class="input-append date date-picker" data-date="<?= date('m-d-Y') ?>"
                     data-date-format="dd-mm-yyyy" data-date-viewmode="">
                    <input id="cc_approval_date" class=" m-ctrl-medium date-picker" size="16" type="text" value="<?= substr(get_procurement_plan_entry_info($entry_id, 'contracts_committee_approval_date'),0,10) ?>"><span
                        class="add-on"><i class="icon-calendar"></i></span>

                </div>
                <input value="<?= get_procurement_plan_entry_info($entry_id, 'contracts_committee_approval_date_duration') ?>" required="" id="cc_approval_date_duration" placeholder="duration" type="text" class="span3 ">
                Days
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Publication of pre-qualification notice date</label>

            <div class="controls">
                <div class="input-append date date-picker" data-date="<?= date('m-d-Y') ?>"
                     data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                    <input id="pre_qualification_notice_date" class=" m-ctrl-medium date-picker" size="16" type="text"
                           value="<?= substr(get_procurement_plan_entry_info($entry_id, 'publication_of_pre_qualification_date'),0,10) ?>"><span class="add-on"><i class="icon-calendar"></i></span>

                </div>
                <input required="" value="<?= get_procurement_plan_entry_info($entry_id, 'publication_of_pre_qualification_date_duration') ?>" id="pre_qualification_notice_date_duration" placeholder="duration" type="text"
                       class="span3 "> Days
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Closing date of pre-qualification proposal submission</label>

            <div class="controls">
                <div class="input-append date date-picker" data-date="<?= date('m-d-Y') ?>"
                     data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                    <input id="proposal_submission_date" class=" m-ctrl-medium date-picker" size="16" type="text"
                           value="<?= substr(get_procurement_plan_entry_info($entry_id, 'proposal_submission_date'),0,10) ?>"><span class="add-on"><i class="icon-calendar"></i></span>

                </div>
                <input required="" id="proposal_submission_date_duration" placeholder="duration" type="text"
                       class="span3" value="<?= get_procurement_plan_entry_info($entry_id, 'proposal_submission_date_duration') ?>"> Days
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Contracts committee approval of shortlist & bidding document</label>

            <div class="controls">
                <div class="input-append date date-picker" data-date="<?= date('m-d-Y') ?>"
                     data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                    <input id="cc_shortlist_approval" class=" m-ctrl-medium date-picker" size="16" type="text" value="<?= substr(get_procurement_plan_entry_info($entry_id, 'contracts_committee_approval_of_shortlist_date'),0,10) ?>"><span
                        class="add-on"><i class="icon-calendar"></i></span>

                </div>
                <input value="<?= get_procurement_plan_entry_info($entry_id, 'contracts_committee_approval_of_shortlist_date_duration') ?>" required="" id="cc_shortlist_approval_duration" placeholder="duration" type="text"
                       class="span3 "> Days
            </div>
        </div>

        <hr>

        <div class="page-header">
            Bidding period
        </div>

        <div class="control-group">
            <label class="control-label">Bid issue date</label>

            <div class="controls">
                <div class="input-append date date-picker" data-date="<?= date('m-d-Y') ?>"
                     data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                    <input  id="bid_issue_date" class=" m-ctrl-medium date-picker" size="16" type="text" value="<?= substr(get_procurement_plan_entry_info($entry_id, 'bid_issue_date'),0,10) ?>"><span
                        class="add-on"><i class="icon-calendar"></i></span>

                </div>
                <input required="" value="<?= get_procurement_plan_entry_info($entry_id, 'bid_submission_opening_date_duration') ?>" id="bid_issue_date_duration" placeholder="duration" type="text" class="span3 "> Days
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Bid submission/opening date</label>

            <div class="controls">
                <div class="input-append date date-picker" data-date="<?= date('m-d-Y') ?>"
                     data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                    <input id="bid_submission_date" class=" m-ctrl-medium date-picker" size="16" type="text"
                           value="<?= substr(get_procurement_plan_entry_info($entry_id, 'bid_issue_date'),0,10) ?>"><span class="add-on"><i class="icon-calendar"></i></span>

                </div>
                <input value="<?= get_procurement_plan_entry_info($entry_id, 'bid_submission_opening_date_duration') ?>" required="" id="bid_submission_date_duration" placeholder="duration" type="text" class="span3 ">
                Days
            </div>
        </div>


        <hr>

        <div class="page-header">
            Contract award stage
        </div>

        <div class="control-group">
            <label class="control-label">Date of securing necessary approval</label>

            <div class="controls">
                <div class="input-append date date-picker" data-date="<?= date('m-d-Y') ?>"
                     data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                    <input id="necessary_approval_date" class=" m-ctrl-medium date-picker" size="16" type="text"
                           value="<?= substr(get_procurement_plan_entry_info($entry_id, 'secure_necessary_approval_date'),0,10) ?>"><span class="add-on"><i class="icon-calendar"></i></span>

                </div>
                <input value="<?= get_procurement_plan_entry_info($entry_id, 'secure_necessary_approval_date_duration') ?>" required="" id="necessary_approval_date_duration" placeholder="duration" type="text"
                       class="span3 "> Days
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Contract award date</label>

            <div class="controls">
                <div class="input-append date date-picker" data-date="<?= date('m-d-Y') ?>"
                     data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                    <input id="contract_award_date" class=" m-ctrl-medium date-picker" size="16" type="text"
                           value="<?= substr(get_procurement_plan_entry_info($entry_id, 'contract_award'),0,10) ?>"><span class="add-on"><i class="icon-calendar"></i></span>

                </div>
                <input value="<?= get_procurement_plan_entry_info($entry_id, 'contract_award_duration') ?>" required="" id="contract_award_date_duration" placeholder="duration" type="text" class="span3 ">
                Days
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Best evaluated bidder display date</label>

            <div class="controls">
                <div class="input-append date date-picker" data-date="<?= date('m-d-Y') ?>"
                     data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                    <input id="best_evaluated_bidder_date" class=" m-ctrl-medium date-picker" size="16" type="text"
                           value="<?= substr(get_procurement_plan_entry_info($entry_id, 'best_evaluated_bidder_date'),0,10) ?>"><span class="add-on"><i class="icon-calendar"></i></span>

                </div>
                <input value="<?= get_procurement_plan_entry_info($entry_id, 'best_evaluated_bidder_date_duration') ?>" required="" id="best_evaluated_bidder_date_duration" placeholder="duration" type="text"
                       class="span3 "> Days
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Contract signature date</label>

            <div class="controls">
                <div class="input-append date date-picker" data-date="<?= date('m-d-Y') ?>"
                     data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                    <input id="contract_signature_date" class=" m-ctrl-medium date-picker" size="16" type="text"
                           value="<?= substr(get_procurement_plan_entry_info($entry_id, 'contract_sign_date'),0,10) ?>"><span class="add-on"><i class="icon-calendar"></i></span>

                </div>
                <input value="<?= get_procurement_plan_entry_info($entry_id, 'contract_sign_date_duration') ?>" required="" id="contract_signature_date_duration" placeholder="duration" type="text"
                       class="span3 "> Days
            </div>
        </div>


        <hr>

        <div class="page-header">
            Bidding evaluation period
        </div>

        <div class="control-group">
            <label class="control-label">Contract committee evaluation report approval</label>

            <div class="controls">
                <div class="input-append date date-picker" data-date="<?= date('m-d-Y') ?>"
                     data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                    <input id="cc_evaluation_approval" class=" m-ctrl-medium date-picker" size="16" type="text"
                           value="<?= substr(get_procurement_plan_entry_info($entry_id, 'cc_approval_of_evaluation_report'),0,10) ?>"><span class="add-on"><i class="icon-calendar"></i></span>

                </div>
                <input value="<?= get_procurement_plan_entry_info($entry_id, 'cc_approval_of_evaluation_report_duration') ?>" id="cc_evaluation_approval_duration" required="" placeholder="duration" type="text"
                       class="span3 "> Days
            </div>
        </div>

        <hr>

        <div class="page-header">
            Negotiation period
        </div>

        <div class="control-group">
            <label class="control-label">Negotiation date</label>

            <div class="controls">
                <div class="input-append date date-picker" data-date="<?= date('m-d-Y') ?>"
                     data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                    <input id="negotiation_date" class=" m-ctrl-medium date-picker" size="16" type="text" value="<?= substr(get_procurement_plan_entry_info($entry_id, 'negotiation_date'),0,10) ?>"><span
                        class="add-on"><i class="icon-calendar"></i></span>

                </div>
                <input value="<?= get_procurement_plan_entry_info($entry_id, 'negotiation_date_duration') ?>" required="" id="negotiation_date_duration" placeholder="duration" type="text" class="span3 ">
                Days
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Contract committee negotiation date approval</label>

            <div class="controls">
                <div class="input-append date date-picker" data-date="<?= date('m-d-Y') ?>"
                     data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                    <input id="negotiation_approval_date" class=" m-ctrl-medium date-picker" size="16" type="text"
                           value="<?= substr(get_procurement_plan_entry_info($entry_id, 'negotiation_approval_date'),0,10) ?>"><span class="add-on"><i class="icon-calendar"></i></span>

                </div>
                <input value="<?= get_procurement_plan_entry_info($entry_id, 'negotiation_approval_date_duration') ?>" required="" id="negotiation_approval_date_duration" placeholder="duration" type="text"
                       class="span3 "> Days
            </div>
        </div>


        <hr>

        <div class="page-header">
            Contract implementation period
        </div>

        <div class="control-group">
            <label class="control-label">Mobilise advanced payment date</label>

            <div class="controls">
                <div class="input-append date date-picker" data-date="<?= date('m-d-Y') ?>"
                     data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                    <input id="advanced_payment_date" class=" m-ctrl-medium date-picker" size="16" type="text" value="<?= substr(get_procurement_plan_entry_info($entry_id, 'mobilise_advance_payment'),0,10) ?>"><span
                        class="add-on"><i class="icon-calendar"></i></span>

                </div>
                <input value="<?= get_procurement_plan_entry_info($entry_id, 'mobilise_advance_payment_duration') ?>" required="" id="advanced_payment_date_duration" placeholder="duration" type="text"
                       class="span3 "> Days
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Substantial completion</label>

            <div class="controls">
                <div class="input-append date date-picker" data-date="<?= date('m-d-Y') ?>"
                     data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                    <input id="substantial_completion_date" class=" m-ctrl-medium date-picker" size="16" type="text"
                           value="<?= substr(get_procurement_plan_entry_info($entry_id, 'substantial_completion'),0,10) ?>"><span class="add-on"><i class="icon-calendar"></i></span>

                </div>
                <input value="<?= get_procurement_plan_entry_info($entry_id, 'substantial_completion_duration') ?>" required="" id="substantial_completion_date_duration" placeholder="duration" type="text"
                       class="span3 "> Days
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Final acceptance</label>

            <div class="controls">
                <div class="input-append date date-picker" data-date="<?= date('m-d-Y') ?>"
                     data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                    <input id="final_acceptance" class=" m-ctrl-medium date-picker" size="16" type="text" value="<?= substr(get_procurement_plan_entry_info($entry_id, 'final_acceptance'),0,10) ?>"><span
                        class="add-on"><i class="icon-calendar"></i></span>

                </div>
                <input value="<?= get_procurement_plan_entry_info($entry_id, 'final_acceptance_duration') ?>" required="" id="final_acceptance_duration" placeholder="duration" type="text" class="span3 ">
                Days
            </div>
        </div>


        <label class="checkbox line">
            <div class="checker" id="uniform-undefined"><span class=""><input id="checkBox" type="checkbox" value=""
                                                                              style="opacity: 0;"></span></div>
            I confirm that data entered for annual procurement plan is correct
        </label>

        <div class="message_alerts">

        </div>


        <div class="form-actions">
            <button disabled="disabled" id="submit_plan" type="submit" class="btn btn-success">Submit</button>
            <a class="btn" href="<?= base_url() . $this->uri->segment(1) ?>">Cancel</a>
        </div>
    </form>
    <!-- END FORM-->
</div>
</div>
<!-- END SAMPLE FORM widget-->

<script>
    $(document).ready(function () {

        //toggle button status depending on checkbox confirmation
        $('#checkBox').click(function () {

            //verify if checkbox is checked
            if ($('#checkBox').attr('checked')) {
                $("#submit_plan").removeAttr("disabled");
            }
            else {
                $("#submit_plan").attr("disabled", "disabled");
            }

        });



        $('#submit_plan').click(function () {

            //loading gif
            $(".message_alerts").html('<img src="<?=base_url()?>images/loading.gif" /> Now loading...');


            var subj_of_procurement = $('#subj_of_procurement').val();
            var procurement_ref_no = $('#procurement_ref_no').val();
            var procurement_type = $('#procurement_type').val();
            var procurement_method = $('#procurement_method').val();
            var pde_department = $('#pde_department').val();
            var source_funding = $('#source_funding').val();
            var estimated_amount = $('#estimated_amount').val();
            var currency = $('#currency').val();
            var pre_bid_events_date = $('#pre_bid_events_date').val();
            var pre_bid_events_date_duration = $('#pre_bid_events_date_duration').val();


            var cc_approval_date = $('#cc_approval_date').val();
            var cc_approval_date_duration = $('#cc_approval_date_duration').val();
            var pre_qualification_notice_date = $('#pre_qualification_notice_date').val();
            var pre_qualification_notice_date_duration = $('#pre_qualification_notice_date_duration').val();
            var proposal_submission_date = $('#proposal_submission_date').val();
            var proposal_submission_date_duration = $('#proposal_submission_date_duration').val();

            var cc_shortlist_approval = $('#cc_shortlist_approval').val();
            var cc_shortlist_approval_duration = $('#cc_shortlist_approval_duration').val();
            var bid_issue_date = $('#bid_issue_date').val();
            var bid_issue_date_duration = $('#bid_issue_date_duration').val();
            var bid_submission_date = $('#bid_submission_date').val();
            var bid_submission_date_duration = $('#bid_submission_date_duration').val();

            var necessary_approval_date = $('#necessary_approval_date').val();
            var necessary_approval_date_duration = $('#necessary_approval_date_duration').val();
            var contract_award_date = $('#contract_award_date').val();
            var contract_award_date_duration = $('#contract_award_date_duration').val();
            var best_evaluated_bidder_date = $('#best_evaluated_bidder_date').val();
            var best_evaluated_bidder_date_duration = $('#best_evaluated_bidder_date_duration').val();

            var contract_signature_date = $('#contract_signature_date').val();
            var contract_signature_date_duration = $('#contract_signature_date_duration').val();
            var cc_evaluation_approval = $('#cc_evaluation_approval').val();
            var cc_evaluation_approval_duration = $('#cc_evaluation_approval_duration').val();
            var negotiation_date = $('#negotiation_date').val();
            var negotiation_date_duration = $('#negotiation_date_duration').val();

            var negotiation_approval_date = $('#negotiation_approval_date').val();
            var negotiation_approval_date_duration = $('#negotiation_approval_date_duration').val();
            var advanced_payment_date = $('#advanced_payment_date').val();
            var advanced_payment_date_duration = $('#advanced_payment_date_duration').val();
            var substantial_completion_date = $('#substantial_completion_date').val();
            var substantial_completion_date_duration = $('#substantial_completion_date_duration').val();

            var final_acceptance = $('#final_acceptance').val();
            var final_acceptance_duration = $('#final_acceptance_duration').val();


            $.ajax({
                url: "<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>",
                type: 'POST',
                data: {
                    subj_of_procurement: subj_of_procurement,
                    procurement_ref_no: procurement_ref_no,
                    procurement_type: procurement_type,
                    procurement_method: procurement_method,
                    pde_department: pde_department,
                    source_funding: source_funding,
                    estimated_amount: estimated_amount,
                    currency: currency,
                    pre_bid_events_date: pre_bid_events_date,
                    pre_bid_events_date_duration: pre_bid_events_date_duration,

                    cc_approval_date: cc_approval_date,
                    cc_approval_date_duration: cc_approval_date_duration,
                    pre_qualification_notice_date: pre_qualification_notice_date,
                    pre_qualification_notice_date_duration: pre_qualification_notice_date_duration,
                    proposal_submission_date: proposal_submission_date,
                    proposal_submission_date_duration: proposal_submission_date_duration,

                    cc_shortlist_approval: cc_shortlist_approval,
                    cc_shortlist_approval_duration: cc_shortlist_approval_duration,
                    bid_issue_date: bid_issue_date,
                    bid_issue_date_duration: bid_issue_date_duration,
                    bid_submission_date: bid_submission_date,
                    bid_submission_date_duration: bid_submission_date_duration,

                    necessary_approval_date: necessary_approval_date,
                    necessary_approval_date_duration: necessary_approval_date_duration,
                    contract_award_date: contract_award_date,
                    contract_award_date_duration: contract_award_date_duration,
                    best_evaluated_bidder_date: best_evaluated_bidder_date,
                    best_evaluated_bidder_date_duration: best_evaluated_bidder_date_duration,

                    contract_signature_date: contract_signature_date,
                    contract_signature_date_duration: contract_signature_date_duration,
                    cc_evaluation_approval: cc_evaluation_approval,
                    cc_evaluation_approval_duration: cc_evaluation_approval_duration,
                    negotiation_date: negotiation_date,
                    negotiation_date_duration: negotiation_date_duration,

                    negotiation_approval_date: negotiation_approval_date,
                    negotiation_approval_date_duration: negotiation_approval_date_duration,
                    advanced_payment_date: advanced_payment_date,
                    advanced_payment_date_duration: advanced_payment_date_duration,
                    substantial_completion_date: substantial_completion_date,
                    substantial_completion_date_duration: substantial_completion_date_duration,

                    final_acceptance: final_acceptance,
                    final_acceptance_duration: final_acceptance_duration,

                    procurement_plan_id: '<?=$plan_id?>',
                    entry_id: '<?=$entry_id?>',
                    ajax: 'edit_procurement_plan'
                },
                success: function (msg) {

                    $('.message_alerts').html(msg);

                }
            });


            return false;

        });


    });
</script>