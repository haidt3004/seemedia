<?php
/**
 * @todo Class for date format
 * @author bb
 */
class MyFormat
{
    public static $sMyDateFormat = 'd-M-Y' ;
    public static $sMyCurrencyFormat = '#,##0' ;
    public static $sCurrencyType = 'S$' ;
    public static $sMyTimeFormat = 'H:i' ;
    public static $sMyTimeFormatAM_PM = 'h:i A' ;
    public static $sDateIndexListing = 'M d, Y' ;
    public static $dateInvoice = 'd/m/Y H:i';
    public static $text_area_newline = array("\n", "\r\n", "\r");
    public static $BAD_CHAR = array('"',"'", "\\");

    /** to do: tính toán index cột excel
     * @param: $index: 
     * @return: name index 
     */        
    public static function columnName($index)
    {
        --$index;
        if($index >= 0 && $index < 26)
                        return chr(ord('A') + $index);
        else if ($index > 25)
            return (MyFormat::columnName($index / 26)).(MyFormat::columnName($index%26 + 1));
        else
            throw new Exception("Invalid Column # ".($index + 1));
    } 
    
    /**
    @param: $date format: 20/05/2013
    @param: $sign "/"
    @return: date format: 2013-05-20
    */
    public static function dateConverDmyToYmd($date, $sign='/'){
        if(empty($date)) return '';
        $dateTmp = explode($sign, $date);
        if(count($dateTmp)>2)
            return $dateTmp[2].'-'.$dateTmp[1].'-'.$dateTmp[0];
        return $date;
    }
    
    
    /** format date from db to format normal
     * @param: $date: 2014-02-25
     * @param: $format: default Yii::app()->params['dateFormat']
     */
    public static function dateConverYmdToDmy($date, $format=''){
        if($date=='0000-00-00' || $date=='0000-00-00 00:00:00' || is_null($date))
            return '';		
        if(is_string($date))
        {
            $date = new DateTime($date);
            if(!empty($format)){
                return $date->format($format);
            }
            return $date->format(Yii::app()->params['dateFormat']);
        }
    }
    
    /**
     * @Author: ANH DUNG Apr 17, 2014
     * @Todo: format date 20-05-2013 to 2013-05-20	
     * @param: date format: 20-05-2013
     * @Return: date format: 2013-05-20	
     */    
    public static function dateConverDmyToYmdForSeach($date){
        if(empty($date)) return '';
        $dateTmp = explode('-', $date);
        if(count($dateTmp)>2)
            return $dateTmp[2].'-'.$dateTmp[1].'-'.$dateTmp[0];
        return $date;
    }
    
    /**
     * @Author: ANH DUNG Mar 11, 2014
     * @Todo: format number with comma
     */
    public static function formatNumberWithComma($value) {
        return number_format($value, 2);
    }

   // đồng bộ hiển thị kiểu số ở input khi edit, không để dấu , thập phân
   public static function formatNumberInput($value)
   {
       $number_left = substr(strrchr($value, "."), 1);
       if($number_left>0)
           return $value;
       return round($value);
   }      
    
    /**
     * @Author: ANH DUNG Mar 12, 2014
     * @Todo: format name of user at Fe
     * @return: string name
     */
    public static function getNameUserLogin() {
        $str='';
        if(isset(Yii::app()->user->id)){
            $str.= Yii::app()->user->first_name." ".Yii::app()->user->last_name;
        }else{
            $str='Guest';
        }
        return $str;
    }
    
    /* Nguyen Dung Jun 30, 2014
    *  check valid date
     * @param: $stringcheck: 2013-05-26
     * @return: true if valid date, else false
    */
    public static function isValidDate($someString){
        $someString = trim($someString);
        if(empty($someString)) return ;
        $date = date_parse($someString);
        if (checkdate($date["month"], $date["day"], $date["year"])){
            return true;
        }
        return false;
    }    
    
    /**
     * @Author: ANH DUNG Mar 12, 2014
     * @Todo: get array order number
     * @return: array number
     */    
    public static function getOrderArray($max=50){
        $res = array();
        for($i=1;$i<=$max;$i++){
            $res[$i]=$i;
        }
        return $res;
    }
    
    /**
     * @Author: ANH DUNG Mar 13, 2014
     * @Todo: removeScriptTag
     */    
    public static function removeScriptTag($string) {
        $CHtmlPurifier = new CHtmlPurifier();
        $CHtmlPurifier->options = array('HTML.ForbiddenElements' => array('script','style','applet'));
        $string =  $CHtmlPurifier->purify($string);
        $scriptRemove = array("<script>", "</script>", "script",'text/javascript');
        return str_replace($scriptRemove, "", $string);    
    }    
    
