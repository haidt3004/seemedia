<?php $modelName = get_class($item); ?>
<?php $elementId = "thumbnail-h-" . $modelName . '-' . $item->id; ?>
<div class="thumbnail-h" id="<?php echo $elementId; ?>">
	<img src="<?php echo Yii::app()->theme->baseUrl; ?>/admin/images/delete.png" onClick="deleteHImage($(this), '<?php echo $item->id; ?>', '<?php echo $modelName; ?>', '<?php echo $elementId; ?>')" data-action="<?php echo $hupload->action; ?>"
		 class="btn pull-right del-icon-h">
		 <?php echo CHtml::image(ImageHelper::getImageUrl($item, 'file_name', 'thumb'), $item->file_name, array()) . " "; ?>
	<div class="h-text">
		<?php echo !empty($hupload->title) ? '<b>' . $item->{$hupload->title} . '</b>' : ''; ?>
		<?php echo !empty($hupload->description) ? '<p>' . $item->{$hupload->description} . '</p>' : ''; ?>
	</div>
	<?php if ($hupload->isSortable): ?>
		<?php echo CHtml::hiddenField($modelName . 'HSORT[sort][' . $item->id . ']', $item->{$hupload->sortField}, array('class' => 'display_order')); ?>
		<?php echo CHtml::hiddenField($modelName . 'HSORT[id][' . $item->id . ']', $item->id, array('class' => '')); ?>		
	<?php endif; ?>
</div>