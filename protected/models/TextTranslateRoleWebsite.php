<?php

/**
 * This is the model class for table "{{_text_translate_role_website}}".
 *
 * The followings are the available columns in table '{{_text_translate_role_website}}':
 * @property integer $id
 * @property integer $text_translate_id
 * @property integer $role_website_id
 * @property string $value
 */
class TextTranslateRoleWebsite extends _BaseModel {
		


		/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_text_translate_role_website}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('text_translate_id, role_website_id', 'numerical', 'integerOnly'=>true),
			array('value', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, text_translate_id, role_website_id, value', 'safe', 'on'=>'search'),
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
			'text_translate_id' => Yii::t('translation','Text Translate'),
			'role_website_id' => Yii::t('translation','Role Website'),
			'value' => Yii::t('translation','Value'),
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
		$criteria->compare('text_translate_id',$this->text_translate_id);
		$criteria->compare('role_website_id',$this->role_website_id);
		$criteria->compare('value',$this->value,true);
					
		 
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
	 * @return TextTranslateRoleWebsite the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function nextOrderNumber()
	{
		return TextTranslateRoleWebsite::model()->count() + 1;
	}



    public static function deleteAllTextWithRoleWebsiteId($role_website_id){
        TextTranslateRoleWebsite::model()->deleteAllByAttributes(array('role_website_id'=>$role_website_id));
    }


    public static function saveDataTextTransalte($text_translate_id,$role_website_id,$language_id,$value){
        TextTranslateRoleWebsite::model()->deleteAllByAttributes(array('language_id'=>$language_id,'role_website_id'=>$role_website_id,'text_translate_id'=>$text_translate_id));
        $moel = new TextTranslateRoleWebsite();
        $moel->text_translate_id = $text_translate_id;
        $moel->role_website_id   = $role_website_id;
        $moel->language_id       = $language_id;
        $moel->value             = $value;
        $moel->save();
    }










}
