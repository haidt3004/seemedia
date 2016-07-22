<?php

class UsersController extends AdminController {

    public $pluralTitle = 'HR';
    public $singleTitle = 'HR';
    public $cannotDelete = array();

    public function actionCreate() {
        try {
            $model = new Users('create_Hr_Profile');
            // $model->status = STATUS_ACTIVE;
            $model->roleProfile =true;
            $model->roleChangepassword =true;
            if (isset($_POST['Users'])) {
                $model->attributes = $_POST['Users'];
                if ($model->validate()) {
                    $model->role_id         = ROLE_HR;
                    $model->application_id  = FE;
                    $model->password_hash   = md5($model->temp_password);
                    $model->role_website_id = ROLE_WEBSITE_ID;
                    $model->dob  = date('Y-m-d',strtotime(str_replace('/','-',$model->dob)));
                    $model->is_changepassword = 0;
                    $model->save(false);
                    SendEmail::createUserAdminToUser($model);

                    $users = Users::model()->findAll('role_website_id = '. ROLE_WEBSITE_ID .' AND email = "'. $model->email .'"');
                    if (count($users) > 1) {
                        $this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been created successfully. This email address already exists.');
                    } else {
                        $this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been created successfully.');
                    }
                    $this->redirect(array('view', 'id' => $model->id));
                }
                else {
                    $this->setNotifyMessage(NotificationType::Error, $this->singleTitle . ' cannot be created for some reasons');
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
                if (!in_array($id, $this->cannotDelete)) {
                    if ($model = $this->loadModel($id)) {
                        $this->setNotifyMessage(NotificationType::Success, 'Your password has been changed successfully.');
                        if ($model->delete()) {
                            Yii::log("Delete record " . print_r($model->attributes, true), 'info');
                        }
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
            $model = new Users('searchMember');
            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['Users'])) {
                $model->attributes = $_GET['Users'];
            }

            $model->role_id         = ROLE_HR;
            $model->role_website_id = ROLE_WEBSITE_ID;

            // export excel
            Yii::app()->session['data_excel'] = $model->searchForExport();

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

        if ($model->role_id == ROLE_HR) {
            $old = new Users();
            $old->attributes = $model->attributes;
            // $model->status = STATUS_ACTIVE;
            $model->roleProfile =true;
            $model->roleChangepassword =true;
            $model->scenario = 'update_Hr_Profile';

            if (isset($_POST['Users'])) {
                $model->attributes = $_POST['Users'];

                if($model->newPassword ==''&& $model->password_confirm ==''){
                    $model->newPassword = $model->password_confirm = $old->temp_password;
                }


                if ($model->validate()) {
                    $model->dob  = date('Y-m-d',strtotime(str_replace('/','-',$model->dob)));

                    $model->temp_password = $model->newPassword;
                    $model->password_hash = md5($model->temp_password);
                    if($model->temp_password == Yii::app()->params['defaultPassword']){
                        $model->is_changepassword = 0;
                    }

                    if ($model->save()) {
                        //SendEmail::createUserAdminToUser($model);
                        $users = Users::model()->findAll('role_website_id = '. ROLE_WEBSITE_ID .' AND email = "'. $model->email .'"');
                        if (count($users) > 1) {
                            $this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been created successfully. This email address already exists.');
                        } else {
                            $this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been created successfully.');
                        }
                        $this->redirect(array('view', 'id' => $model->id));
                    }
                } else {
                    $this->setNotifyMessage(NotificationType::Error, $this->singleTitle . ' cannot be updated for some reasons');
                }
            }else{
                if (isset($model->dob) && $model->dob != '') {
                    $model->dob = Yii::app()->format->Date($model->dob);
                }
            }
            //$model->beforeRender();
            $this->render('update', array(
                    'model' => $model,
                    'actions' => $this->listActionsCanAccess,
                    'title_name' => $model->username)
            );
        } else {
            $this->redirect(Yii::app()->createAbsoluteUrl('admin/users'));
        }
    }

    public function actionView($id) {
        try {
            $model = $this->loadModel($id);
            $this->render('view', array(
                'model' => $model,
                'actions' => $this->listActionsCanAccess,
                'title_name' => $model->username));
        } catch (Exception $exc) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }

    /*
     * Bulk delete
     * If you don't want to delete some specified record please configure it in global $cannotDelete variable
     */

    public function actionDeleteAll() {
        $deleteItems = $_POST['users-grid_c0'];
        $shouldDelete = array_diff($deleteItems, $this->cannotDelete);

        if (!empty($shouldDelete)) {
            Users::model()->deleteAll('id in (' . implode(',', $shouldDelete) . ')');
            $this->setNotifyMessage(NotificationType::Success, 'Your selected records have been deleted successfully.');
        }
        else
            $this->setNotifyMessage(NotificationType::Error, 'No records was deleted');

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public function actionUpdateStatusAll() {
        $updateItems = $_POST['users-grid_c0'];
        $status = $_POST['status'];
        if (!empty($updateItems) && $status != '') {
            Users::model()->updateAll(array('status' => $status), 'id in (' . implode(',', $updateItems) . ')');
            $this->setNotifyMessage(NotificationType::Success, 'Your selected records have been updated successfully.');
        }
        else
            $this->setNotifyMessage(NotificationType::Error, 'No records was updated');

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public function loadModel($id) {
        //need this define for inherit model case. Form will render parent model name in control if we don't have this line
        $initMode = new Users();
        $model = $initMode->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actionResetPassword($id) {
        $model = $this->loadModel($id);
        $model->temp_password = rand(10000000, 99999999);
        $model->password_hash = md5($model->temp_password);
        if ($model->update(array('temp_password', 'password_hash'))) {
            SendEmail::changePassToUser($model);
            $this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been updated successfully.');
            $this->redirect(array('view', 'id' => $model->id));
        }
        else
            $this->setNotifyMessage(NotificationType::Error, $this->singleTitle . ' cannot be updated for some reasons');
    }

    public function actionAjaxExport()
    {
        if(Yii::app()->request->isPostRequest && Yii::app()->user->id) {
            $model = $this->loadModel(Yii::app()->user->id);

            if ($model->temp_password == $_POST['password']) {
                if ($this->export($model)) {
                    unlink(YII_UPLOAD_DIR . DS . 'csv/hr.xlsx');
                    Yii::app()->end();
                }
                Yii::log('Mail is not sent.');
                throw new CHttpException(400,'Mail is not sent.');
            }

            Yii::log('Password is not correct.');
            throw new CHttpException(400,'Password is not correct.');
        }
        Yii::log('Invalid request. Please do not repeat this request again.');
        throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }


    protected function export($user)
    {
        Yii::import('application.extensions.phpexcel.Classes.PHPExcel');
        $objPHPExcel = new PHPExcel();
        // Set properties
        $objPHPExcel->getProperties()->setCreator("VerzDesign")
            ->setLastModifiedBy("Dtoan")
            ->setTitle('Export Current List')
            ->setSubject("Office 2007 XLSX Document")
            ->setDescription("Trackings")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Trackings");
        $objPHPExcel->getActiveSheet()->setTitle('sheet1');
        $objPHPExcel->setActiveSheetIndex(0);

        $model = Yii::app()->session['data_excel'];
        if ($model) {


            $sheet = $objPHPExcel->getActiveSheet();
            $i=1;
            foreach(Languages::getAlllanguage() as $key=> $lang){
                Yii::app()->language = $lang->code;

                $sheetTitle = $lang->title;
                $objWorkSheet = $objPHPExcel->createSheet($key); //Setting index when creating

                //Write cells
                // $objWorkSheet->setCellValue('A1', 'Hello'.$key)
                //         ->setCellValue('B1', 'world!')
                //         ->setCellValue('C1', 'Hello')
                //         ->setCellValue('D1', 'world!');


                //set header threat
                $objWorkSheet->setCellValue("A1", TextMultilangHelper::label('username'), true);
                $objWorkSheet->setCellValue("B1", TextMultilangHelper::label('default-email'), true);
                $objWorkSheet->setCellValue("C1", TextMultilangHelper::label('staff-name'), true);
                $objWorkSheet->setCellValue("D1", TextMultilangHelper::label('first-name'), true);
                $objWorkSheet->setCellValue("E1", TextMultilangHelper::label('middle-name'), true);
                $objWorkSheet->setCellValue("F1", TextMultilangHelper::label('last-name'), true);
                $objWorkSheet->setCellValue("G1", TextMultilangHelper::label('office'), true);
                $objWorkSheet->setCellValue("H1", TextMultilangHelper::label('job-title'), true);
                $objWorkSheet->setCellValue("I1", TextMultilangHelper::label('department'), true);
                $objWorkSheet->setCellValue("J1", TextMultilangHelper::label('company'), true);
                $objWorkSheet->setCellValue("K1", TextMultilangHelper::label('gender-sex'), true);
                $objWorkSheet->setCellValue("L1", TextMultilangHelper::label('date-of-birth'), true);
                $objWorkSheet->setCellValue("M1", TextMultilangHelper::label('skills'), true);
                $objWorkSheet->setCellValue("N1", TextMultilangHelper::label('educations'), true);
                $objWorkSheet->setCellValue("O1", TextMultilangHelper::label('certification'), true);
                $objWorkSheet->setCellValue("P1", TextMultilangHelper::label('languages'), true);
                $objWorkSheet->setCellValue("Q1", TextMultilangHelper::label('associations'), true);
                $objWorkSheet->setCellValue("R1", TextMultilangHelper::label('about-my-self'), true);

                foreach ($model as $key => $row) {
                    $objWorkSheet->setCellValue("A" . ($key + 2), $row->username, true);
                    $objWorkSheet->setCellValue("B" . ($key + 2), $row->email, true);
                    $objWorkSheet->setCellValue("C" . ($key + 2), $row->staff_name, true);
                    $objWorkSheet->setCellValue("D" . ($key + 2), $row->first_name, true);
                    $objWorkSheet->setCellValue("E" . ($key + 2), $row->middle_name, true);
                    $objWorkSheet->setCellValue("F" . ($key + 2), $row->last_name, true);
                    $objWorkSheet->setCellValue("G" . ($key + 2), $row->office, true);
                    $objWorkSheet->setCellValue("H" . ($key + 2), $row->job_title, true);
                    $objWorkSheet->setCellValue("I" . ($key + 2), $row->department, true);
                    $objWorkSheet->setCellValue("J" . ($key + 2), $row->company, true);
                    $objWorkSheet->setCellValue("K" . ($key + 2), (isset($row->gender) && $row->gender != '') ? $row->optionGender[$row->gender] : '', true);
                    $objWorkSheet->setCellValue("L" . ($key + 2), Yii::app()->format->date($row->dob, 'd/m/Y'), true);
                    $objWorkSheet->setCellValue("M" . ($key + 2), $row->skills, true);
                    $objWorkSheet->setCellValue("N" . ($key + 2), $row->educations, true);
                    $objWorkSheet->setCellValue("O" . ($key + 2), $row->certification, true);
                    $objWorkSheet->setCellValue("P" . ($key + 2), $row->languages, true);
                    $objWorkSheet->setCellValue("Q" . ($key + 2), $row->associations, true);
                    $objWorkSheet->setCellValue("R" . ($key + 2), $row->about_my_self, true);
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
                $objWorkSheet->getStyle('A1:R1')->getFont()->setSize(13)->setBold(true);
                $objWorkSheet->getStyle('A1:R1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                $objWorkSheet->getStyle('A1:R1')->getFill()->getStartColor()->setRGB('DBEAF9');
                $objWorkSheet->getStyle('A1:R1')->getFont()->getColor()->setRGB('000000');
                $objWorkSheet->getStyle('A1:R1')->applyFromArray($styleArray2);
                //set width
                $objWorkSheet->getColumnDimension('A')->setAutoSize(true);
                $objWorkSheet->getColumnDimension('B')->setAutoSize(true);
                $objWorkSheet->getColumnDimension('C')->setAutoSize(true);
                $objWorkSheet->getColumnDimension('D')->setAutoSize(true);
                $objWorkSheet->getColumnDimension('E')->setAutoSize(true);
                $objWorkSheet->getColumnDimension('F')->setAutoSize(true);
                $objWorkSheet->getColumnDimension('G')->setAutoSize(true);
                $objWorkSheet->getColumnDimension('H')->setAutoSize(true);
                $objWorkSheet->getColumnDimension('I')->setAutoSize(true);
                $objWorkSheet->getColumnDimension('J')->setAutoSize(true);
                $objWorkSheet->getColumnDimension('K')->setAutoSize(true);
                $objWorkSheet->getColumnDimension('M')->setAutoSize(true);
                $objWorkSheet->getColumnDimension('N')->setAutoSize(true);
                $objWorkSheet->getColumnDimension('O')->setAutoSize(true);
                $objWorkSheet->getColumnDimension('P')->setAutoSize(true);
                $objWorkSheet->getColumnDimension('Q')->setAutoSize(true);
                $objWorkSheet->getColumnDimension('R')->setAutoSize(true);
                //
                $objWorkSheet->getStyle('A1:A' . ($key + 2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objWorkSheet->getStyle('B1:B' . ($key + 2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objWorkSheet->getStyle('C1:C' . ($key + 2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objWorkSheet->getStyle('D1:D' . ($key + 2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objWorkSheet->getStyle('E1:E' . ($key + 2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objWorkSheet->getStyle('F1:F' . ($key + 2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objWorkSheet->getStyle('G1:G' . ($key + 2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objWorkSheet->getStyle('H1:H' . ($key + 2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objWorkSheet->getStyle('I1:I' . ($key + 2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objWorkSheet->getStyle('J1:J' . ($key + 2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objWorkSheet->getStyle('K1:K' . ($key + 2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objWorkSheet->getStyle('M1:M' . ($key + 2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objWorkSheet->getStyle('N1:N' . ($key + 2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objWorkSheet->getStyle('O1:O' . ($key + 2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objWorkSheet->getStyle('P1:P' . ($key + 2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objWorkSheet->getStyle('Q1:Q' . ($key + 2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objWorkSheet->getStyle('R1:R' . ($key + 2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
   
                // Rename sheet
                $objWorkSheet->setTitle($sheetTitle);
            }

            $csv_path = YII_UPLOAD_DIR . DS . 'csv/hr.xlsx';
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            for ($level = ob_get_level(); $level > 0; --$level) {
                @ob_end_clean();
            }

            $objWriter->save($csv_path);

            if (file_exists($csv_path)) {
                $message = new YiiMailMessage('Hr export CSV');
                $message->setBody('', 'text/html');
                $message->addTo($user->email);

                $message->from   = Yii::app()->params['autoEmail'];
                $message->setFrom(array(Yii::app()->params['autoEmail'] => Yii::app()->setting->getItem('mailSenderName')));
                $swiftAttachment = Swift_Attachment::fromPath($csv_path);
                $message->attach($swiftAttachment);
                return Yii::app()->mail->send($message);
            }

            return false;
            // return true;
        }
    }

}