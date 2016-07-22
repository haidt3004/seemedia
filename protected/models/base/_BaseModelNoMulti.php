<?php

// class _BaseModelNoMulti extends CActiveRecord {
class _BaseModelNoMulti extends _MultilanguagesModel {

	public $optionYesNo = array(TYPE_YES => 'Yes', TYPE_NO => 'No');
	public $optionActive = array(STATUS_ACTIVE => 'Active', STATUS_INACTIVE => 'Inactive');
	public $optionShown = array(STATUS_ACTIVE => 'Shown', STATUS_INACTIVE => 'Hidden');
	public $optionPublish = array(STATUS_ACTIVE => 'Publish', STATUS_INACTIVE => 'Un-Publish');
	public $optionGender = array('1' => 'Male', '0' => 'Female', '2' => 'Unspecified');
	public $uploadImageFolder = 'upload/cms'; //remember remove ending slash
	public $defineImageSize = array();
	public $allowImageType = 'jpg, png, gif, jpeg';
	public $maxImageFileSize = 3145728; //3MB
	public $attributesBeforeSave = array(); //first time load model

	public function saveImage($fieldName, $diffModel = false) {
		$oldImage = $this->$fieldName;
		//to save image different model
		if ($diffModel == false) {
			$this->$fieldName = CUploadedFile::getInstance($this, $fieldName);
		}

		if (array_key_exists($fieldName, $this->attributesBeforeSave))
			$oldImage = $this->attributesBeforeSave[$fieldName];

		if (is_null($this->$fieldName)) {
			if (!empty($oldImage)) {
				$this->$fieldName = $oldImage;
				$this->update(array($fieldName));
			}
			return false;
		}

		if (!empty($oldImage))
			$this->deleteImages($fieldName, $oldImage);

		$ext = $this->$fieldName->getExtensionName();

		$fileName = time() . '_' . $this->id . '_' . StringHelper::stripUnicode($this->$fieldName->getName());
		$fileName = str_replace('.' . $ext, '.' . strtolower($ext), $fileName);
		//Haidt - clean file name - replace all whitespace by underscores.
		$fileName = $this->replaceSpaceByUnderscores(urldecode($fileName));
		$imageHelper = new ImageHelper();
		$imageHelper->createDirectoryByPath($this->uploadImageFolder . "/" . $this->id);
		$this->$fieldName->saveAs($this->uploadImageFolder . '/' . $this->id . '/' . $fileName);
		$this->$fieldName = $fileName;
		$this->update(array($fieldName));

		if (array_key_exists($fieldName, $this->defineImageSize) && is_array($this->defineImageSize[$fieldName])) {
			$this->resizeImage($fieldName, $this->uploadImageFolder . '/' . $this->id . '/');
		}
	}

	public function resizeImage($fieldName) {
		$sizeRefactory = array();
		foreach ($this->defineImageSize[$fieldName] as $item) {
			$sizeExplode = explode('x', $item['size']);
			$sizeRefactory[$item['alias']] = array('width' => $sizeExplode[0], 'height' => $sizeExplode[1]);
		}
		$ImageHelper = new ImageHelper();
		$ImageHelper->folder = $this->uploadImageFolder . '/' . $this->id;
		$ImageHelper->file = $this->$fieldName;
		$ImageHelper->thumbs = $sizeRefactory;
		$ImageHelper->createFullImage = true;
		$ImageHelper->createThumbs();
	}

	public function deleteImages($fieldName, $oldImage) {
		if (!empty($oldImage)) {
			ImageHelper::deleteFile($this->uploadImageFolder . '/' . $this->id . '/' . $oldImage);
			if (array_key_exists($fieldName, $this->defineImageSize) && is_array($this->defineImageSize[$fieldName])) {
				$imageSize = $this->defineImageSize[$fieldName];
				foreach ($imageSize as $item) {
					ImageHelper::deleteFile($this->uploadImageFolder . '/' . $this->id . '/' . $item['alias'] . '/' . $oldImage);
				}
			}
		}
	}

	public function removeImage($fieldName = array(), $deleteFolder = true) {
		$updateFiled = array();
		if (!empty($fieldName) && is_array($fieldName)) {
			foreach ($fieldName as $fieldItem) {
				ImageHelper::deleteFile($this->uploadImageFolder . '/' . $this->id . '/' . $this->$fieldItem);
				if (array_key_exists($fieldItem, $this->defineImageSize) && is_array($this->defineImageSize[$fieldItem])) {
					$imageSize = $this->defineImageSize[$fieldItem];
					foreach ($imageSize as $item) {
						ImageHelper::deleteFile($this->uploadImageFolder . '/' . $this->id . '/' . $item['alias'] . '/' . $this->$fieldItem);
						if ($deleteFolder == true && file_exists($this->uploadImageFolder . '/' . $this->id . '/' . $item['alias']))
							rmdir($this->uploadImageFolder . '/' . $this->id . '/' . $item['alias']);
					}
					$this->$fieldItem = '';
					$updateFiled[] = $fieldItem;
				}
			}
			if ($deleteFolder == true && file_exists($this->uploadImageFolder . '/' . $this->id))
				rmdir($this->uploadImageFolder . '/' . $this->id);
			$this->update($updateFiled);
		}
	}

