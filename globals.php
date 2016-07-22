<?php

/**
 * This is the shortcut to DIRECTORY_SEPARATOR
 */
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

/**
 * This is the shortcut to Yii::app()
 * @return CWebApplication
 */
function app()
{
    return Yii::app();
}
 
/**
 * This is the shortcut to Yii::app()->clientScript
 * @return CClientScript
 */
function cs()
{
    return Yii::app()->getClientScript();
}

/**
 *  This is the shortcut to Yii::app()->user.
 * @return GWebUser
 */
function user() 
{
    return Yii::app()->user;
}
 
/**
 * This is the shortcut to Yii::app()->createUrl()
 */
function url($route, $params = array(), $ampersand = '&')
{
    return Yii::app()->createUrl($route, $params, $ampersand);
}
 
/**
 * This is the shortcut to CHtml::encode
 */
function h($text)
{
    return htmlspecialchars($text, ENT_QUOTES, Yii::app()->charset);
}
 
/**
 * This is the shortcut to CHtml::link()
 */
function l($text, $url = '#', $htmlOptions = array()) 
{
    return CHtml::link($text, $url, $htmlOptions);
}
 
/**
 * This is the shortcut to Yii::t() with default category = 'app'
 */
function t($message, $category = 'app', $params = array(), $source = null, $language = null) 
{
    return Yii::t($category, $message, $params, $source, $language);
}
 
/**
 * This is the shortcut to Yii::app()->request->baseUrl
 * If the parameter is given, it will be returned and prefixed with the app baseUrl.
 */
function bu($url=null) 
{
    static $baseUrl;
    if ($baseUrl === null)
        $baseUrl = Yii::app()->getRequest()->getBaseUrl();
    return $url === null ? $baseUrl : $baseUrl . '/' . ltrim($url,'/');
}


/**
 * Get configured data format
 */
function df($format = 'long')
{
    return param('dateFormats', $format);
}

/**
 * Convert date to a specific format
 */
function d($time = null, $format = 'long')
{
    if (!empty($time))
        $time = strtotime($time);
    else $time = time();

    return date(df($format), $time);
}

/**
 * Dump as many variables as you want. Infinite parameters.
 */
function dump()
{
    $args = func_get_args();
    foreach ($args as $k => $arg) {
        echo '<fieldset class="debug">';
        echo '<legend>' . ($k+1) . '</legend>';
        CVarDumper::dump($arg, 10, true);
        echo '</fieldset>';
    }
}

/**
 * Return path of an alias
 */
function poa($alias)
{
	return Yii::getPathOfAlias($alias);
}

function highlight($str, $terms)
{
    if(!is_array($terms)) {
        $terms = explode(" ", $terms);
    }
    foreach ($terms as $key => $search) {
        if(!empty($search))
            $str = preg_replace("/{$search}/i", '<mark>${0}</mark>', $str);
    }
    return $str;

}