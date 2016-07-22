<?php

/**
 * This is the model class for table "{{_email_templates}}".
 *
 * The followings are the available columns in table '{{_email_templates}}':
 * @property integer $id
 * @property string $email_subject
 * @property string $email_body
 * @property string $parameter_description
 * @property integer $type
 */
class EmailTemplates extends _BaseModel
{

	const MAIL_MARKETPLACE_POST = 14;
	const MAIL_ORDER_SPONSOR = 1;
	const MAIL_ORDER_PERSON_CHARGE = 2;
	const MAIL_ORDER_REJECTION = 3;
	const MAIL_ORDER_SUCCESS_ACCOUNTANT = 4;



//    public $languageDefault='en';
    public $modelTranslate='EmailTemplatesTranslate';


    public $email_subject;
    public $email_body;





	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EmailTemplates the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_email_templates}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email_subject,email_body', 'required',),
			array('type', 'numerical', 'integerOnly' => true),
			array('email_subject', 'length', 'max' => 255),
			array('email_body, parameter_description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, email_subject, email_body, parameter_description, type,role_website_id,parent_id', 'safe'),
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
//              'translate' => array(self::HAS_MANY, $this->modelTranslate, 'translate_id','limit' => 1,'on'=>"translate.language='".$this->languageDefault."'"),   
              'translate' => array(self::HAS_MANY, $this->modelTranslate, 'translate_id','limit' => 1,'on'=>"translate.language='".Yii::app()->language."'"),   
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'email_subject' => 'Email Subject',
			'email_body' => 'Email Body',
			'parameter_description' => 'Parameter Description',
			'type' => 'Type',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;
		// $criteria->select = 'email_subject, parameter_description,id';
		$criteria->compare('id', $this->id);
		$criteria->compare('email_subject', $this->email_subject, true);
		$criteria->compare('email_body', $this->email_body, true);
		$criteria->compare('parameter_description', $this->parameter_description, true);
		$criteria->compare('type', $this->type);
        $criteria->compare('role_website_id',ROLE_WEBSITE_ID);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'Pagination' => array(
				'PageSize' => 30, //edit your number items per page here
			),
		));
	}

	protected function beforeSave()
	{
		if ($this->isNewRecord)
			$this->role_website_id = ROLE_WEBSITE_ID;

		return parent::beforeSave();
	}


    

}
