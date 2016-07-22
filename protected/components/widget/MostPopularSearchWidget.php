<?php

/**
 * @Author Xuan Tinh
 * @copyright 2015 Verz Design 	 	 
 * @Todo: left side search listing home widget
 */
class MostPopularSearchWidget extends CWidget {

	public function run() {
                $list_most_search = PopularSearch::getListMostSearch();
		$this->render('side/most_popular_search', array('list_most_search' => $list_most_search));
	}
}