    /**
    * @Author: ANH DUNG Apr 11, 2014
    @param: date format: 20-05-2013
    @return: date format: 2013-05-20	
    */
    public static function dateDmyToYmdForAllIndexSearch($date){
        if(empty($date)) return '';
        $date = explode('-', $date);		
        if(count($date)>2)
            return $date[2].'-'.$date[1].'-'.$date[0];
        return '';
    }
    
    
    /**
    * Returns auto generate max id: ID0001.
    * @param:$className: Users
    * @param:$prefix_code: ID
    * @param:$fieldName: name of field generate max id in database: ex: customer_id, user_no....
    * @param:$length_max_id: int: 10 default
    * @how to do: $model->user_no = MyFunctionCustom::getNextId('Users','ID','user_no', 10);
    */  		
    public static function getNextId($className, $prefix_code, $fieldName, $length_max_id = 10 ){
        $prefix_code_length = strlen($prefix_code);
        $criteria = new CDbCriteria;
        $criteria->select='MAX(CONVERT(SUBSTR(t.'.$fieldName.','.($prefix_code_length+1).'),SIGNED)) as MAX_ID';
        $criteria->compare("t.$fieldName",$prefix_code,true);
        $model_ = call_user_func(array($className, 'model'));        
        $model = $model_->find($criteria);
        $max_id =  (null == $model->MAX_ID) ? 0 : $model->MAX_ID;
        $max_id++;
        $addition_zero_num 	= $length_max_id - strlen($max_id) - strlen($prefix_code);
        $code = $prefix_code;
        for($i=1;$i<=$addition_zero_num;$i++)
            $code.='0';
        $code.= $max_id;
        return $code;
    }    
    
    /**
     * @Author: ANH DUNG Apr 22, 2014
     * @Todo: replaceNewLineTextArea
     * @Return: string 
     */   
    public static function replaceNewLineTextArea($string){
        $string = str_replace(MyFormat::$text_area_newline, '<br>', $string);
        $string = str_replace('<br><br><br>', '<br>', $string);
        $string = str_replace('<br><br>', '<br>', $string);
        return $string;
    }    
    
    
     
    /**  ANH DUNG Apr 24, 2014
    *  @to do: save file from internet
    *  @param string $url: http://verzview.com/verzbutt/demo/upload/temp/3-1374742421.jpg
    *  @param string $path: /upload/temp
    *  @param string $fileName: 3-1374742421.jpg
    */
    public static function DownloadFile($url, $path, $fileName ) {
        MyFormat::DownloadFileUsingCurl($url, $path, $fileName);// ANH Dung fix Sep 08, 2014 do server cấm 
        // fopen() [<a href='function.fopen'>function.fopen</a>]: http:// wrapper is disabled in the server configuration by allow_url_fopen=0
        return ;
//        ROOT.$path: /home/verzview/public_html/verzbutt/demo/upload/temp
         $newfname = ROOT.$path.'/'.$fileName;
         $file = fopen ($url, "rb");
         if ($file) {
           $newf = fopen ($newfname, "wb");
           if ($newf)
           while(!feof($file)) {
                fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
           }
         }

         if ($file) {
           fclose($file);
         }

         if ($newf) {
           fclose($newf);
//           return true;
           return $json=array('success'=>true,'msg'=>'save file ok');
         }else{
//         return false;
           return $json=array('success'=>false,'msg'=>'Can not save file '.$newfname);
         }

     } 
     
     /**  ANH DUNG Sep 08, 2014
    *  @to do: save file from internet
    *  @param string $url: http://verzview.com/verzbutt/demo/upload/temp/3-1374742421.jpg
    *  @param string $path: /upload/temp
    *  @param string $fileName: 3-1374742421.jpg
    */
    public static function DownloadFileUsingCurl($url, $path, $fileName ) {
        $local_file_name = ROOT.$path.'/'.$fileName;
        set_time_limit(0);
//        $fp = fopen (dirname(__FILE__) . '/localfile.tmp', 'w+');//This is the file where we save the    information
        $fp = fopen ($local_file_name, 'w+');//This is the file where we save the    information
        $ch = curl_init(str_replace(" ","%20",$url));//Here is the file we are downloading, replace spaces with %20
        curl_setopt($ch, CURLOPT_TIMEOUT, 50);
        curl_setopt($ch, CURLOPT_FILE, $fp); // write curl response to file
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_exec($ch); // get curl response
        curl_close($ch);
        fclose($fp);
    }
     
