<?php

/**
 * @author Haidt <haidt3004@gmail.com>
 * @version $Id: HUploadImage.php  2015-04-20 23:00:22
 * @since 1.1
 */
class HUploadImage extends CWidget {

	const TYPE_UPDATE = 'update';
	const TYPE_VIEW = 'view';
	
	//Path to assets folder 
	public $assets;
	//action to controller
	public $action;
	//model
	public $model;
	// array attributes for render of view
	public $attributes = array();
	//saved image will be render by related
	public $related = false;
	//parent form id if or self form id 
	public $form_id;
	//unique id for 
	public $id;
	//can sortable
	public $isSortable = false;
	//sort field
	public $sortField = '';
	//allow type of image
	public $allowType;
	//allow max size of image
	public $maxSize;
	//recommended size
	public $recommendedSize;
	//default left column 
	public $col1 = 'col-sm-1';
	//default right column
	public $col2 = 'col-sm-5';
	//default for render image
	public $col3 = 'col-sm-5';
	//set attribute render caption
	public $title;
	//set attribute render description
	public $description;
	//default render edit form
	public $type = self::TYPE_UPDATE;
	//allow select multi files : true is used
	public $multiSelect = false;
	//parent field 
	public $parentField = '';
	
	//demo for edit form
	
//	$this->widget('HUploadImage', array(
//			'model' => $model,
//			'form_id' => 'parent-form',
//			'id' => 'wrap-form-image',
//			'allowType' => $model->allowImageType,
//			'maxSize' => $model->maxImageFileSize,
//			'recommendedSize' => $model->imageSize,
//			'attributes' => array( 
//				'file_name' => array('type' => 'file_field', 'value' => ''),
//				'parent_field' => array('type' => 'hidden_field', 'value' => $model->id),
//				'some_attribute_id' => array('type' => 'hidden_field', 'value' => $model->id),
//			),
//			'parentField' => 'parent_field', 
//			'related' => isset($model->rRelated) ? $model->rRelated : false,
//			'action' => Yii::app()->createAbsoluteUrl('admin/ajax/hupload')
//		));

//type : file_field, hidden_field, text_area

	//	//View area
	//attribute for render image - required for view
	public $attribute;
	//alias size for image
	public $viewSize;
	
	//demo for view
	
//	$this->widget('HUploadImage', array(
//		'attribute' => 'file_name', 
//		'related' => isset($model->rProgressBannerSlider) ? $model->rProgressBannerSlider : false,
//		'viewSize' => 'thumb',
//		'type' => 'view'
//	));
	
	

	public function init() {
		//set assets path
		Yii::setPathOfAlias('HUploadImage', realpath(dirname(__FILE__)));
		//get assets path
		$this->getPathAssets();
		//register css, js file
		$this->registerClientScript();
		return parent::init();
	}

	public function run() {
		if ($this->type == self::TYPE_UPDATE) {
			$this->renderUpdate();
		}else{
			$this->renderView();
		}
	}
	
	//register css, js
	protected function registerClientScript() {
		$cs = Yii::app()->clientScript;
		$cs->registerCssFile($this->assets . '/css/huploadimage.css');
		$cs->registerScriptFile($this->assets . '/js/huploadimage.js');
	}
	
	//get assets path
	protected function getPathAssets() {
		$this->assets = Yii::app()->assetManager->publish(Yii::getPathOfAlias('HUploadImage.assets'), false, -1, YII_DEBUG);
	}

	/**
	 * Author : Haidt
	 * @return string
	 * Description: render form upload image
	 */
	public function renderUpdate() {

		$this->render('view', array(
			'model' => $this->model,
			'hupload' => $this
		));
	}
	
	/**
	 * Author : Haidt
	 * @return string
	 * Description: render view image
	 */
	public function renderView() {
		$this->render('_item_view', array(
			'hupload' => $this,
		));
	}
}
