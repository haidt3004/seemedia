<?php
class UserAdmin extends Users {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Users the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //all module
            array('username', 'match', 'pattern' => '/^[a-zA-Z\d_.]{2,30}$/i', 'message' => 'Username cannot include special characters', 'on' => 'createAdmin, editAdmin'),
            array('username, email, full_name, role_id', 'required', 'on' => 'createAdmin, editAdmin'),
            array('temp_password, password_confirm', 'required', 'on' => 'createAdmin'),
            array('password_confirm', 'compare', 'compareAttribute' => 'temp_password', 'on' => 'editAdmin, createAdmin'),
			array('email', 'email', 'message' => 'Please enter a valid email.', 'on' => 'editAdmin, createAdmin, updateMyProfile'),
            // array('email', 'unique', 'message' => 'This email address existed', 'on' => 'editAdmin, createAdmin, updateMyProfile'),
			// array('username', 'unique', 'message' => 'This username address existed', 'on' => 'editAdmin, createAdmin'),
            array('temp_password, password_confirm', 'length', 'min' => PASSW_LENGTH_MIN, 'max' => PASSW_LENGTH_MAX,
                'tooLong' => 'Password is too long (maximum is ' . PASSW_LENGTH_MAX . ' characters).',
                'tooShort' => 'Password is too short (minimum is ' . PASSW_LENGTH_MIN . ' characters).',
                'on' => 'createAdmin, editAdmin'),
            array('temp_password', 'checkDigit', 'on' => 'editAdmin, createAdmin'),
            array('phone', 'checkPhone', 'on' => 'updateMyProfile, editAdmin, createAdmin'),
            array('phone', 'safe', 'on' => 'updateMyProfile, editAdmin, createAdmin'),
            array('full_name,email,username', 'required', 'on' => 'updateMyProfile'),
            array('username, full_name, email',  'safe', 'on' => 'search'),
            array('status,role_website_id,parent_id', 'safe'),
            array('username', 'unique', 'criteria'=>array(
                            'condition'=>'role_website_id=:role_website_id',
                            'params'=>array(':role_website_id'=>ROLE_WEBSITE_ID)
            )),
//            array('email', 'checkEmailAdminUnique'),
            array('email', 'unique',
                'message' => 'The email address already exists.',
//                'on' => 'create_Hr_Profile',
//                'criteria' => array(
//                    'condition' => 'role_website_id=:role_website_id and role_id=:role_id',
//                    'params' => array(':role_website_id' => ROLE_WEBSITE_ID, ':role_id' => ROLE_COMPANY_ADMIN)
//                ),
                'criteria' => array(
                    'condition' => 'role_website_id=:role_website_id AND application_id=:application_id',
                    'params' => array(':role_website_id' => ROLE_WEBSITE_ID, ':application_id' => BE)
                ),
                //'on' => 'createMember, createMemberFE,create_Hr_Profile,updateEmailMember, updateEmailPasswordMember, updateEmailPasswordMemberBE'
            ),
        );
    }

    public function checkEmailAdminUnique()
    {
        $criteria = new CDbCriteria();
        $criteria->compare('application_id', BE);
        $criteria->compare('role_website_id', ROLE_WEBSITE_ID);
        $criteria->compare('email', $this->email);

        $count = self::model()->count($criteria);
        if ($count > 0) {
            $this->addError('email', 'The email address already exists.');
        }
    }
	
	public function checkPhone($attribute, $params) {
        if ($this->$attribute != '') {
            $pattern = '/^[\+]?[\(]?(\+)?(\d{0,3})[\)]?[\s]?[\-]?(\d{0,9})[\s]?[\-]?(\d{0,9})[\s]?[x]?(\d*)$/';
            $containsDigit = preg_match($pattern, $this->$attribute);
            $lb = $this->getAttributeLabel($attribute);
            if (!$containsDigit)
                $this->addError($attribute, "$lb must be numerical and  allow input (),+,-");
        }
    }

    public function search($criteria = NULL) {
        if ($criteria == NULL)
            $criteria = new CDbCriteria;
            $criteria->compare('t.id', $this->id, true);
            // $criteria->compare('t.role_id', $this->role_id);
            $criteria->compare('t.role_id','> 2');
            $criteria->compare('t.application_id', BE);
            $criteria->compare('t.role_website_id',ROLE_WEBSITE_ID);

            $criteria->compare('t.parent_id', $this->parent_id);
            $criteria->compare('t.username', $this->username, true);
            $criteria->compare('t.email', $this->email, true);
            $criteria->compare('t.password_hash', $this->password_hash, true);
            $criteria->compare('t.temp_password', $this->temp_password, true);
            $criteria->compare('t.first_name', $this->first_name, true);
            $criteria->compare('t.last_name', $this->last_name, true);
            $criteria->compare('t.login_attemp', $this->login_attemp);
            $criteria->compare('t.created_date', $this->created_date, true);
            $criteria->compare('t.last_logged_in', $this->last_logged_in, true);
            $criteria->compare('t.ip_address', $this->ip_address, true);
            
            $criteria->compare('t.status', $this->status);
            $criteria->compare('t.gender', $this->gender, true);
            $criteria->compare('t.phone', $this->phone, true);
            $criteria->compare('t.verify_code', $this->verify_code, true);
            $criteria->compare('t.full_name', $this->full_name);

            
        
        return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
    }

}