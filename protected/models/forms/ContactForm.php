<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class ContactForm extends CFormModel {

    public $name;
    public $phone;
    public $email;
    public $subject;
    public $message;

    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array(
            // name, email, subject and body are required
            array('name, email, subject, message', 'required'),
            array('phone', 'length', 'max' => 30),
            array('name, email', 'length', 'max' => 200),
            array('email', 'email'),
//            array('phone', 'checkPhone'),
            array('id, name, email, subject, message', 'safe'),
        );
    }

    public function checkPhone($attribute, $params) {
        if ($this->$attribute != '') {
            $pattern = '/^[\(]?(\+)?(\d{0,3})[\)]?[\s]?[\-]?(\d{0,9})[\s]?[\-]?(\d{0,9})[\s]?[x]?(\d*)$/';
            $containsDigit = preg_match($pattern, $this->$attribute);
            $lb = $this->getAttributeLabel($attribute);
            if (!$containsDigit)
                $this->addError($attribute, "$lb must be numerical and  allow input (),+,-");
        }
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels() {
        return array(
            'email' => 'Email',
            'name' => 'Name',
            'phone' => 'Phone',
            'offices' => 'Offices',
            'country' => 'Country',
        );
    }

    protected function beforeValidate() {
        $this->name = trim($this->name);
        $this->phone = trim($this->phone);
        $this->email = trim($this->email);
        return parent::beforeValidate();
    }

    public function beforeSendMail() {
//        $country = Country::model()->findByPk($model->country);
//        $offices = Office::model()->findAll('country_id = '.$model->country);
//        $array_1 = array();
//        $array_2 = array();
//        foreach ($offices as $k=>$v){
//            $array_1[] = $v->id;
//        }
//        //offices were selected
//        $offices_select = $model->offices;
//        foreach ($offices_select as $key=>$val){
//            $array_2[] = $val;
//        }
//        $result = array();
//        $result = array_intersect($array_1, $array_2);
//        $model->offices = $result;
    }
    public function sendMail() {
        $this->beforeSendMail();
        //send mail
        SendEmail::noticeContactMailToAdmin($this);
        SendEmail::confirmContactMailToUser($this);
//        Yii::app()->user->setFlash('msg', 'Thank you for contacting us. We will respond to you as soon as possible.');
    }

}
