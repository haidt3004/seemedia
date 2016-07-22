<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><span class="<?php echo $model->isNewRecord ? $this->iconCreate : $this->iconEdit; ?>"></span> <?php echo $model->isNewRecord ? 'Create' : 'Update'; ?> <?php echo $this->singleTitle ?></h3>
	</div>
	<div class="panel-body">
		<div class="form">
    		<?php $form=$this->beginWidget('CActiveForm', array(
    			'id' => 'languages-form',
    			'enableAjaxValidation'=>false,
    			'htmlOptions' => array('class' => 'form-horizontal hidden', 'role' => 'form', 'enctype' => 'multipart/form-data'),
    		)); ?>
<!-- 
            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($mtranslate,'key', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-5">
                    <?php echo $form->textField($mtranslate,'key', array('class' => 'form-control', 'maxlength' => 255,'style'=>'float:left;')); ?>
                    <?php echo $form->error($mtranslate,'key'); ?>
                </div>
            </div>
            <div class='form-group form-group-sm'>
                <?php echo $form->labelEx($mtranslate,'value', array('class' => 'col-sm-1 control-label')); ?>
                <div class="col-sm-5">
                    <?php echo $form->textField($mtranslate,'value', array('class' => 'form-control', 'maxlength' => 255,'style'=>'float:left;')); ?>
                    <?php echo $form->error($mtranslate,'value'); ?>
                    <button class="btn btn-primary" type="submit" name="yt1"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
                </div>
            </div> -->
            <?php $this->endWidget(); ?>



            <div class="clearfix" style="margin-bottom:20px;"></div>

            <?php $form=$this->beginWidget('CActiveForm', array(
                'id' => 'languages-form',
                'enableAjaxValidation'=>false,
                'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data'),
            )); ?>
            <div id="text-translate">
                <fieldset>

                    <?php if(is_array($allFiled) && count($allFiled)>0): foreach($allFiled as $key=>$data): ?>    


                    <div class="form-group form-group-sm">
                        <label class="col-sm-12 control-label required" ><?php echo $data['title']; ?> </label>                        
                        <div class="col-sm-12">
                            <input class="form-control" maxlength="255" name="translate[<?php echo $key; ?>]" type="text" value="<?php echo $data['value']; ?>">                        
                        </div>
                    </div>


                    <?php endforeach;endif; ?>


                </fieldset>
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