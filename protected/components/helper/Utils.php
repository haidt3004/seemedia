<?php

/**
 * @Author Haidt <haidt3004@gmail.com>
 * @copyright 2015 Verz Design 	 	 
 * @Todo: some custom function for you
 */
class Utils {

	/**
	 *
	 * Dump for test
	 * @param string or array
	 */
	public static function dump() {
		$args = func_get_args();
		foreach ($args as $k => $arg) {
			echo '<fieldset class="debug">';
			echo '<legend>' . ($k + 1) . '</legend>';
			CVarDumper::dump($arg, 10, true);
			echo '</fieldset>';
		}
	}

	/**
	 * @Author Haidt <haidt3004@gmail.com>
	 * @copyright 2015 Verz Design 	 	 
	 * @param string $modelName
	 * @param id $parent_id
	 * @param string $fieldName
	 * @Todo: delete all record of model by parent id
	 */
	public static function deleteAllRecordOfModel($modelName, $parent_id, $fieldName) {
		$criteria = new CDbCriteria();
		$criteria->compare($fieldName, $parent_id);
		$models = $modelName::model()->findAll($criteria);
		foreach ($models as $model) {
			$model->delete();
		}
	}
	
	/**
	 * @Author Haidt <haidt3004@gmail.com>
	 * @copyright 2015 Verz Design 	 	 
	 * @param string $modelName
	 * @param array $condition array('parent_id' => 'fieldName')
	 * @Todo: delete all record of model by parent id
	 */
	public static function deleteAllRecordOfModelAdvance($modelName, $condition) {
		$criteria = new CDbCriteria();
		foreach($condition as $fieldName => $id){
			$criteria->compare($fieldName, $id);
		}
		$models = $modelName::model()->findAll($criteria);
		foreach ($models as $model) {
			$model->delete();
		}
	}
	
	/**
	 * @Author Haidt <haidt3004@gmail.com>
	 * @copyright 2015 Verz Design 	 	
	 * @param double $price 
	 * @param int $location
	 * @return string
	 * @Todo: get display price
	 */
	public static function getDisplayPrice($price,$location) {
		return number_format($price,2). ' ' . Listings::$ARR_CURRENCY[$location];
	}
	
	/**
	 * @Author Haidt <haidt3004@gmail.com>
	 * @copyright 2015 Verz Design 	 	
	 * @param int $location
	 * @return string
	 * @Todo: get currency code
	 */
	public static function getCurrencyCode($location) {
		return Listings::$ARR_CURRENCY[$location];
	}
        
        // xuan tinh: subtract two date
        public static function getNumberSubtractTwoDate($date_form, $data_to) {
            $datetime1 = strtotime(date('Y-m-d', strtotime($date_form)));
            $datetime2 = strtotime(date('Y-m-d', strtotime($data_to)));
            $secs = $datetime2 - $datetime1;// == <seconds between the two times>
            $days = $secs / 86400;
            if ($days >= 0) {
                return $days;
            } else {
                return 0;
            }
        }

}
