<?php $modelName = get_class($data); ?>
<?php $elementId = "thumbnail-h-" . $modelName . '-' . $data->id; ?>
<li class="thumbnail-h" id="<?php echo $elementId; ?>">
    <div class="image">
		<?php echo CHtml::image(ImageHelper::getImageUrl($data, 'file_name', 'thumb'), $data->file_name, array()) . " "; ?>
		<?php if ($hupload->setMainImage) : ?>
			<?php if ($data->{$hupload->mainImageField} != 1) : ?>
				<a title="" class="del-icon-h control-tooltip" href="javascript:;" data-original-title="Delete" onClick="hupload.v2.deleteHImage($(this))" data-update="<?php echo $hupload->update_id; ?>" data-model="<?php echo $modelName; ?>" data-id="<?php echo $data->id; ?>" data-action="<?php echo $hupload->action; ?>">
					<img alt="delete" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ico-delete.png">
				</a>
			<?php endif; ?>
		<?php else: ?>
			<a title="" class="del-icon-h control-tooltip" href="javascript:;" data-original-title="Delete" onClick="hupload.v2.deleteHImage($(this))" data-update="<?php echo $hupload->update_id; ?>" data-model="<?php echo $modelName; ?>" data-id="<?php echo $data->id; ?>" data-action="<?php echo $hupload->action; ?>">
				<img alt="delete" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ico-delete.png">
			</a>
		<?php endif; ?>
    </div>

	<?php if ($hupload->setMainImage) : ?>
		<?php if ($data->{$hupload->mainImageField} != 1) : ?>
			<a class="btn-1" href="javascript:;" onClick="hupload.v2.setAsMainImage($(this))" data-updatefield="<?php echo $hupload->mainImageField; ?>"  data-parentfield="<?php echo $hupload->parentField; ?>"  data-parentid="<?php echo $data->{$hupload->parentField}; ?>" data-model="<?php echo $modelName; ?>" data-id="<?php echo $data->id; ?>" data-update="<?php echo $hupload->update_id; ?>" data-action="<?php echo $hupload->action; ?>">Set as main</a>
		<?php endif; ?>
	<?php endif; ?>
</li>
