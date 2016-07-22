<ul>
    <?php if (!empty($menu_items)) {?>
        <?php foreach ($menu_items as $key => $item) {
            $link = $item->createLink();
            $class = "";
            if (isset($this->highlight[$this->layout]) && $item->id == $this->highlight[$this->layout]) {
                $class = 'active';
            } ?>
            <li><a href="<?php echo $link; ?>" class="<?php echo $class; ?>"><?php echo $item->name; ?></a></li>
        <?php }; ?>
    <?php }; ?>
</ul>

<script>
    $( document ).ready(function() {
        $("#footer-menu a").click(function() {
            $("#footer-menu a").removeClass("active");
            $(this).addClass("active");
        });
    });
</script>