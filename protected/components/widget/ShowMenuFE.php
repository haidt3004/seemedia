<?php

class ShowMenuFE {

    /**
     * return menu ul li.
     */
    public $str = "";

    public function haschild($id, $arrobj) {
	foreach ($arrobj as $obj)
	    if ($obj->parent_id == $id)
		return 1;
	return 0;
    }

	public function getCurrentUrlWithoutParam()
	{
		$uriWithoutParam = $_SERVER['REQUEST_URI'];
		if (strpos($uriWithoutParam, '?') != false)
			$uriWithoutParam = substr($uriWithoutParam, 0, strpos($uriWithoutParam, '?'));
		return 'http://' . $_SERVER['SERVER_NAME'] . $uriWithoutParam;
	}
	
    public function findChild($id, $arrobj) {
        foreach ($arrobj as $obj) {
            $name = $obj->name;
            $temp_id = $obj->id;
            $temp_parent_id = $obj->parent_id;
//            $link = $obj->link;
            $link = $obj->createLink();
            $target = $obj->target;
            
            if ($temp_parent_id == $id) {
                $current = '';
                $currentURL = $this->getCurrentUrlWithoutParam();
                if($currentURL == $link)
                    $current = 'selected';
                $this->str.="<li class='$current' ><a href='" . $link . "' target='".$target."'><span>".$name."</span></a><ul >";
                $this->findChild($temp_id, $arrobj);
                $this->str.="</ul></li>";
            }
        }
    }

    public function findChildFooter($id, $arrobj) {
        foreach ($arrobj as $obj) {
            $name = $obj->name;
            $temp_id = $obj->id;
            $temp_parent_id = $obj->parent_id;
            $link = $obj->link;
            $target = $obj->target;

            if ($temp_parent_id == $id) {
                $current = '';
                $currentURL = $this->getCurrentUrlWithoutParam();
                if($currentURL == $link)
                    $current = 'selected';
                
                $this->str.="<li class='$current' ><a href='" . $link . "' target='".$target."'><span>".$name."</span></a></li>";
            }
        }
    }

    public function showMainMenuFE() {
        $menus = Menuitem::findActiveByMenu(MENU_MAIN);
        $strMenu = $this->showMenu($menus, 1);
        return $strMenu;
    }

    public function showMainMenuWithLogoutFE() {
        $menus = Menuitem::findActiveByMenu(MENU_MAIN);

        foreach ($menus as $menu) {
            $menu->getDataTranslate();
        }
        
        $strMenu = $this->showMenuWithLogout($menus, 1);
        return $strMenu;
    }

    //$type: 1->show menu on header, 2-> show menu on footer
    public function showMenuWithLogout($menus, $type = 1){
        if ($menus != NULL) {
            if($type == 1) {
                $this->findChild(0, $menus);

                if(isset(Yii::app()->user->id)){
                    $this->str.="<li class='' ><a href='" . Yii::app()->createAbsoluteUrl('site/logout') . "' target='_self'><span>". TextMultilangHelper::label('logout') ."</span></a></li>";
                }
            } else
                $this->findChildFooter(0, $menus);
        }
        return $this->str;
    }

    public function showMenuFooterFE(){
        $menus = Menuitem::findActiveByMenu(MENU_FOOTER);
        $strMenu = $this->showMenu($menus,2);
        return $strMenu;
    }

    //$type: 1->show menu on header, 2-> show menu on footer
    public function showMenu($menus, $type = 1){
        if ($menus != NULL) {
            if($type == 1)
                $this->findChild(0, $menus);
            else
                $this->findChildFooter(0, $menus);
        }
        return $this->str;
    }

}