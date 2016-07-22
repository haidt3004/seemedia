<div class="banner-home">
	<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="4000">


		<!-- Wrapper for slides -->
		<div class="carousel-inner" role="listbox">
			<?php foreach ($models as $key => $model): ?>
				<div class="item <?php echo $key == 0 ? 'active' : ''; ?>">
<!--					<img src="--><?php //echo $model->getImageUrl($model->fieldNameImage); ?><!--" alt="">-->
					<?php echo $model->getImage('center-block'); ?>
				</div>
			<?php endforeach; ?>
		</div>


	</div>
</div>