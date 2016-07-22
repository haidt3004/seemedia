<?php
$this->breadcrumbs = array(
	'Banners' => Yii::app()->createAbsoluteUrl('admin/groupbanners/index'),
	$groupName->name => array('index', 'group_id' => $groupName->id),
	'View : ' . $title_name,
);

$this->menu = array(
	array('label' => $this->pluralTitle, 'url' => array('index', 'group_id' => $groupName->id), 'icon' => $this->iconList),
	array('label' => 'Update ' . $this->singleTitle, 'url' => array('update', 'id' => $model->id, 'group_id' => $groupName->id)),
//	array('label' => 'Create ' . $this->singleTitle, 'url' => array('create', 'group_id' => $groupName->id)),
);
?>
<h1>View <?php echo $this->singleTitle . ' : ' . $title_name; ?></h1>

<?php
//for notify message
$this->renderNotifyMessage();
//for list action button
echo $this->renderControlNav();
?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><span class="glyphicon glyphicon-list-alt"></span> View <?php echo $this->singleTitle ?></h3>
	</div>
	<div class="panel-body">
		<?php
		$this->widget('zii.widgets.CDetailView', array(
			'data' => $model,
			'attributes' => array(
//				array(
//					'name' => 'banner_type',
//					'value' => $model->getBannerType(),
//				),
				array(
					'name' => 'banner_title',
					'type' => 'html',
				),
//				array(
//					'name' => 'banner_title_2',
//					'type' => 'html',
//					'visible' => $model->checkVisible('banner_title_2')
//				),
//				array(
//					'name' => 'banner_description',
//					'type' => 'html',
//					'visible' => $model->checkVisible('banner_description')
//				),
				array(
					'name' => 'group_banner_id',
					'value' => GroupBanner::model()->find("id = " . $model->group_banner_id . "")->name,
				),
//				array(
//					'name' => 'google_adsense_script',
//					'visible' => $model->checkVisible('google_adsense_script')
//				),
				array(
					'name' => 'large_image',
					'type' => 'raw',
					'value' => $model->getImage("","width:300px;"),
					'visible' => $model->checkVisible('large_image'),

				),
//				array(
//					'label' => 'Total Click',
//					'value' => $model->getNumberOfClick(),
//					'visible' => $model->checkVisible("total_click")
//				),
				array(
					'name' => 'link',
					'visible' => $model->checkVisible("link")
				),
				array(
					'name' => 'link_text',
					'visible' => $model->checkVisible("link_text")
				),
				array(
					'name' => 'language_id',
					'value' => $model->getLanguageName(),
				),
//				'order_display',
				array(
					'name' => 'created_date',
					'type' => 'date',
				),
				'status:status'
			),
		));
		?>
		<div class="well">
			<?php echo CHtml::htmlButton('<span class="' . $this->iconBack . '"></span> Back', array('class' => 'btn btn-default', 'onclick' => 'javascript: location.href=\'' . $this->baseControllerIndexUrl() . '\'')); ?>
		</div>
	</div>
</div>

