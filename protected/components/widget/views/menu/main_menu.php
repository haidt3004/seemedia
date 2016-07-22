<nav id="main-menu">
    <ul id="menu" class="menu">
    <?php
        $menuFe = new ShowMenuFE();
        echo $menuFe->showMainMenuWithLogoutFE();
    ?>
    </ul>
</nav>