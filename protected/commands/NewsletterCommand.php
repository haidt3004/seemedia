<?php
class NewsletterCommand extends CConsoleCommand
{
    protected $max = 50;
    protected $index = 0;
    protected $data = array();

    public function run($arg)
    {
        EmailQueue::RunSendNewsletter();// Anh Dung - Aug 19, 2015
        Yii::app()->setting->setDbItem('last_working', date('Y-m-d h:i:s'));
    }
    
    protected function doTest($arg)
    {
        $data = array(
            'subject'=>'SpeechPrint just for test cron job from NICHE new letter',
            'params'=>array(
                'message'=>'SpeechPrint just for test cron job newsletter form SpeechPrint'.date('Y-m-d H:i:s'),
            ),
            'view'=>'message',
            'to'=>'thoa.nh@verzdesign.com.sg',
            'from'=>Yii::app()->params['autoEmail'],
        );
        //EmailHelper::sendMail($data);
        CmsEmail::mail($data);
    }

    protected function doJob($arg)
    {
        $model = Newsletter::model()->find(array(
            'condition'=>'(t.remain_subscribers IS NOT NULL) AND (length(t.remain_subscribers) > 0 )  
                        AND (t.send_time <= NOW()) AND (t.status=1)
                            ',
            'order'=>'t.id ASC',
        ));
        if($model !== null)
        {
            $subscriber_count = 0;
            // for public subscriber
            if(trim($model->remain_subscribers)!=''):
                    $receivers = explode(',', trim($model->remain_subscribers));
                    while(count($receivers) > 0)
                    {
                        $k = array_shift($receivers);
                        $s = Subscriber::model()->findByPk($k);
                        if(is_null($s) || empty($k))
                            continue;
                        $unsubscribe = "You have received this newsletter because you have subscribed to YummySOS. Please click ".CHtml::link('here', Yii::app()->setting->getItem('baseUrl').'/site/unsubscribe?id='.$s->id.'&code='.md5($s->id.$s->email))." to unsubscribe. Thank you" ;
                        $r = array(
                            'subject'=>$model->subject,
                            'params'=>array(
                                'content'=>$model->content.'<br/>'.$unsubscribe,
                                'newsletterName'=>'YummySOS',
                                'unsubscribe'=> $unsubscribe,
                                
                            ),
                            'message' => $model->content.$unsubscribe,
                            'view'=>'newsletter',
                            'to'=>$s->email,
                            'from'=>Yii::app()->params['autoEmail'],
                        );
                        $this->data[]= $r;

                        $subscriber_count++;//count subscriber is served for current newsletter job
                        $this->index++;//count email is sent for current cron job
                        if($this->index >= $this->max)
                            break;
                    }
                    
                    $model->total_sent = $model->total_sent+$subscriber_count; // track amount mail sent
                    $model->remain_subscribers = implode(',', $receivers);
                    if(count($receivers)==0)
                        $model->remain_subscribers ='';
                    $model->update(array('remain_subscribers','total_sent'));
                    return;
            endif;
                
        }
        else
        {
            return;
        }

        //when sent all subscriber of a newsletter job but the
        if($this->index < $this->max)
            $this->doJob($arg);
    }
}