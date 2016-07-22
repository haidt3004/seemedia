<?php

/**
 * This is the model class for table "{{_actions_users}}".
 *
 * The followings are the available columns in table '{{_actions_users}}':
 * @property integer $id
 * @property integer $user_id
 * @property integer $action_id
 * @property string $can_access
 */
class ActionsUsers extends _BaseModel
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ActionsUsers the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
            return '{{_actions_users}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('user_id', 'numerical', 'integerOnly'=>true),
                    array('can_access', 'length', 'max'=>10),
                    // The following rule is used by search().
                    // Please remove those attributes that should not be searched.
                    array('id, user_id, can_access', 'safe', 'on'=>'search'),
            );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
            // NOTE: you may need to adjust the relation name and the related
            // class name for the relations automatically generated below.
            return array(
                'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'user_id' => 'User',
                    'action_id' => 'Action',
                    'can_access' => 'Can Access',
            );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('user_id',$this->user_id);		
        $criteria->compare('can_access',$this->can_access,true);

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
    
    // May 08, 2014 bb code - ANH DUNG ADD
    public static function getActionArrayByUserIdAndControllerId($user_id, $controller_id, $can_access = 'allow')
    {
        $aActions = array();
        $criteria = new CDbCriteria;
        $criteria->compare('t.user_id', $user_id);
        $criteria->compare('t.controller_id', $controller_id);
        $criteria->compare('t.can_access', $can_access);
        $model = self::model()->find($criteria);
        if ($model)
        {                
            if(!empty($model->actions))
            {
                $aActions = explode(',', $model->actions); // bug:  ANH DUNG FIX NOW 14, 2014( remove space explode)
            }
        }
        return $aActions;
    }


    public static function getActionArrayAllowForCurrentUserByControllerName($controllerName)
    {
        $aResult = array();
        $user_id = Yii::app()->user->id;
        $mUser = Users::model()->findByPk($user_id);
        $mController = Controllers::getByName($controllerName);
        // ANH DUNG FIX  NOW 14, 2014
        if($mController)
        {
            $mActionsUsers = ActionsUsers::model()->findAll('user_id='.$user_id.' AND controller_id='.$mController->id);
            if($mActionsUsers == NULL)
            {
                $aActionsAllowGroup = ActionsRoles::getActionArrayByRoleIdAndControllerId($mUser->role_id, $mController->id);
                $aResult = $aActionsAllowGroup;
            }
            else{
                $aActionsAllowUser = ActionsUsers::getActionArrayByUserIdAndControllerId($user_id, $mController->id);
                $aResult = $aActionsAllowUser;
            }
                
        }
        // ANH DUNG FIX  NOW 14, 2014
//        if($mController)
//        {
//            $mActionsUsers = ActionsUsers::model()->find('user_id='.$user_id.' AND controller_id='.$mController->id);
//            $aActionsAllowGroup = ActionsRoles::getActionArrayByRoleIdAndControllerId($mUser->role_id, $mController->id);
//            $aActionsAllowUser = ActionsUsers::getActionArrayByUserIdAndControllerId($user_id, $mController->id);
//            if($mActionsUsers == NULL)
//            {
//                $aResult = $aActionsAllowGroup;
//            }
//            else
//                $aResult = $aActionsAllowUser;
//        }

        return $aResult;
    }

    public static function isAllowAccess($controllerName, $actionName)
    {
        $aActionAllowed = ActionsUsers::getActionArrayAllowForCurrentUserByControllerName($controllerName);
        if(in_array(ucfirst($actionName), $aActionAllowed))
        {
            return true;
        }
        return false;
    }        
    // END May 08, 2014 bb code - ANH DUNG ADD    
 
    
    
    /**
     * @Author: ANH DUNG Jan 26, 2015
     * @Todo: get name alias controller action
     */
    public static function GetAliasControllers() {
     /******** Dec 19, 2014 ANH DUNG 
     * @note: ex: 'childActions'=>array('NameActionAjax1', 'NameActionAjax2', 'NameActionAjax3')
     * with some action you can use: MyFormat::isAllowAccess("rolesAuth", "group")
     */
    return array(
           
        'Users'=>array('alias'=>'Merchant Managerment',
            'actions'=>array(
                'Index'=>array('alias'=> Yii::t('translation', 'List'),
                                'childActions'=>array()
                                ),                
                'Create'=>array('alias'=>'Create',
                                'childActions'=>array()
                                ),
                'Update'=>array('alias'=>'Update',
                                'childActions'=>array()
                                ),
                'View'=>array('alias'=>'View',
                                'childActions'=>array()
                                ),
                'Delete'=>array('alias'=>'Delete',
                                'childActions'=>array('DeleteAll')
                                ),
                )
        ), /* end controller */
        
        'Subscriber'=>array('alias'=>'Subscribers Management',
            'actions'=>array(
                'Index'=>array('alias'=>'List',
                                'childActions'=>array()
                                ),                
                'Create'=>array('alias'=>'Create',
                                'childActions'=>array()
                                ),
                'Update'=>array('alias'=>'Update',
                                'childActions'=>array()
                                ),
                'View'=>array('alias'=>'View',
                                'childActions'=>array()
                                ),
                'Delete'=>array('alias'=>'Delete',
                                'childActions'=>array('DeleteAll')
                                ),
                )
        ), /* end controller */
        
        'Subscriber'=>array('alias'=>'Subscriber Management',
            'actions'=>array(
                'Index'=>array('alias'=>'List',
                                'childActions'=>array()
                                ),                
                'Create'=>array('alias'=>'Create',
                                'childActions'=>array()
                                ),
                'Update'=>array('alias'=>'Update',
                                'childActions'=>array()
                                ),
                'View'=>array('alias'=>'View',
                                'childActions'=>array()
                                ),
                'Delete'=>array('alias'=>'Delete',
                                'childActions'=>array('DeleteAll')
                                ),
                )
        ), /* end controller */
        
        
        'Article'=>array('alias'=>'Article Management',
            'actions'=>array(
                'Index'=>array('alias'=>'List',
                                'childActions'=>array()
                                ),                
                'Create'=>array('alias'=>'Create',
                                'childActions'=>array()
                                ),
                'Update'=>array('alias'=>'Update',
                                'childActions'=>array()
                                ),
                'View'=>array('alias'=>'View',
                                'childActions'=>array()
                                ),
                'Delete'=>array('alias'=>'Delete',
                                'childActions'=>array('DeleteAll')
                                ),
                )
        ), /* end controller */
        
        'videogallery'=>array('alias'=>'Video Gallery',
            'actions'=>array(
                'Index'=>array('alias'=>'List',
                                'childActions'=>array()
                                ),                
                'Create'=>array('alias'=>'Create',
                                'childActions'=>array()
                                ),
                'Update'=>array('alias'=>'Update',
                                'childActions'=>array()
                                ),
                'View'=>array('alias'=>'View',
                                'childActions'=>array()
                                ),
                'Delete'=>array('alias'=>'Delete',
                                'childActions'=>array('DeleteAll')
                                ),
                )
        ), /* end controller */
        
        'listing'=>array('alias'=>'Listing Management',
            'actions'=>array(
                'Index'=>array('alias'=>'List',
                                'childActions'=>array()
                                ),                
                'Create'=>array('alias'=>'Create',
                                'childActions'=>array('CreateListing', 'ChooseAPlan')
                                ),
                'Update'=>array('alias'=>'Update',
                                'childActions'=>array('ChooseAPlan')
                                ),
                'View'=>array('alias'=>'View',
                                'childActions'=>array()
                                ),
                'Delete'=>array('alias'=>'Delete',
                                'childActions'=>array('DeleteAll')
                                ),
                )
        ), /* end controller */
        
        'homebanners'=>array('alias'=>'Home Banners',
            'actions'=>array(
                'Index'=>array('alias'=>'List',
                                'childActions'=>array()
                                ),                
                'Create'=>array('alias'=>'Create',
                                'childActions'=>array()
                                ),
                'Update'=>array('alias'=>'Update',
                                'childActions'=>array()
                                ),
                'View'=>array('alias'=>'View',
                                'childActions'=>array()
                                ),
                'Delete'=>array('alias'=>'Delete',
                                'childActions'=>array('DeleteAll')
                                ),
                )
        ), /* end controller */
        
        'skyscrapper'=>array('alias'=>'Sky Scrapper',
            'actions'=>array(
                'Index'=>array('alias'=>'List',
                                'childActions'=>array()
                                ),                
                'Create'=>array('alias'=>'Create',
                                'childActions'=>array()
                                ),
                'Update'=>array('alias'=>'Update',
                                'childActions'=>array()
                                ),
                'View'=>array('alias'=>'View',
                                'childActions'=>array()
                                ),
                'Delete'=>array('alias'=>'Delete',
                                'childActions'=>array('DeleteAll')
                                ),
                )
        ), /* end controller */
        
        'leaderboard'=>array('alias'=>'Leader Board',
            'actions'=>array(
                'Index'=>array('alias'=>'List',
                                'childActions'=>array()
                                ),                
                'Create'=>array('alias'=>'Create',
                                'childActions'=>array()
                                ),
                'Update'=>array('alias'=>'Update',
                                'childActions'=>array()
                                ),
                'View'=>array('alias'=>'View',
                                'childActions'=>array()
                                ),
                'Delete'=>array('alias'=>'Delete',
                                'childActions'=>array('DeleteAll')
                                ),
                )
        ), /* end controller */
        
        'featurebanner'=>array('alias'=>'Feature Banner',
            'actions'=>array(
                'Index'=>array('alias'=>'List',
                                'childActions'=>array()
                                ),                
                'Create'=>array('alias'=>'Create',
                                'childActions'=>array()
                                ),
                'Update'=>array('alias'=>'Update',
                                'childActions'=>array()
                                ),
                'View'=>array('alias'=>'View',
                                'childActions'=>array()
                                ),
                'Delete'=>array('alias'=>'Delete',
                                'childActions'=>array('DeleteAll')
                                ),
                )
        ), /* end controller */
        
        'Pages'=>array('alias'=>'Pages Management',
            'actions'=>array(
                'Index'=>array('alias'=>'List',
                                'childActions'=>array()
                                ),                
                'Create'=>array('alias'=>'Create',
                                'childActions'=>array()
                                ),
                'Update'=>array('alias'=>'Update',
                                'childActions'=>array()
                                ),
                'View'=>array('alias'=>'View',
                                'childActions'=>array()
                                ),
                'Delete'=>array('alias'=>'Delete',
                                'childActions'=>array('DeleteAll')
                                ),
                )
        ), /* end controller */
        
        
        'Frontmenus'=>array('alias'=>'Front Menu Management',
            'actions'=>array(
                'Index'=>array('alias'=>'List',
                                'childActions'=>array()
                                ),                
                'Create'=>array('alias'=>'Create',
                                'childActions'=>array()
                                ),
                'Update'=>array('alias'=>'Update',
                                    'childActions'=>array(
                                        'Rendernewpageitem',
                                        'Rendernewitem',
                                    )
                                ),
                'View'=>array('alias'=>'View',
                                'childActions'=>array()
                                ),
                'Delete'=>array('alias'=>'Delete',
                                'childActions'=>array('DeleteAll')
                                ),
                )
        ), /* end controller */
        
        'staticblock'=>array('alias'=>'Smart blocks',
            'actions'=>array(
                'Index'=>array('alias'=>'List',
                                'childActions'=>array()
                                ),                
                'Create'=>array('alias'=>'Create',
                                'childActions'=>array()
                                ),
                'Update'=>array('alias'=>'Update',
                                'childActions'=>array()
                                ),
                'View'=>array('alias'=>'View',
                                'childActions'=>array()
                                ),
                'Delete'=>array('alias'=>'Delete',
                                'childActions'=>array('DeleteAll')
                                ),
                )
        ), /* end controller */
        
        'Emailtemplates'=>array('alias'=>'Email Template Management',
            'actions'=>array(
                'Index'=>array('alias'=>'List',
                                'childActions'=>array()
                                ),                
                'Create'=>array('alias'=>'Create',
                                'childActions'=>array()
                                ),
                'Update'=>array('alias'=>'Update',
                                'childActions'=>array()
                                ),
                'View'=>array('alias'=>'View',
                                'childActions'=>array()
                                ),
                'Delete'=>array('alias'=>'Delete',
                                'childActions'=>array('DeleteAll')
                                ),
                )
        ), /* end controller */
        
        'listingscategories'=>array('alias'=>'Listings Category',
            'actions'=>array(
                'Index'=>array('alias'=>'List',
                                'childActions'=>array()
                                ),                
                'Create'=>array('alias'=>'Create',
                                'childActions'=>array()
                                ),
                'Update'=>array('alias'=>'Update',
                                'childActions'=>array()
                                ),
                'View'=>array('alias'=>'View',
                                'childActions'=>array()
                                ),
                'Delete'=>array('alias'=>'Delete',
                                'childActions'=>array('DeleteAll')
                                ),
                )
        ), /* end controller */
        
        'videocategory'=>array('alias'=>'Videos Category',
            'actions'=>array(
                'Index'=>array('alias'=>'List',
                                'childActions'=>array()
                                ),                
                'Create'=>array('alias'=>'Create',
                                'childActions'=>array()
                                ),
                'Update'=>array('alias'=>'Update',
                                'childActions'=>array()
                                ),
                'View'=>array('alias'=>'View',
                                'childActions'=>array()
                                ),
                'Delete'=>array('alias'=>'Delete',
                                'childActions'=>array('DeleteAll')
                                ),
                )
        ), /* end controller */
        
        'audience'=>array('alias'=>'Audience',
            'actions'=>array(
                'Index'=>array('alias'=>'List',
                                'childActions'=>array()
                                ),                
                'Create'=>array('alias'=>'Create',
                                'childActions'=>array()
                                ),
                'Update'=>array('alias'=>'Update',
                                'childActions'=>array()
                                ),
                'View'=>array('alias'=>'View',
                                'childActions'=>array()
                                ),
                'Delete'=>array('alias'=>'Delete',
                                'childActions'=>array('DeleteAll')
                                ),
                )
        ), /* end controller */
        
        'specialty'=>array('alias'=>'Specialty',
            'actions'=>array(
                'Index'=>array('alias'=>'List',
                                'childActions'=>array()
                                ),                
                'Create'=>array('alias'=>'Create',
                                'childActions'=>array()
                                ),
                'Update'=>array('alias'=>'Update',
                                'childActions'=>array()
                                ),
                'View'=>array('alias'=>'View',
                                'childActions'=>array()
                                ),
                'Delete'=>array('alias'=>'Delete',
                                'childActions'=>array('DeleteAll')
                                ),
                )
        ), /* end controller */
        
        'categoryArticle'=>array('alias'=>'Articles Category',
            'actions'=>array(
                'Index'=>array('alias'=>'List',
                                'childActions'=>array()
                                ),                
                'Create'=>array('alias'=>'Create',
                                'childActions'=>array()
                                ),
                'Update'=>array('alias'=>'Update',
                                'childActions'=>array()
                                ),
                'View'=>array('alias'=>'View',
                                'childActions'=>array()
                                ),
                'Delete'=>array('alias'=>'Delete',
                                'childActions'=>array('DeleteAll')
                                ),
                )
        ), /* end controller */
        
        'locationSg'=>array('alias'=>'SG Location',
            'actions'=>array(
                'Index'=>array('alias'=>'List',
                                'childActions'=>array()
                                ),                
                'Create'=>array('alias'=>'Create',
                                'childActions'=>array()
                                ),
                'Update'=>array('alias'=>'Update',
                                'childActions'=>array()
                                ),
                'View'=>array('alias'=>'View',
                                'childActions'=>array()
                                ),
                'Delete'=>array('alias'=>'Delete',
                                'childActions'=>array('DeleteAll')
                                ),
                )
        ), /* end controller */
        
        'subject'=>array('alias'=>'Subjects',
            'actions'=>array(
                'Index'=>array('alias'=>'List',
                                'childActions'=>array()
                                ),                
                'Create'=>array('alias'=>'Create',
                                'childActions'=>array()
                                ),
                'Update'=>array('alias'=>'Update',
                                'childActions'=>array()
                                ),
                'View'=>array('alias'=>'View',
                                'childActions'=>array()
                                ),
                'Delete'=>array('alias'=>'Delete',
                                'childActions'=>array('DeleteAll')
                                ),
                )
        ), /* end controller */
        
        'locationMy'=>array('alias'=>'MY Location',
            'actions'=>array(
                'Index'=>array('alias'=>'List',
                                'childActions'=>array()
                                ),                
                'Create'=>array('alias'=>'Create',
                                'childActions'=>array()
                                ),
                'Update'=>array('alias'=>'Update',
                                'childActions'=>array()
                                ),
                'View'=>array('alias'=>'View',
                                'childActions'=>array()
                                ),
                'Delete'=>array('alias'=>'Delete',
                                'childActions'=>array('DeleteAll')
                                ),
                )
        ), /* end controller */
        
        'Seos'=>array('alias'=>'SEO Management',
            'actions'=>array(
                'Index'=>array('alias'=>'List',
                                'childActions'=>array()
                                ),                
                'Create'=>array('alias'=>'Create',
                                'childActions'=>array()
                                ),
                'Update'=>array('alias'=>'Update',
                                'childActions'=>array()
                                ),
                'View'=>array('alias'=>'View',
                                'childActions'=>array()
                                ),
                'Delete'=>array('alias'=>'Delete',
                                'childActions'=>array('DeleteAll')
                                ),
                )
        ), /* end controller */
        
        
        /******** May 14, 2014 ANH DUNG ***********/
        
        );
    }
}