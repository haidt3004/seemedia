<?php

class BannerWidget extends CWidget {

	public $layout; // layout of banner as you defined
	public $group_banner_id = null;
	public $current_link = null;

	public function run() {
		$this->getBanners();
	}

	public function getBanners() {
		// get group banner
		if ($this->group_banner_id != null && $this->current_link == null) {
			$models = BannerItem::model()->getAllBanner($this->group_banner_id);
		} else {
			$group = GroupBanner::getActiveBanner($this->current_link);
			if ($group) {
				$models = BannerItem::model()->getAllBanner($group->id);
			} else {
				$models = null;
			}
		}


		if ($models != null) {
			$this->render("banners/" . $this->layout, array(
				'models' => $models,
			));
		}
	}

}
