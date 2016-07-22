<h2 class="title-box"><?php echo Yii::t('translation', 'Subscribe'); ?></h2>
<div class="newsletter-col">
    <?php echo StaticBlock::getBlockContent('subscribe') ?>
    <div class="newsletter-box">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'newletter-form',
            'enableClientValidation' => false,
            'action' => Yii::app()->createAbsoluteUrl('site/GuestSubscriber'),
            'htmlOptions' => array('role' => 'form', 'enctype' => 'multipart/form-data'),
        ));
        ?>
        <div class="input-row">
            <label class="label"><?php echo Yii::t('translation', "Name"); ?></label>
            <div class="input-box">
                <?php echo $form->textField($model, 'name', array('class' => 'newsletter-input')); ?>
                <?php echo $form->error($model, 'name'); ?>
            </div>
        </div>
        <div class="input-row">
            <label class="label"><?php echo Yii::t('translation', "Email address"); ?></label>
            <div class="input-box">
                <?php echo $form->textField($model, 'email', array('class' => 'newsletter-input')); ?>
                <?php echo $form->error($model, 'email'); ?>
            </div>
        </div>
        <div class="input-row">
            <?php echo $form->checkBox($model, 'check'); ?> <?php echo Yii::t('translation', "I agree to abide by LearnSuperMart's"); ?> <a href="<?php echo url('/terms-of-use'); ?>">Terms &amp; Conditions</a>.
        </div>
        <div class="errorMessage" id="error-check" style="display: none; margin-bottom: 5px">Please check Terms & Conditions.</div>
        <input type="submit" class="newsletter-btn" value="Submit">
        <img class="newsletter-loading hidden" src="<?php echo Yii::app()->theme->baseUrl.'/images/loading.gif'; ?>">
        <?php $this->endWidget(); ?> 
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#newletter-form').submit(function (event) {
            event.preventDefault();
            ajaxNewletterSubmit();
        });

    });

    function ajaxNewletterSubmit() {
        $("#error-check").hide();
        if ($('#Subscriber_check').is(":checked"))
        {
            $.ajax({
                type: "post",
                url: $('#newletter-form').attr('action'),
                data: $('#newletter-form').serialize(),
                beforeSend: function () {
                    $('.newsletter-btn').attr('disabled',true);
                    $('.newsletter-loading').removeClass('hidden');
                }
            }).done(function (data) {
                $('.newsletter-btn').attr('disabled',false);
                $('.newsletter-loading').addClass('hidden');
                $('#newletter-form').html(data);
            });
        } else {
            $("#error-check").show();
        }
    }
</script>