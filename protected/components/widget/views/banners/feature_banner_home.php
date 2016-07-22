<div class="module-container-left">
	<h2 class="title-box">Featured Listing</h2>
	<div class="clear"></div>
	<div class="flexslider" id="flexslider1">
		<ul class="slides">
			<?php foreach ($models as $model): ?>
			<li>
				<div class="flex-caption">
					<figure>
						<a class="tracking" data-id="<?php echo $model->id; ?>" <?php echo !empty($model->link) ? 'target = "_blank"' : ''; ?> href="<?php echo !empty($model->link) ? $model->link : 'javascript:;'; ?>">
							<?php echo $model->renderImage('large'); ?>
						</a>
					</figure>
				</div>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>