<?php
$session = Yii::app()->session;
$prefixLen = strlen(CCaptchaAction::SESSION_VAR_PREFIX);
foreach ($session->keys as $key) {
    if (strncmp(CCaptchaAction::SESSION_VAR_PREFIX, $key, $prefixLen) == 0)
        $session->remove($key);
}
?>

<div class="mainchild">
    <div class="wrapper clearfix fullwidth">

        <!-- whisle blow banner -->
        <?php $this->widget('BannerWidget',array('group_banner_id' => WHISTLE_BLOW_BANNER,'layout' => 'inner_page_banner')); ?>
        <!-- End whisle blow banner -->

        <div class="maincontent">
            <div class="t-header-org">
                Whistle Blow
            </div>
            <div class="frm-edit">
                <p>This whistle blowing is part of our effort to enforce and ensure staff compliance to our corporate core values of Integrity, Reliability and Unity.
                    This page serves as an avenue for employees to report on any concerns, doubts or possible improprieties such as bribery, dishonesty, fraud
                    or theft, etc. Confidentiality will be maintained to the fullest extent possible and no employees will be discriminated with respect to the good
                    faith reporting. Upon validation of the case, necessary corrective action will be taken.</p>
                <p>You may report the matter through the following methods: </p>
                <p>a) Use the below form to submit online.</p>
                <p>b) Copy the following email address <a href="mailto:<?php echo Yii::app()->params['adminEmail']; ?>"><?php echo Yii::app()->params['adminEmail']; ?></a> and send using your personal email.</p>
            </div>
            <div class="clear"></div>
                        
            <div class="frm-edit">

                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'whistle-blow-form',
                    'enableAjaxValidation' => false,
                    'htmlOptions' => array('role' => 'form', 'enctype' => 'multipart/form-data'),
                ));
                ?>

                <div class="item-edit">
                    <label>Title<span style="color: red;"> *</span></label>
                    <div class="ipt-edit">
                        <?php echo $form->textField($model, 'title', array('class' => 'txt-1 whistle-title')); ?>
                        <?php echo $form->error($model,'title'); ?>
                    </div>
                </div>

                <div class="item-edit">
                    <label>Message<span style="color: red;"> *</span></label>
                    <div class="ipt-edit">
                        <?php echo $form->textArea($model, 'content', array('class' => 'txt-1')); ?>
                        <?php echo $form->error($model,'content'); ?>
                    </div>
                </div>

<!--                --><?php //if(CCaptcha::checkRequirements()): ?>
<!---->
<!--                    <div class="item-edit">-->
<!--                        <label style="padding-top: 15px;">Captcha<span style="color: red;"> *</span></label>-->
<!--                        <div class="ipt-edit">-->
<!--                            <div class="captcha captcha-wrap" style="height: 100px;">-->
<!--                                <div class="g-recaptcha" style="transform:scale(1.4);transform-origin:0;-webkit-transform:scale(1.4);transform:scale(1.4);-webkit-transform-origin:0 0;transform-origin:0 0;" data-sitekey="--><?php //echo Yii::app()->params['goCapcha']['siteKey']; ?><!--"></div>-->
<!--                                <script type="text/javascript"  src="https://www.google.com/recaptcha/api.js?hl=en"> </script>-->
<!--                            </div>-->
<!--                            --><?php //echo $form->error($model, 'google_capcha',array('style'=>'float:left;margin-top:20px;')); ?>
<!--                        </div>-->
<!---->
<!--                    </div>-->
<!---->
<!---->
<!--                --><?php //endif; ?>


                <div class="item-edit" style="clear:both;">
                    <label> &nbsp; </label><button type="submit" class="btn-sb">SUBMIT</button>
                </div>

                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div><!-- //wrapper -->
</div>

