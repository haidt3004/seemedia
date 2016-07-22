<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><span class="<?php echo $model->isNewRecord ? $this->iconCreate : $this->iconEdit; ?>"></span> <?php echo $model->isNewRecord ? 'Create' : 'Update'; ?> <?php echo $this->singleTitle ?></h3>
	</div>
	<div class="panel-body">
		<div class="form">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id' => 'text-translate-form',
			'enableAjaxValidation'=>false,
			'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data'),
		)); ?>
			<div class='form-group form-group-sm'>
					<?php echo $form->labelEx($model,'title', array('class' => 'col-sm-1 control-label')); ?>
					<div class="col-sm-3">
						<?php echo $form->textField($model,'title', array('class' => 'form-control', 'maxlength' => 255)); ?>
						<?php echo $form->error($model,'title'); ?>
					</div>
			</div>
    
			<div class='form-group form-group-sm'>
					<?php echo $form->labelEx($model,'content', array('class' => 'col-sm-1 control-label')); ?>
					<div class="col-sm-3">
						<?php echo $form->textField($model,'content', array('class' => 'form-control', 'maxlength' => 255)); ?>
						<?php echo $form->error($model,'content'); ?>
					</div>
			</div>
    
			<div class='form-group form-group-sm'>
					<?php echo $form->labelEx($model,'slug', array('class' => 'col-sm-1 control-label')); ?>
					<div class="col-sm-3">
						<?php echo $form->textField($model,'slug', array('class' => 'form-control', 'maxlength' => 255)); ?>
						<?php echo $form->error($model,'slug'); ?>
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