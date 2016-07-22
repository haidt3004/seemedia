<?php
$this->breadcrumbs = array(
	'Banners' => Yii::app()->createAbsoluteUrl('admin/groupbanners/index'),
	$groupName->name => array('index', 'group_id' => $groupName->id),
	'Update : ' . $title_name,
);

$this->menu = array(	
	array('label' => $this->pluralTitle, 'url' => array('index', 'group_id' => $groupName->id), 'icon' => $this->iconList),
	array('label' => 'View ' . $this->singleTitle, 'url' => array('view', 'id' => $model->id, 'group_id' => $groupName->id)),	
//	array('label' => 'Create ' . $this->singleTitle, 'url' => array('create', 'group_id' => $groupName->id)),
);
?>

<h1>Update <?php echo $this->singleTitle . ': ' . $title_name; ?></h1>

<?php
//for notify message
$this->renderNotifyMessage(); 
//for list action button
echo $this->renderControlNav();
?><?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
