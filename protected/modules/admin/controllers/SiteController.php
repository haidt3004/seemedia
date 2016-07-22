<?php

class SiteController extends AdminController
{
    public $counter;

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
        );
    }
    
    
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform  actions
                'actions'=>array('ForgotPassword','importemail', 'ResetPassword', 'Login', 'Logout', 'Error','Loadmenu','importrole','importmenu'),
                'users'=>array('*'),
            ),  
            array('allow',   //allow authenticated user to perform actions
                'actions'=>array('index', 'Update_my_profile', 'Change_my_password'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),                      
        );
    }

    public function actionForgotPassword()
    {
        $model = new ForgotPasswordForm;
        if(isset($_POST['ForgotPasswordForm']))
        {
            $model->attributes=$_POST['ForgotPasswordForm'];
            if($model->validate()) 
            {
                //check Email
                $user = Users::model()->findByAttributes(array(
                    'email' => trim($model->email), 'application_id' => BE,
                ));
                if(!$user){
                    $model->addError('email','Email does not exist.');
                } else {
                    SendEmail::verifyResetPasswordToAdmin($user);
                }                                

            }
        }
		$this->render('forgotPassword',array('model'=>$model));
    }
	
    public function actionResetPassword()
    {
        $id = Yii::app()->request->getParam('id'); 
        $key = Yii::app()->request->getParam('key'); 
        $model = Users::model()->findByPk((int)$id);
        
        if($model !== null && $key == ForgotPasswordForm::generateKey($model))
        {
            $pass = StringHelper::getRandomString(6);
            $model->password_hash = md5($pass);
            $model->temp_password = $pass;
            $model->update();
            SendEmail::resetPasswordToAdmin($model);
        }
        else
        {
            Yii::log('Invalid request. Please do not repeat this request again.');
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
        $this->render('ResetPassword',array('model'=>$model));
        
    }    

	public function actionError()
	{
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
	}

	public function actionIndex()
	{            
            $this->render('index');
	}

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        // $this->checkLogged();
        $messageTimeLimit =null;

        $model=new AdminLoginForm();
        if(isset($_POST['AdminLoginForm']))
	    {
            //var_dump($_POST['LoginForm']);die;
            $model->attributes=$_POST['AdminLoginForm'];
//            $model->validate();

            // check captcha
            $secret = Yii::app()->params['goCapcha']['secret'];
            $recaptcha = new ReCaptcha($secret);
            $resp      = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR'], $secret);

            if (!$resp->isSuccess()) {
                $model->addError('google_capcha','Please make sure you are not a robot.');
            }

            if(!$model->hasErrors()){
                if ($model->validate()) {
                    /* Change at yii 1.1.13:
                * we not use: if (strpos(Yii::app()->user->returnUrl,'/index.php')===false) to check returnUrl
                */
                    if (strtolower(Yii::app()->user->returnUrl)!==strtolower(Yii::app()->baseUrl.'/'))
                        $this->redirect(Yii::app()->user->returnUrl);

                    switch (Yii::app()->user->role_id){
                        case ROLE_MANAGER:
                            $this->redirect(Yii::app()->createAbsoluteUrl('admin'));
                            break;
                        case ROLE_ADMIN:
                            $this->redirect(Yii::app()->createAbsoluteUrl('admin'));
                            break;

                        default: $this->redirect(Yii::app()->createAbsoluteUrl('admin'));
                    }
                }
            } else {
                $this->counter = Yii::app()->session->itemAt('captchaRequired') + 1;
                Yii::app()->session->add('captchaRequired', $this->counter);
            }

            $messageTimeLimit = $model->getError('limitLogin');
        }
        $this->render('login', array('model'=>$model,'messageTimeLimit'=>$messageTimeLimit));
    }
    
    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        $user = Users::model()->findByPk(Yii::app()->user->id);

        $loginLog = new LoginLogs();
        $loginLog->role_website_id = ROLE_WEBSITE_ID;
        $loginLog->username = $user->username;
        $loginLog->email = $user->email;
        $loginLog->logout = date('Y-m-d H:i:s');
        $loginLog->ip_address = Yii::app()->request->getUserHostAddress();
        $loginLog->status = PASSWORD_LOGOUT;
        $loginLog->saveAndDeleteOld();
        
        Yii::app()->user->logout();
        if(isset($_SESSION['LOGGED_USER']))
            unset($_SESSION['LOGGED_USER']);
        //xoa cookie
        if(isset($_COOKIE[VERZ_COOKIE_ADMIN])){
            setcookie(VERZ_COOKIE_ADMIN, '', 1);
            setcookie(VERZ_COOKIE_ADMIN, '', 1, '/');
        }

        $this->redirect(Yii::app()->createAbsoluteUrl('admin/login/'));
    }
    
    
    public function actionUpdate_my_profile()
    {
        if (Yii::app()->user->id == '')
            $this->redirect(array('login'));

        $model = MyFormat::loadModelByClass(Yii::app()->user->id, "Users");
        $model->scenario = 'updateMyProfile';
        //$model->md5pass = $model->password_hash;

        if (isset($_POST['Users']))
        {

            $model->attributes = $_POST['Users'];
            if ($model->validate())
            {
                if ($model->save())
                {
                    $this->setNotifyMessage(NotificationType::Success, 'Your profile information has been successfully updated.');
                    $this->redirect(array('update_my_profile'));
                }
            }
        }

        $this->render('update_my_profile', array(
                'model' => $model,
        ));
    }

    public function actionChange_my_password()
    {
        if (Yii::app()->user->id == '')
            $this->redirect(array('login'));

        $model = MyFormat::loadModelByClass(Yii::app()->user->id, "Users");
        $model->scenario = 'changeMyPassword';

        if (isset($_POST['Users']))
        {
            $model->attributes = $_POST['Users'];
            if ($model->validate())
            {
                $model->password_hash = md5($model->newPassword);
                $model->temp_password = $model->newPassword;
                if ($model->update(array('password_hash', 'temp_password')))
                {
                    SendEmail::noticeChangPasswordSucceedToAdmin($model);
                    $this->setNotifyMessage(NotificationType::Success, 'Your password has been changed successfully');
                    $this->redirect(array('change_my_password'));
                }
            }
        }

        $this->render('change_my_password', array(
                'model' => $model,
        ));
    }
    
    
    public function loadAttribute($data,$model){
        $data  = $data->getAttributes();
        unset($data['id']); 
        $model->attributes      = $data;
        $model->role_website_id = ROLE_WEBSITE_ID;
        $model->syn_id_root     = 1;
        return $model;
    }

    public function Importmenu(){
        //delete all menu cu 
        Menus::model()->deleteAllByAttributes(array('role_website_id'=>1,'syn_id_root'=>1));
        $menus = Menus::model()->findAllByAttributes(array('role_website_id'=>1,'parent_id'=>0));
        foreach($menus as $data){
            $model = new Menus();
            $model = $this->loadAttribute($data,$model);
            if($model->save()){
                //save phan tu con
                $childs = Menus::model()->findAllByAttributes(array('role_website_id'=>1,'parent_id'=>$data->id));
                if(is_array($childs)&&count($childs)>0){
                    foreach($childs as $child){
                        $sub = new Menus(); 
                        $sub = $this->loadAttribute($child,$sub);
                        $sub->parent_id = $model->id;
                        if($sub->save()){
                            echo $sub->menu_name . "-thanh cong <br>";
                        }else{
                            echo "that bai <br>";
                        }
                    }
                }
            }
        }
    }




    public function importActionRole($role=null){
        //delete all MENU CU 
        ActionsRoles::model()->deleteAllByAttributes(array('role_website_id'=>ROLE_WEBSITE_ID,'syn_root_id'=>1));

        $roles = ActionsRoles::model()->findAllByAttributes(array('role_website_id'=>1));
        foreach($roles as $data){
            $role = new ActionsRoles();
            $role->attributes = $data->getAttributes();
            $role->id         = null;
            $role->role_website_id = ROLE_WEBSITE_ID;
            $role->syn_root_id     =  $data->id;
            $role->roles_id        = ROLE_COMPANY_ADMIN;
            if($role->save()){
                echo "thanh cong <br>";
            }else{
                echo "that bai <br>";
            }
        }
    }

    public function actionImportrole(){
        $this->importActionRole();
    }

    public function actionImportmenu(){
         $this->Importmenu();
    }



    public function actionLoadmenu(){

        //import quyen 
        $this->importActionRole();

        //import menu
        $this->Importmenu();

        // echo 123;
    }

    public function importEmail(){
        $emails = EmailTemplates::model()->findAllByAttributes(array('role_website_id'=>1));
        foreach($emails as $data){
            $model = new EmailTemplates();
            $model->attributes = $data->getAttributes();
            $model->parent_id  = $data->id;
            $model->id         = null;
            $model->role_website_id = ROLE_WEBSITE_ID;
            if($model->save()){
                echo "thanh cong <br>";
            }else{
                echo "that bai <br>";
            }
        }        
    }

    public function actionImportemail(){
        $this->importEmail();
    }


}