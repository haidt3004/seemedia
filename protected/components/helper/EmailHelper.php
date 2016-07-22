<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class EmailHelper {

    public static function sendMail($data) {
//        self::_setTestEmail($data, 'quocbao1087@gmail.com');
        $message = new YiiMailMessage($data['subject']);
        $message->setBody($data['message'], 'text/html');
        if (is_array($data['to'])) {
            foreach ($data['to'] as $t) {
                $message->addTo($t);
            }
        }
        else
            $message->addTo($data['to']);

        if (isset($data['cc']))
            $message->setCc($data['cc']);

        $message->from = $data['from'];
        $message->setFrom(array($data['from'] => Yii::app()->setting->getItem('mailSenderName')));
        return Yii::app()->mail->send($message);
    }

    /*     * *
     * $emailTemplateId: Email template id in database
     * $param: supported param in template with array key=>value. Key is param {key} in template
     */

    public static function bindEmailContent($emailTemplateId, $param, $to, $cc = null) {
        $modelEmailTemplate = EmailTemplates::model()->findByPk($emailTemplateId);
        if (!empty($modelEmailTemplate)) {
            $message = $modelEmailTemplate->email_body;
            $subject = $modelEmailTemplate->email_subject;
            if (!empty($param)) {
                foreach ($param as $key => $value) {
                    $message = str_replace('{' . strtoupper($key) . '}', $value, $message);
                    $subject = str_replace('{' . strtoupper($key) . '}', $value, $subject);
                }
            }

            // Send a email to patient     
            $data = array(
                'subject' => $subject,
                'message' => $message,
                'to' => $to,
                'cc' => $cc,
                'from' => Yii::app()->params['autoEmail'],
            );
            self::sendMail($data);
        }
    }

    public static function send($emailTemplateId, $param, $to, $cc = null,$language=null) {
        // $mEmailTemplates = EmailTemplates::model()->findByPk($emailTemplateId);

        /*
            * ROLE_WEBSITE ID  1 : ROLE  MAC DINH
            * 
         */
        
        if(ROLE_WEBSITE_ID !=1){
            $mEmailTemplates = EmailTemplates::model()->findByAttributes(array('parent_id'=>$emailTemplateId,'role_website_id'=>ROLE_WEBSITE_ID));
        }else{
            $mEmailTemplates = EmailTemplates::model()->findByPk($emailTemplateId);
        }


        if ($mEmailTemplates)         {
            // hiep apply multilang
            if($language !=''){
                $mEmailTemplates = $mEmailTemplates->getDataWithLangauge($mEmailTemplates,$language);
            }else{
                $mEmailTemplates->getDataTranslate();
            }

            if (!empty($param)) {
                $message = strtr($mEmailTemplates->email_body, $param);
                $subject = strtr($mEmailTemplates->email_subject, $param);
            }
            $data = array(
                'subject' => $subject,
                'message' => $message,
                'to' => $to,
                'cc' => $cc,
                'from' => Yii::app()->params['autoEmail'],
            );
            return self::sendMail($data);
        }
        return false;
    }
    
    public static function sendContactEmail($countryId, $param, $to, $isAdmin=false, $cc = null) {
        $mEmailTemplates = CountryEmailTemplates::model()->find('country_id = ' . (int)$countryId);
        
        if ($mEmailTemplates)         {
            if (!empty($param)) {
                if ($isAdmin)
                {
					$html_content	= EmailHelper::sgEmailRotatingIconHtmlRecoder($mEmailTemplates->to_admin_emailbody);
                    $message = strtr($html_content, $param);
                    $subject = strtr($mEmailTemplates->to_admin_subject, $param);
                    $to = $mEmailTemplates->admin_email;
                }
                else
                {
					$html_content	= EmailHelper::sgEmailRotatingIconHtmlRecoder($mEmailTemplates->email_body);
                     $message = strtr($html_content, $param);
					//$message = strtr($mEmailTemplates->email_body, $param);
                    $subject = strtr($mEmailTemplates->email_subject, $param);
                }
            }
            $data = array(
                'subject' => $subject,
                'message' => $message,
                'to' => $to,
                'cc' => $cc,
                'from' => Yii::app()->params['autoEmail'],
            );
           
            return self::sendMail($data);
        }
        return false;
    }
	
	public static function testfunction($html_string){
		echo "thank you!";
	}
	
	
	public static function sgEmailRotatingIconHtmlRecoder($html_string){
		$dom= new DOMDocument(); 
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput       = true;
		$dom->loadhtml($html_string); 

		$finder = new DomXPath($dom);
		$domTable = $finder->query("//*[contains(@id, 'sg-email-icon')]");
		if($domTable->length != 0){
			foreach ($domTable as $tables) { 
				//$table_content	= DOMinnerHTML($tables); 
				$innerHTML = ""; 
				$children  = $tables->childNodes;
				foreach ($children as $child) 
				{ 
					$innerHTML .= $tables->ownerDocument->saveHTML($child);
				}
				$table_content	= $innerHTML;
				
			} 

			preg_match_all("!<td(.*?)</td>!is", $table_content, $rows); 
			$icon_html_code_array_list	= $rows[0];

			$rand_keys 	= array_rand($icon_html_code_array_list, 5);

			foreach($rand_keys as $rand_key){
				$new_icon_string	.= $icon_html_code_array_list[$rand_key];
			}


			$xpath = new DOMXPath( $dom );
			$pDivs = $xpath->query("//*[contains(@id, 'sg-email-icon')]");
			  
			foreach ( $pDivs as $div ) { 
			  $div->parentNode->removeChild($div);
			}

			$html_string	= str_replace('<tr id="image-replacer"></tr>',$new_icon_string,$dom->saveHTML());
			return $html_string;
		}else{
			return $html_string;
		}
	}
	
	
	
	
	
    
}

?>
