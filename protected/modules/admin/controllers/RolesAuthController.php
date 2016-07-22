<?php
/**
 * VerzDesignCMS
 * 
 * LICENSE
 *
 * @copyright	Copyright (c) 2014 Verz Design (http://www.verzdesign.com)
 * @version 	$Id: RolesAuthController.php 2014-11-17 09:09:18 nguyendung build from bb code $
 * @since		1.0.0
 */
class RolesAuthController extends AdminController
{
    public $aControllers;
    
    /**
     * @Author: ANH DUNG Jan 26, 2015
     * @Todo: đưa vào model ActionsUsers khởi tạo để sử dụng được Yii::t('translation', 'List')
     */
    public function init() {
        $this->aControllers = ActionsUsers::GetAliasControllers();
        return parent::init();
    }
    
    /**
     * @Author: bb - recopy ANH DUNG May 12, 2014
     * @Todo: phân quyền cho group 
     */    
    public function actionGroup($id)
    {
        if(in_array($id, Roles::$aRoleRestrict))
                $this->redirect (Yii::app()->createAbsoluteUrl('admin/roles'));
        $this->pageTitle = Yii::app()->params['title'].' - Group Privilege';
        $mGroup = Roles::model()->findByPk($id);
        try
        {
            if(isset($_POST['submit']))
            {
                foreach ($this->aControllers as $keyController => $aController) 
                {
                    $mController = Controllers::getByName($keyController);
                    if($mController)
                    {                        
                        $mController->addGroupRoles($this->postArrayCheckBoxToAllowDenyValue($keyController), $id);
                        $this->setNotifyMessage(NotificationType::Success, 'Successful Update');
                    }                    
                }
                $this->refresh();
            }
            $this->render('group',array(
                    'id'=>$id,
                    'mGroup'=>$mGroup,
                    'actions' => $this->listActionsCanAccess,
            ));
        }
        catch (Exception $exc)
        {
            Yii::log("Uid: " .Yii::app()->user->id. " Exception ".  $exc->getMessage(), 'error');
            $code = 404;
            if(isset($exc->statusCode))
                $code=$exc->statusCode;
            if($exc->getCode())
                $code=$exc->getCode();
            throw new CHttpException($code, $exc->getMessage());
        }
    }
    
    /**
     * @Author: bb - recopy ANH DUNG May 12, 2014
     */
    public function postArrayCheckBoxToAllowDenyValue($keyController)
    {
        $aResult = array();
        $aControllers = $this->aControllers;
        foreach($aControllers[$keyController]['actions'] as $keyAction=>$aAction){
            if(isset($_POST[$keyController][$keyAction]))
            {
                $aResult[$keyAction] = 'allow';
                foreach($aAction['childActions'] as $childAction)
                {
                    $aResult[$childAction] = 'allow';
                }
            }
            else
            {
                $aResult[$keyAction] = 'deny';
                foreach($aAction['childActions'] as $childAction)
                {
                    $aResult[$childAction] = 'deny';
                }
            }
        }
        
        return $aResult;
    }
    
    
    /**
     * @Author: ANH DUNG Dec 19, 2014
     * @Todo: reset all custom role of one user
     */
    public function actionResetRoleCustomOfUser($id)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('user_id', $id);
        ActionsUsers::model()->deleteAll($criteria);
        $this->redirect(array('user','id'=>$id));
    }
    
    /** /bb**
     * @Author: ANH DUNG Dec 19, 2014
     * @Todo: thiet lap quyen trong user se uu tien cao nhat. user deny hoac allow thi se k phu thuoc group.
     */
    public function actionUser($id)
    {            
        try
        {
            $mUser = Users::model()->findByPk($id);
            $this->pageTitle = 'Setting Privilege Users - '.$mUser->first_name;
            if(is_null($mUser))
                throw new Exception('Setting Privilege user exists');
            if(isset($_POST['submit']))
            {
                foreach ($this->aControllers as $keyController => $aController) 
                {
                    $mController = Controllers::getByName($keyController);
                    if($mController)
                    {
                        $mController->addUserRoles($this->postArrayCheckBoxToAllowDenyValue($keyController), $id);
                        $this->setNotifyMessage(NotificationType::Success, 'Successful Update');
                    }
                }
                $this->refresh();
            }
            $this->render('user',array(
                    'id'=>$id,
                    'mUser'=>$mUser,
                    'actions' => $this->listActionsCanAccess,
            ));
        }
        catch (Exception $exc)
        {
            Yii::log("Uid: " .Yii::app()->user->id. " Exception ".  $exc->getMessage(), 'error');
            $code = 404;
            if(isset($exc->statusCode))
                $code=$exc->statusCode;
            if($exc->getCode())
                $code=$exc->getCode();
            throw new CHttpException($code, $exc->getMessage());
        }
    }    
    
}
