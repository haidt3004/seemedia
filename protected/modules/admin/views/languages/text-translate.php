<?php
$this->breadcrumbs=array(
    $this->pluralTitle => array('index'),
    'Text Translate' ,
);

$this->menu = array(        
        array('label'=> $this->pluralTitle , 'url'=>array('index'), 'icon' => $this->iconList),
);

?>

<h1>Text Translate</h1>

<?php
    $this->renderNotifyMessage(); 
    echo $this->renderControlNav();
?>

<?php echo $this->renderPartial('_form_text_translate', array('model'=>$model,'mtranslate'=>$mtranslate,'allFiled'=>$allFiled)); ?>
