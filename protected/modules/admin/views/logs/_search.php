<div class="panel panel-default">
  <div class="panel-body">

	<?php $form = $this->beginWidget('CActiveForm', array(
		'action'=>Yii::app()->createUrl($this->route),
		'method'=>'get',
		'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form', 'id' => 'search-form'),
	)); ?>
			<div class="col-sm-4">
				<div class="form-group form-group-sm">
					<?php echo $form->labelEx($model,'username', array('class' => 'col-sm-3 control-label')); ?>
					<div class="col-sm-7">
						<?php echo $form->textField($model,'username', array('class' => 'form-control')); ?>
						<?php echo $form->error($model,'username'); ?>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group form-group-sm">
					<?php echo $form->labelEx($model,'email', array('class' => 'col-sm-3 control-label')); ?>
					<div class="col-sm-7">
						<?php echo $form->textField($model,'email', array('class' => 'form-control')); ?>
						<?php echo $form->error($model,'email'); ?>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group form-group-sm">
					<?php echo $form->labelEx($model,'login', array('class' => 'col-sm-3 control-label')); ?>
					<div class="col-sm-7">
						<?php echo $form->textField($model,'login', array('class' => 'my-datepicker-control form-control')); ?>
						<?php echo $form->error($model,'login'); ?>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group form-group-sm">
					<?php echo $form->labelEx($model,'logout', array('class' => 'col-sm-3 control-label')); ?>
					<div class="col-sm-7">
						<?php echo $form->textField($model,'logout', array('class' => 'my-datepicker-control form-control')); ?>
						<?php echo $form->error($model,'logout'); ?>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group form-group-sm">
					<?php echo $form->labelEx($model,'status', array('class' => 'col-sm-3 control-label')); ?>
					<div class="col-sm-7">
						<?php echo $form->dropDownList($model,'status', $model->optionActive, array('class' => 'form-control')); ?>
						<?php echo $form->error($model,'status'); ?>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group form-group-sm">
					<?php echo $form->labelEx($model,'ip_address', array('class' => 'col-sm-3 control-label')); ?>
					<div class="col-sm-7">
						<?php echo $form->textField($model,'ip_address', array('class' => 'form-control')); ?>
						<?php echo $form->error($model,'ip_address'); ?>
					</div>
				</div>
			</div>
	<div class="col-sm-12">
		<div class="well">
			<?php echo CHtml::htmlButton('<span class="' . $this->iconSearch .  '"></span> Search', array('class' => 'btn btn-default btn-sm', 'type' => 'submit')); ?>			
			<?php echo CHtml::htmlButton('<span class="' . $this->iconCancel . '"></span> Clear', array('class' => 'btn btn-default btn-sm', 'type' => 'reset', 'id' => 'clearsearch')); ?>
		</div>
	</div> 
	<?php $this->endWidget(); ?>

	</div>
</div>

