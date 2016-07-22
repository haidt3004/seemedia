<?php

class BannersController extends AdminController {

    public $pluralTitle = 'Home Page Banners Management';
    public $singleTitle = 'Home Banner';
    public $cannotDetele = array();

    public function actionCreate() {
        $this->pageTitle = "Create Home Banner - " . Yii::app()->setting->getItem('defaultPageTitle');
        $model = new Banners('create');
        $model->order_display = $model->nextOrderNumber();
        if (isset($_POST['Banners'])) {

            $model->attributes = $_POST['Banners'];            
            if ($model->save()) {
                $model->saveImage('image');
                $this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been created');
                $this->redirect(array('view', 'id' => $model->id));
            } else {
                $this->setNotifyMessage(NotificationType::Error, $this->singleTitle . ' cannot be create for some reasons');
            }
        }
        $this->render('create', array(
            'model' => $model, 'actions' => $this->listActionsCanAccess,
        ));
    }

    public function actionDelete($id) {
        try {
            if (Yii::app()->request->isPostRequest) {
                // we only allow deletion via POST request
                if (!in_array($id, $this->cannotDetele)) {
                    if ($model = $this->loadModel($id)) {
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

    public function actionIndex() {
        try {
            $model = new Banners('search');
            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['Banners']))
                $model->attributes = $_GET['Banners'];

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
        if (isset($_POST['Banners'])) {
            $model->attributes = $_POST['Banners'];
            if ($model->save()) {
                $model->saveImage('image');
                $this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been updated');
                $this->redirect(array('view', 'id' => $model->id));
            } else
                $this->setNotifyMessage(NotificationType::Error, $this->singleTitle . ' cannot be updated for some reasons');
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
            $this->render('view', array(
                'model' => $model,
                'actions' => $this->listActionsCanAccess,
                'title_name' => $model->title));
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
            Banners::model()->deleteAll('id in (' . implode(',', $shouldDelete) . ')');
            $this->setNotifyMessage(NotificationType::Success, 'Your selected records have been deleted');
        } else
            $this->setNotifyMessage(NotificationType::Error, 'No records was deleted');

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public function loadModel($id) {
        //need this define for inherit model case. Form will render parent model name in control if we don't have this line
        $initMode = new Banners();
        $model = $initMode->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
    
    public function actionAjaxDeleteImage() {
        if (!YII_DEBUG && !Yii::app()->request->isAjaxRequest) {
            throw new CHttpException('403', 'Forbidden access.');
        }
        $status = false;
        $msg = '';
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $init = new Banners();
            $model = $init->getBannerById($id);
            if ($model) {
                $source = $model->uploadImageFolder . '/' . $model->id . '/' . $model->image;
                if (file_exists($source)) {
                    unlink($source);
                    $model->image = '';
                    if ($model->update()) {
                        $status = true;
                        $msg = 'delete success';
                    } else {
                        $msg = 'delete fail';
                    }
                } else {
                    $msg = 'file is not exist';
                }
            }
        } else {
            $msg = 'Id is not exist';
        }
        echo CJSON::encode(array('status' => $status, 'msg' => $msg));
    }

}
