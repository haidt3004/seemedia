<?php

class LanguagesController extends AdminController
{
    public $pluralTitle = 'Languages';
    public $singleTitle = 'Language';
    public $cannotDelete = array(1,2,4,5,6);
    public function actionCreate(){
        try {
            $model = new Languages('create');
            if (isset($_POST['Languages'])) {
                $model->attributes = $_POST['Languages'];
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
            $model=new Languages('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['Languages']))
                $model->attributes=$_GET['Languages'];

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
        if(isset($_POST['Languages']))
        {
            $model->attributes=$_POST['Languages'];
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
		$deleteItems = $_POST['languages-grid_c0'];
		$shouldDelete = array_diff($deleteItems, $this->cannotDelete);

		if (!empty($shouldDelete))
		{
						Languages::model()->deleteAll('id in (' . implode(',', $shouldDelete) . ')');
			$this->setNotifyMessage(NotificationType::Success, 'Your selected records have been deleted');
		}
		else
			$this->setNotifyMessage(NotificationType::Error, 'No records was deleted');

		if (!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

    public function actionUpdateStatusAll() {
        $updateItems = $_POST['languages-grid_c0'];
        $status = $_POST['status'];
        if (!empty($updateItems) && $status != '') {
            Languages::model()->updateAll(array('status'=>$status), 'id in (' . implode(',', $updateItems) . ')');
            $this->setNotifyMessage(NotificationType::Success, 'Your selected records have been updated');
        }
        else
            $this->setNotifyMessage(NotificationType::Error, 'No records was updated');

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
	
		
    public function loadModel($id){
		//need this define for inherit model case. Form will render parent model name in control if we don't have this line
		$initMode = new Languages();
        $model=$initMode->findByPk($id);
        if($model===null)
                throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }


    public function actionTexttranslate($id){
        $model = $this->loadModel($id);

        $mtranslate = new TextTranslate('create');
         $mtranslate->language_id = $id;
        if(isset($_POST['TextTranslate'])){
            $mtranslate->attributes = $_POST['TextTranslate'];
            $mtranslate->key = StringHelper::slugify($mtranslate->key);
            if($mtranslate->validate()){
                if(!$mtranslate->hasErrors()){
                    $mtranslate->save();
                    $this->refresh();
                }
            }
        }

        if(isset($_POST['translate'])){
            if(is_array($_POST['translate'])&&count($_POST['translate'])>0){
                foreach($_POST['translate'] as $text_translate_id=>$val){
                    TextTranslateRoleWebsite::saveDataTextTransalte($text_translate_id,ROLE_WEBSITE_ID,$id,$val);
                    $this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been updated');
                }
            }
        }
        $allFiled = $mtranslate->getAllTextTranslate($id);
        if(isset($_POST['translate'])){
            $mtranslate->createFileLanguage($allFiled,$model->code);
        }

        $this->render('text-translate',array('model'=>$model,'mtranslate'=>$mtranslate,'allFiled'=>$allFiled));  
    }




}