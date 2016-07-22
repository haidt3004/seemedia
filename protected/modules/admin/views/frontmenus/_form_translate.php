<?php 
    // if(!$item->isNewRecord){
    //     $tmp = Menuitem::model()->findByPk($item->id);
    //     if($tmp){
    //         $item = $tmp->getDataTranslate();
    //     }
    // }

?>

<div class="form-group form-group-sm">
    <?php echo CHtml::activeLabel($item,"[$item->id]name", array('class' => 'col-sm-1 control-label')) ?>
    <div class="col-sm-9">
        <?php echo CHtml::activeTextField($item,"[$item->id][$language]name", array('class' => 'form-control')); ?>
        <?php echo CHtml::error($item,"[$item->id]name"); ?>
    </div>
</div>