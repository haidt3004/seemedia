<?php

/************************************************
 * DTOAN
 * MUltiple language 
 * Version : 2.0 
 ************************************************/

class _MultilanguagesModel extends CActiveRecord {

    //title mac dinh dung de tao ra slug
    //ten cua field dung de tao ra slug
    public $slug_default    = 'title';

    // ngon  ngu mac dinh
    public $languageDefault = 'en';
    public $modelTranslate  = null;


    public function init(){

        $this->languageDefault = Yii::app()->language;
        parent::init();
    }


    //add error tab langauage 
    public $arrErrorsLangauges = array();

    public function getModelName($model){
        return $myclass = get_class($model);
    }

    public function getModelTranslate(){
        $c = $this->modelTranslate;
        return  new $c();
    }


    /**
     * Validate multilanguage
     * Ham dung de validate du lieu
     *  ex: $model->attributes = $model->getDataValidate();
     */
    public function getDataValidate(){
        $modelName  = $this->getModelName($this);
        $languages = Languages::getAlllanguage();
        // $flag
        $langValidate= '';
        if(is_array($languages)&&count($languages)>0){
            foreach($languages as $lang){
                if(isset($_POST[$modelName][$lang->code])){
                    $this->attributes     = array_merge($this->getAttributes(),$_POST[$modelName][$lang->code]);
                    if(!$this->validate()){
                        $this->arrErrorsLangauges[$lang->code] = $this->getErrors();
                        $langValidate = $lang->code;
                    }
                }                
            }
        }

        if(count($this->arrErrorsLangauges)>0 && $langValidate !=''){
            if(isset($_POST[$modelName][$langValidate])){
                $this->attributes = $_POST[$modelName];
                $dataPost         = $_POST[$modelName][$langValidate];
                return array_merge($this->getAttributes(),$dataPost);
            }            
        }
    }



    /*
     * lay du lieu voi ma cua 1 ngon ngu cu the
     * Ex: Language en|vi...
     * . DUNG CHO SUBMIT FỎRM
     */
    public function getDataValidateWithLanguage($language){
        $modelName  = $this->getModelName($this);
        if(isset($_POST[$modelName][$language])){
            $dataPost         = $_POST[$modelName][$language];
            return array_merge($this->getAttributes(),$dataPost);
        }else{
            return $this->getAttributes();
        }
    }



    /*
    * Lay ra tat ca cac loi cua 1 field voi ngon ngu cu the
    * Ex: $model->showErrorLangMessage('en','title');
    **/
    public function showErrorLangMessage($language,$field=null){
        if(isset($this->arrErrorsLangauges[$language]) && isset($this->arrErrorsLangauges[$language][$field])){
            return true;
        }
        return  false;
    }

    /*
    * Them vao class Css de xu ly an hien du lieu khi validate
    */
    public function removeClassErrors($language = null,$field = null){
        if(is_array($this->arrErrorsLangauges) && count($this->arrErrorsLangauges)>0 && isset($this->arrErrorsLangauges[$language]) && isset($this->arrErrorsLangauges[$language][$field])){
            return null ;
        }
        return  ' removeError ';        
    }

    /*
     * Xoa di tat ca du lieu cua bang transtral
     */
    public function deleteAllDataTranslate(){
        $mTranslate = $this->getModelTranslate();
        $mTranslate::model()->deleteAllByAttributes(array('translate_id'=>$this->id));
    }


    /*
    * TAO RA SLUG
    * $slug_default : title;
    * trong model can set lai field nay 
    */

    public function buildSlugMultilanguage(){
        $field = $this->slug_default;
        if(isset($this->slug) && isset($this->$field)){
            $this->attributes = $this->getDataValidateWithLanguage($this->languageDefault);
            $this->update(array($field,'slug'));
        }
    }





    /*
    * Luu du lieu cua multilanguage
    * Ex : $model : Model hien ta muon translate  - EX : EmailTemplate,User..
    
    *  if($model->save()){
    *      $model->saveDataWithLanguage();
    * }
    */