	protected function beforeSave() {
		if (!$this->isNewRecord) {
			if (count($this->attributesBeforeSave) == 0) {
				$model = call_user_func(array(get_class($this), 'model'));
				$mBeforeSave = $model->findByPk($this->id);
				$this->attributesBeforeSave = $mBeforeSave->attributes;
			}
		}
		return parent::beforeSave();
	}

	public function tablePrefix() {
		return $tablePrefix = Yii::app()->db->tablePrefix;
	}

	protected function beforeDelete() {
		if (count($this->defineImageSize) > 0) {
			$this->removeImage(array_keys($this->defineImageSize), true);
		}
		return parent::beforeDelete();
	}

	public function saveImages() {
		foreach ($this->defineImageSize as $fieldName => $size) {
			$this->saveImage($fieldName);
		}
	}

	/**
	 * return array fieldName=>value. Usefull for send email. special param need to overrite or add to this array.
	 * $param = array(
	'{FULL_NAME}'   => $mUser->full_name,
	'{EMAIL}'       => $mUser->email,
	'{PHONE}'       => $mUser->phone
	);
	 */
	public function getParamArray() {
		$param = array();
		foreach ($this->attributes as $fieldName => $value) {
			$param['{' . strtoupper($fieldName) . '}'] = $value;
		}
		return $param;
	}

	public function getImageUrl($fieldName, $imageSizeAlias = null) {
		if ($imageSizeAlias == null) {
			$image = $this->uploadImageFolder . '/' . $this->id . '/' . $this->$fieldName;
			if (file_exists($image) && $this->$fieldName != '')
				return Yii::app()->createAbsoluteUrl($image);
			else
				return Yii::app()->theme->baseUrl . '/admin/js/holder.js/200X200';
		}
		//has image in database
		if ($this->$fieldName != "") {
			if (array_key_exists($fieldName, $this->defineImageSize) && is_array($this->defineImageSize[$fieldName])) {
				foreach ($this->defineImageSize[$fieldName] as $item) {
					if ($item['alias'] == $imageSizeAlias) {
						$thumb = $this->uploadImageFolder . '/' . $this->id . '/' . $item['alias'] . '/' . $this->$fieldName;
						$image = $this->uploadImageFolder . '/' . $this->id . '/' . $this->$fieldName;

						if (!file_exists($thumb) && file_exists($image))
							$this->resizeImage($fieldName);

						if (file_exists($thumb))
							return Yii::app()->createAbsoluteUrl($thumb);
						else
							return $this->getDefaultImageUrl($fieldName, $imageSizeAlias);
					}
				}
				return $this->getDefaultImageUrl($fieldName, $imageSizeAlias);
			}
		}
		else { //don't have image in database
			return $this->getDefaultImageUrl($fieldName, $imageSizeAlias);
		}
	}

	public function getDefaultImageUrl($fieldName, $imageSizeAlias) {//noiamge
		if (array_key_exists($fieldName, $this->defineImageSize) && is_array($this->defineImageSize[$fieldName])) {
			foreach ($this->defineImageSize[$fieldName] as $item) {
				if ($item['alias'] == $imageSizeAlias) {
					if (isset($item['default']) && $item['default'] != '') {
						return Yii::app()->createAbsoluteUrl($item['default']);
					} else
						return Yii::app()->theme->baseUrl . '/admin/js/holder.js/' . $item['size'];
				}
			}
			return Yii::app()->theme->baseUrl . '/admin/js/holder.js/200X200';
		}
	}

	/**
	 * DTOAN
	 * using get dropdownlist
	 * $arrWher : parram ex : array('id'=>10,'status'=>1)
	 */
	public function getDropdownlistWithTable($arrWhere = array(), $key = 'id', $value = 'id', $order = null) {
		if ($order != '') {
			$model = $this->findAllByAttributes($arrWhere, array('order' => $order));
		} else {
			$model = $this->findAllByAttributes($arrWhere);
		}

		if ($model) {
			return CHtml::listData($model, $key, $value);
		}
		return array();
	}

	/**
	 * DTOAN
	 * get info record
	 * $arrWher : parram
	 * ex : array('id'=>10,'status'=>1)
	 */
	public function getInfoRecordWithTable($arrWhere = array(), $field_name = NULL) {
		$model = $this->findByAttributes($arrWhere);
		if ($model) {
			if (empty($field_name))
				return $model;
			else
				return $model->$field_name;
		}
		return null;
	}

	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	/**
	 * @Author Haidt <haidt3004@gmail.com>
	 * @copyright 2015 Verz Design
	 * $params string $str
	 * @return string
	 * @Todo: replace a space by underscores
	 */
	protected function replaceSpaceByUnderscores($str) {
		return str_replace(" ", "_", $str);
	}

}

?>
