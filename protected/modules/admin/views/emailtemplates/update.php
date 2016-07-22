<?php
$this->breadcrumbs = array(
	$this->pluralTitle => array('index'),
	$model->email_subject => array('view', 'id' => $model->id),
	'Update',
);

$this->menu = array(
	array('label' => $this->pluralTitle, 'url' => array('index')),
//	array('label'=>'Create EmailTemplates', 'url'=>array('create')),
	array('label' => 'View ' . $this->singlelTitle, 'url' => array('view', 'id' => $model->id)),
);
?>
<h1>Update <?php echo $this->singlelTitle ?>: <?php echo $model->email_subject; ?></h1>
<?php echo $this->renderControlNav(); ?>
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
	