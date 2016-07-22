
<title><?php echo CHtml::encode($this->pageTitle).' - '. Yii::app()->params['defaultPageTitle']; ?></title>
<link rel="SHORTCUT ICON" href="<?php echo Yii::app()->theme->baseUrl ?>/themes/favicon.ico" type="image/x-icon" />
<link rel="apple-touch-icon" href="<?php echo Yii::app()->theme->baseUrl ?>/themes/favicon.png" />
<meta charset="utf-8" />
<meta name="copyright" content="<?php echo CHtml::encode($this->pageTitle); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta content="telephone=no" name="format-detection" />
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/../all-themes/css/font-awesome.min.css" />
<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
<?php
$desc = $this->getMetaDescription();
$keyword = $this->getMetaKeywords();
if (!empty($desc)) {
	?>
	<meta content="<?php echo $desc; ?>" name="description">
	<?php
}
if (!empty($keyword)) {
	?>
	<meta content="<?php echo $keyword; ?>" name="keywords">
<?php } ?>

<!--haidt - css should be here-->
<link href="<?php echo Yii::app()->theme->baseUrl ?>/../all-themes/css/main.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/../admin/css/jquery-ui-1.8.18.custom.css" type=text/css rel=stylesheet>
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/../all-themes/css/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/../all-themes/css/main.css" />
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/themes/css/style.css" />
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/../all-themes/css/custom.css" />
<link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<!--[if lt IE 9]>
<link href="<?php echo Yii::app()->theme->baseUrl ?>/css/fixie8.css" rel="stylesheet" media="screen" />
<![endif]-->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<?php Yii::app()->getClientScript()->registerCoreScript('jquery'); ?>
<?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/../admin/js/gii.js"></script>
