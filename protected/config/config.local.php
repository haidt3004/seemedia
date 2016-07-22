<?php


/**
 * day la role dung de xac dinh user dang login thuoc ve website nao
 * lay theo id trong bang role_website
 */
// TAISIN.COM.SG = 1
// TAISIN.COM.MY = 2
// TAISIN.COM.VN = 3
// LIMKIMHAI.COM.SG = 4
// LIMKIMHAI.COM.VN = 5
// PRECION.COM.SG = 6
// LKHPOWERDISTRIBUTION.COM = 7
// CASTLAB.COM.SG = 8
// CASTLAB.COM.MY = 9
// CASTLAB.COM.ID = 10

// CastLab SG - done - groupBanner - removeSearch
//$THEME_NAME = 'CastLab';
//$THEME = 'CastLab';
//define('ROLE_WEBSITE_ID', 8);

// Lim Kim Hai Electric - done - groupBanner - removeSearch
//$THEME_NAME = 'LKHElec';
//$THEME = 'LKHElec';
//define('ROLE_WEBSITE_ID', 4);

// Lim Kim Hai Projects Distribution - done - groupBanner - removeSearch
//$THEME_NAME = 'LKHPower';
//$THEME = 'LKHPower';
//define('ROLE_WEBSITE_ID', 7);

// Lim Kim Hai Precion - done - groupBanner - removeSearch
//$THEME_NAME = 'LKHPre';
//$THEME = 'LKHPre';
//define('ROLE_WEBSITE_ID', 6);

// Tai Sin Electric - done - groupBanner - removeSearch
$THEME_NAME = 'TaiSinElec';
$THEME = 'TaiSinElec';
define('ROLE_WEBSITE_ID', 1);


$TABLE_PREFIX = 'hrportal';

include 'config_host/host.php';

//All defined items in Yii-core
//Please do not change if not require
define('BE', 1);
define('FE', 2);

define('ROLE_MANAGER', 1);
define('ROLE_ADMIN', 2);//GIONG NHAU
define('ROLE_SUPER_ADMIN', 2);//GIONG NHAU
define('ROLE_COMPANY_ADMIN', 3);//GIONG NHAU
define('ROLE_HR', 4);//GIONG NHAU


define('ROLE_NORMAL_MEMBER', 3);
define('ROLE_MEMBER', 5);

//max records in logger table
define('LOGGER_TABLE_MAX_RECORDS', 2000);

define('PASSW_LENGTH_MIN', 5);
define('PASSW_LENGTH_MAX', 32);

define('VERZ_COOKIE_ADMIN', md5('verz_cookie_admin'));
define('VERZ_COOKIE', md5('verz_cookie'));
define('VERZLOGIN', md5('verz_login'));
define('VERZLPASS', md5('verz_pass'));

define('VERZ_COOKIE_MEMBER', md5('verz_cookie_member'));
define('VERZLOGIN_MEMBER', md5('verz_login_member'));
define('VERZLPASS_MEMBER', md5('verz_pass_member'));

define('STATUS_INACTIVE', 0);
define('STATUS_ACTIVE', 1);
define('STATUS_NEW', 2);
define('STATUS_WAIT_ACTIVE_CODE', 3);

define('PASSWORD_WRONG', 0);
define('PASSWORD_CORRECT', 1);
define('PASSWORD_LOGOUT', 2);

define('TYPE_YES', 1);
define('TYPE_NO', 0);

//block
define('BLOCK_WIDTH', 100);
define('BLOCK_HEIGHT', 100);

// TAISIN.COM.SG = 1
define('MENU_MAIN', 1);
define('MENU_FOOTER', 2);

define('HOME_BANNER', 1);
define('WHISTLE_BLOW_HOME_BANNER', 2);
define('ANNOUNCEMENT_BANNER', 3);
define('POLICY_ORG_CHART_BANNER', 4);
define('WHISTLE_BLOW_BANNER', 5);
// END TAISIN.COM.SG = 1

// CASTLAB.COM.SG = 8
//define('MENU_MAIN', 5);
//define('MENU_FOOTER', 6);
//
//define('HOME_BANNER', 21);
//define('WHISTLE_BLOW_HOME_BANNER', 22);
//define('ANNOUNCEMENT_BANNER', 23);
//define('POLICY_ORG_CHART_BANNER', 24);
//define('WHISTLE_BLOW_BANNER', 25);
// END CASTLAB.COM.SG = 8

