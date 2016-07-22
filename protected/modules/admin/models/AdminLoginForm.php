<?php
/**
 * LoginForm class.
 * LoginForm is the data structure for keeping

 * user login form data. It is used by the 'login' action of 'SiteController'.

 */

class AdminLoginForm extends CFormModel
{
    private $_identity;
    public $username;
    public $password;
    public $rememberMe;
    public $verifyCode;
    public $limitLogin;
    public $google_capcha;

    /**
     * Declares the validation rules.
     * The rules state that nick_name and password are required,
     * and password needs to be authenticated.
     */

    public function rules()
    {
        return array(
            // nick_name and password are required
            array('username, password', 'required'),
            // rememberMe needs to be a boolean
            array('rememberMe', 'boolean'),
            // password needs to be authenticated
            array('password', 'authenticate'),
//            array('verifyCode', 'required', 'on' => 'captchaRequired'),
//            array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements(), 'on' => 'captchaRequired'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'rememberMe'=>'Remember me',
        );
    }

    /**
    * Authenticates the password.
    * This is the 'authenticate' validator as declared in rules().
    */
    public function authenticate($attribute,$params)
    {
        if(!$this->hasErrors())
        {
            $this->_identity=new AdminUserIdentity($this->username,$this->password);
            if(!$this->_identity->authenticate()){
                switch($this->_identity->errorCode)
                {
                    case AdminUserIdentity::ERROR_USERNAME_INVALID:
                        $this->addError("username","Username is not valid.");
                        break;
                    case UserIdentity::ERROR_FAILURE_MAX_TIMES:
                        $times = Yii::app()->setting->getItem('login_limit_times');
                        $time_refresh = Yii::app()->setting->getItem('time_refresh_login');
//                        $this->addError("username","You can't login more than $times times. Wait $time_refresh minutes!.");
                        $this->addError('limitLogin', "You have entered an incorrect password $times times. Wait for $time_refresh minutes to re-login.");
                        break;
                    case AdminUserIdentity::ERROR_USERNAME_BLOCKED:
                        $this->addError("username","Account has been blocked.");
                        break;
                    case AdminUserIdentity::ERROR_PASSWORD_INVALID:
                        $this->addError("password","Wrong password");
                        break;
                }
            }else{
                $duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
                Yii::app()->user->login($this->_identity,$duration);
            }
        }
    }

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new AdminUserIdentity($this->username,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}
}
?>