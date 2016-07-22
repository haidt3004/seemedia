<?php

class Page extends _BasePost {
    
    /*config multi language*/

    
    // public $languageDefault='vi';
    public $modelTranslate='PostsTranslate';


    // public $title;
    public $content;
    public $short_content;

    /*end config multi language*/






    public static $cannotDelete = array(1,2,3,16,17,18,50,73,74,161,198);
    const FE_PAGE_SIZE = 10;

    public static $LAYOUTS = array(
        'single' => 'Single page',
        'empty' => 'Only first child page',
    );
    public $uploadImageFolder = 'upload/cms'; //remember remove ending slash
    public $defineImageSize = array(
        'featured_image' => array(
            array('alias' => 'thumb1', 'size' => '204x94')
        ),
    );
    public $pageType = 'page';
    
    

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function rules() {
        $retRules = parent::rules();
        $retRules[] = array('layout', 'safe');
        return $retRules;
    }

    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'parent' => array(self::BELONGS_TO, 'Page', 'parent_id'),
            'childs' => array(self::HAS_MANY, 'Page', 'parent_id', 'order' => 'display_order ASC,  title ASC'),
            // 'translate' => array(self::HAS_MANY, $this->modelTranslate, 'translate_id','limit' => 1,'on'=>"translate.language='".$this->languageDefault."'"),
           'translate' => array(self::HAS_MANY, $this->modelTranslate, 'translate_id','limit' => 1,'on'=>"translate.language='".Yii::app()->language."'"),
            // 'translate_pk' => array(self::HAS_MANY, $this->modelTranslate, 'translate_id','on'=>"translate.language='".$this->languageDefault."'"),   
        );
    }

    public function defaultScope() {
        return array(
            'condition' => "post_type='" . $this->pageType . "'",
        );
    }

    //used by other one
    public function getSlugById($id) {
        return Page::model()->findByPk((int) $id);
    }

    public function searchPageBacked() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->with = array('translate');
        $criteria->together = true;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('translate.title', $this->title, true);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('t.created_date', $this->created_date, true);
        // gioi han search theo tung website
        $criteria->compare('t.role_website_id', ROLE_WEBSITE_ID, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params['defaultPageSize'],
            ),
        ));
    }

    public function getPageTree($publishedOnly = false, $parent = 0, $limitLevel = 0, $notIncluded = 0) {
        $criteria = new CDbCriteria ();
        $criteria->select = 't.title,t.status,t.created_date,t.id,t.parent_id,t.display_order';
        $criteria->compare('parent_id', $parent);
        // avoid cicle relationship
        if ($notIncluded != 0)
            $criteria->addCondition('id <> ' . $notIncluded);

        if ($publishedOnly == true)
            $criteria->compare('status', 1);

        $criteria->order = " display_order ASC, t.title ASC";
        $items = array();
        $pages = Page::model()->findAll($criteria);
        $level = 0;
        foreach ($pages as $child) {
            //var_dump($child->attributes);
            self::getListed($child, $level, $items, $publishedOnly, $limitLevel, $notIncluded);
        }
        return $items;
    }

    public function getListed($child, $level, &$return, $publishedOnly, $limitLevel, $notIncluded = 0) {
        $child->level = $level;
        $return[] = $child;
        $childItem = $child->childs;
        if (count($childItem) > 0) {
            foreach ($childItem as $item) {
                if ($notIncluded != 0 && $notIncluded == $item->id)
                    continue;

                if ($publishedOnly == true) {
                    if ($item->status == 1) {
                        if ($limitLevel > 0 && $level >= $limitLevel) {
                            return;
                        }
                        $level++;
                        self::getListed($item, $level, $return, $publishedOnly, $limitLevel);
                        $level--;
                    }
                } else {
                    if ($limitLevel > 0 && $level >= $limitLevel) {
                        return;
                    }
                    $level++;
                    self::getListed($item, $level, $return, $publishedOnly, $limitLevel);
                    $level--;
                }
            }
        }
    }

    public function getBreakscrum($currentPageID, &$return = array(), $publishedOnly = true) {
        $criteria = new CDbCriteria ();
        $criteria->select = 'title, slug, id, parent_id';
        $criteria->compare('id', $currentPageID);
        // gioi han search theo tung website
        $criteria->compare('role_website_id', ROLE_WEBSITE_ID, true);
        if ($publishedOnly == true)
            $criteria->compare('status', 1);
        $curPage = Page::model()->find($criteria);

        $return[] = $curPage->attributes;
        if ($curPage) {
            if ($curPage->parentPage) {
                $this->getBreakscrum($curPage->parentPage->id, $return, $publishedOnly);
            } else
                return;
        }
    }

    public function getRoot($currentPageID, &$return, $publishedOnly = true) {
        $criteria = new CDbCriteria ();
        $criteria->compare('id', $currentPageID);
        if ($publishedOnly == true)
            $criteria->compare('status', 1);
        $curPage = Page::model()->find($criteria);

        if ($curPage) {
            $return = $curPage;
            if (count($curPage->parentPage) > 0 && $curPage->parent_id != 0) {
                $this->getRoot($curPage->parentPage->id, $return, $publishedOnly);
            } else {
                return;
            }
        }
    }

    public function buildLevelTreeCharacter($level) {
       
        $ret = '';
        for ($i = 0; $i < $level; $i++)
            $ret .= "—";
        return $ret . " ";
    }
    public function showTile(){
         $this->getDataTranslate();

         return $this->buildLevelTreeCharacter($this->level) . $this->title;
    }

    public function buildPagesDropdown($excluded = 0) {
        $listPages = $this->getPageTree(false, 0, 2, $excluded);
        //$listPages = array (1 => 'a', 2 => 'b');
        $data = array('' => '-- Root --');
        foreach ($listPages as $item) {
            $tree = "";
            if ($item->level > 0) {
                $tree = "";
                for ($i = 0; $i < $item->level; $i++)
                    $tree .= "—";
            }

            $data[$item->id] = $tree . $item->title;
        }
        return $data;
    }

    public function buildPageTreeData() {
        $listPages = $this->getPageTree(false, 0, 2, $excluded);
        //$listPages = array (1 => 'a', 2 => 'b');
        $data = array('' => '-- Root --');
        foreach ($listPages as $item) {
            $tree = "";
            if ($item->level > 0) {
                $tree = "";
                for ($i = 0; $i < $item->level; $i++)
                    $tree .= "—";
            }

            $data[$item->id] = $tree . $item->title;
        }
        return $data;
    }

    public function nextOrderNumber() {
        return Page::model()->count() + 1;
    }

    /*
     * @author Lam Huynh
     */

    public function getUrl() {
        return Yii::app()->createAbsoluteUrl('cms/index', array('slug' => $this->slug));
    }

    /**
     * Tree level, starting from 0
     *
     * @var int
     */
    public $level;

    /*
     * @author Lam Huynh
     */

    public function getIndent() {
        return str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $this->level);
    }

    /*
     * @author Lam Huynh
     */

    public function getParentPageListData() {
        $pages = array();
        self::buildPageData($pages, null, 0, $this->id);
        $result = array();
        foreach ($pages as $page) {
            $result[$page->id] = $page->getIndent() . $page->title;
        }
        return $result;
    }

    /*
     * @author Lam Huynh
     */

    public static function buildPageData(&$arr, $parentCatId = null, $level = 0, $exclude = null) {
        foreach (self::getChildPages($parentCatId, $exclude) as $page) {
            $page->level = $level;
            $arr[] = $page;
            self::buildPageData($arr, $page->id, $level + 1, $exclude);
        }
    }

    /*
     * @author Lam Huynh
     */

    public static function getChildPages($parentId = null, $exclude = null) {
        $criteria = new CDbCriteria;
        // gioi han search theo tung website
        $criteria->compare('role_website_id', ROLE_WEBSITE_ID, true);
        $criteria->order = 'display_order';

        if ($parentId)
            $criteria->compare('parent_id', $parentId);
        else
            $criteria->addCondition('parent_id = 0');

        if ($exclude)
            $criteria->addCondition("t.id!=$exclude");

        return self::model()->findAll($criteria);
    }

    /*
     * @author Lam Huynh
     */

    public static function getPageTreeListData() {
        $pages = array();
        self::buildPageData($pages, null, 0);
        $result = array();
        foreach ($pages as $page) {
            $result[$page->id] = $page->getIndent() . $page->title;
        }
        return $result;
    }

    /*
     * @author Lam Huynh
     */

    protected function beforeSave() {
        if (empty($this->parent_id))
            $this->parent_id = 0;
        return parent::beforeSave();
    }

    public function getFeatureImageUrl() {
        if (empty($this->featured_image))
            return '';
        return sprintf('%s/upload/cms/%s/%s', Yii::app()->baseUrl, $this->id, $this->featured_image);
    }

    //Vnguyen
    public function getFirstChild($parent_id) {
        $criteria = new CDbCriteria;
        $criteria->order = 'display_order';
        $criteria->compare('parent_id', $parent_id);
        // gioi han search theo tung website
        $criteria->compare('role_website_id', ROLE_WEBSITE_ID, true);
        return self::model()->find($criteria);
    }

    public static function getPageListData() {
        $criteria = new CDbCriteria;
        $criteria->order = 'title';
        $criteria->compare('status', 1);
        // gioi han search theo tung website
        $criteria->compare('role_website_id', ROLE_WEBSITE_ID, true);
        return self::model()->findAll($criteria);
    }

	public static function getModelBySlug($slug) {
		$criteria = new CDbCriteria;
		$criteria->addCondition("slug = :slug");
		$criteria->addCondition("status = :status");
		$criteria->params = array(
			':slug' => $slug,
            // gioi han search theo tung website
			':role_website_id' => ROLE_WEBSITE_ID,
			':status' => STATUS_ACTIVE
		);
		return self::model()->find($criteria);
		//Haidt - closed - fix myslq injection
		//return self::model()->find("slug='" . $slug . "' and status=1");
	}
	
	//haidt - run for live
	public static function getAll() {
		return self::model()->findAll();
	}
        
        /**
	 * @Author xuan tinh
	 * @Todo: site search cms page
	 */
        public function siteSearch($keyword, $is_full = true, $count_all = false) {
            $criteria = new CDbCriteria();
            // compare keyword
            $criteria->compare('t.title', $keyword, true);
            $criteria->compare('t.content', $keyword, true, "OR");
            $criteria->compare('t.status', STATUS_ACTIVE);
            // gioi han search theo tung website
            $criteria->compare('t.role_website_id', ROLE_WEBSITE_ID, true);

            $criteria->order = 't.created_date desc';
//            dump($criteria);
            if ($is_full == false) {
                $criteria->limit = SITE_SEARCH_LIMIT;
            }
            if ($count_all) {
                return self::model()->findAll($criteria);
            } else {
                return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                        'pagination' => array(
                            'pageSize' => self::FE_PAGE_SIZE,
                        ),
                ));
            }
        }

}
