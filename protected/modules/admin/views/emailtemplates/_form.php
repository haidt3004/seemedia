<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><span class="<?php echo $model->isNewRecord ? $this->iconCreate : $this->iconEdit; ?>"></span> <?php echo $model->isNewRecord ? 'Create' : 'Update'; ?> <?php echo $this->singlelTitle ?></h3>
	</div>
	<div class="panel-body">
		<div class="form">
			<?php
    			$form = $this->beginWidget('CActiveForm', array(
    				'id' => 'email-templates-form',
    				'enableAjaxValidation' => false,
    			));
			?>

			<p class="note">Fields with <span class="required">*</span> are required.</p>
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
                    <?php 
                            $this->renderPartial(
                                                '_form_translate',
                                                array(
                                                        'model'      =>  $model->getDataWithLangauge($model,$lang->code),
                                                        'form'       => $form,
                                                        'language'   => $lang->code
                                                    )
                                            ); 
                    ?>
                </div>
                <?php endforeach; ?>
            </div>

			<div class="row" style="display: none;">
				<?php echo $form->labelEx($model, 'type'); ?>
				<?php echo $form->textField($model, 'type', array('size' => 60, 'maxlength' => 255)); ?>
				<?php echo $form->error($model, 'type'); ?>
			</div>
			<div class="well">
				<?php echo CHtml::htmlButton($model->isNewRecord ? '<span class="' . $this->iconCreate . '"></span> Create' : '<span class="' . $this->iconSave . '"></span> Save', array('class' => 'btn btn-primary', 'type' => 'submit')); ?> &nbsp; 
				<?php echo CHtml::htmlButton('<span class="' . $this->iconCancel . '"></span> Cancel', array('class' => 'btn btn-default', 'onclick' => 'javascript: location.href=\'' . $this->baseControllerIndexUrl() . '\'')); ?>
			</div>

		<?php $this->endWidget(); ?>

		</div><!-- form -->
	</div>
</div>