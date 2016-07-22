<?php

class ShowAdminMenu
{

    /**
     * return menu ul li.
     */
    public $str = "";

    public function haschild($id, $arrobj)
    {
        foreach ($arrobj as $obj) {
            if ($obj->parent_id == $id) {
                if ($obj->menu_link == '') {
                    continue;
                }
                $aLinks = explode('/', $obj->menu_link);
                $c = '';
                $a = '';
                if (count($aLinks) == 2) {
                    $c = $aLinks[1];
                    $a = 'Index';
                } elseif (count($aLinks) > 2) {
                    $c = $aLinks[1];
                    $a = ucfirst($aLinks[2]);
                }
                $aActionAllowed = ActionsUsers::getActionArrayAllowForCurrentUserByControllerName($c);
                $aActionAllowed = array_map('strtolower', $aActionAllowed);
                $aActionAllowed = array_map('trim', $aActionAllowed);// Now 14, 2014 ANH DUNG ADD
                if (in_array(strtolower($a), $aActionAllowed)) {
                    return 1;
                }
            }
        }
        return 0;
    }

    public function findchild($id, $arrobj, $selected_id = '', $userRoleMenuId = array())
    {
        foreach ($arrobj as $obj) {
            $temp_id = $obj->id;
            $temp_parent_id = $obj->parent_id;
            if ($temp_parent_id == $id) {
                $name = $obj->menu_name;
                if (!$this->haschild($temp_id, $arrobj) && $obj->menu_link != '') // neu khong con con va co link thi cho ra
                    $this->str .= "<li><a href='" . Yii::app()->createAbsoluteUrl($obj->menu_link) . "'>$obj->menu_name</a></li><li class=\"divider\"></li>";

                if ($this->haschild($temp_id, $arrobj) == 1) {
                    $this->str .= "<li class=\"dropdown\"><a href='#' class=\"dropdown-toggle\" data-toggle=\"dropdown\">" . $obj->menu_name . " <b class=\"caret\"></b></a><ul class=\"dropdown-menu\">";
                    $this->findchild($temp_id, $arrobj, $selected_id, $userRoleMenuId);
                    $this->str .= "</ul></li>";
                }

            }
        }
    }

    public function showMenu()
    {

        if (Yii::app()->session['LOGGED_USER'] != null) {
            $userObj = new Users();
            $userObj = Yii::app()->session['LOGGED_USER'];
            $value = '';

            $userRoleId = $userObj->role_id;

            $appicationId = Roles::getAppicationIdByRoleId($userRoleId);

            if ($appicationId != BE) {
                Yii::app()->user->logout();
                Yii::app()->controller->redirect(Yii::app()->createAbsoluteUrl('admin/site/login'));
            }

            $userRoleMenu = RolesMenus::model()->findAll(array('condition' => 'role_id=' . $userRoleId . ' AND role_website_id =' . ROLE_WEBSITE_ID));
//            echo '<pre>';
//            print_r($userRoleMenu);
//            echo '</pre>';

            $userRoleMenuId = array();

            if ($userRoleMenu) {
                foreach ($userRoleMenu as $u) {
                    $userRoleMenuId[] = $u->menu_id;
                }
            }

//            echo '<pre>';
//            print_r($userRoleMenuId);
//            echo '</pre>';


            $menusTemp = Menus::model()->findAll(array('condition' => 'show_in_menu="1" AND role_website_id =' . ROLE_WEBSITE_ID, 'order' => 'display_order asc'));

//            echo '<pre>';
//            foreach ($menusTemp as $item) {
//                echo $item->id . ' - ';
//            }
//            echo '</pre>';

            // MAY 12, 2014 ANH DUNG ADD
            $menus = array();
            foreach ($menusTemp as $menuTemp) {

                if ($menuTemp->menu_link == '') {
                    $menus[] = $menuTemp;
                    continue;
                }

                $aLinks = explode('/', $menuTemp->menu_link);
                $c = ''; // controller name
                $a = ''; // action name

                if (count($aLinks) == 2) {
                    $c = $aLinks[1];
                    $a = 'Index';
                } elseif (count($aLinks) > 2) {
                    $c = $aLinks[1];
                    $a = ucfirst($aLinks[2]);
                }
                $aActionAllowed = ActionsUsers::getActionArrayAllowForCurrentUserByControllerName($c);
                $aActionAllowed = array_map('strtolower', $aActionAllowed);
                $aActionAllowed = array_map('trim', $aActionAllowed);// Now 14, 2014 ANH DUNG ADD
                if (in_array(strtolower($a), $aActionAllowed)) {
                    $menus[] = $menuTemp;
                }

//                if ($menuTemp->id == 296) {
//
//
//                    echo '<pre>';
//                    echo 'c: '.$c .'- a: ' . $a ;
//                    echo '<br>';
//                    echo count($aLinks);
//                    echo '<br>';
//                    print_r($aLinks);
//                    echo '<br>';
//                    print_r($aActionAllowed);
//                    echo '</pre>';
//                }
            }

            // MAY 12, 2014 ANH DUNG ADD 
            $this->str = "<ul class='nav'>";
            $this->str .= "<li class='nav_li'><a href='" . Yii::app()->createAbsoluteUrl('/admin') . "'>Home</a></li>";
            if ($menus != NULL) {
                $this->findchild(0, $menus, $value, $userRoleMenuId);
            }
            $this->str .= "</ul>";
            if (Yii::app()->user->id) {
                if (isset(Yii::app()->user->application_id) && Yii::app()->user->application_id == BE)
                    return $this->str;
                else
                    return '';
            } else
                return '';
        }
        return '';
    }

}