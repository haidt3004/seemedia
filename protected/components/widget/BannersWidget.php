<?php

/**
 * @Author Haidt <haidt3004@gmail.com>
 * @copyright 2015 Verz Design 	 	 
 * @Todo: banners
 */
class BannersWidget extends CWidget {

	public $type;
	public $position;

	public function run() {
		$this->getBanners();
	}

	public function getBanners() {
		$modelName = "";
		$template = "";
		if ($this->type == HomeBanners::HOME_BANNER_TYPE) {
			$modelName = 'HomeBanners';
			$template = "home_banner";
		} else if ($this->type == LeaderBoard::HOME_BANNER_TYPE) {
			$modelName = 'LeaderBoard';
			if ($this->position == $modelName::POSITION_SMALL) {
				$template = "leader_board_small";
			} else {
				$template = "leader_board_large";
			}
		} else if ($this->type == SkyScrapper::HOME_BANNER_TYPE) {
			$modelName = 'SkyScrapper';
			$template = "sky_scrapper";
		} else if ($this->type == FeatureBanner::HOME_BANNER_TYPE) {
			$modelName = 'FeatureBanner';
			if ($this->position == $modelName::POSITION_HOME_PAGE) {
				$template = "feature_banner_home";
			} else {
				$template = "feature_banner_subpage";
			}
		}

		if (!empty($modelName)) {
			$models = Banners::model()->getActiveBanners($modelName, $this->position);
		}

		if (isset($models)) {
			$this->render("banners/" . $template, array('models' => $models, 'modelName' => $modelName));
		} else {
			throw new CHttpException(404, 'Model not found.');
		}
	}

}

?>