<?php

/**
 * @Author Haidt <haidt3004@gmail.com>
 * @copyright 2015 Verz Design 	 	 
 * @Todo: left side search listing widget
 */
class SearchListingsWidget extends CWidget {
	
	public $category_id;
	public $audience;
	public $specialty;
	public $tags;
	public $location = LOCATION_SG;
	public $region;
	public $district;
	public $keyword;
	
	public function run() {
		$this->renderSearchListings();
	}

	public function renderSearchListings() {
		$model = new Listings('advanceSearch');
		$model->category_id = $this->category_id;
		$model->audience = $this->audience;
		$model->specialty = $this->specialty;
		$model->tags = $this->tags;
		$model->location = $this->location;
		$model->region = $this->region;
		$model->district = $this->district;
		$model->keyword = $this->keyword;
		$this->render('side/search_listings', array('model' => $model));
	}

}
