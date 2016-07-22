<?php

class PagesController extends FrontController {

    public $layout = '//layouts/pages';
    public $isStaticPage = false;

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
    
    public function accessRules()
    {
        return array(
            array('allow',
             'actions' => array('captcha'),
             'users' => array('*'),
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

    public function actionIndex($slug) {
        $page = PageContents::findBySlug($slug);
        
        $this->pageTitle = $page->name . ' - ' . Yii::app()->params['defaultPageTitle'];
        if ($page->title_tag != '')
            $this->pageTitle = $page->title_tag . ' - ' . Yii::app()->params['defaultPageTitle'];
        if (!empty($page->meta_keywords))
            Yii::app()->clientScript->registerMetaTag($page->meta_keywords, 'keywords');
        if (!empty($page->meta_desc))
            Yii::app()->clientScript->registerMetaTag($page->meta_desc, 'description');

        $section = PageContentSessions::findAllByContentId($page->id);
        $faqs = PageContentFaqs::findAllByContentId($page->id);
        // Booking tour
        $model = new BookingTours();
        $model->scenario = "createFe";
        //ValidateHelper::ajaxValidation($model, 'booking-tour-form');
        $error = 0;
        if (isset($_POST['BookingTours'])) {
            $model->attributes = $_POST['BookingTours'];
            
            $secret = Yii::app()->params['goCapcha']['secret'];            
            $recaptcha = new ReCaptcha($secret);
            $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR'], $secret);            
            if ($resp->isSuccess()) {
                $model->google_capcha = '123';
            } else {
                $model->google_capcha = '';
            } 
            
            if ($model->validate()) {
                $model->date = DateHelper::toDbDateFormat($model->date);
                if ($model->save(false)) {
                    // Send mail for admin and user
                    SendEmail::NotificationBookingTourToAdmin($model);
                    SendEmail::NotificationBookingTourToUser($model);
                    Yii::app()->user->setFlash('success', "Booking tour successfully!.");
                    $model = new BookingTours();
                }
            } else {
                $error = 1;
            }
        }
        $this->render('index', array(
            'section' => $section,
            'faqs' => $faqs,
            'slug' => $slug,
            'model' => $model,
            'error' => $error
        ));
    }

}
