<?php

/**
 * This is the model class for table "{{_users}}".
 *
 * The followings are the available columns in table '{{_users}}':
 * @property string $id
 * @property string $email
 * @property string $password_hash
 * @property string $temp_password
 * @property string $first_name
 * @property string $last_name
 * @property string $first_char
 * @property integer $login_attemp
 * @property string $created_date
 * @property string $last_logged_in
 * @property string $ip_address
 * @property integer $role_id
 * @property integer $application_id
 * @property integer $approved_status
 * @property string $gender
 * @property string $area_code_id
 * @property string $phone
 * @property string $verify_code
 * @property string $temp_appointment
 * @property string $i_am_doctor
 * @property integer coach_location_id
 *
 * The followings are the available model relations:
 * @property Appointment[] $appointments
 * @property Booking[] $bookings
 * @property Doctor[] $doctors
 * @property DoctorPictures[] $doctorPictures
 * @property DoctorSpecialty[] $doctorSpecialties
 * @property InsurancesAccept[] $insurancesAccepts
 */
class Users extends _BaseModel {

    public $roleProfile=false;
    public $roleChangepassword=false;
    public $rolePasswordConfirm = false;

    public $optionMaritalStatus = array(0 => ' Married', 1 => 'Single', 2 => 'Divorced', 3 => 'Widowed' );

    public $password_confirm;
    /* for change pass in admin */
    public $currentPassword; //in form
    public $newPassword;
    public $recieveNewsletter;
    public $maxImageFileSize = 3145728; //3MB
    public $allowImageType = 'jpg,gif,png';
    public $uploadImageFolder = 'upload/games'; //remember remove ending slash
    public $defineImageSize = array(
//        'image' => array(array('alias' => 'thumb1', 'size' => '204x94')),
    );
    public static $typeImage = 'jpg,jpeg,gif,png';
    public static $titleArray = array(
        'Mr' => 'Mr',
        'Mrs' => 'Mrs',
        'Ms' => 'Ms',
    );
    public $email_confirm;
    public $validation;


    public $username_forgot;


    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Users the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{_users}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //all module
            //array('full_name,phone,email', 'required'),

            // array('username','required','on'=>'createMember'),
            // array('username','unique','on'=>'create,update,update_Hr_Profile,hr_reset_password,create_Hr_Profile'),

            array('full_name,email', 'required', 'on' => 'createMember, createMemberFE, updatePasswordMember, updatePasswordMemberBE, updateEmailMember, updateEmailPasswordMember, updateEmailPasswordMemberBE'),
            // array('temp_password', 'length', 'max' => 30, 'min' => 6),
            // array('email', 'length', 'max' => 200),
            // array('first_name, last_name', 'length', 'max' => 100),
            // array('full_name', 'length', 'max' => 200),
            // array('ip_address, phone', 'length', 'max' => 30),
            // array('gender', 'length', 'max' => 6),
            // array('verify_code', 'length', 'max' => 20),
            array('email, work_email_address, personal_email_address', 'email', 'message' => 'Please enter a valid email.'),
            // array('email_confirm', 'compareEmail', 'on' => 'createMember, createMemberFE'),
            array('phone', 'checkPhone'),
            array('fin', 'validNRIC'),
            //Create Member
            array('temp_password', 'checkDigit', 'on' => 'createMember, createMemberFE'),
            array('email', 'forgotPassword', 'on' => 'forgotPassword'),
            array('password_confirm', 'compare', 'compareAttribute' => 'temp_password', 'on' => 'createMember, createMemberFE'),
            //array('email', 'unique', 'message' => 'The email address already exists.', 'on' => 'createMember, createMemberFE'),
            array('temp_password, password_confirm', 'length', 'min' => PASSW_LENGTH_MIN, 'max' => PASSW_LENGTH_MAX,
                'tooLong' => 'Password is too long (maximum is ' . PASSW_LENGTH_MAX . ' characters).',
                'tooShort' => 'Password is too short (minimum is ' . PASSW_LENGTH_MIN . ' characters).',
                'on' => 'createMember, createMemberFE'),
            array('email, temp_password, password_confirm', 'required', 'on' => 'createMember, createMemberFE'),
            //reCaptcha
            array('validation', 'required', 'message' => 'Captcha invalid', 'on' => 'createMemberFE'),

