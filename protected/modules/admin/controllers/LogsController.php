<?php

class LogsController extends AdminController
{
    public $pluralTitle = 'Logs';
    public $singleTitle = 'Log';
    public $cannotDelete = array();
    public function actionCreate(){
        try {
            $model = new LoginLogs('create');
            if (isset($_POST['LoginLogs'])) {
                $model->attributes = $_POST['LoginLogs'];
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
            $model=new LoginLogs('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['LoginLogs']))
                $model->attributes=$_GET['LoginLogs'];

            // export excel
            Yii::app()->session['data_excel'] = $model->searchForExport();

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
        if(isset($_POST['LoginLogs']))
        {
            $model->attributes=$_POST['LoginLogs'];
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
            'title_name' => $model->id        ));
    }

    
    public function actionView($id) {
        try {
            $model = $this->loadModel($id);
            $this->render('view', array(
                'model'=> $model,
                'actions' => $this->listActionsCanAccess,
                'title_name' => $model->id            ));
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
		$deleteItems = $_POST['login-logs-grid_c0'];
		$shouldDelete = array_diff($deleteItems, $this->cannotDelete);

		if (!empty($shouldDelete))
		{
						LoginLogs::model()->deleteAll('id in (' . implode(',', $shouldDelete) . ')');
			$this->setNotifyMessage(NotificationType::Success, 'Your selected records have been deleted');
		}
		else
			$this->setNotifyMessage(NotificationType::Error, 'No records was deleted');

		if (!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

    public function actionUpdateStatusAll() {
        $updateItems = $_POST['login-logs-grid_c0'];
        $status = $_POST['status'];
        if (!empty($updateItems) && $status != '') {
            LoginLogs::model()->updateAll(array('status'=>$status), 'id in (' . implode(',', $updateItems) . ')');
            $this->setNotifyMessage(NotificationType::Success, 'Your selected records have been updated');
        }
        else
            $this->setNotifyMessage(NotificationType::Error, 'No records was updated');

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
	
		
    public function loadModel($id){
		//need this define for inherit model case. Form will render parent model name in control if we don't have this line
		$initMode = new LoginLogs();
        $model=$initMode->findByPk($id);
        if($model===null)
                throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    //export CSV
    public function actionExport() {
        Yii::import('application.extensions.phpexcel.Classes.PHPExcel');
        $objPHPExcel = new PHPExcel();
        // Set properties
        $objPHPExcel->getProperties()->setCreator("VerzDesign")
            ->setLastModifiedBy("Nguyen")
            ->setTitle('Export Current List')
            ->setSubject("Office 2007 XLSX Document")
            ->setDescription("Trackings")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Trackings");
        $objPHPExcel->getActiveSheet()->setTitle('sheet1');
        $objPHPExcel->setActiveSheetIndex(0);

        $model = Yii::app()->session['data_excel'];
        if ($model) {
            //set header threat
            $objPHPExcel->getActiveSheet()->setCellValue("A1", 'Username', true);
            $objPHPExcel->getActiveSheet()->setCellValue("B1", 'Email', true);
            $objPHPExcel->getActiveSheet()->setCellValue("C1", 'Login', true);
            $objPHPExcel->getActiveSheet()->setCellValue("D1", 'Logout', true);
            $objPHPExcel->getActiveSheet()->setCellValue("E1", 'Status', true);
            $objPHPExcel->getActiveSheet()->setCellValue("F1", 'Ip Address', true);

            foreach ($model as $key => $row) {
                $objPHPExcel->getActiveSheet()->setCellValue("A" . ($key + 2), $row->username, true);
                $objPHPExcel->getActiveSheet()->setCellValue("B" . ($key + 2), $row->email, true);
                $objPHPExcel->getActiveSheet()->setCellValue("C" . ($key + 2), Yii::app()->format->date($row->login, 'd/m/Y H:i:s'), true);
                $objPHPExcel->getActiveSheet()->setCellValue("D" . ($key + 2), Yii::app()->format->date($row->logout, 'd/m/Y H:i:s'), true);
                $objPHPExcel->getActiveSheet()->setCellValue("E" . ($key + 2), $row->optionStatus[$row->status], true);
                $objPHPExcel->getActiveSheet()->setCellValue("F" . ($key + 2), $row->ip_address, true);
            }
            //bold format
            $styleArray2 = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                        'color' => array(
                            'rgb' => 'FFFFFF'
                        )
                    ),
                )
            );
            $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setSize(13)->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFill()->getStartColor()->setRGB('DBEAF9');
            $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->getColor()->setRGB('000000');
            $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($styleArray2);
            //set width
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
            //
            $objPHPExcel->getActiveSheet()->getStyle('A1:A' . ($key + 2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle('B1:B' . ($key + 2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle('C1:C' . ($key + 2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle('D1:D' . ($key + 2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle('E1:E' . ($key + 2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle('F1:F' . ($key + 2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            //


            // pass
//            $test_path = YII_UPLOAD_DIR . DS . 'test/test.xlsx';
//
//            $objPHPExcel->getSecurity()->setLockWindows(true);
//            $objPHPExcel->getSecurity()->setLockStructure(true);
//            $objPHPExcel->getSecurity()->setWorkbookPassword('password');
//
//            $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
//            $objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
//            $objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
//            $objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
//
//            $objPHPExcel->getActiveSheet()->getProtection()->setPassword('password');

//        $reader = new PHPExcel_Reader_Excel2007;
//        $workbook =  $reader->load($test_path);
//        $workbook->getSecurity()->setWorkbookPassword("password");
            // end pass

            //save file
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//            $objWriter->save($test_path);
            for ($level = ob_get_level(); $level > 0; --$level) {
                @ob_end_clean();
            }
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-type: ' . 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . 'Logs' . '.' . 'xlsx' . '"');

            header('Cache-Control: max-age=0');
            $objWriter->save('php://output');
            Yii::app()->end();
        }
    }
}