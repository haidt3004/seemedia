<?php
class EnquiryWidget extends CWidget {
    
    function run() {
        $model = new ContactForm('create');
        //auto fill
        if(isset(Yii::app()->user->id))
        {
            $mUser = Users::model()->findByPk(Yii::app()->user->id);
            if($mUser)
            {
                $model->name = $mUser->full_name;
                $model->email = $mUser->email;
                $model->phone = $mUser->phone;
            }
        }
        if(isset($_POST['ContactForm']))
        {
            $model->attributes = $_POST['ContactForm'];
            if($model->validate()) {
                $model->sendMail();
                $this->getController()->redirect(Yii::app()->createAbsoluteUrl('cms/index', array('slug' => 'thanks')));
                $this->getController()->refresh();
            }
        }
        $this->render("$this->skin/enquiry", array(
            'model' => $model
        ));
    }
}
