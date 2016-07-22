<?php

class PoliciesController extends AdminController {
    public $pluralTitle = 'Policies';
    public $singleTitle = 'Policy';
    public $cannotDetele = array();

    public function actionCreate() {
        try {
            $model = new Policy('create');
            $model->display_order = $model->nextOrderNumber();
            if (isset($_POST['Policy'])) {
                // $model->attributes = $_POST['Policy'];
                $model->attributes =  $model->getDataValidate();
                $model->created_date = $model->modified_date = date('Y-m-d H:i:s');
                $model->status = $_POST['Policy']['status'];
                // $model->parent_id = $_POST['Policy']['parent_id'];
                if ($model->save()) {
                    $model->saveDataWithLanguage('Policy');
                    $model->saveImage('featured_image');
                    $this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been created successfully.');
                    $this->redirect(array('view', 'id' => $model->id));
                } else {
                    $this->setNotifyMessage(NotificationType::Error, $this->singleTitle . ' cannot be create for some reasons');
                }
            }
            $this->render('create', array(
                'model' => $model,
                'actions' => $this->listActionsCanAccess,
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
                        $model->removeImage(array('featured_image'), true);
                        if ($model->delete())
                            Yii::log("Delete record " . print_r($model->attributes, true), 'info');
                    }

                    // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                    if (!isset($_GET['ajax']))
                        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
                }
            }
            else {
                Yii::log("Invalid request. Please do not repeat this request again.");
                throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
            }
        } catch (Exception $e) {
            Yii::log("Exception " . print_r($e, true), 'error');
            throw new CHttpException($e);
        }
    }

    public function actionIndex() {
        try {
            $model = new Policy('search');
            // $model->ConvertDatatoMultilang();
            
            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['Policy']))
                $model->attributes = $_GET['Policy'];

            $this->render('index', array(
                'model' => $model, 'actions' => $this->listActionsCanAccess,
            ));
        } catch (Exception $e) {
            Yii::log("Exception " . print_r($e, true), 'error');
            throw new CHttpException($e);
        }
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        if (isset($_POST['Policy'])) {
            // $model->attributes = $_POST['Policy'];
            $model->attributes =  $model->getDataValidate();
            $model->modified_date = date('Y-m-d H:i:s');
            $model->status = $_POST['Policy']['status'];
            // $model->parent_id = $_POST['Policy']['parent_id'];

            if ($model->save()) {
                $model->saveDataWithLanguage('Policy');
                $model->saveImage('featured_image');
                $this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been updated successfully.');
                $this->redirect(array('view', 'id' => $model->id));
            } else {
                $this->setNotifyMessage(NotificationType::Error, $this->singleTitle . ' cannot be updated for some reasons');
            }
        }
        //$model->beforeRender();
        $this->render('update', array(
            'model' => $model,
            'actions' => $this->listActionsCanAccess,
            'title_name' => $model->title));
    }

    public function actionView($id) {
        try {
            $model = $this->loadModel($id);
            $model->getDataTranslate();
            $this->render('view', array(
                'model' => $model,
                'actions' => $this->listActionsCanAccess,
                'title_name' => $model->title));
        } catch (Exception $exc) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }

    public function actionDeleteAll() {
        $deleteItems = $_POST['page-grid_c0'];
        $shouldDelete = array_diff($deleteItems, $this->cannotDetele);

        if (!empty($shouldDelete)) {
            $deleteImages = Policy::model()->findAll('id in (' . implode(',', $shouldDelete) . ')');
            if (!empty($deleteImages)) {
                foreach ($deleteImages as $item) {
                    //PostsCategories::model()->deleteAllByCategory($item->id);
                    $item->removeImage(array('featured_image'), true);
                }
            }
            Policy::model()->deleteAll('id in (' . implode(',', $shouldDelete) . ')');
            $this->setNotifyMessage(NotificationType::Success, 'Your selected records have been deleted successfully.');
        } else
            $this->setNotifyMessage(NotificationType::Error, 'No records was deleted');

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

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
        $initModel = new Policy();
        $model = $initModel->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actionUpdateStatusAll() {
        $updateItems = $_POST['page-grid_c0'];
        $status = $_POST['status'];
        if (!empty($updateItems) && $status != '') {
            Policy::model()->updateAll(array('status' => $status), 'id in (' . implode(',', $updateItems) . ')');
            $this->setNotifyMessage(NotificationType::Success, 'Your selected records have been updated successfully.');
        } else
            $this->setNotifyMessage(NotificationType::Error, 'No records was updated');

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

}
