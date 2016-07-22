<div class="mainchild">
    <div class="wrapper clearfix fullwidth">

        <!-- whisle blow banner -->
        <?php $this->widget('BannerWidget',array('group_banner_id' => WHISTLE_BLOW_BANNER,'layout' => 'inner_page_banner')); ?>
        <!-- End whisle blow banner -->

        <div class="maincontent">
            <div class="t-header-org">
                Whistle Blow
            </div>
            <div class="frm-edit frmlogin">
                <div class="clear"></div>
                <div style="margin-top:18px;" class="alert alert-success fade in">
                    Thanks you for the reporting. Your message has been sent to the audit committee for review.
                </div>
                <div class="item-edit" style="text-align: center;">
                    <a href="<?php echo Yii::app()->createUrl('/'); ?>">
                        <button class="btn-sb" type="button">BACK TO HR HOME</button>
                    </a>
                </div>
            </div>
        </div>
    </div><!-- //wrapper -->
</div>