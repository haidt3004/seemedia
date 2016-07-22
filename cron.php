<?php
defined('YII_DEBUG') or define('YII_DEBUG',true);

// including Yii
define('ROOT', dirname(__FILE__));

$yii=dirname(__FILE__).'/../yii-framework-1.1.16/yii.php';
require_once($yii);

// we'll use a separate config file
$config=dirname(__FILE__).'/protected/config/cron.php';

// creating and running console application
Yii::createConsoleApplication($config);
SettingForm::applySettings();//override settings by values from database
Yii::app()->run();