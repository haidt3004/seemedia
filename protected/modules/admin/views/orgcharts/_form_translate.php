<div class="clr" style="margin:10px;"></div>
<div class="form-group form-group-sm">
    <?php echo $form->labelEx($model, "[$language]title",array('class'=>'col-sm-1 '. $model->removeClassErrors($language,'title'))); ?>
    <div class="col-sm-8">
        <?php echo $form->textField($model, "[$language]title", array('size' => 103, 'maxlength' => 255,'class'=>'form-control ' .$model->removeClassErrors($language,'title'))); ?>
        <?php if($model->showErrorLangMessage($language,'title'))  echo $form->error($model, "[$language]title"); ?>
    </div>
</div>

<div class="form-group form-group-sm">
    <?php echo $form->labelEx($model, 'short_content',array('class'=>'col-sm-1 '. $model->removeClassErrors($language,'short_content'))); ?>
    <div class="col-sm-8">
        <?php echo $form->textArea($model, "[$language]short_content", array('cols' => 137, 'rows' => 7)); ?>
        <div class="clr"></div>
        <?php if($model->showErrorLangMessage($language,'short_content'))  echo $form->error($model, "[$language]short_content"); ?>
    </div>
</div>


<div class="form-group form-group-sm">
    <?php echo $form->labelEx($model, 'content',array('class'=>'col-sm-1 '. $model->removeClassErrors($language,'content'))); ?>
    <div class="col-sm-8">
        <?php echo $form->textArea($model, "[$language]content", array('rows' => 6, 'cols' => 50, 'class' => 'my-editor-full')); ?>
        <div class="clr"></div>
        <?php if($model->showErrorLangMessage($language,'content'))  echo $form->error($model, "[$language]content"); ?>
    </div>
</div>

