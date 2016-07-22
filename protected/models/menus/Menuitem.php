<?php

/**
 * This is the model class for table "{{_menuitem}}".
 *
 * The followings are the available columns in table '{{_menuitem}}':
 * @property string $id
 * @property string $name
 * @property string $link
 * @property integer $order
 * @property integer $status
 * @property string $parent_id
 * @property string $menu_id
 * @property string $target
 * @property string $created
 * @property string $modified


 */
class Menuitem extends _BaseModel {

    /*config language*/

    //public $languageDefault='en';
    public $modelTranslate='MenuitemTranslate';


    public $name;

    /*end config*/





    public $delete = false;
    public static $data = NULL;
    public $menuDataId = null;
    public static $active_branch;

    const TYPE_LINK = 0;
    const TYPE_CMS_PAGE = 1;
    const TYPE_STATIC_PAGE = 2;
    
    // XuanTinh: define for import to list FE menu
    const FE_MENU_TYPE_CATE_LISTING_ID = 3; // note: define this case mustbe > 2, and unique on type
    const FE_MENU_CATE_LISTING_MODEL = "ListingsCategories";
    const FE_MENU_TYPE_CATE_ARTICLE_ID = 4; // note: define this case mustbe > 2, and unique on type define
    const FE_MENU_CATE_ARTICLE_MODEL = "CategoryArticle";
    const FE_MENU_TYPE_CATE_VIDEO_ID = 5; // note: define this case mustbe > 2, and unique on type define
    const FE_MENU_CATE_VIDEO_MODEL = "VideosCategory";

    public static $TYPES = array(
        self::TYPE_LINK => 'External Link',
        self::TYPE_CMS_PAGE => 'Cms Page',
        self::TYPE_STATIC_PAGE => 'Static Page',
//        self::FE_MENU_TYPE_CATE_LISTING_ID => 'Listing Categories',
//        self::FE_MENU_TYPE_CATE_ARTICLE_ID => 'Article Categories',
//        self::FE_MENU_TYPE_CATE_VIDEO_ID => 'Video Categories',
    );

    // XuanTinh
    public static $TYPE_MODELS = array(
        self::FE_MENU_TYPE_CATE_LISTING_ID => self::FE_MENU_CATE_LISTING_MODEL,
        self::FE_MENU_TYPE_CATE_ARTICLE_ID => self::FE_MENU_CATE_ARTICLE_MODEL,
        self::FE_MENU_TYPE_CATE_VIDEO_ID => self::FE_MENU_CATE_VIDEO_MODEL,
    );

