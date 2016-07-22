<?php
class Announcement extends _BasePostNoMulti
{

    //multi language
    public $modelTranslate ='AnnouncementsTranslate';
    public $short_content;
    public $content;
    public $title;
    //multi language

    public $uploadImageFolder = 'upload/cms'; //remember remove ending slash
    public $defineImageSize = array(
        'featured_image' => array(array('alias' => 'thumb1', 'size' => '320x310')),
    );
    
    public $pageType    = 'announcement';
    public $categoryId;

    public function tableName()
    {
        return '{{_announcements}}';
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function rules()
    {
        $retRules = parent::rules();

        $retRules[] = array('status', 'required', 'on' => 'create, update');
        $retRules[] = array('author_infos', 'safe');
        return $retRules;
    }

    public function defaultScope() {
        return array(
            'condition' => "post_type='" . $this->pageType . "'",
        );
    }

    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        $return =  array(
            'translate' => array(self::HAS_MANY, $this->modelTranslate, 'translate_id','limit' => 1,'on'=>"translate.language='".Yii::app()->language."'"),   
        );
        return $return;
    }

    public function getSlugById($id)
    {
        return Announcement::model()->findByPk((int)$id);
    }

    protected function beforeSave()
    {
        $this->post_type = $this->pageType;
        return parent::beforeSave();
    }


    public function getAllGrid() {
        $criteria=new CDbCriteria;
        $criteria->compare('status', STATUS_ACTIVE);
        // gioi han search theo tung website
        $criteria->compare('role_website_id', ROLE_WEBSITE_ID, true);
        $criteria->order = 'modified_date DESC, created_date DESC';
        return new CActiveDataProvider('Announcement', array(
            'criteria'=>$criteria,
            'pagination' => array(
                'pageSize' => 6,
            ),
        ));
    }

    public function getLatest() {
        $criteria=new CDbCriteria;
        $criteria->compare('status', STATUS_ACTIVE);
        // gioi han search theo tung website
        $criteria->compare('role_website_id', ROLE_WEBSITE_ID, true);
        $criteria->order = 'modified_date DESC, created_date DESC';
        $criteria->limit = 5;
        return self::model()->findAll($criteria);
    }

    public function getRelate($id) {
        $criteria=new CDbCriteria;
        $criteria->addCondition('id != '.$id);
        $criteria->compare('status', STATUS_ACTIVE);
        // gioi han search theo tung website
        $criteria->compare('role_website_id', ROLE_WEBSITE_ID, true);
        $criteria->order = 'modified_date DESC, created_date DESC';
        $criteria->limit = 6;
        return self::model()->findAll($criteria);
    }

    public function nextOrderNumber()
    {
        return Announcement::model()->count() + 1;
    }

    /**
     * @Author Haidt <haidt3004@gmail.com>
     * @copyright 2015 Verz Design
     * @return string
     * @Todo: render featured image
     */
    public function getFeaturedImage($size = 'thumbs') {
        if (!empty($this->featured_image)) {
            return CHtml::image(ImageHelper::getImageUrl($this, 'featured_image', $size), $this->featured_image);
        }
        return '';
    }

    /**
     * @Author Haidt <haidt3004@gmail.com>
     * @copyright 2015 Verz Design
     * @return string
     * @Todo: get title of Announcement
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @Author Haidt <haidt3004@gmail.com>
     * @copyright 2015 Verz Design
     * @return string
     * @Todo: get description of Announcement
     */
    public function getDescription() {
        return $this->short_content;
    }

    /**
     * @Author Haidt <haidt3004@gmail.com>
     * @copyright 2015 Verz Design
     * @return string
     * @Todo: get content of Announcement
     */
    public function getContent() {
        return $this->content;
    }

    public static function getTimeExist()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('t.status', 1);
        // gioi han search theo tung website
        $criteria->compare('t.role_website_id', ROLE_WEBSITE_ID, true);
        $criteria->order = 'created_date DESC';
        $totals = Announcement::model()->findAll($criteria);



        $leftFilters = array();
        foreach ($totals as $total) {
            $leftFilters[] = array(
                'month' => date_format(date_create($total->created_date), "n"),
                'year' => date_format(date_create($total->created_date), "Y"),
            );
        }

        $leftFilters = array_unique($leftFilters, SORT_REGULAR);

        $leftDatas = array();
        $index = 0;
        $old_key = '';
        foreach ($leftFilters as $leftFilter) {
            if ($index == 0) {
                $leftDatas[$leftFilter['year']] = array($leftFilter['month']);
                $old_key = $leftFilter['year'];
            } else {
                if ($old_key == $leftFilter['year']) {
                    $leftDatas[$leftFilter['year']][] = $leftFilter['month'];
                } else {
                    $leftDatas[$leftFilter['year']] = array($leftFilter['month']);
                }
            }

            $index++;
        }

        return $leftDatas;
    }

    public function showTile(){
         $this->getDataTranslate();
         return $this->title;
    }

}

