<?php

/*
 * using  TextTranslateHelper::label();
 */




class TextMultilangHelper {

	public static function label($key){
        return Yii::t('translation',$key);
    }

	
    
}

?>
