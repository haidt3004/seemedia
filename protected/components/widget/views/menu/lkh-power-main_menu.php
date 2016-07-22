<nav id="main-menu" class="wrapper clearfix">
    <ul id="menu">
        <?php
        $menuFe = new ShowMenuFE();
        echo $menuFe->showMainMenuWithLogoutFE();
        ?>
    </ul>
</nav>

