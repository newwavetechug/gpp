<? if(empty($requiredfields)) $requiredfields = array();?>
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
        <form action="<?=base_url() . 'admin/save_user' . ((!empty($i))? '/i/'.$i : '' )?>" enctype="multipart/form-data" method="post" class="form-horizontal">
        	<div class="form_details">
        		<div class="user_details">
            	<div class="control-group <?=(in_array('firstname', $requiredfields)? 'error': '')?>">
                    <label class="control-label">First Name <span>*</span></label>
                    <div class="controls">
                        <input type="text" name="firstname" value="<?=(!empty($formdata['firstname'])? $formdata['firstname'] : '' )?>" class="input-xlarge" />
                        <?=(in_array('firstname', $requiredfields)? '<span class="help-inline">Please enter your first name</span>': '')?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Middle Name</label>
                    <div class="controls">
                        <input type="text" name="middlename" value="<?=(!empty($formdata['middlename'])? $formdata['middlename'] : '' )?>" class="input-xlarge" />
                    </div>
                </div>
                <div class="control-group <?=(in_array('lastname', $requiredfields)? 'error': '')?>">
                    <label class="control-label">Last Name <span>*</span></label>
                    <div class="controls">
                        <input type="text" name="lastname" value="<?=(!empty($formdata['lastname'])? $formdata['lastname'] : '' )?>" class="input-xlarge" />
                        <?=(in_array('firstname', $requiredfields)? '<span class="help-inline">Please enter the user\'s last name</span>': '')?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Prefix</label>
                    <div class="controls">
                        <input type="text" name="prefix" value="<?=(!empty($formdata['prefix'])? $formdata['prefix'] : '' )?>" class="input-mini" />
                        <span class="help-inline">e.g Prof. , Mr.</span>
                    </div>
                </div>
                <div class="control-group <?=(in_array('gender', $requiredfields)? 'error': '')?>">
                    <label class="control-label">Gender <span>*</span></label>
                    <div class="controls">
                        <select class="input-small m-wrap" name="gender">
                            <option>-Select-</option>
                            <option value="F" <?=((!empty($formdata['gender']) && $formdata['gender'] =='F')? 'selected="selected"' : '' )?> >Female</option>
                            <option value="M" <?=((!empty($formdata['gender']) && $formdata['gender'] =='M')? 'selected="selected"' : '' )?> >Male</option>
                        </select>
                        <?=(in_array('gender', $requiredfields)? '<span class="help-inline">Please select the user\'s gender</span>': '')?>
                    </div>
                </div>
                <div class="control-group <?=(in_array('emailaddress', $requiredfields)? 'error': '')?>">
                    <label class="control-label">Email Address <span>*</span></label>
                    <div class="controls">
                        <input type="text" name="emailaddress" value="<?=(!empty($formdata['emailaddress'])? $formdata['emailaddress'] : '' )?>" class="input-xlarge" />
                        <?=(in_array('emailaddress', $requiredfields)? ((empty($errormsgs['emailaddress']))? '<span class="help-inline">Please enter the user\'s email address</span>' : '<span class="help-inline">'. $errormsgs['emailaddress'] .'</span>' ) : '')?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Phone No. <span>*</span></label>
                    <div class="controls">
                        <input type="text" name="telephone" value="<?=(!empty($formdata['telephone'])? $formdata['telephone'] : '' )?>" class="input-xlarge numbersonly telephone" />
                        <span class="help-inline">e.g 0782123456</span>
                    </div>
                </div>
                
				<?php if($this->session->userdata('isadmin') == 'Y'): ?>
                <div class="control-group">
                    <label class="control-label">User PDE</label>
                    <div class="controls">
                        <select class="input-large m-wrap" name="pde" tabindex="1">
                            <?=get_select_options($pdes, 'pdeid', 'pdename', (!empty($formdata['pde'])? $formdata['pde'] : '' ))?>
                        </select>
                    </div>
                </div>
                <?php endif; ?>
                
                <div class="control-group">
                    <label class="control-label">User Group<span>*</span></label>
                    <div class="controls">
                        <select class="input-large m-wrap" name="roles" tabindex="1">
                            <?=get_select_options($usergroups, 'usergroupid', 'groupname', (!empty($formdata['roles'])? $formdata['roles'] : '' ))?>
                        </select>
                    </div>
                </div>
                
                <div class="control-group <?=(in_array('username', $requiredfields)? 'error': '')?>">
                    <label class="control-label">Username <span>*</span></label>
                    <div class="controls">
                        <input type="text" name="username" value="<?=(!empty($formdata['username'])? $formdata['username'] : '' )?>" class="input-xlarge" />
                        <?=(in_array('username', $requiredfields)? ((empty($errormsgs['username']))? '<span class="help-inline">Please enter the user\'s username</span>' : '<span class="help-inline">'. $errormsgs['username'] .'</span>' ) : '')?>
                    </div>
                </div>
                <div class="control-group <?=(in_array('password', $requiredfields)? 'error': '')?>">
                    <label class="control-label">Password <span>*</span></label>
                    <div class="controls">
                        <input type="password" name="password" class="input-xlarge" />
                        <?=(in_array('password', $requiredfields)? ((empty($errormsgs['password']))? '<span class="help-inline">Please enter the user\'s password</span>' : '<span class="help-inline">'. $errormsgs['password'] .'</span>' ) : '')?>
                    </div>
                </div>
                <div class="control-group <?=(in_array('repeatpassword', $requiredfields)? 'error': '')?>">
                    <label class="control-label">Confirm Password <span>*</span></label>
                    <div class="controls">
                        <input type="password" name="repeatpassword" class="input-xlarge"/>
                        <?=(in_array('repeatpassword', $requiredfields)? ((empty($errormsgs['repeatpassword']))? '<span class="help-inline">Please enter the user\'s password</span>' : '<span class="help-inline">'. $errormsgs['repeatpassword'] .'</span>' ) : '')?>
                    </div>
                </div>
            </div>
            
            </div>
            
            <div class="form-actions">
                <button type="submit" name="save" value="save" class="btn blue"><i class="fa fa-ok"></i> Save</button>
                <button type="submit" name="cancel" value="cancel" class="btn"><i class="fa fa-remove"></i> Cancel</button>
            </div>
        </form>
        <!-- END FORM-->
    </div>
</div>