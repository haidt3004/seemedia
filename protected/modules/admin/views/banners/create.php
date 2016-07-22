<?php
$this->breadcrumbs=array(
	'Banner Management' => array('index'),
	'Create Home ' . $this->singleTitle,
);

$this->menu = array(		
        array('label'=> 'Banner Management' , 'url'=>array('index'), 'icon' => $this->iconList),
);

?>

<h1>Create Home <?php echo $this->singleTitle; ?></h1>

<?php
//for notify message
$this->renderNotifyMessage(); 
//for list action button
echo $this->renderControlNav();
?><?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
