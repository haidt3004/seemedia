<?php

/**
 * This is the model class for table "{{_policies_translate}}".
 *
 * The followings are the available columns in table '{{_policies_translate}}':
 * @property integer $id
 * @property string $title
 * @property string $short_content
 * @property string $content
 * @property integer $role_web_site_id
 * @property integer $translate_id
 * @property string $language
 */
class PoliciesTranslate extends _BaseModel {
		
		/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_policies_translate}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('role_web_site_id, translate_id', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>400),
			array('language', 'length', 'max'=>255),
			array('short_content, content', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, short_content, content, role_web_site_id, translate_id, language', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
	
																						);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('translation','ID'),
			'title' => Yii::t('translation','Title'),
			'short_content' => Yii::t('translation','Short Content'),
			'content' => Yii::t('translation','Content'),
			'role_web_site_id' => Yii::t('translation','Role Web Site'),
			'translate_id' => Yii::t('translation','Translate'),
			'language' => Yii::t('translation','Language'),
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('short_content',$this->short_content,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('role_web_site_id',$this->role_web_site_id);
		$criteria->compare('translate_id',$this->translate_id);
		$criteria->compare('language',$this->language,true);
					
		 
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
                'pageSize'=> Yii::app()->params['defaultPageSize'],
            ),
		));
	}

	

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PoliciesTranslate the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function nextOrderNumber()
	{
		return PoliciesTranslate::model()->count() + 1;
	}
}