    public function saveDataWithLanguage($modelName=null){
        $languages = Languages::getAlllanguage();
        //deleteAllLanguage
        $this->deleteAllDataTranslate();
        if(is_array($languages)&&count($languages)>0){
            foreach($languages as $lang){
                $dataAttributes = $this->getDataValidateWithLanguage($lang->code);
                if(isset($dataAttributes['id'])) unset($dataAttributes['id']);
                $mTranslate = $this->getModelTranslate();
                $mTranslate->attributes = $dataAttributes;
                $mTranslate->language   = $lang->code;
                $mTranslate->translate_id    = $this->id;
                $mTranslate->save(false);
            }
        }
        //update slug voi ngon ngu mac dinh
        $this->buildSlugMultilanguage();
        return $this;
    }

    /*

     *  Su dung ham nay khi dat o trong form sau khi validate loi hay muon show du lieu ra form
     *  Parram : $language : default english
     *  EX:  $model = Abc::model()->findByPk($id);
     *       $model->getDataWithLangauge();
     */

    public function getDataWithLangauge($model=nul,$language=null){
        $mTranslate = $this->getModelTranslate();

        if(!$model->isNewRecord){
            $data       = $mTranslate::model()->findByAttributes(array('translate_id'=>$this->id,'language'=>$language));
            if($data){
                $data = $data->getAttributes();
                unset($data['id']);
                if(!$model->hasErrors()){
                    if(is_array($data)){
                        $arrMerge          = array_merge($model->getAttributes(),$data);
                        $model->attributes = $arrMerge;
                        return $model;
                    }
                }else{
                    $model->attributes = $this->getDataValidateWithLanguage($language);
                     return $model;
                }
            }else{
                $model->attributes = $model->getDataValidateWithLanguage($language);
                return $model;                
            }
        }else{
            $model->attributes = $model->getDataValidateWithLanguage($language);
            return $model;
        } 

       return $model;

        // $data       = $mTranslate::model()->findByAttributes(array('translate_id'=>$this->id,'language'=>$language));
        // if($data){
        //     $data = $data->getAttributes();
        //     unset($data['id']);
        //     if(!$model->hasErrors()){
        //         if(is_array($data)){
        //             $arrMerge          = array_merge($model->getAttributes(),$data);
        //             $this->attributes = $arrMerge;
        //             return $model;
        //         }
        //     }else{
        //         $this->attributes = $this->getDataValidateWithLanguage($language);
        //          return $model;
        //     }
        // }else{
        //     if($model->isNewRecord){
        //         $this->attributes = $model->getDataValidateWithLanguage($language);
        //         return $model;
        //     }
        // }
        // return $model;
    }
    

    /*
    *  Lay ra du lieu cua 1 ngon ngu duoc chon.goi ham nay sau khi query ra 1 record
    * dung ra du lieu cua bang translate
    **/
    public function getDataTranslate(){
        if(isset($this->translate) && isset($this->translate[0])){
            $data = $this->translate[0]->getAttributes();
            unset($data['id']);
            $arrMerge          = array_merge($this->getAttributes(),$data);
            $this->attributes  = $arrMerge;
        }        
    }


    /*
     * DUNG DE CHUYEN DOI DU LIEU TU KHONG MULTILANGAUGE ---MULTILANGUAGE
     * 
     */
    public function ConvertDatatoMultilang(){
        $all = $this->model()->findAll();
        foreach($all as $p){
            foreach(Languages::getAlllanguage() as $key=> $lang){
                $new  = $this->getModelTranslate();
                $data = $p->getAttributes();
                $translateID= $p->id;
                unset($data['id']);
                $new->attributes   = $data;
                $new->language     = $lang->code;
                $new->translate_id = $translateID;

                if(isset($new->role_website_id)){
                    $new->role_website_id = ROLE_WEBSITE_ID;
                }
               
                $new->save(false);
            }
        }        
    }



}

?>