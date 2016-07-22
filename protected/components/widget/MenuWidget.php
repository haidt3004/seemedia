<?php
class MenuWidget extends CWidget{
    public $layout;//layout1, layout2
    public $menu;
    public $parent;
    public $highlight;
    public $id_mn;
    public function init(){

        $controllerName = Yii::app()->controller->id;
        $actionName = Yii::app()->controller->action->id;
        if ($controllerName == 'article') {
            Yii::app()->params['hightlight_menu_id_list'] = array(
                'layout1' => 45,
            );
        } else
        if ($controllerName == 'listing') {
            Yii::app()->params['hightlight_menu_id_list'] = array(
                'layout1' => 44,
            );
        } else
        if ($controllerName == 'video') {
            Yii::app()->params['hightlight_menu_id_list'] = array(
                'layout1' => 65,
                'layout3' => 56,
            );
        } else
        if ($controllerName == 'site' && $actionName == "contactus") {
            Yii::app()->params['hightlight_menu_id_list'] = array(
                'layout1' => 66,
                'layout3' => 57,
            );
        } else
        if ($controllerName == 'site' && $actionName == "index") {
            Yii::app()->params['hightlight_menu_id_list'] = array(
                //'main_menu' => 96,
               // 'footer_menu' => 110,
            );
        }
        
        $this->highlight = Yii::app()->params['hightlight_menu_id_list'];
    }
    public function run() {
        if ($this->menu == MENU_MAIN) {
            $this->render("menu/".$this->layout);
        } else {
            $menu_items = Menuitem::model()->getListActiveByMenu($this->menu, $this->parent);
            foreach ($menu_items as $menu_item) {
                $menu_item->getDataWithLangauge($menu_item, Yii::app()->language);
            }
            $this->render("menu/".$this->layout, array(
                'menu_items' => $menu_items,
            ));
        }
    }
}
