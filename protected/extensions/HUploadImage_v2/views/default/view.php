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
					<?php if (!$hupload->autoUpload): ?>
						<?php echo CHtml::fileField($file_name, '', array('multiple' => $this->multiSelect)); ?>
					<?php else: ?>
						<?php echo CHtml::fileField($file_name, '', array('class' => 'uploadfile', 'multiple' => $this->multiSelect, 'onChange' => "hupload.v2.addImageH($(this))", 'data-update' => $hupload->update_id, 'data-target' => $hupload->id, 'data-model' => $modelName, 'data-formid' => $hupload->form_id, 'data-action' => "{$hupload->action}")); ?>
					<?php endif; ?>
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
	<?php echo CHtml::hiddenField($modelName . '[sortField]', $hupload->sortField); ?>
	<?php echo CHtml::hiddenField($modelName . '[template]', $hupload->template); ?>
	<!--new-->
	<?php echo CHtml::hiddenField($modelName . '[setMainImage]', $hupload->setMainImage); ?>
	<?php echo CHtml::hiddenField($modelName . '[mainImageFunc]', $hupload->mainImageFunc); ?>
	<?php echo CHtml::hiddenField($modelName . '[mainImageField]', $hupload->mainImageField); ?>

	<?php if (!$hupload->autoUpload): ?>
		<div class='form-group form-group-sm'>
			<?php echo CHtml::label('', '', array('class' => $hupload->col1 . ' control-label')); ?>
			<div class="col-sm-3">		
				<button class="btn btn-primary btn-sm" onclick="hupload.v2.addImageH($(this), '<?php echo $hupload->form_id; ?>', '<?php echo $hupload->id; ?>', '<?php echo $modelName; ?>')" data-action="<?php echo $hupload->action; ?>" type="button">Add Image</button>
				<img class="loading" style="width: 20px; height: 20px; display: none;" src="<?php echo Yii::app()->theme->baseUrl; ?>/admin/images/loading.gif">
			</div>
		</div>
	<?php endif; ?>

	<div class='form-group form-group-sm'>
		<?php echo CHtml::label('', '', array('class' => $hupload->col1 . ' control-label')); ?>
		<div class="<?php echo $hupload->col3; ?>">
			<div class="line"></div>
		</div>
	</div>

	<div class="form-group form-group-sm">
		<?php echo CHtml::label('', '', array('class' => $hupload->col1 . ' control-label')); ?>
		<div class="col-sm-5">
			<?php
			$widget = $this->widget('zii.widgets.CListView', array(
				'dataProvider' => $hupload->related,
				'id' => $hupload->update_id,
				'itemView' => $hupload->template . '/_item',
				'viewData' => array('hupload' => $hupload),
				'itemsTagName' => 'ul',
				'itemsCssClass' => 'photo-grid clearfix image-wrap-h ui-sortable',
				'loadingCssClass' => false,
				'pagerCssClass' => 'bottom-pager',
				'template' => "{items}",
				'enablePagination' => false,
			));
			?>
		</div>
	</div>


</div>
<script>
	hupload.v2.hSortable('<?php echo $hupload->id; ?>', '<?php echo $hupload->form_id; ?>', '<?php echo $hupload->action; ?>', '<?php echo $modelName; ?>');
</script>