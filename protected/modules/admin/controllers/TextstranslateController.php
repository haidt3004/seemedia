<?php

class TextstranslateController extends AdminController
{
    public $pluralTitle = 'TextTranslate';
    public $singleTitle = 'TextTranslate';
    public $cannotDelete = array();
    public function actionCreate(){
        try {
            $model = new TextTranslate('create');
            if (isset($_POST['TextTranslate'])) {
                $model->attributes = $_POST['TextTranslate'];
                if($model->save())
				{
										$this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been created');
                    $this->redirect(array('view', 'id'=> $model->id));
				}
				else
					$this->setNotifyMessage(NotificationType::Error, $this->singleTitle . ' cannot be created for some reasons');
            }
            $this->render('create', array(
                'model' => $model,
                'actions' => $this->listActionsCanAccess,
            ));
        }catch (exception $e) {
            Yii::log("Exception " . print_r($e, true), 'error');
            throw new CHttpException($e);
        }
    }

    public function actionDelete($id) {
        try {
            if(Yii::app()->request->isPostRequest) {
                // we only allow deletion via POST request
				if (!in_array($id, $this->cannotDelete))
				{
					if($model = $this->loadModel($id)){
												if($model->delete())
							Yii::log("Delete record ".  print_r($model->attributes, true), 'info');
					}

					// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
					if(!isset($_GET['ajax']))
						$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
				}
            } else {
                Yii::log("Invalid request. Please do not repeat this request again.");
                throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
            }
        } catch (Exception $e) {
            Yii::log("Exception ".  print_r($e, true), 'error');
            throw  new CHttpException($e);
        }
    }      
    
    public function actionIndex() {
        try {
            $model=new TextTranslate('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['TextTranslate']))
                $model->attributes=$_GET['TextTranslate'];

            $this->render('index',array(
                'model'=>$model, 'actions' => $this->listActionsCanAccess,
            ));
        } catch (Exception $e) {
            Yii::log("Exception ".  print_r($e, true), 'error');
            throw  new CHttpException($e);
        }
    }

    public function actionUpdate($id) {
        $model=$this->loadModel($id);
        if(isset($_POST['TextTranslate']))
        {
            $model->attributes=$_POST['TextTranslate'];
            if ($model->save())
			{
								$this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been updated');
				$this->redirect(array('view', 'id'=> $model->id));
			}
			else
				$this->setNotifyMessage(NotificationType::Error, $this->singleTitle . ' cannot be updated for some reasons');
        }
        //$model->beforeRender();
        $this->render('update',array(
            'model' => $model,
            'actions' => $this->listActionsCanAccess,
            'title_name' => $model->title        ));
    }

    
    public function actionView($id) {
        try {
            $model = $this->loadModel($id);
            $this->render('view', array(
                'model'=> $model,
                'actions' => $this->listActionsCanAccess,
                'title_name' => $model->title            ));
        } catch (Exception $exc) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }

	/*
	* Bulk delete
	* If you don't want to delete some specified record please configure it in global $cannotDelete variable
	*/
	public function actionDeleteAll()
	{
		$deleteItems = $_POST['text-translate-grid_c0'];
		$shouldDelete = array_diff($deleteItems, $this->cannotDelete);

		if (!empty($shouldDelete))
		{
						TextTranslate::model()->deleteAll('id in (' . implode(',', $shouldDelete) . ')');
			$this->setNotifyMessage(NotificationType::Success, 'Your selected records have been deleted');
		}
		else
			$this->setNotifyMessage(NotificationType::Error, 'No records was deleted');

		if (!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

    public function actionUpdateStatusAll() {
        $updateItems = $_POST['text-translate-grid_c0'];
        $status = $_POST['status'];
        if (!empty($updateItems) && $status != '') {
            TextTranslate::model()->updateAll(array('status'=>$status), 'id in (' . implode(',', $updateItems) . ')');
            $this->setNotifyMessage(NotificationType::Success, 'Your selected records have been updated');
        }
        else
            $this->setNotifyMessage(NotificationType::Error, 'No records was updated');

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
	
		
    public function loadModel($id){
		//need this define for inherit model case. Form will render parent model name in control if we don't have this line
		$initMode = new TextTranslate();
        $model=$initMode->findByPk($id);
        if($model===null)
                throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
}