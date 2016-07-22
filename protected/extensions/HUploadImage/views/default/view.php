<?php $modelName = get_class($model); ?>
<div id="<?php echo $hupload->id; ?>" class="h-upload-image-wrap" data-model="<?php echo $modelName; ?>">
	<?php foreach ($hupload->attributes as $field => $options): ?>		
		<?php if ($options['type'] == 'file_field'): ?>
			<?php
			if ($hupload->multiSelect) {
				$file_name = $modelName . '[' . $field . '][]';
				echo CHtml::hiddenField($modelName . '[is_multi_select]', true);
			} else {
				$file_name = $modelName . '[' . $field . ']';
				echo CHtml::hiddenField($modelName . '[is_multi_select]', false);
			}
			echo CHtml::hiddenField('model', $modelName);
			?>
			<?php echo CHtml::hiddenField($modelName . '[fileName]', $field); ?>
			<div class='form-group form-group-sm'>
				<?php echo CHtml::activeLabelEx($model, $field, array('class' => $hupload->col1 . ' control-label')); ?>
				<div class="<?php echo $hupload->col2; ?>">					
					<?php echo CHtml::fileField($file_name, '', array('multiple' => $this->multiSelect)); ?>
					<div class='notes'>Recommended Size: <?php echo $hupload->recommendedSize ?>, Allow file type  <?php echo '*.' . str_replace(',', ', *.', $hupload->allowType); ?> - Maximum file size : <?php echo ($hupload->maxSize / 1024) / 1024; ?>M </div>
					<div class="errorMessage" tyle="display:none;"></div>
				</div>
			</div>
		<?php endif; ?>
		<?php if ($options['type'] == 'text_area'): ?>
			<div class='form-group form-group-sm'>
				<?php echo CHtml::activeLabelEx($model, $field, array('class' => $hupload->col1 . ' control-label')); ?>
				<div class="<?php echo $hupload->col2; ?>">				
					<?php echo CHtml::textArea($modelName . '[' . $field . ']', '', array('cols' => 63, 'rows' => 5)); ?>
					<div class="errorMessage" tyle="display:none;"></div>
				</div>
			</div>
		<?php endif; ?>
		<?php if ($options['type'] == 'hidden_field'): ?>
			<?php echo CHtml::hiddenField($modelName . '[' . $field . ']', $options['value']); ?>
		<?php endif; ?>
	<?php endforeach; ?>

	<!--static field-->
	<?php echo CHtml::hiddenField($modelName . '[model]', $modelName); ?>
	<?php echo CHtml::hiddenField($modelName . '[parentField]', $hupload->parentField); ?>
	<?php echo CHtml::hiddenField('actionType', 'add'); ?>
	<?php echo CHtml::hiddenField($modelName . '[isTitle]', $hupload->title); ?>
	<?php echo CHtml::hiddenField($modelName . '[isDescription]', $hupload->description); ?>
	<?php echo CHtml::hiddenField($modelName . '[sortField]', $hupload->sortField, array('class' => '')); ?>
	<?php echo CHtml::hiddenField($modelName . '[template]', $hupload->template, array('class' => '')); ?>
	<div class='form-group form-group-sm'>
		<?php echo CHtml::label('', '', array('class' => $hupload->col1 . ' control-label')); ?>
		<div class="col-sm-3">		
			<button class="btn btn-primary btn-sm" onclick="addImageH($(this), '<?php echo $hupload->form_id; ?>', '<?php echo $hupload->id; ?>', '<?php echo $modelName; ?>')" data-action="<?php echo $hupload->action; ?>" type="button">Add Image</button>
			<img class="loading" style="width: 20px; height: 20px; display: none;" src="<?php echo Yii::app()->theme->baseUrl; ?>/admin/images/loading.gif">
		</div>
	</div>

	<div class='form-group form-group-sm'>
		<?php echo CHtml::label('', '', array('class' => $hupload->col1 . ' control-label')); ?>
		<div class="<?php echo $hupload->col3; ?>">
			<div class="line"></div>
		</div>
	</div>
	<div class='form-group form-group-sm'>
		<?php echo CHtml::label('', '', array('class' => $hupload->col1 . ' control-label')); ?>
		<div class="<?php echo $hupload->col3; ?> image-wrap-h ui-sortable <?php echo $hupload->isSortable ? 'hupload-sortable' : '';?>" id="image-item-<?php echo $hupload->id; ?>">
			<?php
			if ($hupload->related) {
				foreach ($hupload->related as $item) {
					include '_item.php';
				}
			}
			?>
		</div>
	</div>
</div>
<script>
	hSortable('<?php echo $hupload->id; ?>','<?php echo $hupload->form_id; ?>','<?php echo $hupload->action; ?>','<?php echo $modelName; ?>');
</script>