<?php

/**
 * This is the model class for table "{{_text_translate}}".
 *
 * The followings are the available columns in table '{{_text_translate}}':
 * @property integer $id
 * @property string $key
 * @property string $value
 * @property string $slug
 * @property string $created_date
 */
class TextTranslate extends _BaseModel {
	
    public $language_id;


		/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_text_translate}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('key', 'unique', 'on' => 'create, update'), 
		    array('key,value', 'required', 'on' => 'create, update'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id,language_id, key, value, slug, created_date', 'safe'),
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
            // 'translate'=> array(self::HAS_MANY, 'TextTranslateRoleWebsite', 'text_translate_id','on'=>' translate.language_id='.$this->language_id.' AND translate.role_website_id ='.ROLE_WEBSITE_ID),
            // 'translate'=> array(self::HAS_MANY, 'TextTranslateRoleWebsite', 'text_translate_id','on'=>' translate.language_id='.$this->language_id.' AND translate.role_website_id ='.ROLE_WEBSITE_ID),
	
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('translation','ID'),
			'key' => Yii::t('translation','Key'),
			'value' => Yii::t('translation','Value'),
			'slug' => Yii::t('translation','Slug'),
			'created_date' => Yii::t('translation','Created Date'),
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
		$criteria->compare('key',$this->key,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('created_date',$this->created_date,true);
				$sort = new CSort();

        $sort->attributes = array(
            'name' => array(
                'asc' => 't.key',
                'desc' => 't.key desc',
                'default' => 'asc',
            ),
        );
		$sort->defaultOrder = 't.key asc';
					
		 
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
	 * @return TextTranslate the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function nextOrderNumber()
	{
		return TextTranslate::model()->count() + 1;
	}

    public function getContentWithCurrentLink($text_translate_id,$language_id){
        $data = TextTranslateRoleWebsite::model()->findByAttributes(array('text_translate_id'=>$text_translate_id,'role_website_id'=>ROLE_WEBSITE_ID,'language_id'=>$language_id));
        if($data){
            return $data->value;
        }
    }


    public function getAllTextTranslate($language_id){
        $criteria = new CDbCriteria;
        $data     = TextTranslate::model()->findAll($criteria);
        $arrText  = array();
        if(is_array($data)&&count($data)>0){
            foreach($data as $item){
                $dataLangcurrent = $this->getContentWithCurrentLink($item->id,$language_id);
                $value           = ($dataLangcurrent !='') ? $dataLangcurrent : $item->value;
                $arrText[$item->id]=array(
                    'key'    => $item->key,
                    'title'  => $item->value,
                    'value'  => $value,
                );
            }
        }
        return $arrText;
    }



    public function createFileLanguage($allData,$langcode='en'){
        if(is_array($allData)&&count($allData)>0){

            //create file language
            $path  = Yii::app()->basePath . "/messages/$langcode";
            @mkdir($path);
            //write content
            $tmp = "<?php\n   return array( \n";            
            foreach($allData as $item){
                $key   = $item['key'];
                $value = $item['value'];
                $tmp .=  "\t\t\t"."'$key'=>'$value'," . "\n";
            }
            $tmp .=");  \n  ?>";
            file_put_contents($path.'/translation.php', $tmp) or die("Cannot write to file");
        }
    }


}
