<?php
$this->breadcrumbs = array(
	$this->pluralTitle,
);
$this->menu = array(
	array('label' => 'Create ' . $this->singleTitle, 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('page-grid', {
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
	$.fn.yiiGridView.update('page-grid', {data: data});
	return false;
});

$('.deleteall-button').click(function(){
        var atLeastOneIsChecked = $('input[name=\"page-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked)
        {
                alert('Please select at least one record to delete');
        }
        else if (window.confirm('Are you sure you want to delete the selected records?'))
        {
                document.getElementById('page-grid-bulk').action='" . Yii::app()->createAbsoluteUrl('admin/' . Yii::app()->controller->id . '/deleteall') . "';
                document.getElementById('page-grid-bulk').submit();
        }
});

$('.updatestatusall-button').click(function(){
    var atLeastOneIsChecked = $('input[name=\"page-grid_c0[]\"]:checked').length > 0;

    if (!atLeastOneIsChecked)
    {
        alert('Please select at least one record to update status');
    }
    else if (window.confirm('Are you sure you want to update status the selected records?'))
    {
    document.getElementById('page-grid-bulk').action='" . Yii::app()->createAbsoluteUrl('admin/' . Yii::app()->controller->id . '/updatestatusall') . "';
    document.getElementById('page-grid-bulk').submit();
    }
});

");

Yii::app()->clientScript->registerScript('ajaxupdate', "
    $(document).on('click', '#page-grid a.ajaxupdate', function() {
        $.fn.yiiGridView.update('page-grid', {
            type: 'POST',
            url: $(this).attr('href'),
            success: function() {
                $.fn.yiiGridView.update('page-grid');
            }
        });
        return false;
    });
");
?>
<h1><?php echo $this->pluralTitle; ?></h1>
<?php echo CHtml::link(Yii::t('translation', 'Advanced Search'), '#', array('class' => 'search-button')); ?>
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
				'header' => "Staff name",
				'name' => "author",
			),
			array(
				'header' => "Title",
				'name' => "title",
				'type' => 'html',
				'value' => '$data->level > 0 ? $data->buildLevelTreeCharacter($data->level) . $data->title . "</span>": $data->title'
			),
			array(
				'header' => "Message",
				'name' => "content",
				'type' => 'html',
				'value' => 'strlen($data->content) > 130 ? substr($data->content, 0, 130) . " ..." : $data->content'
			),
			array(
				'header' => "Status",
				'name' => 'status',
				'type' => 'status',
				//ANH DUNG CLOSE DEC 19, 2014- sẽ không dùng link ở grid kiểu này nữa'value'=>'array("id"=>$data->id,"status"=>$data->status)',
				'htmlOptions' => array('style' => 'text-align:center;')
			),
			array(
				'header' => "Created Date",
				'name' => 'created_date',
				'type' => 'date',
				'htmlOptions' => array('style' => 'text-align:center;')
			),
			array(
				'header' => "Modified Date",
				'name' => 'modified_date',
				'type' => 'date',
				'htmlOptions' => array('style' => 'text-align:center;')
			),
			array(
				'header' => 'Actions',
				'class' => 'CButtonColumn',
				'template' => ControllerActionsName::createIndexButtonRoles($actions),
			),
		));
		$form = $this->beginWidget('CActiveForm', array(
			'id' => 'page-grid-bulk',
			'enableAjaxValidation' => false,
			'htmlOptions' => array('enctype' => 'multipart/form-data')));

		$this->renderNotifyMessage();
		$this->renderDeleteAllButton();
		$this->renderUpdateStatusAllButton();

		$this->widget('zii.widgets.grid.CGridView', array(
			'id' => 'page-grid',
			'dataProvider' => $model->search(),
			'afterAjaxUpdate' => 'function(id, data){ fixTargetBlank(); }',
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
