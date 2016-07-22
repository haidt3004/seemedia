<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'forgot_password-form',
    'htmlOptions'=>array('class'=>'form-horizontal', 'role'=>'form'),
    'enableClientValidation'=>false,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
)); ?>

<div class="t-header-org">Reset Password</div>
<div class="frm-edit frmlogin">
        <div class="clear"></div>
        <?php if (Yii::app()->user->hasFlash('msg')): ?>
            <div class="alert fade in" style="margin-top:18px;">
                <?php echo Yii::app()->user->getFlash('msg'); ?>
            </div>
        <?php endif; ?> 

<!--         <div class="item-edit">
            <?php echo $form->labelEx($model,'newPassword'); ?>
            <div class="ipt-edit">
                <?php echo $form->passwordField($model,'newPassword', array('class'=>'ipt')); ?>
                <?php echo $form->error($model,'newPassword'); ?>
            </div>
        </div>   
        <div class="item-edit">
            <?php echo $form->labelEx($model,'password_confirm'); ?>
            <div class="ipt-edit">
                <?php echo $form->passwordField($model,'password_confirm', array('class'=>'ipt')); ?>
                <?php echo $form->error($model,'password_confirm'); ?>
            </div>
        </div>     --> 

        <?php //echo $form->error($model, 'google_capcha',array('style'=>'float:left;margin:10px 0px;')); ?>

    <!--     <div class="item-edit" style="margin-top:44px;clear:both;">
            <label> &nbsp; </label><button type="submit" class="btn-sb">Reset Password</button>
        </div> -->

    <div class="item-edit" style="margin-top:44px;clear:both;">
        <label> &nbsp; </label>
        <!-- <button type="submit" class="btn-sb">Reset Password</button> -->
        <a href="<?php echo Yii::app()->getHomeUrl(); ?>">
            <button  type="button" class="btn-sb">BACK TO HR HOME</button>
        </a>
    </div>

        
</div>
<?php $this->endWidget(); ?>