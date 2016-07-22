<?php

/**
 * This is the model class for table "{{_login_logs}}".
 *
 * The followings are the available columns in table '{{_login_logs}}':
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $login
 * @property string $logout
 * @property integer $status
 * @property string $ip_address
 */
class LoginLogs extends _BaseModel {

	public $optionStatus = array(PASSWORD_WRONG => 'Password wrong', PASSWORD_CORRECT => 'Password correct', PASSWORD_LOGOUT => '');
		
		/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_login_logs}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status', 'numerical', 'integerOnly'=>true),
			array('username, email', 'length', 'max'=>255),
			array('ip_address', 'length', 'max'=>100),
			array('username, email, login, logout, status, ip_address', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, email, login, logout, status, ip_address', 'safe', 'on'=>'search'),
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
			'username' => Yii::t('translation','Username'),
			'email' => Yii::t('translation','Email'),
			'login' => Yii::t('translation','Login'),
			'logout' => Yii::t('translation','Logout'),
			'status' => Yii::t('translation','Status'),
			'ip_address' => Yii::t('translation','Ip Address'),
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
		$criteria->compare('role_website_id',ROLE_WEBSITE_ID);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('login',$this->login,true);
		$criteria->compare('logout',$this->logout,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('ip_address',$this->ip_address,true);
				$sort = new CSort();

        $sort->attributes = array(
            'name' => array(
                'asc' => 't.id',
                'desc' => 't.id desc',
                'default' => 'asc',
            ),
        );
		$sort->defaultOrder = 't.id desc';
					
		 
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => $sort,
			'pagination'=>array(
//                'pageSize'=> Yii::app()->params['defaultPageSize'],
                'pageSize'=> 50,
            ),
		));
	}

	
	public function activate()
    {
        $this->status = 1;
        $this->update();
    }



    public function deactivate()
    {
        $this->status = 0;
        $this->update();
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LoginLogs the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function nextOrderNumber()
	{
		return LoginLogs::model()->count() + 1;
	}

	public function saveAndDeleteOld()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('role_website_id',ROLE_WEBSITE_ID);
		$criteria->order = 'id ASC';
		$count = $this->model()->count($criteria);
		$limit = 2000;

//		if (isset(Yii::app()->params['defaultRecord']) && Yii::app()->params['defaultRecord'] != '') {
//			$limit = Yii::app()->params['defaultRecord'] ;
//		}

		if ($count >= $limit) {
			for ($index = 0; $index <= ($count - $limit); $index++) {
				$this->model()->find($criteria)->delete();
			}
		}

		$this->save();
	}

	public function searchForExport()
	{

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('role_website_id',ROLE_WEBSITE_ID);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('login',$this->login,true);
		$criteria->compare('logout',$this->logout,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('ip_address',$this->ip_address,true);
		$criteria->order = 'id DESC';
		$model = self::model()->findAll($criteria);
		
		if($model){
			return $model;
		}
		return ;
	}
}
