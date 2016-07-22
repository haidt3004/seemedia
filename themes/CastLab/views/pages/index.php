<aside>
    <div class="sidenav-wrap">
        <div id="sidenav">
            <button class="navbar-toggle btn-nav" data-toggle="collapse" data-target=".nav-wrap"><?php echo Yii::t('translation','Suited Offices'); ?></button>
            <div class="collapse nav-wrap">
                <ul class="nav-list nav-scroll">
                    <?php
                        foreach ($section as $item) {
                            echo '<li><a href="#section'.$item->id.'">'.$item->name.'</a></li>';
                        }
                    ?>   
                    <li><a href="#faqs"><?php echo Yii::t('translation','FAQs'); ?></a></li>
                </ul>
                <?php
                    if ($slug == 'serviced-offices' || $slug == 'virtual-offices') {
                ?>
					<?php if($slug == 'serviced-offices')) { ?>
					<div class="btn-book"><a href="#book-tour" data-toggle="modal"><?php echo Yii::t('translation','Book a tour!'); ?></a></div>
					<?php } else { ?>
					<div class="btn-book"><a href="#book-tour" data-toggle="modal"><?php echo Yii::t('translation','Sign up now'); ?></a></div>
					<?php } ?>
                <?php } ?>
            </div>
            </div>
    </div>
</aside>
<div class="main-content">
    <div class="document">
        <?php
            foreach ($section as $key=>$item) {
        ?>
        <h1 id="<?php echo 'section'.$item->id; ?>" <?php echo ($key == 0)?'class="title-page"':'';?>><?php echo $item->name; ?></h1>
        <?php echo $item->content; ?>
        <?php
            }
        ?>
        <h2 id="faqs"><?php echo Yii::t('translation','FAQs'); ?></h2>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <?php
                foreach ($faqs as $k => $val) {
                    if ($k == 0) {
            ?>
            <div class="panel panel-default">
              <div class="panel-heading" role="tab" id="heading1">
                  <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $val->id; ?>" aria-expanded="true" aria-controls="collapse1"><?php echo $val->question; ?></a></h4>
              </div>
              <div id="collapse<?php echo $val->id; ?>" class="panel-collapse collapse in" aria-labelledby="heading<?php echo $val->id; ?>">
                  <div class="panel-body"><?php echo $val->aswer; ?></div>
              </div>
            </div>
            <?php } else { ?>
            <div class="panel panel-default">
              <div class="panel-heading" role="tab" id="heading1">
                  <h4 class="panel-title"><a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $val->id; ?>" aria-expanded="false" aria-controls="collapse1"><?php echo $val->question; ?></a></h4>
              </div>
              <div id="collapse<?php echo $val->id; ?>" class="panel-collapse collapse" aria-labelledby="heading<?php echo $val->id; ?>">
                  <div class="panel-body"><?php echo $val->aswer; ?></div>
              </div>
            </div>
            <?php 
                    }
                } 
            ?>
        </div>
		<div class="back-top">
			<a href="#">Back to top</a>
		</div>
    </div>
</div><!-- main content -->
<?php
    if ($slug == 'serviced-offices' || $slug == 'virtual-offices') {
     echo $this->renderPartial('/site/box/book_tour', array('model' => $model));
    }
?>

<script type="text/javascript">
    var CaptchaCallback = function(){
        grecaptcha.render('RecaptchaField3', {'sitekey' : '6Lc6dwgTAAAAACrev5pd7c5BbRJDP3cbE5Rs_U2X'});
    };
</script>

<script src="//www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit" async defer></script>

<?php
    if ($error == 1) {
?>
<script type="text/javascript">
    $(window).load(function(){
        $('#book-tour').modal('show');
    });
</script>
<?php
    }
?>