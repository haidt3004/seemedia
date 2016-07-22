<?php

/**
 * This is the model class for table "{{_email_templates_translate}}".
 *
 * The followings are the available columns in table '{{_email_templates_translate}}':
 * @property integer $id
 * @property integer $translate_id
 * @property string $email_subject
 * @property string $email_body
 * @property string $parameter_description
 */
class EmailTemplatesTranslate extends _BaseModel {
		
		/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_email_templates_translate}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('translate_id', 'numerical', 'integerOnly'=>true),
			array('email_subject', 'length', 'max'=>255),
			array('email_body, parameter_description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, translate_id, email_subject, email_body, parameter_description', 'safe', 'on'=>'search'),
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
			'translate_id' => Yii::t('translation','Translate'),
			'email_subject' => Yii::t('translation','Email Subject'),
			'email_body' => Yii::t('translation','Email Body'),
			'parameter_description' => Yii::t('translation','Parameter Description'),
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
		$criteria->compare('translate_id',$this->translate_id);
		$criteria->compare('email_subject',$this->email_subject,true);
		$criteria->compare('email_body',$this->email_body,true);
		$criteria->compare('parameter_description',$this->parameter_description,true);
					
		 
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
	 * @return EmailTemplatesTranslate the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function nextOrderNumber()
	{
		return EmailTemplatesTranslate::model()->count() + 1;
	}
}
