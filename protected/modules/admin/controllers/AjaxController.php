<?php

class AjaxController extends AdminController {

	public $layout = '/layouts/ajax';

	public function accessRules() {
		return array(
			array('allow', //allow authenticated user to perform actions
				'users' => array('@'),
			),
			array('deny', // deny all users
				'users' => array('*'),
			),
		);
	}
	
	public function actions() {
		return array(
			'hupload' => 'ext.HUploadImage.actions.HUploadAction',
		);
	}

	//Begin - Audience Area
	/**
	 * @Author Haidt <haidt3004@gmail.com>
	 * @copyright 2015 Verz Design 	 	 
	 * @param int $listing_category_id
	 * @Todo: add a audience
	 */
	public function actionAddAudience($listing_category_id) {
		$model = new CategoryAudiances('create');
		$model->listing_category_id = $listing_category_id;
		if (isset($_POST['CategoryAudiances'])) {
			$model->attributes = $_POST['CategoryAudiances'];
			if ($model->save()) {
				$model->saveSpecialty();
				die("<script type='text/javascript'>parent.$.fn.colorbox.close();parent.$.fn.yiiGridView.update('audience-grid');</script>");
			}
		}
		$this->render('audiences/add', array('model' => $model));
	}

	/**
	 * @Author Haidt <haidt3004@gmail.com>
	 * @copyright 2015 Verz Design 	 	 
	 * @param int $id
	 * @Todo: update a audience
	 */
	public function actionUpdateAudience($id) {
		$model = $this->loadModelCustom("CategoryAudiances", $id);
		if (isset($_POST['CategoryAudiances'])) {
			$model->attributes = $_POST['CategoryAudiances'];
			if ($model->save()) {
				$model->saveSpecialty();
				die("<script type='text/javascript'>parent.$.fn.colorbox.close();parent.$.fn.yiiGridView.update('audience-grid');</script>");
			}
		}
		$this->render('audiences/update', array('model' => $model));
	}

	public function actionDeleteAudience($id) {
		if (Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			if ($model = $this->loadModelCustom("CategoryAudiances", $id)) {
				if ($model->delete()) {
					die("<script type='text/javascript'>parent.$.fn.yiiGridView.update('audience-grid');</script>");
				}
			}
		} else {
			Yii::log("Invalid request. Please do not repeat this request again.");
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
		}
	}

	//End - Audience Area
	//Xuan Tinh custom add District
	/**
	 * @Author Haidt <haidt3004@gmail.com>
	 * @copyright 2015 Verz Design 	 	 
	 * @param int $listing_category_id
	 * @Todo: add a audience
	 */
	public function actionAddDistrict($region_id) {
		$model = new LocationDistricts('create');
		$model->region_id = $region_id;
		if (isset($_POST['LocationDistricts'])) {
			$model->attributes = $_POST['LocationDistricts'];
			if ($model->save()) {
				die("<script type='text/javascript'>parent.$.fn.colorbox.close();parent.$.fn.yiiGridView.update('district-grid');</script>");
			}
		}
		$this->render('district/add', array('model' => $model));
	}

	//Xuan Tinh custom add District
	public function actionUpdateDistrict($id) {
		$model = $this->loadModelCustom("LocationDistricts", $id);
		if (isset($_POST['LocationDistricts'])) {
			$model->attributes = $_POST['LocationDistricts'];
			if ($model->save()) {
				die("<script type='text/javascript'>parent.$.fn.colorbox.close();parent.$.fn.yiiGridView.update('district-grid');</script>");
			}
		}
		$this->render('district/update', array('model' => $model));
	}

	public function actionDeleteDistrict($id) {
		if (Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			if ($model = $this->loadModelCustom("LocationDistricts", $id)) {
				if ($model->delete()) {
					die("<script type='text/javascript'>parent.$.fn.yiiGridView.update('district-grid');</script>");
				}
			}
		} else {
			Yii::log("Invalid request. Please do not repeat this request again.");
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
		}
	}

