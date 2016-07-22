<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'htmlOptions'=>array('class'=>'form-horizontal', 'role'=>'form'),
	'enableClientValidation'=>false,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

<div class="t-header-org">HR Portal Login</div>
<div class="frm-edit frmlogin">
    <div class="item-edit">
        <?php echo $form->labelEx($model,'username'); ?>
        <div class="ipt-edit">
            <?php echo $form->textField($model,'username', array('class'=>'ipt')); ?>
            <?php echo $form->error($model,'username'); ?>
        </div>
    </div>
    <div class="item-edit">
        <?php echo $form->labelEx($model,'password'); ?>
        <div class="ipt-edit">
            <?php echo $form->passwordField($model,'password', array('class'=>'ipt')); ?>
            <?php echo $form->error($model,'password'); ?>
            <?php if($messageTimeLimit !=''): ?>
                <div class="errorMessage"><?php echo $messageTimeLimit; ?></div>
            <?php endif; ?>

        </div>
    </div>
<!--    <div class="item-edit">-->
<!--        <label></label>-->
<!--        <div class="ipt-edit">-->
<!--            <div class="captcha captcha-wrap">-->
<!--                <div class="g-recaptcha" style="transform:scale(1.4);transform-origin:0;-webkit-transform:scale(1.4);transform:scale(1.4);-webkit-transform-origin:0 0;transform-origin:0 0;" data-sitekey="--><?php //echo Yii::app()->params['goCapcha']['siteKey']; ?><!--"></div>-->
<!--                <script type="text/javascript"  src="https://www.google.com/recaptcha/api.js?hl=en"> </script>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    --><?php //echo $form->error($model, 'google_capcha',array('style'=>'float:left;margin:10px 0px;')); ?>

    <div class="item-edit" style="clear:both;">
        <label> &nbsp; </label><button type="submit" class="btn-sb">Login</button>
    </div>

    <div class="item-edit">
        <label> &nbsp; </label><a href="<?php echo Yii::app()->createAbsoluteUrl('site/forgotPassword') ?>">Forgot your password?</a>
    </div>
</div>


<?php $this->endWidget(); ?>