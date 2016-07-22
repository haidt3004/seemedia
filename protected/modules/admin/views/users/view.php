<?php
$this->breadcrumbs = array(
    $this->pluralTitle => array('index'),
    'View ' . $this->singleTitle . ' : ' . $title_name,
);

$this->menu = array(
    array('label' => $this->pluralTitle, 'url' => array('index'), 'icon' => $this->iconList),
    array('label' => 'Update ' . $this->singleTitle, 'url' => array('update', 'id' => $model->id)),
);
?>
<h1>View <?php echo $this->singleTitle . ' : ' . $title_name; ?></h1>

<?php
//for notify message
$this->renderNotifyMessage();
//for list action button
echo $this->renderControlNav();
?><div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><span class="glyphicon glyphicon-list-alt"></span> View <?php echo $this->singleTitle ?></h3>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'label' => '',
                    'type' => 'html',
                    'value' => '<strong>ACCOUNT INFORMATION</strong>'
                ),
                'username',
                'email',
                'status:status',
                array(
                    'name' => 'language_id',
                    'value' => (isset($model->language_pk)) ? $model->language_pk->title : '' 
                ),            
                array(
                    'label' => '',
                    'type' => 'html',
                    'value' => '<strong>PROFILE INFORMATION</strong>'
                ),
                'staff_name',
                array(
                    'name' => 'first_name',
                    'visible' => (Yii::app()->params['first_name'] )
                ),
                array(
                    'name' => 'middle_name',
                    'visible' => (Yii::app()->params['middle_name'] )
                ),
                array(
                    'name' => 'last_name',
                    'visible' => (Yii::app()->params['last_name'] )
                ),
                array(
                    'name' => 'nationality',
                    'visible' => (Yii::app()->params['nationality'] )
                ),
                array(
                    'name' => 'permanent_resident',
                    'value' => (isset($model->permanent_resident) && $model->permanent_resident != '') ? $model->optionYesNo[$model->permanent_resident] : '',
                    'visible' => (Yii::app()->params['permanent_resident'] )
                ),
                array(
                    'name' => 'fin',
                    'visible' => (Yii::app()->params['fin'] )
                ),
                array(
                    'name' => 'marital_status',
                    'value' => (isset($model->marital_status) && $model->marital_status != '') ? $model->optionMaritalStatus[$model->marital_status] : '',
                    'visible' => (Yii::app()->params['marital_status'] )
                ),
                array(
                    'name' => 'number_of_children',
                    'visible' => (Yii::app()->params['number_of_children'] )
                ),
                array(
                    'name' => 'driving_license_class_type',
                    'visible' => (Yii::app()->params['driving_license_class_type'] )
                ),
                array(
                    'name' => 'highest_education_level',
                    'visible' => (Yii::app()->params['highest_education_level'] )
                ),
                array(
                    'name' => 'certification_awarded',
                    'visible' => (Yii::app()->params['certification_awarded'] )
                ),
                array(
                    'name' => 'office',
                    'visible' => (Yii::app()->params['office'] )
                ),
                array(
                    'name' => 'job_title',
                    'visible' => (Yii::app()->params['job_title'] )
                ),
                array(
                    'name' => 'department',
                    'visible' => (Yii::app()->params['department'] )
                ),
                array(
                    'name' => 'company',
                    'visible' => (Yii::app()->params['company'] )
                ),
                array(
                    'name' => 'gender',
                    'value' => (isset($model->gender) && $model->gender != '') ? $model->optionGender[$model->gender] : '',
                    'visible' => (Yii::app()->params['gender'] )
                ),
                array(
                    'name' => 'dob',
                    'type' => 'date',
                    'visible' => (Yii::app()->params['date_of_birthday'] )
                ),
                array(
                    'name' => 'skills',
                    'visible' => (Yii::app()->params['skills'] )
                ),
                array(
                    'name' => 'educations',
                    'visible' => (Yii::app()->params['educations'] )
                ),
                array(
                    'name' => 'certification',
                    'visible' => (Yii::app()->params['certification'] )
                ),
                array(
                    'name' => 'languages',
                    'visible' => (Yii::app()->params['languages'] )
                ),
                array(
                    'name' => 'associations',
                    'visible' => (Yii::app()->params['associations'] )
                ),
                array(
                    'name' => 'about_my_self',
                    'visible' => (Yii::app()->params['about_my_self'] )
                ),
                array(
                    'label' => '',
                    'type' => 'html',
                    'value' => '<strong>CONTACT INFORMATION</strong>'
                ),
                array(
                    'name' => 'account_types',
                    'visible' => (Yii::app()->params['account_types'] )
                ),
                array(
                    'name' => 'country_of_residence',
                    'visible' => (Yii::app()->params['country_of_residence'] )
                ),
                array(
                    'name' => 'work_email_address',
                    'visible' => (Yii::app()->params['work_email_address'] )
                ),
                array(
                    'name' => 'personal_email_address',
                    'visible' => (Yii::app()->params['personal_email_address'] )
                ),
                array(
                    'name' => 'address',
                    'visible' => (Yii::app()->params['house_address'] )
                ),
                array(
                    'name' => 'secondary_address',
                    'visible' => (Yii::app()->params['secondary_address'] )
                ),
                array(
                    'name' => 'home_phone_number',
                    'visible' => (Yii::app()->params['house_phone_number'] )
                ),
                array(
                    'name' => 'work_phone_number',
                    'visible' => (Yii::app()->params['work_phone_number'] )
                ),
                array(
                    'name' => 'phone',
                    'visible' => (Yii::app()->params['mobile_phone'] )
                ),
                array(
                    'name' => 'twitter_accounts',
                    'visible' => (Yii::app()->params['twitter_accounts'] )
                ),
                array(
                    'name' => 'im_accounts',
                    'visible' => (Yii::app()->params['im_accounts'] )
                ),
                array(
                    'name' => 'yahoo_accounts',
                    'visible' => (Yii::app()->params['yahoo_accounts'] )
                ),
                array(
                    'name' => 'skype_accounts',
                    'visible' => (Yii::app()->params['skype_accounts'] )
                ),
                array(
                    'name' => 'viber_accounts',
                    'visible' => (Yii::app()->params['viber_accounts'] )
                ),
                array(
                    'name' => 'whatsapp',
                    'visible' => (Yii::app()->params['whatsapp'] )
                ),
                array(
                    'name' => 'facebook_accounts_url',
                    'visible' => (Yii::app()->params['facebook_accounts_url'] )
                ),
                array(
                    'name' => 'emergency',
                    'visible' => (Yii::app()->params['emergency'] )
                ),
                array(
                    'name' => 'emergency_contact_person',
                    'visible' => (Yii::app()->params['emergency_contact_person'] )
                ),
                array(
                    'name' => 'relationship_of_emergency_contact_person',
                    'visible' => (Yii::app()->params['relationship_of_emergency_contact_person'] )
                ),
                array(
                    'name' => 'emergency_contact_number',
                    'visible' => (Yii::app()->params['emergency_contact_number'] )
                ),
                array(
                    'name' => 'created_date',
                    'type' => 'date',
                ),
            ),
        ));
        ?>
        <div class="well">
<?php echo CHtml::htmlButton('<span class="' . $this->iconBack . '"></span> Back', array('class' => 'btn btn-default', 'onclick' => 'javascript: location.href=\'' . $this->baseControllerIndexUrl() . '\'')); ?>	</div>
    </div>
</div>
