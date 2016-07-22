<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class _BaseController extends CController
{
    protected $listActionsCanAccess;
    protected $accessRules = array();
    public $pageTitleCus = '';
    public $_metaKeyword;
    public $_metaDescription;

    /**
     * @Author: ANH DUNG Dec 19, 2014
     * @Todo: get array $accessRules action allow or deny
     * @Param: $controller controller_name
     * @Return: $accessRules
     */
    protected function controllerRules($controller, $module=null)
    {
        $accessArray = array();
        $controller_model = Controllers::model()->find("controller_name like '$controller' and module_name like '$module'");
        if(!$controller_model)
            return array(array('deny'));
        
        //user roles, ưu tiên cho role custom của user
        $criteria = new CDbCriteria();
        $criteria->compare("t.user_id", Yii::app()->user->id);
        $criteria->compare("t.controller_id", $controller_model->id);
        $criteria->compare("t.can_access", 'allow');
        $actions_user = ActionsUsers::model()->findAll($criteria);// thực tế chỉ find ra 1. Chỉ có 2 dòng allow và deny
        if($actions_user)
        {
            foreach($actions_user as $key => $user_action)
            {
                if($user_action->user){
                    $array_action = array_map('trim',explode(",",trim($user_action->actions)));
                    $accessArray[] = array($user_action->can_access,
                            'actions'=>$array_action,
                            // 'users'=>array('@'), // có thể dùng cái này, vì cái bên dưới dư�?ng như ko có ý nghĩa
                            'users'=>array($user_action->user->username),
                        );
                }else
                   $user_action->delete(); // delete data not valid 										
            }
        }else{
                
            //menu roles  
            $criteria = new CDbCriteria();
            $criteria->compare("t.roles_id", Yii::app()->user->role_id);
            $criteria->compare("t.controller_id", $controller_model->id);

            if( ($controller =='controllers' || $controller =='backmenus')){
                if(Yii::app()->user->role_id  != ROLE_MANAGER){
                    $criteria->compare("t.role_website_id", ROLE_WEBSITE_ID);
                }
            }else{
                $criteria->compare("t.role_website_id", ROLE_WEBSITE_ID);
            }

            $criteria->compare("t.can_access", 'allow');
            $actions_role = ActionsRoles::model()->findAll($criteria);  // thực tế chỉ find ra 1. Chỉ có 2 dòng allow và deny
            if($actions_role)
            {
                foreach($actions_role as $key => $action_role)
                {
                    if($action_role->roles_id==Yii::app()->user->role_id){ // ANH DUNG ADD 10-17-2013
                        $array_action = array_map('trim',explode(",",trim($action_role->actions)));
                        $accessArray[] = array('allow',
                                                'actions'=>$array_action,
                                                'users'=>array('@'),
                                                'expression'=>'Yii::app()->user->role_id == '.$action_role->roles_id
                                            );                
                    }
                }
            }
        }
        
        $accessArray[] = array('deny');
        // need debug to add role here
        return $accessArray;
    }    
    
    /**
     * @Author: ANH DUNG Dec 19, 2014
     */
    protected function setActionsAccess()
    {
        if(isset(Yii::app()->user->role_id))
            $this->listActionsCanAccess = ControllerActionsName::getListActionsCanAccess($this->accessRules(), Yii::app()->user->role_id);
    } 
    
    

    public function init() {

        if(isset($_POST['lang']) && $_POST['lang'] != '') {
            Yii::app()->session['language'] =  $_POST['lang'];
        } 

        if(isset(Yii::app()->session['language'])){
            Yii::app()->language =Yii::app()->session['language'];
        } else {
            Yii::app()->language = 'en';
        }

        $this->setActionsAccess();
        parent::init();
    }


    /**
     * @return array action filters
     * This is user for access rule
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }




    public function beforeRender($view) {
        parent::beforeRender($view);
        if(isset (Yii::app()->user->id)){
            $mUser = Users::model()->findByPk(Yii::app()->user->id);
            if(is_null($mUser) || $mUser->status==STATUS_INACTIVE){
                Yii::app()->user->logout();
                Yii::app()->controller->redirect(Yii::app()->createAbsoluteUrl('site/login'));
            }
        }
        $this->rewriteForSeo();
        


        return true;
    }

    public function getCurrentUrlWithoutParam() {
        $uriWithoutParam = $_SERVER['REQUEST_URI'];
        if (strpos($uriWithoutParam, '?') != false)
            $uriWithoutParam = substr($uriWithoutParam, 0, strpos($uriWithoutParam, '?'));
        return 'http://' . $_SERVER['SERVER_NAME'] . $uriWithoutParam;
    }

    public function rewriteForSeo() {
        $titlePage = '';
        $meta_description = '';
        $meta_keywords = '';
        $action = Yii::app()->controller->action->id;
        $controller = Yii::app()->controller->id;
        //set meta_description & meta_keywords for each page of Page
        if ($controller == "pages" && isset($_GET['slug'])) {
            $page = PageContents::findBySlug($_GET['slug']);
            if (!is_null($page))
                $titlePage = $page->title_tag;

            $meta_description = trim($page->meta_keywords);
            $meta_keywords = trim($page->meta_desc);
        }

        $currentURL = $this->getCurrentUrlWithoutParam();
        $currentURL = trim($currentURL, '/');
        $seoObj = Seos::model()->find('url = \'' . str_replace("'", "''", $currentURL) . '\'');
        if ($seoObj) {
            $titlePage = $seoObj->title_tag;
            $meta_description = $seoObj->meta_desc;
            $meta_keywords = $seoObj->meta_keyword;
        }

        $titlePage = trim($titlePage);

        if (!empty($titlePage)) {
            $this->setPageTitle($titlePage);
        }
        if (!empty($meta_description)) {
            $this->setMetaDescription($meta_description);
        }
        if (!empty($meta_keywords)) {
            $this->setMetaKeywords($meta_keywords);
        }
    }

    public function getMetaKeywords() {
        if (!empty($this->_metaKeyword)) {
            return $this->_metaKeyword;
        } else {
            $setting = Yii::app()->setting;
            $default = $setting->getItem('metaDescription');
            return $default;
        }
    }

    public function setMetaKeywords($value) {
        $this->_metaKeyword = $value;
    }

    public function getMetaDescription() {
        if (!empty($this->_metaDescription)) {
            return $this->_metaDescription;
        } else {
            $setting = Yii::app()->setting;
            $default = $setting->getItem('metaKeywords');
            return $default;
        }
    }

    public function setMetaDescription($value) {
        $this->_metaDescription = $value;
    }



    /*
      * Austin added date 9/7/2014
      * Show nofify message if it has
      */
    public function renderNotifyMessage()
    {
        if(Yii::app()->user->hasFlash('beFormAction'))
        {
            echo '<div class="alert alert-success" role="alert">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'
                . Yii::app()->user->getFlash('beFormAction') .
                '</div>';
        }

        if(Yii::app()->user->hasFlash('beFormError'))
        {
            echo '<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'
                . Yii::app()->user->getFlash('beFormError') .
                '</div>';
        }

    }

    /*
      * Austin added date 9/7/2014
      * Set notify message
      * type will get from enum NotificationType
      */
    public function setNotifyMessage($type, $message)
    {
        if ($type == NotificationType::Error)
            Yii::app()->user->setFlash('beFormError', $message);
        elseif($type == NotificationType::Success)
            Yii::app()->user->setFlash('beFormAction', $message);
    }



}

abstract class NotificationType
{
    const Error = "beFormError";
    const Success = "beFormAction";
    // etc.
}

?>