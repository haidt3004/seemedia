<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><span class="<?php echo $model->isNewRecord ? $this->iconCreate : $this->iconEdit; ?>"></span> <?php echo $model->isNewRecord ? 'Create' : 'Update'; ?> <?php echo $this->singleTitle ?></h3>
    </div>
    <div class="panel-body">
        <div class="form">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
            'id' => 'users-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data'),
            ));
            ?>

            <div class='form-group form-group-sm'>
                <label class="col-sm-5 control-label" style="text-transform: uppercase;">Account Information</label>
            </div>
            <br>

            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'staff_name', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model, 'staff_name', array('class' => 'form-control', 'maxlength' => 150)); ?>
                    <?php echo $form->error($model, 'staff_name'); ?>
                </div>
            </div>

            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'username', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model, 'username', array('class' => 'form-control', 'maxlength' => 50)); ?>
                    <?php echo $form->error($model, 'username'); ?>
                </div>
            </div>

            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'email', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model, 'email', array('class' => 'form-control', 'maxlength' => 150)); ?>
                    <?php echo $form->error($model, 'email'); ?>
                </div>
            </div>

            <?php if ($model->isNewRecord) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'temp_password', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->passwordField($model, 'temp_password', array('class' => 'form-control password-default','style'=>'float:left;', 'maxlength' => 150)); ?>
                        <?php echo $form->error($model, 'temp_password'); ?>
                    </div>
                    <button style="margin-top: 4px;margin-left: -8px;padding: 1px 5px;" class="btn-reset btn btn-primary"  type="button">Set default password</button>
                </div>
            <?php } else { ?>
<!--                <div class='form-group form-group-sm'>-->
<!--                    <label class="col-sm-2 control-label">--><?php //echo $model->getAttributeLabel('newPassword'); ?><!-- <span class="required">*</span><br>(use only if you want to change)</label>-->
<!--                    <div class="col-sm-3">-->
<!--                        --><?php //echo $form->passwordField($model, 'newPassword', array('class' => 'form-control password-default','style'=>'float:left;', 'maxlength' => 150)); ?>
<!---->
<!--                        --><?php //echo $form->error($model, 'newPassword'); ?>
<!--                    </div>-->
<!--                    <button style="margin-top: 4px;margin-left: -8px;padding: 1px 5px;" class="btn-reset btn btn-primary"  type="button">Reset password</button>-->
<!--                </div>-->

                <div class='form-group form-group-sm'>
                    <label class="col-sm-2 control-label">(use only if you want to change)</label>
                    <div class="col-sm-3 hidden">
                        <?php echo $form->passwordField($model, 'newPassword', array('class' => 'form-control password-default','style'=>'float:left;', 'maxlength' => 150)); ?>

                        <?php echo $form->error($model, 'newPassword'); ?>
                    </div>
                    <div class="col-sm-3">
                        <button class="btn-reset btn btn-primary"  type="button">Reset password</button>
                    </div>
                </div>
            <?php } ?>

            <script type="text/javascript">
                $('.btn-reset').click(function(){
                    $('.password-default').val('<?php echo Yii::app()->params['defaultPassword'];?>');
                })
            </script>

            <div class='form-group form-group-sm <?php echo $model->isNewRecord ? '' : 'hidden'; ?>'>
                <?php echo $form->labelEx($model, 'password_confirm', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->passwordField($model, 'password_confirm', array('class' => 'form-control password-default', 'maxlength' => 150)); ?>
                    <?php echo $form->error($model, 'password_confirm'); ?>
                </div>
            </div>

            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->dropDownList($model, 'status', $model->optionActive, array('class' => 'form-control','empty'=>'Select')); ?>
                    <?php echo $form->error($model, 'status'); ?>
                </div>
            </div>

            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'language_id', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->dropDownList($model, 'language_id', Languages::getListLanguage(), array('class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'language_id'); ?>
                </div>
            </div>


            <div class='form-group form-group-sm'>
                <label class="col-sm-5 control-label" style="text-transform: uppercase;">Profile Information</label>
            </div>
            <br>

            <?php if (Yii::app()->params['first_name'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'first_name', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textField($model, 'first_name', array('class' => 'form-control', 'maxlength' => 100)); ?>
                        <?php echo $form->error($model, 'first_name'); ?>
                    </div>
                </div>
            <?php } ?>



            <?php if (Yii::app()->params['middle_name'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'middle_name', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textField($model, 'middle_name', array('class' => 'form-control', 'maxlength' => 100)); ?>
                        <?php echo $form->error($model, 'middle_name'); ?>
                    </div>
                </div>
            <?php } ?>



            <?php if (Yii::app()->params['last_name'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'last_name', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textField($model, 'last_name', array('class' => 'form-control', 'maxlength' => 100)); ?>
                        <?php echo $form->error($model, 'last_name'); ?>
                    </div>
                </div>
            <?php } ?>

            <?php if (Yii::app()->params['nationality'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'nationality', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textField($model, 'nationality', array('class' => 'form-control', 'maxlength' => 100)); ?>
                        <?php echo $form->error($model, 'nationality'); ?>
                    </div>
                </div>
            <?php } ?>


            <?php if (Yii::app()->params['permanent_resident'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'permanent_resident', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->dropDownList($model, 'permanent_resident', $model->optionYesNo, array('class' => 'form-control','empty'=>'Select')); ?>
                        <?php echo $form->error($model, 'permanent_resident'); ?>
                    </div>
                </div>
            <?php } ?>

            <?php if (Yii::app()->params['fin'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'fin', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textField($model, 'fin', array('class' => 'form-control', 'maxlength' => 200)); ?>
                        <?php echo $form->error($model, 'fin'); ?>
                    </div>
                </div>
            <?php } ?>

            <?php if (Yii::app()->params['marital_status'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'marital_status', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->dropDownList($model, 'marital_status', $model->optionMaritalStatus, array('class' => 'form-control','empty'=>'Select')); ?>
                        <?php echo $form->error($model, 'marital_status'); ?>
                    </div>
                </div>
            <?php } ?>

            <?php if (Yii::app()->params['number_of_children'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'number_of_children', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->numberField($model, 'number_of_children', array('class' => 'form-control', 'min' => 0)); ?>
                        <?php echo $form->error($model, 'number_of_children'); ?>
                    </div>
                </div>
            <?php } ?>

            <?php if (Yii::app()->params['driving_license_class_type'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'driving_license_class_type', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textField($model, 'driving_license_class_type', array('class' => 'form-control', 'maxlength' => 200)); ?>
                        <?php echo $form->error($model, 'driving_license_class_type'); ?>
                    </div>
                </div>
            <?php } ?>

            <?php if (Yii::app()->params['highest_education_level'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'highest_education_level', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textField($model, 'highest_education_level', array('class' => 'form-control', 'maxlength' => 200)); ?>
                        <?php echo $form->error($model, 'highest_education_level'); ?>
                    </div>
                </div>
            <?php } ?>

            <?php if (Yii::app()->params['certification_awarded'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'certification_awarded', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textField($model, 'certification_awarded', array('class' => 'form-control', 'maxlength' => 200)); ?>
                        <?php echo $form->error($model, 'certification_awarded'); ?>
                    </div>
                </div>
            <?php } ?>


            <?php if (Yii::app()->params['office'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'office', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textField($model, 'office', array('class' => 'form-control', 'maxlength' => 200)); ?>
                        <?php echo $form->error($model, 'office'); ?>
                    </div>
                </div>
            <?php } ?>



            <?php if (Yii::app()->params['job_title'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'job_title', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textField($model, 'job_title', array('class' => 'form-control', 'maxlength' => 200)); ?>
                        <?php echo $form->error($model, 'job_title'); ?>
                    </div>
                </div>
            <?php } ?>



            <?php if (Yii::app()->params['department'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'department', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textField($model, 'department', array('class' => 'form-control', 'maxlength' => 200)); ?>
                        <?php echo $form->error($model, 'department'); ?>
                    </div>
                </div>
            <?php } ?>



            <?php if (Yii::app()->params['company'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'company', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textField($model, 'company', array('class' => 'form-control', 'maxlength' => 200)); ?>
                        <?php echo $form->error($model, 'company'); ?>
                    </div>
                </div>
            <?php } ?>



            <?php if (Yii::app()->params['gender'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'gender', array('class' => 'col-sm-2 control-label', 'label' => 'Gender/Sex')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->dropDownList($model, 'gender', $model->optionGender, array('class' => 'form-control','empty'=>'Select')); ?>
                        <?php echo $form->error($model, 'gender'); ?>
                    </div>
                </div>
            <?php } ?>



            <?php if (Yii::app()->params['date_of_birthday'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model,'dob', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textField($model,'dob', array('class' => 'form-control ver_datepicker', 'maxlength' => 255)); ?>
                        <?php echo $form->error($model,'dob'); ?>
                    </div>
                </div>
            <?php } ?>



            <?php if (Yii::app()->params['skills'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'skills', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textArea($model, 'skills', array('style' => 'width:100%;', 'cols' => 48, 'rows' => 3)); ?>
                        <?php echo $form->error($model, 'skills'); ?>
                    </div>
                </div>
            <?php } ?>



            <?php if (Yii::app()->params['educations'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'educations', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textArea($model, 'educations', array('style' => 'width:100%;', 'cols' => 48, 'rows' => 3)); ?>
                        <?php echo $form->error($model, 'educations'); ?>
                    </div>
                </div>
            <?php } ?>



            <?php if (Yii::app()->params['certification'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'certification', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textArea($model, 'certification', array('style' => 'width:100%;', 'cols' => 48, 'rows' => 3)); ?>
                        <?php echo $form->error($model, 'certification'); ?>
                    </div>
                </div>
            <?php } ?>



            <?php if (Yii::app()->params['languages'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'languages', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textArea($model, 'languages', array('style' => 'width:100%;', 'cols' => 48, 'rows' => 3)); ?>
                        <?php echo $form->error($model, 'languages'); ?>
                    </div>
                </div>
            <?php } ?>



            <?php if (Yii::app()->params['associations'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'associations', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textArea($model, 'associations', array('style' => 'width:100%;', 'cols' => 48, 'rows' => 3)); ?>
                        <?php echo $form->error($model, 'associations'); ?>
                    </div>
                </div>
            <?php } ?>



            <?php if (Yii::app()->params['about_my_self'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'about_my_self', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textArea($model, 'about_my_self', array('style' => 'width:100%;', 'cols' => 48, 'rows' => 3)); ?>
                        <?php echo $form->error($model, 'about_my_self'); ?>
                    </div>
                </div>
            <?php } ?>



            <div class='form-group form-group-sm'>
                <label class="col-sm-5 control-label" style="text-transform: uppercase;">Contact Information</label>
            </div>
            <br>


            <?php if (Yii::app()->params['account_types'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'account_types', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textField($model, 'account_types', array('class' => 'form-control', 'maxlength' => 100)); ?>
                        <?php echo $form->error($model, 'account_types'); ?>
                    </div>
                </div>
            <?php } ?>

            <?php if (Yii::app()->params['country_of_residence'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'country_of_residence', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textField($model, 'country_of_residence', array('class' => 'form-control', 'maxlength' => 100)); ?>
                        <?php echo $form->error($model, 'country_of_residence'); ?>
                    </div>
                </div>
            <?php } ?>


            <?php if (Yii::app()->params['work_email_address'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'work_email_address', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textField($model, 'work_email_address', array('class' => 'form-control', 'maxlength' => 200)); ?>
                        <?php echo $form->error($model, 'work_email_address'); ?>
                    </div>
                </div>
            <?php } ?>



            <?php if (Yii::app()->params['personal_email_address'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'personal_email_address', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textField($model, 'personal_email_address', array('class' => 'form-control', 'maxlength' => 200)); ?>
                        <?php echo $form->error($model, 'personal_email_address'); ?>
                    </div>
                </div>
            <?php } ?>




            <?php if (Yii::app()->params['house_address'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'address', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textArea($model, 'address', array('style' => 'width:100%;', 'cols' => 48, 'rows' => 3)); ?>
                        <?php echo $form->error($model, 'address'); ?>
                    </div>
                </div>
            <?php } ?>



            <?php if (Yii::app()->params['secondary_address'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'secondary_address', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textArea($model, 'secondary_address', array('style' => 'width:100%;', 'cols' => 48, 'rows' => 3)); ?>
                        <?php echo $form->error($model, 'secondary_address'); ?>
                    </div>
                </div>
            <?php } ?>




            <?php if (Yii::app()->params['house_phone_number'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'home_phone_number', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textField($model, 'home_phone_number', array('class' => 'form-control', 'maxlength' => 30)); ?>
                        <?php echo $form->error($model, 'home_phone_number'); ?>
                    </div>
                </div>
            <?php } ?>




            <?php if (Yii::app()->params['work_phone_number'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'work_phone_number', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textField($model, 'work_phone_number', array('class' => 'form-control', 'maxlength' => 30)); ?>
                        <?php echo $form->error($model, 'work_phone_number'); ?>
                    </div>
                </div>
            <?php } ?>




            <?php if (Yii::app()->params['mobile_phone'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'phone', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textField($model, 'phone', array('class' => 'form-control', 'maxlength' => 200)); ?>
                        <?php echo $form->error($model, 'phone'); ?>
                    </div>
                </div>
            <?php } ?>





            <?php if (Yii::app()->params['twitter_accounts'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'twitter_accounts', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textField($model, 'twitter_accounts', array('class' => 'form-control', 'maxlength' => 200)); ?>
                        <?php echo $form->error($model, 'twitter_accounts'); ?>
                    </div>
                </div>
            <?php } ?>




            <?php if (Yii::app()->params['im_accounts'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'im_accounts', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textField($model, 'im_accounts', array('class' => 'form-control', 'maxlength' => 200)); ?>
                        <?php echo $form->error($model, 'im_accounts'); ?>
                    </div>
                </div>
            <?php } ?>



            <?php if (Yii::app()->params['yahoo_accounts'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'yahoo_accounts', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textField($model, 'yahoo_accounts', array('class' => 'form-control', 'maxlength' => 200)); ?>
                        <?php echo $form->error($model, 'yahoo_accounts'); ?>
                    </div>
                </div>
            <?php } ?>



            <?php if (Yii::app()->params['skype_accounts'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'skype_accounts', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textField($model, 'skype_accounts', array('class' => 'form-control', 'maxlength' => 200)); ?>
                        <?php echo $form->error($model, 'skype_accounts'); ?>
                    </div>
                </div>
            <?php } ?>



            <?php if (Yii::app()->params['viber_accounts'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'viber_accounts', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textField($model, 'viber_accounts', array('class' => 'form-control', 'maxlength' => 200)); ?>
                        <?php echo $form->error($model, 'viber_accounts'); ?>
                    </div>
                </div>
            <?php } ?>



            <?php if (Yii::app()->params['whatsapp'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'whatsapp', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textField($model, 'whatsapp', array('class' => 'form-control', 'maxlength' => 200)); ?>
                        <?php echo $form->error($model, 'whatsapp'); ?>
                    </div>
                </div>
            <?php } ?>



            <?php if (Yii::app()->params['facebook_accounts_url'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'facebook_accounts_url', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textField($model, 'facebook_accounts_url', array('class' => 'form-control', 'maxlength' => 200)); ?>
                        <?php echo $form->error($model, 'facebook_accounts_url'); ?>
                    </div>
                </div>
            <?php } ?>



            <?php if (Yii::app()->params['emergency'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'emergency', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textArea($model, 'emergency', array('style' => 'width:100%;', 'cols' => 48, 'rows' => 3)); ?>
                        <?php echo $form->error($model, 'emergency'); ?>
                    </div>
                </div>
            <?php } ?>

            <?php if (Yii::app()->params['emergency_contact_person'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'emergency_contact_person', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textField($model, 'emergency_contact_person', array('class' => 'form-control', 'maxlength' => 200)); ?>
                        <?php echo $form->error($model, 'emergency_contact_person'); ?>
                    </div>
                </div>
            <?php } ?>

            <?php if (Yii::app()->params['relationship_of_emergency_contact_person'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'relationship_of_emergency_contact_person', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textField($model, 'relationship_of_emergency_contact_person', array('class' => 'form-control', 'maxlength' => 200)); ?>
                        <?php echo $form->error($model, 'relationship_of_emergency_contact_person'); ?>
                    </div>
                </div>
            <?php } ?>

            <?php if (Yii::app()->params['emergency_contact_number'] ) { ?>
                <div class='form-group form-group-sm'>
                    <?php echo $form->labelEx($model, 'emergency_contact_number', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->textField($model, 'emergency_contact_number', array('class' => 'form-control', 'maxlength' => 30)); ?>
                        <?php echo $form->error($model, 'emergency_contact_number'); ?>
                    </div>
                </div>
            <?php } ?>

            

            <div class="clr"></div>
            <div class="well">
                <?php echo CHtml::htmlButton($model->isNewRecord ? '<span class="' . $this->iconCreate . '"></span> Create' : '<span class="' . $this->iconSave . '"></span> Save', array('class' => 'btn btn-primary', 'type' => 'submit')); ?> &nbsp;
                <?php if (!$model->isNewRecord) echo CHtml::htmlButton('<span class="' . $this->iconCancel . '"></span> Cancel', array('class' => 'btn btn-default', 'onclick' => 'javascript: location.href=\'' . $this->baseControllerIndexUrl() . '\'')); ?>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>

<style>
label.required {color:#333333 !important};
</style>
