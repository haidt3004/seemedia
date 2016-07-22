<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php

class DetailbannersController extends AdminController {

	public $pluralTitle = 'Banner Items';
	public $singleTitle = 'Banner Item';
	public $cannotDetele = array();

	public function actionCreate($group_id = null) {
		try {
			$groupBanner = GroupBanner::model()->findByPk((int) $group_id);

			if (empty($groupBanner))
				$this->redirect(array('admin/groupbanners'));

			$model = new BannerItem('create');
			$model->group_banner_id = $group_id;
			$model->order_display = $model->nextOrderNumber();
			if (isset($_POST['BannerItem'])) {
				$model->attributes = $_POST['BannerItem'];
				if ($model->banner_type == BannerItem::BANNER_SCRIPT_TYPE) {
					$model->scenario = 'createScript';
				}

				// add because large_image required in create and update
				if (is_null($model->large_image) || empty($model->large_image)) {
					$model->large_image = 'default.jpg';
				}

				if ($model->save()) {
					$model->saveImage('large_image');
					$this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been created successfully.');
					$this->redirect(array('view', 'id' => $model->id, 'group_id' => $group_id));
				} else {
					$this->setNotifyMessage(NotificationType::Error, $this->singleTitle . ' cannot be created for some reasons');
				}
			}
			$this->render('create', array(
				'model' => $model,
				'actions' => $this->listActionsCanAccess,
				'groupName' => $groupBanner,
			));
		} catch (exception $e) {
			Yii::log("Exception " . print_r($e, true), 'error');
			throw new CHttpException($e);
		}
	}

	public function actionDelete($id) {
		try {
			if (Yii::app()->request->isPostRequest) {
				// we only allow deletion via POST request
				if (!in_array($id, $this->cannotDetele)) {
					if ($model = $this->loadModel($id)) {
						//call delete image first
						$model->removeImage(array('large_image'), false);
						if ($model->delete())
							Yii::log("Delete record " . print_r($model->attributes, true), 'info');
					}

					// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
					if (!isset($_GET['ajax']))
						$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
				}
			} else {
				Yii::log("Invalid request. Please do not repeat this request again.");
				throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
			}
		} catch (Exception $e) {
			Yii::log("Exception " . print_r($e, true), 'error');
			throw new CHttpException($e);
		}
	}

	public function actionIndex($group_id = null) {
		try {
			$groupBanner = GroupBanner::model()->findByPk((int) $group_id);
			if (empty($groupBanner)) {
				$this->redirect(array('/admin/groupbanners'));
			}

			$model = new BannerItem('searchAdmin');
			$model->unsetAttributes();  // clear any default values
			if (isset($_GET['BannerItem']))
				$model->attributes = $_GET['BannerItem'];

			if ($group_id != null) {
				$model->group_banner_id = $group_id;
			}
			$this->render('index', array(
				'model' => $model, 'actions' => $this->listActionsCanAccess, 'groupName' => $groupBanner
			));
		} catch (Exception $e) {
			Yii::log("Exception " . print_r($e, true), 'error');
			throw new CHttpException($e);
		}
	}

	public function actionUpdate($id, $group_id = null) {
		$model = $this->loadModel($id);
		$groupBanner = GroupBanner::model()->findByPk((int) $group_id);
		if (empty($groupBanner))
			$this->redirect(array('admin/groupbanners'));

		if (isset($_POST['BannerItem'])) {
			$model->attributes = $_POST['BannerItem'];
			$model->group_banner_id = $group_id;
			if ($model->banner_type == BannerItem::BANNER_SCRIPT_TYPE) {
				$model->scenario = 'updateScript';
			}

			// add because large_image required in create and update
			if (is_null($model->large_image) || empty($model->large_image)) {
				$model->large_image = 'default.jpg';
			}

			if ($model->save()) {
				$model->saveImage('large_image');
				$this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been updated successfully.');
				$this->redirect(array('view', 'id' => $model->id, 'group_id' => $group_id));
			} else
				$this->setNotifyMessage(NotificationType::Error, $this->singleTitle . ' cannot be updated for some reasons.');
		}
		$this->render('update', array(
			'model' => $model,
			'actions' => $this->listActionsCanAccess,
			'title_name' => $model->banner_title,
			'groupName' => $groupBanner
		));
	}

	public function actionView($id, $group_id = null) {
		try {
			$model = $this->loadModel($id);
			$groupBanner = GroupBanner::model()->findByPk((int) $group_id);
			if (empty($groupBanner))
				$this->redirect(array('admin/groupbanners'));

			$this->render('view', array(
				'model' => $model,
				'actions' => $this->listActionsCanAccess,
				'title_name' => $model->banner_title,
				'groupName' => $groupBanner
			));
		} catch (Exception $exc) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}
	}

	/*
	 * Bulk delete
	 * If you don't want to delete some specified record please configure it in global $cannotDetele variable
	 */

	public function actionDeleteAll() {
		$deleteItems = $_POST['banner-grid_c0'];
		$shouldDelete = array_diff($deleteItems, $this->cannotDetele);

		if (!empty($shouldDelete)) {
			if (!empty($deleteImages)) {
				$deleteImages = BannerItem::model()->findAll('id in (' . implode(',', $shouldDelete) . ')');
				foreach ($deleteImages as $item) {
					$item->removeImage(array('large_image'), false);
				}
			}
			BannerItem::model()->deleteAll('id in (' . implode(',', $shouldDelete) . ')');
			$this->setNotifyMessage(NotificationType::Success, 'Your selected records have been deleted successfully.');
		} else
			$this->setNotifyMessage(NotificationType::Error, 'No records was deleted');

		if (!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/*
	 * Remove upload image 
	 * Only files are deleted not folder. Run in ajax mode. Can modify in custom.js admin theme
	 */

	public function actionRemoveImage($fieldName, $id) {
		try {
			$model = $this->loadModel((int) $id);
			$model->removeImage(array($fieldName));
			echo 'thumbnail-' . $id;
		} catch (Exception $exc) {
			echo '';
		}
	}

	public function loadModel($id) {
		//need this define for inherit model case. Form will render parent model name in control if we don't have this line
		$initMode = new BannerItem();
		$model = $initMode->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

}
