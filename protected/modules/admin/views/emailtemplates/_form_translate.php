<div class="row">
    <?php echo $form->labelEx($model, "[$language]email_subject",array('class'=>$model->removeClassErrors($language,'email_subject'))); ?>
    <div class="col-sm-4">
        <?php echo $form->textField($model, "[$language]email_subject", array('size' => 103, 'maxlength' => 255,'class'=>$model->removeClassErrors($language,'email_subject'))); ?>
        <?php if($model->showErrorLangMessage($language,'email_subject'))  echo $form->error($model, "[$language]email_subject"); ?>
    </div>

</div>

<div class="row">
    <?php echo $form->labelEx($model, 'parameter_description',array('class'=>$model->removeClassErrors($language,'parameter_description'))); ?>
    <div class="col-sm-4">
        <?php echo $form->textArea($model,"[$language]parameter_description", array('rows' => 6, 'cols' => 100)); ?>
        <?php if($model->showErrorLangMessage($language,'parameter_description'))  echo $form->error($model, "[$language]parameter_description"); ?>
    </div>
</div>  

<div class="row">
    <?php echo $form->labelEx($model, 'email_body',array('class'=>$model->removeClassErrors($language,'email_body'))); ?>
    <div class="col-sm-8">
        <?php echo $form->textArea($model, "[$language]email_body", array('rows' => 6, 'cols' => 50, 'class' => 'my-editor-full')); ?>
        <div class="clr"></div>
        <?php if($model->showErrorLangMessage($language,'email_body'))  echo $form->error($model, "[$language]email_body"); ?>
    </div>
</div>

