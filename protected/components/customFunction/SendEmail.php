<?php

/**
 * All sendmail function should be placed here.
 * Custom For Each Project
 */
class SendEmail {

	public static function registerSucceedToUser($mUser) {
		$param = array(
			'{FULL_NAME}' => !empty($mUser->full_name) ? $mUser->full_name : $mUser->first_name . ' ' . $mUser->last_name,
			'{EMAIL}' => $mUser->email,
			'{PASSWORD}' => $mUser->temp_password,
			'{PHONE}' => $mUser->phone,
			'{LINK_VERIFY}' => Yii::app()->createAbsoluteUrl('site/confirmregister', array('verify_code' => $mUser->verify_code))
		);

		if (EmailHelper::send(MAIL_REGISTER_SUCCEED_TO_MEMBER, $param, $mUser->email)) {
			
		} else
			$mUser->addError('status', 'Can not send email');
	}

	//registering successfully, send email to Administrator - bb
	public static function registerSucceedToAdmin($mUser) {
		$param = array(
			'{FULL_NAME}' => !empty($mUser->full_name) ? $mUser->full_name : $mUser->first_name . ' ' . $mUser->last_name,
			'{EMAIL}' => $mUser->email,
			'{PHONE}' => $mUser->phone,
			'{COMPANY}' => $mUser->company
		);

		if (EmailHelper::send(MAIL_REGISTER_SUCCEED_TO_ADMIN, $param, Yii::app()->params['adminEmail'])) {
			
		} else
			$mUser->addError('status', 'Can not send email');
	}

	//send email to User for forgetting password  - bb
	public static function forgotPasswordToUser($mUser) {
		$mUser->verify_code = Users::model()->checkVerifyCode(rand(100000, 1000000)); // Gen verify code and send qua mail or sms
		$mUser->update('verify_code');
		$resetlink = '<a href="' . Yii::app()->createAbsoluteUrl("site/resetPassword", array('verify_code' => $mUser->verify_code)) . '">RESET PASSWORD NOW</a>';
		$param = array(
			'{FULL_NAME}' => !empty($mUser->full_name) ? $mUser->full_name : $mUser->first_name . ' ' . $mUser->last_name,
			'{EMAIL}' => $mUser->email,
			'{RESET_LINK}' => $resetlink,
		);

		if (EmailHelper::send(MAIL_FORGET_PASSWORD, $param, $mUser->email)) {
			
		} else
			$mUser->addError('status', 'Can not send email');
	}

	//send email to User for reset password
	public static function changePassToUser($mUser) {
		$name = $mUser->full_name;
		//$login_link = '<a href="'.Yii::app()->createAbsoluteUrl("site/login").'">'.Yii::app()->createAbsoluteUrl("site/login").'</a>';
		$param = array(
			'{FULL_NAME}' => $name,
			'{PASSWORD}' => $mUser->temp_password,
			//'{LINK_LOGIN}' =>$login_link,
		);

		if (EmailHelper::send(MAIL_CHANGE_PASSWORD_TO_USER, $param, $mUser->email))
			Yii::app()->user->setFlash("success", "An email has sent to: $mUser->email. Please check email to get new password.");
		else
			$mUser->addError('email', 'Can not send email to: ' . $mUser->email);
	}

	//Submitting contact form successfully, send email to confirm User
	public static function confirmContactMailToUser($contactM) {
		$param = array(
			'{NAME}' => $contactM->name,
			'{EMAIL}' => $contactM->email,
			'{PHONE}' => $contactM->phone,
			'{MESSAGE}' => $contactM->message,
		);
		if (EmailHelper::send(MAIL_CONTACT_TO_USER, $param, $contactM->email)) {
			
		} else {
			$contactM->addError('email', 'Can not send email to: ' . $contactM->email);
		}
	}

	//Submitting contact form successfully, send email to Administrator
	public static function noticeContactMailToAdmin($contactM) {

		$param = array(
			'{NAME}' => $contactM->name,
			'{EMAIL}' => $contactM->email,
			'{PHONE}' => $contactM->phone,
			'{MESSAGE}' => $contactM->message,
		);
		if (EmailHelper::send(MAIL_CONTACT_TO_ADMIN, $param, Yii::app()->params['adminEmail'])) {
			
		} else {
			$contactM->addError('email', 'Can not send email to: ' . Yii::app()->params['adminEmail']);
		}
	}