     /**  ANH DUNG Oct 07, 2014
    *  @to do: copy a file from one directory to another using PHP?
    *  @param string $path_from: /var/www/html/verz/eogchange/upload/image.jpg
    *  @param string $path_to: /var/www/html/verz/eogchange/upload/image1.jpg
    */
    public static function CopyFile($path_from, $path_to) {
        copy($path_from, $path_to);
    }
    
    /**
     * NGUYEN DUNG - TO COMPARE TWO DATE
     * @param: string $date1: 2013-10-25
     * @param: string $date2: 2013-10-20
     * @return: bool; true if date1>date2 else return flase 
     */
    public static function compareTwoDate($date1, $date2){
        $d1 = new DateTime($date1);
        $d2 = new DateTime($date2);
        if($d1>$d2) return true;
        return false;
    }       
     
    /**  ANH DUNG Apr 24, 2014
    *  @to do: format number
    */
   public static function formatNumberLeft($price)
   {
        $number_left = substr(strrchr($price, "."), 1);
        if($number_left>0){
            $res = number_format((double)$price,2);
        }else{
            $res = number_format((double)$price,0);
        }
        return $res;
   }
    
    /**
     * @Author: ANH DUNG Jun 27, 2014
     * @Todo: format price number
     */    
    public static function formatPrice($price){
//        return Yii::app()->params['paypalCurrencySign']." ".number_format($value, 2); 
        // Jun 27, 2014 ANH DUNG tạm thời đóng dòng trên lại
        $number_left = substr(strrchr($price, "."), 1);
        if($number_left>0){
            $res = number_format((double)$price,2);
        }else{
            $res = number_format((double)$price,0);
        }
        return $res;
    }
     /**
     * @Author: ANH DUNG Jul 02, 2014
     * @Todo: format price number
     */   
    public static function formatPriceSign($price){
//        return Yii::app()->params['paypalCurrencySign']." ".number_format($value, 2); 
        // Jun 27, 2014 ANH DUNG tạm thời đóng dòng trên lại
        $number_left = substr(strrchr($price, "."), 1);
        $sign = MyFormat::getSignCurrency();
        if($number_left>0){
            $res = number_format((double)$price,2);
        }else{
            $res = number_format((double)$price,0);
        }
        return $sign.' '.$res;
    }
    
    /**
     * @Author: ANH DUNG Jul 08, 2014
     * @Todo: load model loadModelByClass
     * @Param: ($id, $ClassName)
     * @Return: $model
     */
    public static function loadModelByClass($id, $ClassName) {
        try {
            $model_ = call_user_func(array($ClassName, 'model'));
            $model = $model_->findByPk($id);
            if ($model === null) {
                Yii::log("Model: $ClassName with id: $id. The requested page does not exist.");
                throw new CHttpException(404, 'The requested page does not exist.');
            }
            return $model;
        } catch (Exception $e) {
            Yii::log("Exception " . print_r($e, true), 'error');
            throw new CHttpException("Exception " . print_r($e, true));
        }
    }
    
    /**
     * @Author: ANH DUNG Nov 17, 2014
     * @Todo: get all item id by status and  $ClassName
     * @Param: $status
     * @RETURN: array(id=>id)
     */
    public static function GetListOptionByStatusAndClassName($ClassName, $status) {
        $model_ = call_user_func(array($ClassName, 'model'));
        $criteria = new CDbCriteria();
        $criteria->compare('t.status', $status);
        $model = $model_->findAll($criteria);
        return  CHtml::listData($model,'id','id');
    }
    
    /**
     * @Author: ANH DUNG Now 14, 2014
     * @Todo: check allow access to controller and action
     * @param string  $controllerName ex: rolesAuth
     * @param string  $action : Users, Index
     * @return: true if allow, false if not allow
     * MyFormat::isAllowAccess('Users', 'Index');
     */
    public static function isAllowAccess($controllerName, $action){
         $aActionAllowed = ActionsUsers::getActionArrayAllowForCurrentUserByControllerName($controllerName);         
         $aActionAllowed = array_map('strtolower',$aActionAllowed);         
         return in_array(strtolower($action), $aActionAllowed);                  
    }    	
    
    /**
     * @Author: ANH DUNG Jul 25, 2014
     * @Todo: check some action need ussr login
     */
    public static function CheckRequiredLogin(){
        if(!isset(Yii::app()->user->id)){
            throw new CHttpException(404, 'The requested page does not exist.');
        }        
    }
    
