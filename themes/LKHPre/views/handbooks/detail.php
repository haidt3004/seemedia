<div class="mainchild">
    <div class="wrapper clearfix fullwidth">
        <!-- Documentation banner -->
        <?php $this->widget('BannerWidget',array('group_banner_id' => POLICY_ORG_CHART_BANNER,'layout' => 'inner_page_banner')); ?>
        <!-- End Documentation banner -->

        <div class="maincontent">

            <div class="group-handbook clearfix">

                <div class="content-list document">
                    <h4><?php echo $model->title; ?></h4>
                    <?php if (strlen($model->short_content) > 0) { ?>
                        <iframe src="<?php echo $model->short_content; ?>/preview" width="100%" height="650" frameborder="0"></iframe>
                    <?php } ?>
                </div>

            </div>

        </div>
    </div><!-- //wrapper -->
</div>
