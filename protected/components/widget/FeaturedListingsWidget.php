<?php
/**
 * @Author Haidt <haidt3004@gmail.com>
 * @copyright 2015 Verz Design 	 	 
 * @Todo: left side feature listing widget
 */
class FeaturedListingsWidget extends CWidget {
    
    public function run() {
       $this->renderFeaturedListings();
    }
	
	public function renderFeaturedListings(){
		$this->render('side/featured_listings');
	}
}