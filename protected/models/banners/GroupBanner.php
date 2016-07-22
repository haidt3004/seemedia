<?php

/**
 * This is the model class for table "gama_group_banners".
 *
 * The followings are the available columns in table 'gama_group_banners':
 * @property integer $id
 * @property string $name
 */
class GroupBanner extends _BaseModel {

	// haidt - define group type
	const GROUP_POSITION = 'position';
	const GROUP_URL = 'url';

	public static $groupTypes = array(
		self::GROUP_POSITION => 'Position',
		self::GROUP_URL => 'Url',
	);

	const GROUP_BANNER_TYPE_HOME = 'home';
	const GROUP_BANNER_TYPE_ADS = 'ads';

	public static $arrGroupBannerType = array(
		self::GROUP_BANNER_TYPE_HOME => 'Home Banner', // will not has google ad
		self::GROUP_BANNER_TYPE_ADS => 'Ads Banner', // will has google ad
	);

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return '{{_group_banners}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, type, recommended_width, recommended_height', 'required'),
			array('name', 'length', 'max' => 250),
			array('group_banner_type', 'length', 'max' => 255),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, type, name', 'safe', 'on' => 'search'),
			array('display_in_url', 'requiredUrl'),
			// require admin choose position for group banner
		);
	}

	public function requiredUrl($attribute, $params) {
		if ($this->type == self::GROUP_URL && empty($this->$attribute)) {
			$lb = $this->getAttributeLabel($attribute);
			$this->addError($attribute, "$lb cannot be blank.");
		}
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => Yii::t('translation', 'ID'),
			'name' => Yii::t('translation', 'Name'),
			'display_in_url' => Yii::t('translation', 'Display in url'),
			'group_banner_type' => Yii::t('translation', 'Group Type'),
			'type' => Yii::t('translation', 'Display Type'),
			'recommended_width' => Yii::t('translation', 'Recommended Width'),
			'recommended_height' => Yii::t('translation', 'Recommended Height'),
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
		$criteria->compare('type', $this->type, true);
		$criteria->compare('name', $this->name, true);
		// gioi han search theo tung website
		$criteria->compare('user_id', Yii::app()->user->id, true);
		$criteria->compare('role_website_id', ROLE_WEBSITE_ID, true);
		$sort = new CSort();

		$sort->attributes = array(
			'name' => array(
				'asc' => 't.name',
				'desc' => 't.name desc',
				'default' => 'asc',
			),
		);
		$sort->defaultOrder = 't.name asc';


		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => array(
				'pageSize' => Yii::app()->params['defaultPageSize'],
			),
		));
	}

	public function behaviors() {
		return array('sluggable' => array(
				'class' => 'application.extensions.mintao-yii-behavior-sluggable.SluggableBehavior',
				'columns' => array('name'),
				'unique' => true,
				'update' => true,
			),);
	}

	public function getDetailBySlug($slug) {
		$criteria = new CDbCriteria;
		$criteria->compare('t.slug', $slug);
		return GroupBanner::model()->find($criteria);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GroupBanner the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function nextOrderNumber() {
		return GroupBanner::model()->count() + 1;
	}

	public function beforeSave() {

		$this->user_id = Yii::app()->user->id;
		$this->role_website_id = ROLE_WEBSITE_ID;
		return true;
	}

	public static function getActiveBanner($current_link) {
		$match = trim($current_link, '/');
		$models = self::model()->findAll(array(
			'order' => 'id ASC'
		));

		if (!empty($models)) {
			foreach ($models as $model) {
				$display_in_url = explode("<br />", nl2br($model->display_in_url));
				foreach ($display_in_url as $url) {
					$check_url = str_replace(array('/', '*', ' or '), array('\/', '.*', '|'), trim($url));
					if (preg_match("/^({$check_url})$/i", $current_link, $matches)) {
						return $model;
					}
				}
			}
		}
		return NULL;
	}

	public function getType() {
		$group_types = self::$groupTypes;
		return $group_types[$this->type];
	}

	public function getDisplayInUrl() {
		return nl2br($this->display_in_url);
	}

	public function getRecommendSize($id) {
		$model = self::model()->findByPk($id);
		if ($model) {
			return 'Recommended Size (width x height): ' . $model->recommended_width . 'px x ' . $model->recommended_height . 'px<br/>';
		}
		return '';
	}

	public function getRecommendSizeName($id) {
		$model = self::model()->findByPk($id);
		if ($model) {
			return $model->recommended_width . 'x' . $model->recommended_height;
		}
		return null;
	}

	public static function getDefaultSize() {
		$criteria = new CDbCriteria;
		$models = GroupBanner::model()->findAll($criteria);
		$result = array();
		if ($models) {
			foreach ($models as $model) {
				$result[] = array('alias' => self::model()->getRecommendSizeName($model->id), 'size' => self::model()->getRecommendSizeName($model->id));
			}
		}
		return $result;
	}

	/**
	 * @Author Haidt <haidt3004@gmail.com>
	 * @copyright 2015 Verz Design 	 	 
	 * @param string $attr attribute name
	 * @return boolean
	 * @Todo: check to show / hide field
	 */
	public function checkVisible($attr) {
		if ($attr == 'display_in_url') {
			if ($this->type == self::GROUP_URL) {
				return true;
			}
		}
		return false;
	}

	/**
	 * @Author Haidt <haidt3004@gmail.com>
	 * @copyright 2015 Verz Design 	 	 
	 * @return string
	 * @Todo: get group banner type
	 */
	public function getGroupBannerType() {
		return isset(self::$arrGroupBannerType[$this->group_banner_type]) ? self::$arrGroupBannerType[$this->group_banner_type] : '';
	}

}
