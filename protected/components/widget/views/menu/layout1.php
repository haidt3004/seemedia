<nav id="sub-menu" class="nav">
	<div id="topMenu">
		<?php
//	echo Yii::app()->request->getUrl();
		if (!empty($menu_items)) {
			?>
			<ul class="menu">
				<?php
				foreach ($menu_items as $key => $item) {
                                        $link = $item->createLink();
					$class = "";
                                        if (isset($this->highlight[$this->layout]) && $item->id == $this->highlight[$this->layout]) {
                                                $class = 'selected';
                                        }
                                        $sub_menu_items = Menuitem::model()->getListActiveByMenu($this->menu, $item->id);
					?>
					<li class="<?php echo $class; ?>"><a href="<?php echo $link; ?>"><?php echo $item->name; ?></a>
						<?php
						if ($sub_menu_items) {
							?>
							<ul>
								<?php
								foreach ($sub_menu_items as $k => $sub_item) {
                                                                        $link_sub = $sub_item->createLink();
									?>
									<li><a href="<?php echo $link_sub; ?>"><?php echo $sub_item->name; ?></a></li>
								<?php }; ?>
							</ul>
						<?php } ?>
					</li>
				<?php }; ?>
			</ul>
		<?php }; ?>
	</div>
</nav>
<script>
    $( document ).ready(function() {
        $("#topMenu li a").click(function() {
            $("#topMenu li").removeClass("selected");
            $(this).parent().addClass("selected");
        });
    });
</script>