<?php
/* @var $this FrontmenusController */
/* @var $item Menuitem */
?>

<?php $item->getDataTranslate(); ?>

<li id="menu-<?php echo $item->id?>" class="dd-item menuItem" data-id="<?php echo $item->id?>">
    <span class="close-menu hidden-symbol close-menu-<?php echo $item->id?>">+</span>
	<span class="glyphicon glyphicon-remove-circle pull-right remove-menu" id="removemenu-<?php echo $item->id?>" title="Remove menu"></span>
    <div class="dd-handle"><?php echo $item->name?> </div>
	
    <div class="data-menu-<?php echo $item->id?> data-wrap" style="display: none; clear: both">

        <ul class="nav nav-tabs">
            <?php foreach(Languages::getAlllanguage() as $key=> $lang): ?>
            <li class="<?php echo ($key=='') ? 'active' : ''; ?>">
                <a data-toggle="tab" href="#<?php echo $lang->code ?>-<?php echo $item->id?>"><?php echo $lang->title;?></a>
            </li>
            <?php endforeach; ?>
        </ul>
        <div class="tab-content">
             <?php foreach(Languages::getAlllanguage() as $key=> $lang): ?>
            <div id="<?php echo $lang->code ?>-<?php echo $item->id?>" class="tab-pane <?php echo ($key=='') ? 'active' : 'fade'; ?>">
                <?php $this->renderPartial(
                                            '_form_translate',
                                            array(
                                                    'language'   => $lang->code,
                                                    'item'=>$item->getDataWithLangauge($item,$lang->code)
                                                )
                                        ); 
                                    ?>
            </div>
            <?php endforeach; ?>
        </div>


		<div class="form-group form-group-sm">
			<?php echo CHtml::activeLabel($item,"[$item->id]status", array('class' => 'col-sm-1 control-label')) ?>
			<div class="col-sm-9">
			<?php echo CHtml::activeDropDownList($item,"[$item->id]status", array(STATUS_ACTIVE => 'Active', STATUS_INACTIVE => 'Inactive'), array('class' => 'form-control')); ?>
			<?php echo CHtml::error($item,"[$item->id]status"); ?>
			</div>
		</div>
		<div class="form-group form-group-sm">
			<?php echo CHtml::activeLabel($item,"[$item->id]target", array('class' => 'col-sm-1 control-label')) ?>
			<div class="col-sm-9">
			<?php echo CHtml::activeDropDownList($item,"[$item->id]target", array('_self' => '_self', '_blank' => '_blank'), array('class' => 'form-control')); ?>
			<?php echo CHtml::error($item,"[$item->id]target"); ?>
			</div>
		</div>
		<div class="form-group form-group-sm">
			<?php echo CHtml::activeLabel($item,"[$item->id]type", array('class' => 'col-sm-1 control-label')) ?>
			<div class="col-sm-9">
			<?php echo CHtml::activeDropDownList($item,"[$item->id]type", Menuitem::$TYPES, array('class' => 'form-control typeSel', 'empty'=>'--Select--')); ?>
			<?php echo CHtml::error($item,"[$item->id]type"); ?>
			</div>
		</div>
		<div class="form-group form-group-sm" id="div-link-<?php echo $item->id;?>">
			<?php echo CHtml::activeLabel($item,"[$item->id]link", array('class' => 'col-sm-1 control-label')) ?>
			<div class="col-sm-9">
			<div class="linkInput"><?php echo $this->getLinkInputHtml($item) ?></div>
			<?php echo CHtml::error($item,"[$item->id]link"); ?>
			</div>
		</div>
		<div class="clr"></div>
    </div>
	
    <?php $childs = $item->getChilds(); ?>
    <?php if(!empty($childs)): ?>
       <ol class="dd-list">
           <?php $this->renderChilds($item) ?>
       </ol>
    <?php endif ?>
 </li>