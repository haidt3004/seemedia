<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class SettingHrForm extends CFormModel
{
    //email
    public $transportType; //php or smtp
    public $smtpHost;
    public $smtpUsername;
    public $smtpPassword;
    public $smtpPort;
    public $encryption;
    public $adminEmail;
    public $adminEmailIndonesia;
    public $autoEmail;
    public $mailSenderName;

    //general
    public $currencySign;
    public $dateFormat;
    public $timeFormat;
    public $login_limit_times;
    public $time_refresh_login;
    public $defaultPageSize;
    public $googleAnalytics;
    public $listingRemindBeforeExpiredDay;

    public $defaultPassword;


    //contact info
    public $companyName;
    public $companyAddress;
    public $contactFreeText;
    public $contactFreeTextForSingapore;
    public $contactFreeTextForIndonesia;

    //paypal for Singapore
    public $paypalBusinessEmailMY;
    public $paypalTypeMY;

    public $paypalURL;
    public $paypalMode;
    public $paypalMinimum;
    public $paypalCurrency;
    public $merchant_acc_no;

    //paypal for Singapore
    public $paypalBusinessEmailSG;
    public $paypalTypeSG;

    //page setting
    public $baseUrl;
    public $projectName;
    public $defaultPageTitle;
    public $metaDescription;
    public $metaKeywords;
    public $twitter;
    public $facebook;
    public $pinterest;
    public $linkedin;
//    public $googleplus;
//    public $youtube;
    public $rss;
    public $copyrightOnFooter;
    public $trialsListingDuration;
    public $messageOnPreviewPage;
    public $messageOnChooseAPlanPage;

    //link select country
    public $link_singapore;
    public $link_indonesia;
    public $link_indonesia_bahasa;

    //mailchimp
    public $mailchimp_on;
    public $mailchimp_api_key;
    public $mailchimp_list_id;
    public $mailchimpTitleGroups;
    public $gst;
    public $enable_gst;

    // Redemption Code
    public $code_1;
    public $code_rate_1;
    public $code_2;
    public $code_rate_2;
    public $code_3;
    public $code_rate_3;
    public $plan_code_1;
    public $plan_code_2;
    public $plan_code_3;

    public $maxFeaturedListing;

    //hr
    public $first_name;
    public $middle_name;
    public $last_name;
    public $office;
    public $job_title;
    public $department;
    public $company;
    public $gender;
//    public $dob;
    public $date_of_birthday;
    public $skills;
    public $educations;
    public $certification;
    public $languages;
    public $associations;
    public $about_my_self;
    public $account_types;
    public $work_email_address;
    public $personal_email_address;
//    public $address;
    public $main_address;
    public $secondary_address;
    public $home_phone_number;
    public $work_phone_number;
//    public $phone;
    public $mobile_phone;
    public $twitter_accounts;
    public $im_accounts;
    public $yahoo_accounts;
    public $skype_accounts;
    public $viber_accounts;
    public $whatsapp;
    public $facebook_accounts_url;
    public $emergency;
    public $emergency_contact_number;


    public static $smtpFields = array('host' => 'smtpHost', 'username' => 'smtpUsername', 'password' => 'smtpPassword',
        'port' => 'smtpPort', 'encryption' => 'encryption');

    /*
      * Austin added date 6/7/2014
      * First element of array is Group Name
      * Items inside are controls in each tab. You should put enough attributes as below to get rid errors
      * Now it just support control text, textarea, editor (add html class my-editor-basic or my-editor-full), image, dropdown
      * Feel free to add more
      */
    public static $settingDefine = array(

        "hrsetting" => array(
            'label' => 'Show Field Hr',
            'htmlOptions' => array(),
            'items' => array(
                array('name' => 'first_name', 'controlTyle' => 'checkbox', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'middle_name', 'controlTyle' => 'checkbox', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'last_name', 'controlTyle' => 'checkbox', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'office', 'controlTyle' => 'checkbox', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'job_title', 'controlTyle' => 'checkbox', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'department', 'controlTyle' => 'checkbox', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'company', 'controlTyle' => 'checkbox', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'gender', 'controlTyle' => 'checkbox', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'date_of_birthday', 'controlTyle' => 'checkbox', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'skills', 'controlTyle' => 'checkbox', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'educations', 'controlTyle' => 'checkbox', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'certification', 'controlTyle' => 'checkbox', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'languages', 'controlTyle' => 'checkbox', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'associations', 'controlTyle' => 'checkbox', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'about_my_self', 'controlTyle' => 'checkbox', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'account_types', 'controlTyle' => 'checkbox', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'work_email_address', 'controlTyle' => 'checkbox', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'personal_email_address', 'controlTyle' => 'checkbox', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'main_address', 'controlTyle' => 'checkbox', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'secondary_address', 'controlTyle' => 'checkbox', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'home_phone_number', 'controlTyle' => 'checkbox', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'work_phone_number', 'controlTyle' => 'checkbox', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'mobile_phone', 'controlTyle' => 'checkbox', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'twitter_accounts', 'controlTyle' => 'checkbox', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'im_accounts', 'controlTyle' => 'checkbox', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'yahoo_accounts', 'controlTyle' => 'checkbox', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'skype_accounts', 'controlTyle' => 'checkbox', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'viber_accounts', 'controlTyle' => 'checkbox', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'whatsapp', 'controlTyle' => 'checkbox', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'facebook_accounts_url', 'controlTyle' => 'checkbox', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'emergency', 'controlTyle' => 'checkbox', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'emergency_contact_number', 'controlTyle' => 'checkbox', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
            ),
        ),
    );


    public function rules()
    {
        $return = array();
        // for reuired attribute
        $requiredRule = self::getRules('required');
        if ($requiredRule != '')
            $return []= array($requiredRule, 'required');

        // for numerical attribute
        $numerical = self::getRules('numerical');
        if ($numerical != '')
            $return []=array($numerical, 'numerical', 'integerOnly' => true);

        // for email attribute
        $email = self::getRules('email');
        if ($email != '')
            $return []=array($email, 'email');

        // for file attribute
        $file = self::getRules('file');
        if ($file != '')
        {
            $return[] = array($file, 'file','on'=>'updateSettings',
                'allowEmpty'=>true,
                'types'=> 'jpg,gif,png,tiff',
                'wrongType'=>'Only jpg,gif,png,tiff allowed',
                'maxSize' => 1024 * 1024 * 3, // 8MB
                'tooLarge' => 'The file was larger than 3MB. Please upload a smaller file.',
            );
            $return[] = array('$file', 'match', 'pattern'=>'/^[^\\/?*:&;{}\\\\]+\\.[^\\/?*:&;{}\\\\]{3}$/', 'message'=>'Upload files name cannot include special characters: &%$#', 'on'=>'updateSettings');
        }
        // for safe attribute
        $return[] = array(implode(',', self::getAllAttributes()), 'safe');
        return $return;
    }

    /*
      * Austin added date 6/7/2014
      * Override configurations.
      * This function is called in index.php and cron.php in root
      */

    public static function applySettings()
    {
        $attributeList = self::getAllAttributes();
        if ($attributeList && is_array($attributeList))
        {
            foreach ($attributeList as $item)
            {
                //check tranport type
                if ($item == 'transportType' && Yii::app()->setting->getItem($item))
                {
                    Yii::app()->mail->transportType = Yii::app()->setting->getItem($item);

                }
                //get SMTP info
                if (Yii::app()->mail->transportType == 'smtp')
                {
                    if (in_array($item, self::$smtpFields))
                    {
                        if (Yii::app()->setting->getItem($item))
                        {
                            foreach(self::$smtpFields as $k=>$v)
                            {
                                if($v == $item)
                                    Yii::app()->mail->transportOptions[$k] = Yii::app()->setting->getItem($item);
                            }
                        }
                    }
                }
                else
                {
                    Yii::app()->mail->transportOptions = '';
                }

                // none SMTP fields
                if (!in_array($item, self::$smtpFields) && Yii::app()->setting->getItem($item))
                {
                    Yii::app()->params[$item] = Yii::app()->setting->getItem($item);
                }
            }
        }
    }

    /*
      * Austin added date 6/7/2014
      * get all attributes from setting array
      */

    public static function getAllAttributes()
    {
        $attributes = array();
        if (self::$settingDefine && is_array(self::$settingDefine))
        {
            foreach (self::$settingDefine as $item)
            {
                $itemObj = (object)$item;
                if ($itemObj->items && is_array($itemObj->items))
                {
                    foreach($itemObj->items as $setItem)
                    {
                        $setItem = (object)$setItem;
                        $attributes[] = $setItem->name;
                    }
                }
            }
        }
        return $attributes;
    }



    /*
      * Austin added date 7/7/2014
      * Build model vaidate rule
      */

    protected static function getRules($ruleName)
    {
        $attributes = array();
        if (self::$settingDefine && is_array(self::$settingDefine))
        {
            foreach (self::$settingDefine as $item)
            {
                $itemObj = (object)$item;
                if ($itemObj->items && is_array($itemObj->items))
                {
                    foreach($itemObj->items as $setItem)
                    {
                        $setItem = (object)$setItem;
                        if (strpos($setItem->rules, $ruleName) !== false)
                            $attributes[] = $setItem->name;
                    }
                }
            }
        }
        return implode(',', $attributes);
    }

    /**
     * Author : Haidt
     * Description: add label for attributes
     */

    public function attributeLabels() {
        return array(
            'code_1' => Yii::t('translation', 'Code'),
            'code_2' => Yii::t('translation', 'Code'),
            'code_3' => Yii::t('translation', 'Code'),
            'defaultPassword' => Yii::t('translation', 'Password Default'),
            'paypalBusinessEmailMY' => Yii::t('translation', 'Paypal Business Email'),
            'paypalTypeMY' => Yii::t('translation', 'Paypal Type'),
            'paypalBusinessEmailSG' => Yii::t('translation', 'Paypal Business Email'),
            'paypalTypeSG' => Yii::t('translation', 'Paypal Type'),
        );
    }










}