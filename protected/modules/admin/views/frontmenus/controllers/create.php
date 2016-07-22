<?php
$this->breadcrumbs=array(
	'Controllers'=>array('index'),
	'Create',
);

$menus=array(
	array('label'=>'Group Privileges', 'url'=>array('group')),
        array('label'=>'User Privileges', 'url'=>array('user')),
);
$this->menu= ControllerActionsName::createMenusRoles($menus, $actions);
?>

<h1>Create Controllers</h1>
<?php echo $this->renderControlNav();?>
<?php echo $this->renderPartial('_form2', array('model'=>$model)); ?>