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
                <?php echo $form->labelEx($model, 'staff_name', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model, 'staff_name', array('class' => 'form-control', 'maxlength' => 50)); ?>
                    <?php echo $form->error($model, 'staff_name'); ?>
                </div>
            </div>

            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'company', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model, 'company', array('class' => 'form-control', 'maxlength' => 50)); ?>
                    <?php echo $form->error($model, 'company'); ?>
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
                    <?php echo $form->textField($model, 'email', array('class' => 'form-control', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'email'); ?>
                </div>
            </div>


            <?php if (!$model->isNewRecord) { ?>
            <div class='form-group form-group-sm'>
                <label class="col-sm-2 control-label required"><?php echo $model->getAttributeLabel('currentPassword'); ?> <span class="required">*</span></label>
                <div class="col-sm-3">
                    <?php echo $form->passwordField($model, 'currentPassword', array('class' => 'form-control', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'currentPassword'); ?>
                </div>
            </div>
            <div class='form-group form-group-sm'>
                <label class="col-sm-2 control-label required"><?php echo $model->getAttributeLabel('newPassword'); ?> <span class="required">*</span></label>
                <div class="col-sm-3">
                    <?php echo $form->passwordField($model, 'newPassword', array('class' => 'form-control', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'newPassword'); ?>
                </div>
            </div>
            <?php } else { ?>
            <div class='form-group form-group-sm'>
                <label class="col-sm-2 control-label required"><?php echo $model->getAttributeLabel('temp_password'); ?> <span class="required">*</span></label>
                <div class="col-sm-3">
                    <?php echo $form->passwordField($model, 'temp_password', array('class' => 'form-control', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'temp_password'); ?>
                </div>
            </div>
            <?php } ?>
            <div class='form-group form-group-sm'>
                <label class="col-sm-2 control-label required"><?php echo $model->getAttributeLabel('password_confirm'); ?> <span class="required">*</span></label>
                <div class="col-sm-3">
                    <?php echo $form->passwordField($model, 'password_confirm', array('class' => 'form-control', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'password_confirm'); ?>
                </div>
            </div>
            <div class='form-group form-group-sm'>
                <label class="col-sm-2 control-label required"><?php echo $model->getAttributeLabel('status'); ?> <span class="required">*</span></label>
                <div class="col-sm-3">
                    <?php echo $form->dropDownList($model, 'status', $model->optionActive, array('class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'status'); ?>
                </div>
            </div>     

            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'address', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model, 'address', array('class' => 'form-control', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'address'); ?>
                </div>
            </div>
            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'phone', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model, 'phone', array('class' => 'form-control', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'phone'); ?>
                </div>
            </div>
            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'emergency', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model, 'emergency', array('class' => 'form-control', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'emergency'); ?>
                </div>
            </div>
            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'emergency_contact_number', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model, 'emergency_contact_number', array('class' => 'form-control', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'emergency_contact_number'); ?>
                </div>
            </div>



            <div class="clr"></div>
            <div class="well">
                <?php echo CHtml::htmlButton($model->isNewRecord ? '<span class="' . $this->iconCreate . '"></span> Create' : '<span class="' . $this->iconSave . '"></span> Save', array('class' => 'btn btn-primary', 'type' => 'submit')); ?> &nbsp;
                <?php if (!$model->isNewRecord) echo CHtml::htmlButton('<span class="' . $this->iconCancel . '"></span> Cancel', array('class' => 'btn btn-default', 'onclick' => 'javascript: location.href=\'' . $this->baseControllerIndexUrl() . '\'')); ?>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>