    /**
     * @Author: ANH DUNG Mar 12, 2014
     * @Todo: remove some user input sql injection
     * @Param: $string string input
     * @Param: $needMore  $needMore['RemoveScript'] if(isset($needMore['RemoveScript'])){
     * @Return: string
     */	
    public static function removeBadCharacters($string, $needMore=array()){        
         $string = str_replace( MyFormat::$BAD_CHAR, '', $string);
         if(isset($needMore['RemoveScript'])){
             $string = MyFormat::removeScriptTag($string);
         }
         return trim($string);
//         return str_replace(array('&','<','>','/','\\','"',"'",'?','+'), '', $string);
    }  
    
    /**
     * @Author: ANH DUNG Aug 05, 2014
     * @Todo: DropDown for pageSize in CGridView
     * @Param: $name='pageSize', $selected='', $needMore=array()){
     * @Return: string
     */	
    public static function GetDropDownPageSize($name='pageSize', $selected='', $needMore=array()){        
        $aValue = array(5=>5,20=>20,50=>50,100=>100);
        if(isset($needMore['empty']))
            $aValue = array(0=>'Select',5=>5,20=>20,50=>50,100=>100);
        return CHtml::dropDownList(
            'pageSize',
            $selected,
            $aValue,
            array('class'=>'change-pageSize w-50'));
    }
    
    /**
     * @Author: ANH DUNG Aug 06, 2014
     * @Todo: remove some field need remove script
     * @Param: $model model 
     * @Param: $aAttributes array  attributes
     * @Return: full name with salution of user
     */
    public static function RemoveScriptOfModelField(&$model, $aAttributes){
        foreach($aAttributes as $FieldName){
            $model->$FieldName = MyFormat::removeScriptTag($model->$FieldName);
        }
    }
    
    /**
     * @Author: ANH DUNG Aug 28, 2014
     * @Todo: Add Ordinal Suffix PHP Function
     * @Param: http://www.if-not-true-then-false.com/2010/php-1st-2nd-3rd-4th-5th-6th-php-add-ordinal-number-suffix/
     */
    public static function addOrdinalNumberSuffix($num) {
        if (!in_array(($num % 100),array(11,12,13))){
          switch ($num % 10) {
            // Handle 1st, 2nd, 3rd
            case 1:  return $num.'st';
            case 2:  return $num.'nd';
            case 3:  return $num.'rd';
          }
        }
        return $num.'th';
    }
            
    /**
     * @Author: ANH DUNG Sep 12, 2014
     * @Todo: DropDown for year
     */	    
    public static function getRangeYear($start_year=2014, $end_year=2051){
        $data = array();
        for($i=$start_year;$i<$end_year;$i++)     
            $data[$i]=$i;
        return $data;
    }
    
    /**
     * @Author: ANH DUNG Sep 12, 2014
     * @Todo: lấy mảng ngày từ 2 ngày đưa ra
     * @Param: $date_from format: Y-m-d
     * @Param: $date_to format: Y-m-d
     * @Return: array date array('2014-06-07','2014-06-08'....)
     */
    public static function getArrayDay($date_from, $date_to){
        if($date_from==$date_to)
            return array($date_from);
        $aRes = array();
        $date_from_obj = new DateTime($date_from);
        $date_to_obj = new DateTime($date_to);
        
        // Nếu ngày bắt đầu lớn hơn ngày kết thúc -=> sai
        if($date_from_obj>$date_to_obj) 
            return array($date_from);
        $aRes[] = $date_from;
        $ok=true;
        while ($ok){
            $temp = MyFormat::modifyDays($date_from, 1);
            $aRes[] = $temp;
            if($temp==$date_to)
                $ok=FALSE;
            $date_from = $temp;
        }
        return $aRes;            
    }
    
    /** Nguyen Dung Sep 12, 2014 fix tên hàm cho dễ hiểu
     *  cộng hoặc trừ thêm ngày 
     *  @param: $date: 2013-05-26
     *  @param: $day_add: 16
     *  @param: $operator: + or - default is +
     *  @param: $amount_of_days: day, month, year default is "day"
     *  @param: $format: default "Y-m-d"
     *  @return: $format: default "Y-m-d"
     */
    public static function modifyDays($date, $day_add, $operator='+', $amount_of_days='day', $format='Y-m-d'){
        MyFormat::isValidDate($date);
        $date2 = new DateTime($date);
        if($day_add==0)
            $day_add=1;
        $date2->modify($operator.$day_add.' '.$amount_of_days);
        return $date2->format($format);        
    } 
    
