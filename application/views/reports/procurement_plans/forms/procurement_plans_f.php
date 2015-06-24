<form action="<?=current_url()?>" enctype="multipart/form-data" method="post" class="reports_form ">



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
            if(!empty($financial_year))
            {
                $selectedyear = $financial_year;
            }
            else
            {
                $selectedyear = null;
            }
            echo financial_year_dropdown($start_year, $end_year , $id='financial_year', $class='input-large m-wrap', $selected=$selectedyear);
            ?>

        </div>
    </div>

    <div class="form-actions">
        <button type="submit" name="view" value="view-report" class="btn blue"><i class="icon-ok"></i> View report</button>

    </div>
</form>


