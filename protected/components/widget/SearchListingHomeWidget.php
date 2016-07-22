<?php

/**
 * @Author Xuan Tinh
 * @copyright 2015 Verz Design 	 	 
 * @Todo: left side search listing home widget
 */
class SearchListingHomeWidget extends CWidget {

        public $category_id;
	public $audience;
	public $specialty;
	public function run() {
		$this->renderSearchListings();
	}

	public function renderSearchListings() {
		$model = new Listings('advanceSearch');
                $model->category_id = $this->category_id;
		$model->audience = $this->audience;
		$model->specialty = $this->specialty;
		$this->render('side/search_listing_home', array('model' => $model));
	}

}
