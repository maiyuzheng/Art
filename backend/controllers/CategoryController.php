<?php
/**
 * 文件名：CategoryController.php
 * 文件说明:
 * 时间: 2016/10/24.13:10
 */

namespace backend\controllers;
use common\models\Category;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class CategoryController extends Controller
{
    public function actionIndex()
    {
//      dd(Category::parents(29));
//      dd(Category::sons(1));
//        $com=Category::treeComponent();
//        $bef=new AddViews();
//        $model=new Category();
//        $model->attachBehavior('tt', $bef);
//        dd($model->getBehaviors());



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
                    'add'=>['post'],
                ],
            ],
        ];
    }
}