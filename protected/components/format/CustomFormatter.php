<?php
class CustomFormatter extends BaseFormatter
{
	public $optionYesNo = array(TYPE_YES => 'Yes', TYPE_NO => 'No');
	public $optionActive = array(STATUS_ACTIVE => 'Active', STATUS_INACTIVE => 'Inactive');
	public $optionShown = array(STATUS_ACTIVE => 'Shown', STATUS_INACTIVE => 'Hidden');
	public $optionPublish = array(STATUS_ACTIVE => 'Publish', STATUS_INACTIVE => 'Un-Publish');
	public $optionGender = array('1' => 'Male', '0' => 'Female', '2' => 'Unspecified');
	
	
	/**
	 * @Author Haidt <haidt3004@gmail.com>
	 * @copyright 2015 Verz Design 	 	 
	 * @param int $value
	 * @return string
	 * @Todo: get status active name
	 */
	
	public function formatStatusActive($value){
		return isset($this->optionActive[$value]) ? $this->optionActive[$value] : "";
	}
	
	/**
	 * @Author Haidt <haidt3004@gmail.com>
	 * @copyright 2015 Verz Design 	 	 
	 * @param int $value
	 * @return string
	 * @Todo: get status shown name
	 */
	
	public function formatStatusShown($value){
		return isset($this->optionShown[$value]) ? $this->optionShown[$value] : "";
	}
	
	/**
	 * @Author Haidt <haidt3004@gmail.com>
	 * @copyright 2015 Verz Design 	 	 
	 * @param int $value
	 * @return string
	 * @Todo: get percent
	 */
	
	public function formatPercent($value){
		return $value .'%';
	}
	
	
	
}

