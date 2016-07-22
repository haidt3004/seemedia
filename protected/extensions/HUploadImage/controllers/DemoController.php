<?php
/**
 * @author Haidt <haidt3004@gmail.com>
 * @version $Id: HUploadImage.php  2015-04-20 23:00:22
 * @since 1.1
 * Description: this is some demo method for using HUploadImage action
 */
class DemoController extends AdminController {

	/**
	 * Author : Haidt
	 * @return json
	 * Description: ajax add image for site map
	 */
	public function actionAddImage() {
		if (!YII_DEBUG && !Yii::app()->request->isAjaxRequest) {
			throw new CHttpException('403', 'Forbidden access.');
		}
		$status = false;
		$data = '';
		$errors = '';
		//Model: name of Model
		if (isset($_POST['Model'])) {			
			$model = new Model();
			$model->progress_id = $_POST['Model']['progress_id'];
			$model->order_number = $model->nextOrderNumberById($model->progress_id);
			$model->file_name = CUploadedFile::getInstance($model, 'file_name');
			if ($model->save()) {
				$model->saveImage('file_name');
				$data = $this->renderPartial('progress/__image_item_view', array('item' => $model), true);
				$status = true;
			} else {
				$errors = $model->getErrors();
			}
		}
		//return JSON data
		echo CJSON::encode(array('status' => $status, 'data' => $data, 'errors' => $errors));
		Yii::app()->end();
	}

	/**
	 * Author : Haidt
	 * @return json
	 * Description: demo for delete image action
	 */
	public function actionDeleteImage() {
		if (!YII_DEBUG && !Yii::app()->request->isAjaxRequest) {
			throw new CHttpException('403', 'Forbidden access.');
		}

		$status = false;
		$data = array();
		$errors = array();

		if (isset($_POST['id'])) {
			$model_name = $_POST['model'];
			$id = $_POST['id'];
			$criteria = new CDbCriteria();
			$criteria->addCondition('id = ' . $id);
			$model = $model_name::model()->find($criteria);
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

}