	//mail from Forgot Password at BE
	public static function verifyResetPasswordToAdmin($mUser) {
		$name = $mUser->full_name;
		$key = ForgotPasswordForm::generateKey($mUser);
		$forgot_link = '<a href="' . Yii::app()->createAbsoluteUrl('/admin/site/resetPassword', array('id' => $mUser->id, 'key' => $key)) . '">' . Yii::app()->createAbsoluteUrl('/admin/site/ResetPassword', array('id' => $mUser->id, 'key' => $key)) . '</a>';

		$param = array(
			'{NAME}' => $name,
			'{USERNAME}' => $mUser->username,
			'{EMAIL}' => $mUser->email,
			'{LINK}' => $forgot_link,
		);

		if (EmailHelper::send(MAIL_VERIFY_TO_RESET_PASSWORD_TO_ADMIN, $param, $mUser->email))
			Yii::app()->user->setFlash("success", "An email has sent to: $mUser->email. Please check email to verify this action.");
		else
			$mUser->addError('email', 'Can not send email.');
	}

	//mail to reset password after admin agreed verify email at BE
	public static function resetPasswordToAdmin($mUser) {
		$name = $mUser->full_name;
		$login_link = '<a href="' . Yii::app()->createAbsoluteUrl("admin/site/login") . '">' . Yii::app()->createAbsoluteUrl("admin/site/login") . '</a>';
		$param = array(
			'{NAME}' => $name,
			'{PASSWORD}' => $mUser->temp_password,
			'{LINK_LOGIN}' => $login_link,
		);

		if (EmailHelper::send(MAIL_RESET_PASSWORD_TO_ADMIN, $param, $mUser->email))
			Yii::app()->user->setFlash("success", "An email has sent to: $mUser->email. Please check email to get new password.");
		else
			$mUser->addError('email', 'Can not send email to: ' . $mUser->email);
	}

	//mail to change password successfully from "Change password form" at BE
	public static function noticeChangPasswordSucceedToAdmin($mUser) {
		$name = $mUser->full_name;
		$login_link = '<a href="' . Yii::app()->createAbsoluteUrl("admin/site/login") . '">' . Yii::app()->createAbsoluteUrl("admin/site/login") . '</a>';
		$param = array(
			'{NAME}' => $name,
			'{PASSWORD}' => $mUser->temp_password,
			'{LINK_LOGIN}' => $login_link,
		);

		if (EmailHelper::send(MAIL_CHANGE_PASSWORD_TO_ADMIN, $param, $mUser->email))
			Yii::app()->user->setFlash("success", "An email has sent to: $mUser->email. Please check email to get new password.");
		else
			$mUser->addError('email', 'Can not send email to: ' . $mUser->email);
	}
    
    /**
	 * @author haidt <haidt3004@gmail.com>
	 * @copyright 2015 VerzDesign 	 	 
	 * @param object $model
	 * @todo send mail to user confirm subscribe
	 */
    
    public static function subcribeConfirm($model) {
		if (!empty($model)) {
			$link = Yii::app()->createAbsoluteUrl('site/subscribeconfirm', array('verify_code' => $model->verify_code));
			$param = array(
				'{NAME}' => $model->name,
				'{VERIFY_LINK}' => $link
			);
			if (!EmailHelper::send(MAIL_SUBCRIBER_CONFIRM, $param, $model->email))
				Yii::app()->user->setFlash("success", "Can not send email.");
		}
	}


	/*
	 * @Huu Thoa
	 * send mail when user submit subcriber successfully
	 */

	public static function subcribeSuccess($model) {
		if (!empty($model)) {
			$code = md5($model->id . $model->email);
			$link = Yii::app()->createAbsoluteUrl('site/unsubscribe', array('id' => $model->id, 'code' => $code));
			$param = array(
				'{NAME}' => $model->name,
				'{LINK}' => $link
			);
			if (!EmailHelper::send(MAIL_SUBCRIBER_SUCCESS, $param, $model->email))
				Yii::app()->user->setFlash("success", "Can not send email.");
		}
	}

	public static function createUserAdminToUser($mUser) {
		$param = array(
            '{FULL_NAME}' => !empty($mUser->full_name) ? $mUser->full_name : $mUser->first_name . ' ' . $mUser->last_name,
			'{USERNAME}' => $mUser->username,
            '{STAFF_NAME}' => $mUser->staff_name,
			'{EMAIL}' => $mUser->email,
			'{PASSWORD}' => $mUser->temp_password,
			'{PHONE}' => $mUser->phone
		);
        $language = isset($mUser->language_pk) ? $mUser->language_pk->code : 'en';

        if (EmailHelper::send(MAIL_CREATE_ACCOUNT_TO_USER, $param, $mUser->email,null,$language)) {
		// if (EmailHelper::send(MAIL_CREATE_ACCOUNT_TO_USER, $param, 'toan.pd@verzdesign.com.sg',null,$language)) {
			
		} else
			$mUser->addError('status', 'Can not send email');
	}


	
	/**
	 * @Author Haidt <haidt3004@gmail.com>
	 * @copyright 2015 Verz Design 	 	 
	 * @param object $mUser
	 * @Todo: send email to User for update password
	 */
	public static function userUpdatePasswordSuccessful($mUser) {
		$name = $mUser->full_name;
		$param = array(
            '{STAFF_NAME}' => $mUser->staff_name,
            '{FULL_NAME}' => $name,
			'{USERNAME}' => $mUser->username,
			'{PASSWORD}' => $mUser->temp_password,
		);

        $language = isset($mUser->language_pk) ? $mUser->language_pk->code : 'en';
		EmailHelper::send(MAIL_TO_USER_WHEN_UPDATE_PASSWORD, $param, $mUser->email,null,$language);
	}



