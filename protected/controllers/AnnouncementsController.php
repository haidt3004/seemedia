<?php

class AnnouncementsController extends FrontController {
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

    public function init() {
        return parent::init();
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        $error = Yii::app()->errorHandler->error;

        if (Yii::app()->request->isAjaxRequest)
            echo $error['message'];
        else
            $this->render('../cms/error', $error);
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        try {
            $this->isStaticPage = true;
            $this->pageTitle = 'Announcement' . ' - ' . Yii::app()->params['defaultPageTitle'];

            $criteriaAnnouncement=new CDbCriteria;
            $criteriaAnnouncement->compare('status', STATUS_ACTIVE);
            // gioi han search theo tung website
            $criteriaAnnouncement->compare('role_website_id', ROLE_WEBSITE_ID, true);
            $criteriaAnnouncement->order = 'created_date DESC';
            $criteriaAnnouncement->limit = 4;

            $models = Announcement::model()->findAll($criteriaAnnouncement);

            $criteria=new CDbCriteria;
            $criteria->compare('status', STATUS_ACTIVE);
            // gioi han search theo tung website
            $criteria->compare('role_website_id', ROLE_WEBSITE_ID, true);
            $criteria->order = 'modified_date DESC, created_date DESC';
            $dataProvider =  new CActiveDataProvider('Announcement', array(
                'criteria'=>$criteria,
                'pagination' => array(
                    'pageSize' => 5,
                ),
            ));

            //$dataProvider = Announcement::model()->getAllGrid();

            $this->render('index', array(
                'models' => $models,
                'dataProvider' => $dataProvider
            ));
        } catch (Exception $exc) {
            throw new Exception($exc->getMessage());
        }
    }

    public function actionDetail($slug) {
        try {
            $this->isStaticPage = true;
            //clean bad script
            $slug = StringHelper::removeScriptTag($slug);

            $criteria = new CDbCriteria;
            $criteria->compare('t.status', 1);
            // gioi han search theo tung website
            $criteria->compare('t.role_website_id', ROLE_WEBSITE_ID);
            $criteria->compare('t.slug', $slug);
            $model = Announcement::model()->find($criteria);
            if (empty($model))
                $this->redirect(array('error'));
            $this->pageTitle = $model->title;
            
            $this->render('detail', array(
                'model' => $model,
            ));

        } catch (Exception $exc) {
            throw new Exception($exc->getMessage());
        }
    }

    public function actionArchive() {
        try {
            $this->isStaticPage = true;
            $this->pageTitle = 'Announcement' . ' - ' . Yii::app()->params['defaultPageTitle'];

            $criteriaAnnouncement=new CDbCriteria;
            $criteriaAnnouncement->compare('status', STATUS_ACTIVE);
            // gioi han search theo tung website
            $criteriaAnnouncement->compare('role_website_id', ROLE_WEBSITE_ID, true);
            $criteriaAnnouncement->order = 'created_date DESC';
            $criteriaAnnouncement->limit = 4;

            $models = Announcement::model()->findAll($criteriaAnnouncement);


//            $number = cal_days_in_month(CAL_GREGORIAN, $_GET['month'], $_GET['year']) + 1;
            $start_date = date('Y-m-d');
            $end_date = date('Y-m-d');
            $active_month = false;

            if (isset($_GET['year']) && isset($_GET['month'])) {
                $start_date = date($_GET['year'] . '-' . $_GET['month']. '-' . '01');
                $end_date = date('Y-m-d', strtotime('+1 month', strtotime($_GET['year'] . '-' . $_GET['month']. '-' . '01')));
                $active_month = true;
            } elseif (isset($_GET['year'])) {
                $start_date = date($_GET['year'] . '-01-01');
                $end_date = date('Y-m-d', strtotime('+1 month', strtotime($_GET['year'] . '-12-01')));
            } else {
                $this->redirect(Yii::app()->createAbsoluteUrl('announcements'));
            }

            $criteria=new CDbCriteria;
            $criteria->compare('status', STATUS_ACTIVE);
            // gioi han search theo tung website
            $criteria->compare('role_website_id', ROLE_WEBSITE_ID, true);
            $criteria->addCondition("created_date < '$end_date' AND created_date >= '$start_date'");
            $criteria->order = 'modified_date DESC, created_date DESC';
            $dataProvider =  new CActiveDataProvider('Announcement', array(
                'criteria'=>$criteria,
                'pagination' => array(
                    'pageSize' => 5,
                ),
            ));

            //$dataProvider = Announcement::model()->getAllGrid();

            $this->render('archive', array(
                'models' => $models,
                'dataProvider' => $dataProvider,
                'start_date' => $start_date,
                'active_month' => $active_month
            ));
        } catch (Exception $exc) {
            throw new Exception($exc->getMessage());
        }
    }

}
