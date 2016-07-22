<link href="<?php echo Yii::app()->theme->baseUrl; ?>/admin/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/admin/css/main.css" rel="stylesheet">
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/admin/css/multiple-select.css" rel="stylesheet">
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/admin/css/bootstrap-responsive.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/admin/css/form.css" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/admin/css/nestable.css" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/admin/css/chosen.css" />
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/admin/css/bootstrap-multiselect.css" type="text/css">
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/admin/css/custom.css" rel="stylesheet">
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/admin/css/colorbox.css" rel="stylesheet">

<?php Yii::app()->getClientScript()->registerCoreScript('jquery'); ?>
<?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>

<script src="<?php echo Yii::app()->theme->baseUrl; ?>/admin/js/jquery.multiple.select.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/admin/js/chosen.jquery.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/admin/js/menu/jquery.nestable.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/admin/js/bootstrap-multiselect.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/admin/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl . '/admin/colorbox/jquery.colorbox-min.js'; ?>"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.fileupload.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/admin/js/bootstrap.file-input.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/admin/js/custom.js"></script>
<div id="main_box">
    <div class="clr"></div>
	<?php echo $content; ?>
    <div class="clr"></div>
</div>

