<?php

class FrontmenusController extends AdminController {

	public $pluralTitle = 'Menus';
	public $singleTitle = 'Menu';
	public $cannotDetele = array(1,2,3);

	public function actionCreate() {
		try {
			$model = new Menu('create');
			if (isset($_POST['Menu'])) {
				$model->attributes = $_POST['Menu'];
				if ($model->save()) {
					$this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been created successfully.');
					$this->redirect(array('update', 'id' => $model->id));
				} else
					$this->setNotifyMessage(NotificationType::Error, $this->singleTitle . ' cannot be created for some reasons');
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
		//try {
			$model = new Menu('search');
			$model->unsetAttributes();  // clear any default values
			if (isset($_GET['Menu']))
				$model->attributes = $_GET['Menu'];

			$this->render('index', array(
				'model' => $model, 'actions' => $this->listActionsCanAccess,
			));
		/*} catch (Exception $e) {
			Yii::log("Exception " . print_r($e, true), 'error');
			throw new CHttpException($e);
		}*/
	}

	private function getAllMenus($menuRelation, $menuItem, $parent = 0, &$mainArray, $level = 0) {
		foreach ($menuRelation as $menu) {
			$this->buildSaveDatalist($menu, $menuItem, $menu['id'], $mainArray, $level);
		}
	}

	private function buildSaveDatalist($menuRelation, $menuItem, $parent = 0, &$mainArray, $level = 0) {
		$menuItem[$menuRelation['id']]['level'] = $level;
		$menuItem[$menuRelation['id']]['parent_id'] = 0;
		if ($menuRelation['id'] != $parent)
			$menuItem[$menuRelation['id']]['parent_id'] = $parent;

		$mainArray[$menuRelation['id']] = $menuItem[$menuRelation['id']];

		if (!empty($menuRelation['children'])) {
			$parent = $menuRelation['id'];
			foreach ($menuRelation['children'] as $menu) {
				$menuItem[$menu['id']]['level'] = $level;
				$mainArray[$menu['id']] = $menuItem[$menu['id']];
				if ($parent > 0 && $parent != $menu['id'])
					$menuItem[$menu['id']]['parent_id'] = $parent;
				$level ++;
				$this->buildSaveDatalist($menu, $menuItem, $parent, $mainArray, $level);
				$level --;
			}
		}
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id);

		if (isset($_POST['Menu'])) {
			$model->attributes = $_POST['Menu'];
			
			if ($model->save()) {
				if (!empty($_POST['LevelMenuJson'])) {
					$tree = json_decode($_POST['LevelMenuJson'], true);
					$menuItems = isset($_POST['Menuitem']) ? $_POST['Menuitem'] : array();
					
					/* remove deleted menus item */
					if (empty($menuItems)) {
						$s = sprintf('menu_id=%d', $model->id);
					} else {
						$ids = array();
						foreach(array_keys($menuItems) as $v)
							$ids[] = is_int($v) ? $v : "'$v'";
						$s = sprintf('menu_id=%d AND id NOT IN(%s)', $model->id, implode(',', $ids));
					}
					Menuitem::model()->deleteAll($s);
					
					/* update & create new menu item */
					$adtData = $savedItems = $realIds = array();
					$this->_parseTree($tree, $adtData);
					foreach ($menuItems as $key => $itemData) {
						$item = Menuitem::model()->findByPk($key);
                        $isnewiTem = false;
						if (!$item) {
							$item = new Menuitem();
                            $isnewiTem =true;
						}
						
						$item->attributes = $itemData;
						$item->menu_id = $model->id;

                        // $item->save();

                        if($item->save()){
                            //delete all translate
                            $item->deleteAllDataTranslate();
                            $languages = Languages::getAlllanguage();
                            if(is_array($languages)>0&&count($languages)>0){
                                foreach($languages as $lang){
                                    $translate = $item->getModelTranslate();
                                    $translate->language        = $lang->code;
                                    $translate->role_website_id = ROLE_WEBSITE_ID;
                                    $translate->translate_id    = $item->id;
                                    if($isnewiTem){
                                        $translate->name = isset($menuItems[$key][$lang->code]['name']) ? $menuItems[$key][$lang->code]['name'] : '';
                                    }else{
                                        $translate->name = isset($menuItems[$item->id][$lang->code]['name']) ? $menuItems[$item->id][$lang->code]['name'] : '';
                                    }
                                    $translate->save(false);
                                }
                            }
                            
                        }
						$item->save();

						$savedItems[$key] = $item;
						$realIds[$key] = $item->id;
					}
					
					/* set order, parent_id */
					foreach ($savedItems as $key => $item) {
						$item->order = $adtData[$key]['order'];
						$parentId = $adtData[$key]['parent_id'];
						$item->parent_id = $parentId ? $realIds[$parentId] : 0;
						$item->save();
					}
				}
				
				$this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been updated successfully.');
				$this->redirect(array('update', 'id' => $model->id));
			} else {
				$this->setNotifyMessage(NotificationType::Error, $this->singleTitle . ' cannot be updated for some reasons');
			}
		}

		$this->render('update', array(
			'model' => $model,
			'actions' => $this->listActionsCanAccess,
		));
	}
	
	private function _parseTree($nodes, &$data, $parentId=null, $order = 10) {
		foreach($nodes as $node) {
			$order += 10;
			$data[$node['id']] = array(
				'parent_id' => $parentId,
				'order' => $order,
			);
			
			if (isset($node['children'])) {
				$this->_parseTree($node['children'], $data, $node['id']);
			}
		}
	}

	private function updateParentKey($mainArray, $oldKey, $dbKey) {

		if (!empty($mainArray)) {
			$order = 1;
			$temp = $mainArray;
			foreach ($mainArray as $key => $item) {
				if ($item['parent_id'] == $oldKey) {
					$temp[$key]['parent_id'] = $dbKey;
				}
			}
		}
		return $temp;
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

	public function renderMenu($menuId) {
		$retMenu = array();
		$resHtml = '';
		Menuitem::viewMenuStructure($menuId, 0, 0, $retMenu);
		if (!empty($retMenu)) {
			foreach ($retMenu as $menuItem) {
				$prefix = "";
				for ($i = 0; $i < $menuItem['level']; $i++)
					$prefix .= "----";
				$resHtml .= $prefix . $menuItem['title'] . "<br />";
			}
		}
		return $resHtml;
	}

	/*
	 * Bulk delete
	 * If you don't want to delete some specified record please configure it in global $cannotDetele variable
	 */

	public function actionDeleteAll() {
		$deleteItems = $_POST['menu-grid_c0'];
		$shouldDelete = array_diff($deleteItems, $this->cannotDetele);

		if (!empty($shouldDelete)) {
			Menu::model()->deleteAll('id in (' . implode(',', $shouldDelete) . ')');
			$this->setNotifyMessage(NotificationType::Success, 'Your selected records have been deleted successfully.');
		} else
			$this->setNotifyMessage(NotificationType::Error, 'No records was deleted');

		if (!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	public function loadModel($id) {
		//need this define for inherit model case. Form will render parent model name in control if we don't have this line
		$initMode = new Menu();
		$model = $initMode->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	public function renderChilds($parent) {
		foreach ($parent->getChilds() as $child) {
			$this->renderPartial('item', array('item' => $child));
		}
	}

	public function actionRendernewitem() {
		$id = $_POST['newId'];
		$child = new Menuitem();
		$child->id = $id;
		$child->name = 'New menu item';
		$this->renderPartial('item', array('item' => $child));
	}

	public function actionRendernewpageitem($menuId) {
		$id = isset($_POST['newId']) ? $_POST['newId'] : '';
		$selectPage = isset($_POST['selectedpage']) ? $_POST['selectedpage'] : '';
		$html = '';
		if (!empty($selectPage)) {
			$pages = Page::model()->findAll('t.id in (' . implode(',', $selectPage) . ')');
			foreach ($pages as $page) {
				$child = new Menuitem();
				$child->id = $id;
				$child->page_id = $page->id;
				$child->name = $page->title;
				$html .= $this->renderPartial('new_item', array('item' => $child, 'id' => $id));
				$id++;
			}
		}
		echo $html;
	}

	public function actionRemoveMenuItem() {
		$id = isset($_POST['menuitemid']) ? $_POST['menuitemid'] : '';
		if ((int) $id > 0) {
			$deleteItem = Menuitem::model()->findByPk($id);
			Menuitem::model()->updateAll(array('parent_id' => $deleteItem->parent_id), 'parent_id = ' . $id);
			$deleteItem->delete();
		}
	}

	public function actionGetLinkInputHtml($type, $menuItemId) {
		$item = Menuitem::model()->findByPk($menuItemId);
		if (!$item) {
			$item = new Menuitem();
			$item->id = $menuItemId;
		}
		$item->type = $type;
		echo $this->getLinkInputHtml($item);
	}

	public function getLinkInputHtml($menuItem) {
		switch ($menuItem->type) {
			case Menuitem::TYPE_LINK:
				return CHtml::activeTextField($menuItem, "[$menuItem->id]link", array('class' => 'form-control'));
				break;

			case Menuitem::TYPE_CMS_PAGE:
				return CHtml::activeDropDownList($menuItem, "[$menuItem->id]link", Page::getPageTreeListData(), array('class' => 'form-control','encode'=>false));
				break;
			
			case Menuitem::TYPE_STATIC_PAGE:
//				$items = array();
//				foreach (Menuitem::$STATIC_PAGES as $item => $value) {
//					$items[Yii::app()->createAbsoluteUrl($item)] = $value;
//				}

				return CHtml::activeDropDownList($menuItem, "[$menuItem->id]link", Menuitem::$STATIC_PAGES, array('class' => 'form-control','encode'=>false));
//				return CHtml::activeDropDownList($menuItem, "[$menuItem->id]link", $items, array('class' => 'form-control','encode'=>false));
				break;
			case ($menuItem->type > Menuitem::TYPE_STATIC_PAGE): // case for get list from master file
					return CHtml::activeDropDownList($menuItem, "[$menuItem->id]link", Menuitem::getCateListData($menuItem->type), array('class' => 'form-control','encode'=>false));
					break;
		}
		return '';
	}

}
