<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><span class="<?php echo $model->isNewRecord ? $this->iconCreate : $this->iconEdit; ?>"></span> <?php echo $model->isNewRecord ? 'Create' : 'Update'; ?> <?php echo $this->singleTitle ?></h3>
	</div>
	<div class="panel-body">
		<div class="form">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id' => 'login-logs-form',
			'enableAjaxValidation'=>false,
			'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data'),
		)); ?>
			<div class='form-group form-group-sm'>
					<?php echo $form->labelEx($model,'username', array('class' => 'col-sm-1 control-label')); ?>
					<div class="col-sm-3">
						<?php echo $form->textField($model,'username', array('class' => 'form-control', 'maxlength' => 255)); ?>
						<?php echo $form->error($model,'username'); ?>
					</div>
			</div>
    
			<div class='form-group form-group-sm'>
					<?php echo $form->labelEx($model,'email', array('class' => 'col-sm-1 control-label')); ?>
					<div class="col-sm-3">
						<?php echo $form->textField($model,'email', array('class' => 'form-control', 'maxlength' => 255)); ?>
						<?php echo $form->error($model,'email'); ?>
					</div>
			</div>
    
			<div class='form-group form-group-sm'>
					<?php echo $form->labelEx($model,'login', array('class' => 'col-sm-1 control-label')); ?>
					<div class="col-sm-3">
						<?php echo $form->textField($model,'login', array('class' => 'form-control', 'maxlength' => 255)); ?>
						<?php echo $form->error($model,'login'); ?>
					</div>
			</div>
    
			<div class='form-group form-group-sm'>
					<?php echo $form->labelEx($model,'logout', array('class' => 'col-sm-1 control-label')); ?>
					<div class="col-sm-3">
						<?php echo $form->textField($model,'logout', array('class' => 'form-control', 'maxlength' => 255)); ?>
						<?php echo $form->error($model,'logout'); ?>
					</div>
			</div>
    
			<div class='form-group form-group-sm'>
					<?php echo $form->labelEx($model,'status', array('class' => 'col-sm-1 control-label')); ?>
					<div class="col-sm-3">
						<?php echo $form->dropDownList($model,'status', $model->optionActive, array('class' => 'form-control')); ?>
						<?php echo $form->error($model,'status'); ?>
					</div>
			</div>
    
			<div class='form-group form-group-sm'>
					<?php echo $form->labelEx($model,'ip_address', array('class' => 'col-sm-1 control-label')); ?>
					<div class="col-sm-3">
						<?php echo $form->textField($model,'ip_address', array('class' => 'form-control', 'maxlength' => 255)); ?>
						<?php echo $form->error($model,'ip_address'); ?>
					</div>
			</div>
    
			
			<div class="clr"></div>
			<div class="well">
				<?php echo CHtml::htmlButton($model->isNewRecord ? '<span class="' . $this->iconCreate . '"></span> Create' : '<span class="' . $this->iconSave . '"></span> Save', array('class' => 'btn btn-primary', 'type' => 'submit')); ?> &nbsp;  
				<?php echo CHtml::htmlButton('<span class="' . $this->iconCancel . '"></span> Cancel', array('class' => 'btn btn-default', 'onclick' => 'javascript: location.href=\'' . $this->baseControllerIndexUrl() . '\'')); ?>
			</div>
		<?php $this->endWidget(); ?>
		</div>
	</div>
</div>