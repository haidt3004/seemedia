<nav id="main-menu" class="nav">
    <ul id="menu" class="menu clearfix">
    <?php
        $menuFe = new ShowMenuFE();
        echo $menuFe->showMainMenuWithLogoutFE();
    ?>
    </ul>
</nav>