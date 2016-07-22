<div class="main">
	<div class="wrapper clearfix">
		<div class="colleft">
			<div class="box-last-news">
				<div class="page-header-left">
					Latest Announcement
				</div>
				<?php foreach($models as $model) : ?>
					<div class="item-news">
						<a href="<?php echo Yii::app()->createAbsoluteUrl('announcements/detail', array('slug' => $model->slug)); ?>"><?php echo $model->title; ?></a>
						<p class="date"><?php echo date_format(date_create($model->created_date), "F j, Y");  ?></p>
					</div>
				<?php endforeach; ?>
				<p class="learn-more"><a href="<?php echo Yii::app()->createAbsoluteUrl('announcements'); ?>"><i class="fa fa-caret-right"></i>READ MORE</a></p>
			</div>
			<!-- whisle blow banner -->
			<?php $this->widget('BannerWidget',array('group_banner_id' => WHISTLE_BLOW_HOME_BANNER,'layout' => 'home_whistle_blow')); ?>
			<!-- End whisle blow banner -->
		</div>
		<div class="colright">

			<!-- Home banner -->
			<?php $this->widget('BannerWidget',array('group_banner_id' => HOME_BANNER,'layout' => 'home_banner')); ?>
			<!-- End Home banner -->

			<div class="group-box-news clearfix">

				<?php foreach($modelHomes as $modelHome) : ?>

					<div class="box-item-news">
						<div class="img-box-news">
							<a href="<?php echo Yii::app()->createAbsoluteUrl('announcements/detail', array('slug' => $modelHome->slug)); ?>"><?php echo $modelHome->getFeaturedImage(); ?></a>
						</div>
						<div class="info-box-news">
							<a href="<?php echo Yii::app()->createAbsoluteUrl('announcements/detail', array('slug' => $modelHome->slug)); ?>"><?php echo $modelHome->title; ?></a>
							<p class="date-new"><?php echo date_format(date_create($modelHome->created_date), "F j, Y");  ?></p>
							<p><?php echo $modelHome->short_content; ?></p>
							<a href="<?php echo Yii::app()->createAbsoluteUrl('announcements/detail', array('slug' => $modelHome->slug)); ?>" class="r-more"><i class="fa fa-caret-right"></i>CLICK HERE</a>
						</div>
					</div>

				<?php endforeach; ?>

			</div>
		</div>
	</div>
</div>