            //update profile
            //array('email', 'unique', 'message' => 'The email address already exists.', 'on' => 'updateEmailMember, updateEmailPasswordMember, updateEmailPasswordMemberBE'),
            array('newPassword', 'checkDigit', 'on' => 'updatPasswordMember, updatEmailPasswordMember'),
            array('currentPassword, password_confirm, newPassword', 'length', 'min' => PASSW_LENGTH_MIN, 'max' => PASSW_LENGTH_MAX,
                'tooLong' => 'Password is too long (maximum is ' . PASSW_LENGTH_MAX . ' characters).',
                'tooShort' => 'Password is too short (minimum is ' . PASSW_LENGTH_MIN . ' characters).',
                'on' => 'updatePasswordMember, updatePasswordMemberBE, updateEmailPasswordMember, updateEmailPasswordMemberBE'),
            array('newPassword', 'required', 'on' => 'updatePasswordMember, updatePasswordMemberBE, updateEmailPasswordMember, updateEmailPasswordMemberBE'),
            array('password_confirm', 'compare', 'compareAttribute' => 'newPassword', 'on' => 'updatePasswordMember, updatePasswordMemberBE, updateEmailPasswordMember, updateEmailPasswordMemberBE'),
            array('currentPassword', 'comparePassword', 'on' => 'updatePasswordMember, updateEmailPasswordMember'),
            array('currentPassword', 'comparePasswordBE', 'on' => 'updatePasswordMemberBE, updateEmailPasswordMemberBE'),
            array('email,email_confirm', 'compareEmail', 'on' => 'updateEmailMember, updateEmailPasswordMember, updateEmailPasswordMemberBE'),
            array('newPassword', 'checkDigit', 'on' => 'updatePasswordMember, updatePasswordMemberBE, updateEmailPasswordMember, updateEmailPasswordMemberBE'),



            /**/
            //array('email', 'unique', 'message' => 'The email address already exists.', 'on' => 'create_Hr_Profile'),
            array('username,email,status,staff_name','required','on'=>'create_Hr_Profile,update_Hr_Profile'),
            array('temp_password,password_confirm','required','on'=>'create_Hr_Profile'),
            array('password_confirm,newPassword','required','on'=>'update_Hr_Profile,hr_reset_password'),
            array('password_confirm', 'compare', 'compareAttribute' => 'newPassword', 'on' => 'update_Hr_Profile,hr_reset_password'),
            array('password_confirm', 'compare', 'compareAttribute' => 'temp_password', 'on' => 'create_Hr_Profile'),
            array('newPassword, password_confirm,temp_password', 'length', 'min' => PASSW_LENGTH_MIN, 'max' => PASSW_LENGTH_MAX,
                  'tooLong' => 'Password is too long (maximum is ' . PASSW_LENGTH_MAX . ' characters).',
                  'tooShort' => 'Password is too short (minimum is ' . PASSW_LENGTH_MIN . ' characters).',
                  'on' => 'hr_reset_password,create_Hr_Profile'
                ),

            array('newPassword, password_confirm', 'length', 'min' => PASSW_LENGTH_MIN, 'max' => PASSW_LENGTH_MAX,
                  'tooLong' => 'Password is too long (maximum is ' . PASSW_LENGTH_MAX . ' characters).',
                  'tooShort' => 'Password is too short (minimum is ' . PASSW_LENGTH_MIN . ' characters).',
                  'on' => 'update_Hr_Profile'
                ),
            // array('newPassword,temp_password', 'match', 'pattern' => '/^.*(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/', 'message' =>'Password must be alphanumeric with upper and lowercase. ( A-Z, a-z, 0-9 )','on'=>'create_Hr_Profile'),
            // array('newPassword', 'match', 'pattern' => '/^.*(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/', 'message'  =>'Password must be alphanumeric with upper and lowercase. ( A-Z, a-z, 0-9 )','on'=>'update_Hr_Profile,create_Hr_Profile'),
            // array('newPassword', 'match', 'pattern' => '/^.*(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/', 'message'  =>'Password must be alphanumeric with upper and lowercase. ( A-Z, a-z, 0-9 )','on'=>'hr_reset_password'),


