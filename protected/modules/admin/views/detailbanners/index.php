<?php
$this->breadcrumbs = array(
	'Banners' => Yii::app()->createAbsoluteUrl('admin/groupbanners/index'),
	$groupName->name,
);

$this->menu = array(
	array('label' => 'Create ' . $this->singleTitle, 'url' => array('create', 'group_id' => $groupName->id)),
	array('label' => 'Back to <strong>"' . $groupName->name . '"</strong> banner', 'url' => array('groupbanners/index'), 'icon' => $this->iconBack),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('banner-grid', {
                url : $(this).attr('action'),
		data: $(this).serialize()
	});
	return false;
});

$('#clearsearch').click(function(){
	var id='search-form';
	var inputSelector='#'+id+' input, '+'#'+id+' select';
	$(inputSelector).each( function(i,o) {
		 $(o).val('');
	});
	var data=$.param($(inputSelector));
	$.fn.yiiGridView.update('banner-grid', {data: data});
	return false;
});

$('.deleteall-button').click(function(){
        var atLeastOneIsChecked = $('input[name=\"banner-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked)
        {
                alert('Please select at least one record to delete');
        }
        else if (window.confirm('Are you sure you want to delete the selected records?'))
        {
                document.getElementById('banner-grid-bulk').action='" . Yii::app()->createAbsoluteUrl('admin/' . Yii::app()->controller->id . '/deleteall') . "';
                document.getElementById('banner-grid-bulk').submit();
        }
});

");

Yii::app()->clientScript->registerScript('ajaxupdate', "
    $('#banner-grid a.ajaxupdate').on('click', function() {
        $.fn.yiiGridView.update('banner-grid', {
            type: 'POST',
            url: $(this).attr('href'),
            success: function() {
                $.fn.yiiGridView.update('banner-grid');
            }
        });
        return false;
    });
");
?>
<h1><?php echo $this->pluralTitle; ?> of <?php echo $groupName->name; ?></h1>
<?php //echo CHtml::link(Yii::t('translation', 'Advanced Search'), '#', array('class' => 'search-button')); ?>
<div class='search-form' style='display:none'>
	<?php
	$this->renderPartial('_search', array(
		'model' => $model,
	));
	?></div>

<?php echo $this->renderControlNav(); ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><span class="<?php echo $this->iconList; ?>"></span> Listing</h3>
    </div>
    <div class="panel-body">
		<?php
		$allowAction = in_array("delete", $this->listActionsCanAccess) ? 'CCheckBoxColumn' : '';
		$columnArray = array();
		if (in_array("Delete", $this->listActionsCanAccess)) {
			$columnArray[] = array(
				'value' => '$data->id',
				'class' => "CCheckBoxColumn",
			);
		}
		$columnArray = array_merge($columnArray, array(
			array(
				'header' => 'S/N',
				'type' => 'raw',
				'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
				'headerHtmlOptions' => array('width' => '30px', 'style' => 'text-align:center;'),
				'htmlOptions' => array('style' => 'text-align:center;')
			),
			array(
				'name' => 'image',
				'value' => '$data->getImage("","width:150px;")',
				'type' => "raw",
				'htmlOptions' => array('style' => 'text-align:center;')
			),
//			array(
//				'name' => 'banner_type',
//				'value' => '$data->getBannerType()',
//				'htmlOptions' => array('style' => 'text-align:center;')
//			),
			'banner_title',
			array(
				'name' => '',
				'header' => 'Total Click',
				'value' => '$data->getNumberOfClick()',
				'htmlOptions' => array('style' => 'text-align:center;'),
				'visible' => Yii::app()->params['enableBannerClickCounter'] == 'yes' ? true : false
			),
//			array(
//				'name' => 'order_display',
//				'htmlOptions' => array('style' => 'text-align:center;'),
//			),
			array(
				'name' => 'created_date',
				'type' => 'date',
				'htmlOptions' => array('style' => 'text-align:center;')
			),
			'link',
			array(
				'name' => 'language_id',
				'value' => '$data->getLanguageName()',
				'htmlOptions' => array('style' => 'text-align:left;'),
			),
			array(
				'header' => 'Visibility',
				'name' => 'status',
				'type' => 'status',
				'value' => 'array("id"=>$data->id,"status"=>$data->status)',
				'htmlOptions' => array('style' => 'text-align:center;')
			),
			array(
				'header' => 'Actions',
				'class' => 'CButtonColumn',
				'template' => '{view}{update}{delete}',
				'buttons' => array(
					'update' => array
					(
						'url' => 'Yii::app()->createUrl("admin/detailbanners/update/id/" . $data->id . "/group_id/' . $groupName->id . '")',
					),
					'view' => array
					(
						'url' => 'Yii::app()->createUrl("admin/detailbanners/view/id/" . $data->id . "/group_id/' . $groupName->id . '")',
					),
					'delete' => array
					(
						'url' => 'Yii::app()->createUrl("admin/detailbanners/delete/id/" . $data->id . "/group_id/' . $groupName->id . '")',
					),
				),
			),
		));

		$form = $this->beginWidget('CActiveForm', array(
			'id' => 'banner-grid-bulk',
			'enableAjaxValidation' => false,
			'htmlOptions' => array('enctype' => 'multipart/form-data')));

		$this->renderNotifyMessage();

		$this->renderDeleteAllButton();

		$this->renderReturnUrlField(Yii::app()->createUrl("admin/detailbanners/index/group_id/" . $_GET['group_id']));

		$this->widget('zii.widgets.grid.CGridView', array(
			'id' => 'banner-grid',
			'dataProvider' => $model->searchAdmin(),
			'pager' => array(
				'header' => '',
				'prevPageLabel' => 'Prev',
				'firstPageLabel' => 'First',
				'lastPageLabel' => 'Last',
				'nextPageLabel' => 'Next',
			),
			'selectableRows' => 2,
			'columns' => $columnArray,
		));
		$this->endWidget();
		?>
