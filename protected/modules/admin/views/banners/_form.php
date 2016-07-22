<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><span class="<?php echo $model->isNewRecord ? $this->iconCreate : $this->iconEdit; ?>"></span> <?php echo $model->isNewRecord ? 'Create' : 'Update'; ?> <?php echo $this->singleTitle ?></h3>
    </div>
    <div class="panel-body">
        <div class="form">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'banner-form',
                'enableAjaxValidation' => false,
                'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data'),
            ));
            ?>

            <div class='form-group form-group-sm'>
                <?php // echo $form->labelEx($model, 'image', array('class' => 'col-sm-1 control-label')); ?>
                <label class="col-sm-1 control-label required" for="image">
                    Image
                    <span class="required">*</span>
                </label>
                <div class="col-sm-3">                    
                    <?php echo $form->fileField($model, 'image', array('title' => "Upload " . $model->getAttributeLabel('image'))); ?>
                    <div class='notes'>Recommended Size: <?php echo $model->imageSize ?> (width x height), Allow file type  <?php echo '*.' . str_replace(',', ', *.', $model->allowImageType); ?> - Maximum file size : <?php echo ($model->maxImageFileSize / 1024) / 1024; ?>M </div>
                    <?php echo $form->error($model, 'image'); ?>
                    <?php if (!$model->isNewRecord) : ?>
                        <?php if (!empty($model->image)): ?>
                            <div class="thumbnail" id="thumbnail-<?php echo $model->id; ?>">
                                <?php echo CHtml::image(ImageHelper::getImageUrl($model, "image", "large"), '', array()); ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'title', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model, 'title', array('class' => 'form-control', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'title'); ?>
                </div>
            </div>

            <div class='form-group form-group-sm editor-width-50'>
                <?php echo $form->labelEx($model, 'description', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-6">
                    <?php echo $form->textArea($model, 'description', array('class' => 'my-editor-full')); ?>
                    <?php echo $form->error($model, 'description'); ?>
                </div>
            </div>

<!--            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'link', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model, 'link', array('class' => 'form-control', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'link'); ?>
                </div>
            </div>-->

            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->dropDownList($model, 'status', $model->optionActive, array('class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'status'); ?>
                </div>
            </div>
            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($model, 'order_display', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model, 'order_display', array('class' => 'form-control', 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'order_display'); ?>
                </div>
            </div>

            <div class="clr"></div>
            <div class="well">
                <?php echo CHtml::htmlButton($model->isNewRecord ? '<span class="' . $this->iconCreate . '"></span> Create' : '<span class="' . $this->iconSave . '"></span> Save', array('class' => 'btn btn-primary', 'type' => 'submit')); ?> &nbsp;  
                <?php echo CHtml::htmlButton('<span class="' . $this->iconCancel . '"></span> Cancel', array('class' => 'btn btn-default', 'onclick' => 'javascript: location.href=\'' . $this->baseControllerIndexUrl() . '\'')); ?>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>

<script>
    $(function () {
        var image = {};
        image.target = $('.thumbnail');
        image.btn_del = $('.img-del');
        image.id = image.btn_del.data('id');
        image.url = '<?php echo Yii::app()->createUrl('admin/banners/AjaxDeleteImage'); ?>';
        image.btn_del.click(function () {
            if (confirm('Do you want to delete this image ?')) {
                deleteImage(image);
            }
        });
    });
</script>