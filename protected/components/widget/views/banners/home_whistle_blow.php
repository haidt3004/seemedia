<div class="adv-left">
    <?php if (count($models) > 0) { ?>
        <a href="<?php echo $models[0]->link; ?>"></a>
        <?php echo $models[0]->getImage('center-block'); ?>
        <div class="adv-text">
            <h3><?php echo $models[0]->link_text; ?></h3>
        </div>
    <?php } ?>
</div>