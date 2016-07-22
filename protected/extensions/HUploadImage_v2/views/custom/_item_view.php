<?php if ($hupload->related): ?>
	<ul class="photo-grid clearfix image-wrap-h ui-sortable">
		<?php foreach ($hupload->related as $item): ?>
			<li>
				<div class="image">
					<?php echo CHtml::image(ImageHelper::getImageUrl($item, $hupload->attribute, $hupload->viewSize), $item->{$hupload->attribute}, array()) . " "; ?>
				</div>

			</li>
		<?php endforeach; ?>
	</ul>
<?php endif;?>

