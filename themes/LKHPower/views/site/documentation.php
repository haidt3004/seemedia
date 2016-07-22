<div class="mainchild">
    <div class="wrapper clearfix fullwidth">

        <!-- Documentation banner -->
        <?php $this->widget('BannerWidget',array('group_banner_id' => 2,'layout' => 'inner_page_banner', 'title_banner' => 'Documentation')); ?>
        <!-- End Documentation banner -->

        <div class="maincontent">
            <div class="t-header-org">
                Documentation
            </div>
            <div class="group-handbook clearfix">
                <div class="side-left">
                    <?php $index_link = 1; foreach($models as $model) : ?>
                        <div class="list-news-item itemdowload">
                            <a class="title" data-toggle="modal" data-target="#myModal"  rel="<?php echo $index_link; ?>">
                                <?php echo $model->title; ?>
                            </a>
                            <p class="learn-more"><a href="<?php echo $model->short_content; ?>">DOWNLOAD</a></p>
                        </div>
                    <?php $index_link++; endforeach; ?>
                </div>
                <div class="side-right">
                    <?php $index_content = 1; foreach($models as $model) : ?>
                        <div class="content-list document" id="list-<?php echo $index_content; ?>">
                            <h4><?php echo $index_content; ?>. <?php echo $model->title; ?></h4>
                            <p><?php echo $model->content; ?></p>
                        </div>
                    <?php $index_content++; endforeach; ?>
                </div>
            </div>
        </div>
    </div><!-- //wrapper -->
</div>

<script>
    $(document).ready(function() {
        $('#myframe').attr('src', 'https://docs.google.com/document/d/13gQwInPYizt2EkJJ_Y_bs4al3RINRvFcZSTrbzYisKE/pub?embedded=true');
    });
</script>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <h4>Vestibulum volutpat eleifend nisi efficitur at diam et, placerat tempor risus</h4>
                <iframe src="" width="99.6%" height="250" frameborder="0"></iframe>
            </div>

        </div>
    </div>
</div>