// LIMKIMHAI.COM.SG = 4
//define('MENU_MAIN', 3);
//define('MENU_FOOTER', 4);
//
//define('HOME_BANNER', 16);
//define('WHISTLE_BLOW_HOME_BANNER', 17);
//define('ANNOUNCEMENT_BANNER', 18);
//define('POLICY_ORG_CHART_BANNER', 19);
//define('WHISTLE_BLOW_BANNER', 20);
// END LIMKIMHAI.COM.SG = 4

// LKHPOWERDISTRIBUTION.COM = 7
//define('MENU_MAIN', 11);
//define('MENU_FOOTER', 2);
//
//define('MENU_FOOTER_COMPANY', 12);
//define('MENU_FOOTER_RELATED_LINKS', 13);
//
//define('HOME_BANNER', 36);
//define('WHISTLE_BLOW_HOME_BANNER', 37);
//define('ANNOUNCEMENT_BANNER', 38);
//define('POLICY_ORG_CHART_BANNER', 39);
//define('WHISTLE_BLOW_BANNER', 40);
// END LKHPOWERDISTRIBUTION.COM = 7

// PRECION.COM.SG = 6
//define('MENU_MAIN', 14);
//define('MENU_FOOTER', 2);
//
//define('MENU_FOOTER_01', 15);
//define('MENU_FOOTER_02', 16);
//define('MENU_FOOTER_03', 17);
//
//define('HOME_BANNER', 41);
//define('WHISTLE_BLOW_HOME_BANNER', 42);
//define('ANNOUNCEMENT_BANNER', 43);
//define('POLICY_ORG_CHART_BANNER', 44);
//define('WHISTLE_BLOW_BANNER', 45);
// END PRECION.COM.SG = 6

//CMS
define('EXTERNAL_PAGE', 0);
define('PAGE_SUCCESS_SIGN_UP', 1);
define('PAGE_SUCCESS_RESET_PASSWORD', 198);
define('PAGE_SUCCESS_ACTIVATE_ACCOUNT', 2);
define('PAGE_INVALID_REQUEST', 3);





//mail
define('MAIL_VERIFY_TO_RESET_PASSWORD_TO_ADMIN', 1);
define('MAIL_RESET_PASSWORD_TO_ADMIN', 2);
define('MAIL_CHANGE_PASSWORD_TO_ADMIN', 3);
define('MAIL_CREATE_ACCOUNT_TO_USER', 11);
define('MAIL_CHANGE_PASSWORD_TO_USER', 12);
define('MAIL_SUBCRIBER_SUCCESS', 14);
define('MAIL_CONTACT_TO_USER', 18);
define('MAIL_CONTACT_TO_ADMIN', 15);
define('MAIL_REGISTER_SUCCEED_TO_MEMBER', 16);
define('MAIL_REGISTER_SUCCEED_TO_ADMIN', 17);
define('MAIL_ORDER_LISTING_TO_USER', 19);
define('MAIL_ORDER_LISTING_TO_ADMIN', 20);
define('MAIL_USER_MODIFY_LISTING_TO_ADMIN', 21);
define('MAIL_TO_USER_WHEN_ADMIN_APPROVED_LISTING', 22);
define('MAIL_TO_USER_WHEN_ADMIN_CANCELLED_LISTING', 23);
define('MAIL_TO_USER_WHEN_LISTING_EXPIRED', 24);
define('MAIL_TO_USER_WHEN_LISTING_BEFORE_EXPIRED', 25);
define('MAIL_SUBCRIBER_CONFIRM', 27);
//merchant update their password
define('MAIL_TO_USER_WHEN_UPDATE_PASSWORD', 26);
define('MAIL_TO_ADMIN_WHEN_SEND_WHISTLE_BLOW', 75);



define('MAIL_RESET_PASSWOR_HR', 28);
define('MAIL_TO_ADMIN_USER_UPDATE_PROFILE', 80);






//max time for failed login to show captcha required
define('MAX_TIME_TO_SHOW_CAPTCHA', 2);
// Config step time interval booking (YES)
define('TIME_INTERVAL_STEP', 1800); // Unit Second

// Xuan Tinh: Define location
define('LOCATION_SG', 1); // Singapore
define('LOCATION_MY', 2); // Malaysia

define('SITE_SEARCH_LIMIT', 2);


?>