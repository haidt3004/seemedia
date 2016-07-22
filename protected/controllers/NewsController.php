<?php

class NewsController extends FrontController {
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

			$models = News::model()->findAll(array(
				'order'=>'created_date DESC',
				'limit'=>4,
			));

			$criteria=new CDbCriteria;
			$criteria->compare('status', STATUS_ACTIVE);
			$criteria->order = 'modified_date DESC, created_date DESC';
			$dataProvider =  new CActiveDataProvider('News', array(
				'criteria'=>$criteria,
				'pagination' => array(
					'pageSize' => 4,
				),
			));

			//$dataProvider = News::model()->getAllGrid();

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
			$model = News::model()->getDetailBySlug($slug);
			if (empty($model))
				$this->redirect(array('error'));
			$this->pageTitle = $model->title;

			$this->render('detail', array(
				'model' => $model
			));
		} catch (Exception $exc) {
			throw new Exception($exc->getMessage());
		}
	}

	public function actionArchive() {
		try {
			$this->isStaticPage = true;
			$this->pageTitle = 'Announcement' . ' - ' . Yii::app()->params['defaultPageTitle'];

			$models = News::model()->findAll(array(
				'order'=>'created_date DESC',
				'limit'=>4,
			));

			$number = cal_days_in_month(CAL_GREGORIAN, $_GET['month'], $_GET['year']);
			$start_date = date($_GET['year'] . '-' . $_GET['month']. '-' . '01');
			$end_date = date($_GET['year'] . '-' . $_GET['month']. '-' . $number);

			$criteria=new CDbCriteria;
			$criteria->compare('status', STATUS_ACTIVE);
//			$criteria->addCondition('created_date <='. $end_date . ' AND created_date >= ' . $star_date . '');
			$criteria->addCondition("created_date <= '$end_date' AND created_date >= '$start_date'");
			$criteria->order = 'modified_date DESC, created_date DESC';
			$dataProvider =  new CActiveDataProvider('News', array(
				'criteria'=>$criteria,
				'pagination' => array(
					'pageSize' => 4,
				),
			));

			//$dataProvider = News::model()->getAllGrid();

			$this->render('archive', array(
				'models' => $models,
				'dataProvider' => $dataProvider,
				'start_date' => $start_date,
			));
		} catch (Exception $exc) {
			throw new Exception($exc->getMessage());
		}
	}

}
