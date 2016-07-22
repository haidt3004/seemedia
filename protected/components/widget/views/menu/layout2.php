<?php if (!empty($menu_items)) {
    ?>
    <ul class="foot-nav2">
        <?php
            foreach ($menu_items as $key => $item) {
                $link = $item->createLink();
                $class_mn = "";
               if($key == 0){
                   $class_mn = "first";
               }
                ?>
            <li class="<?php echo $class_mn ?>" <?php echo ($item->name == "Subscribe" ? "id='subscribe'" : ""); ?> ><a href="<?php echo ($item->name == "Subscribe" ? url('site/subscriber') : $link); ?>"><?php echo $item->name; ?></a></li>
         <?php }; ?>
    </ul>
<?php
}?>