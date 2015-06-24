<div class="widget">
    <div class="widget-title">
        <h4><i class="fa fa-reorder"></i>&nbsp;<?=(!empty($form_title)? $form_title : 'User details') ?></h4>
            <span class="tools">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
                <a href="javascript:;" class="fa fa-remove"></a>
            </span>
    </div>
    <div class="widget-body">
        <!-- BEGIN FORM-->
        <form action="<?=base_url() . 'user/save_profile'?>" enctype="multipart/form-data" method="post" class="form-horizontal">
            <div class="control-group">
                <label class="control-label">First Name <span>*</span></label>
                <div class="controls">
                    <input type="text" name="firstname" value="<?=(!empty($formdata['firstname'])? $formdata['firstname'] : '' )?>" class="input-xxlarge" required/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Middle Name</label>
                <div class="controls">
                    <input type="text" name="middlename" value="<?=(!empty($formdata['middlename'])? $formdata['middlename'] : '' )?>" class="input-xxlarge" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Last Name <span>*</span></label>
                <div class="controls">
                    <input type="text" name="lastname" value="<?=(!empty($formdata['lastname'])? $formdata['lastname'] : '' )?>" class="input-xxlarge" required/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Prefix</label>
                <div class="controls">
                    <input type="text" name="prefix" value="<?=(!empty($formdata['prefix'])? $formdata['prefix'] : '' )?>" class="input-mini" />
                    <span class="help-inline">e.g Prof. , Mr.</span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Gender <span>*</span></label>
                <div class="controls">
                    <select class="input-small m-wrap" name="gender"required>
                        <option>-Select-</option>
                        <option value="F" <?=((!empty($formdata['gender']) && $formdata['gender'] =='F')? 'selected="selected"' : '' )?> >
                        	Female
                        </option>
                        <option value="M" <?=((!empty($formdata['gender']) && $formdata['gender'] =='M')? 'selected="selected"' : '' )?> >
                        	Male
                        </option>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Email Address <span>*</span></label>
                <div class="controls">
                    <input type="text" name="emailaddress" value="<?=(!empty($formdata['emailaddress'])? $formdata['emailaddress'] : '' )?>" class="input-xxlarge" required/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Phone No. <span>*</span></label>
                <div class="controls">
                    <input type="text" name="telephone" value="<?=(!empty($formdata['telephone'])? $formdata['telephone'] : '' )?>" class="input-xxlarge" required/>
                    <span class="help-inline">e.g 256772123456</span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">User PDE</label>
                <div class="controls">
                	<?='<b>' . (!empty($formdata['pdename'])? $formdata['pdename'] : '<i>NONE</i>' ) . '</b>'?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">User Group</label>
                <div class="controls">
                    <?='<b>' . (!empty($formdata['usergroup'])? $formdata['usergroup'] : '<i>NONE</i>' ) . '</b>'?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Username <span>*</span></label>
                <div class="controls">
                    <input type="text" name="username" value="<?=(!empty($formdata['emailaddress'])? $formdata['emailaddress'] : '' )?>" class="input-xxlarge" required readonly="readonly"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Password <span>*</span></label>
                <div class="controls">
                    <input type="password" name="password" class="input-xxlarge"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Confirm Password <span>*</span></label>
                <div class="controls">
                    <input type="password" name="repeatpassword" class="input-xxlarge"/>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" name="save" value="save" class="btn blue"><i class="fa fa-ok"></i> Save</button>
                <button type="button" name="cancel" value="cancel" class="btn"><i class="fa fa-remove"></i> Cancel</button>
            </div>
        </form>
        <!-- END FORM-->
    </div>
</div>