<?php

/**
 * This is the model class for table "{{_banners}}".
 *
 * The followings are the available columns in table '{{_banners}}':
 * @property integer $id
 * @property string $name
 * @property string $banner_title
 * @property string $banner_description
 * @property string $thumb_image
 * @property string $large_image
 * @property string $link
 * @property integer $place_holder_id
 * @property integer $status
 * @property integer $order_display
 * @property integer $language_id
 * @property string $created_date
 */
class BannerItem extends _BaseModel {

	public $maxImageFileSize = 3145728; //3MB
	public $allowImageType = 'jpg,gif,png';
	public $uploadImageFolder = 'upload/banners'; //remember remove ending slash
	public $defineImageSize = array('large_image' => array());
	public $createFullImage = true;
	public $fieldNameImage = 'large_image';

	const BANNER_IMAGE_TYPE = 1;
	const BANNER_SCRIPT_TYPE = 2;

	public static $arrBannerType = array(
		self::BANNER_IMAGE_TYPE => 'Image Banner',
		self::BANNER_SCRIPT_TYPE => 'Google Adsense',
	);

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return '{{_banners}}';
	}

	public function init() {
		//var_dump(GroupBanner::getDefaultSize());die;
		$this->defineImageSize = array('large_image' => GroupBanner::getDefaultSize());
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_display, language_id', 'required'),
			array('status, order_display, banner_type', 'numerical', 'integerOnly' => true),
			array('name', 'length', 'max' => 250),
			array('thumb_image, large_image, link', 'length', 'max' => 255),
			array('banner_title,large_image', 'required', 'on' => 'create, update'),
			array('google_adsense_script', 'safe'),
			array('banner_title, google_adsense_script', 'required', 'on' => 'createScript, updateScript'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, banner_title, banner_description, thumb_image, large_image, link, status, order_display, created_date, language_id', 'safe', 'on' => 'search'),
			array('large_image', 'file', 'on' => 'create',
				'allowEmpty' => false,
				'types' => $this->allowImageType,
				'wrongType' => 'Only jpg,gif,png are allowed.',
				'maxSize' => $this->maxImageFileSize, // 3MB
				'tooLarge' => 'The file was larger than' . ($this->maxImageFileSize / 1024) / 1024 . 'MB. Please upload a smaller file.',
			),
			array('large_image', 'file', 'on' => 'update',
				'allowEmpty' => true,
				'types' => $this->allowImageType,
				'wrongType' => 'Only jpg,gif,png are allowed.',
				'maxSize' => $this->maxImageFileSize, // 3MB
				'tooLarge' => 'The file was larger than' . ($this->maxImageFileSize / 1024) / 1024 . 'MB. Please upload a smaller file.',
			),
			array('banner_title_2, link_text', 'safe'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'groupbanner' => array(self::BELONGS_TO, 'GroupBanner', 'group_banner_id'),
			'rTotalClicked' => array(self::HAS_MANY, 'BannersClickedCounter', 'banner_item_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => Yii::t('translation', 'ID'),
			'name' => Yii::t('translation', 'Name'),
			'banner_title' => Yii::t('translation', 'Banner Title'),
			'banner_title_2' => Yii::t('translation', 'Banner Title 2'),
			'banner_description' => Yii::t('translation', 'Banner Description'),
			'thumb_image' => Yii::t('translation', 'Thumb Image'),
			'large_image' => Yii::t('translation', 'Banner Image'),
			'link' => Yii::t('translation', 'Link'),
			'link_text' => Yii::t('translation', 'Link Text'),
			'status' => Yii::t('translation', 'Visibility'),
			'order_display' => Yii::t('translation', 'Order Display'),
			'created_date' => Yii::t('translation', 'Created Date'),
			'group_banner_id' => Yii::t('translation', 'Banner Group'),
			'google_adsense_script' => Yii::t('translation', 'Google Ads'),
			'language_id' => Yii::t('translation', 'Language')
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search() {
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('banner_title', $this->banner_title, true);
		$criteria->compare('banner_description', $this->banner_description, true);
		$criteria->compare('thumb_image', $this->thumb_image, true);
		$criteria->compare('large_image', $this->large_image, true);
		$criteria->compare('link', $this->link, true);
		$criteria->compare('status', $this->status);
		$criteria->compare('order_display', $this->order_display);
		$criteria->compare('language_id', $this->language_id);
		$criteria->compare('created_date', $this->created_date, true);
		$sort = new CSort();

		$sort->attributes = array(
			'name' => array(
				'asc' => 't.order_display',
				'desc' => 't.order_display desc',
				'default' => 'asc',
			),
		);
		$sort->defaultOrder = 't.order_display asc';


		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => array(
				'pageSize' => Yii::app()->params['defaultPageSize'],
			),
		));
	}

	public function searchAdmin() {
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('banner_title', $this->banner_title, true);
		$criteria->compare('banner_description', $this->banner_description, true);
		$criteria->compare('thumb_image', $this->thumb_image, true);
		$criteria->compare('large_image', $this->large_image, true);
		$criteria->compare('link', $this->link, true);
		$criteria->compare('status', $this->status);
		$criteria->compare('order_display', $this->order_display);
		$criteria->compare('language_id', $this->language_id);
		$criteria->compare('created_date', $this->created_date, true);
		$criteria->compare('group_banner_id', $this->group_banner_id);
		$sort = new CSort();
		$sort->attributes = array(
			'name' => array(
				'asc' => 't.order_display',
				'desc' => 't.order_display desc',
				'default' => 'asc',
			),
		);
		$sort->defaultOrder = 't.order_display asc';


		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => array(
				'pageSize' => Yii::app()->params['defaultPageSize'],
			),
		));
	}

	public function activate() {
		$this->status = 1;
		$this->update();
	}

	public function deactivate() {
		$this->status = 0;
		$this->update();
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Banner the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function nextOrderNumber() {
		$criteria = new CDbCriteria;
		$criteria->compare('group_banner_id', $this->group_banner_id);
		return self::model()->count($criteria) + 1;
	}

	protected function beforeSave() {
		if (parent::beforeSave()) {
			if ($this->isNewRecord)
				$this->created_date = date('Y-m-d H:i:s');
		}
		return true;
	}

	/**
	 * @Author Haidt <haidt3004@gmail.com>
	 * @copyright 2015 Verz Design 	 	 
	 * @param int $group_id
	 * @return objects
	 * @Todo: get all banner
	 */
	public function getAllBanner($group_id) {
		$language = Languages::model()->findByAttributes(array('code'=> Yii::app()->language));
		
		$criteria = new CDbCriteria;
		if (!empty($language)) {
			$criteria->compare('language_id', $language->id);
		}
		$criteria->compare('group_banner_id', $group_id);
		$criteria->compare('status', STATUS_ACTIVE);
		$criteria->order = 'order_display asc';
		return self::model()->findAll($criteria);
	}

	public static function getCurrentPage() {
		return "http" . (($_SERVER['SERVER_PORT'] == 443) ? "s://" : "://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	}

	/**
	 * @Author Haidt <haidt3004@gmail.com>
	 * @copyright 2015 Verz Design 	 	 
	 * @params string $optionClass
	 * @params string $style
	 * @return string
	 * @Todo: render image
	 */
	public function getImage($optionClass = '', $style = '') {
		if (!empty($this->large_image)) {
			return CHtml::image(ImageHelper::getImageUrl($this, 'large_image', GroupBanner::model()->getRecommendSizeName($this->group_banner_id)), $this->large_image, array('class' => $optionClass, 'style' => $style));
		}
		return '';
	}

	/**
	 * @Author Haidt <haidt3004@gmail.com>
	 * @copyright 2015 Verz Design 	 	 
	 * @return string
	 * @Todo: get title 1
	 */
	public function getTitle1() {
		return $this->banner_title;
	}

	/**
	 * @Author Haidt <haidt3004@gmail.com>
	 * @copyright 2015 Verz Design 	 	 
	 * @return string
	 * @Todo: get title 2
	 */
	public function getTitle2() {
		return $this->banner_title_2;
	}

	/**
	 * @Author Haidt <haidt3004@gmail.com>
	 * @copyright 2015 Verz Design 	 	 
	 * @return string
	 * @Todo: get description
	 */
	public function getDescription() {
		return $this->banner_description;
	}

	/**
	 * @Author Haidt <haidt3004@gmail.com>
	 * @copyright 2015 Verz Design 	 	 
	 * @return string
	 * @Todo: get google script
	 */
	public function getGoogleScript() {
		return $this->google_adsense_script;
	}

	/**
	 * @Author Haidt <haidt3004@gmail.com>
	 * @copyright 2015 Verz Design 	 	 
	 * @Todo: banner click increase
	 */
	public function increaseClick() {
		if ($this->checkCanCountClick()) {
			$model = new BannersClickedCounter();
			$model->banner_item_id = $this->id;
			$model->save();
		}
	}

	/**
	 * @Author Haidt <haidt3004@gmail.com>
	 * @copyright 2015 Verz Design 	 	 
	 * @return boolean
	 * @Todo: check cookie,session or ip that can increase counter
	 */
	public function checkCanCountClick() {
		// todo : implement follow requirement

		return true; // counter every click at this time
	}

	/**
	 * @Author Haidt <haidt3004@gmail.com>
	 * @copyright 2015 Verz Design 	 	 
	 * @return string
	 * @Todo: get banner type name
	 */
	public function getBannerType() {
		return isset(self::$arrBannerType[$this->banner_type]) ? self::$arrBannerType[$this->banner_type] : '';
	}

	/**
	 * @Author Haidt <haidt3004@gmail.com>
	 * @copyright 2015 Verz Design 	 	 
	 * @params int 
	 * @Todo: get number of  clicks
	 */
	public function getNumberOfClick() {
		return isset($this->rTotalClicked) ? count($this->rTotalClicked) : 0;
	}

	/**
	 * @Author Haidt <haidt3004@gmail.com>
	 * @copyright 2015 Verz Design 	 	 
	 * @param string $attr
	 * @Todo: check show/hide attribute
	 */
	public function checkVisible($attr) {
		if ($attr == "total_click") {
			if (Yii::app()->params['enableBannerClickCounter'] != 'yes') {
				return false;
			}
		}
		if ($this->banner_type == self::BANNER_SCRIPT_TYPE) {
			$hideAttr = array(
				"banner_title_2",
				"banner_description",
				"large_image",
				"link",
				"link_text"
			);
			if (in_array($attr, $hideAttr)) {
				return false;
			}
		}

		if ($this->banner_type == self::BANNER_IMAGE_TYPE) {
			if ($attr == "google_adsense_script") {
				return false;
			}
		}

		return true;
	}

	public function getLanguageName()
	{
		$language = Languages::model()->findByPk($this->language_id);

		if (!empty($language)) {
			return $language->title;
		}

		return '';
	}

}
