<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'forgot_password-form',
    'htmlOptions'=>array('class'=>'form-horizontal', 'role'=>'form'),
    'enableClientValidation'=>false,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
)); ?>

<div class="t-header-org"> Forgot password</div>
<div class="frm-edit frmlogin">

        <div class="clear"></div>
        <?php if (Yii::app()->user->hasFlash('msg')): ?>
            <div class="alert alert-success fade in" style="margin-top:18px;">
                <?php echo Yii::app()->user->getFlash('msg'); ?>
            </div>
        <?php endif; ?> 



        <h4>Please key in your username to receive a link via email to reset the password. For personnel without an email, please check the with your HR manager for more information The link to reset your password will be sent to the email / please check your HR for more information. </h4>

        <div class="item-edit">
            <?php echo $form->labelEx($model,'username_forgot'); ?>
            <div class="ipt-edit">
                <?php echo $form->textField($model,'username_forgot', array('class'=>'ipt')); ?>
                <?php echo $form->error($model,'username_forgot'); ?>
            </div>
        </div>     
		
		  <!--
        <div class="item-edit">
			<label for="Users_username_forgot" class="required">&nbsp;</label>
            <div class="ipt-edit">
                <div class="captcha captcha-wrap">
                    <div class="g-recaptcha" style="transform:scale(1.4);transform-origin:0;-webkit-transform:scale(1.4);transform:scale(1.4);-webkit-transform-origin:0 0;transform-origin:0 0;" data-sitekey="<?php echo Yii::app()->params['goCapcha']['siteKey']; ?>"></div>
                    <script type="text/javascript"  src="https://www.google.com/recaptcha/api.js?hl=en"> </script>
                </div>
            </div>
        </div>
        <?php echo $form->error($model, 'google_capcha',array('style'=>'float:left;margin:10px 0px;')); ?>
		-->

    <div class="item-edit" style="margin-top:44px;clear:both;">
        <label> &nbsp; </label><button type="submit" class="btn-sb">Reset Password</button>
    </div>
</div>
<?php $this->endWidget(); ?>