            array('newPassword,temp_password' ,'checPasswordDefaul'),
            // array('newPassword' ,'checPasswordDefaul','on'=>'update_Hr_Profile,create_Hr_Profile'),
            // array('newPassword' ,'checPasswordDefaul','on'=>'hr_reset_password'),


            //forgot password hr
            array('username_forgot', 'required', 'on' => 'hr_forgot_password'),
            array('emergency_contact_number, home_phone_number, work_phone_number' ,'checkPhone'),
            // array('emergency','match', 'pattern'=>'/^[\w]+$/'),
            array(
                'username',
                'match', 'not' => true, 'pattern' => '/[^A-Za-z0-9_-]/',
                'message' => 'Invalid characters in username.',
            ),

            array('username', 'unique', 'criteria'=>array(
                            'condition'=>'role_website_id=:role_website_id',
                            'params'=>array(':role_website_id'=>ROLE_WEBSITE_ID)
            )),

//            array('email', 'unique',
//				'message' => 'The email address already exists.', 'on' => 'create_Hr_Profile',
//				'criteria'=>array(
//					'condition'=>'role_website_id=:role_website_id',
//					'params'=>array(':role_website_id'=>ROLE_WEBSITE_ID)
//				),
//				//'on' => 'createMember, createMemberFE,create_Hr_Profile,updateEmailMember, updateEmailPasswordMember, updateEmailPasswordMemberBE'
//			),

