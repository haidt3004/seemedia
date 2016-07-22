<?php if ($hupload->related): ?>
	<?php foreach ($hupload->related as $item): ?>
		<div class="thumbnail-h">
			<?php echo CHtml::image(ImageHelper::getImageUrl($item, $hupload->attribute, $hupload->viewSize), $item->{$hupload->attribute}, array()) . " "; ?>
		</div>
	<?php endforeach; ?>
<?php endif;