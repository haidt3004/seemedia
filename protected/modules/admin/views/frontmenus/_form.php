<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><span class="<?php echo $model->isNewRecord ? $this->iconCreate : $this->iconEdit; ?>"></span> <?php echo $model->isNewRecord ? 'Create' : 'Update'; ?> <?php echo $this->singleTitle ?></h3>
	</div>
	<div class="panel-body">
		<div class="form">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id' => 'menuForm',
			'enableAjaxValidation'=>false,
			'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form'),
		)); ?>
			
			<div class='form-group form-group-sm'>
			<?php echo $form->labelEx($model,'title', array('class' => 'col-sm-1 control-label')); ?>
				<div class="col-sm-3">
				<?php echo $form->textField($model,'title', array('class' => 'form-control', 'maxlength' => 255)); ?>
				<?php echo $form->error($model,'title'); ?>
				</div>
			</div>
			
			<p><button type="button" class="btn btn-default btn-sm" onclick="addMenuItem()">Add Menu Item</button></p>
			
			<div class="panel panel-default" style="padding-left: -20px; padding-right: -20px">
				<div class="panel-body" style="padding-left: -20px; padding-right: -20px">
					
					<input id="LevelMenuJson" name="LevelMenuJson" type="hidden"/>
					<h5 class="pull-left">Menu Structure</h5>
					<div class="clearfix"></div>
					<div class="dd">
						<ol class="dd-list" id="mainlist">
							<?php $this->renderChilds($model) ?>
						</ol>
					</div>
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
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/frontMenu.js'); ?>
<script type="text/javascript">
//<![CDATA[
	window.menuItemUrl = '<?php echo $this->createUrl('rendernewitem') ?>';
	window.menuInputUrl = '<?php echo $this->createUrl('getLinkInputHtml') ?>';
//]]>
</script> 
