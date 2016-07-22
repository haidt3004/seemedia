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
class CountryEmailTemplates extends _BaseModel
{

	const MAIL_MARKETPLACE_POST = 14;
	const MAIL_ORDER_SPONSOR = 1;
	const MAIL_ORDER_PERSON_CHARGE = 2;
	const MAIL_ORDER_REJECTION = 3;
	const MAIL_ORDER_SUCCESS_ACCOUNTANT = 4;

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
			array('email_subject,email_body, country_id, admin_email,to_admin_subject, to_admin_emailbody', 'required',),
			array('type', 'numerical', 'integerOnly' => true),
            array('admin_email', 'email'),
			array('email_subject', 'length', 'max' => 255),
			array('email_body, parameter_description, country_id, admin_email,to_admin_subject, to_admin_emailbody', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, email_subject, email_body, parameter_description, type, country_id, admin_email,to_admin_subject, to_admin_emailbody', 'safe', 'on' => 'search'),
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
            'country' => array(self::BELONGS_TO, 'Country', 'country_id',  'order'=>'name ASC'),
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
            'country_id' => "Country",
            'admin_email' => "Receipient email",
            'to_admin_subject' => "To admin Subject",
            'to_admin_emailbody' => "To admin Email Body"
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
		//$criteria->select = 'email_subject, parameter_description,id, ';
		$criteria->compare('id', $this->id);
		$criteria->compare('email_subject', $this->email_subject, true);
		$criteria->compare('email_body', $this->email_body, true);
		$criteria->compare('parameter_description', $this->parameter_description, true);
		$criteria->compare('type', $this->type);
        $criteria->compare('country_id', $this->country_id);
        $criteria->compare('admin_email', $this->admin_email, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'Pagination' => array(
				'PageSize' => 30, //edit your number items per page here
			),
		));
	}

}
