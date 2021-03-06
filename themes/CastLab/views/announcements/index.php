<div class="mainchild">
	<div class="wrapper clearfix fullwidth">
		<!-- News banner -->
		<?php $this->widget('BannerWidget',array('group_banner_id' => ANNOUNCEMENT_BANNER,'layout' => 'inner_page_banner')); ?>
		<!-- End News banner -->

		<div class="colleft">
			<div class="box-last-news">
				<div class="page-header-left">
					Announcement
				</div>
				<ul class="submenu">
					<?php

					foreach (Announcement::getTimeExist() as $key => $value) { ?>

						<li class="">
							<a href="<?php echo Yii::app()->createAbsoluteUrl('announcements/archive',array('year' => $key ));?>"><i class="fa fa-caret-right"></i><?php echo $key; ?></a>
							<ul>
								<?php foreach ($value as $item) { ?>
									<li class="">
										<a href="<?php echo Yii::app()->createAbsoluteUrl('announcements/archive',array('year' => $key, 'month' => $item ));?>">
											<i class="fa fa-caret-right"></i><?php echo DateTime::createFromFormat('!m', $item)->format('F') ?>
										</a>
									</li>
								<?php } ?>
							</ul>
						</li>

					<?php } ?>
				</ul>
			</div>

		</div>

		<div class="colright maincontent">
			<?php
			$widget = $this->widget('zii.widgets.CListView', array(
				'dataProvider' => $dataProvider,
				'ajaxUpdate' => false,
				'id' => 'news-list-view',
				'loadingCssClass' => false,
				'itemView' => '_item',
				'itemsTagName' => 'div',
				'itemsCssClass' => "",
				'pagerCssClass' => 'bottom-pager',
				'template' => "{items}{pager}",
				'enablePagination' => true,
				'pagerCssClass' => 'pagination-box-top',
				'pager' => array(
					'maxButtonCount' => 3,
					'header' => false,
					'firstPageLabel' => "&laquo; First",
					'prevPageLabel' => "&lsaquo; Previous",
					'nextPageLabel' => "Next &rsaquo;",
					'lastPageLabel' => "Last &raquo;",
					'nextPageCssClass' => false,
					'previousPageCssClass' => false,
					'cssFile' => false,
					'selectedPageCssClass' => 'selected',
					'htmlOptions' => array(
						'class' => 'pagination',
						'style' => '',
						'id' => ''
					),
				),
			));
			?>
		</div>
	</div><!-- //wrapper -->
</div>

<?php
Yii::app()->clientScript->registerScript('addClassListNews', "
			$('#news-list-view .list-news-item').last().addClass('noborder');
		");
?>
