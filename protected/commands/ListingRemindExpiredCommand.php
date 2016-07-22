<?php

/*
 * Xuan Tinh
 * TODO: send mail reminde for merchant before day set in system config
 */

class ListingRemindExpiredCommand extends CConsoleCommand {

	public function run($arg) {
		$this->doJob();
	}

	protected function doJob() {
		$datas = Listings::model()->getListBeforExpired();
                $beforeDateSent = Yii::app()->setting->getItem('listingRemindBeforeExpiredDay');
                foreach ($datas as $model) {
                    SendEmail::sendMailRemindExpiredToMerchant($model, $beforeDateSent);
                }
	}
}
