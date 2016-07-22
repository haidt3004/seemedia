<?php

class SiteController extends MemberController {

    public function beforeRender($view) {
        parent::beforeRender($view);
        $action = Yii::app()->controller->action->id;
        if(!isset(Yii::app()->user->id)){
            $this->redirect(Yii::app()->createAbsoluteUrl('site/login'));
        }else{
            if(Yii::app()->user->is_changepassword==0 && $action !='passwordchanged' ){
                $this->redirect(Yii::app()->createAbsoluteUrl('member/site/passwordchanged'));
            }
        }

        if(isset($_POST['lang']) && $_POST['lang'] != '') {
            Yii::app()->session['language'] =  $_POST['lang'];
        }

        if(isset(Yii::app()->session['language'])){
            Yii::app()->language =Yii::app()->session['language'];
        } else {
            Yii::app()->language = 'en';
        }
        
        return true;
    }

	public $layout = '//layouts/site';
    public $isStaticPage = false;

	/**
	 * Declares class-based actions.
	 */
	public function accessRules() {
		return array();
	}

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

	public function actionIndex() {
        $this->pageTitle = "Profile Management";
        $user_id = Yii::app()->user->id;
        $model = Users::model()->findByPk($user_id);
        $model->roleProfile =true;

        $this->render('index', array(
            'model' => $model,
        ));
	}

    public function actionEdit() {

        $this->pageTitle = "Profile Management";
        $user_id = Yii::app()->user->id;
        $oldData = Users::model()->findByPk($user_id);
        $model = Users::model()->findByPk($user_id);

        $model->roleProfile =true;
        $old = new Users;
        $old->attributes = $model->attributes;

        $model->scenario = 'update_Hr_Profile';
        if (isset($_POST['Users'])) {

            $model->attributes       = $_POST['Users'];
            $checkChangePassword=false;
            if($model->newPassword ==''&& $model->password_confirm ==''){
                $model->newPassword = $model->password_confirm = $old->temp_password;
            }else{
                $checkChangePassword=true;
            }

            if ($model->validate()) {
                $model->temp_password = $model->newPassword;
                $model->dob  = date('Y-m-d',strtotime(str_replace('/','-',$model->dob)));
                if($model->save()){
                    if($checkChangePassword){
                        SendEmail::userUpdatePasswordSuccessful($model);
                    }

                    //send mail update profile
                    SendEmail::sendMailUpdateProfile($model,$oldData);

                    Yii::app()->user->setFlash('msg', "Your profile has been changed successfully.");
                    $this->redirect(Yii::app()->createUrl('member/site'));
                }
            }
        }else{
            $model->newPassword = $model->password_confirm ='';
            if (isset($model->dob) && $model->dob != '') {
                $model->dob = Yii::app()->format->Date($model->dob);
            }
        }
        $this->render('edit', array(
            'model' => $model,
        ));
    }

    public function actionPasswordchanged(){
        $this->pageTitle = "Password changed";
        $user_id = Yii::app()->user->id;
        $model   = Users::model()->findByPk($user_id);
        $model->roleChangepassword =true;
        $old = new Users;
        $old->attributes = $model->attributes;

        $model->scenario = 'hr_reset_password';
        if (isset($_POST['Users'])) {
            $model->attributes       = $_POST['Users'];
            if ($model->validate()) {
                $model->temp_password = $model->newPassword;
                $model->password_hash = md5($model->temp_password);
                $model->is_changepassword = 1;
                if($model->update(array('temp_password','password_hash','is_changepassword'))){
                    SendEmail::userUpdatePasswordSuccessful($model);
                    Yii::app()->user->setFlash('msg', "Your password has been changed successfully.");
                    $this->refresh();
                }
            }
        }else{
            $model->newPassword = $model->password_confirm ='';
        }

        $this->render('password_change', array(
            'model' => $model,
        ));

    }


}