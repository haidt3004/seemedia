<?php

class ArticleController extends AdminController {

    public $pluralTitle = 'Article Listing';
    public $singleTitle = 'Article';
    public $cannotDelete = array();

    public function actionCreate() {
        try {
            $model = new Article('create');
            $model->modified_date = date('Y-m-d');
            if (isset($_POST['Article'])) {
                $model->attributes = $_POST['Article'];
                if (CUploadedFile::getInstance($model, 'featured_image')) {
                    $model->check_name_image = CUploadedFile::getInstance($model, 'featured_image')->getName();
                }

                if (!empty($model->modified_date)) {
                    $model->modified_date = DateHelper::toDbDateFormat($model->modified_date);
                }

                if ($model->validate()) {
                    $model->save(false);
                    $model->saveImage('featured_image');
                    $this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been created');
                    $this->redirect(array('view', 'id' => $model->id));
                } else {
//                    if ($model->check_name_image == "") {
//                        $model->addError('check_name_image','Thumbnail can not blank.');
//                    }
                    $this->setNotifyMessage(NotificationType::Error, $this->singleTitle . ' cannot be created for some reasons');
                }
            }

            if (!empty($model->modified_date)) {
                $model->modified_date = DateHelper::toDateFormat($model->modified_date);
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
                if (!in_array($id, $this->cannotDelete)) {
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
            $model = new Article('search');
            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['Article']))
                $model->attributes = $_GET['Article'];

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
        $model->check_name_image = $model->featured_image;
        if (isset($_POST['Article'])) {
            $model->attributes = $_POST['Article'];
            if (CUploadedFile::getInstance($model, 'featured_image')) {
                $model->check_name_image = CUploadedFile::getInstance($model, 'featured_image')->getName();
            }

            if (!empty($model->modified_date)) {
                $model->modified_date = DateHelper::toDbDateFormat($model->modified_date);
            }

            if ($model->validate()) {
                $model->save(false);
                $model->saveImage('featured_image');
                $this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been updated');
                $this->redirect(array('view', 'id' => $model->id));
            } else {
                if ($model->check_name_image == "") {
                    $model->addError('check_name_image', 'Thumbnail can not blank.');
                }
                $this->setNotifyMessage(NotificationType::Error, $this->singleTitle . ' cannot be updated for some reasons');
            }
        }

        if (!empty($model->modified_date)) {
            $model->modified_date = DateHelper::toDateFormat($model->modified_date);
        }
        
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
     * If you don't want to delete some specified record please configure it in global $cannotDelete variable
     */

    public function actionDeleteAll() {
        $deleteItems = $_POST['article-grid_c0'];
        $shouldDelete = array_diff($deleteItems, $this->cannotDelete);

        if (!empty($shouldDelete)) {
            Article::model()->deleteAll('id in (' . implode(',', $shouldDelete) . ')');
            $this->setNotifyMessage(NotificationType::Success, 'Your selected records have been deleted');
        } else
            $this->setNotifyMessage(NotificationType::Error, 'No records was deleted');

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public function actionUpdateStatusAll() {
        $updateItems = $_POST['article-grid_c0'];
        $status = $_POST['status'];
        if (!empty($updateItems) && $status != '') {
            Article::model()->updateAll(array('status' => $status), 'id in (' . implode(',', $updateItems) . ')');
            $this->setNotifyMessage(NotificationType::Success, 'Your selected records have been updated');
        } else
            $this->setNotifyMessage(NotificationType::Error, 'No records was updated');

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public function loadModel($id) {
        //need this define for inherit model case. Form will render parent model name in control if we don't have this line
        $initMode = new Article();
        $model = $initMode->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

}
