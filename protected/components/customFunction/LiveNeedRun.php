<?php
/**
 * User: Kvan
 * Date: 12/17/14
 * Time: 1:45 PM
 * To change this template use File | Settings | File Templates.
 */

class LiveNeedRun{
/**
* @Author: ANH DUNG Aug 13, 2014
* @Todo: replace link cms to live site
*/
    public static function ReplaceCmsLinkLiveSite(){
        set_time_limit(7200);
        $find = 'verzview.com/coreproject';
        $replace = 'coreproject.com.sg';
        $models = Page::getAll();
        foreach($models as $item){
            $item->external_link = str_replace($find, $replace, $item->external_link);
            $item->content = str_replace($find, $replace, $item->content);
            $item->short_content = str_replace($find, $replace, $item->short_content);
            $item->update(array('content','external_link','short_content'));
        }
        echo 'Done: '.count($models);die;
    }
}