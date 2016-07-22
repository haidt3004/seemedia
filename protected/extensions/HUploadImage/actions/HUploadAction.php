<?php

/**
 * @author Haidt <haidt3004@gmail.com>
 * @version $Id: HUploadAction.php  2015-04-20 23:00:22
 * @since 1.1
 */
class HUploadAction extends CAction {

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
		$data = array();
		$errors = array();
		if (isset($_POST['activeModel'])) {
			$actionUrl = $_POST['actionUrl'];
			$modelName = $_POST['activeModel'];
			$model = new $modelName;
			$fileName = $_POST[$modelName]['fileName'];
			// sort field if has
			$sortField = $_POST[$modelName]['sortField'];
			//title for image if has
			$imgTitle = $_POST[$modelName]['isTitle'];
			//description for image if has
			$imgDesc = $_POST[$modelName]['isDescription'];

			if ($_POST[$modelName]['is_multi_select']) {
				$status = true;
				$files = CUploadedFile::getInstances($model, $fileName);
				if (count($files) > 0) {
					foreach ($files as $file) {
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
				} else {
					$errors = array($fileName => array(0 => 'Please select files to upload'));
					$status = false;
				}
			} else {
				$model->attributes = $_POST[$modelName];
				$model->{$fileName} = CUploadedFile::getInstance($model, $fileName);
				if ($model->save()) {
					$model->saveImage($fileName);
					$status = true;
				} else {
					$errors = $model->getErrors();
				}
			}
			$parentField = $_POST[$modelName]['parentField'];
			$parent_id = isset($parentField) ? $_POST[$modelName][$parentField] : '';
			$models = $this->getAll($modelName, $parentField, $parent_id);
			$data = $this->renderHtml($models, $modelName, $actionUrl, $fileName, $imgTitle, $imgDesc, $sortField);
		}

		echo CJSON::encode(array('status' => $status, 'data' => $data, 'errors' => $errors));
		Yii::app()->end();
	}

	public function getAll($modelName, $parentField, $parent_id) {
		$criteria = new CDbCriteria();
		$criteria->addCondition("{$parentField} = '" . $parent_id . "'");
		$models = $modelName::model()->findAll($criteria);
		return $models;
	}

	/**
	 * @Author : Haidt
	 * @return html
	 * @Description: render list item  
	 */
	public function renderHtml($models, $modelName, $actionUrl, $fileName, $imgTitle, $imgDesc, $sortField) {
		$html = '';
		foreach ($models as $model) {
			$elementId = "thumbnail-h-" . $modelName . '-' . $model->id;
			$html .= CHtml::openTag('div', array('class' => 'thumbnail-h', 'id' => $elementId));
			$html .= CHtml::image(Yii::app()->theme->baseUrl . "/admin/images/delete.png", '', array('onClick' => "deleteHImage($(this),'" . $model->id . "','" . $modelName . "','" . $elementId . "')",
					'class' => 'btn pull-right del-icon-h',
					'data-action' => $actionUrl));
			$html .= CHtml::image(ImageHelper::getImageUrl($model, $fileName, 'thumb'), $model->{$fileName}, array()) . " ";
			$html .= CHtml::openTag('div', array('class' => 'h-text'));
			if (isset($model->{$imgTitle}) && !empty($model->{$imgTitle})) {
				$html .= CHtml::openTag('strong', array('class' => 'h-text'));
				$html .= $model->{$imgTitle};
				$html .= CHtml::closeTag('strong');
			}
			if (isset($model->{$imgDesc}) && !empty($model->{$imgDesc})) {
				$html .= CHtml::openTag('p', array('class' => 'h-text'));
				$html .= $model->{$imgDesc};
				$html .= CHtml::closeTag('p');
			}
			$html .= CHtml::closeTag('div');
			if (!empty($sortField)) {
				$html .= CHtml::hiddenField($modelName . 'HSORT[sort][' . $model->id . ']', $model->{$sortField}, array('class' => 'display_order'));
				$html .= CHtml::hiddenField($modelName . 'HSORT[id][' . $model->id . ']', $model->id, array('class' => ''));
			}
			$html .= CHtml::closeTag('div');
		}
		return $html;
	}

	/**
	 * @Author : Haidt
	 * @Description: delete an image
	 */
	public function deleteImage() {
		$status = false;
		$data = array();
		$errors = array();

		if (isset($_POST['id'])) {
			$modelName = $_POST['model'];
			$id = $_POST['id'];
			$criteria = new CDbCriteria();
			$criteria->addCondition('id = ' . $id);
			$model = $modelName::model()->find($criteria);
			if ($model->delete()) {
				$data = $model->attributes;
				$status = true;
			} else {
				$errors = $model->getErrors();
			}
		}

		echo CJSON::encode(array('status' => $status, 'data' => $data, 'errors' => $errors));
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
			$sortField = $_POST[$modelName]['sortField'];
			// get list data sorted
			$sorts = $_POST[$modelName . 'HSORT']['sort'];
			// get list id of items
			$ids = $_POST[$modelName . 'HSORT']['id'];

			foreach ($ids as $id) {
				$model = $modelName::model()->findByPk($id);
				if ($model) {
					$model->{$sortField} = $sorts[$id];
					$model->update();
				}
			}
			$status = true;
		}
		echo CJSON::encode(array('status' => $status, 'html' => $html, 'msg' => $msg));
	}

}
