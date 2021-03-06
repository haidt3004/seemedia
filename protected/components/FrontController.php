<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class FrontController extends _BaseController {

	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout = '//layouts/site';

	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs = array();
	public $pageHeader;
	public static $activedPage;
	public $searchKey;
	public $pageIndexFollow = false;

	public function init() {
		// register class paths for extension captcha extended
		Yii::$classMap = array_merge(Yii::$classMap, array(
			'CaptchaExtendedAction' => Yii::getPathOfAlias('ext.captchaExtended') . DIRECTORY_SEPARATOR . 'CaptchaExtendedAction.php',
			'CaptchaExtendedValidator' => Yii::getPathOfAlias('ext.captchaExtended') . DIRECTORY_SEPARATOR . 'CaptchaExtendedValidator.php'
		));
		return parent::init();
	}

	public function gotoPage($page_id) {
		$pageM = Page::model()->getSlugById($page_id);
		if (!empty($pageM)) {
			$this->redirect(Yii::app()->createAbsoluteUrl('cms/index', array('slug' => $pageM->slug)));
		} else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

}

?>