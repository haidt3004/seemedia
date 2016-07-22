<?php foreach ($models as $model): ?>
	<div class="small-ad-box">
		<?php if ($model->select_type == $modelName::BANNER_IMAGE_TYPE): ?>
			<a class="tracking" data-id="<?php echo $model->id; ?>" <?php echo !empty($model->link) ? 'target = "_blank"' : ''; ?> href="<?php echo $model->link; ?>"><?php echo $model->renderImage('large'); ?></a>
		<?php else: ?>
			<?php echo $model->getScript(); ?>
		<?php endif; ?>
	</div>
<?php endforeach; ?>
