<?php $data->getDataTranslate(); ?>
<div class="list-news-item">
	<a href="<?php echo Yii::app()->createAbsoluteUrl('announcements/detail', array('slug' => $data->slug)); ?>">
		<?php echo $data->getTitle(); ?>
	</a>
	<p class="date"><i><?php echo DateHelper::toDateMultiLang($data->created_date);  ?></i></p>
	<p class="learn-more"><a href="<?php echo Yii::app()->createAbsoluteUrl('announcements/detail', array('slug' => $data->slug)); ?>"><i class="fa fa-caret-right"></i><?php echo TextMultilangHelper::label('read-more'); ?></a></p>
</div>