    /**
     * @Author: ANH DUNG Sep 30, 2014
     * @Todo: random a string
     */
    public static function randString($length=6, $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')
    {
        $str = '';
        $count = strlen($charset);
        while ($length--) {
            $str .= $charset[mt_rand(0, $count-1)];
        }
        return $str;
    }    
    
    /**
     * @Author: ANH DUNG Nov 17, 2014
     * @Todo: getIpUser
     */
    public static function getIpUser(){
        return Yii::app()->request->getUserHostAddress();
    }
    
    /**
     * @Author: ANH DUNG Nov 17, 2014
     * @Todo: check user run at local host 
     */
    public static function IsRunAtLocal(){
        $ip_address = MyFormat::getIpUser();
        if( $ip_address == '::1' || $ip_address == '127.0.0.1'){
            return true;
        }
        return false;
    }
    
    /**
     * @Author: ANH DUNG Nov 26, 2014
     * @Todo: delete list model detail belong to one model parent: ex: table Users and Order
     * @Param: $ClassNameModelDelete name of model delete: ex: Order
     * @Param: $root_id_belong value id ref to parent table: ex 1,2,3...
     * @Param: $NameField: ex: user_id
     * * will call at beforeDelete: MyFormat::deleteModelDetailByRootId('EogOrderReturnDetail', $this->id, 'order_return_id');
     */
    public static function deleteModelDetailByRootId($ClassNameModelDelete, $root_id, $NameField){
        $criteria = new CDbCriteria();
        $criteria->compare("t.$NameField", $root_id);
        $model_ = call_user_func(array($ClassNameModelDelete, 'model'));
        $models = $model_->findAll($criteria);
        MyFormat::deleteArrModel($models);
    }
    
    /**
     * @Author: ANH DUNG Nov 26, 2014
     * @Todo: delete list model detail belong to one model parent: ex: table Users and Order
     */
    public static function deleteArrModel($mDel){
        if(count($mDel)>0)
            foreach ($mDel as $item)
                    $item->delete();	
    }
    
    /**
     * @Author: ANH DUNG Nov 26, 2014
     * to copy from model to other model in one table
     * @param: model $mFrom  
     * @param: model $mTo
     * @param: array $aFieldNotCopy: array('id','something_else'...)
     * @return: model $mTo
    */
    public static function copyFromToTable($mFrom, &$mTo, $aFieldNotCopy=array()){
        foreach($mFrom->getAttributes() as $field_name=>$field_value){
            if(count($aFieldNotCopy)){
                if(!in_array($field_name, $aFieldNotCopy) && $mTo->hasAttribute($field_name) )
                    $mTo->$field_name = $mFrom->$field_name;        
            }else{
                $mTo->$field_name = $mFrom->$field_name;        
            }
        }
        return $mTo;
    }    
    
    /**
     * @Author: ANH DUNG Nov 26, 2014
     * @Todo: format some number (decimal) show at input
     * @Param: $model model
     * @Param: $aAttribute array()
     */
    public static function FormatNumberDecimal($model, $aAttribute) {
        foreach( $aAttribute as $FieldName){
            $model->$FieldName = MyFormat::formatNumberInput($model->$FieldName);
        }
    }
    
    /** Nguyen Dung 10-15-2013
     * @return: unique request_number in table subscription plan 
     * @param: $className: name of model, string ex Users
     * @param: $fieldName: field name of model need check
     * @return: int: 56461213
     */    
    public static function generateRequestNumberByModel($className, $fieldName){
        $request_number = rand(10000000, 100000000);
        $model_ = call_user_func(array($className, 'model'));
        $count = $model_->count($fieldName.'='.$request_number.'');
        if($count>0){
            $request_number = MyFunctionCustom::generateRequestNumber($className, $fieldName);
            return $request_number;
        }else {
            return $request_number;
        }
    } 
    
    /**
     * @Author: ANH DUNG Dec 12, 2014
     * @Todo: gen unique session id in any table
     * @param: $className: name of model, string ex Users
     * @param: $fieldName: field name of model need check
     * @return: md5 string 
     */
    public static function generateSessionIdByModel($className, $fieldName){
        $session_id = md5(time() . StringHelper::getRandomString(16));
        $model_ = call_user_func(array($className, 'model'));
        $count = $model_->count("$fieldName='$session_id'");
        if($count>0){
            $session_id = MyFunctionCustom::generateSessionIdByModel($className, $fieldName);
            return $session_id;
        }else{
            return $session_id;
        }
    }
    
    
}