    public static $STATIC_PAGES = array(
        'site/index' => 'Home page',
        'site/eleave' => 'eLeave page',
        // LKHPOWERDISTRIBUTION.COM = 7, LIMKIMHAI.COM.SG = 4
//	    'site/eleaveExternal' => 'eLeave External page',
//        'site/eleaveInternal' => 'eLeave Internal page',
        // END LKHPOWERDISTRIBUTION.COM = 7, LIMKIMHAI.COM.SG = 4
        'site/whistleblow' => 'Whistle Blow',
        'site/contactus' => 'Contact Us',
    );

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Menuitem the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{_menuitem}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('order, status, type', 'numerical', 'integerOnly' => true),
            array('name, link', 'length', 'max' => 255),
            array('parent_id, menu_id', 'length', 'max' => 11),
            array('target', 'length', 'max' => 20),
            array('modified, link, status, order, parent_id, menu_id, menuDataId, target', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, link, order, status, parent_id, menu_id, target, created, modified, menuDataId', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'menu_fk' => array(self::BELONGS_TO, 'Menu', 'menu_id'),
            'parent' => array(self::BELONGS_TO, 'Menuitem', 'parent_id'),
//            'translate' => array(self::HAS_MANY, $this->modelTranslate, 'translate_id','limit' => 1,'on'=>"translate.language='".$this->languageDefault."'"),
            'translate' => array(self::HAS_MANY, $this->modelTranslate, 'translate_id','limit' => 1,'on'=>"translate.language='".Yii::app()->language."'"),

        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Label',
            'link' => 'Link',
            'order' => 'Order',
            'status' => 'Status',
            'parent_id' => 'Parent',
            'menu_id' => 'Menu',
            'target' => 'Target',
            'created' => 'Created',
            'modified' => 'Modified',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria;
        $criteria->compare('t.id', $this->id, true);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.link', $this->link, true);
        $criteria->compare('t.order', $this->order);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('t.parent_id', $this->parent_id, true);
        $criteria->compare('t.menu_id', $this->menu_id, true);
        $criteria->compare('t.target', $this->target, true);
        $criteria->compare('t.created', $this->created, true);
        $criteria->compare('t.modified', $this->modified, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
        ));
    }

    /*
      public function activate()
      {
      $this->status = 1;
      $this->update();
      }



      public function deactivate()
      {
      $this->status = 0;
      $this->update();
      }
     */

    public function defaultScope() {
        return array(
                //'condition'=>'',
        );
    }

    public static function findByMenu($menu) {
        $criteria = new CDbCriteria;
        $criteria->compare('t.menu_id', $menu);
        $criteria->order = 't.order ASC';
        return self::model()->findAll($criteria);
    }

    public static function findActiveByMenu($menu) {
        $criteria = new CDbCriteria;
        $criteria->compare('t.status', STATUS_ACTIVE);
        $criteria->compare('t.menu_id', $menu);
        $criteria->order = 't.order ASC';
        return self::model()->findAll($criteria);
    }

    public static function findByParent($parent) {
        return self::model()->findAll('parent_id = ' . $parent);
    }

    public static function getData() {
        if (self::$data == NULL) {
            self::$data = self::model()->findAll(array('order' => '`order` ASC'));
            return self::$data;
        }
        return self::$data;
    }

    public function getParentIdFromHierachy($hierachy, $models) {
        $parentDataId = self::getParentDataIdFromDataId($this->menuDataId, $hierachy);
        return self::getModelIdFromDataId($parentDataId, $models);
    }

    public static function getParentDataIdFromDataId($dataId, $hierachy, $parent = 0) {
        $return = array();
        foreach ($hierachy as $item) {
            if ($item['id'] == $dataId) {
                return $parent;
            } else if (!empty($item['children'])) {
                $return[] = self::getParentDataIdFromDataId($dataId, $item['children'], $item['id']);
            }
        }
        foreach ($return as $value)
            if (!empty($value))
                return $value;
    }

    public static function getModelIdFromDataId($dataId, $models) {
        foreach ($models as $model) {
            if ((string) $model->menuDataId == (string) $dataId)
                return $model->id;
        }
        return 0;
    }

    public function getChilds() {
        if ($this->isNewRecord)
            return array();

        $criteria = new CDbCriteria;
        $criteria->compare('t.parent_id', $this->id);
        $criteria->order = 't.order ASC';
        return Menuitem::model()->findAll($criteria);
    }

    public function getChildsFe() {
        if ($this->isNewRecord)
            return array();

        $criteria = new CDbCriteria;
        $criteria->compare('t.parent_id', $this->id);
        $criteria->compare('t.status', STATUS_ACTIVE);
        $criteria->order = 't.order ASC';
        return Menuitem::model()->findAll($criteria);
    }

    public static function findByPM($parent, $menu) {
        $criteria = new CDbCriteria;
        $criteria->compare('t.menu_id', $menu);
        $criteria->compare('t.parent_id', $parent);
        $criteria->order = 't.order ASC';
        return self::model()->findAll($criteria);
    }

    public static function showMenus($menu = MENU_MAIN, $parent = 0) {
        $criteria = new CDbCriteria;
        $criteria->compare('t.status', STATUS_ACTIVE);
        $criteria->compare('t.menu_id', $menu);
        $criteria->compare('t.parent_id', $parent);
        $criteria->order = 't.order ASC';
        return self::model()->findAll($criteria);
    }

    public static function buildMenuData($menu, $parent, $pageId, $active_class = 'active', $branch = array()) {
        $data = self::getData();
        $models = array();
        foreach ($data as $_data) {
            if ($_data->menu_id == $menu && $_data->parent_id == $parent && $_data->status == STATUS_ACTIVE) {
                $models[] = $_data;
            }
        }

        if (empty($models))
            return array();

        $data_menu_arr = array();
        foreach ($models as $key => $model) {
            $_branch = $branch;
            array_push($_branch, $model->id);
            $class = $model->link == $pageId && $model->type != Menuitem::TYPE_LINK ? $active_class : '';
            if ($class == $active_class)
                self::$active_branch[$menu] = $_branch;

            $data_menu_arr[$key] = array(
                'id' => $model->id,
                'branch' => $_branch,
                'title' => "$model->name",
                'link' => $model->createLink(),
                'type' => $model->type,
                'class' => $class,
                'target' => $model->target,
                'child' => self::buildMenuData($menu, $model->id, $pageId, $active_class, $_branch),
            );
        }
        return $data_menu_arr;
    }

    public function createLink() {
        switch ($this->type) {
            case self::TYPE_LINK:
                return preg_match('/http|https/', $this->link) ? $this->link : $this->createLocalLink($this->link);
                break;

            case self::TYPE_STATIC_PAGE:
                return $this->createLocalLink($this->link);
                break;

            case self::TYPE_CMS_PAGE:
                $p = Page::model()->findByPk((int) $this->link);
                return $p ? $p->getUrl() : Yii::app()->createAbsoluteUrl('site/notfound');
                break;
            case ($this->type > self::TYPE_CMS_PAGE):
                $arrTypeModels = self::$TYPE_MODELS;
                foreach ($arrTypeModels as $key => $value) {
                    if ($this->type == $key) {
                        return $value::getUrlFEmenu($this->link);
                    }
                }
                break;
        }
        return '';
    }

    /*
     * @author Lam Huynh
     */

    public function createLocalLink($relativeLink) {
        if (empty($relativeLink) || $relativeLink == '/')
            return Yii::app()->getBaseUrl(true);

        $q = parse_url($relativeLink, PHP_URL_QUERY);
        parse_str($q, $params);
        $res = Yii::app()->createAbsoluteUrl($relativeLink, $params);
        return $res;
    }

    public static function viewMenuStructure($menu, $parent, $level = 0, &$data_menu_arr) {
        $data = self::getData();

        $models = array();
        foreach ($data as $_data) {
            if ($_data->menu_id == $menu && $_data->parent_id == $parent && $_data->status == STATUS_ACTIVE) {
                $models[] = $_data;
            }
        }

        if (empty($models))
            return array();


        foreach ($models as $model) {
            $data_menu_arr[] = array(
                'title' => $model->name,
                'level' => $level
            );
            $level++;
            self::viewMenuStructure($menu, $model->id, $level, $data_menu_arr);
            $level--;
        }
        return $data_menu_arr;
    }

    //bb- 31/7/2014
    public static function checkActiveLink($link) {
        $uri = str_replace(Yii::app()->baseUrl, '', Yii::app()->request->requestUri);
        if ($uri == $link || $uri == '/' . $link) // short link to enable no need to change url when live site '/about-us' or 'login'
            echo 'class="active"';
        else {//full link with http://....
            $linkUri = strtr($link, array('http://' => '',
                'https://' => '',
                'https://www.' => '',
                $_SERVER['HTTP_HOST'] => '',
                    )
            );
            if (Yii::app()->request->requestUri == $linkUri)//   /BoH/about-us
                echo 'class="active"';
        }
    }

    public static function parentHighlight($id, $link) {
        $data = self::getData();
        $result = array();
        foreach ($data as $_data)
            if ($_data->id == $id) {
                $result[] = array($link => $_data->id);
                $result = array_merge($result, self::parentHighlight($_data->parent_id, $link));
            }
        return $result;
    }

    public static function highlight($external_highlight = array()) {
        $models = self::getData();
        $_highlight = array();
        foreach ($models as $model) {
            if ($model->parent_id == 0)
                $_highlight[] = array($model->link => $model->id);
            else
                $_highlight = array_merge($_highlight, self::parentHighlight($model->id, $model->link));
        }
        if (!empty($external_highlight))
            foreach ($external_highlight as $item)
                array_push($_highlight, $item);
        return $_highlight;
    }

    public function getCssClass() {
        $classes = array();
        if (!empty($this->childs))
            $classes[] = 'dropdown';

        $curMenuItem = Yii::app()->controller->getActiveMenuItem();
        if ($curMenuItem && $curMenuItem->id == $this->id)
            $classes[] = 'active';

        return implode(' ', $classes);
    }

    //Vnguyen
    public function getFooterItems() {
        $criteria = new CDbCriteria;
        $criteria->compare('t.status', STATUS_ACTIVE);
        $criteria->compare('t.menu_id', 6);
        $criteria->compare('t.parent_id', 0);
        $criteria->order = 't.order ASC';
        return self::model()->findAll($criteria);
    }

    //Htram
    public function getListActiveByMenu($menu_id, $parent_id) {
        $criteria = new CDbCriteria;
        $criteria->compare('t.status', STATUS_ACTIVE);
        $criteria->compare('t.menu_id', $menu_id);
        $criteria->compare('t.parent_id', $parent_id,true);
        
        $criteria->order = 't.order ASC';
        return self::model()->findAll($criteria);
    }
    
    // XuanTinh
    public static function getCateListData($menu_type) {
        $arrTypeModels = self::$TYPE_MODELS;
        foreach ($arrTypeModels as $key => $value) {
            if ($menu_type == $key) {
                return $value::getArrListCateForMenuFE();
            }
        }
        return array();
    }

}
