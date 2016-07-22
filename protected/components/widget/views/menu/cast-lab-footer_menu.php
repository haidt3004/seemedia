<?php if (!empty($menu_items)) {?>
    <?php
    $index_menu_items = 0;
    ?>
    <?php foreach ($menu_items as $key => $item) {
        $link = $item->createLink();
        $class = "";
        ?>
        <a href="<?php echo $link; ?>" class="<?php echo $class; ?>"><?php echo $item->name; ?></a><?php $index_menu_items++; if ($index_menu_items != count($menu_items)) { ?> | <?php } ?>
    <?php }; ?>
<?php }; ?>