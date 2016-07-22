<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'update-profile-form',
    'htmlOptions'=>array('class'=>'form-horizontal', 'role'=>'form'),
    'enableClientValidation'=>false,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
)); ?>

    <div class="t-header-org line-t-header">
        <?php echo TextMultilangHelper::label('profile-management'); ?>
    <span class="link-header">
        <a href="<?php echo Yii::app()->createAbsoluteUrl('member/site/passwordchanged') ?>" class="btn-link"><?php echo TextMultilangHelper::label('password-changed'); ?></a>
        <a href="javascript:;" onclick="$('#update-profile-form').submit();" class="btn-link"><?php echo TextMultilangHelper::label('update'); ?></a>
    </span>
    </div>
    <div class="frm-edit">

        <div class="clear"></div>
        <?php if (Yii::app()->user->hasFlash('msg')): ?>
            <div class="alert alert-success fade in" style="margin-top:18px;">
                <?php echo Yii::app()->user->getFlash('msg'); ?>
            </div>
        <?php endif; ?>

        <p><?php echo TextMultilangHelper::label('employees-may-update-their-particulars-and-other-details-here-your-hr-will-be-automaticallt-be-notifed-of-the-new-changes'); ?></p>
    </div>

    <br>
    <div class="item-edit">
        <p style="text-transform: uppercase;border-bottom: 1px solid #FF8B03;font-weight: bold;padding-bottom: 5px;"><?php echo TextMultilangHelper::label('account-information'); ?></p>
    </div>

    <div class="frm-edit">
        <div class="item-edit">
            <?php echo $form->labelEx($model, 'username'); ?>
            <div class="ipt-edit">
                <?php echo $form->textField($model, 'username', array('class' => 'ipt', 'disabled' => true)); ?>
                <?php echo $form->error($model, 'username'); ?>
            </div>
        </div>

        <div class="item-edit">
            <?php echo $form->labelEx($model, 'email'); ?>
            <div class="ipt-edit">
                <?php echo $form->textField($model, 'email', array('class' => 'ipt')); ?>
                <?php echo $form->error($model, 'email'); ?>
            </div>
        </div>
    </div>

    <br>
    <div class="item-edit">
        <p style="text-transform: uppercase;border-bottom: 1px solid #FF8B03;font-weight: bold;padding-bottom: 5px;"><?php echo TextMultilangHelper::label('profile-information'); ?></p>
    </div>

    <div class="frm-edit">
        <div class="item-edit">
            <?php echo $form->labelEx($model, 'staff_name'); ?>
            <div class="ipt-edit">
                <?php echo $form->textField($model, 'staff_name', array('class' => 'ipt', 'maxlength' => 100)); ?>
                <?php echo $form->error($model, 'staff_name'); ?>
            </div>
        </div>

        <?php if (Yii::app()->params['first_name']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'first_name'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textField($model, 'first_name', array('class' => 'ipt', 'maxlength' => 100)); ?>
                    <?php echo $form->error($model, 'first_name'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['middle_name']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'middle_name'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textField($model, 'middle_name', array('class' => 'ipt', 'maxlength' => 100)); ?>
                    <?php echo $form->error($model, 'middle_name'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['last_name']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'last_name'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textField($model, 'last_name', array('class' => 'ipt', 'maxlength' => 100)); ?>
                    <?php echo $form->error($model, 'last_name'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['nationality']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'nationality'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textField($model, 'nationality', array('class' => 'ipt', 'maxlength' => 100)); ?>
                    <?php echo $form->error($model, 'nationality'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['permanent_resident']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'permanent_resident'); ?>
                <div class="ipt-edit">
                    <?php echo $form->dropDownList($model, 'permanent_resident', $model->optionYesNo, array('class' => 'ipt form-control','empty'=>'Select')); ?>
                    <?php echo $form->error($model, 'permanent_resident'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['fin']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'fin'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textField($model, 'fin', array('class' => 'ipt', 'maxlength' => 200)); ?>
                    <?php echo $form->error($model, 'fin'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['marital_status']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'marital_status'); ?>
                <div class="ipt-edit">
                    <?php echo $form->dropDownList($model, 'marital_status', $model->optionMaritalStatus, array('class' => 'ipt form-control','empty'=>'Select')); ?>
                    <?php echo $form->error($model, 'marital_status'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['number_of_children']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'number_of_children'); ?>
                <div class="ipt-edit">
                    <?php echo $form->numberField($model, 'number_of_children', array('class' => 'ipt', 'min' => 0)); ?>
                    <?php echo $form->error($model, 'number_of_children'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['driving_license_class_type']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'driving_license_class_type'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textField($model, 'driving_license_class_type', array('class' => 'ipt', 'maxlength' => 200)); ?>
                    <?php echo $form->error($model, 'driving_license_class_type'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['highest_education_level']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'highest_education_level'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textField($model, 'highest_education_level', array('class' => 'ipt', 'maxlength' => 200)); ?>
                    <?php echo $form->error($model, 'highest_education_level'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['certification_awarded']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'certification_awarded'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textField($model, 'certification_awarded', array('class' => 'ipt', 'maxlength' => 200)); ?>
                    <?php echo $form->error($model, 'certification_awarded'); ?>
                </div>
            </div>
        <?php } ?>


        <?php if (Yii::app()->params['office']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'office'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textField($model, 'office', array('class' => 'ipt', 'maxlength' => 200)); ?>
                    <?php echo $form->error($model, 'office'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['job_title']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'job_title'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textField($model, 'job_title', array('class' => 'ipt', 'maxlength' => 200)); ?>
                    <?php echo $form->error($model, 'job_title'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['department']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'department'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textField($model, 'department', array('class' => 'ipt', 'maxlength' => 200)); ?>
                    <?php echo $form->error($model, 'department'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['company']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'company'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textField($model, 'company', array('class' => 'ipt', 'maxlength' => 200)); ?>
                    <?php echo $form->error($model, 'company'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['gender']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'gender', array('label' => 'Gender/Sex')); ?>
                <div class="ipt-edit">
                    <?php echo $form->dropDownList($model, 'gender', $model->optionGender, array('class' => 'ipt form-control','empty'=>'Select')); ?>
                    <?php echo $form->error($model, 'gender'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['date_of_birthday']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'dob'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textField($model,'dob', array('class' => 'ipt ver_datepicker_FE', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'dob'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['skills']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'skills'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textArea($model, 'skills', array('style' => 'width:100%;', 'cols' => 48, 'rows' => 3, 'class' => 'ipt')); ?>
                    <?php echo $form->error($model, 'skills'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['educations']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'educations'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textArea($model, 'educations', array('style' => 'width:100%;', 'cols' => 48, 'rows' => 3, 'class' => 'ipt')); ?>
                    <?php echo $form->error($model, 'educations'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['certification']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'certification'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textArea($model, 'certification', array('style' => 'width:100%;', 'cols' => 48, 'rows' => 3, 'class' => 'ipt')); ?>
                    <?php echo $form->error($model, 'certification'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['languages']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'languages'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textArea($model, 'languages', array('style' => 'width:100%;', 'cols' => 48, 'rows' => 3, 'class' => 'ipt')); ?>
                    <?php echo $form->error($model, 'languages'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['associations']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'associations'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textArea($model, 'associations', array('style' => 'width:100%;', 'cols' => 48, 'rows' => 3, 'class' => 'ipt')); ?>
                    <?php echo $form->error($model, 'associations'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['about_my_self']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'about_my_self'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textArea($model, 'about_my_self', array('style' => 'width:100%;', 'cols' => 48, 'rows' => 3, 'class' => 'ipt')); ?>
                    <?php echo $form->error($model, 'about_my_self'); ?>
                </div>
            </div>
        <?php } ?>
    </div>

    <br>
    <div class="item-edit">
        <p style="text-transform: uppercase;border-bottom: 1px solid #FF8B03;font-weight: bold;padding-bottom: 5px;"><?php echo TextMultilangHelper::label('contact-information'); ?></p>
    </div>

    <div class="frm-edit">
        <?php if (Yii::app()->params['account_types']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'account_types'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textField($model, 'account_types', array('class' => 'ipt', 'maxlength' => 100)); ?>
                    <?php echo $form->error($model, 'account_types'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['country_of_residence']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'country_of_residence'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textField($model, 'country_of_residence', array('class' => 'ipt', 'maxlength' => 100)); ?>
                    <?php echo $form->error($model, 'country_of_residence'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['work_email_address']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'work_email_address'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textField($model, 'work_email_address', array('class' => 'ipt', 'maxlength' => 200)); ?>
                    <?php echo $form->error($model, 'work_email_address'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['personal_email_address']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'personal_email_address'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textField($model, 'personal_email_address', array('class' => 'ipt', 'maxlength' => 200)); ?>
                    <?php echo $form->error($model, 'personal_email_address'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['house_address']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'address'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textArea($model, 'address', array('style' => 'width:100%;', 'cols' => 48, 'rows' => 3, 'class' => 'ipt')); ?>
                    <?php echo $form->error($model, 'address'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['secondary_address']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'secondary_address'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textArea($model, 'secondary_address', array('style' => 'width:100%;', 'cols' => 48, 'rows' => 3, 'class' => 'ipt')); ?>
                    <?php echo $form->error($model, 'secondary_address'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['house_phone_number']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'home_phone_number'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textField($model, 'home_phone_number', array('class' => 'ipt', 'maxlength' => 30)); ?>
                    <?php echo $form->error($model, 'home_phone_number'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['work_phone_number']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'work_phone_number'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textField($model, 'work_phone_number', array('class' => 'ipt', 'maxlength' => 30)); ?>
                    <?php echo $form->error($model, 'work_phone_number'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['mobile_phone']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'phone'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textField($model, 'phone', array('class' => 'ipt', 'maxlength' => 30)); ?>
                    <?php echo $form->error($model, 'phone'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['twitter_accounts']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'twitter_accounts'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textField($model, 'twitter_accounts', array('class' => 'ipt', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'twitter_accounts'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['im_accounts']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'im_accounts'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textField($model, 'im_accounts', array('class' => 'ipt', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'im_accounts'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['yahoo_accounts']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'yahoo_accounts'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textField($model, 'yahoo_accounts', array('class' => 'ipt', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'yahoo_accounts'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['skype_accounts']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'skype_accounts'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textField($model, 'skype_accounts', array('class' => 'ipt', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'skype_accounts'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['viber_accounts']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'viber_accounts'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textField($model, 'viber_accounts', array('class' => 'ipt', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'viber_accounts'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['whatsapp']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'whatsapp'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textField($model, 'whatsapp', array('class' => 'ipt', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'whatsapp'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['facebook_accounts_url']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'facebook_accounts_url'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textField($model, 'facebook_accounts_url', array('class' => 'ipt', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'facebook_accounts_url'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['emergency']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'emergency'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textArea($model, 'emergency', array('style' => 'width:100%;', 'cols' => 48, 'rows' => 3, 'class' => 'ipt')); ?>
                    <?php echo $form->error($model, 'emergency'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['emergency_contact_person']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'emergency_contact_person'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textField($model, 'emergency_contact_person', array('class' => 'ipt', 'maxlength' => 200)); ?>
                    <?php echo $form->error($model, 'emergency_contact_person'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['relationship_of_emergency_contact_person']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'relationship_of_emergency_contact_person'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textField($model, 'relationship_of_emergency_contact_person', array('class' => 'ipt', 'maxlength' => 200)); ?>
                    <?php echo $form->error($model, 'relationship_of_emergency_contact_person'); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (Yii::app()->params['emergency_contact_number']) { ?>
            <div class="item-edit">
                <?php echo $form->labelEx($model, 'emergency_contact_number'); ?>
                <div class="ipt-edit">
                    <?php echo $form->textField($model, 'emergency_contact_number', array('class' => 'ipt', 'maxlength' => 30)); ?>
                    <?php echo $form->error($model, 'emergency_contact_number'); ?>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="frm-edit">
        <!--    <div class="item-edit">-->
        <!--        <label>--><?php //echo $model->getAttributeLabel('newPassword'); ?><!-- <span class="sys">*</span><br>(use only if you want to change)</label>-->
        <!--        <div class="ipt-edit">-->
        <!--            --><?php //echo $form->passwordField($model,'newPassword', array('class'=>'ipt')); ?>
        <!--            --><?php //echo $form->error($model,'newPassword'); ?>
        <!--        </div>-->
        <!--    </div>-->
        <!--    <div class="item-edit">-->
        <!--        --><?php //echo $form->labelEx($model,'password_confirm'); ?>
        <!--        <div class="ipt-edit">-->
        <!--            --><?php //echo $form->passwordField($model,'password_confirm', array('class'=>'ipt')); ?>
        <!--            --><?php //echo $form->error($model,'password_confirm'); ?>
        <!--        </div>-->
        <!--    </div>-->
    </div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    //set class my-editor-basic for basic
    //set class my-editor-full for full toolbars
    $(document).ready(function () {
        runDatePicker('<?php echo Yii::app()->theme->baseUrl; ?>', 'DD/MM/YYYY');
    });
</script>