    public static function resetForgotPasswordHr($mUser){
        $mUser->verify_code = Users::model()->checkVerifyCode(rand(100000, 1000000)); // Gen verify code and send qua mail or sms
        $mUser->update(array('verify_code'));
        $resetlink = '<a href="' . Yii::app()->createAbsoluteUrl("site/resetpassword", array('verify_code' => $mUser->verify_code)) . '">RESET PASSWORD NOW</a>';
        $param = array(
            '{STAFF_NAME}' => $mUser->staff_name,
            '{USERNAME}'  => $mUser->username,
            '{EMAIL}'     => $mUser->email,
            '{LINK}'      => $resetlink,
        );
        
        $language = isset($mUser->language_pk) ? $mUser->language_pk->code : 'en';
        if (EmailHelper::send(MAIL_RESET_PASSWOR_HR, $param, $mUser->email,null,$language))
            Yii::app()->user->setFlash("success", "An email has sent to: $mUser->email. Please check email to get new password.");
        else
            $mUser->addError('email', 'Can not send email to: ' . $mUser->email);

    }

	public static function sendWhistleBlowToAdmin($whistle) {
		$param = array(
			'{USERNAME}' => $whistle->author,
			'{EMAIL}' => Whistle::getUser($whistle->posted_by),
//			'{EMAIL}' => 'test@gmail.com',
			'{TITLE}' => $whistle->title,
			'{MESSAGE}' => $whistle->content,
		);

		EmailHelper::send(MAIL_TO_ADMIN_WHEN_SEND_WHISTLE_BLOW, $param, Yii::app()->params['adminEmail']);
	}


    public static function sendMailUpdateProfile($mUser,$oldData) {
        $arrFiled = array();
        $form = SettingForm::$settingDefine;
        foreach($form['hrsetting']['items'] as $field){
            $fileName  = $field['name'];

			switch ($fileName) {
				case 'date_of_birthday':
					$fileName = 'dob';
					break;
				case 'house_address':
					$fileName = 'address';
					break;
				case 'house_phone_number':
					$fileName = 'home_phone_number';
					break;
				case 'mobile_phone':
					$fileName = 'phone';
					break;
			}

            $isCheck   = Yii::app()->params[$fileName];
            if($isCheck){
                $old = $oldData->$fileName;
                $new = $mUser->$fileName;
                if($old != $new){
                    $arrFiled[$fileName] =  '<p><b>'.$mUser->getAttributeLabel($fileName).'</b> : '.$mUser->$fileName.'</p>';
                }
            }
        }

        if($mUser->staff_name != $model->staff_name){
            $arrFiled['staff_name'] =  '<p><b>'.$mUser->getAttributeLabel('staff_name').'</b> : '.$mUser->staff_name.'</p>';
        }

        if(count($arrFiled)>0){
            $param = array(
                '{USERNAME}'     =>$mUser->username,
                '{FULL_NAME}'    => !empty($mUser->full_name) ? $mUser->full_name : $mUser->first_name . ' ' . $mUser->last_name,
                '{FIELD_UPDATE}' => implode('',$arrFiled)
            );

            if(Yii::app()->params['multiple_Email'] !=''){
                $arrEmail = explode(';',trim(Yii::app()->params['multiple_Email']));
                if(is_array($arrEmail)&&count($arrEmail)>0){
                    foreach ($arrEmail as $emailHr) {
                        if (!filter_var(trim($emailHr), FILTER_VALIDATE_EMAIL) === false) {
                            if (EmailHelper::send(MAIL_TO_ADMIN_USER_UPDATE_PROFILE, $param,trim($emailHr))) {

                            }else{
                                $mUser->addError('status', 'Can not send email');
                            }                          
                        }                       
                    }
                }
            }else{
                // if (EmailHelper::send(MAIL_TO_ADMIN_USER_UPDATE_PROFILE, $param,Yii::app()->params['adminEmail'])) {
                // } else{
                //     $mUser->addError('status', 'Can not send email');
                // }
            }
        }


    }




}
