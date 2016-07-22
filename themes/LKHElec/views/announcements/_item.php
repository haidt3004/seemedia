<div class="list-news-item">
	<a href="<?php echo Yii::app()->createAbsoluteUrl('announcements/detail', array('slug' => $data->slug)); ?>">
		<?php echo $data->getTitle(); ?>
	</a>
	<p class="date"><i><?php echo date_format(date_create($data->created_date), "F j, Y");  ?></i></p>
	<p class="learn-more"><a href="<?php echo Yii::app()->createAbsoluteUrl('announcements/detail', array('slug' => $data->slug)); ?>"><i class="fa fa-caret-right"></i>READ MORE</a></p>
</div>