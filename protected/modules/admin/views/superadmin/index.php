<?php
$this->breadcrumbs=array(
	$this->pluralTitle
);

$menus=array(
	array('label'=>'Create ' . $this->singlelTitle, 'url'=>array('create')),
);
$this->menu= ControllerActionsName::createMenusRoles($menus, $actions);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('users-grid', {
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
	$.fn.yiiGridView.update('users-grid', {data: data});
	return false;
});

$('.deleteall-button').click(function(){
        var atLeastOneIsChecked = $('input[name=\"users-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked)
        {
                alert('Please select atleast one record to delete');
        }
        else if (window.confirm('Are you sure you want to delete the selected records?'))
        {
                document.getElementById('users-grid-bulk').action='" . Yii::app()->createAbsoluteUrl('admin/' . Yii::app()->controller->id  . '/deleteall') . "';
                document.getElementById('users-grid-bulk').submit();
        }
});

");

Yii::app()->clientScript->registerScript('ajaxupdate', "
$(document).on('click', '#users-grid a.ajaxupdate', function() {
    $.fn.yiiGridView.update('users-grid', {
        type: 'POST',
        url: $(this).attr('href'),
        success: function() {
            $.fn.yiiGridView.update('users-grid');
        }
    });
    return false;
});
");
?>

<h1><?php echo $this->pluralTitle; ?></h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<?php echo $this->renderControlNav();?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><span class="glyphicon glyphicon-pencil"></span> <?php echo $this->pluralTitle; ?></h3>
	</div>
	<div class="panel-body">
		<?php 
		$allowAction = in_array("delete", $this->listActionsCanAccess)?'CCheckBoxColumn':'';
		$columnArray = array();
		if (in_array("Delete", $this->listActionsCanAccess))
		{
			$columnArray[] = array(
								'value'=>'$data->id',
								'class'=> "CCheckBoxColumn",
							);
		}
		
		$columnArray = array_merge($columnArray, array(
				array(
					'header' => 'S/N',
					'type' => 'raw',
					'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
					'headerHtmlOptions' => array('width' => '30px','style' => 'text-align:center;'),
					'htmlOptions' => array('style' => 'text-align:center;'),
				),
                                'username',				
				array(
                                    'name'=>'role_id',
                                    'value'=> 'Users::GetRoleName($data)',
				),
                                array(
                                    'name'=>'email',
                                    'sortable'=>false,
				),
				'full_name',
				array(
					'name' => 'phone',
					'htmlOptions' => array('style' => 'text-align:right;'),
					'sortable'=>false,
				),
				array(
					'header'=>'Status',
					'name'=>'status',
					'type'=>'status',
					'htmlOptions' => array('style' => 'text-align:center;'),
					//                  ANH DUNG CLOSE DEC 19, 2014- sẽ không dùng link ở grid kiểu này nữa'value'=>'(Yii::app()->user->id==$data->id)?$data->status:array("status"=>$data->status,"id"=>$data->id)',
				),
				array(
					'name' => 'created_date',
					'type'=>'datetime',
					'htmlOptions' => array('style' => 'text-align:center;')
				),
                // array(
                //     'header' => 'Privilege',
                //     'class'=>'CButtonColumn',
                //     'template'=> '{user}',
                //     'htmlOptions' => array('style' => 'width:50px;text-align:center;'),
                //     'buttons' => array( 
                //         'user' => array(
                //             'label' => 'Setting Privilege',
                //             'imageUrl' => Yii::app()->theme->baseUrl . '/admin/images/folder.png',
                //             'options' => array('class' => 'show-book-chapters','target'=>'_blank'),
                //             'url' => 'Yii::app()->createAbsoluteUrl("admin/rolesAuth/user",array("id"=>$data->id))',
                //             'visible'=>'MyFormat::isAllowAccess("rolesAuth", "user")',
                //         )
                //     ),
                // ),
				array(
					'header'=>'Actions',
					'class'=>'CButtonColumn',
					'template'=> ControllerActionsName::createIndexButtonRoles($actions),
					'buttons'=>array(
						'delete'=>array('visible'=> 'Yii::app()->user->id!=$data->id && $data->id !=2')
					),

				),
		));
		
		$form=$this->beginWidget('CActiveForm', array(
        'id'=>'users-grid-bulk',
        'enableAjaxValidation'=>false,
        'htmlOptions'=>array('enctype' => 'multipart/form-data')));
		
		$this->renderNotifyMessage(); 
		$this->renderDeleteAllButton(); 
		
		$this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'users-grid',
			'dataProvider'=>$model->search(),
            'afterAjaxUpdate'=>'function(id, data){ fixTargetBlank(); }',
			//'filter'=>$model,
			'pager'=>array(
				'header'         => '',
				'prevPageLabel'  => 'Prev',
				'firstPageLabel' => 'First',
				'lastPageLabel'  => 'Last',
				'nextPageLabel'  => 'Next',
			),
			'selectableRows'=>2,
			'columns'=>$columnArray,
		));
		
		$this->endWidget();
		?>
</div>
</div>
