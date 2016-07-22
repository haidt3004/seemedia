<?php

/**
 * @author Haidt <haidt3004@gmail.com>
 * @version 2: HUploadAction_V2.php  2015-06-03 09:00:22
 */
class HUploadAction_v2 extends CAction {

	//action initial
	public function run() {
		if (isset($_POST['actionType'])) {
			switch ($_POST['actionType']) {
				case 'add' : $this->addImage();
					break;
				case 'delete' : $this->deleteImage();
					break;
				case 'sort' : $this->sortImage();
					break;
				case 'set_main_image' : $this->setMainImage();
					break;
			}
		}
	}

	/**
	 * @Author : Haidt
	 * @return json
	 * @Description: add 1 or multi images
	 */
	public function addImage() {
		$status = false;
		$errors = array();
		if (isset($_POST['activeModel'])) {
			$modelName = $_POST['activeModel'];
			$model = new $modelName;
			
			$fileName = isset($_POST[$modelName]['fileName']) ? $_POST[$modelName]['fileName'] : '';
			$setMainImage = isset($_POST[$modelName]['setMainImage']) ? $_POST[$modelName]['setMainImage'] : '';
			$mainImageFunc = isset($_POST[$modelName]['mainImageFunc']) ? $_POST[$modelName]['mainImageFunc'] : '';
			
			$parentField = isset($_POST[$modelName]['parentField']) ? $_POST[$modelName]['parentField'] : '';
			$parent_id = isset($parentField) ? $_POST[$modelName][$parentField] : '';
					
			
			$criteria = new CDbCriteria;
			$criteria->addCondition($parentField. ' = '.$parent_id);
			$currentFile = $modelName::model()->count($criteria);
			
			if (isset($_POST[$modelName]['is_multi_select'])) {
				$status = true;
				$files = CUploadedFile::getInstances($model, $fileName);
				if (count($files) > 0) {
					$currentFile = $currentFile + count($files);
					if (isset($model->maxFileUpload) && $currentFile  > $model->maxFileUpload) {
						$errors = array($fileName => array(0 => 'You can upload max '.$model->maxFileUpload.' files.'));
						$status = false;
					} else {
						foreach ($files as $key => $file) {
							$model = new $modelName;
							$model->attributes = $_POST[$modelName];
							$model->{$fileName} = $file;
							if ($model->validate()) {
								$model->save();
								$model->saveImage($fileName, true);
							} else {
								$errors = $model->getErrors();
								$status = false;
							}
						}
					}
				} else {
					$errors = array($fileName => array(0 => 'Please select files to upload'));
					$status = false;
				}
			} else {
				$model->attributes = $_POST[$modelName];
				$model->{$fileName} = CUploadedFile::getInstance($model, $fileName);
				if ($model->save()) {
					$model->saveImage($fileName,true);
					$status = true;
				} else {
					$errors = $model->getErrors();
				}
			}

			

			if ($setMainImage) {
				$model->$mainImageFunc($parent_id);
			}
		}

		echo CJSON::encode(array('status' => $status, 'errors' => $errors));
		Yii::app()->end();
	}

	/**
	 * @Author : Haidt
	 * @Description: delete an image
	 */
	public function deleteImage() {
		$status = false;
		$errors = array();

		if (isset($_POST['id'])) {
			$modelName = $_POST['model'];
			$id = $_POST['id'];
			$criteria = new CDbCriteria();
			$criteria->addCondition('id = ' . $id);
			$model = $modelName::model()->find($criteria);
			if ($model->delete()) {
				$status = true;
			} else {
				$errors = $model->getErrors();
			}
		}

		echo CJSON::encode(array('status' => $status, 'errors' => $errors));
		Yii::app()->end();
	}

	/**
	 * @Author : Haidt
	 * @Description: action sort item
	 */
	public function sortImage() {
		$status = false;
		$msg = '';
		if (isset($_POST['activeModel'])) {
			// get active model
			$modelName = $_POST['activeModel'];
			// get sort field
			$sortField = isset($_POST[$modelName]['sortField']) ? $_POST[$modelName]['sortField'] : '';
			// get list data sorted
			$sorts = isset($_POST[$modelName . 'HSORT']['sort']) ? $_POST[$modelName . 'HSORT']['sort'] : '';
			// get list id of items
			$ids = isset($_POST[$modelName . 'HSORT']['id']) ? $_POST[$modelName . 'HSORT']['id'] : '';

			foreach ($ids as $id) {
				$model = $modelName::model()->findByPk($id);
				if ($model) {
					$model->{$sortField} = $sorts[$id];
					$model->update();
				}
			}
			$status = true;
		}
		echo CJSON::encode(array('status' => $status, 'msg' => $msg));
		Yii::app()->end();
	}

	/**
	 * @Author Haidt <haidt3004@gmail.com>
	 * @copyright 2015 Verzdesign 	 
	 * @param type $var
	 * @return 
	 * @Todo: 
	 */
	public function setMainImage() {
		$status = false;
		if (isset($_POST['id'])) {
			$id = $_POST['id'];
			$modelName = isset($_POST['model']) ? $_POST['model'] : '';
			$parent_id = isset($_POST['parent_id']) ? $_POST['parent_id'] : '';
			$parent_field = isset($_POST['parent_field']) ? $_POST['parent_field'] : '';
			$update_field = isset($_POST['update_field']) ? $_POST['update_field'] : '';

			$criteria = new CDbCriteria();
			$criteria->addCondition('id = :id');
			$criteria->addCondition($parent_field . ' = :parent_id');
			$criteria->params = array(
				':id' => $id,
				':parent_id' => $parent_id,
			);

			$criteria1 = new CDbCriteria();
			$criteria1->addCondition($parent_field . ' = :parent_id1');
			$criteria1->params = array(
				':parent_id1' => $parent_id,
			);

			$modelName::model()->updateAll(array($update_field => 0), $criteria1);

			$model = $modelName::model()->find($criteria);
			if ($model) {
				$model->{$update_field} = 1;
				if ($model->update()) {
					$status = true;
				}
			}
		}

		echo CJSON::encode(array('status' => $status));
		Yii::app()->end();
	}

}
