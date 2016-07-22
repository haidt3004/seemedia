<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class AdminUserIdentity extends UserIdentity
{

	private $status = 1;
	public $role_id;
	public $application_id = BE;

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
//		//user ip login more than X times can't login
		$iplogin = new IpLogins();
		// $iplogin->deleteOldRecords();
		// die();
		// if(!$iplogin->limitLoginTimes($this->username, Yii::app()->request->getUserHostAddress()))
		// {
		// 	$this->errorCode = self::ERROR_FAILURE_MAX_TIMES;
		// 	return !$this->errorCode;
		// }

        // $checkManager = Users::model()->findByAttributes(array(
        //     'username'       => $this->username,
        //     'status'         => $this->status,
        //     'application_id' => $this->application_id,

        // ));

        $criteria=new CDbCriteria;
        $criteria->compare('t.username',$this->username);
        $criteria->compare('t.status',$this->status);
        $criteria->compare('t.application_id',$this->application_id);
        $criteria->compare('t.role_id',array(ROLE_MANAGER,ROLE_ADMIN));
        $checkManager= Users::model()->find($criteria);
        
        if($checkManager){
            //danh cho admin quan ly tat cac cac site
            $record = $checkManager;
        }else{
            $record = Users::model()->findByAttributes(array(
                'username' => $this->username,
                'status' => $this->status,
                'application_id' => $this->application_id,
                'role_website_id'=>ROLE_WEBSITE_ID
            ));
        }



		if ($record === null)
		{
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		}
		else if (trim($record->password_hash) != md5(trim($this->password)))
		{
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
			$record->login_attemp = $record->login_attemp + 1;
			$record->update();
		}
		else if ($record->status == 0)
		{
			$this->errorCode = self::ERROR_USERNAME_BLOCKED;
		}
		else
		{
			$this->_id = $record->id;
			$this->role_id = $record->role_id;
			$this->_isAdmin = true;
			$this->errorCode = self::ERROR_NONE;
			// Update last IP and time
			$record->last_logged_in = date('Y-m-d H:i:s');
			$record->login_attemp = 0;
			Yii::app()->session['LOGGED_USER'] = $record;
			if (!$record->update())
				Yii::log(print_r($record->getErrors(), true), 'error', 'AdminUserIdentity.authenticate');

			/**
			 * DTOAN ghostkissboy12@gmail.com
			 * set cookie
			 */
			if (isset($_POST['AdminLoginForm']['rememberMe']))
			{
				if ($_POST['AdminLoginForm']['rememberMe'] == 1)
				{
					$expire = time() + 7 * 24 * 60 * 60;
					$array[VERZLOGIN] = $record->username;
					$array[VERZLPASS] = $record->temp_password;
					setcookie(VERZ_COOKIE_ADMIN, json_encode($array), $expire);
				}
			}
		}

		if($this->errorCode && $this->errorCode != self::ERROR_USERNAME_INVALID)
		{
			//write ip and username
			$iplogin->username   =  $this->username;
			$iplogin->role_website_id   =  ROLE_WEBSITE_ID;
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

		// if (!$this->errorCode) {
		// 	$loginLog = new LoginLogs();
		// 	$loginLog->role_website_id = ROLE_WEBSITE_ID;
		// 	$loginLog->username = $record->username;
		// 	$loginLog->email = $record->email;
		// 	$loginLog->login = date('Y-m-d H:i:s');
		// 	$loginLog->ip_address = Yii::app()->request->getUserHostAddress();
		// 	$loginLog->status = PASSWORD_CORRECT;
		// 	$loginLog->saveAndDeleteOld();
		// }


		return !$this->errorCode;
	}

}
