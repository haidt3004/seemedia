<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    public $login_by;
    protected $_id;
    protected $_isAdmin = false;
	//private $applicationId = 2;
	//private $status = 1;
    public $role_id;
    const ERROR_USERNAME_BLOCKED=35; // verz custom by Nguyen Dung
    const ERROR_FAILURE_MAX_TIMES = 4;
    const ERROR_ACCOUNT_NOT_VERIFY = 36;
    /**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
        //user ip login more than X times can't login
		$login_by = $this->login_by;
        $iplogin = new IpLogins();
        $iplogin->deleteOldRecords();
        // die();
        if(!$iplogin->limitLoginTimes($this->username, Yii::app()->request->getUserHostAddress()))
        {
            $this->errorCode = self::ERROR_FAILURE_MAX_TIMES;
            return !$this->errorCode;
        }
        
		 
        //$record=Users::model()->findByAttributes(array('email'=>$this->username, 'application_id'=>$this->applicationId, 'status' => $this->status ));
       
        $record=Users::model()->findByAttributes(array($login_by=>$this->username,'role_website_id'=>ROLE_WEBSITE_ID));

        if($record===null)
        {
            $this->errorCode=  self::ERROR_USERNAME_INVALID;
        }
        //elseif(!empty($record->verify_code)){
        //    $this->errorCode=  self::ERROR_ACCOUNT_NOT_VERIFY;
        //}
        elseif($record->role_website_id !=ROLE_WEBSITE_ID){
            $this->errorCode=  self::ERROR_USERNAME_INVALID;
        }
        else if(trim($record->password_hash) != md5(trim($this->password)))
        {
            $this->errorCode=  self::ERROR_PASSWORD_INVALID;
            $record->login_attemp = $record->login_attemp + 1;
            $record->update();
        }
//        else if($record->role_id==ROLE_MEMBER && $record->status==0 )
//        {
//            $this->errorCode=  self::ERROR_USERNAME_BLOCKED;
//        }
//        else if($record->role_id==ROLE_MEMBER && $record->status==2 )
//        {
//            $this->errorCode=  self::ERROR_USERNAME_INVALID;
//        }
        else if($record->status==0 )
        {
            $this->errorCode=  self::ERROR_USERNAME_BLOCKED;
        }
        else
        {
            $this->_id=$record->id;
        //  $this->setState('title', $record->nick_name);
            $this->errorCode=self::ERROR_NONE;
            $this->_isAdmin = false;
            // Update last IP and time
            $record->last_logged_in = date('Y-m-d H:i:s');
            $record->ip_address = Yii::app()->request->getUserHostAddress();
            $record->login_attemp = 0;
            Yii::app()->session['LOGGED_USER'] = $record;
            if(!$record->update())
                Yii::log(print_r($record->getErrors(), true), 'error', 'UserIdentity.authenticate');
        }
        
        if($this->errorCode && $this->errorCode != self::ERROR_USERNAME_INVALID)
        {
            //write ip and username            
            $iplogin->username   =  $this->username;
            $iplogin->ip_address = Yii::app()->request->getUserHostAddress();
            $iplogin->time_login = time();
            $iplogin->save();       
        }

        if($this->errorCode && $this->errorCode == self::ERROR_PASSWORD_INVALID) {
            $loginLog = new LoginLogs();
            $loginLog->role_website_id = ROLE_WEBSITE_ID;
            $loginLog->username = $record->username;
            $loginLog->email = $record->email;
            $loginLog->login = date('Y-m-d H:i:s');
            $loginLog->ip_address = Yii::app()->request->getUserHostAddress();
            $loginLog->status = PASSWORD_WRONG;
            $loginLog->saveAndDeleteOld();
        }

        if (!$this->errorCode) {
            $loginLog = new LoginLogs();
            $loginLog->role_website_id = ROLE_WEBSITE_ID;
            $loginLog->username = $record->username;
            $loginLog->email = $record->email;
            $loginLog->login = date('Y-m-d H:i:s');
            $loginLog->ip_address = Yii::app()->request->getUserHostAddress();
            $loginLog->status = PASSWORD_CORRECT;
            $loginLog->saveAndDeleteOld();
        }
        
        return !$this->errorCode;
	}

    public function getId()
    {
        return $this->_id;
    }

    public function getIsAdmin()
    {
        return $this->_isAdmin;
    }

    public function getRoleId()
    {
        return $this->role_id;
    }
}