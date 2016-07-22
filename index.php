<?php
//error_reporting(E_ALL);
date_default_timezone_set('Asia/Singapore');
define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);
define('ROOT', dirname(__FILE__));
define('YII_PROTECTED_DIR', ROOT . DS . 'protected');
define('YII_THEMES_DIR', ROOT . DS . 'themes');
define('YII_UPLOAD_DIR', ROOT . DS . 'upload');
define('YII_UPLOAD_FOLDER', 'upload');

require('globals.php');
$yii='../../framework/1.16/yii.php';
$config = dirname(__FILE__) . '/protected/config/main.php';

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

require_once($yii);

Yii::createWebApplication($config);
//SettingForm::applySettings(); //override settings by values from database
SettingsMultiSite::applySettings();

Yii::app()->run();

