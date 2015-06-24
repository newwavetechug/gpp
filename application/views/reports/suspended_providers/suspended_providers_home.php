<?php
//print_array($results);
//print_array($this->session->all_userdata());
//print_array(get_pde_info_by_id($this->session->userdata('pdeid'),'title'))

if(isset($errors)){
    echo error_template($errors);
}

//if there are results to display
if(isset($results)){
    //print_array($rop_suspended_providers);
    $suspended = array();
    $suspended_info = array();
    foreach ($rop_suspended_providers as $row) {

        $suspended[] = $row['orgname'];


    }
    ?>

    <table  id=""  class="display table table-hover dt-responsive">


        <thead>
        <tr>
            <th>Procurement Reference</th>
            <th>Procurement method</th>
            <th>Procurement value <br>(UGX)</th>
            <th>Bid</th>
            <th>Provider</th>
            <th>Nationality</th>
            <th>Reason</th>


        </tr>
        </thead>

        <tbody>

        <?php
        //print_array($results);
        //print_array($suspended_info);

        $values = array();
        $totals= array();
        foreach ($results as $row) {
            $totals[] = get_bid_invitation_info($row['bid_id'], 'procurement_value');

            if(!isset($financial_year)){
                if (in_array(get_provider_info_by_id($row['providerid'], 'title'), $suspended)) {

                    $values[] = $row['providerid'];

                    ?>
                    <tr>
                        <td><?= get_bid_invitation_info($row['bid_id'], 'procurement_ref_no') ?></td>
                        <td><?= get_bid_invitation_info($row['bid_id'], 'procurement_method') ?></td>
                        <td style="text-align: right;"><?= get_bid_invitation_info($row['bid_id'], 'procurement_value') ?></td>
                        <td><?= get_bid_invitation_info($row['bid_id'], 'procurement') ?></td>
                        <td>
                            <?= get_provider_info_by_id($row['providerid'], 'title') ?>

                        </td>
                        <td>
                            <?=$row['nationality']?>
                        </td>
                        <td>
                            <?php
                            foreach($rop_suspended_providers as $provider){
                                if (in_array(get_provider_info_by_id($row['providerid'], 'title'), $suspended)&&get_provider_info_by_id($row['providerid'], 'title')==$provider['orgname']) {
                                    echo $provider['reason'];
                                }

                            }
                            ?>
                        </td>

                    </tr>

                <?php



                }


            }else{
                //if there is no month passed
                if(!isset($months)){
                    if (in_array(get_provider_info_by_id($row['providerid'], 'title'), $suspended)) {

                        $values[] = $row['providerid'];
                        ?>
                        <tr>
                            <td><?= get_bid_invitation_info($row['bid_id'], 'procurement_ref_no') ?></td>
                            <td><?= get_bid_invitation_info($row['bid_id'], 'procurement_method') ?></td>
                            <td style="text-align: right;"><?= get_bid_invitation_info($row['bid_id'], 'procurement_value') ?></td>
                            <td><?= get_bid_invitation_info($row['bid_id'], 'procurement') ?></td>
                            <td>
                                <?= get_provider_info_by_id($row['providerid'], 'title') ?>

                            </td>
                            <td>
                                <?=$row['nationality']?>
                            </td>
                            <td>
                                <?php
                                foreach($rop_suspended_providers as $provider){
                                    if (in_array(get_provider_info_by_id($row['providerid'], 'title'), $suspended)&&get_provider_info_by_id($row['providerid'], 'title')==$provider['orgname']) {
                                        echo $provider['reason'];
                                    }

                                }
                                ?>
                            </td>

                        </tr>

                    <?php



                    }

                }else{
                    if (in_array(get_provider_info_by_id($row['providerid'], 'title'), $suspended)) {

                        $values[] = $row['providerid'];
                        if ($row['providerid'] != 0 && get_month($month) == get_month(date('m', date_to_seconds($row['datereceived'])))) {
                            $values[] = $row['providerid'];
                            ?>
                            <tr>
                                <td><?= get_bid_invitation_info($row['bid_id'], 'procurement_ref_no') ?></td>
                                <td><?= get_bid_invitation_info($row['bid_id'], 'procurement_method') ?></td>
                                <td style="text-align: right;"><?= get_bid_invitation_info($row['bid_id'], 'procurement_value') ?></td>
                                <td><?= get_bid_invitation_info($row['bid_id'], 'procurement') ?></td>
                                <td>
                                    <?= get_provider_info_by_id($row['providerid'], 'title') ?>

                                </td>
                                <td>
                                    <?=$row['nationality']?>
                                </td>
                                <td>
                                    <?php
                                    foreach($rop_suspended_providers as $provider){
                                        if (in_array(get_provider_info_by_id($row['providerid'], 'title'), $suspended)&&get_provider_info_by_id($row['providerid'], 'title')==$provider['orgname']) {
                                            echo $provider['reason'];
                                        }

                                    }
                                    ?>
                                </td>


                            </tr>

                        <?php
                        }




                    }

                }
            }




        }



        ?>
        <tr>
            <td></td>
            <td></td>
            <td style="text-align: right; border-top: solid 1px"><?= array_sum($totals) ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>

        </tr>


        </tbody>
    </table>

    <?php
    if (!count($values)) {
        echo info_template('No value for this month');
    }

    ?>


<?php

}else{
    echo info_template('Select Financial year ');
}



