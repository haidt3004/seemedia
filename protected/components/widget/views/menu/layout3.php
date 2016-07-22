<?php 
$currUrl = Yii::app()->request->hostInfo . Yii::app()->request->requestUri;
//dump($currUrl);
if (!empty($menu_items)) {
    ?>
    <div class="footer">
        <?php
        $i = 1;
        foreach ($menu_items as $key => $item) {
            ?>
            <div class="fcol<?php echo $i; ?>">
                <div class="fhead"><?php echo $item->name; ?></div>
                <ul class="foot-nav <?php echo ($i == 3 ? "two-col" : ""); ?>">
                    <?php 
                    $sub_item = Menuitem::model()->getListActiveByMenu($this->menu, $item->id);
                    foreach ($sub_item as $sub) {
                            $link = $sub->createLink();
                            $class = "";
                            if (isset($this->highlight[$this->layout]) && $sub->id == $this->highlight[$this->layout]) {
                                    $class .= 'selected';
                            }
                            if ($class == "" && $currUrl == $link) {
                                $class .= 'selected';
                            }
                    ?>
                    <li class="<?php echo $class ?>" ><a href="<?php echo $link; ?>"><?php echo $sub->name; ?></a></li>
                    <?php } ?>
                </ul>
            </div>
            
    <?php $i++; } ?>
    </div>
    <?php
}?>