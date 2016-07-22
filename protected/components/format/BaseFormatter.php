<?php
class BaseFormatter extends CFormatter
{
 
    public function formatStatus($value) {
        if(is_array($value)) {
            return (($value['status'] == STATUS_INACTIVE) ?
                    "Inactive"
                :
                "Active"
            );
        }
        else
            return $value == 0 ? DeclareHelper::$statusFormat[STATUS_INACTIVE] : DeclareHelper::$statusFormat[STATUS_ACTIVE];
    }

    public function formatDate($value,$formatF = '') {
        if(empty($formatF))
            $formatF = Yii::app()->params['dateFormat'];
        if($value=='0000-00-00' || $value=='0000-00-00 00:00:00' || is_null($value))
            return '';
        if(is_string($value)) {
            $date = new DateTime($value);
            return $date->format($formatF);
        }
        return parent::formatDate($value);
    }

    public function formatTime($value,$formatF = '') {
        if(empty($formatF))
            $formatF = Yii::app()->params['timeFormat'];
        if($value=='0000-00-00' || $value=='0000-00-00 00:00:00' || is_null($value))
            return '';	
        if(is_string($value)) {
            $date = new DateTime($value);
            return $date->format($formatF);
        }
        return parent::formatDate($value);
    }

    public function formatDateTime($value,$formatF = '') {
        if(empty($formatF))
            $formatF = Yii::app()->params['dateFormat'] . ' ' . Yii::app()->params['timeFormat'];
        if($value=='0000-00-00' || $value=='0000-00-00 00:00:00' || is_null($value))
            return '';	
        if(is_string($value)) {
            $date = new DateTime($value);
            return $date->format($formatF);
        }
        return parent::formatDate($value);
    }

    /* formatYNStatus use for Yes/No*/
    public static function formatYNStatus($value)
    {
        $return = DeclareHelper::$yesNoFormat;
        return isset($return[$value])?$return[$value]:"";
    }

    public function formatPrice($value, $country = 'sg')
    {
        if($country == 'sg')
        {
            return Yii::app()->params['currencySign'].number_format($value,2);
        }
        return $value;
    }

    public function formatNumberCurrency($value, $country = 'sg')
    {
        if(is_array($value))
        {
            if(empty($value['currencyType']))
                $currencyType = 'SGD';
            else
                $currencyType = $value['currencyType'];
            return number_format((float)$value['number'],2)." (".$currencyType.")";
        }
        else
            return $value = "";
    }

    public function formatStatusNewletters($value) {
        if(is_array($value)) {
            return (($value['status'] == STATUS_INACTIVE) ?
                CHtml::link(
                    "Draft",
                    array("ajaxActivate", "id"=>$value['id']),
                    array(
                        "class"=>"ajaxupdate",
                        "title"=>"Click here to ".DeclareHelper::$statusFormat[STATUS_ACTIVE],
                    )
                )
                :
                CHtml::link(
                    "Active",
                    array("ajaxDeactivate", "id"=>$value['id']),
                    array(
                        "class"=>"ajaxupdate",
                        "title"=>"Click here to draft ",
                    )
                )
            );
        }
        else
            return $value == 0 ? 'Draft' : DeclareHelper::$statusFormat[STATUS_ACTIVE];
    }
    
    public function formatStatusSubScriber($value) {
        if(is_array($value)) {
            return (($value['status'] == STATUS_INACTIVE) ?
                CHtml::link(
                    "Unsubscribed",
                    array("ajaxActivate", "id"=>$value['id']),
                    array(
                        "class"=>"ajaxupdate",
                        "title"=>"Click here to ".DeclareHelper::$statusFormat[STATUS_ACTIVE],
                    )
                )
                :
                CHtml::link(
                    "Active",
                    array("ajaxDeactivate", "id"=>$value['id']),
                    array(
                        "class"=>"ajaxupdate",
                        "title"=>"Click here to Unsubscribed",
                    )
                )
            );
        }
        else
            return $value == 0 ? DeclareHelper::$statusFormat[STATUS_INACTIVE] : DeclareHelper::$statusFormat[STATUS_ACTIVE];
    }  
    
}