            //Rule for safe
            array('id,company, full_name, first_name, last_name, login_attemp, created_date, last_logged_in, ip_address, role_id, application_id, status, verify_code,is_first_login, has_trial,newPassword,temp_password', 'safe'),
            array('role_website_id,username_forgot,staff_name,emergency,emergency_contact_number,dob,address,position,has_personal_email,is_changepassword', 'safe'),
            array('language_id,gender, middle_name, office, job_title, department, dob, skills, educations, certification, languages, associations, about_my_self, account_types, work_email_address, personal_email_address, secondary_address, home_phone_number, work_phone_number, twitter_accounts, im_accounts, yahoo_accounts, skype_accounts, viber_accounts, whatsapp, facebook_accounts_url, who_to_contact', 'safe'),
            array('nationality, permanent_resident, fin, marital_status, number_of_children, driving_license_class_type, highest_education_level, certification_awarded, country_of_residence, emergency_contact_person, relationship_of_emergency_contact_person', 'safe'),

        );
    }

    public function validNRIC($attribute, $params) {
        if($this->fin != ''){
            $match  = preg_match('/^[A-Za-z]\d{7}[A-Za-z]$/',$this->fin);
            if(!$match){
                $label = 'FIN';
                $this->addError("fin","$label is not valid");
            }
        }
    }

    public function checPasswordDefaul($attribute, $params) {
        // if ($this->$attribute != '') {
        //     $containsDigit = preg_match('/^.*(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/', $this->$attribute);
        //     $lb = $this->getAttributeLabel($attribute);
        //     $defaulPassword = Yii::app()->params['defaultPassword'];
        //     if (!$containsDigit){
        //         if($defaulPassword != $this->$attribute){
        //             $this->addError($attribute, "$lb must be alphanumeric with upper and lowercase. ( A-Z, a-z, 0-9 )");
        //         }
        //     }
        // }

        if ($this->$attribute != '') {
            $containsDigit = preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $this->$attribute);
            $lb = $this->getAttributeLabel($attribute);
             $defaulPassword = Yii::app()->params['defaultPassword'];
            if (!$containsDigit){
                if($defaulPassword != $this->$attribute){
                    $this->addError($attribute, "$lb must be at least one letter and one number.");
                }
            }
        }

    }


    public function forgotPassword($attribute, $params) {

        if (!$this->hasErrors()) { // we only want to authenticate when no input errors
            $model = Users::model()->findByAttributes(array('email' => trim($this->email)));
            if (!$model) {
                $this->addError("email", "User not found");
            } else {
                if ($model->role_id == ROLE_ADMIN || $model->role_id == ROLE_MANAGER)
                    $this->addError("email", "User not found");
                else if ($model->status != STATUS_ACTIVE)
                    $this->addError("email", "Your account has not been activated or blocked");
            }
        }
    }

    public function checkDigit($attribute, $params) {
        if ($this->$attribute != '') {
            $containsDigit = preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $this->$attribute);
            $lb = $this->getAttributeLabel($attribute);
            if (!$containsDigit)
                $this->addError($attribute, "$lb must be at least one letter and one number.");
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

    public function compareEmail($attribute, $params) {
        if ($this->email_confirm != $this->email) {
            $this->addError("email_confirm", "Confirm email is wrong.");
        }
    }

    public function comparePassword($attribute, $params) {
        $user = self::model()->getInforUser(Yii::app()->user->id);
        if ($this->currentPassword != $user->temp_password) {
            $this->addError("currentPassword", "Current password is wrong.");
        }
    }

    // Xuan Tinh 
    public function comparePasswordBE($attribute, $params) {
        $user = self::model()->getInforUser($this->id);
        if ($this->currentPassword != $user->temp_password) {
            $this->addError("currentPassword", "Current password is wrong.");
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
//               Yii::import('phpbb.models.*');
        return array(
            'rRole' => array(self::BELONGS_TO, 'Roles', 'role_id'),
            'language_pk' => array(self::BELONGS_TO, 'Languages', 'language_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('translation', 'ID'),
            'email_confirm'                  => TextMultilangHelper::label('confirm-email-address'),
            'password_hash'                  => TextMultilangHelper::label('password'),
            'temp_password'                  => TextMultilangHelper::label('password'),
            'login_attemp'                   => TextMultilangHelper::label('login-temp'),
            'created_date'                   => TextMultilangHelper::label('created-date'),
            'last_logged_in'                 => Yii::t('translation', 'Last Logged In'),
            'ip_address'                     => Yii::t('translation', 'Ip Address'),
            // 'role_id'                     => 'Account Type',
            'role_id'                        => Yii::t('translation', 'Role'), // Dec 19, 2014 ANH DUNG CHANGE
            'application_id'                 => TextMultilangHelper::label('application'),
            'status'                         => TextMultilangHelper::label('status'),
            'full_name'                      => TextMultilangHelper::label('full-name'),
            'currentPassword'                => TextMultilangHelper::label('current-password'),
            'company'                        => TextMultilangHelper::label('company'),
            'validation'                     => TextMultilangHelper::label('security-code'),
            'position'                       => TextMultilangHelper::label('position'),
            'dob'                            => TextMultilangHelper::label('date-of-birthday'),
            'address'                        => TextMultilangHelper::label('house-address'),
            'has_personal_email'             => TextMultilangHelper::label('has-personal-email'),
            'emergency'                      => TextMultilangHelper::label('who-to-contact-in-an-emergency'),
            'emergency_contact_number'       => TextMultilangHelper::label('emergency-contact-number'),
            'email'                          => ($this->roleProfile) ? TextMultilangHelper::label('default-email') :  TextMultilangHelper::label('email-address'),
            //'newPassword'                  => ($this->roleChangepassword) ? Yii::t('translation', 'Password') : Yii::t('translation', 'New password'),
            'newPassword'                    => TextMultilangHelper::label('new-password'),
            //'password_confirm'             => ($this->roleChangepassword) ? Yii::t('translation', 'Confirm Password') : Yii::t('translation', 'Repeat New Password'),
            'password_confirm'               => TextMultilangHelper::label('repeat-new-password'),
            'phone'                          => TextMultilangHelper::label('mobile-phone'),
            'verify_code'                    => TextMultilangHelper::label('verify-code'),
            'username_forgot'                => TextMultilangHelper::label('username'),
            'staff_name'                    => TextMultilangHelper::label('staff-name'),
            'username'                       => TextMultilangHelper::label('username'),
            'first_name'                       => TextMultilangHelper::label('first-name'),
            'middle_name'                       => TextMultilangHelper::label('middle-name'),
            'last_name'                       => TextMultilangHelper::label('last-name'),

            'nationality'                       => TextMultilangHelper::label('nationality'),
            'permanent_resident'                       => TextMultilangHelper::label('permanent-resident'),
            'fin'                       => TextMultilangHelper::label('fin'),
            'marital_status'                       => TextMultilangHelper::label('marital-status'),
            'number_of_children'                       => TextMultilangHelper::label('number-of-children'),
            'driving_license_class_type'                       => TextMultilangHelper::label('driving-license-class-type'),
            'highest_education_level'                       => TextMultilangHelper::label('highest-education-level'),
            'certification_awarded'                       => TextMultilangHelper::label('certification-awarded'),

            'office'                       => TextMultilangHelper::label('office'),
            'job_title'                       => TextMultilangHelper::label('job-title'),
            'department'                       => TextMultilangHelper::label('department'),
            'gender'                       => TextMultilangHelper::label('gender'),
            'skills'                       => TextMultilangHelper::label('skills'),
            'educations'                       => TextMultilangHelper::label('educations'),
            'certification'                       => TextMultilangHelper::label('certification'),
            'languages'                       => TextMultilangHelper::label('languages'),
            'associations'                       => TextMultilangHelper::label('associations'),
            'about_my_self'                       => TextMultilangHelper::label('about-my-self'),
            'account_types'                       => TextMultilangHelper::label('account-types'),

            'country_of_residence'                       => TextMultilangHelper::label('country-of-residence'),
            'emergency_contact_person'                       => TextMultilangHelper::label('emergency-contact-person'),
            'relationship_of_emergency_contact_person'                       => TextMultilangHelper::label('relationship-of-emergency-contact-person'),


            'work_email_address'                       => TextMultilangHelper::label('work-email-address'),
            'personal_email_address'                       => TextMultilangHelper::label('personal-email-address'),
            'main_address'                       => TextMultilangHelper::label('house-address'),
            'secondary_address'                       => TextMultilangHelper::label('secondary-address'),
            'home_phone_number'                       => TextMultilangHelper::label('house-phone-number'),
            'work_phone_number'                       => TextMultilangHelper::label('work-phone-number'),
//            'mobile_phone'                       => TextMultilangHelper::label('mobile-phone'),
            'twitter_accounts'                       => TextMultilangHelper::label('twitter-accounts'),
            'im_accounts'                       => TextMultilangHelper::label('im-accounts'),
            'yahoo_accounts'                       => TextMultilangHelper::label('yahoo-accounts'),
            'skype_accounts'                       => TextMultilangHelper::label('skype-accounts'),
            'viber_accounts'                       => TextMultilangHelper::label('viber-accounts'),
            'whatsapp'                       => TextMultilangHelper::label('whatsapp'),
            'facebook_accounts_url'                       => TextMultilangHelper::label('facebook-accounts-url'),
            'language_id'                       => TextMultilangHelper::label('Language'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($criteria = NULL) {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        if ($criteria == NULL)
            $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id, true);
        $criteria->compare('t.email', $this->email, true);
        $criteria->compare('t.staff_name', $this->staff_name, true);
        $criteria->compare('t.password_hash', $this->password_hash, true);
        $criteria->compare('t.temp_password', $this->temp_password, true);
        $criteria->compare('t.first_name', $this->first_name, true);
        $criteria->compare('t.last_name', $this->last_name, true);
        $criteria->compare('t.login_attemp', $this->login_attemp);
        $criteria->compare('t.created_date', $this->created_date, true);
        $criteria->compare('t.last_logged_in', $this->last_logged_in, true);
        $criteria->compare('t.ip_address', $this->ip_address, true);
        $criteria->compare('t.role_id', $this->role_id);
        $criteria->compare('t.full_name', $this->full_name);
        $criteria->addCondition('t.role_id <> 2');
        $criteria->compare('t.application_id', $this->application_id);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('t.gender', $this->gender, true);
        $criteria->compare('t.phone', $this->phone, true);
        $criteria->compare('t.verify_code', $this->verify_code, true);
        $criteria->order = "t.created_date desc";

        $_SESSION['data_user-excel'] = new CActiveDataProvider($this, array(
            'pagination' => false,
            'criteria' => $criteria,
        ));

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params['defaultPageSize'],
            ),
        ));
    }

    public function searchMember($criteria = NULL) {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        if ($criteria == NULL)
            $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id, true);
        $criteria->compare('t.username', $this->username, true);
        $criteria->compare('t.staff_name', $this->staff_name, true);
        $criteria->compare('t.email', $this->email, true);
        $criteria->compare('t.password_hash', $this->password_hash, true);
        $criteria->compare('t.temp_password', $this->temp_password, true);
        $criteria->compare('t.first_name', $this->first_name, true);
        $criteria->compare('t.last_name', $this->last_name, true);
        $criteria->compare('t.login_attemp', $this->login_attemp);
        $criteria->compare('t.created_date', $this->created_date, true);
        $criteria->compare('t.last_logged_in', $this->last_logged_in, true);
        $criteria->compare('t.ip_address', $this->ip_address, true);
        $criteria->compare('t.role_id', $this->role_id);
        $criteria->compare('t.full_name', $this->full_name,true);

//        $criteria->addCondition('t.role_id <> 2');
        $criteria->compare('t.role_id', ROLE_HR);
//        $criteria->compare('t.application_id', $this->application_id);
        $criteria->compare('t.application_id', FE);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('t.gender', $this->gender, true);
        $criteria->compare('t.phone', $this->phone, true);
        $criteria->compare('t.verify_code', $this->verify_code, true);
        $criteria->compare('t.role_website_id', ROLE_WEBSITE_ID);


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.created_date desc'),
            'pagination' => array(
                'pageSize' => Yii::app()->params['defaultPageSize'],
            ),
        ));
    }

    public function searchAdmin($criteria = NULL) {
        if ($criteria == NULL)
            $criteria = new CDbCriteria;
//        $criteria->select = 't.first_name, t.last_name, t.status, t.email, t.phone, t.created_date, t.id, t.full_name';
        $criteria->compare('t.id', $this->id, true);
        $criteria->compare('t.email', $this->email, true);
        $criteria->compare('t.password_hash', $this->password_hash, true);
        $criteria->compare('t.temp_password', $this->temp_password, true);
        $criteria->compare('t.first_name', $this->first_name, true);
        $criteria->compare('t.last_name', $this->last_name, true);
        $criteria->compare('t.login_attemp', $this->login_attemp);
        $criteria->compare('t.created_date', $this->created_date, true);
        $criteria->compare('t.last_logged_in', $this->last_logged_in, true);
        $criteria->compare('t.ip_address', $this->ip_address, true);
        $criteria->compare('t.application_id', BE);
        $criteria->addCondition('t.role_id = 2');
        $criteria->compare('t.status', $this->status);
        $criteria->compare('t.gender', $this->gender, true);
        $criteria->compare('t.phone', $this->phone, true);
        $criteria->compare('t.verify_code', $this->verify_code, true);
        $criteria->compare('t.full_name', $this->full_name);
        // $criteria->addNotInCondition('t.role_id', Roles::$aRoleRestrict);// Dec 19, 2014 ANH DUNG ADD

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function defaultScope() {
        return array(
            //'condition'=>'',
        );
    }

    public function unlinkAllFileInFolder($path) {
        $files = glob($path . '/*'); // get all file names
        foreach ($files as $file) { // iterate files
            if (is_file($file))
                unlink($file); // delete file
        }
    }

    public function beforeDelete() {
        try {

        } catch (Exception $ex) {
            echo $ex->getMessage();
            die;
        }

        return parent::beforeDelete();
    }

    public function activate() {
        $this->status = 1;
        $this->update();
    }

    public function deactivate() {
        $this->status = 0;
        $this->update();
    }

    public function behaviors() {
        return array(
            // DEC 19, 2014 ANH DUNG CLOSE
//            'LoggableBehavior' => 'application.modules.auditTrail.behaviors.LoggableBehavior',
        );
    }

    public static function getInforUser($id = null, $name = null) {
        $id = (int) $id;
        $name = trim($name);
        if (empty($id))
            return;
        if (!empty($name))
            $result = Users::model()->findByPk($id)->$name;
        else
            $result = Users::model()->findByPk($id);
        return $result;
    }

    public static function loadItems($emptyOption = false) {
        $_items = array();
        if ($emptyOption)
            $_items[""] = "";
        $model = self::model()->findByPk(Yii::app()->user->getId());
        $_items[$model->id] = $model->email;
        return $_items;
    }

    public static function generateKey($user) {
        if (empty($user->email))
            $user->email = '';
        return md5($user->id . $user->email);
    }

    public static function findByVerifyCode($verify_code) {
        return Users::model()->find('verify_code=' . $verify_code . '');
    }

    public static function getUsernameById($id) {
        $model = self::model()->findByPk($id);
        if ($model)
            return $model->username;
        return null;
    }

    public static function getEmailById($id) {
        $model = self::model()->findByPk($id);
        if ($model)
            return $model->email;
        return null;
    }

    public static function isExistEmail($email, $ignore_id = NULL) {
        $criteria = new CDbCriteria;
        if ($ignore_id != NULL && $ignore_id != '')
            $criteria->compare('id', '<>' . $ignore_id);
        $criteria->addCondition('email="' . $email . '"');
        $iCount = self::model()->count($criteria);
        if ($iCount > 0)
            return true;
        return false;
    }

    public static function checkVerifyCode($verify_code) {
        $count = Users::model()->count('verify_code=' . $verify_code . '');
        if ($count > 0) {
            $verify_code = self::checkVerifyCode(rand(100000, 1000000));
            return $verify_code;
        } else
            return $verify_code;
    }

    /**
     * @Author: ANH DUNG Dec 19, 2014
     * @Todo: get role name
     * @Param: $model model user
     */
    public static function GetRoleName($mUser) {
        $mRole = $mUser->rRole;
        if ($mRole) {
            return $mRole->role_name;
        }
        return '';
    }

    public function getFullName() {
        return $this->first_name . ' ' . $this->last_name;
    }

    public static function getList() {
        $criteria = new CDbCriteria;
        $criteria->compare('role_id', ROLE_NORMAL_MEMBER);
        $criteria->compare('status', STATUS_ACTIVE);
        $criteria->order = 't.first_name asc';
        return self::model()->findAll($criteria);
    }

    public function searchForExport()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id, true);
        $criteria->compare('t.username', $this->username, true);
        $criteria->compare('t.staff_name', $this->staff_name, true);
        $criteria->compare('t.email', $this->email, true);
        $criteria->compare('t.password_hash', $this->password_hash, true);
        $criteria->compare('t.temp_password', $this->temp_password, true);
        $criteria->compare('t.first_name', $this->first_name, true);
        $criteria->compare('t.last_name', $this->last_name, true);
        $criteria->compare('t.login_attemp', $this->login_attemp);
        $criteria->compare('t.created_date', $this->created_date, true);
        $criteria->compare('t.last_logged_in', $this->last_logged_in, true);
        $criteria->compare('t.ip_address', $this->ip_address, true);
        $criteria->compare('t.role_id', $this->role_id);
        $criteria->compare('t.full_name', $this->full_name,true);

        $criteria->addCondition('t.role_id <> 2');
        $criteria->compare('t.application_id', $this->application_id);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('t.gender', $this->gender, true);
        $criteria->compare('t.phone', $this->phone, true);
        $criteria->compare('t.verify_code', $this->verify_code, true);
        $criteria->compare('t.role_website_id', ROLE_WEBSITE_ID);

        $model = self::model()->findAll($criteria);
        if($model){
            return $model;
        }
        return ;
    }

}
