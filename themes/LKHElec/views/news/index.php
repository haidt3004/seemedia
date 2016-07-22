<div class="mainchild">
	<div class="wrapper clearfix fullwidth">
		<!-- News banner -->
		<?php $this->widget('BannerWidget',array('group_banner_id' => 3,'layout' => 'inner_page_banner')); ?>
		<!-- End News banner -->

		<div class="maincontent">
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
