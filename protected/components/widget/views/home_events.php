<?php if($models) { ?>
<section class="event-box">
	<h3><span class="icon-calendar"></span> Events</h3>
	<div class="content">
		<ul class="clearfix">
			<?php foreach($models as $model) { 
			$url = Yii::app()->createAbsoluteUrl('event/detail', array('slug'=>$model->slug));
			?>
			<li>
				<div class="image">
					<a href="<?php echo $url;?>"><img src="<?php echo ImageHelper::getImageUrl($model, 'image', 'thumb2');?>" alt="<?php echo $model->name;?>" /></a>
				</div>
				<div class="descript">
					<p class="title"><a href="<?php echo $url;?>"><?php echo $model->name;?></a></p>
					<p><?php echo $model->description;?></p>
					<p class="see-more"><a href="<?php echo $url;?>">See more &raquo;</a></p>
				</div>
			</li>
			<?php } ?>
		</ul>
	</div>
</section>
<?php } ?>