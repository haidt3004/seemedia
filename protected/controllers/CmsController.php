<?php

class CmsController extends FrontController
{
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

//    public $layout='//layouts/cms';
	 /**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
        public function init() {
            return parent::init();
        }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        $error=Yii::app()->errorHandler->error;

            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);

    }
	
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */

	public function actionIndex($slug){
        try {
            // $model = Page::model()->find("slug='".$_GET['slug']."' and status=1 and role_website_id=" . ROLE_WEBSITE_ID);
            $model = Page::model()->findByAttributes(array('slug'=>$_GET['slug'],'status'=>1,'role_website_id'=>ROLE_WEBSITE_ID));

            if(empty($model)) $this->redirect(array('error'));


            $model->getDataTranslate();

           
            if ($this->pageTitleCus == '')
                $this->pageTitle = $model->title ;//. ' - ' . Yii::app()->params['defaultPageTitle'];

            if (substr($model->slug, 0, 6) == 'eleave') {
                $this->isStaticPage = true;
                $this->render('page_eleave',array(
                    'model'=>$model,
                ));
            } else {
                $this->render('page',array(
                    'model'=>$model,
                ));
            }

        } catch (Exception $exc) {
            throw new Exception($exc->getMessage());
        }
	}
}