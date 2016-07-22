<?php
$this->breadcrumbs = array(
    $this->pluralTitle,
);

$this->menu =array(
	array('label'=> 'Create ' . $this->singleTitle, 'url'=>array('create'),  'icon' => $this->iconList),
    array('label' => Yii::t('translation', 'Export CSV'), 'url' => array('ajaxExport')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('users-grid', {
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
	$.fn.yiiGridView.update('users-grid', {data: data});
	return false;
});

$('.deleteall-button').click(function(){
        var atLeastOneIsChecked = $('input[name=\"users-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked)
        {
                alert('Please select at least one record to delete');
        }
        else if (window.confirm('Are you sure you want to delete the selected records?'))
        {
                document.getElementById('users-grid-bulk').action='" . Yii::app()->createAbsoluteUrl('admin/' . Yii::app()->controller->id . '/deleteall') . "';
                document.getElementById('users-grid-bulk').submit();
        }
});

$('.updatestatusall-button').click(function(){
        var atLeastOneIsChecked = $('input[name=\"users-grid_c0[]\"]:checked').length > 0;

        if (!atLeastOneIsChecked)
        {
            alert('Please select at least one record to update status');
        }
        else if (window.confirm('Are you sure you want to update status the selected records?'))
        {
            document.getElementById('users-grid-bulk').action='" . Yii::app()->createAbsoluteUrl('admin/' . Yii::app()->controller->id . '/updatestatusall') . "';
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
    
    $('.navbar-right a').last().attr({
        'href':'',
        'data-toggle':'modal',
        'data-target':'#exportModal'
    })
    
    $(document).on('click', '#export-submit', function() {
        var password = $('#export-repeat-password').val();
        var url = $(this).attr('href');
        if (password.trim() == '') {
            $('#form-export-csv .form-group').addClass('has-error');
            $('#form-export-csv .help-block').text('Password is blank.');
        } else {
            $.blockUI();
//            $('#exportModal').modal('hide');
            $('#exportModal').addClass('hidden');
            $.post( url, { password: password }).done(function( data ) {
                $.unblockUI();
                
                $('#form-export-csv').addClass('hidden');
                $('#cancel-submit').text('Close');
                $('#export-submit').addClass('hidden');
                $('#alert-export-csv').removeClass('hidden');
                $('#exportModal').removeClass('hidden');
            }).fail(function( data ) {
              
                $.unblockUI();
//                $('#exportModal').modal('show');
                var textError = '';
                if (data.status == 400) {
                    textError = data.responseText;
                } else if (data.status == 500) {
                    textError = data.statusText;
                }
                
                $('#form-export-csv .form-group').addClass('has-error');
                $('#form-export-csv .help-block').text(textError);
                $('#export-repeat-password').val('');
                $('#exportModal').removeClass('hidden');
            });
        }
    });
");
?>

    <!-- Modal -->
    <div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Export CSV</h4>
                </div>
                <div class="modal-body">
                    <div id="alert-export-csv" class="alert alert-info hidden" role="alert">
                        <p>File CSV have been sent to your email.</p>
                    </div>
                    <div id="form-export-csv" class="form-horizontal">
                        <div class="form-group">
                            <label for="export-repeat-password" class="col-sm-4 control-label">Repeat Password</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="export-repeat-password" placeholder="Password">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button id="cancel-submit" type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button id="export-submit" href="<?php echo Yii::app()->createAbsoluteUrl('admin/users/ajaxExport'); ?>" type="button" class="btn btn-primary">Export</button>
                </div>
            </div>
        </div>
    </div>

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

            'username',
            'email',
            'staff_name',
            'company',

            array(
                'name' => 'status',
                'type' => 'status',
                'htmlOptions' => array('style' => 'text-align:center;width:150px;')
            ),
            array(
                'name' => 'created_date',
                'type' => 'date',
                'htmlOptions' => array('style' => 'text-align:center;width:150px;')
            ),            
            array(
                'header' => 'Actions',
                'class' => 'CButtonColumn',
                'template' => ControllerActionsName::createIndexButtonRoles($actions),
                'buttons' => array(
                    'delete' => array('visible' => '!in_array($data->id, array(' . implode(',', $this->cannotDelete) . '))'),
                ),
            ),
        ));

        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'users-grid-bulk',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('enctype' => 'multipart/form-data')));

        $this->renderNotifyMessage();
        $this->renderDeleteAllButton();
        $this->renderUpdateStatusAllButton();

        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'users-grid',
            //KNguyen fix holder.js not load after gridview update
            //By: add new jquery gridview and content in Folder:  customassets/gridview
            //And custom update function
            //'baseScriptUrl'=>Yii::app()->baseUrl.DIRECTORY_SEPARATOR.'customassets'.DIRECTORY_SEPARATOR.'gridview',
            'dataProvider' => $model->searchMember(),
            'afterAjaxUpdate' => 'function(id, data){ fixTargetBlank(); }',
            'pager' => array(
                'header' => '',
                'prevPageLabel' => 'Prev',
                'firstPageLabel' => 'First',
                'lastPageLabel' => 'Last',
                'nextPageLabel' => 'Next',
                'pageSize' => $model->count(),
            ),
            'selectableRows' => 2,
            'columns' => $columnArray,
        ));
        $this->endWidget();
        ?>