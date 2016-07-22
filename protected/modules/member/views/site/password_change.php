<?php $form=$this->beginWidget('CActiveForm', array(
'id'=>'update-profile-form',
'htmlOptions'=>array('class'=>'form-horizontal', 'role'=>'form'),
'enableClientValidation'=>false,
'clientOptions'=>array(
'validateOnSubmit'=>true,
),
)); ?>

<div class="t-header-org">
    Password changed
</div>
<div class="frm-edit frmlogin">
    
    <div class="clear"></div>
    <?php if (Yii::app()->user->hasFlash('msg')): ?>
        <div class="alert alert-success fade in" style="margin-top:18px;">
            <?php echo Yii::app()->user->getFlash('msg'); ?>
        </div>
        <div class="item-edit">
            <label> &nbsp; </label>
            <a href="<?php echo Yii::app()->getHomeUrl(); ?>">
                <button  type="button" class="btn-sb">BACK TO HR HOME</button>
            </a>
        </div>

    <?php else: ?>    
   

    
    <div class="item-edit">
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
    </div>

    <div class="item-edit">
        <label> &nbsp;</label>
        <div class="ipt-edit">
            <p class="note-login-2">Password must be alphanumeric with upper and lowercase. ( A-Z, a-z, 0-9 )</p>
        </div>
    </div>
    <div class="item-edit">
        <label> &nbsp; </label><button type="submit" class="btn-sb">Ok</button>
    </div>
    <?php endif; ?> 

</div>

<?php $this->endWidget(); ?>