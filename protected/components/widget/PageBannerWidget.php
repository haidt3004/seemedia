<?php

class PageBannerWidget extends CWidget {

    public $apply_for_page;

    public function run() {
        $this->getPageBanners();
    }
    public function getPageBanners() {
        $init = new Ads();
        $check_action ='';
        if($this->apply_for_page=='site/contactus' )
        {
            $check_action = 'contactus';
        }
        else{
            $check_action ='';
        }
        $models = $init->getAdsBanners($this->apply_for_page);
        $this->render("banner/page_banners", array(
            'models' => $models,
            'check_action'=>$check_action,
            'slug_page' => $this->apply_for_page,
        ));
    }
}

?>