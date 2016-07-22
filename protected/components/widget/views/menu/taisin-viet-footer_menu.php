<p id="footer-menu">
    <?php if (!empty($menu_items)) {?>
        <?php
        $index_menu_items = 0;
        ?>
        <?php foreach ($menu_items as $key => $item) {
            $link = $item->createLink();
            $class = "";
            if (isset($this->highlight[$this->layout]) && $item->id == $this->highlight[$this->layout]) {
                $class = 'active';
            } ?>
            <a href="<?php echo $link; ?>" class="<?php echo $class; ?>"><?php echo $item->name; ?></a><?php $index_menu_items++; if ($index_menu_items != count($menu_items)) { ?> | <?php } ?>
        <?php }; ?>
    <?php }; ?>
</p>

<script>
    $( document ).ready(function() {
        $("#footer-menu a").click(function() {
            $("#footer-menu a").removeClass("active");
            $(this).addClass("active");
        });
    });
</script>