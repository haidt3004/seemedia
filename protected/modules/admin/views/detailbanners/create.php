<?php
$this->breadcrumbs=array(
	'Banners' => Yii::app()->createAbsoluteUrl('admin/groupbanners/index'),
	$this->pluralTitle => array('index', 'group_id' => $groupName->id),
	'Create ' . $this->singleTitle,
);

$this->menu = array(		
        array('label'=> $this->pluralTitle , 'url'=>array('index', 'group_id' => $groupName->id), 'icon' => $this->iconList),
);

?>

<h1>Create <?php echo $this->singleTitle; ?> of <?php echo $groupName->name?></h1>

<?php
//for notify message
$this->renderNotifyMessage(); 
//for list action button
echo $this->renderControlNav();
?><?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
