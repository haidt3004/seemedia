<div class="adv-left">
    <?php foreach ($models as $model) { ?>
        <?php if ($model->banner_title == $title) { ?>
            <a href="<?php echo $model->link; ?>"></a>
            <img src="<?php echo $model->getImageUrl($model->fieldNameImage); ?>" alt=""/>
            <div class="adv-text">
                <h3><?php echo $model->link_text; ?></h3>
            </div>
        <?php } ?>
    <?php } ?>
</div>