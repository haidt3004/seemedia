<?php

/*
 * Xuan Tinh
 * TODO: send mail reminde for merchant before day set in system config
 */

class ListingExpiredCommand extends CConsoleCommand {

	public function run($arg) {
		$this->doJob();
	}

	protected function doJob() {
		$datas = Listings::model()->getListExpired();
                foreach ($datas as $model) {
                    $model->current_status = Listings::CURRENT_STATUS_EXPIRED;
                    $model->number_day_use = 0;
                    $model->pause_date = NULL;
                    $model->resume_date = NULL;
                    $model->save(false);
                    SendEmail::sendMailExpiredToMerchant($model);
                }
	}
}
