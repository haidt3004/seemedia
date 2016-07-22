<?php
/**
 * @Author Haidt <haidt3004@gmail.com>
 * @copyright 2015 Verz Design 	 	 
 * @Todo: left side archive widget for Article and Video Gallery
 */
class LeftSideArchiveWidget extends CWidget {

	public $year;
	public $month;
	public $model;
	public $myController;
	public function run() {
		$this->renderArticles();
	}

	public function renderArticles() {
		if(!empty($this->model)){
			$model = new $this->model;
		}else{
			throw new CHttpException(404, 'The model does not exist.');
		}
		
		if($this->model == "VideoGallery"){
			$this->myController = "video";
		}else{
			$this->myController = "article";
		}
		
		if(!$this->year){
			$this->year = date('Y');
		}
		
		$this->render('side/archive', array(
			'model' => $model,
			'year' => $this->year,
			'month' => $this->month,
			'myController' => $this->myController
		));
	}

}
