<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><span class="<?php echo $model->isNewRecord ? $this->iconCreate : $this->iconEdit; ?>"></span> <?php echo $model->isNewRecord ? 'Create' : 'Update'; ?> <?php echo $this->singleTitle ?></h3>
	</div>
	<div class="panel-body">
		<div class="form">
			<?php
			$form = $this->beginWidget('CActiveForm', array(
				'id' => 'group-banner-form',
				'enableAjaxValidation' => false,
				'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data'),
			));
			?>
			
			<div class='form-group form-group-sm'>
				<?php echo $form->labelEx($model, 'group_banner_type', array('class' => 'col-sm-1 control-label')); ?>
				<div class="col-sm-3">
					<?php echo $form->dropDownList($model, 'group_banner_type', GroupBanner::$arrGroupBannerType, array('class' => 'form-control')); ?>
					<?php echo $form->error($model, 'group_banner_type'); ?>
				</div>
			</div>
			
			<div class='form-group form-group-sm'>
				<?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-1 control-label')); ?>
				<div class="col-sm-3">
					<?php echo $form->textField($model, 'name', array('class' => 'form-control', 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'name'); ?>
				</div>
			</div>
			<div class='form-group form-group-sm'>
				<?php echo $form->labelEx($model, 'recommended_width', array('class' => 'col-sm-1 control-label')); ?>
				<div class="col-sm-3">
					<?php echo $form->textField($model, 'recommended_width', array('class' => 'form-control', 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'recommended_width'); ?>
				</div>
			</div>
			<div class='form-group form-group-sm'>
				<?php echo $form->labelEx($model, 'recommended_height', array('class' => 'col-sm-1 control-label')); ?>
				<div class="col-sm-3">
					<?php echo $form->textField($model, 'recommended_height', array('class' => 'form-control', 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'recommended_height'); ?>
				</div>
			</div>
			<div class='form-group form-group-sm'>
				<?php echo $form->labelEx($model, 'type', array('class' => 'col-sm-1 control-label')); ?>
				<div class="col-sm-3">
					<?php echo $form->dropDownList($model, 'type', GroupBanner::$groupTypes, array('class' => 'form-control')); ?>
					<?php echo $form->error($model, 'type'); ?>
				</div>
			</div>

			<div class='form-group form-group-sm' id="display_in_url">
				<?php echo $form->labelEx($model, 'display_in_url', array('class' => 'col-sm-1 control-label', 'label' => 'Display In Url <span class="required">*</span>')); ?>
				<div class="col-sm-3">
					<div class="notes">Enter the Urls you want banner occurs. One line per Url</div>
					<?php echo $form->textArea($model, 'display_in_url', array('class' => 'col-sm-12', 'cols' => 63, 'rows' => 5)); ?>
					<?php echo $form->error($model, 'display_in_url'); ?>
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
<script>
	banner.setGroupUrl('<?php echo GroupBanner::GROUP_URL; ?>');
	banner.setGroupPosition('<?php echo GroupBanner::GROUP_POSITION; ?>');
</script>