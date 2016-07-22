<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class SettingForm extends CFormModel
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
//    public $defaultRecord;

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
    
    public $nationality;
    public $permanent_resident;
    public $fin;
    public $marital_status;
    public $number_of_children;
    public $driving_license_class_type;
    public $highest_education_level;
    public $certification_awarded;
    
    public $office;
    public $job_title;
    public $department;
    public $company;
    public $gender;
    public $date_of_birthday;//    public $dob;
    public $skills;
    public $educations;
    public $certification;
    public $languages;
    public $associations;
    public $about_my_self;
    
    public $account_types;
    
    public $country_of_residence;
    public $emergency_contact_person;
    public $relationship_of_emergency_contact_person;
    
    public $work_email_address;
    public $personal_email_address;
    public $house_address;//    public $address;
    public $secondary_address;
    public $house_phone_number; // public $home_phone_number;
    public $work_phone_number;
    public $mobile_phone;//    public $phone;
    public $twitter_accounts;
    public $im_accounts;
    public $yahoo_accounts;
    public $skype_accounts;
    public $viber_accounts;
    public $whatsapp;
    public $facebook_accounts_url;
    public $emergency;
    public $emergency_contact_number;
    public $multiple_Email;



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
        "pagesetting" => array(
            'label' => 'Website',
            'htmlOptions' => array(),
            'items' => array(
//                array('name' => 'baseUrl', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => 'required'),
                array('name' => 'projectName', 'controlTyle' => 'text', 'notes' => 'For backend only', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => 'required'),
                array('name' => 'defaultPageTitle', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => 'required'),
                array('name' => 'metaDescription', 'controlTyle' => 'textarea', 'notes' => '', 'unit' => '', 'htmlOptions' => array('cols' => 77, 'rows' => 4), 'rules' =>''),
                array('name' => 'metaKeywords', 'controlTyle' => 'textarea', 'notes' => '', 'unit' => '', 'htmlOptions' => array('cols' => 77, 'rows' => 4), 'rules' =>''),
                array('name' => 'linkedin', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' =>''),
                array('name' => 'facebook', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' =>''),
                // array('name' => 'pinterest', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' =>''),
//                array('name' => 'googleplus', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' =>''),
//                array('name' => 'twitter', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' =>''),
//                array('name' => 'youtube', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' =>''),
                array('name' => 'googleAnalytics', 'controlTyle' => 'textarea', 'notes' => '', 'unit' => '', 'htmlOptions' => array('cols' => 77, 'rows' => 4), 'rules' =>''),
                // array('name' => 'trialsListingDuration', 'controlTyle' => 'dropdown', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('' => 'Choose month', '1' => '1 month', '2' => '2 months', '3' => '3 months', '4' => '4 months', '5' => '5 months', '6' => '6 months', '7' => '7 months', '8' => '8 months', '9' => '9 months', '10' => '10 months', '11' => '11 months', '12' => '12 months'), 'rules' => 'required'),
                array('name' => 'messageOnPreviewPage', 'controlTyle' => 'textarea', 'notes' => '', 'unit' => '', 'htmlOptions' => array('class' => 'my-editor-full'), 'rules' =>''),
                array('name' => 'messageOnChooseAPlanPage', 'controlTyle' => 'textarea', 'notes' => '', 'unit' => '', 'htmlOptions' => array('class' => 'my-editor-full'), 'rules' =>''),
                array('name' => 'copyrightOnFooter', 'controlTyle' => 'textarea', 'notes' => '', 'unit' => '', 'htmlOptions' => array('class' => 'my-editor-full'), 'rules' =>''),
           ),
        ),
        "generalsetting" => array(
            'label' => 'General',
            'htmlOptions' => array(),
            'items' => array(
                // array('name' => 'currencySign', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' =>''),
                array('name' => 'defaultPassword', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => 'required'),
                array('name' => 'dateFormat', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => 'required'),
                array('name' => 'timeFormat', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => 'required'),
                array('name' => 'login_limit_times', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => 'required,numerical'),
                array('name' => 'time_refresh_login', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => 'required,numerical'),
                array('name' => 'defaultPageSize', 'controlTyle' => 'text', 'notes' => '', 'unit' => 'records per page', 'htmlOptions' => array('size' => 80), 'rules' => 'required,numerical'),
                array('name' => 'listingRemindBeforeExpiredDay', 'controlTyle' => 'text', 'notes' => '', 'unit' => 'days', 'htmlOptions' => array('size' => 80), 'rules' => 'required,numerical'),
                // array('name' => 'maxFeaturedListing', 'controlTyle' => 'text', 'notes' => 'Max Featured can be bought', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => 'required,numerical'),
//                array('name' => 'defaultRecord', 'controlTyle' => 'text', 'notes' => '', 'unit' => 'records per page', 'htmlOptions' => array('size' => 80), 'rules' => 'required,numerical'),
                
            ),
        ),

        "emailsetting" => array(
            'label' => 'Email',
            'htmlOptions' => array(),
            'items' => array(
                array('name' => 'mailSenderName', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => 'required'),
                array('name' => 'adminEmail', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => 'required,email'),
                array('name' => 'multiple_Email', 'controlTyle' => 'textarea', 'notes' => 'Use ; separated between the email', 'unit' => '', 'htmlOptions' => array('cols'=>77,'row'=>4,'size' => 80), 'rules' => 'required'),
//                array('name' => 'adminEmailIndonesia', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => 'required,email'),
                array('name' => 'autoEmail', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => 'required,email'),
                array('name' => 'transportType', 'controlTyle' => 'dropdown', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('' => 'PHP', 'smtp' => 'Smtp'), 'rules' => ''),
                array('name' => 'smtpHost', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => ''),
                array('name' => 'smtpUsername', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => ''),
                array('name' => 'smtpPassword', 'controlTyle' => 'password', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => ''),
                array('name' => 'smtpPort', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => ''),
                array('name' => 'encryption', 'controlTyle' => 'dropdown', 'notes' => '', 'unit' => '', 'data' => array('' => 'None', 'ssl' => 'SSL', 'tls' => 'TLS'), 'rules' => ''),
            ),
        ),

        "hrsetting" => array(
            'label' => 'Show Field Hr',
            'htmlOptions' => array(),
            'items' => array(
                array('name' => 'first_name', 'controlTyle' => 'checkbox', 'notes' => 'Max length 100', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'middle_name', 'controlTyle' => 'checkbox', 'notes' => 'Max length 100', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'last_name', 'controlTyle' => 'checkbox', 'notes' => 'Max length 100', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'nationality', 'controlTyle' => 'checkbox', 'notes' => 'Max length 100', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'permanent_resident', 'controlTyle' => 'checkbox', 'notes' => 'Select box', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'fin', 'controlTyle' => 'checkbox', 'notes' => 'Max length 9', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'marital_status', 'controlTyle' => 'checkbox', 'notes' => 'Select box', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'number_of_children', 'controlTyle' => 'checkbox', 'notes' => 'Number', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'driving_license_class_type', 'controlTyle' => 'checkbox', 'notes' => 'Max length 200', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'highest_education_level', 'controlTyle' => 'checkbox', 'notes' => 'Max length 200', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'certification_awarded', 'controlTyle' => 'checkbox', 'notes' => 'Max length 200', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'office', 'controlTyle' => 'checkbox', 'notes' => 'Max length 200', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'job_title', 'controlTyle' => 'checkbox', 'notes' => 'Max length 200', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'department', 'controlTyle' => 'checkbox', 'notes' => 'Max length 200', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'company', 'controlTyle' => 'checkbox', 'notes' => 'Max length 200', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'gender', 'controlTyle' => 'checkbox', 'notes' => 'Select box', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'date_of_birthday', 'controlTyle' => 'checkbox', 'notes' => 'Date', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'skills', 'controlTyle' => 'checkbox', 'notes' => 'Text', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'educations', 'controlTyle' => 'checkbox', 'notes' => 'Text', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'certification', 'controlTyle' => 'checkbox', 'notes' => 'Text', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'languages', 'controlTyle' => 'checkbox', 'notes' => 'Text', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'associations', 'controlTyle' => 'checkbox', 'notes' => 'Text', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'about_my_self', 'controlTyle' => 'checkbox', 'notes' => 'Text', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'account_types', 'controlTyle' => 'checkbox', 'notes' => 'Max length 100', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'country_of_residence', 'controlTyle' => 'checkbox', 'notes' => 'Max length 100', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'work_email_address', 'controlTyle' => 'checkbox', 'notes' => 'Max length 200', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'personal_email_address', 'controlTyle' => 'checkbox', 'notes' => 'Max length 200', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'house_address', 'controlTyle' => 'checkbox', 'notes' => 'Text', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'secondary_address', 'controlTyle' => 'checkbox', 'notes' => 'Text', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'house_phone_number', 'controlTyle' => 'checkbox', 'notes' => 'Max length 30', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'work_phone_number', 'controlTyle' => 'checkbox', 'notes' => 'Max length 30', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'mobile_phone', 'controlTyle' => 'checkbox', 'notes' => 'Max length 30', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'twitter_accounts', 'controlTyle' => 'checkbox', 'notes' => 'Max length 255', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'im_accounts', 'controlTyle' => 'checkbox', 'notes' => 'Max length 255', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'yahoo_accounts', 'controlTyle' => 'checkbox', 'notes' => 'Max length 255', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'skype_accounts', 'controlTyle' => 'checkbox', 'notes' => 'Max length 255', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'viber_accounts', 'controlTyle' => 'checkbox', 'notes' => 'Max length 255', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'whatsapp', 'controlTyle' => 'checkbox', 'notes' => 'Max length 255', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'facebook_accounts_url', 'controlTyle' => 'checkbox', 'notes' => 'Max length 255', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'emergency', 'controlTyle' => 'checkbox', 'notes' => 'Text', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'emergency_contact_person', 'controlTyle' => 'checkbox', 'notes' => 'Max length 200', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'relationship_of_emergency_contact_person', 'controlTyle' => 'checkbox', 'notes' => 'Max length 200', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
                array('name' => 'emergency_contact_number', 'controlTyle' => 'checkbox', 'notes' => 'Max length 30', 'unit' => '', 'htmlOptions' => array(), 'data' => array('hide' => 'Hide', 'show' => 'Show'), 'rules' => ''),
            ),
        ),
        
        // "mailchimp" => array(
        //         'label' => 'Mailchimp',
        //         'htmlOptions' => array(),
        //         'items' => array(
        //                 array('name' => 'mailchimp_on', 'controlTyle' => 'dropdown', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'data' => array('yes' => 'Yes', 'no' => 'No'), 'rules' => ''),
        //                 array('name' => 'mailchimp_api_key', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => ''),
        //                 array('name' => 'mailchimp_list_id', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => ''),
        //         ),
        // ),
        
        // "redemptioncode" => array(
        //         'label' => 'Redemption Code',
        //         'htmlOptions' => array(),
        //         'items' => array(
        //                 array('name' => 'code_1', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80, 'placeholder' => 'code'), 'rules' => ''),
        //                 array('name' => 'code_rate_1', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80, 'placeholder' => '%'), 'rules' => 'numerical'),
        //                 array('name' => 'plan_code_1', 'controlTyle' => 'dropdown', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array(Listings::SELECT_MONTHLY => 'Monthly', Listings::SELECT_QUARTERLY => 'Quarterly', Listings::SELECT_YEARLY => 'Yearly'), 'rules' => ''),
        //                 array('name' => 'code_2', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80, 'placeholder' => 'code'), 'rules' => ''),
        //                 array('name' => 'code_rate_2', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80, 'placeholder' => '%'), 'rules' => 'numerical'),
        //                 array('name' => 'plan_code_2', 'controlTyle' => 'dropdown', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array(Listings::SELECT_MONTHLY => 'Monthly', Listings::SELECT_QUARTERLY => 'Quarterly', Listings::SELECT_YEARLY => 'Yearly'), 'rules' => ''),
        //                 array('name' => 'code_3', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80, 'placeholder' => 'code'), 'rules' => ''),
        //                 array('name' => 'code_rate_3', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80, 'placeholder' => '%'), 'rules' => 'numerical'),
        //                 array('name' => 'plan_code_3', 'controlTyle' => 'dropdown', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array(Listings::SELECT_MONTHLY => 'Monthly', Listings::SELECT_QUARTERLY => 'Quarterly', Listings::SELECT_YEARLY => 'Yearly'), 'rules' => ''),
        //         ),
        // ),

        /*"contactsetting" => array(
            'label' => 'Contact',
            'htmlOptions' => array(),
            'items' => array(
//                array('name' => 'companyName', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => ''),
//                array('name' => 'companyAddress', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => ''),
//                array('name' => 'contactFreeText', 'controlTyle' => 'textarea', 'notes' => '', 'unit' => '', 'htmlOptions' => array('cols' => 77, 'rows' => 4), 'rules' => ''),
                array('name' => 'contactFreeTextForSingapore', 'controlTyle' => 'textarea', 'notes' => '', 'unit' => '', 'htmlOptions' => array('class' => 'my-editor-full'), 'rules' =>''),
                array('name' => 'contactFreeTextForIndonesia', 'controlTyle' => 'textarea', 'notes' => '', 'unit' => '', 'htmlOptions' => array('class' => 'my-editor-full'), 'rules' =>''),

            ),
        ),
        
        "gst_setting" => array(
                'label' => 'GST Setting',
                'htmlOptions' => array(),
                'items' => array(
                        array('name' => 'enable_gst', 'controlTyle' => 'dropdown', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('1' => 'Active', '0' => 'Inactive'), 'rules' => ''),
                        array('name' => 'gst', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => ''),
                ),
        ),
*/
  //       "paypalsettingsg" => array(
  //          'label' => 'Singapore Paypal',
  //           'htmlOptions' => array(),
  //           'items' => array(
  //               array('name' => 'paypalBusinessEmailSG', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => ''),
  //               array('name' => 'paypalTypeSG', 'controlTyle' => 'dropdown', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('live'=>'Live Payment', 'test'=>'Test Payment'), 'rules' => ''),
  //           ),
  //       ),
		// "paypalsettingmy" => array(
  //          'label' => 'Malaysia Paypal',
  //           'htmlOptions' => array(),
  //           'items' => array(
  //               array('name' => 'paypalBusinessEmailMY', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => array('size' => 80), 'rules' => ''),
  //               array('name' => 'paypalTypeMY', 'controlTyle' => 'dropdown', 'notes' => '', 'unit' => '', 'htmlOptions' => array(), 'data' => array('live'=>'Live Payment', 'test'=>'Test Payment'), 'rules' => ''),
  //           ),
  //       ),
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
			'multiple_Email' => Yii::t('translation', 'Multiple HR Admin Email'),
		);
	}










}