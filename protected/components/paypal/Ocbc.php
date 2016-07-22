<?php
/*
 * @Huu Thoa
 * created date 13/06/2015
 * ocbc payment process 
 */

class Ocbc {
    public static function send($data) {
        
        $arrayPost['MERCHANT_ACC_NO'] = Yii::app()->params['merchant_acc_no'];
        $arrayPost['TRANSACTION_TYPE'] =2;
        $arrayPost['AMOUNT'] = $data['amount'];
        $arrayPost['MERCHANT_TRANID'] = $data['transaction_id'];
        $arrayPost['CARD_NO'] = $data['card_no'];
        $arrayPost['CARD_EXP_MM'] = $data['card_exp_month'];
        $arrayPost['CARD_EXP_YY'] = $data['card_exp_year'];
        $arrayPost['CARD_CVC'] = $data['card_cvc'];
        $arrayPost['CARD_HOLDER_NAME'] = $data['card_name'];
        $arrayPost['CARD_TYPE'] = $data['card_type'];
        $arrayPost['TXN_SIGNATURE'] = $data['signature'];
        $arrayPost['RESPONSE_TYPE'] = 'http';
        $arrayPost['RETURN_URL'] = $data['return_url'];
        $arrayPost['TXN_DESC'] = 'sdf';
        
        $paypal_type = Yii::app()->params['paypalType'];//live or test
        if($paypal_type == 'test')
            $bk = 'https://testepayment.ocbc.com/BPG/admin/payment/PaymentWindowSimulator.jsp';
        else
            $bk = 'https://epayment.ocbc.com/BPG/admin/payment/PaymentWindowSimulator.jsp';
        exit;
        $curl = curl_init($bk);
        curl_setopt_array($curl, array(
                CURLOPT_POST=>true,
                CURLOPT_HEADER=>false,
                CURLINFO_HEADER_OUT=>true,
                CURLOPT_TIMEOUT=>30,
                CURLOPT_RETURNTRANSFER=>true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTPAUTH=>CURLAUTH_DIGEST|CURLAUTH_BASIC,
                CURLOPT_USERPWD=>CORE_API_HTTP_USR.':'.CORE_API_HTTP_PWD,
                CURLOPT_POSTFIELDS=>http_build_query($arrayPost)
        ));
        $data = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
    }
}
