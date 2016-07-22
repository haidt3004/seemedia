<?php

/**
 * This is the model class for table "{{_settings_multi_site}}".
 *
 * The followings are the available columns in table '{{_settings_multi_site}}':
 * @property string $id
 * @property string $updated
 * @property string $key
 * @property string $value
 */
class SettingsMultiSite extends _BaseModel {
		

    public static $smtpFields = array('host' => 'smtpHost', 'username' => 'smtpUsername', 'password' => 'smtpPassword',
        'port' => 'smtpPort', 'encryption' => 'encryption');

		/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_settings_multi_site}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(

			array('id,role_website_id, updated, key, value', 'safe'),
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
			'updated' => Yii::t('translation','Updated'),
			'key' => Yii::t('translation','Key'),
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('updated',$this->updated,true);
		$criteria->compare('key',$this->key,true);
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
	 * @return SettingsMultiSite the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function nextOrderNumber()
	{
		return SettingsMultiSite::model()->count() + 1;
	}


    public function saveSetting($data){
        $arrAttributes = $data->getAttributes();
        if(is_array($arrAttributes)&&count($arrAttributes)>0){
            //delete all setting cu
            SettingsMultiSite::model()->deleteAllByAttributes(array('role_website_id'=>ROLE_WEBSITE_ID));
            foreach($arrAttributes as $key=> $attr){
                $multiSetting        = new SettingsMultiSite();
                $multiSetting->key   = $key;
                $multiSetting->value = trim($attr);
                $multiSetting->role_website_id = ROLE_WEBSITE_ID;
                $multiSetting->save();                                
            }
        }
    }


    public static function applySettings(){
        $attributeList = SettingsMultiSite::model()->findAllByAttributes(array('role_website_id'=>ROLE_WEBSITE_ID));
        if ($attributeList && is_array($attributeList))
        {
            foreach ($attributeList as $item)
            {

                //check tranport type
                if ($item->key == 'transportType' && $item->value !='')
                {
                    Yii::app()->mail->transportType = $item->value;

                }
                //get SMTP info
                if (Yii::app()->mail->transportType == 'smtp') 
                {

                    if (in_array($item->key, self::$smtpFields))
                    {
                        if ($item->value !='')
                        {
                            foreach(self::$smtpFields as $k=>$v)
                            {
                                if($v == $item->key)
                                    Yii::app()->mail->transportOptions[$k] = $item->value;
                            }
                        }
                    }
                } 
                else 
                {
                    Yii::app()->mail->transportOptions = '';
                }
                




                Yii::app()->params[$item->key] =$item->value; 
            }
        }        
    }


    public static function setDataSetting($model){

        $attributeList = SettingsMultiSite::model()->findAllByAttributes(array('role_website_id'=>ROLE_WEBSITE_ID));
        if ($attributeList && is_array($attributeList))
        {
            foreach ($attributeList as $item)
            {
                $key = trim($item->key);
               if(isset($model[$key])){
                    $model[$key] = $item->value;
                    $model->$key = $item->value;
               }
            }
        }         
        return $model;
    }

}
