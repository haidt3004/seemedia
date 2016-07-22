<div class="featured-listing">
	<div class="box-heading">Featured <span>Listings</span></div>
	<div class="clear"></div>
	<div class="flexslider" id="flexslider2">
		<ul class="slides">
			<?php foreach ($models as $model): ?>				
				<li>
					<div class="flex-caption">
						<figure><a class="tracking" data-id="<?php echo $model->id; ?>" <?php echo !empty($model->link) ? 'target = "_blank"' : ''; ?> href="<?php echo !empty($model->link) ? $model->link : 'javascript:;'; ?>"><?php echo $model->renderImage('large_sub'); ?></a></figure>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