	/**
	 * @Author Haidt <haidt3004@gmail.com>
	 * @copyright 2015 Verz Design 	 	 
	 * @param string $modelName
	 * @param int $id
	 * @return object $model
	 * @Todo: load model
	 */
	public function loadModelCustom($modelName, $id) {
		//need this define for inherit model case. Form will render parent model name in control if we don't have this line
		$initMode = new $modelName();
		$model = $initMode->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * @Author Haidt <haidt3004@gmail.com>
	 * @copyright 2015 Verz Design 	 	 
	 * @return string
	 * @Todo: export banner
	 */
	public function actionExport() {
		if (Yii::app()->request->isPostRequest) {
			if (isset($_POST['modelName'])) {
				$modelName = $_POST['modelName'];
				$from_date = $_POST[$modelName]['exportFromDate'];
				$to_date = $_POST[$modelName]['exportToDate'];

				Yii::import('application.extensions.phpexcel.XPHPExcel');
				if (!file_exists($modelName::$export_url)) {
					mkdir($modelName::$export_url, 0777, true);
				}
				$filename = strtolower($modelName) . "-list-" . date('dmYHis', time()) . ".xls";
				$file_path = $modelName::$export_url . "/" . $filename;

				$objPHPExcel = XPHPExcel::createPHPExcel();

				$excelStyle = $objPHPExcel->getActiveSheet(0);
				$excelStyle->getColumndimension('A')->setWidth(20);
				$excelStyle->getColumndimension('B')->setWidth(30);
				$excelStyle->getColumndimension('C')->setWidth(30);
				$excelStyle->getColumndimension('D')->setWidth(20);
				$excelStyle->getColumndimension('E')->setWidth(20);


				$excelStyle->getStyle('A1:E1')->getFont()->setBold(true);
				$excelStyle->getStyle('A1:E1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$excelStyle->getStyle('A1:E1')->getFill()->getStartColor()->setARGB('6CA2DB');
				$excelStyle->getStyle('A1:E1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$excelStyle->getStyle('A1:E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$objPHPExcel->getProperties()->setCreator("LearnSuperMart")
					->setLastModifiedBy("LearnSuperMart")
					->setTitle("LearnSuperMart Document")
					->setSubject("LearnSuperMart Document")
					->setDescription("")
					->setKeywords("")
					->setCategory("");

				$model = new $modelName();

				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', $model->getAttributeLabel('title'))
					->setCellValue('B1', $model->getAttributeLabel('link'))
					->setCellValue('C1', $model->getAttributeLabel('number_of_click'))
					->setCellValue('D1', 'From Date')
					->setCellValue('E1', 'To Date');

				$models = $model->getDataToExport($modelName);

				foreach ($models as $key => $item) {
					$cols = $key + 2;
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A' . (string) ($cols), $item->title)
						->setCellValueExplicit('B' . (string) ($cols), $item->link, PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('C' . (string) ($cols), $item->countClick($from_date, $to_date), PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('D' . (string) ($cols), $from_date, PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('E' . (string) ($cols), $to_date, PHPExcel_Cell_DataType::TYPE_STRING);
				}

				$objPHPExcel->getActiveSheet()->setTitle('Banner List');

				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="' . $filename . '"');
				header('Cache-Control: max-age=0');
				header('Cache-Control: max-age=1');

				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
				$objWriter->save($file_path);
				$myfile = Yii::app()->createAbsoluteUrl($file_path);
				echo CJSON::encode(array('status' => true, 'file' => $myfile));
				Yii::app()->end();
			}
		}
	}

	/**
	 * @Author Haidt <haidt3004@gmail.com>
	 * @copyright 2015 Verz Design 	 	 
	 * @Todo: category change -> get list audience
	 */
	public function actionOnCategoryChange() {
		if (Yii::app()->request->isPostRequest) {
			$status = false;
			$data = array();
			if (isset($_POST['Listing'])) {
				$id = $_POST['Listing']['category_id'];
				if (!empty($id)) {
					$model = ListingsCategories::model()->findByPk($id);
					if ($model) {
						$arrAudience = array();
						if (isset($model->rAudience)) {
							$arrAudience = CHtml::listData($model->rAudience, 'id', 'name');
						}
						$data['audience'] = $this->renderPartial('listing/audience', array('data' => $arrAudience), true);
						$data['category_type'] = $model->getTypeOfCategory();
						$status = true;
					}
				}
			}

			echo CJSON::encode(array('status' => $status, 'data' => $data));
			Yii::app()->end();
		} else {
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
		}
	}

	/**
	 * @Author Haidt <haidt3004@gmail.com>
	 * @copyright 2015 Verz Design 	 	 
	 * @Todo: audience change -> get list specialty
	 */
	public function actionOnAudienceChange() {
		if (Yii::app()->request->isPostRequest) {
			$status = false;
			$data = array();
			if (isset($_POST['Listing'])) {
				$id = isset($_POST['Listing']['category_id']) ? $_POST['Listing']['category_id'] : null;
				$audience_ids = isset($_POST['Listing']['audience_id']) ? $_POST['Listing']['audience_id'] : array();
				if (!empty($id)) {
					$model = ListingsCategories::model()->findByPk($id);
					if ($model) {
						$arrSpecialty = array();
						if (isset($model->rCategoryAudiences)) {
							foreach ($model->rCategoryAudiences as $item) {
								if (isset($item->rSpecialty) && in_array($item->audience_id, $audience_ids)) {
									foreach ($item->rSpecialty as $spe) {
										if (!isset($arrSpecialty[$spe->id])) {
											$arrSpecialty[$spe->id] = $spe->name;
										}
									}
								}
							}
						}
						$data['specialty'] = $this->renderPartial('listing/specialty', array('data' => $arrSpecialty), true);
						$status = true;
					}
				}
			}

			echo CJSON::encode(array('status' => $status, 'data' => $data));
			Yii::app()->end();
		} else {
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
		}
	}

	/**
	 * @Author Haidt <haidt3004@gmail.com>
	 * @copyright 2015 Verz Design 	 	 
	 * @Todo: on location change -> get list region
	 */
	public function actionOnLocationChange() {
		if (Yii::app()->request->isPostRequest) {
			$status = false;
			$data = array();
			if (isset($_POST['Listing'])) {
				$location_id = isset($_POST['Listing']['location_id']) ? $_POST['Listing']['location_id'] : null;
				$arrRegion = LocationRegions::model()->getArrRegionByLocationId($location_id);
				$data['region'] = $this->renderPartial('listing/region', array('data' => $arrRegion), true);
				$data['region_type'] = $location_id == LOCATION_SG ? 'Region' : 'State';
				$status = true;
			}
			echo CJSON::encode(array('status' => $status, 'data' => $data));
			Yii::app()->end();
		} else {
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
		}
	}
	
	/**
	 * @Author Haidt <haidt3004@gmail.com>
	 * @copyright 2015 Verz Design 	 	 
	 * @Todo: on region change -> get list district
	 */
	public function actionOnRegionChange() {
		if (Yii::app()->request->isPostRequest) {
			$status = false;
			$data = array();
			if (isset($_POST['Listing'])) {
				$region_ids = isset($_POST['Listing']['region_id']) ? $_POST['Listing']['region_id'] : array();
				if (!empty($region_ids)) {
					$arrDistrict = LocationDistricts::model()->getArrDistrictByIds($region_ids);
				}
				$data['district'] = $this->renderPartial('listing/district', array('data' => $arrDistrict), true);
				$status = true;
			}
			echo CJSON::encode(array('status' => $status, 'data' => $data));
			Yii::app()->end();
		} else {
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
		}
	}

}
