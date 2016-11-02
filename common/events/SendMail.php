<?php
/**
 * 文件名：SendMail.php
 * 文件说明:
 * 时间: 2016/10/25.13:24
 */

namespace common\events;


use yii\base\Event;

class SendMail extends Event
{   
    public $from;//发件者
    public $to;//收件者
    public $subject;//主题
    public $content;//正文
    public $time;//邮件时间

    public function send()
    {
        $mail = \Yii::$app->mailer->compose()
            ->setFrom($this->from)
            ->setTo('3046587188@qq.com')
            ->setSubject('测试邮件信息')
            //->setTextBody('Yii中文网教程真好 www.yii-china.com')   //发布纯文字文本
            ->setHtmlBody("<br>测试yii发送邮件信息")    //发布可以带html标签的文本
            ->send();
        if($mail)
            echo 'success';
        else
            echo 'fail';
    }

}