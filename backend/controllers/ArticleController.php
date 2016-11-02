<?php
/**
 * 文件名：ArticleController.php
 * 文件说明:
 * 时间: 2016/10/25.9:34
 */

namespace backend\controllers;

use common\events\SendMail;
use common\models\Article;

use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class ArticleController extends Controller
{

    function actionIndex()
    {
//       $art= Article::findOne(11);
//        dd($art);
//        $art->art_title='121212';
//        dd($art->save());
       $art=new Article();
       $event=new SendMail();
        $event->from=\Yii::$app->params['admin'];
        $event->content=$art->findOne(1);
        dd($event);
//        $event->time=time();
//        $event->author='lisi';
//        $event->title='odifodfiodfi';
//       $this->on('ok',[$art,'test'],'canshu');
//        $this->trigger('ok',$event);
       dd( $event->from);
        
    }

    public function behaviors()
    {
        return [
          
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'add'],
                'rules' => [
                    // 允许认证用户
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    // 默认禁止其他用户
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['get'],
                    'add' => ['post'],
                ],
            ],
        ];
    }
}