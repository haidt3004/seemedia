<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><span class="<?php echo $model->isNewRecord ? $this->iconCreate : $this->iconEdit; ?>"></span> <?php echo $model->isNewRecord ? 'Create' : 'Update'; ?> <?php echo $this->singleTitle ?></h3>
	</div>
	<div class="panel-body">
		<div class="form">
			<?php
			$form = $this->beginWidget('CActiveForm', array(
				'id' => 'whistle-form',
				'enableAjaxValidation' => false,
				'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data'),
			));
			?>

            <ul class="nav nav-tabs">
                <?php foreach(Languages::getAlllanguage() as $key=> $lang): ?>
                <li class="<?php echo ($key=='') ? 'active' : ''; ?>">
                    <a data-toggle="tab" href="#<?php echo $lang->code ?>"><?php echo $lang->title;?></a>
                </li>
                <?php endforeach; ?>
            </ul>
            <div class="tab-content">
                 <?php foreach(Languages::getAlllanguage() as $key=> $lang): ?>
                <div id="<?php echo $lang->code ?>" class="tab-pane <?php echo ($key=='') ? 'active' : 'fade'; ?>">
                    <?php $this->renderPartial(
                                                '_form_translate',
                                                array(
                                                        'model'      => $model->getDataWithLangauge($model,$lang->code),
                                                        'form'       => $form,
                                                        'language'   => $lang->code
                                                    )
                                            ); 
                                        ?>
                </div>
                <?php endforeach; ?>
            </div>


			<div class='form-group form-group-sm'>
				<?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-1 control-label')); ?>
				<div class="col-sm-3">
					<?php echo $form->dropDownList($model, 'status', $model->optionActive, array('class' => 'form-control')); ?>
					<?php echo $form->error($model, 'status'); ?>
				</div>
			</div>
			<!--<div class='form-group form-group-sm'>
				<?php /*echo $form->labelEx($model, 'featured_image', array('class' => 'col-sm-1 control-label')); */?>
				<div class="col-sm-3">
					<?php /*if ($model->featured_image != '') : */?>
						<div class="thumbnail" id="thumbnail-<?php /*echo $model->id; */?>">
							<?php /*echo $model->getFeaturedImage(); */?>
						</div>
						<p></p>
					<?php /*endif */?>
					<?php /*echo $form->fileField($model, 'featured_image', array('title' => "Upload " . $model->getAttributeLabel('featured_image'))); */?>
					<div class='notes'>Allow file type  <?php /*echo '*.' . str_replace(',', ', *.', $model->allowImageType); */?> - Maximum file size : <?php /*echo ($model->maxImageFileSize / 1024) / 1024; */?>M </div>
					<?php /*echo $form->error($model, 'featured_image'); */?>
				</div>
			</div>-->
			<?php echo $form->hiddenField($model, 'display_order', array('class' => 'numeric-control form-control', 'maxlength' => 10)); ?>
			<div class="clr"></div>
			<div class="well">
				<?php echo CHtml::htmlButton($model->isNewRecord ? '<span class="' . $this->iconCreate . '"></span> Create' : '<span class="' . $this->iconSave . '"></span> Save', array('class' => 'btn btn-primary', 'type' => 'submit')); ?> &nbsp;  
				<?php echo CHtml::htmlButton('<span class="' . $this->iconCancel . '"></span> Cancel', array('class' => 'btn btn-default', 'onclick' => 'javascript: location.href=\'' . $this->baseControllerIndexUrl() . '\'')); ?>
			</div>
			<?php $this->endWidget(); ?>
		</div>
	</div>
</div>
<style>
    .multiselect-container {width: 100% !important}
</style>