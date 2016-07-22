<?php

class SiteController extends FrontController {

    public $attempts = 2;
    public $counter;
    public $isStaticPage = false;

    public function beforeRender($view) {

        parent::beforeRender($view);
        
        $action = Yii::app()->controller->action->id;
        if(!isset(Yii::app()->user->id)){
            if($action !='login' && $action !='forgotPassword' && $action !='resetpassword' ){
                $this->redirect(Yii::app()->createAbsoluteUrl('site/login'));
            }
        }else{
            if(Yii::app()->user->is_changepassword==0 && $action !='passwordchanged' ){
                $this->redirect(Yii::app()->createAbsoluteUrl('member/site/passwordchanged'));
            }
        }
        return true;
    }

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
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('captcha'),
                'users' => array('*'),
            ),
        );
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    protected function performAjaxValidation($model) {
        try {
            if (isset($_POST['ajax'])) {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
        } catch (Exception $e) {
            Yii::log("Exception " . print_r($e, true), 'error');
            throw new CHttpException("Exception " . print_r($e, true));
        }
    }

    public function actionIndex() {
        $this->isStaticPage = true;
        $this->pageTitle = 'Home';

        $criteriaAnnouncement=new CDbCriteria;
        $criteriaAnnouncement->compare('status', STATUS_ACTIVE);
        // gioi han search theo tung website
        $criteriaAnnouncement->compare('role_website_id', ROLE_WEBSITE_ID, true);
        $criteriaAnnouncement->order = 'created_date DESC';
        $criteriaAnnouncement->limit = 5;

        $models = Announcement::model()->findAll($criteriaAnnouncement);

        $criteriaAnnouncementHome=new CDbCriteria;
        $criteriaAnnouncementHome->compare('status', STATUS_ACTIVE);
        // gioi han search theo tung website
        $criteriaAnnouncementHome->compare('role_website_id', ROLE_WEBSITE_ID, true);
        $criteriaAnnouncementHome->compare('parent_id', 1);
        $criteriaAnnouncementHome->order = 'created_date DESC';

        $modelHomes = Announcement::model()->findAll($criteriaAnnouncementHome);

        $this->render('index', array(
            'models' => $models,
            'modelHomes' => $modelHomes
        ));
    }

    public function checkLogged() {
        if (Yii::app()->user->id) {
            $this->redirect(Yii::app()->createAbsoluteUrl('member/site/index'));
        }
    }

    public function actionLogin() {
        // $this->checkLogged();
        $messageTimeLimit =null;

        $this->pageTitle = 'Login - ' . Yii::app()->params['defaultPageTitle'];
        $model =  new LoginForm();
        $model->login_by = 'username'; //login by username or email.
        $returnUrl = '';
        if (isset($_GET['returnUrl'])) {
            $returnUrl = urldecode($_GET['returnUrl']);
        }
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            $model->validate();
            //check captcha
//            $secret = Yii::app()->params['goCapcha']['secret'];
//            $recaptcha = new ReCaptcha($secret);
//            $resp      = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR'], $secret);
//
//            if (!$resp->isSuccess()) {
//                $model->addError('google_capcha','Please make sure you are not a robot.');
//            }

            if(!$model->hasErrors()){
                if (!empty($returnUrl)) {
                    $this->redirect(Yii::app()->createAbsoluteUrl($returnUrl));
                }else{  
                    $this->redirect(Yii::app()->createAbsoluteUrl('site/index'));
                }

                if (strpos(Yii::app()->user->returnUrl, '/index.php') === false)
                    $this->redirect(Yii::app()->user->returnUrl);
                switch (Yii::app()->user->role_id) {
                    case ROLE_ADMIN:
                        $this->redirect(Yii::app()->createAbsoluteUrl('admin/site/login'));
                        break;
                    default :$this->redirect(Yii::app()->createAbsoluteUrl('member/site/index'));
                }
                Yii::app()->session->add('captchaRequired', 0);
                Yii::app()->end();
            } else {
                $this->counter = Yii::app()->session->itemAt('captchaRequired') + 1;
                Yii::app()->session->add('captchaRequired', $this->counter);
                $messageTimeLimit = $model->getError('limitLogin');
            }
        }
        // display the login form
        $this->render('login', array('model' => $model,'messageTimeLimit'=>$messageTimeLimit));
    }


    public function actionLogout() {

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
        $this->redirect(Yii::app()->createAbsoluteUrl('site/login'));
    }

    public function actionForgotPassword() {
        $this->pageTitle = 'Forgot password';
        $model = new Users('hr_forgot_password');
        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            if ($model->validate()) {

				/*
                $secret = Yii::app()->params['goCapcha']['secret'];            
                $recaptcha = new ReCaptcha($secret);
                $resp      = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR'], $secret); 
                
                if (!$resp->isSuccess()) {
                    $model->addError('google_capcha','Please make sure you are not a robot.');
                }else{
                    $userExit = Users::model()->findByAttributes(array(
                        'username' => trim($model->username_forgot),
                        'role_website_id' => ROLE_WEBSITE_ID
                    ));
                    if(!isset($userExit->email)) $model->addError('username_forgot','The username does not exist');                    
                } */
				
				$userExit='';
				$userExit = Users::model()->findByAttributes(array(
					'username' => trim($model->username_forgot),
					'role_website_id' => ROLE_WEBSITE_ID
				));
				if(!isset($userExit->email)) $model->addError('username_forgot','The username does not exist');			   
			   
                if(!$model->hasErrors()){
                    // if(isset($userExit->username) && $userExit->username == $model->username_forgot ){
                    if(isset($userExit->username)){
                        // $userExit->temp_password = (Yii::app()->params['defaultPassword'] !='') ? Yii::app()->params['defaultPassword'] : '123456';
                        // $userExit->password_hash = md5($userExit->temp_password);
                        // $userExit->is_changepassword = 0;
                        // if($userExit->update(array('temp_password','password_hash','is_changepassword'))){
                        //     // Yii::app()->user->setFlash('msg', "Your password has been changed to the default password");
                        //     Yii::app()->user->setFlash('msg', "The password has been changed. Your current password is ".$userExit->temp_password);
                        //     $this->refresh();                           
                        // }                            

                        SendEmail::resetForgotPasswordHr($userExit);
                        Yii::app()->user->setFlash('msg', "Email sent! You'll receive an email with a new password.");
                        $this->refresh();
                    }
                }
            }
        }
        $this->render('forgot_password', array('model' => $model));
    }

    public function actionEleave() {
        $this->isStaticPage = true;
        $this->pageTitle = 'eLeave ' . ' - ' . Yii::app()->params['defaultPageTitle'];
        $this->render('sub_eLeave');
    }

    public function actionEleaveInternal() {
        $this->isStaticPage = true;
        $this->pageTitle = 'eLeave Internal ' . ' - ' . Yii::app()->params['defaultPageTitle'];
        $this->render('sub_eLeave_internal');
    }

    public function actionNews() {
        $this->isStaticPage = true;
        $this->pageTitle = 'News ' . ' - ' . Yii::app()->params['defaultPageTitle'];
        $this->render('news');
    }

    public function actionProjects() {
        $this->isStaticPage = true;
        $this->pageTitle = 'Projects ' . ' - ' . Yii::app()->params['defaultPageTitle'];
        $this->render('projects');
    }

    public function actionDocumentation() {
        $this->isStaticPage = true;
        $this->pageTitle = 'Documentation ' . ' - ' . Yii::app()->params['defaultPageTitle'];

        $models = Handbook::model()->findAll(array(
            'order'=>'created_date DESC',
            'limit'=>5,
        ));

        $this->render('documentation', array(
            'models' => $models
        ));
    }

    public function actionWhistleblow() {
        $this->isStaticPage = true;
        $this->pageTitle = 'Whistle Blow ' . ' - ' . Yii::app()->params['defaultPageTitle'];
        $model = new Whistle('whistleblow');

        // cms whistle
//        $cms = Page::model()->findByAttributes(array('slug'=>'whistle-blow','status'=>1,'role_website_id'=>ROLE_WEBSITE_ID));
        $cms = Page::model()->findByPk(974);
        $cms->getDataTranslate();

        if(isset($_POST['Whistle'])){
            $model->attributes = $_POST['Whistle'];
            $model->author = Users::model()->findByPk(Yii::app()->user->id)->staff_name;

            $model->validate();
            //check captcha
//            $secret = Yii::app()->params['goCapcha']['secret'];
//            $recaptcha = new ReCaptcha($secret);
//            $resp      = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR'], $secret);
//
//            if (!$resp->isSuccess()) {
//                $model->addError('google_capcha','Please make sure you are not a robot.');
//            }

            if(!$model->hasErrors()){
                $model->modified_date = date('Y-m-d H:i:s');
                $model->status = STATUS_ACTIVE;
                if($model->save()){
                    SendEmail::sendWhistleBlowToAdmin($model);
                    // save thanh cong roi anh lam gi thi lam
//                    Yii::app()->user->setFlash('success', "Thank you. Your Whislte Blow has been sent to HR department.");
//                    $this->refresh();
                    $this->redirect('whistleblowsuccess');
                }
            }else{
                //xem lai loi neu can
            }
        }
        
        $this->render('whistle_blow', array(
            'model' => $model,
            'cms' => $cms
        ));            
    }

    public function actionWhistleblowsuccess() {
        $this->isStaticPage = true;
        $this->pageTitle = 'Whistle Blow Success' . ' - ' . Yii::app()->params['defaultPageTitle'];
        $this->render('whistle_blow_success');
    }


    //form reset password  - bb - 27/7/2014
    public function actionResetpassword($verify_code) {
        $this->pageTitle = 'Reset password ' . ' - ' . Yii::app()->params['title'];
        try {
            $verify_code = trim($verify_code );
            $model = Users::model()->findByAttributes(array('verify_code' => $verify_code));
            if (!$model){
                throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
            }

            $model->temp_password = (Yii::app()->params['defaultPassword'] !='') ? Yii::app()->params['defaultPassword'] : '123456';
            $model->password_hash = md5($model->temp_password);
            $model->is_changepassword = 0;
            $model->verify_code   = null;
            if($model->update(array('temp_password','password_hash','is_changepassword','verify_code'))){
                Yii::app()->user->setFlash('msg', "The password has been changed. Your current password is ".$model->temp_password);
                // $this->refresh();                           
            }    

            // $model->scenario = 'hr_reset_password';
            // if (isset($_POST['Users'])) {
            //     $model->attributes = $_POST['Users'];
            //     if ($model->validate()) {
            //         $model->temp_password = $model->newPassword;
            //         $model->password_hash = md5( $model->newPassword);
            //         $model->verify_code   = null;
            //         $model->update(array('password_hash', 'temp_password', 'verify_code'));
            //         $this->gotoPage(PAGE_SUCCESS_RESET_PASSWORD);
            //     }
            // }
            $this->render('resetPassword', array(
                'model' => $model
            ));
        } catch (Exception $e) {
            Yii::log("Exception " . print_r($e, true), 'error');
             throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionContactus() {
        $this->isStaticPage = true;
        $this->pageTitle = 'Contact Us';
        $model = new ContactForm('create');
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            //use recaptcha
            $secret = Yii::app()->params['goCapcha']['secret'];
            $recaptcha = new ReCaptcha($secret);
            $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR'], $secret);
            if ($resp->isSuccess()) {
                $model->validation = 'validated';
            } else {
                $model->validation = '';
            }

            if ($model->validate()) {
                //Send mail to admin
                SendEmail::noticeContactMailToAdmin($model);
                //Send mail to user
                SendEmail::confirmContactMailToUser($model);
                Yii::app()->user->setFlash("msg", "Thank you for your enquiry. We will get back to you shortly.");
                $this->refresh();
            }
        }
        $this->render('contact_us', array(
            'model' => $model
        ));
    }


}